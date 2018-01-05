@extends('frontend.layouts.app')

@section('title', 'Read')

@section('content')
<section id="learn-section">
    <div class="container">
        <div class="col-md-12 learn-search-box">
            <h2 class="text-center">Read! To Enhance Your Knowlegde</h2>
            <div class="row">
                <div class="col-md-offset-2 col-md-8">
                    <div class="ls-box">
                        <form role="form" action="{{ url('read') }}" method="post">
                            {{ csrf_field() }}
                            <div class="input-fields">
                                <div class="search-field-box search-item">
                                    <input type="search" placeholder="Keywords" name="keyword">
                                </div>
                                <div class="search-field-box search-item">
                                    <select class="form-control select2" name="category">
                                        <option value="0">Select Type</option>
                                        @foreach(JobCallMe::getCategories() as $cat)
                                            <option value="{!! $cat->categoryId !!}">{!! $cat->name !!}</option>
                                        @endforeach
                                    </select>
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
                        foreach(JobCallMe::getCategories() as $cat){ ?>
                            <a href="{{ url('read?category='.$cat->categoryId) }}" style="background-color: {{ $cArr[$i] }}">{!! $cat->name !!}</a>
                        <?php if($i == 5){ break; } $i++; } ?>
                    </div>
                    <div class="promote-learning-box">
                        <a href="{{ url('account/writings/article/add') }}" class="promote-learning-btn"><i class="fa fa-edit"></i>&nbsp; WRITE AN ARTICLE</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Read Articles-->
<section id="learn-articles">
    <div class="container">
        <h1 style="margin-left: 15px">Latest Articles</h1>
        <div class="grid">
            <div class="grid-sizer col-xs-12 col-sm-6 col-md-3 col-lg-3"></div>
            <!--Article Item-->
            @foreach($read_record as $rec)
                <div class="col-xs-12 col-sm-6 col-md-3 grid-item">
                    <div class="la-item">
                        <img class=" img-responsive" src="{{ url('article-images/'.$rec->wIcon) }}" alt="">
                        <div class="col-md-12">
                            <p> <a href="{{ url('read/article/'.$rec->writingId ) }}" class="la-title">{!! $rec->title !!}</a></p>
                            <span>{{ $rec->name }}</span>
                            <div class="la-text">{!! $rec->citation !!}</div>
                            <div class="ra-author-box">
                                <img src="{{ url('profile-photos/'.$rec->profilePhoto) }}" class="img-circle" alt="{{ $rec->firstName }}">
                                <div class="ra-author">
                                    <a href="{{ url('people/profile/'.$rec->userId) }}">{{ $rec->firstName.' '.$rec->lastName }}</a><br>
                                    <span>{{ date('M d, Y',strtotime($rec->createdTime))}}</span>
                                </div>
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
//need this to deactivate lightbox on small screens
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