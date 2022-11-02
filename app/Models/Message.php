<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['form', 'to', 'message', 'is_read'];

    public $timestamps = true;

    public function user() 
	{
		return $this->belongsTo('App\Models\User', 'from', 'id');
    }
    
}
