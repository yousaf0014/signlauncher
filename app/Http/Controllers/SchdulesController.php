<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\Channel;
use App\PlayList;
use App\Schdule;
use Auth;
use DB;

class SchdulesController extends Controller
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
    public function index(channel $channel,Request $request)
    {    
        $keyword = '';
        $schduleObj = new Schdule;
        $schduleObj = $schduleObj->where('channel_id',$channel->id);
        $schdules = $schduleObj->paginate(10);
        $playListObj = new PlayList;
        $playListObj = $playListObj->where('user_id',Auth::user()->id);
        $playListes = array();
        $playlistsData = $playListObj->orderBy('id', 'asc')->pluck( 'name','id');
        foreach($playlistsData as $ID=>$name){
            $playListes[$ID] = $name;
        }
        return view('Schdules.index',compact('playListes','schdules','channel'));
    }
    public function create(channel $channel){
        $playListObj = new PlayList;

        $playListObj = $playListObj->where('user_id',Auth::user()->id);
        $playListes = array();
        $playListes = $playListObj->orderBy('id', 'asc')->pluck( 'name','id'); 
        return View('Schdules.create',compact('playListes','channel'));
    }

    public function store(channel $channel,Request $request){
        $rules = array(
            'channel_id'       => 'required',
            'playlist_id'      => 'required',
            'start_time'		=>'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('/Schdules/create')
                ->withErrors($validator)->withInput();
        } else {
            $schduleObj = new Schdule;
            $data = $request->all();
            $data['channel_id'] = $channel->id;
            $schduleObj->create($data);
            flash('Successfully Saved.','success');
            return redirect('/Schdules/'.$channel->id);
        }
    }

    public function edit(Schdule $schdule,Channel $channel){
        $playListObj = new PlayList;
        $playListObj = $playListObj->where('user_id',Auth::user()->id);

        $playListes = array();
        $playListes = $playListObj->orderBy('id', 'asc')->pluck( 'name','id');
        return View('Schdules.edit',compact('channel','playListes','schdule'));
    }

    public function update(Request $request,Schdule $schdule){
    
        $data = $request->all();
            
        $rules = array(
            'channel_id'       => 'required',
            'playlist_id'      => 'required',
            'start_time'		=>'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('/Schdules/'.$schdule->id.'/edit/'.$data['channel_id'])
                ->withErrors($validator)->withInput();
        } else {
            $schdule->end_time = NULL;
			$schdule->duration = NULL;
        	$schdule->channel_id = $data['channel_id'];
        	$schdule->playlist_id = $data['playlist_id'];
        	$schdule->start_time = $data['start_time'];
        	$schdule->duration = $data['duration'];
            $schdule->save();
            flash('Successfully updated!','success');
            return redirect('/Schdules/'.$data['channel_id']);
        }
    }

    public function delete(Schdule $schdule){
        $schdule->delete();
        flash('Successfully deleted the Channel!','success');
        return back();
    }
}
