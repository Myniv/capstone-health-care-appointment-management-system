<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\DataParams;
use App\Models\DoctorAbsentModel;
use App\Models\DoctorModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;
use Config\Roles;

class DoctorController extends BaseController
{
    protected $doctorAbsentModel;
    protected $doctorModel;

    public function __construct()
    {
        $this->doctorAbsentModel = new DoctorAbsentModel();
        $this->doctorModel = new DoctorModel();
    }

    public function index()
    {
        //
    }

    public function dashboard()
    {
        $data = [
            'title' => 'Dashboard Doctor'
        ];

        return view('page/user/v_user_dashboard_doctor', $data);
    }

    public function getDoctorAbsent()
    {
        $params = new DataParams([
            "search" => $this->request->getGet("search"),
            "date" => $this->request->getGet("date"),
            "sort" => $this->request->getGet("sort"),
            "order" => $this->request->getGet("order"),
            "perPage" => $this->request->getGet("perPage"),
            "page" => $this->request->getGet("page_doctor_absent"),
        ]);

        //$result = $this->doctorAbsentModel->getDoctorAbsentById(user_id());
        $result = $this->doctorAbsentModel->getSortedDoctorAbsent($params);

        $data = [
            'doctor_absent' => $result['doctor_absent'],
            'pager' => $result['pager'],
            'total' => $result['total'],
            'params' => $params,
            'baseUrl' => base_url('doctor/absent'),
        ];
        return view('page/doctor_absent/v_doctor_absent_list', $data);
    }

    public function createDoctorAbsent()
    {
        $type = $this->request->getMethod();
        if ($type == "GET") {
            $data['doctor_absent'] = $this->doctorAbsentModel->findAll();
            return view('page/doctor_absent/v_doctor_absent_form', $data);
        }

        $date = $this->request->getPost('date');

        $data = [
            'doctor_id' => $this->doctorModel->getDoctorByUserId(user_id())->id,
            'date' => $date,
            'status' => 'pending',
            'reason' => $this->request->getPost('reason'),
        ];

        $result = $this->doctorAbsentModel->addAbsent($data);

        if (isset($result['error'])) {
            // Pass error message and old input back to the form
            return redirect()->back()->withInput()->with('error', $result['error']);
        }

        return redirect()->to(base_url('doctor/absent'))->with('success', 'Doctor absent requested.');
    }
}
