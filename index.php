<?php
session_start();
$user_id = isset($_SESSION['user_id']);

require "./database/bloggin.php";
require "./partials/header.php";
?>
<style>
.hide {
    display: none;
}

.show {
    display: block !important;
}
</style>
<div
    class="relative flex w-full flex-wrap items-center justify-between bg-[#FBFBFB] py-1 text-neutral-500 shadow-lg hover:text-neutral-700 focus:text-neutral-700 bg-white   border-b border-black px-40">

    <!-- Brand -->
    <a class="brand text-bold text-mono text-lg text-blue-800" href="blogo.php">
        Blogo
    </a>
    <div class="form  flex justify-center items-center h-fit  pt-3 ">
        <form class="hidden md:flex">
            <input type="search"
                class="relative m-0 block w-[250px] h-fit min-w-0 flex-auto rounded border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-0.5 text-base font-normal leading-[1.6] text-dark outline-none transition duration-200 ease-in-out focus:z-[3] focus:border-black focus:text-black focus:shadow-[inset_0_0_0_1px_rgb(59,113,202)] focus:outline-none dark:border-black dark:text-neutral-800 dark:placeholder:text-black dark:focus:border-primary motion-reduce:transition-none"
                placeholder="Search" aria-label="Search" aria-describedby="button-addon2" />

            <!--Search icon-->
            <span
                class="input-group-text flex justify-center items-center whitespace-nowrap rounded px-2 text-center text-base font-normal text-blue-700 dark:text-neutral-200  "
                id="basic-addon2">
                <i class="fa-solid fa-magnifying-glass text-black h-fit"></i>
            </span>
        </form>
    </div>
    <div class="rightEl">
        <ul class="list-style-none ml-auto flex flex-row pl-0 md:pl-4 items-center justify-center gap-5 "
            data-te-navbar-nav-ref>

            <!-- menu -->


            <li class=" relative flex invisible">
                <div x-data="{ isActive: false }" class=" ">
                    <div
                        class="inline-flex  items-center justify-center overflow-hidden rounded-md border bg-black-800">
                        <a href="#"
                            class="border-e px-4 py-2 text-sm/none  text-gray-600 hover:bg-gray-50 hover:text-gray-700">
                            Menu
                        </a>

                        <button x-on:click="isActive = !isActive"
                            class="h-full p-2 text-gray-600 hover:bg-gray-50 hover:text-gray-700">
                            <span class="sr-only">Menu</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>

                    <div class="absolute end-0 z-10 mt-2 w-56 rounded-md border border-gray-100 bg-white shadow-lg"
                        role="menu" x-cloak x-transition x-show="isActive" x-on:click.away="isActive = false"
                        x-on:keydown.escape.window="isActive = false">
                        <div class="p-2">
                            <a href="blogo.php"
                                class="block rounded-lg px-4 py-2 text-sm text-gray-500 hover:bg-gray-50 hover:text-gray-700"
                                role="menuitem">
                                <i class="fa-solid fa-angle-right text-sky-500 me-3"></i> <span
                                    class="hover:ms-4 transition ease-in-out delay-200">home</span>
                            </a>

                            <a href="view-allPosts.php"
                                class="block rounded-lg px-4 py-2 text-sm text-gray-500 hover:bg-gray-50 hover:text-gray-700"
                                role="menuitem">
                                <i class="fa-solid fa-angle-right text-sky-500 me-3"></i> <span
                                    class="hover:ms-4 transition ease-in-out delay-200">posts</span>
                            </a>

                            <a href="category.php"
                                class="block rounded-lg px-4 py-2 text-sm text-gray-500 hover:bg-gray-50 hover:text-gray-700"
                                role="menuitem">
                                <i class="fa-solid fa-angle-right text-sky-500 me-3"></i> <span
                                    class="hover:ms-4 transition ease-in-out delay-200">category</span>
                            </a>

                            <a href="admins.php"
                                class="block rounded-lg px-4 py-2 text-sm text-gray-500 hover:bg-gray-50 hover:text-gray-700"
                                role="menuitem">
                                <i class="fa-solid fa-angle-right text-sky-500 me-3"></i> <span
                                    class="hover:ms-4 transition ease-in-out delay-200">admins</span>
                            </a>
                            <a href="login.php"
                                class="block rounded-lg px-4 py-2 text-sm text-gray-500 hover:bg-gray-50 hover:text-gray-700"
                                role="menuitem">
                                <i class="fa-solid fa-angle-right text-sky-500 me-3"></i> <span
                                    class="hover:ms-4 transition ease-in-out delay-200">login</span>
                            </a>
                            <a href="register.php"
                                class="block rounded-lg px-4 py-2 text-sm text-gray-500   hover:bg-gray-50  text-gray-700"
                                role="menuitem">
                                <i class="fa-solid fa-angle-right text-sky-500 me-3"></i> <span
                                    class="hover:ms-4 transition ease-in-out delay-200">register</span>
                            </a>
                        </div>
                    </div>
                </div>
            </li>
            <!-- user -->
            <li class="px-2 mt-10" id="btn">
                <i class="fa-solid fa-user bg-grey-200 border border-grey rounded p-2"></i>
            </li>

        </ul>
    </div>
    <div class="login-box absolute top-10 right-40 hide" id="login_div">
        <?php if ($user_id) : ?>
        <div
            class=" mt-16 w-60 bg-white border border-1 border-black px-3 py-4 rounded flex flex-col justify-center items-center h-fit p-absolute">
            <p class="text-black text-base text-center w-full"><?= $_SESSION['user_name'] ?></p>
            <div class=" mt-3 m-auto flex flex-col justify-center w-full  gap-2">
                <a href="update-profile.php"
                    class="button h-full hover:bg-slate-700  bg-blue-500 p-2 rounded px-7 text-white text-sm text-center block w-full">Update
                    Profile</a>
                <div class="inout flex flex-row gap-2">
                    <a href="login.php"
                        class="button  h-fit bg-orange-400 p-2 rounded px-7 text-white text-sm text-center block w-full hover:bg-slate-700">Login</a>
                    <a href="register.php"
                        class="button  h-fit bg-orange-400 p-2 rounded px-7 text-white text-sm text-center block w-full hover:bg-slate-700">Register</a>
                </div>
                <a href="logout.php"
                    class="button hover:bg-slate-700 h-full bg-red-400 p-2 rounded px-7 text-white text-sm text-center block w-full">
                    Log Out</a>
            </div>
        </div>
        <?php else : ?>
        <div
            class=" mt-16 w-60 bg-white border border-1 border-black px-3 py-4 rounded flex flex-col justify-center items-center h-fit p-absolute">
            <p class="text-black text-base text-center w-full">Please login first!</p>
            <div class=" mt-3 m-auto flex  flex-row justify-center w-full  gap-3">
                <a href="login.php"
                    class="button  h-fit bg-orange-400 p-2 rounded px-7 text-white text-sm text-center block w-full hover:bg-slate-700">Login</a>
            </div>
        </div>
        <?php endif ?>
    </div>
</div>
<script>
let btn = document.getElementById("btn");
let box = document.getElementById("login_div");
btn.addEventListener('click', function() {
    if (box.classList.contains("hide")) {
        box.classList.remove("hide");
        box.classList.add("show");
    }
    if (box.classList.contains("show")) {
        box.classList.remove("show");
        box.classList.add("hide");
    }
})

// function myFunction() {
//     // alert("kdf");
//     let x = document.getElementById("login_div");
//     if (x.classList.contains("hidden")) {
//         // console.log('pp');
//         x.classList.remove("hidden");
//     } else {
//         x.classList.add("hidden");
//     }
// }
</script>

<?php
require "./partials/footer.php";
?>

<?php
$postComment_qry = "SELECT * FROM comments RIGHT JOIN users ON comments.user_id=users.user_id";
$c = $pdo->prepare($postComment_qry);
// $c->bindParam(":user_id", $user_id, PDO::PARAM_INT);
$c->execute();
$cres = $c->fetchAll(PDO::FETCH_ASSOC);
print_r($cres);
die();
foreach ($cres as $key => $allcomment) :
?>