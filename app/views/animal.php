<?php require 'common/header.php' ?>

<h2><?php echo $animal->getName() ?></h2>
<div id="animal_view">
    <div id="animal_view_photo">
        <!-- TODO: Use real image -->
        <img width="200" src="<?php echo Url::getBase() ?>/img/test_dog.jpg"
             alt="Photo of <?php echo $animal->getName() ?>">
    </div><!--//animal_view_photo-->

    <div id="animal_view_details">
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
        </table>
        <p>
            <?php echo $animal->getDescription() ?>
        </p>
    </div><!--//animal_view_details-->

    <div id="animal_view_shelter">
        <h3>Shelter</h3>
        <address>
            <b><?php echo $shelter->getName() ?></b>
            <br>
            <?php echo $shelter->getStreetAddress() ?>
            <br>
            <?php echo $shelter->getCity(), ' ', $shelter->getState(), ' ',
                       $shelter->getPostalCode() ?>
            <br>
            <?php echo $shelter->getPhone() ?>
        </address>
        <br>
        <?php if ($shelter->getHours()): ?>
            <h4>Hours</h4>
                <?php echo str_replace(';', "<br>", $shelter->getHours()) ?>
        <?php endif ?>
    </div><!--//animal_view_shelter-->
</div>

<?php require 'common/footer.php' ?>
