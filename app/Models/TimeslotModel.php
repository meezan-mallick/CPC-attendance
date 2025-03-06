<?php

namespace App\Models;
use CodeIgniter\Model;


class TimeslotModel extends Model{
    
    protected $table = 'timeslots';
    protected $allowedFields = [
        'id',
        'start_time',
        'end_time',
       
       
    ];

   

}

?>
