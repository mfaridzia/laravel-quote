<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Tag;
use App\Models\User;
use App\Models\Quote;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tags = Tag::all();
        $search_q = urldecode($request->input('search'));
        if(!empty($search_q))
            $quotes = Quote::with('tags')->where('title', 'like', '%'.$search_q.'%')->get();
        else 
            $quotes = Quote::with('tags')->get();

        return view('quotes.index', compact('quotes', 'tags'));
    }

    public function filter($tag)
    {
        $tags = Tag::all();

        // whereHas untuk data yg berelasi
        $quotes = Quote::with('tags')->whereHas('tags', function($query) use($tag) {
            $query->where('name', $tag);
        })->get();

        return view('quotes.index', compact('quotes', 'tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::all();
        return view('quotes.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|min:3',
            'subject' => 'required|min:5'
        ]);
        
        // array_diff untuk membandingkan 2 nilai array
        $request->tags = array_diff($request->tags, [0]);
        if(empty($request->tags))
            return redirect('/quotes/create')->withInput($request->input());

        $slug = str_slug($request->title, '-');

        if(Quote::where('slug', $slug)->first() != null) {
            $slug = $slug . '-'. time();
        }

        $quote = Quote::create([
            'title'   => $request->title,
            'slug'    => $slug,
            'subject' => $request->subject, 
            'user_id' => Auth::user()->id
        ]);

        // untuk insert data relasi many to many
        // PR edit dan delete data relasi many to many menggunakan onDelete dan onUpdate cascade di migration
        $quote->tags()->attach($request->tags);

        $request->session()->flash('message', 'Sukses ngebuat quote');
        $request->session()->flash('error_tag', 'Tag tidak boleh kosong!');
        return redirect('/quotes');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        // menggunakan egaer loading(with) untuk optimaze query
        $quote = Quote::with('comments.user')->where('slug', $slug)->first();
        
        if(!$quote)
            return abort('404');

        return view('quotes.single', compact('quote'));
    }

    public function randomQuote()
    {
        $quote = Quote::inRandomOrder()->first();
        return view('quotes.single', compact('quote'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $quote = Quote::findOrFail($id);
        $tags  = Tag::all();
        return view('quotes.edit', compact('quote', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'   => 'required|min:3',
            'subject' => 'required|min:5'
        ]);

        // validasi ini bisa di refactor
        // validasi untuk tags
        $request->tags = array_diff($request->tags, [0]);
        if(empty($request->tags)) {
            $request->session()->flash('error_tag', 'Tag tidak boleh kosong!');
            return redirect('/quotes/'.$id.'/edit')->withInput($request->input());
        }

        $quote = Quote::findOrFail($id);

        // cek kepemilikan kutipan
        if($quote->isOwner()) {
            $quote->update([
                'title'   => $request->title,
                'subject' => $request->subject
            ]);
            // untuk edit data relasi mano to many
            $quote->tags()->sync($request->tags);
        } else {
            return abort(403);
        }

        $request->session()->flash('message', 'Sukses edit quote');
        return redirect('/quotes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $quote = Quote::findOrFail($id);

        if($quote->isOwner()) {
            $quote->delete();
        } else {
            return abort(403);
        }

        $request->session()->flash('message', 'Sukses hapus quote');
        return redirect('/quotes');
    }
}
