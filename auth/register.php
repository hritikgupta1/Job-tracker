<?php
include("../config/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("INSERT INTO users (name,email,password) VALUES (?,?,?)");
    $stmt->bind_param("sss", $name, $email, $password);

    if ($stmt->execute()) {
        header("Location: login.php");
    }
}
?>

<?php include("../includes/header.php"); ?>

<div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center px-0">
    <div class="w-100 px-3">

        <div class="card shadow p-4">

            <h4 class="text-center mb-3">Register</h4>

            <form method="POST">
                <input class="form-control mb-2" name="name" placeholder="Name" required>
                <input class="form-control mb-2" name="email" placeholder="Email" required>
                <input class="form-control mb-2" type="password" name="password" placeholder="Password" required>

                <button class="btn btn-dark w-100">Register</button>
            </form>

            <a href="login.php" class="d-block mt-3 text-center">Login</a>

        </div>

    </div>
</div>

<?php include("../includes/footer.php"); ?>