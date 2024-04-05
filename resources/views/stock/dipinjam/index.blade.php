@extends('layouts.app')
@extends('layouts.navbar')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dipinjam Stocks</h1>
        </div>

        <div class="container-fluid mt-3">
            <table id="dipinjam-table" class="table table-striped table-bordered" style="width:100%">
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
                $('#dipinjam-table').DataTable({
                    processing: true,
                    serverSide: true,
                    pagingType: 'simple_numbers',
                    paging: true,
                    pageLength: 10,
                    ajax: '{!! route('stock.dipinjam') !!}',
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
                        var r = $("#dipinjam-table tfoot tr");
                        r.find("th").each(function() {
                            $(this).css("padding", 8);
                        });
                        $("#dipinjam-table thead").append(r);

                        this.api().columns().every(function() {
                            let column = this;
                            let title = column.header().textContent;

                            // Create input element
                            let input = document.createElement("input");
                            input.placeholder = title;
                            $(input).appendTo($(column.footer()).empty())
                                .on('keyup change', function() {
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
