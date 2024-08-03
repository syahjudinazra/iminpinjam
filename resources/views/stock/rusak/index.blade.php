@extends('layouts.app')
@extends('layouts.navbar')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Rusak Stocks</h1>
        </div>

        <div class="container-fluid mt-3">
            <div class="overflow-auto">
                <table id="rusak-table" class="table table-striped table-bordered" style="width:100%">
                    <thead class="headfix">
                        <th>No</th>
                        <th>Serial Number</th>
                        <th>Tipe</th>
                        <th>No Invoice</th>
                        <th>Tanggal Masuk</th>
                        <th>Tanggal Keluar</th>
                        <th>Pelanggan</th>
                        <th>Action</th>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Serial Number</th>
                            <th>Tipe</th>
                            <th>No Invoice</th>
                            <th>Tanggal Masuk</th>
                            <th>Tanggal Keluar</th>
                            <th>Pelanggan</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    @endsection

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#rusak-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    pagingType: 'simple_numbers',
                    paging: true,
                    pageLength: 10,
                    ajax: '{!! route('stock.rusak') !!}',
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
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ],
                    initComplete: function() {
                        var api = this.api();
                        var footer = $('#rusak-table tfoot tr');
                        $(footer).appendTo('#rusak-table thead');

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
