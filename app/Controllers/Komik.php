<?php

namespace App\Controllers;

class Komik extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Daftar Komik'
        ];

        //echo ('Aku dalah index komik');

        return view('komik/index', $data);
    }
}
