<?php require 'common/header.php' ?>

<h2><?php echo $animal->getName() ?></h2>
<div id="animal_view">
    <div id="animal_view_photo">
        <img width="200"
             src="<?php echo ($animal->hasImage()) ? $animal->getImage()
                                                   : Url::getBase() . "/img/no-photo.png" ?>"
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
                <th>Color:</th>
                <td><?php echo $animal->getColor() ?></td>
            </tr>
            <tr>
                <th>Sex:</th>
                <td><?php echo ($animal->getSex() === 'F') ? "Female" : "Male" ?></td>
            </tr>
            <tr>
                <th>Fixed:</th>
                <td><?php echo ($animal->isFixed()) ? "Yes" : "No" ?></td>
            </tr>
            <tr>
                <th>Age:</th>
                <td><?php echo $animal->getAge() ?></td>
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
