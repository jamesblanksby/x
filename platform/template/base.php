<!DOCTYPE html>
<html lang="en">
<head>
    <!-- charset -->
    <meta charset="utf-8">
    <!-- viewport -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <?php /* head */ ?>
    <?php $v->section('head'); ?>
</head>
<body>

    <?php /* before */ ?>
    <?php $v->section('before'); ?>

    <!-- main -->
    <main class="main">
        <?php $v->section('main'); ?>
    </main>

    <?php /* after */ ?>
    <?php $v->section('after'); ?>

</body>
</html>
