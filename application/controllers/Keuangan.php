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
	public function ubahbayar($id) 
    {
		$data['pembayaran'] = $this->m_model->get_by_id('pembayaran', 'id', $id)->result();
		$data['siswa'] = $this->m_model->get_data('siswa')->result();
        $this->load->view('keuangan/ubahbayar', $data);
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
	public function aksi_ubah_bayar()
    {
        $data = array (
            'id_siswa'=> $this->input->post('nama'),
            'jenis_pembayaran'=> $this->input->post('jenis_pembayaran'),
            'total_pembayaran'=> $this->input->post('total_pembayaran'),
        );
        $eksekusi=$this->m_model->ubah_data
        ('pembayaran',$data,array('id_siswa'=>$this->input->post('id_siswa')));
        if($eksekusi)
        {
            $this->session->set_flashdata('sukses','berhasil');
            redirect(base_url('keuangan/pembayaran'));
        }
        else
        {
            $this->session->set_flashdata('error','gagal...');
            redirect(base_url('keuangan/pembayaran/ubah_bayar/'.$this->input->post('id_siswa')));

        }
    }
	public function hapus_bayar($id)
    {
       $this->m_model->delete('pembayaran', 'id_siswa', $id);
        redirect(base_url('keuangan/pembayaran'));
    }
}