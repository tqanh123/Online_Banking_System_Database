<?php

session_start();
session_unset();
session_destroy();

header("Location: pages_index.php");
exit;
