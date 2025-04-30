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

        $histories = $this->historyModel->getHistoryForDashboard($patientId);

        $data = [
            'appointments' => $appointments,
            'histories' => $histories
        ];

        return view('page/user/v_user_dashboard_patient', $data);
    }

    public function viewMedicalDocument($historyId)
    {
        $patientId = $this->patientModel->where('user_id', user_id())->first()->id;

        $document = $this->historyModel
            ->where('patient_id', $patientId)
            ->where('id', $historyId)
            ->first();

        if (!$document || empty($document->documents)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Medical document not found.');
        }

        $pathDocument = WRITEPATH . ltrim($document->documents, '/');

        if (!file_exists($pathDocument)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('File not found.');
        }

        // detect MIME type file
        $mimeType = mime_content_type($pathDocument);

        // define header Content-Disposition
        $disposition = in_array($mimeType, ['application/pdf', 'image/jpeg', 'image/png']) ? 'inline' : 'attachment';

        return response()
            ->setHeader('Content-Type', $mimeType)
            ->setHeader('Content-Disposition', $disposition . '; filename="' . basename($document->documents) . '"')
            ->setBody(file_get_contents($pathDocument));
    }
}
