<?php

namespace App\Models;

use CodeIgniter\Model;

class SertifikatModel extends Model
{
    protected $table = 'sertifikat';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['user_id', 'modul_id', 'issued_at', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}