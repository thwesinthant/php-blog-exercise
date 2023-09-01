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

// edit comment php
if (isset($_POST['edit_comment'])) {
    $edit_comment_id = $_POST['edit_comment_id'];
    $comment_edit_box = $_POST['comment_edit_box'];
    $verify_comment = $pdo->prepare("SELECT * FROM `comments` WHERE comment = ? AND comment_id = ?");
    $verify_comment->execute([$comment_edit_box, $edit_comment_id]);

    if ($verify_comment->rowCount() > 0) {
        $message[] = 'comment already added!';
    } else {
        $update_comment = $pdo->prepare("UPDATE `comments` SET comment = ? WHERE comment_id = ?");
        $update_comment->execute([$comment_edit_box, $edit_comment_id]);
        $message[] = 'your comment edited successfully!';
    }
}

if (isset($_POST['delete_comment'])) {
    $comment_id = $_POST['comment_id'];
    $delete_comment = $pdo->prepare("DELETE FROM `comments` WHERE comment_id = ?");
    $delete_comment->execute([$comment_id]);
    $message[] = 'comment delete!';
}
?>

<!-- Edit Box -->
<?php
if (isset($_POST['open_edit_box'])) {
    $comment_id = $_POST['comment_id'];
?>

    <div class="Comment px-40 mt-12">
        <div class="editComment-box" id="editComment_div">
            <div class=" border border-stone-500 rounded shadow">

                <div class="header bg-cyan-900 text-white py-2 px-2.5 text-left ">Edit comment</div>
                <?php
                $select_edit_comment = $pdo->prepare("SELECT * FROM `comments` WHERE comment_id = ?");
                $select_edit_comment->execute([$comment_id]);
                $fetch_edit_comment = $select_edit_comment->fetch(PDO::FETCH_ASSOC);
                ?>
                <form action="" method="post" class="form-control m-2">
                    <input type="hidden" name="username" value="<?= $username; ?>">
                    <input type="hidden" name="edit_comment_id" value="<?= $comment_id; ?>">
                    <textarea name="comment_edit_box" required cols="30" rows="3" placeholder="please enter your comment" class="py-4 px-2 border border-black rounded w-full block mt-3"><?= $fetch_edit_comment['comment']; ?></textarea>
                    <div class="editBtns">

                    </div>
                    <div class="addComment-btn text-left block w-fit mt-6 mb-2  inline-block">
                        <button type="submit" class="bg-blue-600 py-1.5 px-3.5 text-base text-white  text-center rounded cursor-pointer " name="edit_comment">Edit Comment</button>
                    </div>
                    <a class="bg-yellow-500 py-1.5 px-3.5 text-base text-white  text-center rounded cursor-pointer inline-block" onclick="window.location.href = 'readMore.php?post_id=<?= $getpost_id; ?>';">
                        Cancel Edit</a>
            </div>
            </form>
        </div>
    </div>
    </div>
<?php
}
?>
<!-- end of edit box -->

<div class="title mt-10">
    <h1 class="text-center text-2xl text-black-800 font-semibold mt-5 mb-5">Your Comments</h1>
</div>
<div class="col-span-6 w-full block ">
    <div class="postComment  mt-8 mb-10 mx-40  ">
        <!-- fetch comment div -->
        <div class="comment-div border border-stone-500 mt-5 rounded shadow">
            <div class="header bg-cyan-900 text-white text-lg py-2.5 px-2.5 text-left ">your comments on
                the
                posts</div>
            <!-- show comment section -->
            <div class="mt-5 mb-10">
                <div class="border border-2 border-stone-700 rounded shadow mx-5 bg-stone-100 py-1.5 pb-0 px-2">
                    <?php
                    $select_comments = $pdo->prepare("SELECT * FROM comments WHERE user_id= ?");
                    $select_comments->execute([$user_id]);
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
                                        <div class="post-title text-lg mb-2"> From : <span class="text-lg font-semibold"><?= $fetch_posts['title']; ?></span> <a href="readMore.php?post_id=<?= $fetch_posts['post_id']; ?>" class="text-blue-600  hover:underline hover:text-black ms-2 text-base">view
                                                post</a></div>

                                        <!-- comment box -->
                                        <div class="comment-box text-black py-2 px-2.5 text-left rounded mb-3 py-3 border border-2 border-stone-700 rounded" style="background-color:#FFFFFF;">
                                            <?= $fetch_comments['comment']; ?></div>
                                        <!-- btn -->
                                        <form action="" method="post">
                                            <input type="hidden" name="comment_id" value="<?= $fetch_comments['comment_id']; ?>">

                                            <div class="addComment-btn text-left block w-fit mt-4">
                                                <button type="submit" class="bg-orange-500  py-2 px-4 text-base text-white text-center rounded" name="open_edit_box">Edit Comment</button>
                                                <button type="submit" class="bg-red-500 py-2 px-4 text-base text-white text-center rounded" name="delete_comment" onclick="return confirm('delete this comment?')">Delete
                                                    Comment</button>
                                            </div>
                                        </form>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    <?php else : ?>
                        <div class="py-4 px-4">
                            <p class="bg-stone-200 text-stone-900 py-2.5 px-2.5 text-left rounded border border-stone-900 rounded ">
                                No
                                comments added yet!</p>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require "./partials/footer.php";
?>