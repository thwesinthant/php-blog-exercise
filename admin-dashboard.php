<?php
session_start();
$admin = isset($_SESSION['admin']);
if ($admin) {
    $admin_id = $_SESSION['admin_id'];
}
require "./partials/header.php";
require "./partials/sidenav.php";
?>

<div class="col-span-6 bg-slate-50 pe-16">
    <h1 class="text-center fs-lg text-black-800 font-semibold mt-5 mb-5">Dashboard</h1>
    <!-- input box -->
    <div class="grid grid-cols-3 gap-20">
        <!-- welcome -->
        <div
            class="input w-72  bg-white border border-1 border-black px-3 py-4 rounded flex flex-col justify-center items-center">
            <h1 class="text-center text-lg mb-3 font-mono">welcome!</h1>
            <p name="admin" class="text-center text-slate-500  w-60 py-1.5 bg-slate-200">
                <?php
                require "./database/bloggin.php";
                $qry = "SELECT name FROM admins WHERE admin_id=:admin_id";
                $q = $pdo->prepare($qry);
                $q->bindParam(":admin_id", $admin_id, PDO::PARAM_INT);
                $q->execute();
                $qres = $q->fetch();
                ?>
                <?php echo  $qres['name'] ?? "-" ?>
            </p>
            <div class="update-profile    mt-3 m-auto flex justify-center w-100">
                <a href="update-adminProfile.php"
                    class="button w-60 bg-blue-500 p-2 rounded px-4 text-white text-sm text-center ">Update
                    Profile</a>
            </div>
        </div>
        <!-- add new post -->
        <div
            class="input w-72  bg-white border border-1 border-black px-3 py-4 rounded flex flex-col justify-center items-center">
            <?php
            $post_count_qry = "SELECT * FROM posts WHERE admin_id=:admin_id";
            $pcq = $pdo->prepare($post_count_qry);
            $pcq->bindParam("admin_id", $admin_id, PDO::PARAM_INT);
            $pcq->execute();
            $pcres = $pcq->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <h1 class="text-center text-lg mb-3 font-mono"><?= count($pcres) ?></h1>
            <p name="" class="text-center text-slate-500 w-60 py-1.5 bg-slate-200">
                post added
            </p>
            <div class="add-post    mt-3 m-auto flex justify-center w-100">
                <a href="add-post.php"
                    class="button w-60 bg-blue-500 p-2 rounded px-4 text-white text-sm text-center ">Add New
                    Post</a>
            </div>
        </div>
        <!-- active post -->
        <div
            class="input w-72  bg-white border border-1 border-black px-3 py-4 rounded flex flex-col justify-center items-center">
            <?php
            $status = "active";
            $activePost_count_qry = "SELECT * FROM posts WHERE admin_id=:admin_id AND status=:status";
            $pcq = $pdo->prepare($activePost_count_qry);
            $pcq->bindParam("admin_id", $admin_id, PDO::PARAM_INT);
            $pcq->bindParam("status", $status, PDO::PARAM_STR);
            $pcq->execute();
            $pcres = $pcq->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <h1 class="text-center text-lg mb-3 font-mono"><?= count($pcres) ?></h1>
            <p name="" class="text-center text-slate-500 w-60 py-1.5 bg-slate-200">
                active posts
            </p>
            <div class="see_posts    mt-3 m-auto flex justify-center w-100">
                <a href="active-posts.php"
                    class="button w-60 bg-blue-500 p-2 rounded px-4 text-white text-sm text-center ">See Posts</a>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-3 gap-20 mt-12">
        <!-- deactive posts -->
        <div
            class="input w-72  bg-white border border-1 border-black px-3 py-4 rounded flex flex-col justify-center items-center">
            <?php
            $status = "deactive";
            $activePost_count_qry = "SELECT * FROM posts WHERE admin_id=:admin_id AND status=:status";
            $pcq = $pdo->prepare($activePost_count_qry);
            $pcq->bindParam("admin_id", $admin_id, PDO::PARAM_INT);
            $pcq->bindParam("status", $status, PDO::PARAM_STR);
            $pcq->execute();
            $pcres = $pcq->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <h1 class="text-center text-lg mb-3 font-mono"><?= count($pcres) ?></h1>
            <p name="" class="text-center text-slate-500 w-60 py-1.5 bg-slate-200">
                deactive posts
            </p>
            <div class="deactive_posts  mt-3 m-auto flex justify-center w-100">
                <a href="deactive-posts.php"
                    class="button w-60 bg-blue-500 p-2 rounded px-4 text-white text-sm text-center ">See Posts</a>
            </div>
        </div>
        <!-- users account -->
        <div
            class="input w-72  bg-white border border-1 border-black px-3 py-4 rounded flex flex-col justify-center items-center">
            <?php
            $user_qry = "SELECT * FROM users";
            $userq = $pdo->prepare($user_qry);
            $userq->execute();
            $user = $userq->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <h1 class="text-center text-lg mb-3 font-mono"><?= count($user); ?></h1>
            <p name="" class="text-center text-slate-500 w-60 py-1.5 bg-slate-200">
                users account
            </p>
            <div class="users-account    mt-3 m-auto flex justify-center w-100">
                <a href="user-accounts.php"
                    class="button w-60 bg-blue-500 p-2 rounded px-4 text-white text-sm text-center ">See Users </a>
            </div>
        </div>
        <!-- admins account -->
        <div
            class="input w-72  bg-white border border-1 border-black px-3 py-4 rounded flex flex-col justify-center items-center">
            <?php
            $admin_qry = "SELECT * FROM admins";
            $aq = $pdo->prepare($admin_qry);
            $aq->execute();
            $res = $aq->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <h1 class="text-center text-lg mb-3 font-mono"><?= count($res); ?></h1>
            <p name="" class="text-center text-slate-500 w-60 py-1.5 bg-slate-200">
                admins account
            </p>
            <div class="admin_account    mt-3 m-auto flex justify-center w-100">
                <a href="admin-accounts.php"
                    class="button w-60 bg-blue-500 p-2 rounded px-4 text-white text-sm text-center "
                    name="admins_account">See Admins</a>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-3 gap-20 mt-12">
        <!-- comments added -->
        <div
            class="input w-72  bg-white border border-1 border-black px-3 py-4 rounded flex flex-col justify-center items-center">
            <?php
            $select_comments = $pdo->prepare("SELECT * FROM `comments` WHERE admin_id = ?");
            $select_comments->execute([$admin_id]);
            $select_comments->execute();
            $numbers_of_comments = $select_comments->rowCount();
            ?>
            <h1 class="text-center text-lg mb-3 font-mono"><?= $numbers_of_comments ?> </h1>
            <p name="" class="text-center text-slate-500 w-60 py-1.5 bg-slate-200">
                comments added
            </p>
            <div class="comments_added  mt-3 m-auto flex justify-center w-100">
                <a href="admin-comments.php"
                    class="button w-60 bg-blue-500 p-2 rounded px-4 text-white text-sm text-center ">See
                    Comments</a>
            </div>
        </div>
        <!-- total likes -->
        <div
            class="input w-72  bg-white border border-1 border-black px-3 py-4 rounded flex flex-col justify-center items-center">
            <?php
            $select_likes = $pdo->prepare("SELECT * FROM `likes` WHERE admin_id = ?");
            $select_likes->execute([$admin_id]);
            $select_likes->execute();
            $numbers_of_likes = $select_likes->rowCount();
            ?>
            <h1 class="text-center text-lg mb-3 font-mono"><?= $numbers_of_likes ?></h1>
            <p name="" class="text-center text-slate-500 w-60 py-1.5 bg-slate-200">
                total likes
            </p>
            <div class="total-likes    mt-3 m-auto flex justify-center w-100">
                <a href="admin-likes.php"
                    class="button w-60 bg-blue-500 p-2 rounded px-4 text-white text-sm text-center ">See Posts</a>
            </div>
        </div>
    </div>
</div>
</div>

<?php
require "./partials/footer.php";
?>