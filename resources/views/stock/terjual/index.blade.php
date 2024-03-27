@extends('layouts.app')
@extends('layouts.navbar')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Terjual Stocks</h1>
        </div>

        @foreach ($stockTerjual as $item)
            <!-- view data -->
            <div class="modal fade" id="stockViewModal{{ $item->id }}" tabindex="-1"
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
                                <label for="serialnumber" class="form-label font-weight-bold">Serial Number</label>
                                <input type="text" class="form-control shadow-none" id="serialnumber" name="serialnumber"
                                    value="{{ $item->serialnumber }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="tipe" class="form-label font-weight-bold">Tipe Device</label>
                                <input type="text" class="form-control shadow-none" id="tipe" name="tipe"
                                    value="{{ $item->tipe }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="noinvoice" class="form-label font-weight-bold">No Invoice</label>
                                <input type="text" class="form-control shadow-none" id="noinvoice" name="noinvoice"
                                    value="{{ $item->noinvoice }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="tanggalmasuk" class="form-label font-weight-bold">Tanggal Masuk</label>
                                <input type="date" class="form-control shadow-none" id="tanggalmasuk" name="tanggalmasuk"
                                    value="{{ $item->tanggalmasuk }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="tanggalkeluar" class="form-label font-weight-bold">Tanggal Keluar</label>
                                <input type="date" class="form-control shadow-none" id="tanggalkeluar"
                                    name="tanggalkeluar" value="{{ $item->tanggalkeluar }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="pelanggan" class="form-label font-weight-bold">Pelanggan</label>
                                <input type="text" class="form-control shadow-none" id="pelanggan" name="pelanggan"
                                    value="{{ $item->pelanggan }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="keterangan" class="form-label font-weight-bold">Keterangan</label>
                                <input type="text" class="form-control shadow-none" id="keterangan" name="keterangan"
                                    value="{{ $item->keterangan }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label font-weight-bold">Status</label>
                                <input type="text" class="form-control shadow-none" id="status" name="status"
                                    value="{{ $item->status }}" readonly>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
            <!-- end delete data -->
        @endforeach

        <div class="container-fluid mt-3">
            <table id="terjual-table" class="table table-striped table-bordered" style="width:100%">
                <thead class="headfix">
                    <th>No</th>
                    <th>Serial Number</th>
                    <th>Tipe</th>
                    <th>No Invoice</th>
                    <th>Tanggal Masuk</th>
                    <th>Tanggal Keluar</th>
                    <th>Pelanggan</th>
                    <th>Keterangan</th>
                    <th>Action</th>
                </thead>
            </table>
        </div>
    @endsection

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#terjual-table').DataTable({
                    processing: true,
                    serverSide: true,
                    pagingType: 'simple_numbers',
                    paging: true,
                    pageLength: 10,
                    ajax: '{!! route('stock.terjual') !!}',
                    columns: [{
                            data: 'id',
                            name: 'id'
                        },
                        {
                            data: 'serialnumber',
                            name: 'serialnumber'
                        },
                        {
                            data: 'tipe',
                            name: 'tipe'
                        },
                        {
                            data: 'noinvoice',
                            name: 'noinvoice'
                        },
                        {
                            data: 'tanggalmasuk',
                            name: 'tanggalmasuk',
                            render: function(data) {
                                return moment(data).format('DD-MM-YYYY');
                            }
                        },
                        {
                            data: 'tanggalkeluar',
                            name: 'tanggalkeluar',
                            render: function(data) {
                                return moment(data).format('DD-MM-YYYY');
                            }
                        },
                        {
                            data: 'pelanggan',
                            name: 'pelanggan'
                        },
                        {
                            data: 'keterangan',
                            name: 'keterangan'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ],
                });

                $(document).ready(function() {
                    $('.viewModal').on('click', function() {
                        var id = $(this).data('id');
                        $('#stockViewModal' + id).modal('show');
                    });
                });

                $(document).on('click', '.deleteModal', function() {
                    var id = $(this).data('id');
                    $('#deleteModal' + id).modal('show');
                });
            });
        </script>
    @endpush
