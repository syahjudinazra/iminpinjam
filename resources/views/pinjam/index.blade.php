@extends('layouts.app')
@extends('layouts.navbar')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Peminjaman Barang</h1>
            @auth
                @if (auth()->user()->hasRole('superadmin') ||
                        auth()->user()->hasRole('jeffri') ||
                        auth()->user()->hasRole('sylvi') ||
                        auth()->user()->hasRole('coni') ||
                        auth()->user()->hasRole('vivi'))
                    <a href="{{ route('export-pinjam') }}" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
                        <i class="fas fa-download fa-sm text-white-50"></i> Generate Excel</a>
            </div>
            <div class="addPinjam">
                <button type="button" id="addpinjam" class="btn btn-danger mb-2" data-bs-toggle="modal"
                    data-target="#exampleModal">
                    <i class="fa-solid fa-plus"></i> Tambah Produk
                </button>
            </div>
            @endif
        @endauth

        <!-- Tambah Data -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Pinjam Barang</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" action="/pinjam" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="tanggal" class="form-label font-weight-bold">Tanggal</label>
                                <input type="date" class="form-control shadow-none" id="tanggal" name="tanggal">
                            </div>
                            <div class="mb-3">
                                <label for="serialnumber" class="form-label font-weight-bold">Serial Number</label>
                                <input type="text" class="form-control shadow-none" id="serialnumber" name="serialnumber"
                                    placeholder="Masukan Serial Number">
                            </div>
                            <div class="form-group mb-3">
                                <label class="font-weight-bold" for="device">Tipe Device</label>
                                <select class="form-select form-control-chosen shadow-none" name="device"
                                    id="device"required>
                                    <option value="Null">Pilih Device</option>
                                    @foreach ($pinjamsDevice as $device)
                                        <option value="{{ $device->name }}">{{ $device->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold" for="ram">RAM/Storage</label>
                                <select class="form-select shadow-none" id="ram" name="ram"
                                    value="{{ old('ram') }}" required>
                                    <option>Pilih RAM/Storage</option>
                                    <option>-</option>
                                    <option>1/8</option>
                                    <option>2/8</option>
                                    <option>2/16</option>
                                    <option>4/16</option>
                                    <option>4/32</option>
                                    <option>4/64</option>
                                    <option>8/128</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold" for="android">Versi Android</label>
                                <select class="form-select shadow-none" id="android" name="android"
                                    value="{{ old('android') }}" required>
                                    <option>Pilih Versi Android</option>
                                    <option>-</option>
                                    <option>Android 7</option>
                                    <option>Android 8</option>
                                    <option>Android 11</option>
                                    <option>Android 11 GMS</option>
                                    <option>Android 13</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="customer" class="form-label font-weight-bold">Customer</label>
                                <input type="text" class="form-control shadow-none" id="customer" name="customer"
                                    placeholder="Masukan Nama Customer">
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label font-weight-bold">Alamat</label>
                                <textarea class="form-control shadow-none" id="alamat" name="alamat" rows="3"
                                    placeholder="Jl. Pergudangan Ecopark"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="sales" class="form-label font-weight-bold">Sales</label>
                                <input type="text" class="form-control shadow-none" id="sales" name="sales"
                                    placeholder="Masukan Nama Sales">
                            </div>
                            <div class="mb-3">
                                <label for="telp" class="form-label font-weight-bold">No Telp</label>
                                <input type="number" class="form-control shadow-none" id="telp" name="telp"
                                    placeholder="Masukan No Telp">
                            </div>
                            <div class="mb-3">
                                <label for="pengirim" class="form-label font-weight-bold">Pengirim</label>
                                <input type="text" class="form-control shadow-none" id="pengirim" name="pengirim"
                                    placeholder="Masukan Nama Pengirim">
                            </div>
                            <div class="mb-3">
                                <label for="kelengkapankirim" class="form-label font-weight-bold">Kelengkapan
                                    Kirim</label>
                                <textarea class="form-control shadow-none" id="kelengkapankirim" name="kelengkapankirim" rows="3"
                                    placeholder="Contoh:Adaptor,Dus,Docking"></textarea>
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
    </div>

    @foreach ($pinjam as $item)
        <!-- add edit Data -->
        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1"
            aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="{{ route('users.update', $item->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Edit Data Pinjam</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="tanggal" class="form-label font-weight-bold">Tanggal</label>
                                <input type="date" class="form-control shadow-none" id="tanggal" name="tanggal"
                                    value="{{ $item->tanggal }}">
                            </div>
                            <div class="mb-3">
                                <label for="serialnumber" class="form-label font-weight-bold">Serial Number</label>
                                <input type="text" class="form-control shadow-none" id="serialnumber"
                                    name="serialnumber" value="{{ $item->serialnumber }}">
                            </div>
                            <div class="form-group mb-3">
                                <label class="font-weight-bold" for="device">Device</label>
                                <select class="form-select form-control-chosen shadow-none" name="device" id="device"
                                    required>
                                    <option value="Null">Pilih Model</option>
                                    @foreach ($pinjamsDevice as $device)
                                        <option value="{{ $device->name }}"
                                            {{ $item->device == $device->name ? 'selected' : '' }}>{{ $device->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="ram" class="form-label font-weight-bold">RAM</label>
                                <input type="text" class="form-control shadow-none" id="ram" name="ram"
                                    value="{{ $item->ram }}">
                            </div>
                            <div class="mb-3">
                                <label for="android" class="form- font-weight-bold">Android</label>
                                <input type="text" class="form-control shadow-none" id="android" name="android"
                                    value="{{ $item->android }}">
                            </div>
                            <div class="mb-3">
                                <label for="customer" class="form-label font-weight-bold">Customer</label>
                                <input type="text" class="form-control shadow-none" id="customer" name="customer"
                                    value="{{ $item->customer }}">
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label font-weight-bold">Alamat</label>
                                <textarea class="form-control shadow-none" id="alamat" name="alamat" rows="3">{{ $item->alamat }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="sales" class="form-label font-weight-bold">Sales</label>
                                <input type="text" class="form-control shadow-none" id="sales" name="sales"
                                    value="{{ $item->sales }}">
                            </div>
                            <div class="mb-3">
                                <label for="telp" class="form-label font-weight-bold">No Telp</label>
                                <input type="number" class="form-control shadow-none" id="telp" name="telp"
                                    value="{{ $item->telp }}">
                            </div>
                            <div class="mb-3">
                                <label for="pengirim" class="form-label font-weight-bold">Pengirim</label>
                                <input type="text" class="form-control shadow-none" id="pengirim" name="pengirim"
                                    value="{{ $item->pengirim }}">
                            </div>
                            <div class="mb-3">
                                <label for="kelengkapankirim" class="form-label font-weight-bold">Kelengkapan
                                    Kirim</label>
                                <textarea class="form-control shadow-none" id="kelengkapankirim" name="kelengkapankirim" rows="3">{{ $item->kelengkapankirim }}</textarea>
                            </div>
                            <div class="mb-3" hidden>
                                <label for="status" class="form-label font-weight-bold">Status</label>
                                <input type="text" class="form-control shadow-none" id="status" name="status"
                                    value="{{ $item->status }}" readonly>
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
        <!-- end edit data -->

        <!-- view data -->
        <div class="modal fade" id="viewModal{{ $item->id }}" tabindex="-1"
            aria-labelledby="viewModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewModalLabel{{ $item->id }}">View Data Pinjam</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="tanggal" class="form-label font-weight-bold">Tanggal</label>
                            <input type="date" class="form-control shadow-none" id="tanggal" name="tanggal"
                                value="{{ $item->tanggal }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="serialnumber" class="form-label font-weight-bold">Serial Number</label>
                            <input type="text" class="form-control shadow-none" id="serialnumber" name="serialnumber"
                                value="{{ $item->serialnumber }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="device" class="form-label font-weight-bold">Device</label>
                            <input type="text" class="form-control shadow-none" id="device" name="device"
                                value="{{ $item->device }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="ram" class="form-label font-weight-bold">RAM</label>
                            <input type="text" class="form-control shadow-none" id="ram" name="ram"
                                value="{{ $item->ram }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="android" class="form-label font-weight-bold">Android</label>
                            <input type="text" class="form-control shadow-none" id="android" name="android"
                                value="{{ $item->android }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="customer" class="form-label font-weight-bold">Customer</label>
                            <input type="text" class="form-control shadow-none" id="customer" name="customer"
                                value="{{ $item->customer }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label font-weight-bold">Alamat</label>
                            <textarea class="form-control shadow-none" id="alamat" name="alamat" rows="3" readonly>{{ $item->alamat }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="sales" class="form-label font-weight-bold">Sales</label>
                            <input type="text" class="form-control shadow-none" id="sales" name="sales"
                                value="{{ $item->sales }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="telp" class="form-label font-weight-bold">No Telp</label>
                            <input type="number" class="form-control shadow-none" id="telp" name="telp"
                                value="{{ $item->telp }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="pengirim" class="form-label font-weight-bold">Pengirim</label>
                            <input type="text" class="form-control shadow-none" id="pengirim" name="pengirim"
                                value="{{ $item->pengirim }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="kelengkapankirim" class="form-label font-weight-bold">Kelengkapan Kirim</label>
                            <textarea class="form-control shadow-none" id="kelengkapankirim" name="kelengkapankirim" rows="3" readonly>{{ $item->kelengkapankirim }}</textarea>
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
                        <h5 class="modal-title" id="deleteModalLabel{{ $item->id }}">Delete Data Pinjam</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this Data?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <form action="{{ route('users.destroy', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end delete data -->

        <!-- Move data -->
        <div class="modal fade" id="moveModal{{ $item->id }}" tabindex="-1"
            aria-labelledby="moveModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="{{ route('users.update', $item->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="moveModalLabel{{ $item->id }}">Ajukan Pengembalian</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="tanggal" class="form-label font-weight-bold">Tanggal</label>
                                <input type="date" class="form-control shadow-none" id="tanggal" name="tanggal"
                                    value="{{ $item->tanggal }}"readonly>
                            </div>
                            <div class="mb-3">
                                <label for="serialnumber" class="form-label font-weight-bold">Serial Number</label>
                                <input type="text" class="form-control shadow-none" id="serialnumber"
                                    name="serialnumber" value="{{ $item->serialnumber }}"readonly>
                            </div>
                            <div class="mb-3">
                                <label for="device" class="form-label font-weight-bold">Device</label>
                                <input type="text" class="form-control shadow-none" id="device" name="device"
                                    value="{{ $item->device }}"readonly>
                            </div>
                            <div class="mb-3">
                                <label for="ram" class="form-label font-weight-bold">RAM</label>
                                <input type="text" class="form-control shadow-none" id="ram" name="ram"
                                    value="{{ $item->ram }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="android" class="form- font-weight-bold">Android</label>
                                <input type="text" class="form-control shadow-none" id="android" name="android"
                                    value="{{ $item->android }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="customer" class="form- font-weight-bold">Customer</label>
                                <input type="text" class="form-control shadow-none" id="customer" name="customer"
                                    value="{{ $item->customer }}"readonly>
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label font-weight-bold">Alamat</label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="3" readonly>{{ $item->alamat }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="sales" class="form-label font-weight-bold">Sales</label>
                                <input type="text" class="form-control shadow-none" id="sales" name="sales"
                                    value="{{ $item->sales }}"readonly>
                            </div>
                            <div class="mb-3">
                                <label for="telp" class="form-label font-weight-bold">No Telp</label>
                                <input type="number" class="form-control shadow-none" id="telp" name="telp"
                                    value="{{ $item->telp }}"readonly>
                            </div>
                            <div class="mb-3">
                                <label for="pengirim" class="form-label font-weight-bold">Pengirim</label>
                                <input type="text" class="form-control shadow-none" id="pengirim" name="pengirim"
                                    value="{{ $item->pengirim }}"readonly>
                            </div>
                            <div class="mb-3">
                                <label for="kelengkapankirim" class="form-label font-weight-bold">Kelengkapan
                                    Kirim</label>
                                <textarea class="form-control shadow-none" id="kelengkapankirim" name="kelengkapankirim" rows="3" readonly>{{ $item->kelengkapankirim }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="tanggalkembali" class="form-label font-weight-bold">Tanggal Kembali</label>
                                <input type="date" class="form-control shadow-none" id="tanggalkembali"
                                    name="tanggalkembali">
                            </div>
                            <div class="mb-3">
                                <label for="penerima" class="form-label font-weight-bold">Penerima</label>
                                <input type="text" class="form-control shadow-none" id="penerima" name="penerima"
                                    placeholder="Masukan Nama Penerima">
                            </div>
                            <div class="mb-3">
                                <label for="kelengkapankembali" class="form-label font-weight-bold">Kelengkapan
                                    Kembali</label><br />
                                <textarea class="form-control shadow-none" id="kelengkapankembali" name="kelengkapankembali" rows="3"
                                    placeholder="Contoh:Adaptor,Dus,Docking"></textarea>
                            </div>
                            <div class="mb-3" hidden>
                                <label for="status" class="form-label font-weight-bold">Status</label>
                                <input type="text" class="form-control shadow-none" id="status" name="status"
                                    value="1" readonly>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">Pindah Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Move data -->
    @endforeach

    <div class="container-fluid mt-3">
        <table id="pinjams-table" class="table table-striped table-bordered" style="width:100%">
            <thead class="headfix">
                <th>No</th>
                <th>Tanggal</th>
                <th>Serial Number</th>
                <th>Tipe Device</th>
                <th>Customer</th>
                <th>Action</th>
            </thead>

        </table>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#pinjams-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('pinjam.index') !!}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal',
                        render: function(data) {
                            return moment(data).format('DD-MM-YYYY');
                        }
                    },
                    {
                        data: 'serialnumber',
                        name: 'serialnumber'
                    },
                    {
                        data: 'device',
                        name: 'device'
                    },
                    {
                        data: 'customer',
                        name: 'customer'
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
                $('.moveModal').on('click', function() {
                    var id = $(this).data('id');
                    $('#moveModal' + id).modal('show');
                });
            });
            $(document).ready(function() {
                $('.editModal').on('click', function() {
                    var id = $(this).data('id');
                    $('#editModal' + id).modal('show');
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
