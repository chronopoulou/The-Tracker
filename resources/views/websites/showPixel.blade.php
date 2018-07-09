@extends('admin.layout.layout')

@section('title', 'Dashboard')
@section('mainContent')
  <div class="row">
    <div class="col-md-12">
        <div class="bgc-white bd bdrs-3 p-20 mB-20">
            <h4 class="c-grey-900 mB-20">Tracking Pixel of {{$website->url}}</h4>
            <p>Copy and paste the following code before the <code class="highlighter-rouge">&lt;/body&gt;</code> tag </p>
            <div class="form-group row">
                <div class="col-sm-12">
                    <input type="text" class="form-control" name="url" value='<script src="{{route('api.websites.showPixel', ["hash" => $website->hash])}}" async></script>' disabled>
                </div>
            </div>
            <a class="btn btn-secondary btn-block cur-p" href="{{route('websites.index')}}" style="display: inline-block; width: auto;  margin-bottom:10px;">DONE</a>

        </div>
      </div>
  </div>
@endsection
