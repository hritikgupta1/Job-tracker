<?php
include("../includes/auth_check.php");
include("../config/db.php");

$uid = $_SESSION['user_id'];

$where = "WHERE user_id=$uid";

if (!empty($_GET['status'])) {
    $status = $_GET['status'];
    $where .= " AND status='$status'";
}

if (!empty($_GET['company'])) {
    $company = $_GET['company'];
    $where .= " AND company LIKE '%$company%'";
}

if (!empty($_GET['role'])) {
    $role = $_GET['role'];
    $where .= " AND role LIKE '%$role%'";
}

$result = $conn->query("SELECT * FROM jobs $where ORDER BY created_at DESC");
?>

<div class="card p-3 shadow-sm">

    <!-- Top Bar -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2 mb-2">
        <h4 class="mb-0">Jobs</h4>

        <div>
            <a href="jobs/add.php" class="btn btn-dark btn-sm">+ Add Job</a>
        </div>
    </div>

    <!-- Filter -->
    <form class="row g-2 mb-3 mt-2" onsubmit="event.preventDefault(); filterJobs();">

        <div class="col-12 col-md-3">
            <select id="statusFilter" class="form-select">
                <option value="">All Status</option>
                <option>Applied</option>
                <option>Interview</option>
                <option>Rejected</option>
                <option>Offer</option>
            </select>
        </div>

        <div class="col-12 col-md-3">
            <input id="companyFilter" class="form-control" placeholder="Company">
        </div>

        <div class="col-12 col-md-3">
            <input id="roleFilter" class="form-control" placeholder="Role">
        </div>

        <div class="col-12 col-md-2">
            <button class="btn btn-dark w-100">Filter</button>
        </div>

    </form>

    <!-- Table -->
    <div class="table-responsive">

        <table class="table table-bordered">
            <tr>
                <th>Company</th>
                <th>Role</th>
                <th>Status</th>
                <th>Applied Date</th>
                <th>Notes</th>
                <th>Actions</th>
            </tr>

            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['company']) ?></td>
                    <td><?= htmlspecialchars($row['role']) ?></td>

                    <td>
                        <span class="badge bg-dark"><?= $row['status'] ?></span>
                    </td>

                    <td>
                        <?= $row['applied_date'] ? date("d M Y", strtotime($row['applied_date'])) : '-' ?>
                    </td>

                    <td>
                        <?php if (!empty($row['notes'])):
                            $short = substr($row['notes'], 0, 20);
                            $isLong = strlen($row['notes']) > 20;
                            ?>
                            <?= htmlspecialchars($short) ?>         <?= $isLong ? '...' : '' ?>

                            <?php if ($isLong): ?>
                                <button class="btn btn-sm btn-link p-0 ms-1" onclick="showNotes(this)"
                                    data-note="<?= htmlspecialchars($row['notes'], ENT_QUOTES) ?>">
                                    View
                                </button>
                            <?php endif; ?>

                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>

                    <td>
                        <a href="jobs/edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>

                        <a href="jobs/delete.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger"
                            onclick="return confirm('Are you sure you want to delete this job?')">
                            Delete
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>

        </table>
    </div>

</div>