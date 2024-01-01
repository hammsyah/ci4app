<?php

namespace App\Controllers;

use App\Models\waModel;
use App\Models\pesanModel;

class wa extends BaseController
{

    protected $waModel;
    protected $pesanModel;
    public function __construct()
    {
        $this->waModel = new waModel();
        $this->pesanModel = new pesanModel();
    }

    public function index()
    {
        $pesan = $this->pesanModel->where('id', 1)->findAll();

        $pesan = $pesan[0];
        //dd($pesan);
        $data = [
            'title' => 'Home | Yuliamsyah',
            'datawa' => $this->waModel->findAll(),
            'ulang' => 0,
            'pesan' => $pesan
        ];
        // dd($data);
        return view('wa', $data);
    }

    public function importxcel()
    {
        $file_excel = $this->request->getFile('fileexcel');
        $ext = $file_excel->getClientExtension();
        if ($ext == 'xls') {
            $render = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        } else {
            $render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }
        //jika ada eror not foud silahkan install lagi library phpoffice nya, kemungkinan belum diinstal di komputer ini. karena tidak ikut di git

        $spreadsheet = $render->load($file_excel);

        $data = $spreadsheet->getActiveSheet()->toArray();


        $hitung = 0;
        foreach ($data as $x => $row) {
            //baris paling atas tidak perlu diambil datanya
            if ($x == 0) {
                continue;
            }

            $nama = $row[0];
            $nomer = $row[1];
            $alamat = $row[2];

            //ambil data Dosen berdasarkan nidn
            $ceknikerja = $this->waModel->where('nomer', $nomer)->findAll();

            //cek apakah sudah ada data
            if ($ceknikerja != null) {
                return redirect()->to(base_url('wa'))->with('danger', $nomer . ' Sudah terdaftar!! Gagal Import ');
            } else {

                $simpandata = [
                    'nama' => $nama,
                    'nomer' =>  $nomer,
                    'alamat' => $alamat,
                    'status' => 0,

                ];

                $this->waModel->insert($simpandata); // insert data ke data base
                $hitung++;
            }
        }

        return redirect()->to(base_url('wa'))->with('success', $hitung . ' Data berhasil di import');
    }

    public function blast()
    {
        $data =  $this->waModel->where('status', 0)->findAll(20); //ambil data dari database

        $pesan = $this->pesanModel->where('id', 1)->findAll();

        $pesan = $pesan[0]['pesan'];

        //dd($pesan);

        if ($data != null) {
            $ganti = [
                'status' => 1
            ];
            foreach ($data as $val) {
                $kirim = "*PPS KELURAHAN SUMBANG* \nsdr/i *" . $val['nama'] . "* \n" . $pesan;
                $nomorhp = $val['nomer'];
                $id = $val['id'];
                $nomorhp = $this->waModel->formathp($nomorhp);
                //dd($kirim);
                $this->waModel->kirimpesan($nomorhp, $kirim);
                $this->waModel->update($id, $ganti);
                //  sleep(1);
            }
        }

        //dd($data);
        //cari data dengan status nol
        $data =  $this->waModel->where('status', 0)->findAll();

        //jika ada data kerjakan dibawah ini
        if ($data != null) {
            // $ppesan = $this->pesanModel->where('id', 1)->find();
            // $ppesan = $ppesan[0];
            // $dataa = [
            //     'title' => 'Home | Yuliamsyah',
            //     'datawa' => $this->waModel->findAll(),
            //     'ulang' => 1,
            //     'pesan' => $ppesan
            // ];

            // // dd($dataa);
            // return view('wa', $dataa);
            return redirect()->to(base_url('/wa/blast'));
        } else {
            return redirect()->to(base_url('/wa'))->with('success', 'Pesan Dikrim');
        }
    }

    public function simpan()
    {

        $pesan = $this->request->getPost();
        $this->pesanModel->update(1, $pesan);
        return redirect()->to(base_url('/wa'))->with('success', 'Pesan Dikrim');
    }

    public function nolkan()
    {
        $data = $this->waModel->findAll();
        $status = [
            'status' => 0
        ];
        foreach ($data as $k) {
            $this->waModel->update($k['id'], $status);
        }

        return redirect()->to(base_url('/wa'))->with('success', 'Pesan Dikrim');
    }

    public function hapusall()
    {
        $data = $this->waModel->findAll();

        foreach ($data as $k) {
            $this->waModel->delete($k['id']);
        }

        return redirect()->to(base_url('/wa'))->with('success', 'Pesan Dikrim');
    }
}
