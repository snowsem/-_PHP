<?php
/**
 * Created by PhpStorm.
 * User: semenpatnickij
 * Date: 05.03.16
 * Time: 19:03
 */
require 'QAR.php';

$init = new QAR();
if (isset($_GET['method'])) {
    $m = $_GET['method'];

    switch($m){
        case "subject":
            $init->get_subject($_GET['query']);
            break;
        case "city":
            $init->get_city($_GET['query'], $_GET['param']);
            break;
        case "street":
            $init->get_street($_GET['query'], $_GET['param']);
            break;
        case "passport":
            $init->get_passport_code($_GET['query']);
            break;


        default:
            print '0';
            break;
    }

}





