<?php
$proxy_host = "proxysql";
$username = "test";
$password = "testpass";

// Single connection for both read and write
$conn = new mysqli($proxy_host, $username, $password, "ecomm", 6033);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// INSERT
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $conn->query("INSERT INTO products (name, price) VALUES ('$name', $price)");
}

// UPDATE
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $price = $_POST['price'];
    $conn->query("UPDATE products SET price=$price WHERE id=$id");
}

// DELETE
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $conn->query("DELETE FROM products WHERE id=$id");
}

// READ
$result = $conn->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html>
<head><title>eComm Product Admin</title></head>
<body>
    <h2>Add Product</h2>
    <form method="post">
        Name: <input name="name" required>
        Price: <input name="price" required>
        <button name="add">Add</button>
    </form>

    <h2>Update Product</h2>
    <form method="post">
        ID: <input name="id" required>
        New Price: <input name="price" required>
        <button name="update">Update</button>
    </form>

    <h2>Delete Product</h2>
    <form method="post">
        ID: <input name="id" required>
        <button name="delete">Delete</button>
    </form>

    <h2>Product List (Read via ProxySQL)</h2>
    <table border="1">
        <tr><th>ID</th><th>Name</th><th>Price</th></tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row["id"] ?></td>
            <td><?= $row["name"] ?></td>
            <td><?= $row["price"] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

