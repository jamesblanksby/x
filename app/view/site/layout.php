<?php $v->extend('site/base'); ?>

<?php $v->start('head:style'); ?>
<!-- style : site -->
<link rel="stylesheet" href="<?= $v->asset('site/css/site.css'); ?>">
<?php $v->stop(); ?>

<?php $v->start('head:script'); ?>
<!-- script : site -->
<script defer src="<?= $v->asset('site/js/site.js'); ?>"></script>
<?php $v->stop(); ?>

<?php $v->start('before'); ?>
<!-- header -->
<?= $v->include('site/layout/header'); ?>
<?php $v->stop(); ?>

<?php $v->start('after'); ?>
<!-- footer -->
<?= $v->include('site/layout/footer'); ?>
<?php $v->stop(); ?>
