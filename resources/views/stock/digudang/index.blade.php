@extends('layouts.app')
@extends('layouts.navbar')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Gudang Stocks</h1>
        </div>

        <div class="container-fluid mt-3">
            <div class="overflow-auto">
                <table id="gudang-table" class="table table-striped table-bordered">
                    <thead class="headfix">
                        <th>ID</th>
                        <th>Serial Number</th>
                        <th>Tipe</th>
                        <th>No Invoice</th>
                        <th>Tanggal Masuk</th>
                        <th>Pelanggan</th>
                        <th>Action</th>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Serial Number</th>
                            <th>Tipe</th>
                            <th>No Invoice</th>
                            <th>Tanggal Masuk</th>
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
                var table = $('#gudang-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    pagingType: 'simple_numbers',
                    paging: true,
                    pageLength: 10,
                    ajax: '{!! route('stock.gudang') !!}',
                    columns: [{
                            data: 'id',
                            name: 'id',
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
                            data: 'pelanggan',
                            name: 'pelanggan'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ],
                    initComplete: function() {
                        var api = this.api();
                        var footer = $('#gudang-table tfoot tr');
                        $(footer).appendTo('#gudang-table thead');

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
