<?php

function getPDO()
{
    return new PDO('mysql:host=localhost;dbname=shop', 'root', '');
}
