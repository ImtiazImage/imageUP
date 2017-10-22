<?php 
include 'inc/header.php'; 
include 'lib/config.php';
include 'lib/Database.php';

$db = new Database();
?>


<div class="myform">

	<?php
		if (isset($_POST['submit'])) {
			$permitted = array('jpg','jpeg','png','gif');
			$img_Name = $_FILES['image']['name'];
			$img_size = $_FILES['image']['size'];
			$img_temp = $_FILES['image']['tmp_name'];

			$div = explode('.', $img_Name);
			$file_ext = strtolower(end($div));
			$uniue_image = "uploads/".substr(md5(time()), 0 , 10).'.'.$file_ext;


			move_uploaded_file($img_temp, $uniue_image);
			$query = "INSERT INTO tbl_image(image) VALUES ('$uniue_image')";
			$insert = $db->insert($query);
			if ($insert) {
				echo "<span class='success'>Image Uploaded Successfully!!</span>";
			}else{
				echo "<span class='error'>Image Not Uploaded Successfully!!</span>";
			}

		}
	?>


<form action="" method="POST" enctype="multipart/form-data">
	<table>
		<tr>
			<td>Select Image</td>
			<td> <input type="file" name="image"> </td>
		</tr>
		<tr>
			<td></td>
			<td> <input type="submit" name="submit" value="Upload"> </td>
		</tr>
	</table>
</form>
</div>



<?php include 'inc/footer.php'; ?>
