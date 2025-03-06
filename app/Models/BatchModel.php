<?php

namespace App\Models;

use CodeIgniter\Model;

class BatchModel extends Model
{
    protected $table = 'batches';
    protected $primaryKey = 'id';
    protected $allowedFields = ['batch_name', 'course_id', 'semester_id'];

    public function getBatches($course_id, $semester_id)
    {
        return $this->where('course_id', $course_id)
            ->where('semester_id', $semester_id)
            ->findAll();
    }
}
