<?php
include './../core/db_connect.php';

$content=null;
$stmt = $pdo->query("SELECT * FROM users");

while ($row = $stmt->fetch())
{

    $content .= "<a href=\"view.php?email={$row['email']}\">{$row['first_name']}</a>";
}

include './../core/layout.php';
