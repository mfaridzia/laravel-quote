@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        <div class="col-md-8 col-md-offset-2">
             <div class="jumbotron">
                 
                <h2 class="title"> {{ $quote->title }} </h2>
                <p>  {{ $quote->subject }} </p>
                <p> Ditulis oleh : <a href="/profile/{{ $quote->user->id }}"> {{ $quote->user->name }} </a> </p>
                <p> <a href="/quotes" class="btn btn-primary btn-lg"> Balik ke daftar </a> </p>

               <!--  ini bisa di refactor secara dinamis menggunakan fungsi components pada laravel -->
                <div class="like_wrapper">
                    <div class="btn btn-lg {{ $quote->is_liked() ? 'btn-danger btn-unlike' : 'btn-primary btn-like' }}" 
                    data-model-id="{{ $quote->id }}" data-type="1"> 
                        {{ $quote->is_liked() ? 'Unlike' : 'Like' }}
                    </div>
                    <div class="total_like"> 
                        <span class="like_number"> {{ $quote->likes->count() }} </span> Total Like 
                        <span class="like_warning" style="display:none;"> Tidak boleh like diri sendiri </span>
                    </div>
                </div>

                @if ($quote->isOwner())
                    <a id="btn-edit" href="/quotes/{{ $quote->id }}/edit" class="btn btn-info"> Edit </a> 
                    <form action="/quotes/{{ $quote->id }}" method="POST" class="form-horizontal">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="DELETE">
                        <button id="btn-delete" type="submit" class="btn btn-danger"> Delete </button>
                    </form>
                @endif

             </div>

        </div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                @if (session()->has('message'))
                    <div class="alert alert-success">
                        <p> {{ session('message') }} </p>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-12">
                        @foreach ($quote->comments as $comment)
                            <p class="txt-right"> {{ $comment->subject }} </p>
                            <p class="txt-right"> Komentar oleh : <a href="/profile/{{ $comment->user->id }}"> {{ $comment->user->name }} </a> </p>
                            
                            @if ($comment->isOwner())
                                <a id="btn-edit" href="/quotes-comment/{{ $comment->id }}/edit" class="btn btn-info txt-right"> Edit </a> 
                                <form action="/quotes-comment/{{ $comment->id }}" method="POST" class="form-horizontal">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button id="btn-delete" type="submit" class="btn btn-danger" style="float:left;"> Delete </button>
                                </form>
                            @endif

                             <div class="like_wrapper" style="margin-left:150px;">
                                <div class="btn {{ $comment->is_liked() ? 'btn-danger btn-unlike' : 'btn-primary btn-like' }}"
                                data-model-id="{{ $comment->id }}" data-type="2" style="float:left; margin-left:5px;"> 
                                    {{ $comment->is_liked() ? 'Unlike' : 'Like' }}
                                </div>
                                <div class="total_like"> 
                                    <span class="like_number" style="margin-left:10px;"> {{ $comment->likes->count() }} </span> Total Like 
                                    <span class="like_warning" style="display:none;"> Tidak boleh like diri sendiri </span>
                                </div>
                            </div>

                            <hr/>
                        @endforeach

                    </div>
                </div>

              <form action="/quotes-comment/{{ $quote->id }}" method="POST">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('subject') ? ' has-error' : '' }}">
                        <div class="col-md-12">
                            <textarea name="subject"  rows="5" placeholder="komentar disini....." class="form-control" required=""></textarea>
                            @if ($errors->has('subject'))
                                <span class="help-block">
                                    <strong> {{ $errors->first('subject') }} </strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-default"> Submit Komentar </button>  
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
