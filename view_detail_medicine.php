<?php
include 'customer_header.php';
include 'db.php';

//session_start();
//if (!isset($_SESSION['users']) || $_SESSION['users']['role'] !== 'stores') {
    //header('Location: login.php');
   // exit;
//}

// Initialize $product as null in case we need to handle adding a new product
$product = null;
$type = 'tablet'; // Default value for type is 'tablet'

// Check if an ID is passed in the URL for editing
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the product details from the database
    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        // If the product exists, set the type field from the database
        $type = $product['type'];
    } else {
        echo "Product not found!";
        exit();
    }
}

// Check if an ID is passed in the URL for editing
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the product details from the database
    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        // If the product exists, set the type field from the database
        $type = $product['type'];
    } else {
        echo "Product not found!";
        exit();
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $use_of_medicine = $_POST['use_of_medicine'];
    $type = $_POST['type'];  // Use the POST value for 'type'
    $ingredients = $_POST['ingredients'];
    $company_name = $_POST['company_name'];
    $expiry_date = $_POST['expiry_date'];
    $manufacture_date = $_POST['manufacture_date'];
    $strip = $_POST['strip'];
    $tablet = $_POST['tablet'];
    $price = $_POST['price'];
    $bench_number = $_POST['bench_number'];
    $side_effects = $_POST['side_effects'];

    // Check if 'stores_id' exists in the session
    if (isset($_SESSION['stores_id'])) {
        $stores_id = $_SESSION['stores_id'];
    }else{
        $stores_id = 0;
    }

    // Handle image upload (only if a new image is provided)
    $target_file = $product ? $product['image'] : ''; // Default to current image
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    }

        // If we're updating an existing product
        if (isset($_GET['id'])) {
            // Update the product in the database
            $sql = "UPDATE products SET 
                        name = ?, use_of_medicine = ?, type = ?, ingredients = ?, company_name = ?, 
                        expiry_date = ?, manufacture_date = ?, strip = ?, tablet = ?, price = ?, 
                        bench_number = ?, side_effects = ?, image = ? 
                    WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssssiiisssi", // Correct the number of placeholders (14)
                $name, $use_of_medicine, $type, $ingredients, $company_name, 
                $expiry_date, $manufacture_date, $strip, $tablet, $price, 
                $bench_number, $side_effects, $target_file,
                $id
            );
    
            if ($stmt->execute()) {
                echo "Product updated successfully";
            } else {
                echo "Error: " . $stmt->error;
            }
        } else {
                // Insert the product details into the database
    $sql = "INSERT INTO products (name, use_of_medicine, type, ingredients, company_name, 
    expiry_date, manufacture_date, strip, tablet, price,
    bench_number, side_effects, image, approved)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0)";  // Added placeholder for approval

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssssiiisss", // Correct the number of placeholders (14)
$name, $use_of_medicine, $type, $ingredients, $company_name, 
$expiry_date, $manufacture_date, $strip, $tablet, $price, 
$bench_number, $side_effects, $target_file
);

if ($stmt->execute()) {
echo "New product added successfully.";
} else {
echo "Error: " . $stmt->error;
}
 
}

}
?>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://fonts.googleapis.com/css?family=Rubik:400,700|Crimson+Text:400,400i" rel="stylesheet">
  <link rel="stylesheet" href="fonts/icomoon/style.css">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/magnific-popup.css">
  <link rel="stylesheet" href="css/jquery-ui.css">
  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <link rel="stylesheet" href="css/owl.theme.default.min.css">
  <link rel="stylesheet" href="css/aos.css">
  <link rel="stylesheet" href="css/style.css">

<div class="container">
    <h1><?php echo isset($_GET['id']) ? 'Update Medicine' : 'Add Medicine'; ?></h1>
    <form action="seller_addmedicine.php<?php echo isset($_GET['id']) ? '?id=' . $_GET['id'] : ''; ?>" method="POST" enctype="multipart/form-data">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo $product['name'] ?? ''; ?>" required>

        <label for="use_of_medicine">Use of Medicine:</label>
        <textarea name="use_of_medicine" required><?php echo $product['use_of_medicine'] ?? ''; ?></textarea>

        <label for="type">Type:</label>
        <select name="type" required>
            <option value="tablet" <?php echo ($type == 'tablet') ? 'selected' : ''; ?>>Tablet</option>
            <option value="injection" <?php echo ($type == 'injection') ? 'selected' : ''; ?>>Injection</option>
            <option value="bottle" <?php echo ($type == 'bottle') ? 'selected' : ''; ?>>Bottle</option>
        </select>

        <label for="ingredients">Ingredients:</label>
        <textarea name="ingredients" required><?php echo $product['ingredients'] ?? ''; ?></textarea>

        <label for="company_name">Company Name:</label>
        <input type="text" name="company_name" value="<?php echo $product['company_name'] ?? ''; ?>" required>

        <label for="expiry_date">Expiry Date:</label>
        <input type="date" name="expiry_date" value="<?php echo $product['expiry_date'] ?? ''; ?>" required>

        <label for="manufacture_date">Manufacture Date:</label>
        <input type="date" name="manufacture_date" value="<?php echo $product['manufacture_date'] ?? ''; ?>" required>

        <label for="strip">Strip:</label>
        <input type="number" name="strip" value="<?php echo $product['strip'] ?? ''; ?>" required>

        <label for="tablet">Tablet:</label>
        <input type="number" name="tablet" value="<?php echo $product['tablet'] ?? ''; ?>" required>

        <label for="price">Price:</label>
        <input type="number" name="price" value="<?php echo $product['price'] ?? ''; ?>" step="0.01" required>

        <label for="bench_number">Bench Number:</label>
        <input type="text" name="bench_number" value="<?php echo $product['bench_number'] ?? ''; ?>" required>

        <label for="side_effects">Side Effects:</label>
        <textarea name="side_effects"><?php echo $product['side_effects'] ?? ''; ?></textarea>

        <label for="image">Product Image:</label>
        <input type="file" name="image" accept="image/*">
        <?php if (isset($product['image']) && !empty($product['image'])): ?>
            <img src="<?php echo $product['image']; ?>" alt="Product Image" width="100">
        <?php endif; ?>

       
    </form>

 
    <table class="table">
      
    </table>
</div>

<?php
include 'footer.php';
?>