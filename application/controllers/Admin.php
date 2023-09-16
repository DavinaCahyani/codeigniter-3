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
        $data['siswa'] = $this->m_model->get_data('siswa')->num_rows();
        $data['mapel'] = $this->m_model->get_data('mapel')->num_rows();
        $data['kelas'] = $this->m_model->get_data('kelas')->num_rows();
        $data['guru'] = $this->m_model->get_data('guru')->num_rows();
        $this->load->view('admin/index', $data);
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
    public function aksi_ubah_siswa()
    {
        $data = array (
            'nama_siswa'=> $this->input->post('nama'),
            'nisn'=> $this->input->post('nisn'),
            'gender'=> $this->input->post('gender'),
            'id_kelas'=> $this->input->post('id_kelas'),
        );
        $eksekusi=$this->m_model->ubah_data
        ('siswa',$data,array('id_siswa'=>$this->input->post('id_siswa')));
        if($eksekusi)
        {
            $this->session->set_flashdata('sukses','berhasil');
            redirect(base_url('admin/datasiswa'));
        }
        else
        {
            $this->session->set_flashdata('error','gagal...');
            redirect(base_url('admin/datasiswa/ubah_siswa/'.$this->input->post('id_siswa')));

        }
    }
    public function ubah_siswa($id) 
    {
        $data['siswa']=$this->m_model->get_by_id('siswa', 'id_siswa', $id)->result();
        $data['kelas']=$this->m_model->get_data('kelas')->result();
        $this->load->view('admin/update', $data);
    }
    

    public function hapus_siswa($id)
    {
       $this->m_model->delete('siswa', 'id_siswa', $id);
        redirect(base_url('admin/datasiswa'));
    }

}
?>
