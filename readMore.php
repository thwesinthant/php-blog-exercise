<?php
session_start();
$user = isset($_SESSION['user_id']);
if ($user) {
    $user_id = $_SESSION['user_id'];
    $username = $_SESSION['user_name'];
}
require "./database/bloggin.php";
require "./partials/header.php";
require "./partials/navbar.php";
require "./partials/likes.php";

$date = new DateTime('now');
$now = $date->format("Y-m-d H:i:s");
if (isset($_GET['post_id'])) {
    $getpost_id = $_GET['post_id'];
}
// echo $post_id;
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_POST['add_comment'])) {
        $admin_id = $_POST['admin_id'];
        $user_id = $_POST['user_id'];
        $username = $_SESSION['user_name'];
        $comment = $_POST['comment'];

        // verify comment when all condition are right 
        $verify_comment = $pdo->prepare("SELECT * FROM `comments` WHERE post_id = ? AND admin_id = ? AND user_id = ? AND username = ? AND comment = ?");
        $verify_comment->execute([$getpost_id, $admin_id, $user_id, $username, $comment]);


        if ($verify_comment->rowCount() > 0) {
            $message[] = 'comment already added!';
        } else {
            $insert_comment = $pdo->prepare("INSERT INTO `comments`(post_id, admin_id, user_id, username, comment,created_date,updated_date) VALUES(?,?,?,?,?,?,?)");
            $insert_comment->execute([$getpost_id, $admin_id, $user_id, $username, $comment, $now, $now]);
            $message[] = 'new comment added!';
        }
    }
}

// edit comment php
if (isset($_POST['edit_comment'])) {
    $edit_comment_id = $_POST['edit_comment_id'];
    $edit_comment_id = filter_var($edit_comment_id, FILTER_SANITIZE_STRING);
    $comment_edit_box = $_POST['comment_edit_box'];
    $comment_edit_box = filter_var($comment_edit_box, FILTER_SANITIZE_STRING);

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

$post_readmore_qry = "SELECT * FROM posts INNER JOIN post_categories ON posts.category_id=post_categories.category_id WHERE post_id=:post_id";
$s = $pdo->prepare($post_readmore_qry);
$s->bindParam(":post_id", $getpost_id, PDO::PARAM_INT);
$s->execute();
$readMore = $s->fetch();
// print_r($post);
// die();
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

<!-- readmore div -->
<div class="readMore-Div px-40 py-10">
    <div class="bg-white w-full border border-stone-500 w-full p-3.5 rounded shadow">
        <?php
        if ($readMore) {
            $rpost_id = $readMore['post_id'];

            $count_post_comments = $pdo->prepare("SELECT * FROM `comments` WHERE post_id = ?");
            $count_post_comments->execute([$rpost_id]);
            $total_post_comments = $count_post_comments->rowCount();

            $count_post_likes = $pdo->prepare("SELECT * FROM `likes` WHERE post_id = ?");
            $count_post_likes->execute([$rpost_id]);
            $total_post_likes = $count_post_likes->rowCount();

            $confirm_likes = $pdo->prepare("SELECT * FROM likes WHERE user_id = ? AND post_id = ?");
            $confirm_likes->execute([$user_id, $rpost_id]);

        ?>
            <form action="" method="post" class="box">

                <input type="hidden" name="post_id" value="<?= $rpost_id; ?>">
                <input type="hidden" name="admin_id" value="<?= $readMore['admin_id']; ?>">
                <input type="hidden" name="user_id" value="<?= $user_id; ?>">
                <div class="who  flex flex-rows gap-5 items-center justify-start mb-4">
                    <div class="icon">
                        <i class="fa-solid fa-user bg-grey-200 border border-grey rounded p-2"></i>
                    </div>
                    <div class="admin">
                        <p class="text-sm"><?= $readMore['admin_name'] ?></p>
                        <p class="text-sm"><?= substr($readMore['updated_date'], 0, 11) ?></p>
                    </div>
                </div>
                <!--Banner image-->
                <img class="rounded-lg w-full mt-4 mb-4" src="./Post_Image/<?= $readMore['photo'] ?>
              " />
                <!--Title-->
                <h1 class="font-semibold text-gray-900 leading-none text-base mt-1 capitalize truncate">
                    <?= $readMore['title'] ?>
                </h1>
                <!--Description-->
                <di class="max-w-full mb-5">
                    <p class="text-base mt-2 font-medium tracking-wide text-gray-600 mt-1">
                        <?= $readMore['content'] ?>
                    </p>

                    <!-- tags -->
                    <div class="tags mt-5">
                        <i class="fa-solid fa-tag me-2.5"></i><span class="text-blue-800"> <?= $readMore['name'] ?>
                        </span>
                    </div>
                    <!-- message,love -->
                    <div class="response-box w-full block bg-stone-200 border border-black rounded flex justify-between px-2 py-2 mt-4">
                        <div class="message">
                            <i class="fa-solid fa-message text-stone-500 me-1.5"></i><span class="text-blue-800 text-semibold">(<?= $total_post_comments; ?>)</span>
                        </div>
                        <button type="submit" name="like_post"><i class="fas fa-heart me-1.5" style="<?php if ($confirm_likes->rowCount() > 0) {
                                                                                                            echo 'color:red';
                                                                                                        } ?>"></i><span>(<?= $total_post_likes; ?>)</span></button>

                    </div>
            </form>
        <?php
        } else {
            echo '<p class="empty">no posts found!</p>';
        }
        ?>
    </div>
</div>
<!-- comment -->
<div class="comment px-40">
    <!-- add comment section -->
    <div class="addcomment-div border border-stone-500 rounded shadow" id="add-comment">
        <div class="header bg-cyan-900 text-white py-2 px-2.5 text-left ">add comment</div>
        <?php
        if ($_SESSION['user_id'] ?? "") : ?>
            <div class="comment-box py-2 px-4">
                <?php
                $userName_qry = "SELECT * FROM users WHERE user_id=:user_id";
                $uqry = $pdo->prepare($userName_qry);
                $uqry->bindParam(":user_id", $user_id, PDO::PARAM_INT);
                // echo $user_id;
                // die();
                $uqry->execute();
                $ures = $uqry->fetch();

                $select_admin_id = $pdo->prepare("SELECT * FROM posts WHERE post_id = ?");
                $select_admin_id->execute([$getpost_id]);
                $fetch_admin_id = $select_admin_id->fetch(PDO::FETCH_ASSOC);
                ?>
                <form action="" method="post">
                    <input type="hidden" name="admin_id" value="<?= $fetch_admin_id['admin_id']; ?>">
                    <input type="hidden" name="user_id" value="<?= $_SESSION['user_id']; ?>">
                    <p class="text-blue-600 mb-3"> <i class="fa-solid fa-user bg-gray-200 border text-black border-black-700 rounded p-2 me-2" name="username"></i><?= $username; ?>
                    </p>
                    <textarea name="comment" placeholder="write your comment" class="p-2 border border-black rounded w-full block" required></textarea>
                    <div class="addComment-btn text-left block w-fit mt-6 mb-2">
                        <button class=" py-1.5 px-3.5 text-base text-white  text-center rounded cursor-pointer bg-blue-600" name="add_comment" type="submit">Add
                            Comment</button>
                    </div>
                </form>
            </div>
        <?php else : ?>
            <div class="comment-box py-2 px-4 pb-4">
                <p class="text-stone-700 align-left w-full font-bold mb-4 mt-2">please login to add or edit your comment</p>
                <a href="login.php" class="bg-cyan-900 py-1.5 px-5 text-sm text-white text-center rounded">Login</a>
            </div>
        <?php endif ?>
    </div>
    <!-- post comment section -->
    <div class="postComment  mt-5 mb-10">
        <div class="comment-div border border-stone-500 rounded shadow">
            <div class="header bg-cyan-900 text-white py-2 px-2.5 text-left ">post comment</div>
            <div class="comment-box py-2 px-4 mb-4">
                <?php
                $select_comments = $pdo->prepare("SELECT * FROM `comments` WHERE post_id = ?");
                $select_comments->execute([$getpost_id]);
                if ($select_comments->rowCount() > 0) {
                    while ($fetch_comments = $select_comments->fetch(PDO::FETCH_ASSOC)) {
                ?>
                        <div class="show-comments" style="<?php if ($fetch_comments['user_id'] == $_SESSION['user_id']) {
                                                                echo 'order:-1;';
                                                            } ?>">
                            <!-- comment user -->
                            <div class="comment-user flex flex-rows gap-4 items-center justify-start mb-4">
                                <div class="icon">
                                    <i class="fa-solid fa-user bg-gray-200 border border-black-800 rounded p-2"></i>
                                </div>
                                <div class="user">
                                    <p class="text-sm"><?= $fetch_comments['username']; ?></p>
                                    <p class="text-sm"><?= substr($fetch_comments['created_date'], 0, 11) ?></p>
                                </div>
                            </div>
                            <!-- comment box -->
                            <div class="comment-box bg-cyan-900 text-white py-2 px-2.5 text-left rounded mb-3" style="<?php if ($fetch_comments['user_id'] == $user_id) {
                                                                                                                            echo 'color:white; background:black;';
                                                                                                                        } ?>"> <?= $fetch_comments['comment']; ?></div>

                            <?php
                            if ($fetch_comments['user_id'] == $user_id) {
                            ?>
                                <form action="" method="post">
                                    <div class="addComment-btn text-left block w-fit mt-6 mb-2">
                                        <input type="hidden" name="comment_id" value="<?= $fetch_comments['comment_id']; ?>">
                                        <button type="submit" class="bg-orange-400 py-1.5 px-3.5 text-sm text-white text-center rounded" name="open_edit_box" onclick="myFunction()" style="	background-color: rgb(234 88 12);">Edit
                                            Comment</button>
                                        <a href="delete.php?id=<?= $fetch_comments['comment_id'] ?>&tbname=comments&tbid=comment_id" class="bg-red-500 py-1.5 px-3.5 text-sm text-white  text-center rounded" onclick="alert('Are you Sure?')">Delete
                                            Comment</a>
                                    </div>
                                </form>
                            <?php
                            }
                            ?>
                        </div>
                <?php
                    }
                } else {
                    echo '<p class="empty">no comments added yet!</p>';
                }
                ?>
            </div>
        </div>
    </div>


    </body>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        clifford: '#da373d',
                    }
                }
            }
        }

        // let editComment_btn = document.querySelector("#editComment_btn");
        // let editComment_div = document.querySelector("#editComment_div ");

        // editComment_btn.addEventListener("click", function() {
        //     editComment_div.style.display = "block";
        // });

        function myFunction() {
            let x = document.getElementById("editComment_div");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        }
    </script>

    </html>