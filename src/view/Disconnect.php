<?php
require_once '../../config/localConfig.php';

$_SESSION=[];
session_destroy();
header('location: ../../src/view/Connection.php');