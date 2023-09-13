<!DOCTYPE html>
<html lang="en">
<?php
require(base_path('db-connection.php'));
session_start();
if (!isset($_SESSION['user'])) {
    $_SESSION['user']['email'] = "";
}

$check = true;
$error = "";

if (isset($_POST['date'], $_POST['desc'], $_POST['income'], $_POST['expenses'])) {
    $date = $_POST['date'];
    $desc = $_POST['desc'];
    $income = $_POST['income'];
    $expenses = $_POST['expenses'];
    $balance = 0;
    if (empty($date) && empty($desc)) {
        $check = false;
        echo "<script>alert('Fill your info');</script>";
    }
    if (!empty($income) && !empty($expenses)) {
        $error = "*if you add the income value,you can't add expenses value*";
        $check = false;
    }

    $read = "SELECT `id`, `date`, `description`, `income`, `expenses`, `balance` FROM `planer` WHERE 1";
    $query = mysqli_query($connection, $read);
    while ($row = mysqli_fetch_assoc($query)) {
        $balance = $row['balance'];
    }
    if ($income) {
        $balance += $income;
    }
    if ($expenses) {
        $balance -= $expenses;
    }

    if ($check) {
        $created = "INSERT INTO `planer` (date,description,income,expenses,balance) VALUES ('$date','$desc','$income','$expenses','$balance')";
        $sql = mysqli_query($connection, $created);
    }
}
?>


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
</head>

<body>

    <div class="row">
        <div class="main col-sm-2 bg-secondary" style="height:100vh;">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQy4Q3UxGGccDvQGRhZQ55G4JNm0hSZPgwi6g&usqp=CAU" alt="" style=" border-radius:110px;" class=" mx-4 w-75">
            <?php if (empty($_SESSION['user']['email'])) : ?>
                <div class="justify-content-center d-flex mt-3">
                    <a class="nav-link" href="register_form">Register</a>
                </div>
                <div class="justify-content-center d-flex mt-3">
                    <a class="nav-link" href="home">Login</a>
                </div>
            <?php endif ?>
            <?php if (!empty($_SESSION['user']['email'])) : ?>
                <div class="justify-content-center d-flex mt-5 form-control">
                    <?= $_SESSION['user']['email'] ?>
                </div>
                <div class="justify-content-center d-flex mt-5">
                    <a class="nav-link form-control text-center bg-danger w-50" href="/" name="logout_btn">Logout</a>
                </div>
            <?php endif ?>
        </div>
        <div class="col-sm-10 mt-3">
            <button class="btn btn-secondary w-auto" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">Start Now >> </button>
            <small class="text-danger"><?= $error ?></small>
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Check your money</h1>
                            <button type="submit" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body bg-secondary">
                            <form method="POST" action="">
                                <div class="mb-2">
                                    <label for="message-text" class="col-form-label">Date:</label>
                                    <input name="date" type="date" class="form-control" id="recipient-name">
                                </div>
                                <div class="mb-2">
                                    <label for="message-text" class="col-form-label">Description:</label>
                                    <input name="desc" type="text" class="form-control" id="recipient-name">
                                </div>
                                <div class="mb-2">
                                    <label for="message-text" class="col-form-label">Income Amount:</label>
                                    <input name="income" type="number" value="0" class="form-control" id="recipient-name">
                                </div>
                                <div class="mb-2">
                                    <label for="message-text" class="col-form-label">Expenses Amount:</label>
                                    <input name="expenses" type="number" value="0" class="form-control" id="recipient-name">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Check Amount</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-success table-striped mt-2">
                <thead>
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Description</th>
                        <th scope="col">Income</th>
                        <th scope="col">Expenses</th>
                        <th scope="col">Balance</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <?php $read = "SELECT `id`, `date`, `description`, `income`, `expenses`, `balance` FROM `planer` WHERE 1";
                $query = mysqli_query($connection, $read);
                ?>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($query)) : ?>
                        <tr>
                            <td scope='row'><?= $row['date'] ?></td>
                            <td><?= $row['description'] ?></td>
                            <td><?= number_format($row['income']) ?></td>
                            <td><?= number_format($row['expenses']) ?></td>
                            <td><?= number_format($row['balance']) ?></td>
                            <td><a href="./delete?ID=<?=$row['id']?>"><span>Delete</span></a></td>
                        </tr>
                    <?php endwhile ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>