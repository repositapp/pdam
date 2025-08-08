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
        return [
            'user_id' => mt_rand(2, 31),
            'nama_pelanggan' => $this->faker->name(),
            'jenis_kelamin' => $this->faker->randomElement(['L', 'P']),
            'alamat' => $this->faker->address(),
            'nomor_telepon' => $this->faker->phoneNumber(),
            'nomor_sambungan' => '0' . mt_rand(1, 5) . '.0.' . mt_rand(1, 5) . '.0000' . mt_rand(1, 9),
            // 'nomor_sambungan' akan diisi saat pemasangan disetujui
            'file_ktp' => 'dokumen-file/dokumen-1.pdf', // Bisa diisi dengan path file contoh jika diperlukan
            'file_kk' => 'dokumen-file/dokumen-1.pdf', // Bisa diisi dengan path file contoh jika diperlukan
        ];
    }
}
