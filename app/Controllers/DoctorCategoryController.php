<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\DataParams;
use App\Models\DoctorCategoryModel;
use CodeIgniter\HTTP\ResponseInterface;

class DoctorCategoryController extends BaseController
{
    protected $doctorCategoryModel;
    public function __construct()
    {
        $this->doctorCategoryModel = new DoctorCategoryModel();
    }
    public function index()
    {
        $params = new DataParams([
            "search" => $this->request->getGet("search"),

            "sort" => $this->request->getGet("sort"),
            "order" => $this->request->getGet("order"),
            "perPage" => $this->request->getGet("perPage"),
            "page" => $this->request->getGet("page_users"),
        ]);

        $result = $this->doctorCategoryModel->getSortedDoctorCategory($params);
        $data = [
            'doctor_category' => $result['doctor_category'],
            'pager' => $result['pager'],
            'total' => $result['total'],
            'params' => $params,
            'baseUrl' => base_url('admin/doctor-category'),
        ];

        return view('page/doctor_category/v_doctor_category_list', $data);
    }

    public function create()
    {
        $type = $this->request->getMethod();
        if ($type == "GET") {
            return view('page/doctor_category/v_doctor_category_form');
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
        ];

        if (!$this->doctorCategoryModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->doctorCategoryModel->errors());
        }

        return redirect()->to('admin/doctor-category')->with('success', 'Doctor Category Created Successfully');
    }

    public function update($id)
    {
        $type = $this->request->getMethod();
        if ($type == "GET") {
            $doctor_category = $this->doctorCategoryModel->find($id);
            $data = [
                'doctor_category' => $doctor_category,
            ];
            return view('page/doctor_category/v_doctor_category_form', $data);
        }
        $data = [
            'doctor_category_id' => $id,
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
        ];

        if (!$this->doctorCategoryModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $this->doctorCategoryModel->errors());
        }

        return redirect()->to('admin/doctor-category')->with('success', 'Doctor Category Updated Successfully');
    }

    public function delete($id)
    {
        $this->doctorCategoryModel->delete($id);
        return redirect()->to('admin/doctor-category')->with('success', 'Doctor Category Deleted Successfully');
    }
}
