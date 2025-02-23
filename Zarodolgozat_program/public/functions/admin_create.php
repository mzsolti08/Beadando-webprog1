<?php require_once "../pdo.php";
include "../layout/header.php";

$stmt_users = $db->prepare("SELECT * FROM user");
$stmt_users->execute();
$userek = $stmt_users->fetchAll();

$stmt_admin_check = $db->prepare("SELECT * FROM user WHERE web_admin = 2");
$stmt_admin_check->execute();
$admin = $stmt_admin_check->fetch();

if (isset($_POST['create_tema'])){
    $stmt_hozzaadas = $db->prepare("INSERT INTO topics (forum_type) VALUE (:forum_type)");
    $stmt_hozzaadas->bindValue(":forum_type", $_POST['tema_name']);
    $stmt_hozzaadas->execute();
}
?>
    </header>
<?php if ($_SESSION['userID'] != null):
    foreach ($userek as $felhcheck):
        if (isset($_GET['admin_id']) && $_GET['admin_id'] == $_SESSION['userID']): ?>
        <?php else:
            exit("<a href='../forums.php' style='font-size: 25px; float: right'><strong><<</strong> Vissza <strong>>></strong></a> 
              <h1 style='text-align: center; font-size: 50px'> Nincs jogosúltságod ehhez az oldalhoz </h1>"); ?>
        <?php endif;?>
    <?php endforeach;?>
<?php else:
    exit("<a href='../forums.php' style='font-size: 25px; float: right'><strong><<</strong> Vissza <strong>>></strong></a>
    <h1 style='text-align: center; font-size: 50px'> Nincs jogosúltságod ehhez az oldalhoz </h1>"); ?>
<?php endif; ?>

    <form method="post" action="admin_create.php?admin_id=<?= $admin['user_id'] ?>">
        <div class="container" style="width: 80%; margin: auto">
            <div class="subforum">
                <div class="subforum-description">
                    <a href="admin.php?admin_id=<?= $admin['user_id'] ?>" style="float: right; margin-right: 20px; font-size: 18px"><strong><<</strong> Vissza <strong>>></strong></a>
                    <br><br>
                </div>
                <div class="subforum-title">
                    <h1>Téma hozzáadása</h1>
                </div>
                <div class="subforum-row" style="grid-template-columns: 50% 50%">
                    <div class="subforum-description subforum-column center">
                        <input type="text" name="tema_name" id="tema_name" placeholder="Téma neve (maximum 150 karakter)" style="width: 70%;">
                    </div>
                    <div class="subforum-description subforum-column center">
                        <input type="submit" name="create_tema" value="Létrehozás" style="width: 40%; height: 32px">
                    </div>
                </div>
            </div>
    </form>


<?php include "../layout/footer.php"; ?>