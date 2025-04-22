<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\DataParams;
use App\Models\AppointmentModel;
use App\Models\DoctorModel;
use App\Models\DoctorScheduleModel;
use App\Models\PatientModel;
use CodeIgniter\HTTP\ResponseInterface;
use DateTime;

class AppointmentController extends BaseController
{
    protected $appointmentModel;
    protected $doctorModel;
    protected $doctorScheduleModel;
    protected $patientModel;


    public function __construct()
    {
        $this->appointmentModel = new AppointmentModel();
        $this->doctorModel = new DoctorModel();
        $this->doctorScheduleModel = new DoctorScheduleModel();
        $this->patientModel = new PatientModel();
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
            "page" => $this->request->getGet("page_appointment"),
        ]);

        $result = $this->appointmentModel->getSortedAppointment($params);

        $data = [
            'appointment' => $result['appointment'],
            'pager' => $result['pager'],
            'total' => $result['total'],
            'params' => $params,
            'baseUrl' => base_url('appointment'),
        ];
        return view('page/appointment/v_appointment_list', $data);
    }

    public function detail()
    {
        //
        $appointmentId = $this->request->getVar('appointmentId');
        $appointment = $this->appointmentModel
            ->select('doctors.first_name as doctorFirstName,
                doctors.last_name as doctorLastName,
                patients.first_name as patientFirstName,
                patients.last_name as patientLastName,
                doctor_schedules.start_time,
                doctor_schedules.end_time,
                appointments.date,
                rooms.name as roomName')
            ->join('doctors', 'appointments.doctor_id = doctors.id')
            ->join('doctor_schedules', 'appointments.doctor_schedule_id = doctor_schedules.id')
            ->join('patients', 'patients.id = appointments.patient_id')
            ->join('rooms', 'rooms.id = doctor_schedules.room_id')
            ->where('appointments.id', $appointmentId)
            ->first();


        $data = [
            'appointment' => $appointment,
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
                "page" => $this->request->getGet("page_users"),
            ]);
            $result = $this->doctorModel->getFilteredDoctors($params);

            $data = [
                'doctors' => $result['doctors'],
                'pager' => $result['pager'],
                'total' => $result['total'],
                'params' => $params,
                'baseUrl' => base_url('appointment/create'),
            ];

            return view('page/appointment/v_appointment_doctor_list', $data);
        }
    }

    public function createAppointmentSubmit()
    {
        $patient_id = $this->patientModel->where('user_id', user_id())->first()->id;

        $room_id = null;

        if ($this->request->getVar('schedule')) {
            $room_id = $this->doctorScheduleModel->find($this->request->getVar('schedule'))->room_id;
        }


        $data = [
            'patient_id' => $patient_id,
            'doctor_schedule_id' => $this->request->getVar('schedule'),
            'doctor_id' => $this->request->getVar('id'),
            'date' => $this->request->getVar('date'),
            'room_id' =>  $room_id,
            'status' => 'on going',
            'reason_for_visit' => $this->request->getVar('reason')
        ];

        $result = $this->appointmentModel->addAppointment($data);
        if (isset($result) == false) {
            return redirect()->back()
                ->with('errors', $this->appointmentModel->errors())
                ->withInput();
        }
        return redirect()->to(base_url('appointment'))->with('success', 'Data Berhasil Ditambahkan');
    }


    public function createAppointmentForm()
    {
        $doctorId = $this->request->getVar('id');
        $doctor = $this->doctorModel->find($doctorId);

        $data['doctor'] = $doctor;
        $data['schedule'] = $this->request->getVar('schedule') ?? 0;
        $data['date'] = $this->request->getVar('date') ?? (new DateTime())->format('Y-m-d');
        $data['reason'] = $this->request->getVar('reason') ?? '';

        $schedules = $this->doctorScheduleModel
            ->where('doctor_id', $doctorId)
            ->where('status', 'active')
            ->findAll();

        $filteredSchedules = [];

        foreach ($schedules as $schedule) {
            $appointmentCount = $this->appointmentModel
                ->where('doctor_schedule_id', $schedule->id)
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
}
