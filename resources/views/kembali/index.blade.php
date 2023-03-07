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
    <table class="table table-striped table-hover">
        <thead class="table-dark">
          <th>No</th>
          <th>Tanggal</th>
          <th>Gambar</th>
          <th>Serial Number</th>
          <th>Tipe Device</th>
          <th>Customer</th>
          <th>Action</th>
        </thead>
        <tbody>
    @foreach ($kembali as $item)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item->tanggal }}</td>
        <td>
            <img src="{{ asset($item->gambar) }}" width= '60' height='60' class="img img-responsive" />
        </td>
        <td>{{ $item->serialnumber }}</td>
        <td>{{ $item->device }}</td>
        <td>{{ $item->customer }}</td>
        <td>

                <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#editModal{{ $item->id }}"><i class="fa-solid fa-pen-to-square"></i></a>

                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#viewModal{{ $item->id }}"><i class="fa-solid fa-eye"></i></a>

                <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal{{ $item->id }}"><i class="fa-solid fa-trash"></i></a>

                <a href="#" class="btn btn-success" data-toggle="modal" data-target="#"><i class="fa-solid fa-paper-plane"></i></a>


        </td>
    </tr>
    @endforeach
        </tbody>
      </table>
</div>
@endsection
