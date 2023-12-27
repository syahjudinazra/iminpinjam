@extends('layouts.app')
@extends('layouts.navbar')

@section('content')
    <div class="container-fluid">
        <div class="head-title">
            <h3>Firmware Content</h3>
        </div>
        @if (Auth::check())
            <div class="head-area">
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-target="#firmwaremodal">
                    <i class="fa-solid fa-plus"></i> Tambah Firmware
                </button>
            </div>
        @endif
    </div>

    <!-- Tambah Firmware -->
    <div class="modal fade" id="firmwaremodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Firmware</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="post" action="/firmware" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="tipe"><b>Tipe</b></label>
                            <input type="text" class="form-control" id="tipe" name="tipe"
                                placeholder="Masukan Tipe" required value="{{ old('tipe') }}">
                        </div>
                        <div class="form-group">
                            <label for="version"><b>Firmware Version</b></label>
                            <input type="text" class="form-control" id="version" name="version"
                                placeholder="Masukan Firmware Version" value="{{ old('version') }}">
                        </div>
                        <div class="form-group">
                            <label for="android"><b>Android</b></label>
                            <input type="text" class="form-control" id="android" name="android"
                                placeholder="Masukan Android" value="{{ old('android') }}">
                        </div>
                        <div class="form-group">
                            <label for="flash"><b>URL Flash</b></label>
                            <input type="text" class="form-control" id="flash" name="flash"
                                placeholder="Masukan URL Flash" value="{{ old('flash') }}">
                        </div>
                        <div class="form-group">
                            <label for="ota"><b>URL OTA</b></label>
                            <input type="text" class="form-control" id="ota" name="ota"
                                placeholder="Masukan URL OTA" value="{{ old('ota') }}">
                        </div>
                        <div class="form-group">
                            <label for="kategori"><b>Kategori</b></label><br />
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="desktop" name="kategori[]"
                                    value="Desktop">
                                <label class="form-check-label" for="desktop">Desktop</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="mobile" name="kategori[]"
                                    value="Mobile">
                                <label class="form-check-label" for="mobile">Mobile</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="kiosk" name="kategori[]"
                                    value="KIOSK">
                                <label class="form-check-label" for="kiosk">KIOSK</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="gambar" class="form-label"><b>Gambar</b></label>
                            <input class="form-control" type="file" id="gambar" name="gambar">
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

    <!-- Edit Firmware -->
    @foreach ($firmware as $item)
        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1"
            aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="{{ route('firmware.update', $item->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Edit Data Firmware</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="tipe" class="form-label"><b>Tipe</b></label>
                                <input type="text" class="form-control" id="tipe" name="tipe"
                                    value="{{ $item->tipe }}">
                            </div>
                            <div class="mb-3">
                                <label for="version" class="form-label"><b>Firmware Version</b></label>
                                <input type="text" class="form-control" id="version" name="version"
                                    value="{{ $item->version }}">
                            </div>
                            <div class="mb-3">
                                <label for="android" class="form-label"><b>Android</b></label>
                                <input type="text" class="form-control" id="android" name="android"
                                    value="{{ $item->android }}">
                            </div>
                            <div class="mb-3">
                                <label for="flash" class="form-label"><b>URL Flash</b></label>
                                <input type="text" class="form-control" id="flash" name="flash"
                                    value="{{ $item->flash }}">
                            </div>
                            <div class="mb-3">
                                <label for="ota" class="form-label"><b>OTA</b></label>
                                <input type="text" class="form-control" id="ota" name="ota"
                                    value="{{ $item->ota }}">
                            </div>
                            <div class="form-group">
                                <label><b>Kategori</b></label><br />
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="desktop" name="kategori"
                                        value="Desktop"
                                        {{ in_array('Desktop', explode(',', $item->kategori)) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="desktop">Desktop</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="mobile" name="kategori"
                                        value="Mobile"
                                        {{ in_array('Mobile', explode(',', $item->kategori)) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="mobile">Mobile</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="kiosk" name="kategori"
                                        value="KIOSK"
                                        {{ in_array('KIOSK', explode(',', $item->kategori)) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="kiosk">KIOSK</label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="gambar" class="form-label"><b>Gambar</b></label><br>
                                <input class="form-control" type="file" id="gambar" name="gambar">
                                {{-- <img src="{{ asset('storage/gambar/'.$item->gambar) }}" width= '60' height='60' class="img img-responsive"> --}}
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

    <!-- delete data -->
    @foreach ($firmware as $item)
        <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1"
            aria-labelledby="deleteModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel{{ $item->id }}">Delete Data Firmware</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this Data?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <form action="{{ route('firmware.destroy', $item->id) }}" method="POST">
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

    <!-- Table Firmware -->
    <div class="container-fluid mt-3">
        <table id="secondTable" class="table table-striped table-bordered nowrap" style="width:100%">
            <thead>
                <th>No</th>
                <th>Tipe</th>
                <th>Firmware Version</th>
                <th>Android</th>
                <th>Flash</th>
                <th>OTA</th>
                <th>Kategori</th>
                <th>Gambar</th>
                <th>Action</th>
            </thead>
            <tbody>
                @empty($firmware)
                    <tr>
                        <td colspan="6">No data found</td>
                    </tr>
                @else
                    @foreach ($firmware as $item)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $item->tipe }}</td>
                            <td>{{ $item->version }}</td>
                            <td>{{ $item->android }}</td>
                            <td style="white-space: normal;">{{ $item->flash }}</td>
                            <td style="white-space: normal;">{{ $item->ota }}</td>
                            <td>{{ $item->kategori }}</td>
                            <td>
                                <img src="{{ url('/storage/gambar/' . $item->gambar) }}" width= '60' height='60'
                                    class="img img-responsive" />
                            </td>
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
                @endempty
            </tbody>
        </table>
    </div>
@endsection
