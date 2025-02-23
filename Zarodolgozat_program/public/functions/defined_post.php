<?php require_once "../pdo.php";
include "../layout/header.php";

$stmt_poszt = $db->prepare("SELECT * FROM forums INNER JOIN user ON forums.user_id = user.user_id INNER JOIN topics ON forums.topic_id = topics.topic_id WHERE forums.forum_id = :forumid");
$stmt_poszt->bindValue("forumid", $_GET['post']);
$stmt_poszt->execute();
$poszt = $stmt_poszt->fetch();

$stmt_felhasznalo = $db->prepare("SELECT * FROM user INNER JOIN forum_comments ON user.user_id = forum_comments.user_id WHERE forum_comments.forum_id = :forumid");
$stmt_felhasznalo->bindValue("forumid", $_GET['post']);
$stmt_felhasznalo->execute();
$felhasznalok = $stmt_felhasznalo->fetchAll();
?>

</header>

<div class="container">
    <div class="navigate">
        <h1 style="text-align: left; font-size: 32px;">
            <span style="color: #9d29db; margin-left: 20px;"><?= $poszt['posts'] ?></span>
            &nbsp;&nbsp;
            <a href="../posts.php" style="float: right; margin-right: 20px; color: #9d29db; font-size: 20px"><strong><<</strong>Vissza<strong>>></strong></a>
        </h1>
        <span style="font-size: 29px; margin-left: 20px">Témája: <?= $poszt['forum_type'] ?></span>
    </div>
    <div class="body">
        <div class="content">
            <?php for($x = 0; $x<count($felhasznalok); $x++):?>
                <?php if(isset($felhasznalok[$x]['comment']) && $felhasznalok[$x]['deleted'] == null):?>
                    <h2>
                        <span style="color: #17A3AC"><?= $felhasznalok[$x]['comment'] ?></span>&nbsp;&nbsp;&nbsp;
                        <span style="float: right">
                            <i class="fa fa-book"></i> Kommentelte:
                            <a href="/functions/user_show.php?user_id=<?= $felhasznalok[$x]['user_id']?>"><?= $felhasznalok[$x]['user_name'] ?></a>&nbsp;
                        </span>
                    </h2>
                <?php endif;?>
            <?php endfor; ?>
            <?php if(isset($_SESSION['userID'])): ?>
                <span style="font-size: 20px"><a href="./create_comment.php?post=<?= $_GET['post'] ?>" style="float: right; border: 2px solid #9d29db; padding: 4px"> Komment írása</a></span>
            <?php endif;?>
        </div>
    </div>
</div>



<?php include "../layout/footer.php" ?>