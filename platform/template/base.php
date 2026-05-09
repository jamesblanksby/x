<!DOCTYPE html>
<html lang="en">
<head>
    <!-- charset -->
    <meta charset="utf-8">
    <!-- viewport -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <?php /* meta */ ?>
    <?php $v->section('head:meta') ?>
    <?php /* share */ ?>
    <?php $v->section('head:share') ?>
    <?php /* style */ ?>
    <?php $v->section('head:style') ?>
    <?php /* script */ ?>
    <?php $v->section('head:script') ?>
</head>
<body>

    <?php /* before */ ?>
    <?php $v->section('before') ?>

    <!-- main -->
    <main class="main">
        <?php $v->section('main') ?>
    </main>

    <?php /* after */ ?>
    <?php $v->section('after') ?>

</body>
</html>
