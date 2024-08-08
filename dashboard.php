<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="jquery.js" type="text/JavaScript"></script>
	<script src="jqueryUI.js" type="text/JavaScript"></script>
    <style>
        body {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }
        .sidebar {
            width: 250px;
            background: grey;
            color: black;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            padding-top: 56px;
        }
        .space{
            margin-top: 45px;
        }
        .sidebar a {
            color: black;
            text-decoration: none;
            display: block;
            padding: 10px 20px;
            font-weight: bold;
            font-size: 20px;
        }
        .sidebar a:hover {
            background: #495057;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            width: 100%;
            margin-top: 50px
        }
        .navbar-brand {
            margin-left: 20px;
            font-size: 30px;
        }


        .content{
            
        }
        .maindiv {
            display: grid;
            margin-top: 0px;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-top: 20px;
            margin-right: 100px;
            padding: 0 15px;
        }
        .card {
            background-color: gainsboro;
            border-radius: 20px;
            padding: 25px;
            text-align: center;
            margin-top: 30px;
        }
        .card .title {
            color: black;
            font-weight: bold;
            font-size: 30px;
        }
        .card .value {
            color: black;
            font-weight: bold;
            font-size: 30px;
        }
        @media (max-width: 768px) {
            .maindiv {
                margin-right: 0;
            }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="#">IMS</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
               
            </ul>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="space">
        <a href="dashboard.php">Dashboard</a>
        <a href="add_interns.php">Add Interns</a>
        <a href="#">Settings</a>
        <a href="#">Logout</a>
        </div>
    </div>

    <!-- Content -->
    <div class="content">
    <?php
include 'connect.php';

$sql = "SELECT COUNT(*) AS intern_count FROM interns";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $intern_count = $row['intern_count'];
} else {
    $intern_count = 0;
}

$conn->close();
?>

        <div class="card">
            <p class="title">Total Interns</p>
            <p class="value"><?php echo $intern_count; ?></p>
             
            <button id="viewAllInternsBtn" class="btn btn-primary" onclick="window.location.href='view_interns.php'">View All Interns</button>
        </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
