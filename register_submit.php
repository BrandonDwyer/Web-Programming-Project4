<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifying Registration</title>
    <link href="styles/styles.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <?php
    include 'db/connect_db.php';

    if (isset($_POST['Submit'])) {
        $firstname = isset($_POST['firstname']) ? $_POST['firstname'] : '';
        $lastname = isset($_POST['lastname']) ? $_POST['lastname'] : '';
        $type = isset($_POST['type']) ? $_POST['type'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $confirmPass = isset($_POST['confirmPass']) ? $_POST['confirmPass'] : '';
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $cardNum = isset($_POST['card-num']) ? $_POST['card-num'] : '';
        $cardExp = isset($_POST['card-exp']) ? $_POST['card-exp'] : '';
        $address = isset($_POST['address']) ? $_POST['address'] : '';
        $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    }
    $isValid = true;
    $errors = [];

    function password_match($password1, $password2) {
        $str1 = strtolower($password1);
        $str2 = strtolower($password2);
        return (strcmp($str1, $str2) == 0) ? true : false;
    }

    if ($firstname == "") {
        $isValid = false;
        $errors[] = "First Name field is empty.";
    }

    if ($lastname == "") {
        $isValid = false;
        $errors[] = "Last Name field is empty.";
    }

    if ($type == "") {
        $isValid = false;
        $errors[] = "User type(Buyer or Seller) field is empty.";
    }

    if ($email == "") {
        $isValid = false;
        $errors[] = "Email field is empty.";
    }

    $sql = mysqli_query($conn, "SELECT * FROM User WHERE email = '$email' ");
    if (mysqli_num_rows($sql)) {
        $isValid = false;
        $errors[] = "The email: $email is already in use";
    }

    if ($password == "") {
        $isValid = false;
        $errors[] = "Password field is empty.";
    }

    if (!password_match($password, $confirmPass)) {
        $isValid = false;
        $errors[] = "Passwords do not match.";
    }

    if ($name == "") {
        $isValid = false;
        $errors[] = "Name on Card field is empty.";
    }

    if ($cardNum == "") {
        $isValid = false;
        $errors[] = "Card Number field is empty.";
    }
    if ($cardExp == "") {
        $isValid = false;
        $errors[] = "Card Exp. Date field is empty.";
    }

    if ($address == "") {
        $isValid = false;
        $errors[] = "Address field is empty.";
    }

    if ($phone == "") {
        $isValid = false;
        $errors[] = "Phone Number field is empty.";
    }


    if (!$isValid) {
        echo "<div class='error'><p>Please fix the following errors:<ul>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul><input type='button' value='Go Back' onClick='history.back()'></p></div>";
        exit(-1);
    } else {
        $sql = "INSERT INTO User (firstname, lastname, type, email, password)
                VALUES('$firstname', '$lastname', '$type', '$email', md5('$password'))";
        if (mysqli_query($conn, $sql)) {
            header("location:login.php");
            exit;
        }
    }

    mysqli_close($conn);
    ?>
</body>

</html>