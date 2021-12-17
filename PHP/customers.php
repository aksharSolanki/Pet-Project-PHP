<?php
$server_name = "localhost";
$user_name = "root";
$server_password = "";
$db_name = "AdminDB";
$table_name = "customers";

//CHECK IF TABLE EXISTS
function checkTable($server_name, $user_name, $server_password, $db_name, $table_name)
{
    //CREATE NEW CONNECTION
    $conn = mysqli_connect($server_name, $user_name, $server_password, $db_name);
    $sql_query = "
                    CREATE TABLE IF NOT EXISTS $table_name (
                            customer_id int NOT NULL AUTO_INCREMENT,
                            firstName varchar(30) NOT NULL,
                            lastName varchar(30) NOT NULL,
                            address varchar(40) NOT NULL,
                            postal varchar(6) NOT NULL,
                            email varchar(50) NOT NULL,
                            phone numeric(10) NOT NULL,
                            account_created DATE NOT NULL,
                            PRIMARY KEY(customer_id) 
                        )";
    mysqli_query($conn, $sql_query);
}
?>
<html>

<head>
    <title>Customers</title>
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
    $custfname = "";
    $custlname = "";
    $custaddress = "";
    $addpostal = "";
    $custphone = "";
    $custemail = "";

    //INPUT VARIABLES
    $custfnameErr = "";
    $custlnameErr = "";
    $custaddressErr = "";
    $addpostalErr = "";
    $custphoneErr = "";
    $custemailErr = "";

    //INPUT VARIABLES
    $custfnameDB = "";
    $custlnameDB = "";
    $custaddressDB = "";
    $addpostalDB = "";
    $custphoneDB = "";
    $custemailDB = "";

    //FIRSTNAME VALIDATOR
    function validateFName($input)
    {
        $flag = true;
        if (empty($input)) {
            global $custfnameErr;
            $custfnameErr = "First name is required";
            $flag = false;
        } else {
            $flag = true;
            global $custfname;
            $custfname = test_input($input);
        }
        return $flag;
    }

    //LASTNAME VALIDATOR
    function validateLName($input)
    {
        $flag = true;
        if (empty($input)) {
            global $custlnameErr;
            $custlnameErr = "Last name is required";
            $flag = false;
        } else {
            $flag = true;
            global $custlname;
            $custlname = test_input($input);
        }
        return $flag;
    }

    //ADDRESS VALIDATOR
    function validateAddress($input)
    {
        $flag = true;
        if (empty($input)) {
            global $custaddressErr;
            $custaddressErr = "Address is required";
            $flag = false;
        } else {
            $flag = true;
            global $custaddress;
            $custaddress = test_input($input);
        }
        return $flag;
    }

    //POSTAL CODE VALIDATOR
    function validatePost($input)
    {
        $flag = true;
        if (empty($input)) {
            global $addpostalErr;
            $addpostalErr = "Postal code is required";
            $flag = false;
        } else {
            $flag = true;
            global $addpostal;
            $addpostal = test_input($input);
        }
        return $flag;
    }

    //PHONE VALIDATOR
    function validatePhone($input)
    {
        $flag = true;
        if (empty($input)) {
            global $custphoneErr;
            $custphoneErr = "Phone is required";
            $flag = false;
        } else {
            $flag = true;
            global $custphone;
            $custphone = test_input($input);
        }
        return $flag;
    }

    //EMAIL VALIDATOR
    function validateEmail($input)
    {
        $flag = true;
        if (empty($input)) {
            global $custemailErr;
            $custemailErr = "Email is required";
            $flag = false;
        } else {
            $flag = true;
            global $custemail;
            $custemail = test_input($input);
        }
        return $flag;
    }

    //ADD BUTTON 
    if (isset($_POST['btnAdd'])) {
        $flag = true;
        //FIRSTNAME VALIDATION
        $flag = validateFName($_POST['custFName']);
        //LASTNAME VALIDATION
        $flag = validateLName($_POST['custLName']);
        //ADDRESS VALIDATION
        $flag = validateAddress($_POST['custAddress']);
        //POSTAL CODE VALIDATION
        $flag = validatePost($_POST['addpostal']);
        //PHONE VALIDATION
        $flag = validatePhone($_POST['custphone']);
        //EMAIL VALIDATION
        $flag = validateEmail($_POST['custemail']);

        if ($flag) {
            $conn = mysqli_connect($server_name, $user_name, $server_password, $db_name);
            checkTable($server_name, $user_name, $server_password, $db_name, $table_name);

            $sql = "insert into $table_name (firstName, lastName, address, postal, email, phone, account_created)
                    values ('$custfname', '$custlname', '$custaddress', '$addpostal', '$custemail', '$custphone', now());";

            if (mysqli_query($conn, $sql)) {
                $messageBox = "Successfully inserted the record.";
                mysqli_close($conn);
            } else {
                global $errorBox;
                $errorBox = "Error while inserting the record: " . mysqli_error($conn);
            }
        } else {
            $errorBox = "Error while inserting the record";
        }
    }

    //SEARCH BUTTON
    if (isset($_POST['btnSearch'])) {
        $flag = true;
        //LASTNAME VALIDATION
        $flag = validateLName($_POST['custLName']);
        //PHONE VALIDATION
        $flag = validatePhone($_POST['custphone']);
        //EMAIL VALIDATION
        $flag = validateEmail($_POST['custemail']);

        if ($flag) {
            $conn = mysqli_connect($server_name, $user_name, $server_password, $db_name);
            checkTable($server_name, $user_name, $server_password, $db_name, $table_name);

            $sql = "select firstName, lastName, address, postal, email, phone
                    from $table_name where lastName = '$custlname' and phone = '$custphone' and email = '$custemail'";

            $results = mysqli_query($conn, $sql);
            if (mysqli_num_rows($results) > 0) {
                while ($rows = mysqli_fetch_assoc($results)) {
                    $custfnameDB = $rows["firstName"];
                    $custlnameDB = $rows["lastName"];
                    $custaddressDB = $rows["address"];
                    $custemailDB = $rows["email"];
                    $addpostalDB = $rows["postal"];
                    $custphoneDB = $rows["phone"];
                }
                if (mysqli_query($conn, $sql)) {
                    $messageBox = "Successfully found result";
                    mysqli_close($conn);
                } else {

                    $errorBox = "Error while inserting the record: " . mysqli_error($conn);
                }
            } else {
                $errorBox = "No record found";
            }
        }
    }

    //EDIT BUTTON
    if (isset($_POST['btnEdit'])) {
        $flag = true;
        //FIRSTNAME VALIDATION
        $flag = validateFName($_POST['custFName']);
        //LASTNAME VALIDATION
        $flag = validateLName($_POST['custLName']);
        //ADDRESS VALIDATION
        $flag = validateAddress($_POST['custAddress']);
        //POSTAL CODE VALIDATION
        $flag = validatePost($_POST['addpostal']);
        //PHONE VALIDATION
        $flag = validatePhone($_POST['custphone']);
        //EMAIL VALIDATION
        $flag = validateEmail($_POST['custemail']);

        if ($flag) {
            $conn = mysqli_connect($server_name, $user_name, $server_password, $db_name);
            checkTable($server_name, $user_name, $server_password, $db_name, $table_name);
            $sql = "update $table_name set 
                    firstName = '$custfname',
                     lastName = '$custlname',
                     address = '$custaddress',
                     postal = '$addpostal',
                     email = '$custemail',
                     phone = '$custphone'
                     where lastName = '$custlname' and phone = '$custphone' and email = '$custemail'";
            if (mysqli_query($conn, $sql)) {
                $messageBox = "Successfully updated the student records.";
                mysqli_close($conn);
            } else {
                $errorBox = "Error while updating the student records: " . mysqli_error($conn);
            }
        }
    }

    //DELETE BUTTON
    if (isset($_POST['btnDelete'])) {
        $flag = true;
        //LASTNAME VALIDATION
        $flag = validateLName($_POST['custLName']);
        //PHONE VALIDATION
        $flag = validatePhone($_POST['custphone']);
        //EMAIL VALIDATION
        $flag = validateEmail($_POST['custemail']);

        if ($flag) {
            $conn = mysqli_connect($server_name, $user_name, $server_password, $db_name);
            checkTable($server_name, $user_name, $server_password, $db_name, $table_name);
            
            $sql = "delete from $table_name where lastName = '$custlname' and phone = '$custphone' and email = '$custemail'";
            if (mysqli_query($conn, $sql)) {
                $messageBox = "Successfully deleted the customer record.";
            } else {
                $errorBox = "Error while deleting the customer record: " . mysqli_error($conn);
            }
        } else {
            $errorBox = "No record found to be deleted";
        }
    }

    if(isset($_POST['btnDash'])) {
        //HEAD TO DASH IF VERIFIED
        header('location:dashboard.php');
        exit();
    }

    //TESTING INPUT
    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return strtoupper($data);
    }
    ?>
    <div id="siteinfo">
        <h1>Pet Finder</h1>
        <h2>Configure Customer Info</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label>Enter customer firstname</label>
            <input type="text" name="custFName" value="<?php if (isset($_POST['custFName'])) {
                                                            echo htmlentities($_POST['custFName']);
                                                        } ?>" pattern="[A-Za-z]{3, 25}" title="Enter alphabets only" placeholder="First Name">
            <span id="error">*<?php echo $custfnameErr; ?></span>
            <br />
            <label>Enter customer lastname</label>
            <input type="text" name="custLName" value="<?php if (isset($_POST['custLName'])) {
                                                            echo htmlentities($_POST['custLName']);
                                                        } ?>" pattern="[A-Za-z]{3, 25}" title="Enter alphabets only" placeholder="Last Name">
            <span id="error">*<?php echo $custlnameErr; ?></span>
            <br />
            <label>Enter customer address</label>
            <input type="text" name="custAddress" value="<?php if (isset($_POST['custAddress'])) {
                                                                echo htmlentities($_POST['custAddress']);
                                                            } ?>" pattern="[A-Za-z\d]{5, 25}" title="Enter alphabets only" placeholder="Address">
            <span id="error">*<?php echo $custaddressErr; ?></span>
            <br />
            <label>Enter address postal code</label>
            <input type="text" name="addpostal" value="<?php if (isset($_POST['addpostal'])) {
                                                            echo htmlentities($_POST['addpostal']);
                                                        } ?>" pattern="[A-Za-z]{1}[0-9]{1}[A-Za-z]{1}[0-9]{1}[A-Za-z]{1}[0-9]{1}" title="Enter proper postal code only" placeholder="Postal code">
            <span id="error">*<?php echo $addpostalErr; ?></span>
            <br />
            <label>Enter customer phone</label>
            <input type="tel" name="custphone" value="<?php if (isset($_POST['custphone'])) {
                                                            echo htmlentities($_POST['custphone']);
                                                        } ?>" pattern="[0-9]{3}[0-9]{3}[0-9]{4}" placeholder="Phone">
            <span id="error" *><?php echo $custphoneErr; ?></span>
            <br />
            <label>Your Email</label>
            <input type="email" name="custemail" value="<?php if (isset($_POST['custemail'])) {
                                                            echo htmlentities($_POST['custemail']);
                                                        } ?>" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" placeholder="Email">
            <span id="error">*<?php echo $custemailErr; ?></span>
            <br />
            <br />
            <input type="submit" name="btnAdd" value="Add" />
            <input type="submit" name="btnSearch" value="Search" />
            <input type="submit" name="btnEdit" value="Edit Info" />
            <input type="submit" name="btnDelete" value="Delete Record" />
            <input type="reset" value="Reset" />
            <input type="submit" name="btnDash" value="Dashboard" />
        </form>
        <div id="div_result_customers">
            Customer Name: <span  > <?php echo $custfnameDB . " " . $custlnameDB; ?></span><br />
            Address: <span  ><?php echo $custaddressDB; ?></span><br />
            Postal code: <span  ><?php echo $addpostalDB; ?></span><br />
            Phone: <span  ><?php echo $custphoneDB; ?></span><br />
            Email: <span  ><?php echo $custemailDB; ?></span><br />
        </div>
    </div>

    <span><?php echo $messageBox; ?></span>
    <span><?php echo $errorBox; ?></span>
</body>
<script type="text/javascript">
    document.getElementById("btnDash").onclick = function() {
        location.href = "dashboard.php";
    }
</script>
</html>