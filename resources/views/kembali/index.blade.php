@extends('layouts.app')
@extends('layouts.navbar')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Barang dikembalikan</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> Generate Excel</a>
    </div>
</div>
<div class="container-fluid mt-3">
    <table class="table">
        <thead class="table-dark">
          <th>Tanggal</th>
          <th>Serial Number</th>
          <th>Tipe Device</th>
          <th>Customer</th>
          <th>Action</th>
        </thead>
        <tbody>
          <td>test</td>
          <td>test</td>
          <td>test</td>
          <td>test</td>
          <td>test</td>
        </tbody>
      </table>
</div>
@endsection
