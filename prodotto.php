<?php
    session_start();

    $servername = "localhost";
    $username = "esame";
    $password = "esameWeb25";
    $dbname = "GameRig";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connessione fallita: ".mysqli_connect_error());
    }
    $idProdotto;
    if (isset($_GET["idProdotto"])) {
        $idProdotto = $_GET["idProdotto"];  
    } else {
        header("Location: index.php");
        exit();
    }
    $sql = "SELECT * FROM Prodotto WHERE idProdotto = ".$idProdotto.";";
    $result = mysqli_query($conn, $sql);
    $row;
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        header("Location: index.php");
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['aggiungiCarrello'])) {
        if(!isset($_SESSION['idUtente'])) {
            unset($_POST['aggiungiCarrello']);
            header("Location: login.php");
            exit();
        }
        $idProdotto = $_GET['idProdotto'];
        $quantita = $_POST['quantita'];
        if($quantita < 1) {
            unset($_POST['aggiungiCarrello']);
            header("Location: prodotto.php?idProdotto=".$idProdotto);
            exit();
        }
        $quantita = $conn->real_escape_string($quantita);
        $idUtente = $_SESSION['idUtente'];

        $sql = "INSERT INTO Carrello (idUtente, idProdotto, quantita) 
                VALUES ($idUtente, $idProdotto, $quantita)
                ON DUPLICATE KEY UPDATE quantita = quantita + VALUES(quantita)";
        if (mysqli_query($conn, $sql)) {
            header("Location: carrello.php");
        } 
    }
?>

<!DOCTYPE html>
<html lang="it-IT"> 
    <head>
        <title><?php echo "GameRig: ".$row['nomeProdotto'];?></title>
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
        <main class="prodotto">
            <div>
                <div>
                    <img id="imgPrimaria" src="images/<?php echo $idProdotto;?>_1.jpg" alt="<?php echo $row['nomeProdotto'];?>">     
                    <div>
                        <img class="imgSecondaria imgSelezionata" src="images/<?php echo $idProdotto;?>_1.jpg" alt="<?php echo $row['nomeProdotto'];?>"> 
                        <img class="imgSecondaria" src="images/<?php echo $idProdotto;?>_2.jpg" alt="<?php echo $row['nomeProdotto'];?>">
                        <img class="imgSecondaria" src="images/<?php echo $idProdotto;?>_3.jpg" alt="<?php echo $row['nomeProdotto'];?>">
                        <img class="imgSecondaria" src="images/<?php echo $idProdotto;?>_4.jpg" alt="<?php echo $row['nomeProdotto'];?>">
                        <img class="imgSecondaria" src="images/<?php echo $idProdotto;?>_5.jpg" alt="<?php echo $row['nomeProdotto'];?>">
                    </div>
                </div>
                <div id="descrizioneProdotto">
                    <h2><?php echo $row['nomeProdotto'];?></h2>
                    <?php 
                        $recensioni = "SELECT coalesce(round(avg(Acquisto.stelleRecensione), 1), 0) as media_recensioni, count(Acquisto.stelleRecensione) as numero_recensioni 
                        FROM Prodotto 
                        JOIN Acquisto ON Prodotto.idProdotto = Acquisto.idProdotto 
                        WHERE Prodotto.idProdotto = ".$idProdotto."
                        GROUP BY Prodotto.idProdotto";
                        $result = mysqli_query($conn, $recensioni);
                        $recensioni;
                        if (mysqli_num_rows($result) > 0) {
                            $recensioni = mysqli_fetch_assoc($result);
                        }
                        echo "<p>Stelle: " .$recensioni['media_recensioni']. "(" .$recensioni['numero_recensioni']. ")</p>";
                    
                        $sconto = "SELECT sconto 
                                FROM Offerta 
                                WHERE idProdotto = ".$idProdotto." AND dataInizio <= CURDATE() AND dataFine >= CURDATE()";
                        $risSconto = mysqli_query($conn, $sconto);
                        
                        if (mysqli_num_rows($risSconto) > 0) {
                            $sconto = mysqli_fetch_assoc($risSconto);
                            $prezzoScontato = $row['prezzo'] - ($row['prezzo'] * $sconto['sconto'] / 100);
                            echo "<p>Prezzo: <del>".$row['prezzo']."€</del> ".round($prezzoScontato, 2)."€</p>";
                            echo "<p>Sconto: ".$sconto['sconto']."%</p>";
                        } else {
                            echo "<p>Prezzo: " .$row['prezzo']. "€</p>";
                        }
                    ?>
                    <form method="POST" id="aggiungiCarrello">
                        <input type="hidden" name="aggiungiCarrello">
                        <a id="rimuovi"><i class="material-icons" style="font-size:2.3em;">remove</i></a>
                        <input type="number" name="quantita" id="quantita" min="1" value="1">
                        <a id="aggiungi"><i class="material-icons" style="font-size:2.3em;">add</i></a>
                    </form>
                    <button id="bottoneCarrello">Aggiungi al carrello</button>
                </div>
            </div>

            <h2>Descrizione</h2>
            <p><?php echo $row['descrizione'];?></p>

            <h2>Recensioni</h2>
            <div id="recensioni">
            <?php
                $recensioniSql = "SELECT stelleRecensione, descrizioneRecensione 
                        FROM Acquisto 
                        WHERE idProdotto = ".$idProdotto." AND stelleRecensione IS NOT NULL;";
                $recensioniResult = mysqli_query($conn, $recensioniSql);
                if (mysqli_num_rows($recensioniResult) > 0) {
                    while($recensione = mysqli_fetch_assoc($recensioniResult)) {
                        echo "<div>";
                        echo "<p>Stelle: ".$recensione['stelleRecensione']."</p>";
                        if ($recensione['descrizioneRecensione'] != NULL) {
                            echo "<p>".$recensione['descrizioneRecensione']."</p>";
                        } else {
                            echo "<p>Recensione senza descrizione</p>";
                        }
                        echo "</div>";
                    }
                } else {
                    echo "<p>Non ci sono recensioni</p>";
                }         
            ?>
            </div>

            <h2>Prodotti simili</h2>
            <div id="prodottiSimili">
            <?php
                $sql = "SELECT * FROM Prodotto WHERE idProdotto != ".$idProdotto." AND tipo = '".$row['tipo']."' LIMIT 4;";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<div><a href='prodotto.php?idProdotto=".$row["idProdotto"]."'>";
                        echo "<img src='images/".$row["idProdotto"]."_1.jpg' alt='Immagine ".$row["nomeProdotto"]."'>";
                        echo "<p>".$row["nomeProdotto"]."</p>";
                        $sconto = "SELECT sconto 
                                   FROM Offerta 
                                   WHERE idProdotto = ".$row['idProdotto']." AND dataInizio <= CURDATE() AND dataFine >= CURDATE()";
                        $risSconto = mysqli_query($conn, $sconto);
                        
                        if (mysqli_num_rows($risSconto) > 0) {
                            $sconto = mysqli_fetch_assoc($risSconto);
                            $prezzoScontato = $row['prezzo'] - ($row['prezzo'] * $sconto['sconto'] / 100);
                            echo "<p>Prezzo: <del>".$row['prezzo']."€</del> ".round($prezzoScontato, 2)."€</p>";
                            echo "<p>Sconto: ".$sconto['sconto']."%</p>";
                        } else {
                            echo "<p>Prezzo: " .$row['prezzo']. "€</p>";
                        }
                        echo "</a></div>";
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
        <script src="scripts/prodotto.js"></script>
        <script src="scripts/hamburger.js"></script>
    </body>
</html>
<?php
    mysqli_close($conn);
?>