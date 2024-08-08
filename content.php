<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .maindiv {
            display: grid;
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
            color: #ffc800;
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
    <div class="container">
        <div class="maindiv">
            
            <div class="card">
                <p class="title">Total Users</p>
                <p class="value">0</p>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
