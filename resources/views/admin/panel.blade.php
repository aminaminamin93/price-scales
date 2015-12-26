@extends('admin.layouts.default')

@section('content')
<div class="container">
	<div class="row-md-12">
		<div class="col-md-8">
			<div class="left-col-panel">
				<!-- The time line -->
        <ul class="timeline">
          <!-- timeline time label -->
          <li class="time-label">
            <span class="bg-red">
              10 Feb. 2014
            </span>
          </li>
          <!-- /.timeline-label -->
          <!-- timeline item -->
          <li>
            <i class="fa fa-envelope bg-blue"></i>
            <div class="timeline-item">
              <span class="time"><i class="fa fa-clock-o"></i> 12:05</span>
              <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>
              <div class="timeline-body">
                Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                weebly ning heekya handango imeem plugg dopplr jibjab, movity
                jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                quora plaxo ideeli hulu weebly balihoo...
              </div>
              <div class="timeline-footer">
                <a class="btn btn-primary btn-xs">Read more</a>
                <a class="btn btn-danger btn-xs">Delete</a>
              </div>
            </div>
          </li>
          <!-- END timeline item -->
          <!-- timeline item -->
          <li>
            <i class="fa fa-user bg-aqua"></i>
            <div class="timeline-item">
              <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span>
              <h3 class="timeline-header no-border"><a href="#">Sarah Young</a> accepted your friend request</h3>
            </div>
          </li>
          <!-- END timeline item -->
          <!-- timeline item -->
          <li>
            <i class="fa fa-comments bg-yellow"></i>
            <div class="timeline-item">
              <span class="time"><i class="fa fa-clock-o"></i> 27 mins ago</span>
              <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>
              <div class="timeline-body">
                Take me to your leader!
                Switzerland is small and neutral!
                We are more like Germany, ambitious and misunderstood!
              </div>
              <div class="timeline-footer">
                <a class="btn btn-warning btn-flat btn-xs">View comment</a>
              </div>
            </div>
          </li>
          <!-- END timeline item -->
          <!-- timeline time label -->
          <li class="time-label">
            <span class="bg-green">
              3 Jan. 2014
            </span>
          </li>
          <!-- /.timeline-label -->
          <!-- timeline item -->
          <li>
            <i class="fa fa-camera bg-purple"></i>
            <div class="timeline-item">
              <span class="time"><i class="fa fa-clock-o"></i> 2 days ago</span>
              <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>
              <div class="timeline-body">
                <img src="http://placehold.it/150x100" alt="..." class="margin">
                <img src="http://placehold.it/150x100" alt="..." class="margin">
                <img src="http://placehold.it/150x100" alt="..." class="margin">
                <img src="http://placehold.it/150x100" alt="..." class="margin">
              </div>
            </div>
          </li>
          <!-- END timeline item -->
          <!-- timeline item -->
          <li>
            <i class="fa fa-video-camera bg-maroon"></i>
            <div class="timeline-item">
              <span class="time"><i class="fa fa-clock-o"></i> 5 days ago</span>
              <h3 class="timeline-header"><a href="#">Mr. Doe</a> shared a video</h3>
              <div class="timeline-body">
                <div class="embed-responsive embed-responsive-16by9">
                  <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/tMWkeBIohBs" frameborder="0" allowfullscreen></iframe>
                </div>
              </div>
              <div class="timeline-footer">
                <a href="#" class="btn btn-xs bg-maroon">See comments</a>
              </div>
            </div>
          </li>
          <!-- END timeline item -->
          <li>
            <i class="fa fa-clock-o bg-gray"></i>
          </li>
        </ul>	<!-- end of timeline body -->
			</div>
		</div> <!-- End fo col-md-8  -->
		<div class="col-md-4">
			<div class="right-col-panel"  style="padding-right:30px">
				<!-- Responsive calendar - START -->
		    	<div class="responsive-calendar">
			        <div class="controls">
			            <a class="pull-left" data-go="prev"><div class="btn btn-primary">Prev</div></a>
			            <h4><span data-head-year></span> <span data-head-month></span></h4>
			            <a class="pull-right" data-go="next"><div class="btn btn-primary">Next</div></a>
			        </div><hr/>
			        <div class="day-headers">
			          <div class="day header">Mon</div>
			          <div class="day header">Tue</div>
			          <div class="day header">Wed</div>
			          <div class="day header">Thu</div>
			          <div class="day header">Fri</div>
			          <div class="day header">Sat</div>
			          <div class="day header">Sun</div>
			        </div>
			        <div class="days" data-group="days">

			        </div>
		      </div>
		      <!-- Responsive calendar - END -->
			</div>

		</div>
	</div>
</div>
@endsection
