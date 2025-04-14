<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Roles extends BaseConfig
{
    public const ADMIN = 'administrator';
    public const DOCTOR = 'doctor';
    public const PATIENT = 'patient';
}
