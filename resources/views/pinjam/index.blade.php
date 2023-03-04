@extends('layouts.app')
@extends('layouts.navbar')

@section('content')

            <!-- Begin Page Content -->
        <div class="container-fluid">

                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Pinjam Barang</h1>
                    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
                        <i class="fas fa-download fa-sm text-white-50"></i> Generate Excel</a>
                </div>

            <button type="button" class="btn btn-danger mb-2" data-toggle="modal" data-target="#exampleModal">
                Add New Product
            </button>

            @if (session()->has('success'))
            <div class="alert alert-success" role="alert">
            {{ session('success') }}
            </div>
            @endif


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
                            <label for="gambar" class="form-label"><b>Gambar</b></label>
                            <input class="form-control" type="file" id="gambar" name="gambar">
                          </div>
                          <div class="mb-3">
                            <label for="serialnumber" class="form-label"><b>Serial Number</b></label>
                            <input type="text" class="form-control" id="serialnumber" name="serialnumber" placeholder="Masukan Serial Number">
                          </div>
                          <div class="form-group mb-3">
                            <label for="device"><b>Tipe Device</b></label>
                            <select class="form-control selectpicker" name="device" id="device" data-live-search="true" required>
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
                              <option value="D3 DS1 Extention Display" data-tokens="D3 DS1 Extention Display">D3 DS1 Extention Display</option>
                              <option value="D3 DS1 Extention Display TS" data-tokens="D3 DS1 Extention Display TS">D3 DS1 Extention Display TS</option>
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
                              <option value="M2 Swift 1 Scanner" data-tokens="M2 Swift 1 Scanner">M2 Swift 1 Scanner</option>
                              <option value="M2 Swift 1 Printer" data-tokens="M2 Swift 1 Printer">M2 Swift 1 Printer</option>
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
                            <input type="text" class="form-control" id="customer" name="customer" placeholder="Masukan Nama Customer">
                          </div>
                          <div class="mb-3">
                            <label for="telp" class="form-label"><b>No Telp</b></label>
                            <input type="number" class="form-control" id="telp" name="telp" placeholder="Masukan No Telp">
                          </div>
                          <div class="mb-3">
                            <label for="pengirim" class="form-label"><b>Nama Pengirim</b></label>
                            <input type="text" class="form-control" id="pengirim" name="pengirim" placeholder="Masukan Nama Pengirim">
                          </div>
                          <div class="mb-3">
                            <label for="kelengkapankirim" class="form-label"><b>Kelengkapan Kirim</b></label>
                            <textarea class="form-control" id="kelengkapankirim" name="kelengkapankirim" rows="3" placeholder="Contoh:Adaptor,Dus,Docking"></textarea>
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

 <div class="modal fade" id="edit_partner" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Data</h4>
        </div>
        <div class="modal-body">
          <p>Some text in the modal.</p>
          <input type="date" id="tanggal">
          <input type="file" id="gambar">
          <input type="text" id="serialnumber">
          <input type="text" id="device">
          <input type="text" id="customer">
          <input type="number" id="telp">
          <input type="text" id="pengiriman">
          <input type="text" id="kelengkapanpengiriman">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>

        <div class="container-fluid mt-3">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                  <th>No</th>
                  <th>Tanggal</th>
                  <th>Gambar</th>
                  <th>Serial Number</th>
                  <th>Tipe Device</th>
                  <th>Customer</th>
                  <th>Action</th>
                </thead>
                <tbody>
            @foreach ($pinjam as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->tanggal }}</td>
                <td>
                    <img src="{{ asset($item->gambar) }}" width= '60' height='60' class="img img-responsive" />
                </td>
                <td>{{ $item->serialnumber }}</td>
                <td>{{ $item->device }}</td>
                <td>{{ $item->customer }}</td>
                <td>
                    {{-- <a href="/pinjam/{{ $item->id }}/edit"
                       class="badge bg-warning"><i class="fa-solid fa-pen-to-square"></i></a> --}}

                       <a href="#" onclick="edit_partner(this)" data-target="#edit_partner" data-toggle="modal"
                       data-id="{{$item->id}}" data-serialnumber="734698273sada"><i class="fa-solid fa-pen-to-square"></i></a>

                        <a href="/servicedone/show/{{ $item->id }}"
                        class="badge bg-info"><i class="fa-solid fa-eye"></i></a>

                        <form action="/servicedone/{{ $item->id }}" method="post" class="d-inline">
                            @method('delete')
                            @csrf
                            <button class="badge bg-danger border-0" onclick="return confirm('Are you sure?')">
                            <i class="fa-solid fa-trash"></i></button>
                        </form>
                </td>
            </tr>
            @endforeach
                </tbody>
              </table>
        </div>
@endsection
