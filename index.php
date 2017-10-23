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
<table width="100%">
	<tr>
		<th width="30%">No.</th>
		<th width="40%">Image</th>
		<th width="30%">Action</th>
	</tr>
<?php
if (isset($_GET['del'])) {
	$id = $_GET['del'];

	//unlink image
	$query = "SELECT * FROM tbl_image where id='$id'";
	$getImg= $db->read($query);
	if ($getImg) {
	while ($imgres = $getImg->fetch_assoc()){
		$delimg = $imgres['image'];
		unlink($delimg);
		}
	}

	$query = "DELETE FROM tbl_image WHERE id=$id";
	$delImage=$db->delete($query);				
	if ($delImage) {
		echo "<span class='success'>Image Deleted Successfully!!</span>";
	}else{
		echo "<span class='error'>Image Not Deleted Successfully!!</span>";
	}
}
?>

<?php
$query = "SELECT * FROM tbl_image";
$getImage= $db->read($query);
if ($getImage) {
	$i=0;
	while ($result = $getImage->fetch_assoc()) {
		$i++;
?>

	<tr>
		<td><?php echo $i; ?></td>
		<td><img src="<?php echo $result['image'];?>" height="40px" width="50px"/></td>
		<td> <a href="?del=<?php echo $result['id']; ?>">Delete</a> </td>
	</tr>

<?php
	}
}
?>

</table>
</div>

<?php include 'inc/footer.php'; ?>
