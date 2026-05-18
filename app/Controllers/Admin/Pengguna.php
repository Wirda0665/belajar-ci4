<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Pengguna extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Manajemen Pengguna',
            'pengguna' => $this->userModel->getDaftarUser()
        ];

        return view('admin/pengguna/index', $data);
    }

    public function toggleAktif($id)
    {
        // Proteksi agar admin tidak menonaktifkan akunnya sendiri
        if ($id == session()->get('user_id')) {
            return redirect()->back()->with('error', 'Anda tidak dapat mengubah status aktif akun Anda sendiri.');
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'Pengguna tidak ditemukan.');
        }

        $statusBaru = ($user['aktif'] == 1) ? 0 : 1;
        $this->userModel->update($id, ['aktif' => $statusBaru]);

        $pesan = $statusBaru == 1 ? 'Akun berhasil diaktifkan.' : 'Akun berhasil dinonaktifkan.';
        return redirect()->back()->with('sukses', $pesan);
    }

    public function ubahRole($id)
    {
        // Proteksi agar admin tidak mengubah role akunnya sendiri
        if ($id == session()->get('user_id')) {
            return redirect()->back()->with('error', 'Anda tidak dapat mengubah role akun Anda sendiri.');
        }

        $roleBaru = $this->request->getPost('role');
        $validRoles = ['admin', 'petugas', 'anggota'];

        if (!in_array($roleBaru, $validRoles)) {
            return redirect()->back()->with('error', 'Role tidak valid.');
        }

        $this->userModel->update($id, ['role' => $roleBaru]);

        return redirect()->back()->with('sukses', 'Role pengguna berhasil diubah.');
    }
}
