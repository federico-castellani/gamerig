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

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
        unset($_SESSION['idUtente']);
        session_destroy();
        header("Location: login.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="it-IT"> 
    <head>
        <title>GameRig: Utente</title>
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
        <main class="utente">
            <h1>Ciao <?php echo $row['nome']." ".$row['cognome'];?></h1>
            <div>
                <h2>Informazioni personali</h2>
                <p>Email: <?php echo $row['email'];?></p>
                <form method="POST" id="logoutForm">
                    <button type="submit" name="logout">Logout</button>
                </form>
            </div>
            <div>
                <h2>Ordini</h2>
                <div id="ordini">
                <?php
                    $sql = "SELECT * 
                            FROM Acquisto JOIN Prodotto ON Prodotto.idProdotto = Acquisto.idProdotto 
                            WHERE idUtente = ".$_SESSION['idUtente']."
                            ORDER BY Acquisto.data DESC;";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            echo "<div>";
                            echo "<a href='prodotto.php?idProdotto=".$row['idProdotto']."'>";
                            echo "<img src='images/".$row['idProdotto']."_1.jpg' alt='Immagine ".$row['nomeProdotto']."'>";
                            echo "<h2>".$row['nomeProdotto']."</h2></a>";
                            echo "<p>Data acquisto: ".$row['data']."</p>";
                            echo "<p>Indirizzo di spedizione: ".$row['indirizzoSpedizione']."</p>";
                            if($row['stelleRecensione'] != NULL) {
                                echo "<p>Stelle recensione: ".$row['stelleRecensione']."</p>";
                                if($row['descrizioneRecensione'] != NULL) {
                                    echo "<p>Recensione: ".$row['descrizioneRecensione']."</p>";
                                } else {
                                    echo "<p>Recensione: Nessuna descrizione</p>";
                                }
                            } else {
                                echo "<form method='POST' action='recensisci.php'>";
                                echo "<input type='hidden' name='idAcquisto' value='".$row['idAcquisto']."'>";
                                echo "<button type='submit'>Recensisci</button>";
                                echo "</form>";
                            }
                            echo "</div>";
                        }
                    }
                ?>
                </div>
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