<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DoctorAbsentModel;
use CodeIgniter\HTTP\ResponseInterface;

class DoctorController extends BaseController
{
    protected $doctorAbsentModel;
    public function __construct()
    {
        $this->doctorAbsentModel = new DoctorAbsentModel();
    }
    public function index()
    {
        //
    }
    public function getDoctorAbsent()
    {
        //

        //$result = $this->doctorAbsentModel->getDoctorAbsentById(user_id());
        $result = $this->doctorAbsentModel->findAll();


        $data = [
            'doctor_absent' => $result,
        ];
        return view('page/doctor_absent/v_doctor_absent_list', $data);
    }
}
