<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Anti XSS Filter
|--------------------------------------------------------------------------
|
| untuk keamanan XSS Injection dari form input.
|
*/

if (!function_exists('input')) {
	function input($var)
	{
		$ci = get_instance();
		$input = htmlspecialchars(strip_tags(trim($ci->input->post($var, true))), ENT_QUOTES);
		return $input;
	}
}

/*
|--------------------------------------------------------------------------
| Convert htmlentities
|--------------------------------------------------------------------------
|
| untuk mengembalikan tag html yang terenkripsi.
|
*/

if (!function_exists('reverse')) {
	function reverse($var)
	{
		$ci = get_instance();
		$input = html_entity_decode(strtolower($var), ENT_QUOTES, 'UTF-8');
		return $input;
	}
}


/*
|--------------------------------------------------------------------------
| Parse Tanggal Database
|--------------------------------------------------------------------------
|
| merubah format tanggal database menjadi format tanggal indonesia.
|
*/

if (!function_exists('tgl_indo')) {
	function tgl_indo($date)
	{
		$arr_bln = array(
			1 => 'januari', 'februari', 'maret', 'april', 'mei', 'juni', 'jul', 'agustus', 'september', 'oktober', 'november', 'desember'
		);

		$exp = explode('-', $date);

		$d = $exp[2];
		$m = $arr_bln[(int) $exp[1]];
		$y = $exp[0];

		$tgl = $d . ' ' . substr(ucfirst($m), 0, 3) . ' ' . $y;
		return $tgl;
	}
}

function sts_check($id)
{
	$ci = get_instance();

	$result = $ci->db->get_where('tbl_config', ['no' => $id, 'status' => '1']);
	if ($result->num_rows() > 0) {
		return "checked='checked'";
	}
}
