<?php 

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class BaseModel extends Model
{

    public static function boot()
    {
        parent::boot();

        static::creating(function($model)
       {
             $userid = (!Auth::guest()) ? Auth::user()->id : null ;
             $model->user_id = $userid;
        });

        static::updating(function($model)
        {
            $userid = (!Auth::guest()) ? Auth::user()->id : null ;
            $model->user_id = $userid;
        });
    }
}

?>