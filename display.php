<?php
session_start();
if (empty($_SESSION['errors'])) {
    echo $_SESSION['sucess'] . "<br>";
?>
    <ul>
        <?php foreach ($_SESSION['jsonData'] as $dataKey => $dataValue) { ?>
            <li>
                <h5><?php echo "$dataKey" . " : " . "$dataValue"; ?></h5>
            </li>
        <?php } ?>
    </ul>
<?php } ?>