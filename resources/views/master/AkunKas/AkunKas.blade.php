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
                                <li class="active"><a href="{{ route('akunkas') }}">Terapi Obat</a></li>
                            </ul>
                        </div>
                    </div>
                    <a class="btn v3" href="{{ url('akunkas/form/0') }}"><i class="ion-plus-round"></i>Add Terapi Obat </a>
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
                        <h5><i class="ion-ios-people"></i> Akun Biaya</h5>
                    </div>
                    <div class="invoice-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form class="hero__form v2 filter" action="{{ route('akunkas') }}">
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
                                        <th>ID</th>
                                        <th>Nama Akun</th>
                                        <th>Jenis Akun</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($akunkas as $v)
                                    <tr>
                                        <td>{{ $v['id'] }}</td>
                                        <td>{{ $v['NamaAkun'] }}</td>
                                        <td>
                                            <a href="{{ url('akunkas/form/' . $v['id']) }}" class="btn btn-primary" data-toggle="tooltip" title="Edit User"> <i class="ion-ios-eye-outline"></i> Edit</a>

                                            <a href="{{ route('akunkas-delete', $v['id']) }}" class="btn btn-danger" data-toggle="tooltip" title="Delete User" data-confirm-delete="true"> <i class="ion-android-delete"></i> Delete</a>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <!--pagination starts-->
                        {{ $akunkas->links('pagination::bootstrap-4') }}
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