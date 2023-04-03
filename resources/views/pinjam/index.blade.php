@extends('layouts.app')
@extends('layouts.navbar')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            @if (request()->is('pinjam'))
                <h1 class="h3 mb-0 text-gray-800">Peminjaman Barang</h1>
            @endif
            @if (request()->is('kembali'))
                <h1 class="h3 mb-0 text-gray-800">Pengembalian Barang</h1>
            @endif

            <a href="{{ route('export-pinjam') }}" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
                <i class="fas fa-download fa-sm text-white-50"></i> Generate Excel</a>
        </div>

        @if (request()->is('pinjam'))
            <button type="button" class="btn btn-danger mb-2" data-toggle="modal" data-target="#exampleModal">
                <i class="fa-solid fa-plus"></i> Tambah Produk
            </button>
        @endif

        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form method="GET" action="{{ route('search.index') }}"
            class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search"
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

        <!-- Tambah Data -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Pinjam Barang</h5>


                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" action="/pinjam" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="tanggal" class="form-label"><b>Tanggal</b></label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal">
                            </div>
                            <div class="mb-3">
                                <label for="serialnumber" class="form-label"><b>Serial Number</b></label>
                                <input type="text" class="form-control" id="serialnumber" name="serialnumber"
                                    placeholder="Masukan Serial Number">
                            </div>
                            <div class="form-group mb-3">
                                <label for="device"><b>Tipe Device</b></label>
                                <select class="form-control selectpicker" name="device" id="device"
                                    data-live-search="true" required>
                                    <option value="Pilih Device">Pilih Device</option>
                                    <option value="D1" data-tokens="D1">D1</option>
                                    <option value="D1 Moka" data-tokens="D1 Moka">D1 Moka</option>
                                    <option value="D1-Pro" data-tokens="D1-Pro">D1-Pro</option>
                                    <option value="D1w" data-tokens="D1w">D1w</option>
                                    <option value="D2-401" data-tokens="D2-401">D2-401</option>
                                    <option value="D2-402" data-tokens="D2-402">D2-402</option>
                                    <option value="D2-Pro" data-tokens="D2-Pro">D2-Pro</option>
                                    <option value="D3-504 lama" data-tokens="">D3-504 lama</option>
                                    <option value="D3-505 lama" data-tokens="D3-505 lama">D3-505 lama</option>
                                    <option value="D3-506 lama" data-tokens="D3-506 lama">D3-506 lama</option>
                                    <option value="D3-504" data-tokens="D3-504">D3-504</option>
                                    <option value="D3-505" data-tokens="D3-505">D3-505</option>
                                    <option value="D3-506" data-tokens="D3-506">D3-506</option>
                                    <option value="D3-501 Moka" data-tokens="D3-501 Moka">D3-501 Moka</option>
                                    <option value="D3-503 Moka" data-tokens="D3-503 Moka">D3-503 Moka</option>
                                    <option value="D3 DS1" data-tokens="D3 DS1">D3 DS1</option>
                                    <option value="D3 DS1 Extention Display" data-tokens="D3 DS1 Extention Display">D3 DS1
                                        Extention Display</option>
                                    <option value="D3 DS1 Extention Display TS" data-tokens="D3 DS1 Extention Display TS">
                                        D3
                                        DS1 Extention Display TS</option>
                                    <option value="D4-502" data-tokens="D4-502">D4-502</option>
                                    <option value="D4-503" data-tokens="D4-503">D4-503</option>
                                    <option value="D4-503 White" data-tokens="D4-503 White">D4-503 White</option>
                                    <option value="D4-504" data-tokens="D4-504">D4-504</option>
                                    <option value="D4-504 White" data-tokens="D4-504 White">D4-504 White</option>
                                    <option value="D4-505" data-tokens="D4-505">D4-505</option>
                                    <option value="D4-505 DT" data-tokens="D4-505 DT">D4-505 DT</option>
                                    <option value="D4 Falcon 1" data-tokens="D4 Falcon 1">D4 Falcon 1</option>
                                    <option value="M2-202" data-tokens="M2-202">M2-202</option>
                                    <option value="M2-202 iSeller" data-tokens="M2-202 iSeller">M2-202 iSeller</option>
                                    <option value="M2-203" data-tokens="M2-203">M2-203</option>
                                    <option value="M2-203 iSeller" data-tokens="M2-203 iSeller">M2-203 iSeller</option>
                                    <option value="M2-203 White" data-tokens="M2-203 White">M2-203 White</option>
                                    <option value="M2 Pro" data-tokens="M2 Pro">M2 Pro</option>
                                    <option value="M2 Max" data-tokens="M2 Max">M2 Max</option>
                                    <option value="M2 Swift 1S" data-tokens="M2 Swift 1S">M2 Swift 1S</option>
                                    <option value="M2 Swift 1P" data-tokens="M2 Swift 1P">M2 Swift 1P</option>
                                    <option value="M2 Swift PDA" data-tokens="M2 Swift PDA">M2 Swift PDA</option>
                                    <option value="M2 Swift 1 Scanner" data-tokens="M2 Swift 1 Scanner">M2 Swift 1 Scanner
                                    </option>
                                    <option value="M2 Swift 1 Printer" data-tokens="M2 Swift 1 Printer">M2 Swift 1 Printer
                                    </option>
                                    <option value="R1-201" data-tokens="R1-201">R1-201</option>
                                    <option value="R1-202" data-tokens="R1-202">R1-202</option>
                                    <option value="S1-701" data-tokens="S1-701">S1-701</option>
                                    <option value="K1-101" data-tokens="K1-101">K1-101</option>
                                    <option value="K2-201" data-tokens="K2-201">K2-201</option>
                                    <option value="X1 Scanner" data-tokens="X1 Scanner">X1 Scanner</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="customer" class="form-label"><b>Customer</b></label>
                                <input type="text" class="form-control" id="customer" name="customer"
                                    placeholder="Masukan Nama Customer">
                            </div>
                            <div class="mb-3">
                                <label for="telp" class="form-label"><b>No Telp</b></label>
                                <input type="number" class="form-control" id="telp" name="telp"
                                    placeholder="Masukan No Telp">
                            </div>
                            <div class="mb-3">
                                <label for="pengirim" class="form-label"><b>Pengirim</b></label>
                                <input type="text" class="form-control" id="pengirim" name="pengirim"
                                    placeholder="Masukan Nama Pengirim">
                            </div>
                            <div class="mb-3">
                                <label for="kelengkapankirim" class="form-label"><b>Kelengkapan Kirim</b></label>
                                <textarea class="form-control" id="kelengkapankirim" name="kelengkapankirim" rows="3"
                                    placeholder="Contoh:Adaptor,Dus,Docking"></textarea>
                            </div>
                            {{-- <div class="mb-3">
                            <label for="status" class="form-label"><b>Status</b></label>
                            <input type="text" class="form-control" id="status" name="status" value="0" readonly>
                          </div> --}}
                            <div class="mb-3">
                                <label for="gambar" class="form-label"><b>Gambar</b></label>
                                <input class="form-control" type="file" id="gambar" name="gambar">
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
    </div>

    <!-- add edit Data -->
    @foreach ($pinjam as $item)
        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1"
            aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="{{ route('users.update', $item->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Edit Data Pinjam</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="tanggal" class="form-label"><b>Tanggal</b></label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal"
                                    value="{{ $item->tanggal }}">
                            </div>
                            <div class="mb-3">
                                <label for="serialnumber" class="form-label"><b>Serial Number</b></label>
                                <input type="text" class="form-control" id="serialnumber" name="serialnumber"
                                    value="{{ $item->serialnumber }}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="device"><b>Tipe Device</b></label>
                                <select class="form-control selectpicker" name="device" id="device"
                                    data-live-search="true" required>
                                    <option value="Pilih Model">Pilih Model</option>
                                    <option value="D1" data-tokens="D1"
                                        {{ $item->device == 'D1' ? 'selected' : '' }}>
                                        D1</option>
                                    <option value="D1 Moka" data-tokens="D1 Moka"
                                        {{ $item->device == 'D1 Moka' ? 'selected' : '' }}>D1 Moka</option>
                                    <option value="D1-Pro" data-tokens="D1-Pro"
                                        {{ $item->device == 'D1-Pro' ? 'selected' : '' }}>D1-Pro</option>
                                    <option value="D1w" data-tokens="D1w"
                                        {{ $item->device == 'D1w' ? 'selected' : '' }}>D1w</option>
                                    <option value="D2-401" data-tokens="D2-401"
                                        {{ $item->device == 'D2-401' ? 'selected' : '' }}>D2-401</option>
                                    <option value="D2-402" data-tokens="D2-402"
                                        {{ $item->device == 'D2-402' ? 'selected' : '' }}>D2-402</option>
                                    <option value="D2-Pro" data-tokens="D2-Pro"
                                        {{ $item->device == 'D2-Pro' ? 'selected' : '' }}>D2-Pro</option>
                                    <option value="D3 504 lama" data-tokens="D3 504 lama"
                                        {{ $item->device == 'D3 504 lama' ? 'selected' : '' }}>D3 504 lama</option>
                                    <option value="D3 505 lama" data-tokens="D3 505 lama"
                                        {{ $item->device == 'D3 505 lama' ? 'selected' : '' }}>D3 505 lama</option>
                                    <option value="D3 506 lama" data-tokens="D3 506 lama"
                                        {{ $item->device == 'D3 506 lama' ? 'selected' : '' }}>D3 506 lama</option>
                                    <option value="D3-504" data-tokens="D3-504"
                                        {{ $item->device == 'D3-504' ? 'selected' : '' }}>D3-504</option>
                                    <option value="D3-505" data-tokens="D3-505"
                                        {{ $item->device == 'D3-505' ? 'selected' : '' }}>D3-505</option>
                                    <option value="D3-506" data-tokens="D3-506"
                                        {{ $item->device == 'D3-506' ? 'selected' : '' }}>D3-506</option>
                                    <option value="D3-501 Moka" data-tokens="D3-501 Moka"
                                        {{ $item->device == 'D3-501 Moka' ? 'selected' : '' }}>D3-501 Moka</option>
                                    <option value="D3-503 Moka" data-tokens="D3-503 Moka"
                                        {{ $item->device == 'D3-503 Moka' ? 'selected' : '' }}>D3-503 Moka</option>
                                    <option value="D3 DS1" data-tokens="D3 DS1"
                                        {{ $item->device == 'D3 DS1' ? 'selected' : '' }}>D3 DS1</option>
                                    <option value="D3 DS1 Extention Display" data-tokens="D3 DS1 Extention Display"
                                        {{ $item->device == 'D3 DS1 Extention Display' ? 'selected' : '' }}>D3 DS1
                                        Extention Display</option>
                                    <option value="D3 DS1 Extention Display TS" data-tokens="D3 DS1 Extention Display TS"
                                        {{ $item->device == 'D3 DS1 Extention Display TS' ? 'selected' : '' }}>D3 DS1
                                        Extention Display TS</option>
                                    <option value="D4-502" data-tokens="D4-502"
                                        {{ $item->device == 'D4-502' ? 'selected' : '' }}>D4-502</option>
                                    <option value="D4-503" data-tokens="D4-503"
                                        {{ $item->device == 'D4-503' ? 'selected' : '' }}>D4-503</option>
                                    <option value="D4-503 White" data-tokens="D4-503 White"
                                        {{ $item->device == 'D4-503 White' ? 'selected' : '' }}>D4-503 White</option>
                                    <option value="D4-504" data-tokens="D4-504"
                                        {{ $item->device == 'D4-504' ? 'selected' : '' }}>D4-504</option>
                                    <option value="D4-504 White" data-tokens="D4-504 White"
                                        {{ $item->device == 'D4-504 White' ? 'selected' : '' }}>D4-504 White</option>
                                    <option value="D4-505" data-tokens="D4-505"
                                        {{ $item->device == 'D4-505' ? 'selected' : '' }}>D4-505</option>
                                    <option value="D4-505 DT" data-tokens="D4-505 DT"
                                        {{ $item->device == 'D4-505 DT' ? 'selected' : '' }}>D4-505 DT</option>
                                    <option value="D4 Falcon 1" data-tokens="D4 Falcon 1"
                                        {{ $item->device == 'D4 Falcon 1' ? 'selected' : '' }}>D4 Falcon 1</option>
                                    <option value="M2-202" data-tokens="M2-202"
                                        {{ $item->device == 'M2-202' ? 'selected' : '' }}>M2-202</option>
                                    <option value="M2-202 iSeller" data-tokens="M2-202 iSeller"
                                        {{ $item->device == 'M2-202 iSeller' ? 'selected' : '' }}>M2-202 iSeller</option>
                                    <option value="M2-203" data-tokens="M2-203"
                                        {{ $item->device == 'M2-203' ? 'selected' : '' }}>M2-203</option>
                                    <option value="M2-203 iSeller" data-tokens="M2-203 iSeller"
                                        {{ $item->device == 'M2-203 iSeller' ? 'selected' : '' }}>M2-203 iSeller</option>
                                    <option value="M2-203 White" data-tokens="M2-203 White"
                                        {{ $item->device == 'M2-203 White' ? 'selected' : '' }}>M2-203 White</option>
                                    <option value="M2 Pro" data-tokens="M2 Pro"
                                        {{ $item->device == 'M2 Pro' ? 'selected' : '' }}>M2 Pro</option>
                                    <option value="M2 Max" data-tokens="M2 Max"
                                        {{ $item->device == 'M2 Max' ? 'selected' : '' }}>M2 Max</option>
                                    <option value="M2 Swift 1S" data-tokens="M2 Swift 1S"
                                        {{ $item->device == 'M2 Swift 1S' ? 'selected' : '' }}>M2 Swift 1S</option>
                                    <option value="M2 Swift 1P" data-tokens="M2 Swift 1P"
                                        {{ $item->device == 'M2 Swift 1P' ? 'selected' : '' }}>M2 Swift 1P</option>
                                    <option value="M2 Swift PDA" data-tokens="M2 Swift PDA"
                                        {{ $item->device == 'M2 Swift PDA' ? 'selected' : '' }}>M2 Swift PDA</option>
                                    <option value="M2 Swift 1 Scanner" data-tokens="M2 Swift 1 Scanner"
                                        {{ $item->device == 'M2 Swift 1 Scanner' ? 'selected' : '' }}>M2 Swift 1 Scanner
                                    </option>
                                    <option value="M2 Swift 1 Printer" data-tokens="M2 Swift 1 Printer"
                                        {{ $item->device == 'M2 Swift 1 Printer' ? 'selected' : '' }}>M2 Swift 1 Printer
                                    </option>
                                    <option value="R1 201" data-tokens="R1 201"
                                        {{ $item->device == 'R1 201' ? 'selected' : '' }}>R1 201</option>
                                    <option value="R1 202" data-tokens="R1 202"
                                        {{ $item->device == 'R1 202' ? 'selected' : '' }}>R1 202</option>
                                    <option value="S1 701" data-tokens="S1 701"
                                        {{ $item->device == 'S1 701' ? 'selected' : '' }}>S1 701</option>
                                    <option value="K1 101" data-tokens="K1 101"
                                        {{ $item->device == 'K1 101' ? 'selected' : '' }}>K1 101</option>
                                    <option value="K2 201" data-tokens="K1 201"
                                        {{ $item->device == 'K2 201' ? 'selected' : '' }}>K2 201</option>
                                    <option value="X1 Scanner" data-tokens="X1 Scanner"
                                        {{ $item->device == 'X1 Scanner' ? 'selected' : '' }}>X1 Scanner</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="customer" class="form-label"><b>Customer</b></label>
                                <input type="text" class="form-control" id="customer" name="customer"
                                    value="{{ $item->customer }}">
                            </div>
                            <div class="mb-3">
                                <label for="telp" class="form-label"><b>No Telp</b></label>
                                <input type="number" class="form-control" id="telp" name="telp"
                                    value="{{ $item->telp }}">
                            </div>
                            <div class="mb-3">
                                <label for="pengirim" class="form-label"><b>Pengirim</b></label>
                                <input type="text" class="form-control" id="pengirim" name="pengirim"
                                    value="{{ $item->pengirim }}">
                            </div>
                            <div class="mb-3">
                                <label for="kelengkapankirim" class="form-label"><b>Kelengkapan Kirim</b></label>
                                <textarea class="form-control" id="kelengkapankirim" name="kelengkapankirim" rows="3"
                                    placeholder="Contoh:Adaptor,Dus,Docking">{{ $item->kelengkapankirim }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label"><b>Status</b></label>
                                <input type="text" class="form-control" id="status" name="status"
                                    value="{{ $item->status }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="gambar" class="form-label"><b>Gambar</b></label><br>
                                <input class="form-control" type="file" id="gambar" name="gambar">
                                {{-- <img src="{{ asset('storage/gambar/'.$item->gambar) }}" width= '60' height='60' class="img img-responsive"> --}}
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-warning">Edit Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
    <!-- end edit data -->

    <!-- view data -->
    @foreach ($pinjam as $item)
        <div class="modal fade" id="viewModal{{ $item->id }}" tabindex="-1"
            aria-labelledby="viewModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewModalLabel{{ $item->id }}">View Data Pinjam</h5>
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
                            <label for="device" class="form-label"><b>Device</b></label>
                            <input type="text" class="form-control" id="device" name="device"
                                value="{{ $item->device }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="customer" class="form-label"><b>Customer</b></label>
                            <input type="text" class="form-control" id="customer" name="customer"
                                value="{{ $item->customer }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="telp" class="form-label"><b>No Telp</b></label>
                            <input type="number" class="form-control" id="telp" name="telp"
                                value="{{ $item->telp }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="pengirim" class="form-label"><b>Pengirim</b></label>
                            <input type="text" class="form-control" id="pengirim" name="pengirim"
                                value="{{ $item->pengirim }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="kelengkapankirim" class="form-label"><b>Kelengkapan Kirim</b></label>
                            <textarea class="form-control" id="kelengkapankirim" name="kelengkapankirim" rows="3" readonly>{{ $item->kelengkapankirim }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="gambar" class="form-label"><b>Gambar</b></label><br>
                            <img src="{{ url('/storage/gambar/' . $item->gambar) }}" width='60' height='60'
                                class="img img-responsive" id="gambar" name="gambar">
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

    <!-- delete data -->
    @foreach ($pinjam as $item)
        <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1"
            aria-labelledby="deleteModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel{{ $item->id }}">Delete Data Pinjam</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this Data?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <form action="{{ route('users.destroy', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <!-- end delete data -->

    <!-- Move data -->
    @foreach ($pinjam as $item)
        <div class="modal fade" id="moveModal{{ $item->id }}" tabindex="-1"
            aria-labelledby="moveModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="{{ route('users.update', $item->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="moveModalLabel{{ $item->id }}">Ajukan Pengembalian</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="tanggal" class="form-label"><b>Tanggal</b></label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal"
                                    value="{{ $item->tanggal }}"readonly>
                            </div>
                            <div class="mb-3">
                                <label for="gambar" class="form-label"><b>Gambar</b></label>
                                <input class="form-control" type="file" id="gambar" name="gambar"
                                    value="{{ $item->gambar }}"readonly>
                            </div>
                            <div class="mb-3">
                                <label for="serialnumber" class="form-label"><b>Serial Number</b></label>
                                <input type="text" class="form-control" id="serialnumber" name="serialnumber"
                                    value="{{ $item->serialnumber }}"readonly>
                            </div>
                            <div class="mb-3">
                                <label for="device" class="form-label"><b>Device</b></label>
                                <input type="text" class="form-control" id="device" name="device"
                                    value="{{ $item->device }}"readonly>
                            </div>
                            <div class="mb-3">
                                <label for="customer" class="form-label"><b>Customer</b></label>
                                <input type="text" class="form-control" id="customer" name="customer"
                                    value="{{ $item->customer }}"readonly>
                            </div>
                            <div class="mb-3">
                                <label for="telp" class="form-label"><b>No Telp</b></label>
                                <input type="number" class="form-control" id="telp" name="telp"
                                    value="{{ $item->telp }}"readonly>
                            </div>
                            <div class="mb-3">
                                <label for="pengirim" class="form-label"><b>Pengirim</b></label>
                                <input type="text" class="form-control" id="pengirim" name="pengirim"
                                    value="{{ $item->pengirim }}"readonly>
                            </div>
                            <div class="mb-3">
                                <label for="kelengkapankirim" class="form-label"><b>Kelengkapan Kirim</b></label>
                                <textarea class="form-control" id="kelengkapankirim" name="kelengkapankirim" rows="3"
                                    placeholder="Contoh:Adaptor,Dus,Docking" readonly>{{ $item->kelengkapankirim }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="tanggalkembali" class="form-label"><b>Tanggal Kembali</b></label>
                                <input type="date" class="form-control" id="tanggalkembali" name="tanggalkembali">
                            </div>
                            <div class="mb-3">
                                <label for="penerima" class="form-label"><b>Penerima</b></label>
                                <input type="text" class="form-control" id="penerima" name="penerima"
                                    placeholder="Masukan Nama Penerima">
                            </div>
                            <div class="mb-3">
                                <label for="kelengkapankembali" class="form-label"><b>Kelengkapan Kirim</b></label>
                                <textarea class="form-control" id="kelengkapankembali" name="kelengkapankembali" rows="3"
                                    placeholder="Contoh:Adaptor,Dus,Docking"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label"><b>Status</b></label>
                                <input type="text" class="form-control" id="status" name="status" value="1"
                                    readonly>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">Pindah Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
    <!-- End Move data -->

    <!-- view kembali data -->
    @foreach ($pinjam as $item)
        <div class="modal fade" id="viewkembaliModal{{ $item->id }}" tabindex="-1"
            aria-labelledby="viewkembaliModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewModalLabel{{ $item->id }}">View Data Pinjam</h5>
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
                            <label for="device" class="form-label"><b>Device</b></label>
                            <input type="text" class="form-control" id="device" name="device"
                                value="{{ $item->device }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="customer" class="form-label"><b>Customer</b></label>
                            <input type="text" class="form-control" id="customer" name="customer"
                                value="{{ $item->customer }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="telp" class="form-label"><b>No Telp</b></label>
                            <input type="number" class="form-control" id="telp" name="telp"
                                value="{{ $item->telp }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="pengirim" class="form-label"><b>Pengirim</b></label>
                            <input type="text" class="form-control" id="pengirim" name="pengirim"
                                value="{{ $item->pengirim }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="kelengkapankirim" class="form-label"><b>Kelengkapan Kirim</b></label>
                            <textarea class="form-control" id="kelengkapankirim" name="kelengkapankirim" rows="3" readonly>{{ $item->kelengkapankirim }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="tanggalkembali" class="form-label"><b>Tanggal Kembali</b></label>
                            <input type="date" class="form-control" id="tanggalkembali" name="tanggalkembali"
                                value="{{ $item->tanggalkembali }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="penerima" class="form-label"><b>Penerima</b></label>
                            <input type="text" class="form-control" id="penerima" name="penerima"
                                value="{{ $item->penerima }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="kelengkapankembali" class="form-label"><b>Kelengkapan Kembali</b></label>
                            <textarea class="form-control" id="kelengkapankembali" name="kelengkapankembali" rows="3" readonly>{{ $item->kelengkapankembali }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="gambar" class="form-label"><b>Gambar</b></label><br>
                            <img src="{{ url('/storage/gambar/' . $item->gambar) }}" width='60' height='60'
                                class="img img-responsive" id="gambar" name="gambar">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <!-- end view kembali data -->

    <!-- add kembali edit Data -->
    @foreach ($pinjam as $item)
        <div class="modal fade" id="editkembaliModal{{ $item->id }}" tabindex="-1"
            aria-labelledby="editkembaliModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="{{ route('users.update', $item->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Edit Data Pinjam</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="tanggal" class="form-label"><b>Tanggal</b></label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal"
                                    value="{{ $item->tanggal }}">
                            </div>
                            <div class="mb-3">
                                <label for="serialnumber" class="form-label"><b>Serial Number</b></label>
                                <input type="text" class="form-control" id="serialnumber" name="serialnumber"
                                    value="{{ $item->serialnumber }}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="device"><b>Tipe Device</b></label>
                                <select class="form-control selectpicker" name="device" id="device"
                                    data-live-search="true" required>
                                    <option value="Pilih Model">Pilih Model</option>
                                    <option value="D1" data-tokens="D1"
                                        {{ $item->device == 'D1' ? 'selected' : '' }}>D1</option>
                                    <option value="D1 Moka" data-tokens="D1 Moka"
                                        {{ $item->device == 'D1 Moka' ? 'selected' : '' }}>D1 Moka</option>
                                    <option value="D1-Pro" data-tokens="D1-Pro"
                                        {{ $item->device == 'D1-Pro' ? 'selected' : '' }}>D1-Pro</option>
                                    <option value="D1w" data-tokens="D1w"
                                        {{ $item->device == 'D1w' ? 'selected' : '' }}>D1w</option>
                                    <option value="D2-401" data-tokens="D2-401"
                                        {{ $item->device == 'D2-401' ? 'selected' : '' }}>D2-401</option>
                                    <option value="D2-402" data-tokens="D2-402"
                                        {{ $item->device == 'D2-402' ? 'selected' : '' }}>D2-402</option>
                                    <option value="D2-Pro" data-tokens="D2-Pro"
                                        {{ $item->device == 'D2-Pro' ? 'selected' : '' }}>D2-Pro</option>
                                    <option value="D3 504 lama" data-tokens="D3 504 lama"
                                        {{ $item->device == 'D3 504 lama' ? 'selected' : '' }}>D3 504 lama</option>
                                    <option value="D3 505 lama" data-tokens="D3 505 lama"
                                        {{ $item->device == 'D3 505 lama' ? 'selected' : '' }}>D3 505 lama</option>
                                    <option value="D3 506 lama" data-tokens="D3 506 lama"
                                        {{ $item->device == 'D3 506 lama' ? 'selected' : '' }}>D3 506 lama</option>
                                    <option value="D3-504" data-tokens="D3-504"
                                        {{ $item->device == 'D3-504' ? 'selected' : '' }}>D3-504</option>
                                    <option value="D3-505" data-tokens="D3-505"
                                        {{ $item->device == 'D3-505' ? 'selected' : '' }}>D3-505</option>
                                    <option value="D3-506" data-tokens="D3-506"
                                        {{ $item->device == 'D3-506' ? 'selected' : '' }}>D3-506</option>
                                    <option value="D3-501 Moka" data-tokens="D3-501 Moka"
                                        {{ $item->device == 'D3-501 Moka' ? 'selected' : '' }}>D3-501 Moka</option>
                                    <option value="D3-503 Moka" data-tokens="D3-503 Moka"
                                        {{ $item->device == 'D3-503 Moka' ? 'selected' : '' }}>D3-503 Moka</option>
                                    <option value="D3 DS1" data-tokens="D3 DS1"
                                        {{ $item->device == 'D3 DS1' ? 'selected' : '' }}>D3 DS1</option>
                                    <option value="D3 DS1 Extention Display" data-tokens="D3 DS1 Extention Display"
                                        {{ $item->device == 'D3 DS1 Extention Display' ? 'selected' : '' }}>D3 DS1
                                        Extention Display</option>
                                    <option value="D3 DS1 Extention Display TS" data-tokens="D3 DS1 Extention Display TS"
                                        {{ $item->device == 'D3 DS1 Extention Display TS' ? 'selected' : '' }}>D3 DS1
                                        Extention Display TS</option>
                                    <option value="D4-502" data-tokens="D4-502"
                                        {{ $item->device == 'D4-502' ? 'selected' : '' }}>D4-502</option>
                                    <option value="D4-503" data-tokens="D4-503"
                                        {{ $item->device == 'D4-503' ? 'selected' : '' }}>D4-503</option>
                                    <option value="D4-503 White" data-tokens="D4-503 White"
                                        {{ $item->device == 'D4-503 White' ? 'selected' : '' }}>D4-503 White</option>
                                    <option value="D4-504" data-tokens="D4-504"
                                        {{ $item->device == 'D4-504' ? 'selected' : '' }}>D4-504</option>
                                    <option value="D4-504 White" data-tokens="D4-504 White"
                                        {{ $item->device == 'D4-504 White' ? 'selected' : '' }}>D4-504 White</option>
                                    <option value="D4-505" data-tokens="D4-505"
                                        {{ $item->device == 'D4-505' ? 'selected' : '' }}>D4-505</option>
                                    <option value="D4-505 DT" data-tokens="D4-505 DT"
                                        {{ $item->device == 'D4-505 DT' ? 'selected' : '' }}>D4-505 DT</option>
                                    <option value="D4 Falcon 1" data-tokens="D4 Falcon 1"
                                        {{ $item->device == 'D4 Falcon 1' ? 'selected' : '' }}>D4 Falcon 1</option>
                                    <option value="M2-202" data-tokens="M2-202"
                                        {{ $item->device == 'M2-202' ? 'selected' : '' }}>M2-202</option>
                                    <option value="M2-202 iSeller" data-tokens="M2-202 iSeller"
                                        {{ $item->device == 'M2-202 iSeller' ? 'selected' : '' }}>M2-202 iSeller</option>
                                    <option value="M2-203" data-tokens="M2-203"
                                        {{ $item->device == 'M2-203' ? 'selected' : '' }}>M2-203</option>
                                    <option value="M2-203 iSeller" data-tokens="M2-203 iSeller"
                                        {{ $item->device == 'M2-203 iSeller' ? 'selected' : '' }}>M2-203 iSeller</option>
                                    <option value="M2-203 White" data-tokens="M2-203 White"
                                        {{ $item->device == 'M2-203 White' ? 'selected' : '' }}>M2-203 White</option>
                                    <option value="M2 Pro" data-tokens="M2 Pro"
                                        {{ $item->device == 'M2 Pro' ? 'selected' : '' }}>M2 Pro</option>
                                    <option value="M2 Max" data-tokens="M2 Max"
                                        {{ $item->device == 'M2 Max' ? 'selected' : '' }}>M2 Max</option>
                                    <option value="M2 Swift 1S" data-tokens="M2 Swift 1S"
                                        {{ $item->device == 'M2 Swift 1S' ? 'selected' : '' }}>M2 Swift 1S</option>
                                    <option value="M2 Swift 1P" data-tokens="M2 Swift 1P"
                                        {{ $item->device == 'M2 Swift 1P' ? 'selected' : '' }}>M2 Swift 1P</option>
                                    <option value="M2 Swift PDA" data-tokens="M2 Swift PDA"
                                        {{ $item->device == 'M2 Swift PDA' ? 'selected' : '' }}>M2 Swift PDA</option>
                                    <option value="M2 Swift 1 Scanner" data-tokens="M2 Swift 1 Scanner"
                                        {{ $item->device == 'M2 Swift 1 Scanner' ? 'selected' : '' }}>M2 Swift 1 Scanner
                                    </option>
                                    <option value="M2 Swift 1 Printer" data-tokens="M2 Swift 1 Printer"
                                        {{ $item->device == 'M2 Swift 1 Printer' ? 'selected' : '' }}>M2 Swift 1 Printer
                                    </option>
                                    <option value="R1 201" data-tokens="R1 201"
                                        {{ $item->device == 'R1 201' ? 'selected' : '' }}>R1 201</option>
                                    <option value="R1 202" data-tokens="R1 202"
                                        {{ $item->device == 'R1 202' ? 'selected' : '' }}>R1 202</option>
                                    <option value="S1 701" data-tokens="S1 701"
                                        {{ $item->device == 'S1 701' ? 'selected' : '' }}>S1 701</option>
                                    <option value="K1 101" data-tokens="K1 101"
                                        {{ $item->device == 'K1 101' ? 'selected' : '' }}>K1 101</option>
                                    <option value="K2 201" data-tokens="K1 201"
                                        {{ $item->device == 'K2 201' ? 'selected' : '' }}>K2 201</option>
                                    <option value="X1 Scanner" data-tokens="X1 Scanner"
                                        {{ $item->device == 'X1 Scanner' ? 'selected' : '' }}>X1 Scanner</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="customer" class="form-label"><b>Customer</b></label>
                                <input type="text" class="form-control" id="customer" name="customer"
                                    value="{{ $item->customer }}">
                            </div>
                            <div class="mb-3">
                                <label for="telp" class="form-label"><b>No Telp</b></label>
                                <input type="number" class="form-control" id="telp" name="telp"
                                    value="{{ $item->telp }}">
                            </div>
                            <div class="mb-3">
                                <label for="pengirim" class="form-label"><b>Pengirim</b></label>
                                <input type="text" class="form-control" id="pengirim" name="pengirim"
                                    value="{{ $item->pengirim }}">
                            </div>
                            <div class="mb-3">
                                <label for="kelengkapankirim" class="form-label"><b>Kelengkapan Kirim</b></label>
                                <textarea class="form-control" id="kelengkapankirim" name="kelengkapankirim" rows="3"
                                    placeholder="Contoh:Adaptor,Dus,Docking">{{ $item->kelengkapankirim }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="tanggalkembali" class="form-label"><b>Tanggal Kembali</b></label>
                                <input type="date" class="form-control" id="tanggalkembali" name="tanggalkembali"
                                    value="{{ $item->tanggalkembali }}">
                            </div>
                            <div class="mb-3">
                                <label for="penerima" class="form-label"><b>Penerima</b></label>
                                <input type="text" class="form-control" id="penerima" name="penerima"
                                    value="{{ $item->penerima }}">
                            </div>
                            <div class="mb-3">
                                <label for="kelengkapankembali" class="form-label"><b>Kelengkapan Kembali</b></label>
                                <textarea class="form-control" id="kelengkapankembali" name="kelengkapankembali" rows="3"
                                    placeholder="Contoh:Adaptor,Dus,Docking">{{ $item->kelengkapankembali }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label"><b>Status</b></label>
                                <input type="text" class="form-control" id="status" name="status"
                                    value="{{ $item->status }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="gambar" class="form-label"><b>Gambar</b></label><br>
                                <input class="form-control" type="file" id="gambar" name="gambar">
                                {{-- <img src="{{ asset('storage/gambar/'.$item->gambar) }}" width= '60' height='60' class="img img-responsive"> --}}
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-warning">Edit Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
    <!-- end kembali edit data -->

    <div class="container-fluid scroll mt-3 ">
        <table class="table table-striped table-hover table-bordered">
            <thead class="table-dark headfix">
                <th>No</th>
                <th>Tanggal</th>
                {{-- <th>Gambar</th> --}}
                <th>Serial Number</th>
                <th>Tipe Device</th>
                <th>Customer</th>
                <th>Action</th>
            </thead>
            <tbody>
                @foreach ($pinjam as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                        {{-- <td>
                    <img src="{{ url('/storage/gambar/'. $item->gambar ) }}" width= '60' height='60' class="img img-responsive" />
                </td> --}}
                        <td>{{ $item->serialnumber }}</td>
                        <td>{{ $item->device }}</td>
                        <td>{{ $item->customer }}</td>
                        <td>
                            @if (request()->is('pinjam'))
                                <a href="#" class="btn btn-warning" data-toggle="modal"
                                    data-target="#editModal{{ $item->id }}"><i
                                        class="fa-solid fa-pen-to-square"></i></a>
                            @endif

                            @if (request()->is('pinjam'))
                                <a href="#" class="btn btn-primary" data-toggle="modal"
                                    data-target="#viewModal{{ $item->id }}"><i class="fa-solid fa-eye"></i></a>
                            @endif

                            @if (request()->is('kembali'))
                                <a href="#" class="btn btn-warning" data-toggle="modal"
                                    data-target="#editkembaliModal{{ $item->id }}"><i
                                        class="fa-solid fa-pen-to-square"></i></a>
                            @endif

                            @if (request()->is('kembali'))
                                <a href="#" class="btn btn-primary" data-toggle="modal"
                                    data-target="#viewkembaliModal{{ $item->id }}"><i
                                        class="fa-solid fa-eye"></i></a>
                            @endif

                            <a href="#" class="btn btn-danger" data-toggle="modal"
                                data-target="#deleteModal{{ $item->id }}"><i class="fa-solid fa-trash"></i></a>

                            @if (request()->is('pinjam'))
                                <a href="#" class="btn btn-success" data-toggle="modal"
                                    data-target="#moveModal{{ $item->id }}"><i
                                        class="fa-solid fa-paper-plane"></i></a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{-- @if (request()->is('pinjam'))
            {!! $pinjam->onEachSide(10)->links('pagination::bootstrap-5') !!}
        @endif --}}
    </div>
@endsection
