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
                            </ul>
                        </div>
                    </div>
                    <a class="btn v3" href="{{ url('dataobat/form/0') }}"><i class="ion-plus-round"></i>Tambah Data Obat </a>
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
                        <h5><i class="ion-ios-people"></i> Data Obat</h5>
                    </div>
                    <div class="invoice-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form class="hero__form v2 filter" action="{{ route('dataobat') }}">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-12">
                                            <select class="hero__form-input  custom-select" name="KodeKelompok">
                                                <option value="">Semua Kelompok</option>
                                                @foreach($kelompokobat as $ko)
                                                    <option value="{{ $ko['id'] }}">{{ $ko['Nama'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-4 col-md-12">
                                            <select class="hero__form-input  custom-select" name="LokasiRakObat">
                                                <option value="">Semua Rak</option>
                                                @foreach($lokasirak as $rak)
                                                    <option value="{{ $rak['Kode'] }}">{{ $rak['Nama'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-4 col-md-12">
                                            <select class="hero__form-input  custom-select" name="status">
                                                <option value="">Semua Status</option>
                                                <option value="1">Aktif</option>
                                                <option value="0">Tidak Aktif</option>
                                            </select>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-lg-10 col-md-12">
                                            <input class="hero__form-input custom-select" type="text" name="keyword" id="keyword" placeholder="Cari Data">
                                        </div>
                                        <div class="col-lg-2 col-md-12">
                                            <div class="submit_btn text-right md-left">
                                                <button class="btn v3  mar-right-5" type="submit"><i class="ion-ios-search" aria-hidden="true"></i> Cari</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <hr>
                        <div class="table-responsive">
                            <table class="invoice-table">
                                <thead>
                                    <tr class="invoice-headings">
                                        <th>Kode Item</th>
                                        <th>Nama Item</th>
                                        <th>Kelompok Obat</th>
                                        <th>Stock</th>
                                        <th>Satuan</th>
                                        <th>Harga Jual</th>
                                        <th>Lokasi Rak</th>
                                        <th>Alert</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($dataobat as $v)
                                    <tr>
                                        <td>{{ $v['KodeItem'] }}</td>
                                        <td>{{ $v['NamaItem'] }}</td>
                                        <td>{{ $v['Kelompok'] }}</td>
                                        <td>{{ number_format($v['Stock']) }}</td>
                                        <td>{{ $v['Satuan'] }}</td>
                                        <td>{{ number_format($v['HargaJual']) }}</td>
                                        <td>{{ $v['LokasiRak'] }}</td>
                                        <td></td>
                                        
                                        
                                        <td>
                                            <a href="{{ url('dataobat/form/' . $v['KodeItem']) }}" class="btn btn-primary" data-toggle="tooltip" title="Edit Data Obat"> <i class="ion-ios-eye-outline"></i> Edit</a>

                                            <a href="{{ url('dataobat/detail/' . $v['KodeItem']) }}" class="btn btn-warning" data-toggle="tooltip" title="Detail"> <i class="ion-ios-eye-outline"></i> Detail</a>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <!--pagination starts-->
                        {{ $dataobat->links('pagination::bootstrap-4') }}
                        <!--pagination ends-->
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">

</script>
@endpush