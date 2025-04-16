<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\DataParams;
use App\Models\AppointmentModel;
use App\Models\DoctorModel;
use App\Models\DoctorScheduleModel;
use CodeIgniter\HTTP\ResponseInterface;
use DateTime;

class AppointmentController extends BaseController
{
    protected $appointmentModel;
    protected $doctorModel;
    protected $doctorScheduleModel;


    public function __construct()
    {
        $this->appointmentModel = new AppointmentModel();
        $this->doctorModel = new DoctorModel();
        $this->doctorScheduleModel = new DoctorScheduleModel();
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

        dd($this->request->getVar());


        return redirect()->to('doctor/absent')->with('success', 'Doctor Absent Requested');
    }

    public function createAppointmentSubmit()
    {
        dd($this->request->getVar());
    }


    public function createAppointmentForm()
    {
        $doctor = $this->doctorModel->find($this->request->getVar('id'));
        $data['doctor'] = $doctor;
        $data['schedule'] = $this->request->getVar('schedule') ?? 0;
        $data['date'] = $this->request->getVar('date') ?? (new DateTime())->format('Y-m-d');
        $data['doctor_schedule'] = $this->doctorScheduleModel
            ->where('doctor_id', $this->request->getVar('id'))
            ->where('status', 'active')
            ->findAll();
        $data['reason'] = $this->request->getVar('reason') ?? '';

        return view('page/appointment/v_appointment_form', $data);
    }
}
