@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Quotes</div>

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

                <form action="/quotes/{{ $quote->id }}" method="POST" class="form-horizontal">
                    {{ csrf_field() }}
                    
                <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                    <label for="title" class="col-md-4 control-label"> Judul Kutipan </label>
                    <div class="col-md-6">
                        <input type="text" name="title" class="form-control" value="{{ old('title') ? old('title') : $quote->title }}" required>
                   
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
                        <textarea name="subject" id="" class="form-control" required>{{ $quote->subject }}</textarea>
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
    
                            @foreach($quote->tags as $oldtags)
                                <select name="tags[]" id="tag_select" class="form-control">
                                    <option value="0"> Tidak ada </option>
                                    @foreach($tags as $tag) 
                                        <option value="{{ $tag->id }}" 
                                            @if($oldtags->id == $tag->id)
                                                selected="selected"
                                            @endif
                                        > {{ $tag->name }} </option>
                                    @endforeach
                                </select>
                            @endforeach

                            <script src="{{ asset('js/tag.js') }}"></script>
                        </div>
                    </div>
                </div>


                <input type="hidden" name="_method" value="PUT">            
                <div class="form-group">
                    <div class="col-md-8 col-md-offset-4">
                        <button type="submit" class="btn btn-default"> Edit Kutipan </button>  
                    </div>
                </div>

                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
