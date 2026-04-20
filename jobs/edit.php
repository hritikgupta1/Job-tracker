<?php
include("../includes/auth_check.php");
include("../config/db.php");

$id = intval($_GET['id']); // safer

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $conn->prepare("UPDATE jobs SET company=?, role=?, status=?, applied_date=?, notes=? WHERE id=?");
    $stmt->bind_param(
        "sssssi",
        $_POST['company'],
        $_POST['role'],
        $_POST['status'],
        $_POST['date'],
        $_POST['notes'],
        $id
    );
    $stmt->execute();

    // ✅ Redirect back to dashboard (correct flow)
    header("Location: ../dashboard.php?showJobs=1");
    exit;
}

$job = $conn->query("SELECT * FROM jobs WHERE id=$id")->fetch_assoc();
?>

<?php include("../includes/header.php"); ?>

<div class="card shadow p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Edit Job</h4>

        <!-- ✅ Close Button -->
        <a href="../dashboard.php?showJobs=1" class="btn btn-outline-danger btn-sm"
            onclick="return confirm('Are you sure you want to close without saving?')">
            ✕ Close
        </a>
    </div>

    <form method="POST">

        <input class="form-control mb-2" name="company" value="<?= htmlspecialchars($job['company']) ?>"
            placeholder="Company">

        <input class="form-control mb-2" name="role" value="<?= htmlspecialchars($job['role']) ?>" placeholder="Role">

        <select class="form-control mb-2" name="status">
            <option <?= $job['status'] == "Applied" ? "selected" : "" ?>>Applied</option>
            <option <?= $job['status'] == "Interview" ? "selected" : "" ?>>Interview</option>
            <option <?= $job['status'] == "Rejected" ? "selected" : "" ?>>Rejected</option>
            <option <?= $job['status'] == "Offer" ? "selected" : "" ?>>Offer</option>
        </select>

        <!-- Date -->
        <input type="date" class="form-control mb-2" name="date" value="<?= $job['applied_date'] ?>">

        <!-- Notes -->
        <textarea class="form-control mb-3" name="notes"
            placeholder="Notes"><?= htmlspecialchars($job['notes']) ?></textarea>

        <button class="btn btn-dark">Update</button>

    </form>
</div>

<?php include("../includes/footer.php"); ?>