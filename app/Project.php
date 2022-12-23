<?php
namespace App;
use Illuminate\Database\Eloquent\Model;


class Project extends Model{

      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
            'name','design','published','public','play_list'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
}
