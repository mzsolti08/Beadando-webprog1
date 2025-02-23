<?php require_once "../pdo.php";
include "../layout/header.php";

$stmt_users = $db->prepare("SELECT * FROM user");
$stmt_users->execute();
$userek = $stmt_users->fetchAll();

$stmt_admin_check = $db->prepare("SELECT * FROM user WHERE web_admin = 2");
$stmt_admin_check->execute();
$admin = $stmt_admin_check->fetch();

$stmt_felhasznalo = $db->prepare("SELECT * FROM user INNER JOIN forum_comments ON user.user_id = forum_comments.user_id");
$stmt_felhasznalo->execute();
$kommentek = $stmt_felhasznalo->fetchAll();

if (isset($_POST['visszaallitas'])) {
    $stmt_vissza = $db->prepare("UPDATE forum_comments SET deleted = :deleted WHERE comment_id = :cid");
    $stmt_vissza->bindValue(":deleted", null);
    $stmt_vissza->bindValue(":cid", $_POST['hid']);
    $stmt_vissza->execute();
    $url = "/functions/admin_comment.php?admin_id=" . $admin['user_id'];
    header("Location: $url");
}
if (isset($_POST['torles'])) {
    $stmt_komment_torlese = $db->prepare("UPDATE forum_comments SET deleted = :deleted WHERE comment_id = :cid");
    $datum = date("Y-m-d h:i:s");
    $stmt_komment_torlese->bindValue(":deleted", $datum);
    $stmt_komment_torlese->bindValue(":cid", $_POST['cid']);
    $stmt_komment_torlese->execute();
    $url = "/functions/admin_comment.php?admin_id=" . $admin['user_id'];
    header("Location: $url");
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

<div class="container" style="width: 80%; margin: auto">
    <div class="subforum">
        <div class="subforum-description">
            <a href="admin_post.php?admin_id=<?= $admin['user_id'] ?>" style="float: right; margin-right: 20px; font-size: 18px"> <strong><<</strong> Vissza <strong>>></strong> </a>
            <br><br>
        </div>
        <div class="subforum-title">
            <h1 style="font-size: 24px">Kommentek visszaállítása</h1>
        </div>
        <?php foreach ($kommentek as $komment): ?>
            <?php if ($komment['deleted'] != null): ?>
                <div class="subforum-row" style="grid-template-columns: 80% 20%">
                    <div class="subforum-stats subforum-column center">
                        <span style="font-size: 20px"><?= $komment['comment'] ?></span>
                    </div>
                    <div class="subforum-info subforum-column center">
                        <?php if ($admin['web_admin'] == 2): ?>
                            <form method="post" action="/functions/admin_comment.php?admin_id=<?= $admin['user_id'] ?>">
                                <input type="hidden" name="hid" value="<?= $komment['comment_id'] ?>">
                                <input type="submit" name="visszaallitas" id="visszaallitas" value="Komment visszaállítása az oldalról" style="padding: 7px; background-color: lightseagreen; color: black">
                            </form>
                        <?php endif;?>
                    </div>
                </div>
            <?php endif;?>
        <?php endforeach;?>
    </div>
</div>
<div class="container" style="width: 80%; margin: auto">
    <div class="subforum">
        <div class="subforum-title">
            <h1 style="font-size: 24px">Kommentek törlése</h1>
        </div>
        <?php foreach ($kommentek as $komment): ?>
            <?php if ($komment['deleted'] == null): ?>
                <div class="subforum-row" style="grid-template-columns: 80% 20%">
                    <div class="subforum-stats subforum-column center">
                        <span style="font-size: 20px"><?= $komment['comment'] ?></span>
                    </div>
                    <div class="subforum-info subforum-column center">
                        <?php if ($admin['web_admin'] == 2): ?>
                            <form method="post" action="/functions/admin_comment.php?admin_id=<?= $admin['user_id'] ?>">
                                <input type="hidden" name="cid" value="<?= $komment['comment_id'] ?>">
                                <input type="submit" name="torles" id="torles" value="Kommentek törlése az oldalról" style="padding: 7px; background-color: lightseagreen; color: black">
                            </form>
                        <?php endif;?>
                    </div>
                </div>
            <?php endif;?>
        <?php endforeach;?>
    </div>
</div>

<?php include "../layout/footer.php"; ?>