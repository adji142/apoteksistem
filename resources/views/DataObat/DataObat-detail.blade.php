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
                                    <div class="col-lg-5 col-md-12">
                                        <select class="form-control filter-input" name="Supplier" id="Supplier">
                                            <option value="">Semua Supplier / PBF</option>
                                        </select>
                                    </div>
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
                            <table class="invoice-table">
                                <thead>
                                    <tr class="invoice-headings">
                                        <th>Kode Item</th>
                                        <th>Nama Item</th>
                                        <th>Quantity</th>
                                        <th>Saldo Akhir</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
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
                                  <div id="batchGrid">
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
@endsection

@push('scripts')
<script type="text/javascript">
    $(function () {

        $(document).ready(function () {
            generateBatch();
        });

        $('#searchBatch').click(function () {
            generateBatch();
        })

        function generateBatch() {
            var KodeItem = '{{ $KodeItem }}';
            var Supplier = $('#Supplier').val();
            var Stock = $('#Stock').val();

            $.ajax({
                type    : "post",
                url     : "{{route('databatch')}}",
                data    : {
                            'KodeItem':KodeItem,
                            'Supplier' : Supplier,
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
@endpush