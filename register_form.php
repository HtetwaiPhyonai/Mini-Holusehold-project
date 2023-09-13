<!DOCTYPE html>
<html lang="en">
<?php
require(base_path('db-connection.php'));

$errorname = $erroremail = $errorpassword = $errorsamepassword = $errormatch = "";
$name = $email = $password = $samepassword = "";
$check = true;

if (isset($_POST['name'], $_POST['email'], $_POST['password'], $_POST['samepassword'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $samepassword = $_POST['samepassword'];

    if (empty($name)) {
        $errorname = "*Please enter your name*";
        $check = false;
    }

    if (empty($email)) {
        $erroremail = "*Please enter your email*";
        $check = false;
    }

    if (empty($password)) {
        $errorpassword = "*Please enter your password*";
        $check = false;
    }

    if (empty($samepassword)) {
        $errorsamepassword = "*Please enter your confirmpassword*";
        $check = false;
    }

    if (!($password === $samepassword)) {
        $errormatch = "*Password not same*";
        $check = false;
    }

    // Check for duplicate email address
    $stmt = $connection->prepare("SELECT * FROM register WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    if (!empty($row)) {
        $erroremail = "Email already exists";
        $check = false;
    }

    if ($check) {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $connection->prepare("INSERT INTO register (name,email,password) VALUES ('$name', '$email', '$hashed_password')");
        $stmt->execute();
        $stmt->close();

        // Redirect to login page
        header("Location: http://localhost:3000/");
        exit();
    }
}
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
</head>

<body>
    <div class="container-md">
        <section class="py-5">
            <div class="mask d-flex align-items-center">
                <div class="container">
                    <div class="row d-flex justify-content-center align-items-center h-100">
                        <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                            <div class="card shadow w-100" style="border-radius: 15px;">
                                <div class="card-body p-4">
                                    <h2 class="text-uppercase text-center mb-4">Register Form</h2>

                                    <form method="POST" action="">

                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form2Example18">Name: <small class="text-danger " for="form3Example1cg"><?= $errorname ?></small></label>
                                            <input name="name" type="text" id="form3Example1cg" class="form-control" placeholder="Your Name" />
                                        </div>

                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form2Example18">Email:<small class="text-danger" for="form3Example3cg"><?= $erroremail ?></small></label>
                                            <input name="email" type="email" id="form3Example3cg" class="form-control" placeholder="Eg.@gmail.com" />
                                        </div>

                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form2Example18">Password: <small class="text-danger" for="form3Example4cg"><?= $errorpassword ?></small>
                                                <small class="text-danger" for="form3Example4cdg"><?= $errormatch ?></small></label>
                                            <input name="password" type="password" id="form3Example4cg" class="form-control" placeholder="Password" />

                                        </div>

                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form2Example18">Confirm password: <small class="text-danger" for="form3Example4cdg"><?= $errorsamepassword ?></small>
                                                <small class="text-danger" for="form3Example4cdg"><?= $errormatch ?></small></label>
                                            <input name="samepassword" type="password" id="form3Example4cdg" class="form-control" placeholder="Same-password" />

                                        </div>
                                        <div class="d-flex justify-content-center mb-3">
                                            <button type="submit" class="btn btn-primary btn-block btn-lg gradient-custom-4 text-body">Register</button>
                                        </div>
                                        <div class="form-check d-flex justify-content-center mb-2">
                                            <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3cg" />
                                            <label class="form-check-label" for="form2Example3g">
                                                I agree all statements in <a href="#!" class="text-body"><u>Terms of service</u></a>
                                            </label>
                                        </div>
                                        <p class="text-center text-muted mt-3 mb-0">Have already an account? <a href="/" class="fw-bold text-body link-info">Login here</a></p>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>

</html>