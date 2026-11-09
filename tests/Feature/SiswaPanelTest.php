<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Pengaduan;
use App\Models\Siswa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SiswaPanelTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_siswa_page_is_read_only_and_shows_student_cards(): void
    {
        $this->createSiswa('Dina', 'XI RPL 1', '123456');

        $this->get('/admin')
            ->assertRedirect('/admin/login');

        $this->get('/siswa/siswa')
            ->assertOk()
            ->assertSeeText('Dina')
            ->assertSeeText('XI RPL 1')
            ->assertDontSeeText('123456');
    }

    public function test_public_pengaduan_page_can_filter_complaints_by_student(): void
    {
        $category = Category::query()->create(['name' => 'Fasilitas']);
        $siswa = $this->createSiswa('Dina', 'XI RPL 1', '123456');
        $otherSiswa = $this->createSiswa('Budi', 'XI RPL 2', '654321');

        $this->createPengaduan($category, $siswa, 'Kursi rusak', 'menunggu');
        foreach (range(1, 7) as $number) {
            $this->createPengaduan($category, $otherSiswa, "Lampu mati {$number}", 'proses');
        }

        $this->get('/siswa/pengaduan?filters[siswa_id]='.$siswa->id)
            ->assertOk()
            ->assertSeeText('Menunggu')
            ->assertSeeText('Proses')
            ->assertSeeText('Selesai')
            ->assertSeeText('Pilih Siswa')
            ->assertSeeText('1')
            ->assertSeeText('Kursi rusak')
            ->assertDontSeeText('Lampu mati 1')
            ->assertDontSeeText('menunggu');
    }

    private function createSiswa(string $name, string $kelas, string $nis): Siswa
    {
        $siswa = new Siswa;
        $siswa->name = $name;
        $siswa->kelas = $kelas;
        $siswa->nis = $nis;
        $siswa->save();

        return $siswa;
    }

    private function createPengaduan(Category $category, Siswa $siswa, string $nama, string $status): Pengaduan
    {
        return Pengaduan::query()->forceCreate([
            'nama' => $nama,
            'deskripsi' => "{$nama} di kelas.",
            'status' => $status,
            'ruangan' => 'Ruang 1',
            'kapan' => '08:00:00',
            'category_id' => $category->id,
            'siswa_id' => $siswa->id,
        ]);
    }
}
