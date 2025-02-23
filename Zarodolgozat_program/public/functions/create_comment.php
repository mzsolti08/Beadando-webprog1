<?php require_once "../pdo.php";
include "../layout/header.php";

if (isset($_POST['create_comment'])) {
    $error = [];
    if (!isset($_POST["comment"]) || $_POST["comment"] == "" || strlen($_POST["comment"]) > 500) {
        $error[] = "A komment nem lett helyesen megadva!";
    }
    if (count($error) > 0) {
        if ($error[0]) {
            echo $error[0];
        }
        exit;
    }
    $stmt = $db->prepare("INSERT INTO forum_comments (forum_id, user_id, comment) VALUE (:forumid, :userid, :comment)");
    $stmt->bindValue(':forumid', $_GET['post']);
    $stmt->bindValue(':userid', $_SESSION['userID']);
    $stmt->bindValue(':comment', $_POST['comment']);
    if( $stmt->execute() )
    {
        echo "Sikeresen létre lett hozva a kommented!";
        header('Location: /functions/defined_post.php?post='.$_GET['post']);
    }
    else{
        die("Nem sikerült létrehozni a kommented");
    }
}

?>


<?php if (isset($_SESSION['userID'])): ?>
    </header>
    <form method="post" action="create_comment.php?post=<?= $_GET['post'] ?>">
        <div class="container">
            <div class="subforum">
                <div class="subforum-title">
                    <h1 style="font-size: 24px">Komment írása <a href="defined_post.php?post=<?= $_GET['post'] ?>" style="float: right; margin-right: 20px; font-size: 20px"> <strong><<</strong> Vissza <strong>>></strong></a></h1>
                </div>
                <div class="subforum-row" style="grid-template-columns: 100%">
                    <div class="subforum-description subforum-column center">
                        <textarea name="comment" id="comment" placeholder="Kommented ide tudod írni (maximum 500 karakter)" style="width: 50%; height: 200px"></textarea>
                    </div>
                </div>
                <div class="subforum-row" style="grid-template-columns: 100%">
                    <div class="subforum-description subforum-column center">
                        <input type="submit" name="create_comment" value="Létrehozás" style="width: 20%; height: 32px">
                    </div>
                </div>
            </div>
    </form>


<?php else:
exit("<a href='../forums.php' style='font-size: 25px; float: right'><strong><<</strong> Vissza <strong>>></strong></a>
    <h1 style='text-align: center; font-size: 50px'> Nincs jogosúltságod ehhez az oldalhoz </h1>"); ?>
<?php endif;?>


<?php include "../layout/footer.php";
