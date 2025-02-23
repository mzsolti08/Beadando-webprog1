<?php require_once "../pdo.php";
include "../layout/header.php";

$stmt_users = $db->prepare("SELECT * FROM user");
$stmt_users->execute();
$userek = $stmt_users->fetchAll();

$stmt = $db->prepare("SELECT * FROM forums");
$stmt->execute();
$posztok = $stmt->fetchAll();

$stmt_admin_check = $db->prepare("SELECT * FROM user WHERE web_admin = 2");
$stmt_admin_check->execute();
$admin = $stmt_admin_check->fetch();

if (isset($_POST['visszaallitas'])) {
    $stmt_vissza = $db->prepare("UPDATE forums SET removed_post = :removed_post WHERE forum_id = :fid");
    $stmt_vissza->bindValue(":removed_post", null);
    $stmt_vissza->bindValue(":fid", $_POST['hid']);
    $stmt_vissza->execute();
    $url = "/functions/admin_post.php?admin_id=" . $admin['user_id'];
    header("Location: $url");
}
if (isset($_POST['torles'])){
    $stmt_poszt_torles = $db->prepare("UPDATE forums SET removed_post = :removed_p WHERE forum_id = :forum_id");
    $datum = date("Y-m-d h:i:s");
    $stmt_poszt_torles->bindValue(":removed_p", $datum);
    $stmt_poszt_torles->bindValue(":forum_id", $_POST['hrid']);
    $stmt_poszt_torles->execute();
    $url = "/functions/admin_post.php?admin_id=" . $admin['user_id'];
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
            <a href="admin.php?admin_id=<?= $admin['user_id'] ?>" style="float: right; margin-right: 20px; font-size: 18px"> <strong><<</strong> Vissza <strong>>></strong> </a>
            <a href="admin_comment.php?admin_id=<?= $admin['user_id'] ?>" style="float: left; margin-right: 20px; font-size: 18px"> <strong><<</strong> Kommenttek kezelése <strong>>></strong> </a>
            <br><br>
        </div>
        <div class="subforum-title">
            <h1 style="font-size: 24px">Posztok visszaállítása</h1>
        </div>
        <?php foreach ($posztok as $poszt):?>
            <?php if ($poszt['removed_post'] != null): ?>
                <div class="subforum-row" style="grid-template-columns: 80% 20%">
                    <div class="subforum-stats subforum-column center">
                        <span style="font-size: 20px"><?= $poszt['posts'] ?></span>
                    </div>
                    <div class="subforum-info subforum-column center">
                        <?php if ($admin['web_admin'] == 2): ?>
                            <form method="post" action="/functions/admin_post.php?admin_id=<?= $admin['user_id'] ?>">
                                <input type="hidden" name="hid" value="<?= $poszt['forum_id'] ?>">
                                <input type="submit" name="visszaallitas" id="visszaallitas" value="Poszt visszaállítása" style="padding: 7px; background-color: lightseagreen; color: black">
                            </form>
                        <?php endif;?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach;?>
    </div>
</div>
<div class="container" style="width: 80%; margin: auto">
    <div class="subforum">
        <div class="subforum-title">
            <h1 style="font-size: 24px">Posztok törlése</h1>
        </div>
        <?php foreach ($posztok as $poszt):?>
            <?php if ($poszt['removed_post'] == null): ?>
                <div class="subforum-row" style="grid-template-columns: 80% 20%">
                    <div class="subforum-stats subforum-column center">
                        <span style="font-size: 20px"><?= $poszt['posts'] ?></span>
                    </div>
                    <div class="subforum-info subforum-column center">
                        <?php if ($admin['web_admin'] == 2): ?>
                            <form method="post" action="/functions/admin_post.php?admin_id=<?= $admin['user_id'] ?>">
                                <input type="hidden" name="hrid" value="<?= $poszt['forum_id'] ?>">
                                <input type="submit" name="torles" id="torles" value="Poszt törlése" style="padding: 7px; background-color: lightseagreen; color: black">
                            </form>
                        <?php endif;?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach;?>
    </div>
</div>

<?php include "../layout/footer.php"; ?>
