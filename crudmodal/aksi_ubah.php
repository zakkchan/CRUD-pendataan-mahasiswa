<?php
include "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['bhapus'])) {
        echo "<script>
                if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                    window.location.href = 'aksi_hapus.php?id_mhs={$_POST['id_mhs']}';
                } else {
                    window.history.back();
                }
              </script>";
        exit();
    }

    if (isset($_POST['bsimpan']) || isset($_POST['bubah'])) {
        echo "<script>
                if (!confirm('Apakah Anda yakin ingin menyimpan perubahan ini?')) {
                    window.history.back();
                }
              </script>";
        
        $nim = $_POST['tnim'] ?? '';
        $nama = $_POST['tnama'] ?? '';
        $alamat = $_POST['talamat'] ?? '';
        $prodi = $_POST['tprodi'] ?? '';
        $email = $_POST['temail'] ?? '';
        $telepon = $_POST['ttelepon'] ?? '';
        
        if (isset($_POST['bsimpan'])) {
            if (empty($nim) || !preg_match('/^\d{10}$/', $nim)) {
                echo "<script>alert('NIM harus terdiri dari 10 angka.'); window.history.back();</script>";
                exit();
            }
        }
        if (empty($nama)) {
            echo "<script>alert('Nama tidak boleh kosong.'); window.history.back();</script>";
            exit();
        }
        if (empty($alamat)) {
            echo "<script>alert('Alamat tidak boleh kosong.'); window.history.back();</script>";
            exit();
        }
        if (empty($prodi)) {
            echo "<script>alert('Prodi harus dipilih.'); window.history.back();</script>";
            exit();
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<script>alert('Format email tidak valid.'); window.history.back();</script>";
            exit();
        }
        if (!preg_match('/^\d{10,15}$/', $telepon)) {
            echo "<script>alert('Nomor telepon harus terdiri dari 10-15 digit.'); window.history.back();</script>";
            exit();
        }
        
        if (isset($_POST['bsimpan'])) {
            $query = "INSERT INTO tmhs (NIM, Nama, Alamat, Prodi, email, no_telepon) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($koneksi, $query);
            mysqli_stmt_bind_param($stmt, "ssssss", $nim, $nama, $alamat, $prodi, $email, $telepon);
            
            if (mysqli_stmt_execute($stmt)) {
                echo "<script>alert('Data berhasil disimpan!'); document.location='index.php';</script>";
            } else {
                echo "<script>alert('Data gagal disimpan!'); document.location='index.php';</script>";
            }
            mysqli_stmt_close($stmt);
        }

        if (isset($_POST['bubah'])) {
            $id_mhs = $_POST['id_mhs'] ?? '';
            if (empty($id_mhs) || !is_numeric($id_mhs)) {
                echo "<script>alert('ID mahasiswa tidak valid.'); window.history.back();</script>";
                exit();
            }
            
            $query = "UPDATE tmhs SET Nama = ?, Alamat = ?, Prodi = ?, email = ?, no_telepon = ? WHERE id_mhs = ?";
            $stmt = mysqli_prepare($koneksi, $query);
            mysqli_stmt_bind_param($stmt, "sssssi", $nama, $alamat, $prodi, $email, $telepon, $id_mhs);
            
            if (mysqli_stmt_execute($stmt)) {
                echo "<script>alert('Data berhasil diubah!'); document.location='index.php';</script>";
            } else {
                echo "<script>alert('Data gagal diubah!'); document.location='index.php';</script>";
            }
            mysqli_stmt_close($stmt);
        }
    }
}
?>
