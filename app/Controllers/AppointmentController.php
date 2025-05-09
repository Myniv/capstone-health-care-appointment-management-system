<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\DataParams;
use App\Models\AppointmentModel;
use App\Models\DoctorModel;
use App\Models\DoctorScheduleModel;
use App\Models\EducationModel;
use App\Models\PatientModel;
use App\Models\SettingModel;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Roles;
use DateTime;

class AppointmentController extends BaseController
{
    protected $appointmentModel;
    protected $doctorModel;
    protected $doctorScheduleModel;
    protected $patientModel;
    protected $educationModel;
    protected $settingModel;


    public function __construct()
    {
        $this->appointmentModel = new AppointmentModel();
        $this->doctorModel = new DoctorModel();
        $this->doctorScheduleModel = new DoctorScheduleModel();
        $this->patientModel = new PatientModel();
        $this->educationModel = new EducationModel();
        $this->settingModel = new SettingModel();
    }

    public function index()
    {
        if (in_groups(Roles::DOCTOR)) {
            $doctorId = $this->doctorModel->getDoctorByUserId(user_id())->id;
            $params = new DataParams([
                "search" => $this->request->getGet("search"),
                "date" => $this->request->getGet("date"),
                "sort" => $this->request->getGet("sort"),
                "order" => $this->request->getGet("order"),
                "perPage" => $this->request->getGet("perPage"),
                "page" => $this->request->getGet("page_appointments"),
                "doctor" => $doctorId,
            ]);

            $baseUrl = base_url('doctor/appointment');
        } else if (in_groups(Roles::PATIENT)) {
            $patientId = $this->patientModel->getPatientByUserId(user_id())->id;
            $params = new DataParams([
                "search" => $this->request->getGet("search"),
                "date" => $this->request->getGet("date"),
                "sort" => $this->request->getGet("sort"),
                "order" => $this->request->getGet("order"),
                "perPage" => $this->request->getGet("perPage"),
                "page" => $this->request->getGet("page_appointments"),
                "patient" => $patientId,
            ]);
            $baseUrl = base_url('appointment');
        } else { //Admin
            $params = new DataParams([
                "search" => $this->request->getGet("search"),
                "date" => $this->request->getGet("date"),
                "sort" => $this->request->getGet("sort"),
                "order" => $this->request->getGet("order"),
                "perPage" => $this->request->getGet("perPage"),
                "page" => $this->request->getGet("page_appointments"),
            ]);
            $baseUrl = base_url('admin/appointment');
        }

        $result = $this->appointmentModel->getSortedAppointment($params);

        $data = [
            'appointment' => $result['appointments'],
            'pager' => $result['pager'],
            'total' => $result['total'],
            'params' => $params,
            'baseUrl' => $baseUrl,
        ];
        return view('page/appointment/v_appointment_list', $data);
    }

    public function cancelAppointment()
    {
        $appointmentId = $this->request->getPost('appointmentId');
        $appointment = $this->appointmentModel->find($appointmentId);
        $nowDate = new DateTime();
        $appointmentDate = new DateTime($appointment->date);
        $diff = $nowDate->diff($appointmentDate)->days;


        if ($appointmentDate < $nowDate) {
            if ($diff < 3) {
                return redirect()->back()
                    ->with('message', "Cancellations must be made at least 3 days before the appointment date")
                    ->withInput();
            }
            return redirect()->back()
                ->with('message', "The appointment date has already passed.")
                ->withInput();
        }


        $appointment->status = 'cancel';
        $this->appointmentModel->update($appointmentId, $appointment);
        return redirect()->back()->with('success', 'Appointment cancelled');
    }

    public function detail($id)
    {
        //
        $appointmentId = $id;
        $appointment = $this->appointmentModel
            ->select('doctors.first_name as doctorFirstName,
                doctors.last_name as doctorLastName,
                doctors.id as doctorId,
                patients.user_id as patientUserId,
                patients.first_name as patientFirstName,
                patients.last_name as patientLastName,
                doctor_schedules.start_time,
                doctor_schedules.end_time,
                appointments.date,
                rooms.name as roomName,
                rooms.id as roomId,
                appointments.documents,
                appointments.id as id,
                appointments.status as status,
                appointments.is_reschedule as is_reschedule')
            ->join('doctors', 'appointments.doctor_id = doctors.id')
            ->join('doctor_schedules', 'appointments.doctor_schedule_id = doctor_schedules.id')
            ->join('patients', 'patients.id = appointments.patient_id')
            ->join('rooms', 'rooms.id = doctor_schedules.room_id')
            ->where('appointments.id', $appointmentId)
            ->first();
        $education = $this->educationModel->where('doctor_id', $appointment->doctorId)->findAll();
        $doctor = $this->doctorModel->getDoctorWithCategoryName($appointment->doctorId);

        $setting = $this->settingModel->where('key', 'cancel_due')->first();

        if (empty($setting) || empty($setting->value) || !ctype_digit($setting->value)) {
            $cancelDue = 3;
        } else {
            $cancelDue = (int) $setting->value;
        }

        $data = [
            'appointment' => $appointment,
            'doctor' => $doctor,
            'education' => $education,
            'cancelDue' => $cancelDue
        ];
        return view('page/appointment/v_appointment_detail', $data);
    }

    public function createAppointment()
    {
        $type = $this->request->getMethod();
        if ($type == "GET") {

            $params = new DataParams([
                "search" => $this->request->getGet("search"),
                "sort" => $this->request->getGet("sort"),
                "order" => $this->request->getGet("order"),
                "perPage" => $this->request->getGet("perPage"),
                "page" => $this->request->getGet("page_doctors"),
            ]);
            $result = $this->doctorModel->getFilteredDoctors($params);

            $data = [
                'doctors' => $result['doctors'],
                'pager' => $result['pager'],
                'total' => $result['total'],
                'params' => $params,
                'baseUrl' => base_url('/find-doctor'),
            ];

            return view('page/appointment/v_appointment_doctor_list', $data);
        }
    }

    public function createAppointmentSubmit()
    {

        $patient = $this->patientModel->where('user_id', user_id())->first();
        $doctor = $this->doctorModel->find($this->request->getVar('id'));

        $room_id = null;

        if ($this->request->getVar('schedule')) {
            $room_id = $this->doctorScheduleModel->find($this->request->getVar('schedule'))->room_id;
        }

        $isAppointmentExist = $this->appointmentModel
            ->where('patient_id', $patient->id)
            ->where('date', $this->request->getVar('date'))
            ->where('doctor_schedule_id', $this->request->getVar('schedule'))
            ->countAllResults();

        if ($isAppointmentExist > 0) {
            return redirect()->back()
                ->with('errors', ['You already made an Appointment with the doctor at the choosen time'])
                ->withInput();
        }


        $documents = $this->request->getFile('documents');
        $docName = '';
        if ($documents && $documents->isValid() && !$documents->hasMoved()) {
            $docName = 'documents' . '_' . $patient->user_id . '_' . date('Y_m_d') . '_' . time() . '.' . $documents->getClientExtension();

            $uploadPath = WRITEPATH . 'uploads/' . 'patients/' . $patient->user_id . '/' . 'documents' . '/';

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }


            $picturePath = $uploadPath . $docName;
            $documents->move($uploadPath, $docName);

            $relativePath = 'uploads/' . 'patients/' . $patient->user_id . '/' . 'documents' . '/' . $docName;
            $patientData['documents'] = $relativePath;
        }

        $data = [
            'patient_id' => $patient->id,
            'doctor_schedule_id' => $this->request->getVar('schedule'),
            'doctor_id' => $this->request->getVar('id'),
            'date' => $this->request->getVar('date'),
            'room_id' => $room_id,
            'status' => 'booking',
            'documents' => $docName,
            'reason_for_visit' => $this->request->getVar('reason'),
            'is_reschedule' => 'false'
        ];

        $result = $this->appointmentModel->addAppointment($data);
        if (!$result) {
            return redirect()->back()
                ->with('errors', $this->appointmentModel->errors())
                ->withInput();
        }

        $appointment = $this->appointmentModel->find($this->appointmentModel->getInsertID());

        $send = $this->sendEmail($doctor, $patient, $appointment);

        if (!$send) {
            return redirect()->back()
                ->with('errors', ['Fail to send email'])
                ->withInput();
        }

        return redirect()->to(base_url('appointment'))->with('success', 'Appointment created successfully');
    }

    private function sendEmail($doctor, $patient, $appointment)
    {
        $email = service('email');
        $email->setTo($patient->email);
        $email->setCC($doctor->email);
        $email->setSubject("Medical Appointment Booking - HealthCare Hospital");
        $appointment_datetime = strtotime($appointment->date);
        // Example: Friday, April 25, 2025
        $appointment_date = date('l, F j, Y', $appointment_datetime);
        // Example: 12:00 AM
        $appointment_time = date('g:i A', $appointment_datetime);
        $data = [
            'title' => "Medical Appointment Booking",
            'patient_name' => $patient->first_name . " " . $patient->last_name,
            'doctor_name' => $doctor->first_name . " " . $doctor->last_name,
            'appointment_date' => $appointment_date,
            'appointment_time' => $appointment_time,
        ];
        $email->setMessage(view('email/email_appointment_booking', $data));

        $filePath = WRITEPATH . 'uploads/' . 'patients/' . $patient->user_id . '/' . 'documents' . '/' . $appointment->documents;
        if (file_exists($filePath)) {
            $email->attach($filePath);
        }


        if ($email->send()) {
            return true;
        }

        return false;
    }

    public function rescheduleAppointmentSubmit()
    {
        $appointment = $this->appointmentModel->find($this->request->getPost('appointmentId'));
        $patient = $this->patientModel->where('user_id', user_id())->first();
        $room_id = null;
        if ($this->request->getVar('schedule')) {
            $room_id = $this->doctorScheduleModel->find($this->request->getVar('schedule'))->room_id;
        }

        $patientId = null;
        if (!$patient) {
            $patientId = $appointment->patient_id;
        } else {
            $patientId = $patient->id;
        }



        $data = [
            'patient_id' => $patientId,
            'doctor_schedule_id' => $this->request->getVar('schedule'),
            'doctor_id' => $this->request->getVar('id'),
            'date' => $this->request->getVar('date'),
            'room_id' => $room_id,
            'status' => 'booking',
            'reason_for_visit' => $this->request->getVar('reason'),
            'is_reschedule' => 'true'
        ];

        //update
        $appointment->doctor_schedule_id = $this->request->getVar('schedule');
        $appointment->reason_for_visit = $this->request->getVar('reason');
        $appointment->date = $this->request->getVar('date');
        $appointment->room_id = $room_id;

        $result = $this->appointmentModel->updateAppointment($appointment->id, $data);
        if (!$result) {
            return redirect()->back()
                ->with('errors', $this->appointmentModel->errors())
                ->withInput();
        }

        if (in_groups(Roles::ADMIN)) {
            return redirect()->to(base_url('admin/appointment'))->with('success', 'Reschedule success');
        } else {
            return redirect()->to(base_url('appointment'))->with('success', 'Reschedule success');
        }
    }

    public function appointmentForm()
    {
        $doctorId = $this->request->getVar('id');
        $doctor = $this->doctorModel->getDoctorWithCategoryName($doctorId);
        $education = $this->educationModel->where('doctor_id', $doctorId)->findAll();

        $data = [
            'type' => 'create',
            'doctor' => $doctor,
            'education' => $education,
            'schedule' => $this->request->getVar('schedule') ?? 0,
            'date' => $this->request->getVar('date') ?? (new DateTime())->format('Y-m-d'),
            'reason' => $this->request->getVar('reason') ?? '',
        ];

        $schedules = $this->doctorScheduleModel
            ->where('doctor_id', $doctorId)
            ->where('status', 'active')
            ->findAll();

        $filteredSchedules = [];

        foreach ($schedules as $schedule) {
            $appointmentCount = $this->appointmentModel
                ->where('doctor_schedule_id', $schedule->id)
                ->where('status', 'booking')
                ->where('date', $data['date']) // Filter by selected date
                ->countAllResults();

            if ($appointmentCount < $schedule->max_patient) {
                $schedule->full = 0;
            } else {
                $schedule->full = 1;
            }
            $filteredSchedules[] = (object) $schedule;
        }

        //reset the schedule value
        $data['schedule'] = 0;


        $data['doctor_schedule'] = $filteredSchedules;
        $data['appointment'] = $this->appointmentModel->findAll();

        return view('page/appointment/v_appointment_form', $data);
    }

    public function appointmentRescheduleForm()
    {

        $appointmentId = $this->request->getVar('appointmentId');
        $doctorId = $this->request->getVar('id');
        $appointment = $this->appointmentModel->where('id', $appointmentId)->first();

        $doctor = $this->doctorModel->getDoctorWithCategoryName($doctorId);
        $education = $this->educationModel->where('doctor_id', $doctorId)->findAll();


        $datePicked = (new DateTime())->format('Y-m-d');
        if ($this->request->getVar('date')) {
            $datePicked = $this->request->getVar('date');
        } else {
            $datePicked = (new DateTime($appointment->date))->format('Y-m-d');
        }


        $reason = '';
        if ($this->request->getVar('reason')) {
            $reason = $this->request->getVar('reason');
        } else {
            $reason = $appointment->reason_for_visit;
        }


        $data = [
            'type' => 'reschedule',
            'doctor' => $doctor,
            'appointmentId' => $appointmentId,
            'education' => $education,
            'schedule' => $this->request->getVar('schedule') ?? 0,
            'date' => $datePicked,
            'reason' => $reason ?? '',
        ];

        $schedules = $this->doctorScheduleModel
            ->where('doctor_id', $doctorId)
            ->where('status', 'active')
            ->findAll();

        $filteredSchedules = [];

        foreach ($schedules as $schedule) {
            $appointmentCount = $this->appointmentModel
                ->where('doctor_schedule_id', $schedule->id)
                ->where('status', 'booking')
                ->where('date', $data['date']) // Filter by selected date
                ->countAllResults();

            if ($appointmentCount < $schedule->max_patient) {
                $schedule->full = 0;
            } else {
                $schedule->full = 1;
            }
            $filteredSchedules[] = (object) $schedule;
        }

        //reset the schedule value
        $data['schedule'] = 0;
        $data['doctor_schedule'] = $filteredSchedules;
        //$data['appointment'] = $this->appointmentModel->find($appointmentId);

        return view('page/appointment/v_appointment_form', $data);
    }

    public function previewDocument($filename, $user_id)
    {
        $filePath = WRITEPATH . 'uploads/' . 'patients/' . $user_id . '/' . 'documents' . '/' . $filename;
        if (!is_file($filePath)) {
            return redirect()->back()->with('error', 'File not found.');
        }
        $mime = mime_content_type($filePath);

        return response()
            ->setHeader('Content-Type', $mime)
            ->setHeader('Content-Disposition', 'inline; filename="' . $filename . '"')
            ->setBody(file_get_contents($filePath));
    }
}
