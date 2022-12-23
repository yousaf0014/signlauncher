<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\Channel;
use App\PlayList;
use Auth;
use DB;

class ChannelsController extends Controller
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
        $channelObj = new Channel;
        $channelObj = $channelObj->where('user_id',Auth::user()->id);
        $keyword = '';
        if(isset($request->keyword)){
            $keyword = $request->keyword;
            $channelObj = $channelObj->orwhere('name', 'like', '%'.$keyword.'%');
        }

        $channels = $channelObj->paginate(10);
        $playListObj = new PlayList;
        $playListObj = $playListObj->where('user_id',Auth::user()->id);
        $playListes = array();
        $playlistsData = $playListObj->orderBy('id', 'asc')->pluck( 'name','id');
        foreach($playlistsData as $ID=>$name){
            $playListes[$ID] = $name;
        }
        return view('Channels.index',compact('playListes','keyword','channels'));
    }
    public function create(){
        $playListObj = new PlayList;
        $playListObj = $playListObj->where('user_id',Auth::user()->id);
        $playListes = array();
        $playListes = $playListObj->orderBy('id', 'asc')->pluck( 'name','id');        
        return View('Channels.create',compact('playListes'));
    }

    public function store(Request $request){
        $rules = array(
            'name'       => 'required',
            'playlist_id'      => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('/Channels/create')
                ->withErrors($validator)->withInput();
        } else {
            $channelObj = new Channel;
            $data = $request->all();
            $channelObj->create($data);
            flash('Successfully Saved.','success');
            return redirect('/Channels');
        }
    }

    public function show(Channel $channel){
        $playListObj = new PlayList;
        $playListObj->where('user_id',Auth::user()->id);

        $channels = array();
        $channelsData = $playListObj->orderBy('id', 'asc')->pluck( 'name','id');
        foreach($channelsData as $chnnlID=>$chanalName){
            $channels[$chnnlID] = $chanalName;
        }
        return View('Channels.show',compact('channel','playListes'));   
    }

    public function edit(Channel $channel){
        $playListObj = new PlayList;
        $playListObj = $playListObj->where('user_id',Auth::user()->id);

        $playListes = array();
        $playListes = $playListObj->orderBy('id', 'asc')->pluck( 'name','id');
        return View('Channels.edit',compact('channel','playListes'));
    }

    public function update(Request $request,Channel $channel){
    // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'name'       => 'required',
            'playlist_id'      => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('/Channels/'.$channel->id.'/edit')
                ->withErrors($validator)->withInput();
        } else {
            $data = $request->all();
            unset($data['_method']);unset($data['_token']);unset($data['/'.$request->path()]);
            foreach($data as $field=>$value){                
                $channel->$field = $value;
            }
            $channel->save();
            flash('Successfully updated!','success');
            return redirect('/Channels');
        }
    }

    public function delete(Channel $channel){
        $channel->delete();
        flash('Successfully deleted the Channel!','success');
        return redirect('/Channels');
    }
    
}
