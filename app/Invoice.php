<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    //
	protected $fillable = ['title','price', 'screen_count','rate','payment_status','recurring_id','user_id','valid_till','log','used_count'];

  
	public function getPaidAttribute() {
    	if ($this->payment_status == 'Invalid') {
    		return false;
    	}
    	return true;
    }


    public function getUnUsedScreen(){
        $userID = Auth::user()->id;
        $unusedScreen = $this->where('user_id',$userID)->where('screen_count','>','used_count')->first();
        return $unusedScreen;
    }

	public function getUnUsedScreenCount(){
        $userID = Auth::user()->id;
        $unusedScreen = $this->where('user_id',$userID)->where('screen_count','>','used_count')->find();
        $count = 0;
        foreach($unusedScreen as $invoice){
        	$count += ($invoice->screen_count - $invoice->used_count);
        }

        return $count;
    }    

}
