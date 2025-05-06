<?php

namespace App\Libraries;

class DataParams
{
    public $search = '';

    //Date Filter
    public $date = '';

    //User Filter
    public $role = '';

    //DoctorCategoryFilter
    public $doctor_category = '';

    //Status Filter
    public $status = '';

    public $doctor = '';

    public $patient = '';


    public $sort = 'id';
    public $order = 'asc';
    public $page = 1;
    public $perPage = 10;
    public function __construct(array $params = [])
    {
        $this->search = $params['search'] ?? '';

        $this->date = $params['date'] ?? '';

        $this->role = $params['role'] ?? '';

        $this->status = $params['status'] ?? '';

        $this->doctor = $params['doctor'] ?? '';

        $this->patient = $params['patient'] ?? '';

        $this->doctor_category = $params['doctor_category'] ?? '';

        $this->sort = $params['sort'] ?? 'id';
        $this->order = $params['order'] ?? 'desc';
        $this->page = (int) ($params['page'] ?? 1);
        $this->perPage = (int) ($params['perPage'] ?? 10);
    }

    public function getParams()
    {
        return [
            'search' => $this->search,

            'date' => $this->date,

            'role' => $this->role,

            'status' => $this->status,

            'doctor' => $this->doctor,

            'patient' => $this->patient,

            'doctor_category' => $this->doctor_category,

            'sort' => $this->sort,
            'order' => $this->order,
            'page_products' => $this->page,
            'perPage' => $this->perPage,
        ];
    }

    public function getSortUrl($column, $baseUrl)
    {
        $params = $this->getParams();

        $params['sort'] = $column;
        $params['order'] = ($column == $this->sort && $this->order == 'asc') ? 'desc' : 'asc';

        $queryString = http_build_query(array_filter($params));
        return $baseUrl . '?' . $queryString;
    }


    public function getResetUrl($baseUrl)
    {
        return $baseUrl;
    }

    public function isSortedBy($column)
    {
        return $this->sort === $column;
    }

    public function getSortDirection()
    {
        return $this->order;
    }
}
