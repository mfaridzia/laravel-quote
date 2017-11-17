@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-5 col-md-offset-4">
            <center> 
                <h1> Halaman Notifikasi </h1> 
            </center>
             <ul class="list-group">
                @foreach ($notifications as $notif)
                  <li class="list-group-item text-center"> 
                    <a href="/quotes/{{$notif->quote->slug}}"> 
                        {{ $notif->subject . ' di kutipan ' . $notif->quote->title }} 
                    </a> 
                  </li>
                @endforeach
            </ul>
        </div>
        @php
            $notif_model::where('user_id', $user->id)->where('seen', 0)->update(['seen' => 1]);
        @endphp
    </div>
</div>
@endsection
