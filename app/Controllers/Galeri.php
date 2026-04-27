<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Galeri extends BaseController
{
    public function index(): string
    {
        $galeri = [
            [
                'judul' => 'Gunung Bromo',
                'url_gambar' => 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=800&q=80',
                'deskripsi' => 'Pemandangan matahari terbit dari Gunung Bromo selalu memukau dengan kabut lembut dan langit oranye yang dramatis.',
                'kategori' => 'alam',
            ],
            [
                'judul' => 'Pantai Kuta',
                'url_gambar' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80',
                'deskripsi' => 'Pasir putih dan ombak yang tenang membuat Pantai Kuta menjadi lokasi favorit untuk liburan dan bermain air.',
                'kategori' => 'alam',
            ],
            [
                'judul' => 'Kota Tua Jakarta',
                'url_gambar' => 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?auto=format&fit=crop&w=800&q=80',
                'deskripsi' => 'Bangunan bersejarah dan atmosfer klasik di Kota Tua menghadirkan nostalgia dan kesempatan foto yang menarik.',
                'kategori' => 'kota',
            ],
            [
                'judul' => 'Festival Lampion',
                'url_gambar' => 'https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?auto=format&fit=crop&w=800&q=80',
                'deskripsi' => 'Ribuan lampion berwarna-warni menerangi malam, menciptakan suasana magis dan penuh kehangatan.',
                'kategori' => 'kegiatan',
            ],
            [
                'judul' => 'Gurun Pasir',
                'url_gambar' => 'https://images.unsplash.com/photo-1500534623283-312aade485b7?auto=format&fit=crop&w=800&q=80',
                'deskripsi' => 'Cahaya matahari memantul di atas hamparan pasir yang luas, menonjolkan tekstur dan pola alami gurun.',
                'kategori' => 'alam',
            ],
            [
                'judul' => 'Malam di Pusat Kota',
                'url_gambar' => 'https://images.unsplash.com/photo-1494526585095-c41746248156?auto=format&fit=crop&w=800&q=80',
                'deskripsi' => 'Lampu-lampu kota dan jalanan yang sibuk membentuk pemandangan malam yang hidup dan berenergi.',
                'kategori' => 'kota',
            ],
        ];

        $kategoriTerpilih = $this->request->getGet('kategori');
        $kategoriList = array_unique(array_column($galeri, 'kategori'));
        sort($kategoriList);

        if ($kategoriTerpilih) {
            $galeri = array_filter($galeri, function ($item) use ($kategoriTerpilih) {
                return strtolower($item['kategori']) === strtolower($kategoriTerpilih);
            });
        }

        $data = [
            'title' => 'Galeri',
            'galeri' => $galeri,
            'kategori_list' => $kategoriList,
            'kategori_terpilih' => $kategoriTerpilih,
        ];

        return view('galeri/index', $data);
    }
}
