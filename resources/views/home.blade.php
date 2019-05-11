@extends('layouts.app')


@section('content')
<div class="container">
  <div class="row">
        <div class="col-md-12 row-block">
            Name: {{ Auth::user()->name }}<br>
            Profile Picture: <img src="https://graph.facebook.com/v3.0/{{ Auth::user()->facebook_id }}/picture?type=normal" />
        </div>
    </div>
</div>
@endsection
