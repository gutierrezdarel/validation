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
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .container {
        display: flex;
        width: 100%;
        flex-direction: column;
        height: 100vh;
        align-items: center;
        gap: 100px;
    }

    /* #update {
        display: none;
    } */
    .overlay{
        width: 100%;
        height: 100vh;
        position: absolute;
        top: 0;
        /* display: flex; */
        justify-content: center;
        align-items: center;
        display: none;
    }
    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
        display: flex;
        justify-content: center;
        padding-top: 70px;

    }

    td,
    th {
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
                <?php $users = $userController->displayUsers();
                foreach ($users as $user) : ?>
            <tr>
                <td id="data_uname-<?php echo $user['id']; ?>"><?php echo $user['uname']; ?></td>
                <td id="data_fullname-<?php echo $user['id']; ?>" ><?php echo $user['fullname']; ?></td>
                <td id="data_usertype-<?php echo $user['id']; ?>"><?php echo $user['user_type']; ?></td>
                <td><button type="button" onclick="editUser(<?php echo $user['id']; ?>)">Edit</button>
                    <button type="button" onclick="deleteUser(<?php echo $user['id']; ?>)">Delete</button>
                </td>
            </tr>
        <?php endforeach; ?>
        </table>


        <div class="login-container" id="reg">
            <h1>ADD User</h1>
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
                    <button type="submit" name="insert-btn">Add</button>
                </form>
            </div>
        </div>

        <!-- UPDATE USER -->
        <div class="overlay" id="update_user">
            <div class="login-container" id="update">
                <h1>Update User</h1>
                <div class="login">
                    <form action="../Index.php?action=update" method="POST">
                        <input type="text" id="update_uname" name="update_uname" placeholder="Username" required>
                        <!-- <input type="password" id="update_pass" name="update_pass" placeholder="Password" required> -->
                        <input type="text" id="update_fullname" name="update_fullname" placeholder="Full Name" required>
                        <input type="hidden" id="update_id" name="id" value="">
                        <select name="user_type" id="update_utype" required>
                            <option disabled value="">User type</option>
                            <option value="1">ADMIN</option>
                            <option value="2">EMPLOYEE</option>
                            <option value="3">COSTUMER</option>
                        </select>
                        <button type="submit" name="update-btn">Update</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- DELETE USER -->
        <div class="overlay" id="delete_user">
            <div class="login-container" id="update">
                <h1>Update User</h1>
                <div class="login">
                    <form action="../Index.php?action=delete" method="POST">
                        <input type="hidden" id="delete_id" name="delete_id" value="">
                        <p>Are you sure do you wan to delete this user</p>
                        <button type="submit" name="delete_btn">Yes</button>
                        <button type="button" id="close">No</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</body>

</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script>
    function editUser(id) {
      $('#update_id').val(id)
      $('#update_user').css('display', 'flex');
      $('#update_uname').val($('#data_uname-' + id).html())
      $('#update_fullname').val($('#data_fullname-' + id).html())
      var userTypeText = $('#data_usertype-' + id).html();


        $('#update_utype').val(function() {
            return $(this).find('option:contains("' + userTypeText + '")').val();
        });
    }

    function deleteUser(id){
        $('#delete_user').css('display', 'flex');
        $('#delete_id').val(id);
    }
    $('#close').on('click',function(){
    $('#delete_user').css('display','none')
})
    
</script>