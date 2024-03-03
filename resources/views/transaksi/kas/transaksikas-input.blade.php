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
                                <li class="active"><a href="{{ route('transaksikas') }}">Transaksi Kas</a></li>

                                @if (count($transaksikas) > 0)
                                    <li>Edit Transaksi Kas</li>
                                @else
                                    <li>Add Transaksi Kas</li>
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
                        <h5><i class="ion-person"></i> Transaksi Kas :</h5>
                    </div>
                    <div class="db-add-listing">
                        <div class="row">
                            @if (count($transaksikas) > 0)
                            <form action="{{route('transaksikas-edit')}}" method="post">
                            @else
                            <form action="{{route('transaksikas-store')}}" method="post">
                            @endif
                            
                            @csrf
                                <div class="col-md-12">
                                    <input type="hidden" name="from_page" id="from_page" value="backend">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>No Transaksi</label>
                                                <input type="text" class="form-control filter-input" name="NoTransaksi" placeholder="No Transakai" value="{{ count($transaksikas) > 0 ? $transaksikas[0]['NoTransaksi'] : 'AUTO' }}" readonly="">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tgl Transaksi</label>
                                                <input type="date" class="form-control filter-input" name="TglTransaksi" id="TglTransaksi" placeholder="No Transakai" value="{{ count($transaksikas) > 0 ? $transaksikas[0]['TglTransaksi'] : '' }}">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Jenis Transaksi *</label>
                                                <select class="form-control filter-input" id="Transaksi" name="Transaksi" style="display: none;">
                                                    <option value="1" {{ count($transaksikas) > 0 ? $transaksikas[0]['Transaksi'] == '1' ? "selected" : '' :""}}>Penerimaan</option>
                                                    <option value="2" {{ count($transaksikas) > 0 ? $transaksikas[0]['Transaksi'] == '2' ? "selected" : '' :""}}>Pengeluaran</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Akun Kas</label>
                                                <select class="form-control filter-input" name="KodeAkun">
                                                    <option value="">Pilih Akun</option>
                                                    @foreach($akunkas as $ko)
                                                        <option 
                                                            value="{{ $ko['id'] }}"
                                                            {{ count($transaksikas) > 0 ? $transaksikas[0]['KodeAkun'] == $ko['id'] ? 'selected' : '' : '' }}
                                                        >
                                                            {{ $ko['NamaAkun'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Total</label>
                                                <input type="number" class="form-control filter-input" name="Total" placeholder="Total" value="{{ count($transaksikas) >0 ? $transaksikas[0]['Total'] : '' }}">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Keterangan</label>
                                                <input type="text" class="form-control filter-input" name="Keterangan" placeholder="Keterangan" value="{{ count($transaksikas) >0 ? $transaksikas[0]['Keterangan'] : '' }}">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <button type="submit" class="btn v7 mar-top-20">Save Changes</button>
                                        </div>
                                    </div>
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
            // Define a JavaScript object
            var now = new Date();
            var day = ("0" + now.getDate()).slice(-2);
            var month = ("0" + (now.getMonth() + 1)).slice(-2);

            var lastDayofYear = now.getFullYear()+"-"+month+"-"+day;
            $('#TglTransaksi').val(lastDayofYear);
            // console.log(jsonString);
        })
    })
</script>
@endpush