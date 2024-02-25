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
                            </ul>
                        </div>
                    </div>
                    <a class="btn v3" href="{{ url('karyawan/form/0') }}"><i class="ion-plus-round"></i>Add Karyawan </a>
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
                        <h5><i class="ion-ios-people"></i> Karyawan</h5>
                    </div>
                    <div class="invoice-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form class="hero__form v2 filter" action="{{ route('karyawan') }}">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12">
                                            <input class="hero__form-input custom-select" type="text" name="keyword" id="keyword" placeholder="What are you looking for?">
                                        </div>
                                        <div class="col-lg-4 col-md-12">
                                            <select class="hero__form-input  custom-select" name="status">
                                                <option value="1">Aktif</option>
                                                <option value="0">Tidak Aktif</option>
                                                <option value="">Semua Status</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-2 col-md-12">
                                            <div class="submit_btn text-right md-left">
                                                <button class="btn v3  mar-right-5" type="submit"><i class="ion-ios-search" aria-hidden="true"></i> Search</button>
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
                                        <th>NIK</th>
                                        <th>Nama Karyawan</th>
                                        <th>No. Tlp</th>
                                        <th>Tanggal Bergabung</th>
                                        <th>Tanggal Resign</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($karyawan as $v)
                                    <tr>
                                        <td>{{ $v['NIK'] }}</td>
                                        <td>{{ $v['NamaKaryawan'] }}</td>
                                        <td>{{ $v['NoTlp'] }}</td>
                                        <td>{{ \Carbon\Carbon::parse($v['TanggalBergabung'])->format('d-m-Y') }}</td>
                                        <td>
                                            @if (is_null($v['TanggalResign']))
                                                <p>-</p>
                                            @else
                                                {{ \Carbon\Carbon::parse($v['TanggalResign'])->format('d-m-Y') }}
                                            @endif
                                        </td>
                                        
                                        <td>
                                            <a href="{{ url('karyawan/form/' . $v['NIK']) }}" class="btn btn-primary" data-toggle="tooltip" title="Edit Karyawan"> <i class="ion-ios-eye-outline"></i> Edit</a>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <!--pagination starts-->
                        {{ $karyawan->links('pagination::bootstrap-4') }}
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