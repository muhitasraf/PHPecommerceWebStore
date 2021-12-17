<?php include("includes/header.php");?>
	
	<div class="content_wrapper">
		<div id="sidebar">
			<div id="sidebar_title">Catagories</div>
				<ul id="cart">	
					<?php
						getCategories();
					?>
				</ul>
		</div>
		
		<div id="content_area">	
			<div class="shopping_cart_container">
				<div id="shopping_cart" align="right" >
					<?php
						if(isset($_SESSION['customer_email'])){
							echo "Your Email:".$_SESSION['customer_email'];	
						}else{
							echo "";
						}
					?>
					<b style="color:blue">Your Cart - </b> Total Items: <?php getTotalItem(); ?>;  Total Price: <?php total_price(); ?>tk
					
				</div>			
				<form action="" method="post" enctype="multipart/form-data">
					<table align="center" width="100%">
						<tr align="center">
							<th>Remove</th>
							<th>Product</th>
							<th>Quality</th>
							<th>Price</th>
						</tr>
						
						<?php
							$total = 0;
							$ip_address = getIpAddress();
							$run_cart = mysqli_query($con," select * from cart where ip_address = '$ip_address' ");
							while($fetch_cart = mysqli_fetch_array($run_cart)){
								$product_id = $fetch_cart['product_id'];
								$result_product = mysqli_query($con," select * from products where product_id = '$product_id' ");
								while($fetch_product = mysqli_fetch_array($result_product)){
									$product_price = array($fetch_product['product_price']);
									$product_title = $fetch_product['product_title'];
									$product_image = $fetch_product['product_image'];
									$single_price = $fetch_product['product_price'];
									$values = array_sum($product_price);
									
									$run_quality = mysqli_query($con," select * from cart where product_id = '$product_id' ");
									$row_quality = mysqli_fetch_array($run_quality);
									$quality = $row_quality ['quality'];
									$values_quality = $values *	$quality;
									$total = $total + $values_quality;
									
							
						?>
						<tr align="center">
							<td><input type="checkbox" name="remove[]" value="<?php echo $product_id; ?>" /></td>
							<td><?php echo $product_title; ?>
							<br/>
							<img src="admin_area/product_images/<?php echo $product_image;?>"  />
							</td>
							<td><input type="text" name="quality" size="4" value="<?php echo $quality;?>" /></td>
							<td><?php echo $single_price;?></td>
						</tr>
						<?php }} ?>
						
						<tr >
							<td colspan="4" align="right">Total Price:</td>
							<td><?php echo total_price();?></td>
						</tr>
						
						<tr align="center">
							<td colspan="2"><input type="submit" name="update_cart" value="Update Cart" /></td>
							<td><input type="submit" name="continue" value="Continue Shopping" /></td>
							<td><button><a href="checkout.php" style="text-decoration:none;color:black">Check Out</a></button></td>
						</tr>
					</table>
				</form>
				
				<?php
					if(isset($_POST['remove'])){
					foreach($_POST['remove'] as $remove_id){
							$run_delete = mysqli_query($con,"Delete from cart where product_id='$remove_id' AND ip_address='$ip_address' ");
							if($run_delete){
								echo "<script>window.open('cart.php','_self')</script>";
							}
						}
					}
					
					if(isset($_POST['continue'])){
						echo "<script>window.open('index.php','_self')</script>";
					}
					
					if(isset($_POST['quality'])){
						$run_quality = mysqli_query($con,"Update cart set quality = '$quality' where product_id = '$_GET[product_id]' ip_address='$ip_address' ");
						if($run_quality){
							echo "<script>window.open('cart.php','_self')</script>";
						}
					}

				?>
				
				<div id="products_box">
						
				</div>
			</div>
		</div>
	</div>

<?php include("includes/footer.php");?>		