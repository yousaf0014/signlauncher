<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PlayList extends BaseModel
{


	protected $fillable = [
        'name','duration','user_id'
    ];
        
    protected $hidden = [];

    function project(){
        return $this->hasOne('App\Project','play_list');
    }

}
