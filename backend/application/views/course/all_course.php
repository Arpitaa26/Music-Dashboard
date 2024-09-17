        
<style>

</style>
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Course</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                                <li class="breadcrumb-item active">Course</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                           
                           <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title font-weight-bold"><i class="fa fa-tasks"></i>&nbsp; Courses</h3>
                                </div>
                                <div class="card-body table-responsive p-2">
                                <div id="course_detail_tab" class="tabcontent">
                                  <section class="content">
                                    <div class="row flex-row">
                                        <?php foreach($all_course as $course){ ?>
       
    
                                      <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                        <div class="coursebox">
                                          <a href="#" class="course_detail_id text-dark" data-id="53" data-backdrop="static" data-keyboard="false"
                                            data-toggle="modal" data-target="#course_detail_modal">
                                            <div class="coursebox-img">
                                              <img src="<?=base_url();?>uploads/course/course_thumbnail/course_thumbnail53.jpg">
                                              <div class="author-block author-wrap">
                                
                                                <img class="img-circle" src="<?=base_url();?>uploads/staff_images/default_male.jpg" alt="">
                                
                                
                                                <span class="authorname">Jason Sharlton (900002301)</span>
                                                <span class="description"><span>Last Updated </span> 08/05/2023</span>
                                
                                              </div>
                                            </div>
                                            <div class="coursebox-body">
                                              <h4>Classroom Management : </h4>
                                              <div class="course-caption">Participants will learn classroom management strategies and skills that will
                                                benefit their students. They will learn how to create structure and routines, how to set expectations,
                                                and how to make smooth transitions from one activity to the next, plus so much more. These strategies
                                                will help to reduce the amount of down time for children thus, reducing student behavior issues in the
                                                classroom. Classroom Management will be discussed such as the following: Structure and Routines in the
                                                classroom the need and benefit of them. Knowing your students and their needs (how to incorporate those
                                                into your management system).</div>
                                
                                              <div class="classstats">
                                                <b>Course</b>: <?=$course->name;?></br>
                                                <b>Course Level</b>:<?=$course->level;?></br>
                                                 <b>Course Session</b>: <?=$course->type;?></br>
                                                 <b>Country</b>: <?=$course->country_name;?></br>
                                              </div>
                                
                                              <div class="classstats">
                                                <div><i class="fa fa-list-alt"></i>Class - Class 3</div>
                                                <div class="webkit-line">
                                                  <i class="fa fa-play-circle"></i>Lesson 2
                                                </div>
                                              </div>
                                              <div class="classstats">
                                                <div>
                                                  $<?=$course->price?>.00 <span><del>$200.00</del></span> </div>
                                                <div class="webkit-line"><i class="fa fa-clock-o"></i>04:00:00 Hrs</div>
                                              </div>
                                            </div>
                                          </a>
                                
                                          <div class="coursebtn">
                                
                                
                                            <a href="#" class="btn btn-add course_detail_id" data-id="53" data-backdrop="static" data-keyboard="false"
                                              data-toggle="modal" data-target="#course_detail_modal">Manage Course</a>
                                
                                
                                
                                            <a href="#" class="btn btn-buygreen course_preview_id pull-right" data-id="53" data-backdrop="static"
                                              data-keyboard="false" data-toggle="modal" data-target="#course_preview_modal">Course Preview</a>
                                
                                          </div>
                                        </div>
                                      </div><!--./col-lg-3-->
                                    <?php } ?>
                                    </div>
                                  </section>
                                </div>
                           
                           
                         </div>
                        </div>
                          <!-- /.col-md-12 -->
                    </div>
                      <!-- /.row-->
                </div>
               <!-- /.container-fluid-->
            </section>
            <!-- /.content -->
   <div id="course_preview_modal" class="modal fade" role="dialog">
      <div class="modal-dialog modalwrapwidth modal-lg">
        <div class="modal-content">
          <button type="button" class="close" data-dismiss="modal" onclick="stopvideo()">&times;</button>
            <div class="scroll-area">
              <div class="modal-body paddbtop">
                  <div class="row">
                    <div id="course_preview">

                    </div>
                  </div><!--./row-->
              </div><!--./modal-body-->
          </div>
        </div>
      </div>
    </div><!--#/coursedetailmodal-->
 <script>
(function ($) {
 "use strict";

 $('.course_preview_id').click(function(){
    var courseID = $(this).attr('data-id');
   
	$('#course_preview').html('kkk');
    $.ajax({
     url  : "",
     type : 'post',
     data : {courseID:courseID},
     beforeSend: function () {
      $('#course_preview').html('Loading...  <i class="fa fa-spinner fa-spin"></i>');
     },

     success : function(response){
       $('#course_preview').html(response);
     }
    });
  })
  
 } ( jQuery ) );
 </script>
            
<script>
function coursedetail(courseid) {
	$('#course_detail').html('');
  $.ajax({
    url  : "",
    type : 'post',
    data : {courseID:courseid},
    success : function(response){
      $('#course_detail').html(response);
    }
  });
}
  function stopvideo(){
    $('#course_preview').html('');
    $('#course_preview_modal').modal('hide');
  } 
  
   (function ($) {
   "use strict";
    $(".sidebar-closebtn").on('click', function () {
      $(".fa-angle-right").toggleClass("rotate");
    });

    $("#menu-toggle").click(function (e) {
      e.preventDefault();
      $(".wrapper-modal").toggleClass("toggled");
    });
  })(jQuery);
  
  function openCourse(evt, courseName) {

	if(courseName == 'course_card_tab'){
		$('#search_area').addClass('hide');
	}else{
		$('#search_area').removeClass('hide');
	}

	var i, tabcontent, tablinks;
	tabcontent = document.getElementsByClassName("tabcontent");
	for (i = 0; i < tabcontent.length; i++) {
		tabcontent[i].style.display = "none";
	}
	tablinks = document.getElementsByClassName("tablinks");
	for (i = 0; i < tablinks.length; i++) {
		tablinks[i].className = tablinks[i].className.replace(" active", "");
	}
	document.getElementById(courseName).style.display = "block";
	evt.currentTarget.className += " active";
}
</script>

<script type="text/javascript">
  (function ($) {
   "use strict";
    $(".sidebar-closebtn").on('click', function () {
      $(".fa-angle-right").toggleClass("rotate");
    });

    $("#menu-toggle").click(function (e) {
      e.preventDefault();
      $(".wrapper-modal").toggleClass("toggled");
    });
  })(jQuery);

</script>
<script type="text/javascript">
    $(document).ready(function () {
        $(".studentsidebar").mCustomScrollbar({
            theme: "minimal"
        });

        $('.studentsideclose, .overlay').on('click', function () {
            $('.studentsidebar').removeClass('active');
            $('.overlay').fadeOut();
        });

        $('#sidebarCollapse').on('click', function () {
            $('.studentsidebar').addClass('active');
            $('.overlay').fadeIn();
            $('.collapse.in').toggleClass('in');
            $('a[aria-expanded=true]').attr('aria-expanded', 'false');
        });
        
         function collapseSidebar() {

        if (Boolean(sessionStorage.getItem('sidebar-toggle-collapsed'))) {
        sessionStorage.setItem('sidebar-toggle-collapsed', '');
        } else {
        sessionStorage.setItem('sidebar-toggle-collapsed', '1');
        }

        }

    function checksidebar() {
        if (Boolean(sessionStorage.getItem('sidebar-toggle-collapsed'))) {
        var body = document.getElementsByTagName('body')[0];
        body.className = body.className + ' sidebar-collapse';
        }
    }

    checksidebar();
    });
</script>
