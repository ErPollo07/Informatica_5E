<?php
function print_array($array) {
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            echo $key . " {" . "<br>" . print_array($value) . "}";
        } else {
            echo $key . " " . $value . "<BR>";
        }
    }
}