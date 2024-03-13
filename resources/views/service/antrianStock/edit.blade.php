@extends('layouts.app')
@extends('layouts.navbar')

@section('content')
    <div class="container w-50 p-3">
        <div class="row addDataForms">
            <div class="d-flex justify-content-between mb-2">
                <h1 class="h3 mb-3 text-gray-800">Edit Data Service Antrian Stock</h1>
                <div class="d-flex align-items-center gap-3">
                    <a href="/service/antrianStock" class="btn btn-danger btn-sm font-weight-bold text-white">
                        Back
                    </a>
                </div>
            </div>
            <hr style="width: -webkit-fill-available;">
            <form method="POST" action="{{ route('service.update', $service->id) }}" enctype="multipart/form-data">
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
                            value="{{ old('pemakaian', $service->pemakaian) }}" required>
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
                        <label for="tanggalmasuk" class="form-label font-weight-bold">Tanggal Masuk</label>
                        <input type="date" class="form-control shadow-none" id="tanggalmasuk" name="tanggalmasuk"
                            value="{{ $service->tanggalmasuk }}">
                    </div>
                    <div class="mb-3">
                        <label for="catatan" class="form-label font-weight-bold">Catatan</label>
                        <textarea class="form-control shadow-none" id="catatan" name="catatan" rows="3" placeholder="Masukan Catatan">{{ $service->catatan }}</textarea>
                    </div>
                    <div class="form-group" hidden>
                        <label class="font-weight-bold">Status</label><br />
                        <div class="form-check form-check-inline">
                            <input class="form-check-input mt-1" type="radio" id="antrian" name="status"
                                value="antrian" {{ in_array('antrian', explode(',', $service->status)) ? 'checked' : '' }}>
                            <label class="form-check-label" for="antrian">Antrian</label>
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
