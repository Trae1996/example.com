<?php
include './../core/db_connect.php';

$input = filter_input_array(INPUT_GET);
$slug = preg_replace("/[^a-z0-9-]+/", "", $input['slug']);

$content=null;
$stmt = $pdo->prepare('SELECT * FROM posts WHERE slug = ?');
$stmt->execute([$slug]);

$row = $stmt->fetch();

$content=<<<EOT
<h1>{$row['title']}</h1>
{$row['body']}<br>
{$row['meta_description']}<br>
{$row['meta_keywords']}<br>
<div>
<a class="btn btn-link" href="edit.php?id={$row['id']}">Edit</a>
<a class="btn btn-link" href="delete.php?id={$row['id']}">Delete</a>
</div>
EOT;
echo $content;

//include './../core/layout.php';