@extends('frontend.layouts.app')

@section('title', 'Companies')

@section('content')
<section id="companies-section">
    <div class="container">
        <div class="col-md-12 learn-search-box">
            <h2 class="text-center">Companies in {{ JobCallMe::countryName(JobCallMe::getHomeCountry()) }}</h2>
            <div class="row">
                <div class="col-md-offset-2 col-md-8">
                    <div class="ls-box">
                        <form role="form" action="{{ url('companies') }}" method="post">
                            {{ csrf_field() }}
                            <div class="input-fields">
                                <div class="search-field-box search-item">
                                    <input type="search" placeholder="Keywords" name="keyword">
                                </div>
                                <div class="search-field-box search-item">
                                    <input type="search" placeholder="City" name="city">
                                </div>
                                <button type="submit" class="search-btn">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--<div class="row">
                <div class="col-md-2">

                </div>
            </div>-->
            <div class="row text-sm  companies-list">
                <div class="col-md-12">
                    <h4 class="category-label">Companies by Industry</h4>
                    <div class="col-md-4">
                    <ul class="list-unstyled">
                    <?php 
                    $i = 1; 
                    foreach(JobCallMe::getCategories() as $cat){
                        if($i == 10){
                            $i = 1; 
                            echo '</ul></div>';
                            echo '<div class="col-md-4">';
                            echo '<ul class="list-unstyled">';
                        }
                        echo '<li class="ellipsis"><a href="'.url('companies?in='.$cat->categoryId).'" class="hvr-forward">'.$cat->name.'</a></li>';
                        $i++;
                    ?>
                    <?php }?>
                    </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="companies-item-box">

            <div class="row">
                @foreach($companies as $company)
                    <?php
                    //print_r($company);exit;
                    $cLogo = url('compnay-logo/default-logo.jpg');
                    if($company->companyLogo != ''){
                      $cLogo = url('compnay-logo/'.$company->companyLogo);
                    }
                    ?>
                    <div class="col-md-2 hvr-bob">
                        <!-- normal -->
                        <div class="ih-item square effect8 scale_up">
                            <a href="{{ url('companies/company/'.$company->companyId) }}">
                            <div class="img"><img src="{{ $cLogo }}" alt="img"></div>
                            <div class="info">
                                <h3>{!! $company->companyName !!}</h3>
                                <p>{!! substr(strip_tags($company->companyAbout),0,100) !!}</p>
                            </div></a>
                        </div>
                        <!-- end normal -->
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<link href="{{ asset('frontend-assets/css/ihover.css') }}" rel="stylesheet">
<style type="text/css">
.ih-item.square.effect8 .info h3 {font-size: 13px;}
</style>
@endsection
@section('page-footer')