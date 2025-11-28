<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->order_number }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
            line-height: 1.6;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
            font-size: 16px;
            line-height: 24px;
            color: #555;
        }
        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }
        .invoice-box table td {
            padding: 5px;
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
            padding-bottom: 40px;
        }
        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }
        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.item td{
            border-bottom: 1px solid #eee;
        }
        .invoice-box table tr.item.last td {
            border-bottom: none;
        }
        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                LearnHub
                            </td>
                            <td>
                                Invoice #: {{ $order->order_number }}<br>
                                Created: {{ $order->created_at->format('F d, Y') }}<br>
                                Status: {{ ucfirst($order->status) }}
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
                                LearnHub LMS Inc.<br>
                                123 Education Street<br>
                                Knowledge City, 10001
                            </td>
                            <td>
                                {{ $order->user->name }}<br>
                                {{ $order->user->email }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="heading">
                <td>Payment Method</td>
                <td>Check #</td>
            </tr>
            
            <tr class="details">
                <td>{{ ucfirst($order->payment_method) }}</td>
                <td>{{ $order->transaction_id ?? 'N/A' }}</td>
            </tr>
            
            <tr class="heading">
                <td>Item</td>
                <td>Price</td>
            </tr>
            
            @foreach($order->items as $item)
            <tr class="item">
                <td>{{ $item->course->title }}</td>
                <td>${{ number_format($item->price, 2) }}</td>
            </tr>
            @endforeach
            
            <tr class="total">
                <td></td>
                <td>Total: ${{ number_format($order->total_amount, 2) }}</td>
            </tr>
        </table>
    </div>
</body>
</html>
