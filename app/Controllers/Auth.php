<?php

namespace App\Controllers;

use App\Models\PegawaiModel;

class Auth extends BaseController
{
    protected $pegawaiModel;

    public function __construct()
    {
        $this->pegawaiModel = new PegawaiModel();
    }

    /**
     * Tampilkan halaman login
     */
    public function index()
    {
        // Jika sudah login, langsung redirect ke dashboard
        if (session()->get('logged_in')) {
            return redirect()->to(base_url('/'));
        }

        return view('login');
    }

    /**
     * Proses login
     */
    public function proses_login()
    {
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Validasi input
        if (empty($email) || empty($password)) {
            session()->setFlashdata('gagal', 'Email dan password harus diisi');
            return redirect()->to(base_url('login'));
        }

        // Cari pegawai berdasarkan email beserta relasi jabatan & unit
        $pegawai = $this->pegawaiModel->findByEmailWithRelations($email);

        if (!$pegawai) {
            session()->setFlashdata('gagal', 'Email tidak ditemukan atau akun tidak aktif');
            return redirect()->to(base_url('login'));
        }

        // Pastikan akun aktif
        if ($pegawai['status_aktif'] != 0) {
            session()->setFlashdata('gagal', 'Akun anda tidak aktif, hubungi administrator');
            return redirect()->to(base_url('login'));
        }

        // Verifikasi password
        if (!password_verify($password, $pegawai['password'])) {
            session()->setFlashdata('gagal', 'Password salah');
            return redirect()->to(base_url('login'));
        }

        // Set session data termasuk nama jabatan & unit
        $sessionData = [
            'logged_in'    => true,
            'idpegawai'    => $pegawai['idpegawai'],
            'nama_pegawai' => $pegawai['nama_pegawai'],
            'email'        => $pegawai['email'],
            'kode_pegawai' => $pegawai['kode_pegawai'],
            'idjabatan'    => $pegawai['idjabatan'],
            'nama_jabatan' => $pegawai['nama_jabatan'] ?? '-',
            'idunit'       => $pegawai['idunit'],
            'nama_unit'    => $pegawai['nama_unit'] ?? '-',
        ];

        session()->set($sessionData);
        session()->setFlashdata('sukses', 'Selamat datang, ' . $pegawai['nama_pegawai'] . '!');

        return redirect()->to(base_url('/'));
    }

    /**
     * Logout
     */
    public function logout()
    {
        session()->destroy();
        session()->setFlashdata('sukses', 'Berhasil logout');
        return redirect()->to(base_url('login'));
    }
}
