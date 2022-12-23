<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{


	protected $table = 'gallery_images';


    protected $fillable = ['gallary_id', 'file_name', 'file_size', 'file_mime', 'file_path', 'created_by'];


    public function gallery(){
    	return $this->belongsTo('App\Gallery');
    }
}
