<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\DataParams;
use App\Models\AppointmentModel;
use App\Models\DoctorAbsentModel;
use App\Models\DoctorModel;
use App\Models\EducationModel;
use App\Models\HistoryModel;
use App\Models\PatientModel;
use CodeIgniter\HTTP\ResponseInterface;

class DoctorController extends BaseController
{
    protected $doctorAbsentModel, $doctorModel, $educationModel, $appointmentModel, $patientModel, $historyModel;

    public function __construct()
    {
        $this->doctorAbsentModel = new DoctorAbsentModel();
        $this->doctorModel = new DoctorModel();
        $this->educationModel = new EducationModel();
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

        $doctorId = $this->doctorModel->where('user_id', user_id())->first()->id;

        $result = $this->appointmentModel->getUpcomingAppointmentDoctor($doctorId);

        $data = [
            'title' => 'Dashboard Doctor',
            'appointments' => $result
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

    public function storeHistoryPatient()
    {
        $data = $this->request->getPost();

        $patientId = $this->appointmentModel->where('id', $data['appointment_id'])->first()->patient_id;

        $userId = $this->patientModel->where('id', $patientId)->first()->user_id;

        $data['patient_id'] = $patientId;

        $validationRules = [
            'documents' => [
                'label' => 'Documents',
                'rules' => [
                    // 'uploaded[documents]',
                    'mime_in[documents,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,image/jpg,image/jpeg,image/png]',
                    'max_size[documents,5120]', // 5MB dalam KB (5 * 1024)
                ],
                'errors' => [
                    // 'uploaded' => 'The document must be uploaded.',
                    'mime_in' => 'The document must be a valid file type (PDF, DOC, JPG, JPEG, PNG).',
                    'max_size' => 'The document must not exceed 5 MB in size.',
                ]
            ]
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->with(
                'errors',
                $this->validator->getErrors()
            )->withInput();
        }

        $document = $this->request->getFile('documents');
        if ($document && $document->isValid() && !$document->hasMoved()) {
            $uploadPath = WRITEPATH . 'uploads/' . 'patients/' . $userId . '/' . 'medical_document' . '/';

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $documentName = 'medical_document' . '_' . $userId . '_' . date('Y_m_d') . '_' . time() . '.' . $document->getClientExtension();
            $document->move($uploadPath, $documentName);

            $relativePath = 'uploads/' . 'patients/' . $userId . '/' . 'medical_document' . '/' . $documentName;
            $data['documents'] = $relativePath;
        }

        $existingHistory = $this->historyModel->where('appointment_id', $data['appointment_id'])->first();

        if ($existingHistory) {
            if (!$this->historyModel->update($existingHistory->id, $data)) {
                return redirect()->back()->with('errors', $this->historyModel->errors())->withInput();
            }
        } else {
            if (!$this->historyModel->save($data)) {
                return redirect()->back()->with('errors', $this->historyModel->errors())->withInput();
            }
        }

        $insertedId = $this->historyModel->getInsertID();
        $historyData = $this->historyModel->find($insertedId);

        // set status appointment 'done'
        $appointment = $this->appointmentModel->find($data['appointment_id']);
        $appointment->status = 'done';
        $this->appointmentModel->update($data['appointment_id'], $appointment);

        // send email to patient
        $patient = $this->patientModel->find($patientId);
        $doctor = $this->doctorModel->find($appointment->doctor_id);
        $this->sendEmailHistoryPatient($patient, $doctor, $appointment, $historyData);

        return redirect()->to(base_url('doctor/dashboard'))->with('success', 'History added successfully.');
    }

    public function sendEmailHistoryPatient($patient, $doctor, $appointment, $history)
    {
        $appointment_datetime = strtotime($appointment->date);
        $appointment_date = date('l, F j, Y', $appointment_datetime);
        $appointment_time = date('g:i A', $appointment_datetime);


        $email = service('email');
        $email->setTo($patient->email);
        $email->setSubject('Your Appointment Summary');

        $data = [
            'title' => 'Appointment Summary',
            'patient_name' => $patient->first_name . ' ' . $patient->last_name,
            'doctor_name' => $doctor->first_name . ' ' . $doctor->last_name,
            'appointment_date' => date('F j, Y', strtotime($appointment_date)),
            'appointment_time' => date('g:i A', strtotime($appointment_time)),
            'reason' => $appointment->reason,
            'notes' => $history->notes ?? '',
            'prescriptions' => $history->prescriptions ?? '',
        ];

        // Attach documents if they exist
        if (!empty($history->documents)) {
            $filePath = WRITEPATH . $history->documents; // Adjust if stored in public path
            if (file_exists($filePath)) {
                $email->attach($filePath);
            }
        }

        $email->setMessage(view('email/email_history', $data));
        $email->setMailType('html');
        $email->send();
    }
}
