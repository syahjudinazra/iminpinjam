@extends('layouts.app')
@extends('layouts.navbar')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dipinjam Stocks</h1>
        </div>

        @foreach ($stockDipinjam as $item)
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
            <table id="dipinjam-table" class="table table-striped table-bordered" style="width:100%">
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
                $('#dipinjam-table').DataTable({
                    processing: true,
                    serverSide: true,
                    pagingType: 'simple_numbers',
                    paging: true,
                    pageLength: 10,
                    ajax: '{!! route('stock.dipinjam') !!}',
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
                    ]
                });

                $(document).on('click', '.deleteModal', function() {
                    var id = $(this).data('id');
                    $('#deleteModal' + id).modal('show');
                });
            });
        </script>
    @endpush
