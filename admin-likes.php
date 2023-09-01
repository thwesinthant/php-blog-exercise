<?php
session_start();
$admin = isset($_SESSION['admin']);
if ($admin) {
    $admin_id = $_SESSION['admin_id'];
}

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
};

require "./database/bloggin.php";
require "./partials/header.php";
require "./partials/sidenav.php";
?>
<!-- see post div -->
<div class="col-span-6 bg-slate-50 pe-8 ">
    <h1 class="text-center text-xl text-black-800 font-semibold mt-5 mb-5">Like Posts</h1>
    <!-- post divs-->
    <?php
    // $select_like_post = $pdo->prepare("SELECT * FROM posts WHERE admin_id = ?");
    // $select_like_post->execute([$admin_id]);
    // if ($select_like_post->rowCount() > 0) {
    //     $fetch_profile = $select_like_post->fetch(PDO::FETCH_ASSOC);

    //     $count_user_comments = $pdo->prepare("SELECT * FROM comments WHERE user_id = ?");
    //     $count_user_comments->execute([$user_id]);
    //     $total_user_comments = $count_user_comments->rowCount();

    //     $count_user_likes = $pdo->prepare("SELECT * FROM likes WHERE user_id = ?");
    //     $count_user_likes->execute([$user_id]);
    //     $total_user_likes = $count_user_likes->rowCount();

    $like_post_qry = "SELECT * FROM posts FULL JOIN  likes ON posts.post_id=likes.post_id WHERE admin_id=:admin_id AND like_id!= '' ";
    $l = $pdo->prepare($like_post_qry);
    $l->bindParam(":posts.admin_id", $admin_id, PDO::PARAM_INT);
    $l->execute();
    $Allposts = $l->fetchAll(PDO::FETCH_ASSOC);
    print_r($Allposts);
    die();
    ?>
    <form class="grid grid-cols-3 gap-3" method="post">
        <!-- first post -->
        <?php foreach ($Allposts as $key => $post) : ?>
            <div class=" border border-stone-500 w-full p-3.5 rounded shadow bg-white h-fit">
                <div class="bg-white w-full">
                    <!-- active btn -->
                    <div class=" mb-1.5  w-fit mt-1.5">
                        <button class="bg-orange-500  py-1 px-3 rounded text-white text-base  " style="background-color:<?php if ($value['status'] == 'active') {
                                                                                                                            echo 'limegreen';
                                                                                                                        } else {
                                                                                                                            echo 'bg-orange-400';
                                                                                                                        }; ?>;"><?= $value['status']; ?></button>
                    </div>
                    <!--Banner image-->
                    <img class="rounded-lg w-full mt-0 mb-4 h-60 object-cover" src="./Post_Image/<?= $post['photo'] ?>
                      " />

                    <!--Title-->
                    <h1 class="font-semibold text-gray-900 leading-none text-base mt-1 ">
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

                    <!-- message,love -->
                    <div class="response-box w-full block bg-stone-200 border border-black rounded flex justify-between px-2 py-2 mt-4">
                        <div class="message">
                            <i class="fa-solid fa-message text-stone-500 me-1 "></i><span class="">(0)</span>
                        </div>
                        <div class="love">
                            <i class="fa-solid fa-heart text-stone-500 me-1 "></i><span class="text-blue-800 text-semibold">(0)</span>
                        </div>
                    </div>
                    <!-- edit and delete -->
                    <div class="editDelete-btns text-left block w-full mt-6 gap-2 flex">
                        <a href="edit-posts.php?post_id=<?= $post['post_id'] ?>" class="bg-orange-500 py-1.5 px-3.5 text-sm text-white  text-center rounded w-full">Edit
                        </a>
                        <a href="delete.php?id=<?= $post['post_id'] ?>&tbname=posts&tbid=post_id" class="bg-red-500 py-1.5 px-3.5 text-sm text-white  text-center rounded w-full" onclick="alert('are you sure?')">Delete
                        </a>
                    </div>
                    <!-- view posts btn -->
                    <div class="viewPosts-btns   w-full mt-3 ">
                        <a href="view-post.php?post_id=<?= $post['post_id'] ?>" class="bg-blue-500 py-1.5 px-3.5 text-sm text-white  text-center rounded block w-full" name="viewPost">View
                            Posts
                        </a>
                    </div>
                    <!-- ends of inside elements -->
                </div>
            </div>
        <?php endforeach ?>

    </form>



</div>
</div>
<?php
require "./partials/footer.php";
?>