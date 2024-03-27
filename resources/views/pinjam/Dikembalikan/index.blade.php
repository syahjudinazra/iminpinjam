@extends('layouts.app')
@extends('layouts.navbar')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Pengembalian Barang</h1>
        </div>
    </div>

    @foreach ($kembaliPinjam as $item)
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
        <table id="kembali-table" class="table table-striped table-bordered" style="width:100%">
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
            $('#kembali-table').DataTable({
                processing: true,
                serverSide: true,
                pagingType: 'simple_numbers',
                paging: true,
                pageLength: 10,
                ajax: '{!! route('pinjam.kembali') !!}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'tanggalkembali',
                        name: 'tanggalkembali',
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
                $('.deleteModal').on('click', function() {
                    var id = $(this).data('id');
                    $('#deleteModal' + id).modal('show');
                });
            });
        });
    </script>
@endpush
