@extends('layouts.app', [
    'namePage' => 'Register SIAKAD Sekolah',
    'activePage' => 'register',
    'backgroundImage' => asset('assets') . '/img/sman12sby.jpeg',
])

@section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-5 ml-auto">
                    <div class="info-area info-horizontal">
                        <div class="icon icon-info">
                            <i class="now-ui-icons users_single-02"></i>
                        </div>
                        <div class="description">
                            <h5 class="info-title">{{ __('Buat Akun Baru') }}</h5>
                            <p class="description">
                                {{ __('Bebas dan gratis tanpa dipungut biaya. Ayo buat sekarang!') }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mr-auto">
                    <div class="card card-signup text-center">
                        <div class="card-header ">
                            <h4 class="card-title">{{ __('Buat Akun') }}</h4>
                        </div>
                        <div class="card-body ">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <!--Begin input name -->
                                <div class="input-group {{ $errors->has('nama_depan') ? ' has-danger' : '' }}">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="now-ui-icons users_circle-08"></i>
                                        </div>
                                    </div>
                                    <input class="form-control {{ $errors->has('nama_depan') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('Nama Depan') }}" type="text" name="nama_depan"
                                        value="{{ old('nama_depan') }}" required autofocus>
                                    @if ($errors->has('nama_depan'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('nama_depan') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="input-group {{ $errors->has('nama_belakang') ? ' has-danger' : '' }}">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="now-ui-icons users_circle-08"></i>
                                        </div>
                                    </div>
                                    <input class="form-control {{ $errors->has('nama_belakang') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('Nama Belakang') }}" type="text" name="nama_belakang"
                                        value="{{ old('nama_belakang') }}" required autofocus>
                                    @if ($errors->has('nama_belakang'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('nama_belakang') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="input-group {{ $errors->has('nama_pengguna') ? ' has-danger' : '' }}">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="now-ui-icons users_circle-08"></i>
                                        </div>
                                    </div>
                                    <input class="form-control {{ $errors->has('nama_pengguna') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('Nama Pengguna') }}" type="text" name="nama_pengguna"
                                        value="{{ old('nama_pengguna') }}" required autofocus>
                                    @if ($errors->has('nama_pengguna'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('nama_pengguna') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <!--Begin input email -->
                                <div class="input-group {{ $errors->has('email') ? ' has-danger' : '' }}">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="now-ui-icons ui-1_email-85"></i>
                                        </div>
                                    </div>
                                    <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('Email') }}" type="email" name="email"
                                        value="{{ old('email') }}" required>
                                </div>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                                <!--Begin input role -->
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-user-tag"></span>
                                        </div>
                                    </div>
                                    <select id="role" type="text"
                                        class="form-control @error('role') is-invalid @enderror" name="role"
                                        value="{{ old('role') }}" autocomplete="role">
                                        <option value="">-- Pilih {{ __('Level Pengguna') }} --</option>
                                        <option value="Guru">Guru</option>
                                        <option value="Siswa">Siswa</option>
                                    </select>

                                    @error('role')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <div id="pesan"></div>
                                </div>

                                <div class="input-group" id="noId">
                                </div>
                                <!--Begin input user type-->

                                <!--Begin input password -->
                                <div class="input-group {{ $errors->has('password') ? ' has-danger' : '' }}">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="now-ui-icons objects_key-25"></i>
                                        </div>
                                    </div>
                                    <input class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('Password') }}" type="password" name="password" required>
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <!--Begin input confirm password -->
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="now-ui-icons objects_key-25"></i></i>
                                        </div>
                                    </div>
                                    <input class="form-control" placeholder="{{ __('Confirm Password') }}" type="password"
                                        name="password_confirmation" required>
                                </div>
                                <div class="form-check text-left">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox">
                                        <span class="form-check-sign"></span>
                                        {{ __('Saya setuju dengan syarat dan ketentuan.') }}
                                    </label>
                                </div>
                                <div class="card-footer ">
                                    <button type="submit"
                                        class="btn btn-primary btn-round btn-lg">{{ __('Buat Akun ') }}</button>
                                    <a href="{{ route('login') }}" class="text-center btn btn-light text-blue">Kembali ke
                                        login</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            demo.checkFullPageBackgroundImage();
        });
    </script>
@endpush
