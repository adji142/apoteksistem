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

                                @if ($pembelian)
                                    <li>Edit Pembelian</li>
                                @else
                                    <li>Add Pembelian</li>
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
                        <h5><i class="ion-person"></i> Pembelian :</h5>
                    </div>
                    <div class="db-add-listing">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" name="from_page" id="from_page" value="backend">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>NoTransaksi</label>
                                            <input type="text" class="form-control filter-input" name="NoTransaksi" id="NoTransaksi" placeholder="NoTransaksi" value="{{ count($pembelian) > 0 ? $pembelian[0]['NoTransaksi'] : 'Auto' }}" readonly="">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Tanggal Transaksi</label>
                                            <input type="date" class="form-control filter-input" name="TglTransaksi" id="TglTransaksi" placeholder="Nama Pembelian" value="{{ count($pembelian) > 0 ? $pembelian[0]['TglTransaksi'] : '' }}">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Tanggal Jatuh Tempo</label>
                                            <input type="date" class="form-control filter-input" name="TglJatuhTempo" id="TglJatuhTempo" placeholder="Mulai Bekerja" value="{{ count($pembelian) > 0 ? $pembelian[0]['TglJatuhTempo'] : '' }}">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>No. Faktur / No Reff</label>
                                            <input type="text" class="form-control filter-input" name="NoRef" id="NoRef" placeholder="No. Faktur / No Reff" value="{{ count($pembelian) > 0 ? $pembelian[0]['NoRef'] : '' }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Supplier / PBF</label>
                                            <select class="form-control filter-input" name="Supplier" id="Supplier">
                                                <option value="">Semua Supplier / PBF</option>
                                                @foreach($supplier as $sp)
                                                    <option value="{{ $sp['id'] }}" {{count($pembelian) > 0 ? $pembelian[0]['KodeVendor'] == $sp['id'] ? 'selected' : '' : ''}} >{{ $sp['NamaSupplier'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Status Transaksi</label>
                                            <select class="form-control filter-input" name="StatusTRX" id="StatusTRX" disabled="">
                                                <option value="O">Open</option>
                                                <option value="C">Close</option>
                                                <option value="N">Cancel</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Keterangan</label>
                                            <input type="text" class="form-control filter-input" name="Keterangan" id="Keterangan" placeholder="Keterangan" value="{{ count($pembelian) > 0 ? $pembelian[0]['Keterangan'] : '' }}" >
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

                                    <div class="col-md-12">
                                        <button id="btnSave" disabled="" class="btn v7 mar-top-20">Save Changes</button>
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

            bindGridDetail([]);
            // console.log (detailData);
            var jsonString = JSON.stringify(jsonObject);
            SetEnableCommand();
            // console.log(jsonString);
        })
    });

    $('#ItemCancel').click(function () {
        $('#itemModals').modal('toggle');
        // location.reload();
    });

    $('#ItemSave').click(function () {
        var dataGridInstance = $('#itemGrid').dxDataGrid('instance');
        var selectedRowsData = dataGridInstance.getSelectedRowsData();
        AppendItem(selectedRowsData);
    });
    $('#NoRef').change(function() {
        SetEnableCommand();
    });

    $('#Keterangan').change(function() {
        SetEnableCommand();
    });

    $('#Supplier').change(function() {
        SetEnableCommand();
    });

    $('#btnSave').click(function () {
        var header = {
            'TglTransaksi' : $('#TglTransaksi').val(),
            'TglJatuhTempo': $('#TglJatuhTempo').val(),
            'NoRef'        : $('#NoRef').val(),
            'Supplier'     : $('#Supplier').val(),
            'StatusTRX'    : $('#StatusTRX').val(),
            'Keterangan'   : $('#Keterangan').val()
        };
        var dataParam = {
            header : header,
            detail : jsonObject
        };

        // console.log(JSON.stringify(dataParam))
        $.ajax({
            url: "{{route('pembelian-store')}}",
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
                      icon: "success",
                      title: "Horray...",
                      text: "Data berhasil disimpan!",
                    }).then((result)=>{
                      // location.reload();
                      window.location.href = '{{url("pembelian")}}';
                    });
                }
                else{
                    Swal.fire({
                      icon: "error",
                      title: "Opps...",
                      text: response.message,
                    })
                }
            },
            error: function(xhr, status, error) {
                // Handle errors
                console.error('Error:', error);
            }
        });
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
                    BatchNumber : "",
                    ExpiredDate : lastDayofYear,
                    Qty : 1,
                    KodeSatuan : data[0].KodeSatuan,
                    satuan : data[0].Satuan,
                    Harga : data[0].LastPrice,
                    Diskon : 0,
                    LineTotal : 0
                }
                jsonObject.push(item);
            }
        }
        else{
            var item = {
                LineNumber : -1,
                KodeItem : data[0].KodeItem,
                NamaItem : data[0].NamaItem,
                BatchNumber : "",
                ExpiredDate : lastDayofYear,
                Qty : 1,
                KodeSatuan : data[0].KodeSatuan,
                satuan : data[0].Satuan,
                Harga : data[0].LastPrice,
                Diskon : 0,
                LineTotal : 0
            }
            jsonObject.push(item);
        }
        $('#itemModals').modal('toggle');
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
        // var SubTotal = newData.Qty * newData.Harga;
        // newData.LineTotal = SubTotal - (newData.Diskon / 100 * SubTotal)
        jsonObject.push(newData);
        // console.log(jsonObject)
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

        if ($('#NoRef').val() == "") {
            errorCount += 1;
        }

        if ($('#Supplier').val() == "") {
            errorCount += 1;
        }

        var TotalQty = 0;
        // console.log(jsonObject);
        // console.log(jsonObject.length);
        if (jsonObject.length > 0) {
            for (var i = 0; i < jsonObject.length; i++) {
                TotalQty += jsonObject[i]["Qty"];
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
    }

    function bindGridItem(data) {
        $("#itemGrid").dxDataGrid({
            allowColumnResizing: true,
            dataSource: data,
            keyExpr: "KodeItem",
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
                    dataField: "Satuan",
                    caption: "#",
                    allowEditing:false,
                },
                {
                    dataField: "KodeSatuan",
                    caption: "#",
                    allowEditing:false,
                    visible:false
                },
                {
                    dataField: "LastPrice",
                    caption: "#",
                    allowEditing:false,
                    visible:false
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
            paging: {
                enabled: true
            },
            searchPanel: {
                visible: true,
                width: 240,
                placeholder: "Search..."
            },
            editing: {
                mode: "row",
                allowAdding:true,
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
                    allowEditing:true,
                },
                {
                    dataField: "ExpiredDate",
                    caption: "ED",
                    allowEditing:true,
                    dataType: 'date',
                    editorType: 'dxDateBox',
                    width : 130,
                    editorOptions: {
                        format: 'yyyy-MM-dd',
                        displayFormat: 'dd-MM-yyyy',
                        type: 'date',
                        calendarOptions: {
                            firstDayOfWeek: 1
                        }
                    }
                },
                {
                    dataField: "Qty",
                    caption: "Qty",
                    allowEditing:true,
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
                    allowEditing:true,
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
            onInitNewRow: function(e) {
                $.ajax({
                    async   : false,
                    type    : "post",
                    url     : "{{route('obatLookup')}}",
                    data    : {
                                '_token': '{{ csrf_token() }}',
                            },
                    dataType: "json",
                    success: function (response) {
                      // bindGrid(response.data);
                      // console.log(response);
                      bindGridItem(response.data);
                      // console.log(detailData)
                    }
                });
                $('#itemModals').modal('show');
            },
            onEditorPrepared:function (args) {
                // console.log(args);
                if (args.dataField == "ExpiredDate") {
                    args.editorElement.dxDateBox("instance").option("format", "date")
                }
            }
        }).dxDataGrid('instance');

        // console.log(dataGridInstance);

        dataGridInstance.on('editorPreparing', function(e) {
            var Qty = 0;
            var Harga = 0;
            var Diskon = 0;

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
            else if (e.dataField === 'ExpiredDate') {
                oldData = e.row.data;
                e.editorOptions.onValueChanged = function(args) {
                    oldData.ExpiredDate = args.value;
                };
                e.editorOptions.onKeyDown = function (x) {
                    // console.log(oldData.Qty);
                    if (x.event.key == "Enter") {
                        editItem(oldData);
                    }
                }
            }

            else if (e.dataField === 'Qty') {
                oldData = e.row.data;
                e.editorOptions.onValueChanged = function(args) {
                    oldData.Qty = args.value;
                    var SubTotal = oldData.Qty * oldData.Harga
                    oldData.LineTotal = SubTotal - (oldData.Diskon / 100 * SubTotal)
                };
                e.editorOptions.onKeyDown = function (x) {
                    // console.log(oldData.Qty);
                    if (x.event.key == "Enter") {
                        editItem(oldData);
                    }
                }
            }

            else if (e.dataField === 'Harga') {
                oldData = e.row.data;
                e.editorOptions.onValueChanged = function(args) {
                    oldData.Harga = args.value;
                    var SubTotal = oldData.Qty * oldData.Harga
                    oldData.LineTotal = SubTotal - (oldData.Diskon / 100 * SubTotal)
                };
                e.editorOptions.onKeyDown = function (x) {
                    if (x.event.key == "Enter") {
                        editItem(oldData);
                    }
                }
            }

            else if (e.dataField === 'Diskon') {
                oldData = e.row.data;
                e.editorOptions.onValueChanged = function(args) {
                    oldData.Diskon = args.value;
                    var SubTotal = oldData.Qty * oldData.Harga
                    oldData.LineTotal = SubTotal - (oldData.Diskon / 100 * SubTotal)
                };
                e.editorOptions.onKeyDown = function (x) {
                    if (x.event.key === "Enter" || x.event.key === "Tab") {
                        editItem(oldData);
                    }
                }
            }

            // 
        });
    }
</script>
@endpush