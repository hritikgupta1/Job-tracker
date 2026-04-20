<?php
include("includes/auth_check.php");
include("config/db.php");
include("includes/header.php");

$uid = $_SESSION['user_id'];

$total = $conn->query("SELECT COUNT(*) c FROM jobs WHERE user_id=$uid")->fetch_assoc()['c'];
$interviews = $conn->query("SELECT COUNT(*) c FROM jobs WHERE status='Interview' AND user_id=$uid")->fetch_assoc()['c'];
$offers = $conn->query("SELECT COUNT(*) c FROM jobs WHERE status='Offer' AND user_id=$uid")->fetch_assoc()['c'];
?>

<h3 class="mb-3">Dashboard</h3>

<div class="row g-3">

    <div class="col-12 col-md-4">
        <div class="card shadow text-center p-3 h-100">
            <h5>Total</h5>
            <h2><?= $total ?></h2>
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="card shadow text-center p-3 h-100">
            <h5>Interviews</h5>
            <h2><?= $interviews ?></h2>
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="card shadow text-center p-3 h-100">
            <h5>Offers</h5>
            <h2><?= $offers ?></h2>
        </div>
    </div>

</div>

<button class="btn btn-dark mt-3 w-100 w-md-auto" onclick="toggleJobs()" id="manageBtn">
    Manage Jobs
</button>
<div id="jobsContainer" class="mt-4" style="display:none;"></div>

<!-- ✅ GLOBAL MODAL HERE -->
<div class="modal fade" id="notesModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Notes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body" id="notesContent"></div>

        </div>
    </div>
</div>

<script>
    let jobsVisible = false;

    function toggleJobs() {
        let container = document.getElementById('jobsContainer');
        let btn = document.getElementById('manageBtn');

        if (jobsVisible) {
            container.style.display = "none";
            container.innerHTML = "";
            btn.innerText = "Manage Jobs";
            jobsVisible = false;
            return;
        }

        container.style.display = "block";
        loadJobs();
        btn.innerText = "Close Jobs";
        jobsVisible = true;
    }

    function loadJobs(status = '', company = '', role = '') {
        let url = `jobs/list_partial.php?status=${status}&company=${company}&role=${role}`;

        document.getElementById('jobsContainer').innerHTML = "Loading...";

        fetch(url)
            .then(res => res.text())
            .then(data => {
                document.getElementById('jobsContainer').innerHTML = data;
            });
    }

    function filterJobs() {
        let status = document.getElementById('statusFilter').value;
        let company = document.getElementById('companyFilter').value;
        let role = document.getElementById('roleFilter').value;

        loadJobs(status, company, role);
    }

    function showNotes(btn) {
        let note = btn.getAttribute("data-note");

        document.getElementById("notesContent").innerText = note;

        let modal = new bootstrap.Modal(document.getElementById('notesModal'));
        modal.show();
    }

    // auto open after redirect
    window.onload = function () {
        const params = new URLSearchParams(window.location.search);
        if (params.get("showJobs") === "1") {
            toggleJobs();
        }
    };
</script>

<?php include("includes/footer.php"); ?>