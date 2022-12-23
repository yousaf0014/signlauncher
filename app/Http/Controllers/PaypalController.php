<?php
namespace App\Http\Controllers;

use Illuminate\Http;
use Srmklive\PayPal\Services\ExpressCheckout;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Invoice;
use Auth;
use DB;

class PaypalController extends Controller
{
	protected $provider;
	
	public function __construct() {
	    $this->provider = new ExpressCheckout();
	}

    /**

     * Show the application paywith paypalpage.

     *

     * @return \Illuminate\Http\Response

     */

    public function payWithPaypal()
    {
        return view('paywithpaypal');
    }



	private function getCart($invoice_id,Request $request)
    {
    	$data = $request->all();
        return [
            'items' => [
                [
                    'name' => 'Monthly Subscription ' . config('paypal.invoice_prefix') . ' #' . $invoice_id,
                    'price' => config('paypal.PerScreenAmount'),
                    'qty' => $data['qty'],
                ],
            ],

            // return url is the url where PayPal returns after user confirmed the payment
            'return_url' => url('/paypal/express-checkout-success?recurring=1'),
            'subscription_desc' => 'Monthly Subscription ' . config('paypal.invoice_prefix') . ' #' . $invoice_id,
            // every invoice id must be unique, else you'll get an error from paypal
            'invoice_id' => config('paypal.invoice_prefix') . '_' . $invoice_id,
            'invoice_description' => "Order #". $invoice_id ." Invoice",
            'cancel_url' => url('/'),
            // total is calculated by multiplying price with quantity of all cart items and then adding them up
            // in this case total is 20 because price is 20 and quantity is 1
            'total' => $data['qty'] * config('paypal.PerScreenAmount') // Total price of the cart
        ];
        
    }

	public function expressCheckout(Request $request) {
		$data = $request->all();
		$invoice_id = Invoice::count() + 1;
		$cart = $this->getCart($invoice_id,$request);
		  
		// create new invoice
		$invoice = new Invoice();
		$invoice->title = $cart['invoice_description'];
  		$invoice->price = $cart['total'];
		$invoice->screen_count = $data['qty'];
		$invoice->rate = config('paypal.PerScreenAmount');
        $invoice->user_id = Auth::user()->id;
		$invoice->save();

		// send a request to paypal 
		// paypal should respond with an array of data
		// the array should contain a link to paypal's payment system
		$response = $this->provider->setExpressCheckout($cart, 1);

		// if there is no link redirect back with error message
		if (!$response['paypal_link']) {
		return redirect('/')->with(['code' => 'danger', 'message' => 'Something went wrong with PayPal']);
		// For the actual error message dump out $response and see what's in there
		}

		// redirect to paypal
		// after payment is done paypal
		// will redirect us back to $this->expressCheckoutSuccess
		return redirect($response['paypal_link']);
	}

	public function expressCheckoutSuccess(Request $request) {
        // check if payment is recurring
        $token = $request->get('token');
        $PayerID = $request->get('PayerID');

        // initaly we paypal redirects us back with a token
        // but doesn't provice us any additional data
        // so we use getExpressCheckoutDetails($token)
        // to get the payment details
        $response = $this->provider->getExpressCheckoutDetails($token);

        // if response ACK value is not SUCCESS or SUCCESSWITHWARNING
        // we return back with error
        if (!in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
            return redirect('/')->with(['code' => 'danger', 'message' => 'Error processing PayPal payment']);
        }

        // invoice id is stored in INVNUM
        // because we set our invoice to be xxxx_id
        // we need to explode the string and get the second element of array
        // witch will be the id of the invoice
        $invoice_id = explode('_', $response['INVNUM'])[1];

        // set Invoice ID
        $subscription =  'Monthly Subscription ' . config('paypal.invoice_prefix') . ' #' . $invoice_id;
            
        // if recurring then we need to create the subscription
        // you can create monthly or yearly subscriptions

        $response = $this->provider->createMonthlySubscription($response['TOKEN'], $response['AMT'], $subscription);
        
        $status = 'Invalid';
        $profile = 0;
        // if after creating the subscription paypal responds with activeprofile or pendingprofile
        // we are good to go and we can set the status to Processed, else status stays Invalid
        if (!empty($response['PROFILESTATUS']) && in_array($response['PROFILESTATUS'], ['ActiveProfile', 'PendingProfile'])) {
            $status = 'Completed';
            $profile = 1;
        }
    
        // find invoice by id
        $invoice = Invoice::find($invoice_id);
        // set invoice status
        $invoice->payment_status = $status;
        $invoice->valid_till = date('Y-m-d H:i:s',strtotime('+1 month'));
        $invoice->log = serialize($response);
        // if payment is recurring lets set a recurring id for latter use
        $invoice->recurring_id = $response['PROFILEID'];
        

        // save the invoice
        $invoice->save();

        // App\Invoice has a paid attribute that returns true or false based on payment status
        // so if paid is false return with error, else return with success message
        if ($invoice->paid) {
            return redirect('/Invoices')->with(['code' => 'success', 'message' => 'Order ' . $invoice->id . ' has been paid successfully!']);
        }
        
        return redirect('/Invoices')->with(['code' => 'danger', 'message' => 'Error processing PayPal payment for Order ' . $invoice->id . '!']);
    }

    public function notify(Request $request)
    {
        $request->merge(['cmd' => '_notify-validate']);
        $post = $request->all();

        $response = (string) $this->provider->verifyIPN($post);

        //if PayPal responds with VERIFIED we are good to go
        if ($response === 'VERIFIED') {
            $invoice_id = explode('_', $response['INVNUM'])[1];            
            $invoice = Invoice::find($invoice_id);
            $invoice->price = $post['amount'];
            $invoice->valid_till = date('Y-m-d H:i:s',strtotime($post['next_payment_date']));
            $invoice->screen_count = $post['amount']/config('paypal.PerScreenAmount');                
            $invoice->payment_status = 'Completed';
            if ($post['txn_type'] == 'recurring_payment' && $post['payment_status'] == 'Completed') {
                $invoice->payment_status = 'Completed';                
            }else if($post['txn_type'] == 'recurring_payment_expired' || $post['txn_type'] == 'recurring_payment_profile_cancel' ||  $post['txn_type'] == 'recurring_payment_suspended_due_to_max_failed_payment' || $post['txn_type'] == 'recurring_payment_failed' || $post['txn_type'] == 'recurring_payment_skipped'){
                $invoice->payment_status = 'Invalid';               
            }
            $invoice->log = serialize($post);
            $invoice->save();                        
        }
        echo 'done';
        exit;
    }

    function cancelReoccuringPayment(Invoice $invoice){
        if($invoice->user_id !== Auth::user()->id){
            return back();
        }
        
        if(!empty($invoice->recurring_id)){
            try{
                $response = $this->provider->cancelRecurringPaymentsProfile($invoice->recurring_id);
                $invoice->payment_status = 'Canceled';
                //$invoice->log = serialize($post);
                $invoice->save();
            }catch(\Exception $e){
                print_r($e);
            }
        }
        return redirect('/Invoices');
    }

    function updateReoccuringPayment(Invoice $invoice, Request $request){
        if($invoice->user_id !== Auth::user()->id){
            return back();
        }

        $data = $request->all();
        $data = [
            'items' => [
                [
                    'name' => 'Monthly Subscription ' . config('paypal.invoice_prefix') . ' #' . $invoice->recurring_id,
                    'price' => config('paypal.PerScreenAmount'),
                    'qty' => $data['qty'],
                ],
            ],

            // return url is the url where PayPal returns after user confirmed the payment
            'return_url' => url('/paypal/express-checkout-success?recurring=1'),
            'subscription_desc' => 'Monthly Subscription ' . config('paypal.invoice_prefix') . ' #' . $invoice->recurring_id,
            // every invoice id must be unique, else you'll get an error from paypal
            'invoice_id' => config('paypal.invoice_prefix') . '_' .$invoice->recurring_id,
            'invoice_description' => "Order #". $invoice->recurring_id ." Invoice",
            'cancel_url' => url('/'),
            // total is calculated by multiplying price with quantity of all cart items and then adding them up
            // in this case total is 20 because price is 20 and quantity is 1
            'total' => 1 * config('paypal.PerScreenAmount') // Total price of the cart
        ];
        if(!empty($invoice->recurring_id)){
            try{
                $response = $this->provider->updateRecurringPaymentsProfile($data, $invoice->recurring_id);
                $invoice->price = $request->qty * config('paypal.PerScreenAmount') ;
                $invoice->screen_count = $request->qty;
                $invoice->save();                
            }catch(\Exception $e){
                print_r($response);
            }
        }
        return redirect('Invoices');
    }


    function index(Request $request){
        $invoiceObj = new Invoice;
        $keyword = $status = '';
        if(isset($request->keyword)){
            $keyword = $request->keyword;
            $invoiceObj = $invoiceObj->Where('invoice_id', 'like', '%'.$keyword.'%');
        }
        if(!empty($request->status)){
            $status = $request->status;
            $invoiceObj = $invoiceObj->Where('status', 'like', '%'.$status.'%');
        }
        $invoices = $invoiceObj->paginate(20);
        return view('Invoices.index',compact('invoices','keyword','status'));
    }

    function edit(Invoice $invoice){
        if($invoice->user_id != Auth::user()->id){
            return back();
        }
        return view('Invoices.edit',compact('invoice'));   
    }
}