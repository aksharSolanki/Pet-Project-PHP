<?php
$server_name = "localhost";
$user_name = "root";
$server_password = "";
$db_name = "AdminDB";
$table_name = "adminAccounts";
?>
<html>

<head>
    <title>Admin Login</title>
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
            width: 55%;
            color: white;
            margin-left: 25%;
            padding: 25px;
        }
    </style>
</head>

<body>
    <?php
    $username = "";
    $password = "";
    $errorBox = "";

    $usernameErr = "";
    $passwordErr = "";

    if(isset($_POST['btnSignup'])) {
        //HEAD TO HOME IF VERIFIED
        header('location:adminSignUp.php');
        exit();
    }

    if (isset($_POST['btnSubmit'])) {
        $flag = true;
        //USERNAME VALIDATION
        if (empty($_POST['adminUserName'])) {
            $usernameErr = "Username is required";
            $flag = false;
        } else {
            $username = test_input($_POST['adminUserName']);
        }
        // //PASSWORD VALIDATION
        if (empty($_POST['adminPass'])) {
            $passwordErr = "Password is required";
            $flag = false;
        } else {
            $password = test_input($_POST['adminPass']);
        }

        if ($flag) {
            $conn = mysqli_connect($server_name, $user_name, $server_password, $db_name);

            //VALIDATE USERNAME
            $sql = "select userName from $table_name where userName = '$username'";
            $resultU = mysqli_query($conn, $sql);
            if (mysqli_num_rows($resultU) > 0) {
                $sql = "select userName, password from $table_name where userName = '$username'";
                $resultP = mysqli_query($conn, $sql);
                if (mysqli_num_rows($resultP) > 0) {
                    while ($rows = mysqli_fetch_assoc($resultP)) {
                        $DBusername = $rows["userName"];
                        $DBpassword = $rows["password"];
                        if (($username == $DBusername) && ($password == $DBpassword)) {
                            //HEAD TO HOME IF VERIFIED
                            header('location:dashboard.php');
                            exit();
                        } else {
                            $errorBox = "Invalid password";
                        }
                    }
                }
            } else {
                $errorBox = "Invalid username or password";
            }
        }
    }
    //TESTING INPUT
    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    ?>
    <div id="siteinfo">
        <h1>Pet Finder</h1>
        <h2>Admin Login</h2>
        <form method="post">
            <label>Your Username</label>
            <input type="text" name="adminUserName" value="<?php if (isset($_POST['adminUserName'])) {
                                                                echo htmlentities($_POST['adminUserName']);
                                                            } ?>" pattern="[A-Za-z\d\.]{5,31}" title="Username accepts letters, numbers and period only" placeholder="Username">
            <span id="error">*<?php echo $usernameErr; ?></span><br /><br />
            <label>Your Password</label>
            <input type="password" name="adminPass" value="<?php if (isset($_POST['adminPass'])) {
                                                                echo htmlentities($_POST['adminPass']);
                                                            } ?>" placeholder="Password">
            <span id="error">*<?php echo $passwordErr; ?></span><br><br>
            <input type="submit" name="btnSubmit" value="Submit" />
            <input type="reset" name="btnReset" value="Reset" />
            <input type="submit" name="btnSignup" value="Sign Up" />
            <br />
            <span id="error"><?php echo $errorBox; ?></span>
        </form>
    </div>
</body>
</html>