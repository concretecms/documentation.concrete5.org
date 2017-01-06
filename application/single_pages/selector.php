<form method="post" action="<?=URL::to("/selector", "save")?>">

<?php

$home = Page::getByID(1);
print '<h1>Select Multiple And Add</h1>';
$ak = CollectionAttributeKey::getByHandle('tags');
$av = $home->getAttributeValueObject($ak);
$ak->render('form', $av);

print '<br><br>';

print '<h1>Select Single</h1>';
$ak = CollectionAttributeKey::getByHandle('select_single');
$av = $home->getAttributeValueObject($ak);
$ak->render('form', $av);

print '<br><br>';

print '<h1>Select One and Add</h1>';
$ak = CollectionAttributeKey::getByHandle('favorite_band');
$av = $home->getAttributeValueObject($ak);
$ak->render('form', $av);

print '<br><br>';

print '<h1>Select Multiple</h1>';
$ak = CollectionAttributeKey::getByHandle('os');
$av = $home->getAttributeValueObject($ak);
$ak->render('form', $av);

print '<br><br>';


print '<h1>Regular Sitemap</h1>';

?>

    <div class="sitemap-container"></div>
    <script type="text/javascript">
        $(function() {
            $('div.sitemap-container').concreteSitemap({
                includeSystemPages: true
            });
        });
    </script>
    <?php

    print '<br><br>';

    print '<h1>Classic Selector 1 Selected</h1>';

    print Core::make('helper/form/page_selector')->selectPage('cID1', 152);

    print '<h1>Classic Selector  - No selected</h1>';

    print Core::make('helper/form/page_selector')->selectPage('cID2');


    print '<h1>Select One</h1>';

print Core::make('helper/form/page_selector')->selectFromSitemap('a');

print '<br><br>';

print '<h1>Select Multiple - 3 selected</h1>';

print Core::make('helper/form/page_selector')->selectMultipleFromSitemap('b', array(168,151,166));

print '<br><br>';

print '<h1>Select Only Sections - 1 selected</h1>';

print Core::make('helper/form/page_selector')->selectFromSitemap('f', 155, HOME_CID, array('ptID' => '7'));

print '<br><br>';

print '<h1>Select Multiple Only Documents - 2 selected</h1>';

print Core::make('helper/form/page_selector')->selectMultipleFromSitemap('f', array(162,167), HOME_CID, array('ptID' => '8'));

print '<br><br>';

print '<h1>Select One - 1 selected</h1>';

print Core::make('helper/form/page_selector')->selectFromSitemap('c', 152);

print '<br><br>';

print '<h1>Select Multiple - 0 selected</h1>';

print Core::make('helper/form/page_selector')->selectMultipleFromSitemap('d');

print '<br><br>';

?>


    <button type="submit" name="submit">Go</button>

    </form>
