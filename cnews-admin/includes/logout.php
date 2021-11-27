<?php


use \CNEWS\User;
User::logout_user();

header('Location: /login');
exit();