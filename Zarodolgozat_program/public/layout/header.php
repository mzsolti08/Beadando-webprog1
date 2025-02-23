<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Játékokról általában</title>
    <link rel="icon" href="../imgs/a_icon.png">

    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../public/css/styles.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Titillium+Web:ital@1&display=swap" rel="stylesheet">
</head>
<body>
<header>
    <?php
    if (isset($_SESSION['userID'])){
        $stmt = $db->prepare("SELECT * FROM user WHERE user_id = :user_id");
        $stmt->bindValue(":user_id", $_SESSION['userID']);
        $stmt->execute();
        $user = $stmt->fetch();

        $stmt_admin_check = $db->prepare("SELECT * FROM user WHERE web_admin = 2");
        $stmt_admin_check->execute();
        $admin = $stmt_admin_check->fetch();
    }
    ?>
    <?php //if (isset($_SESSION)){ var_dump($_SESSION);}  ?>
    <div class="navbar">
        <!-- <nav class="navigation hide" id="navigation"> -->
            <!-- <span class="close-icon" id="close-icon" onclick="showIconBar()"><i class="fa fa-close"></i></span> -->
            <ul class="nav-list">
                <li class="nav-item"><a href="../public/forums.php" class="nav-link">Témák</a></li>
                <li class="nav-item"><a href="../public/posts.php" class="nav-link">Posztok</a></li>
                <?php if (isset($_SESSION['userID'])): ?>
                    <?php if ($user['web_admin'] == 2): ?>
                    <li class="nav-item"><a href="../public/functions/admin.php?admin_id=<?= $admin['user_id'] ?>">Admin</a></li>
                    <?php endif; ?>
                    <li class="nav-item"><a href="../public/detail.php">Felhasználó</a></li>
                <?php endif;?>
                <?php if (isset($_SESSION['userID']) == null):?>
                <li class="nav-item"><a href="../reg/register.php" style="color: #9d29db">Regisztráció</a></li>
                <li class="nav-item"><a href="../reg/login.php" style="color: #9d29db">Belépés</a></li>
                <?php endif;?>
                <?php if (isset($_SESSION['userID'])): ?>
                    <li class="nav-item"><a href="../reg/logout.php" style="color: #9d29db">Kijelentkezés</a></li>
                <?php endif;?>
            </ul>
        <!-- </nav> -->
        <a class="bar-icon" id="iconBar" onclick="hideIconBar()"><i class="fa fa-bars"></i></a>
        <div class="brand">about games</div>
    </div>