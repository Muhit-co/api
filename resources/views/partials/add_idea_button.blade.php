<?php
$btn_text = (isset($text)) ? $text : 'FİKİR <span class="extended">EKLE</span>';
$btn_class = (isset($class)) ? $class : 'btn btn-primary';
if(isset($role) && $role != 'admin'):
    $loc_param = '';
    if(isset($_GET['location'])) {
        $loc_param = '?' . buildRelativeUrl('location', $_GET['location']);
    } else if(isset($hood)) {
        $loc_param = '?' . buildRelativeUrl('location', $hood->name . ', ' . $hood->district->name . ', ' . $hood->district->city->name);
    }
    $btn_link = ($role == 'user') ? '/issues/new' . $loc_param : 'javascript:openDialog(\'dialog_login\')';
?>
<a href="{{ $btn_link }}" class="{{ $btn_class }}"><i class="ion ion-plus u-mr5"></i> {!! $btn_text !!}</a>
<?php 
endif; 
?>
