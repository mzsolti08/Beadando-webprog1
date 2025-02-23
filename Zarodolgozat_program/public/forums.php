<?php require_once "pdo.php";
include "layout/header.php";

$stmt_tema = $db->query("SELECT * FROM topics");
$mindentema = $stmt_tema->fetchAll();

$stmt_ossz_poszt = $db->prepare("SELECT count(posts) FROM forums ");
$stmt_ossz_poszt->execute();
$ossz_poszt = $stmt_ossz_poszt->fetch();

$stmt_ossz_felh = $db->prepare("SELECT count(user_name) FROM user");
$stmt_ossz_felh->execute();
$ossz_felh = $stmt_ossz_felh->fetch();

?>
    </header>

    <div class="container">
        <div class="navigate">
            <span><a href="">Témák</a> >> </span>
        </div>
        <?php for ($i = 0; $i < count($mindentema); $i++): ?>
            <?php
                $stmt_posztok = $db->prepare("SELECT * FROM forums INNER JOIN user ON forums.user_id = user.user_id WHERE topic_id = :tid");
                $stmt_posztok->bindValue(":tid", $mindentema[$i]['topic_id']);
                $stmt_posztok->execute();
                $adat = $stmt_posztok->fetchAll();
            ?>
            <div class="subforum">
                <div class="subforum-title">
                    <h1><?= $mindentema[$i]['forum_type'] ?></h1>
                </div>
                <?php
                foreach ($adat as $item): ?>
                    <?php if ($item['removed_post'] == null): ?>
                        <?php if ($item['removed'] == null): ?>
                            <div class="subforum-row">
                                <div class="subforum-icon subforum-column center">
                                    <i class="fa fa-bookmark center"></i>
                                </div>
                                <div class="subforum-description subforum-column" style="font-size: large">
                                    <h4><a href="./functions/defined_post.php?post=<?= $item['forum_id'] ?>"><?= $item['posts'] ?></a></h4>
                                </div>
                                <div class="subforum-stats subforum-column center">
                                    <b>Posztolta:&nbsp; <a href="./functions/user_show.php?user_id=<?= $item['user_id'] ?>"><?= $item['user_name'] ?></a></b>
                                </div>
                                <div class="subforum-info subforum-column center">
                                    Posztolva lett, ekkor &nbsp;<b><?= $item['create_time'] ?></b>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="subforum-row">
                                <div class="subforum-icon subforum-column center">
                                    <i class="fa fa-bookmark center"></i>
                                </div>
                                <div class="subforum-description subforum-column" style="font-size: large">
                                    <h4><a href="./functions/defined_post.php?post=<?= $item['forum_id'] ?>"><?= $item['posts'] ?></a></h4>
                                </div>
                                <div class="subforum-stats subforum-column center">
                                    <b>Posztolta:&nbsp; <a href=""><span style="color: darkred">Törölt felhasználó</span></a></b>
                                </div>
                                <div class="subforum-info subforum-column center">
                                    Posztolva lett, ekkor &nbsp;<b><?= $item['create_time'] ?></b>
                                </div>
                            </div>
                        <?php endif;?>
                    <?php endif;?>
                <?php endforeach;?>
            </div>
        <?php endfor;?>
    </div>

    <!-- TODO -->
    <div class="forum-info">
        <div class="chart">
Statisztikák &nbsp;<i class="fa fa-bar-chart"></i>
        </div>
        <span><u><?= $ossz_poszt[0] ?></u> Poszt <u><?= count($mindentema) ?></u> Témával <u><?= $ossz_felh[0] ?></u> felhasználó által.</span><br>
        <!-- TODO -->
        <!-- <span><b><a href="">Legújabb poszt</a></b> on Dec 15 2021 By <a href="">RandomUser</a></span>.<br>
        <span>Megtekintés: <a href=""> Poszt neve </a> .</span><br> -->
    </div>

<?php include "layout/footer.php";?>