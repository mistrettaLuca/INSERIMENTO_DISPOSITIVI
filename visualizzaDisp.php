<?php
include '../config.php';
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="templateVisualizzaDisp.css">
    <title>Form Dispositivo</title>
    <style>
        /* Stile per la colonna descrizione */
        .descrizione-cell {
            max-width: 200px; /* Larghezza massima della cella */
            overflow-x: auto; /* Abilita lo scorrimento orizzontale */
            white-space: nowrap; /* Impedisce il testo di andare a capo */
        }
    </style>
</head>
<body>
<?php
// Connessione al database
$query = "SELECT dispositivi.*, tipologieDispositivi.tipo, ambienti.nome AS nomeAmbiente
          FROM dispositivi
          INNER JOIN tipologieDispositivi ON dispositivi.idTipologia = tipologieDispositivi.IDTipologia
          INNER JOIN ambienti ON dispositivi.idAmbiente = ambienti.IDAmbiente";

$result = mysqli_query($conn, $query);

// Iniziamo a stampare i dati in un formato più leggibile
echo "<table border='1'>";
echo "<tr><th>Tipologia</th><th>Modello</th><th>Marca</th><th>Numero di Serie</th><th>Data di Acquisto</th><th>Sigla Inventario</th><th>Descrizione</th><th>Garanzia(in mesi)</th><th>Etichetta</th><th>Ambiente</th><th>Azioni</th></tr>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row['tipo'] . "</td>";
    echo "<td>" . $row['modello'] . "</td>";
    echo "<td>" . $row['marca'] . "</td>";
    echo "<td>" . $row['numeroSerie'] . "</td>";
    echo "<td>" . $row['dataAcquisto'] . "</td>";
    echo "<td>" . $row['siglaInventario'] . "</td>";
    // Cella descrizione con scorrimento laterale
    echo "<td class='descrizione-cell'>" . htmlspecialchars($row['descrizioneDispositivo']) . "</td>";
    echo "<td>" . $row['garanziaDispositivo'] . "</td>";
    echo "<td>" . $row['etichetta'] . "</td>";
    echo "<td>" . $row['nomeAmbiente'] . "</td>";

    // Aggiungere i pulsanti Modifica ed Elimina
    echo "<td>
            <a href='modificaDispositivo.php?id=" . $row['IDDispositivo'] . "'>Modifica</a> | 
            <a href='eliminaDispositivo.php?id=" . $row['IDDispositivo'] . "' onclick='return confirm(\"Sei sicuro di voler eliminare questo dispositivo?\")'>Elimina</a>
          </td>";

    echo "</tr>";
}
echo "</table>";
?>

<button style="border-radius: 100px; background-color: #ADD8E6; width: 30%;" onclick="window.location.href='formIns.php'">Torna ad inserimento dispositivo</button>
</body>
</html>