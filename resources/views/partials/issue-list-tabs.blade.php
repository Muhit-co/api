<?php 
$active_tab = (isset($_GET['sort'])) ? $_GET['sort'] : 'latest';
?>
<ul class="tabs">
    <li>
        <a href="?<?php echo buildRelativeUrl('sort', 'latest') ?>" <?php echo ((isset($active_tab) and $active_tab == 'latest') ? 'class="active"' : ''); ?> >
            EN SON
        </a>
    </li>
    <li>
        <a href="?<?php echo buildRelativeUrl('sort', 'popular') ?>" <?php echo ((isset($active_tab) and $active_tab == 'popular') ? 'class="active"' : ''); ?>>
            POPÜLER
        </a>
    </li>
    <li>
        <a href="?<?php echo buildRelativeUrl('sort', 'map') ?>" <?php echo ((isset($active_tab) and $active_tab == 'map') ? 'class="active"' : ''); ?>>
            HARİTA
        </a>
    </li>
</ul>
