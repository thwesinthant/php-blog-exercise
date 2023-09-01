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
require "./partials/likes.php";

?>
<!-- Post by selected category-->

<div class="posts grid grid-cols-12 gap-4 px-40 mb-10 mt-14 " id="post_div">
    <?php
    $select_posts = $pdo->prepare("SELECT * FROM `posts` WHERE category_id = ? and status = ?");
    $select_posts->execute([$category_id, 'active']);
    if ($select_posts->rowCount() > 0) {
        while ($fetch_posts = $select_posts->fetch(PDO::FETCH_ASSOC)) {
            $post_id = $fetch_posts['post_id'] ?? "";

            $count_post_comments = $pdo->prepare("SELECT * FROM `comments` WHERE post_id = ?");
            $count_post_comments->execute([$post_id]);
            $total_post_comments = $count_post_comments->rowCount();

            $count_post_likes = $pdo->prepare("SELECT * FROM `likes` WHERE post_id = ?");
            $count_post_likes->execute([$post_id]);
            $total_post_likes = $count_post_likes->rowCount();

            $confirm_likes = $pdo->prepare("SELECT * FROM `likes` WHERE user_id = ? AND post_id = ?");
            $confirm_likes->execute([$user_id, $post_id]);

            $joinAdmin_qry = "SELECT * FROM posts LEFT JOIN admins ON posts.admin_id=admins.admin_id WHERE post_id=:post_id  ORDER BY posts.updated_date";
            $jqry = $pdo->prepare($joinAdmin_qry);
            $jqry->bindParam("post_id", $post_id, PDO::PARAM_INT);
            $jqry->execute();
            $jres = $jqry->fetch();
    ?>
    <form class="col-span-6 border border-stone-500 w-full p-3.5 rounded shadow " action="" method="post">
        <div class="bg-white w-full">
            <input type="hidden" name="user_id" value="<?= $user_id ?>">
            <input type="hidden" name="post_id" value="<?= $fetch_posts['post_id']; ?>">
            <input type="hidden" name="admin_id" value="<?= $fetch_posts['admin_id']; ?>">
            <!-- who -->
            <div class="who  flex flex-rows gap-5 items-center justify-start mb-4">
                <div class="icon">
                    <i class="fa-solid fa-user bg-grey-200 border border-grey rounded p-2"></i>
                </div>
                <div class="admin">
                    <p class="text-sm"><?= $jres['name'] ?></p>
                    <p class="text-sm"><?= substr($jres['updated_date'], 0, 11) ?></p>
                </div>
            </div>
            <!--Banner image-->
            <img class="rounded-lg w-full  h-72 object-cover mt-4 mb-4 " src="./Post_Image/<?= $fetch_posts['photo'] ?>
                  " />
            <!--Title-->
            <h1 class="font-semibold text-gray-900 leading-none text-base mt-1 capitalize truncate">
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
            <!-- message,love -->

            <div
                class="response-box w-full block bg-stone-200 border border-black rounded flex justify-between px-2 py-2 mt-4">
                <div class="message">
                    <a href="readMore.php?post_id=<?= $fetch_posts['post_id'] ?>"><i
                            class="fa-solid fa-message text-stone-500 me-1"></i><span
                            class="text-blue-600 ">(<?= $total_post_comments; ?>)</span></a>
                </div>
                <div class="love">
                    <button type="submit" name="like_post"><i class="fas fa-heart me-1 " style="<?php if ($confirm_likes->rowCount() > 0) {
                                                                                                            echo 'color:red !important;';
                                                                                                        } ?>"></i><span
                            class="text-blue-600 ">(<?= $total_post_likes; ?>)</span></button>
                </div>
            </div>
        </div>
    </form>
    <?php
        }
    } else {
        echo '<p class="inline-block col-span-12 w-full text-center  mt-28 w-fit px-28 py-3 border border-white-800 rounded shadow bg-blue-400 text-white text-bold ">no posts found for this category !</p>';
    }
    ?>
</div>
<?php
require "./partials/footer.php";
?>