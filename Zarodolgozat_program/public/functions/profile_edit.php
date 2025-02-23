<?php require_once "../pdo.php";
include "../layout/header.php";


$stmt_user = $db->prepare("SELECT * FROM user WHERE user_id = :id");
$stmt_user->bindValue(':id', $_SESSION['userID']);
$stmt_user->execute();
$user = $stmt_user->fetch();

if(isset($_POST["edit"])) {
    $error = [];
    if ($_POST["username"] == "" || strlen($_POST["username"]) > 30) {
        $error[]= "A felhasználnév nem lett helyesen megadva!";
    }
    if ($_POST["email"] == "") {
        $error[]= "Az email nem lett helyesen megadva!";
    }
    if ($_POST["description"] == "" || strlen($_POST["description"]) > 400) {
        $error[]= "A profile leírása nem lett helyesen megadva!";
    }
    if (count($error) > 0) {
        if (isset($error[0])) {
            echo $error[0] . "<br>";
        }
        if (isset($error[1])) {
            echo $error[1] . "<br>";
        }
        if (isset($error[2])) {
            echo $error[2] . "<br>";
        }
        exit;
    }
        $stmt = $db->prepare("UPDATE user SET user_name = :name, user_email = :email, user_description = :description WHERE user_id = :sid");
        $stmt->bindValue(":sid", $_SESSION['userID']);
        $stmt->bindValue(":name", $_POST['username']);
        $stmt->bindValue(":email", $_POST['email']);
        $stmt->bindValue(":description", $_POST['description']);
        if ($stmt->execute()){
            echo "Sikeres szerkesztés!";
            header("Location: ../detail.php");
        }
        else{
            echo "Hiba történt a szerkesztés közben!";
            exit();
        }
}
?>

<?php if (isset($_SESSION['userID'])): ?>
</header>
<form method="post" action="profile_edit.php">
    <div class="container">
        <div class="subforum">
            <div class="subforum-title">
                <h1><span style="margin-left: 20px; font-size: 24px">Profil szerkesztése <?= $user['user_name'] ?></span>
                    <a href="../detail.php" style="float: right; margin-right: 20px; font-size: 20px"><strong><<</strong> Vissza <strong>>></strong></a></h1>
            </div>
            <div class="subforum-column">
                <div class="subforum-row" style="grid-template-columns: 33% 33% 33% ">
                    <div class="subforum-description subforum-column center">
                        <input type="text" name="username" id="username" value="<?= $user['user_name'] ?>" style="width: 70%; height: 32px">
                    </div>
                    <div class="subforum-description subforum-column center">
                        <input type="email" name="email" id="email" value="<?= $user['user_email'] ?>" style="width: 70%; height: 32px">
                    </div>
                </div>
            </div>

            <div class="subforum-column">
                    <div class="subforum-description subforum-column center">
                        <textarea name="description" id="description" style="width: 70%;" placeholder="Profil leírása"><?= $user['user_description'] ?></textarea>
                    </div>
            </div>

            <div class="subforum-column">
                <div class="subforum-description subforum-column center">
                    <input type="submit" name="edit" value="Szerkesztés" style="width: 30%; height: 32px">
                </div>
            </div>
        </div>
</form>
<?php else:
    exit("<a href='../forums.php' style='font-size: 25px; float: right'><strong><<</strong> Vissza <strong>>></strong></a>
    <h1 style='text-align: center; font-size: 50px'> Nincs jogosúltságod ehhez az oldalhoz </h1>"); ?>
<?php endif;?>

<?php include "../layout/footer.php" ?>