<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        @page {
            margin: 10px 10px 10px ;
        }

        #footer {
            position: fixed;
            padding-left: 10px;
            padding-right: 10px;
            width: 100%;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 12px;
            bottom: 0;
            text-align: center;
        }

        #footer .page:after {
            content: counter(page);
            text-align: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 12px;
        }

        body {
            font-size: 12px;

            header {}

            .container {
                display: flex;
                align-items: left;
                padding: 5px;
            }

            .logo {
                float: left;
                width: 100px;
                height: 100px;
                margin-right: 20px;
                margin-left: 20px;
            }


            .content {
                line-height: 1;
            }

            .content h1 {
                font-size: 16px;
                margin: 0;
                font-weight: bold;
            }

            .content p {
                margin: 5px 0;
            }

            .content a {
                color: blue;
                text-decoration: none;
            }

        }

        .spreadSheetGroup {
            /*font:0.75em/1.5 sans-serif;
    font-size:14px;
  */
            color: #333;
            background-color: #fff;
            padding: 1em;
        }

        /* Tables */
        .spreadSheetGroup table {
            width: 100%;
            margin-bottom: 1em;
            border-collapse: collapse;
        }

        .spreadSheetGroup .proposedWork th {
            background-color: #eee;
        }

        .tableBorder th {
            background-color: #eee;
        }

        .spreadSheetGroup th,
        .spreadSheetGroup tbody td {
            padding: 0.5em;

        }

        .spreadSheetGroup tfoot td {
            padding: 0.5em;

        }

        .spreadSheetGroup td:focus {
            border: 1px solid #fff;
            -webkit-box-shadow: inset 0px 0px 0px 2px #5292F7;
            -moz-box-shadow: inset 0px 0px 0px 2px #5292F7;
            box-shadow: inset 0px 0px 0px 2px #5292F7;
            outline: none;
        }

        .spreadSheetGroup .spreadSheetTitle {
            font-weight: bold;
        }

        .spreadSheetGroup tr td {
            text-align: center;
        }

        .spreadSheetGroup .calculation::before,
        .spreadSheetGroup .groupTotal::before {
            /*content: "Rp. ";*/
        }

        .spreadSheetGroup .trAdd {
            background-color: #007bff !important;
            color: #fff;
            font-weight: 800;
            cursor: pointer;
        }

        .spreadSheetGroup .tdDelete {
            background-color: #eee;
            color: #888;
            font-weight: 800;
            cursor: pointer;
        }

        .spreadSheetGroup .tdDelete:hover {
            background-color: #df5640;
            color: #fff;
            border-color: #ce3118;
        }

        .documentControls {
            text-align: right;
        }

        .spreadSheetTitle span {
            padding-right: 10px;
        }

        .spreadSheetTitle a {
            font-weight: normal;
            padding: 0 12px;
        }

        .spreadSheetTitle a:hover,
        .spreadSheetTitle a:focus,
        .spreadSheetTitle a:active {
            text-decoration: none;
        }

        .spreadSheetGroup .groupTotal {
            text-align: right;
        }



        table.style1 tr td:first-child {
            font-weight: bold;
            white-space: nowrap;
            text-align: right;
        }

        table.style1 tr td:last-child {
            border-bottom: 1px solid #000;
        }



        table.proposedWork td,
        table.proposedWork th,
        table.exclusions td,
        table.exclusions th {
            border: 1px solid #000;
        }

        table.proposedWork thead th,
        table.exclusions thead th {
            font-weight: bold;
        }

        table.proposedWork td,
        table.proposedWork th:first-child,
        table.exclusions th,
        table.exclusions td {
            text-align: left;
            vertical-align: top;
        }

        table.proposedWork td.description {
            width: 70%;
            text-wrap: stable;
        }

        table.proposedWork td.amountColumn,
        table.proposedWork th.amountColumn,
        table.proposedWork td:last-child,
        table.proposedWork th:last-child {
            text-align: center;
            vertical-align: top;
            white-space: nowrap;
        }

        .amount:before,
        .total:before {
            content: "Rp. ";
        }

        table.proposedWork tfoot td:first-child {
            border: none;
            text-align: right;
        }

        table.proposedWork tfoot tr:last-child td {
            font-size: 12px;
            font-weight: bold;
        }

        table.style1 tr td:last-child {
            width: 100%;
        }

        table.style1 td:last-child {
            text-align: left;
        }

        td.tdDelete {
            width: 1%;
        }

        table.coResponse td {
            text-align: left
        }

        table.shipToFrom td,
        table.shipToFrom th {
            text-align: left
        }

        .docEdit {
            border: 0 !important
        }

        .tableBorder td,
        .tableBorder th {
            border: 1px solid #000;
        }

        .tableBorder th,
        .tableBorder td {
            text-align: center
        }

        table.proposedWork td,
        table.proposedWork th {
            text-align: center
        }

        .ttd {
            width: 200px;
            vertical-align: bottom;
            text-align: center;
        }

        .balance {
            text-wrap: balance;
        }

        table.proposedWork td.description {
            text-align: left
        }
    </style>
</head>

<body>
    <header>
        <div class="container">
            <img class="logo" src="https://pt-kbm.com/wp-content/uploads/2024/10/logo.png" />
            <div class="content">
                <h1>
                    {{ $setting->nama }}
                </h1>
                <p>{{ $setting->alamat }}
                </p>
                <p>
                    Email:&emsp;
                    <a href="mailto:{{ $setting->email }}">
                        {{ $setting->email }}
                    </a>
                </p>
                <p>
                    Website:&emsp;<a href="{{ $setting->website }}">
                        {{ $setting->website }}
                    </a>
                </p>
                <p>Telepon : {{ $setting->telepon }}
                </p>
            </div>
        </div>
    </header>
    <hr style="border: #333  2px solid;">
    <div class="document active">
        <div class="spreadSheetGroup">

            <h3 style="font: bold italic 14px Tahoma, sans-serif;
            color: #000000;">Purchase Order
                #{{ $record->nomor_po }}</h3>
            <table class="shipToFrom">
                <thead style="font-weight:bold">
                    <tr>
                        <th>TO</th>
                        <th>SHIP TO</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td contenteditable="true" style="width:50%">
                            {{ $record->vendor->nama }}<br>
                            {{ $record->vendor->npwp }}
                            <br> Alamat :
                            {{ $record->vendor->alamat }} <br>
                            {{ $record->vendor->telepon }}<br>
                            UP : {{ $record->kontak->nama }} &#40;{{ $record->kontak->telepon }} &#41;


                        </td>
                        <td contenteditable="true" style="width:50%">
                            {{ $setting->nama }}<br>
                            {{ $setting->alamat_pengiriman }}<br />
                            {{ $setting->nama_penerima }}<br />
                            {{ $setting->nomor_telepon_penerima }}<br />
                        </td>
                    </tr>
                </tbody>
            </table>

            <hr style="visibility:hidden" />


            <table class="tableBorder">
                <thead style="font-weight:bold">
                    <tr>
                        <th>PAYMENT TERM</th>
                        <th>REFERENCE</th>
                        <th>SIDEMARK</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td contenteditable="true" style="width:33.3%">{{ $record->paymetTerm->nama }}</td>
                        <td contenteditable="true" style="width:33.3%">{{ $record->nomor_penawaran }}</td>
                        <td contenteditable="true" style="width:33.3%">{{ $record->pengganti_po }}</td>
                    </tr>
                </tbody>
            </table>



            <table class="proposedWork" width="100%" style="margin-top:10px">
                <thead>
                    <th>QTY</th>
                    <th>UNIT</th>
                    <th>DESCRIPTION</th>
                    <th>DISC. %</th>
                    <th>PPN %</th>
                    <th>PRICE</th>
                    <th class="amountColumn">TOTAL</th>
                </thead>
                <tbody>
                    @foreach ($record->items as $item)
                        <tr>
                            <td contenteditable="true">{{ $item->quantity }}</td>
                            <td class="unit" contenteditable="true">{{ $item->satuan->nama }}</td>
                            <td contenteditable="true" class="description balance">{{ $item->produk->nama }}</td>
                            <td style="text-align:center" class="balance">
                                {{ number_format($item->discount, 0, '.', ',') }} %</td>
                            <td style="text-align:center" class="balance">
                                {{ number_format($item->pajak->persentase, 0, '.', ',') }}</td>
                            <td class="amountColumn" contenteditable="true">
                                {{ number_format($item->price, 0, '.', ',') }}</td>
                            <td contenteditable="true" style="text-align:right">
                                {{ number_format($item->subtotal, 0, '.', ',') }}
                            </td>

                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td style="border:none"></td>
                        <td style="border:none"></td>
                        <td style="border:none"></td>
                        <td style="border:none"></td>
                        <td style="border:none"></td>
                        <td style="border:none;text-align:right">SUBTOTAL:</td>
                        <td style="text-align:right">{{ number_format($record->total_po, 0, '.', '.') }}</td>
                    </tr>
                    <tr>
                        <td style="border:none"></td>
                        <td style="border:none"></td>
                        <td style="border:none"></td>
                        <td style="border:none"></td>
                        <td style="border:none"></td>
                        <td style="border:none;text-align:right">TAX:</td>
                        <td contenteditable="true" style="text-align:right">
                            {{ number_format($record->ppn, 0, '.', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <td style="border:none"></td>
                        <td style="border:none"></td>
                        <td style="border:none"></td>
                        <td style="border:none"></td>
                        <td style="border:none"></td>
                        <td style="border:none;text-align:right;white-space:nowrap">SHIPPING & HANDLING:</td>
                        <td contenteditable="true" style="text-align:right">
                            {{ number_format($record->biaya_kirim, 0, '.', ',') }}</td>
                    </tr>
                    <tr>
                        <td style="border:none"></td>
                        <td style="border:none"></td>
                        <td style="border:none"></td>
                        <td style="border:none"></td>
                        <td style="border:none"></td>
                        <td style="border:none;text-align:right">TOTAL:</td>
                        <td class="total amount balance" contenteditable="true" style="text-align:right">
                            {{ number_format($record->total_bayar, 0, '.', ',') }}</td>
                    </tr>
                </tfoot>
            </table>



            <table width="100%">
                <tbody>
                    <tr>

                        <td style=" width:50%; vertical-align:top">
                            <table style="width:100%">
                                <tbody>
                                    <tr>
                                        <td style="text-align:left">
                                            <strong>NOTES !:</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td contenteditable="true" style="text-align:left;border: 1px solid #000">
                                            {!! html_entity_decode($record->note) !!}</td>
                                    </tr>
                                    {{-- <tr>
                                        <td style="text-align:left; padding-top:120px; font-size: small;">
                                            Authorized by: <u> {{$record->user->name}}</u>&emsp;   <br> Date :   <u>{{ date('d F Y') }}</u>
                                        </td>
                                    </tr> --}}
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="tableBorder" style="padding-top: 40px">
                <thead style="font-weight:bold">
                    <tr>
                        <th>Created By</th>
                        <th>Approved By</th>
                        <th>Vendor</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="ttd" style="width:33.3%; padding-top:50px;">{{ $record->user->name }}</td>
                        <td class="ttd" style="width:33.3%; padding-top:50px;">{{ $setting->nama_approver }}</td>
                        <td class="ttd" style="width:33.3%; padding-top:50px;">{{ $record->vendor->nama }}</td>
                    </tr>
                </tbody>
            </table>



        </div>
        <footer>

            <div id="footer">
                <hr style="border: #333  1px solid; padding-right:50px; ">

                <p>
                    website: {{ $setting->website }} email:{{ $setting->email }} telepon:{{ $setting->telepon }}
                    NPWP:{{ $setting->npwp }}
                </p>
            </div>
        </footer>
    </div>
</body>

</html>
