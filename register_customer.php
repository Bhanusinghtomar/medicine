<?php
include 'm_header1.php';
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $role = 'customer';
    $name = $_POST['name'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $mobile_no = $_POST['mobile_no'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $bank_name = $_POST['bank_name'];
    $account_no = $_POST['account_no'];
    $branch = $_POST['branch'];
    $ifsc_code = $_POST['ifsc_code'];

    $query = "INSERT INTO users (role, name, address, email, mobile_no, username, password, bank_name, account_no, branch, ifsc_code, approved) VALUES ('$role', '$name', '$address', '$email', '$mobile_no', '$username', '$password', '$bank_name', '$account_no', '$branch', '$ifsc_code', 0)";
    if (mysqli_query($conn, $query)) {
        echo "Customer registered successfully. Please wait for admin approval.";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}
?>
<head>
  <title>Admin Login</title>
  <meta charset="utf-8">
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
</head>
<div class="container">
    <h1>Register Customer</h1>
    <form method="POST" action="register_customer.php">
        <label for="name">Name:</label>
        <input type="text" name="name" required>
        <label for="address">Address:</label>
        <input type="text" name="address" required>
        <label for="email">E-mail:</label>
        <input type="email" name="email" required>
        <label for="mobile_no">Mobile No:</label>
        <input type="text" name="mobile_no" required>
        <label for="username">Username:</label>
        <input type="text" name="username" required>
        <label for="password">Password:</label>
        <input type="password" name="password" required>

        <h2>Bank Details</h2>
        <label for="bank_name">Bank Name:</label>
        <input type="text" name="bank_name" required>
        <label for="account_no">Account No:</label>
        <input type="text" name="account_no" required>
        <label for="branch">Branch:</label>
        <input type="text" name="branch" required>
        <label for="ifsc_code">IFSC Code:</label>
        <input type="text" name="ifsc_code" required>
        
        <button type="submit">Register</button>
    </form>
</div>

<?php
include 'footer.php';
?>