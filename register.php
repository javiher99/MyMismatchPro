<?php 
	require_once('header.php');
	if(Func::checkLogin($con)){
        header("location: index.php");
	}
	require_once("navnot.php");
	if(isset($_POST['submit'])){
		if($_FILES['user_picture']['error'] == 0){
			if($_POST['user_password'] == $_POST['passRepeat']){
				$suf = USER::sufijo();
				$imgsrc = $_FILES['user_picture']['name'];
				$array = explode('.', $imgsrc);
				$nuevonombre = $array[0]."".$suf.".".$array[1];
				$filename = $_FILES['user_picture']['tmp_name'];
				$destination = "./imgs/".$nuevonombre;
				if(move_uploaded_file($filename, $destination)){
					$sentencia = "SELECT * FROM users WHERE user_username = '".$_POST['user_username']."';";
					$db = new DBConnection();
					$select = $db->getQuery($sentencia);
					if($select->rowCount() == 0){
						$user = new User($_POST);
						$user->setDestination($destination);
						$db = new DBConnection();
						$query = "INSERT INTO users VALUES(".implode($user->getAllData(),',').");";
						$afectadas = $db->runQuery($query);
					}else{
						$afectadas = -3;
					}
				}
			}else{
				$afectadas = -1;
			}
		}else{
			$afectadas = -2;
		}
	}
?>
	
	<div class="limiter m-t-0">
		<div class="container-login100">
			<div class="wrap-login100 p-l-85 p-r-85 p-t-55 p-b-55">
				<?php 
					if(isset($afectadas) && $afectadas == 0){
						echo '<span class="login100-form-title p-b-32 ">';
						echo '<h3 class="d-flex flex-row justify-content-center rojo">Usuario no registrado</h3>';
                		echo '</span>';
					}

					if(isset($afectadas) && $afectadas == 1){
						echo '<span class="login100-form-title p-b-32">';
						echo '<h3 class="d-flex flex-row justify-content-center verde">Usuario registrado</h3>';
                		echo '</span>';
					}

					if(isset($afectadas) && $afectadas == -1){
						echo '<span class="login100-form-title p-b-32">';
						echo '<h3 class="d-flex flex-row justify-content-center rojo">Las claves no coinciden</h3>';
                		echo '</span>';
					}

					if(isset($afectadas) && $afectadas == -2){
						echo '<span class="login100-form-title p-b-32">';
						echo '<h3 class="d-flex flex-row justify-content-center rojo">Error al manejar la imágen</h3>';
                		echo '</span>';
					}

					if(isset($afectadas) && $afectadas == -3){
						echo '<span class="login100-form-title p-b-32">';
						echo '<h3 class="d-flex flex-row justify-content-center rojo">Ya existe un usuario con ese username</h3>';
                		echo '</span>';
					}
					
				?>
				
				<form class="login100-form validate-form flex-sb flex-w" action="<?php echo $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
                    
					<span class="login100-form-title p-b-32">
						Register
                    </span>
                    
                    <span class="txt1 p-b-11">
						Username
					</span>
					<div class="wrap-input100 validate-input m-b-12">
						<input class="input100" type="text" name="user_username" required>
						<span class="focus-input100"></span>
					</div>
					
					<span class="txt1 p-b-11">
						Password
					</span>
					<div class="wrap-input100 validate-input m-b-12">
						<span class="btn-show-pass">
							<i class="fa fa-eye"></i>
						</span>
						<input class="input100" type="password" name="user_password" name="pass" required>
						<span class="focus-input100"></span>
					</div>

                    <span class="txt1 p-b-11">
						Repeat Password
					</span>
					<div class="wrap-input100 validate-input m-b-12">
						<span class="btn-show-pass">
							<i class="fa fa-eye"></i>
						</span>
						<input class="input100" type="password" name="passRepeat" required>
						<span class="focus-input100"></span>
					</div>

                    <span class="txt1 p-b-11">
						First Name
					</span>
					<div class="wrap-input100 validate-input m-b-12">
						<input class="input100" type="text" name="user_firstname" required>
						<span class="focus-input100"></span>
					</div>

                    <span class="txt1 p-b-11">
						Last Name
					</span>
					<div class="wrap-input100 validate-input m-b-12">
						<input class="input100" type="text" name="user_lastname" required>
						<span class="focus-input100"></span>
					</div>

                    <span class="txt1 p-b-11">
						Birthdate
					</span>
					<div class="wrap-input100 validate-input m-b-12">
						<input class="input100" type="date" name="user_birthday" required>
						<span class="focus-input100"></span>
					</div>

                    <span class="txt1 p-b-11">
						Gender
					</span>
					<div class="wrap-input100 validate-input m-b-12">
                        <div class="d-flex flex-row justify-content-around m-t-20 m-b-20">
                            <div>
                                <input type="radio" name="user_gender" value="1" checked> Male
                            </div>
                            <div>
                                <input type="radio" name="user_gender" value="2"> Female
                            </div>
                        </div>
						<span class="focus-input100"></span>
					</div>
                    
                    <span class="txt1 p-b-11">
						Picture Profile
					</span>
					<div class="wrap-input100 validate-input m-b-12">
                        <input type="hidden" name="MAX_FILE_SIZE" value="600000"/>
                            <div class="m-t-20 m-b-20">
                                <input type="file" name="user_picture" accept="image/png, image/jpg, image/jpeg" class="data" required/>
                            </div>
						<span class="focus-input100"></span>
                    </div>

                    <span class="txt1 p-b-11">
						State
					</span>
					<div class="wrap-input100 validate-input m-b-12">
						<input class="input100" type="text" name="user_state" required>
						<span class="focus-input100"></span>
                    </div>
                    
                    <span class="txt1 p-b-11">
						City
					</span>
					<div class="wrap-input100 validate-input m-b-12">
						<input class="input100" type="text" name="user_city" required>
						<span class="focus-input100"></span>
                    </div>

					<div class="container-login100-form-btn justify-content-center">
						<input type="submit"  class="btn btn-default btn-lg" value="Register" id="send" name="submit"/>
					</div>

				</form>
			</div>
		</div>
	</div>

<?php 
    require_once('footer.php');
?>