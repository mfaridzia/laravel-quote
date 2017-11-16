<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Models\Like;
use App\Models\Quote;
use App\Models\QuoteComment;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function like($type, $model_id)
    {
    	$results    = $this->check_type($type, $model_id);
        $model_type = $results[0];
        $model      = $results[1];

        // untuk validasi user tidak boleh like diri sendiri
        if(Auth::user()->id == $model->user->id)
            die('0');

        // untuk validasi tidak boleh like berulang kali
        if($model->is_liked() == null) {
        	Like::create([
        		'user_id'       => Auth::user()->id,
        		'likeable_id'   => $model_id,
        		'likeable_type' => $model_type
        	]);
        }
    }

    // system unlike comment maupun quote
    public function unlike($type, $model_id)
    {
        $results    = $this->check_type($type, $model_id);
        $model_type = $results[0];
        $model      = $results[1];

        // untuk validasi tidak boleh like berulang kali
        if($model->is_liked()) {
            Like::where('user_id', Auth::user()->id)
                ->where('likeable_id', $model_id)
                ->where('likeable_type', $model_type)
                ->delete();
        }
    }

    // refactor
    public function check_type($type, $model_id)
    {
        if($type == 1) {
            $model_type = "App\Models\Quote";
            $model  = Quote::find($model_id);
        } else {
            $model_type = "App\Models\QuoteComment";
            $model = QuoteComment::find($model_id);
        }

        return [$model_type, $model];
    }


}
