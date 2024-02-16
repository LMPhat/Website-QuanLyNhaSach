<?php
require 'class/Database.php';
require 'class/Auth.php';

session_start();

Auth::logout();