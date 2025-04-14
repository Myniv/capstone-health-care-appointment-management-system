<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\DataParams;
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
        $params = new DataParams([
            "search" => $this->request->getGet("search"),
            "sort" => $this->request->getGet("sort"),
            "order" => $this->request->getGet("order"),
            "perPage" => $this->request->getGet("perPage"),
            "page" => $this->request->getGet("page_users"),
        ]);

        //$result = $this->doctorAbsentModel->getDoctorAbsentById(user_id());
        $result = $this->doctorAbsentModel->getSortedDoctorAbsent($params);


        $data = [
            'doctor_absent' => $result,
        ];

        $data = [
            'doctor_absent' => $result['doctor_absent'],
            'pager' => $result['pager'],
            'total' => $result['total'],
            'params' => $params,
            'baseUrl' => base_url('doctor/absent'),
        ];
        return view('page/doctor_absent/v_doctor_absent_list', $data);
    }
}
