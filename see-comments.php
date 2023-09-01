<?php
session_start();
$admin = isset($_SESSION['admin']);

require "./database/bloggin.php";
require "./partials/header.php";
require "./partials/sidenav.php";
?>
<div class="col-span-6 w-full block ">
    <!-- post comment div -->
    <div class="postComment pe-10 mt-5 mb-10 ">
        <h1 class="text-center text-xl mb-5">Post Comments</h1>
        <div class="comment-div border border-stone-500 rounded shadow w-full block bg-white">
            <div class="header bg-cyan-900 text-white py-2 px-2.5 text-left ">post comment</div>
            <div class="comment-box py-2 px-4">
                <p class="bg-slate-50 text-stone-800 py-2.5 px-2.5 text-left border border-stone-500 rounded my-2">No
                    comments added yet..php</p>
            </div>
        </div>
    </div>
    <?php
    require "./partials/footer.php";
    ?>