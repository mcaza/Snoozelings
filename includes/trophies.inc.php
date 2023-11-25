<?php
require_once 'dbh-inc.php';

//Date Stuff
$now = new DateTime();
$date = $now->format('Y-m-d');

//Grab All Info
$query = "SELECT * FROM users WHERE lastLog = :date";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":date", $date);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Go through each member
foreach ($results as $member) {
    //Turn Trophies List into Array
    $trophies = explode(" ", $member['trophies']);
    $copy = $trophies;
    
    //Farming Trophy Check
    $crops = intval($member['cropsHarvested']);
    if ($crops > 100) {
        if ($crops < 1000) {
            if (!in_array("farmerbronze", $trophies)) {
                array_push($trophies, "farmerbronze");
            }
        } elseif ($crops < 10000) {
            if (!in_array("farmersilver", $trophies)) {
                $key = array_search('farmerbronze', $trophies);
                unset($trophies[$key]);
                array_push($trophies, "farmersilver");
            }
        } else {
            if (!in_array("farmergold", $trophies)) {
                $key = array_search('farmersilver', $trophies);
                unset($trophies[$key]);
                array_push($trophies, "farmergold");
            }
            
        }
    }
    
    //Explore Trophy Check
    $explores = intval($member['explores']);
    if ($explores > 100) {
        if ($explores < 1000) {
            if (!in_array("explorerbronze", $trophies)) {
                array_push($trophies, "explorerbronze");
            }
        } elseif ($explores < 10000) {
            if (!in_array("explorersilver", $trophies)) {
                $key = array_search('explorerbronze', $trophies);
                unset($trophies[$key]);
                array_push($trophies, "explorersilver");
            }
        } else {
            if (!in_array("explorergold", $trophies)) {
                $key = array_search('explorersilver', $trophies);
                unset($trophies[$key]);
                array_push($trophies, "explorergold");
            }
            
        }
    }
    
    //Crafting Trophy Check
    $crafts = intval($member['itemsCrafted']);
    if ($crafts > 100) {
        if ($crafts < 1000) {
            if (!in_array("crafterbronze", $trophies)) {
                array_push($trophies, "crafterbronze");
            }
        } elseif ($crafts < 10000) {
            if (!in_array("craftersilver", $trophies)) {
                $key = array_search('crafterbronze', $trophies);
                unset($trophies[$key]);
                array_push($trophies, "craftersilver");
            }
        } else {
            if (!in_array("craftergold", $trophies)) {
                $key = array_search('craftersilver', $trophies);
                unset($trophies[$key]);
                array_push($trophies, "craftergold");
            }
            
        }
    }
    
    //Journal Trophy Check
    $journals = intval($member['journalEntries']);
    if ($journals > 100) {
        if ($journals < 1000) {
            if (!in_array("journalbronze", $trophies)) {
                array_push($trophies, "journalbronze");
            }
        } elseif ($journals < 2500) {
            if (!in_array("journalsilver", $trophies)) {
                $key = array_search('journalbronze', $trophies);
                unset($trophies[$key]);
                array_push($trophies, "journalsilver");
            }
        } else {
            if (!in_array("journalgold", $trophies)) {
                $key = array_search('journalsilver', $trophies);
                unset($trophies[$key]);
                array_push($trophies, "journalgold");
            }
            
        }
    }
    
    //Items Bought Trophy Check
    $bought = intval($member['itemsBought']);
    if ($bought > 100) {
        if ($bought < 1000) {
            if (!in_array("buyingbronze", $trophies)) {
                array_push($trophies, "buyingbronze");
            }
        } elseif ($bought < 2500) {
            if (!in_array("buyingsilver", $trophies)) {
                $key = array_search('buyingbronze', $trophies);
                unset($trophies[$key]);
                array_push($trophies, "buyingsilver");
            }
        } else {
            if (!in_array("buyinggold", $trophies)) {
                $key = array_search('buyingsilver', $trophies);
                unset($trophies[$key]);
                array_push($trophies, "buyinggold");
            }
            
        }
    }
    
    //Snoozelings Made Trophy Check
    $snoozelings = intval($member['snoozelingsCrafted']);
    if ($snoozelings > 20) {
        if ($snoozelings < 50) {
            if (!in_array("sewingbronze", $trophies)) {
                array_push($trophies, "sewingbronze");
            }
        } elseif ($snoozelings < 100) {
            if (!in_array("sewingsilver", $trophies)) {
                $key = array_search('sewingbronze', $trophies);
                unset($trophies[$key]);
                array_push($trophies, "sewingsilver");
            }
        } else {
            if (!in_array("sewinggold", $trophies)) {
                $key = array_search('buyingsilver', $trophies);
                unset($trophies[$key]);
                array_push($trophies, "sewinggold");
            }
            
        }
    }
    
    //Date Check
    $futureDate1=date('Y-m-d', strtotime('+1 year', strtotime($member['signupDate'])) );
    $futureDate2=date('Y-m-d', strtotime('+2 year', strtotime($member['signupDate'])) );
    $futureDate3=date('Y-m-d', strtotime('+3 year', strtotime($member['signupDate'])) );
    $futureDate4=date('Y-m-d', strtotime('+4 year', strtotime($member['signupDate'])) );
    $futureDate5=date('Y-m-d', strtotime('+5 year', strtotime($member['signupDate'])) );
    $futureDate6=date('Y-m-d', strtotime('+6 year', strtotime($member['signupDate'])) );
    if ($date > $futureDate1) {
        if ($date < $futureDate2) {
            if (!in_array("yearone", $trophies)) {
                array_push($trophies, "yearone");
            }
        } elseif ($date < $futureDate3) {
            if (!in_array("yeartwo", $trophies)) {
                $key = array_search('yearone', $trophies);
                unset($trophies[$key]);
                array_push($trophies, "yeartwo");
            } 
        }elseif ($date < $futureDate4) {
            if (!in_array("yearthree", $trophies)) {
                $key = array_search('yeartwo', $trophies);
                unset($trophies[$key]);
                array_push($trophies, "yearthree");
            } 
        }
        elseif ($date < $futureDate5) {
            if (!in_array("yearfour", $trophies)) {
                $key = array_search('yearthree', $trophies);
                unset($trophies[$key]);
                array_push($trophies, "yearfour");
            } 
        }
        elseif ($date < $futureDate6) {
            if (!in_array("yearfive", $trophies)) {
                $key = array_search('yearfour', $trophies);
                unset($trophies[$key]);
                array_push($trophies, "yearfive");
            } 
        }
        
        else {
            if (!in_array("yearsix", $trophies)) {
                $key = array_search('yearfive', $trophies);
                unset($trophies[$key]);
                array_push($trophies, "yearsix");
            }
            
        }
    }
    //Put Array Back into Table
    if ($copy == $trophies) {
        
    } else {
        $string = implode(" ", $trophies);
        $query = 'UPDATE users SET trophies = :trophies WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":trophies", $string);
        $stmt->bindParam(":id", $member['id']);
        $stmt->execute();
    }
}




