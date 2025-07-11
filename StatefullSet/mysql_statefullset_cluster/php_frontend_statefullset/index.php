<?php
// Connection to master for write
$write_conn = new mysqli("mysql-write", "root", "rootpass", "ecomm");
// Connection to slave for read
$read_conn = new mysqli("mysql-read", "root", "", "ecomm");

if ($write_conn->connect_error || $read_conn->connect_error) {
    die("Connection failed: " . $write_conn->connect_error . " " . $read_conn->connect_error);
}

// INSERT
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $write_conn->query("INSERT INTO products (name, price) VALUES ('$name', $price)");
}

// UPDATE
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $price = $_POST['price'];
    $write_conn->query("UPDATE products SET price=$price WHERE id=$id");
}

// DELETE
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $write_conn->query("DELETE FROM products WHERE id=$id");
}

// READ
$result = $read_conn->query("SELECT * FROM products");
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

    <h2>Product List (Read from Replica)</h2>
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

