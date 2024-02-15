$("#submitBtn").click(function () {
    var serialNumbers = $("#serialnumber").val().split("\n");
    var status = $('input[name="status[]"]:checked').val();
    var tanggalkeluar = $("#tanggalkeluar").val();
    var pelanggan = $("#pelanggan").val();
    var route = $(this).data("route");
    var csrfToken = $(this).data("csrf");

    $.ajax({
        type: "POST",
        url: route,
        data: {
            _token: csrfToken,
            serialnumbers: serialNumbers,
            status: status,
            tanggalkeluar: tanggalkeluar,
            pelanggan: pelanggan,
        },
        success: function (response) {
            Swal.fire({
                icon: "success",
                title: "Success!",
                text: response.message,
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
            });
        },
        error: function (xhr, status, error) {
            Swal.fire({
                icon: "error",
                title: "Error!",
                text: xhr.responseText,
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
            });
        },
    });
});
