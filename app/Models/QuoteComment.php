<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Model;

class QuoteComment extends Model
{
	protected $fillable = [
        'subject', 'quote_id', 'user_id',
    ];

    public function user()
    {
    	return $this->belongsTo('App\Models\User');
    }

    public function quote()
    {
    	return $this->belongsTo('App\Models\Quote');
    }

    public function likes()
    {
        return $this->morphMany('App\Models\Like', 'likeable');
    }

    // cek apakah user sudah like apa belum
    public function is_liked()
    {
        return $this->likes->where('user_id', Auth::user()->id)->count();
    }

    public function isOwner()
    {
        // cek jika user sudah login
        if(Auth::guest()) {
            return false;
        }

        return Auth::user()->id == $this->user->id;
    }
}
