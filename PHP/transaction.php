<?php
$server_name = "localhost";
$user_name = "root";
$server_password = "";
$db_name = "AdminDB";
$table_name = "transactions";

//CHECK IF TABLE EXISTS
function checkTable($server_name, $user_name, $server_password, $db_name, $table_name)
{
    //CREATE NEW CONNECTION
    $conn = mysqli_connect($server_name, $user_name, $server_password, $db_name);
    $sql_query = "
                    CREATE TABLE IF NOT EXISTS $table_name (
                            transaction_id int NOT NULL AUTO_INCREMENT,
                            charge int NOT NULL,
                            pet_id varchar(30) NOT NULL,
                            customer_id int NOT NULL,
                            payment_mode varchar(25) NOT NULL,
                            date_adopted DATE NOT NULL,
                            PRIMARY KEY(transaction_id)
                        )";
    mysqli_query($conn, $sql_query);
}
?>
<html>

<head>
    <title>Transactions</title>
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
    $txncharge = "";
    $petid = "";
    $custid = "";
    $payment = "";

    $txnchargeErr = "";
    $petidErr = "";
    $custidErr = "";
    $paymentErr = "";
    $messageBox = "";
    $errorBox = "";

    $txnchargeDB = "";
    $petidDB = "";
    $custidDB = "";
    $paymentDB = "";
    $dateadoptedDB = "";

    //TXNCHARGE VALIDATOR
    function validateCharge($input)
    {
        $flag = true;
        if (empty($input)) {
            $flag = false;
            global $txnchargeErr;
            $txnchargeErr = "Charge is required";
        } else {
            $flag = true;
            global $txncharge;
            $txncharge = test_input($input);
        }
        return $flag;
    }

    //PET ID VALIDATOR
    function validatePetid($input)
    {
        $flag = true;
        if (empty($input)) {
            $flag = false;
            global $petidErr;
            $petidErr = "Pet ID is required";
        } else {
            $flag = true;
            global $petid;
            $petid = test_input($input);
        }
        return $flag;
    }

    //CUSTOMER ID VALIDATOR
    function validateCustomerid($input)
    {
        $flag = true;
        if (empty($input)) {
            $flag = false;
            global $custidErr;
            $custidErr = "Customer ID is required";
        } else {
            $flag = true;
            global $custid;
            $custid = test_input($input);
        }
        return $flag;
    }

    //PAYMENT VALIDATOR
    function validatePayment($input)
    {
        $flag = true;
        if (!(isset($input))) {
            global $paymentErr;
            $paymentErr = "Payment is required";
            $flag = false;
        } else {
            global $payment;
            $payment = test_input($input);
        }
        return $flag;
    }

    //ASSIGN BUTTON CODE
    if (isset($_POST['btnAssign'])) {
        $flag = true;
        //CHARGE VALIDATION
        $flag = validateCharge($_POST['txncharge']);
        // //PET ID VALIDATION
        $flag = validatePetid($_POST['petid']);
        //CUSTOMER ID VALIDATION
        $flag = validateCustomerid($_POST['custid']);
        //PAYMENT VALIDATION
        $flag = validatePayment($_POST['payment']);

        if ($flag) {
            $conn = mysqli_connect($server_name, $user_name, $server_password, $db_name);
            checkTable($server_name, $user_name, $server_password, $db_name, $table_name);

            $sql = "select pet_id from $table_name where pet_id = '$petid'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                $errorBox = "Pet already assigned";
            } else {
                $sql = "insert into $table_name (charge, pet_id, customer_id, payment_mode, date_adopted)
                    values ('$txncharge', '$petid', '$custid', '$payment', now());";

                $sql2 = "update pets set status = 'ADOPTED'
                     where pet_id = '$petid'";

                if (mysqli_query($conn, $sql) && mysqli_query($conn, $sql2)) {
                    $messageBox = "Successfully inserted the record";
                    mysqli_close($conn);
                } else {
                    global $errorBox;
                    $errorBox = "Error while inserting the record: " . mysqli_error($conn);
                }
            }
        } else {
            $errorBox = "Error while inserting the record";
        }
    }

    if (isset($_POST['btnShow'])) {
        $flag = true;
        // //PET ID VALIDATION
        $flag = validatePetid($_POST['petid']);
        //CUSTOMER ID VALIDATION
        $flag = validateCustomerid($_POST['custid']);

        if ($flag) {
            $conn = mysqli_connect($server_name, $user_name, $server_password, $db_name);
            checkTable($server_name, $user_name, $server_password, $db_name, $table_name);

            $sql = "select charge, pet_id, customer_id, payment_mode, date_adopted
                    from $table_name where pet_id = '$petid' and customer_id = '$custid'";

            $results = mysqli_query($conn, $sql);
            if (mysqli_num_rows($results) > 0) {
                while ($rows = mysqli_fetch_assoc($results)) {
                    $txnchargeDB = "$" . $rows["charge"];
                    $petidDB = $rows["pet_id"];
                    $custidDB = $rows["customer_id"];
                    $paymentDB = $rows["payment_mode"];
                    $dateadoptedD = $rows["date_adopted"];
                }
                if (mysqli_query($conn, $sql)) {
                    $messageBox = "Successfully found result";
                    mysqli_close($conn);
                } else {
                    $errorBox = "Error while searching the record: " . mysqli_error($conn);
                }
            } else {
                $errorBox = "No record found";
            }
        }
    }
    if (isset($_POST['btnDash'])) {
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
        <h2>Manage Transactions</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label>Enter amount charged $</label>
            <input type="text" name="txncharge" value="<?php if (isset($_POST['txncharge'])) {
                                                            echo htmlentities($_POST['txncharge']);
                                                        } ?>" placeholder="Charge" require>
            <span id="error">*<?php echo $txnchargeErr; ?></span>
            <br />
            <label>Enter pet id</label>
            <input type="number" name="petid" value="<?php if (isset($_POST['petid'])) {
                                                            echo htmlentities($_POST['petid']);
                                                        } ?>" placeholder="Pet id" require>
            <span id="error">*<?php echo $petidErr; ?></span>
            <br />
            <label>Enter customer id</label>
            <input type="number" name="custid" value="<?php if (isset($_POST['custid'])) {
                                                            echo htmlentities($_POST['custid']);
                                                        } ?>" placeholder="Customer id" require>
            <span id="error">*<?php echo $custidErr; ?></span>
            <br />
            <label>Enter payment method</label>
            <select id="select_payment" name="payment">
                <option selected disabled value="">Select a payment type</option>
                <option value="credit" required>Credit card</option>
                <option value="debit" required>Debit card</option>
                <option value="check" required>Check</option>
                <option value="e_trasnfer" required>e-Transfer</option>
            </select>
            <span id="error">*<?php echo $paymentErr; ?></span>
            <br /><br />
            <input type="submit" name="btnAssign" value="Assign" />
            <input type="submit" name="btnShow" value="Show Transaction" />
            <input type="reset" value="Reset" />
            <input type="submit" name="btnDash" value="Dashboard" />
        </form>
        <div id="div_result_txn">
            Charge: <span> <?php echo $txnchargeDB; ?></span><br />
            Pet ID: <span><?php echo $petidDB; ?></span><br />
            Customer ID: <span><?php echo $custidDB; ?></span><br />
            Payment Mode: <span><?php echo $paymentDB; ?></span><br />
            Adopted on: <span><?php echo $dateadoptedD; ?></span><br />
        </div>
        <span id="error"><?php echo $errorBox; ?></span>
        <span><?php echo $messageBox; ?></span>
    </div>
</body>

</html>