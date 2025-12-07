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
        }
        .header { text-align: center; margin-bottom: 20px; position: relative; }
        .logo { width: 90px; position: absolute; left: 0; top: 0; }
        .title { font-size: 28px; font-weight: bold; margin: 15px 0 10px; }
        .subtitle { font-size: 20px; font-weight: bold; }
        .address { font-size: 17px; line-height: 1.6; margin: 12px 0; }
        .receipt-no { text-align: right; font-size: 19px; font-weight: bold; margin: 20px 0; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            font-size: 19px;
        }
        table, th, td { border: 2px solid black; }
        th {
            width: 40px;
            text-align: center;
            padding: 12px 8px;
            background: #f0f0f0;
        }
        td { padding: 14px 12px; }
        .amount-row td { font-weight: bold; }
        .signature {
            margin-top: 80px;
            text-align: right;
            font-size: 18px;
            font-weight: bold;
            line-height: 1.8;
        }
        @media print {
            body { -webkit-print-color-adjust: exact; padding: 0; }
            .receipt { border: 3px solid #000; }
            @page { margin: 0.4cm; }
        }
    </style>
</head>
<body onload="window.print()">

<div class="receipt">

    <div class="header">
        {{-- <img src="{{ asset($logo) }}" alt="UDC Logo" width="10" class="logo"> --}}

        <div class="title">ভূমিসেবা সহায়তা প্রদান বাবদ ফি গ্রহণের রশিদ</div>
        <div class="subtitle">
            সহায়তা কেন্দ্রের নাম : {{ $receiver->center_name ?? 'এ.বি.এস এন্টারপ্রাইজ এন্ড অনলাইন অ্যাপ্লিকেশন সেন্টার' }}
        </div>
        <div class="address">
            {{ $receiver->center_address ?? 'আমলাপাড়া (উপজেলা ভূমি অফিস সংলগ্ন) জামালপুর সদর, জামালপুর।' }}<br>
            মোবাইল: {{ $receiver->center_mobile ?? '০১৭১৮-৯৯২৭১, ০১৮৬১-২৩৫২৯' }}<br>
            ফোন নং {{ $receiver->center_phone ?? '+৮৮ ০২ ৯৯৬৬২৩১২' }}
        </div>
        
        <div style="font-size: 19px; font-weight: bold; margin: 20px 0;">
            সহায়তাকারীর নাম: {{ $receiver->helper->name }}
        </div>
    </div>

    <div class="receipt-no">
        রশিদ নম্বর {{ $receiver->receipt_no }}
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
        <tr class="amount-row">
            <th>৩।</th>
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

</body>
</html>