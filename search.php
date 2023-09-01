<?php

require './database/bloggin.php';
require './partials/header.php';
$errors = [];

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
};

require "./partials/likes.php";

?>


<?php
if (isset($_POST['search_box']) or isset($_POST['search_btn'])) {
?>
<?php require "./partials/errors.php"; ?>
<div class="latest-posts grid grid-cols-12 gap-8 px-40 mb-20 mt-10" id="post_div">
    <?php
        $search_box = $_POST['search_box'];
        $select_posts = $pdo->prepare("SELECT * FROM posts  LEFT JOIN post_categories ON posts.category_id=post_categories.category_id WHERE title LIKE '%{$search_box}%' AND status = ?");
        $select_posts->execute(['active']);
        if ($select_posts->rowCount() > 0) {
            while ($fetch_posts = $select_posts->fetch(PDO::FETCH_ASSOC)) {
                $fpost_id = $fetch_posts['post_id'];

                $count_post_comments = $pdo->prepare("SELECT * FROM `comments` WHERE post_id = ?");
                $count_post_comments->execute([$fpost_id]);
                $total_post_comments = $count_post_comments->rowCount();

                $count_post_likes = $pdo->prepare("SELECT * FROM `likes` WHERE post_id = ?");
                $count_post_likes->execute([$fpost_id]);
                $total_post_likes = $count_post_likes->rowCount();

                $confirm_likes = $pdo->prepare("SELECT * FROM `likes` WHERE user_id = ? AND post_id = ?");
                $confirm_likes->execute([$user_id, $fpost_id]);
        ?>
    <div class="col-span-6 border border-stone-500 w-full p-3.5 rounded shadow  h-fit ">
        <div class="bg-white w-full">
            <form class="box" method="post">
                <div class="who flex flex-rows gap-5 items-center justify-start mb-4">
                    <div class="icon">
                        <i class="fa-solid fa-user bg-grey-200 border border-grey rounded p-2"></i>
                    </div>
                    <div class="admin">
                        <a class="text-sm text-blue-700"
                            href="view-postbyadmin.php?admin_id=<?= $fetch_posts['admin_id'] ?>"><?= $fetch_posts['name'] ?></a>
                        <p class="text-sm"><?= substr($fetch_posts['created_date'], 0, 11) ?></p>
                    </div>

                </div>
                <input type="hidden" name="post_id" value="<?= $fpost_id; ?>">
                <input type="hidden" name="admin_id" value="<?= $fetch_posts['admin_id']; ?>">
                <!--Banner image-->
                <img class="rounded-lg w-full  h-60 object-cover mt-4 mb-4 " src="./Post_Image/<?= $fetch_posts['photo'] ?>
                              " />
                <!--Title-->
                <h1 class="font-semibold text-gray-900 leading-none text-base mt-1  mb-5">
                    <?= $fetch_posts['title'] ?>
                </h1>
                <!--Description-->
                <div class="max-w-full mb-5">
                    <p class="text-base mt-2 font-medium tracking-wide text-gray-600 mt-1">
                        <?= substr($fetch_posts['content'], 0, 100) ?>
                        <?php if (strlen($fetch_posts['content']) > 100) : ?>
                        ....
                        <?php else : ?>
                        <?php endif ?>
                    </p>
                </div>
                <!-- read more  -->
                <a href="readMore.php?post_id=<?= $fetch_posts['post_id'] ?>"
                    class="bg-blue-500 hover:bg-slate-700 text-white font-mono text-sm p-2 px-3 rounded w-fit ">Read
                    More</a>
                <!-- tags -->
                <div class="tags mt-5">
                    <i class="fa-solid fa-tag me-2.5"></i><span class="text-cyan-700"><?= $fetch_posts['name'] ?></span>
                </div>
                <!-- form -->
                <form method="post"
                    class="response-box  w-full block bg-stone-200 border border-black rounded flex justify-between px-2 py-2 mt-4">
                    <input type="hidden" name="user_id" value="<?= $user_id ?>">
                    <input type="hidden" name="post_id" value="<?= $homePosts['post_id']; ?>">
                    <input type="hidden" name="admin_id" value="<?= $homePosts['admin_id']; ?>">
                    <div
                        class="icon-box  w-full block bg-stone-200 border border-black rounded flex justify-between px-4 py-2 mt-4">
                        <div class="message">
                            <a href="readMore.php?post_id=<?= $homePosts['post_id'] ?>"><i
                                    class="fa-solid fa-message text-stone-500 me-1"></i><span
                                    class="text-blue-600 ">(<?= $total_post_comments; ?>)</span></a>
                        </div>
                        <div class="love">
                            <button type="submit" name="like_post"><i class="fas fa-heart me-1 "
                                    style="<?php if ($confirm_likes->rowCount() > 0) {
                                                                                                                        echo 'color:red !important;';
                                                                                                                    } ?>"></i><span
                                    class="text-blue-600 ">(<?= $total_post_likes; ?>)</span></button>
                        </div>
                    </div>
                </form>
        </div>
    </div>
    <?php } ?>
    <?php } else {
           echo $errors = "No result found 🙁";
            // echo "<p class='col-span-12 w-100vh h-100vh m-auto mt-20'>No results 🙁 </p>";
            header('location:blogo.php');
        } ?>

</div>
<?php
} else {
    echo '';
}
?>
<?php require './partials/footer.php'; ?>