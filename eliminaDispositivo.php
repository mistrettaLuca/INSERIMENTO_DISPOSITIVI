<?php
include '../config.php';  // Connessione al database

// Verifica se l'ID è passato tramite la URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Verifica se la connessione è attiva
    if ($conn) {
        // Inizia una transazione
        mysqli_begin_transaction($conn);

        try {
            // 1. Disabilita temporaneamente i vincoli di foreign key
            mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 0");

            // 2. Elimina prima gli interventi associati al dispositivo
            $query_interventi = "DELETE FROM interventi WHERE idDispositivo = '$id'";
            $result_interventi = mysqli_query($conn, $query_interventi);
            
            if (!$result_interventi) {
                throw new Exception('Errore durante l\'eliminazione degli interventi');
            }

            // 3. Elimina il dispositivo dalla tabella dispositivi
            $query_dispositivo = "DELETE FROM dispositivi WHERE IDDispositivo = '$id'";
            $result_dispositivo = mysqli_query($conn, $query_dispositivo);
            
            if (!$result_dispositivo) {
                throw new Exception('Errore durante l\'eliminazione del dispositivo');
            }

            // 4. Riabilita il controllo delle foreign key
            mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1");

            // Se tutte le operazioni sono andate a buon fine, conferma la transazione
            mysqli_commit($conn);

            // Reindirizza alla pagina di visualizzazione con messaggio di successo
            header("Location: visualizzaDisp.php?result=success");

        } catch (Exception $e) {
            // Se c'è un errore, fai il rollback della transazione
            mysqli_roll_back($conn);
            
            // Mostra l'errore
            echo "Errore durante l'eliminazione: " . $e->getMessage();
        }
    } else {
        // Se la connessione al database fallisce
        echo "Errore nella connessione al database.";
    }
} else {
    // Se l'ID non è passato, reindirizza con un errore
    header("Location: visualizzaDisp.php?result=error");
}

// Chiudi la connessione al database
mysqli_close($conn);
?>