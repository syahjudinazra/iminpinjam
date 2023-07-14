<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<style>
    body {
        font-family: Arial, Helvetica, sans-serif;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        font-family: Arial, Helvetica, sans-serif;
    }

    hr {
        color: black !important;
    }

    .invoice-box {
        max-width: 800px;
        margin: auto;
        font-size: 16px;
    }

    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
    }

    .invoice-box table td {
        /* padding: 5px; */
        vertical-align: top;
    }

    .invoice-box table tr td:nth-child(2) {
        text-align: right;
    }

    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }

    .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
    }

    .invoice-box table tr.information table td {
        padding-bottom: 10px;
    }

    .invoice-box table tr.heading td {
        border-bottom: 1px solid;
        font-weight: bold;
    }

    .invoice-box table tr.details td {
        padding-bottom: 10px;
    }

    .invoice-box table tr.item td {
        border-bottom: 1px solid;
    }

    .invoice-box table tr.item.last td {
        border-bottom: none;
    }

    .invoice-box table tr.total td:nth-child(2) {
        border-top: 2px solid;
        font-weight: bold;
    }

    .pinjamcontent th {
        border: 1px solid black;
        margin-bottom: 10px;
    }

    .pinjamcontent td {
        border: 1px solid black;
        margin-bottom: 10px;
        height: 50px;
    }


    .content {
        border: 1px solid black;
        font-size: 12px;
    }

    .aggreement {
        border: 1px solid black;
        font-size: 12px;
    }

    .aggreement td {
        font-size: 12px;
    }

    .bottom-text {
        display: -webkit-flex;
        display: flex;
        -webkit-flex-direction: row;
        flex-direction: row;
        -webkit-flex-wrap: nowrap;
        flex-wrap: nowrap;
        -webkit-justify-content: flex-start;
        justify-content: flex-start;
        -webkit-align-content: stretch;
        align-content: stretch;
        -webkit-align-items: flex-end;
        align-items: flex-end;
    }

    .checkterima {
        margin-top: 10rem;
        font-weight: bold;
    }

    .checkterima td {
        border: 1px solid black;
        border-collapse: collapse;
    }

    .checkkembali {
        margin-top: 2rem;
        font-weight: bold;
    }

    .checkkembali td {
        border: 1px solid black;
        border-collapse: collapse;
    }

    .catatan {
        border: 1px solid black;
        border-collapse: collapse;
    }

    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block;
            text-align: center;
        }

        .invoice-box table tr.information table td {
            width: 100%;
            display: block;

        }
    }

    /** RTL **/
    .invoice-box.rtl {
        direction: rtl;
    }

    .invoice-box.rtl table {
        text-align: right;
    }

    .invoice-box.rtl table tr td:nth-child(2) {
        text-align: left;
    }
</style>

<body>
    <div class="invoice-box">
        <table>
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="{{ public_path('img/iminbusinessnew.png') }}" alt=""
                                    style="widows: 70px; height: 70px" />
                            </td>

                            <td style="font-size: 12px;">
                                <h6>PT Imin Technology</h6>
                                11 Bishan Street 21 #03-05 Singapore 573943<br>&copy;2019 iMin Technology Pte Ltd.
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="equipment">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>

                            </td>

                            <td>
                                <h3 style="margin-top:-20px"><b>EQUIPMENT LOAN FORM</b></h3>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                <p style="font-size: 12px"><b>Loan to : {{ $pinjam->customer }} </b></p>
                                <p style="font-size: 10px; margin-top:-10px; width: 50%"><b>Address :
                                        {{ $pinjam->alamat }}</b></p>
                            </td>
                            <td>
                                <p style="font-size: 10px; margin-left:-20px"><b>Date :
                                        {{ $pinjam->tanggal->format('d-m-Y') }} </b></p>
                                <p style="font-size: 10px; margin-top:-10px; margin-left:-20px"><b>Sales Rep :
                                        {{ Auth::user()->name }}</b>
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <div class="customer" style="margin-top: 10px; font-size: 10px">
            <p><b>PIC : {{ $pinjam->customer }} </b></p>
            <p style="margin-top:-10px"><b>Phone : {{ $pinjam->telp }} </b></p>
        </div>

        <div class="container-fluid">
            <div class="pinjamcontent">
                <table class="text-center">
                    <thead style="background-color:#eee">
                        <tr>
                            <th>Item</th>
                            <th>Model</th>
                            <th>Description</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>S/N</th>
                        </tr>
                    </thead>
                    <tbody height="20px">
                        <tr>
                            <td>1</td>
                            <td style="text-align: center">{{ $pinjam->device }}</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>{{ $pinjam->serialnumber }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="container-fluid">
            <div class="content mt-2">
                <table>
                    <thead class="text-center" style="background-color:#eee">
                        <tr>
                            <th>Terms of Equipment Loan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <p style="margin-bottom: 3px">1. We understand that we are responsible for returning the
                                    equipment listed above in the condition in which it was received and are
                                    willingly to take responsibility to make certain that it is returned in the same
                                    condition. We accept financial responsibility for any
                                    repairs or replacement of lost or damaged items.</p><br>

                                <p style="margin-bottom: 3px">2. With respect to any item of equipment loan out to
                                    client, client will be liable toiMinin the event hat any loan item of equipment is
                                    lost, destroyed, stolen or rendered inoperative. Client will indemnify iMin against
                                    any loss arising out of damage to or destruction of
                                    any item of equipment provided hereunder for any cause whatsoever.</p><br>

                                <p style="margin-bottom: 3px">3. Compensation Cost :- (i) 30% of unit's selling price of
                                    equipment for minor appearance damage (ii) 50% of unit's selling price of
                                    equipment if equipment cannot function normally and/or major appearance damage.</p>
                                <br>

                                <p style="margin-bottom: 3px">4. The amount payable is considered as good faith deposit
                                    for the demo units. If theunitsare not able to meet customer's
                                    requirements, the deposit will be fully refunded once the items are sent back toiMin
                                    (customer will pay for the shipping fee) in good working condition. The loan period
                                    is 30 days and for any loan exceeding the time frame,the demo units will be
                                    considered as sold.</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="container-fluid mt-2">
            <div class="aggreement">
                <table>
                    <thead style="background-color:#eee">
                        <tr>
                            <th class="text-center">Aggreement</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <p style="margin-left: 30px">I have read and understand the terms of this equipment
                                    loan.</p>
                                <p style="margin-left: 30px; margin-top:-10px;">CHECK OUT DATE :</p>
                                <hr style="width:20%; margin-top:-20px; margin-left:9rem">
                                <p style="margin-left: 75px">DUE DATE :</p>
                                <hr style="width:20%; margin-top:-20px; margin-left:9rem">

                                <p>Acknowledged Receipt by :-</p>
                                <hr class="mt-5" size="2" width="30%" color="black">
                                <p style="margin-top:-10px">Dimas</p>
                                <p style="position: absolute; margin-left:7rem; margin-top:-30px">NAME & DATE:</p>
                            </td>
                            <td class="bottom-text" style="position: absolute; margin-left: -14rem; margin-top: 76px">
                                <p style="text-align:left">Approved for Loan</p>
                                <hr class="mt-5" size="2" color="black" style="width: 13rem">
                                <p style="margin-top:-10px; text-align:left">Jeffry</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="container-fluid mt-2">
            <div class="aggreement">
                <table>
                    <thead style="background-color:#eee">
                        <tr>
                            <th class="text-center" style="margin-left:-5rem">Equipment Return Information (for Office
                                use only)</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <p style="margin-left: 30px; margin-top:10px">DATE RETURNED :</p>
                                <hr style="width:20%; margin-top:-20px; margin-left:9rem">
                                <p style="position:absolute; margin-left: 20rem; margin-top:-28px">RECEIVED BY :</p>
                                <hr style="width:20%; margin-top:-17px; margin-left:26rem">

                                <p>CONDITION OF THE RETURNED EQUIPMENT :</p>
                                <hr style="width:40%; margin-top:-20px; margin-left:17rem">

                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="checkterima">
        <table width="70%">
            <thead class="text-center">
                <tr>
                    <td colspan="3">Kelengkapan Barang Dikirim</td>
                </tr>
            </thead>
            <tbody>
                <tr class="text-center">
                    <td>No</td>
                    <td>Nama barang</td>
                    <td>Checklist</td>
                </tr>
                <tr>
                    <td class="text-center" width="20">1</td>
                    <td>Kabel Power</td>
                    <td style="color:white">V</td>
                </tr>
                <tr>
                    <td class="text-center" width="20">2</td>
                    <td>Antena</td>
                    <td style="color:white">V</td>
                </tr>
                <tr>
                    <td class="text-center" width="20">3</td>
                    <td>Kunci Thermal</td>
                    <td style="color:white">V</td>
                </tr>
                <tr>
                    <td class="text-center" width="20">4</td>
                    <td>Kunci Belakang</td>
                    <td style="color:white">V</td>
                </tr>
                <tr style="color:white">
                    <td>5</td>
                    <td>Kabel Power</td>
                    <td>V</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="checkkembali">
        <table width="70%">
            <thead class="text-center">
                <tr>
                    <td colspan="3">Kelengkapan Barang Kembali</td>
                </tr>
            </thead>
            <tbody>
                <tr class="text-center">
                    <td width="20%">No</td>
                    <td>Nama barang</td>
                    <td>Checklist</td>
                </tr>
                <tr>
                    <td class="text-center" width="20">1</td>
                    <td>Kabel Power</td>
                    <td style="color:white">V</td>
                </tr>
                <tr>
                    <td class="text-center" width="20">2</td>
                    <td>Antena</td>
                    <td style="color:white">V</td>
                </tr>
                <tr>
                    <td class="text-center" width="20">3</td>
                    <td>Kunci Thermal</td>
                    <td style="color:white">V</td>
                </tr>
                <tr>
                    <td class="text-center" width="20">4</td>
                    <td>Kunci Belakang</td>
                    <td style="color:white">V</td>
                </tr>
                <tr style="color:white">
                    <td>5</td>
                    <td>Kabel Power</td>
                    <td>V</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="container-fluid mt-2">
        <h6>Catatan:</h6>
        <div class="catatan">
            <textarea name="catatan" id="" cols="30" rows="10"></textarea>
        </div>
    </div>
</body>

</html>
