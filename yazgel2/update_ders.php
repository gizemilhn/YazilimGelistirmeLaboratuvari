<?php
include './vendor/classes.php';
include './vendor/functions.php';
include './vendor/connection.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

$ders_sor = $db->prepare("SELECT * FROM ders where ders_id=:ders_id");
$ders_sor->execute(array(
    'ders_id' => $_GET['id']
));

$ders_cek = $ders_sor->fetch(PDO::FETCH_ASSOC);



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

            <form action="./database.php" method="post">
                <div class="row">
                    <div class="col-lg-2">
                        Dersin Adı:
                    </div>
                    <div class="col-lg-10">
                        <input type="text" name="ders_ad" class="form-control" value="<?= $ders_cek['ders_ad'] ?>">
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-lg-2">
                        Dersin Bulunmasını İstediğiniz Gün:
                    </div>
                    <div class="col-lg-10">
                        <select name="ders_gun" class="form-control" id="">
                            <option value="null">Herhangi Bir Gün Olabilir</option>
                            <option value="Pazartesi">Pazartesi</option>
                            <option value="Salı">Salı</option>
                            <option value="Çarşamba">Çarşamba</option>
                            <option value="Perşembe">Perşembe</option>
                            <option value="Cuma">Cuma</option>
                            <option value="Cumartesi">Cumartesi</option>
                            <option value="Pazar">Pazar</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-lg-2">
                        Dersin Bulunmasını İstediğiniz Saat:
                    </div>
                    <div class="col-lg-10">
                        <input type="text" name="ders_saat" class="form-control">
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-lg-2">
                        Dersin Bulunmasını İstediğiniz Hoca:
                    </div>
                    <div class="col-lg-10">
                        <select name="ders_hoca" class="form-control" id="">
                            <?php

                            $hoca_sor = $db->prepare("SELECT * FROM hoca");
                            $hoca_sor->execute(array());
                            $say = $hoca_sor->rowCount();
                            if ($say != 0) {
                                while ($hoca_cek = $hoca_sor->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                                    <option value="<?= $hoca_cek['hoca_id'] ?>"><?= $hoca_cek['hoca_isim'] ?></option>
                            <?php }
                            } ?>
                        </select>
                    </div>
                </div>
                <input type="hidden" name="id" value="<?=$_GET['id'] ?>">

                <div class="mt-5">
                    <button name="update_ders" class="btn btn-primary">Kaydet</button>
                    <a href="./index.php" class="btn btn-danger">Geri Dön</a>
                </div>
            </form>
        </div>
        <!-- Nav tabs -->

    </div>


</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

</html>