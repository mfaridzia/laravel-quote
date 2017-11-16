<?php

namespace App\Models;
use Auth;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
	protected $fillable = [
        'title', 'slug', 'subject', 'user_id',
    ];

    public function user()
    {
    	return $this->belongsTo('App\Models\User');
    }
    
    public function comments()
    {
        return $this->hasMany('App\Models\QuoteComment');
    }

    // ini bisa di refactor menggunakan trait
    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag');
    }

     // ini bisa di refactor menggunakan trait
    public function likes()
    {
        return $this->morphMany('App\Models\Like', 'likeable');
    }

    public function notifications()
    {
        return $this->hasMany('App\Models\Notification');
    }
    
    // cek apakah user sudah like apa belum
    public function is_liked()
    {
        return $this->likes->where('user_id', Auth::user()->id)->count();
    }

    // cek kepemilikan quote
    public function isOwner()
    {
        // cek jika user sudah login
        if(Auth::guest()) {
            return false;
        }

    	return Auth::user()->id == $this->user->id;
    }
}
