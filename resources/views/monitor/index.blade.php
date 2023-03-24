@extends('layouts.app')
@extends('layouts.navbar')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <p>Total Service Done</p>
                        <h3>{{ $servicedone->total() }}</h3>
                    </div>
                    <div class="icon">
                        <i class="fas fa-box"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <p>Total Service Pending</p>
                        <h3>{{ $servicepending->total() }}</h3>
                    </div>
                    <div class="icon">
                        <i class="fas fa-box-open"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <p>Total Kanibal</p>
                        <h3>{{ $kanibal->total() }}</h3>
                    </div>
                    <div class="icon">
                        <i class="fas fa-project-diagram"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
