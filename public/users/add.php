<?php
require './../core/functions.php';
require '../../config/keys.php';
require './../core/db_connect.php';

$message=null;

$args = [
    'first_name'=>FILTER_SANITIZE_STRING, //strips HMTL
    'last_name'=>FILTER_SANITIZE_STRING, //strips HMTL
    'email'=>FILTER_SANITIZE_STRING, //strips HMTL
  
];

$input = filter_input_array(INPUT_POST, $args);

if(!empty($input)){

    //Strip white space, begining and end
    $input = array_map('trim', $input);

    //Allow only whitelisted HTML
    $input['body'] = cleanHTML($input['body']);



    //Sanitiezed insert
    $sql = 'INSERT INTO users SET first_name=?, last_name=?, email=?';

    if($pdo->prepare($sql)->execute([
        $input['first_name'],
        $input['last_name'],
        $input['email']
    ])){
       header('LOCATION:/example.com/public/users');
    }else{
        $message = 'Something bad happened';
    }
}

$content = <<<EOT
<h1>Add a new user</h1>
{$message}
<form method="users">

<div class="form-group">
    <label for="first_name">First Name</label>
    <input id="first_name name="first_name" type="text" class="form-control">
</div>

<div class="form-group">
    <label for="last_name">Last Name</label>
    <input id="last_name" name="last_name" class="form-control">
</div>

    <div class="form-group">
        <label for="email">Email Address</label>
        <input id="last_name" name="last_name class="form-control">
    </div>


<div class="form-group">
    <input type="submit" value="Submit" class="btn btn-primary">
</div>
</form>
EOT;

include './../core/layout.php';