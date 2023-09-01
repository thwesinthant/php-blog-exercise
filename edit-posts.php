<?php
session_start();
$admin = isset($_SESSION['admin']);
require "./database/bloggin.php";
require "./partials/header.php";
require "./partials/sidenav.php";
$date = new DateTime('now');
$now = $date->format("Y-m-d H:i:s");
$errors = [];

$post_id = $_GET['post_id'];
$post_Edit_qry = "SELECT * FROM posts WHERE post_id=:post_id";
$s = $pdo->prepare($post_Edit_qry);
$s->bindParam(":post_id", $post_id, PDO::PARAM_INT);
$s->execute();
$epost = $s->fetch();


?>

<!-- component -->
<div class="col-span-6 bg-slate-50 pe-6 ">
    <?php require("./partials/errors.php");  ?>
    <div class="heading text-center font-bold text-2xl m-5 text-gray-800">Edit Post</div>
    <style>
    body {
        background: white !important;
    }
    </style>

    <form
        class="editor mx-auto w-10/12 flex flex-col text-gray-800 border border-gray-300 p-4 shadow-lg max-w-2xl rounded"
        action="save-post.php" method="post" enctype="multipart/form-data">
        <!-- hidden value -->
        <input type="hidden" name="admin_id" value="<?= $epost['admin_id'] ?>">
        <input type="hidden" name="admin_name" value="<?= $epost['admin_name'] ?>">
        <input type="hidden" name="category_id" value="<?= $epost['category_id'] ?>">
        <input type="hidden" name="post_id" value="<?= $epost['post_id'] ?>">
        <!-- post status -->
        <label class="mb-2 text-sm font-semibold mt-4 rounded" for="">
            <p>post status <span>*</span></p>
        </label>
        <select name="status" class="bg-gray-100 border border-gray-300 p-2 rounded mb-4" required>
            <option value="<?= $epost['status']; ?>" selected><?= $epost['status']; ?></option>
            <option value="active" selected>active</option>
            <option value="deactive" selected>deactive</option>

        </select>
        <!-- post title -->
        <label class="mb-2 text-sm font-semibold" for="">post title*</label>
        <input class="title bg-gray-100 border border-gray-300 p-2 mb-4 outline-none rounded" spellcheck="false"
            placeholder="Title" type="text" name="title" value="<?= $epost['title'] ?>">
        <!--  post content -->
        <label class="mb-2 text-sm font-semibold" for="">post content*</label>
        <textarea class="description bg-gray-100 sec p-3 h-60 border border-gray-300 outline-none rounded"
            name="content" spellcheck="false"
            placeholder="Describe everything about this post here"><?= $epost['content'] ?></textarea>
        <!-- post category -->
        <label class="mb-2 text-sm font-semibold mt-4 rounded" for="">post category*</label>
        <select name="post_category" class="bg-gray-100 border border-gray-300 p-2 rounded">
            <?php
            $cat_sql = "SELECT * FROM post_categories";
            $c = $pdo->prepare($cat_sql);
            $c->execute();
            $cat = $c->fetchAll(PDO::FETCH_ASSOC);
            foreach ($cat as $key => $value) { ?>
            <?php if ($value['category_id'] === $epost['category_id']) : ?>
            <option selected value="<?= $value['category_id'] ?>" class="form-control">
                <?= $value['name'] ?></option>
            <?php else : ?>
            <option value="<?= $value['category_id'] ?>">
                <?= $value['name'] ?>
            </option>
            <?php endif ?>
            <?php } ?>
        </select>
        <!-- post image -->
        <label class="mb-3 text-sm font-semibold rounded mt-4" for="">edit image</label>
        <img src="Post_Image/<?= $epost['photo'] ?>" width="200" height="240"
            style="object-fit:cover;object-fit:contain;" alt="post-image">
        <input type="hidden" name="oldphoto" value="<?= $epost['photo'] ?>">
        <input type="file" name="photo"
            class="bg-gray-100 border border-gray-300 p-2 py-1 input::file-upload-button-p-1 rounded mt-5"
            value="<?= $epost['photo'] ?>">
        <!-- buttons -->
        <div class="  m-auto flex justify-center w-full gap-5 mt-6">
            <!-- <a class="button w-full bg-stone-600 p-2 rounded px-4 text-white text-base text-center text-base" name="save" href="save-post.php">Save
                Post</a> -->
            <input type="submit" value="Save Post" name="save"
                class="button w-full bg-stone-600 p-2 rounded px-4 text-white text-base text-center text-base">
            <a href="your-posts.php"
                class="button w-full bg-orange-500 p-2 rounded px-4 text-white text-base text-center text-base ">Go
                Back</a>
            <a href="delete.php?id=<?= $epost['post_id'] ?>&tbname=posts&tbid=post_id" onclick="alert('are you sure?')"
                class="button w-full bg-red-500 p-2 rounded px-4 text-white text-base text-center ">Delete
                Post</a>
        </div>
    </form>
</div>

<?php
require "./partials/footer.php";
?>