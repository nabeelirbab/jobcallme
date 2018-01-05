<!--Footer-->
<footer id="footer">
    <div class="container">
        <div class="col-md-2">
            <h5><span class="footer-title-box" style="background-color: #9b9b36">Category by occupation</span></h5>
            <ul class="quick-links">
                @foreach(JobCallMe::getCategories() as $fCat)
                    <li><a href="{{ url('jobs?category='.$fCat->categoryId) }}"><span class="lh-eff34 c18-cyan-1"><span></span>{{ ucfirst($fCat->name) }}</span></a></li>
                @endforeach
            </ul>
        </div>

        <div class="col-md-2">
            <h5><span class="footer-title-box" style="background-color: #8d7d8d">
Hourly work place</span></h5>
            <ul class="quick-links">
                @foreach(JobCallMe::getJobShifts() as $fShift)
                    <li><a href="{{ url('jobs?shift='.$fShift->name) }}"><span class="lh-eff34 c18-cyan-3"><span></span>{{ ucfirst($fShift->name) }}</span></a></li>
                @endforeach
            </ul>
			<br>
				 <h5><span class="footer-title-box2"><a href="#" style="background-color: #428f7e">About Head Hunter</a></span></h5><br>
				 <h5><span class="footer-title-box2"><a href="#" style="background-color: #956f4f">
                               Dispatch and agency information</a></span></h5>
         </div>

         <div class="col-md-2">
            <h5><span class="footer-title-box" style="background-color: #94a5a5">
                               Jobs by Career</span></h5>
            <ul class="quick-links">
                @foreach(JobCallMe::getCareerLevel() as $career)
                    <li><a href="{{ url('jobs?career='.$career) }}"><span class="lh-eff34 c18-cyan-2"><span></span>{{ $career }}</span></a></li>
                @endforeach
            </ul>
        </div>

        <div class="col-md-2">
            <h5><span class="footer-title-box" style="background-color: #4e6c7c">Job information by Type</span></h5>
            <ul class="quick-links">
                @foreach(JobCallMe::getJobType() as $fType)
                    <li><a href="{{ url('jobs?type='.$fType->name) }}"><span class="lh-eff34 c18-cyan-4"><span></span>{{ ucfirst($fType->name) }}</span></a></li>
                @endforeach
            </ul>
        </div>

        <div class="col-md-2">
            <h5><span class="footer-title-box" style="background-color: #b0a48a">Jobs In {{ JobCallMe::countryName(JobCallMe::getHomeCountry()) }}</span></h5>
            <ul class="quick-links">
                @foreach(JobCallMe::getHomeCities() as $loca)
                    <li><a href="{{ url('jobs?country='.JobCallMe::getHomeCountry().'&state='.$loca->state_id.'&city='.$loca->id )}}"><span class="lh-eff34 c18-cyan-5"><span></span>Jobs in {{ $loca->name }}</span></a></li>
                @endforeach
            </ul>
        </div>

        <div class="col-md-2">
            <h5><span class="footer-title-box" style="background-color: #717171">About us</span></h5>
            <ul class="quick-links">
                <li><a href="{{ url('about') }}"><span class="lh-eff34 c18-cyan-6"><span></span>About</span></a></li>
                <li><a href="{{ url('contact') }}"><span class="lh-eff34 c18-cyan-6"><span></span>Contact</span></a></li>
                <li><a href="{{ url('privacy-policy') }}"><span class="lh-eff34 c18-cyan-6"><span></span>Privacy Policy</span></a></li>
                <li><a href="{{ url('terms-conditions') }}"><span class="lh-eff34 c18-cyan-6"><span></span>Terms & Conditions</span></a></li>
                <li><a href="{{ url('account/register') }}"><span class="lh-eff34 c18-cyan-6"><span></span>Signup Now</span></a></li>
            </ul>
            <ul class="social-links">
                <li><a href="https://facebook.com"><i class="fa fa-facebook-square"></i> </a> </li>
                <li><a href="https://twitter.com"><i class="fa fa-twitter-square"></i> </a> </li>
                <li><a href="https://linkedin.com"><i class="fa fa-linkedin-square"></i> </a> </li>
            </ul>
        </div>
    </div>
</footer>