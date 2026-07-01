<?php

namespace App\Models;

use CodeIgniter\Model;

class AnggotaModel extends Model
{
    protected $table = 'anggota';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['nama', 'nim', 'peran', 'foto', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}