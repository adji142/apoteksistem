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
                                <li class="active"><a href="{{ route('lokasi') }}">Lokasi</a></li>

                                @if ($lokasi)
                                    <li>Edit Lokasi</li>
                                @else
                                    <li>Add Lokasi</li>
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
                        <h5><i class="ion-person"></i> Lokasi :</h5>
                    </div>
                    <div class="db-add-listing">
                        <div class="row">
                            
                            @if (count($lokasi) > 0)
                            <form action="{{route('lokasi-edit')}}" method="post">
                            @else
                            <form action="{{route('lokasi-store')}}" method="post">
                            @endif
                            
                            @csrf
                                <div class="col-md-12">
                                    <input type="hidden" name="from_page" id="from_page" value="backend">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Kode Lokasi</label>
                                                <input type="text" class="form-control filter-input" name="Kode" id="Kode" placeholder="Kode Lokasi" value="{{ count($lokasi) > 0 ? $lokasi[0]['Kode'] : '' }}" >
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Name Lokasi</label>
                                                <input type="text" class="form-control filter-input" name="Nama" placeholder="Nama Lokasi" value="{{ count($lokasi) > 0 ? $lokasi[0]['Nama'] : '' }}">
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
@include('master.Lokasi.Lokasi-js')
@endsection