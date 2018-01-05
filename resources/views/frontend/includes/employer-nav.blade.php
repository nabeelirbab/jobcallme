<section id="jobseeker-box">
    <div class="container">
        <h1>Welcome {{ Session::get('jcmUser')->firstName.' '.Session::get('jcmUser')->lastName }}!</h1>
        <div class="col-md-12 user-dashboard-panel">
            <ul class="udp-items">
                <li>
                    <a href="{{ url('account/employer/job/new') }}">
                        <i class="fa fa-tasks"></i>
                        <div class="udp-type">POST JOB</div>
                    </a>
                </li>

                <li>
                    <a href="{{ url('account/employer/application') }}">
                        <i class="fa fa-file-text-o"></i>
                        <div class="udp-type">APPLICATION</div>
                    </a>
                </li>
                <li>
                    <a href="{{ url('account/employer/application?show=interview') }}" id="jaTab-3">
                        <i class="fa fa-calendar"></i>
                        <div class="udp-type">INTERVIEW</div>
                    </a>
                </li>
                <li>
                    <a href="{{ url('messages') }}">
                        <i class="fa fa-envelope"></i>
                        <div class="udp-type">MESSAGE</div>
                    </a>
                </li>
                <li>
                    <a href="{{ url('account/people') }}">
                        <i class="fa fa-users"></i>
                        <div class="udp-type">Find Peoples</div>
                    </a>
                </li>
                <li>
                    <a href="{{ url('learn') }}">
                        <i class="fa fa-line-chart"></i>
                        <div class="udp-type">LEARN</div>
                    </a>
                </li>
				 <li>
                    <a href="{{ url('download') }}">
                        <i class="fa fa-download"></i>
                        <div class="udp-type">Download</div>
                    </a>
                </li>
				 <li>
                    <a href="{{ url('career-tab') }}">
                        <i class="fa fa-bars"></i>
                        <div class="udp-type">Careers Tab</div>
                    </a>
                </li>
                <li>
                    <a href="{{ url('read') }}">
                        <i class="fa fa-book"></i>
                        <div class="udp-type">READ</div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-shopping-cart"></i>
                        <div class="udp-type">UPGRADE</div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</section>