<?php 
include './vendor/connection.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['update_ders'])) {

    $gun = null;
    $saat = null;

    if ($_POST['ders_gun'] != "null") {
        $gun = $_POST['ders_gun'];
    }
    if ($_POST['ders_saat'] != "") {
        $saat = $_POST['ders_saat'];
    }
    

    $kaydet = $db->prepare("UPDATE ders SET
    ders_ad=:ders_ad,
    ders_gun=:ders_gun,
    ders_saat=:ders_saat,
    ders_hoca=:ders_hoca
    WHERE ders_id={$_POST['id']}");
    $insert = $kaydet->execute(array(
        'ders_ad' => $_POST['ders_ad'],
        'ders_gun' => $gun,
        'ders_saat' => $saat,
        'ders_hoca' => $_POST['ders_hoca']
    ));
    if ($insert) {
        header('Location:./index.php?updated=ok');
    } else {
        header('Location:./update_ders.php?durum=basarisiz');
    }
    
}
