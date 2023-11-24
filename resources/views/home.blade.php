@extends('layouts.app')
@extends('layouts.navbar')

@section('content')
    <div class="container">
        <div class="dashboard">

            <h1>Dashboard</h1>
        </div>
        <div class="row">
            <div class="col">
                <a href="/history" style="text-decoration: none">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <h3>History</h3>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col">

            </div>
            <div class="col">

            </div>
        </div>
    </div>
@endsection
