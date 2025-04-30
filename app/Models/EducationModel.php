<?php

namespace App\Models;

use App\Entities\Education;
use CodeIgniter\Model;

class EducationModel extends Model
{
    protected $table            = 'educations';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    //protected $returnType       = 'array';
    protected $returnType       = Education::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'doctor_id',
        'university',
        'city',
        'study_program',
        'degree',
        'year'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'doctor_id' => 'required',
        'university'  => 'required',
        'city' => 'required',
        'study_program' => 'required',
        'degree' => 'required',
        'year' => 'required|integer|min_length[4]|max_length[4]',
    ];
    protected $validationMessages   = [
        'doctor_id' => [
            'required' => 'Doctor ID is required.',
        ],
        'university' => [
            'required' => 'University must be filled.',
        ],
        'city' => [
            'required' => 'City must be filled.',
        ],
        'study_program' => [
            'required' => 'Major must be filled.',
        ],
        'degree' => [
            'required' => 'Degree must be filled.',
        ],
        'year' => [
            'required' => 'Year must be filled.',
            'integer' => 'Year cant be string.',
            'min_length' => 'Year must be 4 digits.',
            'max_length' => 'Year must be 4 digits.',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];


    public function insertBatchValidated($educations)
    {
        if (!is_array($educations) || count($educations) < 1) {
            return [
                'error' => 'At least 1 education record is required.',
                'status' => false
            ];
        }

        foreach ($educations as $edu) {
            if (empty($edu['degree']) || empty($edu['university']) || empty($edu['year'])) {
                return [
                    'error' => 'Each education record must have a degree, university and year.',
                    'status' => false
                ];
            }
        }

        $this->insertBatch($educations);
        return ['success' => 'Education successfully added.', 'status' => true];
    }

    public function addEducation($data)
    {
        return $this->save($data);
    }

    public function updateEducation($id, $data)
    {
        return $this->update($id, $data);
    }
}
