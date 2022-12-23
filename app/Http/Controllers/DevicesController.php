<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\Device;
use App\Channel;
use Auth;
use DB;

class DevicesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {    
        $deviceObj = new Device;
        $keyword = '';
        $deviceObj = $deviceObj->where('user_id',Auth::user()->id);
        if(isset($request->keyword)){
            $keyword = $request->keyword;
            $deviceObj = $deviceObj->orwhere('device_id', 'like', $keyword.'%');
            $deviceObj = $deviceObj->orWhere('name', 'like', '%'.$keyword.'%');
            $deviceObj = $deviceObj->orWhere('location', 'like', '%'.$keyword.'%');
        }

        $devices = $deviceObj->paginate(10);
        $channelsObj = new Channel;
        $channelsObj = $channelsObj->where('user_id',Auth::user()->id);
        $channels = array();
        
        $channelsData = $channelsObj->orderBy('id', 'asc')->pluck( 'name','id');
        foreach($channelsData as $chnnlID=>$name){
            $channels[$chnnlID] = $name;
        }
        return view('Devices.index',compact('devices','keyword','channels'));
    }
    public function create(){
        if(!canAddDevice()){
    		return Redirect::to('/Invoices/create');	
    	}
        $channelsObj = new Channel;
        $channelsObj = $channelsObj->where('user_id',Auth::user()->id);
        $channels = array();
        $channels = $channelsObj->orderBy('id', 'asc')->pluck( 'name','id');        
        return View('Devices.create',compact('channels'));

    }
    public function store(Request $request){
        if(!canAddDevice()){
    		return Redirect::to('/Invoices/create');	
    	}
        $rules = array(
            'name'       => 'required',
            'device_id'      => 'required',
            'channel_id' 		=> 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('/Devices/create')
                ->withErrors($validator)->withInput();
        } else {
            $deviceObj = new Device;
            $data = $request->all();
            $deviceObj->create($data);
            flash('Successfully Saved.','success');
            return redirect('/Devices');
        }
    }

    public function show(Device $device){
        $channelsObj = new Channel;
        $channelsObj = $channelsObj->where('user_id',Auth::user()->id);

        $channels = array();
        $channelsData = $channelsObj->orderBy('id', 'asc')->pluck( 'name','id');
        foreach($channelsData as $chnnlID=>$chanalName){
            $channels[$chnnlID] = $chanalName;
        }
        return View('Devices.show',compact('device','channels'));   
    }

    public function edit(Device $device){
    	$channelsObj = new Channel;
        $channelsObj = $channelsObj->where('user_id',Auth::user()->id);

        $channels = array();
        $channels = $channelsObj->orderBy('id', 'asc')->pluck( 'name','id');
        return View('Devices.edit',compact('device','channels'));
    }

    public function update(Request $request,Device $device){
    // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'name'       => 'required',
            'device_id'      => 'required',
            'channel_id'        => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('/Devices/'.$device->id.'/edit')
                ->withErrors($validator)->withInput();
        } else {
            $data = $request->all();
            unset($data['_method']);unset($data['_token']);
            /*foreach($data as $field=>$value){                
                $device->$field = $value;
            }*/
            $device->device_id = $data['device_id'];
        	$device->name = $data['name'];
        	$device->channel_id = $data['channel_id'];
        	$device->location = $data['location'];
        	$device->secret = $data['secret'];
        	$device->notes = htmlentities($data['secret']);
            $device->save();
            flash('Successfully updated!','success');
            return redirect('/Devices');
        }
    }

    public function delete(Device $device){
        $device->delete();
        flash('Successfully deleted the Device!','success');
        return redirect('/Devices');
    }
}