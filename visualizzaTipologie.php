<?php
// Dati di connessione al database
include '../config.php';
?>

<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="templateVisualizzaDisp.css">
    <title>Form Dispositivo</title>
</head>
<body>
<?php
// Query per selezionare tutti i tipi dalla tabella 'tipologieDispositivi'
$query = "SELECT * FROM tipologieDispositivi";

// Esegui la query
$result = mysqli_query($conn, $query);

// Verifica se la query ha prodotto risultati
if (mysqli_num_rows($result) > 0) {
    // Inizio della tabella HTML
    echo "<table border='1'>
            <tr>
                <th>IDTipologia</th>
                <th>Tipo</th>
                <th>Azioni</th>
            </tr>";

    // Stampa ogni riga della tabella
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>" . $row['IDTipologia'] . "</td>
                <td>" . $row['tipo'] . "</td>
                <td>
                    <button onclick=\"window.location.href='modificaTipologia.php?id=" . $row['IDTipologia'] . "'\">Modifica</button>
                    <button onclick=\"confermaElimina('" . $row['IDTipologia'] . "')\">Elimina</button>
                </td>
              </tr>";
    }

    // Fine della tabella HTML
    echo "</table>";
} else {
    echo "Nessun risultato trovato.";
}

// Chiudi la connessione
mysqli_close($conn);
?>

<button style="border-radius: 100px; background-color: #ADD8E6; width: 30%;" onclick="window.location.href='formAggTipol.php'">Torna ad inserimento nuova tipologia</button>

<script>
// Funzione per chiedere conferma prima di eliminare
function confermaElimina(id) {
    if (confirm('Sei sicuro di voler eliminare questa tipologia?')) {
        window.location.href = 'eliminaTipologia.php?id=' + id;
    }
}
</script>
</body>
</html>