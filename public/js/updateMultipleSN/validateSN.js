document
    .getElementById("validateSerialNumber")
    .addEventListener("click", function () {
        var form = document.getElementById("serialNumberForm");
        var formData = new FormData(form);

        fetch(form.action, {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-Token": "{{ csrf_token() }}",
            },
        })
            .then((response) => response.json())
            .then((data) => {
                // Display validation results
                if (data.validationResults) {
                    var tableBody = document.getElementById(
                        "serialNumberTableBody"
                    );
                    tableBody.innerHTML = "";

                    data.validationResults.forEach((result) => {
                        var row = document.createElement("tr");

                        var serialNumberCell = document.createElement("td");
                        serialNumberCell.textContent = result.serialNumber;

                        var customerCell = document.createElement("td");
                        customerCell.textContent = result.exists
                            ? result.pelanggan
                            : "N/A";

                        var typeCell = document.createElement("td");
                        typeCell.textContent = result.exists
                            ? result.tipe
                            : "N/A";

                        var statsCell = document.createElement("td");
                        statsCell.textContent = result.exists
                            ? result.status
                            : "N/A";

                        var messageCell = document.createElement("td");
                        messageCell.textContent = result.message;
                        if (result.message === "Not Exist") {
                            messageCell.className = "text-danger";
                        }

                        row.appendChild(serialNumberCell);
                        row.appendChild(customerCell);
                        row.appendChild(typeCell);
                        row.appendChild(statsCell);
                        row.appendChild(messageCell);

                        tableBody.appendChild(row);
                    });
                }
            })
            .catch((error) => console.error("Error:", error));
    });

$(document).ready(function () {
    $("#submitBtn").prop("disabled", true);
    function checkFields() {
        var textareaValue = $("#serialnumber").val().trim();
        var radioValue = $('input[name="status[]"]:checked').val();
        var pelangganValue = $("#pelanggan").val().trim();
        var tanggalKeluarValue = $("#tanggalkeluar").val().trim();

        if (
            textareaValue !== "" &&
            radioValue &&
            pelangganValue !== "" &&
            tanggalKeluarValue !== ""
        ) {
            $("#submitBtn").prop("disabled", false);
        } else {
            $("#submitBtn").prop("disabled", true);
        }
    }

    $('#serialnumber, input[name="status[]"], #pelanggan, #tanggalkeluar').on(
        "keyup change",
        function () {
            checkFields();
        }
    );

    $("#submitBtn").click(function () {
        if ($(this).prop("disabled")) {
            alert("Please fill in all fields before submitting.");
            return false;
        }

        return true;
    });
});
