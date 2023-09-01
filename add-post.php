<?php
session_start();
$admin = isset($_SESSION['admin']);
$admin_id = $_SESSION['admin_id'];
$admin_name = $_SESSION['admin_name'];

require "./database/bloggin.php";
require "./partials/header.php";
require "./partials/sidenav.php";
$errors = [];
$date = new DateTime('now');
$now = $date->format("Y-m-d H:i:s");

if (isset($_POST['post'])) {
    $category_id = $_POST['category_id'];
    $admin_id = $_POST['admin_id'];
    $admin_name = $_SESSION['admin_name'];

    $title = $_POST['title'];
    $content = $_POST['content'];
    $pname = $_FILES['photo']['name'];
    $tmpname = $_FILES['photo']['tmp_name'];
    $status = 'active';

    move_uploaded_file($tmpname, "Post_Image/$pname");
    empty($title) ? $errors[] = "title required..." : "";
    empty($content) ? $errors[] = "content required..." : "";


    if (count($errors) === 0) {
        $check_title_qry = "SELECT * FROM posts WHERE title=:title";
        $ctq = $pdo->prepare($check_title_qry);
        $ctq->bindParam(":title", $title, PDO::PARAM_STR);
        $ctq->execute();
        $res = $ctq->fetch();
        if ($res) {

            $errors[] = "Title Already Exist";
        } else {
            $add_post_qry = "INSERT INTO posts (category_id,admin_id,admin_name,title,content,photo,status,created_date,updated_date) VALUES (:category_id,:admin_id,:admin_name,:title,:content,:photo,:status,:created_date,:updated_date)";

            $apq = $pdo->prepare($add_post_qry);
            $apq->bindParam(":category_id", $category_id, PDO::PARAM_INT);
            $apq->bindParam(":admin_id", $admin_id, PDO::PARAM_INT);
            $apq->bindParam(":admin_name", $admin_name, PDO::PARAM_STR);
            $apq->bindParam(":title", $title, PDO::PARAM_STR);
            $apq->bindParam(":content", $content, PDO::PARAM_STR);
            $apq->bindParam(":photo", $pname, PDO::PARAM_STR);
            $apq->bindParam(":status", $status, PDO::PARAM_STR);
            $apq->bindParam(":created_date", $now, PDO::PARAM_STR);
            $apq->bindParam(":updated_date", $now, PDO::PARAM_STR);
            if ($apq->execute()) {
                header("location:your-posts.php");
            } else {
                $errors[]  = "Oops! Something went wrong. creating post error!.";
            }
        }
    }
}

// save draft php
if (isset($_POST['draft'])) {
    $category_id = $_POST['category_id'];
    $admin_id = $_POST['admin_id'];
    $admin_name = $_POST['admin_name'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $pname = $_FILES['photo']['name'];
    $tmpname = $_FILES['photo']['tmp_name'];
    $status = 'deactive';

    move_uploaded_file($tmpname, "Post_Image/$pname");
    empty($title) ? $errors[] = "title required..." : "";
    empty($content) ? $errors[] = "content required..." : "";

    if (count($errors) === 0) {
        $check_title_qry = "SELECT * FROM posts WHERE title=:title";
        $ctq = $pdo->prepare($check_title_qry);
        $ctq->bindParam(":title", $title, PDO::PARAM_STR);
        $ctq->execute();
        $res = $ctq->fetch();
        if ($res) {
            $errors[] = "Title Already Exist";
        } else {
            $add_post_qry = "INSERT INTO posts (category_id,admin_id,admin_name,title,content,photo,status,created_date,updated_date) VALUES (:category_id,:admin_id,:admin_name,:title,:content,:photo,:status,:created_date,:updated_date)";
            $apq = $pdo->prepare($add_post_qry);
            $apq->bindParam(":category_id", $category_id, PDO::PARAM_INT);
            $apq->bindParam(":admin_id", $admin_id, PDO::PARAM_INT);
            $apq->bindParam(":admin_name", $admin_name, PDO::PARAM_STR);
            $apq->bindParam(":title", $title, PDO::PARAM_STR);
            $apq->bindParam(":content", $content, PDO::PARAM_STR);
            $apq->bindParam(":photo", $pname, PDO::PARAM_STR);
            $apq->bindParam(":status", $status, PDO::PARAM_STR);
            $apq->bindParam(":created_date", $now, PDO::PARAM_STR);
            $apq->bindParam(":updated_date", $now, PDO::PARAM_STR);
            if ($apq->execute()) {
                header("location:your-posts.php");
            } else {
                $errors[]  = "Oops! Something went wrong. saving post error!.";
            }
        }
    }
}

?>

<!-- component -->
<div class="col-span-6 bg-slate-50 pe-6 ">
    <div class="heading text-center font-bold text-2xl m-5 text-gray-800">Add New Post</div>
    <style>
        body {
            background: white !important;
        }
    </style>

    <form class="editor mx-auto w-10/12 flex flex-col text-gray-800 border border-gray-300 p-4 shadow-lg max-w-2xl rounded" method="post" enctype="multipart/form-data" action="add-post.php">
        <?php require "./partials/errors.php"; ?>

        <input type="hidden" name="admin_id" value="<?= $_SESSION['admin_id'] ?>">
        <input type="hidden" name="admin_name" value="<?= $_SESSION['admin_name'] ?>">

        <label class="mb-2 text-sm font-semibold" for="">post title*</label>
        <input class="title bg-gray-100 border border-gray-300 p-2 mb-4 outline-none rounded" spellcheck="false" placeholder="Title" type="text" name="title">
        <label class="mb-2 text-sm font-semibold" for="">post content*</label>
        <textarea class="description bg-gray-100 sec p-3 h-60 border border-gray-300 outline-none rounded" spellcheck="false" placeholder="Describe everything about this post here" name="content"></textarea>


        <label class="mb-2 text-sm font-semibold mt-4 rounded">post category*</label>
        <select name="category_id" required class="bg-gray-100 border border-gray-300 p-2 rounded">
            <?php
            $sql = "SELECT * FROM post_categories";
            $s = $pdo->prepare($sql);
            $s->execute();
            $pc = $s->fetchAll(PDO::FETCH_ASSOC);
            foreach ($pc as $key => $value) :
            ?>
                <option value="<?= $value['category_id'] ?>" selected> <?= $value['name']  ?>
                </option>
            <?php endforeach ?>
        </select>

        <label class="mb-2 text-sm font-semibold rounded mt-4">post image</label>
        <input type="file" name="photo" class="bg-gray-100 border border-gray-300 p-2 py-1 input::file-upload-button-p-1 rounded">
        <!-- buttons -->
        <div class="update-profile m-auto flex justify-center w-full gap-5  mt-9">
            <input name="post" type="submit" value="Public Post" class="button w-full bg-blue-500 p-2 rounded px-4 text-white text-base text-center text-base">
            <input name="draft" type="submit" value="Save Draft" class="button w-full bg-orange-500 p-2 rounded px-4 text-white text-base text-center text-base">
        </div>
    </form>
</div>

<?php
require "./partials/footer.php";
?>