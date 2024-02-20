@extends('layouts.app')
@extends('layouts.navbar')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <h1>Antrian Stock</h1>
        </div>
    </div>

    <!-- Edit Data -->
    @foreach ($antrianStock as $item)
        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1"
            aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="{{ route('service.update', $item->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Edit Data</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="font-weight-bold">Pemilik</label><br />
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input mt-1" type="radio" id="stock" name="pemilik"
                                        value="stock"
                                        {{ in_array('stock', explode(',', $item->pemilik)) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="stock">Stock</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input mt-1" type="radio" id="customer" name="pemilik"
                                        value="customer"
                                        {{ in_array('customer', explode(',', $item->pemilik)) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="customer">Customer</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="pelanggan" class="form-label font-weight-bold">Pelanggan</label>
                                <input type="text" class="form-control shadow-none" id="pelanggan" name="pelanggan"
                                    value="{{ $item->pelanggan }}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="device"><b>Tipe Device</b></label>
                                <select class="form-select form-control-chosen" name="device" id="device" required>
                                    <option value="Null">Pilih Tipe Device</option>
                                    <option value="D1" {{ $item->device == 'D1' ? 'selected' : '' }}>D1</option>
                                    <option value="D1-Pro" {{ $item->device == 'D1-Pro' ? 'selected' : '' }}>D1-Pro</option>
                                    <option value="D1w" {{ $item->device == 'D1w' ? 'selected' : '' }}>D1w</option>
                                    <option value="D1w-702" {{ $item->device == 'D1w-702' ? 'selected' : '' }}>D1w-702
                                    </option>
                                    <option value="D2-402" {{ $item->device == 'D2-402' ? 'selected' : '' }}>D2-402
                                    </option>
                                    <option value="D3-501" {{ $item->device == 'D3-501' ? 'selected' : '' }}>D3-501
                                    </option>
                                    <option value="D3-503" {{ $item->device == 'D3-503' ? 'selected' : '' }}>D3-503
                                    </option>
                                    <option value="D3-504" {{ $item->device == 'D3-504' ? 'selected' : '' }}>D3-504
                                    </option>
                                    <option value="D3-504 Lama" {{ $item->device == 'D3-504 Lama' ? 'selected' : '' }}>
                                        D3-504 Lama
                                    </option>
                                    <option value="D3-505" {{ $item->device == 'D3-505' ? 'selected' : '' }}>D3-505
                                    </option>
                                    <option value="D3-505 Lama" {{ $item->device == 'D3-505 Lama' ? 'selected' : '' }}>
                                        D3-505 Lama
                                    </option>
                                    <option value="D3-506" {{ $item->device == 'D3-506' ? 'selected' : '' }}>D3-506
                                    </option>
                                    <option value="D3-506 Lama" {{ $item->device == 'D3-506 Lama' ? 'selected' : '' }}>
                                        D3-506 Lama
                                    </option>
                                    <option value="D4-502" {{ $item->device == 'D4-502' ? 'selected' : '' }}>D4-502
                                    </option>
                                    <option value="D4-503" {{ $item->device == 'D4-503' ? 'selected' : '' }}>D4-503
                                    </option>
                                    <option value="D4-504" {{ $item->device == 'D4-504' ? 'selected' : '' }}>D4-504
                                    </option>
                                    <option value="D4-505" {{ $item->device == 'D4-505' ? 'selected' : '' }}>D4-505
                                    </option>
                                    <option value="K1-101" {{ $item->device == 'K1-101' ? 'selected' : '' }}>K1-101
                                    </option>
                                    <option value="K2-201" {{ $item->device == 'K2-201' ? 'selected' : '' }}>K2-201
                                    </option>
                                    <option value="M2-202" {{ $item->device == 'M2-202' ? 'selected' : '' }}>M2-202
                                    </option>
                                    <option value="M2-203" {{ $item->device == 'M2-203' ? 'selected' : '' }}>M2-203
                                    </option>
                                    <option value="M2 Pro" {{ $item->device == 'M2 Pro' ? 'selected' : '' }}>M2 Pro
                                    </option>
                                    <option value="M2 Max" {{ $item->device == 'M2 Max' ? 'selected' : '' }}>M2 Max
                                    </option>
                                    <option value="S1-701" {{ $item->device == 'S1-701' ? 'selected' : '' }}>S1-701
                                    </option>
                                    <option value="Swan 1" {{ $item->device == 'Swan 1' ? 'selected' : '' }}>Swan 1
                                    </option>
                                    <option value="Swan 1K" {{ $item->device == 'Swan 1K' ? 'selected' : '' }}>Swan 1K
                                    </option>
                                    <option value="Swan 1 Pro" {{ $item->device == 'Swan 1 Pro' ? 'selected' : '' }}>Swan 1
                                        Pro</option>
                                    <option value="Swift 1" {{ $item->device == 'Swift 1' ? 'selected' : '' }}>Swift 1
                                    </option>
                                    <option value="Swift 1 Pro" {{ $item->device == 'Swift 1 Pro' ? 'selected' : '' }}>
                                        Swift 1 Pro</option>
                                    <option value="Swift 2" {{ $item->device == 'Swift 2' ? 'selected' : '' }}>Swift 2
                                    </option>
                                    <option value="Swift 2 Pro" {{ $item->device == 'Swift 2 Pro' ? 'selected' : '' }}>
                                        Swift 2 Pro</option>
                                    <option value="Falcon 1" {{ $item->device == 'Falcon 1' ? 'selected' : '' }}>Falcon 1
                                    </option>
                                    <option value="Crane 1 16" {{ $item->device == 'Crane 1 16' ? 'selected' : '' }}>Crane
                                        1 16</option>
                                    <option value="Crane 1 21.5" {{ $item->device == 'Crane 1 21.5' ? 'selected' : '' }}>
                                        Crane 1 21.5</option>
                                    <option value="Crane 1 27" {{ $item->device == 'Crane 1 27' ? 'selected' : '' }}>Crane
                                        1 27</option>
                                    <option value="Crane 1 32" {{ $item->device == 'Crane 1 32' ? 'selected' : '' }}>Crane
                                        1 32</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="serialnumber" class="form-label font-weight-bold">Serial Number</label>
                                <input type="text" class="form-control shadow-none" id="serialnumber" name="serialnumber"
                                    value="{{ $item->serialnumber }}">
                            </div>
                            <div class="form-group mb-3">
                                <label class="font-weight-bold" for="pemakaian">Pemakaian</label>
                                <select class="form-select shadow-none" id="pemakaian" name="pemakaian"
                                    value="{{ old('pemakaian') }}" required>
                                    <option value="Null">Pilih Lama Pemakaian</option>
                                    <option
                                        value="Baru Di Unboxing"{{ $item->pemakaian == 'Baru Di Unboxing' ? 'selected' : '' }}>
                                        Baru Di Unboxing
                                    </option>
                                    <option
                                        value="7 Hari Kurang"{{ $item->pemakaian == '7 Hari Kurang' ? 'selected' : '' }}>
                                        7 Hari Kurang
                                    </option>
                                    <option
                                        value="1 Tahun Kurang"{{ $item->pemakaian == '1 Tahun Kurang' ? 'selected' : '' }}>
                                        1 Tahun Kurang
                                    </option>
                                    <option
                                        value="1 Tahun Lebih"{{ $item->pemakaian == '1 Tahun Lebih' ? 'selected' : '' }}>
                                        1 Tahun Lebih
                                    </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="kerusakan" class="form-label font-weight-bold">Kerusakan</label>
                                <textarea class="form-control shadow-none" id="kerusakan" name="kerusakan" rows="3"
                                    placeholder="Masukan Kerusakan">{{ $item->kerusakan }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="tanggalmasuk" class="form-label font-weight-bold">Tanggal Masuk</label>
                                <input type="date" class="form-control shadow-none" id="tanggalmasuk"
                                    name="tanggalmasuk" value="{{ $item->tanggalmasuk }}">
                            </div>
                            <div class="mb-3">
                                <label for="catatan" class="form-label font-weight-bold">Catatan</label>
                                <textarea class="form-control shadow-none" id="catatan" name="catatan" rows="3"
                                    placeholder="Masukan Catatan">{{ $item->catatan }}</textarea>
                            </div>
                            <div class="form-group" hidden>
                                <label class="font-weight-bold">Status</label><br />
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input mt-1" type="radio" id="antrian" name="status"
                                        value="antrian"
                                        {{ in_array('antrian', explode(',', $item->status)) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="antrian">Antrian</label>
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
    <!-- End Edit data -->

    <!-- view data -->
    @foreach ($antrianStock as $item)
        <div class="modal fade" id="viewModal{{ $item->id }}" tabindex="-1"
            aria-labelledby="viewModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewModalLabel{{ $item->id }}">View Data </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="pemilik" class="form-label font-weight-bold">Pemilik</label>
                            <input type="text" class="form-control shadow-none" id="pemilik" name="pemilik"
                                value="{{ $item->pemilik }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="pelanggan" class="form-label font-weight-bold">Pelanggan</label>
                            <input type="text" class="form-control shadow-none" id="pelanggan" name="pelanggan"
                                value="{{ $item->pelanggan }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="device" class="form-label font-weight-bold">Tipe Device</label>
                            <input type="text" class="form-control shadow-none" id="device" name="device"
                                value="{{ $item->device }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="serialnumber" class="form-label font-weight-bold">Serial Number</label>
                            <input type="text" class="form-control shadow-none" id="serialnumber" name="serialnumber"
                                value="{{ $item->serialnumber }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="pemakaian" class="form-label font-weight-bold">Pemakaian</label>
                            <input type="text" class="form-control shadow-none" id="pemakaian" name="pemakaian"
                                value="{{ $item->pemakaian }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="kerusakan" class="form-label font-weight-bold">Kerusakan</label>
                            <textarea class="form-control shadow-none" id="kerusakan" name="kerusakan" rows="3" readonly>{{ $item->kerusakan }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="tanggalmasuk" class="form-label font-weight-bold">Tanggal Masuk</label>
                            <input type="date" class="form-control shadow-none" id="tanggalmasuk" name="tanggalmasuk"
                                value="{{ $item->tanggalmasuk }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="catatan" class="form-label font-weight-bold">Catatan</label>
                            <textarea class="form-control shadow-none" id="catatan" name="catatan" rows="3" readonly>{{ $item->catatan }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <!-- end view data -->

    <!-- delete data -->
    @foreach ($antrianStock as $item)
        <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1"
            aria-labelledby="deleteModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel{{ $item->id }}">Delete Data</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this Data?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <form action="{{ route('service.destroy', $item->id) }}" method="POST">
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

    <!-- Copy Text -->
    @foreach ($antrianStock as $item)
        <div class="modal fade" id="copyText{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="copyModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="copyModalLabel{{ $item->id }}">Copy Data</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body bg-light">
                        <div class="highlight float-right">
                            <button type="button" class="copyClipboard btn btn-secondary"
                                data-clipboard-target="#copyData{{ $item->id }}">
                                <i class="fa-solid fa-clone mr-2"></i>Copy
                            </button>
                        </div>
                        <pre id="copyData{{ $item->id }}" class="highlight mt-4 d-flex flex-column">
                            <span>{{ $item->pelanggan }}</span>
                            <span>{{ $item->device }}</span>
                            <span>{{ $item->serialnumber }}</span>
                            <span>*Status :* {{ $item->status }}</span>
                            <span> </span>
                            <span>*Kerusakan :* <br /> {{ $item->kerusakan }}</span>
                            <span> </span>
                            <span>*Catatan :* <br /> {{ $item->catatan }}</span>
                        </pre>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <!-- End Copy Text -->

    <!-- Move Data -->
    @foreach ($antrianStock as $item)
        <div class="modal fade" id="moveModal{{ $item->id }}" tabindex="-1"
            aria-labelledby="moveModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="{{ route('service.update', $item->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="moveModalLabel{{ $item->id }}">Move Data</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="serialnumber" class="form-label font-weight-bold">Serial Number</label>
                                <input type="text" class="form-control shadow-none" id="serialnumber"
                                    name="serialnumber" value="{{ $item->serialnumber }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="pelanggan" class="form-label font-weight-bold">Pelanggan</label>
                                <input type="text" class="form-control shadow-none" id="pelanggan" name="pelanggan"
                                    value="{{ $item->pelanggan }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="kerusakan" class="form-label font-weight-bold">Kerusakan</label>
                                <textarea class="form-control shadow-none" id="kerusakan" name="kerusakan" rows="3"
                                    placeholder="Masukan Kerusakan" readonly>{{ $item->kerusakan }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="perbaikan" class="form-label font-weight-bold">Perbaikan</label>
                                <textarea class="form-control shadow-none" id="perbaikan" name="perbaikan" rows="3"
                                    placeholder="Masukan Perbaikan">{{ $item->perbaikan }}</textarea>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold" for="teknisi">Teknisi</label>
                                <select class="form-select shadow-none" id="teknisi" name="teknisi"
                                    value="{{ old('teknisi') }}" required>
                                    <option value="Null">Pilih Teknisi</option>
                                    <option value="Khaerul"{{ $item->teknisi == 'Khaerul' ? 'selected' : '' }}>
                                        Khaerul
                                    </option>
                                    <option value="Ozi"{{ $item->teknisi == 'Ozi' ? 'selected' : '' }}>
                                        Ozi
                                    </option>
                                    <option value="Alfian"{{ $item->teknisi == 'Alfian' ? 'selected' : '' }}>
                                        Alfian
                                    </option>
                                    <option value="Timo"{{ $item->teknisi == 'Timo' ? 'selected' : '' }}>
                                        Timo
                                    </option>
                                    <option value="Andre"{{ $item->teknisi == 'Andre' ? 'selected' : '' }}>
                                        Andre
                                    </option>
                                    <option value="Barul"{{ $item->teknisi == 'Barul' ? 'selected' : '' }}>
                                        Barul
                                    </option>
                                    <option value="Other"{{ $item->teknisi == 'Other' ? 'selected' : '' }}>
                                        Other
                                    </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="nosparepart" class="form-label font-weight-bold">No SparePart</label>
                                <input type="text" class="form-control shadow-none" id="nosparepart"
                                    name="nosparepart" placeholder="Masukan No Spare Part"
                                    value="{{ $item->nosparepart }}">
                            </div>
                            <div class="mb-3">
                                <label for="snkanibal" class="form-label font-weight-bold">SN Kanibal</label>
                                <input type="text" class="form-control shadow-none" id="snkanibal" name="snkanibal"
                                    placeholder="Masukan SN Kanibal" value="{{ $item->snkanibal }}">
                            </div>
                            <div class="mb-3">
                                <label for="tanggalkeluar" class="form-label font-weight-bold">Tanggal Selesai</label>
                                <input type="date" class="form-control shadow-none" id="tanggalkeluar"
                                    name="tanggalkeluar" value="{{ $item->tanggalkeluar }}">
                            </div>
                            <div class="mb-3">
                                <label for="catatan" class="form-label font-weight-bold">Catatan</label>
                                <textarea class="form-control shadow-none" id="catatan" name="catatan" rows="3"
                                    placeholder="Masukan Catatan">{{ $item->catatan }}</textarea>
                            </div>
                            <div class="mb-3" hidden>
                                <label for="tanggalmasuk" class="form-label font-weight-bold">Tanggal Masuk</label>
                                <input type="date" class="form-control shadow-none" id="tanggalmasuk"
                                    name="tanggalmasuk" value="{{ $item->tanggalmasuk }}">
                            </div>
                            <div class="form-group" hidden>
                                <label class="font-weight-bold">Pemilik</label><br />
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input mt-1" type="radio" id="stock" name="pemilik"
                                        value="stock"
                                        {{ in_array('stock', explode(',', $item->pemilik)) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="stock">Stock</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input mt-1" type="radio" id="customer" name="pemilik"
                                        value="customer"
                                        {{ in_array('customer', explode(',', $item->pemilik)) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="customer">Customer</label>
                                </div>
                            </div>
                            <div class="form-group" hidden>
                                <label class="font-weight-bold">Status</label><br />
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input mt-1" type="radio" id="validasi" name="status"
                                        value="validasi"
                                        {{ in_array('validasi', explode(',', $item->status)) ? 'checked' : '' }} checked>
                                    <label class="form-check-label" for="validasi">Validasi</label>
                                </div>
                            </div>
                            <div class="form-group mb-3" hidden>
                                <label for="device" class="font-weight-bold">Tipe Device</label>
                                <select class="form-select form-control-chosen" name="device" id="device" required>
                                    <option value="Null">Pilih Tipe Device</option>
                                    <option value="D1" {{ $item->device == 'D1' ? 'selected' : '' }}>D1</option>
                                    <option value="D1-Pro" {{ $item->device == 'D1-Pro' ? 'selected' : '' }}>D1-Pro
                                    </option>
                                    <option value="D1w" {{ $item->device == 'D1w' ? 'selected' : '' }}>D1w</option>
                                    <option value="D1w-702" {{ $item->device == 'D1w-702' ? 'selected' : '' }}>D1w-702
                                    </option>
                                    <option value="D2-402" {{ $item->device == 'D2-402' ? 'selected' : '' }}>D2-402
                                    </option>
                                    <option value="D3-501" {{ $item->device == 'D3-501' ? 'selected' : '' }}>D3-501
                                    </option>
                                    <option value="D3-503" {{ $item->device == 'D3-503' ? 'selected' : '' }}>D3-503
                                    </option>
                                    <option value="D3-504" {{ $item->device == 'D3-504' ? 'selected' : '' }}>D3-504
                                    </option>
                                    <option value="D3-504 Lama" {{ $item->device == 'D3-504 Lama' ? 'selected' : '' }}>
                                        D3-504 Lama
                                    </option>
                                    <option value="D3-505" {{ $item->device == 'D3-505' ? 'selected' : '' }}>D3-505
                                    </option>
                                    <option value="D3-505 Lama" {{ $item->device == 'D3-505 Lama' ? 'selected' : '' }}>
                                        D3-505 Lama
                                    </option>
                                    <option value="D3-506" {{ $item->device == 'D3-506' ? 'selected' : '' }}>D3-506
                                    </option>
                                    <option value="D3-506 Lama" {{ $item->device == 'D3-506 Lama' ? 'selected' : '' }}>
                                        D3-506 Lama
                                    </option>
                                    <option value="D4-502" {{ $item->device == 'D4-502' ? 'selected' : '' }}>D4-502
                                    </option>
                                    <option value="D4-503" {{ $item->device == 'D4-503' ? 'selected' : '' }}>D4-503
                                    </option>
                                    <option value="D4-504" {{ $item->device == 'D4-504' ? 'selected' : '' }}>D4-504
                                    </option>
                                    <option value="D4-505" {{ $item->device == 'D4-505' ? 'selected' : '' }}>D4-505
                                    </option>
                                    <option value="K1-101" {{ $item->device == 'K1-101' ? 'selected' : '' }}>K1-101
                                    </option>
                                    <option value="K2-201" {{ $item->device == 'K2-201' ? 'selected' : '' }}>K2-201
                                    </option>
                                    <option value="M2-202" {{ $item->device == 'M2-202' ? 'selected' : '' }}>M2-202
                                    </option>
                                    <option value="M2-203" {{ $item->device == 'M2-203' ? 'selected' : '' }}>M2-203
                                    </option>
                                    <option value="M2 Pro" {{ $item->device == 'M2 Pro' ? 'selected' : '' }}>M2 Pro
                                    </option>
                                    <option value="M2 Max" {{ $item->device == 'M2 Max' ? 'selected' : '' }}>M2 Max
                                    </option>
                                    <option value="S1-701" {{ $item->device == 'S1-701' ? 'selected' : '' }}>S1-701
                                    </option>
                                    <option value="Swan 1" {{ $item->device == 'Swan 1' ? 'selected' : '' }}>Swan 1
                                    </option>
                                    <option value="Swan 1K" {{ $item->device == 'Swan 1K' ? 'selected' : '' }}>Swan 1K
                                    </option>
                                    <option value="Swan 1 Pro" {{ $item->device == 'Swan 1 Pro' ? 'selected' : '' }}>Swan
                                        1
                                        Pro</option>
                                    <option value="Swift 1" {{ $item->device == 'Swift 1' ? 'selected' : '' }}>Swift 1
                                    </option>
                                    <option value="Swift 1 Pro" {{ $item->device == 'Swift 1 Pro' ? 'selected' : '' }}>
                                        Swift 1 Pro</option>
                                    <option value="Swift 2" {{ $item->device == 'Swift 2' ? 'selected' : '' }}>Swift 2
                                    </option>
                                    <option value="Swift 2 Pro" {{ $item->device == 'Swift 2 Pro' ? 'selected' : '' }}>
                                        Swift 2 Pro</option>
                                    <option value="Falcon 1" {{ $item->device == 'Falcon 1' ? 'selected' : '' }}>Falcon 1
                                    </option>
                                    <option value="Crane 1 16" {{ $item->device == 'Crane 1 16' ? 'selected' : '' }}>
                                        Crane
                                        1 16</option>
                                    <option value="Crane 1 21.5" {{ $item->device == 'Crane 1 21.5' ? 'selected' : '' }}>
                                        Crane 1 21.5</option>
                                    <option value="Crane 1 27" {{ $item->device == 'Crane 1 27' ? 'selected' : '' }}>
                                        Crane
                                        1 27</option>
                                    <option value="Crane 1 32" {{ $item->device == 'Crane 1 32' ? 'selected' : '' }}>
                                        Crane
                                        1 32</option>
                                </select>
                            </div>
                            <div class="form-group mb-3" hidden>
                                <label class="font-weight-bold" for="pemakaian">Pemakaian</label>
                                <select class="form-select shadow-none" id="pemakaian" name="pemakaian"
                                    value="{{ old('pemakaian') }}" required>
                                    <option value="Null">Pilih Lama Pemakaian</option>
                                    <option
                                        value="Baru Di Unboxing"{{ $item->pemakaian == 'Baru Di Unboxing' ? 'selected' : '' }}>
                                        Baru Di Unboxing
                                    </option>
                                    <option
                                        value="7 Hari Kurang"{{ $item->pemakaian == '7 Hari Kurang' ? 'selected' : '' }}>
                                        7 Hari Kurang
                                    </option>
                                    <option
                                        value="1 Tahun Kurang"{{ $item->pemakaian == '1 Tahun Kurang' ? 'selected' : '' }}>
                                        1 Tahun Kurang
                                    </option>
                                    <option
                                        value="1 Tahun Lebih"{{ $item->pemakaian == '1 Tahun Lebih' ? 'selected' : '' }}>
                                        1 Tahun Lebih
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">Move</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
    <!-- End Move data -->

    <div class="container-fluid mt-3">
        <div style="overflow: auto">
            <table id="secondTable" class="table table-striped table-bordered nowrap" style="width:100%">
                <thead>
                    <th>No</th>
                    <th>Tanggal Masuk</th>
                    <th>Serial Number</th>
                    <th>Pelanggan</th>
                    <th>Device</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @empty($antrianStock)
                        <tr>
                            <td colspan="6">No data found</td>
                        </tr>
                    @else
                        @foreach ($antrianStock as $item)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggalmasuk)->format('d/m/Y') }}</td>
                                <td>{{ $item->serialnumber }}</td>
                                <td>{{ $item->pelanggan }}</td>
                                <td>{{ $item->device }}</td>
                                <td class="d-flex align-items-center gap-3">
                                    <a href="#" class="text-decoration-none" data-bs-toggle="modal"
                                        data-target="#viewModal{{ $item->id }}"><i class="fa-solid fa-eye"></i> View</a>
                                    @auth
                                        @if (auth()->user()->hasRole('superadmin') || auth()->user()->hasRole('jeffri') || auth()->user()->hasRole('maulana'))
                                            <div class="dropdown dropright">
                                                <a href="#" class="text-decoration-none dropdown-toggle"
                                                    data-toggle="dropdown" aria-expanded="false">
                                                    More
                                                </a>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-target="#copyText{{ $item->id }}"><i
                                                            class="fa-solid fa-clone"></i>
                                                        Copy</a>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-target="#moveModal{{ $item->id }}"><i
                                                            class="fa-solid fa-paper-plane"></i>
                                                        Move</a>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-target="#editModal{{ $item->id }}"><i
                                                            class="fa-solid fa-pen-to-square"></i> Edit</a>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-target="#deleteModal{{ $item->id }}"><i
                                                            class="fa-solid fa-trash"></i> Delete</a>
                                                </div>
                                            </div>
                                        @endif
                                    @endauth
                                </td>
                            </tr>
                        @endforeach
                    @endempty
                </tbody>
            </table>
        </div>
    </div>
@endsection
