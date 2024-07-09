document.getElementById("inputStocks").addEventListener("change", function (e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();

        reader.onload = function (e) {
            const data = new Uint8Array(e.target.result);
            const workbook = XLSX.read(data, {
                type: "array",
            });

            const sheet = workbook.Sheets[workbook.SheetNames[0]];
            const sheetData = XLSX.utils.sheet_to_json(sheet, { header: 1 });

            const errorMessage = validateSheetData(sheetData);
            document.getElementById("errorMessage").innerText = errorMessage;

            if (!errorMessage) {
                const serialnumberDuplicates =
                    checkSerialnumberDuplicates(sheet);
                const importButton = document.getElementById("importStocks");
                importButton.style.display = serialnumberDuplicates
                    ? "none"
                    : "block";

                renderScrollableTable(sheetData);
            } else {
                document.getElementById("importStocks").style.display = "none";
            }
        };

        reader.readAsArrayBuffer(file);
    }
});

function renderScrollableTable(data) {
    const htmlTable = convertSheetToHtmlWithDuplicateHighlight(data, true);
    document.getElementById("previewStockTable").innerHTML = htmlTable;
    document.getElementById("paginationControls").innerHTML = ""; // Remove pagination controls
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
