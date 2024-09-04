@extends('layouts.app')
@extends('layouts.navbar')

@section('content')
    <div class="container w-50 p-3">
        <div class="row addDataForms">
            <div class="d-flex justify-content-between mb-2">
                <h1 class="h3 mb-3 text-gray-800">Edit Data Service Validasi Pelanggan</h1>
                <div class="d-flex align-items-center gap-3">
                    <a href="/service/validasiPelanggan" class="btn btn-danger btn-sm font-weight-bold text-white">
                        Back
                    </a>
                </div>
            </div>
            <hr style="width: -webkit-fill-available;">
            <form method="POST" action="{{ route('service.updateValidasiPelanggan', $service->id) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Pemilik</label><br />
                        <div class="form-check form-check-inline">
                            <input class="form-check-input mt-1" type="radio" id="stock" name="pemilik" value="stock"
                                {{ in_array('stock', explode(',', $service->pemilik)) ? 'checked' : '' }}>
                            <label class="form-check-label" for="stock">Stock</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input mt-1" type="radio" id="customer" name="pemilik"
                                value="customer"
                                {{ in_array('customer', explode(',', $service->pemilik)) ? 'checked' : '' }}>
                            <label class="form-check-label" for="customer">Customer</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="pelanggan" class="form-label font-weight-bold">Pelanggan</label>
                        <input type="text" class="form-control shadow-none" id="pelanggan" name="pelanggan"
                            value="{{ $service->pelanggan }}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="device"><b>Tipe Device</b></label>
                        <select class="form-select form-control-chosen" name="device" id="device" required>
                            <option value="Null">Pilih Tipe Device</option>
                            @foreach ($serviceDevice as $device)
                                <option value="{{ $device->name }}"
                                    {{ $service->device == $device->name ? 'selected' : '' }}>
                                    {{ $device->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="serialnumber" class="form-label font-weight-bold">Serial Number</label>
                        <input type="text" class="form-control shadow-none" id="serialnumber" name="serialnumber"
                            value="{{ $service->serialnumber }}">
                    </div>
                    <div class="form-group mb-3">
                        <label class="font-weight-bold" for="pemakaian">Pemakaian</label>
                        <select class="form-select shadow-none" id="pemakaian" name="pemakaian"
                            value="{{ old('pemakaian') }}" required>
                            <option value="Null">Pilih Lama Pemakaian</option>
                            <option
                                value="Baru Di Unboxing"{{ $service->pemakaian == 'Baru Di Unboxing' ? 'selected' : '' }}>
                                Baru Di Unboxing
                            </option>
                            <option value="7 Hari Kurang"{{ $service->pemakaian == '7 Hari Kurang' ? 'selected' : '' }}>
                                7 Hari Kurang
                            </option>
                            <option value="1 Tahun Kurang"{{ $service->pemakaian == '1 Tahun Kurang' ? 'selected' : '' }}>
                                1 Tahun Kurang
                            </option>
                            <option value="1 Tahun Lebih"{{ $service->pemakaian == '1 Tahun Lebih' ? 'selected' : '' }}>
                                1 Tahun Lebih
                            </option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="kerusakan" class="form-label font-weight-bold">Kerusakan</label>
                        <textarea class="form-control shadow-none" id="kerusakan" name="kerusakan" rows="3"
                            placeholder="Masukan Kerusakan">{{ $service->kerusakan }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="perbaikan" class="form-label font-weight-bold">Perbaikan</label>
                        <textarea class="form-control shadow-none" id="perbaikan" name="perbaikan" rows="3"
                            placeholder="Masukan perbaikan">{{ $service->perbaikan }}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold" for="teknisi">Teknisi</label>
                        <select class="form-select shadow-none" id="teknisi" name="teknisi" value="{{ old('teknisi') }}"
                            required>
                            <option value="Null">Pilih Teknisi</option>
                            <option value="Ozi"{{ $service->teknisi == 'Ozi' ? 'selected' : '' }}>
                                Ozi
                            </option>
                            <option value="Alfian"{{ $service->teknisi == 'Alfian' ? 'selected' : '' }}>
                                Alfian
                            </option>
                            <option value="Andre"{{ $service->teknisi == 'Andre' ? 'selected' : '' }}>
                                Andre
                            </option>
                            <option value="Other"{{ $service->teknisi == 'Other' ? 'selected' : '' }}>
                                Other
                            </option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nosparepart" class="form-label font-weight-bold">No SparePart</label>
                        <input type="text" class="form-control shadow-none" id="nosparepart" name="nosparepart"
                            value="{{ $service->nosparepart }}">
                    </div>
                    <div class="mb-3">
                        <label for="snkanibal" class="form-label font-weight-bold">SN Kanibal</label>
                        <input type="text" class="form-control shadow-none" id="snkanibal" name="snkanibal"
                            value="{{ $service->snkanibal }}">
                    </div>
                    <div class="mb-3">
                        <label for="tanggalmasuk" class="form-label font-weight-bold">Tanggal Masuk</label>
                        <input type="date" class="form-control shadow-none" id="tanggalmasuk" name="tanggalmasuk"
                            value="{{ $service->tanggalmasuk }}">
                    </div>
                    <div class="mb-3">
                        <label for="tanggalkeluar" class="form-label font-weight-bold">Tanggal Selesai</label>
                        <input type="date" class="form-control shadow-none" id="tanggalkeluar" name="tanggalkeluar"
                            value="{{ $service->tanggalkeluar }}">
                    </div>
                    <div class="mb-3">
                        <label for="catatan" class="form-label font-weight-bold">Catatan</label>
                        <textarea class="form-control shadow-none" id="catatan" name="catatan" rows="3"
                            placeholder="Masukan Catatan">{{ $service->catatan }}</textarea>
                    </div>
                    <div class="form-group" hidden>
                        <label class="font-weight-bold">Status</label><br />
                        <div class="form-check form-check-inline">
                            <input class="form-check-input mt-1" type="radio" id="validasi" name="status"
                                value="validasi"
                                {{ in_array('validasi', explode(',', $service->status)) ? 'checked' : '' }} checked>
                            <label class="form-check-label" for="validasi">Validasi</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
@endsection
