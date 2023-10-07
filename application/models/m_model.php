<?php
class M_model extends CI_Model {
    function get_data($table) {
        return $this->db->get($table);
    }
    function getwhere($table, $data)
    {
        return $this->db->get_where($table, $data);
    }
    function delete($table, $field, $id)
    {
        $data=$this->db->delete($table, array($field => $id));
        return $data;
    }
    function tambah_data($table, $data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }
    function get_by_id($tabel, $id_column, $id)
    {
        $data=$this->db->where($id_column, $id)->get($tabel);
        return $data;
    }
    function ubah_data($tabel, $data, $where)
    {
        $data=$this->db->update($tabel, $data, $where);
        return $this->db->affected_rows();
    }
    public function get_by_column($table, $column, $value)
    {
        return $this->db->get_where($table, array($column => $value));
    }
    public function get_siswa_foto_by_id($id_siswa)
{
    $this->db->select('foto');
    $this->db->from('siswa');
    $this->db->where('id_siswa', $id_siswa);
    $query = $this->db->get();

    if ($query->num_rows() > 0) {
        $result = $query->row();
        return $result->foto;
    } else {
        return false;
    }
}
public function getNamaSiswaByID($id_siswa)
{
    // Gantilah 'siswa' dengan nama tabel yang sesuai di database Anda.
    $this->db->select('nama_siswa');
    $this->db->where('id_siswa', $id_siswa);
    $query = $this->db->get('siswa');

    if ($query->num_rows() > 0) {
        $row = $query->row();
        return $row->nama_siswa;
    } else {
        return null; // Atau Anda bisa mengembalikan nilai default jika ID siswa tidak ditemukan.
    }
}

public function getDataPembayaran() 
{
$this->db->select('pembayaran.id, pembayaran.jenis_pembayaran, pembayaran.total_pembayaran, siswa.nama_siswa, kelas.tingkat_kelas,
kelas.jurusan_kelas');
$this->db->from('pembayaran');
$this->db->join('siswa', 'siswa.id_siswa = pembayaran.id_siswa','left');
$this->db->join('kelas', 'siswa.id_kelas = kelas.id','left');
$query = $this->db->get();

return $query->result();
}

public function get_data_siswa() {
    // Gantilah 'nama_tabel' dengan nama tabel Anda
$this->db->join('kelas', 'siswa.id_kelas = kelas.id','left');

    $query = $this->db->get('siswa');
    
    // Mengembalikan hasil query dalam bentuk array
    return $query->result();
}
// Import
public function get_by_nisn($nisn) 
{
$this->db->select('id_siswa');
$this->db->from('siswa');
$this->db->where('nisn', $nisn);
$query = $this->db->get();

if($query->num_rows()>0) {
    $result = $query->row();
    return $result->id_siswa;
} else {
return false;
}
}

public function get_by_jurusan($jurusan, $tingkat) 
{
    $this->db->select('id');
    $this->db->from('kelas');
    $this->db->where('jurusan_kelas', $jurusan);
    $this->db->where('tingkat_kelas', $tingkat);
    $query = $this->db->get();

    if ($query->num_rows() > 0) {
        $result = $query->row();
        return $result->id;
    } else {
        return false;
    }
}
public function get_mapel_by_id($id_mapel) 
{
    $this->db->select('nama_mapel');
    $this->db->where('id', $id_mapel);
    $query = $this->db->get('mapel');

    if ($query->num_rows() > 0) {
        return $query->row();
    } else {
        return null;
    }
}

// Contoh metode get_kelas_by_id dalam model
public function get_kelas_by_id($id_kelas)
{
    // Gantilah 'nama_kelas' dengan nama kolom yang sesuai di tabel kelas
    $query = $this->db->select('tingkat_kelas', 'jurusan_kelas')
        ->where('id_kelas', $id_kelas)
        ->get('kelas');

    return $query->row();
}


}
?>