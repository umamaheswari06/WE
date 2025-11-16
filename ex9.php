   <?php 
// PHP code remains unchanged from the previous example // Initialize variables to store error messages and form inputs 
$usernameErr = $emailErr = $passwordErr = $phoneErr = ""; 
$username = $email = $password = $phone = ""; 
 
// Check if the form is submitted 
if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    // Validate Username 
    if (empty($_POST["username"])) {         $usernameErr = "Username is required";     } else { 
        $username = test_input($_POST["username"]);         if (!preg_match("/^[a-zA-Z-' ]*$/", $username)) {             $usernameErr = "Only letters and spaces allowed"; 
        } 
    } 
 
    // Validate Email     if (empty($_POST["email"])) {         $emailErr = "Email is required"; 
    } else { 
        $email = test_input($_POST["email"]); 
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { 
            $emailErr = "Invalid email format"; 
        } 
    }  
    // Validate Password 
    if (empty($_POST["password"])) {         $passwordErr = "Password is required";     } else { 
        $password = test_input($_POST["password"]);         if (strlen($password) < 8 || !preg_match("/[a-z]/i", $password) || !preg_match("/[0-9]/", $password)) { 
            $passwordErr = "Password must be at least 8 characters long, contain one letter and one number"; 
        } 
    } 
 
    // Validate Phone 
    if (empty($_POST["phone"])) { 
        $phoneErr = "Phone number is required"; 
    } else { 
        $phone = test_input($_POST["phone"]);         if (!preg_match("/^[0-9]{10}$/", $phone)) { 
            $phoneErr = "Invalid phone number. Must be 10 digits."; 
        } 
   } 
   // If no errors, proceed to database insertion 
   if (empty($usernameErr) && empty($emailErr) && empty($passwordErr) && 
empty($phoneErr)) { 
        // Database connection 
        $servername = "localhost"; 
        $username_db = "root"; // Default XAMPP MySQL username 
        $password_db = ""; // Leave empty for default 
        $dbname = "user_registration"; 
 
        // Create connection 
        $conn = new mysqli($servername, $username_db, $password_db, $dbname); 
 
        // Check connection         if ($conn->connect_error) { 
            die("Connection failed: " . $conn->connect_error); 
        }  
        // Hash the password before saving it 
        $hashed_password = password_hash($password, PASSWORD_DEFAULT); 
 
        // Insert data into the database 
        $sql = "INSERT INTO users (username, email, password, phone) VALUES 
('$username', '$email', '$hashed_password', '$phone')"; 
 
        if ($conn->query($sql) === TRUE) {             echo "<p class='success-message'>New record created successfully</p>"; 
        } else { 
            echo "<p class='error-message'>Error: " . $sql . "<br>" . $conn->error . "</p>"; 
        } 
 
        $conn->close(); 
    
 
// Function to sanitize user input function test_input($data) {     $data = trim($data); 
    $data = stripslashes($data);     $data = htmlspecialchars($data); 
    return $data; 
?> 
 
<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Registration Form</title> 
    <style> 
       body {            font-family: Arial, sans-serif;            background-color: #f4f4f9;            margin: 0; 
            padding: 0;             display: flex;             justify-content: center;             align-items: center; 
            height: 100vh; 
        }         .container {             background-color: #ffffff;             padding: 20px;             border-radius: 8px;             box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);             width: 100%; 
            max-width: 500px; 
        }         h2 {             text-align: center;             color: #333; 
        } 
 
        form {             display: flex; 
            flex-direction: column; 
        } 
        label {             margin-bottom: 8px;             font-weight: bold;             color: #333; 
        } 
 
        input[type="text"],         input[type="password"] {             padding: 10px;             margin-bottom: 12px;             border: 1px solid #ddd;             border-radius: 4px; 
            font-size: 16px; 
        } 
 
        input[type="submit"] {             padding: 10px;             background-color: #007bff;             border: none;             border-radius: 4px;             color: white;             font-size: 16px;             cursor: pointer;             transition: background-color 0.3s; 
        } 
       input[type="submit"]:hover { 
           background-color: #0056b3; 
       } 
 
        .error-message {             color: #e74c3c;             font-size: 14px; 
            margin: 10px 0; 
        } 
 
        .success-message {             color: #2ecc71;             font-size: 14px; 
            margin: 10px 0; 
        } 
    </style> 
</head> <body> 
 
<div class="container"> 
    <h2>Registration Form</h2> 
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
        <label for="username">Username:</label> 
        <input type="text" id="username" name="username" value="<?php echo $username; ?>"> 
        <span class="error-message"><?php echo $usernameErr; ?></span> 
 
        <label for="email">Email:</label> 
        <input type="text" id="email" name="email" value="<?php echo $email; ?>"> 
        <span class="error-message"><?php echo $emailErr; ?></span> 
 
        <label for="password">Password:</label> 
        <input type="password" id="password" name="password" value="<?php echo $password; ?>"> 
        <span class="error-message"><?php echo $passwordErr; ?></span> 
 
        <label for="phone">Phone:</label> 
        <input type="text" id="phone" name="phone" value="<?php echo $phone; ?>"> 
        <span class="error-message"><?php echo $phoneErr; ?></span> 
 
        <input type="submit" name="submit" value="Register"> 
    </form> </div> 
 
</body> </html> 
 
