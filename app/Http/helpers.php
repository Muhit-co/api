<?php

// Returns issues status array(class, icon, title) based on status
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
    } elseif($status == 'in-progress') {
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

// Adds query parameter to current url
function buildRelativeUrl($param, $value) {
    parse_str($_SERVER['QUERY_STRING'], $query_string);
    $query_string[$param] = $value;
    return http_build_query($query_string);
}

// Removes Turkish characters with url-friendly ones
function strTRtoEN($source) {
    $turkish = array("Ü", "Ş", "Ğ", "Ç", "İ", "Ö", "ü", "ş", "ç", "ı", "ö", "ğ"); // turkish letters
    $english = array("U", "S", "G", "C", "I", "O", "u", "s", "c", "i", "o", "g"); // corresponding english letters
    $result = str_replace($turkish, $english, $source); //replace php function
    return $result;
}


// Clears $url from given query parameter $key
function clearParam($url, $key) { 
    $url = preg_replace('/(.*)(?|&)' . $key . '=[^&]+?(&)(.*)/i', '$1$2$4', $url . '&'); 
    $url = substr($url, 0, -1); 
    return $url; 
}

// returns human-readable user role based on level
function getUserLevel($level, $plural = false) {
    $roles = [
        'User', // 0
        '', // 1
        '', // 2
        'Rejected muhtar', // 3
        'Pending muhtar', // 4
        'Muhtar', // 5
        '', // 6
        '', // 7
        '', // 8
        '', // 9
        'Admin' // 10
    ];
    $result = $roles[$level];
    if ($plural != false) {
        $result .= 's';
    }
    return $result;
}

// returns link to support form, currently Google Docs
function getSupportLink() {
    $url = 'https://docs.google.com/forms/d/1Gwyj1OZ_MkMF7QYBN625ADYWIifMsQdFqACA7uTcof0/viewform';
    return $url;
}
