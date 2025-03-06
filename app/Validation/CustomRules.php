<?php

namespace App\Validation;

use App\Models\CollegeModel;

class CustomRules
{
    public function checkCollegeCode(string $str, ?string $fields = null, array $data = []): bool
    {
        $collegeModel = new CollegeModel();
        return $collegeModel->where('college_code', $str)->countAllResults() > 0;
    }
}
