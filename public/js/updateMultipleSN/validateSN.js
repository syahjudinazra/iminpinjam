document
    .getElementById("validateSerialNumber")
    .addEventListener("click", function () {
        var form = document.getElementById("serialNumberForm");
        var formData = new FormData(form);

        fetch(form.action, {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-Token": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
            },
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.validationResults) {
                    makeScrollable(data.validationResults);
                }
            })
            .catch((error) => console.error("Error:", error));
    });

function makeScrollable(data) {
    const tableBody = document.getElementById("serialNumberTableBody");
    const pagination = document.getElementById("pagination");
    const errorTable = document.getElementById("errorTable");

    tableBody.innerHTML = "";
    pagination.innerHTML = "";

    const errors = [];

    data.forEach((result, index) => {
        var row = document.createElement("tr");

        var numberCell = document.createElement("td");
        numberCell.textContent = index + 1;

        var serialNumberCell = document.createElement("td");
        serialNumberCell.textContent = result.serialNumber;

        var customerCell = document.createElement("td");
        customerCell.textContent = result.exists ? result.pelanggan : "N/A";

        var typeCell = document.createElement("td");
        typeCell.textContent = result.exists ? result.tipe : "N/A";

        var statsCell = document.createElement("td");
        statsCell.textContent = result.exists ? result.status : "N/A";

        var messageCell = document.createElement("td");
        messageCell.textContent = result.message;
        if (result.message === "Not Exist") {
            messageCell.className = "text-danger";
            const errorMsg = `Error di baris ${index + 1}: Serial number ${
                result.serialNumber
            } tidak ada`;
            errors.push(errorMsg);
        }

        row.appendChild(numberCell);
        row.appendChild(serialNumberCell);
        row.appendChild(customerCell);
        row.appendChild(typeCell);
        row.appendChild(statsCell);
        row.appendChild(messageCell);

        tableBody.appendChild(row);
    });

    // Display errors
    displayErrors(errors);

    // Apply scrollable style
    const tableWrapper = document.getElementById("tableWrapper");
    tableWrapper.style.maxHeight = "400px";
    tableWrapper.style.overflowY = "scroll";
}

function displayErrors(errors) {
    const errorTable = document.getElementById("errorTable");
    errorTable.innerHTML = "";
    if (errors.length > 0) {
        const errorList = document.createElement("ul");
        errorList.className = "text-danger";
        errors.forEach((error) => {
            const errorItem = document.createElement("li");
            errorItem.textContent = error;
            errorList.appendChild(errorItem);
        });
        errorTable.appendChild(errorList);
    }
}

$("#submitBtn").click(function (e) {
    e.preventDefault(); // Prevent default form submission

    if ($(this).prop("disabled")) {
        alert("Please fill in all fields before submitting.");
        return false;
    }

    // Collect serial numbers from the table
    var serialNumbers = [];
    $("#serialNumberTableBody tr").each(function () {
        serialNumbers.push($(this).find("td:eq(1)").text());
    });

    // Get form data
    var formData = new FormData($("#serialNumberForm")[0]);
    formData.append("serialnumbers", JSON.stringify(serialNumbers));

    // Send AJAX request
    $.ajax({
        url: $(this).data("route"),
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            "X-CSRF-TOKEN": $(this).data("csrf"),
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
