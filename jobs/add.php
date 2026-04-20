<?php
include("../includes/auth_check.php");
include("../config/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uid = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO jobs (user_id, company, role, status, applied_date, notes) VALUES (?,?,?,?,?,?)");
    $stmt->bind_param(
        "isssss",
        $uid,
        $_POST['company'],
        $_POST['role'],
        $_POST['status'],
        $_POST['date'],
        $_POST['notes']
    );
    $stmt->execute();

    // ✅ Redirect to dashboard and auto-open jobs
    header("Location: ../dashboard.php?showJobs=1");
    exit;
}
?>

<?php include("../includes/header.php"); ?>

<div class="card shadow p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Add Job</h4>

        <!-- ✅ Close Button -->
        <a href="../dashboard.php?showJobs=1" class="btn btn-outline-danger btn-sm">
            ✕ Close
        </a>
    </div>

    <form method="POST">

        <input class="form-control mb-2" name="company" placeholder="Company" required>

        <input class="form-control mb-2" name="role" placeholder="Role" required>

        <select class="form-control mb-2" name="status">
            <option>Applied</option>
            <option>Interview</option>
            <option>Rejected</option>
            <option>Offer</option>
        </select>

        <input type="date" class="form-control mb-2" name="date">

        <textarea class="form-control mb-3" name="notes" placeholder="Notes"></textarea>

        <button class="btn btn-dark">Save</button>

    </form>
</div>

<?php include("../includes/footer.php"); ?>