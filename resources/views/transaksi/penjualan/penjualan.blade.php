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
                                <li class="active"><a href="{{ route('penjualan') }}">Penjualan</a></li>
                            </ul>
                        </div>
                    </div>
                    <a class="btn v3" href="{{ url('penjualan/form/0') }}"><i class="ion-plus-round"></i>Tambah Penjualan </a>
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
                        <h5><i class="ion-ios-people"></i> Penjualan</h5>
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
                                        <select class="form-control filter-input" name="Customer" id="Customer">
                                            <option value="">Semua Customer</option>
                                            @foreach($customer as $sp)
                                                <option value="{{ $sp['id'] }}">{{ $sp['NamaCustomer'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-2 col-md-12">
                                        <div class="submit_btn text-right md-left">
                                            <button class="btn v3  mar-right-5 form-control filter-input" id="SearchPenjualan"><i class="ion-ios-search" aria-hidden="true"></i> Cari</button>
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

<div class="modal fade bs-example-modal-lg" id="ModalsBayar" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel"
        aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="mediumBody">
                <div>
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{route('penjualan-bayar')}}" method="post">
                                @csrf
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Nomor Penjualan</label>
                                        <input type="text" class="form-control filter-input" name="NoTransaksi" id="NoTransaksi" placeholder="Nomor Penjualan" >
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Metode Pembayaran *</label>
                                        <select class="form-control filter-input" name="KodeMetodePembayaran" style="display: none;">
                                            <option value="">Pilih Metode Pembayaran</option>
                                            @foreach($metode as $sp)
                                                <option value="{{ $sp['id'] }}">{{ $sp['NamaMetodePembayaran'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Tanggal Bayar</label>
                                        <input type="date" class="form-control filter-input" name="TglPembayaran" id="TglPembayaran" placeholder="Total Pembayaran" >
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Total</label>
                                        <input type="number" class="form-control filter-input" name="TotalPembayaran" id="TotalPembayaran" placeholder="Total Pembayaran" >
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Keterangan</label>
                                        <input type="text" class="form-control filter-input" name="NoReffPembayaran" id="NoReffPembayaran" placeholder="Keterangan" >
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn v7 mar-top-20">Save Changes</button>
                                </div>
                            </form>
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

        $('#SearchPenjualan').click(function () {
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
                            'Customer'  : $('#Customer').val(),
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
                        caption: "#",
                        allowEditing:false,
                    },
                    {
                        dataField: "TglTransaksi",
                        caption: "Tanggal",
                        allowEditing:false,
                    },
                    {
                        dataField: "NamaCustomer",
                        caption: "Customer",
                        allowEditing:false,
                    },
                    {
                        dataField: "DocTotal",
                        caption: "Total Faktur",
                        allowEditing:false,
                        dataType: 'number',
                        format: { type: 'fixedPoint', precision: 2 }
                    },
                    {
                        dataField: "Pembayaran",
                        caption: "Pembayaran",
                        allowEditing:false,
                        dataType: 'number',
                        format: { type: 'fixedPoint', precision: 2 }
                    },
                    {
                        dataField: "StatusTRX",
                        caption: "Status Transaksi",
                        allowEditing:false,
                    },
                    {
                        dataField: "StatusBayar",
                        caption: "Status Pembayaran",
                        allowEditing:false,
                    },
                    {
                    dataField: "FileItem",
                        caption: "Action",
                        allowEditing:false,
                        cellTemplate: function(cellElement, cellInfo) {
                            var id = cellInfo.data.NoTransaksi;
                            var route = "penjualan/cancel/" +cellInfo.data.NoTransaksi
                            var status = cellInfo.data.StatusTRX;
                            var statusbayar = cellInfo.data.StatusBayar;

                            var LinkAccess = '';
                            if (status != 'CANCEL' && statusbayar != 'LUNAS') {
                                LinkAccess = '<a href="'+route+'" class="btn btn-warning" data-toggle="tooltip" title="Delete" data-confirm-delete="true"> <i class="ion-android-delete"></i> CANCEL</a>';
                                if (statusbayar == 'BELUM LUNAS') {
                                    LinkAccess += "<button id='btnBayar' class='btn btn-success' title='Delete' onClick=loadPembayaran('"+cellInfo.data.NoTransaksi+"')> <i class='ion-android-delete'></i>Bayar</button>";
                                }
                            }
                            
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
    });

    function loadPembayaran(NoTransaksi) {
        var now = new Date();
        var day = ("0" + now.getDate()).slice(-2);
        var month = ("0" + (now.getMonth() + 1)).slice(-2);
        var lastDayofYear = now.getFullYear()+"-"+month+"-"+day;

        $('#NoTransaksi').val(NoTransaksi);
        $('#TglPembayaran').val(lastDayofYear)

        $('#ModalsBayar').modal('show');
    }
</script>
@endpush