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
                            </ul>
                        </div>
                    </div>
                    <a class="btn v3" href="{{ url('lokasi/form/0') }}"><i class="ion-plus-round"></i>Add Lokasi </a>
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
                        <h5><i class="ion-ios-people"></i> Lokasi</h5>
                    </div>
                    <div class="invoice-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form class="hero__form v2 filter" action="{{ route('lokasi') }}">
                                    <div class="row">
                                        <div class="col-lg-10 col-md-12">
                                            <input class="hero__form-input custom-select" type="text" name="keyword" id="keyword" placeholder="What are you looking for?">
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
                                        <th>Kode</th>
                                        <th>Nama</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lokasi as $v)
                                    <tr>
                                        <td>{{ $v['Kode'] }}</td>
                                        <td>{{ $v['Nama'] }}</td>
                                        
                                        <td>
                                            <a href="{{ url('lokasi/form/' . $v['Kode']) }}" class="btn btn-primary" data-toggle="tooltip" title="Edit Lokasi"> <i class="ion-ios-eye-outline"></i> Edit</a>

                                            <a href="{{ route('lokasi-delete', $v['Kode']) }}" class="btn btn-danger" data-toggle="tooltip" title="Delete Lokasi" data-confirm-delete="true"> <i class="ion-android-delete"></i> Delete</a>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <!--pagination starts-->
                        {{ $lokasi->links('pagination::bootstrap-4') }}
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