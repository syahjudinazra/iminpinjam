<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoice['invoice_no'] }}</title>
    <style>
        body {
            font-family: Helvetica, Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        .header {
            margin-bottom: 30px;
            width: 100%;
        }

        .company-info {
            width: 100%;
            display: table !important;
            table-layout: fixed;
        }

        .company-logo {
            display: table-cell;
            vertical-align: top;
            width: 60px;
            padding-right: 20px;
        }

        .company-logo img {
            width: 20%;
            height: auto;
            display: block;
        }

        .company-desc {
            display: table-cell;
            vertical-align: top;
            text-align: left;
            width: 50%;
        }

        .company-address {
            display: table-cell;
            vertical-align: top;
            text-align: right;
            width: calc(50% - 80px);
            /* Accounting for logo width and padding */
        }

        .company-desc h4,
        .company-address h4 {
            margin: 0 0 5px 0;
            font-size: 16px;
            font-weight: normal;
            color: #000;
        }

        .company-desc p,
        .company-address p {
            margin: 0;
            font-size: 12px;
            line-height: 1.4;
            color: #666;
        }

        .divider {
            margin-top: 10px;
            border-bottom: 1px solid #ddd;
            width: 100%;
        }

        /* Rest of your existing styles */
        .proforma-info {
            width: 100%;
            display: table !important;
            margin: 20px 0;
            table-layout: fixed;
        }

        .bill-to {
            display: table-cell;
            vertical-align: top;
            width: 60%;
            padding-right: 20px;
        }

        .invoice-details {
            display: table-cell;
            vertical-align: top;
            width: 40%;
        }

        .bill-to p,
        .invoice-details p {
            margin: 0 0 8px 0;
            font-size: 12px;
            line-height: 1.4;
        }

        .bill-to p:first-child,
        .invoice-details p:first-child {
            margin-bottom: 12px;
        }

        .bill-to strong,
        .invoice-details strong {
            font-weight: bold;
            color: #000;
        }

        /* Optional: Add some spacing between the lines in the bill-to address */
        .bill-to p:not(:first-child) {
            white-space: pre-line;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th {
            background-color: #000000;
            color: #ffff;
            text-align: left;
            padding: 8px;
        }

        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .total {
            text-align: right;
            margin-top: 20px;
        }

        .signature {
            margin-top: 30px;
            text-align: right;
        }

        .payment-info {
            margin-top: 50px;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="company-info">
            <div class="company-logo">
                <img src="{{ public_path('img/darivisi.png') }}" alt="Logo">
            </div>

            <div class="company-address">
                <h4>PT. Dari Visi Teknologi</h4>
                <p>Equity Tower 22nd Floor (SC25)<br>
                    Jl.Sudirman No.22, RT.5/RW.3, Senayan, CBD<br>
                    Jakarta Selatan 12190</p>
            </div>
        </div>
        <div class="divider"></div>
    </div>

    <h2 style="text-align: right;">PROFORMA INVOICE</h2>

    <div class="proforma-info">
        <div class="bill-to">
            <p><strong>BILL TO</strong></p>
            <p>{!! nl2br(e($invoice['bill_to'])) !!}</p>
        </div>
        <div class="invoice-details">
            <p><strong>Proforma Invoice No:</strong> {{ $invoice['invoice_no'] }}</p>
            <p><strong>Date:</strong> {{ $formatted_date }}</p>
            <p><strong>PO / SO No: - </strong></p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Items</th>
                <th>Quantity</th>
                <th>Price (Rp)</th>
                <th>Amount (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoice['items'] as $item)
                <tr>
                    <td>{{ $item['description'] }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td style="text-align: right">
                        {{ number_format($item['price'], 0, ',', '.') }}
                    </td>
                    <td style="text-align: right">
                        {{ number_format($item['amount'], 0, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" style="text-align: right"><strong>Total:</strong></td>
                <td style="text-align: right">
                    <strong>{{ number_format($total, 0, ',', '.') }}</strong>
                </td>
            </tr>
        </tfoot>
    </table>

    <div class="signature">
        <p><strong>PT. DARI VISI TEKNOLOGI</strong></p>
        <img src="{{ public_path('img/ttd.png') }}" alt="Logo" width="200">
        <br>
        <p>Finance Dept</p>
    </div>

    <div class="payment-info">
        <p>For Payment, please remit to:</p>
        <p><strong>PT. Dari Visi Teknologi</strong></p>
        <p>BCA - Jakarta Acc. No. 746-0330429</p>
        <p>BRI - Jakarta Acc. No.1223-01-001431-30-8</p>
    </div>
</body>

</html>
