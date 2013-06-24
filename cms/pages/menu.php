        <div class="menu">
            <ul>
                <li><a href="../home.php?page=myplaces">Mijn plaatsen</a></li>
	            <li><a href="../home.php?page=newplace">Nieuwe plaats aanmaken</a></li> 
                <li><a href="../home.php?page=myaccount">Mijn account</a></li>          
			<?php	if($_SESSION["SESS_ROLE"] == 1) { ?>
                <li><a href="newuser.php">Gebruiker aanmaken</a>
                <li><a href="allusers.php">Alle gebruikers</a></li>
            <? } ?>
            	<li class="logout"><a href="../logout.php">Uitloggen</a></li>   
           </ul>
        </div>