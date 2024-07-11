<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>iMin Service</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/logoiminblack.PNG') }}">

    <!-- Custom fonts for this template-->
    <link href="{{ asset('sb2admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('sb2admin/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">

    <!--Bootstrap 4.6 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <!--Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-Avb2QiuDEEvB4bZJYdft2mNjVShBftLdPG8FJ0V7irTLQ8Uo0qcPxh4Plq7G5tGm0rU+1SPhVotteLpBERwTkw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <!-- Datatables -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <!-- Chosen Select Search -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap4c-chosen@1.1.1/dist/css/component-chosen.min.css"rel="stylesheet">

</head>

<body>

    <div>
        @yield('container')
    </div>
    <!-- Internal JS -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/stockMonitor/importViewStocks.js') }}" defer></script>
    <script src="{{ asset('js/copyText.js') }}" defer></script>
    <script src="{{ asset('js/importSpareparts.js') }}" defer></script>
    <script src="{{ asset('js/login/passwordView.js') }}" defer></script>
    <script src="{{ asset('js/service/tambahData.js') }}" defer></script>
    <script src="{{ asset('js/updateMultipleSN/validateSN.js') }}" defer></script>
    <script src="{{ asset('js/updateMultipleSN/updateSN.js') }}" defer></script>

    <!-- Jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"
        integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous">
    </script>
    <!-- SweetAlert2 JavaScript-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Core plugin JavaScript-->
    <script src="{{ asset('sb2admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <!-- Custom scripts for all pages-->
    <script src="{{ asset('sb2admin/js/sb-admin-2.min.js') }}"></script>
    <!-- Datatables -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <!-- Chosen Select Search -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"
        integrity="sha512-rMGGF4wg1R73ehtnxXBt5mbUfN9JUJwbk21KMlnLZDJh7BkPmeovBuddZCENJddHYYMkCh9hPFnPmS9sspki8g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    @include('sweetalert::alert')
    <script>
        new DataTable('#hometable', {
            initComplete: function() {
                var r = $('#hometable tfoot tr');
                r.find('th').each(function() {
                    $(this).css('padding', 8);
                });
                $('#hometable thead').append(r);
                $('#search_0').css('text-align', 'center');
                this.api()
                    .columns()
                    .every(function() {
                        let column = this;
                        let title = column.footer().textContent;

                        // Create input element
                        let input = document.createElement('input');
                        input.placeholder = title;
                        column.footer().replaceChildren(input);

                        // Event listener for user input
                        input.addEventListener('keyup', () => {
                            if (column.search() !== this.value) {
                                column.search(input.value).draw();
                            }
                        });
                    });
            }
        });
    </script>
    <script>
        new DataTable("#secondTable", {
            info: true,
            ordering: true,
            paging: true,
            responsive: true,
            "fnServerData": function(sUrl, aoData, fnCallback, oSettings) {
                oSettings.jqXHR = $.ajax({
                    "url": sUrl,
                    "data": aoData,
                    "success": function(json) {
                        if (json.sError) {
                            oSettings.oApi._fnLog(oSettings, 0, json.sError);
                        }

                        $(oSettings.oInstance).trigger('xhr', [oSettings, json]);
                        fnCallback(json);
                    },
                    "dataType": "json",
                    "cache": true, // Enable caching
                    "type": oSettings.sServerMethod,
                    "error": function(xhr, error, thrown) {
                        if (error == "parsererror") {
                            oSettings.oApi._fnLog(oSettings, 0,
                                "DataTables warning: JSON data from " +
                                "server could not be parsed. This is caused by a JSON formatting error."
                            );
                        }
                    }
                });
            },
            initComplete: function() {
                var r = $("#secondTable tfoot tr");
                r.find("th").each(function() {
                    $(this).css("padding", 8);
                });
                $("#secondTable thead").append(r);
                $("#search_0").css("text-align", "center");
                this.api()
                    .columns()
                    .every(function() {
                        let column = this;
                        let title = column.footer().textContent;

                        // Create input element
                        let input = document.createElement("input");
                        input.placeholder = title;
                        column.footer().replaceChildren(input);

                        // Event listener for user input
                        input.addEventListener("keyup", () => {
                            if (column.search() !== this.value) {
                                column.search(input.value).draw();
                            }
                        });
                    });
            },
        });
    </script>
    <script>
        new DataTable("#firmwareTable", {
            info: true,
            ordering: true,
            paging: true,
            responsive: true,
            "fnServerData": function(sUrl, aoData, fnCallback, oSettings) {
                oSettings.jqXHR = $.ajax({
                    "url": sUrl,
                    "data": aoData,
                    "success": function(json) {
                        if (json.sError) {
                            oSettings.oApi._fnLog(oSettings, 0, json.sError);
                        }

                        $(oSettings.oInstance).trigger('xhr', [oSettings, json]);
                        fnCallback(json);
                    },
                    "dataType": "json",
                    "cache": true, // Enable caching
                    "type": oSettings.sServerMethod,
                    "error": function(xhr, error, thrown) {
                        if (error == "parsererror") {
                            oSettings.oApi._fnLog(oSettings, 0,
                                "DataTables warning: JSON data from " +
                                "server could not be parsed. This is caused by a JSON formatting error."
                            );
                        }
                    }
                });
            },
            initComplete: function() {
                var r = $("#firmwareTable tfoot tr");
                r.find("th").each(function() {
                    $(this).css("padding", 1);
                });
                $("#firmwareTable thead").append(r);
                $("#search_0").css("text-align", "center");
                this.api()
                    .columns()
                    .every(function() {
                        let column = this;
                        let title = column.footer().textContent;

                        // Create input element
                        let input = document.createElement("input");
                        input.placeholder = title;
                        input.style.width = "100%";
                        column.footer().replaceChildren(input);

                        // Event listener for user input
                        input.addEventListener("keyup", () => {
                            if (column.search() !== this.value) {
                                column.search(input.value).draw();
                            }
                        });
                    });
            },
        });
    </script>
    <script>
        $(".form-control-chosen").chosen();
    </script>
    @stack('scripts')
</body>

</html>
