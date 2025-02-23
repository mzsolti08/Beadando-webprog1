<?php require_once "pdo.php";
include "layout/header.php";

$stmt = $db->prepare("SELECT * FROM user WHERE user_id = :id");
$stmt->bindValue(":id", $_SESSION['userID']);
$stmt->execute();
$adat = $stmt->fetch();

$stmtallposts = $db->prepare("SELECT COUNT(posts) FROM forums WHERE user_id = :id");
$stmtallposts->bindValue(':id', $_SESSION['userID']);
$stmtallposts->execute();
$ossz = $stmtallposts->fetch();

?>

<?php if (isset($_SESSION['userID'])): ?>
    <!-- Header része felhasználó fül-->
    </header>
    <div class="container">
        <div class="navigate">
            <span><a href="">Profil</a> >> <?= $adat['user_name']?> >> <a href="./functions/profile_edit.php" style="border: 2px solid #9d29db; padding: 4px">Profil szerkesztése</a></span>
        </div>

        <div class="topic-container">
            <div class="head">
                <div class="authors">Felhasználó</div>
                <!-- <div class="content"></div> -->
            </div>

            <div class="body">
                <div class="authors">
                    <h2 style="margin-bottom: 0; margin-top: 0; font-weight: normal" class="username"><span style="color: #9d29db; font-weight: bold"><?= $adat['user_name']?></span></h2>
                    <h3 style="margin-bottom: 0; margin-top: 0; font-weight: normal">Jogosúltságod: <?php if ($adat['web_admin'] == 1): echo "<span style='color: gray'>Felhasználó</span>"?><?php else: echo "<span style='color: red'>Admin</span>"?><?php endif;?></h3>
                    <br>
                    <h3 style="margin-bottom: 0; margin-top: 0; font-weight: normal">Összes posztod: <u><?= $ossz[0] ?></u></h3>
                </div>
                <div class="content">
                    <h1 style="font-size: 20px">Leírás</h1>
                    <p style="font-size: 22px"><?php if (isset($adat['user_description']) && $adat['user_description'] != "") : echo $adat['user_description'] ?><?php else: echo "Nincs leírása" ?> <?php endif; ?></p>

                    <!--
                        <div class="comment">
                            <button onclick="showComment()">Comment</button>
                        </div>
                    -->
                </div>
            </div>
        </div>

        <div class="comment-area hide" id="comment-area">
            <textarea name="comment" id="" placeholder="comment here ... "></textarea>
            <input type="submit" value="submit">
        </div>
    </div>
<?php else:
    exit("<a href='../forums.php' style='font-size: 25px; float: right'><strong><<</strong> Vissza <strong>>></strong></a>
    <h1 style='text-align: center; font-size: 50px'> Nincs jogosúltságod ehhez az oldalhoz </h1>"); ?>
<?php endif;?>

<?php include "layout/footer.php" ?>