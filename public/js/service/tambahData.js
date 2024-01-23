document.addEventListener("DOMContentLoaded", function () {
    // Get radio buttons and input field
    var stockRadio = document.getElementById("stock");
    var customerRadio = document.getElementById("customer");
    var pelangganInput = document.getElementById("pelanggan");

    // Function to handle radio button change
    function handleRadioChange(isStock) {
        pelangganInput.value = isStock ? "imin.id" : "";
    }

    // Add event listeners to radio buttons
    stockRadio.addEventListener("change", function () {
        handleRadioChange(stockRadio.checked);
    });

    customerRadio.addEventListener("change", function () {
        handleRadioChange(!customerRadio.checked);
    });
});
