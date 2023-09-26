<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
<style>
/* DEMO STYLE */

@import "https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700";

body {
    font-family: 'Poppins', sans-serif;
    background: #fafafa;
    margin: 0;
    padding: 0;
}

.navbar {
    background: #7386D5;
    padding: 10px 30px;
    /* Tambahkan padding atas dan kiri kanan */
    position: fixed;
    /* Tetapkan posisi navbar */
    width: 100%;
    /* Navbar mencakup seluruh lebar layar */
    top: 0;
    /* Navbar di atas layar */
    z-index: 999;
    /* Agar navbar tetap di atas elemen lain */
    padding-right: 10px;

}

.navbar-brand {
    color: #fff;
    font-size: 24px;
    font-weight: bold;
}

.navbar-toggler-icon {
    background-color: #fff;
}

.navbar-toggler {
    border: none;
}

.navbar-nav .nav-item .nav-link {
    color: #fff;
    transition: all 0.3s;
}

.navbar-nav .nav-item .nav-link:hover {
    color: #6d7fcc;
}

/* SIDEBAR STYLE */

.wrapper {
    display: flex;
}

#sidebar {
    min-width: 250px;
    max-width: 250px;
    background: #7386D5;
    color: #fff;
    transition: all 0.3s;
    /* height: 800px; */
}

#sidebar.active {
    margin-left: -250px;
}

#sidebar .sidebar-header {
    padding: 20px;
    background: #6d7fcc;
}

#sidebar ul.components {
    padding: 20px 0;
    border-bottom: 1px solid #47748b;
    height: 675px;
}

#sidebar ul p {
    color: #fff;
    padding: 10px;
}

#sidebar ul li a {
    padding: 10px;
    font-size: 1.1em;
    display: block;
    color: #fff;
}

#sidebar ul li a:hover {
    background: #6d7fcc;
}

#sidebar ul li.active>a,
a[aria-expanded="true"] {
    background: #6d7fcc;

}

/* Logout style */
.logout {
    padding: 5px;
    /* text-align: center; */
}

.logout a {
    color: #fff;
    text-decoration: none;
}

.logout img {
    width: 20px;
    opacity: 0.5;
    margin-right: 10px;
}

.logout a:hover {
    color: #6d7fcc;
}


/* CONTENT STYLE */

#content {
    flex-grow: 1;
    padding: 20px;
}

.card {
    margin-bottom: 20px;
}

.card-header {
    background: #6d7fcc;
    color: #fff;
}

.card-body {
    background: #7386D5;
    color: #fff;
}
</style>

<body>
    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>Dashboard</h3>
            </div>

            <ul class="list-unstyled components">
                <li class="active">
                    <ul>
                        <li>
                            <a href="<?php echo base_url('admin/index')?>">Dashboard Sekolah</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('admin/datasiswa')?>">Data Siswa</a>
                        </li>
                    </ul>
                </li>
        </nav>
        <!-- content -->
        <div class="card w-100 m-auto p-3">
            <h3 class="text-center">Update</h3>
            <?php foreach($siswa as $data_siswa): ?>
            <form action="<?php echo base_url('admin/aksi_ubah_siswa')?>" encytype="multipart/form-data" method="post"
                class="row">
                <input name="id_siswa" type="hidden" value="<?php echo $data_siswa->id_siswa?>">
                <div class="mb-3 col-6">
                    <label for="nama" class="form-label">Nama Siswa</label>
                    <input type="text" class="form-control" id="nama" name="nama"
                        value="<?php echo $data_siswa->nama_siswa?>">
                </div>
                <div class="mb-3 col-6">
                    <label for="nama" class="form-label">NISN</label>
                    <input type="text" class="form-control" id="nisn" name="nisn"
                        value="<?php echo $data_siswa->nisn?>">
                </div>
                <div class="mb-3 col-6">
                    <label for="gender" class="form-label">Gender</label>
                    <select name="gender" id="gender" class="form-select">
                        <option selected value="<?php echo $data_siswa->gender ?>">
                            <?php echo $data_siswa->gender ?>
                        </option>
                        <option value="Laki-Laki">Laki-Laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
                <div class="mb-3 col-6">
                    <label for="kelas" class="form-label">Kelas</label>
                    <select name="id_kelas" id="kelas" class="form-select">
                        <option selected value="<?php echo $data_siswa->id_kelas ?>">
                            <?php echo tampil_full_kelas_byid($data_siswa->id_kelas)?>
                            <?php foreach ($kelas as $row):?>
                        <option value="<?php echo $row->id ?>">
                            <?php echo $row->tingkat_kelas.' '.$row->jurusan_kelas; ?> </option>
                        <?php endforeach; ?>
                        </option>

                    </select>
                </div>
                <div class="mb-3 col-12">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
            <?php endforeach ?>
        </div>
</body>

</html>