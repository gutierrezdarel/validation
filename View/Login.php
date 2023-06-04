
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login.css">
  
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class="login-container" id="login">
            <h1>Login</h1>
            <div class="login">
                <form action="../Index.php?action=Login" method="POST">
                    <p class="error"></p>
                    <input type="text" name="username" id="username" placeholder="Username">
                    <input type="password" name="password" id="password" placeholder="Password">
                    
                    <button type="submit" name="login" value="login">Login</button>
                    <button type="button" id="reg-btn">Register</button>
                </form>
            </div>
        </div>

       

        <div class="login-container" id="reg">
            <h1>Register</h1>
            <div class="login">
                <form action="../Index.php?action=Register" method="POST">
                    <input type="text" name="insert_uname" placeholder="Username" required>
                    <input type="password" name="insert_pass" placeholder="Password" required>
                    <input type="text" name="fullname" placeholder="Full Name" required>
                    <select name="user_type" id="" required>
                        <option selected disabled value="">User type</option>
                        <option value="1">Admin</option>
                        <option value="2">Employee</option>
                        <option value="3">Costumer</option>
                    </select>
                    <button type="submit" name="insert-btn">Register</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="../js/action.js"></script>