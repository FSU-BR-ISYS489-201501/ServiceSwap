<?php

function valid_pass($pass)
{
    if (!preg_match_all('$\S*(?=\S{7,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$', $pass))
        return FALSE;
    return TRUE;
}
function valid_email($email)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        return FALSE;

    return TRUE;
}

?>