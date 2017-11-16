@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
         <div class="col-md-12">
            <a href="/quotes" class="btn btn-primary"> All Quote </a> 
            <a href="/quotes/create" class="btn btn-primary"> Buat Quote </a> 
            <a href="/quotes/random" class="btn btn-primary"> Random Quote </a> 
            
            <span> Filter By :
                @foreach($tags as $tag)
                    <a href="/quotes/filter/{{$tag->name}}"> / {{ $tag->name }} </a>
                @endforeach
            </span>

            <br/> <br/>
        </div>
    </div>
    
     <div class="row">
        <div class="col-md-2">
            <form action="/quotes" method="GET" class="form-horizontal">
                <input type="text" name="search" class="form-control" placeholder="Search Quote...." required>
            </form>
        </div>
    </div>

    <br/>
    <div class="row">

        @if (session()->has('message'))
            <div class="alert alert-success">
                <p> {{ session('message') }} </p>
            </div>
        @endif
        
        @foreach ($quotes as $quote)
            <div class="col-md-4">
                <div class="thumbnail">
                    <div class="caption"> 
                        <p> {{ $quote->title }} <p>
            
                        @foreach($quote->tags as $tag)
                            <span> <i> Tag:
                                {{ $tag->name }} </i>
                            </span>
                        @endforeach
    
                     <p> <a href="/quotes/{{ $quote->slug }}" class="btn btn-primary"> Lihat Kutipan </a> </p>
                    </div>
                </div>
            </div>

        @endforeach
    </div>
</div>
@endsection
