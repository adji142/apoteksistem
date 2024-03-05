@extends('layouts.head-app')

@section('content')

<style type="text/css">
	.nice-select{
		display: none!important;
	}

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
                                <li class="active"><a href="#">Laporan Kas</a></li>
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
                        <h5><i class="ion-ios-people"></i> Laporan Kas <br><hr> <div id="periodelaporan"></div></h5>
                    </div>
                    <div class="invoice-body">
                        <div class="row filterbox">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-lg-3 col-md-12">
                                        <input type="date" class="form-control " name="TglAwal_sc" id="TglAwal_sc">
                                    </div>
                                    <div class="col-lg-3 col-md-12">
                                        <input type="date" class="form-control " name="TglAkhir_sc" id="TglAkhir_sc">
                                    </div>

                                    <div class="col-lg-2 col-md-12">
                                        <div class="submit_btn text-right md-right">
                                            <button class="btn btn-success" id="searchStockCard"><i class="ion-ios-search" aria-hidden="true"></i> Cari</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row exportbox">
			        		<div class="col-lg-3 col-md-12">
                                <div class="submit_btn text-right md-left">
                                    <button class="btn btn-success  mar-right-5 form-control filter-input" id="btExportXLS"><i class="ion-android-document" aria-hidden="true"></i> Excel</button>
                                </div>
                            </div>

                            <!-- <div class="col-lg-3 col-md-12">
                                <div class="submit_btn text-right md-left">
                                    <button class="btn btn-warning  mar-right-5 form-control filter-input" id="btExportPDF"><i class="ion-ios-search" aria-hidden="true"></i> PDF</button>
                                </div>
                            </div> -->

                            <div class="col-lg-3 col-md-12">
                                <div class="submit_btn text-right md-left">
                                    <button class="btn btn-default  mar-right-5 form-control filter-input" id="btPrint"><i class="ion-ios-printer" aria-hidden="true"></i> Print</button>
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
                                        <th>Akun Kas</th>
                                        <th>Keterangan</th>
                                        <th>Debit</th>
                                        <th>Kredit</th>
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

            $('#TglAwal_sc').val(today);
            $('#TglAkhir_sc').val(lastDayofYear);

            $('#KodeItem').select2();

            
		});

		$('#searchStockCard').click(function () {
			var KodeItem = '';
            $.ajax({
                async   : false,
                type    : "post",
                url     : "{{route('reportkas')}}",
                data    : {
                            'TglAwal'   : $('#TglAwal_sc').val(),
                            'TglAkhir'  : $('#TglAkhir_sc').val(),
                            '_token': '{{ csrf_token() }}',
                        },
                dataType: "json",
                success: function (response) {
                    // console.log($('#TglAwal_sc').val())
                    var TglAwal = new Date($('#TglAwal_sc').val())
                    var TglAkhir = new Date($('#TglAkhir_sc').val())

                    $('#periodelaporan').text("Periode : " +TglAwal.getDate() + "/" + (TglAwal.getMonth() + 1)+"/"+TglAwal.getFullYear() +" s/d "+TglAkhir.getDate() + "/" + (TglAkhir.getMonth() + 1)+"/"+TglAkhir.getFullYear())

                    if (response.data.length > 0) {
                        var xHtml = "";
                        var saldoAkhir = 0;
                        $("#dtrecord tbody tr").remove();

                        $.each(response.data,function (k,v) {
                            // console.log(v.KodeItem);

                            if (v.AkunKas == "SALDO AWAL") {
                                xHtml += "<tr>";
                                xHtml += "  <td colspan='6'> "+v.AkunKas+" </td>";
                                xHtml += "  <td>"+ v.Debit +"</td>";
                                xHtml += "</tr>";

                                saldoAkhir += v.Debit;
                            }
                            else{
                                saldoAkhir += v.Debit - v.Kredit;
                                xHtml += "<tr>";
                                xHtml += "  <td> "+v.NoTransaksi+" </td>";
                                xHtml += "  <td>"+ v.Tanggal +"</td>";
                                xHtml += "  <td>"+ v.AkunKas +"</td>";
                                xHtml += "  <td>"+ v.Keterangan +"</td>";
                                xHtml += "  <td>"+ v.Debit +"</td>";
                                xHtml += "  <td>"+ v.Kredit +"</td>";
                                xHtml += "  <td>"+ saldoAkhir +"</td>";
                                xHtml += "</tr>";
                            }
                        });

                        // dtrecord
                        $('#dtrecord tbody').append(xHtml);
                    }
                }
            });
		})

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