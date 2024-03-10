<?php



try {
    
    $db = new PDO("mysql:host=localhost;dbname=canan;charset=utf8", 'root', '');
    
} catch (PDOException $e) {
    
    echo "Hata kodu: " . $e->getCode() . "<br>";
    echo "Hata mesajı: " . $e->getMessage() . "<br>";
}
