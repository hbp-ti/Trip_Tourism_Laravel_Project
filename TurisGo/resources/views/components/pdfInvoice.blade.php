<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&family=Roboto:wght@400;700&display=swap"
        rel="stylesheet"> <!-- Fontes Google -->
    <style>
        /* Reset de Estilos */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f4f6f9;
            color: #333;
            line-height: 1.6;
        }

        .invoice-container {
            max-width: 800px;
            margin: 30px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid #e0e0e0;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .logo {
            width: 120px;
            margin-bottom: 15px;
        }

        h1 {
            font-family: 'Roboto', sans-serif;
            font-size: 32px;
            color: #3b3a3a;
        }

        p {
            font-size: 14px;
            color: #777;
        }

        .details,
        .payment-method,
        .billing-details {
            margin-bottom: 25px;
        }

        .details h3,
        .payment-method h3,
        .billing-details h3 {
            font-size: 22px;
            color: #444;
            margin-bottom: 10px;
        }

        .bold {
            font-weight: 600;
            color: #555;
        }

        .items {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border-radius: 8px;
            overflow: hidden;
        }

        .items th,
        .items td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .items th {
            background-color: #f4f7fa;
            color: #333;
            font-weight: 600;
        }

        .items td {
            background-color: #fafafa;
            color: #666;
        }

        .items tr:last-child td {
            border-bottom: none;
        }

        .total {
            font-size: 20px;
            font-weight: 600;
            text-align: right;
            margin-top: 20px;
            color: #222;
            padding-top: 10px;
        }

        .payment-method,
        .billing-details {
            background-color: #f9f9f9;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .payment-method p,
        .billing-details p {
            font-size: 16px;
            margin-bottom: 8px;
        }

        .payment-method p span,
        .billing-details p span {
            font-weight: 700;
        }

        @media (max-width: 768px) {
            .invoice-container {
                width: 90%;
                padding: 20px;
            }

            h1 {
                font-size: 28px;
            }

            .items th,
            .items td {
                font-size: 14px;
            }

            .total {
                font-size: 18px;
            }
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <div class="header">
            <h1>Invoice</h1>
            <p>Date: {{ $date }}</p>
        </div>

        <div class="details">
            <h3>Order Details</h3>
            <p><span class="bold">Order ID:</span> {{ $order->id }}</p>
            <p><span class="bold">Customer Name:</span> {{ $order->user->first_name . ' ' . $order->user->last_name }}
            </p>
            <p><span class="bold">Email:</span> {{ $order->user->email }}</p>
        </div>

        <table class="items">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Type</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orderItems as $item)
                    <tr>
                        @if ($item->item->item_type === 'Ticket')
                            <td>{{ $item->details->name }}</td>
                            <td>{{ $item->item->item_type }}</td>
                            <td>{{ $item->train_people_count }}</td>
                            <td>${{ number_format($item->details->total_price, 2) }}</td>
                        @elseif($item->item->item_type === 'Activity')
                            <td>{{ $item->details->name }}</td>
                            <td>{{ $item->item->item_type }}</td>
                            <td>{{ $item->numb_people_activity }}</td>
                            <td>${{ number_format($item->details->total_price, 2) }}</td>
                        @elseif($item->item->item_type === 'Hotel')
                            <td>{{ $item->details->name }}</td>
                            <td>{{ $item->item->item_type }}</td>
                            <td>{{ $item->numb_people_hotel }}</td>
                            <td>${{ number_format($item->details->total_price, 2) }}</td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p class="total">Total: ${{ number_format($order->total, 2) }}</p>

        <div class="payment-method">
            <h3>Payment Method</h3>
            <p><span class="bold">Method:</span> {{ ucfirst($order->payment_method) }}</p>
        </div>

        <div class="billing-details">
            <h3>Billing Information</h3>
            <p><span class="bold">Billing Country:</span> {{ $order->billing_country }}</p>
            <p><span class="bold">Billing City:</span> {{ $order->billing_city }}</p>
            <p><span class="bold">Billing Address:</span> {{ $order->billing_address }}</p>
            <p><span class="bold">Postal Code:</span> {{ $order->billing_postal_code }}</p>
        </div>
    </div>
	<script>
	const appUrl = "{{ config('app.url') }}";
	</script>
</body>

</html>
