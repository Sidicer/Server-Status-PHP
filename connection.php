<?php

$server_credentials    = array();
$server_credentials[0] = "HOST";
$server_credentials[1] = "USERNAME";
$server_credentials[2] = "PASSWORD";
$server_credentials[3] = "DATABASE";

$conn = new mysqli($server_credentials[0], $server_credentials[1], $server_credentials[2], $server_credentials[3]);
if ($conn->connect_errno) return false;