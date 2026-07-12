
<?php
session_start();
include 'config/database.php';

$message = "";

if(isset($_POST['login'])){

    $email = mysqli_real_escape_string(
        $conn,
        $_POST['email']
    );

    $password = $_POST['password'];

    $query = mysqli_query(
        $conn,
        "SELECT * FROM users
        WHERE email='$email'"
    );

    if(mysqli_num_rows($query) > 0){

        $user = mysqli_fetch_assoc($query);

        if(password_verify($password, $user['password'])){

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['fullname'] = $user['fullname'];
            $_SESSION['role'] = $user['role'];

            if($user['role'] == 'admin'){

                header("Location: admin/dashboard.php");
                exit();

            }else{

                header("Location: dashboard.php");
                exit();
            }

        }else{

            $message = "
            <div class='alert alert-danger'>
                Invalid Password
            </div>";
        }

    }else{

        $message = "
        <div class='alert alert-danger'>
            User Not Found
        </div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<title>ADNU-PRINTS Login</title>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#0f2d7a;
}

.login-card{
    border:none;
    border-radius:20px;
}

.logo{
    color:#0f2d7a;
    font-size:32px;
    font-weight:bold;
}

.btn-adnu{
    background:#0f2d7a;
    color:white;
}

.btn-adnu:hover{
    background:#091d4f;
    color:white;
}

</style>

</head>

<body>

<div class="container">

<div class="row vh-100 justify-content-center align-items-center">

<div class="col-md-4">

<div class="card login-card shadow-lg">

<div class="card-body p-5">

<h2 class="text-center logo">
ADNU-PRINTS
</h2>

<p class="text-center text-muted">
Sign in to your account
</p>

<?php echo $message; ?>

<form method="POST">

<div class="mb-3">

<label>Email</label>

<input
type="email"
name="email"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Password</label>

<input
type="password"
name="password"
class="form-control"
required>

</div>

<button
type="submit"
name="login"
class="btn btn-adnu w-100">

Login

</button>

</form>

<hr>

<div class="text-center">

<a href="register.php">
Create Account
</a>

</div>

</div>

</div>

</div>

</div>

</div>

</body>
</html>
```
