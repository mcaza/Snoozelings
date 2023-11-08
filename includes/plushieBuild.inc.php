<?php

if (isset($_GET['ID'])) {   
    $id = $_GET['ID'];
}

    $query = "SELECT * FROM snoozelings WHERE id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $queryMainColor = "SELECT display FROM colors WHERE name = :mainColor";
        $queryHairColor = "SELECT * FROM colors WHERE name = :haircolor";
        $queryTailColor = "SELECT * FROM colors WHERE name = :tailColor";
        $queryEyeColor = "SELECT * FROM colors WHERE name = :eyeColor";
        $queryNoseColor = "SELECT * FROM colors WHERE name = :noseColor";

        $stmt2 = $pdo->prepare($queryMainColor);
        $stmt3 = $pdo->prepare($queryHairColor);
        $stmt4 = $pdo->prepare($queryTailColor);
        $stmt5 = $pdo->prepare($queryEyeColor);
        $stmt6 = $pdo->prepare($queryNoseColor);
        
        $stmt2->bindParam(":mainColor", $result['mainColor']);
        $stmt3->bindParam(":haircolor", $result['hairColor']);
        $stmt4->bindParam(":tailColor", $result['tailColor']);
        $stmt5->bindParam(":eyeColor", $result['eyeColor']);
        $stmt6->bindParam(":noseColor", $result['noseColor']);
        
        $stmt2->execute();
        $stmt3->execute();
        $stmt4->execute();
        $stmt5->execute();
        $stmt6->execute();
        
        $mainColorResults = $stmt2->fetch(PDO::FETCH_ASSOC);
        $hairColorResults = $stmt3->fetch(PDO::FETCH_ASSOC);
        $tailColorResults = $stmt4->fetch(PDO::FETCH_ASSOC);
        $eyeColorResults = $stmt5->fetch(PDO::FETCH_ASSOC);
        $noseColorResults = $stmt6->fetch(PDO::FETCH_ASSOC);

    echo '<p class="snoozelinginfo" id="pbmaincolor"><strong>Main Color: </strong>' . $mainColorResults["display"] . '</p>
                    <p class="snoozelinginfo" id="pbhaircolor"><strong>Hair Color: </strong>' . $hairColorResults["display"] . '</p>
                    <p class="snoozelinginfo" id="pbtailcolor"><strong>Tail Color: </strong>' . $tailColorResults["display"] . '</p>
                    <p class="snoozelinginfo" id="pbeyecolor"><strong>Eye Color: </strong>' . $eyeColorResults["display"] . '</p>
                    <p class="snoozelinginfo" id="pbnosecolor"><strong>Nose Color: </strong>' . $hairColorResults["display"] . '</p>
                    <p class="snoozelinginfo" id="pbhairstyle"><strong>Hair Style: </strong>' . $result["hairType"] . '</p>
                    <p class="snoozelinginfo" id="pbtailstyle"><strong>Tail Type: </strong>' . $result["tailType"] . '</p>
                    <p class="snoozelinginfo" id="pbspecialmarkings" style="margin-bottom: .3rem;"><strong>Special Traits: </strong></p>
                    <ul style="text-align: left;margin-top: 0;padding-bottom: 0;font-size:1.6rem;">';
                    $specialArray = explode(" ", $result["specials"]);
                        foreach ($specialArray as $special) {
                            echo '<li style="margin-bottom:.3rem;margin-left:3rem;">' . $special . '</li>';
                        }
                   echo  '</ul>';