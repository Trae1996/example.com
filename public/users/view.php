<?php
include './../core/db_connect.php';
$input = filter_input_array(INPUT_GET);
$id = !(empty($input['id']))? $input['id']:null;
$email = !(empty($input['email']))? $input['email']:null;
if(!empty($email)){
    $lookup = $email;
    $where = 'email = :lookup';
}else{
    $lookup = $id;
    $where = 'id = :lookup';
}
$stmt = $pdo->prepare("SELECT * FROM users WHERE {$where}");
$stmt->execute(['lookup'=>$lookup]);
$row = $stmt->fetch();
$content= <<<EOT
<h1>{$row['first_name']}</h1>
{$row['last_name']}<br>
{$row['email']}
<div>
<a class="btn btn-link" href="edit.php?id={$row['id']}">Edit</a>
<a class="btn btn-link" href="delete.php?id={$row['id']}">Delete</a>
</div>
EOT;
echo $content;
 //include './../core/layout.php';