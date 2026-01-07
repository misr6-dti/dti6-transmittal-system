<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Transmittal - {{ $transmittal->reference_number }}</title>
    <style>
        /* PDF Layout & Page Configuration */
        @page {
            size: A4 portrait;
            margin: 0.13in;
        }
        
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 9.5pt;
            color: #1a1a1a;
            margin: 0;
            padding: 0;
            line-height: 1.15;
            width: 100%;
        }

        /* Typography Hierarchy */
        h1, .heading-main {
            font-size: 15pt;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
            margin: 0;
            padding: 0;
        }

        .sub-heading {
            font-size: 11pt;
            font-weight: bold;
            color: #000;
            margin: 0;
        }

        .label-secondary {
            color: #666;
            font-size: 9.5pt;
            text-transform: uppercase;
            font-weight: normal;
        }

        /* Header Block (Target Height <= 40mm) */
        .header-block {
            text-align: center;
            height: 30mm;
            border-bottom: 1.5pt solid #000;
            margin-bottom: 2mm;
            display: block;
            position: relative;
        }
        .header-title {
            font-size: 13pt;
            font-weight: bold;
            margin-bottom: 0.5mm;
            text-align: center;
        }
        .header-sub {
            font-size: 9.5pt;
            margin-bottom: 0.5mm;
            text-align: center;
            color: #444;
        }

        /* Spacing & Dividers */
        .divider-line {
            height: 0.5pt;
            background-color: #999;
            margin: 2mm 0;
            width: 100%;
        }

        /* Origin/Destination Section (Target Height <= 55mm) */
        .section-node {
            width: 100%;
            /* height: 40mm; Removed fixed height to prevent clipping */
            margin-bottom: 2mm;
        }
        .node-table {
            width: 100%;
            border-collapse: collapse;
        }
        .node-table td {
            padding: 2.5mm 0;
            line-height: 1.2;
            vertical-align: top;
        }

        /* Main Table Guidelines */
        .content-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 4mm;
            table-layout: fixed;
        }
        .content-table th {
            background-color: #f8f9fa;
            border: 0.5pt solid #333;
            padding: 2.5mm;
            font-size: 9pt;
            text-align: center;
            text-transform: uppercase;
            font-weight: bold;
        }
        .content-table td {
            border: 0.5pt solid #333;
            padding: 2.5mm;
            font-size: 9pt;
            vertical-align: top;
            height: 11mm; /* Aggressive single page target */
        }

        /* Signature Blocks */
        .signature-section {
            width: 100%;
            margin-top: 4mm;
            page-break-inside: avoid;
        }
        .sign-table {
            width: 100%;
            border-collapse: collapse;
        }
        .sign-table td {
            width: 50%;
            vertical-align: top;
            padding-right: 10mm;
        }
        .sign-title {
            font-size: 9pt;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 8mm;
        }
        .sign-name-line {
            border-bottom: 0.75pt solid #000;
            height: 6mm;
            margin-bottom: 1mm;
        }
        .sign-label {
            text-align: center;
            font-size: 9pt;
            font-weight: normal;
            color: #1a1a1a;
        }
        .date-row {
            margin-top: 4mm;
            font-size: 8pt;
            font-weight: bold;
        }

        /* Instructions (Target 8-9pt) */
        .instructions-block {
            margin-top: 6mm;
            border-top: 0.75pt solid #999;
            padding-top: 3mm;
            page-break-inside: avoid;
        }
        .instructions-title {
            text-align: center;
            font-weight: bold;
            font-size: 9pt;
            margin-bottom: 2mm;
            text-transform: uppercase;
        }
        .instructions-list {
            font-size: 8pt;
            line-height: 1.1;
            margin: 0;
            padding-left: 4mm;
            color: #333;
        }
        .instructions-list li {
            margin-bottom: 1mm;
        }

        /* Footer Branding */
        .footer-branding {
            position: fixed;
            bottom: 0mm;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 8pt;
            color: #999;
            padding-top: 2mm;
            border-top: 0.5pt solid #eee;
        }
    </style>
</head>
<body>
    <div class="header-block">
        <div style="position: absolute; right: 0; top: 0; width: 28mm; height: 28mm;">
            <img src="{{ $qrcode }}" style="width: 100%; height: 100%;" alt="QR">
        </div>
        <div style="margin-top: 3mm;">
            <div class="header-title">
                @if($transmittal->senderOffice->type === 'Regional')
                    DTI - Regional Office 6
                @else
                    DTI - {{ str_ireplace('DTI ', '', $transmittal->senderOffice->name) }}
                @endif
            </div>
            <div class="header-sub">Region VI - Western Visayas</div>
            <div style="margin-top: 3mm; font-size: 8.5pt; color: #666; text-transform: uppercase;">
                Portal Validation ID: {{ $transmittal->reference_number }}
            </div>
        </div>
    </div>

    <div class="heading-main" style="margin-top: 1mm; margin-bottom: 2mm; text-align: center; font-size: 13pt;">TRANSMITTAL FORM</div>

    <div class="section-node">
        <table class="node-table">
            <tr>
                <td width="50%">
                    <div class="label-secondary">Originating Office</div>
                    <div class="sub-heading">{{ $transmittal->senderOffice->name }}</div>
                    <div style="margin-top: 2mm; margin-bottom: 6mm;">
                        <span class="label-secondary" style="margin-right: 4px;">Reference No:</span> <strong>{{ $transmittal->reference_number }}</strong>
                    </div>
                </td>
                <td width="50%" style="text-align: right;">
                    <div class="label-secondary">Destination Office</div>
                    <div class="sub-heading">{{ $transmittal->receiverOffice->name }}</div>
                    <div style="margin-top: 2mm; margin-bottom: 6mm;">
                        <span class="label-secondary">Transmission Date:</span> <strong>{{ \Carbon\Carbon::parse($transmittal->transmittal_date)->format('F d, Y') }}</strong>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="divider-line"></div>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="label-secondary">Form Status:</span> 
                    <strong style="color: #1e40af;">{{ strtoupper($transmittal->status) }}</strong>
                </td>
                <td style="text-align: right;">
                    <span class="label-secondary">Sender Unit:</span> {{ $transmittal->senderOffice->code }}
                </td>
            </tr>
        </table>
    </div>

    <table class="content-table" style="margin-top: 4mm;">
        <thead>
            <tr>
                <th width="10%">Qty</th>
                <th width="12%">Unit</th>
                <th width="53%">Description / Particulars</th>
                <th width="25%">Remarks</th>
            </tr>
        </thead>
        <tbody>
            @php
                $items = $transmittal->items->values();
                $rowCount = max(10, count($items));
            @endphp
            @for ($i = 0; $i < $rowCount; $i++)
                <tr>
                    @if (isset($items[$i]))
                        <td style="text-align: center; font-weight: bold;">{{ $items[$i]->quantity }}</td>
                        <td style="text-align: center;">{{ $items[$i]->unit }}</td>
                        <td>{{ $items[$i]->description }}</td>
                        <td style="font-style: italic; color: #666;">{{ $items[$i]->remarks }}</td>
                    @else
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    @endif
                </tr>
            @endfor
        </tbody>
    </table>

    @if($transmittal->remarks)
    <div style="text-align: left; margin-top: 2mm; margin-bottom: 2mm;">
        <span class="label-secondary" style="font-size: 8pt; font-weight: bold;">EXECUTIVE REMARKS:</span>
        <span style="font-size: 8pt; color: #1a1a1a; margin-left: 2mm;">{{ $transmittal->remarks }}</span>
    </div>
    @endif

    <div class="signature-section" style="margin-top: 2mm;">
        <table class="sign-table">
            <tr>
                <td>
                    <div class="sign-title">For Transmitting Office:</div>
                    <div style="font-size: 9pt; margin-bottom: 3mm; visibility: hidden;">&nbsp;</div>
                    <div class="sign-name-line"></div>
                    <div class="sign-label">Name / Signature</div>
                    <div class="date-row">
                        Date: {{ \Carbon\Carbon::parse($transmittal->transmittal_date)->format('M d, Y') }}
                    </div>
                </td>
                <td>
                    <div class="sign-title">For Receiving Office:</div>
                    <div style="font-size: 9pt; margin-bottom: 3mm; color: #666;">Received by:</div>
                    <div class="sign-name-line"></div>
                    <div class="sign-label">Name / Signature</div>
                    <div class="date-row">
                        Date: {{ $transmittal->received_at ? \Carbon\Carbon::parse($transmittal->received_at)->format('M d, Y') : '________________' }}
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="instructions-block">
        <div class="instructions-title">Standard Operating Instructions</div>
        <ol class="instructions-list">
            <li>Prepare the transmittal in triplicate. Retain the third copy for your records.</li>
            <li>Send the original and duplicate together with the materials to the receiving office.</li>
            <li>Request the receiving office to sign and return the duplicate.</li>
            <li>Log the transmittal in the TMS-R6 Portal immediately after sending.</li>
            <li>Monitor the status in the system to track submission and receiving confirmation.</li>
            <li>Once the signed duplicate is returned, update the digital record to complete the workflow.</li>
        </ol>
    </div>

    <div class="footer-branding">
        Official DTI Region VI Institutional Record | TMS-R6 Digital Portal | Page 1 of 1
    </div>
</body>
</html>
