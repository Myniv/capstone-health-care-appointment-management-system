<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\DataParams;
use App\Models\DoctorCategoryModel;
use App\Models\DoctorModel;
use App\Models\DoctorScheduleModel;
use App\Models\RoomModel;
use CodeIgniter\HTTP\ResponseInterface;

class DoctorScheduleController extends BaseController
{
    protected $doctorCategoryModel;
    protected $doctorScheduleModel;
    protected $roomModel;
    protected $doctorModel;
    public function __construct()
    {
        $this->doctorCategoryModel = new DoctorCategoryModel();
        $this->doctorScheduleModel = new DoctorScheduleModel();
        $this->doctorModel = new DoctorModel();
        $this->roomModel = new RoomModel();
    }

    public function index()
    {
        $params = new DataParams([
            "doctor_category" => $this->request->getGet("doctor_category"),

            "search" => $this->request->getGet("search"),
            "sort" => $this->request->getGet("sort"),
            "order" => $this->request->getGet("order"),
            "perPage" => $this->request->getGet("perPage"),
            "page" => $this->request->getGet("page_doctor_schedule"),
        ]);

        $result = $this->doctorScheduleModel->getFilteredDoctorSchedule($params);

        $doctorCategory = $this->doctorCategoryModel->findAll();

        $data = [
            'doctor_schedule' => $result['doctor_schedule'],
            'doctor_category' => $doctorCategory,
            'pager' => $result['pager'],
            'total' => $result['total'],
            'params' => $params,
            'baseUrl' => base_url('admin/doctor-schedule'),
        ];

        if (!cache()->get("doctor_schedule")) {
            cache()->save("doctor_schedule", $data['doctor_schedule'], 3600);
        }

        return view('page/doctor_schedule/v_doctor_schedule_list', $data);
    }

    public function create()
    {
        $type = $this->request->getMethod();
        if ($type == "GET") {
            $doctor = $this->doctorModel->findAll();
            $rooms = $this->roomModel->findAll();

            $data = [
                'doctors' => $doctor,
                'rooms' => $rooms
            ];
            return view('page/doctor_schedule/v_doctor_schedule_form', $data);
        }

        if ($type == "POST") {
            $data = [
                'room_id' => $this->request->getPost('room_id'),
                'doctor_id' => $this->request->getPost('doctor_id'),
                'start_time' => $this->request->getPost('start_time'),
                'end_time' => $this->request->getPost('end_time'),
                'max_patient' => $this->request->getPost('max_patient'),
                'status' => $this->request->getPost('status'),
            ];
            $result = $this->doctorScheduleModel->addSchedule($data);

            if (isset($result['error'])) {
                // Pass error message and old input back to the form
                return redirect()->back()->withInput()->with('error', $result['error']);
            }

            cache()->delete("doctor_schedule");

            return redirect()->to(base_url('admin/doctor-schedule'))->with('success', 'Data Berhasil Ditambahkan');
        }
    }

    public function update($id)
    {
        $type = $this->request->getMethod();
        if ($type == "GET") {
            $doctor_schedule = $this->doctorScheduleModel->find($id);
            $doctor = $this->doctorModel->findAll();
            $rooms = $this->roomModel->findAll();

            $data = [
                'schedule' => $doctor_schedule,
                'doctors' => $doctor,
                'rooms' => $rooms
            ];
            return view('page/doctor_schedule/v_doctor_schedule_form', $data);
        }

        $data = [
            'id' => $id,
            'room_id' => $this->request->getPost('room_id'),
            'doctor_id' => $this->request->getPost('doctor_id'),
            'start_time' => $this->request->getPost('start_time'),
            'end_time' => $this->request->getPost('end_time'),
            'max_patient' => $this->request->getPost('max_patient'),
            'status' => $this->request->getPost('status'),
        ];
        $result = $this->doctorScheduleModel->addSchedule($data);

        if (isset($result['error'])) {
            // Pass error message and old input back to the form
            return redirect()->back()->withInput()->with('error', $result['error']);
        }

        cache()->delete("doctor_schedule");

        return redirect()->to(base_url('admin/doctor-schedule'))->with('success', 'Data Berhasil Ditambahkan');
    }

    public function checkAvailability()
    {
        // Enable CSRF protection for this request
        $this->validateAjaxRequest();

        // Get JSON data from request
        $json = $this->request->getJSON(true);
        $roomId = $json['room_id'] ?? '';
        $startTime = $json['start_time'] ?? '';
        $endTime = $json['end_time'] ?? '';
        $scheduleId = $json['schedule_id'] ?? null; // For edit mode

        // Format times for database comparison (adding today's date)
        $date = date('Y-m-d');
        $startDateTime = $date . ' ' . $startTime;
        $endDateTime = $date . ' ' . $endTime;

        // Query to check for conflicts
        $query = $this->doctorScheduleModel->select('doctor_schedules.*')
            ->where('room_id', $roomId)
            ->groupStart()
            ->where('start_time <', $endDateTime)
            ->where('end_time >', $startDateTime)
            ->groupEnd();

        // Exclude current schedule if in edit mode
        if ($scheduleId) {
            $query->where('id !=', $scheduleId);
        }

        $result = $query->get();

        $conflict = $result->getNumRows() > 0;

        // Return JSON response
        return $this->response->setJSON([
            'conflict' => $conflict,
            'message' => $conflict ? 'Room is already booked during this time.' : null
        ]);
    }

    /**
     * Validate AJAX request
     */
    private function validateAjaxRequest()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON(['error' => 'Direct access not allowed']);
        }
    }

    public function getRoomSchedules($roomId)
    {
        try {
            // Simplify the query first to see if it works
            $schedules = $this->doctorScheduleModel
                ->where('room_id', $roomId)
                ->findAll();

            // Then add doctor names if needed
            $doctorIds = array_column($schedules, 'doctor_id');
            $doctors = [];

            if (!empty($doctorIds)) {
                $doctorResults = $this->doctorModel->whereIn('id', $doctorIds)->findAll();
                foreach ($doctorResults as $doctor) {
                    $doctors[$doctor->id] = $doctor->first_name . ' ' . $doctor->last_name;
                }
            }

            // Format the schedules with doctor names
            foreach ($schedules as &$schedule) {
                $schedule->doctor_name = $doctors[$schedule->doctor_id] ?? 'Unknown Doctor';
                $schedule->start_time = date('H:i', strtotime($schedule->start_time));
                $schedule->end_time = date('H:i', strtotime($schedule->end_time));
            }

            return $this->response->setJSON([
                'success' => true,
                'schedules' => $schedules
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error in getRoomSchedules: ' . $e->getMessage());

            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'error' => 'Failed to fetch room schedules: ' . $e->getMessage()
            ]);
        }
    }

    public function delete($id)
    {
        $this->doctorScheduleModel->delete($id);

        cache()->delete("doctor_schedule");
        return redirect()->to(base_url('admin/doctor-schedule'))->with('success', 'Data Berhasil Dihapus');
    }
}
