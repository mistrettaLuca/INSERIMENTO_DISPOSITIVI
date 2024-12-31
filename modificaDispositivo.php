<?php
include '../config.php';

// Controlla se l'ID del dispositivo è stato passato tramite URL
if (isset($_GET['id'])) {
    $idDispositivo = $_GET['id'];

    // Recupera i dati del dispositivo dal database
    $query = "SELECT * FROM dispositivi WHERE IDDispositivo = $idDispositivo";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $device = mysqli_fetch_assoc($result);
    } else {
        echo "Dispositivo non trovato.";
        exit;
    }
} else {
    echo "ID dispositivo non fornito.";
    exit;
}

// Recupera le tipologie dal database per il menu a tendina
$tipologieQuery = "SELECT * FROM tipologieDispositivi";
$tipologieResult = mysqli_query($conn, $tipologieQuery);

// Recupera gli ambienti dal database per il menu a tendina
$ambientiQuery = "SELECT * FROM ambienti";
$ambientiResult = mysqli_query($conn, $ambientiQuery);

// Controlla se il modulo è stato inviato per aggiornare i dati
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $modello = mysqli_real_escape_string($conn, $_POST['modello']);
    $marca = mysqli_real_escape_string($conn, $_POST['marca']);
    $numeroSerie = mysqli_real_escape_string($conn, $_POST['numeroSerie']);
    $dataAcquisto = mysqli_real_escape_string($conn, $_POST['dataAcquisto']);
    $siglaInventario = mysqli_real_escape_string($conn, $_POST['siglaInventario']);
    $descrizione = mysqli_real_escape_string($conn, $_POST['descrizione']);
    $garanzia = mysqli_real_escape_string($conn, $_POST['garanzia']);
    $etichetta = mysqli_real_escape_string($conn, $_POST['etichetta']);
    $idTipologia = mysqli_real_escape_string($conn, $_POST['idTipologia']);
    $idAmbiente = mysqli_real_escape_string($conn, $_POST['idAmbiente']);

    // Aggiorna i dati nel database
    $updateQuery = "UPDATE dispositivi SET modello='$modello', marca='$marca', numeroSerie='$numeroSerie', dataAcquisto='$dataAcquisto', siglaInventario='$siglaInventario', descrizioneDispositivo='$descrizione', garanziaDispositivo='$garanzia', etichetta='$etichetta', idTipologia='$idTipologia', idAmbiente='$idAmbiente' WHERE IDDispositivo=$idDispositivo";
    
    if (mysqli_query($conn, $updateQuery)) {
        echo "Dispositivo aggiornato con successo.";
    } else {
        echo "Errore nell'aggiornamento del dispositivo: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="estForm.css">
    <title>Modifica Dispositivo</title>
</head>
<body>

<h2>Modifica Dispositivo</h2>

<form method="POST">
    <label for="modello">Modello:</label><br>
    <input type="text" name="modello" value="<?php echo $device['modello']; ?>"><br>

    <label for="marca">Marca:</label><br>
    <input type="text" name="marca" value="<?php echo $device['marca']; ?>"><br>

    <label for="numeroSerie">Numero di Serie:</label><br>
    <input type="text" name="numeroSerie" value="<?php echo $device['numeroSerie']; ?>"><br>

    <label for="dataAcquisto">Data di Acquisto:</label><br>
    <input type="date" name="dataAcquisto" value="<?php echo $device['dataAcquisto']; ?>"><br>

    <label for="siglaInventario">Sigla Inventario:</label><br>
    <input type="text" name="siglaInventario" value="<?php echo $device['siglaInventario']; ?>"><br>

    <label for="descrizione">Descrizione:</label><br>
    <textarea name="descrizione"><?php echo $device['descrizioneDispositivo']; ?></textarea><br>

    <label for="garanzia">Garanzia (in mesi):</label><br>
    <input type="number" name="garanzia" value="<?php echo $device['garanziaDispositivo']; ?>"><br>

    <label for="etichetta">Etichetta:</label><br>
    <input type="text" name="etichetta" value="<?php echo $device['etichetta']; ?>"><br>

    <label for="idTipologia">Tipologia:</label><br>
<select name="idTipologia">
    <?php 
    while ($tipologia = mysqli_fetch_assoc($tipologieResult)) { ?>
        <option value="<?php echo $tipologia['IDTipologia']; ?>" 
            <?php echo ($device['idTipologia'] == $tipologia['IDTipologia']) ? 'selected' : ''; ?>>
            <?php echo $tipologia['tipo']; ?>
        </option>
    <?php } ?>
</select><br>


    <label for="idAmbiente">Ambiente:</label><br>
    <select name="idAmbiente">
        <?php while ($ambiente = mysqli_fetch_assoc($ambientiResult)) { ?>
            <option value="<?php echo $ambiente['IDAmbiente']; ?>" <?php echo ($device['idAmbiente'] == $ambiente['IDAmbiente']) ? 'selected' : ''; ?>>
                <?php echo $ambiente['nome']; ?>
            </option>
        <?php } ?>
    </select><br>
    <input style="border-radius: 100px; background-color: #ADD8E6; width: 30%; margin-left: 60%; font-size: 20px;" type="submit" value="Aggiorna">
    
</form>

<button style="border-radius: 100px; background-color: #ADD8E6; width: 30%;" onclick="window.location.href='visualizzaDisp.php'">Torna a visualizza dispositivi</button>

</body>
</html>