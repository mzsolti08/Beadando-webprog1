<?php require_once "pdo.php";
include "layout/header.php";
$pageNumber = 1;
$stmt = $db->prepare("SELECT * FROM ((forums INNER JOIN user ON forums.user_id = user.user_id) INNER JOIN topics ON forums.topic_id = topics.topic_id)");
$stmt->execute();
$sor = $stmt->rowCount();
$posztok = $stmt->fetchAll();
if(isset($_GET['page'])){
    $pageNumber = $_GET['page'];
}

$poszt_kereses_cimek = null;
$poszt_kereses_kommentek = null;
if (isset($_POST['kereses'])){
    $stmt = $db->prepare("SELECT * FROM ((forums INNER JOIN user ON forums.user_id = user.user_id) INNER JOIN topics ON forums.topic_id = topics.topic_id) WHERE posts LIKE :poszt");
    $stmt->execute(array(':poszt' => '%'.$_POST['kereses_text'].'%'));
    $sor = $stmt->rowCount();
    $posztok = $stmt->fetchAll();
}
?>
    <!-- Header része posztok fül-->
        <div class="search-box" style="border: solid 1px #9d29db; box-shadow:1px 2px 3px #9d29db; ">
            <div>
                <form method="post" action="posts.php">
                    <label style="font-size: 22px;">Poszt címének keresése:&nbsp;&nbsp;</label>
                    <input type="text" name="kereses_text" id="kereses_text" placeholder="keresés ...">
                    <button type="submit" name="kereses" id="kereses"><i class="fa fa-search"></i></button>
                </form>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="navigate">
            <span><a href="">Posztok</a> >> </span>
            <?php if (isset($_SESSION['userID'])): ?>
            <span><a href="./functions/create_post.php" style="border: 2px solid #9d29db; padding: 4px">Poszt létrehozása</a></span>
            <?php endif; ?>
        </div>
        <div class="posts-table">
            <div class="table-head">
                <div class="status">Státusza</div>
                <div class="subjects">Poszt</div>
                <div class="replies">Válaszok és Téma</div>
                <div class="last-reply">Létrehozva</div>
            </div>
            <?php if ($poszt_kereses_cimek == null || $poszt_kereses_kommentek == null) : ?>
                <?php for($i = ($pageNumber-1)*10; $i < $sor && $i < ($pageNumber*10); $i++): ?>
                <?php
                    $dateLine = explode(" ",$posztok[$i]['create_time']);
                    $date_year = explode("-",$dateLine[0]);
                    $date_hour = explode(".", $dateLine[1]);
                    $stmt_komment = $db->prepare("SELECT COUNT(comment_id) FROM forum_comments WHERE forum_id = :fid");
                    $stmt_komment->bindValue(":fid", $posztok[$i]['forum_id']);
                    $stmt_komment->execute();
                    $komment = $stmt_komment->fetch();
                    ?>

                    <?php if ($posztok[$i]['removed_post'] == null): ?>
                        <?php if ($posztok[$i]['removed'] == null): ?>
                            <div class="table-row">
                                <!-- <div class="status"><i class="fa fa-fire"></i></div> -->
                                <?php if ($komment["COUNT(comment_id)"] <= 5) : ?>
                                    <div class="status"><i class="fa fa-battery-1"></i></div>
                                <?php elseif ($komment["COUNT(comment_id)"] >= 6 && $komment["COUNT(comment_id)"] <= 15): ?>
                                    <div class="status"><i class="fa fa-battery-2"></i></div>
                                <?php elseif ($komment["COUNT(comment_id)"] >= 16 && $komment["COUNT(comment_id)"] <= 25): ?>
                                    <div class="status"><i class="fa fa-battery-3"></i></div>
                                <?php elseif ($komment["COUNT(comment_id)"] >= 26): ?>
                                    <div class="status"><i class="fa fa-battery-4"></i></div>
                                <?php endif; ?>
                                <div class="subjects">
                                    <a href="./functions/defined_post.php?post=<?= $posztok[$i]['forum_id'] ?>"><?= $posztok[$i]['posts']?></a>
                                    <br>
                                    <span>Elkészítette <b><a href="./functions/user_show.php?user_id=<?= $posztok[$i]['user_id']?>"><?= $posztok[$i]['user_name'] ?></a></b></span>
                                </div>
                                <div class="replies">
                                    <?= $komment["COUNT(comment_id)"] ?> komment <br> <span style="color: #9d29db"><?= $posztok[$i]['forum_type'] ?></span>
                                </div>

                                <div class="last-reply">
                                    <?= $date_year[0].".".$date_year[1].".".$date_year[2]." - ".$date_hour[0] ?>
                                    <br><b><?= $posztok[$i]['user_name'] ?> </b>által
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="table-row">
                                <!-- <div class="status"><i class="fa fa-fire"></i></div> -->
                                <?php if ($komment["COUNT(comment_id)"] <= 5) : ?>
                                    <div class="status"><i class="fa fa-battery-1"></i></div>
                                <?php elseif ($komment["COUNT(comment_id)"] >= 6 && $komment["COUNT(comment_id)"] <= 15): ?>
                                    <div class="status"><i class="fa fa-battery-2"></i></div>
                                <?php elseif ($komment["COUNT(comment_id)"] >= 16 && $komment["COUNT(comment_id)"] <= 25): ?>
                                    <div class="status"><i class="fa fa-battery-3"></i></div>
                                <?php elseif ($komment["COUNT(comment_id)"] >= 26): ?>
                                    <div class="status"><i class="fa fa-battery-4"></i></div>
                                <?php endif; ?>
                                <div class="subjects">
                                    <a href="./functions/defined_post.php?post=<?= $posztok[$i]['forum_id'] ?>"><?= $posztok[$i]['posts']?></a>
                                    <br>
                                    <span>Elkészítette <b><a href=""><span style="color: darkred">Törölt felhasználó</span></a></b></span>
                                </div>
                                <div class="replies">
                                    <?= $komment["COUNT(comment_id)"] ?> komment <br> <span style="color: #9d29db"><?= $posztok[$i]['forum_type'] ?></span>
                                </div>

                                <div class="last-reply">
                                    <?= $date_year[0].".".$date_year[1].".".$date_year[2]." - ".$date_hour[0] ?>
                                    <br><b><span style="color: darkred">Törölt felhasználó</span> </b>által
                                </div>
                            </div>
                        <?php endif;?>
                    <?php endif;?>
                <?php endfor;?>
            <?php endif; ?>

        </div>
        <?php if($sor > 10):?>
            <div class="pagination">
                Oldalak:
                <?php for ($a = 1; $a <= ceil($sor/10); $a++):?>
                <a href="./posts.php?page=<?=$a?>"><?=$a?></a>
                <?php endfor;?>
            </div>
        <?php endif;?>
    </div>

    <div class="note">
        <!-- <i class="fa fa-frown-o"></i> -->
        <!-- <?php if (isset($_SESSION['userID'])): ?> /detail.php <?php endif; ?> -->
        <span>Profilod</span>&nbsp;&nbsp;&nbsp;<a href="<?php if (isset($_SESSION['userID'])): ?> /detail.php <?php endif; ?>"><i class="fa fa-share-square"></i></a><br>
    </div>
<?php include "layout/footer.php" ?>