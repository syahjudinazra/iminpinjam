$("#submitBtn").click(function () {
    var serialNumbers = $("#serialnumber").val().split("\n");
    var status = $('input[name="status[]"]:checked').val();
    var tanggalkeluar = $("#tanggalkeluar").val();
    var pelanggan = $("#pelanggan").val();
    var lokasi = $("#lokasi").val();
    var keterangan = $("#keterangan").val();
    var kode_pengiriman = $("#kode_pengiriman").val();
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
            lokasi: lokasi,
            keterangan: keterangan,
            kode_pengiriman: kode_pengiriman,
        },
        success: function (response) {
            Swal.fire({
                icon: "success",
                title: "Success!",
                text: "Move SN Berhasil",
                showConfirmButton: true,
                timer: 2000,
            });
        },
        error: function (xhr, status, error) {
            Swal.fire({
                icon: "error",
                title: "Error!",
                text: "Move SN Gagal",
                showConfirmButton: true,
                timer: 2000,
            });
        },
    });
});
