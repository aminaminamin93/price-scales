<div class="header">
    <div class="row-md-12">
    <div class="col-md-6" style="background:#F2F2F2">
        <div class="user-menu">
            <ul>


                @if(Auth::check())
                    <li><a href="/account/details/{!! Auth::id(); !!}"><i class="fa fa-user"></i>{!! ucwords(Auth::user()->user_firstname) !!}&nbsp;{!! ucwords(Auth::user()->user_lastname) !!}</a></li>
                @else
                    <li><a href="/auth/login"><i class="fa fa-user"></i>Login</a></li>
                    <li><a href="/auth/register"><i class="fa fa-user"></i>Register</a></li>
                @endif
                <li><a href="/favorite/view" style="text-decoration:none;"><i class="fa fa-heart"></i> Favorites</a></li>



            </ul>
        </div>
    </div>

    <div class="col-md-6" style="background:#F2F2F2">
        <div class="header-right">
            <ul class="list-unstyled list-inline">
              <li class="dropdown dropdown-small">
                  <a id="search-btn" style="text-decoration:none;cursor:pointer" ng-click="searchform()">Search Here &nbsp;&nbsp;<span class="key"><i class="fa fa-search"></i></span></a>
              </li>
              @if(Auth::check())
              <li class="dropdown dropdown-small">
                 <a href="/logout" style="text-decoration:none;"><span class="key">Log Out</span></a>

              </li>
              @else
                <li class="btn btn-social-icon btn-xs btn-facebook"><a href="/login/facebook"><span class="fa fa-facebook"></span></a></li>
                <li class="btn btn-social-icon btn-xs btn-twitter"><a href="/login/twitter"><span class="fa fa-twitter"></span></a></li>
                <li class="btn btn-social-icon btn-xs btn-google"><a href="/login/google"><span class="fa fa-google"></span></a></li>
              @endif

            </ul>
        </div>
    </div>
    </div>
</div>
