<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{

    use HasFactory;
    //protected $table = 'books'; //par défaut 
    protected $fillable = ['title','author','synopsis', 'prix', 'type', 'availability', 'likes', 'categories', 'user_id'];

	public $timestamps = true;

    public function user() 
	{
		return $this->belongsTo('App\Models\User');
	}


}
