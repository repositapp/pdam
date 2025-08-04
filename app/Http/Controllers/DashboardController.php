<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\Pemasangan;
use App\Models\Pemutusan;
use App\Models\Pengaduan;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->role == 'admin') {

            // Hitung jumlah data untuk setiap kategori
            $jumlahPelanggan = Pelanggan::count();
            $jumlahTagihan = Tagihan::count();
            $jumlahPengaduan = Pengaduan::count();
            $jumlahPemasangan = Pemasangan::count();
            $jumlahPemutusan = Pemutusan::count();

            // Hitung jumlah tagihan yang belum lunas
            $jumlahTagihanBelumLunas = Tagihan::where('status_pembayaran', false)->count();

            // Hitung jumlah pengaduan yang belum selesai
            $jumlahPengaduanPending = Pengaduan::where('status', 'pending')->count();
            $jumlahPengaduanProses = Pengaduan::where('status', 'proses')->count();

            // Hitung jumlah permohonan pemasangan berdasarkan status
            $jumlahPemasanganPending = Pemasangan::where('status', 'pending')->count();
            $jumlahPemasanganProses = Pemasangan::where('status', 'proses')->count();
            $jumlahPemasanganDisetujui = Pemasangan::where('status', 'disetujui')->count();
            $jumlahPemasanganDitolak = Pemasangan::where('status', 'ditolak')->count();

            // Hitung jumlah permohonan pemutusan berdasarkan status
            $jumlahPemutusanPending = Pemutusan::where('status', 'pending')->count();
            $jumlahPemutusanProses = Pemutusan::where('status', 'proses')->count();
            $jumlahPemutusanDisetujui = Pemutusan::where('status', 'disetujui')->count();
            $jumlahPemutusanDitolak = Pemutusan::where('status', 'ditolak')->count();

            // Data untuk chart (contoh: 6 bulan terakhir)
            $dataChart = $this->getDataForChart();

            // === TAMBAHKAN BAGIAN INI ===
            // Ambil 5 permohonan pemasangan terbaru
            $permohonanPemasanganTerbaru = Pemasangan::with('pelanggan')
                ->latest()
                ->limit(5)
                ->get();
            // === AKHIR TAMBAHAN ===

            return view('dashboard.index', compact(
                'jumlahPelanggan',
                'jumlahTagihan',
                'jumlahPengaduan',
                'jumlahPemasangan',
                'jumlahPemutusan',
                'jumlahTagihanBelumLunas',
                'jumlahPengaduanPending',
                'jumlahPengaduanProses',
                'jumlahPemasanganPending',
                'jumlahPemasanganProses',
                'jumlahPemasanganDisetujui',
                'jumlahPemasanganDitolak',
                'jumlahPemutusanPending',
                'jumlahPemutusanProses',
                'jumlahPemutusanDisetujui',
                'jumlahPemutusanDitolak',
                'dataChart',
                // === TAMBAHKAN BAGIAN INI JUGA ===
                'permohonanPemasanganTerbaru'
                // === AKHIR TAMBAHAN ===
            ));
        } elseif (Auth::user()->role == 'pelanggan') {
            $pelanggan_id = session('pelanggan_id');

            // Ambil data tagihan terbaru untuk pelanggan ini
            $tagihanTerbaru = Tagihan::where('pelanggan_id', $pelanggan_id)
                ->latest('periode') // Urutkan berdasarkan periode terbaru
                ->first();

            // Ambil beberapa tagihan terakhir (misal 3) untuk ditampilkan di tabel
            $tagihanTerakhir = Tagihan::where('pelanggan_id', $pelanggan_id)
                ->latest('periode')
                ->limit(3)
                ->get();

            // Hitung jumlah tagihan yang belum lunas
            $jumlahTagihanBelumLunas = Tagihan::where('pelanggan_id', $pelanggan_id)
                ->where('status_pembayaran', false)
                ->count();

            // Ambil data pengaduan terbaru
            $pengaduanTerbaru = Pengaduan::where('pelanggan_id', $pelanggan_id)
                ->latest()
                ->first();

            // Hitung jumlah pengaduan yang belum selesai
            $jumlahPengaduanPending = Pengaduan::where('pelanggan_id', $pelanggan_id)
                ->where('status', 'pending')
                ->count();
            $jumlahPengaduanProses = Pengaduan::where('pelanggan_id', $pelanggan_id)
                ->where('status', 'proses')
                ->count();

            // Ambil data permohonan pemasangan terbaru
            $pemasanganTerbaru = Pemasangan::where('pelanggan_id', $pelanggan_id)
                ->latest()
                ->first();

            // Hitung jumlah permohonan pemasangan
            $jumlahPemasangan = Pemasangan::where('pelanggan_id', $pelanggan_id)
                ->count();

            // Ambil data permohonan pemutusan terbaru
            $pemutusanTerbaru = Pemutusan::where('pelanggan_id', $pelanggan_id)
                ->latest()
                ->first();

            // Hitung jumlah permohonan pemutusan
            $jumlahPemutusan = Pemutusan::where('pelanggan_id', $pelanggan_id)
                ->count();

            return view('dashboard.index', compact(
                'tagihanTerbaru',
                'tagihanTerakhir',
                'jumlahTagihanBelumLunas',
                'pengaduanTerbaru',
                'jumlahPengaduanPending',
                'jumlahPengaduanProses',
                'pemasanganTerbaru',
                'jumlahPemasangan',
                'pemutusanTerbaru',
                'jumlahPemutusan'
            ));
        }
    }

    private function getDataForChart()
    {
        $bulan = [];
        $dataPemasangan = [];
        $dataPemutusan = [];
        $dataPengaduan = [];

        // Ambil data untuk 6 bulan terakhir
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $bulan[] = $date->format('M Y'); // Nama bulan dan tahun

            // Hitung jumlah pemasangan per bulan
            $countPemasangan = Pemasangan::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $dataPemasangan[] = $countPemasangan;

            // Hitung jumlah pemutusan per bulan
            $countPemutusan = Pemutusan::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $dataPemutusan[] = $countPemutusan;

            // Hitung jumlah pengaduan per bulan
            $countPengaduan = Pengaduan::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $dataPengaduan[] = $countPengaduan;
        }

        return [
            'labels' => $bulan,
            'datasets' => [
                [
                    'label' => 'Pemasangan',
                    'data' => $dataPemasangan,
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'borderWidth' => 1
                ],
                [
                    'label' => 'Pemutusan',
                    'data' => $dataPemutusan,
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                    'borderWidth' => 1
                ],
                [
                    'label' => 'Pengaduan',
                    'data' => $dataPengaduan,
                    'backgroundColor' => 'rgba(255, 206, 86, 0.2)',
                    'borderColor' => 'rgba(255, 206, 86, 1)',
                    'borderWidth' => 1
                ]
            ]
        ];
    }
}
