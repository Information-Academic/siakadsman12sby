<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light" style="background-color: #0f4c81;">
    <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" style="color: #fff;" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <div class="btn-group" role="group">
                    <a id="btnGroupDrop1" style="color: #fff; margin-right: 40px;" type="button" class="dropdown-toggle text-capitalize" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <i class="nav-icon fas fa-user-circle"></i> &nbsp; {{ Auth::user()->nama_depan. ' '.Auth::user()->nama_belakang }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                        <a class="dropdown-item" href="{{ route('profile') }}">
                            <i class="nav-icon fas fa-user"></i> &nbsp; My Profile</a>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="nav-icon fas fa-sign-out-alt"></i> &nbsp; Log Out</a>
                        <hr size="15" color="grey">
                        <span id="jam" style="font-size: 15px;" class="dropdown-item fs-12 hint-text"></span>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                        </div>
                    </div>
                  </div>
            </li>
        </ul>
 </nav>
    <!-- /.navbar -->
<script type="text/javascript">
      window.onload = function() {
         jam();
      }

       function jam() {
        var dt = new Date();
        document.getElementById("jam").innerHTML = (("0"+dt.getDate()).slice(-2)) +"."+ (("0"+(dt.getMonth()+1)).slice(-2)) +"."+ (dt.getFullYear()) +" "+ (("0"+dt.getHours()).slice(-2)) +":"+ (("0"+dt.getMinutes()).slice(-2)) + ":" + (("0"+dt.getSeconds()).slice(-2));
        setTimeout('jam()', 1000);
       }

       function set(e){
          e = e < 10 ? '0'+ e : e;
            return e;
       }
</script>
