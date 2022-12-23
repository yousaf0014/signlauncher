<?php

namespace App\Http\Controllers;

use App\Gallery;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class GalleryController extends BaseController
{

	public function __construct(){

		$this->middleware('auth');
	}

	public function viewGalleryList(){

		$galleries = Gallery::where('created_by', Auth::user()->id)->get();

		return view('gallery.gallery')->with('galleries', $galleries);
	}

	public function saveGallery(Request $request){

		// validate the rule through the validation rule
		$validator = Validator::make($request->all(), [
				'gallery_name' => 'required|min:3',
			]);

		if($validator->fails()){
			return redirect('gallery/list')->withErrors($validator)->withInput();
		}

		$gallery = new Gallery;

		//save a new gallary

		$gallery->name = $request->input('gallery_name');
		$gallery->created_by = Auth::user()->id;
		$gallery->published = 1;
		$gallery->save();

		return redirect()->back();

	}

	public function viewGalleryPics($id){

		$gallery = Gallery::findOrFail($id);

		return view('gallery.gallery-view')->with('gallery', $gallery);

	}

	public function doImageUpload(Request $request){

		//get the file from the post request
		$file = $request->file('file');

		//set my file name
		$filename = uniqid() . $file->getClientOriginalName();

		//move the file to the correct location
		$file->move('gallery/images', $filename);

		//save the image detail o the database
		$gallery = Gallery::find($request->input('gallery_id'));
		$image = $gallery->images()->create([
				'gallery_id' => $request->input('gallery_id'),
				'file_name' => $filename,
				'file_size' => $file->getClientSize(),
				'file_mime' => $file->getClientMimeType(),
				'file_path' => 'gallery/images/' . $filename,
				'created_by' => Auth::user()->id,
			]);

		return $image;
	}

	public function deleteGallery($id){

		$currentGallery = Gallery::findOrFail($id);

		if($currentGallery->created_by != Auth::user()->id){
			abort('403', 'You are not allowed to delete this gallery');
		}

		$images = $currentGallery->images();

		foreach ($currentGallery->images as $image) {
			unlink(public_path($image->file_path));
		}

		$currentGallery->images()->delete();

		$currentGallery->delete();

		return redirect()->back();
	}

    
}
