@extends('layouts.head-app')

@section('content')
<!--Dashboard breadcrumb starts-->
<div class="dash-breadcrumb">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="dash-breadcrumb-content">
                    <div class="dash-breadcrumb-left">
                        <div class="breadcrumb-menu text-right sm-left">
                            <ul>
                                <li class="active"><a href="#">Home</a></li>
                                <li>Dashboard</li>
                            </ul>
                        </div>
                    </div>
                    <a class="btn v3" href="add-listing.html"><i class="ion-plus-round"></i>Add Listing </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Dashboard breadcrumb ends-->

<!-- Dashboard Statistics starts-->
<div class="statistic-wrap">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-3 col-md-6 col-12">
                <div class="statistic__item item--green">
                    <h2 class="counter-value"></h2>
                    <span class="desc">Published Listings</span>
                    <div class="icon">
                        <img src="images/dashboard/map-of-roads.png" alt="...">
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 col-12">
                <div class="statistic__item item--orange">
                    <h2 class="counter-value"></h2>
                    <span class="desc">Total Reviews</span>
                    <div class="icon">
                        <img src="images/dashboard/review.png" alt="...">
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 col-12">
                <div class="statistic__item item--blue">
                    <h2 class="counter-value"></h2>
                    <span class="desc">Total Visitor</span>
                    <div class="icon">
                        <img src="images/dashboard/bar-chart.png" alt="...">
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 col-12">
                <div class="statistic__item item--red">
                    <h2 class="counter-value"></h2>
                    <span class="desc">Total Booking</span>
                    <div class="icon">
                        <img src="images/dashboard/like.png" alt="...">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Dashboard Statistics ends-->

<!--Dashboard content starts-->

<!--Dashboard content ends-->
@endsection