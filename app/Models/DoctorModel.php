<?php

namespace App\Models;

use App\Entities\Doctor;
use CodeIgniter\Model;

class DoctorModel extends Model
{
    protected $table = 'doctors';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = Doctor::class;
    protected $useSoftDeletes = true;
    protected $protectFields = true;
    protected $allowedFields = [
        'first_name',
        'last_name',
        'phone',
        'address',
        'sex',
        'dob',
        'email',
        'profile_picture',
        'doctor_category_id',
        'user_id',
        'createdAt',
        'updatedAt',
        'deletedAt'
    ];
    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [
        'first_name' => 'required|min_length[2]|max_length[100]',
        'last_name' => 'required|min_length[2]|max_length[100]',
        'phone' => 'required|regex_match[/^[0-9\-\+\s\(\)]+$/]',
        'address' => 'required|max_length[500]',
        'sex' => 'required|in_list[male,female,other]',
        'dob' => 'required|valid_date[Y-m-d]',
        'email' => 'required|valid_email|max_length[150]',
        'profile_picture' => 'permit_empty|max_length[255]',
        'doctor_category_id' => 'permit_empty|integer',
        'user_id' => 'permit_empty|integer',
    ];
    protected $validationMessages = [
        'first_name' => [
            'required' => 'First name is required.',
            'min_length' => 'First name must be at least 2 characters.',
            'max_length' => 'First name must not exceed 100 characters.',
        ],
        'last_name' => [
            'required' => 'Last name is required.',
            'min_length' => 'Last name must be at least 2 characters.',
            'max_length' => 'Last name must not exceed 100 characters.',
        ],
        'phone' => [
            'required' => 'Phone number is required.',
            'regex_match' => 'Phone number format is invalid.',
        ],
        'address' => [
            'required' => 'Address is required.',
            'max_length' => 'Address must not exceed 255 characters.',
        ],
        'sex' => [
            'required' => 'Sex is required.',
            'in_list' => 'Sex must be either Male or Female.',
        ],
        'dob' => [
            'required' => 'Date of birth is required.',
            'valid_date' => 'Date of birth must be in the format YYYY-MM-DD.',
        ],
        'email' => [
            'required' => 'Email is required.',
            'valid_email' => 'Email format is invalid.',
            'max_length' => 'Email must not exceed 150 characters.',
        ],
    ];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    public function getDoctorByUserId($userId)
    {
        return $this->where('user_id', $userId)->first();
    }
}
