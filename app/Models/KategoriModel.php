<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table = 'kategori';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $useTimestamps = true;
    protected $allowedFields = ['nama', 'deskripsi'];
    /**
     * Ambil semua kategori sebagai dropdown options
     * Return: ['id' => 'nama'] untuk form select
     */
    public function getDropdown(): array
    {
        $kategori = $this->orderBy('nama')->findAll();
        $result = ['' => '-- Pilih Kategori --'];
        foreach ($kategori as $k) {
            $result[$k['id']] = $k['nama'];
        }
        return $result;
    }

    /**
     * Ambil kategori dengan paginasi dan jumlah buku
     */
    public function getKategoriPaginate(int $perPage = 10, string $keyword = '')
    {
        $this->select('kategori.*, (SELECT COUNT(id) FROM buku WHERE buku.kategori_id = kategori.id) AS jumlah_buku')
             ->orderBy('kategori.nama', 'ASC');
             
        if (!empty($keyword)) {
            $this->like('kategori.nama', $keyword);
        }
        
        return $this->paginate($perPage);
    }

    /**
     * Cek apakah nama kategori sudah ada (untuk validasi unik)
     */
    public function isNamaTaken(string $nama, int $excludeId = 0): bool
    {
        $qb = $this->where('nama', $nama);
        if ($excludeId > 0) {
            $qb->where('id !=', $excludeId);
        }
        return $qb->countAllResults() > 0;
    }
}
