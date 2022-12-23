<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http;
use Illuminate\Support\Facades\Redirect;
use App\Device;
use App\Channel;
use App\PlayList;
use App\Schdule;
use App\Project;
use Auth;
use DB;

class UtilitiesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       
    }


    public function getPageNumber(Request $request){
        $data = $request->all();
        
        if(!empty($data['token']) && !empty($data['time']) && $data['secret']){
            $deviceID = $data['token'];
            $baseQuery = DB::table('devices')
                    ->join('channels', 'channels.id', '=', 'devices.channel_id')
                    ->join('play_lists', 'play_lists.id', '=', 'channels.playlist_id')
                    ->where('devices.device_id', '=', "$deviceID")
                    ->where('devices.secret',"{$data['secret']}")
                    ->select('devices.*','channels.name as channel_name','play_lists.name as list_name','play_lists.name as list_name',
                    'play_lists.aspect_ratio as  aspect_ratio', 'play_lists.layout as layout','play_lists.id as PID' ,'play_lists.screen_resolution as screen_resolution',
                    'play_lists.duration as duration')
                    ->get();        
			if($baseQuery){
                $pageQuery = DB::table('devices')
                        ->join('channels', 'channels.id', '=', 'devices.channel_id')
                        ->join('schdules', 'schdules.channel_id', '=', 'channels.id')
                        ->join('play_lists', 'play_lists.id', '=', 'schdules.playlist_id')
                        ->where('devices.device_id', '=', $deviceID)
                        ->where('devices.secret',$data['secret'])
                        ->select('devices.*','channels.name as channel_name','play_lists.name as list_name','play_lists.name as list_name',
                        'play_lists.aspect_ratio as  aspect_ratio', 'play_lists.layout as layout', 'play_lists.screen_resolution as screen_resolution',
                        'play_lists.duration as duration','schdules.start_time','schdules.end_time','schdules.duration as SC_duration',
                        'play_lists.duration as l_duration','play_lists.id as PID')
                        ->get();

                //$results = DB::Select($baseQuery);
				$timeArr = explode(':', $data['time']);
                $time = $timeArr[0] * 60 + $timeArr[1];
                $PlayListID = $playListLayout = '';
                foreach($baseQuery as $item){
                    $PlayListID = $item->PID; // if there is no play list to play at this time. then deafult is set
                    $playListLayout = $item->layout;
                }

                $playListArr = array();

                /// Makeing Play list to projects array. also checking what play list we need to play;
                foreach($pageQuery as $item){
                	$playListArr[$item->PID][] = 1;//$item->project_id;

                    // calculate time range
                    $rowTimeArr = explode(':', $item->start_time);
                    $rowStartTime = $rowTimeArr[0] * 60 + $rowTimeArr['1'];
                    $rowEndTime = $rowStartTime + $item->duration;
                    if(!empty($item->end_time)){
                        $rowEndTimeArr = explode(':', $item->end_time);
                        $rowEndTime = $rowEndTimeArr[0] * 60 + $rowEndTimeArr['1'];
                    }

                    if($time >= $rowStartTime && $time <= $rowEndTime){   /// that means this play list need to be run right now
                        $PlayListID = $item->PID;   ///// over ride default play list
                        $playListLayout = $item->layout;
                    }
                }
                $outArray['status'] = 'success';
                $outArray['play_list'] = $PlayListID;
                return json_encode($outArray);
            }
        }
        $outArray['status'] = 'error';
        $outArray['error_message'] = 'No Record Found';
        return json_encode($outArray);
    }


    public function getPage(Request $request){
        $data = $request->all();
        
        if(!empty($data['token']) && !empty($data['time'])){
        $deviceID = $data['token'];
            $baseQuery = DB::table('devices')
                    ->join('channels', 'channels.id', '=', 'devices.channel_id')
                    ->join('play_lists', 'play_lists.id', '=', 'channels.playlist_id')
                    ->where('devices.device_id', '=', $deviceID)
                    ->where('devices.secret',$data['secret'])
                    ->select('devices.*','channels.name as channel_name','play_lists.name as list_name','play_lists.name as list_name',
                    'play_lists.aspect_ratio as  aspect_ratio', 'play_lists.layout as layout','play_lists.id as PID' ,'play_lists.screen_resolution as screen_resolution',
                    'play_lists.duration as duration')
                    ->get();        

            if($baseQuery){

                $pageQuery = DB::table('devices')
                        ->join('channels', 'channels.id', '=', 'devices.channel_id')
                        ->join('schdules', 'schdules.channel_id', '=', 'channels.id')
                        ->join('play_lists', 'play_lists.id', '=', 'schdules.playlist_id')
                        ->where('devices.device_id', '=', $deviceID)
                        ->where('devices.secret',$data['secret'])
                        ->select('devices.*','channels.name as channel_name','play_lists.name as list_name','play_lists.name as list_name',
                        'play_lists.aspect_ratio as  aspect_ratio', 'play_lists.layout as layout', 'play_lists.screen_resolution as screen_resolution',
                        'play_lists.duration as duration','schdules.start_time','schdules.end_time','schdules.duration as SC_duration',
                        'play_lists.duration as l_duration','play_lists.id as PID')
                        ->get();

                //$results = DB::Select($baseQuery);

                $timeArr = explode(':', $data['time']);
                $time = $timeArr[0] * 60 + $timeArr[1];
                $PlayListID = $playListLayout = '';
                foreach($baseQuery as $item){
                    $PlayListID = $item->PID; // if there is no play list to play at this time. then deafult is set
                    $playListLayout = $item->layout;
                }

                $playListArr = array();

                /// Makeing Play list to projects array. also checking what play list we need to play;
                foreach($pageQuery as $item){
                    $playListArr[$item->PID][] = 1; //$item->project_id;

                    // calculate time range
                    $rowTimeArr = explode(':', $item->start_time);
                    $rowStartTime = $rowTimeArr[0] * 60 + $rowTimeArr['1'];
                    $rowEndTime = $rowStartTime + $item->duration;
                    if(!empty($item->end_time)){
                        $rowEndTimeArr = explode(':', $item->end_time);
                        $rowEndTime = $rowEndTimeArr[0] * 60 + $rowEndTimeArr['1'];
                    }

                    if($time >= $rowStartTime && $time <= $rowEndTime){   /// that means this play list need to be run right now
                        $PlayListID = $item->PID;   ///// over ride default play list
                        $playListLayout = $item->layout;
                    }
                }
                $outArray['status'] = 'success';
                $outArray['play_list'] = $PlayListID;
                $outArray['layout'] = $playListLayout;
                $htmlArr = array();
                foreach($playListArr[$PlayListID] as $project){
                    //$outArray['html'][$project] = url('/').'/editor/storage/exports/'.$project.'/index.html';
                    $uri = str_replace('/backend','',url('/'));
                  
                  	//$url = $uri.'/editor/storage/exports/'.$project.'/index.html';   
                    //$htm = $this->__url_get_contents($url);
                    //$substr = '<head>';
                    //$attachment = ' <base href="'.$uri.'/editor/storage/exports/'.$project.'" >';
                    //$newstring = str_replace($substr, $substr.$attachment, $htm);
                    $url = 'https://site.turboanchor.com';   
                    $newstring = $htm = $this->__url_get_contents($url);

                    $outArray['html'] = $newstring;
                }
                if(!empty($data['type']) && $data['type'] == 'html'){
                    return $outArray['html'];
                }else{
                    return json_encode($outArray);
                }
            }
        }
        $outArray['status'] = 'error';
        $outArray['error_message'] = 'No Record Found';
        return json_encode($outArray);
    }

    function __url_get_contents($url, $useragent='cURL', $headers=false, $follow_redirects=true, $debug=false) {

        // initialise the CURL library
        $ch = curl_init();

        // specify the URL to be retrieved
        curl_setopt($ch, CURLOPT_URL,$url);

        // we want to get the contents of the URL and store it in a variable
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);

        // specify the useragent: this is a required courtesy to site owners
        curl_setopt($ch, CURLOPT_USERAGENT, $useragent);

        // ignore SSL errors
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // return headers as requested
        if ($headers==true){
            curl_setopt($ch, CURLOPT_HEADER,1);
        }

        // only return headers
        if ($headers=='headers only') {
            curl_setopt($ch, CURLOPT_NOBODY ,1);
        }

        // follow redirects - note this is disabled by default in most PHP installs from 4.4.4 up
        if ($follow_redirects == true) {
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 
        }

        // if debugging, return an array with CURL's debug info and the URL contents
        if ($debug==true) {
            $result['contents'] = curl_exec($ch);
            $result['info'] = curl_getinfo($ch);            
        }

        // otherwise just return the contents as a variable
        else $result = curl_exec($ch);
        // free resources
        // send back the data
        return $result;
    }

    public function autologout(){
        Auth::logout();
  		return redirect('/login');
        //return view('Utilities.signout');
    }

	public function logout(){
    	Auth::logout();
  		return redirect('/login');
    }
}