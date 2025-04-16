<?php
    session_start();
    include "koneksi.php";
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pendataan Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
          rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
          crossorigin="anonymous">
</head>
<body>
<div class="d-flex">
    <!-- Sidebar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success flex-column vh-100 p-3" style="width: 250px;">
        <a class="navbar-brand text-white" href="dashboard.php">Dashboard</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav flex-column">
                <li class="nav-item"><a class="nav-link text-white" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <!-- Konten -->
    <div class="content p-3" style="flex-grow: 1;">
        <div class="container">
            <h3 class="text-center">Pendataan Mahasiswa Universitas Negeri Tangerang</h3>
            <h3 class="text-center">2025 - 2026</h3>

            <div class="card mt-3">
                <div class="card-header bg-success text-white">Data Mahasiswa</div>
                <div class="card-body">
                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">Tambah Data</button>

                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>No.</th><th>NIM</th><th>Nama</th><th>Alamat</th><th>Prodi</th><th>No Telepon</th><th>Email</th><th>Aksi</th>
                        </tr>
                        <?php
                        $no = 1;
                        $result = mysqli_query($koneksi, "SELECT * FROM tmhs ORDER BY id_mhs DESC");
                        while($data = mysqli_fetch_array($result)) :
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $data['NIM'] ?></td>
                            <td><?= $data['Nama'] ?></td>
                            <td><?= $data['Alamat'] ?></td>
                            <td><?= $data['Prodi'] ?></td>
                            <td><?= $data['no_telepon'] ?></td>
                            <td><?= $data['email'] ?></td>
                            
                            <td style="display: flex; gap: 0 10px">
                                <a href="#" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalUbah<?= $data['id_mhs'] ?>">Ubah</a>
                                <a href="aksi_hapus.php?id=<?= $data['id_mhs'] ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                            </td>
                        </tr>

                        <!-- Modal Ubah -->
                        <div class="modal fade" id="modalUbah<?= $data['id_mhs'] ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Ubah Data</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form method="POST" action="aksi_ubah.php">
                                        <input type="hidden" name="id_mhs" value="<?= $data['id_mhs'] ?>">
                                        <div class="modal-body">
                                            <label>NIM</label>
                                            <input type="text" class="form-control" name="tnim" value="<?= $data['NIM'] ?>" readonly>

                                            <label>Nama</label>
                                            <input type="text" class="form-control" name="tnama" value="<?= $data['Nama'] ?>">

                                            <label>Alamat</label>
                                            <textarea class="form-control" name="talamat"><?= $data['Alamat'] ?></textarea>

                                            <label>Prodi</label>
                                            <select class="form-select" name="tprodi" required>
                                                <option value=" <?= $data['Prodi'] ?>"><?= $data['Prodi'] ?></option>
                                                <option value="Sastra Indonesia">Sastra Indonesia</option>
                                                <option value="Sastra Inggris">Sastra Inggris</option>
                                                <option value="Sistem Informatika">Sistem Informatika</option>
                                                <option value="Ilmu Komunikasi">Ilmu Komunikasi</option>
                                                <option value="Ilmu Komputer">Ilmu Komputer</option>
                                                <option value="Hukum">Hukum</option>
                                            </select>

                                            <label>No Telepon</label>
                                            <input type="text" class="form-control" name="ttelepon" value="<?= $data['no_telepon'] ?>">

                                            <label>Email</label>
                                            <input type="email" class="form-control" name="temail" value="<?= $data['email'] ?>">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary" name="bubah">Simpan</button>
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <?php endwhile; ?>
                    </table>

                        <!-- Modal Hapus -->
                        <div class="modal fade" id="modalHapus<?= $data['id_mhs']; ?>" tabindex="-1" aria-labelledby="modalHapusLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="modalHapusLabel">Konfirmasi Hapus</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                    <div class="modal-body"><p>Apakah Anda yakin ingin menghapus data mahasiswa <b><?= $data['Nama']; ?></b>?</p>
                                </div>
                                    <div class="modal-footer">
                                        <form method="POST" action="aksi_hapus.php">
                                            <input type="hidden" name="id_mhs" value="<?= $data['id_mhs']; ?>">
                                                <button type="submit" class="btn btn-danger" name="bhapus">Hapus</button>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <!-- Modal Tambah -->
                    <div class="modal fade" id="modalTambah" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Tambah Data</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form method="POST" action="aksi_tambah.php">
                                    <div class="modal-body">
                                        <label>NIM</label>
                                        <input type="text" class="form-control" name="tnim" required>

                                        <label>Nama</label>
                                        <input type="text" class="form-control" name="tnama" required>

                                        <label>Alamat</label>
                                        <textarea class="form-control" name="talamat" required></textarea>

                                        <label class="form-label">Prodi</label>
                                        <select class="form-select" name="tprodi" required>
                                            <option value="" disabled selected>Pilih Program Studi</option>
                                            <option value="Sastra Indonesia">Sastra Indonesia</option>
                                            <option value="Sastra Inggris">Sastra Inggris</option>
                                            <option value="Sistem Informatika">Sistem Informatika</option>
                                            <option value="Ilmu Komunikasi">Ilmu Komunikasi</option>
                                            <option value="Ilmu Komputer">Ilmu Komputer</option>
                                            <option value="Hukum">Hukum</option>
                                        </select>

                                        <label>No Telepon</label>
                                        <input type="text" class="form-control" name="ttelepon" required>

                                        <label>Email</label>
                                        <input type="email" class="form-control" name="temail" required>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary" name="bsimpan">Simpan</button>
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div> 
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>