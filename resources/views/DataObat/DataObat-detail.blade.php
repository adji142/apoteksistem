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
                                <li class="active"><a href="{{ route('dataobat') }}">Data Obat</a></li>
                                <li class="active"><a href="#">Detail</a></li>
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
                        <h5><i class="ion-ios-people"></i> Data Batch</h5>
                    </div>
                    <div class="invoice-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <!-- <div class="col-lg-5 col-md-12">
                                        <select class="form-control filter-input" name="Supplier" id="Supplier">
                                            <option value="">Semua Supplier / PBF</option>
                                        </select>
                                    </div> -->
                                    <div class="col-lg-5 col-md-12">
                                        <select class="form-control filter-input" name="Stock" id="Stock">
                                            <option value="-1">Tampilkan Stok 0</option>
                                            <option value="1">YA</option>
                                            <option value="0">TIDAK</option>
                                        </select>
                                    </div>

                                    <div class="col-lg-2 col-md-12">
                                        <div class="submit_btn text-right md-left">
                                            <button class="btn v3  mar-right-5 form-control filter-input" id="searchBatch"><i class="ion-ios-search" aria-hidden="true"></i> Cari</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="table-responsive">
                            <div class="dx-viewport demo-container">
                                <div id="data-grid-demo">
                                  <div id="batchGrid">
                                  </div>
                                </div>
                            </div>
                        </div>
                        <!--pagination starts-->
                        <!--pagination ends-->
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="invoice-panel">
                    <div class="act-title">
                        <h5><i class="ion-ios-people"></i> Kartu Stock</h5>
                    </div>
                    <div class="invoice-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-lg-5 col-md-12">
                                        <input type="date" class="form-control filter-input" name="TglAwal_sc" id="TglAwal_sc">
                                    </div>
                                    <div class="col-lg-5 col-md-12">
                                        <input type="date" class="form-control filter-input" name="TglAkhir_sc" id="TglAkhir_sc">
                                    </div>

                                    <div class="col-lg-2 col-md-12">
                                        <div class="submit_btn text-right md-left">
                                            <button class="btn v3  mar-right-5 form-control filter-input" id="searchStockCard"><i class="ion-ios-search" aria-hidden="true"></i> Cari</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="table-responsive">
                            <table id="dtrecord" class="table">
                                <thead>
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Tanggal</th>
                                        <th>Nama Item</th>
                                        <th>Keterangan</th>
                                        <th>IN</th>
                                        <th>OUT</th>
                                        <th>Saldo Akhir</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="invoice-panel">
                    <div class="act-title">
                        <h5><i class="ion-ios-people"></i> Pembelian</h5>
                    </div>
                    <div class="invoice-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-lg-6 col-md-12">
                                        <input type="date" class="form-control filter-input" name="TglAwal_pb" id="TglAwal_pb">
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <input type="date" class="form-control filter-input" name="TglAkhir_pb" id="TglAkhir_pb">
                                    </div>

                                    <div class="col-lg-12 col-md-12">
                                        <div class="submit_btn text-right md-left">
                                            <button class="btn v3  mar-right-5 form-control filter-input" id="searchPembelian"><i class="ion-ios-search" aria-hidden="true"></i> Cari</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="table-responsive">
                            <div class="dx-viewport demo-container">
                                <div id="data-grid-demo">
                                  <div id="pembelianGrid">
                                  </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="invoice-panel">
                    <div class="act-title">
                        <h5><i class="ion-ios-people"></i> Penjualan</h5>
                    </div>
                    <div class="invoice-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-lg-6 col-md-12">
                                        <input type="date" class="form-control filter-input" name="TglAwal_pj" id="TglAwal_pj">
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <input type="date" class="form-control filter-input" name="TglAkhir_pj" id="TglAkhir_pj">
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="submit_btn text-right md-left">
                                            <button class="btn v3  mar-right-5 form-control filter-input" id="searchPenjualan"><i class="ion-ios-search" aria-hidden="true"></i> Cari</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="table-responsive">
                            <div class="dx-viewport demo-container">
                                <div id="data-grid-demo">
                                  <div id="PenjualanGrid">
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

            $('#TglAwal_pb').val(today);
            $('#TglAkhir_pb').val(lastDayofYear);
            $('#TglAwal_pj').val(today);
            $('#TglAkhir_pj').val(lastDayofYear);
            $('#TglAwal_sc').val(today);
            $('#TglAkhir_sc').val(lastDayofYear);
            generateBatch();
            getPembelian();
            getPenjualan();
            getStockCard();
        });

        $('#searchBatch').click(function () {
            generateBatch();
        })
        $('#searchPenjualan').click(function () {
            getPenjualan();
        })
        $('#searchPembelian').click(function () {
            getPembelian();
        })

        function generateBatch() {
            var KodeItem = '{{ $KodeItem }}';
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
        function getPembelian() {
            var KodeItem = '{{ $KodeItem }}';
            $.ajax({
                async   : false,
                type    : "post",
                url     : "{{route('getreport')}}",
                data    : {
                            'TglAwal'   : $('#TglAwal_pb').val(),
                            'TglAkhir'  : $('#TglAkhir_pb').val(),
                            'Supplier'  : '',
                            'KodeItem'  : KodeItem,
                            '_token': '{{ csrf_token() }}',
                        },
                dataType: "json",
                success: function (response) {
                  // bindGrid(response.data);
                  // console.log(response);
                  bindGridPembelian(response.data);
                }
            });
        }

        function getStockCard() {
            var KodeItem = '{{ $KodeItem }}';
            $.ajax({
                async   : false,
                type    : "post",
                url     : "{{route('getstockcard')}}",
                data    : {
                            'TglAwal'   : $('#TglAwal_sc').val(),
                            'TglAkhir'  : $('#TglAkhir_sc').val(),
                            'KodeItem'  : KodeItem,
                            '_token': '{{ csrf_token() }}',
                        },
                dataType: "json",
                success: function (response) {
                  if (response.data.length > 0) {
                        var xHtml = "";
                        var saldoAkhir = 0;
                        $.each(response.data,function (k,v) {
                            // console.log(v.KodeItem);

                            if (v.KodeItem == "SALDO AWAL") {
                                xHtml += "<tr>";
                                xHtml += "  <td colspan='6'> "+v.KodeItem+" </td>";
                                xHtml += "  <td>"+ v.QtyIN +"</td>";
                                xHtml += "</tr>";

                                saldoAkhir += v.QtyIN;
                            }
                            else{
                                saldoAkhir += v.QtyIN - v.QtyOut;
                                xHtml += "<tr>";
                                xHtml += "  <td> "+v.NoTransaksi+" </td>";
                                xHtml += "  <td>"+ v.Tanggal +"</td>";
                                xHtml += "  <td>"+ v.NamaItem +"</td>";
                                xHtml += "  <td>"+ v.Keterangan +"</td>";
                                xHtml += "  <td>"+ v.QtyIN +"</td>";
                                xHtml += "  <td>"+ v.QtyOut +"</td>";
                                xHtml += "  <td>"+ saldoAkhir +"</td>";
                                xHtml += "</tr>";
                            }
                        });

                        console.log(xHtml);

                        // dtrecord
                        $('#dtrecord tbody').append(xHtml);
                    }
                }
            });
        }

        function getPenjualan() {
            var KodeItem = '{{ $KodeItem }}';
            $.ajax({
                async   : false,
                type    : "post",
                url     : "{{route('getreportpenjualan')}}",
                data    : {
                            'TglAwal'   : $('#TglAwal_pj').val(),
                            'TglAkhir'  : $('#TglAkhir_pj').val(),
                            'Customer'  : '',
                            'KodeItem'  : KodeItem,
                            '_token': '{{ csrf_token() }}',
                        },
                dataType: "json",
                success: function (response) {
                  // bindGrid(response.data);
                  // console.log(response);
                  bindGridPenjualan(response.data);
                }
            });
        }

        function bindgridBatch(data) {
            $("#batchGrid").dxDataGrid({
                allowColumnResizing: true,
                dataSource: data,
                keyExpr: "BatchNumber",
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

        function bindGridPembelian(data) {
            var dataGridInstance = $("#pembelianGrid").dxDataGrid({
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
                        dataField: "NamaSupplier",
                        caption: "Supplier",
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
                        dataField: "StatusBayar",
                        caption: "Status Pembayaran",
                        allowEditing:false,
                    }
                ]
            })
        }

        function bindGridPenjualan(data) {
            var dataGridInstance = $("#PenjualanGrid").dxDataGrid({
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
                        dataField: "StatusBayar",
                        caption: "Status Pembayaran",
                        allowEditing:false,
                    }
                ]
            })
        }


    })
</script>
@endpush