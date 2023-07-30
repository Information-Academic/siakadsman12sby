@extends('layouts.app')
@section('page','Reset Password')
@section('content')
<div class="card-body login-card-body">
    <p class="login-box-msg">Lupa Password? Disini akan kita bantu cara mengembalikan password lama anda.</p>
    @if (Session::has('message'))
    <div class="alert alert-success" role="alert">
       {{ Session::get('message') }}
   </div>
@endif

 <form action="{{ route('forget.password.post') }}" method="POST">
     @csrf
     <div class="form-group row">
         <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
         <div class="col-md-6">
             <input type="text" id="email_address" class="form-control" name="email" required autofocus>
             @if ($errors->has('email'))
                 <span class="text-danger">{{ $errors->first('email') }}</span>
             @endif
         </div>
     </div>
     <a href="{{route('login')}}">Login saja</a>
         <button type="submit" class="btn btn-primary">
             Send Password Reset Link
         </button>
 </form>
</div>
@endsection