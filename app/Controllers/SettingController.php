<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\DataParams;
use App\Models\SettingModel;
use CodeIgniter\HTTP\ResponseInterface;

class SettingController extends BaseController
{
    protected $settingModel;
    public function __construct()
    {
        $this->settingModel = new SettingModel();
    }
    public function index()
    {
        $params = new DataParams([
            "search" => $this->request->getGet("search"),
            "sort" => $this->request->getGet("sort"),
            "order" => $this->request->getGet("order"),
            "perPage" => $this->request->getGet("perPage"),
            "page" => $this->request->getGet("page_settings"),
        ]);

        $result = $this->settingModel->getFilteredSetting($params);

        $data = [
            'settings' => $result['settings'],
            'pager' => $result['pager'],
            'total' => $result['total'],
            'params' => $params,
            'baseUrl' => base_url('admin/setting'),
        ];

        if (!cache()->get("setting")) {
            cache()->save("setting", $data['settings'], 3600);
        }

        return view('page/setting/v_setting_list', $data);
    }

    public function create()
    {
        $type = $this->request->getMethod();
        if ($type == "GET") {
            return view('page/setting/v_setting_form');
        }

        $data = [
            'key' => $this->request->getPost('key'),
            'value' => $this->request->getPost('value'),
            'description' => $this->request->getPost('description'),
        ];

        if (!$this->settingModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->settingModel->errors());
        }

        cache()->delete("setting");

        return redirect()->to(base_url('admin/setting'))->with('success', 'Data berhasil disimpan.');
    }

    public function update($id)
    {
        $type = $this->request->getMethod();
        if ($type == "GET") {
            $setting = $this->settingModel->find($id);
            $data = [
                'setting' => $setting,
            ];
            return view('page/setting/v_setting_form', $data);
        }

        $data = [
            'id' => $id,
            'key' => $this->request->getPost('key'),
            'value' => $this->request->getPost('value'),
            'description' => $this->request->getPost('description'),
        ];

        $this->settingModel->setValidationRule('key', "required|is_unique[settings.key,id,{$id}]");

        if (!$this->settingModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->settingModel->errors());
        }

        cache()->delete("setting");

        return redirect()->to(base_url('admin/setting'))->with('success', 'Data berhasil disimpan.');
    }

    public function delete($id)
    {
        $this->settingModel->delete($id);

        cache()->delete("setting");

        return redirect()->to(base_url('admin/setting'))->with('success', 'Data berhasil dihapus.');
    }
}
