<!-- side nav -->
<div class="grid lg:grid-cols-8  gap-10 bg-slate-50 ">
    <div class="sideBar col-span-2 pt-5 px-5 bg-yellow-10 border-black border-r-2 h-screen sticky top-0 left-0 ">
        <form action="" method="post">
            <h2 class=" text-black-50 text-center w-100 text-lg">Admin<span class="text-sky-400">Panel</span></h2>
            <div class="updateProfile mt-5 border border-black border-1 py-4">
                <?php
                require "./database/bloggin.php";
                $qry = "SELECT name FROM admins WHERE admin_id=:admin_id";
                $q = $pdo->prepare($qry);
                $q->bindParam(":admin_id", $admin_id, PDO::PARAM_INT);
                $q->execute();
                $qres = $q->fetch();
                ?>
                <p class="text-center"><?php echo $qres['name'] ?? "" ?></p>
                <div class="update-profile    mt-3 flex justify-center">
                    <a href="update-adminProfile.php" class="button w-100 bg-blue-500 p-2 rounded px-4 text-white text-sm text-center m-auto ">Update
                        Profile</a>

                </div>
        </form>
    </div>
    <div class="sidebar mt-10 ps-9">
        <ul class="flex  flex-col gap-7 ">
            <li><i class="fa-solid fa-house me-3 text-blue-700"></i><a href="admin-dashboard.php">Home</a></li>

            <li><i class="fa-solid fa-pen me-3 text-blue-700"></i><a href="add-post.php">add posts</a></li>

            <li><i class="fa-solid fa-eye me-3 text-blue-700"></i><a href="your-posts.php">view your posts</a>
            </li>

            <li><i class="fa-solid fa-user me-3 text-blue-700"></i><a href="admin-accounts.php">accounts</a></li>

            <li><i class="fa-solid fa-right-from-bracket me-3 text-blue-700"></i><a href="logout.php" class="text-red-500">logout</a>
            </li>
        </ul>
        <div class="navBtns mt-10 flex flex-rows gap-2 w-full  block">
            <a href="login.php" class="w-full button bg-orange-500  rounded text-center text-white text-base py-1.5">Login</a>
            <a href="register.php" class="w-full button bg-orange-500 rounded text-white text-center py-1.5">Register</a>
        </div>
    </div>
</div>