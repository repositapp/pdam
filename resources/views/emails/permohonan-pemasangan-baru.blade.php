<!DOCTYPE html>
<html>

<head>
    <title>Notifikasi Permohonan Pemasangan Air Baru</title>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .header {
            background-color: #007bff;
            color: white;
            padding: 10px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }

        .content {
            padding: 20px;
        }

        .footer {
            background-color: #f8f9fa;
            padding: 10px;
            text-align: center;
            font-size: 0.9em;
            border-top: 1px solid #ddd;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 15px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Notifikasi Sistem PDAM</h2>
        </div>
        <div class="content">
            <p><strong>Kepada Tim Admin PDAM,</strong></p>

            <p>Ada permohonan pemasangan air baru yang perlu diperhatikan:</p>

            <table width="100%" cellpadding="5">
                <tr>
                    <td><strong>Nama Pelanggan:</strong></td>
                    <td>{{ $pemasangan->pelanggan->nama_pelanggan }}</td>
                </tr>
                <tr>
                    <td><strong>Nomor Telepon:</strong></td>
                    <td>{{ $pemasangan->pelanggan->nomor_telepon }}</td>
                </tr>
                <tr>
                    <td><strong>Tanggal Permohonan:</strong></td>
                    <td>{{ \Carbon\Carbon::parse($pemasangan->tanggal_permohonan)->translatedFormat('d F Y') }}</td>
                </tr>
                <tr>
                    <td><strong>Tujuan Pemasangan:</strong></td>
                    <td>{{ $pemasangan->deskripsi }}</td>
                </tr>
                @if ($pemasangan->lokasi)
                    <tr>
                        <td><strong>Lokasi:</strong></td>
                        <td>
                            {{ $pemasangan->lokasi }}
                            <br>
                            <a href="https://www.google.com/maps?q={{ $pemasangan->lokasi }}" target="_blank">Lihat di
                                Google Maps</a>
                        </td>
                    </tr>
                @endif
                <tr>
                    <td><strong>Status Saat Ini:</strong></td>
                    <td>
                        @if ($pemasangan->status == 'pending')
                            <span style="color: #ffc107;">Pending</span>
                        @elseif($pemasangan->status == 'proses')
                            <span style="color: #17a2b8;">Proses</span>
                        @elseif($pemasangan->status == 'disetujui')
                            <span style="color: #28a745;">Disetujui</span>
                        @elseif($pemasangan->status == 'ditolak')
                            <span style="color: #dc3545;">Ditolak</span>
                        @endif
                    </td>
                </tr>
            </table>

            <p>Silakan login ke sistem admin untuk memproses permohonan ini.</p>

            <a href="{{ url('/admin/pemasangan/' . $pemasangan->id . '/edit') }}" class="btn">Lihat Detail
                Permohonan</a>
        </div>
        <div class="footer">
            <p>Email ini dikirim secara otomatis oleh Sistem PDAM. Mohon tidak membalas email ini.</p>
        </div>
    </div>
</body>

</html>
