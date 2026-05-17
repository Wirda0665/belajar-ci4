<?php

namespace App\Models;

use CodeIgniter\Model;

class BukuModel extends Model
{
    protected $table = 'buku';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $useTimestamps = true;
    protected $allowedFields = [
        'kode_buku',
        'judul',
        'penulis',
        'penerbit',
        'tahun',
        'isbn',
        'deskripsi',
        'stok',
        'kategori_id'
    ];
    /**
     * Ambil semua buku beserta nama kategorinya (JOIN)
     */
    public function getBukuDenganKategori(): array
    {
        return $this
            ->select('buku.*, kategori.nama AS nama_kategori')
            ->join('kategori', 'kategori.id = buku.kategori_id', 'left')
            ->orderBy('buku.judul', 'ASC')
            ->findAll();
    }
    /**
     * Cari buku berdasarkan keyword di judul atau penulis
     */
    public function cari(string $keyword): array
    {
        return $this
            ->select('buku.*, kategori.nama AS nama_kategori')
            ->join('kategori', 'kategori.id = buku.kategori_id', 'left')
            ->groupStart()
            ->like('buku.judul', $keyword)
            ->orLike('buku.penulis', $keyword)
            ->orLike('buku.penerbit', $keyword)
            ->groupEnd()
            ->orderBy('buku.judul', 'ASC')
            ->findAll();
    }
    /**
     * Ambil buku dengan paginasi dan JOIN kategori
     */
    public function getBukuPaginate(int $perPage = 10, string $keyword = '')
    {
        $this->select('buku.*, kategori.nama AS nama_kategori')
            ->join('kategori', 'kategori.id = buku.kategori_id', 'left')
            ->orderBy('buku.judul', 'ASC');
        if (!empty($keyword)) {
            $this->groupStart()
                ->like('buku.judul', $keyword)
                ->orLike('buku.penulis', $keyword)
                ->groupEnd();
        }
        return $this->paginate($perPage);
    }
    /**
     * Cek apakah kode buku sudah ada (untuk validasi unik saat edit)
     */
    public function isKodeTaken(string $kode, int $excludeId = 0): bool
    {
        $qb = $this->where('kode_buku', $kode);
        if ($excludeId > 0) {
            $qb->where('id !=', $excludeId);
        }
        return $qb->countAllResults() > 0;
    }
    /**
     * Ambil statistik buku
     */
    public function getStatistik(): array
    {
        $db = \Config\Database::connect();
        return [
            'total' => $this->countAll(),
            'total_stok' => (int)
            $db->table('buku')->selectSum('stok')->get()->getRow()->stok,
            'per_kategori' => $db->table('buku')
                ->select('kategori.nama, COUNT(buku.id) AS jumlah')
                ->join('kategori', 'kategori.id = buku.kategori_id', 'left')
                ->groupBy('buku.kategori_id')
                ->orderBy('jumlah', 'DESC')
                ->get()->getResultArray(),
        ];
    }

    /**
     * Ambil statistik buku yang sangat lengkap untuk halaman statistik
     */
    public function getStatistikDetail(): array
    {
        $db = \Config\Database::connect();
        
        // 1. Ringkasan (Total Buku, Total Stok, Rata-rata Stok)
        $totalBuku = $this->countAll();
        
        $sumStockRow = $this->selectSum('stok')->first();
        $totalStok = $sumStockRow ? (int)$sumStockRow['stok'] : 0;
        
        $avgStockRow = $this->selectAvg('stok')->first();
        $rataStok = $avgStockRow && $avgStockRow['stok'] !== null ? round((float)$avgStockRow['stok'], 2) : 0.00;
        
        // 2. Distribusi per kategori (nama kategori, jumlah buku, jumlah stok)
        $distribusi = $db->table('kategori')
            ->select('kategori.nama AS nama_kategori, COUNT(buku.id) AS jumlah_buku, SUM(COALESCE(buku.stok, 0)) AS jumlah_stok')
            ->join('buku', 'buku.kategori_id = kategori.id', 'left')
            ->groupBy('kategori.id, kategori.nama')
            ->orderBy('kategori.nama', 'ASC')
            ->get()->getResultArray();
            
        // Jika ada buku yang kategori_id-nya NULL (Tanpa Kategori), tambahkan ke distribusi
        $tanpaKategori = $db->table('buku')
            ->select('COUNT(buku.id) AS jumlah_buku, SUM(COALESCE(buku.stok, 0)) AS jumlah_stok')
            ->where('buku.kategori_id IS NULL')
            ->get()->getRowArray();
            
        if ($tanpaKategori && (int)$tanpaKategori['jumlah_buku'] > 0) {
            $distribusi[] = [
                'nama_kategori' => 'Tanpa Kategori',
                'jumlah_buku' => (int) $tanpaKategori['jumlah_buku'],
                'jumlah_stok' => (int) $tanpaKategori['jumlah_stok']
            ];
        }

        // 3. Daftar 5 buku dengan stok terbanyak
        $stokTerbanyak = $this->select('buku.*, kategori.nama AS nama_kategori')
            ->join('kategori', 'kategori.id = buku.kategori_id', 'left')
            ->orderBy('buku.stok', 'DESC')
            ->orderBy('buku.judul', 'ASC')
            ->limit(5)
            ->findAll();

        // 4. Daftar buku yang stoknya 0 (perlu restock)
        $stokKosong = $this->select('buku.*, kategori.nama AS nama_kategori')
            ->join('kategori', 'kategori.id = buku.kategori_id', 'left')
            ->where('stok', 0)
            ->orderBy('buku.judul', 'ASC')
            ->findAll();

        return [
            'total_buku' => $totalBuku,
            'total_stok' => $totalStok,
            'rata_stok' => $rataStok,
            'distribusi_kategori' => $distribusi,
            'stok_terbanyak' => $stokTerbanyak,
            'stok_kosong' => $stokKosong
        ];
    }
}

