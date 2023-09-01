<?php
if (count($errors) > 0) {
    foreach ($errors as $err) {
        echo "<p class='text-center text-white bg-danger p-2  shadow' onclick='this.remove()'>$err</p>";
    }
}
