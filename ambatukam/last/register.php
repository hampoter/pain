<?php 

include 'config.php';

error_reporting(0);

session_start();

if (isset($_SESSION['username'])) {
    header("Location: index.php");
}

if (isset($_POST['submit'])) {
	$username = $_POST['username'];
	$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);
	//$email = $_POST['email'];
	$password = md5($_POST['password']);
	$cpassword = md5($_POST['cpassword']);

	if ($password == $cpassword) {
		$sql = "SELECT * FROM users WHERE email='$email'";
		$result = mysqli_query($conn, $sql);
		if ($result->num_rows <= 0) {
			$sql = "INSERT INTO users (username, email, password)
					VALUES ('$username', '$email', '$password')";
			$result = mysqli_query($conn, $sql);
			if ($result) {
				echo "<script>alert('Аккаунт успешно создан! .')</script>";
				$username = "";
				$email = "";
				$_POST['password'] = "";
				$_POST['cpassword'] = "";
			} else {
				echo "<script>alert('Упс! Что-то пошло не так.')</script>";
			}
		} else {
			echo "<script>alert('Данная почта уже существует.')</script>";
		}
		
	} else {
		echo "<script>alert('Пароли не совпадают.')</script>";
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Register Form</title>
	<style>
		.div1 {
		  width: 300px;
		  background: #FFFFFF;
		/* Shadow 1 */

		  box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.16);
		  border-radius: 4px;
		  padding: 50px;
		  margin: 20px;
		}

		.myclass{
			font-family: Montserrat;
			font-style: normal;
			font-weight: bold;
			font-size: 16px;
			line-height: 14px;
			/* identical to box height, or 88% */

			letter-spacing: -0.005em;

			/* Brand Colors/CB Green */

			color: #0B4B36;
		}

		.div2 {
		  width: 300px;
		  background: #FFFFFF;
		/* Shadow 1 */

		  box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.16);
		  border-radius: 4px;
		  padding: 50px;
		  margin: 20px;
		}

		.placeholder{
			font-family: Fira Sans;
			font-style: normal;
			font-weight: normal;
			font-size: 16px;
			line-height: 19px;
			/* identical to box height, or 119% */


			/* Layout Colors/Basic/Brown Grey */

			color: #939393;
		}
		</style>


</head>
<body>
	<div class="div1">
		<form method="POST"; >
			<p  style="font-size: 2rem; font-weight: 800; color: #0B4B36;">Регистрация</p>
			<div >
				<label class="myclass">Имя пользователя: </label>
				<input class="placeholder" type="text" placeholder="Введите имя..." name="username" value="<?php echo $username; ?>" required>
			</div>

			<div >
				<label class="myclass">Email</label>
				<input class="placeholder" type="email" placeholder="Введите ваш email..." name="email" value="<?php echo $email; ?>" required>
			</div>

			<div >
				<label class="myclass">Пароль</label>
				<input class="placeholder" type="password" placeholder="Введите пароль..." name="password" value="<?php echo $_POST['password']; ?>" required>
            </div>

            <div >
            	<label class="myclass">Подтверждения пароля</label>
				<input class="placeholder" type="password" placeholder="Подтвердите пароль..." name="cpassword" value="<?php echo $_POST['cpassword']; ?>" required>
			</div>

			<div >
				<button name="submit" class="btn">Подтвердить</button>
			</div>
			<p>Уже есть аккаунт? <a href="index.php">Войдите здесь</a>.</p>
		</form>
	</div>
</body>
</html>