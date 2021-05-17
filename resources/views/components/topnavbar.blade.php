<nav class="navbar fixed-top">
    <div class="d-flex align-items-center navbar-left">
        <a href="#" class="menu-button d-none d-md-block">
            <i class="fa fa-bars fa-3x" aria-hidden="true"></i>
        </a>

        <a href="#" class="menu-button-mobile d-xs-block d-sm-block d-md-none">
            <i class="fa fa-bars fa-2x" aria-hidden="true"></i>
        </a>
    </div>


    <a class="navbar-logo" href="/">
        <span class="logo d-none d-xs-block">
            <img src="https://qrlogins.s3-ap-southeast-2.amazonaws.com/img/logo-black.svg" alt="" class="et_logo">
        </span>
        <span class="logo-mobile d-block d-xs-none"></span>
    </a>

    <div class="navbar-right">
        <div class="user d-inline-block">
            <button class="btn btn-empty p-0" type="button" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                <i class="fa fa-user-circle-o fa-2x" style="padding-right: 5px" aria-hidden="true"></i>{{ Auth::user()->name }}
            </button>

            <div class="dropdown-menu dropdown-menu-right mt-3">
                <a class="dropdown-item" href="{{ route('profile-update') }}" >Change Password</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" uk-hidden>
                    @csrf
                </form>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign out</a>
            </div>
        </div>
    </div>
</nav>