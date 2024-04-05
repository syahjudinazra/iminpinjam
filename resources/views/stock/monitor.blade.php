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
                            <select id="tipe" class="form-control form-control-chosen shadow-none" name="tipe"
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
                                <option value="A01">A01</option>
                                <option value="A02">A02</option>
                                <option value="B01">B01</option>
                                <option value="B02">B02</option>
                                <option value="C01">C01</option>
                                <option value="C02">C02</option>
                                <option value="D01">D01</option>
                                <option value="D02">D02</option>
                                <option value="E01">E01</option>
                                <option value="E02">E02</option>
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
