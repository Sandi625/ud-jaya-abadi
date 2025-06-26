<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Riwayat Medis & Special Request</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f5f7fa;
      margin: 0;
      padding: 20px;
    }

    .container {
      max-width: 800px;
      margin: auto;
      background-color: #ffffff;
      padding: 20px 30px;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
      text-align: center;
      margin-bottom: 30px;
    }

    .info {
      font-size: 16px;
      margin-bottom: 20px;
      font-weight: bold;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      table-layout: fixed;
    }

    th, td {
      border: 1px solid #ccc;
      padding: 12px;
      text-align: left;
      vertical-align: top;
      word-wrap: break-word;
      white-space: pre-wrap;
    }

    th {
      background-color: #f0f0f0;
      width: 20%;
    }

    .back-link {
      display: block;
      text-align: right;
      margin-top: 20px;
      text-decoration: none;
      color: #007bff;
      font-weight: bold;
    }

    .back-link:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<div class="container">
  <h2>Riwayat Medis & Special Request</h2>

  <div class="info">Pesanan: {{ $pesanan->nama }}</div>

  <table>
    <tr>
      <th>Riwayat Medis</th>
      <td>{{ $pesanan->riwayat_medis ?? '-' }}</td>
    </tr>
    <tr>
      <th>Special Request</th>
      <td>{{ $pesanan->special_request ?? '-' }}</td>
    </tr>
  </table>

  <a href="{{ route('halamanguide.index') }}" class="back-link">Kembali ke Daftar Pesanan</a>
</div>

</body>
</html>
