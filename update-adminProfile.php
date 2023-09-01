<?php
session_start();
$errors = [];
$admin = isset($_SESSION['admin']);
$admin_id = $_SESSION['admin_id'];

require "./database/bloggin.php";
require "./partials/header.php";
require "./partials/sidenav.php";


if (isset($_POST['update'])) {
    $admin_id = $_POST['admin_id'];
    $admin_name = $_POST['name'];
    $updAdminPf = "UPDATE admins SET name=:name WHERE admin_id=:admin_id";
    $a = $pdo->prepare($updAdminPf);
    $a->bindParam(":name", $admin_name, PDO::PARAM_STR);
    $a->bindParam(":admin_id", $admin_id, PDO::PARAM_STR);
    $update = $a->execute();
    if ($update) {
        header("location:admin-dashboard.php");
    } else {
        $errors[] = "Errors";
    }
}
?>
<div class="col-span-6 m-auto pe-10">
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8  ">
        <div class="w-96 p-3.5 border border-black shadow rounded bg-white">
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
                    $qry = "SELECT name FROM admins WHERE admin_id=:admin_id";

                    $q = $pdo->prepare($qry);
                    $q->bindParam(":admin_id", $admin_id, PDO::PARAM_STR);
                    $q->execute();
                    $qres = $q->fetch();
                    ?>
                    <!-- NAME -->
                    <input type="hidden" value="<?= $_SESSION['admin_id'] ?>" name="admin_id">
                    <div class="mt-2">
                        <input name="name" type="text" placeholder="<?= $qres['name'] ?>" class="block  px-3 w-full rounded-md border border-stone-700 mb-4 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
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
        </form>
    </div>
    <?php
    require "./partials/footer.php";
    ?>