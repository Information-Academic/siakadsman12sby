<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>SMAN 12 Surabaya</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <link rel="icon" type="image/png" href="{{ asset('img/sman12sby.png') }}">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
  <style>
    #transparent{
      background: url('https://media.istockphoto.com/id/1211889635/id/foto/wallpaper-hitam-abstrak-latar-belakang-gelap-minimal-dalam-dan-elegan.jpg?s=170667a&w=0&k=20&c=381hcWs5UCXsYWMm5MJNEwc43JYw0Q7v0SzUuGFEqJU=');
      background-size: cover;
      background-attachment: fixed;
      opacity: 1;
    }
  </style>
  <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</head>

<body class="hold-transition">
  <div class="login-page" id="transparent">
  <div class="login-box">
    <div class="login-logo">
      <img src="{{ asset('img/logosiakad.png') }}" width="100%" alt="">
    </div>

    <div class="login-logo" style="color: white; font-weight: bold;">
      @yield('page')
    </div>

    <div class="card">
      @yield('content')
    </div>

    <footer style="color: white;">
      <marquee>
          <strong>Copyright &copy; <script>document.write(new Date().getFullYear());</script> &diams; <a href="https://sman12sby.sch.id/" style="color: white;">SMA Negeri 12 Surabaya</a>. </strong>
      </marquee>
    </footer>

  </div>
</div>

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
<!-- page script -->
@yield('script')
<script>
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $(document).ready(function(){
      $('#roles').change(function(){
          var kel = $('#roles option:selected').val();
          if (kel == "Guru") {
            $("#noId").addClass("mb-3");
            $("#noId").html(`
              <input id="nomer" type="text" maxlength="5" onkeypress="return inputAngka(event)" placeholder="NIP" class="form-control @error('nomer') is-invalid @enderror" name="nomer" autocomplete="nomer">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-id-card"></span>
                </div>
              </div>
              `);
            $("#pesan").html(`
              @error('nomer')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            `);
          } else if(kel == "Siswa") {
            $("#noId").addClass("mb-3");
            $("#noId").html(`
              <input id="nomer" type="text" placeholder="No Induk Siswa" class="form-control" name="nomer" autocomplete="nomer">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-id-card"></span>
                </div>
              </div>
            `);
            $("#pesan").html(`
              @error('nomer')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            `);
          } else {
            $('#noId').removeClass("mb-3");
            $('#noId').html('');
          }
      });
  });
  function inputAngka(e) {
    var charCode = (e.which) ? e.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57)){
      return false;
    }
    return true;
  }
</script>


@error('nip')
  <script>
    toastr.error("Maaf User ini tidak terdaftar sebagai Guru SMAN 12 Surabaya!");
  </script>
@enderror
@error('guru')
  <script>
    toastr.error("Maaf Guru ini sudah terdaftar sebagai User!");
  </script>
@enderror
@error('nis')
  <script>
    toastr.error("Maaf User ini tidak terdaftar sebagai Siswa SMAN 12 Surabaya!");
  </script>
@enderror
@error('siswa')
  <script>
    toastr.error("Maaf Siswa ini sudah terdaftar sebagai User!");
  </script>
@enderror
@if (session('status'))
  <script>
    toastr.success("{{ Session('success') }}");
  </script>
@endif
@if (Session::has('error'))
    <script>
        toastr.error("{{ Session('error') }}");
    </script>
@endif
</body>
</html>
