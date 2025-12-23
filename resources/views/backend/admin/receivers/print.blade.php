<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>ভূমিসেবা সহায়তা প্রদান বাবদ ফি গ্রহণের রশিদ</title>

    <style>
        body {
            font-family: 'SolaimanLipi', 'Kalpurush', 'Siyam Rupali', sans-serif !important;
            margin: 0;
            padding: 15px;
            background: white;
        }
        .receipt {
            width: 21cm;
            min-height: 29.7cm;
            margin: 0 auto;
            background: white;
            padding: 30px 40px;
            border: 3px solid #000;
            box-sizing: border-box;
            position: relative;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            position: relative;
            padding-top: 20px;
        }

        .logo {
            width: 100px;     
            position: absolute;
            left: -10px;    
            top: 70px;      
        }

        .title {
            font-size: 24px;     
            font-weight: bold;
            margin: 8px 0 4px;
        }
        .subtitle {
            font-size: 18px;      
            font-weight: bold;
            margin-top: 4px;
        }
        .address {
            font-size: 15.5px;     
            line-height: 1.5;
            margin: 12px 0;
        }
        .helper-name {
            font-size: 17px;     
            font-weight: bold;
            margin-top: 12px;
        }

        .receipt-no {
            text-align: right;
            font-size: 19px;
            font-weight: bold;
            margin: 20px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            font-size: 19px;
        }
        table, th, td {
            border: 2px solid black;
        }
        th {
            width: 40px;
            text-align: center;
            padding: 12px 8px;
            background: #f0f0f0;
        }
        td {
            padding: 14px 12px;
        }
        .amount-row td {
            font-weight: bold;
        }
        .signature {
            margin-top: 80px;
            text-align: right;
            font-size: 18px;
            font-weight: bold;
            line-height: 1.8;
        }

        @media print {
            body {
                -webkit-print-color-adjust: exact;
                padding: 0;
            }
            .receipt {
                border: 3px solid #000;
            }
            @page {
                margin: 0.4cm;
            }
        }
    </style>
</head>

<body onload="window.print()">

<div class="receipt">

    <div class="header">
        @php
            $logo = App\Models\SystemSetting::pluck('logo')->first();
            $email = App\Models\SystemSetting::pluck('email')->first();
            $phone = App\Models\SystemSetting::pluck('system_name')->first();
        @endphp

        <img src="{{ asset($logo) }}" class="logo" alt="UDC Logo">

        <div class="title">ভূমিসেবা সহায়তা প্রদান বাবদ ফি গ্রহণের রশিদ</div>

        <div class="subtitle">
            সহায়তা কেন্দ্রের নাম :
            {{ $receiver->center_name ?? 'এ.বি.এস এক্সপ্রেস এন্ড অনলাইন অ্যাপ্লিকেশন সেন্টার' }}
        </div>

        <div class="address">
            {{ $receiver->center_address ?? 'আমলাপাড়া (উপজেলা ভূমি অফিস সংলগ্ন) জামালপুর সদর, জামালপুর।' }}<br>
            মোবাইল: {{ $receiver->center_mobile ?? '০১৭৭৮-৯৯৯২৭৭, ০১৫৮১-৫৩৫২২৯' }}<br>
            ফোন নং {{ $phone ?? '+৮৮ ০২ ৯৯৮৮২৩১৩২' }}<br>
            ই-মেইল {{ $email ?? 'abs.jamalpur.bd@gmail.com' }}
        </div>

        <div class="helper-name">
            সহায়তাকারীর নাম: {{ $receiver->helper->name }}
        </div>
    </div>


    {{-- BARCODE + RECEIPT NO IN SAME ROW --}}
    <div class="barcode-row" style="display: flex; justify-content: space-between; align-items: center; margin: 25px 0;">

        <div style="flex: 1; text-align: left;">
            <svg id="barcode"></svg>
        </div>

        <div style="flex: 1; text-align: right; font-size: 19px; font-weight: bold;">
            রশিদ নম্বর: {{ $receiver->receipt_no }}
        </div>

    </div>


    <table>
        <tr>
            <th>১।</th>
            <td><strong>সেবা গ্রহীতার নাম</strong></td>
            <td>{{ $receiver->receiver_name }}</td>
        </tr>

        <tr>
            <th>২।</th>
            <td><strong>ভূমিসেবার নাম</strong></td>
            <td>{{ $receiver->category?->name ?? $receiver->service_name }}</td>
        </tr>

        <tr>
            <th>৩।</th>
            <td><strong> মৌজার নাম</strong></td>
            <td>{{ $receiver->mouza_name }}</td>
        </tr>

        <tr>
            <th>৪।</th>
            <td><strong>খতিয়ান/ট্রেকিং নম্বর </strong></td>
            <td>{{ $receiver->khatian_no }}</td>
        </tr>

        <tr class="amount-row">
            <th>৫।</th>
            <td><strong>গৃহীত ফি (অনলাইন ও প্রসেসিং চার্জ)</strong></td>
            <td>
                প্রসেসিং চার্জ: {{ $receiver->processing_charge }} টাকা + 
                অনলাইন চার্জ: {{ $receiver->online_charge }} টাকা = 
                মোট {{ $receiver->total_charge }} টাকা
            </td>
        </tr>
    </table>

    <div class="signature">
        {{ $receiver->entrepreneur_name ?? 'মোঃ আবু বকর সিদ্দিক' }}<br>
        কেন্দ্র ইনচার্জ<br>
        ভূমিসেবা সহায়তা কেন্দ্র
    </div>

</div>

{{-- BARCODE SCRIPT --}}
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        JsBarcode("#barcode", "{{ $receiver->receipt_no }}", {
            format: "CODE128",
            width: 1,
            height: 20,
            displayValue: true,
            fontSize: 16
        });
    });
</script>

</body>
</html>
