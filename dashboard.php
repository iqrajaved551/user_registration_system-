<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$userName = $_SESSION["user_name"] ?? "User";
$userEmail = $_SESSION["user_email"] ?? "";
$userRole = $_SESSION["user_role"] ?? "user";

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f2f3f5;
            color: #222;
        }

        .navbar {
            background: white;
            height: 65px;
            padding: 0 7%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
        }

        .logo {
            font-size: 20px;
            font-weight: bold;
        }

        .logout {
            text-decoration: none;
            color: #333;
            border: 1px solid #ccc;
            padding: 9px 16px;
            border-radius: 6px;
            font-size: 14px;
        }

        .logout:hover {
            background: #333;
            color: white;
        }

        .container {
            max-width: 950px;
            margin: 50px auto;
            padding: 0 20px;
        }

        .welcome {
            margin-bottom: 30px;
        }

        .welcome h1 {
            font-size: 30px;
            margin-bottom: 8px;
        }

        .welcome p {
            color: #666;
        }

        .cards {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            border: 1px solid #ddd;
        }

        .card h2 {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .info {
            padding: 13px 0;
            border-bottom: 1px solid #eee;
        }

        .info:last-child {
            border-bottom: none;
        }

        .info span {
            color: #777;
            margin-right: 10px;
        }

        .info strong {
            color: #222;
        }

        .status {
            display: inline-block;
            margin-top: 10px;
            padding: 7px 13px;
            border-radius: 20px;
            background: #eee;
            font-size: 13px;
        }

        @media (max-width: 700px) {

            .navbar {
                padding: 0 20px;
            }

            .cards {
                grid-template-columns: 1fr;
            }

            .welcome h1 {
                font-size: 25px;
            }

        }

    </style>

</head>

<body>

    <nav class="navbar">

        <div class="logo">
            User Management System
        </div>

        <a href="logout.php" class="logout">
            Logout
        </a>

    </nav>


    <div class="container">

        <div class="welcome">

            <h1>
                Welcome, <?php echo htmlspecialchars($userName); ?>
            </h1>

            <p>
                Welcome to your account dashboard.
            </p>

        </div>


        <div class="cards">


            <div class="card">

                <h2>Account Information</h2>

                <div class="info">

                    <span>Name:</span>

                    <strong>
                        <?php echo htmlspecialchars($userName); ?>
                    </strong>

                </div>


                <div class="info">

                    <span>Email:</span>

                    <strong>
                        <?php echo htmlspecialchars($userEmail); ?>
                    </strong>

                </div>


                <div class="info">

                    <span>Role:</span>

                    <strong>
                        <?php echo htmlspecialchars(ucfirst($userRole)); ?>
                    </strong>

                </div>

            </div>


            <div class="card">

                <h2>Account Status</h2>

                <p>
                    Your account is active.
                </p>

                <span class="status">
                    Active
                </span>

            </div>


        </div>

    </div>

</body>

</html>