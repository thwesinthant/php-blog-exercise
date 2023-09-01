<?php
session_start();
$user = isset($_SESSION['user']);
if ($user) {
    $user_id = $_SESSION['user_id'];
}

$admin = isset($_SESSION['admin']);
if ($admin) {
    $admin_id = $_SESSION['admin_id'];
}

require "./database/bloggin.php";
require "./partials/header.php";
require "./partials/sidenav.php";

$post_id = $_GET['post_id'];
$post_qry = "SELECT * FROM posts WHERE post_id=:post_id";
$p = $pdo->prepare($post_qry);
$p->bindParam(":post_id", $post_id, PDO::PARAM_INT);
$p->execute();
$Allposts = $p->fetchAll(PDO::FETCH_ASSOC);
?>
<!-- see post div -->
<div class="col-span-6 bg-slate-50 pe-8 mb-8 ">


    <form class="grid grid-cols-1 gap-3" method="post">

        <?php foreach ($Allposts as $key => $post) : ?>
            <div class=" border border-stone-500 w-full p-3.5 rounded shadow bg-white h-fit mt-5">
                <div class="bg-white w-full">
                    <!-- active btn -->
                    <div class="btn mb-3 status">
                        <button class="bg-orange-500  py-1 px-3 rounded text-white text-base" style="background-color:<?php if ($post['status'] == 'active') {
                                                                                                                            echo 'limegreen';
                                                                                                                        } else {
                                                                                                                            echo 'bg-orange-400';
                                                                                                                        }; ?>;"><?= $post['status']; ?></button>
                    </div>
                    <!--Banner image-->
                    <img class="rounded-lg w-full mt-0 mb-5 h-fit object-cover" src="./Post_Image/<?= $post['photo'] ?>
                      " />

                    <!--Title-->
                    <h1 class="font-semibold text-gray-900 leading-none text-base mt-2.5 ">
                        <?= $post['title'] ?>
                    </h1>
                    <!--Description-->
                    <div class="max-w-full mb-5">
                        <p class="text-base mt-2 font-medium tracking-wide text-gray-600 mt-1">
                            <?= $post['content'] ?>

                        </p>
                    </div>

                    <!-- message,love -->
                    <div class="response-box w-full block bg-stone-200 border border-black rounded flex justify-between px-2 py-3 mt-4">
                        <div class="message">
                            <i class="fa-solid fa-message  text-stone-500 text-lg me-2 "></i><span class="text-lg">(0)</span>
                        </div>
                        <div class="love">
                            <i class="fa-solid fa-heart text-stone-500 me-2 text-lg"></i><span class="text-blue-800 text-semibold text-lg">(0)</span>
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