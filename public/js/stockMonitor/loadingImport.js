document.addEventListener("DOMContentLoaded", () => {
    const importForm = document.getElementById("importForm");
    const importStocksButton = document.getElementById("importStocks");

    importForm.addEventListener("submit", (event) => {
        event.preventDefault(); // Prevent the default form submission

        setLoading(true);

        // Simulate form submission process (replace this with your actual form submission logic)
        // Here, you would typically send an AJAX request to submit the form
        const formData = new FormData(importForm);
        fetch(importForm.action, {
            method: "POST",
            body: formData,
        })
            .then((response) => response.json())
            .then((data) => {
                setLoading(false);
                // Handle success or error response
                if (data.success) {
                    // Close the modal and reset the form
                    new bootstrap.Modal(
                        document.getElementById("importModal")
                    ).hide();
                    importForm.reset();
                } else {
                    // Display error message
                    document.getElementById("errorMessage").innerText =
                        data.message;
                }
            })
            .catch((error) => {
                setLoading(false);
                document.getElementById("errorMessage").innerText =
                    "Terjadi Kesalahan, Mohon Coba Kembali!";
            });
    });

    function setLoading(isLoading) {
        if (isLoading) {
            importStocksButton.disabled = true;
            importStocksButton.innerHTML =
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';
        } else {
            importStocksButton.disabled = false;
            importStocksButton.innerHTML = "Submit";
        }
    }
});
