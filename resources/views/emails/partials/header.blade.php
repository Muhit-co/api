<?php $first_name = (isset($username)) ? $username : '' ?>
{{ trans('email.welcome', array('username' => $first_name)) }},
<br /><br />
