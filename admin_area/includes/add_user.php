
<div class="view_product_box">
	<h2>Add New User</h2>
	<div class="border_bottom"></div>
	<form action="" method="post" enctype="multipart/form-data">
	<div class="search_box">
		<input type="text" id="search" placeholder="Search here"/>
	</div>
		<table width="100%">
			<thead>
				<tr>
					<th><input type="checkbox" id="checkAll" />Check</th>
					<th>ID</th>
					<th>Name</th>
					<th>Email</th>
					<th>Image</th>
					<th>Status</th>
					<th>Delete</th>
				</tr>
			</thead>
			<?php 
				$all_users = mysqli_query($con,"select * from users order by user_id DESC ");
				$i=1;
				while($row = mysqli_fetch_array($all_users)){
			?>
			<tbody>
				<tr>
					<td><input type="checkbox" id="deleteAll[]" value="<?php echo $row['product_id']; ?>"/></td>
					<td><?php echo $i; ?></td>
					<td><?php echo $row['user_name']; ?></td>
					<td><?php echo $row['user_email']; ?></td>
					<td><img src="../customer_area/customer_images/<?php echo $row['user_image']; ?>" width="70" height="50" alt="" /></td>

					<td>
						<?php 
						if($row['visible']==1){
							echo "Approved";
						}else{
							echo "Pending";
						}
						?>
					</td>
					<td><a href="index.php?action=view_pro&delete_user=<?php echo $row['user_id']; ?>">Delete</a></td>
					
				</tr>
			</tbody>
				<?php $i++;} ?>
				<tr>
					<td><input type="submit" name="delete_all" value="Remove" /></td>
				</tr>
		</table>
	</form>
</div>

<?php 
if(isset($_GET['delete_user'])){
	$delete_user = mysqli_query($con,"delete from users where user_id = '$_GET[delete_user]' ");
	if($delete_user){
		echo "<script>alert('Product delete successfully.')</script>";
		echo "<script>window.open('index.php?action=view_pro','_self')</script>";
	}else{
		echo "<script>alert('Problem.')</script>";
	}
}

if(isset($_POST['deleteAll'])){
	$remove = $_POST['deleteAll'];
	foreach($remove as $key){
		$run_remove = mysqli_query($con,"delete from users where user_id = '$key' ");
		if($run_remove){
			echo "<script>alert('Selected item delete successfully.')</script>";
			echo "<script>window.open('index.php?action=view_pro','_self')</script>";
		}else{
			echo "<script>alert('Selected item delete successfully.')</script>";
			echo "<script>window.open('index.php?action=view_pro','_self')</script>";
		}
	}
}
?>

