<?php

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
};

if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];
} else {
    $category_id = '';
}
require "./database/bloggin.php";
require "./partials/header.php";
require "./partials/navbar.php";
include './partials/likes.php';
?>

<?php
// $select_posts = $pdo->prepare("SELECT * FROM `posts` WHERE category_id = ? and status = ?");
// $select_posts->execute([$category_id, 'active']);
// if ($select_posts->rowCount() > 0) {
//     while ($fetch_posts = $select_posts->fetch(PDO::FETCH_ASSOC)) {

//         $post_id = $fetch_posts['post_id'];

//         $count_post_comments = $pdo->prepare("SELECT * FROM `comments` WHERE post_id = ?");
//         $count_post_comments->execute([$post_id]);
//         $total_post_comments = $count_post_comments->rowCount();

//         $count_post_likes = $pdo->prepare("SELECT * FROM `likes` WHERE post_id = ?");
//         $count_post_likes->execute([$post_id]);
//         $total_post_likes = $count_post_likes->rowCount();

//         $confirm_likes = $conn->prepare("SELECT * FROM `likes` WHERE user_id = ? AND post_id = ?");
//         $confirm_likes->execute([$user_id, $post_id]);


?>




<div class="category-list flex flex-col  items-center justify-start  w-8/12 m-auto shadow border border-black  px-8 py-5 mt-10 pt-9">
    <?php
    $cat_qry = "SELECT * FROM post_categories";
    $c = $pdo->prepare($cat_qry);
    $c->execute();
    $res = $c->fetchAll(PDO::FETCH_ASSOC);
    // print_r($res);
    foreach ($res as $key => $cate) :
    ?>
        <div class="cat flex flex-row items-center justify-start gap-3  w-full " style="margin-top: -18px;">
            <span class="w-fit h-fit bg-neutral-200 py-1.5 rounded px-3 text-black text-base text-left border border-black  block my-5 font-serif">
                <?= ++$key ?></span>
            <span><a class="text-black  text-center hover:text-blue-800 hover:underline cursor-pointer " href="view-postbycate.php?category_id=<?= $cate['category_id'] ?>">
                    <?= $cate['name'] ?></a></span>
        </div>
    <?php endforeach ?>
</div>

<?php
require "./partials/footer.php";
?>