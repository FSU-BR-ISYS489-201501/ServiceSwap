<?php

function valid_pass($pass)
{
    if (!preg_match_all('$\S*(?=\S{7,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$', $pass))
        return FALSE;
    return TRUE;
}

?>