<?php
// INCLUDE KONEKSI KE DATABASE
include_once("config.php");

if (isset($_POST['update'])) {

	// AMBIL ID DATA
	$id = mysqli_real_escape_string($mysqli, $_POST['id']);

	// AMBIL NAMA FILE FOTO SEBELUMNYA
	$data = mysqli_query($mysqli, "SELECT gambar FROM users WHERE id='$id'");
	$dataImage = mysqli_fetch_assoc($data);
	$oldImage = $dataImage['gambar'];

	// AMBIL DATA DATA DIDALAM INPUT
	$nama = mysqli_real_escape_string($mysqli, $_POST['nama']);
	$umur = mysqli_real_escape_string($mysqli, $_POST['umur']);
	$email = mysqli_real_escape_string($mysqli, $_POST['email']);
	$filename = $_FILES['newImage']['name'];

	// CEK DATA TIDAK BOLEH KOSONG
	if (empty($nama) || empty($umur) || empty($email)) {

		if (empty($nama)) {
			echo "<font color='red'>Kolom Nama tidak boleh kosong.</font><br/>";
		}

		if (empty($umur)) {
			echo "<font color='red'>Kolom Umur tidak boleh kosong.</font><br/>";
		}

		if (empty($email)) {
			echo "<font color='red'>Kolom Email tidak boleh kosong.</font><br/>";
		}
	} else {

		// JIKA FOTO DI GANTI
		if (!empty($filename)) {
			$filetmpname = $_FILES['newImage']['tmp_name'];
			$folder = "image/";

			// GAMBAR LAMA DI DELETE
			unlink($folder . $oldImage) or die("GAGAL");

			// GAMBAR BARU DI MASUKAN KE FOLDER
			move_uploaded_file($filetmpname, $folder . $filename);

			// NAMA FILE FOTO + DATA YANG DI GANTIBARU DIMASUKAN
			$result = mysqli_query($mysqli, "UPDATE users SET nama='$nama',umur='$umur',email='$email',gambar='$filename' WHERE id=$id");
		}

		// MEMASUKAN DATA YANG DI UPDATE KECUALI GAMBAR
		$result = mysqli_query($mysqli, "UPDATE users SET nama='$nama',umur='$umur',email='$email' WHERE id=$id");

		// REDIRECT KE HALAMAN INDEX.PHP
		header("Location: index.php");
	}
}
?>
<?php
// AMBIL ID DARI URL
$id = $_GET['id'];

// AMBIL DATA BERDASARKAN ID
$result = mysqli_query($mysqli, "SELECT * FROM users WHERE id=$id");

while ($res = mysqli_fetch_array($result)) {
	$name = $res['nama'];
	$age = $res['umur'];
	$email = $res['email'];
	$image = $res['gambar'];
}
?>
<html>

<head>
	<title>Edit Data</title>
</head>

<body>
	<center>
		<a href="index.php">Home</a>
		<br /><br />

		<form name="form1" method="post" action="edit.php" enctype="multipart/form-data">
			<table border="0">
				<tr>
					<td>Nama</td>
					<td><input type="text" name="nama" value="<?php echo $name; ?>"></td>
				</tr>
				<tr>
					<td>Umur</td>
					<td><input type="text" name="umur" value="<?php echo $age; ?>"></td>
				</tr>
				<tr>
					<td>Email</td>
					<td><input type="text" name="email" value="<?php echo $email; ?>"></td>
				</tr>
				<tr>
					<td>Gambar</td>
					<td><img width="80" src="image/<?php echo $image ?>"></td>
					<td><input type="file" name="newImage"></td>
				</tr>
				<tr>
					<td><input type="hidden" name="id" value=<?php echo $_GET['id']; ?>></td>
					<td><input type="submit" name="update" value="Update"></td>
				</tr>
			</table>
		</form>
	</center>
</body>

</html>
