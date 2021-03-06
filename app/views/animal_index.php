<?php require 'common/header.php' ?>

<h2><?php echo $title ?></h2>

<div class="animal_container">
    <?php $i = 0 ?>
    <?php foreach ($animals as $animal): ?>
        <div class="animal <?php echo (($i & 1) === 0) ? "left" : "right"; $i++ ?>">
            <div class="photo">
                <img width="100"
                     src="<?php echo ($animal->hasImage()) ? $animal->getImage()
                                                           : Url::getBase() . "/img/no-photo.png" ?>"
                     alt="Photo of <?php echo $animal->getName() ?>">
            </div>
            <div class="details">
                <table>
                    <tr>
                        <th>Name:</th>
                        <td><?php echo $animal->getName() ?></td>
                    </tr>
                    <tr>
                        <th>Breed:</th>
                        <td><?php echo $animal->getBreed() ?></td>
                    </tr>
                    <tr>
                        <th>Shelter:</th>
                        <td><?php echo $animal->getShelter() ?></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <a href="<?php echo Url::route2url("animal/view/{$animal->getId()}") ?>">Details</a></td>
                    </tr>
                </table>
            </div>
        </div>
    <?php endforeach ?>
</div>
<?php require 'common/footer.php' ?>
