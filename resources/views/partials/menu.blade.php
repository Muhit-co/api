<?php
$pages = array();
if(isset($role)):

    // defining menu items for citizen users
    if ($role == 'user'):

        $pages = array(
            array(
                'name' => 'TÜMÜ',
                'uri' => '/',
                'icon' => 'ion-android-home'
            ),
            array(
                'name' => 'DESTEKLEDİKLERİM',
                'uri' => '/issues/supported',
                'icon' => 'ion-thumbsup'
            ),
            array(
                'name' => 'FİKİRLERİM',
                'uri' => '/issues/created',
                'icon' => 'ion-lightbulb'
            ),
            array(
                'name' => 'DUYURULAR',
                'uri' => '/announcements',
                'icon' => 'ion-speakerphone'
            ),
            array(
                'name' => 'MUHTARIM',
                'uri' => '/muhtar',
                'icon' => 'ion-information-circled'
            ),
        );

    // defining menu items for muhtar & belediye users
    elseif ($role == 'admin'):

        $pages = array(
            array(
                'name' => 'TÜMÜ',
                'uri' => '/',
                'icon' => 'ion-android-home'
            ),
            array(
                'name' => 'GELİŞMEKTE',
                'uri' => '/issues/development',
                'icon' => 'ion-wrench'
            ),
            array(
                'name' => 'ÇÖZÜLENLER',
                'uri' => '/issues/solved',
                'icon' => 'ion-ios-checkmark'
            ),
            array(
                'name' => 'DUYURULARIM',
                'uri' => '/announcements',
                'icon' => 'ion-speakerphone'
            ),
            array(
                'name' => 'İLETİSİM BİLGİSİ',
                'uri' => '/muhtar',
                'icon' => 'ion-person'
            ),
        );

    // defining menu items for super admins
    elseif ($role == 'superadmin'):

        $pages = array(
            array(
                'name' => 'TÜMÜ',
                'uri' => '/',
                'icon' => 'ion-android-home'
            ),
        );

    endif;

endif;
?>


<ul id="menu">
    <?php
    // output menu content
    foreach($pages as $page):
    ?>
    <li{{ Request::is( $page['uri'] ) ? ' class=active' : '' }}>
        <a href="{{ URL::to( $page['uri']) }}" class="u-nowrap">
            <i class="ion <?php echo $page['icon'] ?> ion-15x"></i>
            <?php echo $page['name'] ?>
        </a>
    </li>
    <?php endforeach; ?>
</ul>
