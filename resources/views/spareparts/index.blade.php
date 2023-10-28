@extends('layouts.app')
@extends('layouts.navbar')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <h1 class="h3 mb-3 text-gray-800">Spare Parts</h1>
            @if (Auth::check())
                <div class="head-area">
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#sparepartmodal">
                        <i class="fa-solid fa-plus"></i> Tambah
                    </button>
                </div>
            @endif
            <div class="buttonarea d-flex gap-3 justify-content-end mb-3">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importModal">
                    Import Excel
                </button>
                <a href="{{ route('export.spareparts') }}" class="btn btn-success float-end">Export Excel</a>
            </div>
        </div>
    </div>

    <!-- Import Excel Modal -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="width: auto">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('import.spareparts') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="d-flex justify-content-center">
                            <input type="file" name="file" id="file" class="form-control" style="width: auto">
                        </div>
                        <a href="{{ route('download.template', ['filename' => 'templateexcelimport.xlsx']) }}"
                            class="d-flex justify-content-center">Download
                            template</a>
                        {{-- <button id="previewButton">Preview Excel File</button> --}}
                        <div class="table table-bordered mt-2" id="preview"></div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-success">Submit</button>
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
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="post" action="/spareparts" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nospareparts"><b>No Spare Parts</b></label>
                            <input type="text" class="form-control" id="nospareparts" name="nospareparts"
                                placeholder="Masukan Nomor Spare Parts" required value="{{ old('nospareparts') }}">
                        </div>
                        <div class="form-group">
                            <label for="tipe"><b>Tipe</b></label>
                            <input type="text" class="form-control" id="tipe" name="tipe"
                                placeholder="Masukan Nama Tipe" value="{{ old('tipe') }}">
                        </div>
                        <div class="form-group">
                            <label for="nama"><b>Nama</b></label>
                            <input type="text" class="form-control" id="nama" name="nama"
                                placeholder="Masukan Nama" value="{{ old('nama') }}">
                        </div>
                        <div class="form-group">
                            <label for="quantity"><b>Quantity</b></label>
                            <input type="number" class="form-control" id="quantity" name="quantity"
                                placeholder="Masukan Quantity" value="{{ old('quantity') }}">
                        </div>
                        <div class="form-group">
                            <label for="harga"><b>Harga</b></label>
                            <input type="number" class="form-control" id="harga" name="harga"
                                placeholder="Masukan Harga" value="{{ old('harga') }}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Tambah</button>
                    </div>
                </form>
            </div>
            <!-- End Tambah Data -->
        </div>
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
                            <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Edit Data Quantity</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                                    value="{{ $item->quantity }}">
                            </div>
                            <div class="mb-3">
                                <label for="harga" class="form-label"><b>Harga</b></label>
                                <input type="number" class="form-control" id="harga" name="harga"
                                    value="{{ $item->harga }}">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
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
                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>
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
                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>
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
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this Data?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
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
        <table id="hometable" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>No Spare Parts</th>
                    <th>Tipe</th>
                    <th>Nama</th>
                    <th>Quantity</th>
                    <th>Harga</th>
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
                        <td>{{ $item->harga }}</td>
                        <td>
                            <a href="#" class="btn btn-warning" data-toggle="modal"
                                data-target="#editModalQuantityReduce{{ $item->id }}" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Quantity"><i class="fa-solid fa-minus"></i></a>

                            <a href="#" class="btn btn-success" data-toggle="modal"
                                data-target="#editModalQuantity{{ $item->id }}" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Quantity"><i class="fa-solid fa-plus"></i></a>

                            <a href="#" class="btn btn-primary" data-toggle="modal"
                                data-target="#editModal{{ $item->id }}" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>

                            <a href="#" class="btn btn-danger" data-toggle="modal"
                                data-target="#deleteModal{{ $item->id }}" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Delete"><i class="fa-solid fa-trash"></i></a>
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
                    <th>Harga</th>
                </tr>
            </tfoot>
        </table>
    </div>
@endsection
