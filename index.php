<?php 
include 'inc/header.php'; 
include 'lib/config.php';
include 'lib/Database.php';

$db = new Database();
?>


<div class="myform">

	<?php
		if (isset($_POST['submit'])) {
			//Image original info.
			$permitted = array('jpg','jpeg','png','gif');
			$img_Name = $_FILES['image']['name'];
			$img_size = $_FILES['image']['size'];
			$img_temp = $_FILES['image']['tmp_name'];

			//Unique name for Image with folder location.
			$div = explode('.', $img_Name);
			$file_ext = strtolower(end($div));
			$uniue_image = "uploads/".substr(md5(time()), 0 , 10).'.'.$file_ext;

			if (empty($img_Name)) {
				echo "<span class='error'>Please Select an Image...</span>";
			}

			elseif ($img_size < 5120) {
				echo "<span class='error'>Image size should be atleast 5kb..</span>";
			}

			elseif (!in_array($file_ext, $permitted)) {
				echo "<span class='error'>You can Upload only:".implode(',', $permitted)."</span>";
			}

			else{
				//Move image to destination folder and insert into database.
				move_uploaded_file($img_temp, $uniue_image);
				$query = "INSERT INTO tbl_image(image) VALUES ('$uniue_image')";
				$insert = $db->insert($query);
				if ($insert) {
					echo "<span class='success'>Image Uploaded Successfully!!</span>";
				}else{
					echo "<span class='error'>Image Not Uploaded Successfully!!</span>";
				}
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
