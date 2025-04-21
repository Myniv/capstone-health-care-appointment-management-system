<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\DataParams;
use App\Models\EquipmentModel;
use App\Models\EquipmentRoomModel;
use App\Models\InventoryModel;
use App\Models\InventoryRoomModel;
use App\Models\RoomModel;
use CodeIgniter\HTTP\ResponseInterface;

class RoomController extends BaseController
{
    protected $roomModel;
    protected $equipmentModel;
    protected $inventoryModel;
    protected $equipmentRoomModel;
    protected $inventoryRoomModel;

    public function __construct()
    {
        $this->roomModel = new RoomModel();
        $this->equipmentModel = new EquipmentModel();
        $this->inventoryModel = new InventoryModel();
        $this->equipmentRoomModel = new EquipmentRoomModel();
        $this->inventoryRoomModel = new InventoryRoomModel();

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

    public function createRoomEquipment($id)
    {
        $type = $this->request->getMethod();
        if ($type == "GET") {
            $room = $this->roomModel->find($id);
            $equipments = $this->equipmentModel->findAll();
            $roomEquipments = $this->equipmentRoomModel->getEquipmentRoom($id);
            $data = [
                'room' => $room,
                'equipments' => $equipments,
                'room_equipment' => $roomEquipments
            ];
            return view('page/room/v_room_equipment_form', $data);
        }

        if ($type == "POST") {
            $equipmentIds = $this->request->getPost('equipmentIds');
            $deletedEquipmentIds = $this->request->getPost('deletedEquipmentIds');
            if (!empty($deletedEquipmentIds || $deletedEquipmentIds != null)) {
                $checkDeletedEquipments = $this->equipmentRoomModel->where('room_id', $id)->where('equipment_id', $deletedEquipmentIds)->first();
                if ($checkDeletedEquipments != "" || $checkDeletedEquipments != null) {
                    $this->equipmentRoomModel->delete($checkDeletedEquipments->id);
                }
            }

            if (!empty($equipmentIds)) {
                $equipmentPairs = explode(',', $equipmentIds);

                foreach ($equipmentPairs as $pair) {
                    list($equipmentId, $quantity) = explode(':', $pair);

                    $equipmentId = (int) $equipmentId;
                    $quantity = (int) $quantity;

                    $existtingRoomEquipments = $this->equipmentRoomModel->getEquipmentRoomById($id, $equipmentId);

                    if ($existtingRoomEquipments) {
                        $currentQuantity = $existtingRoomEquipments->total;

                        $this->equipmentRoomModel->save([
                            'id' => $existtingRoomEquipments->id,
                            'total' => $quantity
                        ]);

                        $stock = $this->equipmentModel->find($equipmentId)->stock;

                        if ($quantity > $currentQuantity) {
                            // Quantity increased → reduce stock
                            $stockDecrement = $quantity - $currentQuantity;
                            $this->equipmentModel->save([
                                'id' => $equipmentId,
                                'stock' => $stock - $stockDecrement
                            ]);
                        } else if ($quantity < $currentQuantity) {
                            // Quantity decreased → increase stock
                            $stockIncrement = $currentQuantity - $quantity;
                            $this->equipmentModel->save([
                                'id' => $equipmentId,
                                'stock' => $stock + $stockIncrement
                            ]);
                        }
                    } else {
                        // New assignment
                        $this->equipmentRoomModel->save([
                            'room_id' => $id,
                            'equipment_id' => $equipmentId,
                            'total' => $quantity
                        ]);

                        $stock = $this->equipmentModel->find($equipmentId)->stock;

                        $this->equipmentModel->save([
                            'id' => $equipmentId,
                            'stock' => $stock - $quantity
                        ]);
                    }

                }
            }

            return redirect()->to(base_url('admin/room/detail/' . $id))->with('success', 'Data berhasil disimpan.');
        }
    }

    public function createRoomInventory($id)
    {
        $type = $this->request->getMethod();
        if ($type == "GET") {
            $room = $this->roomModel->find($id);

            // Fetch all available inventory
            $inventories = $this->inventoryModel->findAll();

            // Fetch existing room inventory with names
            $room_inventory = $this->inventoryRoomModel->getInventoryRoom($id);

            return view('page/room/v_room_inventory_form', [
                'room' => $room,
                'inventories' => $inventories,
                'room_inventory' => $room_inventory
            ]);
        }

        if ($type == "POST") {
            // Validate and save room inventory
            $inventoryIds = $this->request->getPost('inventoryIds');
            $deletedInventoryIds = $this->request->getPost('deletedInventoryIds');

            // Delete removed inventory
            if (!empty($deletedInventoryIds)) {
                $deletedIds = explode(',', $deletedInventoryIds);
                $this->inventoryModel->save([
                    'id' => $deletedIds,
                    'status' => "Available"
                ]);
                $this->inventoryRoomModel->where('room_id', $id)
                    ->whereIn('inventory_id', $deletedIds)
                    ->delete();
            }

            if (!empty($inventoryIds)) {
                $inventoryList = explode(',', $inventoryIds);

                foreach ($inventoryList as $inventoryId) {
                    // Check if this inventory is already associated with the room
                    $existing = $this->inventoryRoomModel
                        ->where('room_id', $id)
                        ->where('inventory_id', $inventoryId)
                        ->first();

                    if (!$existing) {
                        // Create new association
                        $this->inventoryRoomModel->insert([
                            'room_id' => $id,
                            'inventory_id' => $inventoryId,
                            'created_at' => date('Y-m-d H:i:s')
                        ]);

                        $this->inventoryModel->save([
                            'id' => $inventoryId,
                            'status' => "In Use"
                        ]);
                    }
                }
            }

            return redirect()->to(base_url('admin/room/detail/' . $id))->with('success', 'Data berhasil disimpan.');
        }
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

    public function detail($id)
    {
        $room = $this->roomModel->find($id);
        $inventories = $this->inventoryRoomModel->getInventoryRoom($id);
        $equipments = $this->equipmentRoomModel->getEquipmentRoom($id);

        $data = [
            'room' => $room,
            'inventories' => $inventories,
            'equipments' => $equipments
        ];
        return view('page/room/v_room_detail', $data);
    }
}
