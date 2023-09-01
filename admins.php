<?php
session_start();
$admin = isset($_SESSION['admin']);
require "./database/bloggin.php";
require "./partials/header.php";
require "./partials/navbar.php";

?>
<style>
    body {
        background-color: #F8FAFC;
    }
</style>
<div class="admins flex flex-col bg-slate-50 gap-0 mt-6">
    <div class="title">
        <h1 class="text-center text-2xl text-black-800 font-semibold mt-5 mb-5">Your Posts</h1>
    </div>
    <div class="flex flex-row justify-center items-center gap-4 flex-wrap  bg-slate-50 mt-4 grid grid-cols-2 px-56 ">
        <?php
        $showAdminName_qry = "SELECT DISTINCT name , posts.admin_id FROM posts LEFT JOIN  admins ON posts.admin_id=admins.admin_id ";
        $s = $pdo->prepare($showAdminName_qry);
        $s->execute();
        $res = $s->fetchAll(PDO::FETCH_ASSOC);
        foreach ($res as $key => $admin) :
        ?>
            <!-- admin div -->
            <div class="input cols-span-6 bg-white border border-1 border-black px-5 py-4 rounded flex flex-col justify-center items-center h-fit ">
                <input type="hidden" value="<?= $admin['admin_id'] ?>">
                <p class="text-left w-full text-stone-600 text-lg font-semibold">admin : <span class="  ms-1 text-lg " style="color: #4834D4;"><?= $admin['name'] ?></span></p>
                <p class="text-left w-full text-stone-600 text-lg font-semibold">total posts : <span class="text-blue-700  ms-1 text-lg "><?= count($admin) ?></span></p>
                <p class="text-left w-full text-stone-600 text-lg font-semibold">posts likes : <span class="text-blue-700  ms-1 text-lg">1</span>
                </p>
                <p class="text-left w-full text-stone-600 text-lg font-semibold">posts comments : <span class="text-blue-700  ms-1 text-lg">1</span>
                </p>
                <div class="mt-3  flex justify-center w-full">
                    <a href="view-postbyadmin.php?admin_id=<?= $admin['admin_id'] ?>" class="button w-full bg-blue-500 p-2 rounded px-4 text-white text-base font-semibold text-center ">View
                        Posts
                    </a>
                </div>
            </div>
        <?php endforeach ?>
        <!-- -->

    </div>

</div>
<?php
require "./partials/footer.php";
?>