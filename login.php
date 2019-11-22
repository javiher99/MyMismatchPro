<?php 
	require_once('header.php');
	if(!Func::checkLogin($con)){
		if(isset($_POST['submit'])){
			if(isset($_POST['username']) && isset($_POST['password'])){
				$username = $_POST['username'];
				$password = sha1($_POST['password']);

				$sql = "SELECT *FROM users WHERE user_username = :username AND user_password = :password ";
				$stmt = $con->prepare($sql);
				$stmt->execute(array(':username' => $username, ':password' => $password));

				$row = $stmt->fetch(PDO::FETCH_ASSOC);

				if($row['user_id'] > 0){
					$remember = 0;
					if(isset($_POST["remember"])){
						$remember = 1;
					}
					Func::recordSession($con, $row['user_id'], $remember);
					header("location: index.php");
				}else{
					$error = "Usuario o contraseña no válidos";
				}
			}
		}
	}else{
		header("location: index.php");
	}
	require_once("navnot.php");
?>
	
	<div class="limiter m-t-0">
		<div class="container-login100">
			<div class="wrap-login100 p-l-85 p-r-85 p-t-55 p-b-55">
				<?php
					if(isset($error)){
						echo '<span class="login100-form-title p-b-32">';
						echo '<h3 class="d-flex flex-row justify-content-center rojo">'.$error.'</h3>';
						echo '</span>';
					}
				?>
				<form class="login100-form validate-form flex-sb flex-w" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
					<span class="login100-form-title p-b-32">
						Account Login
					</span>

					<span class="txt1 p-b-11">
						Username
					</span>
					<div class="wrap-input100 validate-input m-b-36" data-validate = "Username is required">
						<input class="input100" type="text" name="username" >
						<span class="focus-input100"></span>
					</div>
					
					<span class="txt1 p-b-11">
						Password
					</span>
					<div class="wrap-input100 validate-input m-b-12" data-validate = "Password is required">
						<span class="btn-show-pass">
							<i class="fa fa-eye"></i>
						</span>
						<input class="input100" type="password" name="password" >
						<span class="focus-input100"></span>
					</div>
					
					<div class="flex-sb-m w-full p-b-48">
						<div class="contact100-form-checkbox">
							<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember">
							<label class="label-checkbox100" for="ckb1">
								Remember me
							</label>
						</div>

						<div>
							<a href="register.php" class="txt3">
								Do you want to join Mismatch?
							</a>
						</div>
					</div>

					<div class="container-login100-form-btn justify-content-center m-t-10">
						<input type="submit" class="btn btn-default btn-lg" value="Log in" id="send" name="submit"/>
					</div>

				</form>
			</div>
		</div>
	</div>

<?php 
    require_once('footer.php');
?>