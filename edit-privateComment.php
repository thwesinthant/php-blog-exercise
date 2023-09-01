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

if (isset($_POST['edit_comment'])) {
    $comment = $_POST['comment'];
    $editComment_qry = "UPDATE comments SET comment=:comment WHERE comment_id=:comment_id";
    $cqry = $pdo->prepare($editComment_qry);
    $cqry->bindParam(":comment_id", $comment_id, PDO::PARAM_INT);
    $cqry->bindParam(":comment", $comment, PDO::PARAM_INT);
    $cqry->execute();
    if ($cqry->execute()) {
        header("location:readMore.php");
    } else {
        $errors[] = "Errors";
    }
}

?>
<!-- comment -->
<div class="Comment px-40 mt-12">
    <!-- edit comment box -->
    <div class="editComment-box" id="editComment_div">
        <div class=" border border-stone-500 rounded shadow">
            <div class="header bg-cyan-900 text-white py-2 px-2.5 text-left ">Edit comment</div>
            <div class="comment-box py-2 px-4">
                <form action="editprivateComment.php" method="post">
                    <?php
                    $fetchComment_qry = "SELECT * FROM comments WHERE comment_id=:comment_id";
                    $fcqry = $pdo->prepare($fetchComment_qry);
                    $fcqry->bindParam(":comment_id", $comment_id, PDO::PARAM_INT);
                    $fcqry->execute();
                    $fcres = $fcqry->fetch();
                    ?>
                    <textarea name="comment"
                        class="py-4 px-2 border border-black rounded w-full block mt-3"><?= $fcres['comment'] ?></textarea>
                    <div class="addComment-btn text-left block w-fit mt-6 mb-2">
                        <a class="bg-blue-600 py-1.5 px-3.5 text-base text-white  text-center rounded cursor-pointer"
                            name="edit_comment">Edit
                            Comment</a>
                        <a class="bg-orange-500 py-1.5 px-3.5 text-base text-white  text-center rounded cursor-pointer"
                            name="cancelEdit" href="userComments.php">Cancel
                            Edit</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="title mt-10">
    <h1 class="text-center text-2xl text-black-800 font-semibold mt-5 mb-5">Your Comments</h1>
</div>
<!-- your comment -->
<div class="Comment px-40 mt-10">
    <!-- your post comment div -->
    <div class="postComment  mt-5 mb-10">
        <div class="comment-div border border-stone-500 rounded shadow">
            <div class="header bg-cyan-900 text-white py-2 px-2.5 text-left ">post comment</div>
            <div class="comment-box py-2 px-4">
                <?php
                $postComment_qry = "SELECT * FROM comments";
                $p = $pdo->prepare($postComment_qry);
                $p->execute();
                $res = $p->fetchAll(PDO::FETCH_ASSOC);
                foreach ($res as $key => $comment) :
                ?>
                <p>from : <span>blog title goes here php...</span><a href="readMore.php">view post</a></p>
                <p
                    class="bg-slate-50 border border-cyan-900 rounded text-stone-900 py-2 px-2.5 text-left font-mono rounded mt-2">
                    <?= $comment['comment'] ?>
                </p>
                <?php endforeach ?>
                <div class="addComment-btn text-left block w-fit mt-5 mb-2">
                    <a href="edit-privateComment.php?comment_id=<?= $comment['comment_id'] ?>&post_id=<?= $post_id ?>"
                        class="bg-orange-500 py-1.5 px-3.5 text-white  text-center rounded">Edit
                        Comment</a>
                    <a href="delete.php?comment_id=<?= $comment['comment_id'] ?>"
                        class="bg-red-500 py-1.5 px-3.5  text-white  text-center rounded"
                        onclick="alert('Are you Sure?')">Delete
                        Comment</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require "./partials/footer.php";
?>