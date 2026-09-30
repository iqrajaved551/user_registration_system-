<?php

session_start();

require_once "db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

if (($_SESSION["user_role"] ?? "user") !== "admin") {
    header("Location: dashboard.php");
    exit;
}

$message = "";
$messageType = "";

$currentUserId = $_SESSION["user_id"];


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $action = $_POST["action"] ?? "";
    $userId = filter_input(INPUT_POST, "user_id", FILTER_VALIDATE_INT);


    if ($action == "delete") {

        if (!$userId) {

            $message = "Invalid user.";
            $messageType = "error";

        } elseif ($userId == $currentUserId) {

            $message = "You cannot delete your own admin account.";
            $messageType = "error";

        } else {

            $sql = "DELETE FROM users WHERE id = ?";

            $stmt = mysqli_prepare($conn, $sql);

            mysqli_stmt_bind_param($stmt, "i", $userId);

            if (mysqli_stmt_execute($stmt)) {

                $message = "User deleted successfully.";
                $messageType = "success";

            } else {

                $message = "Unable to delete user.";
                $messageType = "error";
            }

            mysqli_stmt_close($stmt);
        }
    }


    if ($action == "update_role") {

        $role = $_POST["role"] ?? "";

        if (!$userId || !in_array($role, ["user", "admin"])) {

            $message = "Invalid role or user.";
            $messageType = "error";

        } elseif ($userId == $currentUserId) {

            $message = "You cannot change your own role.";
            $messageType = "error";

        } else {

            $sql = "UPDATE users SET role = ? WHERE id = ?";

            $stmt = mysqli_prepare($conn, $sql);

            mysqli_stmt_bind_param($stmt, "si", $role, $userId);

            if (mysqli_stmt_execute($stmt)) {

                $message = "User role updated successfully.";
                $messageType = "success";

            } else {

                $message = "Unable to update user role.";
                $messageType = "error";
            }

            mysqli_stmt_close($stmt);
        }
    }
}


$sql = "SELECT id, name, email, role FROM users ORDER BY id DESC";

$result = mysqli_query($conn, $sql);

$totalUsers = mysqli_num_rows($result);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Panel</title>

    <link rel="stylesheet" href="style.css">

</head>

<body class="dashboard-page">

    <nav class="navbar">

        <div class="brand">
            User Management System
        </div>

        <div class="nav-links">

            <a href="dashboard.php" class="nav-link">
                Dashboard
            </a>

            <a href="logout.php" class="logout-btn">
                Logout
            </a>

        </div>

    </nav>


    <main class="dashboard-container">

        <section class="welcome-section">

            <div>

                <span class="dashboard-label">
                    Administration
                </span>

                <h1>Admin Panel</h1>

                <p>
                    Manage registered users and account roles.
                </p>

            </div>

        </section>


        <?php if ($message != "") { ?>

            <div class="message <?php echo $messageType; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>

        <?php } ?>


        <div class="admin-summary">

            <div class="summary-card">

                <span>Total Users</span>

                <strong>
                    <?php echo $totalUsers; ?>
                </strong>

            </div>

        </div>


        <section class="dashboard-card">

            <div class="card-heading">

                <h2>Registered Users</h2>

            </div>


            <div class="table-wrapper">

                <table class="user-table">

                    <thead>

                        <tr>

                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Actions</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php while ($user = mysqli_fetch_assoc($result)) { ?>

                            <tr>

                                <td>
                                    <?php echo $user["id"]; ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($user["name"]); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($user["email"]); ?>
                                </td>

                                <td>

                                    <span class="role-badge">
                                        <?php echo htmlspecialchars(ucfirst($user["role"])); ?>
                                    </span>

                                </td>

                                <td>

                                    <?php if ($user["id"] != $currentUserId) { ?>

                                        <div class="admin-actions">

                                            <form method="POST">

                                                <input
                                                    type="hidden"
                                                    name="action"
                                                    value="update_role"
                                                >

                                                <input
                                                    type="hidden"
                                                    name="user_id"
                                                    value="<?php echo $user["id"]; ?>"
                                                >

                                                <select name="role" class="role-select">

                                                    <option
                                                        value="user"
                                                        <?php echo $user["role"] == "user" ? "selected" : ""; ?>
                                                    >
                                                        User
                                                    </option>

                                                    <option
                                                        value="admin"
                                                        <?php echo $user["role"] == "admin" ? "selected" : ""; ?>
                                                    >
                                                        Admin
                                                    </option>

                                                </select>

                                                <button
                                                    type="submit"
                                                    class="small-btn"
                                                >
                                                    Update
                                                </button>

                                            </form>


                                            <form method="POST">

                                                <input
                                                    type="hidden"
                                                    name="action"
                                                    value="delete"
                                                >

                                                <input
                                                    type="hidden"
                                                    name="user_id"
                                                    value="<?php echo $user["id"]; ?>"
                                                >

                                                <button
                                                    type="submit"
                                                    class="delete-btn"
                                                    onclick="return confirm('Are you sure you want to delete this user?');"
                                                >
                                                    Delete
                                                </button>

                                            </form>

                                        </div>

                                    <?php } else { ?>

                                        <span class="current-user">
                                            Current Admin
                                        </span>

                                    <?php } ?>

                                </td>

                            </tr>

                        <?php } ?>

                    </tbody>

                </table>

            </div>

        </section>

    </main>

</body>

</html>