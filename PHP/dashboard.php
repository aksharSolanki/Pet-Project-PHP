<?php
?>
<html>

<head>
    <title>Dashboard</title>
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

        button {
            font-family: 'Poppins', sans-serif;
            font-size: 1em;
            border-radius: 10px;
            background-color: rgba(255, 255, 255, 0.6);
            width: 60%;
        }
        #options {
            background-color: rgba(255, 255, 255, 0.6);
            color: black;
        }
    </style>
</head>

<body>
    <?php
    ?>
    <div id="siteInfo">
    <h1>Pet Finder</h1>
        Get Personalized Pet Matches
        <p>Get Your Pet specializes in all kinds of pets, from the traditional dog and cat to chirpy birds,<br />
            You can filter your pet search and get great recommendations.<br />
            Your are sure to find the loveliest
            and most adorable pet you are looking for.<br />
            You can also receive endless advice about training and grooming.
        </p>
        <div id="options">
            <p>Configure everything about
                <br />the pets on site
            </p>
            <button id="btnPets">About Pets</button>
        </div>
        <div id="options">
            <p>Configure everything about
                <br />the customers
            </p>
            <button id="btnCustomers">About Customers</button>
        </div>
        <div id="options">
            <p>Manage and keep track of
                <br />all the transactions
            </p>
            <button id="btnTransactions">Transactions</button>
        </div>
    </div>

</body>
<script type="text/javascript">
    document.getElementById("btnPets").onclick = function() {
        location.href = "pets.php";
    }
    document.getElementById("btnCustomers").onclick = function() {
        location.href = "customers.php";
    }
    document.getElementById("btnTransactions").onclick = function() {
        location.href = "transaction.php";
    }
</script>

</html>