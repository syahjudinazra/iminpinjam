document
    .getElementById("inputSpareParts")
    .addEventListener("change", function (e) {
        const file = e.target.files[0];
        if (file) {
            // Read the Excel file
            const reader = new FileReader();

            reader.onload = function (e) {
                const data = new Uint8Array(e.target.result);
                const workbook = XLSX.read(data, {
                    type: "array",
                });

                const sheet = workbook.Sheets[workbook.SheetNames[0]];
                const htmlTable =
                    convertSheetToHtmlWithDuplicateHighlight(sheet);
                document.getElementById("preview").innerHTML = htmlTable;
                const nosparepartsDuplicates =
                    checkNosparepartsDuplicates(sheet);
                const importButton = document.getElementById("importButton");
                importButton.style.display = nosparepartsDuplicates
                    ? "none"
                    : "block";
            };

            reader.readAsArrayBuffer(file);
        }
    });

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

function checkNosparepartsDuplicates(sheet) {
    const sheetData = XLSX.utils.sheet_to_json(sheet, {
        header: 1,
    });
    const nosparepartsIndex = sheetData[0].indexOf("nospareparts");
    const nosparepartsValues = new Set();

    for (let row of sheetData.slice(1)) {
        const nosparepartsValue = row[nosparepartsIndex];
        if (nosparepartsValues.has(nosparepartsValue)) {
            return true;
        }
        nosparepartsValues.add(nosparepartsValue);
    }

    return false;
}
