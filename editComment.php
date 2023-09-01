<?php
session_start();
$user_id = isset($_SESSION['user_id']);
// $user_name = $_SESSION['user_name'];

require "./database/bloggin.php";
require "./partials/header.php";
require "./partials/navbar.php";
$date = new DateTime('now');
$now = $date->format("Y-m-d H:i:s");
$post_id = $_GET['post_id'];
$comment_id = $_GET['comment_id'];

$post_readmore_qry = "SELECT * FROM posts INNER JOIN post_categories ON posts.category_id=post_categories.category_id WHERE post_id=:post_id";
$s = $pdo->prepare($post_readmore_qry);
$s->bindParam(":post_id", $post_id, PDO::PARAM_INT);
$s->execute();
$post = $s->fetch();
// print_r($post);
// die();

$joinAdmin_qry = "SELECT * FROM posts LEFT JOIN admins ON posts.admin_id=admins.admin_id  WHERE post_id=:post_id ";
$j = $pdo->prepare($joinAdmin_qry);
$j->bindParam(":post_id", $post_id, PDO::PARAM_INT);
$j->execute();
$admin = $j->fetchAll();
// print_r($admin);
// die();
?>
<!-- comment -->
<div class="Comment px-40 mt-12">
    <!-- edit comment box -->
    <div class="editComment-box" id="editComment_div">
        <div class=" border border-stone-500 rounded shadow">
            <div class="header bg-cyan-900 text-white py-2 px-2.5 text-left ">Edit comment</div>
            <div class="comment-box py-2 px-4">
                <form action="updateComment.php" method="post">
                    <?php
                    $fetchComment_qry = "SELECT * FROM comments WHERE comment_id=:comment_id";
                    $fcqry = $pdo->prepare($fetchComment_qry);
                    $fcqry->bindParam(":comment_id", $comment_id, PDO::PARAM_INT);
                    $fcqry->execute();
                    $fcres = $fcqry->fetch();
                    ?>
                    <input type="hidden" value="<?= $post_id ?>" name="post_id">
                    <input type="hidden" value="<?= $comment_id ?>" name="comment_id">
                    <textarea name="comment" class="py-4 px-2 border border-black rounded w-full block mt-3"><?= $fcres['comment'] ?></textarea>
                    <div class="addComment-btn text-left block w-fit mt-6 mb-2">
                        <button class="bg-blue-600 py-1.5 px-3.5 text-base text-white  text-center rounded cursor-pointer" name="editComment" type="submit">Edit
                            Comment</button>
                        <button class="bg-yellow-500 py-1.5 px-3.5 text-base text-white  text-center rounded cursor-pointer" name="cancelEdit">Cancel
                            Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="readMore-Div px-40 py-10 hidden">
    <div class="bg-white w-full border border-stone-500 w-full p-3.5 rounded shadow">
        <div class="who  flex flex-rows gap-5 items-center justify-start mb-4">
            <div class="icon">
                <i class="fa-solid fa-user bg-grey-200 border border-grey rounded p-2"></i>
            </div>
            <div class="admin">
                <p class="text-sm"><?= $admin[0]['name'] ?></p>
                <p class="text-sm"><?= substr($post['updated_date'], 0, 11) ?></p>
            </div>
        </div>
        <!--Banner image-->
        <img class="rounded-lg w-full mt-4 mb-4" src="./Post_Image/<?= $post['photo'] ?>
                  " />
        <!--Title-->
        <h1 class="font-semibold text-gray-900 leading-none text-base mt-1 capitalize truncate">
            <?= $post['title'] ?>
        </h1>
        <!--Description-->
        <div class="max-w-full mb-5">
            <p class="text-base mt-2 font-medium tracking-wide text-gray-600 mt-1">
                <?= $post['content'] ?>

            </p>
        </div>

        <!-- tags -->
        <div class="tags mt-5">
            <i class="fa-solid fa-tag me-2.5"></i><span class="text-blue-800"> <?= $post['name'] ?>
            </span>
        </div>
        <!-- message,love -->
        <div class="response-box w-full block bg-stone-200 border border-black rounded flex justify-between px-2 py-2 mt-4">
            <div class="message">
                <i class="fa-solid fa-message text-stone-500 me-1 "></i><span class="text-blue-800 text-semibold">(0)</span>
            </div>
            <div class="love">
                <i class="fa-solid fa-heart text-stone-500 me-1 "></i><span class="text-blue-800 text-semibold">(0)</span>
            </div>
        </div>
    </div>

</div>

<?php
require "./partials/footer.php";
?>