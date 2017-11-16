<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Models\Quote;
use App\Models\QuoteComment;
use App\Models\Notification;
use Illuminate\Http\Request;

class QuoteCommentController extends Controller
{
    public function store(Request $request, $id)
    {
        $request->validate([
            'subject' => 'required|min:5'
        ]);

        $quote = Quote::findOrFail($id);
        
        QuoteComment::create([
            'subject'  => $request->subject,
            'quote_id' => $id,
            'user_id'  => Auth::user()->id
        ]);

        // bagian notifikasi 
        if($quote->user->id != Auth::user()->id) {
            Notification::create([
                'subject'  => 'ada komentar dari'. Auth::user()->name,
                'user_id'  => $quote->user->id,
                'quote_id' => $id
            ]);
        }

        $request->session()->flash('message', 'Sukses submit komentar');
        return redirect('/quotes/'. $quote->slug);
    }

    public function edit($id)
    {
        $comment = QuoteComment::findOrFail($id);
        return view('/quotes-comment.edit', compact('comment'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'subject' => 'required|min:5'
        ]);

        $comment = QuoteComment::findOrFail($id);

        if($comment->isOwner()) {
            $comment->update([
                'subject' => $request->subject
            ]);
        } else {
            return abort(403);
        }

        $request->session()->flash('message', 'Sukses edit komentar');
        return redirect('/quotes/'. $comment->quote->slug);
    }

    public function destroy(Request $request, $id)
    {
        $comment = QuoteComment::findOrFail($id);

        if($comment->isOwner()) {
            $comment->delete();
        } else {
            return abort(403);
        }

        $request->session()->flash('message', 'Sukses hapus komentar');
        return redirect('/quotes/'.$comment->quote->slug);
    }
}
