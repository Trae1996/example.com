<?php
require './../core/functions.php';
//require '../../config/keys.php';
require './../core/db_connect.php';
// Get the users
$get = filter_input_array(INPUT_GET);
$id = $get['id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id=:id");
$stmt->execute(['id'=>$id]);
$row = $stmt->fetch();
//If the id cannot be found kill the request
if(empty($row)){
  http_response_code(404);
  die('Page Not Found <a href="/">Home</a>');
}
//var_dump($row);
$meta=[];
$meta['first_name']= "Edit: {$row['first_name']}";
// Update the users
$message=null;
$args = [
    'first_name'=>FILTER_SANITIZE_STRING, //strips HMTL
    'email'=>FILTER_SANITIZE_STRING, //strips HMTL
    'last_name'=>FILTER_SANITIZE_STRING, //strips HMTL
];
$input = filter_input_array(INPUT_POST, $args);
if(!empty($input)){
    //Strip white space, begining and end
    $input = array_map('trim', $input);
    //Allow only whitelisted HTML
    $input['body'] = cleanHTML($input['body']);
    //Sanitized insert
    $sql = 'UPDATE
        users
      SET
        first_name=:first_name,
        email=:email,
        last_name=:last_name
      WHERE
        id=:id';
    if($pdo->prepare($sql)->execute([
        'first_name'=>$input['first_name'],
        'email'=>$input['email'],
        'last_name'=>$input['last_name'],
    ])){
       header('LOCATION:/users/view.php?email=' . $row['email']);
    }else{
        $message = 'Something bad happened';
    }
}
$content = <<<EOT
<h1>Edit: {$row['first_name']}</h1>
{$message}
<form method="users">
<input id="id" name="id" value="{$row['id']}" type="hidden">

<div class="form-group">
    <label for="first_name">First Name</label>
    <input id="first_name" value="{$row['first_name']}" name="first_name" type="text" class="form-control">
</div>

<div class="form-group">
    <label for="last_name">Last Name</label>
    <input id="last_name" value="{$row['last_name']}" name="last_name" type="text" class="form-control">
</div>

<div class="form-group">
    <div class="form-group>
        <label for="email">Email Address</label>
        <input id="email" value="{$row['email']}" name="email" type="text" class="form-control">
    </div>
</div>
<div class="form-group">
    <input type="submit" value="Submit" class="btn btn-primary">
</div>
</form>
EOT;
include './../core/layout.php';