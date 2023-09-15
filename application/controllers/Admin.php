<?php
defined('BASEPATH') or exit('No direct script access allowed');

class admin extends CI_Controller
{

    function __construct()
    {
        parent::  __construct();
  $this->load->model('m_model');
  $this->load->helper('my_helper');;
        if ($this->session->userdata('logged_in')!=true) {
            redirect(base_url().'auth');
        }  
    }

    public function index()
    {
        $this->load->view('admin/index');
    }
    public function datasiswa()
    {
        $data['siswa'] = $this->m_model->get_data('siswa')->result();
        $this->load->view('admin/datasiswa' , $data);
    }
    public function tambahsiswa()
    {
        $data['kelas'] = $this->m_model->get_data('kelas')->result();
        $this->load->view('admin/tambahsiswa', $data);
    }
    public function update()
    {
        $data['kelas'] = $this->m_model->get_data('kelas')->result();
        $this->load->view('admin/update', $data);
    }
    public function aksi_tambahsiswa()
    {
        $data=[
            'nama_siswa' => $this->input->post('nama'),
            'nisn' => $this->input->post('nisn'),
            'gender' => $this->input->post('gender'),
            'id_kelas' => $this->input->post('id_kelas'),
        ];
        $this->m_model->tambah_data('siswa', $data);
        redirect(base_url('admin/datasiswa'));
    }

    public function hapus_siswa($id)
    {
       $this->m_model->delete('siswa', 'id_siswa', $id);
        redirect(base_url('admin/datasiswa'));
    }

}
?>
