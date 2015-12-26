@extends('admin.layouts.default')

@section('content')
<div class="mailbox-container"  ng-controller="mailListController">
  <div class="row-md-10">
    <div class="col-md-3">
      <a href="compose.html" class="btn btn-primary btn-block margin-bottom">Compose</a>
      <div class="box box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">Folders</h3>
          <div class="box-tools">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div>
        <div class="box-body no-padding">
          <ul class="nav nav-pills nav-stacked">
            <li class="active"><a href="#"><i class="fa fa-inbox"></i> Inbox <span class="label label-primary pull-right">12</span></a></li>
            <li><a href="#"><i class="fa fa-envelope-o"></i> Sent</a></li>
            <li><a href="#"><i class="fa fa-file-text-o"></i> Drafts</a></li>
            <li><a href="#"><i class="fa fa-filter"></i> Junk <span class="label label-warning pull-right">65</span></a></li>
            <li><a href="#"><i class="fa fa-trash-o"></i> Trash</a></li>
          </ul>
        </div><!-- /.box-body -->
      </div><!-- /. box -->
      <div class="box box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">Labels</h3>
          <div class="box-tools">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div>
        <div class="box-body no-padding">
          <ul class="nav nav-pills nav-stacked">
            <li><a href="#"><i class="fa fa-circle-o text-red"></i> Important</a></li>
            <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> Promotions</a></li>
            <li><a href="#"><i class="fa fa-circle-o text-light-blue"></i> Social</a></li>
          </ul>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->
    <div class="col-md-9">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Inbox</h3>
          <div class="box-tools pull-right">
            <div class="has-feedback">
              <input type="text" class="form-control input-sm" placeholder="Search Mail" ng-model="search_mail">
              <span class="glyphicon glyphicon-search form-control-feedback"></span>
            </div>
          </div><!-- /.box-tools -->
        </div><!-- /.box-header -->
        <div class="box-body no-padding">
          <div class="mailbox-controls">
            <!-- Check all button -->
            <button class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
            <div class="btn-group">
              <button class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
              <button class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
              <button class="btn btn-default btn-sm"><i class="fa fa-share"></i></button>
            </div><!-- /.btn-group -->
            <button class="btn btn-default btn-sm" ng-click="refresh_mailbox()" data-translate><i class="fa fa-refresh"></i></button>
            <div class="pull-right">
              <span>@{{ mailLimit + 1 }} - @{{ mailTotal.length + mailLimit }}</span>/<span ng-repeat="total_mailbox in total_mailboxs">@{{ total_mailbox.total }}</span>
              <!-- <input type="text" ng-model="mailLimit" class="form-control" ng-change="mailListLimit(mailLimit)"/> -->
               <div class="btn-group">
                <button class="btn btn-default btn-sm" ng-click="mailListLimit(-2)" ng-disabled="disableLeftRange"><i class="fa fa-chevron-left"></i></button>
                <button class="btn btn-default btn-sm" ng-click="mailListLimit(2)" ng-disabled="disableRightRange"><i class="fa fa-chevron-right"></i></button>
              </div><!-- /.btn-group -->
            </div><!-- /.pull-right -->
          </div>
          <div class="table-responsive mailbox-messages" >
            <table class="table table-hover table-striped">
              <tbody>
                <tr ng-repeat="mailList in mailLists | filter:search_mail">
                  <td><input type="checkbox"></td>
                  <td class="mailbox-star"><a href="#"><i class="fa fa-star text-yellow"></i></a></td>
                  <td class="mailbox-name"><a href="#">@{{ mailList.user_firstname }}</a></td>
                  <td class="mailbox-subject"><b>@{{ mailList.message_title }}</b> @{{ mailList.message_content | strlimit:true:15: '......' }}</td>
                  <td class="mailbox-attachment"></td>
                  <td class="mailbox-date">@{{ mailList.message_created_date |timeago }}</td>
                </tr>


              </tbody>
            </table><!-- /.table -->
          </div><!-- /.mail-box-messages -->
        </div><!-- /.box-body -->
        <div class="box-footer no-padding">
          <div class="mailbox-controls">
            <!-- Check all button -->
            <button class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
            <div class="btn-group">
              <button class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
              <button class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
              <button class="btn btn-default btn-sm"><i class="fa fa-share"></i></button>
            </div><!-- /.btn-group -->
            <button class="btn btn-default btn-sm" ng-click="refresh_mailbox()"><i class="fa fa-refresh"></i></button>
            <div class="pull-right">
               <!-- ng-repeat="total_mailbox in total_mailboxs" -->
              <span>@{{ mailLimit + 1 }} - @{{ mailTotal.length + mailLimit }}</span>/<span ng-repeat="total_mailbox in total_mailboxs">@{{ total_mailboxs.total }}</span>
              <div class="btn-group">
                <button class="btn btn-default btn-sm" ng-click="mailListLimit(-2)" ng-disabled="disableLeftRange"><i class="fa fa-chevron-left" ></i></button>
                <button class="btn btn-default btn-sm" ng-click="mailListLimit(2)" ng-disabled="disableRightRange"><i class="fa fa-chevron-right"></i></button>
              </div><!-- /.btn-group -->
            </div><!-- /.pull-right -->
          </div>
        </div>
      </div><!-- /. box -->
    </div><!-- /.col -->
  </div><!-- /.row -->
</div> <!-- container -->
@endsection
