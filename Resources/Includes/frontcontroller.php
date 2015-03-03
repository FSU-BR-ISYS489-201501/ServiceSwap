<?php

function valid_pass($candidate)
{
    if (!preg_match_all('$\S*(?=\S{7,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$', $candidate))
        return FALSE;
    return TRUE;
}

?>