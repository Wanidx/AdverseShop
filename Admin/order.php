<?php 
    session_start();
    if ($_SESSION['role'] == 'user') {
        header("Location: ../index.php");
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header class="bg-dark py-3">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-dark">
                <div class="container-fluid">
                    <a class="navbar-brand" href="management.php">
                        ADVERSE ADMIN PANEL
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto me-5">
                            <li class="nav-item">
                                <a class="nav-link" href="../index.php">HOME</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="account.php">ACCOUNT</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="order.php">ORDER</a>
                            </li>
                        </ul>
                        <div class="d-flex">
                            <?php

                            if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
                                echo('<a href="../login.php" class="btn btn-warning me-3">LOGIN</a>');
                            } else {
                                echo('<a href="../Service/logout.php" class="btn btn-danger"><img src="../assets/logout.svg" alt=""></a>');
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <div class="container">
        <h1 class="mt-4 mb-4">Order List</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Account Name</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include('../Service/connection.php');

                $order_query = "SELECT orderlist.ID_OR, product.name, account.username
                FROM orderlist
                JOIN product ON orderlist.ID_PRO = product.ID_PRO
                JOIN account ON orderlist.ID_ACC = account.ID_ACC";
                $order_result = mysqli_query($con, $order_query) or die("Error: " . mysqli_error($con));

                while ($order_row = mysqli_fetch_array($order_result)) {
                    echo "<tr>";
                    echo "<td>" . $order_row["ID_OR"] .  "</td> ";
                    echo "<td>" . $order_row["name"] .  "</td> ";
                    echo "<td>" . $order_row["username"] .  "</td> ";
                    echo "<td><a href='../Service/orderdelete.php?ID_OR=" . $order_row["ID_OR"] . "' class='btn btn-success'>Confirm Order</a></td>";
                    echo "</tr>";
}

                mysqli_close($con);
                ?>
                
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
