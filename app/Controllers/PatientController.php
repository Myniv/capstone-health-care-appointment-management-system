<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AppointmentModel;
use App\Models\HistoryModel;
use App\Models\PatientModel;
use CodeIgniter\HTTP\ResponseInterface;

class PatientController extends BaseController
{
    protected $appointmentModel, $patientModel, $historyModel;

    public function __construct()
    {
        $this->appointmentModel = new AppointmentModel();
        $this->patientModel = new PatientModel();
        $this->historyModel = new HistoryModel();
    }

    public function index()
    {
        //
    }

    public function dashboard()
    {
        if (empty(user_id())) {
            return redirect()->to('/login');
        }

        $patientId = $this->patientModel->where('user_id', user_id())->first()->id;

        $appointments = $this->appointmentModel->getUpcomingAppointmentPatient($patientId);

        $histories = $this->historyModel->getHistory();

        $data = [
            'appointments' => $appointments,
            'histories' => $histories
        ];

        return view('page/user/v_user_dashboard_patient', $data);
    }
}
