<?php

namespace App\Models;

use CodeIgniter\Model;

class ModulModel extends Model
{
    protected $table = 'modul_pelatihan';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['judul', 'urutan', 'file_materi', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}