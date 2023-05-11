@extends('layouts.app')
@extends('layouts.navbar')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Service Pending</h1>

            <a href="{{ route('export-servicepending') }}" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
                <i class="fas fa-download fa-sm text-white-50"></i> Generate Excel</a>
        </div>

        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (Auth::check())
            <div class="searchpending">
                @if (Auth::check())
                    <button type="button" class="btn btn-danger mb-2" data-toggle="modal" data-target="#exampleModal">
                        <i class="fa-solid fa-plus"></i> Tambah Produk
                    </button>
                @endif

                <form method="GET" action="{{ route('search.servicepending') }}"
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
            </div>
        @else
            <div class="searchpending" style="margin-bottom: 80px">
                @if (Auth::check())
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

                <form method="GET" action="{{ route('search.servicepending') }}"
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
            </div>
        @endif
        <!-- Tambah Data -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Service Done</h5>


                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" action="/servicepending" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="tanggal"><b>Tanggal</b></label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal"
                                    placeholder="Masukan Tanggal" required autofocus value="{{ old('tanggal') }}">
                            </div>
                            <div class="form-group">
                                <label for="serialnumber"><b>Serial Number</b></label>
                                <input type="text" class="form-control" id="serialnumber" name="serialnumber"
                                    placeholder="Masukan Serial Number" required value="{{ old('serialnumber') }}">
                            </div>
                            <div class="form-group">
                                <label for="pelanggan"><b>Pelanggan</b></label>
                                <input type="text" class="form-control" id="pelanggan" name="pelanggan"
                                    placeholder="Masukan Nama Pelanggan" value="{{ old('pelanggan') }}">
                            </div>
                            <div class="form-group">
                                <label for="model"><b>Model</b></label>
                                <select class="form-control selectpicker" name="model" id="model"
                                    data-live-search="true" required>
                                    <option value="Pilih Model">Pilih Model</option>
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
                            <div class="form-group">
                                <label for="ram"><b>RAM/Storage</b></label>
                                <select class="form-control" id="ram" name="ram" value="{{ old('ram') }}"
                                    required>
                                    <option>Pilih RAM/Storage</option>
                                    <option>-</option>
                                    <option>1/8</option>
                                    <option>2/8</option>
                                    <option>2/16</option>
                                    <option>4/16</option>
                                    <option>4/32</option>
                                    <option>4/64</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="android"><b>Versi Android</b></label>
                                <select class="form-control" id="android" name="android" value="{{ old('android') }}"
                                    required>
                                    <option>Pilih Versi Android</option>
                                    <option>-</option>
                                    <option>Android 7</option>
                                    <option>Android 11</option>
                                    <option>Android 11 GMS</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="garansi"><b>Garansi</b></label>
                                <select class="form-control" id="garansi" name="garansi" value="{{ old('garansi') }}"
                                    required>
                                    <option>Pilih Garansi</option>
                                    <option>DOA (Garansi)</option>
                                    <option>RMA (Garansi)</option>
                                    <option>RMA (Tidak Garansi)</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="kerusakan"><b>Kerusakan</b></label>
                                <input type="text" class="form-control" id="kerusakan" name="kerusakan"
                                    placeholder="Masukan Kerusakan" value="{{ old('kerusakan') }}">
                            </div>

                            <div class="form-group">
                                <label for="teknisi"><b>Teknisi</b></label>
                                <select class="form-control" id="teknisi" name="teknisi" required>
                                    <option>Pilih Teknisi</option>
                                    <option>Khaerul</option>
                                    <option>Ozi</option>
                                    <option>Alfian</option>
                                    <option>Other</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="perbaikan"><b>Perbaikan</b></label>
                                <input type="text" class="form-control" id="perbaikan" name="perbaikan"
                                    placeholder="Masukan Perbaikan" value="{{ old('perbaikan') }}">
                            </div>
                            <div class="form-group">
                                <label for="snkanibal"><b>SN Kanibal</b></label>
                                <input type="text" class="form-control" id="snkanibal" name="snkanibal"
                                    placeholder="Masukan SN Kanibal" value="{{ old('snkanibal') }}">
                            </div>
                            <div class="form-group">
                                <label for="nosparepart"><b>No SparePart</b></label>
                                <input type="text" class="form-control" id="nosparepart" name="nosparepart"
                                    placeholder="Masukan No SparePart" value="{{ old('nosparepart') }}">
                            </div>
                            <div class="form-group">
                                <label for="note"><b>Note</b></label>
                                <textarea type="text" class="form-control" name="note" id="note" cols="30" rows="5"
                                    placeholder="Masukan Note">{{ old('note') }}</textarea>
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
    @foreach ($servicepending as $item)
        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1"
            aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="{{ route('servicepending.update', $item->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Edit Data Service Done</h5>
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
                            <div class="mb-3">
                                <label for="pelanggan" class="form-label"><b>Pelanggan</b></label>
                                <input type="text" class="form-control" id="pelanggan" name="pelanggan"
                                    value="{{ $item->pelanggan }}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="model"><b>Model</b></label>
                                <select class="form-control selectpicker" name="model" id="model"
                                    data-live-search="true" required>
                                    <option value="Pilih Model">Pilih Model</option>
                                    <option value="D1" data-tokens="D1" {{ $item->model == 'D1' ? 'selected' : '' }}>
                                        D1</option>
                                    <option value="D1 Moka" data-tokens="D1 Moka"
                                        {{ $item->model == 'D1 Moka' ? 'selected' : '' }}>D1 Moka</option>
                                    <option value="D1-Pro" data-tokens="D1-Pro"
                                        {{ $item->model == 'D1-Pro' ? 'selected' : '' }}>D1-Pro</option>
                                    <option value="D1w" data-tokens="D1w"
                                        {{ $item->model == 'D1w' ? 'selected' : '' }}>D1w</option>
                                    <option value="D2-401" data-tokens="D2-401"
                                        {{ $item->model == 'D2-401' ? 'selected' : '' }}>D2-401</option>
                                    <option value="D2-402" data-tokens="D2-402"
                                        {{ $item->model == 'D2-402' ? 'selected' : '' }}>D2-402</option>
                                    <option value="D2-Pro" data-tokens="D2-Pro"
                                        {{ $item->model == 'D2-Pro' ? 'selected' : '' }}>D2-Pro</option>
                                    <option value="D3 504 lama" data-tokens="D3 504 lama"
                                        {{ $item->model == 'D3 504 lama' ? 'selected' : '' }}>D3 504 lama</option>
                                    <option value="D3 505 lama" data-tokens="D3 505 lama"
                                        {{ $item->model == 'D3 505 lama' ? 'selected' : '' }}>D3 505 lama</option>
                                    <option value="D3 506 lama" data-tokens="D3 506 lama"
                                        {{ $item->model == 'D3 506 lama' ? 'selected' : '' }}>D3 506 lama</option>
                                    <option value="D3-504" data-tokens="D3-504"
                                        {{ $item->model == 'D3-504' ? 'selected' : '' }}>D3-504</option>
                                    <option value="D3-505" data-tokens="D3-505"
                                        {{ $item->model == 'D3-505' ? 'selected' : '' }}>D3-505</option>
                                    <option value="D3-506" data-tokens="D3-506"
                                        {{ $item->model == 'D3-506' ? 'selected' : '' }}>D3-506</option>
                                    <option value="D3-501 Moka" data-tokens="D3-501 Moka"
                                        {{ $item->model == 'D3-501 Moka' ? 'selected' : '' }}>D3-501 Moka</option>
                                    <option value="D3-503 Moka" data-tokens="D3-503 Moka"
                                        {{ $item->model == 'D3-503 Moka' ? 'selected' : '' }}>D3-503 Moka</option>
                                    <option value="D3 DS1" data-tokens="D3 DS1"
                                        {{ $item->model == 'D3 DS1' ? 'selected' : '' }}>D3 DS1</option>
                                    <option value="D3 DS1 Extention Display" data-tokens="D3 DS1 Extention Display"
                                        {{ $item->model == 'D3 DS1 Extention Display' ? 'selected' : '' }}>D3 DS1
                                        Extention Display</option>
                                    <option value="D3 DS1 Extention Display TS" data-tokens="D3 DS1 Extention Display TS"
                                        {{ $item->model == 'D3 DS1 Extention Display TS' ? 'selected' : '' }}>D3 DS1
                                        Extention Display TS</option>
                                    <option value="D4-502" data-tokens="D4-502"
                                        {{ $item->model == 'D4-502' ? 'selected' : '' }}>D4-502</option>
                                    <option value="D4-503" data-tokens="D4-503"
                                        {{ $item->model == 'D4-503' ? 'selected' : '' }}>D4-503</option>
                                    <option value="D4-503 White" data-tokens="D4-503 White"
                                        {{ $item->model == 'D4-503 White' ? 'selected' : '' }}>D4-503 White</option>
                                    <option value="D4-504" data-tokens="D4-504"
                                        {{ $item->model == 'D4-504' ? 'selected' : '' }}>D4-504</option>
                                    <option value="D4-504 White" data-tokens="D4-504 White"
                                        {{ $item->model == 'D4-504 White' ? 'selected' : '' }}>D4-504 White</option>
                                    <option value="D4-505" data-tokens="D4-505"
                                        {{ $item->model == 'D4-505' ? 'selected' : '' }}>D4-505</option>
                                    <option value="D4-505 DT" data-tokens="D4-505 DT"
                                        {{ $item->model == 'D4-505 DT' ? 'selected' : '' }}>D4-505 DT</option>
                                    <option value="D4 Falcon 1" data-tokens="D4 Falcon 1"
                                        {{ $item->model == 'D4 Falcon 1' ? 'selected' : '' }}>D4 Falcon 1</option>
                                    <option value="M2-202" data-tokens="M2-202"
                                        {{ $item->model == 'M2-202' ? 'selected' : '' }}>M2-202</option>
                                    <option value="M2-202 iSeller" data-tokens="M2-202 iSeller"
                                        {{ $item->model == 'M2-202 iSeller' ? 'selected' : '' }}>M2-202 iSeller</option>
                                    <option value="M2-203" data-tokens="M2-203"
                                        {{ $item->model == 'M2-203' ? 'selected' : '' }}>M2-203</option>
                                    <option value="M2-203 iSeller" data-tokens="M2-203 iSeller"
                                        {{ $item->model == 'M2-203 iSeller' ? 'selected' : '' }}>M2-203 iSeller</option>
                                    <option value="M2-203 White" data-tokens="M2-203 White"
                                        {{ $item->model == 'M2-203 White' ? 'selected' : '' }}>M2-203 White</option>
                                    <option value="M2 Pro" data-tokens="M2 Pro"
                                        {{ $item->model == 'M2 Pro' ? 'selected' : '' }}>M2 Pro</option>
                                    <option value="M2 Max" data-tokens="M2 Max"
                                        {{ $item->model == 'M2 Max' ? 'selected' : '' }}>M2 Max</option>
                                    <option value="M2 Swift 1S" data-tokens="M2 Swift 1S"
                                        {{ $item->model == 'M2 Swift 1S' ? 'selected' : '' }}>M2 Swift 1S</option>
                                    <option value="M2 Swift 1P" data-tokens="M2 Swift 1P"
                                        {{ $item->model == 'M2 Swift 1P' ? 'selected' : '' }}>M2 Swift 1P</option>
                                    <option value="M2 Swift PDA" data-tokens="M2 Swift PDA"
                                        {{ $item->model == 'M2 Swift PDA' ? 'selected' : '' }}>M2 Swift PDA</option>
                                    <option value="M2 Swift 1 Scanner" data-tokens="M2 Swift 1 Scanner"
                                        {{ $item->model == 'M2 Swift 1 Scanner' ? 'selected' : '' }}>M2 Swift 1 Scanner
                                    </option>
                                    <option value="M2 Swift 1 Printer" data-tokens="M2 Swift 1 Printer"
                                        {{ $item->model == 'M2 Swift 1 Printer' ? 'selected' : '' }}>M2 Swift 1 Printer
                                    </option>
                                    <option value="R1 201" data-tokens="R1 201"
                                        {{ $item->model == 'R1 201' ? 'selected' : '' }}>R1 201</option>
                                    <option value="R1 202" data-tokens="R1 202"
                                        {{ $item->model == 'R1 202' ? 'selected' : '' }}>R1 202</option>
                                    <option value="S1 701" data-tokens="S1 701"
                                        {{ $item->model == 'S1 701' ? 'selected' : '' }}>S1 701</option>
                                    <option value="K1 101" data-tokens="K1 101"
                                        {{ $item->model == 'K1 101' ? 'selected' : '' }}>K1 101</option>
                                    <option value="K2 201" data-tokens="K1 201"
                                        {{ $item->model == 'K2 201' ? 'selected' : '' }}>K2 201</option>
                                    <option value="X1 Scanner" data-tokens="X1 Scanner"
                                        {{ $item->model == 'X1 Scanner' ? 'selected' : '' }}>X1 Scanner</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="ram"><b>RAM/Storage</b></label>
                                <select class="form-control" id="ram" name="ram" required>
                                    <option value="Pilih RAM/Storage">Pilih RAM/Storage</option>
                                    <option value="-" data-tokens="-" {{ $item->ram == '-' ? 'selected' : '' }}>
                                        -
                                    </option>
                                    <option value="1/8" data-tokens="1/8" {{ $item->ram == '1/8' ? 'selected' : '' }}>
                                        1/8
                                    </option>
                                    <option value="2/8" data-tokens="2/8" {{ $item->ram == '2/8' ? 'selected' : '' }}>
                                        2/8
                                    </option>
                                    <option value="2/16" data-tokens="2/16"
                                        {{ $item->ram == '2/16' ? 'selected' : '' }}>
                                        2/16
                                    </option>
                                    <option value="4/16" data-tokens="4/16"
                                        {{ $item->ram == '4/16' ? 'selected' : '' }}>
                                        4/16
                                    </option>
                                    <option value="4/32" data-tokens="4/32"
                                        {{ $item->ram == '4/32' ? 'selected' : '' }}>
                                        4/32
                                    </option>
                                    <option value="4/64" data-tokens="4/64"
                                        {{ $item->ram == '4/64' ? 'selected' : '' }}>
                                        4/64
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="android"><b>Versi Android</b></label>
                                <select class="form-control" id="android" name="android" required>
                                    <option value="Pilih Android">Pilih Android</option>
                                    <option value="-" data-tokens="-" {{ $item->android == '-' ? 'selected' : '' }}>
                                        -
                                    </option>
                                    <option value="Android 7" data-tokens="Android 7"
                                        {{ $item->android == 'Android 7' ? 'selected' : '' }}>
                                        Android 7
                                    </option>
                                    <option value="Android 11" data-tokens="Android 11"
                                        {{ $item->android == 'Android 11' ? 'selected' : '' }}>
                                        Android 11
                                    </option>
                                    <option value="Android 11 GMS" data-tokens="Android 11 GMS"
                                        {{ $item->android == 'Android 11 GMS' ? 'selected' : '' }}>
                                        Android 11 GMS
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="garansi"><b>Garansi</b></label>
                                <select class="form-control" id="garansi" name="garansi" value="{{ old('garansi') }}"
                                    required>
                                    <option value="Pilih Garansi">Pilih Garansi</option>
                                    <option value="DOA (Garansi)" data-tokens="DOA (Garansi)"
                                        {{ $item->garansi == 'DOA (Garansi)' ? 'selected' : '' }}>
                                        DOA (Garansi)
                                    </option>
                                    <option value="RMA (Garansi)" data-tokens="RMA (Garansi)"
                                        {{ $item->garansi == 'RMA (Garansi)' ? 'selected' : '' }}>
                                        RMA (Garansi)
                                    </option>
                                    <option value="RMA (Tidak Garansi)" data-tokens="RMA (Tidak Garansi)"
                                        {{ $item->garansi == 'RMA (Tidak Garansi)' ? 'selected' : '' }}>
                                        RMA (Tidak Garansi)
                                    </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="kerusakan" class="form-label"><b>Kerusakan</b></label>
                                <input type="text" class="form-control" id="kerusakan" name="kerusakan"
                                    value="{{ $item->kerusakan }}">
                            </div>
                            <div class="form-group">
                                <label for="teknisi"><b>Teknisi</b></label>
                                <select class="form-control" id="teknisi" name="teknisi" value="{{ old('teknisi') }}"
                                    required>
                                    <option value="Pilih Teknisi">Pilih Teknisi</option>
                                    <option value="Khaerul" data-tokens="Khaerul"
                                        {{ $item->teknisi == 'Khaerul' ? 'selected' : '' }}>
                                        Khaerul
                                    </option>
                                    <option value="Ozi" data-tokens="Ozi"
                                        {{ $item->teknisi == 'Ozi' ? 'selected' : '' }}>
                                        Ozi
                                    </option>
                                    <option value="Alfian" data-tokens="Alfian"
                                        {{ $item->teknisi == 'Alfian' ? 'selected' : '' }}>
                                        Alfian
                                    </option>
                                    <option value="Other" data-tokens="Other"
                                        {{ $item->teknisi == 'Other' ? 'selected' : '' }}>
                                        Other
                                    </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="perbaikan" class="form-label"><b>Perbaikan</b></label>
                                <input type="text" class="form-control" id="perbaikan" name="perbaikan"
                                    value="{{ $item->perbaikan }}">
                            </div>
                            <div class="mb-3">
                                <label for="snkanibal" class="form-label"><b>SNKanibal</b></label>
                                <input type="text" class="form-control" id="snkanibal" name="snkanibal"
                                    value="{{ $item->snkanibal }}">
                            </div>
                            <div class="mb-3">
                                <label for="nosparepart" class="form-label"><b>No SparePart</b></label>
                                <input type="text" class="form-control" id="nosparepart" name="nosparepart"
                                    value="{{ $item->nosparepart }}">
                            </div>
                            <div class="mb-3">
                                <label for="note" class="form-label"><b>Note</b></label>
                                <textarea class="form-control" id="note" name="note" rows="3"
                                    placeholder="Contoh:Adaptor,Dus,Docking">{{ $item->note }}</textarea>
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
    @foreach ($servicepending as $item)
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

    <!-- delete data -->
    @foreach ($servicepending as $item)
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
                        <form action="{{ route('servicepending.destroy', $item->id) }}" method="POST">
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

    <div class="container-fluid mt-3">
        <div style="overflow: auto">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Serial Number</th>
                    <th>Pelanggan</th>
                    <th>Model</th>
                    <th>Action</th>
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

                                <a href="#" class="btn btn-warning" data-toggle="modal"
                                    data-target="#editModal{{ $item->id }}"><i
                                        class="fa-solid fa-pen-to-square"></i></a>

                                <a href="#" class="btn btn-primary" data-toggle="modal"
                                    data-target="#viewModal{{ $item->id }}"><i class="fa-solid fa-eye"></i></a>

                                <a href="#" class="btn btn-danger" data-toggle="modal"
                                    data-target="#deleteModal{{ $item->id }}"><i class="fa-solid fa-trash"></i></a>

                                {{-- <a href="#" class="btn btn-success" data-toggle="modal"
                                data-target="#moveModal{{ $item->id }}"><i class="fa-solid fa-paper-plane"></i></a> --}}

                                <a href="/servicepending/finish/{{ $item->id }}" class="btn btn-success"><i
                                        class="fa-solid fa-paper-plane"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {!! $servicepending->onEachSide(10)->links('pagination::bootstrap-5') !!}
        </div>
    </div>
@endsection
