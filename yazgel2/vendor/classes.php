<?php


class Ders
{
    public $id;
    public $ad;
    public $gun;
    public $saat;
    public $classes;


    public function __construct($id = null, $ad = null, $gun = null, $saat = null, $classes = null)
    {
        $this->id = $id;
        $this->ad = $ad;
        $this->gun = $gun;
        $this->saat = $saat;
        $this->classes = $classes;
    }

    public function isEqual($other)
    {
        return $other instanceof Ders &&
            $this->id == $other->id &&
            $this->ad == $other->ad &&
            $this->saat == $other->saat &&
            $this->gun == $other->gun;
    }

    public function getHash()
    {
        return hash("sha256", json_encode([$this->ad, $this->saat, $this->gun]));
    }
}

class Classes
{
    public $className;

    

    public function __construct($className = null)
    {
        $this->className = $className;
    }
    private static $derslikler = []; 


    public static function init($db)
    {
        $derslik_sor = $db->prepare("SELECT * FROM sinif");
        $derslik_sor->execute(array());
        $say = $derslik_sor->rowCount();
        if ($say != 0) {
            while ($derslik_cek = $derslik_sor->fetch(PDO::FETCH_ASSOC)) {
                array_push(self::$derslikler, $derslik_cek['sinif_isim']);
            }
        }
    }

    public function isEqual($other)
    {
        return $other instanceof Classes && $this->className == $other->className;
    }

    public function getHash()
    {
        return hash("sha256", $this->className);
    }


    public static function getDerslikler()
    {
        return self::$derslikler;
    }

    public static function bosDerslikBul($gun, $saat, $program)
    {
        $derslikler = self::getDerslikler(); 

        
        foreach ($derslikler as $derslik) {
            $bos = true;

            foreach ($program as $hocaDersleri) {
                foreach ($hocaDersleri as $existingDers) {
                    if ($existingDers->gun == $gun && $existingDers->saat == $saat && $existingDers->classes == $derslik) {
                        $bos = false;
                        break 2; 
                    }
                }
            }

            if ($bos) {
                return $derslik;
            }
        }

        
        foreach ($derslikler as $derslik) {
            $bos = true;

            foreach ($program as $hocaDersleri) {
                foreach ($hocaDersleri as $existingDers) {
                    if ($existingDers->classes == $derslik) {
                        $bos = false;
                        break 2; 
                    }
                }
            }

            if ($bos) {
                return $derslik;
            }
        }

        return null; 
    }
}

class Hoca
{
    public $id;
    public $ad;
    public $istenmeyen_gun;
    public $givenLessons;


    


    public function __construct($id = null, $ad = null, $istenmeyen_gun = null, $givenLessons = null)
    {
        $this->id = $id;
        $this->ad = $ad;
        $this->istenmeyen_gun = $istenmeyen_gun;
        $this->givenLessons = $givenLessons ? $givenLessons : [];
    }

    public function hash()
    {
        return hash('sha256', $this->ad . $this->istenmeyen_gun);
    }

    public function getHash()
    {
        return hash("sha256", json_encode([$this->ad, $this->istenmeyen_gun]));
    }
    public function oncelikliDersleriGetir()
    {
        $oncelikliDersler = [];

        foreach ($this->givenLessons as $ders) {
            
            if ($ders->gun != "") {
                $oncelikliDersler[] = $ders;
            }
        }

        return $oncelikliDersler;
    }
    public function equals($other)
    {
        return $this->ad == $other->ad;
    }
}

class WorkingHours
{
    

    public static $_workingDays = ["Pazartesi", "Salı", "Çarşamba", "Perşembe", "Cuma"];
    public static $_workingHours = [
        "09:00",
        "10:00",
        "11:00",
        "12:00",
        "13:00",
        "14:00",
        "15:00",
        "16:00",
        "17:00",
    ];

    public static function workingHours()
    {
        $result = [];
        foreach (WorkingHours::$_workingDays as $day) {
            $result[$day] = WorkingHours::$_workingHours;
        }
        return $result;
    }

    public static function excludeDays($excludedDays)
    {
        $result = array_diff(self::$_workingDays, (array) $excludedDays);

        foreach ($result as $day) {
            $workingHours[$day] = self::$_workingHours;
        }

        return $workingHours;
    }
}
