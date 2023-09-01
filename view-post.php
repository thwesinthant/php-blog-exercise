<?php
session_start();

require "./database/bloggin.php";
require "./partials/header.php";
require "./partials/sidenav.php";

$post_id = $_GET['post_id'];
$view_qry = "SELECT * FROM posts  WHERE post_id=:post_id";
$vq = $pdo->prepare($view_qry);
$vq->bindParam(":post_id", $post_id, PDO::PARAM_INT);
$vq->execute();
$vqres = $vq->fetchAll(PDO::FETCH_ASSOC);
foreach ($vqres as $key => $value) {
    # code...
}
?>
<div class="readMore-Div px-10 py-10 col-span-6 me-6">
    <!-- post -->
    <div class="bg-white w-full border border-stone-500 w-full p-3.5 py-2 rounded shadow">
        <!-- active btn -->
        <div class=" mb-1.5  w-fit mt-1.5">
            <button class="bg-orange-500  py-1 px-3 rounded text-white text-base  " style="background-color:<?php if ($value['status'] == 'active') {
                                                                                                                echo 'limegreen';
                                                                                                            } else {
                                                                                                                echo 'bg-orange-400';
                                                                                                            }; ?>;"><?= $value['status']; ?></button>
        </div>
        <div class="who  flex flex-col gap-5 items-center justify-start mb-3">
            <!--Banner image-->
            <img class="rounded-lg w-full mt-2.5 mb-2" src="./Post_Image/<?= $value['photo'] ?>
                  " />
            <!--Title-->
            <h1 class="font-semibold text-gray-900 leading-none text-lg   text-left w-full">
                <?= $value['title'] ?>
            </h1>
            <!--Description-->
            <div class="max-w-full mb-2">
                <p class="text-lg  font-medium tracking-wide text-gray-600 ">
                    <?= $value['content'] ?>
                </p>
            </div>
            <?php
            $count_post_comments = $pdo->prepare("SELECT * FROM `comments` WHERE post_id = ?");
            $count_post_comments->execute([$post_id]);
            $total_post_comments = $count_post_comments->rowCount();

            $count_post_likes = $pdo->prepare("SELECT * FROM `likes` WHERE post_id = ?");
            $count_post_likes->execute([$post_id]);
            $total_post_likes = $count_post_likes->rowCount();
            ?>
            <!-- message,love -->
            <div class="response-box w-full block bg-stone-200 border border-black rounded flex justify-between px-2 py-2 ">
                <div class="message">
                    <i class="fa-solid fa-message text-stone-500 text-lg me-1.5"></i><span class="text-blue-800 text-semibold text-lg"><?= $total_post_comments ?></span>
                </div>
                <div class="love">
                    <i class="fa-solid fa-heart text-stone-500 text-lg me-1.5 "></i><span class="text-blue-800 text-semibold text-lg"><?= $total_post_likes ?></span>
                </div>
            </div>
            <div class="viewBtns text-left block w-full mt-1 gap-3 flex">
                <a href="edit-posts.php?post_id=<?= $value['post_id'] ?>" class="bg-orange-500 py-2 px-4 text-base text-white  text-center rounded w-20 whitespace-nowrap hover:bg-slate-700 hover:text-white ">Edit
                </a>
                <a href="delete.php?id=<?= $value['post_id'] ?>&tbname=posts&tbid=post_id" class="bg-red-500  py-2 px-4 text-base  text-white  text-center rounded w-20 hover:bg-slate-700 whitespace-nowrap hover:text-white" onclick="alert('are you sure?')">Delete
                </a>
                <a href="your-posts.php" class="bg-orange-500  py-2 px-4 text-base  text-white  text-center rounded w-22 text-center whitespace-nowrap hover:bg-slate-700 hover:text-white">Go
                    Back
                </a>
            </div>
        </div>


    </div>
    <!-- fetch comment div -->
    <div class="comment-div border border-stone-500 mt-5 rounded shadow">
        <div class="header bg-cyan-900 text-white text-lg py-2.5 px-2.5 text-left ">post comments</div>
        <!-- show comment section -->
        <div class="mt-5 mb-10">
            <div class="border border-2 border-stone-700 rounded shadow mx-5 bg-stone-100 py-1.5 pb-0 px-2">
                <?php
                $select_comments = $pdo->prepare("SELECT * FROM `comments` WHERE post_id = ?");
                $select_comments->execute([$post_id]);
                if ($select_comments->rowCount() > 0) :
                    while ($fetch_comments = $select_comments->fetch(PDO::FETCH_ASSOC)) {
                ?>
                        <div class="comment-box py-1 px-4 mb-6 ">
                            <!-- user comment box -->
                            <div class=" comment-user flex flex-rows gap-4 items-center justify-start mb-4">
                                <div class="icon">
                                    <i class="fa-solid fa-user bg-white border border border-2 px-3 border-stone-700 rounded p-2 text-base"></i>
                                </div>
                                <div class="user">
                                    <p class=" text-lg text-blue-600"><?= $fetch_comments['username']; ?></p>
                                    <p class="text-base "><?= substr($fetch_comments['created_date'], 0, 11) ?>
                                    </p>
                                </div>
                            </div>
                            <!-- comment box -->
                            <div class="comment-box text-black py-2 px-2.5 text-left rounded mb-3 py-3 border border-2 border-stone-700 rounded" style="background-color:#FFFFFF;">
                                <?= $fetch_comments['comment']; ?></div>
                            <form action="" method="post">
                                <div class="addComment-btn text-left block w-fit mt-4">
                                    <input type="hidden" name="comment_id" value="<?= $fetch_comments['comment_id']; ?>">
                                    <button type="submit" class="bg-red-500 py-2 px-4 text-base text-white text-center rounded" name="">Delete
                                        Comment</button>
                                </div>
                            </form>
                        </div>
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

<?php require "./partials/footer.php";
?>