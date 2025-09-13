 <?php
    require_once 'dbh-inc.php';

    //Grab all Cookies
    $query = "SELECT * FROM sessions";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $sessions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $now = new DateTime('now', new DateTimezone('UTC'));
    $now->modify("-1 day");
    $firstDate = $now->format('m-d');

    $countActive = 0;
    $countKilled = 0;
    foreach ($sessions as $session) {
        $secondDate = substr($session['datetime'], 5);
        if ($firstDate < $secondDate) {
            $countActive++;
        } else {
            $query = "DELETE FROM sessions WHERE auto = :id;";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":id", $session['auto']);
            $stmt->execute();
            $countKilled++;
        }
    }

echo $countActive . ' Sessions Active. ' . $countKilled . ' Sessions Killed.';