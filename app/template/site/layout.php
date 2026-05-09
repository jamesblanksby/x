<?php $v->extend('base'); ?>

<?php $v->block('head'); ?>
<!-- title -->
<title></title>
<!-- description -->
<meta name="description" content>
<!-- share -->
<meta property="og:type" content="url">
<meta property="og:url" content>
<meta property="og:title" content>
<meta property="og:description" content>
<meta property="og:image" content>
<!-- style : site -->
<link rel="stylesheet" href="<?= $v->asset('site/css/site.css'); ?>">
<!-- script : site -->
<script defer src="<?= $v->asset('site/js/site.css'); ?>"></script>
<?php $v->endblock(); ?>

<?php $v->block('before'); ?>
<!-- header -->
<?php $v->include('site/template/layout/header'); ?>
<?php $v->endblock(); ?>

<?php $v->block('after'); ?>
<!-- footer -->
<?php $v->include('site/template/layout/footer'); ?>
<?php $v->endblock(); ?>
