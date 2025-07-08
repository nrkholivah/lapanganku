<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title><?= $title ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }

        th {
            background-color: #f44336;
            color: white;
        }
    </style>
</head>

<body>
    <h2 style="text-align: center;"><?= $title ?></h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Pengguna</th>
                <th>Lapangan</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Total Harga</th>
                <th>Pembayaran</th>
                <th>Status Booking</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bookings as $b): ?>
                <tr>
                    <td><?= $b['id'] ?></td>
                    <td><?= $b['username'] ?></td>
                    <td><?= $b['lapangan_name'] ?></td>
                    <td><?= date('d-m-Y', strtotime($b['booking_date'])) ?></td>
                    <td><?= date('H:i', strtotime($b['start_time'])) ?> - <?= date('H:i', strtotime($b['end_time'])) ?></td>
                    <td>Rp<?= number_format($b['total_price'], 0, ',', '.') ?></td>
                    <td><?= ucfirst($b['payment_status']) ?></td>
                    <td><?= ucfirst($b['booking_status']) ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</body>

</html>