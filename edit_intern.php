<?php
include 'connect.php';

if (isset($_GET['email'])) {
    $email = $_GET['email'];

    $sql = "SELECT * FROM interns WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $intern = $result->fetch_assoc();
} else {
    echo "No email provided!";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $gender = $_POST['gender'];

    $sql = "UPDATE interns SET first_name = ?, last_name = ?, gender = ? WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $firstName, $lastName, $gender, $email);

    if ($stmt->execute()) {
        echo "Intern updated successfully";
        header("Location: view_interns.php");
    } else {
        echo "Error updating intern: " . $conn->error;
    }
}
?>


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

    <style>
        .container {
            max-width: 600px;
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-bottom: 20px;
        }
        .form-label {
            font-weight: bold;
        }
        .form-control,
        .form-select {
            border-radius: 5px;
            border: 1px solid #ced4da;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 16px;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
        .mb-3 {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2>Edit Intern</h2>
    <form method="POST" action="edit_intern.php?email=<?php echo htmlspecialchars($email); ?>">
        <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo htmlspecialchars($intern['first_name']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo htmlspecialchars($intern['last_name']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="gender" class="form-label">Gender</label>
            <select class="form-select" id="gender" name="gender" required>
                <option value="Male" <?php echo ($intern['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                <option value="Female" <?php echo ($intern['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>

      <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>