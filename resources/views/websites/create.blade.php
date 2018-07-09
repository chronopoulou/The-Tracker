@extends('admin.layout.layout')

@section('title', 'Dashboard')
@section('mainContent')
  <div class="row">
    <div class="col-md-12">
        <div class="bgc-white bd bdrs-3 p-20 mB-20">
            <h4 class="c-grey-900 mB-20">Add New Website</h4>

            <form method="POST" action="{{ route('websites.store') }}">
              {{ csrf_field() }}
              <div class="form-group row">
                  <label for="inputEmail3" class="col-sm-2 col-form-label">Website URL:</label>
                  <div class="col-sm-8">
                      <input type="text" class="form-control" name="url" placeholder="https://example.com">
                      @if ($errors->has('url'))
                          <span class="help-block text-danger">
                              <strong>{{ $errors->first('url') }}</strong>
                          </span>
                      @endif
                  </div>
                  <div class="col-sm-2">
                    <button type="submit" class="btn btn-primary btn-block cur-p" href="">Add Website</button>
                  </div>
              </div>
            </form>

        </div>
      </div>
  </div>
@endsection
