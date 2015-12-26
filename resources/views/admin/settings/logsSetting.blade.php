@extends('admin.layouts.default')

@section('content')

<div class="container" >
<div class="logs-settings">


  <div class="row-md-12">
   <h3>Logs And Settings:</h3>
   <div class="header-tap">
     <ul class="nav nav-tabs" id="myTab">
         <li><a data-toggle="tab" href="#setting1">General Settings</a></li>
         @if(Auth::user()->role_id == 1)<li><a data-toggle="tab" href="#setting2">Users & Administrator</a></li>@endif
         <li class="dropdown">
             <a data-toggle="dropdown" class="dropdown-toggle" href="#">Search Engines <b class="caret"></b></a>
             <ul class="dropdown-menu">
                 <li><a data-toggle="tab" href="#drop-setting1">PDF</a></li>
                 <li><a data-toggle="tab" href="#drop-setting2">WEBSITE</a></li>
             </ul>
         </li>
         <li><a data-toggle="tab" href="#setting4">System logs</a></li>
         <li><a data-toggle="tab" href="#setting5">Task</a></li>

     </ul>
   </div>



   <div class="tab-content">
      <div id="setting1" class="tab-pane fade in active" ng-controller="GeneralSettingsController">
          {!! Form::open(array('url'=>'')) !!}
            <p>General settings</p>
            <div class="table-responsives">
              <table class="table table-bordered" id="table-generalSettings" ng-repeat="generalsetting in generalsettings">
                <tr><th>Field</th><th>Content</th></tr>
                <tr><td>Name</td><td>@{{ generalsetting.user_firstname }} @{{ generalsetting.user_lastname }}</td></tr>
                <tr><td>Email</td><td>@{{ generalsetting.user_email }}</td></tr>
                <tr><td>Admin Level</td><td>@{{ generalsetting.role_title }}</td></tr>
              </table>
            </div>
            <div class="tab-footer">
                <div style="clear:right; display: inline;">
                  <button type="button" name="button" class="btn btn-info btn-xs">Edit</button>
                  <button type="button" name="button" class="btn btn-waring btn-xs">Cancel</button>
                  <button type="button" name="button" class="btn btn-success btn-xs" disabled>Save</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>


        @if(Auth::user()->role_id == 1)
        <div id="setting2" class="tab-pane fade">
            <h3>Users & administrator</h3>




            <div class="tab-footer">
                <div style="clear:right; display: inline;">
                  <button type="button" name="button" class="btn btn-default btn-xs">Edit</button>
                <button type="button" name="button" class="btn btn-default btn-xs">Cancel</button>
                <button type="button" name="button" class="btn btn-default btn-xs" disabled>Save</button>
              </div>
            </div>
        </div>
        @endif



        <div id="drop-setting1" class="tab-pane fade"  ng-controller="PdfCrawlerController">
          <div class="row-md-12">
            <div class="table-responsives" id="pdf-crawler-table">
              <table class="table table-hover">
                <tr><th>Retailer Name</th><th>Price List</th><th colspan="3">Settings</th></tr>
                <tr ng-repeat="pdf in pdfs"><td>@{{ pdf.retailer_name }}</td>
                  <td><input type="text" name="pdf[@{{pdf.id}}]" ng-model='pdf.pricelist_file' ng-hide="!edit[@{{pdf.id}}]" class="form-control"><div ng-show="!edit[@{{pdf.id}}]" style="word-wrap:break-word">@{{ pdf.pricelist_file }}</div></td>
                  <td style="min-width:100px;">
                    <div class="inline-block">
                      <input type="checkbox" ng-model="edit[pdf.id]" >Edit    <button type="button" name="save" class="btn btn-success btn-xs" ng-hide="!edit[@{{pdf.id}}]">Save</button>
                    </div>
                  </td>
                  <td>
                      <div class="">
                        <a type="button" name="button" class="btn btn-success btn-xs btn-block" ng-click="extractPdf({'pdf_id':pdf.id,'r_name':pdf.retailer_name})" >Extract Data</a>
                      </div>
                      <div class="" style="margin-top:5px;">
                        <a type="button" name="button" class="btn btn-success btn-xs btn-block" ng-click="processdata({'r_name':pdf.retailer_name})" >Process Data</a>

                      </div>
                  </td>

                </tr>

              </table>
            </div>

          </div>

          <div class="resultcrawlerpdf" >
            <div align="center" class="loader"></div>
          </div>
        </div>
        <div id="drop-setting2" class="tab-pane fade"  ng-controller="WebsiteCrawlerController">            <div class="resultcrawlerwebsite">
              <div align="center" class="loader2"></div>
            </div>
            <div class="table-responsives">
                <table class="table table-hover" >
                  <tr><th>Crawler Name</th><th>Retailer</th><th colspan="3">Settings</th></tr>
                  <tr ng-repeat="webcrawler in webcrawlers">
                    <td>@{{webcrawler.website_crawler}}</td><td>@{{webcrawler.retailer_name}}</td>
                      <td><a type="button" name="button" class="btn btn-success btn-xs" ng-click="startCrawlerWebsite({'crawler_name':webcrawler.website_crawler})" >Start Crawler</a></td>
                  </tr>

                </table>
              </div>
        </div>

        <div id="setting4" class="tab-pane fade" ng-controller="SystemlogsController">
            <h3>System logs</h3>
            <div class="row-xs-12">
              <div class="col-xs-4">
                <h3>@{{ currentPage }}</h3>
              </div>
              <div class="col-xs-4">
                <label for="search">Search:</label>
                <input ng-model="search" id="search" class="form-control" placeholder="Filter text">
              </div>
              <div class="col-xs-4">
                <label for="search">items per page:</label>
                <input type="number" min="1" max="100" class="form-control" ng-model="pageSize">
              </div>
            </div>
            <div class="table table-responsives">
              <table class="table table-strict">
                <tr><th>User ID</th><th>Name</th><th>user level</th><th>Last Login</th></tr>
                <tr style="background-color:black; color:white" dir-paginate="systemlog in systemlogs | filter:search | itemsPerPage: pageSize">
                  <td>@{{ systemlog.id }}</td>
                  <td>@{{ systemlog.user_firstname }} @{{ systemlog.user_lastname }}</td>
                  <td>@{{ systemlog.role_title }}</td>
                  <td>@{{ systemlog.last_login }}</td>
                  </tr>

              </table>
            </div>
            <div ng-controller="SystemlogsController2" class="other-controller">

              <div class="text-center">
                <dir-pagination-controls boundary-links="true" on-page-change="pageChangeHandler(newPageNumber)" template-url="/admin-bootstrap/js/pagination-angular/dirPagination.tpl.html"></dir-pagination-controls>
              </div>
            </div>
            <div class="tab-footer">
                <div style="clear:right; display: inline;">
                  <button type="button" name="button" class="btn btn-default btn-xs">Edit</button>
                  <button type="button" name="button" class="btn btn-default btn-xs">Cancel</button>
                  <button type="button" name="button" class="btn btn-default btn-xs">Save</button>
                </div>
            </div>
        </div>

        <div id="setting5" class="tab-pane fade">
          <h3>Task</h3>
          @if(Auth::user()->role_id == 1)
            <div>
              Create taks
            </div>
          @endif
          <div>
            List of task
          </div>

        </div>
    </div>
  </div>
</div>
</div>
@endsection
