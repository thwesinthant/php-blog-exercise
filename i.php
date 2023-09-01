<!-- likes.php -->
<?php
require "./database/bloggin.php";
require "./partials/header.php";
require "./partials/navbar.php";
?>
<!-- Each Admin Posts -->
<div class="latest-posts grid grid-cols-12 gap-4 px-40 mb-10 mt-14 " id="post_div">
    <?php
    $admin_id = $_GET['admin_id'];
    $fectchPost_qry = "SELECT * FROM posts INNER JOIN post_categories ON posts.category_id=post_categories.category_id  WHERE admin_id=:admin_id ORDER BY created_date";
    $fqry = $pdo->prepare($fectchPost_qry);
    $fqry->bindParam(":admin_id", $admin_id, PDO::PARAM_INT);
    $fqry->execute();
    $fres = $fqry->fetchAll(PDO::FETCH_ASSOC);
    foreach ($fres as $key => $post) :
    ?>
        <?php
        $joinAdmin_qry = "SELECT * FROM posts LEFT JOIN admins ON posts.admin_id=admins.admin_id WHERE post_id=:post_id  ORDER BY posts.created_date";
        $jqry = $pdo->prepare($joinAdmin_qry);
        $jqry->bindParam("post_id", $post['post_id'], PDO::PARAM_INT);

        $jqry->execute();
        $jres = $jqry->fetch();
        // echo "<pre>";
        // print_r($jres);
        // echo "</pre>";
        // die();

        ?>
        <div class="col-span-6 border border-stone-500 w-full p-3.5 rounded shadow ">
            <div class="bg-white w-full">
                <!-- who -->
                <div class="who  flex flex-rows gap-5 items-center justify-start mb-4">
                    <div class="icon">
                        <i class="fa-solid fa-user bg-grey-200 border border-grey rounded p-2"></i>
                    </div>
                    <div class="admin">
                        <p class="text-sm"><?= $jres['name'] ?></p>
                        <p class="text-sm"><?= substr($post['created_date'], 0, 11) ?></p>
                    </div>
                </div>
                <!--Banner image-->
                <img class="rounded-lg w-full  h-72 object-cover mt-4 mb-4 " src="./Post_Image/<?= $post['photo'] ?>
                  " />
                <!--Title-->
                <h1 class="font-semibold text-gray-900 leading-none text-base mt-1 capitalize truncate">
                    <?= $post['title'] ?>
                </h1>
                <!--Description-->
                <div class="max-w-full mb-5">
                    <p class="text-base mt-2 font-medium tracking-wide text-gray-600 mt-1">
                        <?= substr($post['content'], 0, 100) ?>
                        <?php if (strlen($post['content']) > 100) : ?>
                            ....
                        <?php else : ?>
                        <?php endif ?>
                    </p>
                </div>

                <!-- read more  -->
                <a href="readMore.php?post_id=<?= $post['post_id'] ?>" class="bg-blue-500 hover:bg-slate-700 text-white font-mono text-sm p-2 px-3 rounded w-fit ">Read
                    More</a>
                <!-- tags -->
                <div class="tags mt-5">
                    <i class="fa-solid fa-tag me-2.5"></i><span class=" text-blue-600"><?= $post['name'] ?></span>
                </div>
                <!-- message,love -->
                <div class="response-box w-full block bg-stone-200 border border-black rounded flex justify-between px-2 py-2 mt-4">
                    <div class="message">
                        <i class="fa-solid fa-message text-stone-500 me-1.5 "></i><span class="text-blue-600 text-semibold">(0)</span>
                    </div>
                    <div class="love">
                        <i class="fa-solid fa-heart text-stone-500 me-1 "></i><span class="text-blue-600 text-semibold">(0)</span>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>
<?php
require "./partials/footer.php";
?>

<?php
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
};

require "./database/bloggin.php";
require "./partials/header.php";
require "./partials/navbar.php";
?>
<!-- Post by selected category-->

<div class="flex items-center justify-center ">
    <?php
    $category_id = $_GET['category_id'];
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
            <div class="posts grid grid-cols-12 gap-4 px-40 mb-10 mt-14 " id="post_div">
                <div class="col-span-6 border border-stone-500 w-full p-3.5 rounded shadow ">

                    <div class="bg-white w-full">
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
                        <a href="readMore.php?post_id=<?= $fetch_posts['post_id'] ?>" class="bg-blue-500 hover:bg-slate-700 text-white font-mono text-sm p-2 px-3 rounded w-fit ">Read
                            More</a>
                        <!-- message,love -->
                        <div class="response-box w-full block bg-stone-200 border border-black rounded flex justify-between px-2 py-2 mt-4">
                            <div class="message">
                                <i class="fa-solid fa-message text-stone-500 me-1.5 "></i><span class="text-blue-600 text-semibold">(0)</span>
                            </div>
                            <div class="love">
                                <i class="fa-solid fa-heart text-stone-500 me-1 "></i><span class="text-blue-600 text-semibold">(0)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    <?php
        }
    } else {
        echo '<p class="inline-block m-auto mt-28 w-fit px-28 py-3 border border-stone-800 rounded ">no posts found for this category!</p>';
    }
    ?>
</div>
<?php
require "./partials/footer.php";
?>