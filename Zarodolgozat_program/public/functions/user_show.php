<?php require_once "../pdo.php";
include "../layout/header.php";

$stmt_user = $db->prepare("SELECT * FROM user WHERE user_id = :id");
$stmt_user->bindValue(':id', $_GET['user_id']);
$stmt_user->execute();
$user = $stmt_user->fetch();

$stmt_userPosts = $db->prepare("SELECT * FROM forums WHERE user_id = :id");
$stmt_userPosts->bindValue(':id', $_GET['user_id']);
$stmt_userPosts->execute();
$userPosts = $stmt_userPosts->fetchAll();

$stmtallposts = $db->prepare("SELECT COUNT(posts) FROM forums WHERE user_id = :id");
$stmtallposts->bindValue(':id', $_GET['user_id']);
$stmtallposts->execute();
$ossz = $stmtallposts->fetch();

?>

    </header>
    <div class="container">
        <div class="navigate">
            <div class="topic-container">
                <div class="head">
                    <div class="authors">
                        <h1 style="font-size: large; text-align: center; "><span style="color: #9d29db; text-transform: uppercase"><?= $user['user_name']?></span> Profilja</h1>
                    </div>
                </div>
                <div class="body">
                    <div class="authors">
                        <h4 style="margin-bottom: 0">Statisztikák:</h4>
                        <p>Jogosúltsága: <?php if ($user['web_admin'] == 1): echo "<span style='color: gray'>Felhasználó</span>"?><?php else: echo "<span style='color: red'>Admin</span>"?><?php endif;?></p>
                        <p style="margin-bottom: 0">Posts: <u><?= $ossz[0] ?></u></p>
                        <!-- <p style="margin-bottom: 0">Points: <u></u></p> -->
                    </div>
                    <div class="content">
                        <h3><?= $user['user_name'] ?> lerírása:</h3><p> <?php if (isset($user['user_description']) && $user['user_description'] != "") : echo $user['user_description'] ?><?php else: echo "Nincs leírása" ?> <?php endif; ?></p>
                    </div>
                </div>
                <div class="body">
                    <div class="content">
                        <div class="table-head">
                        Posztjai:
                        </div>
                        <?php $sorszam = 1 ?>
                        <?php foreach ($userPosts as $posts): ?>
                            <div class="table-row" style="margin-left: 20px">
                                <?php if (isset($posts['posts'])) : echo $sorszam . ".&nbsp;&nbsp;" . "<a href='defined_post.php?post=" . $posts['forum_id'] .  "' style='color: darkslateblue'>" . $posts['posts'] ."</a>"; $sorszam += 1?><?php else: echo "Jelenleg nincs a felhasználónak posztja" ?> <?php endif; ?>
                            </div>
                        <?php endforeach;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include "../layout/footer.php";
