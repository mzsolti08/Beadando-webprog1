<?php require_once "../pdo.php";
include "../layout/header.php";

$stmt_mindenUser = $db->prepare("SELECT * FROM user");
$stmt_mindenUser->execute();
$mindenUser = $stmt_mindenUser->fetchAll();

$stmt_admin_check = $db->prepare("SELECT * FROM user WHERE web_admin = 2");
$stmt_admin_check->execute();
$admin = $stmt_admin_check->fetch();
?>

</header>
<?php if (isset($_SESSION['userID']) && $_SESSION['userID'] != null):
        foreach ($mindenUser as $felhcheck):
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
            <a href="admin_post.php?admin_id=<?= $admin['user_id'] ?>" style="float: right; margin-right: 20px; font-size: 18px"><strong><<</strong> Posztok kezelése <strong>>></strong></a>
            <a href="admin_create.php?admin_id=<?= $admin['user_id'] ?>" style="float: left; margin-left: 20px; font-size: 18px"><strong><<</strong> Oldal kezelése <strong>>></strong></a>
            <br><br>
        </div>
        <div class="subforum-title">
            <h1 style="font-size: 24px">Felhasználók</h1>
        </div>
        <?php foreach ($mindenUser as $users):?>
            <?php if ($users['web_admin'] == 1):?>
                <div class="subforum-row" style="grid-template-columns: 80% 20%">
                    <div class="subforum-stats subforum-column center">
                        <h4 style="font-size: 20px"><a href="../functions/user_show.php?user_id=<?= $users['user_id'] ?>" style="font-size: 24px"><?= $users['user_name'] ?></a></h4>
                    </div>
                    <div class="subforum-info subforum-column center">
                        <?php
                        if (isset($_POST['ban'])){
                            $stmt_ban = $db->prepare("UPDATE user SET removed = :removed WHERE user_id = :uid");
                            $datum = date("Y-m-d h:i:s");
                            $stmt_ban->bindValue(":removed", $datum);
                            $stmt_ban->bindValue(":uid", $_POST['hid']);
                            $stmt_ban->execute();
                            $url = "/functions/admin.php?admin_id=" . $admin['user_id'];
                            header("Location: $url");
                        }else if (isset($_POST['unban'])){
                            $stmt_ban = $db->prepare("UPDATE user SET removed = :removed WHERE user_id = :uid");
                            $stmt_ban->bindValue(":removed", null);
                            $stmt_ban->bindValue(":uid", $_POST['hid']);
                            $stmt_ban->execute();
                            $url = "/functions/admin.php?admin_id=" . $admin['user_id'];
                            header("Location: $url");
                        }
                        ?>
                        <?php if ($admin['web_admin'] == 2): ?>
                            <form method="post" action="/functions/admin.php?admin_id=<?= $admin['user_id'] ?>">
                                <input type="hidden" name="hid" value="<?= $users['user_id'] ?>">
                                <?php if ($users['removed'] == null): ?>
                                    <input type="submit" name="ban" id="ban" value="Felhasználó kitiltása az oldalról" style="padding: 7px; background-color: darkred; color: wheat">
                                <?php else: ?>
                                    <input type="submit" name="unban" id="unban" value="Felhasználó újra engedélyezése" style="padding: 7px; background-color: lightblue; color: black" >
                                <?php endif;?>
                            </form>
                        <?php endif;?>
                    </div>
                </div>
            <?php endif;?>
        <?php endforeach;?>
    </div>
</div>
<?php include "../layout/footer.php"; ?>
