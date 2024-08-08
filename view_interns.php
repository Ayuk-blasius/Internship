<?php
session_start();

include 'connect.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0; // Assuming the user ID is stored in the session

if ($user_id) {
    // Fetch user details from the database
    $sql = "SELECT `name` FROM interns WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($name, $profile_image);
    $stmt->fetch();
    $stmt->close();
    }

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="jquery.js" type="text/JavaScript"></script>
	<script src="jqueryUI.js" type="text/JavaScript"></script>
    <title>View All Interns</title>
</head>
<style>
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


    .main-body {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
        }
        .table-container {
            width: 100%;
            overflow-x: auto;
        }
        .table {
            width: 100%;
        }
</style>
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

    <style>
        .main-body {
            margin-top: 80px;
            width: 80%;
            margin-right: 50px;
        }
        .table-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .table thead th {
            background-color: #f8f9fa;
        }
        .btn-delete {
            color: #fff;
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .btn-delete:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
    </style>
</head>
<body>

<div class="container main-body">
    <div class="card">
        <div class="card-header">
            <h2>ALL INTERNS</h2>
        </div>
        <div class="card-body table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">N/s</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'connect.php';
                    $sql = "SELECT * FROM interns";
                    $qry = mysqli_query($conn, $sql);
                    $count = 0;
                    while ($data = mysqli_fetch_assoc($qry)) {
                        $count++;
                        $firstName = $data['first_name'];
                        $lastName = $data['last_name'];
                        $email = $data['email'];
                        $gender = $data['gender'];
                    ?>
                        <tr>
                            <td><?php echo $count ?></td>
                            <td><?php echo htmlspecialchars($firstName) ?></td>
                            <td><?php echo htmlspecialchars($lastName) ?></td>
                            <td><?php echo htmlspecialchars($email) ?></td>
                            <td><?php echo htmlspecialchars($gender) ?></td>
                            <td>
                            <a href="edit_intern.php?email=<?php echo $email ?>" class="btn btn-edit btn-sm me-2"><button class="btn btn-sm" style="background: gray; color: white;">Edit</button></a>
                            <button class="btn btn-delete btn-sm" data-email="<?php echo $email ?>">Delete</button>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function deleteIntern(email) {
    if (confirm('Are you sure you want to delete this intern?')) {
        fetch('delete_intern.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({ email: email })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Intern deleted successfully');
                location.reload(); // Reload the page to reflect the changes
            } else {
                alert('Failed to delete intern: ' + data.message);
            }
        });
    }
}

document.querySelectorAll('.btn-delete').forEach(button => {
    button.addEventListener('click', () => {
        const email = button.getAttribute('data-email');
        deleteIntern(email);
    });
});
</script>