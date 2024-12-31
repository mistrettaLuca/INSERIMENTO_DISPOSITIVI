<?php
// Dati di connessione al database
include '../config.php';

// Funzione per sanificare i dati in ingresso
function betterInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

function convertiMaiuscolo($stringa) {
    return strtoupper($stringa);
}

$etichetta_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo = $_POST["tipo"];
    
    $err = false;
    if (empty($tipo)) {
        echo "Inserisci un campo tipo.<br>";
        $err = true;
    }
    
    // Correzione della sintassi della query: usa i backtick per il nome della tabella e delle colonne
    $query = "SELECT `tipo` FROM `tipologieDispositivi` WHERE `tipo` = ?";
    
    // Preparazione della query
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $tipo);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Verifica se esiste una corrispondenza
    if ($result->num_rows > 0) {
        echo "Questa tipologia esiste già nel database.<br>";
        $err = true;
    }

    // Sanificazione e conversione in maiuscolo
    $tipo = betterInput($tipo);
    $tipo = convertiMaiuscolo($tipo);
    
    if (!$err) {
        try {
            // Correzione della sintassi della query di inserimento
            $query = "INSERT INTO `tipologieDispositivi` (`IDTipologia`, `tipo`) VALUES (NULL, ?)";
            
            // Preparazione della query di inserimento
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $tipo);
            
            if ($stmt->execute()) {
                // Se la query è riuscita, reindirizza con 'success'
                header("Location: formAggTipol.php?result=success");
            } else {
                // Se c'è stato un errore, reindirizza con 'fail'
                header("Location: formAggTipol.php?result=fail");
            }
            exit();  // Assicurati che lo script termini per evitare ulteriori output
        } catch (Exception $exc) {
            echo "Errore: " . $exc->getMessage();
        }
    }
}
?>