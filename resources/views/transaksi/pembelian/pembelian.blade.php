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
                                <li class="active"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="active"><a href="{{ route('pembelian') }}">Pembelian</a></li>
                            </ul>
                        </div>
                    </div>
                    <a class="btn v3" href="{{ url('pembelian/form/0') }}"><i class="ion-plus-round"></i>Tambah Pembelian </a>
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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-lg-3 col-md-12">
                                        <input type="date" class="form-control filter-input" name="TglAwal" id="TglAwal">
                                    </div>
                                    <div class="col-lg-3 col-md-12">
                                        <input type="date" class="form-control filter-input" name="TglAkhir" id="TglAkhir">
                                    </div>
                                    <div class="col-lg-4 col-md-12">
                                        <select class="form-control filter-input" name="Supplier" id="Supplier">
                                            <option value="">Semua Supplier / PBF</option>
                                            @foreach($supplier as $sp)
                                                <option value="{{ $sp['id'] }}">{{ $sp['NamaSupplier'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-2 col-md-12">
                                        <div class="submit_btn text-right md-left">
                                            <button class="btn v3  mar-right-5 form-control filter-input" id="SearchPembelian"><i class="ion-ios-search" aria-hidden="true"></i> Cari</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <div class="dx-viewport demo-container">
                                        <div id="data-grid-demo">
                                          <div id="headerGrid">
                                          </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="table-responsive">
                                    <div class="dx-viewport demo-container">
                                        <div id="data-grid-demo">
                                          <div id="detailGrid">
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

            getHeader();
            getDetail('');
        });

        $('#SearchPembelian').click(function () {
            getHeader();
            getDetail('');
        })

        function getHeader() {
            $.ajax({
                async   : false,
                type    : "post",
                url     : "{{route('getheader')}}",
                data    : {
                            'TglAwal'   : $('#TglAwal').val(),
                            'TglAkhir'  : $('#TglAkhir').val(),
                            'Supplier'  : $('#Supplier').val(),
                            '_token': '{{ csrf_token() }}',
                        },
                dataType: "json",
                success: function (response) {
                  // bindGrid(response.data);
                  // console.log(response);
                  bindGridHeader(response.data);
                }
            });
        }

        function getDetail(NoTransaksi) {
            $.ajax({
                async   : false,
                type    : "post",
                url     : "{{route('getdetail')}}",
                data    : {
                            'NoTransaksi'   : NoTransaksi,
                            '_token': '{{ csrf_token() }}',
                        },
                dataType: "json",
                success: function (response) {
                  // bindGrid(response.data);
                  // console.log(response);
                  bindGridDetail(response.data);
                }
            });
        }

        function bindGridHeader(data) {
            var dataGridInstance = $("#headerGrid").dxDataGrid({
                allowColumnResizing: true,
                dataSource: data,
                keyExpr: "NoTransaksi",
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
                        caption: "#",
                        allowEditing:false,
                    },
                    {
                        dataField: "TglTransaksi",
                        caption: "Tanggal",
                        allowEditing:false,
                    },
                    {
                        dataField: "NamaSupplier",
                        caption: "Supplier",
                        allowEditing:false,
                    },
                    {
                        dataField: "NoRef",
                        caption: "No. Reff",
                        allowEditing:false,
                    },
                    {
                        dataField: "StatusTRX",
                        caption: "Status Transaksi",
                        allowEditing:false,
                    },
                    {
                    dataField: "FileItem",
                        caption: "Action",
                        allowEditing:false,
                        cellTemplate: function(cellElement, cellInfo) {
                            var id = cellInfo.data.NoTransaksi;
                            var route = "customer/delete/" +cellInfo.data.NoTransaksi
                            LinkAccess = '<a href="'+route+'" class="btn btn-danger" data-toggle="tooltip" title="Delete" data-confirm-delete="true"> <i class="ion-android-delete"></i> Delete</a>';
                          // console.log();
                            cellElement.append(LinkAccess);
                      }
                    }
                ]
            }).dxDataGrid('instance');

            dataGridInstance.on('selectionChanged', function(e) {
                // Get the selected rows
                var selectedRows = e.selectedRowsData;
                
                // Perform actions based on the selected rows
                // console.log('Selected rows:', selectedRows);
                getDetail(selectedRows[0].NoTransaksi)
            });
        }

        function bindGridDetail(data) {
            $("#detailGrid").dxDataGrid({
                allowColumnResizing: true,
                dataSource: data,
                keyExpr: "LineNumber",
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
                        dataField: "LineNumber",
                        caption: "#",
                        allowEditing:false,
                        visible:false
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
                        dataField: "BatchNumber",
                        caption: "Batch",
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
                        dataField: "satuan",
                        caption: "#",
                        allowEditing:false,
                    },
                    {
                        dataField: "Harga",
                        caption: "Harga",
                        allowEditing:false,
                        dataType: 'number',
                        format: { type: 'fixedPoint', precision: 2 }
                    },
                    {
                        dataField: "Diskon",
                        caption: "Disk",
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
            })
        }
    })
</script>
@endpush