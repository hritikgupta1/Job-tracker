<?php
if (isset($_SESSION['user_id'])) {
    header("Location: ../dashboard.php");
    exit();
}
include("../config/db.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if ($user && $password == $user['password']) {
        $_SESSION['user_id'] = $user['id'];

        header("Location: ../dashboard.php");
        exit(); // VERY IMPORTANT
    } else {
        $error = "Invalid credentials";
    }
}
?>

<?php include("../includes/header.php"); ?>

<div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center">
    <div class="w-100 px-3">

        <div class="card shadow p-4">

            <h4 class="text-center mb-3">Login</h4>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST">
                <input class="form-control mb-2" name="email" placeholder="Email">

                <div class="input-group mb-2">
                    <input class="form-control" type="password" id="password" name="password" placeholder="Password">
                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword()">👁</button>
                </div>

                <button class="btn btn-dark w-100">Login</button>
            </form>

            <a href="register.php" class="d-block mt-3 text-center">Register</a>

        </div>

    </div>
</div>

<?php include("../includes/footer.php"); ?>

<script>
    function togglePassword() {
        const pwd = document.getElementById("password");
        const btn = event.target;

        if (pwd.type === "password") {
            pwd.type = "text";
            btn.textContent = "👁";
        } else {
            pwd.type = "password";
            btn.textContent = "👁";
        }
    }
</script>