<?php
include './vendor/classes.php';
include './vendor/functions.php';
include './vendor/connection.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);


$hocalar = [];
Classes::init($db);

$hoca_sor = $db->prepare("SELECT * FROM hoca");
$hoca_sor->execute(array());
$say = $hoca_sor->rowCount();
if ($say != 0) {
    while ($hoca_cek = $hoca_sor->fetch(PDO::FETCH_ASSOC)) {
        $hocanin_dersleri = [];

        $ders_sor = $db->prepare("SELECT * FROM ders where ders_hoca=:ders_hoca");
        $ders_sor->execute(array(
            'ders_hoca' => $hoca_cek['hoca_id']
        ));
        $ders_say = $ders_sor->rowCount();
        if ($ders_say != 0) {
            while ($ders_cek = $ders_sor->fetch(PDO::FETCH_ASSOC)) {
                array_push($hocanin_dersleri, new Ders($ders_cek['ders_id'], $ders_cek['ders_ad'], $ders_cek['ders_gun'], $ders_cek['ders_saat']));
            }
        }
        $istenmeyen_gunler = arrayOfExplodedDays($hoca_cek['hoca_istenmeyengun']);
        array_push($hocalar, new Hoca(
            $hoca_cek['hoca_id'],
            $hoca_cek['hoca_isim'],
            $istenmeyen_gunler,
            $hocanin_dersleri
        ));
    }
}

$dersProgrami = otomatikDersProgramiOlustur($hocalar);

if (isset($_GET['updated'])) {
    foreach ($dersProgrami as $renk => $dersGunleri) {
        foreach ($hocalar as $hoca) {
            if ($hoca->getHash() == $renk) {
                $hocaAdi = $hoca->ad;
                $hocaId = $hoca->id;
                break;
            }
        }
        $json = array();
        $json['dersprogrami'] = (array) $dersGunleri;

        $kaydet = $db->prepare("UPDATE hoca SET
    hoca_dersProgrami=:hoca_dersProgrami
    WHERE hoca_id={$hocaId}");
        $insert = $kaydet->execute(array(
            'hoca_dersProgrami' => json_encode($json)
        ));
    }
}



?>

<!DOCTYPE html>
<html lang="tr-TR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yazgel</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            width: 100vw;
            height: 100vh;
            background-color: #14141D;

            display: flex;
            align-items: center;
            flex-direction: column;

        }

        .programs {

            margin-top: 25px;
            width: 80vw;
            background-color: #DCE0E5;
            padding: 50px;
            border-radius: 50px;
        }

        table {
            width: 100%;
        }

        th,
        td {
            padding: 15px;
        }
    </style>
</head>

<body>

    <div class="container ">

        <h5 style="color:#DCE0E5; text-align:center;margin-top: 75px;">Kocaeli Universitesi - Çizge Renklendirme ile Ders Programı Hazırlama</h5>

        <div class="programs">


            <ul class="nav nav-tabs" id="myTab" role="tablist">

                <?php
                $index = 0;
                foreach ($dersProgrami as $renk => $dersGunleri) {
                    $hocaAdi = ""; 
                    foreach ($hocalar as $hoca) {
                        if ($hoca->getHash() == $renk) {
                            $hocaAdi = $hoca->ad;
                            break;
                        }
                    }

                ?>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link <?php if ($index == 0) {
                                                    echo 'active';
                                                } ?>" id="<?= 'tabs' . $index ?>-tab" data-bs-toggle="tab" data-bs-target="#<?= 'tabs' . $index ?>" type="button" role="tab" aria-controls="<?= 'tabs' . $index ?>" aria-selected="true"><?= $hocaAdi ?></button>
                    </li>
                <?php
                    $index++;
                }

                ?>


            </ul>

            <!-- Tab panes -->
            <div class="tab-content">


                <?php
                $index = 0;
                foreach ($dersProgrami as $renk => $dersGunleri) {
                    $hocaAdi = ""; 
                    foreach ($hocalar as $hoca) {
                        if ($hoca->getHash() == $renk) {
                            $hocaAdi = $hoca->ad;
                            break;
                        }
                    }
                ?>
                    <div class="tab-pane <?php if ($index == 0) {
                                                echo 'active';
                                            }  ?>" id="<?= 'tabs' . $index  ?>" role="tabpanel" aria-labelledby="<?= 'tabs' . $index ?>-tab">

                        <?php
                        

                        
                        $workingHours = WorkingHours::workingHours();

                        echo '<table border="1">';
                        echo '<tr><th>Saat</th>';
                        foreach ($workingHours as $day => $hours) {
                            echo "<th>$day</th>";
                        }
                        echo '</tr>';

                        foreach (WorkingHours::$_workingHours as $hour) {
                            echo '<tr>';
                            echo "<td>$hour</td>";

                            foreach ($workingHours as $day => $hours) {
                                echo '<td>';

                                
                                $ders = findLessonAtHourAndDay($dersGunleri, $hour, $day);
                                if ($ders !== null) {
                        ?>
                                    <a href="./update_ders.php?id=<?= $ders->id ?>">
                                        <?= $ders->ad . '<br>' . $ders->classes; ?>
                                    </a>
                        <?php

                                } else {
                                    echo '-';
                                }

                                echo '</td>';
                            }

                            echo '</tr>';
                        }

                        echo '</table>';


                        ?>

                    </div>
                <?php
                    $index++;
                }

                ?>

            </div>
        </div>
        <!-- Nav tabs -->

    </div>


</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

</html>