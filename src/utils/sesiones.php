<?php

if (isset($_SESSION['autentificado']) && !empty($_SESSION['autentificado'])) {
  
  if($_SESSION["autentificado"] == 4040 || $_SESSION["autentificado"] == 3030) {
  }else{
    unset($_SESSION['user_id']);
    unset($_SESSION['user_name']);
    unset($_SESSION['user_email']);
    unset($_SESSION['autentificado']);
    session_unset();
    session_destroy();
    header("Location: ../");
  } 
} else {
  unset($_SESSION['user_id']);
  unset($_SESSION['user_name']);
  unset($_SESSION['user_email']);
  unset($_SESSION['autentificado']);
  session_unset();
  session_destroy();
  header("Location: ../");
}

?>