<?php
// like post method btn from blogo.php
if (isset($_POST['like_post'])) {
    if ($user_id != '') {
        $post_id = $_POST['post_id'];
        $admin_id = $_POST['admin_id'];
        $user_id = $_POST['user_id'];

        $select_post_like = $pdo->prepare("SELECT * FROM likes WHERE post_id = ? AND user_id = ?");
        $select_post_like->execute([$post_id, $user_id]);

        if ($select_post_like->rowCount() > 0) {
            $remove_like = $pdo->prepare("DELETE FROM likes WHERE post_id = ?");
            $remove_like->execute([$post_id]);
            $message[] = 'removed from likes';
        } else {
            $add_like_qry = "INSERT INTO `likes` (user_id,admin_id,post_id) VALUES (:user_id,:admin_id,:post_id)";
            $add_like = $pdo->prepare($add_like_qry);
            $add_like->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $add_like->bindParam(":admin_id", $admin_id, PDO::PARAM_INT);
            $add_like->bindParam(":post_id", $post_id, PDO::PARAM_INT);
            $add_like->execute();
            die('');

            // $add_like = $pdo->prepare("INSERT INTO likes (user_id, admin_id, post_id) VALUES (?,?,?)");
            // $add_like->execute([$user_id, $admin_id, $post_id]);
            // echo '';
        }
    }
}
