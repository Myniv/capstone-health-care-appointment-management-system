<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\DataParams;
use App\Models\InventoryModel;
use CodeIgniter\HTTP\ResponseInterface;

class InventoryController extends BaseController
{
    protected $inventoryModel;
    public function __construct()
    {
        $this->inventoryModel = new InventoryModel();
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

        $result = $this->inventoryModel->getFilteredInventory($params);

        $data = [
            'inventories' => $result['inventories'],
            'pager' => $result['pager'],
            'total' => $result['total'],
            'params' => $params,
            'baseUrl' => base_url('admin/inventory'),
        ];

        return view('page/inventory/v_inventory_list', $data);
    }

    public function create()
    {
        $type = $this->request->getMethod();
        if ($type == "GET") {
            return view('page/inventory/v_inventory_form');
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'function' => $this->request->getPost('function'),
            'status' => $this->request->getPost('status'),
        ];

        if (!$this->inventoryModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->inventoryModel->errors());
        }

        return redirect()->to(base_url('admin/inventory'))->with('success', 'Data berhasil disimpan.');
    }

    public function update($id)
    {
        $type = $this->request->getMethod();
        if ($type == "GET") {
            $inventory = $this->inventoryModel->find($id);
            $data = [
                'inventory' => $inventory,
            ];
            return view('page/inventory/v_inventory_form', $data);
        }

        $data = [
            'id' => $id,
            'name' => $this->request->getPost('name'),
            'function' => $this->request->getPost('function'),
            'status' => $this->request->getPost('status'),
        ];

        if (!$this->inventoryModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->inventoryModel->errors());
        }

        return redirect()->to(base_url('admin/inventory'))->with('success', 'Data berhasil disimpan.');
    }

    public function delete($id)
    {
        $this->inventoryModel->delete($id);
        return redirect()->to(base_url('admin/inventory'))->with('success', 'Data berhasil dihapus.');
    }
}
