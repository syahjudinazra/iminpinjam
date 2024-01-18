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

        @if (Auth::check())
            <div class="searchpinjam">
                @if (Auth::check() && request()->is('pinjam'))
                    <button type="button" id="addpinjam" class="btn btn-danger mb-2" data-bs-toggle="modal"
                        data-target="#exampleModal">
                        <i class="fa-solid fa-plus"></i> Tambah Produk
                    </button>
                @endif

                {{-- <form method="GET" action="{{ route('search.index') }}"
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
                </form> --}}
            </div>
        @else
            <div class="searchpinjam">
                @if (Auth::check() && request()->is('pinjam'))
                    <button type="button" id="addpinjam" class="btn btn-danger mb-2" data-bs-toggle="modal"
                        data-target="#exampleModal">
                        <i class="fa-solid fa-plus"></i> Tambah Produk
                    </button>
                @endif

                {{-- <form method="GET" action="{{ route('search.index') }}"
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
                </form> --}}
            </div>
        @endif
        <!-- Tambah Data -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Pinjam Barang</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
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
                                <select class="form-select form-control-chosen" data-live-search="true" name="device"
                                    id="device"required>
                                    <option value="Pilih Device">Pilih Device</option>
                                    <option value="A4-101 Handle" data-tokens="A4-101 Handle">A4-101 Handle</option>
                                    <option value="A4-102 Desktop Stand" data-tokens="A4-102 Desktop Stand">A4-102
                                        Desktop
                                        Stand</option>
                                    <option value="A4-103 Stand" data-tokens="A4-103 Stand">A4-103 Stand</option>
                                    <option value="A4-104 Stand" data-tokens="A4-104 Stand">A4-104 Stand</option>
                                    <option value="A4-105 Stand" data-tokens="A4-105 Stand">A4-105 Stand</option>
                                    <option value="A4-107 Desktop Stand" data-tokens="A4-107 Desktop Stand">A4-107
                                        Desktop
                                        Stand</option>
                                    <option value="D1" data-tokens="D1">D1</option>
                                    <option value="D1 Pro" data-tokens="D1 Pro">D1 Pro</option>
                                    <option value="D1 Moka" data-tokens="D1 Moka">D1 Moka</option>
                                    <option value="D1W-702" data-tokens="D1W-702">D1W-702</option>
                                    <option value="D2 Pro" data-tokens="D2 Pro">D2 Pro</option>
                                    <option value="D2-401" data-tokens="D2-401">D2-401</option>
                                    <option value="D2-402" data-tokens="D2-402">D2-402</option>
                                    <option value="D3-504" data-tokens="D3-504">D3-504</option>
                                    <option value="D3-505" data-tokens="D3-505">D3-505</option>
                                    <option value="D3-506" data-tokens="D3-506">D3-506</option>
                                    <option value="D3-504 lama" data-tokens="D3-504 lama">D3-504 lama</option>
                                    <option value="D3-505 lama" data-tokens="D3-505 lama">D3-505 lama</option>
                                    <option value="D3-506 lama" data-tokens="D3-506 lama">D3-506 lama</option>
                                    <option value="D3-501 Moka" data-tokens="D3-501 Moka">D3-501 Moka</option>
                                    <option value="D3-503 Moka" data-tokens="D3-503 Moka">D3-503 Moka</option>
                                    <option value="D3-501 Moka Ultra" data-tokens="D3-501 Moka Ultra">D3-501 Moka
                                        Ultra
                                    </option>
                                    <option value="D3-503 Moka Ultra+" data-tokens="D3-503 Moka Ultra+">D3-503 Moka
                                        Ultra+
                                    </option>
                                    <option value="D3 DS1" data-tokens="D3 DS1">D3 DS1</option>
                                    <option value="D3 DS1K" data-tokens="D3 DS1K">D3 DS1K</option>
                                    <option value="D3 DS1 DP" data-tokens="D3 DS1 DP">D3 DS1 DP</option>
                                    <option value="D3 DS1 PRO DP" data-tokens="D3 DS1 PRO DP">D3 DS1 PRO DP</option>
                                    <option value="D3 DS1 TS DP" data-tokens="D3 DS1 TS DP">D3 DS1 TS DP</option>
                                    <option value="D3 DS1 HDMI" data-tokens="D3 DS1 HDMI">D3 DS1 HDMI</option>
                                    <option value="D3 DS1 HDMI TS" data-tokens="D3 DS1 HDMI TS">D3 DS1 HDMI TS</option>
                                    <option value="D3 DS1 HDMI NFC" data-tokens="D3 DS1 HDMI NFC">D3 DS1 HDMI NFC</option>
                                    <option value="D3 DS1 Iseller" data-tokens="D3 DS1 Iseller">D3 DS1 Iseller
                                    </option>
                                    <option value="D3 DS1 Iseller DP" data-tokens="D3 DS1 Iseller DP">D3 DS1 Iseller DP
                                    </option>
                                    <option value="D3 DS1 TS Iseller DP" data-tokens="D3 DS1 TS Iseller DP">D3 DS1 TS
                                        Iseller DP</option>
                                    <option value="D3 DS1 Iseller Extention Display DP"
                                        data-tokens="D3 DS1 Iseller Extention Display DP">D3 DS1 Iseller Extention Display
                                        DP</option>
                                    <option value="D3 DS1 Stand" data-tokens="D3 DS1 Stand">D3 DS1 Stand</option>
                                    <option value="D3 DS1 Stand 1M DP" data-tokens="D3 DS1 Stand 1M DP">D3 DS1 Stand
                                        1M DP
                                    </option>
                                    <option value="D3 DS1 Display NFC" data-tokens="D3 DS1 Display NFC">D3 DS1 Display
                                        NFC
                                    </option>
                                    <option value="D3 DS1 Extention Display" data-tokens="D3 DS1 Extention Display">D3
                                        DS1
                                        Extention Display</option>
                                    <option value="D3 DS1 Extention Display Iseller"
                                        data-tokens="D3 DS1 Extention Display Iseller">D3 DS1
                                        Extention Display Iseller</option>
                                    <option value="D3 DS1 Extention Display DP" data-tokens="D3 DS1 Extention Display DP">
                                        D3 DS1 Extention Display DP</option>
                                    <option value="D3 DS1 Extention Display TS" data-tokens="D3 DS1 Extention Display TS">
                                        D3 DS1 Extention Display TS</option>
                                    <option value="D3 DS1 Extention Display TS DP"
                                        data-tokens="D3 DS1 Extention Display TS DP">
                                        D3 DS1 Extention Display TS DP</option>
                                    <option value="D3 DS1 Extention Display HDMI"
                                        data-tokens="D3 DS1 Extention Display HDMI">
                                        D3 DS1 Extention Display HDMI</option>
                                    <option value="D3 DS1 Extention Display TS HDMI"
                                        data-tokens="D3 DS1 Extention Display TS HDMI">D3 DS1 Extention Display TS HDMI
                                    </option>
                                    <option value="D4-501" data-tokens="D4-501">D4-501</option>
                                    <option value="D4-502" data-tokens="D4-502">D4-502</option>
                                    <option value="D4-503" data-tokens="D4-503">D4-503</option>
                                    <option value="D4-503 White" data-tokens="D4-503 White">D4-503 White</option>
                                    <option value="D4-504" data-tokens="D4-504">D4-504</option>
                                    <option value="D4-504 White" data-tokens="D4-504 White">D4-504 White</option>
                                    <option value="D4-504 Pro" data-tokens="D4-504 Pro">D4-504 Pro</option>
                                    <option value="D4-505" data-tokens="D4-505">D4-505</option>
                                    <option value="D4-505 DT" data-tokens="D4-505 DT">D4-505 DT</option>
                                    <option value="D4-505 Pro" data-tokens="D4-505 Pro">D4-505 Pro</option>
                                    <option value="D4 Falcon 1" data-tokens="D4 Falcon 1">D4 Falcon 1</option>
                                    <option value="M1" data-tokens="M1">M1</option>
                                    <option value="M2-201" data-tokens="M2-201">M2-201</option>
                                    <option value="M2-202" data-tokens="M2-202">M2-202</option>
                                    <option value="M2-202 Olsera" data-tokens="M2-202 Olsera">M2-202 Olsera
                                    </option>
                                    <option value="M2-202 iSeller" data-tokens="M2-202 iSeller">M2-202 iSeller
                                    </option>
                                    <option value="M2-202 Grab" data-tokens="M2-202 Grab">M2-202 Grab
                                    </option>
                                    <option value="M2-203" data-tokens="M2-203">M2-203</option>
                                    <option value="M2-203 iSeller" data-tokens="M2-203 iSeller">M2-203 iSeller
                                    </option>
                                    <option value="M2-203 White" data-tokens="M2-203 White">M2-203 White</option>
                                    <option value="M2-203 (Full)" data-tokens="M2-203 (Full)">M2-203 (Full)</option>
                                    <option value="M2-203 NFC Iseller" data-tokens="M2-203 NFC Iseller">M2-203 NFC
                                        Iseller
                                    </option>
                                    <option value="M-203 Traveloka" data-tokens="M2-203 Traveloka">M2-203 Traveloka
                                    </option>
                                    <option value="M2-203 Grab" data-tokens="M2-203 Grab">M2-203 Grab
                                    </option>
                                    <option value="M2 Pro" data-tokens="M2 Pro">M2 Pro</option>
                                    <option value="M2 Max" data-tokens="M2 Max">M2 Max</option>
                                    <option value="M2 Max NFC" data-tokens="M2 Max NFC">M2 Max NFC</option>
                                    <option value="M2 Max BASE" data-tokens="M2 Max BASE">M2 Max BASE</option>
                                    <option value="M2 Swift 1S" data-tokens="M2 Swift 1S">M2 Swift 1S</option>
                                    <option value="M2 Swift 1S NFC" data-tokens="M2 Swift 1S NFC">M2 Swift 1S NFC
                                    </option>
                                    <option value="M2 Swift 1P" data-tokens="M2 Swift 1P">M2 Swift 1P</option>
                                    <option value="M2 Swift 1 NFC" data-tokens="M2 Swift 1 NFC">M2 Swift 1 NFC
                                    </option>
                                    <option value="M2 Swift 1P NFC" data-tokens="M2 Swift 1P NFC">M2 Swift 1P NFC
                                    </option>
                                    <option value="M2 Swift PDA" data-tokens="M2 Swift PDA">M2 Swift PDA</option>
                                    <option value="M2 Swift 1 PDA" data-tokens="M2 Swift 1 PDA">M2 Swift 1 PDA
                                    </option>
                                    <option value="M2 Swift 1 STRAP" data-tokens="M2 Swift 1 STRAP">M2 Swift 1 STRAP
                                    </option>
                                    <option value="M2 Swift 1 Scanner" data-tokens="M2 Swift 1 Scanner">M2 Swift 1
                                        Scanner
                                    </option>
                                    <option value="M2 Swift Printer" data-tokens="M2 Swift Printer">M2 Swift Printer
                                    </option>
                                    <option value="M2 Swift 1 Printer" data-tokens="M2 Swift 1 Printer">M2 Swift 1
                                        Printer
                                    </option>
                                    <option value="M2 Swift 2 Pro" data-tokens="M2 Swift 2 Pro">M2 Swift 2 Pro
                                    </option>
                                    <option value="R1-201" data-tokens="R1-201">R1-201</option>
                                    <option value="R1-202" data-tokens="R1-202">R1-202</option>
                                    <option value="S1-701" data-tokens="S1-701">S1-701</option>
                                    <option value="S1 Rotating Bracket" data-tokens="S1 Rotating Bracket">S1 Rotating
                                        Bracket</option>
                                    <option value="S1 Wall Mount" data-tokens="S1 Wall Mount">S1 Wall Mount</option>
                                    <option value="K1-101" data-tokens="K1-101">K1-101</option>
                                    <option value="K2-201" data-tokens="K2-201">K2-201</option>
                                    <option value="X1-201" data-tokens="X1-201">X1-201</option>
                                    <option value="X1 Scanner" data-tokens="X1 Scanner">X1 Scanner</option>
                                    <option value="Stand S1" data-tokens="Stand S1">Stand S1</option>
                                    <option value="Stand K1" data-tokens="Stand K1">Stand K1</option>
                                    <option value="Stand K2" data-tokens="Stand K2">Stand K2</option>
                                    <option value="Stand Swan" data-tokens="Stand Swan">Stand Swan</option>
                                    <option value="Kassen Barcode 2D RS-720" data-tokens="Kassen Barcode 2D RS-720">
                                        Kassen
                                        Barcode 2D RS-720</option>
                                    <option value="Kassen Barcode KS-605" data-tokens="Kassen Barcode KS-605">Kassen
                                        Barcode KS-605</option>
                                    <option value="Kassen Printer BT-P3200" data-tokens="Kassen Printer BT-P3200">
                                        Kassen
                                        Printer BT-P3200</option>
                                    <option value="Kassen Printer BT-P299" data-tokens="Kassen Printer BT-P299">Kassen
                                        Printer BT-P299</option>
                                    <option value="Kassen Printer BT-P290" data-tokens="Kassen Printer BT-P290">Kassen
                                        Printer BT-P290</option>
                                    <option value="Kassen Printer Label DT-643" data-tokens="Kassen Printer Label DT-643">
                                        Kassen Printer Label DT-643</option>
                                    <option value="Cash Drawer KH-330" data-tokens="Cash Drawer KH-330">Cash Drawer
                                        KH-330
                                    </option>
                                    <option value="Cash Drawer KH-410" data-tokens="Cash Drawer KH-410">Cash Drawer
                                        KH-410
                                    </option>
                                    <option value="Cash Drawer 408" data-tokens="Cash Drawer 408">Cash Drawer 408
                                    </option>
                                    <option value="Cash Drawer Panda" data-tokens="Cash Drawer Panda">Cash Drawer
                                        Panda
                                    </option>
                                    <option value="Barcode Scanner" data-tokens="Barcode Scanner">Barcode Scanner
                                    </option>
                                    <option value="Barcode Scanner RS-720" data-tokens="Barcode Scanner RS-720">
                                        Barcode
                                        Scanner RS-720
                                    </option>
                                    <option value="Printer Thermal Label DT-643"
                                        data-tokens="Printer Thermal Label DT-643">Printer Thermal Label DT-643
                                    </option>
                                    <option value="Printer Thermal BT-P299" data-tokens="Printer Thermal BT-P299">
                                        Printer
                                        Thermal BT-P299
                                    </option>
                                    <option value="Printer Thermal BT-P290" data-tokens="Printer Thermal BT-P290">
                                        Printer
                                        Thermal BT-P290
                                    </option>
                                    <option value="Printer Thermal BTP-3200 USE"
                                        data-tokens="Printer Thermal BTP-3200 USE">Printer Thermal BTP-3200 USE
                                    </option>
                                    <option value="Printer Thermal BTP-3200 BT" data-tokens="Printer Thermal BTP-3200 BT">
                                        Printer Thermal BTP-3200 BT
                                    </option>
                                    <option value="Printer Thermal 58" data-tokens="Printer Thermal 58">Printer
                                        Thermal 58
                                    </option>
                                    <option value="Thermal Label 40 X 30 mm" data-tokens="Thermal Label 40 X 30 mm">
                                        Thermal Label 40 X 30 mm
                                    </option>
                                    <option value="Converter USB - AUX" data-tokens="Converter USB - AUX">
                                        Converter USB - AUX
                                    </option>
                                    <option value="Webcam Camera" data-tokens="Webcam Camera">
                                        Webcam Camera
                                    </option>
                                    <option value="Comson CSPL 78 BT" data-tokens="Comson CSPL 78 BT">
                                        Comson CSPL 78 BT
                                    </option>
                                    <option value="Comson CSP 893 UE" data-tokens="Comson CSP 893 UE">
                                        Comson CSP 893 UE
                                    </option>
                                    <option value="Crane 1">
                                        Crane 1
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="ram"><b>RAM/Storage</b></label>
                                <select class="form-select" id="ram" name="ram" value="{{ old('ram') }}"
                                    required>
                                    <option>Pilih RAM/Storage</option>
                                    <option>-</option>
                                    <option>1/8</option>
                                    <option>2/8</option>
                                    <option>2/16</option>
                                    <option>4/16</option>
                                    <option>4/32</option>
                                    <option>4/64</option>
                                    <option>8/128</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="android"><b>Versi Android</b></label>
                                <select class="form-select" id="android" name="android" value="{{ old('android') }}"
                                    required>
                                    <option>Pilih Versi Android</option>
                                    <option>-</option>
                                    <option>Android 7</option>
                                    <option>Android 8</option>
                                    <option>Android 11</option>
                                    <option>Android 11 GMS</option>
                                    <option>Android 13</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="customer" class="form-label"><b>Customer</b></label>
                                <input type="text" class="form-control" id="customer" name="customer"
                                    placeholder="Masukan Nama Customer">
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label"><b>Alamat</b></label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="3" placeholder="Jl. Pergudangan Ecopark"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="sales" class="form-label"><b>Sales</b></label>
                                <input type="text" class="form-control" id="sales" name="sales"
                                    placeholder="Masukan Nama Sales">
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
                            <div class="mb-3">
                                <label for="gambar" class="form-label"><b>Gambar</b></label>
                                <input class="form-control" type="file" id="gambar" name="gambar">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
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
                                <select class="form-select form-control-chosen" name="device" id="device" required>
                                    <option value="Pilih Model">Pilih Model</option>
                                    <option value="A4-101 Handle" data-tokens="A4-101 Handle"
                                        {{ $item->device == 'A4-101 Handle' ? 'selected' : '' }}>A4-101 Handle</option>
                                    <option value="A4-102 Desktop Stand" data-tokens="A4-102 Desktop Stand"
                                        {{ $item->device == 'A4-102 Desktop Stand' ? 'selected' : '' }}>A4-102 Desktop
                                        Stand</option>
                                    <option value="A4-103 Stand" data-tokens="A4-103 Stand"
                                        {{ $item->device == 'A4-103 Stand' ? 'selected' : '' }}>A4-103 Stand</option>
                                    <option value="A4-104 Stand" data-tokens="A4-104 Stand"
                                        {{ $item->device == 'A4-104 Stand' ? 'selected' : '' }}>A4-104 Stand</option>
                                    <option value="A4-105 Stand" data-tokens="A4-105 Stand"
                                        {{ $item->device == 'A4-105 Stand' ? 'selected' : '' }}>A4-105 Stand</option>
                                    <option value="A4-107 Desktop Stand" data-tokens="A4-107 Desktop Stand"
                                        {{ $item->device == 'A4-107 Desktop Stand' ? 'selected' : '' }}>A4-107 Desktop
                                        Stand</option>
                                    <option value="D1" data-tokens="D1"
                                        {{ $item->device == 'D1' ? 'selected' : '' }}>D1</option>
                                    <option value="D1 Pro" data-tokens="D1 Pro"
                                        {{ $item->device == 'D1 Pro' ? 'selected' : '' }}>D1 Pro</option>
                                    <option value="D1 Moka" data-tokens="D1 Moka"
                                        {{ $item->device == 'D1 Moka' ? 'selected' : '' }}>D1 Moka</option>
                                    <option value="D1W-702" data-tokens="D1W-702"
                                        {{ $item->device == 'D1W-702' ? 'selected' : '' }}>D1W-702</option>
                                    <option value="D2 Pro" data-tokens="D2 Pro"
                                        {{ $item->device == 'D2 Pro' ? 'selected' : '' }}>D2 Pro</option>
                                    <option value="D2-401" data-tokens="D2-401"
                                        {{ $item->device == 'D2-401' ? 'selected' : '' }}>D2-401</option>
                                    <option value="D2-402" data-tokens="D2-402"
                                        {{ $item->device == 'D2-402' ? 'selected' : '' }}>D2-402</option>
                                    <option value="D3-504" data-tokens="D3-504"
                                        {{ $item->device == 'D3-504' ? 'selected' : '' }}>D3-504</option>
                                    <option value="D3-505" data-tokens="D3-505"
                                        {{ $item->device == 'D3-505' ? 'selected' : '' }}>D3-505</option>
                                    <option value="D3-506" data-tokens="D3-506"
                                        {{ $item->device == 'D3-506' ? 'selected' : '' }}>D3-506</option>
                                    <option value="D3-504 lama" data-tokens="D3-504 lama"
                                        {{ $item->device == 'D3-504 lama' ? 'selected' : '' }}>D3-504 lama</option>
                                    <option value="D3-505 lama" data-tokens="D3-505 lama"
                                        {{ $item->device == 'D3-505 lama' ? 'selected' : '' }}>D3-505 lama</option>
                                    <option value="D3-506 lama" data-tokens="D3-506 lama"
                                        {{ $item->device == 'D3-506 lama' ? 'selected' : '' }}>D3-506 lama</option>
                                    <option value="D3-501 Moka" data-tokens="D3-501 Moka"
                                        {{ $item->device == 'D3-501 Moka' ? 'selected' : '' }}>D3-501 Moka</option>
                                    <option value="D3-503 Moka" data-tokens="D3-503 Moka"
                                        {{ $item->device == 'D3-503 Moka' ? 'selected' : '' }}>D3-503 Moka</option>
                                    <option value="D3-501 Moka Ultra" data-tokens="D3-501 Moka Ultra"
                                        {{ $item->device == 'D3-501 Moka Ultra' ? 'selected' : '' }}>D3-501 Moka Ultra
                                    </option>
                                    <option value="D3-503 Moka Ultra+" data-tokens="D3-503 Moka Ultra+"
                                        {{ $item->device == 'D3-503 Moka Ultra+' ? 'selected' : '' }}>D3-503 Moka Ultra+
                                    </option>
                                    <option value="D3 DS1" data-tokens="D3 DS1"
                                        {{ $item->device == 'D3 DS1' ? 'selected' : '' }}>D3 DS1</option>
                                    <option value="D3 DS1K" data-tokens="D3 DS1K"
                                        {{ $item->device == 'D3 DS1K' ? 'selected' : '' }}>D3 DS1K</option>
                                    <option value="D3 DS1 DP" data-tokens="D3 DS1 DP"
                                        {{ $item->device == 'D3 DS1 DP' ? 'selected' : '' }}>D3 DS1 DP</option>
                                    <option value="D3 DS1 PRO DP" data-tokens="D3 DS1 PRO DP"
                                        {{ $item->device == 'D3 DS1 PRO DP' ? 'selected' : '' }}>D3 DS1 PRO DP</option>
                                    <option value="D3 DS1 TS DP" data-tokens="D3 DS1 TS DP"
                                        {{ $item->device == 'D3 DS1 TS DP' ? 'selected' : '' }}>D3 DS1 TS DP</option>
                                    <option value="D3 DS1 HDMI" data-tokens="D3 DS1 HDMI"
                                        {{ $item->device == 'D3 DS1 HDMI' ? 'selected' : '' }}>D3 DS1 HDMI</option>
                                    <option value="D3 DS1 HDMI TS" data-tokens="D3 DS1 HDMI TS"
                                        {{ $item->device == 'D3 DS1 HDMI TS' ? 'selected' : '' }}>D3 DS1 HDMI TS</option>
                                    <option value="D3 DS1 HDMI NFC" data-tokens="D3 DS1 HDMI NFC"
                                        {{ $item->device == 'D3 DS1 HDMI NFC' ? 'selected' : '' }}>D3 DS1 HDMI NFC</option>
                                    <option value="D3 DS1 Iseller" data-tokens="D3 DS1 Iseller"
                                        {{ $item->device == 'D3 DS1 Iseller' ? 'selected' : '' }}>D3 DS1 Iseller</option>
                                    <option value="D3 DS1 Iseller DP" data-tokens="D3 DS1 Iseller DP"
                                        {{ $item->device == 'D3 DS1 Iseller DP' ? 'selected' : '' }}>D3 DS1 Iseller DP
                                    </option>
                                    <option value="D3 DS1 TS Iseller DP" data-tokens="D3 DS1 TS Iseller DP"
                                        {{ $item->device == 'D3 DS1 TS Iseller DP' ? 'selected' : '' }}>D3 DS1 TS
                                        Iseller DP</option>
                                    <option value="D3 DS1 Iseller Extention Display DP"
                                        data-tokens="D3 DS1 Iseller Extention Display DP"
                                        {{ $item->device == 'D3 DS1 Iseller Extention Display DP' ? 'selected' : '' }}>D3
                                        DS1 Iseller Extention Display DP</option>
                                    <option value="D3 DS1 Stand" data-tokens="D3 DS1 Stand"
                                        {{ $item->device == 'D3 DS1 Stand' ? 'selected' : '' }}>D3 DS1 Stand</option>
                                    <option value="D3 DS1 Stand 1M DP" data-tokens="D3 DS1 Stand 1M DP"
                                        {{ $item->device == 'D3 DS1 Stand 1M DP' ? 'selected' : '' }}>D3 DS1 Stand 1M DP
                                    </option>
                                    <option value="D3 DS1 Display NFC" data-tokens="D3 DS1 Display NFC"
                                        {{ $item->device == 'D3 DS1 Display NFC' ? 'selected' : '' }}>D3 DS1 Display NFC
                                    </option>
                                    <option value="D3 DS1 Extention Display" data-tokens="D3 DS1 Extention Display"
                                        {{ $item->device == 'D3 DS1 Extention Display' ? 'selected' : '' }}>D3 DS1
                                        Extention Display</option>
                                    <option value="D3 DS1 Extention Display Iseller"
                                        data-tokens="D3 DS1 Extention Display Iseller"
                                        {{ $item->device == 'D3 DS1 Extention Display Iseller' ? 'selected' : '' }}>D3 DS1
                                        Extention Display Iseller</option>
                                    <option value="D3 DS1 Extention Display DP" data-tokens="D3 DS1 Extention Display DP"
                                        {{ $item->device == 'D3 DS1 Extention Display DP' ? 'selected' : '' }}>
                                        D3 DS1 Extention Display DP</option>
                                    <option value="D3 DS1 Extention Display TS" data-tokens="D3 DS1 Extention Display TS"
                                        {{ $item->device == 'D3 DS1 Extention Display TS' ? 'selected' : '' }}>
                                        D3 DS1 Extention Display TS</option>
                                    <option value="D3 DS1 Extention Display TS DP"
                                        data-tokens="D3 DS1 Extention Display TS DP"
                                        {{ $item->device == 'D3 DS1 Extention Display TS DP' ? 'selected' : '' }}>
                                        D3 DS1 Extention Display TS DP</option>
                                    <option value="D3 DS1 Extention Display HDMI"
                                        data-tokens="D3 DS1 Extention Display HDMI"
                                        {{ $item->device == 'D3 DS1 Extention Display HDMI' ? 'selected' : '' }}>
                                        D3 DS1 Extention Display HDMI</option>
                                    <option value="D3 DS1 Extention Display TS HDMI"
                                        data-tokens="D3 DS1 Extention Display TS HDMI"
                                        {{ $item->device == 'D3 DS1 Extention Display TS HDMI' ? 'selected' : '' }}>D3 DS1
                                        Extention Display TS HDMI</option>
                                    <option value="D4-501" data-tokens="D4-501"
                                        {{ $item->device == 'D4-501' ? 'selected' : '' }}>D4-501</option>
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
                                    <option value="D4-504 Pro" data-tokens="D4-504 Pro"
                                        {{ $item->device == 'D4-504 Pro' ? 'selected' : '' }}>D4-504 Pro</option>
                                    <option value="D4-505" data-tokens="D4-505"
                                        {{ $item->device == 'D4-505' ? 'selected' : '' }}>D4-505</option>
                                    <option value="D4-505 DT" data-tokens="D4-505 DT"
                                        {{ $item->device == 'D4-505 DT' ? 'selected' : '' }}>D4-505 DT</option>
                                    <option value="D4-505 Pro" data-tokens="D4-505 Pro"
                                        {{ $item->device == 'D4-505 Pro' ? 'selected' : '' }}>D4-505 Pro</option>
                                    <option value="D4 Falcon 1" data-tokens="D4 Falcon 1"
                                        {{ $item->device == 'D4 Falcon 1' ? 'selected' : '' }}>D4 Falcon 1</option>
                                    <option value="M1" data-tokens="M1"
                                        {{ $item->device == 'M1' ? 'selected' : '' }}>M1</option>
                                    <option value="M2-201" data-tokens="M2-201"
                                        {{ $item->device == 'M2-201' ? 'selected' : '' }}>M2-201</option>
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
                                    <option value="M2-203 (Full)" data-tokens="M2-203 (Full)"
                                        {{ $item->device == 'M2-203 (Full)' ? 'selected' : '' }}>M2-203 (Full)</option>
                                    <option value="M2-203 NFC Iseller" data-tokens="M2-203 NFC Iseller"
                                        {{ $item->device == 'M2-203 NFC Iseller' ? 'selected' : '' }}>M2-203 NFC Iseller
                                    </option>
                                    <option value="M-203 Traveloka" data-tokens="M2-203 Traveloka"
                                        {{ $item->device == 'M-203 Traveloka' ? 'selected' : '' }}>M2-203 Traveloka
                                    </option>
                                    <option value="M2-203 Grab" data-tokens="M2-203 Grab"
                                        {{ $item->device == 'M2-203 Grab' ? 'selected' : '' }}>M2-203 Grab
                                    </option>
                                    <option value="M2 Pro" data-tokens="M2 Pro"
                                        {{ $item->device == 'M2 Pro' ? 'selected' : '' }}>M2 Pro</option>
                                    <option value="M2 Max" data-tokens="M2 Max"
                                        {{ $item->device == 'M2 Max' ? 'selected' : '' }}>M2 Max</option>
                                    <option value="M2 Max NFC" data-tokens="M2 Max NFC"
                                        {{ $item->device == 'M2 Max NFC' ? 'selected' : '' }}>M2 Max NFC</option>
                                    <option value="M2 Max BASE" data-tokens="M2 Max BASE"
                                        {{ $item->device == 'M2 Max BASE' ? 'selected' : '' }}>M2 Max BASE</option>
                                    <option value="M2 Swift 1S" data-tokens="M2 Swift 1S"
                                        {{ $item->device == 'M2 Swift 1S' ? 'selected' : '' }}>M2 Swift 1S</option>
                                    <option value="M2 Swift 1S NFC" data-tokens="M2 Swift 1S NFC"
                                        {{ $item->device == 'M2 Swift 1S NFC' ? 'selected' : '' }}>M2 Swift 1S NFC</option>
                                    <option value="M2 Swift 1P" data-tokens="M2 Swift 1P"
                                        {{ $item->device == 'M2 Swift 1P' ? 'selected' : '' }}>M2 Swift 1P</option>
                                    <option value="M2 Swift 1 NFC" data-tokens="M2 Swift 1 NFC"
                                        {{ $item->device == 'M2 Swift 1 NFC' ? 'selected' : '' }}>M2 Swift 1 NFC</option>
                                    <option value="M2 Swift 1P NFC" data-tokens="M2 Swift 1P NFC"
                                        {{ $item->device == 'M2 Swift 1P NFC' ? 'selected' : '' }}>M2 Swift 1P NFC</option>
                                    <option value="M2 Swift PDA" data-tokens="M2 Swift PDA"
                                        {{ $item->device == 'M2 Swift PDA' ? 'selected' : '' }}>M2 Swift PDA</option>
                                    <option value="M2 Swift 1 PDA" data-tokens="M2 Swift 1 PDA"
                                        {{ $item->device == 'M2 Swift 1 PDA' ? 'selected' : '' }}>M2 Swift 1 PDA</option>
                                    <option value="M2 Swift 1 STRAP" data-tokens="M2 Swift 1 STRAP"
                                        {{ $item->device == 'M2 Swift 1 STRAP' ? 'selected' : '' }}>M2 Swift 1 STRAP
                                    </option>
                                    <option value="M2 Swift 1 Scanner" data-tokens="M2 Swift 1 Scanner"
                                        {{ $item->device == 'M2 Swift 1 Scanner' ? 'selected' : '' }}>M2 Swift 1 Scanner
                                    </option>
                                    <option value="M2 Swift Printer" data-tokens="M2 Swift Printer"
                                        {{ $item->device == 'M2 Swift Printer' ? 'selected' : '' }}>M2 Swift Printer
                                    </option>
                                    <option value="M2 Swift 1 Printer" data-tokens="M2 Swift 1 Printer"
                                        {{ $item->device == 'M2 Swift 1 Printer' ? 'selected' : '' }}>M2 Swift 1 Printer
                                    </option>
                                    <option value="M2 Swift 2 Pro" data-tokens="M2 Swift 2 Pro"
                                        {{ $item->device == 'M2 Swift 2 Pro' ? 'selected' : '' }}>M2 Swift 2 Pro
                                    </option>
                                    <option value="R1-201" data-tokens="R1-201"
                                        {{ $item->device == 'R1-201' ? 'selected' : '' }}>R1-201</option>
                                    <option value="R1-202" data-tokens="R1-202"
                                        {{ $item->device == 'R1-202' ? 'selected' : '' }}>R1-202</option>
                                    <option value="S1-701" data-tokens="S1-701"
                                        {{ $item->device == 'S1-701' ? 'selected' : '' }}>S1-701</option>
                                    <option value="S1 Rotating Bracket" data-tokens="S1 Rotating Bracket"
                                        {{ $item->device == 'S1 Rotating Bracket' ? 'selected' : '' }}>S1 Rotating
                                        Bracket</option>
                                    <option value="S1 Wall Mount" data-tokens="S1 Wall Mount"
                                        {{ $item->device == 'S1 Wall Mount' ? 'selected' : '' }}>S1 Wall Mount</option>
                                    <option value="K1-101" data-tokens="K1-101"
                                        {{ $item->device == 'K1-101' ? 'selected' : '' }}>K1-101</option>
                                    <option value="K2-201" data-tokens="K2-201"
                                        {{ $item->device == 'K2-201' ? 'selected' : '' }}>K2-201</option>
                                    <option value="X1-201" data-tokens="X1-201"
                                        {{ $item->device == 'X1-201' ? 'selected' : '' }}>X1-201</option>
                                    <option value="X1 Scanner" data-tokens="X1 Scanner"
                                        {{ $item->device == 'X1 Scanner' ? 'selected' : '' }}>X1 Scanner</option>
                                    <option value="Stand S1" data-tokens="Stand S1"
                                        {{ $item->device == 'Stand S1' ? 'selected' : '' }}>Stand S1</option>
                                    <option value="Stand K1" data-tokens="Stand K1"
                                        {{ $item->device == 'Stand K1' ? 'selected' : '' }}>Stand K1</option>
                                    <option value="Stand K2" data-tokens="Stand K2"
                                        {{ $item->device == 'Stand K2' ? 'selected' : '' }}>Stand K2</option>
                                    <option value="Stand Swan" data-tokens="Stand Swan"
                                        {{ $item->device == 'Stand Swan' ? 'selected' : '' }}>Stand Swan</option>
                                    <option value="Kassen Barcode 2D RS-720" data-tokens="Kassen Barcode 2D RS-720"
                                        {{ $item->device == 'Kassen Barcode 2D RS-720' ? 'selected' : '' }}>Kassen
                                        Barcode 2D RS-720</option>
                                    <option value="Kassen Barcode KS-605" data-tokens="Kassen Barcode KS-605"
                                        {{ $item->device == 'Kassen Barcode KS-605' ? 'selected' : '' }}>Kassen
                                        Barcode KS-605</option>
                                    <option value="Kassen Printer BT-P3200" data-tokens="Kassen Printer BT-P3200"
                                        {{ $item->device == 'Kassen Printer BT-P3200' ? 'selected' : '' }}>Kassen
                                        Printer BT-P3200</option>
                                    <option value="Kassen Printer BT-P299" data-tokens="Kassen Printer BT-P299"
                                        {{ $item->device == 'Kassen Printer BT-P299' ? 'selected' : '' }}>Kassen
                                        Printer BT-P299</option>
                                    <option value="Kassen Printer BT-P290" data-tokens="Kassen Printer BT-P290"
                                        {{ $item->device == 'Kassen Printer BT-P290' ? 'selected' : '' }}>Kassen
                                        Printer BT-P290</option>
                                    <option value="Kassen Printer Label DT-643" data-tokens="Kassen Printer Label DT-643"
                                        {{ $item->device == 'Kassen Printer Label DT-643' ? 'selected' : '' }}>
                                        Kassen Printer Label DT-643</option>
                                    <option value="Cash Drawer KH-330" data-tokens="Cash Drawer KH-330"
                                        {{ $item->device == 'Cash Drawer KH-330' ? 'selected' : '' }}>Cash Drawer KH-330
                                    </option>
                                    <option value="Cash Drawer KH-410" data-tokens="Cash Drawer KH-410"
                                        {{ $item->device == 'Cash Drawer KH-410' ? 'selected' : '' }}>Cash Drawer KH-410
                                    </option>
                                    <option value="Cash Drawer 408" data-tokens="Cash Drawer 408"
                                        {{ $item->device == 'Cash Drawer 408' ? 'selected' : '' }}>Cash Drawer 408
                                    </option>
                                    <option value="Cash Drawer Panda" data-tokens="Cash Drawer Panda"
                                        {{ $item->device == 'Cash Drawer Panda' ? 'selected' : '' }}>Cash Drawer Panda
                                    </option>
                                    <option value="Barcode Scanner" data-tokens="Barcode Scanner"
                                        {{ $item->device == 'Barcode Scanner' ? 'selected' : '' }}>Barcode Scanner
                                    </option>
                                    <option value="Barcode Scanner RS-720" data-tokens="Barcode Scanner RS-720"
                                        {{ $item->device == 'Barcode Scanner RS-720' ? 'selected' : '' }}>Barcode
                                        Scanner RS-720
                                    </option>
                                    <option value="Printer Thermal Label DT-643"
                                        data-tokens="Printer Thermal Label DT-643"
                                        {{ $item->device == 'Printer Thermal Label DT-643' ? 'selected' : '' }}>Printer
                                        Thermal Label DT-643
                                    </option>
                                    <option value="Printer Thermal BT-P299" data-tokens="Printer Thermal BT-P299"
                                        {{ $item->device == 'Printer Thermal BT-P299' ? 'selected' : '' }}>Printer
                                        Thermal BT-P299
                                    </option>
                                    <option value="Printer Thermal BT-P290" data-tokens="Printer Thermal BT-P290"
                                        {{ $item->device == 'Printer Thermal BT-P290' ? 'selected' : '' }}>Printer
                                        Thermal BT-P290
                                    </option>
                                    <option value="Printer Thermal BTP-3200 USE"
                                        data-tokens="Printer Thermal BTP-3200 USE"
                                        {{ $item->device == 'Printer Thermal BTP-3200 USE' ? 'selected' : '' }}>Printer
                                        Thermal BTP-3200 USE
                                    </option>
                                    <option value="Printer Thermal BTP-3200 BT" data-tokens="Printer Thermal BTP-3200 BT"
                                        {{ $item->device == 'Printer Thermal BTP-3200 BT' ? 'selected' : '' }}>
                                        Printer Thermal BTP-3200 BT
                                    </option>
                                    <option value="Printer Thermal 58" data-tokens="Printer Thermal 58"
                                        {{ $item->device == 'Printer Thermal 58' ? 'selected' : '' }}>Printer Thermal 58
                                    </option>
                                    <option value="Thermal Label 40 X 30 mm" data-tokens="Thermal Label 40 X 30 mm"
                                        {{ $item->device == 'Thermal Label 40 X 30 mm' ? 'selected' : '' }}>
                                        Thermal Label 40 X 30 mm
                                    </option>
                                    <option value="Converter USB - AUX" data-tokens="Converter USB - AUX"
                                        {{ $item->device == 'Converter USB - AUX' ? 'selected' : '' }}>
                                        Converter USB - AUX
                                    </option>
                                    <option value="Webcam Camera" data-tokens="Webcam Camera"
                                        {{ $item->device == 'Webcam Camera' ? 'selected' : '' }}>
                                        Webcam Camera
                                    </option>
                                    <option value="Comson CSPL 78 BT" data-tokens="Comson CSPL 78 BT"
                                        {{ $item->device == 'Comson CSPL 78 BT' ? 'selected' : '' }}>
                                        Comson CSPL 78 BT
                                    </option>
                                    <option value="Comson CSP 893 UE" data-tokens="Comson CSP 893 UE"
                                        {{ $item->device == 'Comson CSP 893 UE' ? 'selected' : '' }}>
                                        Comson CSP 893 UE
                                    </option>
                                    <option value="Crane 1" {{ $item->device == 'Crane 1' ? 'selected' : '' }}>
                                        Crane 1
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="ram"><b>RAM/Storage</b></label>
                                <select class="form-control" id="ram" name="ram" required>
                                    <option value="Pilih RAM/Storage">Pilih RAM/Storage</option>
                                    <option value="-" data-tokens="-" {{ $item->ram == '-' ? 'selected' : '' }}>
                                        -
                                    </option>
                                    <option value="1/8" data-tokens="1/8"
                                        {{ $item->ram == '1/8' ? 'selected' : '' }}>
                                        1/8
                                    </option>
                                    <option value="2/8" data-tokens="2/8"
                                        {{ $item->ram == '2/8' ? 'selected' : '' }}>
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
                                    <option value="8/128" data-tokens="8/128"
                                        {{ $item->ram == '8/128' ? 'selected' : '' }}>
                                        8/128
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="android"><b>Versi Android</b></label>
                                <select class="form-control" id="android" name="android" required>
                                    <option value="Pilih Android">Pilih Android</option>
                                    <option value="-" data-tokens="-"
                                        {{ $item->android == '-' ? 'selected' : '' }}>
                                        -
                                    </option>
                                    <option value="Android 7" data-tokens="Android 7"
                                        {{ $item->android == 'Android 7' ? 'selected' : '' }}>
                                        Android 7
                                    </option>
                                    <option value="Android 8" data-tokens="Android 8"
                                        {{ $item->android == 'Android 8' ? 'selected' : '' }}>
                                        Android 8
                                    </option>
                                    <option value="Android 11" data-tokens="Android 11"
                                        {{ $item->android == 'Android 11' ? 'selected' : '' }}>
                                        Android 11
                                    </option>
                                    <option value="Android 11 GMS" data-tokens="Android 11 GMS"
                                        {{ $item->android == 'Android 11 GMS' ? 'selected' : '' }}>
                                        Android 11 GMS
                                    </option>
                                    <option value="Android 13" data-tokens="Android 13"
                                        {{ $item->android == 'Android 13' ? 'selected' : '' }}>
                                        Android 13
                                    </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="customer" class="form-label"><b>Customer</b></label>
                                <input type="text" class="form-control" id="customer" name="customer"
                                    value="{{ $item->customer }}">
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label"><b>Alamat</b></label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="3">{{ $item->alamat }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="sales" class="form-label"><b>Sales</b></label>
                                <input type="text" class="form-control" id="sales" name="sales"
                                    value="{{ $item->sales }}">
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
                                <textarea class="form-control" id="kelengkapankirim" name="kelengkapankirim" rows="3">{{ $item->kelengkapankirim }}</textarea>
                            </div>
                            <div class="mb-3" hidden>
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
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
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
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
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
                            <label for="customer" class="form-label"><b>Customer</b></label>
                            <input type="text" class="form-control" id="customer" name="customer"
                                value="{{ $item->customer }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label"><b>Alamat</b></label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="3" readonly>{{ $item->alamat }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="sales" class="form-label"><b>Sales</b></label>
                            <input type="text" class="form-control" id="sales" name="sales"
                                value="{{ $item->sales }}" readonly>
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
                            <img src="{{ asset('storage/gambar/' . $item->gambar) }}" width='60' height='60'
                                class="img img-responsive" id="gambar" name="gambar">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this Data?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
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
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
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
                                <label for="customer" class="form-label"><b>Customer</b></label>
                                <input type="text" class="form-control" id="customer" name="customer"
                                    value="{{ $item->customer }}"readonly>
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label"><b>Alamat</b></label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="3" readonly>{{ $item->alamat }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="sales" class="form-label"><b>Sales</b></label>
                                <input type="text" class="form-control" id="sales" name="sales"
                                    value="{{ $item->sales }}"readonly>
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
                                <textarea class="form-control" id="kelengkapankirim" name="kelengkapankirim" rows="3" readonly>{{ $item->kelengkapankirim }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="tanggalkembali" class="form-label"><b>Tanggal Kembali</b></label>
                                <input type="date" class="form-control" id="tanggalkembali"
                                    name="tanggalkembali">
                            </div>
                            <div class="mb-3">
                                <label for="penerima" class="form-label"><b>Penerima</b></label>
                                <input type="text" class="form-control" id="penerima" name="penerima"
                                    placeholder="Masukan Nama Penerima">
                            </div>
                            <div class="mb-3">
                                <label for="kelengkapankembali" class="form-label"><b>Kelengkapan Kembali</b></label>
                                <textarea class="form-control" id="kelengkapankembali" name="kelengkapankembali" rows="3"
                                    placeholder="Contoh:Adaptor,Dus,Docking"></textarea>
                            </div>
                            <div class="mb-3" hidden>
                                <label for="status" class="form-label"><b>Status</b></label>
                                <input type="text" class="form-control" id="status" name="status"
                                    value="1" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="gambar" class="form-label"><b>Gambar</b></label><br>
                                <img src="{{ asset('storage/gambar/' . $item->gambar) }}" width='60'
                                    height='60' class="img img-responsive" id="gambar" name="gambar">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
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
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
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
                            <label for="customer" class="form-label"><b>Customer</b></label>
                            <input type="text" class="form-control" id="customer" name="customer"
                                value="{{ $item->customer }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label"><b>Alamat</b></label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="3" readonly>{{ $item->alamat }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="sales" class="form-label"><b>Sales</b></label>
                            <input type="text" class="form-control" id="sales" name="sales"
                                value="{{ $item->sales }}" readonly>
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
                            <img src="{{ asset('storage/gambar/' . $item->gambar) }}" width='60' height='60'
                                class="img img-responsive" id="gambar" name="gambar">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                    <form method="POST" action="{{ route('users.update', $item->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Edit Data Pinjam</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
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
                                <select class="form-select form-control-chosen" name="device" id="device"
                                    required>
                                    <option value="Pilih Model">Pilih Model</option>
                                    <option value="A4-101 Handle" data-tokens="A4-101 Handle"
                                        {{ $item->device == 'A4-101 Handle' ? 'selected' : '' }}>A4-101 Handle</option>
                                    <option value="A4-102 Desktop Stand" data-tokens="A4-102 Desktop Stand"
                                        {{ $item->device == 'A4-102 Desktop Stand' ? 'selected' : '' }}>A4-102 Desktop
                                        Stand</option>
                                    <option value="A4-103 Stand" data-tokens="A4-103 Stand"
                                        {{ $item->device == 'A4-103 Stand' ? 'selected' : '' }}>A4-103 Stand</option>
                                    <option value="A4-104 Stand" data-tokens="A4-104 Stand"
                                        {{ $item->device == 'A4-104 Stand' ? 'selected' : '' }}>A4-104 Stand</option>
                                    <option value="A4-105 Stand" data-tokens="A4-105 Stand"
                                        {{ $item->device == 'A4-105 Stand' ? 'selected' : '' }}>A4-105 Stand</option>
                                    <option value="A4-107 Desktop Stand" data-tokens="A4-107 Desktop Stand"
                                        {{ $item->device == 'A4-107 Desktop Stand' ? 'selected' : '' }}>A4-107 Desktop
                                        Stand</option>
                                    <option value="D1" data-tokens="D1"
                                        {{ $item->device == 'D1' ? 'selected' : '' }}>D1</option>
                                    <option value="D1 Pro" data-tokens="D1 Pro"
                                        {{ $item->device == 'D1 Pro' ? 'selected' : '' }}>D1 Pro</option>
                                    <option value="D1 Moka" data-tokens="D1 Moka"
                                        {{ $item->device == 'D1 Moka' ? 'selected' : '' }}>D1 Moka</option>
                                    <option value="D1W-702" data-tokens="D1W-702"
                                        {{ $item->device == 'D1W-702' ? 'selected' : '' }}>D1W-702</option>
                                    <option value="D2 Pro" data-tokens="D2 Pro"
                                        {{ $item->device == 'D2 Pro' ? 'selected' : '' }}>D2 Pro</option>
                                    <option value="D2-401" data-tokens="D2-401"
                                        {{ $item->device == 'D2-401' ? 'selected' : '' }}>D2-401</option>
                                    <option value="D2-402" data-tokens="D2-402"
                                        {{ $item->device == 'D2-402' ? 'selected' : '' }}>D2-402</option>
                                    <option value="D3-504" data-tokens="D3-504"
                                        {{ $item->device == 'D3-504' ? 'selected' : '' }}>D3-504</option>
                                    <option value="D3-505" data-tokens="D3-505"
                                        {{ $item->device == 'D3-505' ? 'selected' : '' }}>D3-505</option>
                                    <option value="D3-506" data-tokens="D3-506"
                                        {{ $item->device == 'D3-506' ? 'selected' : '' }}>D3-506</option>
                                    <option value="D3-504 lama" data-tokens="D3-504 lama"
                                        {{ $item->device == 'D3-504 lama' ? 'selected' : '' }}>D3-504 lama</option>
                                    <option value="D3-505 lama" data-tokens="D3-505 lama"
                                        {{ $item->device == 'D3-505 lama' ? 'selected' : '' }}>D3-505 lama</option>
                                    <option value="D3-506 lama" data-tokens="D3-506 lama"
                                        {{ $item->device == 'D3-506 lama' ? 'selected' : '' }}>D3-506 lama</option>
                                    <option value="D3-501 Moka" data-tokens="D3-501 Moka"
                                        {{ $item->device == 'D3-501 Moka' ? 'selected' : '' }}>D3-501 Moka</option>
                                    <option value="D3-503 Moka" data-tokens="D3-503 Moka"
                                        {{ $item->device == 'D3-503 Moka' ? 'selected' : '' }}>D3-503 Moka</option>
                                    <option value="D3-501 Moka Ultra" data-tokens="D3-501 Moka Ultra"
                                        {{ $item->device == 'D3-501 Moka Ultra' ? 'selected' : '' }}>D3-501 Moka Ultra
                                    </option>
                                    <option value="D3-503 Moka Ultra+" data-tokens="D3-503 Moka Ultra+"
                                        {{ $item->device == 'D3-503 Moka Ultra+' ? 'selected' : '' }}>D3-503 Moka Ultra+
                                    </option>
                                    <option value="D3 DS1" data-tokens="D3 DS1"
                                        {{ $item->device == 'D3 DS1' ? 'selected' : '' }}>D3 DS1</option>
                                    <option value="D3 DS1K" data-tokens="D3 DS1K"
                                        {{ $item->device == 'D3 DS1K' ? 'selected' : '' }}>D3 DS1K</option>
                                    <option value="D3 DS1 DP" data-tokens="D3 DS1 DP"
                                        {{ $item->device == 'D3 DS1 DP' ? 'selected' : '' }}>D3 DS1 DP</option>
                                    <option value="D3 DS1 PRO DP" data-tokens="D3 DS1 PRO DP"
                                        {{ $item->device == 'D3 DS1 PRO DP' ? 'selected' : '' }}>D3 DS1 PRO DP</option>
                                    <option value="D3 DS1 TS DP" data-tokens="D3 DS1 TS DP"
                                        {{ $item->device == 'D3 DS1 TS DP' ? 'selected' : '' }}>D3 DS1 TS DP</option>
                                    <option value="D3 DS1 HDMI" data-tokens="D3 DS1 HDMI"
                                        {{ $item->device == 'D3 DS1 HDMI' ? 'selected' : '' }}>D3 DS1 HDMI</option>
                                    <option value="D3 DS1 HDMI TS" data-tokens="D3 DS1 HDMI TS"
                                        {{ $item->device == 'D3 DS1 HDMI TS' ? 'selected' : '' }}>D3 DS1 HDMI TS</option>
                                    <option value="D3 DS1 HDMI NFC" data-tokens="D3 DS1 HDMI NFC"
                                        {{ $item->device == 'D3 DS1 HDMI NFC' ? 'selected' : '' }}>D3 DS1 HDMI NFC
                                    </option>
                                    <option value="D3 DS1 Iseller" data-tokens="D3 DS1 Iseller"
                                        {{ $item->device == 'D3 DS1 Iseller' ? 'selected' : '' }}>D3 DS1 Iseller</option>
                                    <option value="D3 DS1 Iseller DP" data-tokens="D3 DS1 Iseller DP"
                                        {{ $item->device == 'D3 DS1 Iseller DP' ? 'selected' : '' }}>D3 DS1 Iseller DP
                                    </option>
                                    <option value="D3 DS1 TS Iseller DP" data-tokens="D3 DS1 TS Iseller DP"
                                        {{ $item->device == 'D3 DS1 TS Iseller DP' ? 'selected' : '' }}>D3 DS1 TS
                                        Iseller DP</option>
                                    <option value="D3 DS1 Iseller Extention Display DP"
                                        data-tokens="D3 DS1 Iseller Extention Display DP"
                                        {{ $item->device == 'D3 DS1 Iseller Extention Display DP' ? 'selected' : '' }}>D3
                                        DS1 Iseller Extention Display DP</option>
                                    <option value="D3 DS1 Stand" data-tokens="D3 DS1 Stand"
                                        {{ $item->device == 'D3 DS1 Stand' ? 'selected' : '' }}>D3 DS1 Stand</option>
                                    <option value="D3 DS1 Stand 1M DP" data-tokens="D3 DS1 Stand 1M DP"
                                        {{ $item->device == 'D3 DS1 Stand 1M DP' ? 'selected' : '' }}>D3 DS1 Stand 1M DP
                                    </option>
                                    <option value="D3 DS1 Display NFC" data-tokens="D3 DS1 Display NFC"
                                        {{ $item->device == 'D3 DS1 Display NFC' ? 'selected' : '' }}>D3 DS1 Display NFC
                                    </option>
                                    <option value="D3 DS1 Extention Display" data-tokens="D3 DS1 Extention Display"
                                        {{ $item->device == 'D3 DS1 Extention Display' ? 'selected' : '' }}>D3 DS1
                                        Extention Display</option>
                                    <option value="D3 DS1 Extention Display Iseller"
                                        data-tokens="D3 DS1 Extention Display Iseller"
                                        {{ $item->device == 'D3 DS1 Extention Display Iseller' ? 'selected' : '' }}>D3 DS1
                                        Extention Display Iseller</option>
                                    <option value="D3 DS1 Extention Display DP"
                                        data-tokens="D3 DS1 Extention Display DP"
                                        {{ $item->device == 'D3 DS1 Extention Display DP' ? 'selected' : '' }}>
                                        D3 DS1 Extention Display DP</option>
                                    <option value="D3 DS1 Extention Display TS"
                                        data-tokens="D3 DS1 Extention Display TS"
                                        {{ $item->device == 'D3 DS1 Extention Display TS' ? 'selected' : '' }}>
                                        D3 DS1 Extention Display TS</option>
                                    <option value="D3 DS1 Extention Display TS DP"
                                        data-tokens="D3 DS1 Extention Display TS DP"
                                        {{ $item->device == 'D3 DS1 Extention Display TS DP' ? 'selected' : '' }}>
                                        D3 DS1 Extention Display TS DP</option>
                                    <option value="D3 DS1 Extention Display HDMI"
                                        data-tokens="D3 DS1 Extention Display HDMI"
                                        {{ $item->device == 'D3 DS1 Extention Display HDMI' ? 'selected' : '' }}>
                                        D3 DS1 Extention Display HDMI</option>
                                    <option value="D3 DS1 Extention Display TS HDMI"
                                        data-tokens="D3 DS1 Extention Display TS HDMI"
                                        {{ $item->device == 'D3 DS1 Extention Display TS HDMI' ? 'selected' : '' }}>D3 DS1
                                        Extention Display TS HDMI</option>
                                    <option value="D4-501" data-tokens="D4-501"
                                        {{ $item->device == 'D4-501' ? 'selected' : '' }}>D4-501</option>
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
                                    <option value="D4-504 Pro" data-tokens="D4-504 Pro"
                                        {{ $item->device == 'D4-504 Pro' ? 'selected' : '' }}>D4-504 Pro</option>
                                    <option value="D4-505" data-tokens="D4-505"
                                        {{ $item->device == 'D4-505' ? 'selected' : '' }}>D4-505</option>
                                    <option value="D4-505 DT" data-tokens="D4-505 DT"
                                        {{ $item->device == 'D4-505 DT' ? 'selected' : '' }}>D4-505 DT</option>
                                    <option value="D4-505 Pro" data-tokens="D4-505 Pro"
                                        {{ $item->device == 'D4-505 Pro' ? 'selected' : '' }}>D4-505 Pro</option>
                                    <option value="D4 Falcon 1" data-tokens="D4 Falcon 1"
                                        {{ $item->device == 'D4 Falcon 1' ? 'selected' : '' }}>D4 Falcon 1</option>
                                    <option value="M1" data-tokens="M1"
                                        {{ $item->device == 'M1' ? 'selected' : '' }}>M1</option>
                                    <option value="M2-201" data-tokens="M2-201"
                                        {{ $item->device == 'M2-201' ? 'selected' : '' }}>M2-201</option>
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
                                    <option value="M2-203 (Full)" data-tokens="M2-203 (Full)"
                                        {{ $item->device == 'M2-203 (Full)' ? 'selected' : '' }}>M2-203 (Full)</option>
                                    <option value="M2-203 NFC Iseller" data-tokens="M2-203 NFC Iseller"
                                        {{ $item->device == 'M2-203 NFC Iseller' ? 'selected' : '' }}>M2-203 NFC Iseller
                                    </option>
                                    <option value="M-203 Traveloka" data-tokens="M2-203 Traveloka"
                                        {{ $item->device == 'M-203 Traveloka' ? 'selected' : '' }}>M2-203 Traveloka
                                    </option>
                                    <option value="M2-203 Grab" data-tokens="M2-203 Grab"
                                        {{ $item->device == 'M2-203 Grab' ? 'selected' : '' }}>M2-203 Grab
                                    </option>
                                    <option value="M2 Pro" data-tokens="M2 Pro"
                                        {{ $item->device == 'M2 Pro' ? 'selected' : '' }}>M2 Pro</option>
                                    <option value="M2 Max" data-tokens="M2 Max"
                                        {{ $item->device == 'M2 Max' ? 'selected' : '' }}>M2 Max</option>
                                    <option value="M2 Max NFC" data-tokens="M2 Max NFC"
                                        {{ $item->device == 'M2 Max NFC' ? 'selected' : '' }}>M2 Max NFC</option>
                                    <option value="M2 Max BASE" data-tokens="M2 Max BASE"
                                        {{ $item->device == 'M2 Max BASE' ? 'selected' : '' }}>M2 Max BASE</option>
                                    <option value="M2 Swift 1S" data-tokens="M2 Swift 1S"
                                        {{ $item->device == 'M2 Swift 1S' ? 'selected' : '' }}>M2 Swift 1S</option>
                                    <option value="M2 Swift 1S NFC" data-tokens="M2 Swift 1S NFC"
                                        {{ $item->device == 'M2 Swift 1S NFC' ? 'selected' : '' }}>M2 Swift 1S NFC
                                    </option>
                                    <option value="M2 Swift 1P" data-tokens="M2 Swift 1P"
                                        {{ $item->device == 'M2 Swift 1P' ? 'selected' : '' }}>M2 Swift 1P</option>
                                    <option value="M2 Swift 1 NFC" data-tokens="M2 Swift 1 NFC"
                                        {{ $item->device == 'M2 Swift 1 NFC' ? 'selected' : '' }}>M2 Swift 1 NFC</option>
                                    <option value="M2 Swift 1P NFC" data-tokens="M2 Swift 1P NFC"
                                        {{ $item->device == 'M2 Swift 1P NFC' ? 'selected' : '' }}>M2 Swift 1P NFC
                                    </option>
                                    <option value="M2 Swift PDA" data-tokens="M2 Swift PDA"
                                        {{ $item->device == 'M2 Swift PDA' ? 'selected' : '' }}>M2 Swift PDA</option>
                                    <option value="M2 Swift 1 PDA" data-tokens="M2 Swift 1 PDA"
                                        {{ $item->device == 'M2 Swift 1 PDA' ? 'selected' : '' }}>M2 Swift 1 PDA</option>
                                    <option value="M2 Swift 1 STRAP" data-tokens="M2 Swift 1 STRAP"
                                        {{ $item->device == 'M2 Swift 1 STRAP' ? 'selected' : '' }}>M2 Swift 1 STRAP
                                    </option>
                                    <option value="M2 Swift 1 Scanner" data-tokens="M2 Swift 1 Scanner"
                                        {{ $item->device == 'M2 Swift 1 Scanner' ? 'selected' : '' }}>M2 Swift 1 Scanner
                                    </option>
                                    <option value="M2 Swift Printer" data-tokens="M2 Swift Printer"
                                        {{ $item->device == 'M2 Swift Printer' ? 'selected' : '' }}>M2 Swift Printer
                                    </option>
                                    <option value="M2 Swift 1 Printer" data-tokens="M2 Swift 1 Printer"
                                        {{ $item->device == 'M2 Swift 1 Printer' ? 'selected' : '' }}>M2 Swift 1 Printer
                                    </option>
                                    <option value="M2 Swift 2 Pro" data-tokens="M2 Swift 2 Pro"
                                        {{ $item->device == 'M2 Swift 2 Pro' ? 'selected' : '' }}>M2 Swift 2 Pro
                                    </option>
                                    <option value="R1-201" data-tokens="R1-201"
                                        {{ $item->device == 'R1-201' ? 'selected' : '' }}>R1-201</option>
                                    <option value="R1-202" data-tokens="R1-202"
                                        {{ $item->device == 'R1-202' ? 'selected' : '' }}>R1-202</option>
                                    <option value="S1-701" data-tokens="S1-701"
                                        {{ $item->device == 'S1-701' ? 'selected' : '' }}>S1-701</option>
                                    <option value="S1 Rotating Bracket" data-tokens="S1 Rotating Bracket"
                                        {{ $item->device == 'S1 Rotating Bracket' ? 'selected' : '' }}>S1 Rotating
                                        Bracket</option>
                                    <option value="S1 Wall Mount" data-tokens="S1 Wall Mount"
                                        {{ $item->device == 'S1 Wall Mount' ? 'selected' : '' }}>S1 Wall Mount</option>
                                    <option value="K1-101" data-tokens="K1-101"
                                        {{ $item->device == 'K1-101' ? 'selected' : '' }}>K1-101</option>
                                    <option value="K2-201" data-tokens="K2-201"
                                        {{ $item->device == 'K2-201' ? 'selected' : '' }}>K2-201</option>
                                    <option value="X1-201" data-tokens="X1-201"
                                        {{ $item->device == 'X1-201' ? 'selected' : '' }}>X1-201</option>
                                    <option value="X1 Scanner" data-tokens="X1 Scanner"
                                        {{ $item->device == 'X1 Scanner' ? 'selected' : '' }}>X1 Scanner</option>
                                    <option value="Stand S1" data-tokens="Stand S1"
                                        {{ $item->device == 'Stand S1' ? 'selected' : '' }}>Stand S1</option>
                                    <option value="Stand K1" data-tokens="Stand K1"
                                        {{ $item->device == 'Stand K1' ? 'selected' : '' }}>Stand K1</option>
                                    <option value="Stand K2" data-tokens="Stand K2"
                                        {{ $item->device == 'Stand K2' ? 'selected' : '' }}>Stand K2</option>
                                    <option value="Stand Swan" data-tokens="Stand Swan"
                                        {{ $item->device == 'Stand Swan' ? 'selected' : '' }}>Stand Swan</option>
                                    <option value="Kassen Barcode 2D RS-720" data-tokens="Kassen Barcode 2D RS-720"
                                        {{ $item->device == 'Kassen Barcode 2D RS-720' ? 'selected' : '' }}>Kassen
                                        Barcode 2D RS-720</option>
                                    <option value="Kassen Barcode KS-605" data-tokens="Kassen Barcode KS-605"
                                        {{ $item->device == 'Kassen Barcode KS-605' ? 'selected' : '' }}>Kassen
                                        Barcode KS-605</option>
                                    <option value="Kassen Printer BT-P3200" data-tokens="Kassen Printer BT-P3200"
                                        {{ $item->device == 'Kassen Printer BT-P3200' ? 'selected' : '' }}>Kassen
                                        Printer BT-P3200</option>
                                    <option value="Kassen Printer BT-P299" data-tokens="Kassen Printer BT-P299"
                                        {{ $item->device == 'Kassen Printer BT-P299' ? 'selected' : '' }}>Kassen
                                        Printer BT-P299</option>
                                    <option value="Kassen Printer BT-P290" data-tokens="Kassen Printer BT-P290"
                                        {{ $item->device == 'Kassen Printer BT-P290' ? 'selected' : '' }}>Kassen
                                        Printer BT-P290</option>
                                    <option value="Kassen Printer Label DT-643"
                                        data-tokens="Kassen Printer Label DT-643"
                                        {{ $item->device == 'Kassen Printer Label DT-643' ? 'selected' : '' }}>
                                        Kassen Printer Label DT-643</option>
                                    <option value="Cash Drawer KH-330" data-tokens="Cash Drawer KH-330"
                                        {{ $item->device == 'Cash Drawer KH-330' ? 'selected' : '' }}>Cash Drawer KH-330
                                    </option>
                                    <option value="Cash Drawer KH-410" data-tokens="Cash Drawer KH-410"
                                        {{ $item->device == 'Cash Drawer KH-410' ? 'selected' : '' }}>Cash Drawer KH-410
                                    </option>
                                    <option value="Cash Drawer 408" data-tokens="Cash Drawer 408"
                                        {{ $item->device == 'Cash Drawer 408' ? 'selected' : '' }}>Cash Drawer 408
                                    </option>
                                    <option value="Cash Drawer Panda" data-tokens="Cash Drawer Panda"
                                        {{ $item->device == 'Cash Drawer Panda' ? 'selected' : '' }}>Cash Drawer Panda
                                    </option>
                                    <option value="Barcode Scanner" data-tokens="Barcode Scanner"
                                        {{ $item->device == 'Barcode Scanner' ? 'selected' : '' }}>Barcode Scanner
                                    </option>
                                    <option value="Barcode Scanner RS-720" data-tokens="Barcode Scanner RS-720"
                                        {{ $item->device == 'Barcode Scanner RS-720' ? 'selected' : '' }}>Barcode
                                        Scanner RS-720
                                    </option>
                                    <option value="Printer Thermal Label DT-643"
                                        data-tokens="Printer Thermal Label DT-643"
                                        {{ $item->device == 'Printer Thermal Label DT-643' ? 'selected' : '' }}>Printer
                                        Thermal Label DT-643
                                    </option>
                                    <option value="Printer Thermal BT-P299" data-tokens="Printer Thermal BT-P299"
                                        {{ $item->device == 'Printer Thermal BT-P299' ? 'selected' : '' }}>Printer
                                        Thermal BT-P299
                                    </option>
                                    <option value="Printer Thermal BT-P290" data-tokens="Printer Thermal BT-P290"
                                        {{ $item->device == 'Printer Thermal BT-P290' ? 'selected' : '' }}>Printer
                                        Thermal BT-P290
                                    </option>
                                    <option value="Printer Thermal BTP-3200 USE"
                                        data-tokens="Printer Thermal BTP-3200 USE"
                                        {{ $item->device == 'Printer Thermal BTP-3200 USE' ? 'selected' : '' }}>Printer
                                        Thermal BTP-3200 USE
                                    </option>
                                    <option value="Printer Thermal BTP-3200 BT"
                                        data-tokens="Printer Thermal BTP-3200 BT"
                                        {{ $item->device == 'Printer Thermal BTP-3200 BT' ? 'selected' : '' }}>
                                        Printer Thermal BTP-3200 BT
                                    </option>
                                    <option value="Printer Thermal 58" data-tokens="Printer Thermal 58"
                                        {{ $item->device == 'Printer Thermal 58' ? 'selected' : '' }}>Printer Thermal 58
                                    </option>
                                    <option value="Thermal Label 40 X 30 mm" data-tokens="Thermal Label 40 X 30 mm"
                                        {{ $item->device == 'Thermal Label 40 X 30 mm' ? 'selected' : '' }}>
                                        Thermal Label 40 X 30 mm
                                    </option>
                                    <option value="Converter USB - AUX" data-tokens="Converter USB - AUX"
                                        {{ $item->device == 'Converter USB - AUX' ? 'selected' : '' }}>
                                        Converter USB - AUX
                                    </option>
                                    <option value="Webcam Camera" data-tokens="Webcam Camera"
                                        {{ $item->device == 'Webcam Camera' ? 'selected' : '' }}>
                                        Webcam Camera
                                    </option>
                                    <option value="Comson CSPL 78 BT" data-tokens="Comson CSPL 78 BT"
                                        {{ $item->device == 'Comson CSPL 78 BT' ? 'selected' : '' }}>
                                        Comson CSPL 78 BT
                                    </option>
                                    <option value="Comson CSP 893 UE" data-tokens="Comson CSP 893 UE"
                                        {{ $item->device == 'Comson CSP 893 UE' ? 'selected' : '' }}>
                                        Comson CSP 893 UE
                                    </option>
                                    <option value="Crane 1" {{ $item->device == 'Crane 1' ? 'selected' : '' }}>
                                        Crane 1
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="ram"><b>RAM/Storage</b></label>
                                <select class="form-control" id="ram" name="ram" required>
                                    <option value="Pilih RAM/Storage">Pilih RAM/Storage</option>
                                    <option value="-" data-tokens="-" {{ $item->ram == '-' ? 'selected' : '' }}>
                                        -
                                    </option>
                                    <option value="1/8" data-tokens="1/8"
                                        {{ $item->ram == '1/8' ? 'selected' : '' }}>
                                        1/8
                                    </option>
                                    <option value="2/8" data-tokens="2/8"
                                        {{ $item->ram == '2/8' ? 'selected' : '' }}>
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
                                    <option value="8/128" data-tokens="8/128"
                                        {{ $item->ram == '8/128' ? 'selected' : '' }}>
                                        8/128
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="android"><b>Versi Android</b></label>
                                <select class="form-control" id="android" name="android" required>
                                    <option value="Pilih Android">Pilih Android</option>
                                    <option value="-" data-tokens="-"
                                        {{ $item->android == '-' ? 'selected' : '' }}>
                                        -
                                    </option>
                                    <option value="Android 7" data-tokens="Android 7"
                                        {{ $item->android == 'Android 7' ? 'selected' : '' }}>
                                        Android 7
                                    </option>
                                    <option value="Android 8" data-tokens="Android 8"
                                        {{ $item->android == 'Android 8' ? 'selected' : '' }}>
                                        Android 8
                                    </option>
                                    <option value="Android 11" data-tokens="Android 11"
                                        {{ $item->android == 'Android 11' ? 'selected' : '' }}>
                                        Android 11
                                    </option>
                                    <option value="Android 11 GMS" data-tokens="Android 11 GMS"
                                        {{ $item->android == 'Android 11 GMS' ? 'selected' : '' }}>
                                        Android 11 GMS
                                    </option>
                                    <option value="Android 13" data-tokens="Android 13"
                                        {{ $item->android == 'Android 13' ? 'selected' : '' }}>
                                        Android 13
                                    </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="customer" class="form-label"><b>Customer</b></label>
                                <input type="text" class="form-control" id="customer" name="customer"
                                    value="{{ $item->customer }}">
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label"><b>Alamat</b></label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="3">{{ $item->alamat }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="sales" class="form-label"><b>Sales</b></label>
                                <input type="text" class="form-control" id="sales" name="sales"
                                    value="{{ $item->sales }}">
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
                                <textarea class="form-control" id="kelengkapankirim" name="kelengkapankirim" rows="3">{{ $item->kelengkapankirim }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="tanggalkembali" class="form-label"><b>Tanggal Kembali</b></label>
                                <input type="date" class="form-control" id="tanggalkembali" name="tanggalkembali"
                                    value="{{ $item->tanggalkembali }}">
                            </div>
                            <div class="mb-3">
                                <label for="penerima" class="form-label"><b>Penerima</b></label>
                                <input type="text" class="form-control" id="penerima" name="penerima"
                                    placeholder="Masukan Nama Penerima" value="{{ $item->penerima }}">
                            </div>
                            <div class="mb-3">
                                <label for="kelengkapankembali" class="form-label"><b>Kelengkapan Kembali</b></label>
                                <textarea class="form-control" id="kelengkapankembali" name="kelengkapankembali" rows="3"
                                    placeholder="Contoh:Adaptor,Dus,Docking">{{ $item->kelengkapankembali }}</textarea>
                            </div>
                            <div class="mb-3" hidden>
                                <label for="status" class="form-label"><b>Status</b></label>
                                <input type="text" class="form-control" id="status" name="status"
                                    value="{{ $item->status }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="gambar" class="form-label"><b>Gambar</b></label><br>
                                <input class="form-control" type="file" id="gambar" name="gambar">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
    <!-- end kembali edit data -->

    <div class="container-fluid mt-3">
        <table id="hometable" class="table table-striped table-bordered" style="width:100%">
            <thead class="headfix">
                <th>No</th>
                <th>Tanggal</th>
                {{-- <th>Gambar</th> --}}

                <th>Serial Number</th>
                <th>Tipe Device</th>
                <th>Customer</th>
                <th>Action</th>
            </thead>
            <tbody>
                @empty($pinjam)
                    <tr>
                        <td colspan="6">No data found</td>
                    </tr>
                @else
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

                                @if (Auth::check() && request()->is('pinjam'))
                                    <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                        data-target="#editModal{{ $item->id }}"><i
                                            class="fa-solid fa-pen-to-square"></i></a>
                                @endif

                                @if (Auth::check() && request()->is('kembali'))
                                    <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                        data-target="#editkembaliModal{{ $item->id }}"><i
                                            class="fa-solid fa-pen-to-square"></i></a>
                                @endif

                                @if (request()->is('pinjam'))
                                    <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-target="#viewModal{{ $item->id }}"><i class="fa-solid fa-eye"></i></a>
                                @else
                                    <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-target="#viewkembaliModal{{ $item->id }}"><i
                                            class="fa-solid fa-eye"></i></a>
                                @endif

                                @if (Auth::check())
                                    <a href="#" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-target="#deleteModal{{ $item->id }}"><i
                                            class="fa-solid fa-trash"></i></a>
                                @endif

                                @if (Auth::check() && request()->is('pinjam'))
                                    <a href="#" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                        data-target="#moveModal{{ $item->id }}"><i
                                            class="fa-solid fa-paper-plane"></i></a>
                                @endif

                                @if (Auth::check())
                                    <a href="{{ url('generate-pdf', $item->id) }}" class="btn btn-secondary btn-sm"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Download PDF"><i
                                            class="fa-solid fa-file-pdf"></i></a>
                                @endif

                            </td>
                        </tr>
                    @endforeach
                @endempty
            </tbody>
        </table>
    </div>
@endsection
