<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Equipment;
use App\Libraries\DataParams;
use App\Models\EquipmentModel;
use CodeIgniter\HTTP\ResponseInterface;

class EquipmentController extends BaseController
{
    protected $equipmentModel;
    public function __construct()
    {
        $this->equipmentModel = new EquipmentModel();
    }
    public function index()
    {
        $params = new DataParams([
            'status' => $this->request->getGet("status"),

            "search" => $this->request->getGet("search"),
            "sort" => $this->request->getGet("sort"),
            "order" => $this->request->getGet("order"),
            "perPage" => $this->request->getGet("perPage"),
            "page" => $this->request->getGet("page_equipments"),
        ]);

        $result = $this->equipmentModel->getFilteredEquipment($params);

        $data = [
            'equipments' => $result['equipments'],
            'pager' => $result['pager'],
            'total' => $result['total'],
            'params' => $params,
            'baseUrl' => base_url('admin/equipment'),
        ];

        if (!cache()->get("equipment")) {
            cache()->save("equipment", $data['equipments'], 3600);
        }

        return view('page/equipment/v_equipment_list', $data);
    }

    public function create()
    {
        $type = $this->request->getMethod();
        if ($type == "GET") {
            return view('page/equipment/v_equipment_form');
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'function' => $this->request->getPost('function'),
            'stock' => $this->request->getPost('stock'),
            'status' => ''
        ];

        $dataEquipment = new Equipment($data);

        if (!$this->equipmentModel->save($dataEquipment)) {
            return redirect()->back()->withInput()->with('errors', $this->equipmentModel->errors());
        }

        cache()->delete("equipment");

        return redirect()->to(base_url('admin/equipment'))->with('success', 'Data berhasil disimpan.');

    }

    public function update($id)
    {
        $type = $this->request->getMethod();
        if ($type == "GET") {
            $equipment = $this->equipmentModel->find($id);
            $data = [
                'equipment' => $equipment,
            ];
            return view('page/equipment/v_equipment_form', $data);
        }

        $data = [
            'id' => $id,
            'name' => $this->request->getPost('name'),
            'function' => $this->request->getPost('function'),
            'stock' => $this->request->getPost('stock'),
            'status' => ''
        ];

        $dataEquipment = new Equipment($data);

        if (!$this->equipmentModel->save($dataEquipment)) {
            return redirect()->back()->withInput()->with('errors', $this->equipmentModel->errors());
        }

        cache()->delete("equipment");

        return redirect()->to(base_url('admin/equipment'))->with('success', 'Data berhasil disimpan.');
    }

    public function delete($id)
    {
        $this->equipmentModel->delete($id);

        cache()->delete("equipment");
        return redirect()->to(base_url('admin/equipment'))->with('success', 'Data berhasil dihapus.');
    }
}
