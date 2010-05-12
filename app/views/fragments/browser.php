<div id="category_container">
    <div class="category first">
        <h3>Common Name</h3>
        <ul>
            <?php foreach ($commonNames as $commonName): ?>
                <?php $url = Url::route2url("browse/view/common_name_id/{$commonName->getId()}") ?>
                <li>
                    <a href="<?php echo $url ?>">
                        <?php echo $commonName->getName() ?>
                    </a>
                </li>
            <?php endforeach ?>
        </ul>
    </div>
    <div class="category">
        <h3>Breed</h3>
        <ul>
            <?php foreach ($breeds as $breed): ?>
            <li>
                <a href="<?php echo Url::route2url("browse/view/breed/{$breed->getSlug()}") ?>">
                    <?php echo $breed->getName() ?>
                </a>
            </li>
            <?php endforeach ?>
        </ul>
    </div>
    <div class="category">
        <h3>Sex</h3>
        <ul>
            <?php $url = Url::route2url("browse/view/sex/") ?>
            <?php foreach (array("m" => "Male", "f" => "Female") as $key => $value): ?>
            <li>
                <a href="<?php echo $url, $key ?>">
                    <?php echo $value ?>
                </a>
            </li>
            <?php endforeach ?>
        </ul>
    </div>
    <div class="category">
        <h3>Shelter</h3>
        <ul>
            <?php foreach ($shelters as $shelter): ?>
                <li>
                    <a href="<?php echo Url::route2url("browse/view/shelter_id/{$shelter->getId()}") ?>">
                        <?php echo $shelter->getName() ?>
                    </a>
                </li>
            <?php endforeach ?>
        </ul>
    </div>
</div>
