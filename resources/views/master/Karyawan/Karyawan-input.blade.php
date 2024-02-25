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
                                <li class="active"><a href="{{ route('karyawan') }}">Karyawan</a></li>

                                @if ($karyawan)
                                    <li>Edit Karyawan</li>
                                @else
                                    <li>Add Karyawan</li>
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
                        <h5><i class="ion-person"></i> Karyawan :</h5>
                    </div>
                    <div class="db-add-listing">
                        <div class="row">
                            
                            @if (count($karyawan) > 0)
                            <form action="{{route('karyawan-edit')}}" method="post">
                            @else
                            <form action="{{route('karyawan-store')}}" method="post">
                            @endif

                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    {{ $error }}
                                @endforeach
                            @endif
                            
                            @csrf
                                <div class="col-md-12">
                                    <input type="hidden" name="from_page" id="from_page" value="backend">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Nomor Induk Karyawan *</label>
                                                <input type="text" class="form-control filter-input" name="NIK" id="NIK" placeholder="Nomor Induk Karyawan" value="{{ count($karyawan) > 0 ? $karyawan[0]['NIK'] : '' }}" >
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Nama Karyawan *</label>
                                                <input type="text" class="form-control filter-input" name="NamaKaryawan" placeholder="Nama Karyawan" value="{{ count($karyawan) > 0 ? $karyawan[0]['NamaKaryawan'] : '' }}">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Jenis Kelamin *</label>
                                                <select class="form-control filter-input" name="JenisKelamin" style="display: none;">
                                                    <option value="L" {{ count($karyawan) > 0 ? $karyawan[0]['JenisKelamin'] == 'L' ? "selected" : '' :""}}>Laki - Laki</option>
                                                    <option value="P" {{ count($karyawan) > 0 ? $karyawan[0]['JenisKelamin'] == 'P' ? "selected" : '' :""}}>Permpuan</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tempat Lahir *</label>
                                                <input type="text" class="form-control filter-input" name="TempatLahir" placeholder="Tempat Lahir" value="{{ count($karyawan) > 0 ? $karyawan[0]['TempatLahir'] : '' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tanggal Lahir *</label>
                                                <input type="date" class="form-control filter-input" name="TanggalLahir" placeholder="Tanggal Lahir" value="{{ count($karyawan) > 0 ? $karyawan[0]['TanggalLahir'] : '' }}">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>No. Tlp *</label>
                                                <input type="number" class="form-control filter-input" name="NoTlp" placeholder="No. Tlp" value="{{ count($karyawan) > 0 ? $karyawan[0]['NoTlp'] : '' }}">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Alamat</label>
                                                <textarea class="form-control" id="Alamat" rows="4" name="Alamat" placeholder="Enter your Address hire">{{ count($karyawan) > 0 ? $karyawan[0]['karyawan'] : '' }}</textarea>
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tempat Bergabung *</label>
                                                <input type="date" class="form-control filter-input" name="TanggalBergabung" placeholder="Tempat Lahir" value="{{ count($karyawan) > 0 ? $karyawan[0]['TanggalBergabung'] : '' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tanggal Resign</label>
                                                <input type="date" class="form-control filter-input" name="TanggalResign" placeholder="Tanggal Lahir" value="{{ count($karyawan) > 0 ? $karyawan[0]['TanggalResign'] : '' }}">
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
@include('master.Karyawan.Karyawan-js')
@endsection