<?php
$userId = $_COOKIE['user_id'];
$var = "id";

$order = "datetime";
//Filter GET Stuff
if ($_GET['type']) {
    $type = strtolower($_GET['type']);
}

//Get Page. Assign to 1 if no page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;


//Amount Per Page
$perPage = 10;

//Positioning
$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;

//Get Posts Count
$query = 'SELECT * FROM posts WHERE category = :type ORDER BY id DESC LIMIT 20';
$stmt = $pdo->prepare($query);
$stmt->bindParam(':type', $type);
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
$total = count($posts);

//Pages Amount
$pages = ceil($total / $perPage);

//Get Mail
$query = 'SELECT * FROM posts WHERE category = :type ORDER BY id DESC LIMIT :start , :perPage';
$stmt = $pdo->prepare($query);
$stmt->bindParam(':start', $start, PDO::PARAM_INT);
$stmt->bindParam(':perPage', $perPage, PDO::PARAM_INT);
$stmt->bindParam(':type', $type);
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo '<div style="display: flex;justify-content:space-between;flex-direction: row;">';
//Go Back Arrow
echo '<div class="leftRightButtons">';
echo '<a href="critterweb"><<</a>';
echo '</div>';

//Post Button (Right)
if ($type == "news" || $type == "submissions") {
    if ($userId == 1) {
        echo '<div style="text-align: right;"><button  class="fancyButton" onClick="window.location.href=\'newPost?type=' . $type . '\'">New Post</button></div>';
    }
} else {
    echo '<div style="text-align: right;"><button  class="fancyButton" onClick="window.location.href=\'newPost?type=' . $type . '\'">New Post</button></div>';
}

echo '</div>';

//Title
if ($type === "submissions") {
    echo '<h3 style="margin-bottom: 3rem">Monthly Submissions</h3>';
} elseif ($type === "giveaways") {
    echo '<h3 style="margin-bottom: 3rem">Giveaways & Freebies</h3>';
} elseif ($type === "guides") {
    echo '<h3 style="margin-bottom: 3rem">User Made Guides</h3>';
} elseif ($type === "questions") {
    echo '<h3 style="margin-bottom: 3rem">Questions & Answers</h3>';
} elseif ($type == "share") {
    echo '<h3 style="margin-bottom: 3rem">Snoozeling Sharing</h3>';
}  elseif ($type == "helpcenter") {
    echo '<h3 style="margin-bottom: 3rem">Help Center</h3>';
}  elseif ($type == "virtualpets") {
    echo '<h3 style="margin-bottom: 3rem">Virtual Pets Board</h3>';
} elseif ($type == "findfriends") {
    echo '<h3 style="margin-bottom: 3rem">Find Friendships</h3>';
}  elseif ($type == "forumgames") {
    echo '<h3 style="margin-bottom: 3rem">Forum Games</h3>';
}  elseif ($type == "mature") {
    echo '<h3 style="margin-bottom: 3rem">18+ Exclusive Boards</h3>';
}  else {
    echo '<h3 style="margin-bottom: 3rem">' . $_GET['type'] . ' Board</h3>';
}


//Display Posts
foreach ($posts as $post) {
    //Grab Bonded ID and Username
    $query = 'SELECT username, bonded FROM users WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $post['user_id']);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Get Pet Information
    $query = 'SELECT * FROM snoozelings WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $user['bonded']);
    $stmt->execute();
    $pet = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo '<div class="post">';
    echo '<div class="postRowOne">';
    echo '<div class="postUser">';
    echo '<a href="profile?id=' . $post['user_id'] . '"><h4 style="margin-top: 0;">'  . htmlspecialchars($user['username']) . '</h4></a>';
    displayPet($pet, "articon");
    
    echo '</div>';

    echo '<div class="postContent" style="margin-right: auto; margin-left: auto;">';
    echo '<h3>' . htmlspecialchars($post['title']) . '</h3>';
    if ($post['category'] === "news" || $post['category'] === "submissions") {
        echo '<p>' . nl2br($post['text']) . '</p></div>';
    } else {
        echo '<p>' . nl2br(htmlspecialchars($post['text'])) . '</p></div>';
    }
    
    echo '</div>';
    echo '<div class="readMore"><a href="post?id=' . $post['id'] . '"><h4>Read More >></h4></a></div>';
    echo '</div>';
    
}

if ($pages > 1) {
//Pagination
echo '<div class="pagination" style="margin-top: 1rem;">';
for ($x = 1; $x <= $pages; $x++) {
    if ($page === $x) {
        $selected = "selected";
    } else {
        $selected = "";
    }
    echo '<a href="?type=' . $_GET['type'] . '&page=' . $x . '" style="font-size: 2rem; margin: 1rem;" class="' . $selected . '">' . $x . '</a>';
}
echo '</div>';
}























