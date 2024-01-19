@extends('layouts.app')
@extends('layouts.navbar')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <h1>Selesai Pelanggan</h1>
        </div>
    </div>

    <!-- Edit Data -->
    @foreach ($selesaiPelanggan as $item)
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
                            <div class="mb-3">
                                <label for="tanggalmasuk" class="form-label font-weight-bold">Tanggal Masuk</label>
                                <input type="date" class="form-control shadow-none" id="tanggalmasuk" name="tanggalmasuk"
                                    value="{{ $item->tanggalmasuk }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="serialnumber" class="form-label font-weight-bold">Serial Number</label>
                                <input type="text" class="form-control shadow-none" id="serialnumber" name="serialnumber"
                                    value="{{ $item->serialnumber }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="pemilik" class="form-label font-weight-bold">Pemilik</label>
                                <input type="text" class="form-control shadow-none" id="pemilik" name="pemilik"
                                    value="{{ $item->pemilik }}" readonly>
                            </div>
                            <div class="form-group" hidden>
                                <label class="font-weight-bold">Status</label><br />
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input mt-1" type="radio" id="validasi" name="status"
                                        value="validasi"
                                        {{ in_array('validasi', explode(',', $item->status)) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="validasi">Validasi</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="pelanggan" class="form-label font-weight-bold">Pelanggan</label>
                                <input type="text" class="form-control shadow-none" id="pelanggan" name="pelanggan"
                                    value="{{ $item->pelanggan }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="device" class="form-label font-weight-bold">Device</label>
                                <input type="text" class="form-control shadow-none" id="device" name="device"
                                    value="{{ $item->device }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="pemakaian" class="form-label font-weight-bold">Pemakaian</label>
                                <input type="text" class="form-control shadow-none" id="pemakaian" name="pemakaian"
                                    value="{{ $item->pemakaian }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="kerusakan" class="form-label font-weight-bold">Kerusakan</label>
                                <textarea class="form-control shadow-none" id="kerusakan" name="kerusakan" rows="3"
                                    placeholder="Masukan Kerusakan" readonly>{{ $item->kerusakan }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="catatan" class="form-label font-weight-bold">Catatan</label>
                                <textarea class="form-control shadow-none" id="catatan" name="catatan" rows="3" placeholder="Masukan Catatan"
                                    readonly>{{ $item->catatan }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="tanggalkeluar" class="form-label font-weight-bold">Tanggal Selesai</label>
                                <input type="date" class="form-control shadow-none" id="tanggalkeluar"
                                    name="tanggalkeluar" value="{{ $item->tanggalkeluar }}">
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
    @foreach ($selesaiPelanggan as $item)
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
                            <label for="tanggalmasuk" class="form-label font-weight-bold">Tanggal Masuk</label>
                            <input type="date" class="form-control shadow-none" id="tanggalmasuk" name="tanggalmasuk"
                                value="{{ $item->tanggalmasuk }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="serialnumber" class="form-label font-weight-bold">Serial Number</label>
                            <input type="text" class="form-control shadow-none" id="serialnumber" name="serialnumber"
                                value="{{ $item->serialnumber }}" readonly>
                        </div>
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
                            <label for="pemakaian" class="form-label font-weight-bold">Pemakaian</label>
                            <input type="text" class="form-control shadow-none" id="pemakaian" name="pemakaian"
                                value="{{ $item->pemakaian }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="kerusakan" class="form-label font-weight-bold">Kerusakan</label>
                            <textarea class="form-control shadow-none" id="kerusakan" name="kerusakan" rows="3" readonly>{{ $item->kerusakan }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="catatan" class="form-label font-weight-bold">Catatan</label>
                            <textarea class="form-control shadow-none" id="catatan" name="catatan" rows="3" readonly>{{ $item->catatan }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="tanggalkeluar" class="form-label font-weight-bold">Tanggal Selesai</label>
                            <input type="date" class="form-control shadow-none" id="tanggalkeluar"
                                name="tanggalkeluar" value="{{ $item->tanggalkeluar }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="perbaikan" class="form-label font-weight-bold">Perbaikan</label>
                            <textarea class="form-control shadow-none" id="perbaikan" name="perbaikan" rows="3"
                                placeholder="Masukan Perbaikan" readonly>{{ $item->perbaikan }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="teknisi" class="form-label font-weight-bold">Teknisi</label>
                            <input type="text" class="form-control shadow-none" id="teknisi" name="teknisi"
                                placeholder="Masukan No Spare Part" value="{{ $item->teknisi }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="nosparepart" class="form-label font-weight-bold">No SparePart</label>
                            <input type="text" class="form-control shadow-none" id="nosparepart" name="nosparepart"
                                placeholder="Masukan No Spare Part" value="{{ $item->nosparepart }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="snkanibal" class="form-label font-weight-bold">SN Kanibal</label>
                            <input type="text" class="form-control shadow-none" id="snkanibal" name="snkanibal"
                                placeholder="Masukan SN Kanibal" value="{{ $item->snkanibal }}" readonly>
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
    @foreach ($selesaiPelanggan as $item)
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
    @foreach ($selesaiPelanggan as $item)
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
                            <span>*Teknisi :* {{ $item->teknisi }}</span>
                            &nbsp;
                            <span>*Kerusakan :* <br /> {{ $item->kerusakan }}</span>
                            &nbsp;
                            <span>*Perbaikan :* <br /> {{ $item->perbaikan }}</span>
                            &nbsp;
                            <span>*Catatan :* <br />{{ $item->catatan }}</span>
                        </pre>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <!-- End Copy Text -->

    <div class="container-fluid mt-3">
        <div style="overflow: auto">
            <table id="secondTable" class="table table-striped table-bordered nowrap" style="width:100%">
                <thead>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Serial Number</th>
                    <th>Pelanggan</th>
                    <th>Device</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @empty($selesaiPelanggan)
                        <tr>
                            <td colspan="6">No data found</td>
                        </tr>
                    @else
                        @foreach ($selesaiPelanggan as $item)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggalmasuk)->format('d/m/Y') }}</td>
                                <td>{{ $item->serialnumber }}</td>
                                <td>{{ $item->pelanggan }}</td>
                                <td>{{ $item->device }}</td>
                                <td class="d-flex align-items-center gap-3">
                                    <a href="#" class="text-decoration-none" data-bs-toggle="modal"
                                        data-target="#viewModal{{ $item->id }}"><i class="fa-solid fa-eye"></i> View</a>

                                    <div class="dropdown dropright">
                                        <a href="#" class="text-decoration-none dropdown-toggle" data-toggle="dropdown"
                                            aria-expanded="false">
                                            More
                                        </a>
                                        <div class="dropdown-menu">
                                            {{-- <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                data-target="#editModal{{ $item->id }}"><i
                                                    class="fa-solid fa-pen-to-square"></i> Edit</a> --}}
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                data-target="#deleteModal{{ $item->id }}"><i
                                                    class="fa-solid fa-trash"></i> Delete</a>
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                data-target="#copyText{{ $item->id }}"><i class="fa-solid fa-clone"></i>
                                                Copy</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endempty
                </tbody>
            </table>
        </div>
    </div>
@endsection
