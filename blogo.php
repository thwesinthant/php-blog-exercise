<?php
session_start();
$user = isset($_SESSION['user']);
if ($user) {
    $user_name = $_SESSION['user_name'];
}
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
};
$admin = isset($_SESSION['admin']);
if ($admin) {
    $admin_id = $_SESSION['admin_id'];
}
require "./database/bloggin.php";
require "./partials/navbar.php";
require "./partials/header.php";
include "./partials/likes.php";
require "./search.php";

if (isset($_POST['submit'])) {
    // submit from search button
    $keyword = $_POST['search'];
    $keyword = "%$keyword%";

    $sql = "SELECT * FROM posts WHERE title LIKE :keyword;";
    $s = $pdo->prepare($sql);
    $s->bindParam(":keyword", $keyword, PDO::PARAM_STR);
    $s->execute();
    $res = $s->fetchAll(PDO::FETCH_ASSOC);
}

?>
<div class="grid grid-cols-12 gap-8 px-40 ">
    <!-- USER FORM -->
    <form class="col-span-4  w-72 " action="blogo.php" method="post">
        <?php if ($user_id) : ?>
        <div
            class=" mt-20  bg-white border border-1 border-black px-6 py-4 rounded flex flex-col justify-center items-center h-fit form-control">
            <?php
                $select_profile = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
                $select_profile->execute([$user_id]);
                if ($select_profile->rowCount() > 0) {
                    $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);

                    $count_user_comments = $pdo->prepare("SELECT * FROM `comments` WHERE user_id = ?");
                    $count_user_comments->execute([$user_id]);
                    $total_user_comments = $count_user_comments->rowCount();

                    $count_user_likes = $pdo->prepare("SELECT * FROM `likes` WHERE user_id = ?");
                    $count_user_likes->execute([$user_id]);
                    $total_user_likes = $count_user_likes->rowCount();


                ?>
            <p class="text-gray-500 text-base align-left w-full">welcome <span
                    class="text-blue-800"><?= $fetch_profile['name'] ?? "" ?></span>
            </p>
            <p class="text-gray-500 text-base align-left w-full">total comments : <span class="text-blue-800">
                    <?= $total_user_comments; ?></span>
            </p>
            <p class="text-gray-500 text-base align-left w-full">post likes :<span class="text-blue-800">
                    <?= $total_user_likes; ?></span>
            </p>
            <?php } ?>
            <div class=" relative w-full mb-8 mt-4">
                <a href="update-profile.php?user_id=<?= $user_id ?>"
                    class="absolute w-full block  h-fit bg-blue-500 font-semibold p-2 rounded px-7 text-white text-sm text-center hover:bg-slate-700"
                    name="update">Update
                    Profile</a>

            </div>
            <div class=" mt-3 m-auto flex  flex-row justify-center w-full gap-2">
                <a href="user-likes.php"
                    class="button w-full  h-fit bg-yellow-400 font-semibold p-2 rounded px-7 text-white text-sm text-center hover:bg-slate-700">Likes</a>
                <a href="user-comments.php"
                    class="button w-full h-fit bg-yellow-400 font-semibold p-2 rounded px-7 text-white text-sm text-center hover:bg-slate-700">Comments
                </a>
            </div>
        </div>
        <?php else : ?>
        <div
            class=" mt-20  bg-white border border-1 border-black px-3 py-4 rounded flex flex-col justify-center items-center h-fit">
            <p class="text-grey text-sm align-left w-full">login or register!</p>
            <div class=" mt-3 m-auto flex  flex-row justify-center w-100 gap-3">
                <a href="login.php"
                    class="button w-full  h-fit bg-yellow-400 font-semibold p-2 rounded px-7 text-white text-sm text-center hover:bg-slate-700">Login</a>
                <a href="register.php"
                    class="button w-full h-fit bg-yellow-400 font-semibold p-2 rounded px-7 text-white text-sm text-center hover:bg-slate-700">Register
                </a>
            </div>
        </div>
        <?php endif ?>
    </form>
    <!-- CATEGORY BOX -->
    <div class="col-span-4 w-72">
        <div
            class=" mt-20  bg-white border border-1 border-black px-3 py-4 rounded flex flex-col justify-center items-center h-fit ">
            <p>categories</p>
            <div class=" mt-3 m-auto flex  flex-row justify-center  gap-3  flex-wrap ">
                <?php
                require "./database/bloggin.php";
                $cat_qry = "SELECT * FROM post_categories LIMIT 6";
                $c = $pdo->prepare($cat_qry);
                $c->execute();
                $res = $c->fetchAll(PDO::FETCH_ASSOC);
                foreach ($res as $key => $catName) :
                ?>
                <a class="w-fit h-fit bg-neutral-200 py-1.5 rounded px-6 text-black text-sm text-center border border-black hover:bg-slate-700 hover:text-white hover:border-white"
                    href="view-postbycate.php?category_id=<?= $catName['category_id'] ?>" class="links">
                    <?= $catName['name'] ?></a>
                <?php endforeach ?>
            </div>
            <div class=" mt-3 m-auto flex  flex-row justify-center w-full block gap-3">
                <a class="button w-full hover:bg-slate-700 h-fit bg-blue-500 p-2 rounded px-7 text-white text-sm text-center "
                    href="categories.php">View
                    All</a>
            </div>
        </div>
    </div>
    <!-- author box -->
    <div class="col-span-4 w-72">
        <div
            class=" mt-20  bg-white border border-1 border-black px-3 py-4 rounded flex flex-col justify-center items-center h-fit">
            <p>admins</p>
            <div class=" mt-3 m-auto flex  flex-row justify-center  gap-3  flex-wrap  " id="admin_div">
                <?php
                require "./database/bloggin.php";
                $admin_qry = "SELECT * FROM admins ";
                $a = $pdo->prepare($admin_qry);
                $a->execute();
                $res = $a->fetchAll(PDO::FETCH_ASSOC);
                foreach ($res as $key => $admin) :
                ?>
                <a href="view-postbyadmin.php?admin_id=<?= $admin['admin_id'] ?>"
                    class="button w-fit  h-fit bg-neutral-200 py-1.5 rounded px-6 text-black text-sm text-center border border-black rounded hover:bg-slate-700 hover:text-white hover:border-white"><?= $admin['name'] ?></a>
                <?php endforeach ?>
            </div>
            <div id="viewadminAll" class=" mt-3 m-auto flex  flex-row justify-center w-full block gap-3">
                <a class="button w-full  h-fit bg-blue-500 p-2 rounded px-7 text-white text-sm text-center hover:bg-slate-700"
                    href="admins.php">View
                    All</a>
            </div>
        </div>
    </div>
</div>
<!-- Latest Posts -->
<h1 class="text-center text-3xl text-red-400 mt-14 font-bold mb-8">Latest Posts</h1>

<div class="latest-posts grid grid-cols-12 gap-8 px-40 mb-20" id="post_div">
    <?php
    $select_posts = $pdo->prepare("SELECT * FROM posts INNER JOIN post_categories ON posts.category_id=post_categories.category_id  WHERE status = ? LIMIT 6 ");
    $select_posts->execute(['active']);
    if ($select_posts->rowCount() > 0) {
        while ($homePosts = $select_posts->fetch(PDO::FETCH_ASSOC)) {

            $hpost_id = $homePosts['post_id'];

            $count_post_comments = $pdo->prepare("SELECT * FROM `comments` WHERE post_id = ?");
            $count_post_comments->execute([$hpost_id]);
            $total_post_comments = $count_post_comments->rowCount();

            $count_post_likes = $pdo->prepare("SELECT * FROM `likes` WHERE post_id = ?");
            $count_post_likes->execute([$hpost_id]);
            $total_post_likes = $count_post_likes->rowCount();

            $confirm_likes = $pdo->prepare("SELECT * FROM `likes` WHERE user_id = ? AND post_id = ?");
            $confirm_likes->execute([$user_id, $hpost_id]);
    ?>
    <div class="col-span-4 border border-stone-500 w-full p-3.5 rounded shadow  h-fit ">
        <!-- post div -->
        <div class="bg-white w-full">
            <!-- profile -->
            <div class="who  flex flex-rows gap-5 items-center justify-start mb-4">
                <div class="icon">
                    <i class="fa-solid fa-user bg-grey-200 border border-grey rounded p-2"></i>
                </div>

                <div class="admin">
                    <a class="text-sm text-blue-700"
                        href="view-postbyadmin.php?admin_id=<?= $homePosts['admin_id'] ?>"><?= $homePosts['admin_name'] ?></a>
                    <p class="text-sm"><?= substr($homePosts['created_date'], 0, 11) ?></p>
                </div>

            </div>
            <!--Banner image-->
            <img class="rounded-lg w-full  h-60 object-cover mt-4 mb-4 " src="./Post_Image/<?= $homePosts['photo'] ?>
                  " />
            <!--Title-->
            <h1 class="font-semibold text-gray-900 leading-none text-base mt-1 capitalize truncate">
                <?= $homePosts['title'] ?>
            </h1>
            <!--Description-->
            <div class="max-w-full mb-5">
                <p class="text-base mt-2 font-medium tracking-wide text-gray-600 mt-1">
                    <?= substr($homePosts['content'], 0, 100) ?>
                    <?php if (strlen($homePosts['content']) > 100) : ?>
                    ....
                    <?php else : ?>
                    <?php endif ?>
                </p>
            </div>
            <!-- read more  -->
            <a href="readMore.php?post_id=<?= $homePosts['post_id'] ?>"
                class="bg-blue-500 hover:bg-slate-700 text-white font-mono text-sm p-2 px-3 rounded w-fit ">Read
                More</a>
            <!-- tags -->
            <div class="tags mt-5">
                <i class="fa-solid fa-tag me-2.5"></i><span class="text-cyan-700"><?= $homePosts['name'] ?></span>
            </div>
            <!-- form -->
            <form method="post"
                class="response-box w-full block bg-stone-200 border border-black rounded flex justify-between px-2 py-2 mt-4">
                <input type="hidden" name="user_id" value="<?= $user_id ?>">
                <input type="hidden" name="post_id" value="<?= $homePosts['post_id']; ?>">
                <input type="hidden" name="admin_id" value="<?= $homePosts['admin_id']; ?>">
                <div class="message">
                    <a href="readMore.php?post_id=<?= $homePosts['post_id'] ?>"><i
                            class="fa-solid fa-message text-stone-500 me-1"></i><span
                            class="text-blue-600 ">(<?= $total_post_comments; ?>)</span></a>
                </div>
                <div class="love">
                    <button type="submit" name="like_post"><i class="fas fa-heart me-1 " style="<?php if ($confirm_likes->rowCount() > 0) {
                                                                                                            echo 'color:red;';
                                                                                                        } ?>"></i><span
                            class="text-blue-600 ">(<?= $total_post_likes; ?>)</span></button>
                </div>
            </form>
        </div>
    </div>
    <?php } ?>
    <?php } ?>

</div>
</div>


<div class=" w-full block text-center place-self-center mb-20">
    <a class="button w-full  h-fit bg-blue-600 p-2 rounded px-7  text-white text-base text-center hover:bg-slate-700 "
        href="view-allPosts.php" id="post_btn">View
        All Posts</a>
</div>


<script>
const cat_div = document.getElementById("cat_div");
const btn = document.getElementById("viewcatAll");
btn.addEventListener('click', function() {
    cat_div.style.overflow = "visible";
    cat_div.style.height = "auto";
})

const admin_div = document.getElementById("admin_div");
const adminBtn = document.getElementById("viewadminAll");
adminBtn.addEventListener('click', function() {
    admin_div.style.overflow = "visible";
    admin_div.style.height = "auto";
})
</script>

<?php
require "./partials/footer.php";
?>