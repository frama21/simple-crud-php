<?php
// INCLUDE KONEKSI KE DATABASE
include_once("config.php");

// AMBIL DATA DARI DATABASE BERDASARKAN DATA TERAKHIR DI INPUT
$result = mysqli_query($mysqli, "SELECT * FROM users ORDER BY id DESC");
?>

<html>

<head>
	<title>Homepage</title>
</head>

<body>
	<center>
		<a href="add.html">Tambah Data Baru</a><br /><br />

		<table width='80%' border=0>

			<tr bgcolor='#CCCCCC'>
				<td>Nama</td>
				<td>Umur</td>
				<td>Email</td>
				<td>Gambar</td>
				<td>Update</td>
			</tr>
			<?php

			while ($res = mysqli_fetch_array($result)) {
				echo "<tr>";
				echo "<td>" . $res['nama'] . "</td>";
				echo "<td>" . $res['umur'] . "</td>";
				echo "<td>" . $res['email'] . "</td>";
				echo "<td><img width='80' src='image/" . $res['gambar'] . "'</td>";
				echo "<td><a href=\"edit.php?id=$res[id]\">Edit</a> | <a href=\"delete.php?id=$res[id]\" onClick=\"return confirm('Kamu yakin untuk delete ini?')\">Delete</a></td>";
			}
			?>
		</table>
	</center>
</body>

</html>
