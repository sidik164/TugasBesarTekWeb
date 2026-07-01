<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgressModel extends Model
{
    protected $table = 'progress_karyawan';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['user_id', 'modul_id', 'status', 'nilai_kuis', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}