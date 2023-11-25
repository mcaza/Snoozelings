<?php

$id = $_GET['id'];

//Go Back Arrow
echo '<div class="leftRightButtons">';
echo '<a href="profile?id=' . $id . '"><<</a>';
echo '</div>';

//Send Message Form
echo '<form method="post" action="includes/sendmail.inc.php">';
echo '<label class="form" for="title">Title:</label><br>';
echo '<input class="input" type="text" name="title" required><br>';
echo '<label class="form" for="reply">Message:</label><br>';
echo '<textarea name="reply" cols="72" class="input" style="height: 20rem;"></textarea><br>';
echo '<input type="hidden" name="to" value="' . $id . '">';
echo '<button  class="fancyButton">Send Message</button>';
echo '</form>';