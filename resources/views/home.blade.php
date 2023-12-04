@extends('layouts.app')
@extends('layouts.navbar')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        </div>
    </div>
    <div class="ag-format-container">
        <div class="ag-courses_box">
            <div class="ag-courses_item">
                <a href="/servicedone" class="ag-courses-item_link">
                    <div class="ag-courses-item_bg"></div>

                    <div class="ag-courses-item_title">
                        {{ $servicedone->total() }}
                    </div>

                    <div class="ag-courses-item_date-box">
                        Jumlah Data:
                        <span class="ag-courses-item_date">
                            Service Done
                        </span>
                    </div>
                </a>
            </div>

            <div class="ag-courses_item">
                <a href="/servicepending" class="ag-courses-item_link">
                    <div class="ag-courses-item_bg"></div>

                    <div class="ag-courses-item_title">
                        {{ $servicepending->total() }}
                    </div>

                    <div class="ag-courses-item_date-box">
                        Jumlah Data:
                        <span class="ag-courses-item_date">
                            Service Pending
                        </span>
                    </div>
                </a>
            </div>

            <div class="ag-courses_item">
                <a href="/kanibal" class="ag-courses-item_link">
                    <div class="ag-courses-item_bg"></div>

                    <div class="ag-courses-item_title">
                        {{ $kanibal->total() }}
                    </div>

                    <div class="ag-courses-item_date-box">
                        Jumlah Data:
                        <span class="ag-courses-item_date">
                            Kanibal
                        </span>
                    </div>
                </a>
            </div>

            <div class="ag-courses_item">
                <a href="/pinjam" class="ag-courses-item_link">
                    <div class="ag-courses-item_bg"></div>

                    <div class="ag-courses-item_title">
                        {{ $pinjam->total() }}
                    </div>

                    <div class="ag-courses-item_date-box">
                        Jumlah Data:
                        <span class="ag-courses-item_date">
                            Pinjam & Kembali
                        </span>
                    </div>
                </a>
            </div>

            <div class="ag-courses_item">
                <a href="/spareparts" class="ag-courses-item_link">
                    <div class="ag-courses-item_bg"></div>

                    <div class="ag-courses-item_title">
                        {{ $spareParts->total() }}
                    </div>

                    <div class="ag-courses-item_date-box">
                        Jumlah Data:
                        <span class="ag-courses-item_date">
                            SpareParts
                        </span>
                    </div>
                </a>
            </div>

            {{-- <div class="ag-courses_item">
                <a href="#" class="ag-courses-item_link">
                    <div class="ag-courses-item_bg"></div>

                    <div class="ag-courses-item_title">
                        Front-end development&#160;+ jQuery&#160;+ CMS
                    </div>
                </a>
            </div>

            <div class="ag-courses_item">
                <a href="#" class="ag-courses-item_link">
                    <div class="ag-courses-item_bg">
                    </div>
                    <div class="ag-courses-item_title">
                        Digital Marketing
                    </div>
                </a>
            </div>

            <div class="ag-courses_item">
                <a href="#" class="ag-courses-item_link">
                    <div class="ag-courses-item_bg"></div>

                    <div class="ag-courses-item_title">
                        Interior Design
                    </div>

                    <div class="ag-courses-item_date-box">
                        Start:
                        <span class="ag-courses-item_date">
                            31.10.2022
                        </span>
                    </div>
                </a>
            </div> --}}

        </div>
    </div>
@endsection
