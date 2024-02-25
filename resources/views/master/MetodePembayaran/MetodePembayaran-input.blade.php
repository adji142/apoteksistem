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
                                <li class="active"><a href="{{ route('metodepembayaran') }}">Metode Pembayaran</a></li>

                                @if ($metodepembayaran)
                                    <li>Edit Metode Pembayaran</li>
                                @else
                                    <li>Add Metode Pembayaran</li>
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
                        <h5><i class="ion-person"></i> MetodePembayaran :</h5>
                    </div>
                    <div class="db-add-listing">
                        <div class="row">
                            
                            @if ($metodepembayaran)
                            <form action="{{route('metodepembayaran-edit')}}" method="post">
                            @else
                            <form action="{{route('metodepembayaran-store')}}" method="post">
                            @endif

                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    {{ $error }}
                                @endforeach
                            @endif
                            
                            @csrf
                                <div class="col-md-12">
                                    <input type="hidden" name="id" id="id" value="{{ request()->id }}">
                                    <input type="hidden" name="from_page" id="from_page" value="backend">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Nama Metode Pembayaran *</label>
                                                <input type="text" class="form-control filter-input" name="NamaMetodePembayaran" id="NamaMetodePembayaran" placeholder="Nama Metode Pembayaran" value="{{ $metodepembayaran ? $metodepembayaran->NamaMetodePembayaran : '' }}" >
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Jenis Verifikasi *</label>
                                                <select class="form-control filter-input" id="JenisVerifikasi" name="JenisVerifikasi" style="display: none;">
                                                    <option value="1" {{ $metodepembayaran ? $metodepembayaran->JenisVerifikasi == '1' ? "selected" : '' :""}}>Manual</option>
                                                    <option value="2" {{ $metodepembayaran ? $metodepembayaran->JenisVerifikasi == '2' ? "selected" : '' :""}}>Auto</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div id="AfterMetodePembayaran" class="row">
                                            
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
@include('master.MetodePembayaran.MetodePembayaran-js')
@endsection