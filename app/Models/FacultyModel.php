<?php

namespace App\Models;
use CodeIgniter\Model;


class FacultyModel extends Model{
    
    protected $table = 'faculties';
    protected $allowedFields = [
        'id',
        'name',
        'username',
        'password',
        'coordinator',
    ];
}

?>
