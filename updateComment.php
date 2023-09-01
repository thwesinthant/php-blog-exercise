<?php
require "./database/bloggin.php";

if (isset($_POST['editComment'])) {
    $comment = $_POST['comment'];
    $comment_id = $_POST['comment_id'];
    $post_id = $_POST['post_id'];
    // print_r($_POST['post_id']);
    // die();

    // echo $comment_id;
    // die();
    $editComment_qry = "UPDATE comments SET comment=:comment WHERE comment_id=:comment_id";
    $cqry = $pdo->prepare($editComment_qry);
    $cqry->bindParam(":comment", $comment, PDO::PARAM_STR);
    $cqry->bindParam(":comment_id", $comment_id, PDO::PARAM_INT);
    $cqry->execute();
    if ($cqry->execute()) {
        header("location:readMore.php?post_id=$post_id");
    } else {
        $errors[] = "Errors";
    }
}