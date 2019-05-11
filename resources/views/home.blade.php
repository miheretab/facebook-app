@extends('layouts.app')


@section('content')
<div class="container">
  <div class="row">
        <div class="col-md-12 row-block">
            <a href="{{url('/logout')}}">Logout</a><br>
            Name: {{ Auth::user()->name }}<br>
            Profile Picture: <img src="{{ Auth::user()->picture_url }}" />
        </div>
    </div>
</div>
@endsection
