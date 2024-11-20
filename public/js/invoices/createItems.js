$(document).ready(function () {
    // Add new row
    $("#addRow").click(function () {
        let rowCount = $(".item-row").length;
        let newRow = $(".item-row:first").clone();

        // Clear values and update names
        newRow.find("input").val("");
        newRow.find('input[name^="items"]').each(function () {
            let name = $(this)
                .attr("name")
                .replace("[0]", "[" + rowCount + "]");
            $(this).attr("name", name);
        });
        newRow.find(".quantity").val(1);
        newRow.find(".price").val(0);
        newRow.find(".amount").val(0);

        $("#itemsTable tbody").append(newRow);
        calculateTotals();
    });

    // Delete row
    $(document).on("click", ".delete-row", function () {
        if ($(".item-row").length > 1) {
            $(this).closest("tr").remove();
            calculateTotals();
        }
    });

    // Calculate amount and total
    $(document).on("input", ".quantity, .price", function () {
        let row = $(this).closest("tr");
        let quantity = parseFloat(row.find(".quantity").val()) || 0;
        let price = parseFloat(row.find(".price").val()) || 0;
        let amount = quantity * price;

        row.find(".amount").val(amount);
        calculateTotals();
    });

    function calculateTotals() {
        let total = 0;
        $(".amount").each(function () {
            total += parseFloat($(this).val()) || 0;
        });

        $("#total").text(formatCurrency(total));
    }

    function formatCurrency(value) {
        return new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR",
            minimumFractionDigits: 0,
        }).format(value);
    }
});
