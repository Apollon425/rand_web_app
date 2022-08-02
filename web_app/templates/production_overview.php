<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../static/css/style4.css">
    <script src="../static/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.8.0/dist/chart.min.js"></script>
    <title>Produktionsübersicht</title>
</head>
<body>


    <button id="side_button_left" onclick="openNav()">☰</button>



    <div id="sidebar_left" class="sidebar_left">
        <a href="javascript:void(0)" class="sidebar_left_closebtn" onclick="closeNav()">×</a>
        <a href="projects2.html">Projektübersicht</a>
        <a href="production_overview.php" class="active_page">Produktionsübersicht</a>
      </div>

      <div class="chart-container">
        <canvas id="anzahl_abs"></canvas>
    </div>
</br>

    <div class="chart-container">
        <canvas id="testChart"></canvas>
    </div>


    <?php
        include "db_access.inc.php";
        if($msconn === false) {
            echo "Verbindung Zur MSSQL Datenbank Fehlgeschlagen, abrufen der Abreitschritte aktuell nicht möglich";
        }
        else {
            $msq = $msconn->query("
            SELECT DATENAME(MONTH,EndTime) as Monat, Count(Idx) As Auftrag
            FROM [IB33DB].[dbo].[T_InfoBoardItem]
            WHERE ProductId = 3593
            AND IsFinished = 1
            AND YEAR(EndTime) = YEAR(GETDATE())
            
            GROUP BY DATENAME(MONTH, EndTime), MONTH(EndTime)

            ");

            foreach ($msq as $row) {
                $stamper_amount[] = $row['Auftrag'];
            }

        }

    ?>

<?php
        include "db_access.inc.php";
        if($conn_lexware_db === false) {
            echo "Verbindung Zur MSSQL Datenbank Fehlgeschlagen, abrufen der Abreitschritte aktuell nicht möglich";
        }
        else {
            $msq = $conn_lexware_db->query("
            SELECT                             
            DATENAME(MONTH,Datum_erfassung) as Monat, Count(AuftragsNr) As Auftrag              
            FROM lxdw_ab_daten_rand.dbo.FK_Auftrag as Auftrag 
            WHERE                                 
            Auftrag.Auftragskennung = 1 
            
            AND bStatus_obsolet = 0 
            AND bStatus_storniert = 0
            AND ProjektNr is NOT NULL
            AND BestellNr is NOT NULL
            AND NOT KundenNr IN (12316, 999999)
            AND YEAR(Datum_erfassung) = YEAR(GETDATE())
            
            GROUP BY DATENAME(MONTH, Datum_erfassung), MONTH(Datum_erfassung)

            ");

            foreach ($msq as $row) {
                $abs_amount[] = $row['Auftrag'];
            }

        }

    ?>

<?php
        include "db_access.inc.php";
        if($conn_lexware_db === false) {
            echo "Verbindung Zur MSSQL Datenbank Fehlgeschlagen, abrufen der Abreitschritte aktuell nicht möglich";
        }
        else {
            $msq = $conn_lexware_db->query("
            SELECT                             
            DATENAME(MONTH,Datum_erfassung) as Monat, Count(AuftragsNr) As Auftrag              
            FROM lxdw_ab_daten_rand.dbo.FK_Auftrag as Auftrag 
            WHERE                                 
            Auftrag.Auftragskennung = 1 
            
            AND bStatus_obsolet = 0 
            AND bStatus_storniert = 0
            AND ProjektNr is NOT NULL
            AND BestellNr is NOT NULL
            AND KundenNr = 12316
            AND YEAR(Datum_erfassung) = YEAR(GETDATE())
            
            GROUP BY DATENAME(MONTH, Datum_erfassung), MONTH(Datum_erfassung)

            ");

            $reklas_amount = array(0, 0, 0);
            foreach ($msq as $row) {
           
                $reklas_amount[] = $row['Auftrag'];

            }

        }

    ?>



    <script>
        const labels = ["Januar", "Februar", "März", "April", "Mai", "Juni", "Juli", "August"];
        const data = {
        labels: labels,
        datasets: [{
            label: 'Erledigte Aufträge Stamperpräparierung',
            data: <?php echo json_encode($stamper_amount)?>,
            fill: false,
            borderColor: 'rgb(75, 192, 192)',
            tension: 0.1
        }]
        };

        const config = {
        type: 'line',
        data: data,
        options: {
            maintainAspectRatio: false,           
            plugins: {
                title: {
                    display: true,
                    text: 'Produktion'
                }
            },
            scales: {
                y: {
                    max: 400,
                    min: 0,
                    ticks: {

                        stepSize: 50
                        
                }
            }
        }


        }

};

    </script>

    <script>
        const testChart = new Chart(
        document.getElementById('testChart'),
        config
        );
    </script>

<script>
        const labels2 = ["Januar", "Februar", "März", "April", "Mai", "Juni", "Juli", "August"];
        const data2 = {
        labels: labels2,
        datasets: [{
            label: 'Auftragseingänge (ABs)',
            data: <?php echo json_encode($abs_amount)?>,
            fill: false,
            borderColor: 'rgb(75, 192, 192)',
            tension: 0.1
        },
        {
            label: 'Reklas',
            data: <?php echo json_encode($reklas_amount)?>,
            fill: false,
            borderColor: 'rgb(252, 44, 3)',
            tension: 0.1
        }
        
        
    
    ]
        };

        const config_2 = {
        type: 'line',
        data: data2,
        options: {
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: 'Vertrieb'
                }
            },
            scales: {
                y: {
                    max: 400,
                    min: 0,
                    ticks: {

                        stepSize: 50
                        
                }
            }
        }

        }
        
        };

    </script>

    <script>
        const testChart2 = new Chart(
        document.getElementById('anzahl_abs'),
        config_2
        );
    </script>
    
</body>
</html>


