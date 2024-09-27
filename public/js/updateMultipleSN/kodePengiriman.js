function updateKodePengiriman() {
    const status = document.querySelector('input[name="status"]:checked').value;
    let kodePengiriman = "";

    switch (status) {
        case "Gudang":
            kodePengiriman = "GDG";
            break;
        case "Service":
            kodePengiriman = "RSV";
            break;
        case "Dipinjam":
            kodePengiriman = "LOA";
            break;
        case "Terjual":
            kodePengiriman = "DO";
            break;
        case "Rusak":
            kodePengiriman = "EOL";
            break;
        case "Titip":
            kodePengiriman = "TIP";
            break;
        default:
            kodePengiriman = "";
    }

    document.getElementById("kode_pengiriman").value = kodePengiriman;
}
