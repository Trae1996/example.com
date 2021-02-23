<?php
require './../core/functions.php';
require './../core/db_connect.php';
$args=[
  'email'=>FILTER_UNSAFE_RAW,
  'confirm'=>FILTER_VALIDATE_INT
];
$input = filter_input_array(INPUT_GET, $args);
$email=$input['email'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE email=:email");
$stmt->execute(['email'=>$email]);
$row = $stmt->fetch();
if(!empty($input['confirm'])){
  $stmt = $pdo->prepare("DELETE FROM users WHERE email=:email");
  if($stmt->execute(['email'=>$email])){
    header('Location: /example.com/public/users/');
  }
}
$first_name=[];
$first_name['first_name']="DELETE: {$row['first_name']}";
$content=<<<EOT
<h1 class="text-danger text-center">DELETE: {$row['first_name']}</h1>
<p class="text-danger text-center">Are you sure you want to delete {$row['first_name']}?</p>
<div class="text-center">
  <a href="./" class="btn btn-success btn-lg">Cancel</a>
  <br><br>
  <a href="delete.php?id={$row['email']}&confirm=1" class="btn btn-link text-danger">Delete</a>
</div>
EOT;
require './../core/layout.php';