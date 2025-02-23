<?php require_once "../pdo.php";
include "../layout/header.php";

$stmt_topic = $db->query("SELECT * FROM topics");
$stmt_topic->execute();
$temak = $stmt_topic->fetchAll();

if (isset($_POST['create_post'])){
    $error = [];
    if(!isset($_POST["post_name"]) || $_POST["post_name"] == "" || strlen($_POST["post_name"]) > 500){
        $error[]= "A poszt neve nem lett helyesen megadva!";
    }
    if(count($error) > 0){
        if ($error[0]){
            echo $error[0];
        }
        exit;
    }
    $stmt = $db->prepare("INSERT INTO forums (user_id, topic_id, posts, create_time) VALUE (:user_id, :topic_id, :posts, :create_time)");
    $stmt->bindValue(":user_id", $_SESSION['userID']);
    $stmt->bindValue(":topic_id", $_POST['temak_form']);
    $stmt->bindValue(':posts', $_POST['post_name']);
    $datum = date("Y-m-d h:i:s");
    $stmt->bindValue(':create_time', $datum);
    $stmt->execute();

    if( $stmt_topic->execute() )
    {
        echo "Sikeresen létre lett hozva a posztod!";
    }
    else{
        die("Nem sikerült létrehozni a posztot");
    }
}
?>

</header>
<form method="post" action="create_post.php">
    <div class="container">
        <div class="subforum">
            <div class="subforum-title">
                <h1><span style="margin-left: 20px; font-size: 24px">Poszt létrehozása</span> <a href="../posts.php" style="float: right; margin-right: 20px; font-size: 20px"><strong><<</strong> Vissza <strong>>></strong></a></h1>
            </div>
            <div class="subforum-row" style="grid-template-columns: 33% 33% 33%">
                <div class="subforum-description subforum-column center">
                    <textarea name="post_name" id="post_name" placeholder="Poszt (maximum 500 karakter)" style="width: 100%;"></textarea>
                </div>
                <div class="subforum-description subforum-column center">
                    <select name="temak_form">
                        <?php foreach ($temak as $tema): ?>
                            <option value="<?= $tema['topic_id'] ?>" ><?= $tema['forum_type'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="subforum-description subforum-column center">
                    <input type="submit" name="create_post" value="Létrehozás" style="width: 40%; height: 32px">
                </div>
            </div>
        </div>
    </div>
</form>
<?php include "../layout/footer.php" ?>