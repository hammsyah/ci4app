<?php

namespace App\Models;

use CodeIgniter\Model;

class pesanModel extends Model
{
    protected $table = 'pesan';
    // protected $useTimestamps = true;
    protected $allowedFields = ['pesan'];
}
