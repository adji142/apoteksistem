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
	    <!-- DevExtreme theme -->
	    
	    
	    @include('sweetalert::alert')
	</body>

</html>