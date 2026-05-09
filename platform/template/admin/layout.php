<?php $v->extend('base') ?>

<?php $v->block('head:meta') ?>
<!-- title -->
<title></title>
<?php $v->endblock() ?>

<?php $v->block('head:style') ?>
<!-- style : admin -->
<link rel="stylesheet" href="<?= $v->asset('admin/css/admin.css') ?>">
<?php $v->endblock() ?>

<?php $v->block('head:script') ?>
<!-- script : jquery -->
<script defer src="<?= $v->asset('admin/js/jquery.js') ?>"></script>
<!-- script : jqueryui -->
<script defer src="<?= $v->asset('admin/js/jqueryui.js') ?>"></script>
<!-- script : scriptkit -->
<script defer src="<?= $v->asset('admin/js/scriptkit.js') ?>"></script>
<!-- script : admin -->
<script defer src="<?= $v->asset('admin/js/admin.js') ?>"></script>
<?php $v->endblock() ?>

<?php $v->block('before') ?>
<!-- header -->
<?php $v->include('admin/template/layout/header') ?>
<?php $v->endblock() ?>

<?php $v->block('after') ?>
<!-- footer -->
<?php $v->include('admin/template/layout/footer') ?>
<?php $v->endblock() ?>
