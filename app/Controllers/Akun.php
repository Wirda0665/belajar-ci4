<?php

namespace App\Controllers;

use App\Models\UserModel;

class Akun extends BaseController
{
    private UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /** Halaman form ganti password. */
    public function gantiPassword(): string
    {
        return view('akun/ganti-password', ['title' => 'Ganti Password']);
    }

    /** Proses ganti password. */
    public function prosesGantiPassword()
    {
        $rules = [
            'password_lama' => [
                'label' => 'Password Lama',
                'rules' => 'required',
            ],
            'password_baru' => [
                'label' => 'Password Baru',
                'rules' => 'required|min_length[8]',
                'errors' => ['min_length' => 'Password minimal {param} karakter.'],
            ],
            'konfirmasi' => [
                'label' => 'Konfirmasi Password Baru',
                'rules' => 'required|matches[password_baru]',
                'errors' => ['matches' => 'Konfirmasi password tidak cocok dengan password baru.'],
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->to('/login');
        }

        // Ambil data user dari database
        $user = $this->userModel->find($userId);

        $passwordLama = $this->request->getPost('password_lama');
        $passwordBaru = $this->request->getPost('password_baru');

        // Verifikasi password lama
        if (!password_verify($passwordLama, $user['password'])) {
            session()->setFlashdata('error', 'Password lama tidak cocok.');
            return redirect()->back()->withInput();
        }

        // Update ke password baru
        $this->userModel->update($userId, [
            'password' => password_hash($passwordBaru, PASSWORD_DEFAULT),
        ]);

        session()->setFlashdata('sukses', 'Password berhasil diubah.');
        return redirect()->to('/');
    }
}
