<?php
session_start();
$admin = isset($_SESSION['admin']);
require "./database/bloggin.php";
require "./partials/header.php";
require "./partials/sidenav.php";
?>
<!-- see post div -->
<div class="col-span-6 bg-slate-50 pe-8 ">
    <h1 class="text-center text-xl text-black-800 font-semibold mt-5 mb-5"> Posts</h1>
    <!-- post divs-->
    <div class="grid grid-cols-3 gap-3">
        <!-- adimin post -->
        <!-- first post -->
        <div class=" border border-stone-500 w-full p-3.5 rounded shadow bg-white">
            <div class="bg-white w-full">
                <!--Banner image-->
                <img class="rounded-lg w-full mt-4 mb-4" src="https://images.unsplash.com/photo-1603349206295-dde20617cb6a?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=750&q=80
                      " />
                <!-- active btn -->
                <div class="btn mb-3">
                    <a href="" class="bg-orange-500 text-sm py-1 px-2 rounded text-white ">active</a>
                </div>
                <!--Title-->
                <h1 class="font-semibold text-gray-900 leading-none text-base mt-1 capitalize truncate">
                    the life of albert einstein
                </h1>
                <!--Description-->
                <div class="max-w-full mb-5">
                    <p class="text-base mt-2 font-medium tracking-wide text-gray-600 mt-1">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Obcaecati
                        vel soluta dolore id nesciunt eum nam ipsam, eveniet cupiditate sint
                        veritatis harum odit. Iste dignissimos, ad provident nulla
                        voluptatum ut.
                    </p>
                </div>

                <!-- message,love -->
                <div
                    class="response-box w-full block bg-stone-200 border border-black rounded flex justify-between px-2 py-2 mt-4">
                    <div class="message">
                        <i class="fa-solid fa-message text-stone-500 me-1 "></i><span class="">(0)</span>
                    </div>
                    <div class="love">
                        <i class="fa-solid fa-heart text-stone-500 me-1 "></i><span
                            class="text-blue-800 text-semibold">(0)</span>
                    </div>
                </div>
                <!-- edit and delete -->
                <div class="editDelete-btns text-left block w-full mt-6 gap-2 flex">
                    <a href="" class="bg-orange-500 py-1.5 px-3.5 text-sm text-white  text-center rounded w-full">Edit
                    </a>
                    <a href="" class="bg-red-500 py-1.5 px-3.5 text-sm text-white  text-center rounded w-full">Delete
                    </a>
                </div>
                <!-- view posts btn -->
                <div class="viewPosts-btns   w-full mt-3 ">
                    <a href=""
                        class="bg-blue-500 py-1.5 px-3.5 text-sm text-white  text-center rounded block w-full">View
                        Posts
                    </a>
                </div>
                <!-- ends of inside elements -->
            </div>
        </div>

    </div>
</div>
</div>
<?php
require "./partials/footer.php";
?>