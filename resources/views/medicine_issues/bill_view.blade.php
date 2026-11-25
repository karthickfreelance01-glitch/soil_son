<!DOCTYPE html>
<html lang="ta">
<head>
    <meta charset="UTF-8">
    <title>Hospital Bill - {{ $bill->name }}</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f0f4f7; margin: 0; padding: 20px; color: #333; }
        .bill-container { max-width: 850px; margin: auto; background: #fff; padding: 40px; border-radius: 8px; border-top: 8px solid #2d6a4f; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }

        .bill-header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #eee; padding-bottom: 20px; margin-bottom: 25px; }
        .hospital-brand h1 { margin: 0; font-size: 24px; color: #2d6a4f; letter-spacing: 1px; }
        .hospital-brand p { margin: 2px 0; font-size: 13px; color: #555; line-height: 1.4; }
        
        .bill-info { display: flex; justify-content: space-between; margin-bottom: 30px; background: #f9fbf9; padding: 15px; border-radius: 5px; }
        .bill-info div p { margin: 5px 0; font-size: 14px; }
        .bill-info strong { width: 110px; display: inline-block; color: #2d6a4f; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 25px; }
        table th { background-color: #2d6a4f; color: #ffffff; padding: 12px; text-align: left; font-size: 14px; text-transform: uppercase; }
        table td { border-bottom: 1px solid #eee; padding: 12px; font-size: 14px; }
        table tbody tr:nth-child(even) { background-color: #fcfcfc; }

        .summary-wrapper { display: flex; justify-content: flex-end; }
        .totals { width: 250px; }
        .total-row { display: flex; justify-content: space-between; padding: 10px 0; border-top: 1px solid #eee; }
        .grand-total { font-size: 18px; color: #2d6a4f; border-top: 2px solid #2d6a4f; margin-top: 5px; padding-top: 10px; font-weight: bold; }

        .footer { text-align: center; margin-top: 40px; padding-top: 20px; border-top: 1px solid #eee; }
        .footer p { font-size: 13px; color: #666; margin: 5px 0; }
        .quote { font-style: italic; color: #2d6a4f; margin-top: 15px; font-weight: 500; display: block; }
        
        .print-btn { padding: 10px 25px; background-color: #2d6a4f; color: #fff; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; transition: 0.3s; }
        .print-btn:hover { background-color: #1b4332; }

        @media print {
            body { background: #fff; padding: 0; }
            .bill-container { box-shadow: none; border-radius: 0; max-width: 100%; padding: 20px; }
            .print-btn { display: none; }
        }
    </style>
</head>
<body>

<div class="bill-container">

    <div class="bill-header">
        <div class="hospital-brand">
            <h1>Soil Sons Welfare Foundation</h1>
            <p><strong>De-addiction & Psychiatric Care</strong></p>
            <p>No. 68/0, Ahimsapuram, Mela Street, Puthiyavisalam (Sivagami Street), Sellur, Madurai, Tamil Nadu 625002</p>
            <p>Phone: +91 74181 44991, 74181 44992, 0452 400 2111</p>
        </div>
        <div style="text-align: right;">
            <h2 style="color: #ccc; margin: 0; font-size: 32px;"><img src="{{asset('assets/uploads/sswf/favicon-256.png')}}" width="50"></h2>
        </div>
    </div>

    <div class="bill-info">
        <div>
            <p><strong>Bill No:</strong> #{{ $bill->bill_id }}</p>
            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($bill->issue_date)->format('d-M-Y') }}</p>
        </div>
        <div>
            <p><strong>Patient Name:</strong> {{ $bill->name }}</p>
            <p><strong>Reg No:</strong> {{ $bill->reg_no }}</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Medicine / Description</th>
                <th>Qty</th>
                <th>Price (₹)</th>
                <th>Total (₹)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($medicines as $index => $med)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $med->drug_name }}</td>
                <td>{{ $med->drug_count }}</td>
                <td>{{ number_format($med->price, 2) }}</td>
                <td>{{ number_format($med->price * $med->drug_count, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary-wrapper">
        <div class="totals">
            <div class="total-row grand-total">
                <span>Grand Total:</span>
                <span>₹{{ number_format($totalAmount, 2) }}</span>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>Thank you for trusting Brindhavan for your wellness journey.</p>
        <p class="no-print">
            <button class="print-btn" onclick="window.print()">Print Statement</button>
        </p>
        <span class="quote">“மனதை நன்றாகப் பழகுங்கள், பழக்கங்களை மாற்றுங்கள்; போதைவிலக்கல் உங்கள் வாழ்க்கையை மாற்றும்!”</span>
    </div>

</div>

</body>
</html>
