<?php
    $servername = "localhost";
    $username = "esame";
    $password = "esameWeb25";
    $dbname = "GameRig";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connessione fallita: ".mysqli_connect_error());
    }
?>
<!DOCTYPE html>
<html lang="it-IT"> 
    <head>
        <title>GameRig: Schede madri<?php echo $ricerca;?></title>
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
        <main class="motherboard">
            <i class="material-icons" style="font-size:3em;" id="indietro">arrow_circle_left</i>
            <div>
                <img src="images/moba1.png" alt="Immagine di una Motherboard" id="mobaImg">
            </div>
            <i class="material-icons" style="font-size:3em;" id="avanti">arrow_circle_right</i>
            <h1>Schede madri</h1>
            <h2>Cosa Considerare:</h2>
            <ul>
                <li><span>Socket e Chipset:</span>
                <br>
                Il socket deve essere compatibile con la CPU scelta (es. LGA per Intel, AM per AMD).
                Il chipset determina funzionalità come overclocking, numero di porte e supporto alla memoria.
                </li>

                <li><span>Fattore di Forma:</span>
                <br>
                ATX (full-size) per espandibilità, micro-ATX e mini-ITX per configurazioni compatte.
                </li>

                <li><span>Slot di Espansione:</span>
                <br>
                Controlla il numero di slot PCIe disponibili per GPU, SSD NVMe e altre schede di espansione.
                </li>

                <li><span>Supporto alla RAM:</span>
                <br>
                Frequenza massima supportata e numero di slot disponibili per future espansioni.
                </li>

                <li><span>Connettività:</span>
                <br>
                Assicurati di avere le porte necessarie come USB-C, Wi-Fi integrato, e porte M.2 per SSD NVMe.
                </li>

                <li><span>Funzioni Extra:</span>
                <br>
                Considera BIOS avanzati, dissipatori per VRM, e il supporto per configurazioni multi-GPU.
                </li>
            </ul>

            <div id="proposte">
                <div>   
                    <h2>Scheda madre più acquistata</h2> 
                    <?php
                        $sql = "SELECT Prodotto.*, COUNT(Acquisto.idProdotto) as acquisti 
                                FROM Prodotto 
                                JOIN Acquisto ON Prodotto.idProdotto = Acquisto.idProdotto 
                                WHERE Prodotto.tipo = 'moba' 
                                GROUP BY Prodotto.idProdotto 
                                ORDER BY acquisti DESC 
                                LIMIT 1;";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                            echo "<div><a href='prodotto.php?idProdotto=".$row["idProdotto"]."'>";
                            echo "<img src='images/".$row["idProdotto"]."_1.jpg' alt='Immagine ".$row["nomeProdotto"]."'>";
                            echo "<p>".$row["nomeProdotto"]."</p>";
                            echo "<p>Acquisti: ".$row["acquisti"]."</p>";
                            $sconto = "SELECT sconto FROM Offerta WHERE idProdotto = ".$row["idProdotto"]." AND dataInizio <= CURDATE() AND dataFine >= CURDATE();";
                            $sconto = mysqli_query($conn, $sconto);
                            if(mysqli_num_rows($sconto) > 0) {
                                $sconto = mysqli_fetch_assoc($sconto);
                                echo "<p style='text-decoration:line-through;display:inline-block'>".$row["prezzo"]."€ </p>";
                                echo "<p style='display:inline-block'>Sconto: ".$sconto["sconto"]."%</p>";
                                echo "<p>".($row["prezzo"] - ($row["prezzo"] * $sconto["sconto"] / 100))."€</p>";
                            } else {
                                echo "<p>".$row["prezzo"]."€</p>";
                            }
                            echo "</a></div>";
                        }
                    ?>
                </div>
            
                <div>
                    <h2>Scheda madre preferita dai nostri utenti</h2>
                    <?php
                        $sql = "SELECT Prodotto.*, round(avg(Acquisto.stelleRecensione), 1) as media_recensioni 
                                FROM Prodotto 
                                JOIN Acquisto ON Prodotto.idProdotto = Acquisto.idProdotto 
                                WHERE Prodotto.tipo = 'moba' 
                                GROUP BY Prodotto.idProdotto 
                                ORDER BY media_recensioni DESC 
                                LIMIT 1;";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                            echo "<div><a href='prodotto.php?idProdotto=".$row["idProdotto"]."'>";
                            echo "<img src='images/".$row["idProdotto"]."_1.jpg' alt='Immagine ".$row["nomeProdotto"]."'>";
                            echo "<p>".$row["nomeProdotto"]."</p>";
                            echo "<p>Valutazione media: ".$row["media_recensioni"]."</p>";
                            $sconto = "SELECT sconto FROM Offerta WHERE idProdotto = ".$row["idProdotto"]." AND dataInizio <= CURDATE() AND dataFine >= CURDATE();";
                            $sconto = mysqli_query($conn, $sconto);
                            if(mysqli_num_rows($sconto) > 0) {
                                $sconto = mysqli_fetch_assoc($sconto);
                                echo "<p style='text-decoration:line-through;display:inline-block'>".$row["prezzo"]."€ </p>";
                                echo "<p style='display:inline-block'>Sconto: ".$sconto["sconto"]."%</p>";
                                echo "<p>".($row["prezzo"] - ($row["prezzo"] * $sconto["sconto"] / 100))."€</p>";
                            } else {
                                echo "<p>".$row["prezzo"]."€</p>";
                            }
                            echo "</a></div>";
                        }
                    ?>
                </div>
            </div>
            <h2>Schede madri in sconto</h2>
            <div id="sconto">
                <?php
                    $sql = "SELECT * FROM Offerta JOIN Prodotto ON Offerta.idProdotto = Prodotto.idProdotto
                            WHERE dataInizio <= CURDATE() AND dataFine >= CURDATE() AND Prodotto.tipo = 'moba';";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            echo "<div><a href='prodotto.php?idProdotto=".$row["idProdotto"]."'>";
                            echo "<img src='images/".$row["idProdotto"]."_1.jpg' alt='Immagine ".$row["nomeProdotto"]."'>";
                            echo "<p>".$row["nomeProdotto"]."</p>";
                            $prezzoScontato = $row['prezzo'] - ($row['prezzo'] * $row['sconto'] / 100);
                            echo "<p>Prezzo: <del>".$row['prezzo']."€</del> ".round($prezzoScontato, 2)."€</p>";
                            echo "<p>Sconto: ".$row['sconto']."%</p>";
                            echo "</a></div>";
                        }
                    } else {
                        echo "<p>Non ci sono Schede madri in sconto</p>";
                    }   
                ?>
            </div>
            <h2>Tutte le nostre Schede madri</h2>
            <div id="motherboard">      
                <?php
                    $sql = "SELECT * FROM Prodotto WHERE tipo = 'moba';";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            echo "<div><a href='prodotto.php?idProdotto=".$row["idProdotto"]."'>";
                            echo "<img src='images/".$row["idProdotto"]."_1.jpg' alt='Immagine ".$row["nomeProdotto"]."'>";
                            echo "<p>".$row["nomeProdotto"]."</p>";
                            $sconto = "SELECT sconto FROM Offerta WHERE idProdotto = ".$row["idProdotto"]." AND dataInizio <= CURDATE() AND dataFine >= CURDATE();";
                            $sconto = mysqli_query($conn, $sconto);
                            if(mysqli_num_rows($sconto) > 0) {
                                $sconto = mysqli_fetch_assoc($sconto);
                                echo "<p style='text-decoration:line-through;display:inline-block'>".$row["prezzo"]."€ </p>";
                                echo "<p style='display:inline-block'>Sconto: ".$sconto["sconto"]."%</p>";
                                echo "<p>".($row["prezzo"] - ($row["prezzo"] * $sconto["sconto"] / 100))."€</p>";
                            } else {
                                echo "<p>".$row["prezzo"]."€</p>";
                            }
                            echo "</a></div>";
                        }
                    }  else {
                        echo "<p>Non ci sono Schede madri in sconto</p>";
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
        <script src="scripts/moba.js"></script>
    </body>
</html>
<?php
    mysqli_close($conn);
?>