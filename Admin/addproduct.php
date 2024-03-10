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
    <title>Add Product</title>
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
    <div class="container mt-5">
        <h2>Add Product</h2>
        <form method="post" action="" enctype="multipart/form-data" class="mt-4">
            <div class="mb-3">
                <input type="checkbox" id="keyboard" name="productType[]" value="1" class="form-check-input">
                <label for="keyboard" class="form-check-label">Keyboard</label><br>
                <input type="checkbox" id="mouse" name="productType[]" value="2" class="form-check-input">
                <label for="mouse" class="form-check-label">Mouse</label><br>
                <input type="checkbox" id="headphone" name="productType[]" value="3" class="form-check-input">
                <label for="headphone" class="form-check-label">Headphone</label>
            </div>

            <div class="mb-3">
                <label for="productName" class="form-label">Product Name:</label>
                <input type="text" id="productName" name="productName" class="form-control" placeholder="Product Name" required>
            </div>

            <div class="mb-3">
                <label for="productPrice" class="form-label">Price:</label>
                <input type="text" id="productPrice" name="productPrice" class="form-control" placeholder="Price" required>
            </div>

            <div class="mb-3">
                <label for="productDetail" class="form-label">Detail:</label>
                <textarea id="productDetail" name="productDetail" class="form-control" placeholder="Detail" required rows="4"></textarea>
            </div>

            <div class="mb-3">
                <label for="productImage" class="form-label">Image:</label>
                <input type="file" id="productImage" name="productImage" class="form-control" required>
            </div>

            <button type="submit" name="submit" class="btn btn-success">Add Product</button>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "adverse";

        $conn = mysqli_connect($servername, $username, $password, $database);

        if (!$conn) {
            die("การเชื่อมต่อล้มเหลว: " . mysqli_connect_error());
        }

        mysqli_query($conn, "set character_set_connection=utf8mb4");
        mysqli_query($conn, "set character_set_client=utf8mb4");
        mysqli_query($conn, "set character_set_results=utf8mb4");

        $productName = $_POST['productName'];
        $productPrice = $_POST['productPrice'];
        $productDetail = $_POST['productDetail'];

        // ตรวจสอบว่ามีการเลือกสินค้าหรือไม่
        if(isset($_POST['productType'])) {
            $productType = $_POST['productType'][0]; // ใช้ตัวแรกใน array สำหรับประเภทสินค้า
        } else {
            $productType = ""; // ถ้าไม่ได้เลือกสินค้าก็เก็บเป็นค่าว่าง
        }

        

        // เช็คว่ามีไฟล์รูปหรือไม่
        if(isset($_FILES["productImage"]) && $_FILES["productImage"]["error"] == UPLOAD_ERR_OK) {
            $target_dir = "../pictures/"; // โฟลเดอร์ที่จะเก็บรูป
            $target_file = $target_dir . basename($_FILES["productImage"]["name"]); // เอาชื่อไฟล์

            $filename = basename($_FILES["productImage"]["name"]);

            if(move_uploaded_file($_FILES["productImage"]["tmp_name"], $target_file)) {
                echo "<p>อัพโหลดรูปสำเร็จ</p>";
            } else {
                echo "<p>อัพโหลดรูปไม่สำเร็จ</p>";
            }
        } else {
            echo "<p>โปรดเลือกไฟล์รูป</p>";
            exit();
        }

        $insertSql = "INSERT INTO product (type, name, price, detail, image) VALUES ('$productType', '$productName', '$productPrice', '$productDetail', '$filename')";

        if (mysqli_query($conn, $insertSql)) {
            echo "<p>เพิ่มข้อมูลสำเร็จ</p>";
            // ทำการ redirect หลังจากการเพิ่มข้อมูล
            header("Location: ../index.php"); 
            exit(); 
        } else {
            echo "<p>ผิดพลาดในการเพิ่มข้อมูล: " . mysqli_error($conn) . "</p>";
        }

        mysqli_close($conn);
    }
    ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
