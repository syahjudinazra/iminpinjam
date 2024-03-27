@extends('layouts.app')
@extends('layouts.navbar')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <h1>Selesai Stock</h1>
        </div>
    </div>

    @foreach ($selesaiStock as $item)
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
        <!-- End Copy Text -->
    @endforeach


    <div class="container-fluid mt-3">
        <div style="overflow: auto">
            <table id="selesaiStock-table" class="table table-striped table-bordered nowrap" style="width:100%">
                <thead>
                    <th>No</th>
                    <th>Tanggal Keluar</th>
                    <th>Serial Number</th>
                    <th>Pelanggan</th>
                    <th>Device</th>
                    <th>Action</th>
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
                pagingType: 'simple_numbers',
                paging: true,
                pageLength: 10,
                ajax: '{!! route('service.selesaiStock') !!}',
                columns: [{
                        data: 'id',
                        name: 'id'
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
