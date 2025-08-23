<!DOCTYPE html>
<html>

<head>
    <title>Update Status Permohonan Pemasangan Air</title>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
        }

        .header {
            background-color: #f8f9fa;
            padding: 10px;
            text-align: center;
        }

        .content {
            padding: 20px 0;
        }

        .footer {
            background-color: #f8f9fa;
            padding: 10px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .status-pending {
            color: orange;
        }

        .status-proses {
            color: blue;
        }

        .status-disetujui {
            color: green;
        }

        .status-ditolak {
            color: red;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>{{ config('app.name') }}</h2>
            <p>Update Status Permohonan Pemasangan Air</p>
        </div>
        <div class="content">
            <p><strong>Kepada Yth. {{ $pemasangan->pelanggan->nama_pelanggan }},</strong></p>

            <p>Status permohonan pemasangan air Anda telah diperbarui.</p>

            <p><strong>Detail Permohonan:</strong></p>
            <ul>
                <li><strong>ID Permohonan:</strong> {{ $pemasangan->id }}</li>
                <li><strong>Nama Pelanggan:</strong> {{ $pemasangan->pelanggan->nama_pelanggan }}</li>
                <li><strong>Tanggal Permohonan:</strong>
                    {{ \Carbon\Carbon::parse($pemasangan->tanggal_permohonan)->translatedFormat('d F Y') }}</li>
                <li><strong>Tujuan Pemasangan:</strong> {{ $pemasangan->deskripsi }}</li>
                <li><strong>Status Sebelumnya:</strong>
                    @if ($statusLama == 'pending')
                        <span class="status-pending">Pending</span>
                    @elseif($statusLama == 'proses')
                        <span class="status-proses">Proses</span>
                    @elseif($statusLama == 'disetujui')
                        <span class="status-disetujui">Disetujui</span>
                    @elseif($statusLama == 'ditolak')
                        <span class="status-ditolak">Ditolak</span>
                    @else
                        {{ $statusLama }}
                    @endif
                </li>
                <li><strong>Status Baru:</strong>
                    @if ($statusBaru == 'pending')
                        <span class="status-pending">Pending</span>
                    @elseif($statusBaru == 'proses')
                        <span class="status-proses">Proses</span>
                    @elseif($statusBaru == 'disetujui')
                        <span class="status-disetujui">Disetujui</span>
                    @elseif($statusBaru == 'ditolak')
                        <span class="status-ditolak">Ditolak</span>
                    @else
                        {{ $statusBaru }}
                    @endif
                </li>
            </ul>

            @if ($statusBaru == 'disetujui')
                <p><strong>Selamat!</strong> Permohonan pemasangan air Anda telah <span
                        class="status-disetujui"><strong>Disetujui</strong></span>.</p>
                @if ($pemasangan->tanggal_penelitian)
                    <p><strong>Tanggal Survei:</strong>
                        {{ \Carbon\Carbon::parse($pemasangan->tanggal_penelitian)->translatedFormat('d F Y') }}</p>
                @endif
                @if ($pemasangan->tanggal_bayar)
                    <p><strong>Tanggal Pembayaran:</strong>
                        {{ \Carbon\Carbon::parse($pemasangan->tanggal_bayar)->translatedFormat('d F Y') }}</p>
                @endif
                @if ($pemasangan->spk_nomor)
                    <p><strong>SPK Nomor:</strong> {{ $pemasangan->spk_nomor }}</p>
                @endif
                @if ($pemasangan->spk_tanggal)
                    <p><strong>SPK Tanggal:</strong>
                        {{ \Carbon\Carbon::parse($pemasangan->spk_tanggal)->translatedFormat('d F Y') }}</p>
                @endif
                @if ($pemasangan->ba_nomor)
                    <p><strong>B.A Nomor:</strong> {{ $pemasangan->ba_nomor }}</p>
                @endif
                @if ($pemasangan->ba_tanggal)
                    <p><strong>B.A Tanggal:</strong>
                        {{ \Carbon\Carbon::parse($pemasangan->ba_tanggal)->translatedFormat('d F Y') }}</p>
                @endif
                @if ($pemasangan->merek_meteran)
                    <p><strong>Merek Meteran:</strong> {{ $pemasangan->merek_meteran }}</p>
                @endif
                <p>Tim teknis kami akan segera menghubungi Anda untuk proses selanjutnya.</p>
            @elseif($statusBaru == 'ditolak')
                <p><strong>Mohon Maaf,</strong> Permohonan pemasangan air Anda <span
                        class="status-ditolak"><strong>Ditolak</strong></span>.</p>
                @if ($pemasangan->alasan_ditolak)
                    <p><strong>Alasan Penolakan:</strong> {{ $pemasangan->alasan_ditolak }}</p>
                @endif
                <p>Jika Anda memiliki pertanyaan, silakan hubungi layanan pelanggan kami.</p>
            @elseif($statusBaru == 'proses')
                <p>Permohonan Anda sedang dalam tahap <span class="status-proses"><strong>Proses</strong></span>. Tim
                    kami sedang meninjau permohonan Anda.</p>
            @endif

            <p>Terima kasih atas kepercayaan Anda kepada {{ config('app.name') }}.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
