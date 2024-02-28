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

                                @if ($dataobat)
                                    <li>Edit Data Obat</li>
                                @else
                                    <li>Add Data Obat</li>
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
                        <h5><i class="ion-person"></i> DataObat :</h5>
                    </div>
                    <div class="db-add-listing">
                        <div class="row">
                            
                            @if (count($dataobat) > 0)
                            <form action="{{route('dataobat-edit')}}" method="post">
                            @else
                            <form action="{{route('dataobat-store')}}" method="post">
                            @endif
                            
                            @csrf
                                <div class="col-md-12">
                                    <input type="hidden" name="from_page" id="from_page" value="backend">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Kode Obat</label>
                                                <input type="text" class="form-control filter-input" name="KodeItem" id="KodeItem" placeholder="Kode Obat" value="{{ count($dataobat) > 0 ? $dataobat[0]['KodeItem'] : '' }}" >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Name Obat</label>
                                                <input type="text" class="form-control filter-input" name="NamaItem" placeholder="Nama Obat" value="{{ count($dataobat) > 0 ? $dataobat[0]['NamaItem'] : '' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Kelompok Obat</label>
                                                <select class="form-control filter-input" name="KodeKelompok">
                                                    <option value="">Pilih Kelompok</option>
                                                    @foreach($kelompokobat as $ko)
                                                        <option 
                                                            value="{{ $ko['id'] }}"
                                                            {{ count($dataobat) > 0 ? $dataobat[0]['KodeKelompok'] == $ko['id'] ? 'selected' : '' : '' }}
                                                        >
                                                            {{ $ko['Nama'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Satuan</label>
                                                <select class="form-control filter-input" name="KodeSatuan">
                                                    <option value="">Pilih Satuan</option>
                                                    @foreach($satuan as $sat)
                                                        <option 
                                                            value="{{ $sat['Kode'] }}"
                                                            {{ count($dataobat) > 0 ? $dataobat[0]['KodeSatuan'] == $sat['Kode'] ? 'selected' : '' : '' }}
                                                        >

                                                            {{ $sat['Nama'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Lokasi Rak</label>
                                                <select class="form-control filter-input" name="LokasiRakObat">
                                                    <option value="">Pilih Lokasi Rak</option>
                                                    @foreach($lokasirak as $rak)
                                                        <option 
                                                            value="{{ $rak['Kode'] }}"
                                                            {{ count($dataobat) > 0 ? $dataobat[0]['LokasiRakObat'] == $rak['Kode'] ? 'selected' : '' : '' }}
                                                        >
                                                            {{ $rak['Nama'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Minimal Qty</label>
                                                <input type="number" class="form-control filter-input" name="MinQty" placeholder="Minimal Qty" value="{{ count($dataobat) > 0 ? $dataobat[0]['MinQty'] : '' }}">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Harga Pokok</label>
                                                <input type="text" class="form-control filter-input" name="HargaPokok" placeholder="HargaPokok" value="{{ count($dataobat) > 0 ? number_format($dataobat[0]['HargaPokok']) : '0' }}" readonly="">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Harga Jual</label>
                                                <input type="number" class="form-control filter-input" name="HargaJual" placeholder="HargaJual" value="{{ count($dataobat) > 0 ? number_format($dataobat[0]['HargaJual']) : '0' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select class="form-control filter-input" name="Active" style="display: none;">
                                                    <option value="Y" {{ count($dataobat) > 0 ? $dataobat[0]['Active'] == 'Y' ? "selected" :"" : ""}}>Active</option>
                                                    <option value="N" {{ count($dataobat) >0 ? $dataobat[0]['Active'] == 'N' ? "selected" :"" : ""}}>Non Active</option>
                                                </select>
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
@include('DataObat.DataObat-js')
@endsection