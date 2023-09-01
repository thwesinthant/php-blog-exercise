<?php
session_start();
$user = isset($_SESSION['user_id']);
// echo "user is" . $user;
// die();
if ($user) {
    $user_id = $_SESSION['user_id'];
    $user_name = $_SESSION['user_name'];
}

require "./database/bloggin.php";
require "./partials/header.php";
require "./partials/navbar.php";
$date = new DateTime('now');
$now = $date->format("Y-m-d H:i:s");
if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];
}
// echo $post_id;
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_POST['addComment'])) {
        $comment = $_POST['comment'];
        $comment_qry = "INSERT INTO comments (user_id,username,post_id,comment,created_date,updated_date) VALUES (:user_id,:username,:post_id,:comment,:created_date,:updated_date) ";
        $cqry = $pdo->prepare($comment_qry);
        $cqry->bindParam(":post_id", $post_id, PDO::PARAM_INT);
        $cqry->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $cqry->bindParam(":username", $user_name, PDO::PARAM_STR);
        $cqry->bindParam(":comment", $comment, PDO::PARAM_STR);
        $cqry->bindParam(":created_date", $now, PDO::PARAM_STR);
        $cqry->bindParam(":updated_date", $now, PDO::PARAM_STR);
        $cqry->execute();
        if ($cqry->execute()) {
            echo '';
        } else {
            echo "error adding comment";
        }
    } else {
        echo "error";
    }
}

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
<!-- readmore div -->
<div class="readMore-Div px-40 py-10">
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
<!-- comment -->
<div class="comment px-40">
    <!-- add comment section -->
    <div class="addcomment-div border border-stone-500 rounded shadow" id="add-comment">
        <div class="header bg-cyan-900 text-white py-2 px-2.5 text-left ">add comment</div>
        <?php if ($_SESSION['user_id'] ?? "") : ?>
            <div class="comment-box py-2 px-4">
                <?php
                $userName_qry = "SELECT * FROM users WHERE user_id=:user_id";
                $uqry = $pdo->prepare($userName_qry);
                $uqry->bindParam(":user_id", $user_id, PDO::PARAM_INT);
                // echo $user_id;
                // die();
                $uqry->execute();
                $ures = $uqry->fetch();
                ?>
                <p class="text-blue-600 mb-3"> <i class="fa-solid fa-user bg-gray-200 border text-black border-black-700 rounded p-2 me-2"></i></i><?= $user_name ?? '' ?>
                </p>
                <form action="" method="post">

                    <textarea name="comment" placeholder="write your comment" class="p-2 border border-black rounded w-full block"></textarea>
                    <div class="addComment-btn text-left block w-fit mt-6 mb-2">
                        <button class="bg-cyan-900 py-1.5 px-3.5 text-base text-white  text-center rounded cursor-pointer" name="addComment" type="submit">Add
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
            <?php
            $postComment_qry = "SELECT * FROM comments";
            $c = $pdo->prepare($postComment_qry);
            // $c->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $c->execute();
            if ($c->execute()) {
                $cres = $c->fetchAll(PDO::FETCH_ASSOC);
                // echo "<pre>";
                // print_r($cres);
                // echo "</pre>";
                // die();
                foreach ($cres as $key => $allcomment) :

                    // $commentUser_qry = "SELECT * FROM comments";
                    // $u = $pdo->prepare($commentUser_qry);
                    // $u->execute();
                    // $ures = $u->fetchAll(PDO::FETCH_ASSOC);
                    // // print_r($ures);
                    // // die();
                    // foreach ($ures as $key => $commentUser) :
            ?>
                    <div class="comment-box py-2 px-4 mb-4">
                        <div class="who flex flex-rows gap-4 items-center justify-start mb-4">
                            <div class="icon">
                                <i class="fa-solid fa-user bg-gray-200 border border-black-800 rounded p-2"></i>
                            </div>
                            <div class="admin">
                                <p class="text-sm"><?= $commentUser['name'] ?></p>
                                <p class="text-sm"><?= substr($allcomment['updated_date'], 0, 11) ?></p>
                            </div>
                        </div>
                        <p class="bg-cyan-900 text-white py-2 px-2.5 text-left rounded"><?= $allcomment['comment'] ?></p>
                        <?php if ($allcomment['user_id'] = $_SESSION['user_id']) : ?>
                            <div class="addComment-btn text-left block w-fit mt-6 mb-2">
                                <a href="editComment.php?comment_id=<?= $allcomment['comment_id'] ?>&post_id=<?= $post_id ?>" class="bg-orange-500 py-1.5 px-3.5 text-sm text-white  text-center rounded" id="editComment_btn" onclick="myFunction()">Edit
                                    Comment</a>
                                <a href="delete.php?id=<?= $allcomment['comment_id'] ?>&tbname=comments&tbid=comment_id" class="bg-red-500 py-1.5 px-3.5 text-sm text-white  text-center rounded" onclick="alert('Are you Sure?')">Delete
                                    Comment</a>
                            </div>
                        <?php else : ?>
                            <?php echo "" ?>
                        <?php endif ?>

                    <?php endforeach ?>

                    </div>
                <?php } else {
                echo '<p>No Comment Yet!</p>';
            } ?>
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