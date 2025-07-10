<?php
    session_start();
    if(isset($_SESSION['idUtente'])) {
        header("Location: utente.php");
        exit();
    }

    $servername = "localhost";
    $username = "esame";
    $password = "esameWeb25";
    $dbname = "GameRig";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connessione fallita: ".mysqli_connect_error());
    }

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $email = $conn->real_escape_string($email);
        $password = $_POST['password'];
        $password = $conn->real_escape_string($password);
        $sql = "SELECT idUtente FROM Utente WHERE email = '".$email."' AND password = '".$password."'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['idUtente'] = $row['idUtente'];
            header("Location: utente.php");
            exit();
        } else {
            echo "<script>alert('Email o password errati')</script>";
        }
    }  
    mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="it-IT"> 
    <head>
        <title>GameRig: Login</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Sito di vendita di componenti per PC da Gaming">
        <link href="style.css" type="text/css" rel="stylesheet">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    </head>
    <body>
        <header class="header">     
            <form method="GET" action="ricerca.php">
                <a href="index.php"><h1>GameRig</h1></a>
                <input type="text" name="ricerca" placeholder="Cerca" id="cerca" class="ricercaBarraLunga">
                <button type="submit"><i class="material-icons" style="font-size:2.3em;">search</i></button>
                <a href="utente.php" class="icone"><i class="material-icons" style="font-size:2.3em;">person</i></a>
                <a href="carrello.php" class="icone"><i class="material-icons" style="font-size:2.3em;">shopping_cart</i></a>
            </form>
            <a href="javascript:void(0);" id="hamburger">
                <i class="material-icons" style="font-size:1.5em;" id="icona-hamburger">menu</i>
                <p>Menu</p>
            </a>
            <nav>
                <ul>
                    <li><a href="cpu.php">CPU</a></li>
                    <li><a href="gpu.php">SCHEDE VIDEO</a></li>
                    <li><a href="ram.php">RAM</a></li>
                    <li><a href="motherboard.php">SCHEDE MADRI</a></li>
                    <li><a href="case.php">CASE</a></li>
                </ul>
            </nav>
        </header>
        <main class="login">
            <h1>Accedi</h1>
            <form method="POST">
                <input type="text" name="email" placeholder="Email" required>
                <br>
                <input type="password" name="password" placeholder="Password" required>
                <br>
                <button type="submit">Accedi</button>
            </form>
        </main>
        <footer>
            <p>Advertise</p>
            <p>Cookie Policy</p>
            <p>Terms of service</p>
            <p onclick="location.href='maps.html'" id="maps">Dove siamo</p>
        </footer>
        <script src="scripts/hamburger.js"></script>
    </body>
</html>
<?php
    
?>