<?php
header('Content-type: application/atom+xml; charset=utf-8');
echo '<?xml version="1.0" encoding="utf-8"?>'
?>

<feed xmlns="http://www.w3.org/2005/Atom">
    <title>Latest Animals from <?php echo Site::getInstance()->getName() ?></title>
    <subtitle>The latest adoptable animals in Missoula.</subtitle>
    <id><?php echo Url::getBase() ?></id>
    <link href="<?php echo Url::route2url("animal/feed") ?>" rel="self" />
    <link href="<?php echo Url::getBase() ?>" />
    <updated><!-- TODO: Last scrape date --></updated>
    <author>
        <name><?php echo Site::getInstance()->getName() ?></name>
        <email><?php echo Site::getInstance()->getEmail() ?></email>
    </author>

    <?php foreach ($animals as $animal): ?>
        <entry>
            <link href="<?php $url = Url::route2url("animal/view/{$animal->getId()}"); echo $url ?>"/>
            <id><?php echo $url ?></id>
            <updated><?php echo $animal->getDateRecorded() ?></updated>
            <title>[<?php echo $animal->getCommonName() ?>] <?php echo $animal->getName() ?></title>
            <content type="html">
                <![CDATA[
                    <p>
                        <img alt="Photo of <?php echo $animal->getName() ?>"
                             src="<?php echo ($animal->hasImage()) ? $animal->getImage()
                                                                   : Url::getBase() . "/img/no-photo.png" ?>"/>
                    </p>
                    <p>
                        <?php echo $animal->getDescription() ?>
                    </p>
                ]]>
            </content>
        </entry>
    <?php endforeach ?>
</feed>