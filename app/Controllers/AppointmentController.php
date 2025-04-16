<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\DataParams;
use App\Models\AppointmentModel;
use App\Models\DoctorModel;
use CodeIgniter\HTTP\ResponseInterface;

class AppointmentController extends BaseController
{
    protected $appointmentModel;
    protected $doctorModel;

    public function __construct()
    {
        $this->appointmentModel = new AppointmentModel();
        $this->doctorModel = new DoctorModel();
    }

    public function index()
    {
        //
        $params = new DataParams([
            "search" => $this->request->getGet("search"),
            "date" => $this->request->getGet("date"),
            "sort" => $this->request->getGet("sort"),
            "order" => $this->request->getGet("order"),
            "perPage" => $this->request->getGet("perPage"),
            "page" => $this->request->getGet("page_users"),
        ]);

        $result = $this->appointmentModel->getSortedAppointment($params);

        $data = [
            'appointment' => $result,
        ];

        $data = [
            'appointment' => $result['appointment'],
            'pager' => $result['pager'],
            'total' => $result['total'],
            'params' => $params,
            'baseUrl' => base_url('appointment'),
        ];
        return view('page/appointment/v_appointment_list', $data);
    }

    public function createAppointment()
    {
        $type = $this->request->getMethod();
        if ($type == "GET") {
            $data['doctors'] = $this->doctorModel->findAll();
            return view('page/appointment/v_appointment_doctor_list', $data);
        }


        return redirect()->to('doctor/absent')->with('success', 'Doctor Absent Requested');
    }

    public function createAppointmentForm($id)
    {
        $data['id'] = $id;
        return view('page/appointment/v_appointment_form', $data);
    }
}
