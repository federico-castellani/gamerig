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
        <title>GameRig</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Sito di vendita di componenti per PC da Gaming">
        <link href="style.css" type="text/css" rel="stylesheet">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    </head>
    <body>
        <header class="header">     
            <form method="GET" action="ricerca.php">
                <a href="index.php"><h1 id="titoloTop" class="titoloTopInvisibile">GameRig</h1></a>
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
        <main class="index">
            <h1 id="titoloBottom">GameRig</h1>
            <div>
                <div>
                    <h2>Consigliati</h2>
                    <div>
                    <?php
                        $sql = "SELECT Prodotto.*, round(avg(Acquisto.stelleRecensione), 1) as media_recensioni 
                                FROM Prodotto 
                                JOIN Acquisto ON Prodotto.idProdotto = Acquisto.idProdotto 
                                GROUP BY Prodotto.idProdotto 
                                ORDER BY media_recensioni DESC 
                                LIMIT 6;";
                    
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                                echo "<div><a href='prodotto.php?idProdotto=".$row["idProdotto"]."'>";
                                echo "<img src='images/".$row["idProdotto"]."_1.jpg' alt='Immagine ".$row["nomeProdotto"]."'>";
                                echo "<p>".$row["nomeProdotto"]."</p>";
                                echo "<p>Valutazione media: ".$row["media_recensioni"]."</p>";
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
                
                </div>
                <div>
                    <h2>Più acquistati</h2>
                    <div>
                    <?php
                        $sql = "SELECT Prodotto.*, count(Acquisto.idProdotto) as acquisti 
                                FROM Prodotto 
                                JOIN Acquisto ON Prodotto.idProdotto = Acquisto.idProdotto 
                                GROUP BY Prodotto.idProdotto 
                                ORDER BY acquisti DESC 
                                LIMIT 6;";
                    
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                                echo "<div><a href='prodotto.php?idProdotto=".$row["idProdotto"]."'>";
                                echo "<img src='images/".$row["idProdotto"]."_1.jpg' alt='Immagine ".$row["nomeProdotto"]."'>";
                                echo "<p>".$row["nomeProdotto"]."</p>";
                                echo "<p>Acquisti: ".$row["acquisti"]."</p>";
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
                </div>
            </div>
            <div id="contOfferte">
                <h2>Offerte del giorno</h2>
                <div>
                    <?php
                        $sql = "SELECT * FROM Offerta JOIN Prodotto ON Offerta.idProdotto = Prodotto.idProdotto
                                WHERE dataInizio <= CURDATE() AND dataFine >= CURDATE();";
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
            </div>
        </main>
        <footer>
            <p>Advertise</p>
            <p>Cookie Policy</p>
            <p>Terms of service</p>
            <p onclick="location.href='maps.html'" id="maps">Dove siamo</p>
        </footer>
        <script src="scripts/index.js"></script>
        <script src="scripts/hamburger.js"></script>
    </body>
</html>
<?php
    mysqli_close($conn);
?>