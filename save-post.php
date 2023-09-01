<?php
require "./database/bloggin.php";
?>
<?php
$errors = [];
$date = new DateTime('now');
$now = $date->format("Y-m-d H:i:s");
if (isset($_POST['save'])) {
    $post_id = $_POST['post_id'];
    $category_id = $_POST['category_id'];
    $admin_id = $_POST['admin_id'];
    $admin_name = $_POST['admin_name'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    // $featured = $_POST['featured'] ?? "0";
    $oldphoto = $_POST['oldphoto'];
    $pname = $_FILES['photo']['name'];
    $tmpname = $_FILES['photo']['tmp_name'];
    $status = $_POST['status'];

    if ($pname) {
        move_uploaded_file($tmpname, "Post_Image/$pname");
    } else {
        $pname = $oldphoto;
    }
    empty($category_id) ? $errors[] = "category_id required..." : "";
    empty($title) ? $errors[] = "title required..." : "";
    empty($content) ? $errors[] = "content required..." : "";


    if (count($errors) === 0) {
        $updatepostqry = "UPDATE posts SET admin_id=:admin_id ,admin_name=:admin_name,category_id=:category_id ,title=:title , content=:content,
 photo=:photo,status=:status,updated_date=:updated_date WHERE post_id=:post_id";
        // add require db.php which contains $pdo
        $statement = $pdo->prepare($updatepostqry);
        // bind
        $statement->bindParam(":admin_id", $admin_id, PDO::PARAM_INT);
        $statement->bindParam(":admin_name", $admin_name, PDO::PARAM_STR);
        $statement->bindParam(":category_id", $category_id, PDO::PARAM_INT);
        $statement->bindParam(":title", $title, PDO::PARAM_STR);
        $statement->bindParam(":content", $content, PDO::PARAM_STR);
        // $statement->bindParam(":featured", $featured, PDO::PARAM_STR);
        $statement->bindParam(":photo", $pname, PDO::PARAM_STR);
        $statement->bindParam(":status", $status, PDO::PARAM_STR);
        $statement->bindParam(":post_id", $post_id, PDO::PARAM_INT);
        $statement->bindParam(":updated_date", $now, PDO::PARAM_STR);
        $res = $statement->execute();
        if ($res) {
            header("location:your-posts.php");
        } else {
            die('error');
        }
    } else {
        die('error');
        $errors[] = "error found";
    }
}
?>