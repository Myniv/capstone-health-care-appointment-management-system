<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AppointmentModel;
use App\Models\PatientModel;
use CodeIgniter\HTTP\ResponseInterface;

class PatientController extends BaseController
{
    protected $appointmentModel, $patientModel;

    public function __construct()
    {
        $this->appointmentModel = new AppointmentModel();
        $this->patientModel = new PatientModel();
    }

    public function index()
    {
        //
    }

    public function dashboard()
    {
        $patientId = $this->patientModel->where('user_id', user_id())->first()->id;

        $result = $this->appointmentModel->getUpcomingAppointment($patientId)->first();

        $data = [
            'title' => 'Dashboard',
            'appointment' => $result
        ];

        return view('page/user/v_user_dashboard_patient', $data);
    }
}
