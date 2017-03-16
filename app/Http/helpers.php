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
function buildRelativeUrl($param, $value, $remove = '') {
    parse_str($_SERVER['QUERY_STRING'], $query_string);
    $query_string[$param] = $value;
    if(strlen($remove) > 0) {
        $query_string[$remove] = '';
    }
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

// Returns link to support form, currently Google Docs
function getSupportLink() {
    $url = 'https://docs.google.com/forms/d/1Gwyj1OZ_MkMF7QYBN625ADYWIifMsQdFqACA7uTcof0/viewform';
    return $url;
}

// Returns link to Hikaye website based on current language
function getStoryLink($page = '') {
    $base = '//hikaye.muhit.co/';
    $lang_ext = (App::getLocale() == 'en') ? 'en/' : '';
    return $base . $lang_ext . $page;
}

// Returns link of cloudfront hosted image
function getImageURL($url, $size = '80x80') {
    $baseURL = '//d1vwk06lzcci1w.cloudfront.net/';
    $fullURL = $baseURL . $size . '/' . $url;
    return $fullURL;
}

// Returns an array with attachment options for Slack message
function getSlackIssueAttachment($issue) {

    $user_display = ($issue['is_anonymous'] === 1) ? '(Anonymous)' : $issue['user']['first_name'] . ' ' . $issue['user']['last_name'];
    $tags_display = '';
    foreach($issue['tags'] as $key => $tag) { 
        $tags_display .= $tag['name']; 
        $tags_display .= ($key !== count($issue['tags']) - 1) ? ', ' : '';
    }
    $thumb_display = (count($issue['images']) > 0) ? getImageURL($issue['images'][0]['image'], '75x75') : '';

    $attachments = [
        'fallback'  => 'New idea added: *' . $issue['title'] . '*',
        'color'     => '#44a1e0',
        'mrkdwn_in' => ['text', 'fallback', 'fields'],
        'fields'    => [
            [
                'title' => ':bulb: ' . $issue['title'],
                'value' => '_' . $issue['location'] . '_'
            ],
            [
                'value' => ':confused: *Problem*: ' . $issue['problem']
            ],
            [
                'value' => ':smiley: *Solution*: ' . $issue['solution']
            ],
            [
                'title' => ':bust_in_silhouette: ' . $user_display,
                'value' => '_Added on: ' . strftime('%d %B %Y', strtotime( $issue['created_at'] )) . '_'
            ],
            [
                'title' => ':pushpin: Tags',
                'value' => $tags_display,
                'short' => true

            ],
            [
                'title' => ':arrow_right: Go to idea',
                'value' => 'muhit.co/issues/view/' . $issue['id'],
                'short' => true
            ]
        ],
        'thumb_url' => $thumb_display,
        'footer' => 'Muhit.co'
    ];

    return $attachments;
}

// Returns an array with attachment options for Slack message
function getSlackCommentAttachment($comment) {

    $attachments = [
        'fallback'  => 'New comment added: *' . $comment->id . '*',
        'color'     => '#245672',
        'mrkdwn_in' => ['text', 'fallback', 'fields'],
        'fields'    => [
            [
                'title' => $comment->comment,
                'value' => ':bust_in_silhouette: ' . $comment->user_name
            ],
            [
                'title' => 'In response to issue "' . $comment->issue_title . '"',
                'value' => ':arrow_right: muhit.co/issues/view/' . $comment->issue_id . '#comment-' . $comment->id,
            ],
        ],
        'footer' => 'Muhit.co',
        'footer_icon' => '//muhit.co/images/favicon.png',

    ];

    return $attachments;
}