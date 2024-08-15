@extends('layouts.app')
@extends('layouts.navbar')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="d-flex justify-content-between align-items-center">
                <div class="head-title">
                    <h3>Firmware</h3>
                </div>
                @auth
                    @if (auth()->user()->hasAnyRole(['superadmin', 'jeffri']))
                        @include('components.firmware.ReportAction')
                    @endif
                @endauth
            </div>
            <!-- Import Firmware Modal -->
            <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModal" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Import Excel</h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('firmware.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="d-flex justify-content-center">
                                    <input type="file" name="inputFirmware" id="inputFirmware"
                                        class="form-control shadow-none" style="width: auto">
                                </div>
                                <a href="{{ route('template.firmware', ['filename' => 'TemplateImportFirmware.xlsx']) }}"
                                    class="d-flex justify-content-center text-decoration-none">Download
                                    template</a>
                                <div class="table table-bordered mt-2" id="preview"></div>
                            </div>
                            <div class="modal-footer justify-content-center">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button id="importButton" class="btn btn-success">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="d-flex mb-4 mt-4" id="wrapper">
                <div class="bg-light border-right" id="sidebar-wrapper">
                    @include('firmware.sidebar')
                </div>
                <div id="firmwares-content">
                    <div class="container-fluid">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
