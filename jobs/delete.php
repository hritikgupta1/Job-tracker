<?php
include("../includes/auth_check.php");
include("../config/db.php");

$id = intval($_GET['id']); // safer

$conn->query("DELETE FROM jobs WHERE id=$id");

// ✅ Redirect to dashboard and reopen jobs
header("Location: ../dashboard.php?showJobs=1");
exit;