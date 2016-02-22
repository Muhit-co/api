<?php
$menu_items = array();
if(isset($role)):

    // defining menu items for citizen users
    if ($role == 'user'):

        $menu_items = array(
            array(
                'name' => trans('issues.all_cap'),
                'uri' => '/fikirler/all',
                'icon' => 'ion-android-home'
            ),
            array(
                'name' => trans('issues.my_ideas_cap'),
                'uri' => '/issues/created',
                'icon' => 'ion-lightbulb'
            ),
            array(
                'name' => trans('issues.my_supported_ones_cap'),
                'uri' => '/issues/supported',
                'icon' => 'ion-thumbsup'
            ),
            array(
                'name' => trans('issues.announcements_cap'),
                'uri' => '/duyurular',
                'icon' => 'ion-speakerphone'
            ),
            array(
                'name' => trans('issues.my_muhtar_cap'),
                'uri' => '/muhtar',
                'icon' => 'ion-information-circled'
            ),
        );

    // defining menu items for muhtar & belediye users
    elseif ($role == 'admin'):

        $menu_items = array(
            array(
                'name' => trans('issues.in_my_mahalle_cap'),
                'uri' => '/',
                'icon' => 'ion-android-home'
            ),
            array(
                'name' => trans('issues.all_ideas_cap'),
                'uri' => '/fikirler/all',
                'icon' => 'ion-lightbulb'
            ),
            array(
                'name' => trans('issues.my_announcements_cap'),
                'uri' => '/duyurular',
                'icon' => 'ion-speakerphone'
            ),
            array(
                'name' => trans('issues.my_profile_cap'),
                'uri' => '/members/my-profile',
                'icon' => 'ion-person'
            ),
        );

    // defining menu items for super admins
    elseif ($role == 'superadmin'):

        $menu_items = array(
            array(
                'name' => trans('issues.ideas_cap'),
                'uri' => '/fikirler/all',
                'icon' => 'ion-lightbulb'
            ),
            array(
                'name' => trans('issues.users_cap'),
                'uri' => '/admin/members',
                'icon' => 'ion-person-stalker'
            ),
        );

    endif;

endif;
?>


<ul class="menu">
    <?php
    // output menu content
    foreach($menu_items as $menu_item):
    ?>
    <li{{ (ltrim(Request::path(), '/') == ltrim($menu_item['uri'], '/') ) ? ' class=active' : '' }}>
        <a href="{{ URL::to( $menu_item['uri']) }}" class="u-nowrap" data-path="{{ Request::path() }}" data-ltrim="{{ ltrim($menu_item['uri'], '/') }}">
            <i class="ion <?php echo $menu_item['icon'] ?> ion-15x"></i>
            <span class="text"><?php echo $menu_item['name'] ?></span>
        </a>
    </li>
    <?php endforeach; ?>
</ul>
