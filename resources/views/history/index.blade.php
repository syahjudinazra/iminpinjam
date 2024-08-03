@extends('layouts.app')
@extends('layouts.navbar')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <h1 class="h3 mb-3 text-gray-800">History SpareParts</h1>
            <div class="buttonarea d-flex gap-3 justify-content-end mb-3">
                <a href="{{ route('export.sparepartsactivity') }}" class="btn btn text-white float-end"
                    style="background-color: #F05025"><i class="fa-solid fa-download" style="color: #ffffff;"></i> Export
                    Excel</a>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="overflow-auto">
            <table id="hometable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>No SpareParts</th>
                        <th>Tipe</th>
                        <th>Before</th>
                        <th>After</th>
                        <th>Description</th>
                        <th>Date Changes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($historyLog as $item)
                        <tr>
                            <td>{{ $item->causer->name }}</td>
                            <td>
                                @if ($item->subject)
                                    {{ $item->subject->nospareparts }}
                                @endif
                            </td>
                            <td>
                                @if ($item->subject)
                                    {{ $item->subject->tipe }}
                                @endif
                            </td>
                            <td>
                                @if (@is_array($item->changes['old']))
                                    @foreach ($item->changes['old'] as $key => $itemChange)
                                        {{ $key }} : {{ $itemChange }}
                                    @endforeach
                                @endif
                            </td>
                            <td>
                                @if (@is_array($item->changes['attributes']))
                                    @foreach ($item->changes['attributes'] as $key => $itemChange)
                                        {{ $key }} : {{ $itemChange }}
                                    @endforeach
                                @endif
                            </td>
                            <td>{{ $item->description }}</td>
                            <td>{{ $item->created_at->setTimezone('Asia/Jakarta')->format('d/m/Y H:i:s') }}</td>
                        </tr>
                    @endforeach
                </tbody>

                <tfoot>
                    <tr>
                        <th>User</th>
                        <th>No SpareParts</th>
                        <th>Tipe</th>
                        <th>Before</th>
                        <th>After</th>
                        <th>Description</th>
                        <th>Date Changes</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
