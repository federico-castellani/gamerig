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

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rimuovi'])) {
        $idProdotto = $_POST['idProdotto'];
        $idUtente = $_POST['idUtente'];
        $sqlQuantita = "SELECT quantita FROM Carrello WHERE idUtente = ".$idUtente." AND idProdotto = ".$idProdotto.";";
        $resultQuantita = mysqli_query($conn, $sqlQuantita);
        if (mysqli_num_rows($resultQuantita) > 0) {
            $quantita = mysqli_fetch_assoc($resultQuantita)['quantita'];
            if ($quantita > 1) {
                $sqlRimuovi = "UPDATE Carrello SET quantita = quantita - 1 WHERE idUtente = ".$idUtente." AND idProdotto = ".$idProdotto.";";
            } else {
                $sqlRimuovi = "DELETE FROM Carrello WHERE idUtente = ".$idUtente." AND idProdotto = ".$idProdotto.";";
            }
            if(mysqli_query($conn, $sqlRimuovi)) {
                unset($_POST['rimuovi']);
            }
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['aggiungi'])) {
        $idProdotto = $_POST['idProdotto'];
        $idUtente = $_POST['idUtente'];
        $sqlAggiungi = "UPDATE Carrello SET quantita = quantita + 1 WHERE idUtente = ".$idUtente." AND idProdotto = ".$idProdotto.";";
        if(mysqli_query($conn, $sqlAggiungi)) {
            unset($_POST['aggiungi']);
        }
    }
?>
<!DOCTYPE html>
<html lang="it-IT"> 
    <head>
        <title>GameRig: Carrello</title>
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
        <main class="carrello">
            <div>
                <h1>Carrello di <?php echo $row['nome']." ".$row['cognome'];?></h1>
                <div>
                <?php
                    $sqlProdottiCarrello = "SELECT Prodotto.*, Carrello.quantita
                                            FROM Prodotto 
                                            JOIN Carrello ON Prodotto.idProdotto = Carrello.idProdotto 
                                            WHERE Carrello.idUtente = ".$_SESSION['idUtente'].";";
                    $resultCarrello = mysqli_query($conn, $sqlProdottiCarrello);
                    if (mysqli_num_rows($resultCarrello) > 0) {
                        $totale = 0;
                        while($prodotto = mysqli_fetch_assoc($resultCarrello)) {
                            $sqlSconto = "SELECT sconto 
                                        FROM Offerta 
                                        WHERE idProdotto = ".$prodotto["idProdotto"]." AND dataInizio <= CURDATE() AND dataFine >= CURDATE();";
                            $sconto = mysqli_query($conn, $sqlSconto);
                            if(mysqli_num_rows($sconto) > 0) {
                                $sconto = mysqli_fetch_assoc($sconto);
                                $totale += ($prodotto["prezzo"] - ($prodotto["prezzo"] * $sconto["sconto"] / 100)) * $prodotto["quantita"];
                            } else {
                                $totale += ($prodotto["prezzo"] * $prodotto["quantita"]);
                            }
                            
                        }
                        echo "<h2>Totale: ".round($totale, 2)."€</h2>";
                    }
                ?>
                <form method="POST" action="acquisto.php">
                    <button type="submit">Acquista</button>
                </form>
                
                </div>
            </div>
            <div id="prodotti">
                <?php
                    $sqlProdottiCarrello = "SELECT Prodotto.*, Carrello.quantita
                                            FROM Prodotto 
                                            JOIN Carrello ON Prodotto.idProdotto = Carrello.idProdotto 
                                            WHERE Carrello.idUtente = ".$_SESSION['idUtente'].";";
                    $resultCarrello = mysqli_query($conn, $sqlProdottiCarrello);
                    if (mysqli_num_rows($resultCarrello) > 0) {     
                        while($prodotto = mysqli_fetch_assoc($resultCarrello)) {
                            $sconto = "SELECT sconto FROM Offerta WHERE idProdotto = ".$prodotto["idProdotto"]." AND dataInizio <= CURDATE() AND dataFine >= CURDATE();";
                            $sconto = mysqli_query($conn, $sconto);
                            
                            echo "<div><a href='prodotto.php?idProdotto=".$prodotto["idProdotto"]."'>";
                            echo "<img src='images/".$prodotto["idProdotto"]."_1.jpg' alt='Immagine ".$prodotto["nomeProdotto"]."'>";
                            echo "<h2>".$prodotto["nomeProdotto"]."</h2></a>";
                            if(mysqli_num_rows($sconto) > 0) {
                                $sconto = mysqli_fetch_assoc($sconto);
                                echo "<p style='text-decoration:line-through;display:inline-block'>".$prodotto["prezzo"]."€ </p>";
                                echo "<p style='display:inline-block'>Sconto: ".$sconto["sconto"]."%</p>";
                                echo "<p>".round(($prodotto["prezzo"] - ($prodotto["prezzo"] * $sconto["sconto"] / 100)), 2)."€</p>";
                            } else {
                                echo "<p>".$prodotto["prezzo"]."€</p>";
                            }
                            echo "<p>Quantità: ".$prodotto["quantita"]."</p>";
                            echo "<div>";
                            echo "<form method='POST'>";
                            echo "<input type='hidden' name='idProdotto' value='".$prodotto['idProdotto']."'>";
                            echo "<input type='hidden' name='idUtente' value='".$row['idUtente']."'>";
                            echo "<button type='submit' name='rimuovi'><i class='material-icons' style='font-size:1em;'>remove</i></button>";
                            echo "</form>";
                            echo "<form method='POST'>";
                            echo "<input type='hidden' name='idProdotto' value='".$prodotto['idProdotto']."'>";
                            echo "<input type='hidden' name='idUtente' value='".$row['idUtente']."'>";
                            echo "<button type='submit' name='aggiungi'><i class='material-icons' style='font-size:1em;'>add</i></button>";
                            echo "</form>";
                            echo "</div>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>Il carrello è vuoto</p>";
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