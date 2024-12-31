<?php
include '../config.php';
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="estForm.css">
    <title>Form Dispositivo</title>
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
    <h2>Inserisci i dettagli sul dispositivo</h2>
    
    <form action="inserimentoDisp.php" method="POST">
        <label for="tipologia">*Tipologia:</label>
            <select id="tipologia" name="tipologia">
            <?php
                $query="SELECT * FROM `tipologieDispositivi`";
                $result=mysqli_query($conn, $query);
                while($row = mysqli_fetch_assoc($result)){
                    
                    echo "<option value='".$row['IDTipologia']."'>".$row['tipo']."</option>";
                    
                }
                ?>
        </select>
        <button style="border-radius: 150px; background-color: #ADD8E6; width: 4%; text-align: center;"  onclick="window.location.href='formAggTipol.php'">+</button>
        <label for="ambiente">*Ambiente:</label>
        <select name="ambiente" id="ambiente">
            <?php
                $query="SELECT * FROM `ambienti`";
                $result=mysqli_query($conn, $query);
                while($row = mysqli_fetch_assoc($result)){
                    
                    echo "<option value='".$row['IDAmbiente']."'>".$row['nome']."</option>";
                    
                }
                ?>
        </select><br><br>
        <label for="modello">*Modello:</label>
        <input type="text" id="modello" name="modello" maxlength="40" required><br><br>

        <label for="marca">*Marca:</label>
        <input type="text" id="marca" name="marca" maxlength="40" required><br><br>

        <label for="numeroSerie">*Numero di Serie:</label>
        <input type="text" id="numeroSerie" name="numeroSerie" maxlength="20" required><br><br>
        
        <label for="dataAcquisto">*Inserisci la data di acquisto(min: <?php echo Date('Y')-25 ?>):</label>
        <input type="date" id="dataAcquisto" name="dataAcquisto" min="1999-01-01" max="<?php echo date('Y-m-d'); ?>" required>


        <label for="siglaInventario">Sigla Inventario(univoca per ogni dispositivo):</label>
        <input type="text" id="siglaInventario" name="siglaInventario" maxlength="20"><br><br>

        <label for="descrizioneDispositivo">Descrizione Dispositivo:</label>
        <textarea id="descrizioneDispositivo" name="descrizioneDispositivo" rows="4" cols="50" maxlength="500"></textarea><br><br>

        <label for="garanziaDispositivo">*Garanzia Dispositivo (in mesi):</label>
        <input type="number" id="garanziaDispositivo" name="garanziaDispositivo" maxlength="3" min = "0" max = "999" required><br><br>
        
        <label for="etichetta">*Etichetta(scritta attaccata sul dispositivo):</label>
        <input type="text" id="etichetta" name="etichetta" maxlength="30" required><br><br>
        
        <button style="border-radius: 100px; background-color: #ADD8E6; width: 30%; margin-left: 60%; font-size: 20px;" type="submit">Inserisci dispositivo</button>
    </form>
    
    <button style="border-radius: 100px; background-color: #ADD8E6; width: 20%; font-size: 18px;"  onclick="window.location.href='visualizzaDisp.php'">Visualizza i dispositivi già inseriti</button>


</body>
</html>