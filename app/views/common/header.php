<?php
header('content-type: text/html; charset=utf-8');
?><!doctype html>
<html lang="en-us">
<head>
    <title><?php echo (isset($title)) ? $title . " &#8211; " : '',
                      Site::getInstance()->getName() ?></title>
    <link href="<?php echo Url::route2url("animal/feed") ?>" rel="alternate"
          type="application/atom+xml"
          title="Latest Adoptable Animals &#8211; <?php echo Site::getInstance()->getName() ?>">
    <link href="<?php echo Url::getBase() ?>/css/screen.css" rel="stylesheet" media="screen">
</head>
<body>
    <div id="header">
        <div id="header_inner">
            <h1>
                <a href="<?php echo Url::getBase() ?>">
                    <?php echo Site::getInstance()->getName() ?>
                </a>
            </h1>

            <ul id="nav">
                <li><a href="<?php echo Url::getBase() ?>">Home</a></li>
                <li><a href="<?php echo Url::route2url("animal/browse") ?>">Browse</a></li>
                <li><a href="<?php echo Url::route2url("animal/feed") ?>">Updates</a></li>
                <li id="search">
                    <form action="<?php echo Url::route2url("animal/search") ?>"
                          method="get">
                        <label for="q">Search:</label>
                        <input id="q" name="q" type="text">
                        <button type="submit">
                            Go!
                        </button>
                    </form>
                </li>
            </ul>

        </div><!--//header_inner-->
    </div><!--//header-->

    <div id="mission">
        <div id="mission_inner">
            <div id="mission_photo">
                <img src="<?php echo Url::getBase() ?>/img/blossom.jpg"
                     alt="">
                Blossom, &copy; Jon-Michael Deldin.
            </div>
            <div id="mission_text">
                <p>
                    Our mission is to showcase pets from Missoula animal
                    shelters and rescue groups.
                </p>
            </div>
        </div><!--//mission_inner-->
    </div><!--//mission-->

    <div id="content">
        <div id="content_inner">
