@extends('layouts.app')
@extends('layouts.navbar')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="d-flex justify-content-between align-items-center">
            <div class="head-title">
                <h3>Firmware</h3>
            </div>
            @auth
                @if (auth()->user()->hasRole('superadmin') ||
                        auth()->user()->hasRole('jeffri'))
                    <div class="edit-firmware">
                        <a href="/firmware/table" class="btn btn-primary"><i class="fas fa-table"></i>
                            Edit
                        </a>

                        <a href="#" class="btn btn-success" data-toggle="modal" data-target="#importModal"><i class="fas fa-file-import"></i> Import</a>
                    </div>
                @endif
            @endauth
        </div>
        <!-- Import Firmware Modal -->
        <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Import Excel</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('firmware.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="d-flex justify-content-center">
                                <input type="file" name="inputFirmware" id="inputFirmware" class="form-control shadow-none"
                                    style="width: auto">
                            </div>
                            <a href="{{ route('template.firmware', ['filename' => 'TemplateImportFirmware.xlsx']) }}"
                                class="d-flex justify-content-center text-decoration-none">Download
                                template</a>
                            <div class="table table-bordered mt-2" id="preview"></div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button id="importButton" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Firmware -->
        @foreach ($d4 as $item)
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
                                    <input class="form-check-input mt-1" type="radio" id="desktop" name="kategori"
                                        value="Desktop"
                                        {{ in_array('Desktop', explode(',', $item->kategori)) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="desktop">Desktop</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input mt-1" type="radio" id="mobile" name="kategori"
                                        value="Mobile"
                                        {{ in_array('Mobile', explode(',', $item->kategori)) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="mobile">Mobile</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input mt-1" type="radio" id="kiosk" name="kategori"
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
        @foreach ($d4 as $item)
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
        <div class="d-flex mb-4 mt-4" id="wrapper">
            <div class="bg-light border-right" id="sidebar-wrapper">
                @include('firmware.sidebar')
            </div>
            <div id="firmwares-content" class="container-fluid">
                <table id="firmwareTable" class="table table-striped table-bordered nowrap" style="width:100%">
                            <thead>
                                <th>Model</th>
                                <th>Android</th>
                                <th>Version</th>
                                <th>Flash</th>
                                <th>OTA</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @empty($d4)
                                    <tr>
                                        <td colspan="6">No data found</td>
                                    </tr>
                                @else
                                    @foreach ($d4 as $item)
                                        <tr>
                                            <td>{{ $item->tipe }}</td>
                                            <td>{{ $item->android }}</td>
                                            <td>{{ $item->version }}</td>
                                            @if ($item->flash)
                                            <td> <a href="{{ $item->flash }}"
                                                class="btn btn-success btn-sm" target="__blank">Download</a></td>
                                            @else
                                                <td></td>
                                            @endif

                                            @if($item->ota)
                                                <td>
                                                    <a href="{{ $item->ota }}" class="btn btn-secondary btn-sm" target="__blank">Download</a>
                                                </td>
                                            @else
                                                <td></td>
                                            @endif
                                            @auth
                                            @if (auth()->user()->hasRole('superadmin') || auth()->user()->hasRole('jeffri'))
                                                <td>
                                                    <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                       data-target="#editModal{{ $item->id }}" data-bs-toggle="tooltip"
                                                       data-bs-placement="top" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>

                                                    <a href="#" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                       data-target="#deleteModal{{ $item->id }}" data-bs-toggle="tooltip"
                                                       data-bs-placement="top" title="Delete"><i class="fa-solid fa-trash"></i></a>
                                                </td>
                                            @else
                                                <td></td>
                                            @endif
                                        @endauth
                                        </tr>
                                    @endforeach
                                @endempty
                            </tbody>
                            <tfoot>
                                <th>Model</th>
                                <th>Android</th>
                                <th>Version</th>
                                <th>Flash</th>
                                <th>OTA</th>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
