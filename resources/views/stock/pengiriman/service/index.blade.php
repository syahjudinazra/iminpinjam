@extends('layouts.app')
@extends('layouts.navbar')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h2 class="h3 mb-0 text-gray-800">Cek Pengiriman Service Stocks</h2>
        </div>

        <div class="container-fluid mt-3">
            <table id="pengirimanService-table" class="table table-striped table-bordered" style="width:100%">
                <thead class="headfix">
                    <tr>
                        <th>No</th>
                        <th>Serial Number</th>
                        <th>Tipe</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Serial Number</th>
                        <th>Tipe</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    @endsection

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#pengirimanService-table').DataTable({
                    processing: true,
                    serverSide: true,
                    pagingType: 'simple_numbers',
                    paging: true,
                    pageLength: 10,
                    ajax: '{!! route('stock.pengirimanService') !!}',
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
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ],
                    initComplete: function() {
                        var api = this.api();
                        var footer = $('#pengirimanService-table tfoot tr');
                        $(footer).appendTo('#pengirimanService-table thead');

                        api.columns().every(function() {
                            var column = this;
                            var input = $('<input type="text" placeholder="' + $(column.header())
                                    .text() + '" style="width: 100%;" />')
                                .appendTo($(column.footer()).empty())
                                .on('keyup change clear', function() {
                                    if (column.search() !== this.value) {
                                        column.search(this.value).draw();
                                    }
                                });
                        });
                    }
                });
            });
        </script>
    @endpush
