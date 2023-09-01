<?php
session_start();
$errors = [];
// $admin = isset($_SESSION['admin']);
$user_id = $_SESSION['user_id'];


require "./database/bloggin.php";
require "./partials/header.php";

if (isset($_POST['update'])) {
    echo "sdfsd";
    die();
    $user_name = $_POST['user_name'];
    $updUserPf = "UPDATE users SET name=:name WHERE user_id=:user_id";
    $a = $pdo->prepare($updUserPf);
    $a->bindParam(":name", $user_name, PDO::PARAM_STR);
    $a->bindParam(":user_id", $user_id, PDO::PARAM_INT);
    $update = $a->execute();
    if ($update) {
        header("location:blogo.php");
    } else {
        $errors[] = "Errors";
    }
}
?>
<div class="flex justify-center items-center m-auto h-screen">
    <div class="w-96 p-3.5 border border-black shadow rounded bg-white">
        <form action="update-profile.php" method="post">
            <!-- title -->

            <div class="sm:mx-auto sm:w-full sm:max-w-sm">
                <h2 class=" text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Update Profile
                </h2>
            </div>
            <!-- form -->
            <div class="mt-5 sm:mx-auto sm:w-full sm:max-w-sm">
                <form class="space-y-6" action="update-adminProfile.php" method="post">
                    <?php
                    require "./database/bloggin.php";
                    $qry = "SELECT name FROM users WHERE user_id=:user_id";

                    $q = $pdo->prepare($qry);
                    $q->bindParam(":user_id", $user_id, PDO::PARAM_INT);
                    $q->execute();
                    $qres = $q->fetch();

                    ?>
                    <!-- NAME -->
                    <input type="hidden" value="<?= $user_id ?>" name="user_id">
                    <div class="mt-2">
                        <input name="user_name" type="text" placeholder="<?= $qres['name'] ?>" class="block  px-3 w-full rounded-md border border-stone-700 mb-4 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>

                    <!-- email -->
                    <div class="mt-2">
                        <input name="password" type="password" placeholder="enter your old password" class="block   px-3 w-full rounded-md border border-stone-700 mb-4 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                    <!-- password -->
                    <div class="mt-2">
                        <input name="password" type="password" placeholder="enter your new password" class="block px-3 w-full rounded-md border border-stone-700 mb-4 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                    <!-- confirm password -->
                    <div class="mt-2">
                        <input name="password" type="password" placeholder="confirm your new password" " class=" block px-3 w-full rounded-md border border-stone-700 mb-4 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                    <!-- button -->
                    <div>
                        <input class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 pointer" name="update" type="submit" value="Update Now">
                    </div>
                </form>
            </div>
    </div>
</div>
<?php
require "./partials/footer.php";
?>