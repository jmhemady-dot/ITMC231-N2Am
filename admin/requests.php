
<?php
session_start();

include '../config/database.php';

if(isset($_POST['update_status'])){

    $id = $_POST['request_id'];
    $status = $_POST['status'];

    mysqli_query(
        $conn,
        "UPDATE print_requests
        SET status='$status',
        updated_at=NOW()
        WHERE id='$id'"
    );

    header("Location: requests.php");
    exit();
}

$search = "";

if(isset($_GET['search'])){
    $search = $_GET['search'];
}

$requests = mysqli_query(
    $conn,
    "SELECT
        pr.*,
        u.fullname,
        u.student_id
    FROM print_requests pr
    INNER JOIN users u
    ON pr.user_id = u.id
    WHERE
    u.fullname LIKE '%$search%'
    OR pr.filename LIKE '%$search%'
    OR pr.queue_number LIKE '%$search%'
    ORDER BY pr.queue_number ASC"
);
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Manage Requests</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#eef2f7;
    font-family:'Segoe UI',sans-serif;
}

.sidebar{
    background:#062b78;
    min-height:100vh;
    color:white;
}

.logo{
    font-size:26px;
    font-weight:bold;
    padding:25px;
    border-bottom:1px solid rgba(255,255,255,.15);
}

.sidebar a{
    display:block;
    color:white;
    text-decoration:none;
    padding:15px 25px;
}

.sidebar a:hover{
    background:#0d47c8;
}

.main{
    padding:30px;
}

.search-card{
    background:white;
    padding:20px;
    border-radius:15px;
    box-shadow:0 3px 15px rgba(0,0,0,.08);
    margin-bottom:20px;
}

.request-card{
    background:white;
    border-radius:15px;
    box-shadow:0 3px 15px rgba(0,0,0,.08);
    padding:20px;
    margin-bottom:20px;
}

.status-pending{
    background:#fff3cd;
    color:#856404;
}

.status-progress{
    background:#d1ecf1;
    color:#0c5460;
}

.status-printing{
    background:#cce5ff;
    color:#004085;
}

.status-ready{
    background:#d4edda;
    color:#155724;
}

.status-completed{
    background:#e2e3e5;
    color:#383d41;
}

.badge-custom{
    padding:8px 12px;
    border-radius:20px;
    font-size:13px;
}

</style>

</head>

<body>

<div class="container-fluid">

<div class="row">

<div class="col-md-2 sidebar p-0">

<div class="logo">
ADNU-PRINTS
</div>

<a href="dashboard.php">📊 Dashboard</a>
<a href="requests.php">📋 Manage Requests</a>
<a href="../dashboard.php">👨 Student View</a>
<a href="../logout.php">🚪 Logout</a>

</div>

<div class="col-md-10 main">

<h2>Manage Print Requests</h2>

<p class="text-muted">
Update request status and monitor queue activity.
</p>

<div class="search-card">

<form method="GET">

<div class="row">

<div class="col-md-10">

<input
type="text"
name="search"
class="form-control"
placeholder="Search student, file, or queue number..."
value="<?php echo $search; ?>">

</div>

<div class="col-md-2">

<button class="btn btn-primary w-100">
Search
</button>

</div>

</div>

</form>

</div>

<?php while($row = mysqli_fetch_assoc($requests)){ ?>

<div class="request-card">

<div class="row">

<div class="col-md-8">

<h5>
Queue #<?php echo $row['queue_number']; ?>
</h5>

<p class="mb-1">

<strong>
<?php echo $row['fullname']; ?>
</strong>

</p>

<p class="text-muted mb-1">
Student ID:
<?php echo $row['student_id']; ?>
</p>

<p class="mb-1">
<?php echo $row['filename']; ?>
</p>

<p class="mb-1">
Pages:
<?php echo $row['pages']; ?>
</p>

<p class="mb-1">
Copies:
<?php echo $row['copies']; ?>
</p>

<p class="mb-1">
Cost:
<strong>
₱<?php echo $row['estimated_cost']; ?>
</strong>
</p>

<?php

$statusClass = "";

if($row['status']=="Pending"){
    $statusClass="status-pending";
}
elseif($row['status']=="In Progress"){
    $statusClass="status-progress";
}
elseif($row['status']=="Printing"){
    $statusClass="status-printing";
}
elseif($row['status']=="Ready for Pickup"){
    $statusClass="status-ready";
}
elseif($row['status']=="Completed"){
    $statusClass="status-completed";
}

?>

<span class="badge-custom <?php echo $statusClass; ?>">
<?php echo $row['status']; ?>
</span>

</div>

<div class="col-md-4">

<form method="POST">

<input
type="hidden"
name="request_id"
value="<?php echo $row['id']; ?>">

<select
name="status"
class="form-select mb-2">

<option
<?php if($row['status']=="Pending") echo "selected"; ?>>
Pending
</option>

<option
<?php if($row['status']=="In Progress") echo "selected"; ?>>
In Progress
</option>

<option
<?php if($row['status']=="Printing") echo "selected"; ?>>
Printing
</option>

<option
<?php if($row['status']=="Ready for Pickup") echo "selected"; ?>>
Ready for Pickup
</option>

<option
<?php if($row['status']=="Completed") echo "selected"; ?>>
Completed
</option>

</select>

<button
name="update_status"
class="btn btn-primary w-100">

Update Status

</button>

</form>

</div>

</div>

</div>

<?php } ?>

</div>

</div>

</div>

</body>
</html>