<?php

defined('BASEPATH') or exit('No direct script access allowed');

class B_model extends CI_Model
{
	public function getAvailable_Username($username)
	{
		$query = $this->db->query("SELECT username FROM users WHERE username = '$username'");

		if ($query->num_rows() == 0) {
			return true;
		}

		if ($query->num_rows() == 1) {
			return false;
		}
	}

	public function getAvailable_Nis($nis)
	{
		$query = $this->db->select('nis')
			->from('tabel_siswa')
			->where('nis', $nis)
			->get();

		return $query->result_array();
	}

	public function getAvailable_Nip($nip)
	{
		$query = $this->db->select('nip')
			->from('tabel_pengajar')
			->where('nip', $nip)
			->get();

		return $query->result_array();
	}
}
