<?php 
 session_start(); //I wil resume my session thus
   
 unset($_SESSION['user_id']);            //unset the user ID >>check delete.php (without storage synax) >>>ONLY UNSETS IT DOESN'T DESTROY THE SESSION SO THE COUNTER IS STILL ON
  //session_destroy();//unset everything in a session,,destroys the session completly and every data, including the counter and  other variables

 header('location:index.php'); //can take to login page doesn't matter because index page  immediately redirect to login because he's not loggied in to login page ????????//WHAT IF TWO USERS WERE LOGGED IN??WILL IT BE UNDER THE SAME SESSION
 exit()

?>


  

