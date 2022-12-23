<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Payment extends BaseModel{
	protected $fillable = [
        'user_id', 'payment_id', 'screens_count','total','response'
    ];
        
    protected $hidden = [];

}