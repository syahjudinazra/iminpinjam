@extends('layouts.app')
@extends('layouts.navbar')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h2 class="h3 mb-0 text-gray-800">Cek Pengiriman Dipinjam Stocks</h2>
        </div>

        <div class="container-fluid mt-3">
            <div class="overflow-auto">
                <table id="pengirimanDipinjam-table" class="table table-striped table-bordered" style="width:100%">
                    <thead class="headfix">
                        <tr>
                            <th>Kode Pengiriman</th>
                            <th>Serial Number</th>
                            <th>Tipe</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Kode Pengiriman</th>
                            <th>Serial Number</th>
                            <th>Tipe</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    @endsection

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#pengirimanDipinjam-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    pagingType: 'simple_numbers',
                    paging: true,
                    pageLength: 10,
                    ajax: '{!! route('stock.pengirimanDipinjam') !!}',
                    columns: [{
                            data: 'kode_pengiriman',
                            name: 'kode_pengiriman'
                        },
                        {
                            data: 'serialnumber',
                            name: 'serialnumber',
                            render: function(data, type, row) {
                                if (Array.isArray(data)) {
                                    var count = data.length;
                                    var displayedSerials = data.slice(0, 3);
                                    var serialText = displayedSerials.join(', ');

                                    if (count > 3) {
                                        return serialText + ', + more';
                                    } else {
                                        return serialText;
                                    }
                                }
                                return data;
                            }
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
                        var footer = $('#pengirimanDipinjam-table tfoot tr');
                        $(footer).appendTo('#pengirimanDipinjam-table thead');

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
