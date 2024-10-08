@extends('layouts.app')
@extends('layouts.navbar')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <h1 class="h3 mb-3 text-gray-800">Spare Parts</h1>
            @auth
                @if (auth()->user()->hasRole('superadmin') || auth()->user()->hasRole('jeffri'))
                    <div class="head-area">
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-target="#sparepartmodal">
                            <i class="fa-solid fa-plus"></i> Tambah
                        </button>
                    </div>

                    <div class="buttonarea d-flex gap-3 justify-content-end mb-3">
                        <button type="button" class="btn btn-success text-white" data-bs-toggle="modal"
                            data-target="#importModal"><i class="fa-solid fa-file-import" style="color: #ffffff;"></i>
                            Import Excel
                        </button>
                        <a href="{{ route('export.spareparts') }}" class="btn btn text-white float-end"
                            style="background-color: #F05025"><i class="fa-solid fa-download" style="color: #ffffff;"></i>
                            Export
                            Excel</a>
                    </div>
                @endif
            @endauth
        </div>
    </div>

    <!-- Import Excel Modal -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Import Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('import.spareparts') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="d-flex justify-content-center">
                            <input type="file" name="inputSpareParts" id="inputSpareParts" class="form-control"
                                style="width: auto">
                        </div>
                        <a href="{{ route('download.template', ['filename' => 'templateexcelimport.xlsx']) }}"
                            class="d-flex justify-content-center">Download
                            template</a>
                        <div class="table table-bordered mt-2" id="preview"></div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button id="importButton" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Tambah Data -->
    <div class="modal fade" id="sparepartmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Spare Parts</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="post" action="/spareparts" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="font-weight-bold" for="nospareparts">No Spare Parts</label>
                            <input type="text" class="form-control" id="nospareparts" name="nospareparts"
                                placeholder="Masukan Nomor Spare Parts" required value="{{ old('nospareparts') }}">
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold" for="tipe">Tipe</label>
                            <input type="text" class="form-control" id="tipe" name="tipe"
                                placeholder="Masukan Nama Tipe" value="{{ old('tipe') }}">
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold" for="nama">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama"
                                placeholder="Masukan Nama" value="{{ old('nama') }}">
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold" for="quantity">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" min="0"
                                placeholder="Masukan Quantity" value="{{ old('quantity') }}">
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold" for="harga">Harga</label>
                            <input type="number" class="form-control" id="harga" name="harga"
                                placeholder="Masukan Harga" value="{{ old('harga') }}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Tambah</button>
                    </div>
                </form>
            </div>
            <!-- End Tambah Data -->
        </div>
    </div>

    <!-- add edit Data -->
    @foreach ($spareParts as $item)
        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1"
            aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="{{ route('spareparts.update', $item->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Edit Data SpareParts</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="nospareparts" class="form-label"><b>No Spare Parts</b></label>
                                <input type="text" class="form-control" id="nospareparts" name="nospareparts"
                                    value="{{ $item->nospareparts }}">
                            </div>
                            <div class="mb-3">
                                <label for="tipe" class="form-label"><b>Tipe</b></label>
                                <input type="text" class="form-control" id="tipe" name="tipe"
                                    value="{{ $item->tipe }}">
                            </div>
                            <div class="mb-3">
                                <label for="nama" class="form-label"><b>Nama</b></label>
                                <input type="text" class="form-control" id="nama" name="nama"
                                    value="{{ $item->nama }}">
                            </div>
                            <div class="mb-3">
                                <label for="quantity" class="form-label"><b>Quantity</b></label>
                                <input type="number" class="form-control" id="quantity" name="quantity"
                                    min="0" value="{{ $item->quantity }}">
                            </div>
                            <div class="mb-3">
                                <label for="harga" class="form-label"><b>Harga</b></label>
                                <input type="number" class="form-control" id="harga" name="harga"
                                    value="{{ $item->harga }}">
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

    <!-- add Quantity -->
    @foreach ($spareParts as $item)
        <div class="modal fade" id="editModalQuantity{{ $item->id }}" tabindex="-1"
            aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Quantity</h5>
                    </div>
                    <form method="POST" action="{{ route('update.quantity', ['id' => $item->id]) }}">
                        @csrf
                        <div class="modal-body d-flex justify-content-center">
                            <input class="addquan text-center" type="number" id="quantity" name="quantity">
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Cancel</button>
                            <button class="btn btn-success btn-sm mb-1" type="submit" name="add">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
    <!-- end Quantity -->

    <!-- reduce Quantity -->
    @foreach ($spareParts as $item)
        <div class="modal fade" id="editModalQuantityReduce{{ $item->id }}" tabindex="-1"
            aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Kurangi Quantity</h5>
                    </div>
                    <form method="POST" action="{{ route('update.quantity', ['id' => $item->id]) }}">
                        @csrf
                        <div class="modal-body d-flex justify-content-center">
                            <input class="minusquan text-center" type="number" id="quantity" name="quantity">
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Cancel</button>
                            <button class="btn btn-success btn-sm mb-1" type="submit" name="reduce">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
    <!-- end reduce Quantity -->

    <!-- delete data -->
    @foreach ($spareParts as $item)
        <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1"
            aria-labelledby="deleteModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel{{ $item->id }}">Delete Data Spare Parts</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this Data?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <form action="{{ route('spareparts.destroy', $item->id) }}" method="POST">
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

    <div class="container-fluid mt-3">
        <div class="overflow-auto">
            <table id="hometable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>No Spare Parts</th>
                        <th>Tipe</th>
                        <th>Nama</th>
                        <th>Quantity</th>
                        <th>Harga (Rp)</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($spareParts as $item)
                        <tr>
                            <td>{{ $item->nospareparts }}</td>
                            <td>{{ $item->tipe }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format((float) $item->harga, 0, ',', '.') }}</td>
                            <td>
                                @auth
                                    @if (auth()->user()->hasRole('superadmin') || auth()->user()->hasRole('jeffri'))
                                        <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-target="#editModalQuantityReduce{{ $item->id }}"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Quantity"><i
                                                class="fa-solid fa-minus"></i></a>

                                        <a href="#" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                            data-target="#editModalQuantity{{ $item->id }}" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Quantity"><i class="fa-solid fa-plus"></i></a>

                                        <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                            data-target="#editModal{{ $item->id }}" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Edit"><i
                                                class="fa-solid fa-pen-to-square"></i></a>

                                        <a href="#" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-target="#deleteModal{{ $item->id }}" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Delete"><i class="fa-solid fa-trash"></i></a>
                                    @endif
                                @endauth
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>No Spare Parts</th>
                        <th>Tipe</th>
                        <th>Nama</th>
                        <th>Quantity</th>
                        <th>Harga (Rp)</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('js/importSpareparts.js') }}"></script>
@endpush
