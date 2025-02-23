<?php require_once "../pdo.php";
include "../layout/header.php";

if(isset($_POST["login"])){
    $error = [];
    if(!isset($_POST["username"]) || $_POST["username"] == "" || strlen($_POST["username"]) > 30){
        $error[]= "A felhasználnév nem lett helyesen megadva!";
    }
    if(!isset($_POST["password"]) || $_POST["password"] == "" || strlen($_POST["password"]) > 40){
        $error[]= "A jelszó nem lett helyesen megadva!";
    }
    if(count($error) > 0){
        if(isset($error[0])){
            echo "<br>" . $error[0];
        }
        if(isset($error[1])){
            echo "<br>" . $error[1];
        }
        else if (isset($error[0]) && isset($error[1])){
            echo $error[0] . "<br>" . $error[1];
        }
        echo "<br><a href='login.php'>Vissza</a>";
        exit;
    }
    $stmt = $db->prepare("SELECT * FROM user WHERE user_name = :username AND user_password = :password");
    $stmt->bindValue(":username", $_POST["username"]);
    $pw = md5($_POST["password"]);
    $stmt->bindValue(":password", $pw);
    $stmt->execute();
    $row = $stmt->rowCount();
    $fetch = $stmt->fetch();
    if (isset($fetch['user_name']) && isset($fetch['user_password'])){
        if ($fetch['removed'] == null){
            if($row > 0)
            {
                $_SESSION['userID'] = $fetch['user_id'];
                header("Location: ../index.php");
            }
            else{
                echo "<br> Hibás a felhasználónév és a jelszó!";
                echo "<br><a href='login.php'>Vissza</a>";
                exit();
            }
        }
        else{
            echo "<br> Ezt a profilt törölték!";
            echo "<br><a href='login.php'>Vissza</a>";
            exit();
        }
    }
    else{
        echo "<br> Hibás a felhasználónév és a jelszó!";
        echo "<br><a href='login.php'>Vissza</a>";
        exit();
    }
}
?>


</header>
<form method="post" action="login.php">
    <div class="container">
        <div class="subforum">
            <div class="subforum-title">
                <h1 style="font-size: 24px">Bejelentkezés</h1>
            </div>
            <div class="subforum-row" style="grid-template-columns: 40% 40% 20%">
                <div class="subforum-description subforum-column center" style="height: 100px">
                    <input type="text" name="username" id="username" placeholder="Felhasználónév" style="width: 100%; height: 70px; font-size: 16px">
                </div>
                <div class="subforum-description subforum-column center">
                    <input type="password" name="password" id="password" placeholder="Jelszó" style="width: 100%; height: 70px; font-size: 16px">
                </div>
                <div class="subforum-description subforum-column center">
                    <input type="submit" name="login" value="Belépés" style="width: 50%; height: 70px; font-size: 16px">
                </div>
            </div>
        </div>
</form>


<?php include "../layout/footer.php" ?>
