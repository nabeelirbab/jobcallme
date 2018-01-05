<section id="jobseeker-box">
    <div class="container">
        <h1>Welcome {{ Session::get('jcmUser')->firstName.' '.Session::get('jcmUser')->lastName }}!</h1>
        <div class="col-md-12 user-dashboard-panel">
            <ul class="udp-itemss">
                <li>
                    <a href="{{ url('account/jobseeker/resume') }}">
                        <i class="fa fa-id-badge"></i>
                        <div class="udp-type">RESUME</div>
                    </a>
                </li>
                <li>
                    <a href="{{ url('jobs') }}">
                        <i class="fa fa-search"></i>
                        <div class="udp-type">JOBS</div>
                    </a>
                </li>
                <li>
                    <a href="{{ url('account/jobseeker/application') }}">
                        <i class="fa fa-file-text-o"></i>
                        <div class="udp-type">APPLICATION</div>
                    </a>
                </li>
                <li>
                    <a href="{{ url('account/jobseeker/application?show=interview') }}">
                        <i class="fa fa-calendar"></i>
                        <div class="udp-type">INTERVIEW</div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-envelope"></i>
                        <div class="udp-type">MESSAGE</div>
                    </a>
                </li>
                <li>
                    <a href="{{ url('learn') }}">
                        <i class="fa fa-line-chart"></i>
                        <div class="udp-type">LEARN</div>
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