document.getElementById("inputStocks").addEventListener("change", function (e) {
    const file = e.target.files[0];
    const loader = document.getElementById("loader");
    const errorMessageElem = document.getElementById("errorMessage");
    const importButton = document.getElementById("importStocks");

    if (file) {
        const reader = new FileReader();

        reader.onloadstart = function () {
            loader.style.display = "block";
            errorMessageElem.innerText = "";
            importButton.style.display = "none";
        };

        reader.onload = function (e) {
            try {
                const data = new Uint8Array(e.target.result);
                const workbook = XLSX.read(data, { type: "array" });

                const sheet = workbook.Sheets[workbook.SheetNames[0]];
                const sheetData = XLSX.utils.sheet_to_json(sheet, {
                    header: 1,
                });

                // Debug log the sheet data
                console.log("Sheet Data:", sheetData);

                // Validate sheet data
                const errorMessage = validateSheetData(sheetData);
                errorMessageElem.innerText = errorMessage;

                if (!errorMessage) {
                    // Check for serial number duplicates
                    const serialnumberDuplicates =
                        checkSerialnumberDuplicates(sheet);
                    importButton.style.display = serialnumberDuplicates
                        ? "none"
                        : "block";

                    // Render the table with sheet data
                    renderScrollableTable(sheetData);
                } else {
                    // Hide import button if there's an error
                    importButton.style.display = "none";
                }
            } catch (error) {
                console.error("Error processing file:", error);
                errorMessageElem.innerText =
                    "Error processing file. Please check the file format.";
                importButton.style.display = "none";
            } finally {
                // Hide loader when file processing completes
                loader.style.display = "none";
            }
        };

        reader.onerror = function (error) {
            console.error("Error reading file:", error);
            errorMessageElem.innerText = "Error reading file.";
            loader.style.display = "none"; // Hide loader on error
        };

        reader.readAsArrayBuffer(file);
    }
});

function renderScrollableTable(data) {
    const htmlTable = convertSheetToHtmlWithDuplicateHighlight(data, true);
    document.getElementById("previewStockTable").innerHTML = htmlTable;
}

function convertSheetToHtmlWithDuplicateHighlight(data, isScrollable) {
    const uniqueValues = new Set();
    let htmlTable = "<table class='table table-bordered'>";

    htmlTable += "<thead><tr>";
    data[0].forEach((cellValue) => {
        htmlTable += `<th>${cellValue}</th>`;
    });
    htmlTable += "</tr></thead>";

    htmlTable += "<tbody>";
    data.slice(1).forEach((row) => {
        htmlTable += "<tr>";
        row.forEach((cellValue, cellIndex) => {
            const isDuplicate = uniqueValues.has(cellValue);
            htmlTable += `<td style="color: ${
                isDuplicate ? "red" : "black"
            }">${cellValue}</td>`;
            if (cellIndex === 0) {
                uniqueValues.add(cellValue);
            }
        });
        htmlTable += "</tr>";
    });
    htmlTable += "</tbody></table>";

    return htmlTable;
}

function checkSerialnumberDuplicates(sheet) {
    const sheetData = XLSX.utils.sheet_to_json(sheet, { header: 1 });
    const serialnumberIndex = sheetData[0].indexOf("serialnumber");
    const serialnumberValues = new Set();

    for (let row of sheetData.slice(1)) {
        const serialnumberValue = row[serialnumberIndex];
        if (serialnumberValues.has(serialnumberValue)) {
            return true;
        }
        serialnumberValues.add(serialnumberValue);
    }

    return false;
}

function validateSheetData(sheetData) {
    const statusIndex = sheetData[0].indexOf("status");
    if (statusIndex === -1) {
        return "";
    }

    const validStatuses = [
        "Gudang",
        "Service",
        "Dipinjam",
        "Terjual",
        "Rusak",
        "Titip",
    ];

    for (let row of sheetData.slice(1)) {
        const statusValue = row[statusIndex];
        if (!validStatuses.includes(statusValue)) {
            return `Status harus memiliki isi setidaknya (Gudang, Service, Dipinjam, Terjual, Rusak, Atau Titip), Bukan ${statusValue}`;
        }
    }

    return "";
}
