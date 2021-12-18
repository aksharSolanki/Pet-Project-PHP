<?php
$server_name = "localhost";
$user_name = "root";
$server_password = "";
$db_name = "AdminDB";
$table_name = "pets";

//CHECK IF TABLE EXISTS
function checkTable($server_name, $user_name, $server_password, $db_name, $table_name)
{
    //CREATE NEW CONNECTION
    $conn = mysqli_connect($server_name, $user_name, $server_password, $db_name);
    $sql_query = "
                    CREATE TABLE IF NOT EXISTS $table_name (
                            pet_id int NOT NULL AUTO_INCREMENT,
                            petCategory varchar(30) NOT NULL,
                            petName varchar(30) NOT NULL,
                            petBreed varchar(30) NOT NULL,
                            petAge numeric(5) NOT NULL,
                            petGender varchar(30) NOT NULL,
                            petListedOn DATE NOT NULL,
                            status varchar(15) NOT NULL,
                            PRIMARY KEY(pet_id) 
                        )";
    mysqli_query($conn, $sql_query);
}
?>
<html>

<head>
    <title>About pets</title>
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
    $petcategory = "";
    $petname = "";
    $petbreed = "";
    $petage = "";
    $petgender = "";
    $petstatus = "";

    $petcategoryDB = "";
    $petnameDB = "";
    $petbreedDB = "";
    $petageDB = "";
    $petgenderDB = "";
    $petstatusDB = "";

    //ERROR MESSAGES FOR INPUT VARIABLES
    $petcategoryErr = "";
    $petnameErr = "";
    $petbreedErr = "";
    $petageErr = "";
    $petgenderErr = "";
    $petstatusErr = "";
    $messageBox = "";
    $errorBox = "";

    //NAME VALIDATOR
    function validatePetName($input)
    {
        $flag = true;
        if (empty($input)) {
            global $petnameErr;
            $petnameErr = "Pet name is required";
            $flag = false;
        } else {
            $flag = true;
            global $petname;
            $petname = test_input($input);
        }
        return $flag;
    }

    //BREED VALIDATOR
    function validatePetBreed($input)
    {
        $flag = true;
        if (empty($input)) {
            global $petbreedErr;
            $petbreedErr = "Pet breed is required";
            $flag = false;
        } else {
            $flag = true;
            global $petbreed;
            $petbreed = test_input($input);
        }
        return $flag;
    }

    //AGE VALIDATOR
    function validatePetAge($input)
    {
        $flag = true;
        if (empty($input)) {
            global $petageErr;
            $petageErr = "Pet age is required";
            $flag = false;
        } else {
            $flag = true;
            global $petage;
            $petage = test_input($input);
        }
        return $flag;
    }

    //CATEGORY VALIDATOR
    function validatePetCategory($input)
    {
        $flag = true;
        if (!isset($input)) {
            global $petcategoryErr;
            $petcategoryErr = "Pet category is required";
            $flag = false;
        } else {
            $flag = true;
            global $petcategory;
            $petcategory = test_input($input);
        }
        return $flag;
    }

    //GENDER VALIDATOR
    function validatePetGender($input)
    {
        $flag = true;
        if (!isset($input)) {
            global $petgenderErr;
            $petgenderErr = "Pet gender is required";
            $flag = false;
        } else {
            $flag = true;
            global $petgender;
            $petgender = test_input($input);
        }
        return $flag;
    }

    //STATUS VALIDATOR
    function validateStatus($input)
    {
        $flag = true;
        if (!isset($input)) {
            global $petstatusErr;
            $petstatusErr = "Pet status is required";
            $flag = false;
        } else {
            $flag = true;
            global $petstatus;
            $petstatus = test_input($input);
        }
        return $flag;
    }

    //ADD BUTTON 
    if (isset($_POST['btnAdd'])) {
        $flag = true;
        //CATEGORY VALIDATION
        $flag = validatePetCategory($_POST['petCategory']);
        //PET NAME VALIDATION
        $flag = validatePetName($_POST['petName']);
        //PET BREED VALIDATION
        $flag = validatePetBreed($_POST['petBreed']);
        //PET AGE VALIDATION
        $flag = validatePetAge($_POST['petAge']);
        //PET GENDER VALIDATION
        $flag = validatePetGender($_POST['petGender']);
        // PET STATUS VALIDATION
        $flag = validateStatus($_POST['petStatus']);
        if ($flag) {
            $conn = mysqli_connect($server_name, $user_name, $server_password, $db_name);
            checkTable($server_name, $user_name, $server_password, $db_name, $table_name);

            $sql = "insert into $table_name (petCategory, petName, petBreed, petAge, petGender, status, petListedOn)
                    values ('$petcategory', '$petname', '$petbreed', '$petage', '$petgender', '$petstatus', now());";

            if (mysqli_query($conn, $sql)) {
                $messageBox = "Successfully inserted the record.";
                mysqli_close($conn);
            } else {
                global $errorBox;
                $errorBox = "Error while inserting the record: " . mysqli_error($conn);
            }
        }
    }

    //SEARCH BUTTON
    if (isset($_POST['btnSearch'])) {
        $flag = true;
        //CATEGORY VALIDATION
        $flag = validatePetCategory($_POST['petCategory']);
        //PET NAME VALIDATION
        $flag = validatePetName($_POST['petName']);
        //PET BREED VALIDATION
        $flag = validatePetBreed($_POST['petBreed']);

        if ($flag) {
            $conn = mysqli_connect($server_name, $user_name, $server_password, $db_name);
            checkTable($server_name, $user_name, $server_password, $db_name, $table_name);

            $sql = "select petCategory, petName, petBreed, petAge, petGender, status
                    from $table_name where petCategory = '$petcategory' and petBreed = '$petbreed' and petName = '$petname'";
            //AND petBreed = '$petbreed' AND petName = '$petName'
            $results = mysqli_query($conn, $sql);
            if (mysqli_num_rows($results) > 0) {
                while ($rows = mysqli_fetch_assoc($results)) {
                    $petcategoryDB = $rows["petCategory"];
                    $petnameDB = $rows["petName"];
                    $petbreedDB = $rows["petBreed"];
                    $petageDB = $rows["petAge"] . " MONTHS";
                    $petgenderDB = $rows["petGender"];
                    $petstatusDB = $rows["status"];
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

    //EDIT BUTTON
    if (isset($_POST['btnEdit'])) {
        $flag = true;
        //CATEGORY VALIDATION
        $flag = validatePetCategory($_POST['petCategory']);
        //PET NAME VALIDATION
        $flag = validatePetName($_POST['petName']);
        //PET BREED VALIDATION
        $flag = validatePetBreed($_POST['petBreed']);
        //PET AGE VALIDATION
        $flag = validatePetAge($_POST['petAge']);
        //PET GENDER VALIDATION
        $flag = validatePetGender($_POST['petGender']);
        // PET STATUS VALIDATION
        $flag = validateStatus($_POST['petStatus']);

        if ($flag) {
            $conn = mysqli_connect($server_name, $user_name, $server_password, $db_name);
            checkTable($server_name, $user_name, $server_password, $db_name, $table_name);
            $sql = "update $table_name set 
                    petCategory = '$petcategory',
                     petName = '$petname',
                     petBreed = '$petbreed',
                     petAge = '$petage',
                     petGender = '$petgender',
                     status = '$petstatus'
                     where petCategory = '$petcategory' and petBreed = '$petbreed' and petName = '$petname'";
            if (mysqli_query($conn, $sql)) {
                $messageBox = "Successfully updated the pet records.";
                mysqli_close($conn);
            } else {
                $errorBox = "Error while updating the pet records: " . mysqli_error($conn);
            }
        } else {
            $errorBox = "Error while updating pet records";
        }
    }

    //DELETE BUTTON
    if (isset($_POST['btnDelete'])) {
        $flag = true;
        //CATEGORY VALIDATION
        $flag = validatePetCategory($_POST['petCategory']);
        //PET NAME VALIDATION
        $flag = validatePetName($_POST['petName']);
        //PET BREED VALIDATION
        $flag = validatePetBreed($_POST['petBreed']);

        if ($flag) {
            $conn = mysqli_connect($server_name, $user_name, $server_password, $db_name);
            checkTable($server_name, $user_name, $server_password, $db_name, $table_name);

            $sql = "delete from $table_name where petCategory = '$petcategory' and petBreed = '$petbreed' and petName = '$petname'";
            if (mysqli_query($conn, $sql)) {
                $messageBox = "Successfully deleted the student record.";
            } else {
                $errorBox = "Error while deleting the student record: " . mysqli_error($conn);
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
        <h2>Configure Pet Info</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label>Enter pet category</label>
            <select id="select_category" name="petCategory">
                <option selected disabled value="">Select a category</option>
                <option value="bird" required>Bird</option>
                <option value="cat" required>Cat</option>
                <option value="dog" required>Dog</option>
            </select>
            <span id="error">*<?php echo $petcategoryErr; ?></span>
            <br />
            <label>Enter pet name</label>
            <input type="text" name="petName" value="<?php if (isset($_POST['petName'])) {
                                                            echo htmlentities($_POST['petName']);
                                                        } ?>" placeholder="Pet name">
            <span id="error">*<?php echo $petnameErr; ?></span>
            <br />
            <label>Enter pet breed</label>
            <input type="text" name="petBreed" value="<?php if (isset($_POST['petBreed'])) {
                                                            echo htmlentities($_POST['petBreed']);
                                                        } ?>" placeholder="Pet breed">
            <span id="error">*<?php echo $petbreedErr; ?></span>
            <br />
            <label>Enter pet age [months]</label>
            <input type="number" name="petAge" min="1" max="100" value="<?php if (isset($_POST['petAge'])) {
                                                                            echo htmlentities($_POST['petAge']);
                                                                        } ?>" pattern="[0-9]{1,3}" title="Enter number only">
            <span id="error">*<?php echo $petageErr; ?></span>
            <br />
            <div id="gender">
                <label>Enter pet gender</label>
                <span id="error">*<?php echo $petgenderErr; ?></span><br />
                <input type="radio" name="petGender" value="male" />
                <label>Male</label><br />
                <input type="radio" name="petGender" value="female" />
                <label>Female</label><br />
            </div>
            <label>Is the pet adopted</label>
            <select id="select_status" name="petStatus">
                <option selected disabled value="">Select a status</option>
                <option value="adopted" required>Adopted</option>
                <option value="unadopted" required>Unadopted</option>
            </select>
            <span id="error">*<?php echo $petstatusErr; ?></span>
            <br /><br />
            <input type="submit" name="btnAdd" value="Add" />
            <input type="submit" name="btnSearch" value="Search" />
            <input type="submit" name="btnEdit" value="Edit Info" />
            <input type="submit" name="btnDelete" value="Delete Record" />
            <input type="reset" value="Reset" />
            <input type="submit" name="btnDash" value="Dashboard" />
        </form>
        <div id="div_result_pets">
            Pet category: <span><?php echo $petcategoryDB; ?></span><br />
            Pet name: <span  ><?php echo $petnameDB; ?></span><br />
            Pet breed: <span  ><?php echo $petbreedDB; ?></span><br />
            Pet age : <span  ><?php echo $petageDB; ?></span><br />
            Pet gender: <span  ><?php echo $petgenderDB; ?></span><br />
            Pet status: <span  ><?php echo $petstatusDB; ?></span><br />
        </div>
    </div>
    <span><?php echo $messageBox; ?></span>
    <span><?php echo $errorBox; ?></span>
</body>
</html>