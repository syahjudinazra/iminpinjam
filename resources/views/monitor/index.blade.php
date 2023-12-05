@extends('layouts.app')
@extends('layouts.navbar')

@section('content')
    {{-- <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Service Monitoring</h1>
        </div>
    </div> --}}

    {{-- <div class="row justify-content-center">

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Jumlah Service Done</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $servicedone->total() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-list-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Jumlah Service Pending</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $servicepending->total() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-spinner fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Jumlah Service Kanibal</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $kanibal->total() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-gears fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- view data -->
    @foreach ($servicedone as $item)
        <div class="modal fade" id="viewModal{{ $item->id }}" tabindex="-1"
            aria-labelledby="viewModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewModalLabel{{ $item->id }}">View Data </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="tanggal" class="form-label"><b>Tanggal</b></label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal"
                                value="{{ $item->tanggal }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="serialnumber" class="form-label"><b>Serial Number</b></label>
                            <input type="text" class="form-control" id="serialnumber" name="serialnumber"
                                value="{{ $item->serialnumber }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="pelanggan" class="form-label"><b>Pelanggan</b></label>
                            <input type="text" class="form-control" id="pelanggan" name="pelanggan"
                                value="{{ $item->pelanggan }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="model" class="form-label"><b>Model</b></label>
                            <input type="text" class="form-control" id="model" name="model"
                                value="{{ $item->model }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="ram" class="form-label"><b>RAM</b></label>
                            <input type="text" class="form-control" id="ram" name="ram"
                                value="{{ $item->ram }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="android" class="form-label"><b>Android</b></label>
                            <input type="text" class="form-control" id="android" name="android"
                                value="{{ $item->android }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="garansi" class="form-label"><b>Garansi</b></label>
                            <input type="text" class="form-control" id="garansi" name="garansi"
                                value="{{ $item->garansi }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="kerusakan" class="form-label"><b>Kerusakan</b></label>
                            <input type="text" class="form-control" id="kerusakan" name="kerusakan"
                                value="{{ $item->kerusakan }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="teknisi" class="form-label"><b>Teknisi</b></label>
                            <input type="text" class="form-control" id="teknisi" name="teknisi"
                                value="{{ $item->teknisi }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="perbaikan" class="form-label"><b>Perbaikan</b></label>
                            <input type="text" class="form-control" id="perbaikan" name="perbaikan"
                                value="{{ $item->perbaikan }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="snkanibal" class="form-label"><b>SNKanibal</b></label>
                            <input type="text" class="form-control" id="snkanibal" name="snkanibal"
                                value="{{ $item->snkanibal }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="nosparepart" class="form-label"><b>No SparePart</b></label>
                            <input type="text" class="form-control" id="nosparepart" name="nosparepart"
                                value="{{ $item->nosparepart }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="note" class="form-label"><b>Note</b></label>
                            <textarea class="form-control" id="note" name="note" rows="3" readonly>{{ $item->note }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <!-- end view data -->

    <!-- view data -->
    @foreach ($servicepending as $item)
        <div class="modal fade" id="viewModalPending{{ $item->id }}" tabindex="-1"
            aria-labelledby="viewModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewModalLabel{{ $item->id }}">View Data </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="tanggal" class="form-label"><b>Tanggal</b></label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal"
                                value="{{ $item->tanggal }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="serialnumber" class="form-label"><b>Serial Number</b></label>
                            <input type="text" class="form-control" id="serialnumber" name="serialnumber"
                                value="{{ $item->serialnumber }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="pelanggan" class="form-label"><b>Pelanggan</b></label>
                            <input type="text" class="form-control" id="pelanggan" name="pelanggan"
                                value="{{ $item->pelanggan }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="model" class="form-label"><b>Model</b></label>
                            <input type="text" class="form-control" id="model" name="model"
                                value="{{ $item->model }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="ram" class="form-label"><b>RAM</b></label>
                            <input type="text" class="form-control" id="ram" name="ram"
                                value="{{ $item->ram }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="android" class="form-label"><b>Android</b></label>
                            <input type="text" class="form-control" id="android" name="android"
                                value="{{ $item->android }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="garansi" class="form-label"><b>Garansi</b></label>
                            <input type="text" class="form-control" id="garansi" name="garansi"
                                value="{{ $item->garansi }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="kerusakan" class="form-label"><b>Kerusakan</b></label>
                            <input type="text" class="form-control" id="kerusakan" name="kerusakan"
                                value="{{ $item->kerusakan }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="teknisi" class="form-label"><b>Teknisi</b></label>
                            <input type="text" class="form-control" id="teknisi" name="teknisi"
                                value="{{ $item->teknisi }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="perbaikan" class="form-label"><b>Perbaikan</b></label>
                            <input type="text" class="form-control" id="perbaikan" name="perbaikan"
                                value="{{ $item->perbaikan }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="snkanibal" class="form-label"><b>SNKanibal</b></label>
                            <input type="text" class="form-control" id="snkanibal" name="snkanibal"
                                value="{{ $item->snkanibal }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="nosparepart" class="form-label"><b>No SparePart</b></label>
                            <input type="text" class="form-control" id="nosparepart" name="nosparepart"
                                value="{{ $item->nosparepart }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="note" class="form-label"><b>Note</b></label>
                            <textarea class="form-control" id="note" name="note" rows="3" readonly>{{ $item->note }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <!-- end view data -->

    <!-- view data -->
    @foreach ($kanibal as $item)
        <div class="modal fade" id="viewModalKanibal{{ $item->id }}" tabindex="-1"
            aria-labelledby="viewModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewModalLabel{{ $item->id }}">View Data </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="tanggal" class="form-label"><b>Tanggal</b></label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal"
                                value="{{ $item->tanggal }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="serialnumber" class="form-label"><b>Serial Number</b></label>
                            <input type="text" class="form-control" id="serialnumber" name="serialnumber"
                                value="{{ $item->serialnumber }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="pelanggan" class="form-label"><b>Pelanggan</b></label>
                            <input type="text" class="form-control" id="pelanggan" name="pelanggan"
                                value="{{ $item->pelanggan }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="model" class="form-label"><b>Model</b></label>
                            <input type="text" class="form-control" id="model" name="model"
                                value="{{ $item->model }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="ram" class="form-label"><b>RAM</b></label>
                            <input type="text" class="form-control" id="ram" name="ram"
                                value="{{ $item->ram }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="android" class="form-label"><b>Android</b></label>
                            <input type="text" class="form-control" id="android" name="android"
                                value="{{ $item->android }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="garansi" class="form-label"><b>Garansi</b></label>
                            <input type="text" class="form-control" id="garansi" name="garansi"
                                value="{{ $item->garansi }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="kerusakan" class="form-label"><b>Kerusakan</b></label>
                            <input type="text" class="form-control" id="kerusakan" name="kerusakan"
                                value="{{ $item->kerusakan }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="teknisi" class="form-label"><b>Teknisi</b></label>
                            <input type="text" class="form-control" id="teknisi" name="teknisi"
                                value="{{ $item->teknisi }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="perbaikan" class="form-label"><b>Perbaikan</b></label>
                            <input type="text" class="form-control" id="perbaikan" name="perbaikan"
                                value="{{ $item->perbaikan }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="snkanibal" class="form-label"><b>SNKanibal</b></label>
                            <input type="text" class="form-control" id="snkanibal" name="snkanibal"
                                value="{{ $item->snkanibal }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="nosparepart" class="form-label"><b>No SparePart</b></label>
                            <input type="text" class="form-control" id="nosparepart" name="nosparepart"
                                value="{{ $item->nosparepart }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="note" class="form-label"><b>Note</b></label>
                            <textarea class="form-control" id="note" name="note" rows="3" readonly>{{ $item->note }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <!-- end view data -->


    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between">
            <h1 class="h3 mb-0 text-gray-800">Service Done</h1>
            <form method="GET" action="{{ route('search.servicedone') }}" class="d-none d-sm-inline-block form-inline"
                style="float: right">
                <div class="input-group" style="flex-wrap: nowrap;">
                    <div class="form-outline ">
                        <input type="search" id="form1" name="search" class="form-control"
                            value="{{ request()->input('search') }}" />
                        <label class="form-label" for="form1">Search</label>
                    </div>
                    <button type="submit" class="btn btn-danger d-inline">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="container-fluid mt-3">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="bg-danger" style="color:white">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Serial Number</th>
                        <th>Pelanggan</th>
                        <th>Model</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($servicedone as $item)
                        <tr>
                            <td>{{ $servicedone->firstItem() + $loop->index }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                            <td>{{ $item->serialnumber }}</td>
                            <td>{{ $item->pelanggan }}</td>
                            <td>{{ $item->model }}</td>
                            <td>
                                <a href="#" class="btn btn-primary" data-toggle="modal"
                                    data-target="#viewModal{{ $item->id }}"><i class="fa-solid fa-eye"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- {{ $servicedone->appends($_GET)->links() }} --}}
            {{ $servicedone->onEachSide(2)->links('pagination::bootstrap-5') }}
        </div>
    </div>


    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between">
            <h1 class="h3 mb-0 text-gray-800">Service Pending</h1>
            <form method="GET" action="{{ route('search.servicepending') }}"
                class="d-none d-sm-inline-block form-inline" style="float: right">
                <div class="input-group" style="flex-wrap: nowrap;">
                    <div class="form-outline ">
                        <input type="search" id="form1" name="search" class="form-control"
                            value="{{ request()->input('search') }}" />
                        <label class="form-label" for="form1">Search</label>
                    </div>
                    <button type="submit" class="btn btn-danger d-inline">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="container-fluid mt-3">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="bg-warning">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Serial Number</th>
                        <th>Pelanggan</th>
                        <th>Model</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($servicepending as $item)
                        <tr>
                            <td>{{ $servicepending->firstItem() + $loop->index }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                            <td>{{ $item->serialnumber }}</td>
                            <td>{{ $item->pelanggan }}</td>
                            <td>{{ $item->model }}</td>
                            <td>
                                <a href="#" class="btn btn-primary" data-toggle="modal"
                                    data-target="#viewModalPending{{ $item->id }}"><i
                                        class="fa-solid fa-eye"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {!! $servicepending->onEachSide(2)->links('pagination::bootstrap-5') !!}
        </div>
    </div>

    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between">
            <h1 class="h3 mb-0 text-gray-800">Kanibal</h1>
            <form method="GET" action="{{ route('search.kanibal') }}" class="d-none d-sm-inline-block form-inline"
                style="float: right">
                <div class="input-group" style="flex-wrap: nowrap;">
                    <div class="form-outline ">
                        <input type="search" id="form1" name="search" class="form-control"
                            value="{{ request()->input('search') }}" />
                        <label class="form-label" for="form1">Search</label>
                    </div>
                    <button type="submit" class="btn btn-danger d-inline">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="container-fluid mt-3">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="bg-dark" style="color:white">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Serial Number</th>
                        <th>Pelanggan</th>
                        <th>Model</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kanibal as $item)
                        <tr>
                            <td>{{ $kanibal->firstItem() + $loop->index }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                            <td>{{ $item->serialnumber }}</td>
                            <td>{{ $item->pelanggan }}</td>
                            <td>{{ $item->model }}</td>
                            <td>
                                <a href="#" class="btn btn-primary" data-toggle="modal"
                                    data-target="#viewModalKanibal{{ $item->id }}"><i
                                        class="fa-solid fa-eye"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {!! $kanibal->onEachSide(2)->links('pagination::bootstrap-5') !!}
        </div>
    </div>
    </main>
    </div>
    </div>
@endsection
