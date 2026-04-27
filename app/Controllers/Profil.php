<?php

namespace App\Controllers;

class Profil extends BaseController
{
    public function index(): string
    {
        $data = [
            'title' => 'Profil Mahasiswa',
            'npm' => '2310010076',
            'nama' => 'Wirda Hajiza Fadila',
            'prodi' => 'Teknik Informatika',
            'fakultas' => 'Teknologi Banjarmasin',
            'angkatan' => '2023',
            'ipk' => 4.00,
            'mata_kuliah' => [
                'Surat Penunjang Keputusan',
                'Metode Penelitian',
                'Jaringan Syaraf Tiruan',
                'Keamanan Sistem Komputer',
                'Manajemen Perangkat Lunak',
            ],
        ];

        if ($data['ipk'] >= 3.5) {
            $data['ipk_badge'] = 'success';
        } elseif ($data['ipk'] >= 3.0) {
            $data['ipk_badge'] = 'warning';
        } else {
            $data['ipk_badge'] = 'danger';
        }

        return view('profil/index', $data);
    }
}
