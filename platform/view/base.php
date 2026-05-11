<!DOCTYPE html>
<html lang="en">
<head>

    <?php /* meta */ ?>
    <?php $v->section('head:meta'); ?>
    <!-- charset -->
    <meta charset="utf-8">
    <!-- viewport -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <?php $v->endsection(); ?>

    <?php /* share */ ?>
    <?php $v->section('head:share'); ?>
    <?php $v->endsection(); ?>

    <?php /* style */ ?>
    <?php $v->section('head:style'); ?>
    <?php $v->endsection(); ?>

    <?php /* script */ ?>
    <?php $v->section('head:script'); ?>
    <?php $v->endsection(); ?>
    
</head>
<body>

    <?php /* before */ ?>
    <?php $v->section('before'); ?>
    <?php $v->endsection(); ?>

    <!-- main -->
    <main class="main">
        <?php $v->section('main'); ?>
        <?php $v->endsection(); ?>
    </main>

    <?php /* after */ ?>
    <?php $v->section('after'); ?>
    <?php $v->endsection(); ?>

</body>
</html>
