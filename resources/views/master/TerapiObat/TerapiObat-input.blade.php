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
                                <li class="active"><a href="{{ route('terapiobat') }}">Terapi Obat</a></li>

                                @if ($terapi)
                                    <li>Edit Terapi Obat</li>
                                @else
                                    <li>Add Terapi Obat</li>
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
                        <h5><i class="ion-person"></i> Terapi Obat :</h5>
                    </div>
                    <div class="db-add-listing">
                        <div class="row">
                            
                            @if ($terapi)
                            <form action="{{route('terapiobat-edit')}}" method="post">
                            @else
                            <form action="{{route('terapiobat-store')}}" method="post">
                            @endif
                            
                            @csrf
                                <div class="col-md-12">
                                    <input type="hidden" name="id" id="id" value="{{ request()->id }}">
                                    <input type="hidden" name="from_page" id="from_page" value="backend">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Name Terapi</label>
                                                <input type="text" class="form-control filter-input" name="Nama" placeholder="Nama Terapi" value="{{ ($terapi) ? $terapi->Nama : '' }}">
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