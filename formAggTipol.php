<?php
include '../config.php';
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="estForm.css">
    <title>Form Aggiungi Dispositivo nel database</title>
</head>
<body>
<?php


if(isset($_GET['result'])){
    if($_GET['result'] =="success" )  {
      echo "Caricato con successo";
    }else{
      echo "Fallito";
    }
}

?>
    <h2>Inserisci la nuova tipologia di dispositivo nel database</h2>
    
    <form action="inserimentoAggTipol.php" method="POST">
        <label for="tipo">Nuova Tipologia:</label>
        <input type="text" id="tipo" name="tipo" maxlength="40" required><br><br>
        <button style="border-radius: 100px; background-color: #ADD8E6; width: 30%; margin-left: 60%; font-size: 20px;" type="submit">Invia</button>
    </form>
    
    <button style="border-radius: 100px; background-color: #ADD8E6; width: 15%; font-size: 14px;"  onclick="window.location.href='formIns.php'">Torna all'insermento dispositivi</button>
    
    <button style="border-radius: 100px; background-color: #ADD8E6; width: 15%; font-size: 14px;"  onclick="window.location.href='visualizzaTipologie.php'">Visualizza le tipologie già presenti</button>
    


</body>
</html>