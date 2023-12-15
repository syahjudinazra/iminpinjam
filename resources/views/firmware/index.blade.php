@extends('layouts.app')
@extends('layouts.navbar')

@section('content')
    <div class="container">
        <div class="row">
            <div class="d-flex justify-content-between align-items-center">
                <div class="head-title">
                    <h3>Firmware</h3>
                </div>
                @if (Auth::check())
                    <div class="edit-firmware">
                        <a href="/firmware/table" class="btn btn-success">
                            <h5>Firmware Data</h5>
                        </a>
                    </div>
                @endif
            </div>

            <main>
                <div class="container-fluid bg-trasparent my-4 p-3" style="position: relative;">
                    <div class="row g-3">
                        <div class="all-firmware">
                            <div class="desktop-firmware">
                                <h2>Desktop Firmware</h2>
                                <div class="d-flex flex-wrap">
                                    @foreach ($desktopFirmware as $item)
                                        <div class="col-12 col-md-6 col-lg-4 p-3">
                                            <div class="card h-100 shadow-sm">
                                                <img src="{{ asset('/storage/gambar/' . $item->gambar) }}"
                                                    class="card-img-top" height="280">
                                                <div class="card-body">
                                                    <div class="clearfix mb-3 d-flex justify-content-center fs-3">
                                                        <span
                                                            class="float-start badge rounded-pill bg-primary">{{ $item->tipe }}</span>
                                                    </div>
                                                    <h5 class="card-title">Firmware : {{ $item->version }}</h5>
                                                    <h5 class="card-title">Android : {{ $item->android }}</h5>
                                                    <h5 class="card-title">Flash : <a href="{{ $item->flash }}"
                                                            class="btn btn-warning btn-sm" target="__blank">Download</a>
                                                    </h5>
                                                    <h5 class="card-title">OTA : <a href="{{ $item->ota }}"
                                                            class="btn btn-danger btn-sm" target="__blank">Download</a>
                                                    </h5>
                                                    <div class="text-center my-4">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>


                            <div class="mobile-firmware mt-4">
                                <h2>Mobile Firmware</h2>
                                <div class="d-flex flex-wrap">
                                    @foreach ($mobileFirmware as $item)
                                        <div class="col-12 col-md-6 col-lg-4 p-3
                                        ">
                                            <div class="card h-100 shadow-sm">
                                                <img src="{{ asset('/storage/gambar/' . $item->gambar) }}"
                                                    class="card-img-top" height="280">
                                                <div class="card-body">
                                                    <div class="clearfix mb-3 d-flex justify-content-center fs-3">
                                                        <span
                                                            class="float-start badge rounded-pill bg-primary">{{ $item->tipe }}</span>
                                                    </div>
                                                    <h5 class="card-title">Firmware : {{ $item->version }}</h5>
                                                    <h5 class="card-title">Android : {{ $item->android }}</h5>
                                                    <h5 class="card-title">Flash : <a href="{{ $item->flash }}"
                                                            class="btn btn-warning btn-sm" target="__blank">Download</a>
                                                    </h5>
                                                    <h5 class="card-title">OTA : <a href="{{ $item->ota }}"
                                                            class="btn btn-danger btn-sm" target="__blank">Download</a>
                                                    </h5>
                                                    <div class="text-center my-4">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="kiosk-firmware mt-4">
                                <h2>KIOSK Firmware</h2>
                                <div class="d-flex flex-wrap">
                                    @foreach ($kioskFirmware as $item)
                                        <div class="col-12 col-md-6 col-lg-4 p-3">
                                            <div class="card h-100 shadow-sm">
                                                <img src="{{ asset('/storage/gambar/' . $item->gambar) }}"
                                                    class="card-img-top" height="280">
                                                <div class="card-body">
                                                    <div class="clearfix mb-3 d-flex justify-content-center fs-3">
                                                        <span
                                                            class="float-start badge rounded-pill bg-primary">{{ $item->tipe }}</span>
                                                    </div>
                                                    <h5 class="card-title">Firmware : {{ $item->version }}</h5>
                                                    <h5 class="card-title">Android : {{ $item->android }}</h5>
                                                    <h5 class="card-title">Flash : <a href="{{ $item->flash }}"
                                                            class="btn btn-warning btn-sm" target="__blank">Download</a>
                                                    </h5>
                                                    <h5 class="card-title">OTA : <a href="{{ $item->ota }}"
                                                            class="btn btn-danger btn-sm" target="__blank">Download</a>
                                                    </h5>
                                                    <div class="text-center my-4">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection
