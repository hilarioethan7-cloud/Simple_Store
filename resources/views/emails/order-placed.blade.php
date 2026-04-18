<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmed</title>
    <style>
        body { font-family: sans-serif; background: #f9fafb; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 40px auto; background: white; border-radius: 12px; overflow: hidden; border: 1px solid #e5e7eb; }
        .header { background: #2563eb; padding: 32px; text-align: center; }
        .header h1 { color: white; margin: 0; font-size: 24px; }
        .header p { color: #bfdbfe; margin: 8px 0 0; font-size: 14px; }
        .body { padding: 32px; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px; }
        .info-box { background: #f9fafb; border-radius: 8px; padding: 16px; }
        .info-box p { margin: 0; font-size: 12px; color: #9ca3af; }
        .info-box span { font-weight: bold; color: #111827; font-size: 14px; }
        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
        .items-table th { text-align: left; font-size: 12px; color: #6b7280; padding: 8px 0; border-bottom: 1px solid #e5e7eb; }
        .items-table td { padding: 12px 0; font-size: 14px; border-bottom: 1px solid #f3f4f6; }
        .total-row { font-weight: bold; font-size: 16px; }
        .delivery { background: #f9fafb; border-radius: 8px; padding: 16px; margin-bottom: 24px; font-size: 14px; color: #4b5563; }
        .delivery h3 { margin: 0 0 12px; font-size: 14px; color: #111827; }
        .delivery p { margin: 4px 0; }
        .footer { text-align: center; padding: 24px; background: #f9fafb; font-size: 12px; color: #9ca3af; }
        .btn { display: inline-block; background: #2563eb; color: white; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-size: 14px; font-weight: bold; margin-bottom: 24px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎉 Order Confirmed!</h1>
            <p>Thank you for your purchase, {{ $order->name }}!</p>
        </div>

        <div class="body">
            <div class="info-grid">
                <div class="info-box">
                    <p>Order ID</p>
                    <span>#{{ $order->id }}</span>
                </div>
                <div class="info-box">
                    <p>Date</p>
                    <span>{{ $order->created_at->format('M j, Y') }}</span>
                </div>
                <div class="info-box">
                    <p>Status</p>
                    <span>{{ ucfirst($order->status) }}</span>
                </div>
                <div class="info-box">
                    <p>Total</p>
                    <span>₱{{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>

            <table class="items-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderItems as $item)
                        <tr>
                            <td>{{ $item->product->name ?? 'Product unavailable' }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>₱{{ number_format($item->price, 2) }}</td>
                            <td>₱{{ number_format($item->price * $item->quantity, 2) }}</td>
                        </tr>
                    @endforeach
                    <tr class="total-row">
                        <td colspan="3">Total</td>
                        <td>₱{{ number_format($order->total_amount, 2) }}</td>
                    </tr>
                </tbody>
            </table>

            <div class="delivery">
                <h3>Delivery Information</h3>
                <p><strong>Name:</strong> {{ $order->name }}</p>
                <p><strong>Email:</strong> {{ $order->email }}</p>
                <p><strong>Phone:</strong> {{ $order->phone }}</p>
                <p><strong>Address:</strong> {{ $order->address }}</p>
            </div>

            <div style="text-align: center;">
                <a href="{{ url('/orders/' . $order->id) }}" class="btn">View Order Details</a>
            </div>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Simple Store. All rights reserved.</p>
        </div>
    </div>
</body>
</html>