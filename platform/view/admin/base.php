<?php $v->extend('base'); ?>

<?php $v->start('head:meta'); ?>
<!-- title -->
<title></title>
<?php $v->stop(); ?>

<?php $v->start('head:style'); ?>
<!-- style : admin -->
<link rel="stylesheet" href="<?= $v->asset('admin/css/admin.css'); ?>">
<?php $v->stop(); ?>

<?php $v->start('head:script'); ?>
<!-- script : jquery -->
<script defer src="<?= $v->asset('admin/js/jquery.js'); ?>"></script>
<!-- script : jqueryui -->
<script defer src="<?= $v->asset('admin/js/jqueryui.js'); ?>"></script>
<!-- script : scriptkit -->
<script defer src="<?= $v->asset('admin/js/scriptkit.js'); ?>"></script>
<!-- script : admin -->
<script defer src="<?= $v->asset('admin/js/admin.js'); ?>"></script>
<?php $v->stop(); ?>

<?php $v->start('before'); ?>
<!-- header -->
<?= $v->include('admin/layout/header'); ?>
<?php $v->stop(); ?>

<?php $v->start('after'); ?>
<!-- footer -->
<?= $v->include('admin/layout/footer'); ?>
<?php $v->stop(); ?>
