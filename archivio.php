<?php
// 1. Connessione al database MySQL
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'webgis_parchi';

$conn = new mysqli($host, $user, $password, $dbname);
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// 2. Estrazione dati e creazione della mappa Regione -> Province
$sql = "SELECT * FROM parchi_e_giardini_aggiornato";
$result = $conn->query($sql);

$rows = [];
$regioneProvince = []; 
$tutteLeProvince = [];

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $rows[] = $row;
        $reg = $row['Regione'] ?? '';
        $prov = $row['Provincia'] ?? '';
        
        if (!empty($reg) && !empty($prov)) {
            if (!isset($regioneProvince[$reg]) || !in_array($prov, $regioneProvince[$reg])) {
                $regioneProvince[$reg][] = $prov;
            }
            $tutteLeProvince[$prov] = true;
        }
    }
    ksort($regioneProvince);
    foreach ($regioneProvince as $reg => $provinceList) {
        sort($regioneProvince[$reg]);
    }
    ksort($tutteLeProvince);
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Archivio Parchi e Giardini</title>
    <style>
        table a:link { color: #0066cc; text-decoration: underline; font-weight: bold; }
        table a:visited { color: #660099; text-decoration: none; font-weight: normal; }
        table a:hover { color: #004080; text-decoration: underline; }
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f9f9f9; }
        h1 { color: #333; }
        .filtri-container { display: flex; gap: 15px; margin-bottom: 20px; flex-wrap: wrap; }
        .filtro-item { flex: 1; min-width: 200px; }
        input[type="text"], select { width: 100%; padding: 10px; box-sizing: border-box; font-size: 16px; border: 1px solid #ccc; border-radius: 4px; background-color: #fff; }
        table { width: 100%; border-collapse: collapse; background-color: #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #4CAF50; color: white; }
        tr:hover { background-color: #f1f1f1; }
    </style>
</head>
<body>
    <p><a href="index.html" style="text-decoration: none; color: #4CAF50; font-weight: bold;">← Torna alla Mappa Interattiva</a></p>

    <h1>Archivio Parchi e Giardini Italiani</h1>

    <div class="filtri-container">
        <div class="filtro-item">
            <label for="filtroRicerca" style="display:block; margin-bottom:5px; font-weight:bold; color:#555;">Cerca per nome o via:</label>
            <input type="text" id="filtroRicerca" onkeyup="filtraTabella()" placeholder="Es. Parco o via...">
        </div>
        <div class="filtro-item">
            <label for="filtroRegione" style="display:block; margin-bottom:5px; font-weight:bold; color:#555;">Filtra per Regione:</label>
            <select id="filtroRegione" onchange="aggiornaProvinceEFiltra()">
                <option value="">Tutte le regioni</option>
                <?php foreach ($regioneProvince as $reg => $provinceList): ?>
                    <option value="<?php echo htmlspecialchars($reg); ?>"><?php echo htmlspecialchars($reg); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="filtro-item">
            <label for="filtroProvincia" style="display:block; margin-bottom:5px; font-weight:bold; color:#555;">Filtra per Provincia:</label>
            <select id="filtroProvincia" onchange="filtraTabella()">
                <option value="">Tutte le province</option>
                <?php foreach ($tutteLeProvince as $prov => $val): ?>
                    <option value="<?php echo htmlspecialchars($prov); ?>"><?php echo htmlspecialchars($prov); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    
    <p id="counter" style="font-family: Arial, sans-serif; color: #555; margin-bottom: 10px; font-weight: bold;"></p>
        
    <table id="tabellaParchi">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome / Indirizzo</th>
                <th>Latitudine</th>
                <th>Longitudine</th>
                <th>Provincia</th>
                <th>Sigla</th>
                <th>Regione</th>
            </tr>
        </thead>
        <tbody>
           <?php
            if (count($rows) > 0) {
                $idProgressivo = 1;
                foreach($rows as $row) {
                    $nomeParco = $row['Nome_parco_e_indirizzo'] ?? '';
                    $lat = $row['Latitudine'] ?? '';
                    $lon = $row['Longitudine'] ?? '';
                    $provincia = $row['Provincia'] ?? '';
                    $sigla = $row['Sigla_provincia'] ?? '';
                    $regione = $row['Regione'] ?? '';

                    echo "<tr>";
                    echo "<td>" . $idProgressivo . "</td>";
                    echo "<td><a href='index.html?lat=" . $lat . "&lon=" . $lon . "&nome=" . urlencode($nomeParco) . "'>" . htmlspecialchars($nomeParco) . "</a></td>";
                    echo "<td>" . $lat . "</td>";
                    echo "<td>" . $lon . "</td>";
                    echo "<td>" . htmlspecialchars($provincia) . "</td>";
                    echo "<td>" . htmlspecialchars($sigla) . "</td>";
                    echo "<td>" . htmlspecialchars($regione) . "</td>";
                    echo "</tr>";
                    $idProgressivo++;
                }
            } else {
                echo "<tr><td colspan='7'>Nessun record trovato</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <script>
        var mappaRegioniProvince = <?php echo json_encode($regioneProvince); ?>;

        function aggiornaProvinceEFiltra() {
            var selectRegione = document.getElementById("filtroRegione");
            var selectProvincia = document.getElementById("filtroProvincia");
            var regioneSelezionata = selectRegione.value;
            
            selectProvincia.innerHTML = '<option value="">Tutte le province</option>';

            if (regioneSelezionata === "") {
                <?php foreach ($tutteLeProvince as $prov => $val): ?>
                    var opt = document.createElement("option");
                    opt.value = "<?php echo addslashes($prov); ?>";
                    opt.textContent = "<?php echo addslashes($prov); ?>";
                    selectProvincia.appendChild(opt);
                <?php endforeach; ?>
            } else if (mappaRegioniProvince[regioneSelezionata]) {
                var provinceDellaRegione = mappaRegioniProvince[regioneSelezionata];
                for (var i = 0; i < provinceDellaRegione.length; i++) {
                    var opt = document.createElement("option");
                    opt.value = provinceDellaRegione[i];
                    opt.textContent = provinceDellaRegione[i];
                    selectProvincia.appendChild(opt);
                }
            }

            selectProvincia.value = ""; 
            filtraTabella();
        }

        function filtraTabella() {
            var inputFiltro = document.getElementById("filtroRicerca");
            var filtroTesto = inputFiltro.value.toUpperCase();
            
            var selectRegione = document.getElementById("filtroRegione");
            var filtroRegione = selectRegione.value.toUpperCase();
            
            var selectProvincia = document.getElementById("filtroProvincia");
            var filtroProvincia = selectProvincia.value.toUpperCase();
            
            var tabella = document.getElementById("tabellaParchi");
            var tr = tabella.getElementsByTagName("tr");
            var conteggio = 0;

            for (var i = 1; i < tr.length; i++) {
                var tdNome = tr[i].getElementsByTagName("td")[1];
                var tdProv = tr[i].getElementsByTagName("td")[4];
                var tdReg = tr[i].getElementsByTagName("td")[6];
                
                if (tdNome && tdProv && tdReg) {
                    var txtNome = tdNome.textContent || tdNome.innerText;
                    var txtProv = tdProv.textContent || tdProv.innerText;
                    var txtReg = tdReg.textContent || tdReg.innerText;
                    
                    var matchTesto = txtNome.toUpperCase().indexOf(filtroTesto) > -1;
                    var matchRegione = (filtroRegione === "" || txtReg.toUpperCase() === filtroRegione);
                    var matchProvincia = (filtroProvincia === "" || txtProv.toUpperCase() === filtroProvincia);
                    
                    if (matchTesto && matchRegione && matchProvincia) {
                        tr[i].style.display = "";
                        conteggio++;
                    } else {
                        tr[i].style.display = "none";
                    }
                }       
            }
            document.getElementById("counter").innerText = "Parchi visualizzati: " + conteggio;
        }

        window.onload = function() {
            filtraTabella();
        };
    </script>
</body>
</html>