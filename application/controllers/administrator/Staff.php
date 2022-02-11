<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Staff extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		if ($this->session->userdata('hak_akses') != 1) {
			$this->session->set_flashdata('error', "<script> alert('Anda Bukan Adminstrator'); </script> ");
			redirect('login');
		}
	}

	public function index()
	{
		$data['staff'] = $this->a_model->getUsers_join_staff();
		$data['mapel'] = $this->a_model->getMapel();
		$data['jabatan'] = $this->a_model->getJabatan();
		$data['myAccount'] = $this->session->userdata('nama_awal');
		$this->load->view('private/admin/control_panel/pengajar/pengajar_panel', $data);
	}

	public function insert()
	{
		$validations = [
		  [
			'field' => 'nip',
			'label' => 'NIP',
			'rules' => 'required|trim',
			],

		  [
			'field' => 'nama_pengajar',
			'label' => 'Nama Lengkap',
			'rules' => 'required|trim',
			],

		  [
			'field' => 'ttl_location',
			'label' => 'TTL',
			'rules' => 'trim',
			],

		  [
			'field' => 'ttl_date',
			'label' => 'Tanggal Lahir',
			'rules' => 'trim',
			],

		  [
			'field' => 'phone',
			'label' => 'No. HP',
			'rules' => 'trim',
			],

		  [
			'field' => 'gender',
			'label' => 'Gender',
			'rules' => 'required|trim',
			],

		  [
			'field' => 'golongan_darah',
			'label' => 'Golongan Darah',
			'rules' => 'trim',
			],

		  [
			'field' => 'email',
			'label' => 'Email',
			'rules' => 'trim',
			],

		  [
			'field' => 'alamat',
			'label' => 'Alamat',
			'rules' => 'trim',
			],

		  [
			'field' => 'jabatan',
			'label' => 'Jabatan',
			'rules' => 'trim',
			],

		  [
			'field' => 'agama',
			'label' => 'Agama',
			'rules' => 'trim',
			],

		  [
			'field' => 'guru_bid_studi',
			'label' => 'Bidang Studi',
			'rules' => 'trim',
			],
	];

		$this->form_validation->set_rules($validations);

		if ($this->form_validation->run() == false) {
			// Jika Ada Kesalahan Buka Ini
			$this->index();
		} else {
			// Cek NIP Jika Tersedia
			$nip_input = $this->input->post('nip');
			$status = $this->b_model->getAvailable_Nip($nip_input);

			if ($status == true) {
				$this->session->set_flashdata(
			  'notif_result',
		  "<script type='text/javascript'>
                          $('.result').html('Terjadi Kesalahan <br/> NIP Sudah Terpakai.')
                              .css('background', '#F1D70E')
                              .css('height', '62px')
                              .fadeIn(1000)
                              .delay(2000)
                              .fadeOut(1000)
          </script>"
		  );
				redirect('administrator/staff');
			} elseif ($status == false) {
				// Jika Tidak ada kesalahan, eksekusi perintah ini...
				$data_staff = [
			  'nip' => $this->input->post('nip'),
			  'id_user' => $this->input->post('nip'),
			  'nama_pengajar' => $this->input->post('nama_pengajar'),
			  'ttl_location' => $this->input->post('ttl_location'),
			  'ttl_date' => $this->input->post('ttl_date'),
			  'phone' => $this->input->post('phone'),
			  'gender' => $this->input->post('gender'),
			  'golongan_darah' => $this->input->post('golongan_darah'),
			  'email' => $this->input->post('email'),
			  'alamat' => $this->input->post('alamat'),
			  'jabatan' => $this->input->post('jabatan'),
			  'agama' => $this->input->post('agama'),
			  'guru_bid_studi' => $this->input->post('guru_bid_studi'),
			];

				$password_default = md5('admin');
				$hak_akses = 2;
				$data_user = [
				'id_user' => $this->input->post('nip'),
				'nama_user' => $this->input->post('nama_pengajar'),
				'hak_akses' => $hak_akses,
				'password' => $password_default,
			  ];

				$insert_staff = $this->a_model->QueryInsert('tabel_pengajar', $data_staff);

				if ($insert_staff == true) {
					$insert_user = $this->a_model->QueryInsert('users', $data_user);

					$this->session->set_flashdata(
				  'notif_result',
			  "<script type='text/javascript'>
                              $('.result').html('Insert Success!!!')
                                  .fadeIn(1000)
                                  .delay(1000)
                                  .fadeOut(1000)
              </script>"
			  );
					redirect('administrator/staff');
				} else {
					$this->session->set_flashdata(
				  'notif_result',
			  "<script type='text/javascript'>
                              $('.result').html('Insert Failed!!!')
                                  .fadeIn(1000)
                                  .delay(1000)
                                  .fadeOut(1000)
              </script>"
			  );
					redirect('administrator/staff');
				}
			}
		}
	}

	public function update($id_pengajar = null)
	{
		$data['users'] = $this->a_model->getUsers();
		$data['pengajar'] = $this->a_model->getPengajar();
		$id_to_update = $id_pengajar;

		$validations = [
		  [
			'field' => 'nip',
			'label' => 'NIP',
			'rules' => 'required|trim',
			],

		  [
			'field' => 'nama_pengajar',
			'label' => 'Nama Pengajar',
			'rules' => 'required|trim',
			],

		  [
			'field' => 'ttl_location',
			'label' => 'TTL',
			'rules' => 'trim',
			],

		  [
			'field' => 'ttl_date',
			'label' => 'Tanggal Lahir',
			'rules' => 'trim',
			],

		  [
			'field' => 'phone',
			'label' => 'No. HP',
			'rules' => 'trim',
			],

		  [
			'field' => 'gender',
			'label' => 'Gender',
			'rules' => 'required|trim',
			],

		  [
			'field' => 'golongan_darah',
			'label' => 'Golongan Darah',
			'rules' => 'trim',
			],

		  [
			'field' => 'email',
			'label' => 'Email',
			'rules' => 'trim',
			],

		  [
			'field' => 'alamat',
			'label' => 'Alamat',
			'rules' => 'trim',
			],

		  [
			'field' => 'jabatan',
			'label' => 'Jabatan',
			'rules' => 'trim',
			],

		  [
			'field' => 'agama',
			'label' => 'Agama',
			'rules' => 'trim',
			],

		  [
			'field' => 'guru_bid_studi',
			'label' => 'Bidang Studi',
			'rules' => 'trim',
			],
	  ];
		$this->form_validation->set_rules($validations);

		if ($this->form_validation->run() == false) {
			// Jika Ada Kesalahan Buka Ini
			redirect('administrator/staff');
		} else {
			// Jika Tidak ada kesalahan, eksekusi perintah ini...
			$data_valid = [
			'nip' => $this->input->post('nip'),
			'nama_pengajar' => $this->input->post('nama_pengajar'),
			'ttl_location' => $this->input->post('ttl_location'),
			'ttl_date' => $this->input->post('ttl_date'),
			'phone' => $this->input->post('phone'),
			'gender' => $this->input->post('gender'),
			'golongan_darah' => $this->input->post('golongan_darah'),
			'email' => $this->input->post('email'),
			'alamat' => $this->input->post('alamat'),
			'jabatan' => $this->input->post('jabatan'),
			'agama' => $this->input->post('agama'),
			'guru_bid_studi' => $this->input->post('guru_bid_studi'),
		  ];
			$where = ['id_pengajar' => $id_to_update];

			$update = $this->a_model->QueryUpdate('tabel_pengajar', $data_valid, $where);

			if ($update == true) {
				$this->session->set_flashdata(
			  'notif_result',
		  "<script type='text/javascript'>
                          $('.result').html('Update Success!!!')
                              .fadeIn(1000)
                              .delay(1000)
                              .fadeOut(1000)
          </script>"
		  );
				redirect('administrator/staff');
			} else {
				$this->session->set_flashdata(
			  'notif_result',
		  "<script type='text/javascript'>
                          $('.result').html('Update Failed!!!')
                              .fadeIn(1000)
                              .delay(1000)
                              .fadeOut(1000)
          </script>"
		  );
				redirect('administrator/staff');
			}
		}
	}

	public function delete($id_staff = null)
	{
		// Validation Data
		$id_user = $this->input->post('id_user');
		$where_id_user = ['id_user' => $id_user];

		$where_id_staff = ['id_pengajar' => $id_staff];
		$delete = $this->a_model->QueryDelete('tabel_pengajar', $where_id_staff);

		if ($delete == true) {
			$delete_from_user = $this->a_model->QueryDelete('users', $where_id_user);
			$this->session->set_flashdata(
		  'notif_result',
	  "<script type='text/javascript'>
                      $('.result').html('Insert Success!!!')
                          .fadeIn(1000)
                          .delay(1000)
                          .fadeOut(1000)
      </script>"
	  );
			redirect('administrator/staff');
		} else {
			$this->session->set_flashdata(
		  'notif_result',
	  "<script type='text/javascript'>
                      $('.result').html('Insert Success!!!')
                          .fadeIn(1000)
                          .delay(1000)
                          .fadeOut(1000)
      </script>"
	  );
			redirect('administrator/staff');
		}
	}

	public function cekNip()
	{
		$input_nip = $_GET['nip'];
		$status = $this->b_model->getAvailable_Nip($input_nip);

		if ($status == true) {
			echo 'failed';
		} else {
			echo 'succes';
		}
	}
}
