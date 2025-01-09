<?php
    $page = $_SERVER['PHP_SELF'];

?>

<aside class="sidebar">
            <h2 class="sidebar-title">RENTAL CAR</h2>
            <ul class="sidebar-list">
                <li class="sidebar-item"><a href="./reservation_clients.php" class="sidebar-link <?php  if($page ==  '/pages/index.php') echo 'active' ?>">reservation</a></li>
                <li class="sidebar-item"><a href="./voiture_client.php" class="sidebar-link  <?php  if($page ==  '/pages/reservations.php') echo 'active' ?>">voitures</a></li>
               
                
            </ul>
        </aside>