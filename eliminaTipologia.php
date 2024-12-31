<?php
include '../config.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Query per eliminare la riga
    $query = "DELETE FROM tipologieDispositivi WHERE IDTipologia = $id";

    if (mysqli_query($conn, $query)) {
        header('Location: visualizzaTipologie.php');
    } else {
        echo "Errore durante l'eliminazione: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>