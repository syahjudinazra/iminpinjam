@extends('layouts.app')
@extends('layouts.navbar')

@section('content')
    <div class="container w-50 p-3">
        <div class="row addDataForms">
            <div class="d-flex justify-content-between mb-2">
                <h1 class="h3 mb-3 text-gray-800">Edit Data Barang Dikembalikan</h1>
                <div class="d-flex align-items-center gap-3">
                    <a href="/pinjam/kembali" class="btn btn-danger btn-sm font-weight-bold text-white">
                        Back
                    </a>
                </div>
            </div>
            <hr style="width: -webkit-fill-available;">
            <form method="POST" action="{{ route('pinjam.update', $pinjam->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tanggal" class="form-label font-weight-bold">Tanggal</label>
                        <input type="date" class="form-control shadow-none" id="tanggal" name="tanggal"
                            value="{{ $pinjam->tanggal }}">
                    </div>
                    <div class="mb-3">
                        <label for="serialnumber" class="form-label font-weight-bold">Serial Number</label>
                        <input type="text" class="form-control shadow-none" id="serialnumber" name="serialnumber"
                            value="{{ $pinjam->serialnumber }}">
                    </div>
                    <div class="form-group mb-3">
                        <label class="font-weight-bold" for="device">Tipe Device</label>
                        <select class="form-select form-control-chosen shadow-none" name="device" id="device" required>
                            <option value="Null">Pilih Model</option>
                            @foreach ($pinjamsDevice as $device)
                                <option value="{{ $device->name }}"
                                    {{ $pinjam->device == $device->name ? 'selected' : '' }}>{{ $device->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold" for="ram">RAM/Storage</label>
                        <select class="form-control shadow-none" id="ram" name="ram" required>
                            <option value="Pilih RAM/Storage">Pilih RAM/Storage</option>
                            <option value="-" data-tokens="-" {{ $pinjam->ram == '-' ? 'selected' : '' }}>
                                -
                            </option>
                            <option value="1/8" data-tokens="1/8" {{ $pinjam->ram == '1/8' ? 'selected' : '' }}>
                                1/8
                            </option>
                            <option value="2/8" data-tokens="2/8" {{ $pinjam->ram == '2/8' ? 'selected' : '' }}>
                                2/8
                            </option>
                            <option value="2/16" data-tokens="2/16" {{ $pinjam->ram == '2/16' ? 'selected' : '' }}>
                                2/16
                            </option>
                            <option value="4/16" data-tokens="4/16" {{ $pinjam->ram == '4/16' ? 'selected' : '' }}>
                                4/16
                            </option>
                            <option value="4/32" data-tokens="4/32" {{ $pinjam->ram == '4/32' ? 'selected' : '' }}>
                                4/32
                            </option>
                            <option value="4/64" data-tokens="4/64" {{ $pinjam->ram == '4/64' ? 'selected' : '' }}>
                                4/64
                            </option>
                            <option value="8/128" data-tokens="8/128" {{ $pinjam->ram == '8/128' ? 'selected' : '' }}>
                                8/128
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold" for="android">Versi Android</label>
                        <select class="form-control shadow-none" id="android" name="android" required>
                            <option value="Pilih Android">Pilih Android</option>
                            <option value="-" data-tokens="-" {{ $pinjam->android == '-' ? 'selected' : '' }}>
                                -
                            </option>
                            <option value="Android 7" data-tokens="Android 7"
                                {{ $pinjam->android == 'Android 7' ? 'selected' : '' }}>
                                Android 7
                            </option>
                            <option value="Android 8" data-tokens="Android 8"
                                {{ $pinjam->android == 'Android 8' ? 'selected' : '' }}>
                                Android 8
                            </option>
                            <option value="Android 11" data-tokens="Android 11"
                                {{ $pinjam->android == 'Android 11' ? 'selected' : '' }}>
                                Android 11
                            </option>
                            <option value="Android 11 GMS" data-tokens="Android 11 GMS"
                                {{ $pinjam->android == 'Android 11 GMS' ? 'selected' : '' }}>
                                Android 11 GMS
                            </option>
                            <option value="Android 13" data-tokens="Android 13"
                                {{ $pinjam->android == 'Android 13' ? 'selected' : '' }}>
                                Android 13
                            </option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="customer" class="form-label font-weight-bold">Customer</label>
                        <input type="text" class="form-control shadow-none" id="customer" name="customer"
                            value="{{ $pinjam->customer }}">
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label font-weight-bold">Alamat</label>
                        <textarea class="form-control shadow-none" id="alamat" name="alamat" rows="3">{{ $pinjam->alamat }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="sales" class="form-label font-weight-bold">Sales</label>
                        <input type="text" class="form-control shadow-none" id="sales" name="sales"
                            value="{{ $pinjam->sales }}">
                    </div>
                    <div class="mb-3">
                        <label for="telp" class="form-label font-weight-bold">No Telp</label>
                        <input type="number" class="form-control shadow-none" id="telp" name="telp"
                            value="{{ $pinjam->telp }}">
                    </div>
                    <div class="mb-3">
                        <label for="pengirim" class="form-label font-weight-bold">Pengirim</label>
                        <input type="text" class="form-control shadow-none" id="pengirim" name="pengirim"
                            value="{{ $pinjam->pengirim }}">
                    </div>
                    <div class="mb-3">
                        <label for="kelengkapankirim" class="form-label font-weight-bold">Kelengkapan
                            Kirim</label>
                        <textarea class="form-control shadow-none" id="kelengkapankirim" name="kelengkapankirim" rows="3">{{ $pinjam->kelengkapankirim }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="tanggalkembali" class="form-label font-weight-bold">Tanggal Kembali</label>
                        <input type="date" class="form-control shadow-none" id="tanggalkembali" name="tanggalkembali"
                            value="{{ $pinjam->tanggalkembali }}">
                    </div>
                    <div class="mb-3">
                        <label for="penerima" class="form-label font-weight-bold">Penerima</label>
                        <input type="text" class="form-control shadow-none" id="penerima" name="penerima"
                            placeholder="Masukan Nama Penerima" value="{{ $pinjam->penerima }}">
                    </div>
                    <div class="mb-3">
                        <label for="kelengkapankembali" class="form-label font-weight-bold">Kelengkapan
                            Kembali</label><br />
                        <textarea class="form-control shadow-none" id="kelengkapankembali" name="kelengkapankembali" rows="3"
                            placeholder="Contoh:Adaptor,Dus,Docking">{{ $pinjam->kelengkapankembali }}</textarea>
                    </div>
                    <div class="mb-3" hidden>
                        <label for="status" class="form-label font-weight-bold">Status</label>
                        <input type="text" class="form-control shadow-none" id="status" name="status"
                            value="{{ $pinjam->status }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="gambar" class="form-label font-weight-bold">Gambar</label><br>
                        <input class="form-control shadow-none" type="file" id="gambar" name="gambar">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
@endsection
