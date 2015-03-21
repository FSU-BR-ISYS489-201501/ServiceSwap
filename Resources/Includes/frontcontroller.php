<?php
// This function checks passwords to make sure they meet the requirements of 1 upper case letter 1 lower case letter 1 number and at least 7 char
function valid_pass($pass)
{
    if (!preg_match_all('$\S*(?=\S{7,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$', $pass))
        return FALSE;
    return TRUE;
}
//This checks to make sure that the email used is a valid email
function valid_email($email)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        return FALSE;

    return TRUE;
}

?>