<?php
    session_start();
    if(!isset($_SESSION['idUtente'])) {
        header("Location: login.php");
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

    $sql = "SELECT * FROM Utente WHERE idUtente = ".$_SESSION['idUtente'].";";
    $result = mysqli_query($conn, $sql);
    $row;
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        unset($_SESSION['idUtente']);
        session_destroy();
        header("Location: login.php");
        exit();
    }  

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acquista'])) {  
        $indirizzo = $_POST['indirizzo'];
        $indirizzo = $conn->real_escape_string($indirizzo);
        $citta = $_POST['citta'];
        $citta = $conn->real_escape_string($citta);
        $indirizzoSpedizione = $indirizzo.", ".$citta;
        $data = date('Y-m-d H:i:s');

        $sqlProdottiCarrello = "SELECT Prodotto.*, Carrello.quantita
                                FROM Prodotto 
                                JOIN Carrello ON Prodotto.idProdotto = Carrello.idProdotto 
                                WHERE Carrello.idUtente = ".$_SESSION['idUtente'].";";
        $resultCarrello = mysqli_query($conn, $sqlProdottiCarrello);
        if (mysqli_num_rows($resultCarrello) > 0) {
            while($prodotto = mysqli_fetch_assoc($resultCarrello)) {
                for ($i = 0; $i < $prodotto['quantita']; $i++) {
                    $sqlAcquisto = "INSERT INTO Acquisto (idUtente, idProdotto, data, indirizzoSpedizione) 
                                    VALUES (".$_SESSION['idUtente'].", ".$prodotto['idProdotto'].", '" .$data. "', '" .$indirizzoSpedizione. "');";
                    if (mysqli_query($conn, $sqlAcquisto)) {
                        $sqlTogliElemento = "UPDATE Carrello SET quantita = quantita - 1 WHERE idUtente = ".$_SESSION['idUtente']." AND idProdotto = ".$prodotto['idProdotto'].";";
                        mysqli_query($conn, $sqlTogliElemento);  
                    } 
                }
                $sqlTogliProdottoCarrello = "DELETE FROM Carrello WHERE idUtente = ".$_SESSION['idUtente']." AND idProdotto = ".$prodotto['idProdotto']." AND quantita = 0;";
                mysqli_query($conn, $sqlTogliProdottoCarrello);
            }
        }
        unset($_POST['acquista']);
        header("Location: utente.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="it-IT"> 
    <head>
        <title>GameRig: Acquisto</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Sito di vendita di componenti per PC da Gaming">
        <link href="style.css" type="text/css" rel="stylesheet">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    </head>
    <body>
        <header class="header">     
            <form method="GET"  action="ricerca.php">
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
        <main class="acquisto">
            <h1>Acquisto</h1>
            <form method="POST">
                <input type="text" name="indirizzo" id="indirizzo" placeholder="Indirizzo" required><br>
                <input type="text" name="citta" id="citta" placeholder="Città" required><br>
                <button type="submit" name="acquista">Acquista</button>
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
    mysqli_close($conn);
?>