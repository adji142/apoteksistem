

<script type="text/javascript">
	$(function () {

		$(document).ready(function () {
			generateBatch();
			$("#batchGrid").dxDataGrid({
		        // Configuration options
		    });
		})

		function generateBatch() {
			var token = window.csrf_token;
			$.ajax({
		    	type 	: "post",
		     	url 	: "{{route('databatch')}}",
		        data 	: {
			        		'KodeItem':'10001',
			        		"_token": "{{ csrf_token() }}",
			        	},
		        dataType: "json",
		        success: function (response) {
		          // bindGrid(response.data);
		          console.log(response);
		          // bindgridBatch(response.data);
		        }
		    });
		}

		function bindgridBatch(data) {
			$("#batchGrid").dxDataGrid({
				allowColumnResizing: true,
				dataSource: data,
				keyExpr: "id",
				showBorders: true,
				paging: {
	                enabled: true
	            },
	            searchPanel: {
	                visible: true,
	                width: 240,
	                placeholder: "Search..."
	            },
	            export: {
	                enabled: true,
	                fileName: "Stock Batch"
	            },
	            columns: [
	            	{
	                    dataField: "BatchNumber",
	                    caption: "Batch",
	                    allowEditing:false,
	                },
	                {
	                    dataField: "Supplier",
	                    caption: "Supplier / PBF",
	                    allowEditing:false,
	                },
	                {
	                    dataField: "Stock",
	                    caption: "Stock",
	                    allowEditing:false,
	                },
	                {
	                    dataField: "ExpiredDate",
	                    caption: "Expired Date",
	                    allowEditing:false,
	                },
	            ]
			})
		}


	})
</script>