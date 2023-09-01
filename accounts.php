<?php
session_start();
$admin = isset($_SESSION['admin']);
$admin1 = isset($_SESSION['admin1']);
$admin2 = isset($_SESSION['admin2']);
require "./database/bloggin.php";
require "./partials/header.php";
?>
<div class="grid lg:grid-cols-8  gap-12 bg-slate-50">
    <div class="sideBar col-span-2 pt-5 px-5 bg-yellow-10 border-black border-r-2 h-screen">
        <form action="" method="post">
            <h2 class=" text-black-50 text-center w-100 text-lg">Admin<span class="text-sky-400">Panel</span></h2>
            <div class="updateProfile mt-5 border border-black border-1 py-4">
                <?php if ($admin) : ?>
                    <p class="text-center"><?= $_SESSION['admin'] ?></p>
                <?php elseif ($admin1) : ?>
                    <p class="text-center"><?= $_SESSION['admin1'] ?></p>
                <?php elseif ($admin2) : ?>
                    <p class="text-center"><?= $_SESSION['admin2'] ?></p>
                <?php else : ?>
                <?php endif ?>
                <div class="update-profile    mt-3 flex justify-center">
                    <a href="update-profile.php" class="button w-100 bg-blue-500 p-2 rounded px-4 text-white text-sm text-center m-auto ">Update
                        Profile</a>

                </div>
        </form>
    </div>
    <div class="sidebar mt-10 ps-2">
        <ul class="flex  flex-col gap-7 ">
            <li><i class="fa-solid fa-house me-3 text-blue-700"></i><a href="home.php">Home</a></li>

            <li><i class="fa-solid fa-pen me-3 text-blue-700"></i><a href="add-post.php">add posts</a></li>

            <li><i class="fa-solid fa-eye me-3 text-blue-700"></i><a href="view-post.php"></a>view posts</li>

            <li><i class="fa-solid fa-user me-3 text-blue-700"></i><a href="accounts.php">accounts</a></li>

            <li><i class="fa-solid fa-right-from-bracket me-3 text-blue-700"></i><a href="logout.php" class="text-red-500">logout</a>
            </li>
        </ul>
        <div class="navBtns mt-10 flex flex-row gap-5 px-4">
            <a href="login.php" class="w-32 button bg-orange-400 py-2 px-5 rounded text-center text-white text-base">Login</a>
            <a href="register.php" class="w-32 button bg-orange-400 py-2 px-5 rounded text-white text-center ">Register</a>
        </div>
    </div>
</div>
<div class="flex flex-row justify-center  gap-10 col-span-6 bg-slate-50 pe-20 ">
    <div class="input w-72 mt-20 bg-white border border-1 border-black px-3 py-4 rounded flex flex-col justify-center items-center h-fit">
        <h1 class="text-center text-lg mb-3 font-mono">welcome!</h1>
        <div class="update-profile    mt-3 m-auto flex justify-center w-100">
            <a href="update-profile.php" class="button w-60 bg-blue-500 p-2 rounded px-4 text-white text-sm text-center ">Update
                Profile</a>
        </div>
    </div>
    <!-- add new post -->
    <div class="input w-72 mt-20  bg-white border border-1 border-black px-3 py-4 rounded flex flex-col justify-center items-center h-fit">
        <p>admin id : 1</p>
        <p>username : admin</p>
        <p>admin id : 1</p>
        <div class="add-post mt-3 m-auto flex  flex-row justify-center w-100 gap-3">
            <a href="add-post.php" class="button w-fit  h-fit bg-orange-400 p-2 rounded px-7 text-white text-sm text-center ">Update</a>
            <a href="add-post.php" class="button w-fit h-fit bg-red-400 p-2 rounded px-7 text-white text-sm text-center ">Add
                Delete</a>
        </div>
    </div>

</div>
<?php
require "./partials/footer.php";
?>