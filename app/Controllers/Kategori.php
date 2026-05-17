<?php

namespace App\Controllers;

use App\Models\KategoriModel;
use App\Models\BukuModel;

class Kategori extends BaseController
{
    private KategoriModel $kategoriModel;
    private BukuModel $bukuModel;

    public function __construct()
    {
        $this->kategoriModel = new KategoriModel();
        $this->bukuModel = new BukuModel();
    }

    public function index(): string
    {
        $keyword = $this->request->getGet('q') ?? '';
        $perPage = 10;
        
        $kategori = $this->kategoriModel->getKategoriPaginate($perPage, $keyword);
        $pager = $this->kategoriModel->pager;
        
        $data = [
            'title'    => 'Daftar Kategori',
            'kategori' => $kategori,
            'pager'    => $pager,
            'keyword'  => $keyword,
            'total'    => $this->kategoriModel->countAllResults(false),
        ];

        return view('kategori/index', $data);
    }

    public function tambah(): string
    {
        return view('kategori/form', [
            'title'    => 'Tambah Kategori',
            'kategori' => null,
        ]);
    }

    public function simpan()
    {
        $data = $this->ambilDataForm();
        
        if (empty(trim($data['nama']))) {
            session()->setFlashdata('error', 'Nama kategori tidak boleh kosong.');
            return redirect()->back()->withInput();
        }

        if ($this->kategoriModel->isNamaTaken($data['nama'])) {
            session()->setFlashdata('error', 'Nama kategori sudah digunakan.');
            return redirect()->back()->withInput();
        }

        $this->kategoriModel->insert($data);
        session()->setFlashdata('sukses', "Kategori '{$data['nama']}' berhasil ditambahkan.");
        return redirect()->to('/kategori');
    }

    public function edit(int $id): string
    {
        $kategori = $this->kategoriModel->find($id);
        if (!$kategori) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kategori tidak ditemukan');
        }

        return view('kategori/form', [
            'title'    => 'Edit Kategori: ' . $kategori['nama'],
            'kategori' => $kategori,
        ]);
    }

    public function update(int $id)
    {
        $data = $this->ambilDataForm();
        
        if (empty(trim($data['nama']))) {
            session()->setFlashdata('error', 'Nama kategori tidak boleh kosong.');
            return redirect()->back()->withInput();
        }

        if ($this->kategoriModel->isNamaTaken($data['nama'], $id)) {
            session()->setFlashdata('error', 'Nama kategori sudah digunakan.');
            return redirect()->back()->withInput();
        }

        $this->kategoriModel->update($id, $data);
        session()->setFlashdata('sukses', "Kategori '{$data['nama']}' berhasil diperbarui.");
        return redirect()->to('/kategori');
    }

    public function hapus(int $id)
    {
        $kategori = $this->kategoriModel->find($id);
        if (!$kategori) {
            session()->setFlashdata('error', 'Kategori tidak ditemukan.');
            return redirect()->to('/kategori');
        }

        $bukuCount = $this->bukuModel->where('kategori_id', $id)->countAllResults();
        if ($bukuCount > 0) {
            session()->setFlashdata('error', "Gagal dihapus: Kategori '{$kategori['nama']}' sedang digunakan oleh {$bukuCount} buku.");
            return redirect()->to('/kategori');
        }

        $this->kategoriModel->delete($id);
        session()->setFlashdata('sukses', "Kategori '{$kategori['nama']}' berhasil dihapus.");
        return redirect()->to('/kategori');
    }

    private function ambilDataForm(): array
    {
        return [
            'nama'      => $this->request->getPost('nama'),
            'deskripsi' => $this->request->getPost('deskripsi') ?: null,
        ];
    }
}
