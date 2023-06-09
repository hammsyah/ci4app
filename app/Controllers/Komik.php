<?php

namespace App\Controllers;

use App\Models\KomikModel;

class Komik extends BaseController
{
    protected $komikModel;
    public function __construct()
    {
        $this->komikModel = new KomikModel();
    }

    public function index()
    {
        // $komik = $this->komikModel->findAll();
        $data = [
            'title' => 'Daftar Komik',
            'komik' => $this->komikModel->getKomik()
        ];


        //echo ('Aku dalah index komik');

        return view('komik/index', $data);
    }

    public function detail($slug)
    {

        // dd($komik);
        $data = [
            'title' => 'Detail Komik',
            'komik' => $this->komikModel->getKomik($slug)
        ];

        //jika komik tidak ditemukan
        if (empty($data['komik'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Judul komik ' . $slug . ' tidak Ditemukan');
        }

        return view('komik/detail', $data);
    }

    public function create()
    {
        session();
        $data  = [
            'title' => 'Form Tambah Data Komik',
            'validation' => \Config\Services::validation()
        ];

        return view('komik/create', $data);
    }

    public function save()
    {
        // validasi
        if (!$this->validate([
            'judul' => [
                'rules' => 'required|is_unique[komik.judul]',
                'errors' => [
                    'required' => '{field} komik harus diisi!',
                    'is_unique' => '{field} komik sudah terdaftar'
                ]
            ],
            'sampul' => [
                'rules' => 'max_size[sampul,1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [

                    'max_size' => 'ukuran gambar terlalu besar',
                    'is_image' => 'Yang anda pilih bukan gambar',
                    'mime_in' => 'Yang anda pilih bukan gambar',
                ]
            ]
        ])) {
            // $validation = \Config\Services::validation();
            // return redirect()->to('komik/create')->withInput()->with('validation', $validation);
            return redirect()->to('komik/create')->withInput();
        }

        //ambil gambar
        $fileSampul = $this->request->getFile('sampul');
        //apakah tidak ada gambar yang diupload
        if ($fileSampul->getError() == 4) {
            $nama_sampul = 'default.png';
        } else {
            //generate nama sampul random
            $nama_sampul = $fileSampul->getRandomName();

            //pindahkan file de folder img
            $fileSampul->move('img', $nama_sampul);
        }




        $slug = url_title($this->request->getVar('judul'), '-', true); //ambil judul dan proses jadi slug
        $this->komikModel->save([
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $nama_sampul
        ]);
        return redirect()->to('/komik')->with('sukses', 'Data Komik Berhasil ditambah');
    }

    public function delete($id)
    {
        //cari gambar berdasarkan ID
        $komik = $this->komikModel->find($id);

        //cek jika file gambarnya default.png
        if ($komik['sampul'] != 'default.png') {
            //hapus gambar
            unlink('img/' . $komik['sampul']);
        }



        $this->komikModel->delete($id);
        return redirect()->to('/komik')->with('sukses', 'Data Komik Berhasil dihapus');
    }

    public function edit($slug)
    {
        $data  = [
            'title' => 'Form ubah Data Komik',
            'validation' => \Config\Services::validation(),
            'komik' => $this->komikModel->getKomik($slug)
        ];

        return view('komik/edit', $data);
    }

    public function update($id)
    {
        //cek judul
        $komikLama = $this->komikModel->getKomik($this->request->getVar('slug'));
        if ($komikLama['judul'] == $this->request->getVar('judul')) {
            $rule_judul = 'required';
        } else {
            $rule_judul = 'required|is_unique[komik.judul]';
        }

        // validasi
        if (!$this->validate([
            'judul' => [
                'rules' => $rule_judul,
                'errors' => [
                    'required' => '{field} komik harus diisi!',
                    'is_unique' => '{field} komik sudah terdaftar'
                ]
            ],
            'sampul' => [
                'rules' => 'max_size[sampul,1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [

                    'max_size' => 'ukuran gambar terlalu besar',
                    'is_image' => 'Yang anda pilih bukan gambar',
                    'mime_in' => 'Yang anda pilih bukan gambar',
                ]
            ]
        ])) {
            // $validation = \Config\Services::validation();
            return redirect()->to('komik/edit' . $this->request->getVar('slug'))->withInput();
        }

        $fileSampul = $this->request->getFile('sampul');
        //cek gambar, apakah tetap gambar lama
        if ($fileSampul->getError() == 4) {
            $namaSampul = $this->request->getVar('sampulLama');
        } else {
            //generate nama file random
            $namaSampul = $fileSampul->getRandomName();
            //Pindahkan gambar
            $fileSampul->move('img', $namaSampul);
            //Hapus File lama, agar tidak memenuhi server
            unlink('img/' . $this->request->getVar('sampulLama'));
        }

        $slug = url_title($this->request->getVar('judul'), '-', true); //ambil judul dan proses jadi slug
        $this->komikModel->save([
            'id' => $id,
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $namaSampul
        ]);
        return redirect()->to('/komik')->with('sukses', 'Data Komik Berhasil diubah');
    }
}
