<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Keuangan extends CI_Controller {
	function __construct()
    {
        parent::  __construct();
     $this->load->model('m_model');
     $this->load->helper('my_helper');
	 if ($this->session->userdata('logged_in')!=true && $this->session->userdata('role') == 'keuangan') {
		redirect(base_url().'auth');
	}  
	}
	public function index()
	{
		$this->load->view('keuangan/index');
	}
	
    public function pembayaran()
    {
        $data['pembayaran'] = $this->m_model->get_data('pembayaran')->result();
        $this->load->view('keuangan/pembayaran' , $data);
    }
	public function tambahbayar()
    {
        $data['pembayaran'] = $this->m_model->get_data('pembayaran')->result();
        $data['siswa'] = $this->m_model->get_data('siswa')->result();
        $this->load->view('keuangan/tambahbayar', $data);
    }
    public function aksi_tambahbayar()
    {
        $data=[
            'id_siswa' => $this->input->post('id_siswa'),
            'jenis_pembayaran' => $this->input->post('jenis_pembayaran'),
            'total_pembayaran' => $this->input->post('total_pembayaran'),
        ];
        $this->m_model->tambah_data('pembayaran', $data);
        redirect(base_url('keuangan/pembayaran'));
    }
	
	public function ubahbayar($id)
    {
        $data['siswa'] = $this->m_model->get_data('siswa')->result();
        $data['pembayaran'] = $this->m_model->get_by_id('pembayaran', 'id_siswa', $id)->row();
        $this->load->view('keuangan/ubahbayar', $data);
    }

    // untuk aksi ubah bayar
    public function aksi_ubah_bayar()
    {
        // Ambil data dari form
        $nama_siswa = $this->input->post('nama_siswa');
        $jenis_pembayaran = $this->input->post('jenis_pembayaran');
        $total_pembayaran = $this->input->post('total_pembayaran');
    
        // Cari ID siswa berdasarkan nama siswa
        $siswa = $this->m_model->get_by_column('siswa', 'nama_siswa', $nama_siswa)->row();
    
        if (!$siswa) {
            // Nama siswa tidak ditemukan, berikan pesan kesalahan
            $this->session->set_flashdata('error', 'Nama siswa tidak ditemukan');
            redirect(base_url('keuangan/pembayaran/' . $this->input->post('id')));
        }
    
        // Buat array dengan data yang akan disimpan
        $data = array(
            'id_siswa' => $siswa->id_siswa,
            'jenis_pembayaran' => $jenis_pembayaran,
            'total_pembayaran' => $total_pembayaran
        );
    
        // Panggil model untuk menyimpan data ke database
        $eksekusi = $this->m_model->ubah_data('pembayaran', $data, array('id' => $this->input->post('id')));
    
        if ($eksekusi) {
            $this->session->set_flashdata('sukses', 'Data berhasil diubah');
            redirect(base_url('keuangan/pembayaran'));
        } else {
            $this->session->set_flashdata('error', 'Gagal mengubah data');
            redirect(base_url('keuangan/pembayaran/' . $this->input->post('id')));
        }
    }
    
    

	
	public function hapus_bayar($id)
    {
       $this->m_model->delete('pembayaran', 'id_siswa', $id);
        redirect(base_url('keuangan/pembayaran'));
    }
}
?>