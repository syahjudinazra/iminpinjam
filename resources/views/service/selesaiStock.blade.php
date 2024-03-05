@extends('layouts.app')
@extends('layouts.navbar')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <h1>Selesai Stock</h1>
        </div>
    </div>

    <!-- Edit Data -->
    @foreach ($selesaiStock as $item)
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
                                <label class="font-weight-bold" for="device">Tipe Device</label>
                                <select class="form-select form-control-chosen" name="device" id="device" required>
                                    <option value="Null">Pilih Tipe Device</option>
                                    @foreach ($serviceDevice as $device)
                                        <option value="{{ $device->name }}"
                                            {{ $item->device == $device->name ? 'selected' : '' }}>{{ $device->name }}
                                        </option>
                                    @endforeach
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
                                <label for="perbaikan" class="form-label font-weight-bold">Perbaikan</label>
                                <textarea class="form-control shadow-none" id="perbaikan" name="perbaikan" rows="3"
                                    placeholder="Masukan perbaikan">{{ $item->perbaikan }}</textarea>
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
                                    name="nosparepart" value="{{ $item->nosparepart }}">
                            </div>
                            <div class="mb-3">
                                <label for="snkanibal" class="form-label font-weight-bold">SN Kanibal</label>
                                <input type="text" class="form-control shadow-none" id="snkanibal" name="snkanibal"
                                    value="{{ $item->snkanibal }}">
                            </div>
                            <div class="mb-3">
                                <label for="tanggalmasuk" class="form-label font-weight-bold">Tanggal Masuk</label>
                                <input type="date" class="form-control shadow-none" id="tanggalmasuk"
                                    name="tanggalmasuk" value="{{ $item->tanggalmasuk }}">
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
                            <div class="form-group">
                                <label class="font-weight-bold">Status</label><br />
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input mt-1" type="radio" id="antrian" name="status"
                                        value="antrian"
                                        {{ in_array('antrian', explode(',', $item->status)) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="antrian">Antrian</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input mt-1" type="radio" id="validasi" name="status"
                                        value="validasi"
                                        {{ in_array('validasi', explode(',', $item->status)) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="validasi">Validasi</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input mt-1" type="radio" id="selesai" name="status"
                                        value="selesai"
                                        {{ in_array('selesai', explode(',', $item->status)) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="selesai">Selesai</label>
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
        <!-- End Edit data -->

        <!-- view data -->
        <div class="modal fade" id="viewModal{{ $item->id }}" tabindex="-1"
            aria-labelledby="viewModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewModalLabel{{ $item->id }}">View Data </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                            <label for="perbaikan" class="form-label font-weight-bold">Perbaikan</label>
                            <textarea class="form-control shadow-none" id="perbaikan" name="perbaikan" rows="3" readonly>{{ $item->perbaikan }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="teknisi" class="form-label font-weight-bold">Teknisi</label>
                            <input type="text" class="form-control shadow-none" id="teknisi" name="teknisi"
                                value="{{ $item->teknisi }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="nosparepart" class="form-label font-weight-bold">No SparePart</label>
                            <input type="text" class="form-control shadow-none" id="nosparepart" name="nosparepart"
                                value="{{ $item->nosparepart }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="snkanibal" class="form-label font-weight-bold">SN Kanibal</label>
                            <input type="text" class="form-control shadow-none" id="snkanibal" name="snkanibal"
                                value="{{ $item->snkanibal }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="tanggalmasuk" class="form-label font-weight-bold">Tanggal Masuk</label>
                            <input type="date" class="form-control shadow-none" id="tanggalmasuk" name="tanggalmasuk"
                                value="{{ $item->tanggalmasuk }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="tanggalkeluar" class="form-label font-weight-bold">Tanggal Selesai</label>
                            <input type="date" class="form-control shadow-none" id="tanggalkeluar"
                                name="tanggalkeluar" value="{{ $item->tanggalkeluar }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="catatan" class="form-label font-weight-bold">Catatan</label>
                            <textarea class="form-control shadow-none" id="catatan" name="catatan" rows="3" readonly>{{ $item->catatan }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end view data -->

        <!-- delete data -->
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
        <!-- end delete data -->

        <!-- Copy Text -->
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
                            <span>*Perbaikan :* <br /> {{ $item->perbaikan }}</span>
                            <span> </span>
                            <span>*Teknisi :* <br /> {{ $item->teknisi }}</span>
                            <span> </span>
                            <span>*Catatan :* <br /> {{ $item->catatan }}</span>
                        </pre>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <!-- End Copy Text -->

    <div class="container-fluid mt-3">
        <div style="overflow: auto">
            <table id="selesaiStock-table" class="table table-striped table-bordered nowrap" style="width:100%">
                <thead>

                    <tr>
                        <th>No</th>
                        <th>Tanggal Selesai</th>
                        <th>SerialNumber</th>
                        <th>Pelanggan</th>
                        <th>Device</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#selesaiStock-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('service.selesaiStock') !!}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'tanggalkeluar',
                        name: 'tanggalkeluar',
                        render: function(data) {
                            return moment(data).format('DD-MM-YYYY');
                        }
                    },
                    {
                        data: 'serialnumber',
                        name: 'serialnumber'
                    },
                    {
                        data: 'pelanggan',
                        name: 'pelanggan'
                    },
                    {
                        data: 'device',
                        name: 'device'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $(document).ready(function() {
                $('.viewModal').on('click', function() {
                    var id = $(this).data('id');
                    $('#viewModal' + id).modal('show');
                });
            });
            $(document).ready(function() {
                $('.editModal').on('click', function() {
                    var id = $(this).data('id');
                    $('#editModal' + id).modal('show');
                });
            });
            $(document).ready(function() {
                $('.copyText').on('click', function() {
                    var id = $(this).data('id');
                    $('#copyText' + id).modal('show');
                });
            });
            $(document).ready(function() {
                $('.deleteModal').on('click', function() {
                    var id = $(this).data('id');
                    $('#deleteModal' + id).modal('show');
                });
            });
        });
    </script>
@endpush
