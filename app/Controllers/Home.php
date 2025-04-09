<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {

        try {
            $db = \Config\Database::connect();

            //$db = db_connect();

            $db->initialize();

            if ($db->connID) {
                echo "Koneksi database berhasil!";
                print_r($db->getDatabase());
            }

        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
        }

        return view('welcome_message');

    }
}
