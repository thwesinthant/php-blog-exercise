<?php
session_start();
$admin = $_SESSION['admin'];
$admin_name = isset($_SESSION['admin_name']);
$admin_id = $_SESSION['admin_id'];

require "./database/bloggin.php";
require "./partials/header.php";
require "./partials/sidenav.php";
?>
<div class=" col-span-6">
    <div class="title w-full block pe-5 ">
        <h1 class=" text-center text-xl text-black-800 mt-5 ">Admin Accounts</h1>
    </div>
    <div class="flex flex-row justify-center    bg-slate-50 pe-20 grid grid-cols-3 ps-10 gap-6">
        <div class="input w-64 mt-14 bg-white border border-1 border-black px-3 py-3 rounded flex flex-col justify-center items-center h-fit ">
            <h1 class="text-center text-lg mb-1 ">register new admin</h1>
            <div class="update-profle mt-2 m-auto flex justify-center w-full">
                <a href="admin-register.php" class="button w-60 bg-blue-500 p-2 rounded px-4 text-white text-sm text-center ">
                    Register</a>
            </div>
        </div>
        <!-- log in admin  -->
        <div class="input w-64 mt-14  bg-white border border-1 border-black px-0 py-3 rounded flex flex-col justify-center items-center h-fit ">
            <p>admin id : <?= $_SESSION['admin_id'] ?></p>
            <p>username : <?= $_SESSION['admin_name'] ?></p>
            <?php
            $totalpost_count_qry = "SELECT * FROM posts WHERE admin_id=:admin_id";
            $tcq = $pdo->prepare($totalpost_count_qry);
            $tcq->bindParam("admin_id", $admin_id, PDO::PARAM_INT);
            $tcq->execute();
            $tcres = $tcq->fetchAll(PDO::FETCH_ASSOC);
            // echo "<pre>";
            // print_r($tcres);
            // echo "</pre>";
            // die();
            ?>
            <p>total posts : <?= count($tcres) ?></p>
            <div class="add-post mt-3 m-auto flex  flex-row justify-center w-full gap-2 px-3">
                <a href="update-adminProfile.php" class="button w-full  h-fit bg-orange-400 p-2 rounded px-7 text-white text-sm text-center ">Update</a>
                <a href="add-post.php" class="button w-full h-fit bg-red-400 p-2 rounded px-7 text-white text-sm whitespace-nowrap text-center ">
                    Delete</a>
            </div>
        </div>
        <!-- other admins -->
        <?php
        $select_account = $pdo->prepare("SELECT * FROM admins WHERE admin_id!=:admin_id");
        $select_account->bindParam("admin_id", $admin_id, PDO::PARAM_INT);
        $select_account->execute();
        if ($select_account->rowCount() > 0) {
            while ($fetch_accounts = $select_account->fetch(PDO::FETCH_ASSOC)) {
                $count_admin_posts = $pdo->prepare("SELECT * FROM `posts` WHERE admin_id = ?");
                $count_admin_posts->execute([$fetch_accounts['admin_id']]);
                $total_admin_posts = $count_admin_posts->rowCount();
        ?>

                <div class="other-admins bg-white border border-1 border-black px-10 py-5 rounded  flex flex-col justify-center items-center h-fit mt-14">
                    <p>admin id: <?= $fetch_accounts['admin_id']; ?></p>
                    <p>username : <?= $fetch_accounts['name']; ?></p>
                    <p>total posts : <?= $total_admin_posts;  ?></p>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
</div>


<?php
require "./partials/footer.php";
?>