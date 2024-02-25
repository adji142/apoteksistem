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
                                <li class="active"><a href="{{ route('shift') }}">Shift</a></li>

                                @if ($shift)
                                    <li>Edit Shift</li>
                                @else
                                    <li>Add Shift</li>
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
                        <h5><i class="ion-person"></i> Shift :</h5>
                    </div>
                    <div class="db-add-listing">
                        <div class="row">
                            
                            @if (count($shift) > 0)
                            <form action="{{route('shift-edit')}}" method="post">
                            @else
                            <form action="{{route('shift-store')}}" method="post">
                            @endif
                            
                            @csrf
                                <div class="col-md-12">
                                    <input type="hidden" name="from_page" id="from_page" value="backend">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Kode Shift</label>
                                                <input type="text" class="form-control filter-input" name="Kode" id="Kode" placeholder="Kode Shift" value="{{ count($shift) > 0 ? $shift[0]['Kode'] : '' }}" >
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Name Shift</label>
                                                <input type="text" class="form-control filter-input" name="Nama" placeholder="Nama Shift" value="{{ count($shift) > 0 ? $shift[0]['Nama'] : '' }}">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Mulai Bekerja</label>
                                                <input type="time" class="form-control filter-input" name="MulaiKerja" placeholder="Mulai Bekerja" value="{{ count($shift) > 0 ? $shift[0]['MulaiKerja'] : '' }}">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Selesai Bekerja</label>
                                                <input type="time" class="form-control filter-input" name="SelesaiKerja" placeholder="Selesai Bekerja" value="{{ count($shift) > 0 ? $shift[0]['SelesaiKerja'] : '' }}">
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
@include('master.Shift.Shift-js')
@endsection