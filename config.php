<?php


$mysqli = mysqli_connect('localhost', 'root', '', 'crudtest');

if (!$mysqli) {
    die("Connection failed: ".mysqli_connect_error());
}

