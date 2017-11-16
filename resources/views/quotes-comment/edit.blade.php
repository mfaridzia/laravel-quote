@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Komentar</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                <form action="/quotes-comment/{{ $comment->id }}" method="POST" class="form-horizontal">
                    {{ csrf_field() }}
                    
                <div class="form-group{{ $errors->has('subject') ? ' has-error' : '' }}">
                    <label for="subject" class="col-md-4 control-label"> Isi Komentar </label>
  
                    <div class="col-md-6">
                        <textarea name="subject" id="" class="form-control" required>{{ $comment->subject }}</textarea>
                        @if ($errors->has('subject'))
                            <span class="help-block">
                                <strong> {{ $errors->first('subject') }} </strong>
                            </span>
                        @endif
                    </div>
                </div>

                <input type="hidden" name="_method" value="PUT">            
                <div class="form-group">
                    <div class="col-md-8 col-md-offset-4">
                        <button type="submit" class="btn btn-default"> Edit Komentar </button>  
                    </div>
                </div>

                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
