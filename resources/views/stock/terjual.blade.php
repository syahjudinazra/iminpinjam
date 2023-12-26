@extends('layouts.app')
@extends('layouts.navbar')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <h1 class="h3 mb-3 text-gray-800">Terjual Stocks</h1>
        </div>

        <!-- Edit Data Stock -->
        @foreach ($stockTerjual as $item)
            <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1"
                aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="POST" action="{{ route('stock.update', $item->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Edit Data Stocks</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="serialnumber" class="form-label"><b>Serial Number</b></label>
                                    <input type="text" class="form-control" id="serialnumber" name="serialnumber"
                                        value="{{ $item->serialnumber }}">
                                </div>
                                <div class="mb-3">
                                    <label for="tipe" class="form-label"><b>Tipe</b></label>
                                    <input type="text" class="form-control" id="tipe" name="tipe"
                                        value="{{ $item->tipe }}">
                                </div>
                                <div class="mb-3">
                                    <label for="noinvoice" class="form-label"><b>No Invoice</b></label>
                                    <input type="text" class="form-control" id="noinvoice" name="noinvoice"
                                        value="{{ $item->noinvoice }}">
                                </div>
                                <div class="mb-3">
                                    <label for="tanggalmasuk" class="form-label"><b>Tanggal Masuk</b></label>
                                    <input type="date" class="form-control" id="tanggalmasuk" name="tanggalmasuk"
                                        value="{{ $item->tanggalmasuk }}">
                                </div>
                                <div class="mb-3">
                                    <label for="tanggalkeluar" class="form-label"><b>Tanggal Keluar</b></label>
                                    <input type="date" class="form-control" id="tanggalkeluar" name="tanggalkeluar"
                                        value="{{ $item->tanggalkeluar }}">
                                </div>
                                <div class="mb-3">
                                    <label for="pelanggan" class="form-label"><b>Pelanggan</b></label>
                                    <input type="text" class="form-control" id="pelanggan" name="pelanggan"
                                        value="{{ $item->pelanggan }}">
                                </div>
                                <div class="form-group">
                                    <label><b>Status</b></label><br />
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="gudang" name="status"
                                            value="Gudang"
                                            {{ in_array('Gudang', explode(',', $item->status)) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="gudang">Gudang</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="service" name="status"
                                            value="Service"
                                            {{ in_array('Service', explode(',', $item->status)) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="service">Service</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="dipinjam" name="status"
                                            value="Dipinjam"
                                            {{ in_array('Dipinjam', explode(',', $item->status)) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="dipinjam">Dipinjam</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="terjual" name="status"
                                            value="Terjual"
                                            {{ in_array('Terjual', explode(',', $item->status)) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="terjual">Terjual</label>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
        <!-- end edit data -->

        <!-- delete data -->
        @foreach ($stockTerjual as $item)
            <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1"
                aria-labelledby="deleteModalLabel{{ $item->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel{{ $item->id }}">Delete Data Stocks</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete this Data?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <form action="{{ route('stock.destroy', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <!-- end delete data -->

    </div>
    <div class="container-fluid mt-3">
        <table id="hometable" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>Serial Number</th>
                    <th>Tipe</th>
                    <th>No Invoice</th>
                    <th>Tanggal Masuk</th>
                    <th>Tanggal Keluar</th>
                    <th>Pelanggan</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($stockTerjual as $item)
                    <tr>
                        <td>{{ $item->serialnumber }}</td>
                        <td>{{ $item->tipe }}</td>
                        <td>{{ $item->noinvoice }}</td>
                        <td>{{ $item->tanggalmasuk }}</td>
                        <td>{{ $item->tanggalkeluar }}</td>
                        <td>{{ $item->pelanggan }}</td>
                        <td>
                            <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-target="#editModal{{ $item->id }}" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>

                            <a href="#" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                data-target="#deleteModal{{ $item->id }}" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Delete"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>Serial Number</th>
                    <th>Tipe</th>
                    <th>No Invoice</th>
                    <th>Tanggal Masuk</th>
                    <th>Tanggal Keluar</th>
                    <th>Pelanggan</th>
                    <th>Action</th>
                </tr>
            </tfoot>
        </table>
    </div>
@endsection
