@extends('layouts.app')
@extends('layouts.navbar')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <h1 class="h3 mb-3 text-gray-800">History Stocks</h1>
        </div>
    </div>

    <div class="container-fluid">
        <div class="overflow-auto">
            <table id="stockHistory-table" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Serial Numbers</th>
                        <th>Tipe</th>
                        <th>Before</th>
                        <th>After</th>
                        <th>Description</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>User</th>
                        <th>Serial Numbers</th>
                        <th>Tipe</th>
                        <th>Before</th>
                        <th>After</th>
                        <th>Description</th>
                        <th>Date</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            var table = $('#stockHistory-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pagingType: 'simple_numbers',
                paging: true,
                pageLength: 10,
                ajax: '{!! route('stock.history') !!}',
                columns: [{
                        data: 'causer.name',
                        name: 'causer.name'
                    },
                    {
                        data: 'subject.serialnumber',
                        name: 'subject.serialnumber'
                    },
                    {
                        data: 'subject.tipe',
                        name: 'subject.tipe'
                    },
                    {
                        data: 'properties.old',
                        name: 'properties.old'
                    },
                    {
                        data: 'properties.attributes',
                        name: 'properties.attributes'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    }
                ],
                initComplete: function() {
                    var api = this.api();
                    var footer = $('#stockHistory-table tfoot tr');
                    $(footer).appendTo('#stockHistory-table thead');

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
