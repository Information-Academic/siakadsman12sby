@extends('layouts.app')
@section('page','Ubah Password')
@section('content')
<div class="card-body login-card-body">
    <p class="login-box-msg">Ubah Password supaya lebih aman</p>
    @if (Session::has('message'))
    <div class="alert alert-success" role="alert">
       {{ Session::get('message') }}
   </div>
@endif
<form method="POST" action="{{ url('/change-password') }}">
    @csrf
    <label for="password">New Password</label>
    <input id="password" class="form-control" type="password" name="password" required autocomplete="new-password">
    <label for="password_confirmation">Confirm Password</label>
    <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required>
    <button type="submit" class="btn btn-primary">Change Password</button>
</form>
</div>
@endsection
