<?php

session_start();
unset($_SESSION['usuario_atual']);
session_destroy();
header('Location: /');
exit();
