@extends('frontend.layouts.app')

@section('title', 'Learn')

@section('content')
<section id="learn-section">
    <div class="container">
        <div class="col-md-12 learn-search-box">
            <h2 class="text-center">Learn! To Enhance Your Competitive Advantage</h2>
            <div class="row">
                <div class="col-md-offset-2 col-md-8">
                    <div class="ls-box">
                        <form role="form" action="{{ url('learn/search')}}" method="post">
                            {{ csrf_field() }}
                            <div class="input-fields">
                                <div class="search-field-box search-item">
                                    <input type="search" placeholder="Keywords" name="learn-keyword">
                                </div>
                                <div class="search-field-box search-item">
                                    <input type="search" placeholder="City" name="learn-city">
                                </div>
                                <button type="submit" class="search-btn">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="job-locations-box">
                        <?php 
                        $cArr = array('purple','green','darkred','orangered','blueviolet','#122b40');
                        $i = 0;
                        foreach(JobCallMe::getUpkillsType() as $skill){ ?>
                            <a href="{{ url('learn/search?type='.strtolower($skill)) }}" style="background-color: {{ $cArr[$i] }}">{!! $skill !!}</a>
                        <?php $i++; } ?>
                    </div>
                    <div class="promote-learning-box">
                        <a href="{{ url('account/upskill/add') }}" class="promote-learning-btn"><i class="fa fa-bullhorn"></i>&nbsp; Promote Your Learning Solutions</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Learn Articles-->
<section id="learn-articles">
    <div class="container">
        <h1 style="margin-left: 15px">Latest Courses</h1>
        <div class="grid">
            <div class="grid-sizer col-xs-12 col-sm-6 col-md-3 col-lg-3"></div>
            <!--Article Item-->
            @foreach($lear_record as $rec)
                <div class="col-xs-12 col-sm-6 col-md-3 grid-item">
                   <div class="la-item">
                        @if($rec->upskillImage != '')
                        <img class=" img-responsive" src="{{ url('upskill-images/'.$rec->upskillImage) }}" alt="">
                        @else
                        <img src="{{ url('d-cover.jpg') }}">
                        @endif
                        <div class="col-md-12">
                            <p> <a href="{{ url('learn/'.strtolower($rec->type).'/'.$rec->skillId) }}" class="la-title">{!! $rec->title !!}</a></p>
                            <p>{{ $rec->organiser != '' ?  $rec->organiser : JobCallMe::userName($rec->userId) }}</p>
                            <span>{{ $rec->type }}</span>
                            <p><i class="fa fa-calendar"></i> {{ date('M d, Y',strtotime($rec->startDate))}} <i class="fa fa-clock-o"></i> {{ JobCallMe::timeDuration($rec->startDate,$rec->endDate,'min')}}</p>
                            <div class="la-text">{{ substr(strip_tags($rec->description),0,200) }}</div>
                            <span><i class="fa fa-map-marker"></i> {{ JobCallMe::cityName($rec->city) }},{{ JobCallMe::countryName($rec->country) }}</span>
                            <div>
                                <p class="pull-right la-price">{{ $rec->currency.' '.number_format($rec->cost)}}/-</p>
                            </div>
                       </div>
                   </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
@section('page-footer')
<script src="https://npmcdn.com/isotope-layout@3.0/dist/isotope.pkgd.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {

    lightboxOnResize();

});

$(window).resize(function() {
    lightboxOnResize();

});

//***ISOTOPE***
// init Isotope
var $grid = $('.grid').isotope({
    itemSelector: '.grid-item',
    layoutMode: 'masonry'
});

// filter items on button click
$('.filter-button-group').on( 'click', 'button', function() {
    var filterValue = $(this).attr('data-filter');
    $grid.isotope({ filter: filterValue });
});

// change is-checked class on buttons
$('.btn-group').each( function( i, buttonGroup ) {
    var $buttonGroup = $( buttonGroup );
    $buttonGroup.on( 'click', 'button', function() {
        $buttonGroup.find('.is-checked').removeClass('is-checked');
        $( this ).addClass('is-checked');
    });
});


function lightboxOnResize() {

    if ($(window).width() < 768) {

        $('a[rel="prettyPhoto[portfolio]"]')
            .removeAttr('rel')
            .addClass('lightboxRemoved');

        $('a.lightboxRemoved').click(function( event ) {
            event.preventDefault();
            console.log("test");
        });

    } else {

        $('a.lightboxRemoved').attr('rel', 'prettyPhoto[portfolio]').removeClass("lightboxRemoved");
        $("a[rel='prettyPhoto[portfolio]']").prettyPhoto({
            theme: "light_square",
        });

    }
}
</script>
@endsection