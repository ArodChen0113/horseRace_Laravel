<?php

if($result!=NULL) {
    foreach ($result as $key => $value) {
        echo "第" . ($key + 1) . "個號碼為" . $value . "<br />";
    }
}