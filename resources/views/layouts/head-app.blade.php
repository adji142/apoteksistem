<!DOCTYPE html>
<html dir="ltr" lang="en-US">

	@include('layouts.head')

	<body>
		<!--Page Wrapper starts-->
	    <div class="page-wrapper">
	    	<!--Sidebar Menu Starts-->
	        <aside class="menu-sidebar js-right-sidebar d-block d-lg-none">
	            <div class="logo">
	                <a href="#">
	                    <img src="{{ asset('images/logo-black.png') }}" alt="Listagram" />
	                </a>
	            </div>
	            <div class="menu-sidebar__content js-scrollbar2">
	                <div class="account-img">
	                    <img src="{{ asset('images/clients/reviewer-4.png') }}" alt="Steve Austin" />
	                </div>
	                <h4 class="name">User</h4>
	                <nav class="navbar-sidebar2">
	                	<ul class="list-unstyled navbar__list">
							<li>
						        <a class="active" href="#">
						            <i class="ion-ios-gear-outline"></i>Dashboard
						        </a>
						    </li>

			                @foreach ($navbars as $items)
								@if (count($items['Detail']) > 0)
									<li class="has-sub">
										<a class="js-arrow" href="#">
						                    <i class="{{$items['Icon']}}"></i>{{$items['PermissionName']}}
						                </a>

						                <ul class="list-unstyled navbar__sub-list js-sub-list">
						                	@foreach ($items['Detail'] as $itemdetails)
						                		<li>
				                                    <a href="{{ route($itemdetails['Link']) }}">
				                                    	{{$itemdetails['PermissionName']}}
				                                    </a>
				                                </li>
						                	@endforeach
						                </ul>
									</li>
								@else
									<li>
							            <a href="#">
							                <i class="{{$items['Icon']}}"></i> {{$items['PermissionName']}}
							            </a>
							        </li>
								@endif

							@endforeach
						</ul>
	                </nav>
	            </div>
	        </aside>
	        <!--Sidebar Menu ends-->
	        <!-- Top header starts-->
	        <header class="db-top-header">
	            <div class="container-fluid">
	                <div class="row align-items-center">
	                    <div class="col-md-9 col-sm-6 col-4">
	                        <div class="site-navbar-wrap v2">
	                            <div class="site-navbar">
	                                <div class="row align-items-center">
	                                    <div class="d-lg-none sm-right">
	                                        <a href="#" class="mobile-bar js-menu-toggle">
	                                            <span class="ion-android-menu"></span>
	                                        </a>
	                                    </div>
	                                </div>
	                            </div>
	                            <div class="site-mobile-menu">
	                                <div class="site-mobile-menu-header">
	                                    <div class="site-mobile-menu-close  js-menu-toggle">
	                                        <span class="ion-ios-close-empty"></span>
	                                    </div>
	                                </div>
	                                <div class="site-mobile-menu-body"></div>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="col-md-3 col-sm-6 col-8">
	                        <div class="header-button">
	                            <div class="header-button-item has-noti js-item-menu">
	                                <i class="ion-ios-bell-outline"></i>
	                                <div class="notifi-dropdown js-dropdown">
	                                    <div class="notifi__title">
	                                        <p>You have 2 Notifications</p>
	                                    </div>
	                                    <div class="notifi__item">
	                                        <div class="bg-c1 red">
	                                            <i class="icofont-check"></i>
	                                        </div>
	                                        <div class="content">
	                                            <p>Your listing <b>Hotel Ocean Paradise</b> has been approved!</p>
	                                            <span class="date">5min ago</span>
	                                        </div>
	                                    </div>
	                                    <div class="notifi__item">
	                                        <div class="bg-c1 green">
	                                            <i class="icofont-ui-message"></i>
	                                        </div>
	                                        <div class="content">
	                                            <p>You have 3 unread Messages</p>
	                                            <span class="date">5min ago</span>
	                                        </div>
	                                    </div>
	                                    <div class="notify-bottom text-center pad-tb-20">
	                                        <a href="#">View All Notification</a>
	                                    </div>
	                                </div>
	                            </div>
	                            <div class="header-button-item js-sidebar-btn">
	                                <img src="{{ asset('images/clients/reviewer-4.png') }}" alt="...">
	                                <span>{{ auth()->user()->name }} <i class="ion-arrow-down-b"></i></span>
	                            </div>
	                            <div class="setting-menu js-right-sidebar d-none d-lg-block">
	                                <div class="account-dropdown__body">
	                                    <div class="account-dropdown__item">
	                                        <a href="">
	                                            <i class="ion-ios-gear-outline"></i>Dashboard</a>
	                                    </div>
	                                    <div class="account-dropdown__item">
	                                        <a href="{{route('logout')}}">
	                                            <i class="ion-ios-upload-outline"></i>Logout</a>
	                                    </div>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </header>
	        <!-- Top header ends-->

	        <!--Dashboard content Wrapper starts-->
	        <div class="dash-content-wrap">
	        	@yield('content')
	        	<!--Dashboard footer starts-->
		        <div class="dash-footer">
		            <div class="container">
		                <div class="row">
		                    <div class="col-md-12">
		                        <div class="copyright">
		                            <p>&copy; 2023 {{ config('app.name', 'Laravel') }}. All Rights Reserved.</p>
		                        </div>
		                    </div>
		                </div>
		            </div>
		        </div>
		        <!--Dashboard footer ends-->
	        </div>
	    </div>

	    <!--Scripts starts-->
	    <!--plugin js-->
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	    <script src="{{ asset('js/plugin.js') }}"></script>
	    <!--Perfect Scrollbar JS-->
	    <script src="{{ asset('js/perfect-scrollbar.min.js') }}"></script>
	    <!--Main js-->
	    <script src="{{ asset('js/main.js') }}"></script>
	    <!-- Dashboard JS-->
	    <script src="{{ asset('js/dashboard.js') }}"></script>
	    <!--Scripts ends-->
	    @include('sweetalert::alert')
	</body>

</html>