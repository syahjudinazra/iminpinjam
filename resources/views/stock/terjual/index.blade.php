@extends('layouts.app')
@extends('layouts.navbar')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Terjual Stocks</h1>
        </div>

        <div class="container-fluid mt-3">
            <table id="terjual-table" class="table table-striped table-bordered" style="width:100%">
                <thead class="headfix">
                    <th>Serial Number</th>
                    <th>Tipe</th>
                    <th>No Invoice</th>
                    <th>Tanggal Masuk</th>
                    <th>Tanggal Keluar</th>
                    <th>Pelanggan</th>
                    <th>Lokasi</th>
                    <th>Action</th>
                </thead>
                <tfoot>
                    <tr>
                        <th>Serial Number</th>
                        <th>Tipe</th>
                        <th>No Invoice</th>
                        <th>Tanggal Masuk</th>
                        <th>Tanggal Keluar</th>
                        <th>Pelanggan</th>
                        <th>Lokasi</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
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
                            data: 'lokasi',
                            name: 'lokasi'
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
                    var footer = $('#terjual-table tfoot tr');
                    $(footer).appendTo('#terjual-table thead');

                    api.columns().every(function() {
                        var column = this;
                        var input = $('<input type="text" placeholder="' + $(column.header()).text() + '" style="width: 100%;" />')
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
