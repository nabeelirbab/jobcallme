<?php 
$headerWeb = json_decode(file_get_contents(public_path('website/web-setting.info')),true);
$headerFavicon = url('/website/favicon.ico');
if(file_exists('/website/'.$headerWeb['webFavicon'])){
    $headerFavicon = url('/website/'.$headerWeb['webFavicon']);
}
$navArr = array('jobseeker','manage','resume','employer');
$navPage =  Request::segment(2);

$app = Session::get('jcmUser');
$next = Request::route()->uri;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>@yield('title') &raquo; {{ $headerWeb['webTitle'] }}</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" href="{{ $headerFavicon }}">
		
         <!-- Bootstrap -->
        <link href="{{ asset('frontend-assets/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('frontend-assets/css/style.css') }}" rel="stylesheet">
        <link href="{{ asset('frontend-assets/css/font-awesome.css') }}" rel="stylesheet">
        <link href="{{ asset('frontend-assets/css/animate.css') }}" rel="stylesheet">
        <link href="{{ asset('frontend-assets/css/select2.css') }}" rel="stylesheet">
        <link href="{{ asset('frontend-assets/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
	<link href="{{ asset('frontend-assets/css/component.css') }}" rel="stylesheet">
        <link href="{{ asset('frontend-assets/css/hover-min.css') }}" rel="stylesheet">
        <link href="{{ asset('frontend-assets/css/ihover.css') }}" rel="stylesheet">
	<link href="{{ asset('frontend-assets/css/ticker.css') }}" rel="stylesheet">
	<link href="{{ asset('frontend-assets/css/font-awesome.css') }}" rel="stylesheet">
    <!--FeedBack Form-->
    	<link href="{{ asset('frontend-assets/css/feedBackBox.css') }}" rel="stylesheet">
        <!--Latest Job Slide -->
        <!-- <link href="{{ asset('frontend-assets/css/ticker.css') }}" rel="stylesheet"> -->
        <link href="{{ asset('frontend-assets/css/toastr.css') }}" rel="stylesheet">
        <!--FeedBack Form-->
        <link href="{{ asset('frontend-assets/css/feedBackBox.css') }}" rel="stylesheet">
        <!-- pace -->
        <link rel="stylesheet" type="text/css" href="{{ asset('frontend-assets/pace/pace-theme-flat-top.css') }}">
		
        <?php if(in_array($navPage, $navArr)){ if(!Session::has('jcmUser')){ ?>
            <script type="text/javascript"> window.location.href = "{{ url('account/login?next='.$next) }}"</script>
        <?php }} ?>
        <style type="text/css">
            .mce-branding-powered-by {display: none;}
            .udp-items li {width: 10%;}
			
        </style>
		<style>
		
		.mat-card{transition:box-shadow 280ms cubic-bezier(.4,0,.2,1);display:block;position:relative;padding:24px;border-radius:2px}.mat-card:not([class*=mat-elevation-z]){box-shadow:0 3px 1px -2px rgba(0,0,0,.2),0 2px 2px 0 rgba(0,0,0,.14),0 1px 5px 0 rgba(0,0,0,.12)}@media screen and (-ms-high-contrast:active){.mat-card{outline:solid 1px}}.mat-card-flat{box-shadow:none}.mat-card-actions,.mat-card-content,.mat-card-subtitle,.mat-card-title{display:block;margin-bottom:16px}.mat-card-actions{margin-left:-16px;margin-right:-16px;padding:8px 0}.mat-card-actions-align-end{display:flex;justify-content:flex-end}.mat-card-image{width:calc(100% + 48px);margin:0 -24px 16px -24px}.mat-card-xl-image{width:240px;height:240px;margin:-8px}.mat-card-footer{display:block;margin:0 -24px -24px -24px}.mat-card-actions .mat-button,.mat-card-actions .mat-raised-button{margin:0 4px}.mat-card-header{display:flex;flex-direction:row}.mat-card-header-text{margin:0 8px}.mat-card-avatar{height:40px;width:40px;border-radius:50%;flex-shrink:0}.mat-card-lg-image,.mat-card-md-image,.mat-card-sm-image{margin:-8px 0}.mat-card-title-group{display:flex;justify-content:space-between;margin:0 -8px}.mat-card-sm-image{width:80px;height:80px}.mat-card-md-image{width:112px;height:112px}.mat-card-lg-image{width:152px;height:152px}@media (max-width:600px){.mat-card{padding:24px 16px}.mat-card-actions{margin-left:-8px;margin-right:-8px}.mat-card-image{width:calc(100% + 32px);margin:16px -16px}.mat-card-title-group{margin:0}.mat-card-xl-image{margin-left:0;margin-right:0}.mat-card-header{margin:-8px 0 0 0}.mat-card-footer{margin-left:-16px;margin-right:-16px}}.mat-card-content>:first-child,.mat-card>:first-child{margin-top:0}.mat-card-content>:last-child:not(.mat-card-footer),.mat-card>:last-child:not(.mat-card-footer){margin-bottom:0}.mat-card-image:first-child{margin-top:-24px}.mat-card>.mat-card-actions:last-child{margin-bottom:-16px;padding-bottom:0}.mat-card-actions .mat-button:first-child,.mat-card-actions .mat-raised-button:first-child{margin-left:0;margin-right:0}.mat-card-subtitle:not(:first-child),.mat-card-title:not(:first-child){margin-top:-4px}.mat-card-header .mat-card-subtitle:not(:first-child){margin-top:-8px}.mat-card>.mat-card-xl-image:first-child{margin-top:-8px}.mat-card>.mat-card-xl-image:last-child{margin-bottom:-8px}</style>
    </head>
    <body>
        @include('frontend.includes.header')

        @yield('inner-header')

        @yield('content')

        @include('frontend.includes.footer')

       <a href="#" class="job-notification">
        <i class="fa fa-bell"></i>
        <span class="notification-label">Subscribe for job notifications</span>
    </a>

    <a href="#" class="back-to-top" style="display: inline;">
        <i class="fa fa-arrow-up"></i>
    </a>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="{{ asset('frontend-assets/js/jquery.min.js') }}"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="{{ asset('frontend-assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('frontend-assets/js/select2.js') }}"></script>
        <script src="{{ asset('frontend-assets/js/bootstrap-datetimepicker.js') }}"></script>
		<!--For Text animation-->
         <script src="{{ asset('frontend-assets/js/TweenMax.min.js') }}"></script>
        <script src="{{ asset('frontend-assets/js/cooltext.animate.js') }}"></script>
        <script src="{{ asset('frontend-assets/js/cooltext.min.js') }}"></script>
    <!--Sliding Latest Job-->
<script src="{{ asset('frontend-assets/js/ticker.js') }}"></script>
        <!--Sliding Latest Job-->
        <!-- <script src="{{ asset('frontend-assets/js/ticker.js') }}"></script> -->
        <script src="{{ asset('frontend-assets/js/toastr.min.js') }}"></script>
        <!--FeedBack Form-->
        <script src="{{ asset('frontend-assets/js/feedBackBox.js') }}"></script>
        <!-- pace -->
        <script type="text/javascript" src="{{ asset('frontend-assets/pace/pace.js') }}"></script>
        <script src="{{ asset('frontend-assets/tinymce/tinymce.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
		
<!--Top Navigation active li-->
<script type="text/javascript">
    $(document).ready(function () {
        var url = window.location;
        $('ul.nav a[href="'+ url +'"]').parent().addClass('active');
        $('ul.nav a').filter(function() {
            return this.href == url;
        }).parent().addClass('active');
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $(".location").select2();
    });
</script>
<!--FeedBack Form-->
<script src="js/feedBackBox.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#feedback-Form').feedBackBox();
    });
</script>
<!--Scroll to top Button-->
<script>
    jQuery(document).ready(function() {
        var offset = 250;
        var duration = 300;
        jQuery(window).scroll(function() {
            if (jQuery(this).scrollTop() > offset) {
                jQuery('.back-to-top').fadeIn(duration);
            } else {
                jQuery('.back-to-top').fadeOut(duration);
            }
        });
        jQuery('.back-to-top').click(function(event) {
            event.preventDefault();
            jQuery('html, body').animate({scrollTop: 0}, duration);
            return false;
        })
    });
</script>

    <script type="text/javascript">

        $(document).ready(function()
        {

            $("#hp_text").cooltext({
                cycle:true,
                sequence:[

                    {action:"update", text:"Finding your next job or career more 1000+ availabilities"},
                    {action:"animation", animation:"cool84", stagger:200},
                    {action:"animation", animation:"cool138", stagger:200},
                    {action:"animation", delay:2, animation:"cool264", stagger:200},

                    {action:"update", text:"Finding your next job or career more 1000+ availabilities"},
                    {action:"animation", animation:"cool92", stagger:200},
                    {action:"animation", animation:"cool150", stagger:200},
                    {action:"animation", delay:2, animation:"cool237", stagger:200},

                    {action:"update", text:"Finding your next job or career more 1000+ availabilities"},
                    {action:"animation", animation:"cool16", stagger:200},
                    {action:"animation", animation:"cool103", stagger:200},
                    {action:"animation", delay:2, animation:"cool266", stagger:200},

                    {action:"update", text:"Finding your next job or career more 1000+ availabilities"},
                    {action:"animation", animation:"cool71", elements:"words", stagger:200},
                    {action:"animation", delay:1, animation:"cool263", elements:"words", stagger:200},

                    {action:"update", text:"Finding your next job or career more 1000+ availabilities"},
                    {action:"animation", animation:"cool77", stagger:200, css:{color:"#ffffff", textShadow:"3px 3px 4px #999"}},
                    {action:"animation", animation:"cool112", css:{color:"white", textShadow:""},  stagger:200},
                    {action:"animation", delay:2, animation:"cool213", stagger:200},

                    {action:"update", text:"Finding your next job or career more 1000+ availabilities"},
                    {action:"animation", animation:"cool32", stagger:200},
                    {action:"animation", animation:"cool193", stagger:200},
                    {action:"animation", delay:2, animation:"cool205", stagger:200},

                    {action:"update", text:"Finding your next job or career more 1000+ availabilities"},
                    {action:"animation", animation:"cool95", stagger:200},
                    {action:"animation", animation:"cool181", stagger:200},
                    {action:"animation", delay:3, animation:"cool229", stagger:200}
                ]
            });

        });



        $(document).ready(function()
        {

            $("#hp_text2").cooltext({
                cycle:true,
                sequence:[
                    {action:"update", text:"Finding your next job or career more 1000+ availabilities"},
                    {action:"animation", animation:"cool43", stagger:200},
                    {action:"animation", animation:"cool120", stagger:200},
                    {action:"animation", animation:"cool215", stagger:200},

                    {action:"update", text:"Finding your next job or career more 1000+ availabilities"},
                    {action:"animation", animation:"cool84", stagger:200},
                    {action:"animation", animation:"cool138", stagger:200},
                    {action:"animation", animation:"cool264", stagger:200},

                    {action:"update", text:"Finding your next job or career more 1000+ availabilities"},
                    {action:"animation", animation:"cool92", stagger:200},
                    {action:"animation", animation:"cool150", stagger:200},
                    {action:"animation", animation:"cool237", stagger:200},

                    {action:"update", text:"Finding your next job or career more 1000+ availabilities"},
                    {action:"animation", animation:"cool16", stagger:200},
                    {action:"animation", animation:"cool103", stagger:200},
                    {action:"animation", animation:"cool266", stagger:200},

                    {action:"update", text:"Finding your next job or career more 1000+ availabilities"},
                    {action:"animation", animation:"cool71", elements:"words", stagger:200},
                    {action:"animation", delay:1, animation:"cool263", elements:"words", stagger:200},

                    {action:"update", text:"Finding your next job or career more 1000+ availabilities"},
                    {action:"animation", animation:"cool77", stagger:200, css:{color:"#F3BB11", textShadow:"3px 3px 4px #999"}},
                    {action:"animation", animation:"cool112", css:{color:"white", textShadow:""},  stagger:200},
                    {action:"animation", animation:"cool213", stagger:200},

                    {action:"update", text:"Finding your next job or career more 1000+ availabilities"},
                    {action:"animation", animation:"cool32", stagger:200},
                    {action:"animation", animation:"cool193", stagger:200},
                    {action:"animation", animation:"cool205", stagger:200},

                    {action:"update", text:"Finding your next job or career more 1000+ availabilities"},
                    {action:"animation", animation:"cool95", stagger:200},
                    {action:"animation", animation:"cool181", stagger:200},
                    {action:"animation", delay:3, animation:"cool229", stagger:200}
                ]
            });

        });


    </script>

        <!--Scroll to top Button-->
        <script>
        $(document).ready(function () {
            var url = window.location;
            $('ul.nav a[href="'+ url +'"]').parent().addClass('active');
            $('ul.nav a').filter(function() {
                return this.href == url;
            }).parent().addClass('active');
        });
        $(document).ready(function() {
            $(".location,.select2").select2();
            $('#feedback-Form').feedBackBox();
            var offset = 250;
            var duration = 300;
            $(window).scroll(function() {
                if ($(this).scrollTop() > offset) {
                    $('.back-to-top').fadeIn(duration);
                } else {
                    $('.back-to-top').fadeOut(duration);
                }
            });
            $('.back-to-top').click(function(event) {
                event.preventDefault();
                $('html, body').animate({scrollTop: 0}, duration);
                return false;
            })
            $('.date-picker').datetimepicker({
                weekStart: 1,
                todayBtn:  1,
                autoclose: 1,
                todayHighlight: 1,
                startView: 2,
                minView: 2,
                forceParse: 0,
                format: 'yyyy-mm-dd'
            });
        });
        $(document).ajaxStart(function() { Pace.restart(); });
        </script>
        @yield('page-footer')
    </body>
</html>
@if(Session()->has('fNotice'))
<div class="popup" data-popup="popup-1010">
    <div class="popup-inner">
        <p>{!! Session()->get('fNotice') !!}</p>
        <a class="popup-close" data-popup-close="popup-1010" href="#">&times;</a>
    </div>
</div>
<button class="btn btn-block" data-popup-open="popup-1010" style="display: none;" id="popup-1010">ONotice</button>
<script type="text/javascript">
    $('[data-popup="popup-1010"]').fadeIn(300);
    $('[data-popup-close]').on('click', function(e)  {
        var targeted_popup_class = jQuery(this).attr('data-popup-close');
        $('[data-popup="' + targeted_popup_class + '"]').fadeOut(350);
        e.preventDefault();
    });
</script>
{{ Session()->forget('fNotice') }}
@endif