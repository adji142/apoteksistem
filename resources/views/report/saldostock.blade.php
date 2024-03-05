@extends('layouts.head-app')

@section('content')

<style type="text/css">

	@media print {
	    .row.exportbox {
	        display: none;
	    }
	    .row.filterbox {
	        display: none;
	    }
	}
</style>
<!--Dashboard breadcrumb starts-->
<div class="dash-breadcrumb">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="dash-breadcrumb-content">
                    <div class="dash-breadcrumb-left">
                        <div class="breadcrumb-menu text-right sm-left">
                            <ul>
                                <li class="active"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="active"><a href="#">Laporan Saldo Stock</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Dashboard breadcrumb ends-->
<div class="dash-content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
                <div class="invoice-panel">
                    <div class="act-title">
                        <h5><i class="ion-ios-people"></i> Saldo Stock</h5>
                    </div>
                    <div class="invoice-body">
                        <div class="row filterbox">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-lg-5 col-md-12">
                                        <select class="form-control filter-input" name="Stock" id="Stock">
                                            <option value="-1">Tampilkan Stok 0</option>
                                            <option value="1">YA</option>
                                            <option value="0">TIDAK</option>
                                        </select>
                                    </div>

                                    <div class="col-lg-2 col-md-12">
                                        <div class="submit_btn text-right md-left">
                                            <button class="btn v3  mar-right-5 form-control filter-input" id="searchData"><i class="ion-ios-search" aria-hidden="true"></i> Cari</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="table-responsive">
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="dx-viewport demo-container">
                                        <div id="data-grid-demo">
                                          <div id="itemGrid">
                                          </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12">
                                    <div class="dx-viewport demo-container">
                                        <div id="data-grid-demo">
                                          <div id="batchGrid">
                                          </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		</div>
	</div>
</div>
@endsection

@push('scripts')

<script type="text/javascript">
	$(function () {
		$(document).ready(function () {
			$('#searchData').click();
		});

		$('#searchData').click(function () {
			var KodeItem = '';
            var Stock = $('#Stock').val();
            $.ajax({
                type    : "post",
                url     : "{{route('listobat')}}",
                data    : {
                            'Stock' : Stock,
                            '_token': '{{ csrf_token() }}',
                        },
                dataType: "json",
                success: function (response) {
                  // bindGrid(response.data);
                  // console.log(response);
                  bindgridItem(response.data);
                }
            });
		});

        function generateBatch(KodeItem) {
            // var Supplier = $('#Supplier').val();
            var Stock = $('#Stock').val();

            $.ajax({
                type    : "post",
                url     : "{{route('databatch')}}",
                data    : {
                            'KodeItem':KodeItem,
                            // 'Supplier' : Supplier,
                            'Stock' : Stock,
                            '_token': '{{ csrf_token() }}',
                        },
                dataType: "json",
                success: function (response) {
                  // bindGrid(response.data);
                  // console.log(response);
                  bindgridBatch(response.data);
                }
            });
        }

        function bindgridItem(data) {
            var dataGridInstance = $("#itemGrid").dxDataGrid({
                allowColumnResizing: true,
                dataSource: data,
                keyExpr: "KodeItem",
                showBorders: true,
                allowColumnReordering: true,
                allowColumnResizing: true,
                columnAutoWidth: true,
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
                selection:{
                    mode: "single"
                },
                columns: [
                    {
                        dataField: "KodeItem",
                        caption: "Batch",
                        allowEditing:false,
                    },
                    {
                        dataField: "NamaItem",
                        caption: "Nama Item",
                        allowEditing:false,
                    },
                    {
                        dataField: "Kelompok",
                        caption: "Kelompok",
                        allowEditing:false,
                    },
                    {
                        dataField: "Stock",
                        caption: "Stock",
                        allowEditing:false,
                    },
                    {
                        dataField: "Satuan",
                        caption: "#",
                        allowEditing:false,
                    },
                    {
                        dataField: "LokasiRak",
                        caption: "Rak",
                        allowEditing:false,
                    },
                ]
            }).dxDataGrid('instance');

            dataGridInstance.on('selectionChanged', function(e) {
                // Get the selected rows
                var selectedRows = e.selectedRowsData;
                
                // Perform actions based on the selected rows
                // console.log('Selected rows:', selectedRows);
                generateBatch(selectedRows[0].KodeItem)
            });
        }

        function bindgridBatch(data) {
            $("#batchGrid").dxDataGrid({
                allowColumnResizing: true,
                dataSource: data,
                keyExpr: "BatchNumber",
                showBorders: true,
                allowColumnReordering: true,
                allowColumnResizing: true,
                columnAutoWidth: true,
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
                selection:{
                    mode: "single"
                },
                columns: [
                    {
                        dataField: "BatchNumber",
                        caption: "Batch",
                        allowEditing:false,
                    },
                    // {
                    //     dataField: "Supplier",
                    //     caption: "Supplier / PBF",
                    //     allowEditing:false,
                    // },
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

		$('#btExportXLS').click(function() {
	        $('#dtrecord').tableExport({
		        formats: ['xlsx'],
		        filename: 'Kartu Stock',
		        bootstrap: false,
		    });
	    });
	})
</script>

@endpush