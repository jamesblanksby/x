<?php $v->extend('base'); ?>

<?php $v->block('head'); ?>
<!-- title -->
<title></title>
<!-- style : admin -->
<link rel="stylesheet" href>
<!-- script : jquery -->
<script defer src></script>
<!-- script : jqueryui -->
<script defer src></script>
<!-- script : scriptkit -->
<script defer src></script>
<!-- script : admin -->
<script defer src></script>
<?php $v->endblock(); ?>

<?php $v->block('before'); ?>
<!-- header -->
<?php $v->include('admin/template/layout/header'); ?>
<?php $v->endblock(); ?>

<?php $v->block('after'); ?>
<!-- footer -->
<?php $v->include('admin/template/layout/footer'); ?>
<?php $v->endblock(); ?>
