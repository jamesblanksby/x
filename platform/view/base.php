<!DOCTYPE html>
<html lang="en">
<head>
    <?php /* meta */ ?>
    <?= $v->section('head:meta'); ?>
    <?php /* share */ ?>
    <?= $v->section('head:share'); ?>
    <?php /* style */ ?>
    <?= $v->section('head:style'); ?>
    <?php /* script */ ?>
    <?= $v->section('head:script'); ?>    
</head>
<body>

    <?php /* before */ ?>
    <?= $v->section('before'); ?>

    <!-- main -->
    <main class="main">
        <?= $v->section('main'); ?>
    </main>

    <?php /* after */ ?>
    <?= $v->section('after'); ?>

</body>
</html>

<?php $v->start('head:meta'); ?>
<!-- charset -->
<meta charset="utf-8">
<!-- viewport -->
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<?php $v->stop(); ?>
