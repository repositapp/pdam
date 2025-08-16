<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pelanggan>
 */
class PelangganFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $alamat = $this->faker->randomElement(['Jl. Bataraguru', 'Jl. Karya Baru', 'Jl. Anoa', 'Jl. Rusa Bure', 'Jl. Ahmad Yani', 'Jl. Anoa', 'Jl. Erlangga', 'Jl. Pahlawan', 'Jl. Wahidin', 'Jl. Bulawambona', 'Jl. Budi Utomo', 'Jl. Diponegoro', 'Jl. Jambu Mente', 'Jl. Gatot Subroto', 'Jl. Betoambari', 'Jl. Labalawo', 'Jl. Jendral Sudirman', 'Jl. Balai Kota', 'Jl. Protokol', 'Jl. Kihajar Dewantara', 'Jl. Poros Pasar Wajo']);

        static $urutan = 1; // counter auto increment manual

        $kodeWilayah = $this->faker->randomElement(['01', '02', '03', '04', '05']);
        $randBagian = mt_rand(1, 20);
        $kodeBagian = $randBagian < 10 ? '0' . $randBagian : (string)$randBagian;

        // urutan sambungan (5 digit)
        $nomorUrut   = str_pad($urutan, 5, '0', STR_PAD_LEFT);

        $urutan++; // increment setiap record

        return [
            'user_id' => mt_rand(2, 10),
            'nama_pelanggan' => $this->faker->name(),
            'jenis_kelamin' => $this->faker->randomElement(['L', 'P']),
            'alamat' => $alamat,
            'nomor_telepon' => $this->faker->phoneNumber(),
            // 'nomor_sambungan' => '0' . mt_rand(1, 5) . '.0' . mt_rand(1, 5) . '.0000' . mt_rand(1, 9),
            'nomor_sambungan' => "{$kodeWilayah}.{$kodeBagian}.{$nomorUrut}",
            // 'nomor_sambungan' akan diisi saat pemasangan disetujui
            'file_ktp' => 'dokumen-file/dokumen-1.pdf', // Bisa diisi dengan path file contoh jika diperlukan
            'file_kk' => 'dokumen-file/dokumen-1.pdf', // Bisa diisi dengan path file contoh jika diperlukan
        ];
    }
}
