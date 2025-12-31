<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->order_number }} | Oweru Hardware</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Inter', 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #333;
            background: white;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
        }
        .header {
            border-bottom: 3px solid #002147;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        .company-info h1 {
            font-size: 28px;
            font-weight: 800;
            color: #002147;
            margin-bottom: 5px;
        }
        .company-info p {
            font-size: 11px;
            color: #666;
            margin: 2px 0;
        }
        .invoice-info {
            text-align: right;
        }
        .invoice-info h2 {
            font-size: 24px;
            font-weight: 700;
            color: #333;
            margin-bottom: 10px;
        }
        .invoice-info p {
            font-size: 11px;
            color: #666;
            margin: 3px 0;
        }
        .bill-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .bill-box {
            width: 48%;
        }
        .bill-box h3 {
            font-size: 14px;
            font-weight: 700;
            color: #333;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        .bill-box p {
            font-size: 11px;
            color: #333;
            margin: 4px 0;
            line-height: 1.5;
        }
        .bill-box .bold {
            font-weight: 600;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        thead {
            background-color: #f8f9fa;
        }
        th {
            padding: 12px 10px;
            text-align: left;
            font-size: 11px;
            font-weight: 700;
            color: #333;
            border: 1px solid #ddd;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        td {
            padding: 10px;
            font-size: 11px;
            color: #333;
            border: 1px solid #ddd;
        }
        tbody tr:nth-child(even) {
            background-color: #fafafa;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .totals {
            width: 100%;
            max-width: 300px;
            margin-left: auto;
            margin-bottom: 30px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 11px;
            color: #333;
        }
        .total-row.total {
            border-top: 2px solid #333;
            margin-top: 10px;
            padding-top: 15px;
            font-size: 16px;
            font-weight: 700;
            color: #002147;
        }
        .footer {
            border-top: 2px solid #ddd;
            padding-top: 20px;
            text-align: center;
            margin-top: 40px;
        }
        .footer p {
            font-size: 11px;
            color: #666;
            margin: 5px 0;
        }
        .footer .bold {
            font-weight: 600;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">

        <!-- Invoice Header -->
        <div class="header">
            <div class="header-row">
                <div class="company-info">
                    <h1>Oweru Hardware</h1>
                    <p>Building Materials Supplier</p>
                    <p>Tanzania</p>
                    <p>Tel: +255 616 012 915</p>
                </div>
                <div class="invoice-info">
                    <h2>INVOICE</h2>
                    <p><strong>Invoice #:</strong> {{ $order->order_number }}</p>
                    <p><strong>Date:</strong> {{ $order->created_at->format('F d, Y') }}</p>
                    <p><strong>Order Date:</strong> {{ $order->created_at->format('F d, Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Bill To Section -->
        <div class="bill-section" >
            <div class="bill-box">
                <h3>Bill To:</h3>
                <p class="bold">{{ $order->customer_name }}</p>
                <p>{{ $order->customer_email }}</p>
                <p>{{ $order->customer_phone }}</p>
                <p style="margin-top: 10px;">{{ $order->shipping_address }}</p>
            </div>
            <div class="bill-box">
                <h3>Order Information:</h3>
                <p><span class="bold">Order Number:</span> {{ $order->order_number }}</p>
                <p><span class="bold">Order Status:</span> {{ ucwords(str_replace('_', ' ', $order->status)) }}</p>
                <p><span class="bold">Payment Method:</span> {{ ucwords(str_replace('_', ' ', $order->payment_method)) }}</p>
                <p><span class="bold">Payment Status:</span> {{ ucfirst($order->payment_status) }}</p>
                @if($order->paid_at)
                <p><span class="bold">Paid At:</span> {{ $order->paid_at->format('F d, Y') }}</p>
                @endif
            </div>
        </div>

        <!-- Items Table -->
        <table>
            <thead>
                <tr>
                    <th style="width: 50%;">Item Description</th>
                    <th class="text-center" style="width: 15%;">Quantity</th>
                    <th class="text-right" style="width: 17.5%;">Unit Price</th>
                    <th class="text-right" style="width: 17.5%;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $item)
                <tr>
                    <td>{{ $item->product_name }}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-right">TZS {{ number_format($item->price, 0) }}</td>
                    <td class="text-right"><strong>TZS {{ number_format($item->subtotal, 0) }}</strong></td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals -->
        <div class="totals">
            <div class="total-row">
                <span>Subtotal:</span>
                <span>TZS {{ number_format($order->subtotal ?? ($order->total_amount - ($order->delivery_fee ?? 25000) - ($order->vat_amount ?? 0)), 0) }}</span>
            </div>
            <div class="total-row">
                <span>Delivery Fee:</span>
                <span>TZS {{ number_format($order->delivery_fee ?? 25000, 0) }}</span>
            </div>
            @if($order->vat_amount)
            <div class="total-row">
                <span>VAT (18%):</span>
                <span>TZS {{ number_format($order->vat_amount, 0) }}</span>
            </div>
            @endif
            <div class="total-row total">
                <span>Total Amount:</span>
                <span>TZS {{ number_format($order->total_amount, 0) }}</span>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p class="bold">Thank you for your business!</p>
            <p>Oweru Hardware - Tanzania's Premier Building Materials Supplier</p>
            <p>For inquiries, contact us at: <strong>+255 616 012 915</strong></p>
            <p style="margin-top: 15px; font-size: 10px; color: #999;">This is a computer-generated invoice and does not require a signature.</p>
        </div>
    </div>
</body>
</html>
