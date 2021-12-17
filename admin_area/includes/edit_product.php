
<?php 
$edit_product  = mysqli_query($con,"select * from products where product_id = '$_GET[product_id]' ");
$fetch_edit = mysqli_fetch_array($edit_product);
?>
<div class="form_box">	
	<form action="" method="post" enctype="multipart/form-data">
		<table align="center" width="100%">
			<tr>
				<td colspan="7">
				<h2>Edit product</h2> 
				<div class="border_bottom"></div>
				</td>
				
			</tr>
			<tr>
				<td>Product Title</td>
				<td><input type="text" name="product_title" value="<?php echo $fetch_edit['product_title']; ?>" size="60" required/></td>
			</tr>
			
			
			<tr>
				<td>Title Slug</td>
				<td><input type="text" name="title_slug" value="<?php echo $fetch_edit['title_slug']; ?>" size="60" required/></td>
			</tr>
			
			<tr>
				<td>Category:</td>
				<td>
				<select name="product_categories" id=""><option value="">Select Category</option>
					<?php
						$get_categories = "select * from categories";
						$run_categories = mysqli_query($con,$get_categories);
						
						while($row_categories=mysqli_fetch_array($run_categories)){
							$categories_id = $row_categories['categories_id'];
							$categories_title = $row_categories['categories_title'];
							
							if($fetch_edit['product_categories'] == $categories_id){
								echo "<option value='$fetch_edit[product_categories]' selected>$categories_title</option>";
							}else{
								echo "<option value='$categories_id'>$categories_title</option>";
							}
							
						}
					?>
				</select>
				</td>
			</tr>
			
			<tr>
				<td valign="top">Product Image:</td>
				<td>
					<input type="file" name="product_image"/>
					<div class="edit_image">
						<img src="product_images/<?php echo $fetch_edit['product_image'];?>" width="100" height="70" />
					</div>
				</td>
			</tr>
			
			<tr>
				<td>Product Price:</td>
				<td><input type="text" name="product_price" value="<?php echo $fetch_edit['product_price'];?>" required/></td>
			</tr>
			
			<tr>
				<td  valign="top">Product Detils:</td>
				<td><textarea name="product_description" rows="10"><?php echo $fetch_edit['product_description'];?></textarea></td>
			</tr>
			
			<tr>
				<td>Product Tag:</td>
				<td><input type="text" name="product_keywords" value="<?php echo $fetch_edit['product_keywords'];?>" required/></td>
			</tr>
			
			<tr>
			<td></td>
				<td colspan="7"><input type="submit" name="edit_post" value="Update"/> </td>
			</tr>
			
		</table>
	</form>
</div>

<?php
	if(isset($_POST['edit_post'])){
		$product_title = trim(mysqli_real_escape_string($con,$_POST['product_title']));
		$title_slug = $_POST['title_slug'];
		$product_categories = $_POST['product_categories'];
		$product_price = $_POST['product_price'];
		$product_description = trim(mysqli_real_escape_string($con,$_POST['product_description']));
		$product_keywords = $_POST['product_keywords'];
		
		$product_image = $_FILES['product_image']['name'];
		$product_image_tmp = $_FILES['product_image']['tmp_name'];
		$date = date("F d,Y");
		
		if(!empty($_FILES['product_image']['name'])){
			if(move_uploaded_file($product_image_tmp,"product_images/$product_image")){
				$update_product = mysqli_query($con,"update products set product_categories ='$product_categories' , product_title ='$product_title', title_slug = '$title_slug', product_price = '$product_price', product_description = '$product_description', product_image = '$product_image', product_keywords = '$product_keywords', date = '$date' where product_id = '$_GET[product_id]' ");
			}
				
		}else{
			$update_product = mysqli_query($con,"update products set product_categories ='$product_categories' , product_title ='$product_title', title_slug ='$title_slug', product_price = '$product_price', product_description = '$product_description', product_keywords = '$product_keywords', date = '$date' where product_id = '$_GET[product_id]' ");
		}
		
		if($update_product){
			echo "<script>alert('Product has been updated successfully')</script>";
			echo "<script>window.open(window.location.href,'_self')</script>";
		}
	}
	

?>
