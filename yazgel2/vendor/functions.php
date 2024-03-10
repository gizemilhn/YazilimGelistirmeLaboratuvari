<?php



function renklendirmeAlgoritmasi($hocaList)
{
    $renkler = []; 
    $program = []; 
    
    

    foreach ($hocaList as $hoca) {
        $hash = $hoca->getHash();
        if (!isset($renkler[$hash])) {
           
            $renkler[$hash] = []; 
        }
        $renk = $hash; 

        
        foreach ($hoca->givenLessons as $ders) {
            if (!isset($program[$renk])) {
                $program[$renk] = []; 
            }
            $program[$renk][] = $ders; 
        }
    }

    return $program; 
}


function otomatikDersProgramiOlustur($hocalar)
{
    $program = []; 
    $renkler = renklendirmeAlgoritmasi($hocalar); 

    $index = 0;

    foreach ($renkler as $renk => $dersler) {
        $workingHours = WorkingHours::workingHours(); 

        if (!isset($program[$renk])) {
            $program[$renk] = []; 
        }

        if (isset($hocalar[$index]->istenmeyen_gun) and $hocalar[$index]->istenmeyen_gun != null) {
            $workingHours = WorkingHours::excludeDays($hocalar[$index]->istenmeyen_gun);
        }


        foreach ($dersler as $ders) {
            if ($ders->gun != "") {
                if ($ders->saat != "") {
                    $hour = $ders->saat;
                } else {
                    $hour = $workingHours[$ders->gun][0];
                }
                $derslik = Classes::bosDerslikBul($ders->gun, $hour, $program);
                if ($derslik !== null) {
                    $program[$renk][] = new Ders($ders->id, $ders->ad, $ders->gun, $hour, $derslik);
                    array_shift($workingHours[$ders->gun]);
                }
            } else {
                $derslik = null;
                foreach ($workingHours as $day => $hours) {
                    foreach ($hours as $saat) {
                        $derslik = Classes::bosDerslikBul($day, $saat, $program);
                        if ($derslik !== null) {
                            $program[$renk][] = new Ders($ders->id, $ders->ad, $day, $saat, $derslik);
                            array_shift($workingHours[$day]);
                            break;
                        }
                    }
                    if ($derslik !== null) {
                        break; 
                    }
                }
            }
        }
        $index++;
    }


    return $program; 
}

function arrayOfExplodedDays($days)
{
    if ($days != null) {
        return explode(",", $days);
    } else {
        return null;
    }
}

function findLessonAtHourAndDay($dersler, $saat, $gun)
{
    foreach ($dersler as $ders) {
        if ($ders->saat == $saat && $ders->gun == $gun) {
            return $ders;
        }
    }
    return null;
}
