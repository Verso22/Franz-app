<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sales Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        h2 {
            margin-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>

<h2>Sales Report</h2>

@if($from || $to)
    <p>
        Period:
        {{ $from ?? '—' }} to {{ $to ?? '—' }}
    </p>
@endif

<p><strong>Total Revenue:</strong> {{ rupiah($totalRevenue) }}</p>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Date</th>
            <th>Customer</th>
            <th>Total</th>
            <th>Payment</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transactions as $i => $trx)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $trx->created_at->format('Y-m-d') }}</td>
                <td>{{ $trx->user->name ?? 'Unknown' }}</td>
                <td class="text-right">{{ rupiah($trx->total_amount) }}</td>
                <td>{{ strtoupper($trx->payment_method) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
