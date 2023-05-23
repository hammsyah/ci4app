<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Home | Yuliamsyah',
        ];

        echo view('pages/home', $data);
    }

    public function about()
    {
        $data = [
            'title' => 'About | Yuliamsyah',
        ];
        echo view('pages/about', $data);
    }

    public function contact()
    {
        $data = [
            'title' => 'Contact | Yuliamsyah',
            'alamat' => [
                [
                    'tipe' => 'Rumah',
                    'alamat' => 'Jl. Kolonel Sugiono',
                    'kota' => 'BOJONEGORO'
                ],
                [
                    'tipe' => 'Kantor',
                    'alamat' => 'Jl. KH. Rosyid km.5',
                    'kota' => 'TULUNGAGUNG'
                ]

            ]

        ];

        echo view('pages/contact', $data);
    }
}
