<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\DataParams;
use App\Models\RoomModel;
use CodeIgniter\HTTP\ResponseInterface;

class RoomController extends BaseController
{
    protected $roomModel;

    public function __construct()
    {
        $this->roomModel = new RoomModel();
    }
    public function index()
    {
        $params = new DataParams([
            "search" => $this->request->getGet("search"),
            "sort" => $this->request->getGet("sort"),
            "order" => $this->request->getGet("order"),
            "perPage" => $this->request->getGet("perPage"),
            "page" => $this->request->getGet("page_rooms"),
        ]);

        $result = $this->roomModel->getFilteredRoom($params);

        $data = [
            'rooms' => $result['rooms'],
            'pager' => $result['pager'],
            'total' => $result['total'],
            'params' => $params,
            'baseUrl' => base_url('admin/room'),
        ];

        return view('page/room/v_room_list', $data);
    }

    public function create()
    {
        $type = $this->request->getMethod();
        if ($type == "GET") {
            return view('page/room/v_room_form');
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'function' => $this->request->getPost('function'),
            'status' => $this->request->getPost('status'),
        ];

        if (!$this->roomModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->roomModel->errors());
        }

        return redirect()->to(base_url('admin/room'))->with('success', 'Data berhasil disimpan.');
    }

    public function update($id)
    {
        $type = $this->request->getMethod();
        if ($type == "GET") {
            $room = $this->roomModel->find($id);
            $data = [
                'room' => $room,
            ];
            return view('page/room/v_room_form', $data);
        }

        $data = [
            'id' => $id,
            'name' => $this->request->getPost('name'),
            'function' => $this->request->getPost('function'),
            'status' => $this->request->getPost('status'),
        ];

        if (!$this->roomModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->roomModel->errors());
        }

        return redirect()->to(base_url('admin/room'))->with('success', 'Data berhasil disimpan.');
    }

    public function delete($id)
    {
        $this->roomModel->delete($id);
        return redirect()->to(base_url('admin/room'))->with('success', 'Data berhasil dihapus.');
    }
}
