<html>

<head>
    <title>Home</title>
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
        button {
            background-color: rgba(255,255,255,0.6);   
            padding: 15px;
            font-family: 'Poppins', sans-serif;
            border-radius: 10px;
            font-size: 1.2em;
            width: 30%;
        }   
    </style>
</head>

<body>
    <div id="siteInfo">
        <h1>Pet Finder</h1>
        <h4 id="greetUser"></h4>

        Get Personalized Pet Matches
        <p>Get Your Pet specializes in all kinds of pets, from the traditional dog and cat to chirpy birds,<br />
            You can filter your pet search and get great recommendations.<br />
            Your are sure to find the loveliest
            and most adorable pet you are looking for.<br />
            You can also receive endless advice about training and grooming.
        </p>
        <div>
            <button id="btnLogin">Admin Login</button>
            <button id="btnSignUp">Admin Signup</button>
        </div>
    </div>
</body>
<script type="text/javascript">
    document.getElementById("btnLogin").onclick = function() {
        location.href = "Login.php";
    }
    document.getElementById("btnSignUp").onclick = function() {
        location.href = "adminSignUp.php";
    }
</script>

</html>