@extends('layouts.app')
@extends('layouts.navbar')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <h1 class="h3 mb-3 text-gray-800">Monitor All Stocks</h1>
            @if (Auth::check())
                <div class="head-area">
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#stockModal">
                        <i class="fa-solid fa-plus"></i> Tambah
                    </button>
                </div>
            @endif
            <div class="buttonarea d-flex gap-3 justify-content-end mb-3">
                <button type="button" class="btn btn-success text-white" data-bs-toggle="modal"
                    data-target="#importModal"><i class="fa-solid fa-file-import" style="color: #ffffff;"></i>
                    Import Excel
                </button>
                <a href="{{ route('export.stocks') }}" class="btn btn text-white float-end"
                    style="background-color: #F05025"><i class="fa-solid fa-download" style="color: #ffffff;"></i> Export
                    Excel</a>
            </div>
        </div>
    </div>

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
                        <a href="{{ route('template.stocks', ['filename' => 'templatestocks.xlsx']) }}"
                            class="d-flex justify-content-center">Download
                            template</a>
                        <div class="table table-bordered mt-2" id="preview"></div>
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
                            <label for="serialnumber"><b>Serial Number</b></label>
                            <input type="text" class="form-control" id="serialnumber" name="serialnumber"
                                placeholder="Masukan Serial Number" required value="{{ old('serialnumber') }}">
                        </div>
                        <div class="form-group">
                            <label for="tipe"><b>Tipe Device</b></label><br />
                            <select id="tipe" class="form-control form-control-chosen" name="tipe"
                                data-placeholder="Pilih Tipe Device" required>
                                <option value="Null">Pilih Tipe Device</option>
                                <option value="A4-101" data-tokens="A4-101">A4-101</option>
                                <option value="A4-102" data-tokens="A4-102">A4-102</option>
                                <option value="A4-103" data-tokens="A4-103">A4-103</option>
                                <option value="A4-104" data-tokens="A4-104">A4-104</option>
                                <option value="A4-105" data-tokens="A4-105">A4-105</option>
                                <option value="A4-107" data-tokens="A4-107">A4-107</option>
                                <option value="D1 2+16" data-tokens="D1 2+16">D1 2+16</option>
                                <option value="D1 2+16 MOKA" data-tokens="D1 2+16 MOKA">D1 2+16 MOKA</option>
                                <option value="D1-Pro 4+16 NFC" data-tokens="D1-Pro 4+16 NFC">D1-Pro 4+16 NFC
                                </option>
                                <option value="D1-Pro 8+128 NFC" data-tokens="D1-Pro 8+128 NFC">D1-Pro 8+128 NFC
                                </option>
                                <option value="D1W-702" data-tokens="D1W-702">D1W-702</option>
                                <option value="D1W-702 4+16" data-tokens="D1W-702 4+16">D1W-702 4+16</option>
                                <option value="D2 Pro 1+8" data-tokens="D2 Pro 1+8">D2 Pro 1+8</option>
                                <option value="D2 Pro 2+16" data-tokens="D2 Pro 2+16">D2 Pro 2+16</option>
                                <option value="D2-401" data-tokens="D2-401">D2-401</option>
                                <option value="D2-402" data-tokens="D2-402">D2-402</option>
                                <option value="D2-402 2+16" data-tokens="D2-402 2+16">D2-402 2+16</option>
                                <option value="D3 DS1 2+16" data-tokens="D3 DS1 2+16">D3 DS1 2+16</option>
                                <option value="D3 DS1 2+16 DP" data-tokens="D3 DS1 2+16 DP">D3 DS1 2+16 DP</option>
                                <option value="D3 DS1 2+16 TS" data-tokens="D3 DS1 2+16 TS">D3 DS1 2+16 TS</option>
                                <option value="D3 DS1 4+32" data-tokens="D3 DS1 4+32">D3 DS1 4+32</option>
                                <option value="D3 DS1 4+32 (iSeller)" data-tokens="D3 DS1 4+32 (iSeller)">D3 DS1
                                    4+32 (iSeller)</option>
                                <option value="D3 DS1 4+32 DP" data-tokens="D3 DS1 4+32 DP">D3 DS1 4+32 DP</option>
                                <option value="D3 DS1 4+32 TS" data-tokens="D3 DS1 4+32 TS">D3 DS1 4+32 TS</option>
                                <option value="D3 DS1 Extention Display" data-tokens="D3 DS1 Extention Display">D3
                                    DS1 Extention Display</option>
                                <option value="D3 DS1 EXTENTION DISPLAY (DP)" data-tokens="D3 DS1 EXTENTION DISPLAY (DP)">
                                    D3 DS1 EXTENTION DISPLAY (DP)
                                </option>
                                <option value="D3 DS1 EXTENTION DISPLAY (DP) TS"
                                    data-tokens="D3 DS1 EXTENTION DISPLAY (DP) TS">D3 DS1 EXTENTION DISPLAY (DP) TS
                                </option>
                                <option value="D3 DS1 EXTENTION DISPLAY (HDMI)"
                                    data-tokens="D3 DS1 EXTENTION DISPLAY (HDMI)">D3 DS1 EXTENTION DISPLAY (HDMI)
                                </option>
                                <option value="D3 DS1 EXTENTION DISPLAY (iseller)"
                                    data-tokens="D3 DS1 EXTENTION DISPLAY (iseller)">D3 DS1 EXTENTION DISPLAY
                                    (iseller)</option>
                                <option value="D3 DS1 Extention Display TS" data-tokens="D3 DS1 Extention Display TS">D3
                                    DS1 Extention Display TS</option>
                                <option value="D3 DS1 PRO 8+128" data-tokens="D3 DS1 PRO 8+128">D3 DS1 PRO 8+128
                                </option>
                                <option value="D3 DS1 STAND" data-tokens="D3 DS1 STAND">D3 DS1 STAND</option>
                                <option value="D3 DS1 STAND (1 M CABLE) / HDMI"
                                    data-tokens="D3 DS1 STAND (1 M CABLE) / HDMI">D3 DS1 STAND (1 M CABLE) / HDMI
                                </option>
                                <option value="D3 DS1 STAND (1 M CABLE)/DP" data-tokens="D3 DS1 STAND (1 M CABLE)/DP">D3
                                    DS1 STAND (1 M CABLE)/DP</option>
                                <option value="D3 DS1 STAND 50 CM" data-tokens="D3 DS1 STAND 50 CM">D3 DS1 STAND
                                    50 CM</option>
                                <option value="D3 DS1K 2+16" data-tokens="D3 DS1K 2+16">D3 DS1K 2+16</option>
                                <option value="D3-501 2+16" data-tokens="D3-501 2+16">D3-501 2+16</option>
                                <option value="D3-501 4+16 MOKA ULTRA" data-tokens="D3-501 4+16 MOKA ULTRA">D3-501
                                    4+16 MOKA ULTRA</option>
                                <option value="D3-503 2+16" data-tokens="D3-503 2+16">D3-503 2+16</option>
                                <option value="D3-503 4+16 MOKA ULTRA" data-tokens="D3-503 4+16 MOKA ULTRA">D3-503
                                    4+16 MOKA ULTRA</option>
                                <option value="D3-504 1+8" data-tokens="D3-504 1+8">D3-504 1+8</option>
                                <option value="D3-504 2+16" data-tokens="D3-504 2+16">D3-504 2+16</option>
                                <option value="D3-504 4+16" data-tokens="D3-504 4+16">D3-504 4+16</option>
                                <option value="D3-505 2+16" data-tokens="D3-505 2+16">D3-505 2+16</option>
                                <option value="D3-505 2+8" data-tokens="D3-505 2+8">D3-505 2+8</option>
                                <option value="D3-505 4+16" data-tokens="D3-505 4+16">D3-505 4+16</option>
                                <option value="D3-505 4+64" data-tokens="D3-505 4+64">D3-505 4+64</option>
                                <option value="D3-506 2+16" data-tokens="D3-506 2+16">D3-506 2+16</option>
                                <option value="D3-506 4+16" data-tokens="D3-506 4+16">D3-506 4+16</option>
                                <option value="D4-501" data-tokens="D4-501">D4-501</option>
                                <option value="D4-502" data-tokens="D4-502">D4-502</option>
                                <option value="D4-503 2+16" data-tokens="D4-503 2+16">D4-503 2+16</option>
                                <option value="D4-503 2+16 WHITE" data-tokens="D4-503 2+16 WHITE">D4-503 2+16
                                    WHITE</option>
                                <option value="D4-503 4+16" data-tokens="D4-503 4+16">D4-503 4+16</option>
                                <option value="D4-503 4+16 1D" data-tokens="D4-503 4+16 1D">D4-503 4+16 1D
                                </option>
                                <option value="D4-504 2+16" data-tokens="D4-504 2+16">D4-504 2+16</option>
                                <option value="D4-504 2+16 WHITE" data-tokens="D4-504 2+16 WHITE">D4-504 2+16
                                    WHITE</option>
                                <option value="D4-504 4+16" data-tokens="D4-504 4+16">D4-504 4+16</option>
                                <option value="D4-504 4+64 Pro" data-tokens="D4-504 4+64 Pro">D4-504 4+64 Pro
                                </option>
                                <option value="D4-505 2+16" data-tokens="D4-505 2+16">D4-505 2+16</option>
                                <option value="D4-505 4+16" data-tokens="D4-505 4+16">D4-505 4+16</option>
                                <option value="D4-505 4+16 DT" data-tokens="D4-505 4+16 DT">D4-505 4+16 DT
                                </option>
                                <option value="D4-505 4+32" data-tokens="D4-505 4+32">D4-505 4+32</option>
                                <option value="D4-505 4+64" data-tokens="D4-505 4+64">D4-505 4+64</option>
                                <option value="D4-505 4+64 DT" data-tokens="D4-505 4+64 DT">D4-505 4+64 DT
                                </option>
                                <option value="D4-505 8+128 DT" data-tokens="D4-505 8+128 DT">D4-505 8+128 DT
                                </option>
                                <option value="D4-505 PRO" data-tokens="D4-505 PRO">D4-505 PRO</option>
                                <option value="D4-505 PRO 8+128" data-tokens="D4-505 PRO 8+128">D4-505 PRO 8+128
                                </option>
                                <option value="D4-Falcon 1 2+16" data-tokens="D4-Falcon 1 2+16">D4-Falcon 1 2+16
                                </option>
                                <option value="D4-Falcon 1 4+32 NFC" data-tokens="D4-Falcon 1 4+32 NFC">D4-Falcon
                                    1 4+32 NFC</option>
                                <option value="K1-101" data-tokens="K1-101">K1-101</option>
                                <option value="K1-101 4+16" data-tokens="K1-101 4+16">K1-101 4+16</option>
                                <option value="K1-101 4+32" data-tokens="K1-101 4+32">K1-101 4+32</option>
                                <option value="K2-201 2+16" data-tokens="K2-201 2+16">K2-201 2+16</option>
                                <option value="M2 SWIFT 1 2+16" data-tokens="M2 SWIFT 1 2+16">M2 SWIFT 1 2+16
                                </option>
                                <option value="M2 Swift 1 2+16 NFC" data-tokens="M2 Swift 1 2+16 NFC">M2 Swift 1
                                    2+16 NFC</option>
                                <option value="M2 Swift 1 4+32 NFC" data-tokens="M2 Swift 1 4+32 NFC">M2 Swift 1
                                    4+32 NFC</option>
                                <option value="M2 SWIFT 1 PRINTER" data-tokens="M2 SWIFT 1 PRINTER">M2 SWIFT 1
                                    PRINTER</option>
                                <option value="M2 SWIFT 1 SCANNER" data-tokens="M2 SWIFT 1 SCANNER">M2 SWIFT 1
                                    SCANNER</option>
                                <option value="M2 SWIFT 1 STRAP" data-tokens="M2 SWIFT 1 STRAP">M2 SWIFT 1 STRAP
                                </option>
                                <option value="M2 Swift 1p 2+16 NFC" data-tokens="M2 Swift 1p 2+16 NFC">M2 Swift
                                    1p 2+16 NFC</option>
                                <option value="M2 Swift 1P 4+32 NFC" data-tokens="M2 Swift 1P 4+32 NFC">M2 Swift
                                    1P 4+32 NFC</option>
                                <option value="M2 Swift 1s 2+16 NFC" data-tokens="M2 Swift 1s 2+16 NFC">M2 Swift
                                    1s 2+16 NFC</option>
                                <option value="M2 Swift 1s 4+32 NFC" data-tokens="M2 Swift 1s 4+32 NFC">M2 Swift
                                    1s 4+32 NFC</option>
                                <option value="M2-201" data-tokens="M2-201">M2-201</option>
                                <option value="M2-202 1+8" data-tokens="M2-202 1+8">M2-202 1+8</option>
                                <option value="M2-202 1+8 iSeller" data-tokens="M2-202 1+8 iSeller">M2-202 1+8
                                    iSeller</option>
                                <option value="M2-202 2+16" data-tokens="M2-202 2+16">M2-202 2+16</option>
                                <option value="M2-202 2+16 OLSERA" data-tokens="M2-202 2+16 OLSERA">M2-202 2+16
                                    OLSERA</option>
                                <option value="M2-203 (Full)" data-tokens="M2-203 (Full)">M2-203 (Full)</option>
                                <option value="M2-203 1+8" data-tokens="M2-203 1+8">M2-203 1+8</option>
                                <option value="M2-203 1+8 iSeller" data-tokens="M2-203 1+8 iSeller">M2-203 1+8
                                    iSeller</option>
                                <option value="M2-203 1+8 NFC ISELLER" data-tokens="M2-203 1+8 NFC ISELLER">M2-203
                                    1+8 NFC ISELLER</option>
                                <option value="M2-203 1+8 WHITE" data-tokens="M2-203 1+8 WHITE">M2-203 1+8 WHITE
                                </option>
                                <option value="M2-203 2+16" data-tokens="M2-203 2+16">M2-203 2+16</option>
                                <option value="M2-203 2+16 GRAB" data-tokens="M2-203 2+16 GRAB">M2-203 2+16 GRAB
                                </option>
                                <option value="M2-203 2+16 TRAVELOKA" data-tokens="M2-203 2+16 TRAVELOKA">M2-203
                                    2+16 TRAVELOKA</option>
                                <option value="M2-MAX 2+16" data-tokens="M2-MAX 2+16">M2-MAX 2+16</option>
                                <option value="M2-MAX 2+16 NFC" data-tokens="M2-MAX 2+16 NFC">M2-MAX 2+16 NFC
                                </option>
                                <option value="M2-MAX 4+16" data-tokens="M2-MAX 4+16">M2-MAX 4+16</option>
                                <option value="M2-MAX BASE" data-tokens="M2-MAX BASE">M2-MAX BASE</option>
                                <option value="M2-Pro 2+16" data-tokens="M2-Pro 2+16">M2-Pro 2+16</option>
                                <option value="R1-201" data-tokens="R1-201">R1-201</option>
                                <option value="R1-202" data-tokens="R1-202">R1-202</option>
                                <option value="S1 Rotating Bracket" data-tokens="S1 Rotating Bracket">S1 Rotating
                                    Bracket</option>
                                <option value="S1 WALL MOUNT" data-tokens="S1 WALL MOUNT">S1 WALL MOUNT</option>
                                <option value="S1-701 2+16" data-tokens="S1-701 2+16">S1-701 2+16</option>
                                <option value="S1-701 4+64" data-tokens="S1-701 4+64">S1-701 4+64</option>
                                <option value="X1-201" data-tokens="X1-201">X1-201</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="noinvoice"><b>No Invoice</b></label>
                            <input type="text" class="form-control" id="noinvoice" name="noinvoice"
                                placeholder="Masukan No Invoice" value="{{ old('noinvoice') }}">
                        </div>
                        <div class="form-group">
                            <label for="tanggalmasuk"><b>Tanggal Masuk</b></label>
                            <input type="date" class="form-control" id="tanggalmasuk" name="tanggalmasuk"
                                placeholder="Masukan Tanggal Masuk" value="{{ old('tanggalmasuk') }}">
                        </div>
                        <div class="form-group">
                            <label for="tanggalkeluar"><b>Tanggal Keluar</b></label>
                            <input type="date" class="form-control" id="tanggalkeluar" name="tanggalkeluar"
                                placeholder="Masukan Tanggal Keluar" value="{{ old('tanggalkeluar') }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="pelanggan"><b>Pelanggan</b></label>
                            <input type="text" class="form-control" id="pelanggan" name="pelanggan"
                                placeholder="Masukan Pelanggan" value="{{ old('pelanggan') }}">
                        </div>
                        <div class="form-group">
                            <label for="status"><b>Status</b></label><br />
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

    <!-- Edit Data Stock -->
    @foreach ($stock as $item)
        <div class="modal fade" id="stockEditModal{{ $item->id }}"
            aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="{{ route('stock.update', $item->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Edit Data Stocks</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="serialnumber" class="form-label"><b>Serial Number</b></label>
                                <input type="text" class="form-control" id="serialnumber" name="serialnumber"
                                    value="{{ $item->serialnumber }}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="tipe"><b>Tipe Device</b></label><br />
                                <select id="tipe" class="form-control form-control-chosen" name="tipe" required>
                                    <option value="Null">Pilih Tipe Device</option>
                                    <option value="A4-101" data-tokens="A4-101"
                                        {{ $item->tipe == 'A4-101' ? 'selected' : '' }}>
                                        A4-101</option>
                                    <option value="A4-102" data-tokens="A4-102"
                                        {{ $item->tipe == 'A4-102' ? 'selected' : '' }}>
                                        A4-102</option>
                                    <option value="A4-103" data-tokens="A4-103"
                                        {{ $item->tipe == 'A4-103' ? 'selected' : '' }}>
                                        A4-103</option>
                                    <option value="A4-104" data-tokens="A4-104"
                                        {{ $item->tipe == 'A4-104' ? 'selected' : '' }}>
                                        A4-104</option>
                                    <option value="A4-105" data-tokens="A4-105"
                                        {{ $item->tipe == 'A4-105' ? 'selected' : '' }}>
                                        A4-105</option>
                                    <option value="A4-107" data-tokens="A4-107"
                                        {{ $item->tipe == 'A4-107' ? 'selected' : '' }}>
                                        A4-107</option>
                                    <option value="D1 2+16" data-tokens="D1 2+16"
                                        {{ $item->tipe == 'D1 2+16' ? 'selected' : '' }}>
                                        D1 2+16</option>
                                    <option value="D1 2+16 MOKA" data-tokens="D1 2+16 MOKA"
                                        {{ $item->tipe == 'D1 2+16 MOKA' ? 'selected' : '' }}>
                                        D1 2+16 MOKA</option>
                                    <option value="D1-Pro 4+16 NFC" data-tokens="D1-Pro 4+16 NFC"
                                        {{ $item->tipe == 'D1-Pro 4+16 NFC' ? 'selected' : '' }}>
                                        D1-Pro 4+16 NFC</option>
                                    <option value="D1-Pro 8+128 NFC" data-tokens="D1-Pro 8+128 NFC"
                                        {{ $item->tipe == 'D1-Pro 8+128 NFC' ? 'selected' : '' }}>
                                        D1-Pro 8+128 NFC</option>
                                    <option value="D1W-702" data-tokens="D1W-702"
                                        {{ $item->tipe == 'D1W-702' ? 'selected' : '' }}>
                                        D1W-702</option>
                                    <option value="D1W-702 4+16" data-tokens="D1W-702 4+16"
                                        {{ $item->tipe == 'D1W-702 4+16' ? 'selected' : '' }}>
                                        D1W-702 4+16</option>
                                    <option value="D2 Pro 1+8" data-tokens="D2 Pro 1+8"
                                        {{ $item->tipe == 'D2 Pro 1+8' ? 'selected' : '' }}>
                                        D2 Pro 1+8</option>
                                    <option value="D2 Pro 2+16" data-tokens="D2 Pro 2+16"
                                        {{ $item->tipe == 'D2 Pro 2+16' ? 'selected' : '' }}>
                                        D2 Pro 2+16</option>
                                    <option value="D2-401" data-tokens="D2-401"
                                        {{ $item->tipe == 'D2-401' ? 'selected' : '' }}>
                                        D2-401</option>
                                    <option value="D2-402" data-tokens="D2-402"
                                        {{ $item->tipe == 'D2-402' ? 'selected' : '' }}>
                                        D2-402</option>
                                    <option value="D2-402 2+16" data-tokens="D2-402 2+16"
                                        {{ $item->tipe == 'D2-402 2+16' ? 'selected' : '' }}>
                                        D2-402 2+16</option>
                                    <option value="D3 DS1 2+16" data-tokens="D3 DS1 2+16"
                                        {{ $item->tipe == 'D3 DS1 2+16' ? 'selected' : '' }}>
                                        D3 DS1 2+16</option>
                                    <option value="D3 DS1 2+16 DP" data-tokens="D3 DS1 2+16 DP"
                                        {{ $item->tipe == 'D3 DS1 2+16 DP' ? 'selected' : '' }}>
                                        D3 DS1 2+16 DP</option>
                                    <option value="D3 DS1 2+16 TS" data-tokens="D3 DS1 2+16 TS"
                                        {{ $item->tipe == 'D3 DS1 2+16 TS' ? 'selected' : '' }}>
                                        D3 DS1 2+16 TS</option>
                                    <option value="D3 DS1 4+32" data-tokens="D3 DS1 4+32"
                                        {{ $item->tipe == 'D3 DS1 4+32' ? 'selected' : '' }}>
                                        D3 DS1 4+32</option>
                                    <option value="D3 DS1 4+32 (iSeller)" data-tokens="D3 DS1 4+32 (iSeller)"
                                        {{ $item->tipe == 'D3 DS1 4+32 (iSeller)' ? 'selected' : '' }}>
                                        D3 DS1 4+32 (iSeller)</option>
                                    <option value="D3 DS1 4+32 DP" data-tokens="D3 DS1 4+32 DP"
                                        {{ $item->tipe == 'D3 DS1 4+32 DP' ? 'selected' : '' }}>
                                        D3 DS1 4+32 DP</option>
                                    <option value="D3 DS1 4+32 TS" data-tokens="D3 DS1 4+32 TS"
                                        {{ $item->tipe == 'D3 DS1 4+32 TS' ? 'selected' : '' }}>
                                        D3 DS1 4+32 TS</option>
                                    <option value="D3 DS1 Extention Display" data-tokens="D3 DS1 Extention Display"
                                        {{ $item->tipe == 'D3 DS1 Extention Display' ? 'selected' : '' }}>
                                        D3 DS1 Extention Display</option>
                                    <option value="D3 DS1 EXTENTION DISPLAY (DP)"
                                        data-tokens="D3 DS1 EXTENTION DISPLAY (DP)"
                                        {{ $item->tipe == 'D3 DS1 EXTENTION DISPLAY (DP)' ? 'selected' : '' }}>
                                        D3 DS1 EXTENTION DISPLAY (DP)</option>
                                    <option value="D3 DS1 EXTENTION DISPLAY (DP) TS"
                                        data-tokens="D3 DS1 EXTENTION DISPLAY (DP) TS"
                                        {{ $item->tipe == 'D3 DS1 EXTENTION DISPLAY (DP) TS' ? 'selected' : '' }}>
                                        D3 DS1 EXTENTION DISPLAY (DP) TS</option>
                                    <option value="D3 DS1 EXTENTION DISPLAY (HDMI)"
                                        data-tokens="D3 DS1 EXTENTION DISPLAY (HDMI)"
                                        {{ $item->tipe == 'D3 DS1 EXTENTION DISPLAY (HDMI)' ? 'selected' : '' }}>
                                        D3 DS1 EXTENTION DISPLAY (HDMI)</option>
                                    <option value="D3 DS1 EXTENTION DISPLAY (iseller)"
                                        data-tokens="D3 DS1 EXTENTION DISPLAY (iseller)"
                                        {{ $item->tipe == 'D3 DS1 EXTENTION DISPLAY (iseller)' ? 'selected' : '' }}>
                                        D3 DS1 EXTENTION DISPLAY (iseller)</option>
                                    <option value="D3 DS1 Extention Display TS" data-tokens="D3 DS1 Extention Display TS"
                                        {{ $item->tipe == 'D3 DS1 Extention Display TS' ? 'selected' : '' }}>
                                        D3 DS1 Extention Display TS</option>
                                    <option value="D3 DS1 PRO 8+128" data-tokens="D3 DS1 PRO 8+128"
                                        {{ $item->tipe == 'D3 DS1 PRO 8+128' ? 'selected' : '' }}>
                                        D3 DS1 PRO 8+128</option>
                                    <option value="D3 DS1 STAND" data-tokens="D3 DS1 STAND"
                                        {{ $item->tipe == 'D3 DS1 STAND' ? 'selected' : '' }}>
                                        D3 DS1 STAND</option>
                                    <option value="D3 DS1 STAND (1 M CABLE) / HDMI"
                                        data-tokens="D3 DS1 STAND (1 M CABLE) / HDMI"
                                        {{ $item->tipe == 'D3 DS1 STAND (1 M CABLE) / HDMI' ? 'selected' : '' }}>
                                        D3 DS1 STAND (1 M CABLE) / HDMI</option>
                                    <option value="D3 DS1 STAND (1 M CABLE)/DP" data-tokens="D3 DS1 STAND (1 M CABLE)/DP"
                                        {{ $item->tipe == 'D3 DS1 STAND (1 M CABLE)/DP' ? 'selected' : '' }}>
                                        D3 DS1 STAND (1 M CABLE)/DP</option>
                                    <option value="D3 DS1 STAND 50 CM" data-tokens="D3 DS1 STAND 50 CM"
                                        {{ $item->tipe == 'D3 DS1 STAND 50 CM' ? 'selected' : '' }}>
                                        D3 DS1 STAND 50 CM</option>
                                    <option value="D3 DS1K 2+16" data-tokens="D3 DS1K 2+16"
                                        {{ $item->tipe == 'D3 DS1K 2+16' ? 'selected' : '' }}>
                                        D3 DS1K 2+16</option>
                                    <option value="D3-501 2+16" data-tokens="D3-501 2+16"
                                        {{ $item->tipe == 'D3-501 2+16' ? 'selected' : '' }}>
                                        D3-501 2+16</option>
                                    <option value="D3-501 4+16 MOKA ULTRA" data-tokens="D3-501 4+16 MOKA ULTRA"
                                        {{ $item->tipe == 'D3-501 4+16 MOKA ULTRA' ? 'selected' : '' }}>
                                        D3-501 4+16 MOKA ULTRA</option>
                                    <option value="D3-503 2+16" data-tokens="D3-503 2+16"
                                        {{ $item->tipe == 'D3-503 2+16' ? 'selected' : '' }}>
                                        D3-503 2+16</option>
                                    <option value="D3-503 4+16 MOKA ULTRA" data-tokens="D3-503 4+16 MOKA ULTRA"
                                        {{ $item->tipe == 'D3-503 4+16 MOKA ULTRA' ? 'selected' : '' }}>
                                        D3-503 4+16 MOKA ULTRA</option>
                                    <option value="D3-504 1+8" data-tokens="D3-504 1+8"
                                        {{ $item->tipe == 'D3-504 1+8' ? 'selected' : '' }}>
                                        D3-504 1+8</option>
                                    <option value="D3-504 2+16" data-tokens="D3-504 2+16"
                                        {{ $item->tipe == 'D3-504 2+16' ? 'selected' : '' }}>
                                        D3-504 2+16</option>
                                    <option value="D3-504 4+16" data-tokens="D3-504 4+16"
                                        {{ $item->tipe == 'D3-504 4+16' ? 'selected' : '' }}>
                                        D3-504 4+16</option>
                                    <option value="D3-505 2+16" data-tokens="D3-505 2+16"
                                        {{ $item->tipe == 'D3-505 2+16' ? 'selected' : '' }}>
                                        D3-505 2+16</option>
                                    <option value="D3-505 2+8" data-tokens="D3-505 2+8"
                                        {{ $item->tipe == 'D3-505 2+8' ? 'selected' : '' }}>
                                        D3-505 2+8</option>
                                    <option value="D3-505 4+16" data-tokens="D3-505 4+16"
                                        {{ $item->tipe == 'D3-505 4+16' ? 'selected' : '' }}>
                                        D3-505 4+16</option>
                                    <option value="D3-505 4+64" data-tokens="D3-505 4+64"
                                        {{ $item->tipe == 'D3-505 4+64' ? 'selected' : '' }}>
                                        D3-505 4+64</option>
                                    <option value="D3-506 2+16" data-tokens="D3-506 2+16"
                                        {{ $item->tipe == 'D3-506 2+16' ? 'selected' : '' }}>
                                        D3-506 2+16</option>
                                    <option value="D3-506 4+16" data-tokens="D3-506 4+16"
                                        {{ $item->tipe == 'D3-506 4+16' ? 'selected' : '' }}>
                                        D3-506 4+16</option>
                                    <option value="D4-501" data-tokens="D4-501"
                                        {{ $item->tipe == 'D4-501' ? 'selected' : '' }}>
                                        D4-501</option>
                                    <option value="D4-502" data-tokens="D4-502"
                                        {{ $item->tipe == 'D4-502' ? 'selected' : '' }}>
                                        D4-502</option>
                                    <option value="D4-503 2+16" data-tokens="D4-503 2+16"
                                        {{ $item->tipe == 'D4-503 2+16' ? 'selected' : '' }}>
                                        D4-503 2+16</option>
                                    <option value="D4-503 2+16 WHITE" data-tokens="D4-503 2+16 WHITE"
                                        {{ $item->tipe == 'D4-503 2+16 WHITE' ? 'selected' : '' }}>
                                        D4-503 2+16 WHITE</option>
                                    <option value="D4-503 4+16" data-tokens="D4-503 4+16"
                                        {{ $item->tipe == 'D4-503 4+16' ? 'selected' : '' }}>
                                        D4-503 4+16</option>
                                    <option value="D4-503 4+16 1D" data-tokens="D4-503 4+16 1D"
                                        {{ $item->tipe == 'D4-503 4+16 1D' ? 'selected' : '' }}>
                                        D4-503 4+16 1D</option>
                                    <option value="D4-504 2+16" data-tokens="D4-504 2+16"
                                        {{ $item->tipe == 'D4-504 2+16' ? 'selected' : '' }}>
                                        D4-504 2+16</option>
                                    <option value="D4-504 2+16 WHITE" data-tokens="D4-504 2+16 WHITE"
                                        {{ $item->tipe == 'D4-504 2+16 WHITE' ? 'selected' : '' }}>
                                        D4-504 2+16 WHITE</option>
                                    <option value="D4-504 4+16" data-tokens="D4-504 4+16"
                                        {{ $item->tipe == 'D4-504 4+16' ? 'selected' : '' }}>
                                        D4-504 4+16</option>
                                    <option value="D4-504 4+64 Pro" data-tokens="D4-504 4+64 Pro"
                                        {{ $item->tipe == 'D4-504 4+64 Pro' ? 'selected' : '' }}>
                                        D4-504 4+64 Pro</option>
                                    <option value="D4-505 2+16" data-tokens="D4-505 2+16"
                                        {{ $item->tipe == 'D4-505 2+16' ? 'selected' : '' }}>
                                        D4-505 2+16</option>
                                    <option value="D4-505 4+16" data-tokens="D4-505 4+16"
                                        {{ $item->tipe == 'D4-505 4+16' ? 'selected' : '' }}>
                                        D4-505 4+16</option>
                                    <option value="D4-505 4+16 DT" data-tokens="D4-505 4+16 DT"
                                        {{ $item->tipe == 'D4-505 4+16 DT' ? 'selected' : '' }}>
                                        D4-505 4+16 DT</option>
                                    <option value="D4-505 4+32" data-tokens="D4-505 4+32"
                                        {{ $item->tipe == 'D4-505 4+32' ? 'selected' : '' }}>
                                        D4-505 4+32</option>
                                    <option value="D4-505 4+64" data-tokens="D4-505 4+64"
                                        {{ $item->tipe == 'D4-505 4+64' ? 'selected' : '' }}>
                                        D4-505 4+64</option>
                                    <option value="D4-505 4+64 DT" data-tokens="D4-505 4+64 DT"
                                        {{ $item->tipe == 'D4-505 4+64 DT' ? 'selected' : '' }}>
                                        D4-505 4+64 DT</option>
                                    <option value="D4-505 8+128 DT" data-tokens="D4-505 8+128 DT"
                                        {{ $item->tipe == 'D4-505 8+128 DT' ? 'selected' : '' }}>
                                        D4-505 8+128 DT</option>
                                    <option value="D4-505 PRO" data-tokens="D4-505 PRO"
                                        {{ $item->tipe == 'D4-505 PRO' ? 'selected' : '' }}>
                                        D4-505 PRO</option>
                                    <option value="D4-505 PRO 8+128" data-tokens="D4-505 PRO 8+128"
                                        {{ $item->tipe == 'D4-505 PRO 8+128' ? 'selected' : '' }}>
                                        D4-505 PRO 8+128</option>
                                    <option value="D4-Falcon 1 2+16" data-tokens="D4-Falcon 1 2+16"
                                        {{ $item->tipe == 'D4-Falcon 1 2+16' ? 'selected' : '' }}>
                                        D4-Falcon 1 2+16</option>
                                    <option value="D4-Falcon 1 4+32 NFC" data-tokens="D4-Falcon 1 4+32 NFC"
                                        {{ $item->tipe == 'D4-Falcon 1 4+32 NFC' ? 'selected' : '' }}>
                                        D4-Falcon 1 4+32 NFC</option>
                                    <option value="K1-101" data-tokens="K1-101"
                                        {{ $item->tipe == 'K1-101' ? 'selected' : '' }}>
                                        K1-101</option>
                                    <option value="K1-101 4+16" data-tokens="K1-101 4+16"
                                        {{ $item->tipe == 'K1-101 4+16' ? 'selected' : '' }}>
                                        K1-101 4+16</option>
                                    <option value="K1-101 4+32" data-tokens="K1-101 4+32"
                                        {{ $item->tipe == 'K1-101 4+32' ? 'selected' : '' }}>
                                        K1-101 4+32</option>
                                    <option value="K2-201 2+16" data-tokens="K2-201 2+16"
                                        {{ $item->tipe == 'K2-201 2+16' ? 'selected' : '' }}>
                                        K2-201 2+16</option>
                                    <option value="M2 SWIFT 1 2+16" data-tokens="M2 SWIFT 1 2+16"
                                        {{ $item->tipe == 'M2 SWIFT 1 2+16' ? 'selected' : '' }}>
                                        M2 SWIFT 1 2+16</option>
                                    <option value="M2 Swift 1 2+16 NFC" data-tokens="M2 Swift 1 2+16 NFC"
                                        {{ $item->tipe == 'M2 Swift 1 2+16 NFC' ? 'selected' : '' }}>
                                        M2 Swift 1 2+16 NFC</option>
                                    <option value="M2 Swift 1 4+32 NFC" data-tokens="M2 Swift 1 4+32 NFC"
                                        {{ $item->tipe == 'M2 Swift 1 4+32 NFC' ? 'selected' : '' }}>
                                        M2 Swift 1 4+32 NFC</option>
                                    <option value="M2 SWIFT 1 PRINTER" data-tokens="M2 SWIFT 1 PRINTER"
                                        {{ $item->tipe == 'M2 SWIFT 1 PRINTER' ? 'selected' : '' }}>
                                        M2 SWIFT 1 PRINTER</option>
                                    <option value="M2 SWIFT 1 SCANNER" data-tokens="M2 SWIFT 1 SCANNER"
                                        {{ $item->tipe == 'M2 SWIFT 1 SCANNER' ? 'selected' : '' }}>
                                        M2 SWIFT 1 SCANNER</option>
                                    <option value="M2 SWIFT 1 STRAP" data-tokens="M2 SWIFT 1 STRAP"
                                        {{ $item->tipe == 'M2 SWIFT 1 STRAP' ? 'selected' : '' }}>
                                        M2 SWIFT 1 STRAP</option>
                                    <option value="M2 Swift 1p 2+16 NFC" data-tokens="M2 Swift 1p 2+16 NFC"
                                        {{ $item->tipe == 'M2 Swift 1p 2+16 NFC' ? 'selected' : '' }}>
                                        M2 Swift 1p 2+16 NFC</option>
                                    <option value="M2 Swift 1P 4+32 NFC" data-tokens="M2 Swift 1P 4+32 NFC"
                                        {{ $item->tipe == 'M2 Swift 1P 4+32 NFC' ? 'selected' : '' }}>
                                        M2 Swift 1P 4+32 NFC</option>
                                    <option value="M2 Swift 1s 2+16 NFC" data-tokens="M2 Swift 1s 2+16 NFC"
                                        {{ $item->tipe == 'M2 Swift 1s 2+16 NFC' ? 'selected' : '' }}>
                                        M2 Swift 1s 2+16 NFC</option>
                                    <option value="M2 Swift 1s 4+32 NFC" data-tokens="M2 Swift 1s 4+32 NFC"
                                        {{ $item->tipe == 'M2 Swift 1s 4+32 NFC' ? 'selected' : '' }}>
                                        M2 Swift 1s 4+32 NFC</option>
                                    <option value="M2-201" data-tokens="M2-201"
                                        {{ $item->tipe == 'M2-201' ? 'selected' : '' }}>
                                        M2-201</option>
                                    <option value="M2-202 1+8" data-tokens="M2-202 1+8"
                                        {{ $item->tipe == 'M2-202 1+8' ? 'selected' : '' }}>
                                        M2-202 1+8</option>
                                    <option value="M2-202 1+8 iSeller" data-tokens="M2-202 1+8 iSeller"
                                        {{ $item->tipe == 'M2-202 1+8 iSeller' ? 'selected' : '' }}>
                                        M2-202 1+8 iSeller</option>
                                    <option value="M2-202 2+16" data-tokens="M2-202 2+16"
                                        {{ $item->tipe == 'M2-202 2+16' ? 'selected' : '' }}>
                                        M2-202 2+16</option>
                                    <option value="M2-202 2+16 OLSERA" data-tokens="M2-202 2+16 OLSERA"
                                        {{ $item->tipe == 'M2-202 2+16 OLSERA' ? 'selected' : '' }}>
                                        M2-202 2+16 OLSERA</option>
                                    <option value="M2-203 (Full)" data-tokens="M2-203 (Full)"
                                        {{ $item->tipe == 'M2-203 (Full)' ? 'selected' : '' }}>
                                        M2-203 (Full)</option>
                                    <option value="M2-203 1+8" data-tokens="M2-203 1+8"
                                        {{ $item->tipe == 'M2-203 1+8' ? 'selected' : '' }}>
                                        M2-203 1+8</option>
                                    <option value="M2-203 1+8 iSeller" data-tokens="M2-203 1+8 iSeller"
                                        {{ $item->tipe == 'M2-203 1+8 iSeller' ? 'selected' : '' }}>
                                        M2-203 1+8 iSeller</option>
                                    <option value="M2-203 1+8 NFC ISELLER" data-tokens="M2-203 1+8 NFC ISELLER"
                                        {{ $item->tipe == 'M2-203 1+8 NFC ISELLER' ? 'selected' : '' }}>
                                        M2-203 1+8 NFC ISELLER</option>
                                    <option value="M2-203 1+8 WHITE" data-tokens="M2-203 1+8 WHITE"
                                        {{ $item->tipe == 'M2-203 1+8 WHITE' ? 'selected' : '' }}>
                                        M2-203 1+8 WHITE</option>
                                    <option value="M2-203 2+16" data-tokens="M2-203 2+16"
                                        {{ $item->tipe == 'M2-203 2+16' ? 'selected' : '' }}>
                                        M2-203 2+16</option>
                                    <option value="M2-203 2+16 GRAB" data-tokens="M2-203 2+16 GRAB"
                                        {{ $item->tipe == 'M2-203 2+16 GRAB' ? 'selected' : '' }}>
                                        M2-203 2+16 GRAB</option>
                                    <option value="M2-203 2+16 TRAVELOKA" data-tokens="M2-203 2+16 TRAVELOKA"
                                        {{ $item->tipe == 'M2-203 2+16 TRAVELOKA' ? 'selected' : '' }}>
                                        M2-203 2+16 TRAVELOKA</option>
                                    <option value="M2-MAX 2+16" data-tokens="M2-MAX 2+16"
                                        {{ $item->tipe == 'M2-MAX 2+16' ? 'selected' : '' }}>
                                        M2-MAX 2+16</option>
                                    <option value="M2-MAX 2+16 NFC" data-tokens="M2-MAX 2+16 NFC"
                                        {{ $item->tipe == 'M2-MAX 2+16 NFC' ? 'selected' : '' }}>
                                        M2-MAX 2+16 NFC</option>
                                    <option value="M2-MAX 4+16" data-tokens="M2-MAX 4+16"
                                        {{ $item->tipe == 'M2-MAX 4+16' ? 'selected' : '' }}>
                                        M2-MAX 4+16</option>
                                    <option value="M2-MAX BASE" data-tokens="M2-MAX BASE"
                                        {{ $item->tipe == 'M2-MAX BASE' ? 'selected' : '' }}>
                                        M2-MAX BASE</option>
                                    <option value="M2-Pro 2+16" data-tokens="M2-Pro 2+16"
                                        {{ $item->tipe == 'M2-Pro 2+16' ? 'selected' : '' }}>
                                        M2-Pro 2+16</option>
                                    <option value="R1-201" data-tokens="R1-201"
                                        {{ $item->tipe == 'R1-201' ? 'selected' : '' }}>
                                        R1-201</option>
                                    <option value="R1-202" data-tokens="R1-202"
                                        {{ $item->tipe == 'R1-202' ? 'selected' : '' }}>
                                        R1-202</option>
                                    <option value="S1 Rotating Bracket" data-tokens="S1 Rotating Bracket"
                                        {{ $item->tipe == 'S1 Rotating Bracket' ? 'selected' : '' }}>
                                        S1 Rotating Bracket</option>
                                    <option value="S1 WALL MOUNT" data-tokens="S1 WALL MOUNT"
                                        {{ $item->tipe == 'S1 WALL MOUNT' ? 'selected' : '' }}>
                                        S1 WALL MOUNT</option>
                                    <option value="S1-701 2+16" data-tokens="S1-701 2+16"
                                        {{ $item->tipe == 'S1-701 2+16' ? 'selected' : '' }}>
                                        S1-701 2+16</option>
                                    <option value="S1-701 4+64" data-tokens="S1-701 4+64"
                                        {{ $item->tipe == 'S1-701 4+64' ? 'selected' : '' }}>
                                        S1-701 4+64</option>
                                    <option value="X1-201" data-tokens="X1-201"
                                        {{ $item->tipe == 'X1-201' ? 'selected' : '' }}>
                                        X1-201</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="noinvoice" class="form-label"><b>No Invoice</b></label>
                                <input type="text" class="form-control" id="noinvoice" name="noinvoice"
                                    value="{{ $item->noinvoice }}">
                            </div>
                            <div class="mb-3">
                                <label for="tanggalmasuk" class="form-label"><b>Tanggal Masuk</b></label>
                                <input type="date" class="form-control" id="tanggalmasuk" name="tanggalmasuk"
                                    value="{{ $item->tanggalmasuk }}">
                            </div>
                            <div class="mb-3">
                                <label for="tanggalkeluar" class="form-label"><b>Tanggal Keluar</b></label>
                                <input type="date" class="form-control" id="tanggalkeluar" name="tanggalkeluar"
                                    value="{{ $item->tanggalkeluar }}">
                            </div>
                            <div class="mb-3">
                                <label for="pelanggan" class="form-label"><b>Pelanggan</b></label>
                                <input type="text" class="form-control" id="pelanggan" name="pelanggan"
                                    value="{{ $item->pelanggan }}">
                            </div>
                            <div class="form-group">
                                <label><b>Status</b></label><br />
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input mt-1" type="radio" id="gudang" name="status"
                                        value="Gudang"
                                        {{ in_array('Gudang', explode(',', $item->status)) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="gudang">Gudang</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input mt-1" type="radio" id="service" name="status"
                                        value="Service"
                                        {{ in_array('Service', explode(',', $item->status)) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="service">Service</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input mt-1" type="radio" id="dipinjam" name="status"
                                        value="Dipinjam"
                                        {{ in_array('Dipinjam', explode(',', $item->status)) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="dipinjam">Dipinjam</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input mt-1" type="radio" id="terjual" name="status"
                                        value="Terjual"
                                        {{ in_array('Terjual', explode(',', $item->status)) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="terjual">Terjual</label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
    <!-- end edit data -->

    <!-- delete data -->
    @foreach ($stock as $item)
        <div class="modal fade" id="deleteModal{{ $item->id }}"
            aria-labelledby="deleteModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel{{ $item->id }}">Delete Data Stocks</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this Data?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <form action="{{ route('stock.destroy', $item->id) }}" method="POST">
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
            <table id="hometable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <th>Serial Number</th>
                    <th>Tipe</th>
                    <th>No Invoice</th>
                    <th>Tanggal Masuk</th>
                    <th>Tanggal Keluar</th>
                    <th>Pelanggan</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @foreach ($stock as $item)
                        <tr>
                            <td>{{ $item->serialnumber }}</td>
                            <td>{{ $item->tipe }}</td>
                            <td>{{ $item->noinvoice }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggalmasuk)->format('d/m/Y') }}</td>
                            <td>{{ $item->tanggalkeluar }}</td>
                            <td>{{ $item->pelanggan }}</td>
                            <td>
                                <a href="#" class="btn btn-primary btn-sm" data-toggle="modal"
                                    data-target="#stockEditModal{{ $item->id }}" data-toggle="tooltip"
                                    data-placement="top" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>

                                <a href="#" class="btn btn-danger btn-sm" data-toggle="modal"
                                    data-target="#deleteModal{{ $item->id }}" data-toggle="tooltip"
                                    data-placement="top" title="Delete"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Serial Number</th>
                        <th>Tipe</th>
                        <th>No Invoice</th>
                        <th>Tanggal Masuk</th>
                        <th>Tanggal Keluar</th>
                        <th>Pelanggan</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('js/stockMonitor/searchDevice.js') }}"></script>
    <script src="{{ asset('js/stockMonitor/importViewStocks.js') }}"></script>
@endpush
