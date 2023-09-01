<!-- blogo.nav -->


<?php
$user_id = isset($_SESSION['user_id']);
// $user_id = $_SESSION['user_id'];
require "./database/bloggin.php";
// require "./partials/header.php";
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tw-elements/dist/css/tw-elements.min.css" />
<nav class="relative flex w-full flex-wrap items-center justify-between bg-[#FBFBFB] py-2 text-neutral-500 shadow-lg hover:text-neutral-700 focus:text-neutral-700 bg-white   border-b border-black px-40">

    <!-- Brand -->
    <a class="brand text-bold text-mono text-lg text-blue-800" href="blogo.php">
        Blogo
    </a>
    <div class="form  flex justify-center items-center h-fit">
        <form class="hidden md:flex " action="search.php" method="post" role="search">
            <input type="text" name="search_box" class="relative m-0 block w-[250px] h-fit min-w-0 flex-auto rounded border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-0.5 text-base font-normal leading-[1.6] text-dark outline-none transition duration-200 ease-in-out focus:z-[3] focus:border-black focus:text-black focus:shadow-[inset_0_0_0_1px_rgb(59,113,202)] focus:outline-none dark:border-black dark:text-neutral-800 dark:placeholder:text-black dark:focus:border-primary motion-reduce:transition-none" placeholder="Search" aria-label="Search" aria-describedby="button-addon2" />
            <!--Search icon-->
            <button class="btn btn-outline-success ms-3" name="search_btn" type="submit"> <i class="fa-solid fa-magnifying-glass text-black h-fit"></i></button>
        </form>
    </div>
    <!-- Right elements -->
    <div class="rightEl ">
        <ul class="list-style-none ml-auto flex flex-row pl-0 md:pl-4 items-center justify-center gap-5 " data-te-navbar-nav-ref aria-expanded="false">
            <li class=" relative flex">
                <div x-data="{ isActive: false }" class=" ">
                    <div class="inline-flex  items-center justify-center overflow-hidden rounded-md border bg-black-800">
                        <a href="#" class="border-e px-4 py-2 text-sm/none  text-gray-600 hover:bg-gray-50 hover:text-gray-700">
                            Menu
                        </a>

                        <button x-on:click="isActive = !isActive" class="h-full p-2 text-gray-600 hover:bg-gray-50 hover:text-gray-700">
                            <span class="sr-only">Menu</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>

                    <div class="absolute end-0 z-10 mt-2 w-56 rounded-md border border-gray-100 bg-white shadow-lg" role="menu" x-cloak x-transition x-show="isActive" x-on:click.away="isActive = false" x-on:keydown.escape.window="isActive = false">
                        <div class="p-2">
                            <a href="blogo.php" class="block rounded-lg px-4 py-2 text-sm text-gray-500 hover:bg-gray-50 hover:text-gray-700" role="menuitem">
                                <i class="fa-solid fa-angle-right text-sky-500 me-3"></i> <span class="hover:ms-4 transition ease-in-out delay-200">home</span>
                            </a>
                            <a href="view-allPosts.php" class="block rounded-lg px-4 py-2 text-sm text-gray-500 hover:bg-gray-50 hover:text-gray-700" role="menuitem">
                                <i class="fa-solid fa-angle-right text-sky-500 me-3"></i> <span class="hover:ms-4 transition ease-in-out delay-200">posts</span>
                            </a>
                            <a href="category.php" class="block rounded-lg px-4 py-2 text-sm text-gray-500 hover:bg-gray-50 hover:text-gray-700" role="menuitem">
                                <i class="fa-solid fa-angle-right text-sky-500 me-3"></i> <span class="hover:ms-4 transition ease-in-out delay-200">category</span>
                            </a>
                            <a href="admins.php" class="block rounded-lg px-4 py-2 text-sm text-gray-500 hover:bg-gray-50 hover:text-gray-700" role="menuitem">
                                <i class="fa-solid fa-angle-right text-sky-500 me-3"></i> <span class="hover:ms-4 transition ease-in-out delay-200">admins</span>
                            </a>
                            <a href="login.php" class="block rounded-lg px-4 py-2 text-sm text-gray-500 hover:bg-gray-50 hover:text-gray-700" role="menuitem">
                                <i class="fa-solid fa-angle-right text-sky-500 me-3"></i> <span class="hover:ms-4 transition ease-in-out delay-200">login</span>
                            </a>
                            <a href="register.php" class="block rounded-lg px-4 py-2 text-sm text-gray-500   hover:bg-gray-50  text-gray-700" role="menuitem">
                                <i class="fa-solid fa-angle-right text-sky-500 me-3"></i> <span class="hover:ms-4 transition ease-in-out delay-200">register</span>
                            </a>
                        </div>
                    </div>
                </div>
            </li>

            <!-- user -->
            <div class="relative" data-te-dropdown-ref>
                <button class="" data-te-dropdown-toggle-ref aria-expanded="false" data-te-ripple-init data-te-ripple-color="light">
                    <i class="fa-solid fa-user text-slate-700 border border-slate-700 rounded p-1.5 hover:text-white hover:bg-slate-700"></i>
                </button>
                <style>
                    .mt {
                        margin-top: 10px !important;
                    }
                </style>
                <ul class=" mt absolute z-[1000] float-left  hidden  list-none overflow-hidden rounded-lg border border-gray-300 bg-white bg-clip-padding text-left text-base shadow-lg  [&[data-te-dropdown-show]]:block px-2 py-1 w-48" aria-labelledby="dropdownMenuButton1" data-te-dropdown-menu-ref>
                    <?php if ($user_id) : ?>
                        <li>
                            <a class="block w-full whitespace-nowrap bg-white px-4 py-2 text-sm font-normal  text-gray-500 hover:bg-gray-50   active:no-underline hover:text-slate-700 " href="update-profile.php" data-te-dropdown-item-ref> <i class="fa-solid fa-angle-right text-sky-500 me-3"></i>
                                <span class=" transition ease-in-out delay-200">Update Profile</span></a>
                        </li>
                        <li>
                            <a class="block w-full whitespace-nowrap bg-white px-4 py-2 text-sm font-normal  text-gray-500 hover:bg-gray-50 hover:text-gray-700  active:no-underline hover:text-slate-700" href="logout.php" data-te-dropdown-item-ref> <i class="fa-solid fa-angle-right text-sky-500 me-3"></i> <span class=" transition ease-in-out delay-200">Logout</span></a>
                        </li>
                    <?php else : ?>
                        <li>
                            <a class="block w-full whitespace-nowrap bg-white px-4 py-2 text-sm font-normal  text-gray-500 hover:bg-gray-50 hover:text-gray-700  active:no-underline hover:text-slate-700" href="login.php" data-te-dropdown-item-ref> <i class="fa-solid fa-angle-right text-sky-500 me-3"></i> <span class="hover:ms-2 transition ease-in-out delay-200">Login</span></a>
                        </li>
                        <li>
                            <a class="block w-full whitespace-nowrap bg-white px-4 py-2 text-sm font-normal  text-gray-500 hover:bg-gray-50 hover:text-gray-700  active:no-underline hover:text-slate-700" href="register.php" data-te-dropdown-item-ref> <i class="fa-solid fa-angle-right text-sky-500 me-3"></i> <span class="hover:ms-1 transition ease-in-out delay-200">Register</span></a>
                        </li>
                    <?php endif ?>

                </ul>
            </div>
        </ul>
    </div>
</nav>
<style>
    .hide {
        display: none !important;
    }

    .show {
        display: block !important;
    }
</style>
<div class="login-box absolute top-0 right-40 hide" id="login-box">
    <?php if ($user_id) : ?>
        <div class=" mt-16 w-60 bg-white border border-1 border-black px-3 py-4 rounded flex flex-col justify-center items-center h-fit p-absolute">
            <p class="text-black text-base text-center w-full"><?= $_SESSION['user_name'] ?></p>
            <div class=" mt-3 m-auto flex flex-col justify-center w-full  gap-2">
                <a href="update-profile.php" class="button h-full hover:bg-slate-700  bg-blue-500 p-2 rounded px-7 text-white text-sm text-center block w-full">Update
                    Profile</a>
                <div class="inout flex flex-row gap-2">
                    <a href="login.php" class="button  h-fit bg-orange-400 p-2 rounded px-7 text-white text-sm text-center block w-full hover:bg-slate-700">Login</a>
                    <a href="register.php" class="button  h-fit bg-orange-400 p-2 rounded px-7 text-white text-sm text-center block w-full hover:bg-slate-700">Register</a>
                </div>
                <a href="logout.php" class="button hover:bg-slate-700 h-full bg-red-400 p-2 rounded px-7 text-white text-sm text-center block w-full">
                    Log Out</a>
            </div>
        </div>
    <?php else : ?>
        <div class=" mt-16 w-60 bg-white border border-1 border-black px-3 py-4 rounded flex flex-col justify-center items-center h-fit p-absolute">
            <p class="text-black text-base text-center w-full">Please login first!</p>
            <div class=" mt-3 m-auto flex  flex-row justify-center w-full  gap-3">
                <a href="login.php" class="button  h-fit bg-orange-400 p-2 rounded px-7 text-white text-sm text-center block w-full hover:bg-slate-700">Login</a>
            </div>
        </div>
    <?php endif ?>
</div>
<script defer src="https://cdn.jsdelivr.net/npm/tw-elements/dist/js/tw-elements.umd.min.js"></script>
<script defer>
    // Initialization for ES Users
    import {
        Collapse,
        Dropdown,
        initTE,
    } from "tw-elements";

    initTE({
        Collapse,
        Dropdown
    });
</script>

<script defer>
    // Initialization for ES Users
    import {
        Dropdown,
        Ripple,
        initTE,
    } from "tw-elements";

    initTE({
        Dropdown,
        Ripple
    });
</script>

<script defer src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>