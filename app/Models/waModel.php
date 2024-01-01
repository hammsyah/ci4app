<?php

namespace App\Models;

use CodeIgniter\Model;

class waModel extends Model
{
    protected $table = 'wa';
    protected $useTimestamps = true;
    protected $allowedFields = ['nama', 'nomer', 'alamat', 'status'];

    function formathp($nomorhp)
    {
        //Terlebih dahulu kita trim dl
        $nomorhp = trim($nomorhp);
        //bersihkan dari karakter yang tidak perlu
        $nomorhp = strip_tags($nomorhp);
        // Berishkan dari spasi
        $nomorhp = str_replace(" ", "", $nomorhp);
        // bersihkan dari bentuk seperti  (022) 66677788
        $nomorhp = str_replace("(", "", $nomorhp);
        // bersihkan dari format yang ada titik seperti 0811.222.333.4
        $nomorhp = str_replace(".", "", $nomorhp);

        //cek apakah mengandung karakter + dan 0-9
        if (!preg_match('/[^+0-9]/', trim($nomorhp))) {
            // cek apakah no hp karakter 1-3 adalah +62
            if (substr(trim($nomorhp), 0, 3) == '+62') {
                // $nomorhp = trim($nomorhp);
                $nomorhp = '62' . substr($nomorhp, 3);
            }
            // cek apakah no hp karakter 1 adalah 0
            elseif (substr($nomorhp, 0, 1) == '0') {
                $nomorhp = '62' . substr($nomorhp, 1);
            }
        }

        return $nomorhp;
    }

    //http://wa.rajekwesi.ac.id:3000/sendtext?number=6285706088386&to=6285232868412@s.whatsapp.net&message=percobaan kirim text

    function kirimpesan($penerima, $pesan)
    {
        $curl = curl_init();
        $ownNumber = '6285706088386';
        $url = 'http://wa.rajekwesi.ac.id:3000';
        $urlEasyWa = $url . '/sendmessage?number=' . $ownNumber;
        $destination = $penerima . '@s.whatsapp.net';
        $message = [
            'to' => $destination,
            'message' => [
                'text' => $pesan,
            ],
        ];
        $sendMessage = json_encode($message, 1);

        curl_setopt_array($curl, [
            CURLOPT_URL => $urlEasyWa,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $sendMessage,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
            ],
        ]);

        $response = curl_exec($curl);

        curl_close($curl);

        // $data_wa = json_decode($response, true);
        // $pesanwa = $data_wa['message'];
        // $pesanwa = $pesanwa['message'];
        // $pesanwa = $pesanwa['extendedTextMessage'];
        // $pesanwa = $pesanwa['text'];
        // dd($pesanwa);
    }
}
