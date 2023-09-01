<?php
session_start();
require "./database/bloggin.php";
require "./partials/header.php";
require "./partials/sidenav.php";


$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
}

?>
<!-- users accounts section starts  -->

<section class="accounts">

    <h1 class="heading">users account</h1>

    <div class="box-container">

        <?php
        $select_account = $pdo->prepare("SELECT * FROM `users`");
        $select_account->execute();
        if ($select_account->rowCount() > 0) {
            while ($fetch_accounts = $select_account->fetch(PDO::FETCH_ASSOC)) {
                $user_id = $fetch_accounts['user_id'];
                $count_user_comments = $pdo->prepare("SELECT * FROM `comments` WHERE user_id = ?");
                $count_user_comments->execute([$user_id]);
                $total_user_comments = $count_user_comments->rowCount();
                $count_user_likes = $pdo->prepare("SELECT * FROM `likes` WHERE user_id = ?");
                $count_user_likes->execute([$user_id]);
                $total_user_likes = $count_user_likes->rowCount();
        ?>
        <div class="box">
            <p> users id : <span><?= $user_id; ?></span> </p>
            <p> username : <span><?= $fetch_accounts['name']; ?></span> </p>
            <p> total comments : <span><?= $total_user_comments; ?></span> </p>
            <p> total likes : <span><?= $total_user_likes; ?></span> </p>
        </div>
        <?php
            }
        } else {
            echo '<p class="empty">no accounts available</p>';
        }
        ?>

    </div>

</section>
<div class=" col-span-6">
    <div class="title w-full block pe-5 ">
        <h1 class=" text-center text-xl text-black-800 mt-5 ">User Accounts</h1>
    </div>
    <div class="flex flex-row justify-center  bg-slate-50 pe-20 grid grid-cols-3 ps-10 gap-6">
        <!-- users -->
        <?php
        $select_account = $pdo->prepare("SELECT * FROM `users`");
        $select_account->execute();
        if ($select_account->rowCount() > 0) {
            while ($fetch_accounts = $select_account->fetch(PDO::FETCH_ASSOC)) {
                $user_id = $fetch_accounts['user_id'];
                $count_user_comments = $pdo->prepare("SELECT * FROM `comments` WHERE user_id = ?");
                $count_user_comments->execute([$user_id]);
                $total_user_comments = $count_user_comments->rowCount();
                $count_user_likes = $pdo->prepare("SELECT * FROM `likes` WHERE user_id = ?");
                $count_user_likes->execute([$user_id]);
                $total_user_likes = $count_user_likes->rowCount();
        ?>

        <div
            class="other-admins bg-white border border-1 border-black px-10 py-5 rounded  flex flex-col justify-center items-center h-fit mt-14">
            <p>admin id: <?= $fetch_accounts['admin_id']; ?></p>
            <p>username : <?= $fetch_accounts['name']; ?></p>
            <p>total posts : <?= $total_admin_posts;  ?></p>
        </div>
        <?php } ?>
        <?php } ?>
    </div>
</div>
<!-- users accounts section ends -->
<?php require "./partials/footer.php"; ?>