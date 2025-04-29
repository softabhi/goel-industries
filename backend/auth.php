<?php
if(empty(session_start()))
    session_start();

if(isset($_SESSION['username']) && $_SESSION['username']){
   include_once 'connect.php';
}else{
   echo ' 
   <script>
     window.location.href = "index.php";
   </script>
   ';
}   