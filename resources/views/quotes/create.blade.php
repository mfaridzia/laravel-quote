@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Buat Quotes</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(session('error_tag'))
                         <div class="alert alert-danger">
                            {{ session('error_tag') }}
                        </div>
                    @endif

                <form action="/quotes" method="POST" class="form-horizontal">
                    {{ csrf_field() }}
                    
                <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                    <label for="title" class="col-md-4 control-label"> Judul Kutipan </label>
                    <div class="col-md-6">
                        <input type="text" name="title" class="form-control" placeholder="isi judul kutipan" required>
                   
                        @if ($errors->has('title'))
                            <span class="help-block">
                               <strong> {{ $errors->first('title') }} </strong>
                            </span>
                        @endif

                    </div>
                </div>

                <div class="form-group{{ $errors->has('subject') ? ' has-error' : '' }}">
                    <label for="subject" class="col-md-4 control-label"> Isi Kutipan </label>
  
                    <div class="col-md-6">
                        <textarea name="subject" id="" placeholder="isi kutipan disini" class="form-control" value=" {{ old('subject') }}" required=""></textarea>
                        @if ($errors->has('subject'))
                            <span class="help-block">
                                <strong> {{ $errors->first('subject') }} </strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                     <label for="subject" class="col-md-4 control-label"> Tag(Max 3) </label>
                    <div class="col-md-6">
                        <div id="tag_wrapper">
                            <div id="add_tag" class="btn btn-xs btn-default">Add Tag</div> <p></p>
    
                            <select name="tags[]" id="tag_select" class="form-control">
                                <option value="0"> Tidak ada </option>
                                @foreach($tags as $tag) 
                                    <option value="{{ $tag->id }}"> {{ $tag->name }} </option>
                                @endforeach
                            </select>
                            <script src="{{ asset('js/tag.js') }}"></script>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-8 col-md-offset-4">
                        <button type="submit" class="btn btn-default"> Submit Kutipan </button>  
                    </div>
                </div>

                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
