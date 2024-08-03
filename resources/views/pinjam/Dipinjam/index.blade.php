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
                    <a href="{{ route('pinjam.export-pinjam') }}"
                        class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
                        <i class="fas fa-download fa-sm text-white-50"></i> Export Excel</a>
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
                        <form action="{{ route('pinjam.destroy', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end delete data -->
    @endforeach

    <div class="container-fluid mt-3">
        <div class="overflow-auto">
            <table id="pinjams-table" class="table table-striped table-bordered" style="width:100%">
                <thead class="headfix">
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Days</th>
                    <th>Serial Number</th>
                    <th>Tipe Device</th>
                    <th>Customer</th>
                    <th>Action</th>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            function highlightIfOverdue(date) {
                const startDate = moment(date);
                const endDate = moment();
                const diffInDays = endDate.diff(startDate, 'days');
                let className = diffInDays > 14 ? "text-danger" : "";
                return {
                    diffInDays,
                    className
                };
            }

            $('#pinjams-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pagingType: 'simple_numbers',
                paging: true,
                pageLength: 10,
                ajax: '{!! route('pinjam.Dipinjam') !!}',
                columns: [{
                        data: 'id',
                        name: 'id',
                        render: function(data, type, row) {
                            const {
                                className
                            } = highlightIfOverdue(row.tanggal);
                            return `<span class="${className}">${data}</span>`;
                        }
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal',
                        render: function(data) {
                            const {
                                className
                            } = highlightIfOverdue(data);
                            return `<span class="${className}">${moment(data).format('DD-MM-YYYY')}</span>`;
                        }
                    },
                    {
                        data: null,
                        name: 'days',
                        render: function(data, type, row) {
                            const {
                                diffInDays,
                                className
                            } = highlightIfOverdue(row.tanggal);
                            return `<span class="${className}">${diffInDays}</span>`;
                        }
                    },
                    {
                        data: 'serialnumber',
                        name: 'serialnumber',
                        render: function(data, type, row) {
                            const {
                                className
                            } = highlightIfOverdue(row.tanggal);
                            return `<span class="${className}">${data}</span>`;
                        }
                    },
                    {
                        data: 'device',
                        name: 'device',
                        render: function(data, type, row) {
                            const {
                                className
                            } = highlightIfOverdue(row.tanggal);
                            return `<span class="${className}">${data}</span>`;
                        }
                    },
                    {
                        data: 'customer',
                        name: 'customer',
                        render: function(data, type, row) {
                            const {
                                className
                            } = highlightIfOverdue(row.tanggal);
                            return `<span class="${className}">${data}</span>`;
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                    },
                ]
            });

            $('.deleteModal').on('click', function() {
                var id = $(this).data('id');
                $('#deleteModal' + id).modal('show');
            });
        });
    </script>
@endpush
