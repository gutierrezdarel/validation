<?php 
require_once '../controller/init.php';
session_start();
$userController = new UserManipulateController();

if (!isset($_SESSION['id']) || !in_array("ADMIN", $_SESSION['roles'])) {
    header("location: Login.php");

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
.container{
    display: flex;
    width: 100%;
    flex-direction: column;
    height: 100vh;
    align-items: center;
    gap: 100px;
}
    table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
  display: flex;
  justify-content: center;
  padding-top: 70px;
  
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
.login-container h1 {
    padding-bottom: 20px;
    color: black;
}
.login-container {
    background-color: green;
    padding: 33px;
    text-align: center;
    border-radius: 5px;
    background: rgba(0, 0, 0, 0.05);
    box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
    backdrop-filter: blur(9.5px);
    -webkit-backdrop-filter: blur(9.5px);
    border-radius: 10px;
    border: 1px solid rgba(255, 255, 255, 0.18);
    /* display: none; */
}

.login-container form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}
</style>
<body>
<div class="container">
    <table> 
  <tr>
    <th>Username</th>
    <th>Name</th>
    <th>Role</th>
    <th>Action</th>
    <?php $users = $userController->displayUsers(); foreach ($users as $user): ?>
  <tr> 
    <td><?php echo $user['uname']; ?></td>
    <td><?php echo $user['fullname']; ?></td>
    .<td><?php echo $user['user_type']; ?></td>
  </tr>
<?php endforeach; ?>
</table>
    

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
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="../js/action.js"></script> -->