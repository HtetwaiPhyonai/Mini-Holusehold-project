<!DOCTYPE html>
<html lang="en">
<?php
require(base_path('db-connection.php'));
session_start();
$erroremail = $errorpassword = $errorBox = "";
$email = $password = "";
$check = true;
if (isset($_POST['email'], $_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    if (empty($email) && empty($password)) {
        $erroremail = "*Please enter your email*";
        $errorpassword = "*Please enter your password*";
        $check = false;
    }
    if ($check) {
        $read = "SELECT*FROM register";
        $sqli = mysqli_query($connection, $read);
        while ($row = mysqli_fetch_assoc($sqli)) {
            if ($email === $row['email'] && password_verify($password , $row['password'])) {
                $_SESSION['user']['email'] = $email;
                header("location: http://localhost:3000/category");
            } else {
                $errorBox = "Login Fail! Try again!";
            }
        }
    }
}
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <section class="vh-100 mt-4">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6 text-black ">
                        <div class="card shadow w-100">
                            <div class="card-body">
                                <div class="px-5 ms-xl-4 text-center mt-3">
                                    <span class="h1 fw-bold mb-0 ">Logo</span>
                                </div>
                                <div class="d-flex align-items-center h-custom-2 px-5 ms-xl-4 mt-5 pt-5 pt-xl-0 mt-xl-n5">
                                    <form style="width: 23rem;" method="POST">

                                        <h3 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Log in</h3>

                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form2Example18">Email address</label>
                                            <input name="email" type="email" id="form2Example18" class="form-control form-control-lg" placeholder="Eg.@gmail.com" />
                                            <small class="text-danger" for="form3Example3cg"><?= $erroremail ?></small>
                                        </div>

                                        <div class="form-outline mb-2">
                                            <label class="form-label" for="form2Example28">Password</label>
                                            <input name="password" type="password" id="form2Example28" class="form-control form-control-lg" placeholder="password" />
                                            <small class="text-danger" for="form3Example3cg"><?= $errorpassword ?></small>
                                        </div>

                                        <div class="pt-1 mb-3 d-flex justify-content-center">
                                            <button class="btn btn-primary btn-lg w-50" type="submit">Login</button>
                                        </div>
                                        <p class="small mb-3 pb-lg-2 text-center text-danger"><?= $errorBox ?></p>
                                        <p class="small mb-3 pb-lg-2 text-center"><a class="text-muted" href="#!">Forgot password?</a></p>
                                        <p class="justify-content-center d-flex">Don't have an account? <a href="./register_form" class="fw-bold text-body link-info">Register here</a></p>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <img src="https://img.freepik.com/free-vector/financial-accounting-female-accountant-cartoon-character-making-financial-report-summary-analysis-reporting-financial-statement-income-balance_335657-2380.jpg?size=626&ext=jpg&ga=GA1.1.210238986.1678423949&semt=ais" alt="">
                    </div>
                </div>
            </div>
        </section>
    </div>
    </div>
</body>

</html>