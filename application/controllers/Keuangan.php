<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
	public function export()
	{
		$spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $style_col = [
            'font' => ['bold' => true ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'top' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            ]
            ];
        $style_row = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'top' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            ]
        ];

        $sheet->setCellValue('A1', "DATA PEMBAYARAN");
        $sheet->mergeCells('A1:E1');
        $sheet->getStyle('A1')->getFont()->setBold(true);

        $sheet->setCellValue('A3', "ID");
        $sheet->setCellValue('B3', "JENIS PEMBAYARAN");
        $sheet->setCellValue('C3', "TOTAL PEMBAYARAN");
        $sheet->setCellValue('D3', "SISWA");
        $sheet->setCellValue('E3', "KELAS");
       
        $sheet->getStyle('A3')->applyFromArray($style_col);
        $sheet->getStyle('B3')->applyFromArray($style_col);
        $sheet->getStyle('C3')->applyFromArray($style_col);
        $sheet->getStyle('D3')->applyFromArray($style_col);
        $sheet->getStyle('E3')->applyFromArray($style_col);

        $data_pembayaran = $this->m_model->get_data('pembayaran')->result();
        $data['siswa'] = $this->m_model->get_data('siswa')->result();
      


        $no= 1;
        $numrow = 4;
        foreach($data_pembayaran as $data) {
            
        $sheet->setCellValue('A'.$numrow,$data->id);
        $sheet->setCellValue('B'.$numrow,$data->jenis_pembayaran);
        $sheet->setCellValue('C'.$numrow,$data->total_pembayaran);
        $nama_siswa = nama_siswa($data->id_siswa); 
        $sheet->setCellValue('D' . $numrow, $nama_siswa);

      
        $sheet->getStyle('A'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('B'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('C'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('D'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('E'.$numrow)->applyFromArray($style_row);

        $no++;
        $numrow++;

        }

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(30);


        $sheet->getDefaultRowDimension()->setRowHeight(-1);

        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

        $sheet->SetTitle("LAPORAN DATA PEMBAYARAN");

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="PEMBAYARAN.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');

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