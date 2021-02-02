<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Version Control
|--------------------------------------------------------------------------
|
| 'envi' => berisikan pengaturan fase pengembangan (enviroment).
| 'prod' => berisikan pengaturan fase go live (production).
| 'maintenance' => non-aktifkan fase go live untuk sementara.
|
*/
$ver = 'envi';

switch ($ver) {
	case "maintenance":
		$config = array(
			'version' => 'maintenance',
			'hostname' => 'localhost',
			'username' => '',
			'password' => '',
			'database' => '',
			'dbdriver' => 'mysqli'
		);
		break;
	case "prod":
		$config = array(
			'version' => 'prod',
			'hostname' => 'localhost',
			'username' => '',
			'password' => '',
			'database' => '',
			'dbdriver' => 'mysqli'
		);
		break;
	default:
		$config = array(
			'version' => 'envi',
			'hostname' => 'localhost',
			'username' => 'root',
			'password' => '',
			'database' => 'db_e-filing',
			'dbdriver' => 'mysqli'
		);
		break;
}
