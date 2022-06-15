<?php

function dd($data) : void {
    echo json_encode($data, JSON_PRETTY_PRINT);
    die();
}