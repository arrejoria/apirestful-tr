<?php

require_once 'clases/auth.class.php';
require_once 'clases/responses.class.php';

// $_auth = new auth;
$_responses = new responses;


if($_SERVER["REQUEST_METHOD"] === 'POST'){

}else{
     echo "metodo no permitido";
}