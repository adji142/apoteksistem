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
                                <li class="active"><a href="#">Laporan Pembelian</a></li>
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
                        <h5><i class="ion-ios-people"></i> Pembelian</h5>
                    </div>
                    <div class="invoice-body">
                        <div class="row filterbox">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-lg-3 col-md-12">
                                        <input type="date" class="form-control filter-input" name="TglAwal" id="TglAwal">
                                    </div>
                                    <div class="col-lg-3 col-md-12">
                                        <input type="date" class="form-control filter-input" name="TglAkhir" id="TglAkhir">
                                    </div>
                                    <div class="col-lg-3 col-md-12">
                                        <select class="form-control filter-input" name="StatusHutang" id="StatusHutang">
                                            <option value="">Status Hutang</option>
                                            <option value="LUNAS">LUNAS</option>
                                            <option value="BELUM LUNAS">BELUM LUNAS</option>
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
                                          <div id="gridData">
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
            var now = new Date();
            var day = ("0" + now.getDate()).slice(-2);
            var month = ("0" + (now.getMonth() + 1)).slice(-2);
            var today = now.getFullYear()+"-"+month+"-01";
            var lastDayofYear = now.getFullYear()+"-"+month+"-"+day;

            $('#TglAwal').val(today);
            $('#TglAkhir').val(lastDayofYear);
			$('#searchData').click();
		});

		$('#searchData').click(function () {
			var KodeItem = '';
            $.ajax({
                async   : false,
                type    : "post",
                url     : "{{route('getreport')}}",
                data    : {
                            'TglAwal'   : $('#TglAwal').val(),
                            'TglAkhir'  : $('#TglAkhir').val(),
                            'Supplier'  : '',
                            'KodeItem'  : '',
                            'StatusHutang' : $('#StatusHutang').val(),
                            '_token': '{{ csrf_token() }}',
                        },
                dataType: "json",
                success: function (response) {
                  // bindGrid(response.data);
                  // console.log(response);
                  bindgrid(response.data);
                }
            });
		});

        function bindgrid(data) {
            var dataGridInstance = $("#gridData").dxDataGrid({
                allowColumnResizing: true,
                dataSource: data,
                keyExpr: "NoTransaksi",
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
                        dataField: "NoTransaksi",
                        caption: "No Transaksi",
                        allowEditing:false,
                        groupIndex:0
                    },
                    {
                        dataField: "NoRef",
                        caption: "Reff",
                        allowEditing:false,
                    },
                    {
                        dataField: "TglTransaksi",
                        caption: "Tanggal",
                        allowEditing:false,
                    },
                    {
                        dataField: "NamaSupplier",
                        caption: "Customer",
                        allowEditing:false,
                    },
                    {
                        dataField: "DocTotal",
                        caption: "Total",
                        allowEditing:false,
                        dataType: 'number',
                        format: { type: 'fixedPoint', precision: 2 }
                    },
                    {
                        dataField: "KodeItem",
                        caption: "Kode Item",
                        allowEditing:false,
                    },
                    {
                        dataField: "NamaItem",
                        caption: "Nama Item",
                        allowEditing:false,
                    },
                    {
                        dataField: "Qty",
                        caption: "Qty",
                        allowEditing:false,
                        dataType: 'number',
                        format: { type: 'fixedPoint', precision: 2 }
                    },
                    {
                        dataField: "Harga",
                        caption: "Harga",
                        allowEditing:false,
                        dataType: 'number',
                        format: { type: 'fixedPoint', precision: 2 }
                    },
                    {
                        dataField: "Potongan",
                        caption: "Potongan",
                        allowEditing:false,
                        dataType: 'number',
                        format: { type: 'fixedPoint', precision: 2 }
                    },
                    {
                        dataField: "LineTotal",
                        caption: "Total",
                        allowEditing:false,
                        dataType: 'number',
                        format: { type: 'fixedPoint', precision: 2 }
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