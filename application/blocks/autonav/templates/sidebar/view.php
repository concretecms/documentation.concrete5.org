<?php defined('C5_EXECUTE') or die("Access Denied.");

$navItems = $controller->getNavItems();
$c = Page::getCurrentPage();

/**
 * Each nav item object contains the following information:
 *	$navItem->url        : URL to the page
 *	$navItem->name       : page title (already escaped for html output)
 *	$navItem->target     : link target (e.g. "_self" or "_blank")
 *	$navItem->level      : number of levels deep the current menu item is from the top (top-level nav items are 1, their sub-items are 2, etc.)
 *	$navItem->subDepth   : number of levels deep the current menu item is *compared to the next item in the list* (useful for determining how many <ul>'s to close in a nested list)
 *	$navItem->hasSubmenu : true/false -- if this item has one or more sub-items (sometimes useful for CSS styling)
 *	$navItem->isFirst    : true/false -- if this is the first nav item *in its level* (for example, the first sub-item of a top-level item is TRUE)
 *	$navItem->isLast     : true/false -- if this is the last nav item *in its level* (for example, the last sub-item of a top-level item is TRUE)
 *	$navItem->isCurrent  : true/false -- if this nav item represents the page currently being viewed
 *	$navItem->inPath     : true/false -- if this nav item represents a parent page of the page currently being viewed (also true for the page currently being viewed)
 *	$navItem->attrClass  : Value of the 'nav_item_class' custom page attribute (if it exists and is set)
 *	$navItem->isHome     : true/false -- if this nav item represents the home page
 *	$navItem->cID        : collection id of the page this nav item represents
 *	$navItem->cObj       : collection object of the page this nav item represents (use this if you need to access page properties and attributes that aren't already available in the $navItem object)
 */


/**
 * @param $items
 * @return \Generator
 */
$item_generator = function($items) {
    $length = count($items);
    for ($i = 0; $i < $length;) {
        $item = $items[$i];
        if ($item->isHome) {
            $i++;
            continue;
        }
        $item->children = [];

        do {
            $i++;
            $next_item = $items[$i];

            if ($next_item->level <= $item->level) {
                break;
            }

            $item->children[] = $next_item;

        } while ($i < $length);

        yield $item;
    }
}

?>
<ul class="nav nav-stacked nav-sidebar">
    <?php
    foreach ($item_generator($navItems) as $item) {
        ?>
        <li class="<?= $item->isCurrent ? 'active' : '' ?>">
            <a href="<?= $item->url ?>"><?= $item->name ?></a>
            <?php
            if ($item->children) {
                ?>
                <ul class="nav nav-stacked nav-sub-sidebar">
                    <?php
                    foreach ($item->children as $child) {

                        ?>
                        <li class="<?= $child->isCurrent ? 'active' : '' ?>">
                            <a href="<?= $child->url ?>"><?= $child->name ?></a>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
                <?php
            }
            ?>
        </li>
        <?php
    }
    ?>
</ul>

