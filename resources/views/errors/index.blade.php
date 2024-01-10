@extends('layouts.app')
@extends('layouts.navbar')

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-md-2 text-center">
                <p><i class="fa fa-exclamation-triangle fa-5x"></i><br />Status Code: 403</p>
            </div>
            <div class="col-md-10">
                <h3>OPPSSS!!!! Sorry...</h3>
                <p>{{ $exception }}</p>
                <a class="btn btn-danger" href="javascript:history.back()">Go Back</a>
            </div>
        </div>
    </div>
@endsection
