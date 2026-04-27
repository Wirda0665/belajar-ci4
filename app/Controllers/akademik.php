<?php

namespace App\Controllers;

class Akademik extends BaseController
{
    /**
     * Method index()
     * Menampilkan Judul dan Nama Mahasiswa
     */
    public function index(): string
    {
        return "<h1>Sistem Informasi Akademik</h1><p>Nama Mahasiswa: Wirda Hajiza Fadila</p>";
    }

    /**
     * Method matkul()
     * Menampilkan daftar 5 mata kuliah dalam format list HTML
     */
    public function matkul(): string
    {
        return "
            <h1>Daftar Mata Kuliah Semester Ini</h1>
            <ul>
                <li>Teknik Informatika</li>
                <li>Pemrograman Berbasis Web</li>
                <li>Interaksi Manusia dan Komputer</li>
                <li>Data Science / Machine Learning</li>
                <li>Rekayasa Perangkat Lunak</li>
            </ul>
        ";
    }

    /**
     * Method nilai($nim)
     * Menerima parameter NIM dan menampilkannya
     */
    public function nilai(string $nim = ''): string
    {
        return "<h1>Cek Nilai</h1><p>Nilai mahasiswa dengan NIM: {$nim}</p>";
    }
}
