@extends('layouts.app')
@extends('layouts.navbar')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <h1 class="h3 mb-3 text-gray-800">Monitor All Stocks</h1>
            @auth
                @if (auth()->user()->hasRole('superadmin') ||
                        auth()->user()->hasRole('jeffri') ||
                        auth()->user()->hasRole('sylvi') ||
                        auth()->user()->hasRole('coni'))
                    <div class="head-area">
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#stockModal">
                            <i class="fa-solid fa-plus"></i> Tambah
                        </button>
                    </div>

                    <div class="buttonarea d-flex gap-3 justify-content-end mb-3">
                        <button type="button" class="btn btn-success text-white" data-bs-toggle="modal"
                            data-target="#importModal"><i class="fa-solid fa-file-import" style="color: #ffffff;"></i>
                            Import Excel
                        </button>
                        <a href="{{ route('export.stocks') }}" class="btn btn text-white float-end"
                            style="background-color: #F05025"><i class="fa-solid fa-download" style="color: #ffffff;"></i>
                            Export
                            Excel</a>
                        <button type="button" class="btn btn-danger text-white" data-bs-toggle="modal" data-target="#moveSN"><i
                                class="fa-solid fa-truck-fast" style="color: #ffffff;"></i>
                            Move SN
                        </button>
                    </div>
                @endif
            @endauth
        </div>
    </div>

    <!-- Move SN Modal -->
    <div class="modal fade" id="moveSN" tabindex="-1" aria-labelledby="moveSNLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="moveSNLabel">Add Serial Numbers</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="serialNumberForm" action="{{ route('stock.checkSerialnumbers') }}" method="POST">
                        @csrf
                        <div class="d-flex gap-4">
                            <textarea class="form-control w-50 shadow-none" id="serialnumber" name="serialnumber" rows="5" cols="30"
                                placeholder="Enter the SN (Multiple Sns Separated by enter)." required></textarea>
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>SN</th>
                                        <th>Pelanggan</th>
                                        <th>Tipe</th>
                                        <th>Status</th>
                                        <th>Message</th>
                                    </tr>
                                </thead>
                                <tbody id="serialNumberTableBody">
                                    <!-- Serial numbers will be dynamically added here -->
                                </tbody>
                            </table>
                        </div>
                        <div id="formValidationInput">

                        </div>
                        <button type="button" id="validateSerialNumber" class="btn btn-outline-danger mt-2">Add SN</button>

                        <div class="form-group mt-4">
                            <label class="font-weight-bold" for="status">Status</label><br />
                            <div class="form-check form-check-inline">
                                <input class="form-check-input mt-1" type="radio" id="gudang" name="status[]"
                                    value="Gudang">
                                <label class="form-check-label" for="gudang">Gudang</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input mt-1" type="radio" id="service" name="status[]"
                                    value="Service">
                                <label class="form-check-label" for="service">Service</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input mt-1" type="radio" id="dipinjam" name="status[]"
                                    value="Dipinjam">
                                <label class="form-check-label" for="dipinjam">Dipinjam</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input mt-1" type="radio" id="terjual" name="status[]"
                                    value="Terjual">
                                <label class="form-check-label" for="terjual">Terjual</label>
                            </div>
                            <div class="form-group mt-3">
                                <label class="font-weight-bold" for="pelanggan">Pelanggan</label>
                                <input type="text" class="form-control shadow-none" id="pelanggan" name="pelanggan"
                                    placeholder="Masukan Pelanggan" value="{{ old('pelanggan') }}" required>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold" for="tanggalkeluar">Tanggal Keluar</label>
                                <input type="date" class="form-control shadow-none" id="tanggalkeluar"
                                    name="tanggalkeluar" placeholder="Masukan Tanggal Keluar"
                                    value="{{ old('tanggalkeluar') }}" required>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold" for="lokasi">Lokasi</label><br />
                            <select id="lokasi" class="form-control form-control-chosen shadow-none" name="lokasi"
                                data-placeholder="Pilih Lokasi" required>
                                    <option value="Null">Pilih Lokasi</option>
                                    <option value="Online">Online</option>
                                    <option value="Pelanggan">Pelanggan</option>
                                    <option value="Partner">Partner</option>
                                    <option value="Surabaya">Surabaya</option>
                                    <option value="Bali">Bali</option>
                                    <option value="Jogja">Jogja</option>
                                    <option value="BSD">BSD</option>
                                    <option value="Jakarta warehouse">Jakarta warehouse</option>
                                    <option value="Service Room">Service Room</option>
                                    <option value="Sales Room">Sales Room</option>
                                    <option value="TSE Room">TSE Room</option>
                                    <option value="Meeting Room">Meeting Room</option>
                                    <option value="Studio">Studio</option>
                            </select>

                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold" for="keterangan">Keterangan</label>
                                <textarea type="text" class="form-control shadow-none" id="keterangan" name="keterangan"
                                    placeholder="Masukan Keterangan">{{ old('keterangan') }}</textarea>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="submitBtn" class="btn btn-danger" data-bs-toggle="modal"
                        data-route="{{ route('update.data') }}" data-csrf="{{ csrf_token() }}">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Move SN Modal -->

    <!-- Import Excel Modal -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Import Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('import.stocks') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="d-flex justify-content-center">
                            <input type="file" name="inputStocks" id="inputStocks" class="form-control"
                                style="width: auto">
                        </div>
                        <a href="{{ route('template.stocks', ['filename' => 'TemplateImportStock.xlsx']) }}"
                            class="d-flex justify-content-center text-decoration-none">Download
                            template</a>
                        <div class="table table-bordered mt-2" id="preview"></div>
                        <h5>Note</h5>
                        <p>Pada template, Mohon isi kolom status dengan Gudang, Service, Dipinjam atau Terjual</p>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button id="importButton" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Tambah Data -->
    <div class="modal fade" id="stockModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Stocks</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="post" action="/stock" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="font-weight-bold" for="serialnumber">Serial Number</label>
                            <input type="text" class="form-control shadow-none" id="serialnumber" name="serialnumber"
                                placeholder="Masukan Serial Number" required value="{{ old('serialnumber') }}">
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold" for="tipe">Tipe Device</label><br />
                            <select id="tipe" class="form-control form-control-chosen shadow-none" name="tipe" required>
                                <option value="Null">Pilih Tipe Device</option>
                                @foreach ($stockDevices as $tipe)
                                <option value="{{ $tipe->name }}">{{ $tipe->name }}
                                </option>
                            @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold" for="sku">SKU</label><br />
                            <select id="sku" class="form-control form-control-chosen shadow-none" name="sku" required>
                                <option value="Null">Pilih SKU</option>
                                @foreach ($stockSku as $sku)
                                <option value="{{ $sku->name }}">{{ $sku->name }}
                                </option>
                            @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold" for="noinvoice">No Invoice</label>
                            <input type="text" class="form-control shadow-none" id="noinvoice" name="noinvoice"
                                placeholder="Masukan No Invoice" value="{{ old('noinvoice') }}">
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold" for="tanggalmasuk">Tanggal Masuk</label>
                            <input type="date" class="form-control shadow-none" id="tanggalmasuk" name="tanggalmasuk"
                                placeholder="Masukan Tanggal Masuk" value="{{ old('tanggalmasuk') }}">
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold" for="tanggalkeluar">Tanggal Keluar</label>
                            <input type="date" class="form-control shadow-none" id="tanggalkeluar"
                                name="tanggalkeluar" placeholder="Masukan Tanggal Keluar"
                                value="{{ old('tanggalkeluar') }}" readonly>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold" for="pelanggan">Pelanggan</label>
                            <input type="text" class="form-control shadow-none" id="pelanggan" name="pelanggan"
                                placeholder="Masukan Pelanggan" value="{{ old('pelanggan') }}">
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold" for="lokasi">Lokasi</label><br />
                        <select id="lokasi" class="form-control form-control-chosen shadow-none" name="lokasi"
                            data-placeholder="Pilih Lokasi" required>
                                <option value="Null">Pilih Lokasi</option>
                                <option value="Online">Online</option>
                                <option value="Pelanggan">Pelanggan</option>
                                <option value="Partner">Partner</option>
                                <option value="Surabaya">Surabaya</option>
                                <option value="Bali">Bali</option>
                                <option value="Jogja">Jogja</option>
                                <option value="BSD">BSD</option>
                                <option value="Jakarta warehouse">Jakarta warehouse</option>
                                <option value="Service Room">Service Room</option>
                                <option value="Sales Room">Sales Room</option>
                                <option value="TSE Room">TSE Room</option>
                                <option value="Meeting Room">Meeting Room</option>
                                <option value="Studio">Studio</option>
                        </select>

                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold" for="keterangan">Keterangan</label>
                            <textarea type="text" class="form-control shadow-none" id="keterangan" name="keterangan"
                                placeholder="Masukan Keterangan">{{ old('keterangan') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold" for="status">Status</label><br />
                            <div class="form-check form-check-inline">
                                <input class="form-check-input mt-1" type="radio" id="gudang" name="status[]"
                                    value="Gudang">
                                <label class="form-check-label" for="gudang">Gudang</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input mt-1" type="radio" id="service" name="status[]"
                                    value="Service">
                                <label class="form-check-label" for="service">Service</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input mt-1" type="radio" id="dipinjam" name="status[]"
                                    value="Dipinjam">
                                <label class="form-check-label" for="dipinjam">Dipinjam</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input mt-1" type="radio" id="terjual" name="status[]"
                                    value="Terjual">
                                <label class="form-check-label" for="terjual">Terjual</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Tambah</button>
                    </div>
                </form>
            </div>
            <!-- End Tambah Data -->
        </div>
    </div>

    <div class="container-fluid mt-3">
        <div style="overflow: auto">
            <table id="stockTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <th>Tipe</th>
                    <th>Gudang</th>
                    <th>Service</th>
                    <th>Dipinjam</th>
                    <th>Terjual</th>
                    <th>Total</th>
                </thead>
                <tbody>
                    @php
                        $displayedTipes = [];
                        $totalCounts = ['Gudang' => 0, 'Service' => 0, 'Dipinjam' => 0, 'Terjual' => 0];
                    @endphp
                    @foreach ($stock as $item)
                        @if (!in_array($item->tipe, $displayedTipes))
                            <tr>
                                <td>{{ $item->tipe }}</td>
                                <td>{{ $countByStatus['Gudang'][$item->tipe] ?? 0 }}</td>
                                <td>{{ $countByStatus['Service'][$item->tipe] ?? 0 }}</td>
                                <td>{{ $countByStatus['Dipinjam'][$item->tipe] ?? 0 }}</td>
                                <td>{{ $countByStatus['Terjual'][$item->tipe] ?? 0 }}</td>
                                <td>
                                    @php
                                        $totalCount =
                                            ($countByStatus['Gudang'][$item->tipe] ?? 0) +
                                            ($countByStatus['Service'][$item->tipe] ?? 0) +
                                            ($countByStatus['Dipinjam'][$item->tipe] ?? 0) +
                                            ($countByStatus['Terjual'][$item->tipe] ?? 0);
                                        $totalCounts['Gudang'] += $countByStatus['Gudang'][$item->tipe] ?? 0;
                                        $totalCounts['Service'] += $countByStatus['Service'][$item->tipe] ?? 0;
                                        $totalCounts['Dipinjam'] += $countByStatus['Dipinjam'][$item->tipe] ?? 0;
                                        $totalCounts['Terjual'] += $countByStatus['Terjual'][$item->tipe] ?? 0;
                                    @endphp
                                    {{ $totalCount }}
                                </td>
                            </tr>
                            @php
                                $displayedTipes[] = $item->tipe;
                            @endphp
                        @endif
                    @endforeach
                    <tr>
                        <td><strong>Total</strong></td>
                        <td>{{ $totalCounts['Gudang'] }}</td>
                        <td>{{ $totalCounts['Service'] }}</td>
                        <td>{{ $totalCounts['Dipinjam'] }}</td>
                        <td>{{ $totalCounts['Terjual'] }}</td>
                        <td>{{ array_sum($totalCounts) }}</td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('js/stockMonitor/importViewStocks.js') }}"></script>
    <script src="{{ asset('js/updateMultipleSN/MoveSN.js') }}"></script>
@endpush
