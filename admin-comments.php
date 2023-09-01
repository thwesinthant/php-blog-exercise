<?php
session_start();
$admin = isset($_SESSION['admin']);
if ($admin) {
    $admin_id = $_SESSION['admin_id'];
}

require "./partials/header.php";
require "./database/bloggin.php";
require "./partials/sidenav.php";


if (isset($_POST['delete_comment'])) {
    $comment_id = $_POST['comment_id'];
    $comment_id = filter_var($comment_id, FILTER_SANITIZE_STRING);
    $delete_comment = $pdo->prepare("DELETE FROM `comments` WHERE comment_id = ?");
    $delete_comment->execute([$comment_id]);
    // $message[] = 'comment delete!';
}
if (isset($_POST['delete_comment'])) {
    $comment_id = $_POST['comment_id'];
    $delete_comment = $pdo->prepare("DELETE FROM `comments` WHERE comment_id = ?");
    $delete_comment->execute([$comment_id]);
    $message[] = 'comment delete!';
}
?>
<div class="col-span-6 w-full block ">
    <div class="postComment pe-10 mt-5 mb-10 ">

        <h1 class="text-center text-2xl mb-5">Post Comments</h1>

        <!-- fetch comment div -->
        <div class="comment-div border border-stone-500 mt-5 rounded shadow">
            <div class="header bg-cyan-900 text-white text-lg py-2.5 px-2.5 text-left ">post comments</div>
            <!-- show comment section -->
            <div class="mt-5 mb-10">
                <div class="border border-2 border-stone-700 rounded shadow mx-5 bg-stone-100 py-1.5 pb-0 px-2">
                    <?php
                    $select_comments = $pdo->prepare("SELECT * FROM comments WHERE admin_id= ?");
                    $select_comments->execute([$admin_id]);
                    if ($select_comments->rowCount() > 0) :
                        while ($fetch_comments = $select_comments->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <?php
                            $post_id = $fetch_comments['post_id'];
                            $select_posts = $pdo->prepare("SELECT * FROM posts WHERE post_id= ? ");
                            $select_posts->execute([$post_id]);
                            if ($select_posts->rowCount() > 0) {
                                while ($fetch_posts = $select_posts->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                    <div class="comment-box py-1 px-4 mb-6 ">
                        <!-- user comment box -->
                        <div class="post-title text-lg mb-2"> From : <span
                                class="text-lg font-semibold"><?= $fetch_posts['title']; ?></span> <a
                                href="view-post.php?post_id=<?= $fetch_posts['post_id']; ?>"
                                class="text-blue-600  hover:underline hover:text-black ms-2 text-base">view
                                post</a></div>
                        <div class=" comment-user flex flex-rows gap-4 items-center justify-start mb-4">
                            <div class="icon">
                                <i
                                    class="fa-solid fa-user bg-white border border border-2 px-3 border-stone-700 rounded p-2 text-base"></i>
                            </div>
                            <div class="user">
                                <p class=" text-lg text-blue-600"><?= $fetch_comments['username']; ?></p>
                                <p class="text-base "><?= substr($fetch_comments['created_date'], 0, 11) ?>
                                </p>
                            </div>
                        </div>
                        <!-- comment box -->
                        <div class="comment-box text-black py-2 px-2.5 text-left rounded mb-3 py-3 border border-2 border-stone-700 rounded"
                            style="background-color:#FFFFFF;">
                            <?= $fetch_comments['comment']; ?></div>
                        <!-- btn -->
                        <form action="" method="post">
                            <input type="hidden" name="comment_id" value="<?= $fetch_comments['comment_id']; ?>">
                            <div class="addComment-btn text-left block w-fit mt-4">
                                <button type="submit"
                                    class="bg-red-500 py-2 px-4 text-base text-white text-center rounded"
                                    name="delete_comment" onclick="return confirm('delete this comment?')">Delete
                                    Comment</button>
                            </div>
                        </form>
                    </div>
                    <?php } ?>
                    <?php } ?>
                    <?php } ?>
                    <?php else : ?>
                    <div class="py-4 px-4">
                        <p
                            class="bg-stone-200 text-stone-900 py-2.5 px-2.5 text-left rounded border border-stone-900 rounded ">
                            No
                            comments added yet!</p>
                    </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require "./partials/footer.php" ?>