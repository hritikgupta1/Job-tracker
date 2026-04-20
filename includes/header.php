<?php if(session_status()===PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Job Tracker</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="/job_tracker/assets/style.css">
</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-dark px-4">
    <a href="/job_tracker/dashboard.php" class="navbar-brand">Job Tracker</a>

    <?php if(isset($_SESSION['user_id'])): ?>
        <a href="/job_tracker/auth/logout.php" class="btn btn-danger btn-sm">Logout</a>
    <?php endif; ?>
</nav>

<div class="container mt-4">