<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>WebGIS - Chi Siamo</title>
    
    <!-- Leaflet CSS (mantenuto per coerenza) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    
    <style>
        * {
            box-sizing: border-box;
        }
        html, body {
            margin: 0;
            padding: 0;
            height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f2eb;
        }

        /* Layout principale a due colonne */
        .wrapper {
            display: flex;
            height: 100vh;
            width: 100vw;
        }

        /* Menu laterale a sinistra */
        .sidebar {
            width: 270px;
            background-color: #34495e;
            color: #ffffff;
            display: flex;
            flex-direction: column;
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1001;
        }

        .sidebar-header {
            padding: 20px 15px;
            font-size: 1.1rem;
            font-weight: bold;
            background-color: #2c3e50;
            border-bottom: 1px solid #4e6d8c;
            line-height: 1.4;
            text-align: center;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
            flex-grow: 1;
        }

        .sidebar-menu li a {
            display: block;
            padding: 15px 20px;
            color: #ecf0f1;
            text-decoration: none;
            font-size: 0.95rem;
            border-bottom: 1px solid #4e6d8c;
            transition: all 0.2s ease-in-out;
        }

        .sidebar-menu li a:hover, 
        .sidebar-menu li a.active {
            background-color: #2980b9;
            color: #ffffff;
            padding-left: 25px;
        }

        /* Box informativo esteso */
        .sidebar-footer {
            padding: 15px 20px;
            background-color: #2c3e50;
            border-top: 1px solid #4e6d8c;
            font-size: 0.78rem;
            color: #bdc3c7;
            line-height: 1.5;
        }

        .sidebar-footer strong {
            color: #ffffff;
        }

        /* Area principale con padding */
        .main-content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            padding: 20px;
            height: 100vh;
            background-color: #f5f2eb;
            overflow-y: auto;
        }

        /* Riquadro di testo principale in stile con il layout */
        .info-container {
            background: #ffffff;
            border-radius: 4px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border: 1px solid #222222;
            padding: 30px;
            max-width: 900px;
            margin: auto;
            line-height: 1.6;
            color: #2c3e50;
        }

        .info-container h2 {
            margin-top: 0;
            color: #2c3e50;
            border-bottom: 2px solid #2980b9;
            padding-bottom: 10px;
        }

        .info-container p {
            margin-bottom: 20px;
            font-size: 0.98rem;
            text-align: justify;
        }

        .info-container a {
            color: #2980b9;
            word-break: break-all;
        }
    </style>
</head>
<body>

    <div class="wrapper">
        <!-- Menu Laterale -->
        <nav class="sidebar">
            <div class="sidebar-header">WebGIS Parchi e Giardini Pubblici in Italia</div>
            <ul class="sidebar-menu">
                <li><a href="index.html">📍 Mappa Interattiva</a></li>
                <li><a href="archivio.php">📊 Archivio Tabellare</a></li>
                <li><a href="chisiamo.php" class="active">ℹ Chi siamo</a></li>
            </ul>
            
            <!-- Specifiche di Riferimento Spaziale -->
            <div class="sidebar-footer">
                <strong>CRS del layer punti (ubicazione parchi e giardini pubblici):</strong> WGS 84 (EPSG:4326) in Gradi Decimali<br><br>
                <strong>CRS della basemap:</strong> Web Mercator (EPSG:3857)
            </div>
        </nav>

        <!-- Contenuto Destra con Riquadro Informativo -->
        <main class="main-content">
            <div class="info-container">
                <h2>Informazioni sul Progetto</h2>
                
                <p><strong>WebGIS Parchi e Giardini Pubblici in Italia</strong><br>
                Realizzato a ottobre 2026 da <strong>Renato Forte</strong>, tecnico GIS e studente del Master di II livello in Geomatica presso il CGT dell'Università di Siena (a.a. 2026), come verifica finale nell'ambito del modulo <em>'WebGIS e Database Spaziali'</em> - Docente Daniele Simoncini.</p>
                
                <p><strong>Note sui Dati:</strong><br>
                I dati relativi a ubicazione parchi e giardini pubblici in Italia sono stati ricavati dal file <code>Parchi_E_Giardini.csv</code>, scaricabile dal sito <a href="https://www.poigps.com" target="_blank">www.poigps.com</a> (<a href="https://www.poigps.com/modules.php?name=Downloads&d_op=getit&lid=13" target="_blank">link diretto al download</a>). Tali dati non sono ufficiali e inclusivi di tutti i parchi e giardini pubblici, in quanto raccolti da una community di utenti e appassionati tramite rilevazioni GPS/GNSS amatoriali e quindi non necessariamente completi e/o aggiornati.</p>
                
                <p><strong>Finalità Didattica e Tecnologie:</strong><br>
                Il presente WebGIS costituisce semplice dimostrazione dell'utilizzo e potenzialità dei linguaggi HTML, CSS, JavaScript, PHP e della libreria Leaflet.</p>
            </div>
        </main>
    </div>

</body>
</html>