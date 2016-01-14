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
          
            <p>General settings</p>
            <div class="table-responsives">
              <table class="table table-bordered" id="table-generalSettings" ng-repeat="generalsetting in generalsettings">
                <tr><th>Field</th><th>Content</th></tr>
                <tr>
                    <td>Name</td>
                    <td>
                      <p ng-show="!editable">@{{ generalsetting.user_firstname }} @{{ generalsetting.user_lastname }}</p>
                      <div class="form-inline" ng-show="editable">
                        <div class="form-group">{!! Form::text('admin_fname',null, array('class'=>'form-control input-block','ng-model'=>'generalsetting.user_firstname')) !!}</div>
                       
                        <div class="form-group">{!! Form::text('admin_lname',null, array('class'=>'form-control input-block', 'ng-model'=>'generalsetting.user_lastname')) !!}</div>
                       
                      </div>
                      <div ng-show="error.name">@{{ error.name }}</div>
                    </td>
                </tr>
                <tr>
                    <td><p>Email</p></td>
                    <td>
                      <p ng-show="!editable">@{{ generalsetting.user_email }}</p>
                      <div ng-show="editable">{!! Form::text('admin_email',null, array('class'=>'form-control input-block', 'ng-model'=>'generalsetting.user_email')) !!}</div>
                      <div ng-show="error.email">@{{ error.email }}</div>
                    </td>
                </tr>
                <tr>
                    <td><p>Admin Level</p></td>
                    <td>@{{ generalsetting.role_title }}</td>
                </tr>
                <tr ng-show="editable">
                    <td><p>New Password</p></td>
                    <td>
                      <div >
                        {!! Form::password('password', array('placeholder'=>'New Password','class'=>'form-control', 'ng-model'=>'generalsetting.newpassword')) !!}
                      </div>
                      <!-- <div ng-show="error">@{{ error.password }}</div> -->
                    </td>
                </tr>
                <tr ng-show="editable">
                    <td><p>Confirm Password</p></td>
                    <td>
                        <div>
                        {!! Form::password('confirmation_password', array('placeholder'=>'Confirm New Password', 'class'=>'form-control', 'ng-model'=>'generalsetting.newconfirmation_password')) !!}
                        </div>
                        <div ng-show="error.confirmation_password">@{{ error.confirmation_password }}</div>
                    </td>
                </tr>
                <tr>
                  <td></td>
                  <td>
                    <div style="clear:right; display: inline;">
                          {!! Form::button('Edit', array('class'=>'btn btn-info btn-sm', 'ng-show'=>'!editable', ' ng-click'=>'edit(this)')) !!}
                          {!! Form::button('Save', array('class'=>'btn btn-success btn-sm','ng-show'=>'editable' ,'ng-click'=>'saveGenSettings(this)')) !!}
                          {!! Form::button('Cancel', array('class'=>'btn btn-warning btn-sm','ng-show'=>'editable' ,'ng-click'=>'saveCanceled(this)')) !!}
                    </div>
                  </td> 
                </tr>
              </table>
            </div>
            <div class="tab-footer">
                        
            </div>
            
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
           <!-- {!! Form::open(array('url'=>'/pdfcrawler/saveCrawler/', 'method'=>'POST' , 'ng-submit'=>'saveCrawler($event)') )!!} -->
              <table class="table table-hover">
              
                <tr><th>Retailer Name</th><th>Price List</th>@if(Auth::user()->role_id == 1)<th>Modify</th>@endif<th>Process</th><th>Status</th></tr>
                <tr ng-repeat="pdf in pdfs"><td>@{{ pdf.retailer_name }}</td>
                  <td><input type="text" name="pdf[@{{pdf.pdf_id}}]" ng-model='pdf.pricelist_file' ng-hide="!edit[@{{pdf.pdf_id}}]" class="form-control"><div ng-show="!edit[@{{pdf.pdf_id}}]" style="word-wrap:break-word">@{{ pdf.pricelist_file }}</div></td>
                  @if(Auth::user()->role_id == 1)
                  <td style="min-width:100px;">
                    <div class="inline-block">
                    <div ng-hide="edit[@{{pdf.pdf_id}}]"><input type="checkbox" ng-model="edit[pdf.pdf_id]" ></div>
                    <div ng-hide="!edit[@{{pdf.pdf_id}}]">
                      <button type="button" name="save" class="btn btn-success btn-sm btn-block" ng-click="saveCrawler(pdf, this)" ng-show="!removetable">
                          <span ng-show="!spinnerSave" >Save</span>
                          <span>
                          <div id="circularG" ng-show="spinnerSave">
                            <div id="circularG_1" class="circularG"></div>
                            <div id="circularG_2" class="circularG"></div>
                            <div id="circularG_3" class="circularG"></div>
                            <div id="circularG_4" class="circularG"></div>
                            <div id="circularG_5" class="circularG"></div>
                            <div id="circularG_6" class="circularG"></div>
                            <div id="circularG_7" class="circularG"></div>
                            <div id="circularG_8" class="circularG"></div>
                          </div>
                          </span>
                      </button>
                    </div>
                    <div style="margin-top:5px;"  ng-hide="!edit[@{{pdf.pdf_id}}]">
                      <button type="button" name="delete" class="btn btn-danger btn-sm btn-block" ng-click="removetable=true" ng-show="!removetable">
                          <span>Delete</span> 
                      </button>
                      <button type="button" name="confirmdelete" class="btn btn-danger btn-sm btn-block" ng-click="deleteCrawler($index, this)" ng-show="removetable">
                          <span ng-show="!spinnerDelete" >Confirm Delete</span>
                          <span>
                          <div id="circularG" ng-show="spinnerDelete">
                            <div id="circularG_1" class="circularG"></div>
                            <div id="circularG_2" class="circularG"></div>
                            <div id="circularG_3" class="circularG"></div>
                            <div id="circularG_4" class="circularG"></div>
                            <div id="circularG_5" class="circularG"></div>
                            <div id="circularG_6" class="circularG"></div>
                            <div id="circularG_7" class="circularG"></div>
                            <div id="circularG_8" class="circularG"></div>
                          </div>
                          </span>
                      </button>
                      <button type="button" name="canceldelete" class="btn btn-warning btn-sm btn-block" ng-click="removetable = false" ng-show="removetable">
                          <span>Cancel Delete</span>
                      </button>
                    </div>
                   </div>
                  </td>
                  @endif
                  <td>
                      <a type="button" name="button" class="btn btn-success btn-sm btn-block" style="text-align:center;" ng-click="processCrawler(pdf,this)" >
                          <span ng-show="!spinner" >Process Data</span>
                          <span>
                          <div id="circularG" ng-show="spinner">
                            <div id="circularG_1" class="circularG"></div>
                            <div id="circularG_2" class="circularG"></div>
                            <div id="circularG_3" class="circularG"></div>
                            <div id="circularG_4" class="circularG"></div>
                            <div id="circularG_5" class="circularG"></div>
                            <div id="circularG_6" class="circularG"></div>
                            <div id="circularG_7" class="circularG"></div>
                            <div id="circularG_8" class="circularG"></div>
                          </div>
                          </span>
                          </a>
                  </td>
                  <td>                        
                  
                          <span ng-show="status">@{{ status }}</span>
                  </td>
                </tr>

              </table>
              <!-- {!! Form::close() !!} -->
            </div>

          </div>

          <div class="resultcrawlerpdf" >
            <div align="center" class="loader"></div>
          </div>
        </div>
        <div id="drop-setting2" class="tab-pane fade"  ng-controller="WebsiteCrawlerController">            
            <div class="table-responsives">
              <table class="table table-hover" >
                <tr><th>Crawler Name</th><th>Retailer</th><th>Settings</th><th>Status</th></tr>
                <tr ng-repeat="webcrawler in webcrawlers">
                  <td>@{{webcrawler.website_crawler}}</td>
                  <td>@{{webcrawler.retailer_name}}</td>
                  <td style="padding-right:30px;">
                    <a type="button" name="button" class="btn btn-success btn-sm btn-block" ng-click="startCrawlerWebsite(webcrawler.website_crawler, this)" >
                    <span ng-show="!spinner">Start Crawler</span>
                    <span>
                        <div id="circularG" ng-show="spinner">
                          <div id="circularG_1" class="circularG"></div>
                          <div id="circularG_2" class="circularG"></div>
                          <div id="circularG_3" class="circularG"></div>
                          <div id="circularG_4" class="circularG"></div>
                          <div id="circularG_5" class="circularG"></div>
                          <div id="circularG_6" class="circularG"></div>
                          <div id="circularG_7" class="circularG"></div>
                          <div id="circularG_8" class="circularG"></div>
                        </div>
                    </span>
                    </a>
                  </td>
                  <td><span ng-show="status">@{{ status }}</span></td>
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
