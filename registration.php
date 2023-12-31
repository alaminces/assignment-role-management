<?php 
  
  $userErr = $emailErr = $passErr = "";
  

  // When logined or registration page is executed user information will save in users file

  $adminInfo = [
    'username' => 'Alamin Miah',
    'email' => 'alamin@gmail.com',
    'password'=> 12345,
    'role'=> 'admin'
  ];

  $file = file_get_contents("./data/users.txt");

  if (empty($file)) {
    $fp = fopen("./data/users.txt","w");
    
    $data = sprintf("%s,%s,%s,%s\n",$adminInfo['role'],$adminInfo['username'],$adminInfo['email'],$adminInfo['password']);
    fwrite($fp,$data);
    fclose($fp);
  }
    

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    function validation($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }

    $username = validation($_POST['username']);
    $email    = validation($_POST['email']);
    $password = validation($_POST['password']);

    

    $error = [];

    if (empty($username)) {
      $userErr = 'Username field must not be empty!';
      $error[] = true;
    }
    if(empty($email)) {
      $emailErr = "Email field must not be empty!";
      $error[] = true;
    }
    if (empty($password)) {
      $passErr = "Password field must not be empty!";
      $error[] = true;
    }

    if ( count($error) === 0 ) {
      $filename = "./data/users.txt";
      
      if ( is_writeable($filename) ) {
        $data = file_get_contents($filename);

        $fp = fopen($filename,"a+");

        $found = false;
        // check if exist email 
        $data = file_get_contents($filename);
        $lines = explode("\n",rtrim($data,"\n"));
        foreach($lines as $line) {
          $data = explode(',',$line);
          if ($data[2] == $email) {
            $found = true;
          }
        }

        if ($found) {
          $errMsg = "Already Email address exists";;
        }else {
          fwrite($fp,"user,$username,$email,$password\n");
          $msg = "Registration Successfully";
        }
        fclose($fp);

      }
      
    } 

  }

  
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-2"></div>
      <div class="col-md-8 bg-info p-5">
        <h2 class="text-center">Registration System</h2>
        <span class="text-success"><?php echo $msg ?? ""; ?></span>
        <span class="text-danger"><?php echo $errMsg ?? ""; ?></span>
        <form action="registration.php" method="post">
          <div class="mb-4 mt-5">
            <input type="text" class="form-control" name="username" placeholder="Enter Username">
            <span class="text-danger"><?php echo $userErr; ?></span>
          </div>

          <div class="mb-4">
            <input type="email" class="form-control" name="email" placeholder="Enter Email">
            <span class="text-danger"><?php echo $emailErr; ?></span>
          </div>

          <div class="mb-4">
            <input type="password" name="password" placeholder="Enter Password" class="form-control" >
            <span class="text-danger"><?php echo $passErr; ?></span>
          </div>
          
          <div class="mt-5">
            <button type="submit" name="register" class="btn btn-primary">Register</button>
            <a class="btn btn-warning end" href="login.php">Login here</a>
          </div>

        </form>
      </div>
    </div>
    
  </div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>