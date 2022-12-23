<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\PlayList;
use App\Project;
use Auth;
use DB;

class PlayListsController extends Controller
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
        $keyword = '';
        $playListObj = new PlayList;
        $playListObj = $playListObj->where('user_id',Auth::user()->id);
        if(!empty($request->keyword)){
            $keyword = $request->keyword;
            $playListObj = $playListObj->orwhere('name', 'like', '%'.$keyword.'%');
        }
        $playListObj = $playListObj->with('project');
        $playLists = $playListObj->paginate(10);
        return view('PlayLists.index',compact('playLists','keyword'));
    }
    public function create(){
        return View('PlayLists.create');
    }
    public function store(Request $request){
        $rules = array(
            'name'       => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('/PlayLists/create')
                ->withErrors($validator)->withInput();
        } else {
            $playListObj = new PlayList;
            $data = $request->all();
            //$content->uuid = String::uuid();
            $playListObj->create($data);
            flash('Successfully Saved.','success');
            return redirect('/PlayLists');
        }
    }

    public function show(PlayList $playList){
        return View('PlayLists.show',compact('playList'));   
    }

    public function edit(PlayList $playList){         
        return View('PlayLists.edit',compact('playList'));
    }

    public function update(Request $request,PlayList $playList){
        $rules = array(
            'name'       => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('/PlayLists/edit/'.$playList->id)
                ->withErrors($validator)->withInput();
        } else {
        	$data = $request->all();
        	unset($data['_method']);unset($data['_token']);unset($data['/'.$request->path()]);
        	foreach($data as $field=>$value){                
                $playList->$field = $value;
            }
            $playList->save();
	        flash('Play List updated Successfully!','success');
	        return redirect('/PlayLists');
	    }
    }

	public function delete(PlayList $playList){
        $playList->delete();
        flash('Successfully deleted the Channel!','success');
        return back();
    }

    public function designPage(PlayList $playList){
        $project = $playList->project()->first();
        return View('PlayLists.designpage',compact('playList','project'));   
    }

    public function savedesignPage(PlayList $playList,Request $request){
        $project = $playList->project()->first();
        if(empty($project->id)){
            $project = new project;
        }
        $data = $request->all();
        $project->design = $data['pagedesign'];
        $project->published = 1;
        $project->play_list = $playList->id;
        $project->save();
        return redirect('/PlayLists');
    }

    public function viewDesign(PlayList $playList,Request $request)
    {
        $project = $playList->project()->first();
        return View('PlayLists.viewpagedesign',compact('playList','project'));   
    }

}
