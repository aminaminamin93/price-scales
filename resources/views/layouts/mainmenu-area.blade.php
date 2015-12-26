<div class="mainmenu-area" >
    <div class="container">
        <div class="row">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-left">
                    <li @if($title == "Home" || $title == "Welcome")class="active" @endif>
                        <a href="/">Home</a>
                    </li>
                    <li class="li-category"><a id="li-category">Category</a>
                        <div style=" background-color: #D0F1FA; ">
                        <div class="view-category" >
                        <table>

                         </table>
                        </div>
                        </div>

                    </li>
                    <li class="li-brand"><a id="li-brand">Brand</a>
                        <div style=" background-color: #D0F1FA; ">
                        <div class="view-brand" >
                          <table>

                           </table>
                        </div>
                        </div>

                    </li>

                     <li><a href="contact">Contact</a></li>

                </ul>
                <form class="navbar-form navbar-right" role="search">
                  <div class="inline-block-custom">
                    <input type="text" class="form-control" placeholder="Search" style="min-width:100%" ng-model="searchProducts" ng-keyup="departmentSearch(searchProducts)">
                  </div>
                  <div class="inline-block-custom">
                      <a class="btn btn-default btn-xs-block"><span class="glyphicon glyphicon-search"></span></a>
                  </div>

                </form>

            </div>
        </div>
    </div>
</div>
<!-- End mainmenu area -->
