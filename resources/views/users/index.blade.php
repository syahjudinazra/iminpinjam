@extends('layouts.app')
@extends('layouts.navbar')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="head-user">
                <h1>User Settings Page</h1>
                <div class="btn btn-danger">
                    Tambah Users
                </div>
            </div>
        </div>

        <div style="overflow: auto">
            <table id="secondTable" class="table table-striped table-bordered nowrap" style="width:100%">
                <thead>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Role</th>
                    <th>Permissions</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Azra</td>
                        <td>superadmin</td>
                        <td>all</td>
                        <td>action</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
