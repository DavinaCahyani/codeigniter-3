<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
                            <a href="<?php echo base_url('keuangan/index')?>">Dashboard Keuangan</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('keuangan/pembayaran')?>">Pembayaran</a>
                        </li>
                    </ul>
                </li>
            </ul>

        </nav>
        <!-- content -->
        <div class="card w-100 m-auto p-3">
            <h3 class="text-center">Update</h3>
            <?php foreach($pembayaran as $data_pembayaran): ?>
            <form action="<?php echo base_url('keuangan/aksi_ubah_bayar')?>" enctype="multipart/form-data" method="post"
                class="row">
                <input name="id" type="hidden" value="<?php echo $data_pembayaran->id?>">
                <div class="mb-3 col-6">
                    <label for="siswa" class="form-label">Nama Siswa</label>
                    <select name="id_siswa" class="form-select">
                        <?php foreach ($siswa as $row) : ?>
                        <option value="<?php echo $row->id_siswa ?>">
                            <?php echo $row->nama_siswa ?>
                        </option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="mb-3 col-6">
                    <label for="jenis_pembayaran" class="form-label">Jenis Pembayaran</label>
                    <select name="jenis_pembayaran" id="id_pembayaran" class="form-select">
                        <option selected value="<?php echo $data_pembayaran->jenis_pembayaran ?>">
                            <?php echo $data_pembayaran->jenis_pembayaran ?>
                        </option>
                        <option value="Pembayaran SPP">Pembayaran SPP</option>
                        <option value="Pembayaran Uang Gedung">Pembayaran Uang Gedung</option>
                        <option value="Pembayaran Uang Seragam">Pembayaran Uang Seragam</option>
                    </select>
                </div>
                <div class="mb-3 col-6">
                    <label for="nama" class="form-label">Total Pembayaran</label>
                    <input type="text" class="form-control" id="total_pembayaran" name="total_pembayaran"
                        value="<?php echo $data_pembayaran->total_pembayaran?>">
                </div>
                <div class="mb-3 col-12">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
            <?php endforeach ?>
        </div>
    </div>

</body>

</html>