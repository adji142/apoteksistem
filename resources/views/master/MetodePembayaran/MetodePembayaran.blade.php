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
                            </ul>
                        </div>
                    </div>
                    <a class="btn v3" href="{{ url('metodepembayaran/form/0') }}"><i class="ion-plus-round"></i>Add Metode Pembayaran </a>
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
                        <h5><i class="ion-ios-people"></i> Metode Pembayaran</h5>
                    </div>
                    <div class="invoice-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form class="hero__form v2 filter" action="{{ route('metodepembayaran') }}">
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
                                        <th>Nama Metode</th>
                                        <th>Jenis Metode</th>
                                        <th>No. Acct</th>
                                        <th>Nama Pemilik Acct</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($metodepembayaran as $v)
                                    <tr>
                                        <td>{{ $v['NamaMetodePembayaran'] }}</td>
                                        @if ($v['JenisVerifikasi'] == "1")
                                            <li>MANUAL</li>
                                        @else
                                            <li>AUTO</li>
                                        @endif
                                        <td>{{ $v['AcctNumber'] }}</td>
                                        <td>{{ $v['AcctName'] }}</td>
                                        
                                        <td>
                                            <a href="{{ url('metodepembayaran/form/' . $v['id']) }}" class="btn btn-primary" data-toggle="tooltip" title="Edit MetodePembayaran"> <i class="ion-ios-eye-outline"></i> Edit</a>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <!--pagination starts-->
                        {{ $metodepembayaran->links('pagination::bootstrap-4') }}
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