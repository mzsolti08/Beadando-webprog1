<?php require_once "../pdo.php";
include "../layout/header.php";

if(isset($_POST["reg"])){
    $error = [];
    if(!isset($_POST["username"]) || $_POST["username"] == "" || strlen($_POST["username"]) > 30){
        $error[]= "A felhasználnév nem lett helyesen megadva!";
    }
    if(!isset($_POST["password"]) || $_POST["password"] == "" || strlen($_POST["password"]) > 40){
        $error[]= "A jelszó nem lett helyesen megadva!";
    }
    if(!isset($_POST["passwordre"]) || $_POST["passwordre"] == "" || strlen($_POST["passwordre"]) > 40 || ($_POST['password'] != $_POST['passwordre'])){
        $error[]= "A két jelszó nem egyezik!";
    }
    if(!isset($_POST["email"]) || $_POST["email"] == ""){
        $error[]= "Az email nem lett helyesen megadva!";
    }
    if(count($error) > 0){
        if ($error[0]){
            echo $error[0];
        }
        if ($error[1]){
            echo $error[1];
        }
        if ($error[2]){
            echo $error[2];
        }
        if ($error[3]){
            echo $error[3];
        }
        exit;
    }
    $stmt = $db->prepare("INSERT INTO user (user_name, user_password, user_email, web_admin) VALUE(:nam, :pw, :email, :jog)");
    $stmt->bindValue(":nam", $_POST["username"]);
    $pw = md5($_POST["password"]);
    $stmt->bindValue(":pw", $pw);
    $stmt->bindValue(":email", $_POST["email"]);
    $stmt->bindValue(":jog", "1");
    if($stmt->execute())
    {
        echo "Sikeres regisztráció, üdvözlünk " . $_POST['username']. " az oldalon!";
    }
    else{
        die("Hiba történt a regisztráció során");
    }
}
?>


</header>
    <form method="post" action="register.php">
    <div class="container">
        <div class="subforum">
            <div class="subforum-title">
                <h1 style="font-size: 24px">Regisztráció</h1>
            </div>
            <div class="subforum-row" style="grid-template-columns: 15% 12.5% 12.5% 35% 25%; ">
                <div class="subforum-description subforum-column center" style="height: 100px">
                    <input type="text" name="username" id="username" placeholder="Felhasználónév" style="width: 100%; height: 70px; font-size: 16px">
                 </div>
                <div class="subforum-description subforum-column center">
                    <input type="password" name="password" id="password" placeholder="Jelszó" style="width: 100%; height: 70px; font-size: 16px">
                 </div>
                <div class="subforum-description subforum-column center">
                    <input type="password" name="passwordre" id="passwordre" placeholder="Jelszó újra" style="width: 100%; height: 70px; font-size: 16px">
                </div>
                <div class="subforum-description subforum-column center">
                    <input type="email" name="email" id="email" placeholder="Email" style="width: 100%; height: 70px; font-size: 16px">
                </div>
                <div class="subforum-description subforum-column center">
                    <input type="submit" name="reg" value="Regisztráció" style="width: 50%; height: 70px; font-size: 16px">
                </div>
            </div>
        </div>
    </form>


<?php include "../layout/footer.php" ?>