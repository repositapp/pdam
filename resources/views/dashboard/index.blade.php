@extends('layouts.master')
@section('title')
    Dashboard
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Dashboard
        @endslot
        @slot('li_2')
            Halaman Utama
        @endslot
        @slot('title')
            Dashboard
        @endslot
    @endcomponent

    <section class="content">
        <div class="callout callout-info">
            <h4>Selamat Datang <span class="text-info">{{ session('nama') }}</span></h4>

            <p>Anda Sedang Mengakses Sistem Informasi
                {{ $aplikasi->nama_lembaga }}.
                Anda Login
                Sebagai <span class="badge bg-aqua"><i class="fa fa-user" style="margin-right: 5px;"></i>
                    @if (Auth::user()->role == 'admin')
                        Administrator
                    @elseif (Auth::user()->role == 'pelanggan')
                        Pelanggan
                    @endif
                </span></p>
        </div>

        @if (Auth::user()->role == 'admin')
            <!-- Info boxes -->
            <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua"><i class="fa fa-users"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Pelanggan</span>
                            <span class="info-box-number">{{ number_format($jumlahPelanggan, 0, ',', '.') }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-green"><i class="fa fa-file-text"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Tagihan</span>
                            <span class="info-box-number">{{ number_format($jumlahTagihan, 0, ',', '.') }}</span>
                            <span class="info-box-text"><small>Belum Lunas:
                                    {{ number_format($jumlahTagihanBelumLunas, 0, ',', '.') }}</small></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-yellow"><i class="fa fa-exclamation-circle"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Pengaduan</span>
                            <span class="info-box-number">{{ number_format($jumlahPengaduan, 0, ',', '.') }}</span>
                            <span class="info-box-text">
                                <small>
                                    Pending: {{ $jumlahPengaduanPending }} |
                                    Proses: {{ $jumlahPengaduanProses }}
                                </small>
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-red"><i class="fa fa-tint"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Permohonan</span>
                            <span
                                class="info-box-number">{{ number_format($jumlahPemasangan + $jumlahPemutusan, 0, ',', '.') }}</span>
                            <span class="info-box-text">
                                <small>
                                    PMB: {{ $jumlahPemasangan }} |
                                    PMT: {{ $jumlahPemutusan }}
                                </small>
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Statistik Permohonan (6 Bulan Terakhir)</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i></button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                        class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="chart">
                                <canvas id="permohonanChart" style="height: 250px; width: 393px;" height="250"
                                    width="393"></canvas>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>
            <!-- /.row -->

            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Permohonan Pemasangan Terbaru</h3>
                            <div class="box-tools pull-right">
                                <a href="{{ route('pemasangan.index') }}" class="btn btn-box-tool">
                                    <i class="fa fa-external-link"></i> Lihat Semua
                                </a>
                                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body no-padding">
                            @if ($permohonanPemasanganTerbaru->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="width: 40px">No.</th>
                                                <th>Pelanggan</th>
                                                <th>Tanggal Permohonan</th>
                                                <th>Tujuan</th>
                                                <th>Status</th>
                                                <th class="text-center" style="width: 80px">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($permohonanPemasanganTerbaru as $pemasangan)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td>{{ Str::limit($pemasangan->pelanggan->nama_pelanggan, 20) }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($pemasangan->tanggal_permohonan)->translatedFormat('d F Y') }}
                                                    </td>
                                                    <td>{{ Str::limit($pemasangan->deskripsi, 30) }}</td>
                                                    <td>
                                                        @if ($pemasangan->status == 'pending')
                                                            <span class="label label-warning">Pending</span>
                                                        @elseif($pemasangan->status == 'proses')
                                                            <span class="label label-info">Proses</span>
                                                        @elseif($pemasangan->status == 'disetujui')
                                                            <span class="label label-success">Disetujui</span>
                                                        @elseif($pemasangan->status == 'ditolak')
                                                            <span class="label label-danger">Ditolak</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="btn-group d-flex">
                                                            @if ($pemasangan->status !== 'disetujui')
                                                                <a href="{{ route('pemasangan.edit', $pemasangan->id) }}"
                                                                    class="btn btn-default btn-sm text-green"
                                                                    title="Edit"><i class="fa fa-edit"></i></a>
                                                            @endif
                                                            @if ($pemasangan->status !== 'disetujui')
                                                                <form
                                                                    action="{{ route('pemasangan.destroy', $pemasangan->id) }}"
                                                                    method="POST"
                                                                    onsubmit="return confirm('Yakin ingin menghapus permohonan pemasangan ini?')"
                                                                    class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="btn btn-default btn-sm text-red"
                                                                        title="Hapus"><i
                                                                            class="fa fa-trash-o"></i></button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                            @else
                                <p class="text-center">Tidak ada permohonan pemasangan terbaru.</p>
                            @endif
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Status Permohonan Pemasangan</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="progress-group">
                                        <span class="progress-text">Pending</span>
                                        <span
                                            class="progress-number"><b>{{ $jumlahPemasanganPending }}</b>/{{ $jumlahPemasangan }}</span>
                                        <div class="progress sm">
                                            <div class="progress-bar progress-bar-aqua"
                                                style="width: {{ $jumlahPemasangan > 0 ? ($jumlahPemasanganPending / $jumlahPemasangan) * 100 : 0 }}%">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.progress-group -->
                                    <div class="progress-group">
                                        <span class="progress-text">Proses</span>
                                        <span
                                            class="progress-number"><b>{{ $jumlahPemasanganProses }}</b>/{{ $jumlahPemasangan }}</span>
                                        <div class="progress sm">
                                            <div class="progress-bar progress-bar-yellow"
                                                style="width: {{ $jumlahPemasangan > 0 ? ($jumlahPemasanganProses / $jumlahPemasangan) * 100 : 0 }}%">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.progress-group -->
                                </div>
                                <!-- /.col -->
                                <div class="col-md-6">
                                    <div class="progress-group">
                                        <span class="progress-text">Disetujui</span>
                                        <span
                                            class="progress-number"><b>{{ $jumlahPemasanganDisetujui }}</b>/{{ $jumlahPemasangan }}</span>
                                        <div class="progress sm">
                                            <div class="progress-bar progress-bar-green"
                                                style="width: {{ $jumlahPemasangan > 0 ? ($jumlahPemasanganDisetujui / $jumlahPemasangan) * 100 : 0 }}%">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.progress-group -->
                                    <div class="progress-group">
                                        <span class="progress-text">Ditolak</span>
                                        <span
                                            class="progress-number"><b>{{ $jumlahPemasanganDitolak }}</b>/{{ $jumlahPemasangan }}</span>
                                        <div class="progress sm">
                                            <div class="progress-bar progress-bar-red"
                                                style="width: {{ $jumlahPemasangan > 0 ? ($jumlahPemasanganDitolak / $jumlahPemasangan) * 100 : 0 }}%">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.progress-group -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->

                <div class="col-md-6">
                    <div class="box box-danger">
                        <div class="box-header with-border">
                            <h3 class="box-title">Status Permohonan Pemutusan</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="progress-group">
                                        <span class="progress-text">Pending</span>
                                        <span
                                            class="progress-number"><b>{{ $jumlahPemutusanPending }}</b>/{{ $jumlahPemutusan }}</span>
                                        <div class="progress sm">
                                            <div class="progress-bar progress-bar-aqua"
                                                style="width: {{ $jumlahPemutusan > 0 ? ($jumlahPemutusanPending / $jumlahPemutusan) * 100 : 0 }}%">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.progress-group -->
                                    <div class="progress-group">
                                        <span class="progress-text">Proses</span>
                                        <span
                                            class="progress-number"><b>{{ $jumlahPemutusanProses }}</b>/{{ $jumlahPemutusan }}</span>
                                        <div class="progress sm">
                                            <div class="progress-bar progress-bar-yellow"
                                                style="width: {{ $jumlahPemutusan > 0 ? ($jumlahPemutusanProses / $jumlahPemutusan) * 100 : 0 }}%">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.progress-group -->
                                </div>
                                <!-- /.col -->
                                <div class="col-md-6">
                                    <div class="progress-group">
                                        <span class="progress-text">Disetujui</span>
                                        <span
                                            class="progress-number"><b>{{ $jumlahPemutusanDisetujui }}</b>/{{ $jumlahPemutusan }}</span>
                                        <div class="progress sm">
                                            <div class="progress-bar progress-bar-green"
                                                style="width: {{ $jumlahPemutusan > 0 ? ($jumlahPemutusanDisetujui / $jumlahPemutusan) * 100 : 0 }}%">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.progress-group -->
                                    <div class="progress-group">
                                        <span class="progress-text">Ditolak</span>
                                        <span
                                            class="progress-number"><b>{{ $jumlahPemutusanDitolak }}</b>/{{ $jumlahPemutusan }}</span>
                                        <div class="progress sm">
                                            <div class="progress-bar progress-bar-red"
                                                style="width: {{ $jumlahPemutusan > 0 ? ($jumlahPemutusanDitolak / $jumlahPemutusan) * 100 : 0 }}%">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.progress-group -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
        @elseif (Auth::user()->role == 'pelanggan')
            <!-- Info boxes -->
            <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua"><i class="fa fa-file-text"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Tagihan</span>
                            <span
                                class="info-box-number">{{ number_format($jumlahTagihanBelumLunas, 0, ',', '.') }}</span>
                            <span class="info-box-text"><small>Belum Lunas</small></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-yellow"><i class="fa fa-exclamation-circle"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Pengaduan</span>
                            <span
                                class="info-box-number">{{ number_format($jumlahPengaduanPending + $jumlahPengaduanProses, 0, ',', '.') }}</span>
                            <span class="info-box-text">
                                <small>
                                    Pending: {{ $jumlahPengaduanPending }} |
                                    Proses: {{ $jumlahPengaduanProses }}
                                </small>
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-green"><i class="fa fa-plus-circle"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Pemasangan</span>
                            <span class="info-box-number">{{ number_format($jumlahPemasangan, 0, ',', '.') }}</span>
                            @if ($pemasanganTerbaru)
                                <span class="info-box-text">
                                    <small>
                                        Terbaru:
                                        @if ($pemasanganTerbaru->status == 'pending')
                                            <span class="label label-warning">Pending</span>
                                        @elseif($pemasanganTerbaru->status == 'proses')
                                            <span class="label label-info">Proses</span>
                                        @elseif($pemasanganTerbaru->status == 'disetujui')
                                            <span class="label label-success">Disetujui</span>
                                        @elseif($pemasanganTerbaru->status == 'ditolak')
                                            <span class="label label-danger">Ditolak</span>
                                        @endif
                                    </small>
                                </span>
                            @endif
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-red"><i class="fa fa-minus-circle"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Pemutusan</span>
                            <span class="info-box-number">{{ number_format($jumlahPemutusan, 0, ',', '.') }}</span>
                            @if ($pemutusanTerbaru)
                                <span class="info-box-text">
                                    <small>
                                        Terbaru:
                                        @if ($pemutusanTerbaru->status == 'pending')
                                            <span class="label label-warning">Pending</span>
                                        @elseif($pemutusanTerbaru->status == 'proses')
                                            <span class="label label-info">Proses</span>
                                        @elseif($pemutusanTerbaru->status == 'disetujui')
                                            <span class="label label-success">Disetujui</span>
                                        @elseif($pemutusanTerbaru->status == 'ditolak')
                                            <span class="label label-danger">Ditolak</span>
                                        @endif
                                    </small>
                                </span>
                            @endif
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Tagihan Terbaru</h3>
                                    <div class="box-tools pull-right">
                                        <a href="{{ route('tagihan.index') }}" class="btn btn-box-tool">
                                            <!-- Ganti dengan route yang sesuai -->
                                            <i class="fa fa-external-link"></i> Lihat Semua
                                        </a>
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                                class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body no-padding">
                                    @if ($tagihanTerbaru)
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Periode</th>
                                                        <th>Volume (m³)</th>
                                                        <th>Total Tagihan</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>{{ $tagihanTerbaru->periode->format('F Y') }}</td>
                                                        <td>{{ number_format($tagihanTerbaru->volume_air, 0, ',', '.') }}
                                                        </td>
                                                        <td>Rp
                                                            {{ number_format($tagihanTerbaru->total_tagihan, 2, ',', '.') }}
                                                        </td>
                                                        <td>
                                                            @if ($tagihanTerbaru->status_pembayaran)
                                                                <span class="label label-success">Lunas</span>
                                                            @else
                                                                <span class="label label-warning">Belum Lunas</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /.table-responsive -->
                                    @else
                                        <p class="text-center">Tidak ada tagihan.</p>
                                    @endif
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                        </div>
                        <div class="col-md-6">
                            <div class="box box-success">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Riwayat Tagihan Terakhir</h3>
                                    <div class="box-tools pull-right">
                                        <a href="{{ route('tagihan.index') }}" class="btn btn-box-tool">
                                            <!-- Ganti dengan route yang sesuai -->
                                            <i class="fa fa-external-link"></i> Lihat Semua
                                        </a>
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                                class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body no-padding">
                                    @if ($tagihanTerakhir->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Periode</th>
                                                        <th>Volume (m³)</th>
                                                        <th>Total</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($tagihanTerakhir as $tagihan)
                                                        <tr>
                                                            <td>{{ $tagihan->periode->format('M Y') }}</td>
                                                            <td>{{ number_format($tagihan->volume_air, 0, ',', '.') }}</td>
                                                            <td>Rp
                                                                {{ number_format($tagihan->total_tagihan, 2, ',', '.') }}
                                                            </td>
                                                            <td>
                                                                @if ($tagihan->status_pembayaran)
                                                                    <span class="label label-success">Lunas</span>
                                                                @else
                                                                    <span class="label label-warning">Belum</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /.table-responsive -->
                                    @else
                                        <p class="text-center">Tidak ada riwayat tagihan.</p>
                                    @endif
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                        </div>
                    </div>
                </div>
                <!-- /.col -->

                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="box box-warning">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Permohonan Terbaru</h3>
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                                class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body no-padding">
                                    @if ($pemasanganTerbaru || $pemutusanTerbaru)
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Jenis</th>
                                                        <th>Tanggal</th>
                                                        <th>Deskripsi</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($pemasanganTerbaru)
                                                        <tr>
                                                            <td>Pemasangan</td>
                                                            <td>{{ \Carbon\Carbon::parse($pemasanganTerbaru->tanggal_permohonan)->translatedFormat('d F Y') }}
                                                            </td>
                                                            <td>{{ Str::limit($pemasanganTerbaru->deskripsi, 30) }}</td>
                                                            <td>
                                                                @if ($pemasanganTerbaru->status == 'pending')
                                                                    <span class="label label-warning">Pending</span>
                                                                @elseif($pemasanganTerbaru->status == 'proses')
                                                                    <span class="label label-info">Proses</span>
                                                                @elseif($pemasanganTerbaru->status == 'disetujui')
                                                                    <span class="label label-success">Disetujui</span>
                                                                @elseif($pemasanganTerbaru->status == 'ditolak')
                                                                    <span class="label label-danger">Ditolak</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endif
                                                    @if ($pemutusanTerbaru)
                                                        <tr>
                                                            <td>Pemutusan</td>
                                                            <td>{{ \Carbon\Carbon::parse($pemutusanTerbaru->created_at)->translatedFormat('d F Y, H:i') }}
                                                            </td>
                                                            <td>{{ Str::limit($pemutusanTerbaru->deskripsi, 30) }}</td>
                                                            <td>
                                                                @if ($pemutusanTerbaru->status == 'pending')
                                                                    <span class="label label-warning">Pending</span>
                                                                @elseif($pemutusanTerbaru->status == 'proses')
                                                                    <span class="label label-info">Proses</span>
                                                                @elseif($pemutusanTerbaru->status == 'disetujui')
                                                                    <span class="label label-success">Disetujui</span>
                                                                @elseif($pemutusanTerbaru->status == 'ditolak')
                                                                    <span class="label label-danger">Ditolak</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /.table-responsive -->
                                    @else
                                        <p class="text-center">Tidak ada permohonan terbaru.</p>
                                    @endif

                                    <div class="text-center" style="margin-top: 15px;">
                                        <a href="{{ route('pemasangan.create') }}" class="btn btn-sm btn-success">
                                            <!-- Ganti dengan route yang sesuai -->
                                            <i class="fa fa-plus"></i> Ajukan Pemasangan
                                        </a>
                                        <a href="{{ route('pemutusan.create') }}" class="btn btn-sm btn-danger"
                                            style="margin-left: 10px;"> <!-- Ganti dengan route yang sesuai -->
                                            <i class="fa fa-minus"></i> Ajukan Pemutusan
                                        </a>
                                    </div>
                                </div>
                                <!-- /.box-body no-padding -->
                            </div>
                            <!-- /.box -->
                        </div>
                        <div class="col-md-6">
                            <div class="box box-danger">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Pengaduan Terbaru</h3>
                                    <div class="box-tools pull-right">
                                        <a href="{{ route('pengaduan.index') }}" class="btn btn-box-tool">
                                            <!-- Ganti dengan route yang sesuai -->
                                            <i class="fa fa-external-link"></i> Lihat Semua
                                        </a>
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                                class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body no-padding">
                                    @if ($pengaduanTerbaru)
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Tanggal</th>
                                                        <th>Deskripsi</th>
                                                        <th>Status</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>{{ $pengaduanTerbaru->created_at->format('d/m/Y') }}</td>
                                                        <td>{{ Str::limit($pengaduanTerbaru->deskripsi, 30) }}</td>
                                                        <td>
                                                            @if ($pengaduanTerbaru->status == 'pending')
                                                                <span class="label label-warning">Pending</span>
                                                            @elseif($pengaduanTerbaru->status == 'proses')
                                                                <span class="label label-info">Proses</span>
                                                            @elseif($pengaduanTerbaru->status == 'selesai')
                                                                <span class="label label-success">Selesai</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('pengaduan.show', $pengaduanTerbaru->id) }}"
                                                                class="btn btn-xs btn-primary" title="Detail">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /.table-responsive -->
                                    @else
                                        <p class="text-center">Tidak ada pengaduan.</p>
                                    @endif

                                    <div class="text-center" style="margin-top: 15px;">
                                        <a href="{{ route('pengaduan.create') }}" class="btn btn-sm btn-primary">
                                            <!-- Ganti dengan route yang sesuai -->
                                            <i class="fa fa-exclamation-circle"></i> Buat Pengaduan
                                        </a>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                        </div>
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        @endif
        <!-- /.row -->
    </section>
@endsection
@if (Auth::user()->role == 'admin')
    @push('script')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Chart data from controller
                var chartData = @json($dataChart);

                // Get canvas element
                var ctx = document.getElementById('permohonanChart').getContext('2d');

                // Create chart
                var myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: chartData.labels,
                        datasets: chartData.datasets
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    callback: function(value) {
                                        if (value % 1 === 0) {
                                            return value;
                                        }
                                    }
                                }
                            }]
                        },
                        tooltips: {
                            mode: 'index',
                            intersect: false,
                        },
                        hover: {
                            mode: 'nearest',
                            intersect: true
                        }
                    }
                });
            });
        </script>
    @endpush
@endif
