@extends('layouts.head-app')

@section('content')
<div class="dash-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="db-add-list-wrap">
                    <div class="act-title">
                        <h5><i class="ion-person"></i> Setting Company :</h5>
                    </div>
                    <div class="db-add-listing">
                        <div class="row">
                            <form action="{{route('setting-store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Nama Apotek</label>
                                                <input type="text" class="form-control filter-input" name="NamaPartner" placeholder="Nama Apotek" value="{{ ($data) ? $data[0]['NamaPartner'] : '' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>SIA</label>
                                                <input type="text" class="form-control filter-input" name="SIA" placeholder="SIA" value="{{ ($data) ? $data[0]['SIA'] : '' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>SIPA</label>
                                                <input type="text" class="form-control filter-input" name="SIPA" placeholder="SIPA" value="{{ ($data) ? $data[0]['SIPA'] : '' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>No Tlp</label>
                                                <input type="text" class="form-control filter-input" name="NoTlp" placeholder="NoTlp" value="{{ ($data) ? $data[0]['NoTlp'] : '' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="list_info">Alamat</label>
                                                <textarea class="form-control" id="list_info" rows="4" name="Alamat" placeholder="Enter your text here">{{ ($data) ? $data[0]['Alamat'] : '' }}</textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Jenis Printer</label>
                                                <select class="form-control" name="PrinterType" id="PrinterType">
                                                	<option value="-1">-- Pilih Jenis Printer --</option>
                                                	<option value="1">USB</option>
                                                	<option value="2">Bluetoth</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Device ID</label>
                                                <select class="form-control" name="PrinterDeviceName" id="PrinterDeviceName">
                                                	<option value="0">-- Device --</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Perhitungan Harga Pokok</label>
                                                <select class="form-control" name="PerhitunganHargaPokok" id="PerhitunganHargaPokok">
                                                    <option value="-1">-- Pilih Perhitungan --</option>
                                                    <option value="1">Average</option>
                                                    <option value="2">FIFO</option>
                                                    <option value="3">LIFO</option>
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
@endsection