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
            'title' => 'Oluşturuldu'
        );
        if($issue_supporters < 5) {
            $issue_status['class'] = $status . '-empty';
        }
    } elseif($status == 'progress') {
        $issue_status = array(
            'class' => $status,
            'icon' => 'ion-wrench',
            'title' => 'Gelişmekte'
        );
    } elseif($status == 'solved') {
        $issue_status = array(
            'class' => $status,
            'icon' => 'ion-ios-checkmark',
            'title' => 'Çözüldü'
        );
    }

    return $issue_status;
}
