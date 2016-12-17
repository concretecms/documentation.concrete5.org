<?php defined('C5_EXECUTE') or die("Access Denied."); ?>
<!DOCTYPE html>
<html lang="<?=Localization::activeLanguage()?>">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" type="text/css" href="<?=$view->getThemePath()?>/css/main.css">
    <?php Loader::element('header_required', array('pageTitle' => $pageTitle));?>
    <link rel="stylesheet" type="text/css" href="<?=$view->getThemePath()?>/css/bootstrap.min.css">
    <script type="text/javascript" src="<?=$view->getThemePath()?>/js/bootstrap.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
        if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
            var msViewportStyle = document.createElement('style')
            msViewportStyle.appendChild(
                document.createTextNode(
                    '@-ms-viewport{width:auto!important}'
                )
            )
            document.querySelector('head').appendChild(msViewportStyle)
        }
    </script>
</head>
<body>

<div class="<?=$c->getPageWrapperClass()?>">
