<?php
$server_name = "localhost";
$user_name = "root";
$server_password = "";
$db_name = "AdminDB";
$table_name = "adminAccounts";

//CHECK IF TABLE EXISTS
function checkTable($server_name, $user_name, $server_password, $db_name, $table_name)
{
    //CREATE NEW CONNECTION
    $conn = mysqli_connect($server_name, $user_name, $server_password, $db_name);
    $sql_query = "
                    CREATE TABLE IF NOT EXISTS $table_name (
                            admin_id int NOT NULL AUTO_INCREMENT,
                            firstName varchar(30) NOT NULL,
                            lastName varchar(30) NOT NULL,
                            userName varchar(40) NOT NULL,
                            password varchar(40) NOT NULL,
                            email varchar(50) NOT NULL,
                            phone numeric(10) NOT NULL,
                            agreement boolean NOT NULL,
                            account_created DATE NOT NULL,
                            PRIMARY KEY(admin_id) 
                        )
                    ";
    mysqli_query($conn, $sql_query);
}

//CHECK IF DATABASE EXISTS
function checkDB($server_name, $db_name, $user_name, $server_password)
{
    //MAKING CONNECTION TO CREATE DATABASE IF DOESN'T EXIST
    $conn = mysqli_connect($server_name, $user_name, $server_password);
    $sql_query = "CREATE DATABASE $db_name";
    mysqli_query($conn, $sql_query);
}
?>
<html>

<head>
    <title>Admin Sign Up</title>
    <link rel="stylesheet" href="PetAdoptionCSS.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito&family=Poppins:wght@200;400&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito&family=Poppins:ital,wght@0,200;0,400;1,200&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-image: url(./img/bg.jpeg);
            background-size: cover;
        }

        #siteinfo {
            margin-top: 3%;
            background-color: rgba(0, 0, 0, 0.5);
            width: 60%;
            color: white;
            margin-left: 15%;
            padding: 25px;
        }

        #field {
            font-family: 'Poppins', sans-serif;
            width: 30%;
            margin-left: 10px;
        }

        button {
            font-family: 'Poppins', sans-serif;
            font-size: 1em;
            border-radius: 10px;
            background-color: rgba(255, 255, 255, 0.6);
            width: 20%;
        }

        #button {
            font-family: 'Poppins', sans-serif;
            font-size: 1.2em;
            border-radius: 10px;
            padding: 5px;
            background-color: rgba(255, 255, 255, 0.6);
            width: 20%;
        }
    </style>
</head>

<body>
    <?php
    //INPUT VARIABLES
    $fname = "";
    $lname = "";
    $username = "";
    $password = "";
    $email = "";
    $phone = "";
    $agree = false;

    //ERROR MESSAGES FOR INPUT VARIABLES
    $fnameErr = "";
    $lnameErr = "";
    $usernameErr = "";
    $passwordErr = "";
    $emailErr = "";
    $phoneErr = "";
    $agreeErr = "";

    $errorBox = "";
    $messageBox = "";

    //SUBMIT BUTTON CLICK EVENT
    if (isset($_POST['btnSubmit'])) {
        $flag = true;
        //FIRST NAME VALIDATION
        if (empty($_POST['adminFName'])) {
            $fnameErr = "First name is required";
            $flag = false;
        } else {
            $fname = test_input($_POST['adminFName']);
        }
        // LAST NAME VALIDATION
        if (empty($_POST['adminLName'])) {
            $lnameErr = " Last name is required";
            $flag = false;
        } else {
            $lname = test_input($_POST['adminLName']);
        }
        // USER NAME VALIDATION
        if (empty($_POST['adminUserName'])) {
            $usernameErr = "Username is required";
            $flag = false;
        } else {
            $username = test_input($_POST['adminUserName']);
        }
        // PASSWORD VALIDATION
        if (empty($_POST['adminPass'])) {
            $passwordErr = "Password is required";
            $flag = false;
        } else {
            $password = test_input($_POST['adminPass']);
        }
        // EMAIL VALIDATION
        if (empty($_POST['adminEmail'])) {
            $emailErr = "Email is required";
            $flag = false;
        } else {
            $email = test_input($_POST['adminEmail']);
        }
        // PHONE VALIDATION
        if (empty($_POST['adminPhone'])) {
            $phoneErr = "Phone is required";
            $flag = false;
        } else {
            $phone = test_input($_POST['adminPhone']);
        }
        // AGREEMENT VALIDATION
        if ($_POST['agreement']) {
            $agree = true;
        } else {
            $agreeErr = "Please agree to the terms";
            $flag = false;
        }

        if ($flag) {
            $conn = mysqli_connect($server_name, $user_name, $server_password, $db_name);
            checkDB($server_name, $db_name, $user_name, $server_password);
            checkTable($server_name, $user_name, $server_password, $db_name, $table_name);

            //VALIDATE USERNAME
            $sql = "select username from $table_name where username = '$username'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
            $usernameErr = "Username is already taken";
            } else {
            //INSERTING ADMIN DATA INTO THE TABLE
            $sql = "insert into $table_name (firstName, lastName, userName, password, email, phone, agreement, account_created)
                values('$fname', '$lname', '$username', '$password', '$email', '$phone', '$agree', now())";

            if (mysqli_query($conn, $sql)) {
                $messageBox = "Successfully inserted the record.";
                //mysqli_close($conn);
                //HEAD TO HOME IF VERIFIED
                // header('location:Login.php');
                // exit();
            } else {
                global $errorBox;
                $errorBox = "Error while inserting the record: " . mysqli_error($conn);
            }
        }
        }
    }

    //TESTING INPUT
    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return strtoupper($data);
    }

    //CHECK USERNAME
    function check_username($server_name, $user_name, $server_password, $db_name, $table_name, $username)
    {
        $conn = mysqli_connect($server_name, $user_name, $server_password, $db_name);
        $sql_query = "select $username from $table_name";
        $result = mysqli_query($conn, $sql_query);
    }

    ?>
    <div id="siteinfo">
        <h1>Pet Finder</h1>
        <h2>Admin Signup</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label>Your Name</label>
            <input type="text" name="adminFName" value="<?php if (isset($_POST['adminFName'])) {
                                                            echo htmlentities($_POST['adminFName']);
                                                        } ?>" placeholder="First Name">
            <input type="text" name="adminLName" value="<?php if (isset($_POST['adminLName'])) {
                                                            echo htmlentities($_POST['adminLName']);
                                                        } ?>"" placeholder="Last Name">
            <span id="error">*<?php echo $fnameErr;
                                echo $lnameErr; ?></span>
            <br />
            <label>Create unique Username</label>
            <input type="text" name="adminUserName" value="<?php if (isset($_POST['adminUserName'])) {
                                                                echo htmlentities($_POST['adminUserName']);
                                                            } ?>" placeholder="Username">
            <span id="error">*<?php echo $usernameErr; ?></span>
            <br />
            <label>Create Secure Password</label>
            <input type="password" name="adminPass" value="<?php if (isset($_POST['adminPass'])) {
                                                                echo htmlentities($_POST['adminPass']);
                                                            } ?>" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters" placeholder="Password">
            <span id="error">*<?php echo $passwordErr; ?></span>
            <br />
            <label>Your Email</label>
            <input type="email" name="adminEmail" value="<?php if (isset($_POST['adminEmail'])) {
                                                                echo htmlentities($_POST['adminEmail']);
                                                            } ?>" placeholder="Email">
            <span id="error">*<?php echo $emailErr; ?></span>
            <br />
            <label>Your Phone</label>
            <input type="tel" name="adminPhone" value="<?php if (isset($_POST['adminPhone'])) {
                                                            echo htmlentities($_POST['adminPhone']);
                                                        } ?>" pattern="[0-9]{3}[0-9]{3}[0-9]{4}" placeholder="Phone">
            <span id="error">*<?php echo $phoneErr; ?></span>
            <br />
            <input type="checkbox" name="agreement" <?php if (isset($_POST['agreement'])) {
                                                        echo "checked='checked'";
                                                    } ?>>
            <label>I agree to the Terms of Service and Privacy Policy</label>
            <span id="error">*<?php echo $agreeErr; ?></span>
            <br /><br />
            <input type="submit" name="btnSubmit" value="Submit">
            <input type="reset" name="btnReset" value="Reset">
            <br /><br />
            <span id="message"><?php echo $messageBox; ?></span>
            <span id="error"><?php echo $errorBox; ?></span>
        </form>
        <label>Already have an account?</label><br />
        <button id="loginButton">Login</button>
    </div>
</body>
<script type="text/javascript">
    document.getElementById("loginButton").onclick = function() {
        location.href = "Login.php";
    }
</script>
</html>