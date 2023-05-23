<?php

namespace App\Models;

use CodeIgniter\Model;

class KomikModel extends Model
{
    protected $table = 'komik';
    //protected $allowedField = ;
    protected $useTimestamps = true;

    public function getKomik($slug = false) //metod buatan kita sendiri, bisa pakai paramter atau tidak
    {
        if ($slug == false) { //jika tidak ada parameter
            return $this->findAll(); //cari semua data
        }
        return $this->where(['slug' => $slug])->first(); //jika ada paramter, cari sesuai paramternya
    }
}
