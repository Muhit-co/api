<?php

function getIssueStatus($status, $issue_supporters) {
    $issue_status = array(
        'class' => '',
        'icon' => 'ion-lightbulb',
        'title' => ''
    );
    if($status == 'new') {
        $issue_status = array(
            'class' => $status,
            'icon' => 'ion-lightbulb',
            'title' => trans('issues.created')
        );
        if($issue_supporters < 5) {
            $issue_status['class'] = $status . '-empty';
        }
    } elseif($status == 'progress') {
        $issue_status = array(
            'class' => $status,
            'icon' => 'ion-wrench',
            'title' => trans('issues.in_progress')
        );
    } elseif($status == 'solved') {
        $issue_status = array(
            'class' => $status,
            'icon' => 'ion-ios-checkmark',
            'title' => trans('issues.solved')
        );
    }

    return $issue_status;
}


function buildRelativeUrl($param, $value) {
    parse_str($_SERVER['QUERY_STRING'], $query_string);
    $query_string[$param] = $value;
    return http_build_query($query_string);
}

function strTRtoEN($source) {
    $turkish = array("Ü", "Ş", "Ğ", "Ç", "İ", "Ö", "ü", "ş", "ç", "ı", "ö", "ğ"); // turkish letters
    $english = array("U", "S", "G", "C", "I", "O", "u", "s", "c", "i", "o", "g"); // corresponding english letters
    $result = str_replace($turkish, $english, $source); //replace php function
    return $result;
}
