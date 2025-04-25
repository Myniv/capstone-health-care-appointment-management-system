<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DoctorModel;
use App\Models\EducationModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class EducationController extends BaseController
{
    protected $doctorModel;
    protected $educationModel;

    public function __construct()
    {
        $this->doctorModel = new DoctorModel();
        $this->educationModel = new EducationModel();
    }

    public function index()
    {
        //
    }

    public function create()
    {
        $type = $this->request->getMethod();
        if ($type == "GET") {
            $doctorId = $this->request->getVar('d_id');

            $data = [
                'doctor_id' => $doctorId,
            ];
            return view('page/education/v_education_form', $data);
        }


        $data = [
            'doctor_id' => $this->request->getPost('doctor_id'),
            'university' => $this->request->getPost('university'),
            'city' => $this->request->getPost('city'),
            'study_program' => $this->request->getPost('study_program'),
            'degree' => $this->request->getPost('degree'),
            'year' => $this->request->getPost('year'),
        ];

        $result = $this->educationModel->addEducation($data);

        if (!$result) {
            return redirect()->back()
                ->with('errors', $this->educationModel->errors())
                ->withInput();
        }

        $userId = $this->doctorModel->getUserIdByDoctorId($this->request->getPost('doctor_id'));
        return redirect()->to(base_url('admin/users/doctor/profile/' . $userId))->with('success', 'Data added');
    }

    public function update($id)
    {
        $type = $this->request->getMethod();

        if ($type == "GET") {
            $education = $this->educationModel->where('doctor_id', $id)->first();

            $data = [
                'education' => $education,
                'doctor_id' => $id,
            ];

            return view('page/education/v_education_form', $data);
        }

        $data = [
            'id' => $this->request->getPost('education_id'),
            'doctor_id' => $this->request->getPost('doctor_id'),
            'university' => $this->request->getPost('university'),
            'city' => $this->request->getPost('city'),
            'study_program' => $this->request->getPost('study_program'),
            'degree' => $this->request->getPost('degree'),
            'year' => $this->request->getPost('year'),
        ];

        $result = $this->educationModel->updateEducation($this->request->getPost('education_id'), $data);
        if (!$result) {
            return redirect()->back()
                ->with('errors', $this->educationModel->errors())
                ->withInput();
        }

        $userId = $this->doctorModel->getUserIdByDoctorId($this->request->getPost('doctor_id'));
        return redirect()->to(base_url('admin/users/doctor/profile/' . $userId))->with('success', 'Data updated');
    }

    public function delete($educationId, $userId)
    {
        $this->educationModel->delete($educationId);
        return redirect()->to(base_url('admin/users/doctor/profile/' . $userId))->with('success', 'Data updated');
    }
}
