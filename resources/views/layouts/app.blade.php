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
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.1.0/mdb.min.css" rel="stylesheet" />

    <!--Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <!--Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <!-- Datatables -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
</head>

<body>

    <div>
        @yield('container')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    {{-- <script src="{{ asset('js/previewexcel.js') }}"></script> --}}
    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.1.0/mdb.min.js"></script>
    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('sb2admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('sb2admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Core plugin JavaScript-->
    <script src="{{ asset('sb2admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <!-- Custom scripts for all pages-->
    <script src="{{ asset('sb2admin/js/sb-admin-2.min.js') }}"></script>
    <!-- Datatables -->
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script>


    @include('sweetalert::alert')
    <script>
        // Function to handle file input change event
        document.getElementById("file").addEventListener("change", function(e) {
            const file = e.target.files[0];
            if (file) {
                // Read the Excel file
                const reader = new FileReader();

                reader.onload = function(e) {
                    const data = new Uint8Array(e.target.result);
                    const workbook = XLSX.read(data, {
                        type: "array",
                    });

                    // Assuming the Excel file has only one sheet
                    const sheet = workbook.Sheets[workbook.SheetNames[0]];

                    // Convert the sheet data to HTML with duplicate checking
                    const htmlTable = convertSheetToHtmlWithDuplicateHighlight(sheet);

                    // Display the HTML table in the preview container
                    document.getElementById("preview").innerHTML = htmlTable;
                };

                reader.readAsArrayBuffer(file);
            }
        });

        // // Function to handle the preview button click
        // document.getElementById('previewButton').addEventListener('click', function() {
        //     // Trigger the file input click event
        //     document.getElementById('importSpareparts').click();
        // });

        function convertSheetToHtmlWithDuplicateHighlight(sheet) {
            const sheetData = XLSX.utils.sheet_to_json(sheet, {
                header: 1,
            });
            const uniqueValues = new Set();
            let htmlTable = "<table>";

            for (let row of sheetData) {
                htmlTable += "<tr>";
                for (let cellIndex in row) {
                    const cellValue = row[cellIndex];
                    const isDuplicate = uniqueValues.has(cellValue);
                    if (cellIndex == 0) {
                        htmlTable += `<td style="color: ${
                    isDuplicate ? "red" : "black"
                }">${cellValue}</td>`;
                    } else {
                        htmlTable += `<td>${cellValue}</td>`;
                    }
                    uniqueValues.add(cellValue);
                }
                htmlTable += "</tr>";
            }

            htmlTable += "</table>";
            return htmlTable;
        }
    </script>
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
        new DataTable("#service", {
            info: false,
            ordering: false,
            paging: false,
            initComplete: function() {
                var r = $("#hometable tfoot tr");
                r.find("th").each(function() {
                    $(this).css("padding", 8);
                });
                $("#hometable thead").append(r);
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
</body>

</html>
