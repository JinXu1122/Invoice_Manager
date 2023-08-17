<?php 
    require "data.php";
?>
<nav>
    <div class="container">
        <ul class="nav">
            <li class="nav-item"><a class="nav-link active" href="index.php">All</a></li>
            <li class="nav-item"><a class="nav-link" href="index.php?status=1">Draft</a></li>
            <li class="nav-item"><a class="nav-link" href="index.php?status=2">Pending</a></li>
            <li class="nav-item"><a class="nav-link" href="index.php?status=3">Paid</a></li>
            <li class="nav-item"><a class="nav-link" href="add.php">New</a></li>
        </ul>
    </div>
</nav>