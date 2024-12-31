<?php
include '../config.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Recupera i dati della tipologia da modificare
    $query = "SELECT * FROM tipologieDispositivi WHERE IDTipologia = $id";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        ?>
        <form action="modificaTipologia.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $row['IDTipologia']; ?>">
            <label for="tipo">Tipo:</label>
            <input type="text" id="tipo" name="tipo" value="<?php echo $row['tipo']; ?>" required>
            <button type="submit">Salva modifiche</button>
        </form>
        <?php
    } else {
        echo "Tipologia non trovata.";
    }

    mysqli_close($conn);
} elseif (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $tipo = mysqli_real_escape_string($conn, $_POST['tipo']);

    // Query per aggiornare la tipologia
    $query = "UPDATE tipologieDispositivi SET tipo = '$tipo' WHERE IDTipologia = $id";

    if (mysqli_query($conn, $query)) {
        header('Location: visualizzaTipologie.php');
    } else {
        echo "Errore durante la modifica: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>