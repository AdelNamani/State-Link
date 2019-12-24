<nav class="navbar fixed-top" style="padding: 0.5rem 0">
    <div class="d-flex align-items-center navbar-left">
        <a href="#" class="menu-button d-none d-md-block">
            <svg class="main" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 9 17">
                <rect x="0.48" y="0.5" width="7" height="1" />
                <rect x="0.48" y="7.5" width="7" height="1" />
                <rect x="0.48" y="15.5" width="7" height="1" />
            </svg>
            <svg class="sub" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 17">
                <rect x="1.56" y="0.5" width="16" height="1" />
                <rect x="1.56" y="7.5" width="16" height="1" />
                <rect x="1.56" y="15.5" width="16" height="1" />
            </svg>
        </a>

        <a href="#" class="menu-button-mobile d-xs-block d-sm-block d-md-none">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 17">
                <rect x="0.5" y="0.5" width="25" height="1" />
                <rect x="0.5" y="7.5" width="25" height="1" />
                <rect x="0.5" y="15.5" width="25" height="1" />
            </svg>
        </a>

        <div class="search">
            <input placeholder="Rechercher...">
            <span class="search-icon">
                    <i class="simple-icon-magnifier"></i>
                </span>
        </div>
    </div>


    <a class="navbar-logo" href="javascript:void(0)">
        <span  class="logo d-none d-xs-block" style="height: 70px;background-size: contain;"></span>
        <span  class="logo-mobile d-block d-xs-none" style="height: 70px;background-size: contain;"></span>
    </a>

    <div class="navbar-right">
        <div class="header-icons d-inline-block align-middle">
            <div class="position-relative d-inline-block">
                <button class="header-icon btn btn-empty" type="button" id="notificationButton" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                    <i class="simple-icon-bell"></i>
                    <span class="count">3</span>
                </button>
                <div class="dropdown-menu dropdown-menu-right mt-3 scroll position-absolute" id="notificationDropdown">

                    <div class="d-flex flex-row mb-3 pb-3 border-bottom">
                        <div class="pl-3 pr-2">
                            <a href="#">
                                <p class="font-weight-medium mb-1">1 projet vient d'etre commenté</p>
                                <p class="text-muted mb-0 text-small">24.12.2019 - 17:50</p>
                            </a>
                        </div>
                    </div>

                    <div class="d-flex flex-row mb-3 pb-3 border-bottom">
                        <div class="pl-3 pr-2">
                            <a href="#">
                                <p class="font-weight-medium mb-1">3 nouvelles propositions</p>
                                <p class="text-muted mb-0 text-small">24.12.2019 - 15:05</p>
                            </a>
                        </div>
                    </div>


                    <div class="d-flex flex-row mb-3 pb-3 border-bottom">
                        <div class="pl-3 pr-2">
                            <a href="#">
                                <p class="font-weight-medium mb-1">Un projet va bientot se lancer</p>
                                <p class="text-muted mb-0 text-small">24.12.2019 - 12:45</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <button class="header-icon btn btn-empty d-none d-sm-inline-block" type="button" id="fullScreenButton">
                <i class="simple-icon-size-fullscreen"></i>
                <i class="simple-icon-size-actual"></i>
            </button>
        </div>

        <div class="user d-inline-block">
            <button class="btn btn-empty p-0" type="button" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                <span class="name">{{Auth::user()->first_name.' '.Auth::user()->last_name}}</span>
                <span>
                    @if(Auth::user()->photo)
                        <img alt="Profile Picture" src="{{ Auth::user()->photo->getUrl('thumb') }}" />
                    @endif
                </span>
            </button>

            <div class="dropdown-menu dropdown-menu-right mt-3">
                <a class="dropdown-item" href="javascript:void(0)">Account</a>
                <a class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logoutform').submit();" href="">Sign out</a>
                <form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </div>
        </div>
    </div>
</nav>
