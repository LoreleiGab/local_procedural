<?php
if(isset($_GET['p']))
{
    $p = $_GET['p'];
}
else
{
    $p = "inicio";
}
include "local/".$p.".php";