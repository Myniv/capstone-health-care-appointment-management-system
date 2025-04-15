<?php

namespace App\Libraries;

class DataParams
{
    public $search = '';

    //Product Filter
    public $price_range = '';
    public $category_id = '';

    //User Filter
    public $role = '';

    //DoctorCategoryFilter
    public $doctor_category = '';


    public $sort = 'id';
    public $order = 'asc';
    public $page = 1;
    public $perPage = 10;
    public function __construct(array $params = [])
    {
        $this->search = $params['search'] ?? '';

        $this->category_id = $params['category_id'] ?? '';
        $this->price_range = $params['price_range'] ?? '';

        $this->role = $params['role'] ?? '';

        $this->sort = $params['sort'] ?? 'id';
        $this->order = $params['order'] ?? 'asc';
        $this->page = (int) ($params['page'] ?? 1);
        $this->perPage = (int) ($params['perPage'] ?? 10);
    }

    public function getParams()
    {
        return [
            'search' => $this->search,

            'category_id' => $this->category_id,
            'price_range' => $this->price_range,

            'role' => $this->role,

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