<?php

function  check_limit( $page  ,  $numberOfPages ) {
    if($page >=1 && $page <=$numberOfPages) {
        return  true;
    }else {
        return false;
    }
}