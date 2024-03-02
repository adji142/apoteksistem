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

                                @if ($penjualan)
                                    <li>Edit Penjualan</li>
                                @else
                                    <li>Add Penjualan</li>
                                @endif
                               
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
                <div class="db-add-list-wrap">
                    <div class="act-title">
                        <h5><i class="ion-person"></i> Penjualan :</h5>
                    </div>
                    <div class="db-add-listing">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" name="from_page" id="from_page" value="backend">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>NoTransaksi</label>
                                            <input type="text" class="form-control filter-input" name="NoTransaksi" id="NoTransaksi" placeholder="NoTransaksi" value="{{ count($penjualan) > 0 ? $penjualan[0]['NoTransaksi'] : 'Auto' }}" readonly="">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Tanggal Transaksi</label>
                                            <input type="date" class="form-control filter-input" name="TglTransaksi" id="TglTransaksi" placeholder="Nama Penjualan" value="{{ count($penjualan) > 0 ? $penjualan[0]['TglTransaksi'] : '' }}">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Customer</label>
                                            <select class="form-control filter-input" name="Customer" id="Customer">
                                                <option value="">Semua Customer</option>
                                                @foreach($customer as $sp)
                                                    <option value="{{ $sp['id'] }}" {{count($penjualan) > 0 ? $penjualan[0]['KodeCustomer'] == $sp['id'] ? 'selected' : '' : ''}} >{{ $sp['NamaCustomer'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Scan Barcode</label>
                                            <input type="text" class="form-control filter-input" name="Barcode" id="Barcode" placeholder="Scan Barcode" >
                                        </div>
                                    </div>

                                    <hr>
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <div class="dx-viewport demo-container">
                                                <div id="data-grid-demo">
                                                  <div id="detailGrid">
                                                  </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <!-- <br> -->
                                            <hr>
                                            <table class="invoice-table">
                                                <thead>
                                                    <tr class="invoice-headings">
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th>Total Transaksi</th>
                                                        <th>:</th>
                                                        <th align="right"><div id="_TotalTransaksi"></div></th>
                                                    </tr>
                                                    <tr>
                                                        <th>Diskon</th>
                                                        <th>:</th>
                                                        <th align="right"><div id="_Diskon"></div></th>
                                                    </tr>
                                                    <tr>
                                                        <th>Grand Total</th>
                                                        <th>:</th>
                                                        <th align="right"><div id="_GrandTotal"></div></th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>                                    

                                    <div class="col-md-12">
                                        <button id="btnSave" disabled="" class="btn v7 mar-top-20">Bayar</button>
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


<div class="modal fade bs-example-modal-lg" id="itemModals" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel"
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
                            <div class="table-responsive">
                                <div class="dx-viewport demo-container">
                                    <div id="data-grid-demo">
                                      <div id="itemGrid">
                                      </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8"></div>
                        <div class="col-md-4">
                            <button id="ItemSave" class="btn btn-success mar-top-20" >Save Changes</button>
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
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Metode Pembayaran *</label>
                                    <select class="form-control filter-input" name="KodeMetodePembayaran" id="KodeMetodePembayaran" style="display: none;">
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
                                    <label>Total Transaksi</label>
                                    <input type="number" class="form-control filter-input" name="TotalTransaksi" id="TotalTransaksi" placeholder="Total Transaksi" >
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Total Bayar</label>
                                    <input type="number" class="form-control filter-input" name="TotalPembayaran" id="TotalPembayaran" placeholder="Total Pembayaran" >
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>NO. Reff</label>
                                    <input type="text" class="form-control filter-input" name="NoReffPembayaran" id="NoReffPembayaran" placeholder="Keterangan" >
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button id="btnBayar" class="btn v7 mar-top-20" >Bayar</button>
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
    var jsonObject = [];
    $(function () {
        $(document).ready(function () {
            // Define a JavaScript object
            var now = new Date();
            var day = ("0" + now.getDate()).slice(-2);
            var month = ("0" + (now.getMonth() + 1)).slice(-2);

            var lastDayofYear = now.getFullYear()+"-"+month+"-"+day;
            $('#TglTransaksi').val(lastDayofYear);
            $('#TglJatuhTempo').val(lastDayofYear);
            $('#TglPembayaran').val(lastDayofYear);

            bindGridDetail([]);
            // console.log (detailData);
            var jsonString = JSON.stringify(jsonObject);
            SetEnableCommand();
            // console.log(jsonString);
        })
    });

    $('#Barcode').keypress(function(event) {
        if (event.keyCode === 13) {
            $.ajax({
                async   : false,
                type    : "post",
                url     : "{{route('batchLookup')}}",
                data    : {
                            'kriteria' : $('#Barcode').val(),
                            '_token': '{{ csrf_token() }}',
                        },
                dataType: "json",
                success: function (response) {
                    if (response.data.length == 1) {
                        var temp = [];
                        $.each(response.data,function (k,v) {
                            var item = {
                                LineNumber : -1,
                                KodeItem : v.KodeItem,
                                NamaItem : v.NamaItem,
                                BatchNumber : v.BatchNumber,
                                Qty : 1,
                                HargaJual : v.HargaJual,
                                Diskon : 0,
                                LineTotal : 0,
                                KodeSatuan : v.KodeSatuan
                            }
                            temp.push(item);
                        });
                        AppendItem(temp);

                    }
                    else if (response.data.length > 1) {
                        bindGridItem(response.data);
                        $('#itemModals').modal('show');
                    }
                    else{
                        alert('Item Tidak ditemukan')
                        $('#Barcode').val('');
                    }
                    $('#Barcode').val('');
                }
            });
        }
    });

    $('#ItemCancel').click(function () {
        $('#itemModals').modal('toggle');
        // location.reload();
    });

    $('#ItemSave').click(function () {
        var dataGridInstance = $('#itemGrid').dxDataGrid('instance');
        var selectedRowsData = dataGridInstance.getSelectedRowsData();
        AppendItem(selectedRowsData);
        $('#itemModals').modal('toggle');
    });

    $('#Customer').change(function() {
        SetEnableCommand();
    });

    $('#btnBayar').click(function () {
        $('#btnBayar').text('Tunggu Sebentar.....');
        $('#btnBayar').attr('disabled',true);
        var header = {
            'TglTransaksi' : $('#TglTransaksi').val(),
            'KodeCustomer' : $('#Customer').val(),
            'StatusTRX'    : 'O',
            'Keterangan'   : ''
        };
        var pembayaran  = {
            'KodeMetodePembayaran'  : $('#KodeMetodePembayaran').val(),
            'NoReffPembayaran'      : $('#NoReffPembayaran').val(),
            'TglPembayaran'         : $('#TglPembayaran').val(),
            'TotalTransaksi'        : $('#TotalTransaksi').val(),
            'TotalPembayaran'       : $('#TotalPembayaran').val(),
        }
        var dataParam = {
            header : header,
            pembayaran : pembayaran,
            detail : jsonObject
        };

        // console.log(JSON.stringify(dataParam))
        $.ajax({
            url: "{{route('penjualan-store')}}",
            type: 'POST',
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
            },
            data: JSON.stringify(dataParam),
            success: function(response) {
                // Handle the response from the controller
                // console.log('Response from controller:', response);
                if (response.success == true) {
                    Swal.fire({
                        html: "Data berhasil disimpan! <br> Dengan Kembalian Rp. " + response.Kembalian.toLocaleString('en-US'),
                        icon: "success",
                        title: "Horray...",
                        // text: "Data berhasil disimpan! <br> " + response.Kembalian,
                    }).then((result)=>{
                        $('#btnBayar').text('Save');
                        $('#btnBayar').attr('disabled',false);
                        // location.reload();
                        window.location.href = '{{url("penjualan")}}';
                    });
                }
                else{
                    Swal.fire({
                      icon: "error",
                      title: "Opps...",
                      text: response.message,
                    })
                    $('#btnBayar').text('Save');
                    $('#btnBayar').attr('disabled',false);
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                  icon: "error",
                  title: "Opps...",
                  text: error,
                })
                // Handle errors
                console.error('Error:', error);
                $('#btnBayar').text('Save');
                $('#btnBayar').attr('disabled',false);
            }
        });
    })

    $('#btnSave').click(function () {
        $('#ModalsBayar').modal('show');
    })


    function AppendItem(data) {
        var dataGridInstance = $('#detailGrid').dxDataGrid('instance');
        var allRowsData  = dataGridInstance.getDataSource().items();

        var now = new Date();
        var day = ("0" + now.getDate()).slice(-2);
        var month = ("0" + (now.getMonth() + 1)).slice(-2);

        var lastDayofYear = now.getFullYear()+"-"+month+"-"+day;

        if (allRowsData.length > 0) {
            if (cekDuplicate(allRowsData, data[0].KodeItem)) {
                alert('Data Sudah ada di baris lain');
            }
            else{
                var item = {
                    LineNumber : -1,
                    KodeItem : data[0].KodeItem,
                    NamaItem : data[0].NamaItem,
                    BatchNumber : data[0].BatchNumber,
                    Qty : 1,
                    HargaJual : data[0].HargaJual,
                    Diskon : 0,
                    LineTotal : 1 * data[0].HargaJual,
                    KodeSatuan : data[0].KodeSatuan
                }
                jsonObject.push(item);
            }
        }
        else{
            console.log(data);
            var item = {
                LineNumber : -1,
                KodeItem : data[0].KodeItem,
                NamaItem : data[0].NamaItem,
                BatchNumber : data[0].BatchNumber,
                Qty : 1,
                HargaJual : data[0].HargaJual,
                Diskon : 0,
                LineTotal : 1 * data[0].HargaJual,
                KodeSatuan : data[0].KodeSatuan
            }
            jsonObject.push(item);
        }
        // $('#itemModals').modal('toggle');
        bindGridDetail(jsonObject);
        SetEnableCommand();
        // bindGridDetail();
        // console.log(jsonObject);
    }

    function editItem(newData) {
        var itemIndex = -1;
        for (var i = 0; i < jsonObject.length; i++) {
            if (jsonObject[i]['KodeItem'] == newData['KodeItem']) {
                itemIndex = i;
            }
        }

        jsonObject.splice(itemIndex,1);
        console.log(jsonObject.length)
        // var SubTotal = newData.Qty * newData.Harga;
        // newData.LineTotal = SubTotal - (newData.Diskon / 100 * SubTotal)
        jsonObject.push(newData);
        console.log(newData)
        bindGridDetail(jsonObject);
        SetEnableCommand();
    }

    function cekDuplicate(griddata, newValue) {
        var itemCount = 0;
        var duplicate = false;
        for (var i = 0 ; i < griddata.length; i++) {
            if (griddata[i].KodeItem == newValue) {
                itemCount += 1;
            }
        }

        if (itemCount > 0) {
            duplicate = true;
        }
        return duplicate;
    }

    function SetEnableCommand() {
        var errorCount = 0;

        if ($('#Customer').val() == "") {
            errorCount += 1;
        }

        var TotalQty = 0;
        // console.log(jsonObject);
        // console.log(jsonObject.length);
        var xTotalTransaksi = 0;
        var xDiskon = 0;
        var xGrandTotal = 0;
        if (jsonObject.length > 0) {
            for (var i = 0; i < jsonObject.length; i++) {
                TotalQty += jsonObject[i]["Qty"];
                xTotalTransaksi += (jsonObject[i]["Qty"] * jsonObject[i]["HargaJual"]);
                xDiskon = Math.abs(jsonObject[i]['LineTotal'] - (jsonObject[i]['Qty'] * jsonObject[i]['HargaJual']));
                console.log(jsonObject[i]["Qty"])
            }
        }
        else{
            errorCount += 1;
        }

        if (TotalQty == 0) {
            errorCount +=1;
        }

        if (errorCount > 0) {
            $('#btnSave').prop('disabled', true);
        }
        else{
            $('#btnSave').prop('disabled', false);
        }

        // Set Total Transaksi
        xGrandTotal = xTotalTransaksi - xDiskon;
        $("#_TotalTransaksi").text(xTotalTransaksi.toLocaleString('en-US'));
        $("#_Diskon").text(xDiskon.toLocaleString('en-US'));
        $("#_GrandTotal").text(xGrandTotal.toLocaleString('en-US'));
        $('#TotalTransaksi').val(xGrandTotal);
    }

    function bindGridItem(data) {
        $("#itemGrid").dxDataGrid({
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
            selection:{
                mode: "single"
            },
            columns: [
                {
                    dataField: "BatchNumber",
                    caption: "Batch",
                    allowEditing:false,
                },
                {
                    dataField: "KodeItem",
                    caption: "Kode",
                    allowEditing:false,
                },
                {
                    dataField: "NamaItem",
                    caption: "Nama Item",
                    allowEditing:false,
                },
                {
                    dataField: "Stock",
                    caption: "Stock",
                    allowEditing:false,
                    dataType: 'number',
                    format: { type: 'fixedPoint', precision: 2 }
                },
                {
                    dataField: "HargaJual",
                    caption: "Harga",
                    allowEditing:false,
                },
            ]
        });
    }

    function bindGridDetail(data) {
        var oldData = {};
        var dataGridInstance = $("#detailGrid").dxDataGrid({
            allowColumnResizing: true,
            dataSource: data,
            keyExpr: "KodeItem",
            showBorders: true,
            searchPanel: {
                visible: true,
                width: 240,
                placeholder: "Search..."
            },
            editing: {
                mode: "row",
                allowUpdating: true,
                allowDeleting: true,
                texts: {
                    confirmDeleteMessage: ''  
                }
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
                    allowEditing:true,
                    dataType: 'number',
                    format: { type: 'fixedPoint', precision: 2 }
                },
                {
                    dataField: "HargaJual",
                    caption: "Harga",
                    allowEditing:false,
                    dataType: 'number',
                    format: { type: 'fixedPoint', precision: 2 }
                },
                {
                    dataField: "Diskon",
                    caption: "Disk",
                    allowEditing:true,
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
            ],
            onRowRemoved:function (e) {
                SetEnableCommand();
            }
        }).dxDataGrid('instance');

        // console.log(dataGridInstance);

        dataGridInstance.on('editorPreparing', function(e) {

            if (e.dataField === 'BatchNumber') {
                oldData = e.row.data;
                e.editorOptions.onValueChanged = function(args) {
                    oldData.BatchNumber = args.value;
                };
                e.editorOptions.onKeyDown = function (x) {
                    if (x.event.key == "Enter") {
                        editItem(oldData);
                    }
                }
            }

            else if (e.dataField === 'Qty') {
                oldData = e.row.data;
                e.editorOptions.onValueChanged = function(args) {
                    oldData.Qty = args.value;
                    var SubTotal = oldData.Qty * oldData.HargaJual
                    oldData.LineTotal = SubTotal - (oldData.Diskon / 100 * SubTotal)
                    // editItem(oldData);
                    SetEnableCommand()
                };
                e.editorOptions.onKeyDown = function (x) {
                    // console.log(oldData.Qty);
                    if (x.event.key == "Enter") {
                        // oldData = e.row.data;
                        // editItem(oldData);
                        var $focusedRow = $(e.component._$focusedRowElement);
                        var $saveButton = $focusedRow.find(".dx-link dx-link-save");
                        // console.log($focusedRow);
                        if ($saveButton.length) {
                            $saveButton.trigger("click");
                        }
                    }
                }
            }

            else if (e.dataField === 'HargaJual') {
                oldData = e.row.data;
                e.editorOptions.onValueChanged = function(args) {
                    oldData.HargaJual = args.value;
                    var SubTotal = oldData.Qty * oldData.HargaJual
                    oldData.LineTotal = SubTotal - (oldData.Diskon / 100 * SubTotal)
                };
            }

            else if (e.dataField === 'Diskon') {
                oldData = e.row.data;
                e.editorOptions.onValueChanged = function(args) {
                    oldData.Diskon = args.value;
                    var SubTotal = oldData.Qty * oldData.HargaJual
                    oldData.LineTotal = SubTotal - (oldData.Diskon / 100 * SubTotal)
                    SetEnableCommand()
                };
                e.editorOptions.onKeyDown = function (x) {
                    if (x.event.key === "Enter" || x.event.key === "Tab") {
                        // editItem(oldData);
                        var $focusedRow = $(e.component._$focusedRowElement);
                        var $saveButton = $focusedRow.find(".dx-link dx-link-save");
                        // console.log($focusedRow);
                        if ($saveButton.length) {
                            $saveButton.trigger("click");

                        }
                    }
                }
            }
            // 
        });
    }
</script>
@endpush