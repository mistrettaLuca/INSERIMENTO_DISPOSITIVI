<?php

// Credenziali per la connessione al database
include '../config.php';


//Rimuove spazi extra all'inizio e alla fine della stringa.
//Elimina evenutali / e \
//Codifica i caratteri speciali in modo che non possano essere interpretati come HTML o JavaScript.
function betterInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}
function convertiMaiuscolo($stringa) {
    return strtoupper($stringa);
}
function tronca($descrizione) {
    // Controlla e trunca la stringa se supera 499 caratteri
    if (strlen($descrizione) > 499) {
        return substr($descrizione, 0, 499);
    }
    return $descrizione;
}

$etichetta_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipologia = $_POST["tipologia"];
    $modello = $_POST["modello"];
    $marca = $_POST["marca"];
    $numeroSerie = $_POST["numeroSerie"];
    $dataAcquisto = $_POST["dataAcquisto"];
    $siglaInventario = $_POST["siglaInventario"];
    $descrizioneDispositivo = $_POST["descrizioneDispositivo"];
    $garanziaDispositivo = $_POST["garanziaDispositivo"];
    $etichetta = $_POST["etichetta"];
    $ambiente = $_POST["ambiente"];

    $err=false;
    // Validazione dei campi del form
    if (empty($_POST["modello"])) {
        echo "Il campo 'Modello' è obbligatorio.<br>";
        $err=true;
    } else {
        $modello = betterInput($_POST["modello"]);
    }
    $modello = convertiMaiuscolo($_POST["modello"]);

    if (empty($_POST["marca"])) {
        echo "Il campo 'Marca' è obbligatorio.<br>";
        $err=true;
    } else {
        $marca = betterInput($_POST["marca"]);
    }
    $marca = convertiMaiuscolo($_POST["marca"]);

    $query = "SELECT numeroSerie FROM dispositivi WHERE numeroSerie = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $numeroSerie);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Verifica se esiste una corrispondenza
    if ($result->num_rows > 0) {
        echo "Questo numero di serie esiste già nel database.<br>";
        $err=true;
    }
    
    $numeroSerie = betterInput($_POST["numeroSerie"]);
    $numeroSerie = convertiMaiuscolo($_POST["numeroSerie"]);

    if (empty($_POST["dataAcquisto"])) {
        echo "La data di acquisto è un campo obbligatorio.<br>";
        $err=true;
    } else {
        $dataAcquisto = betterInput($_POST["dataAcquisto"]);
    }

    $query = "SELECT siglaInventario FROM dispositivi WHERE siglaInventario = ?";
    
    // Preparazione della query per evitare SQL injection
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $siglaInventario);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Verifica se esiste una corrispondenza
    if ($result->num_rows > 0) {
        echo "Questa sigla inventario esiste già nel database.<br>";
        $err=true;
    }
    $siglaInventario = betterInput($_POST["siglaInventario"]);
    $siglaInventario = convertiMaiuscolo($_POST["siglaInventario"]);
    
    $descrizioneDispositivo = tronca($descrizioneDispositivo);

    if (empty($_POST["garanziaDispositivo"]) || !is_numeric($_POST["garanziaDispositivo"]) || $_POST["garanziaDispositivo"] <= 0) {
        echo "La durata della garanzia deve essere un numero positivo.<br>";
        $err=true;
    } else {
        $garanziaDispositivo = betterInput($_POST["garanziaDispositivo"]);
    }
    $etichetta = convertiMaiuscolo($_POST["etichetta"]);

    // Validazione del file (etichetta)
    try{
        if(!$err){
            $query = "INSERT INTO `dispositivi`(`idTipologia`, `modello`, `marca`, `numeroSerie`, `dataAcquisto`, `siglaInventario`, `descrizioneDispositivo`, `garanziaDispositivo`, `etichetta`, `idAmbiente`) 
                      VALUES ('$tipologia', '$modello', '$marca', '$numeroSerie', '$dataAcquisto', '$siglaInventario', '$descrizioneDispositivo', '$garanziaDispositivo', '$etichetta', '$ambiente')";
            
            if ($conn->query($query) === TRUE) {
                // Se la query è riuscita, reindirizza con 'success'
                header("Location: formIns.php?result=success");
            } else {
                // Se c'è stato un errore, reindirizza con 'fail'
                header("Location: formIns.php?result=fail");
            }
            exit();  // Assicurati che lo script termini per evitare ulteriori output
        }
    }catch(Exception $exc){
        echo $exc;
    }
}

?>