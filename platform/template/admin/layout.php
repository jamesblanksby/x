<?php $v->extend('base'); ?>

<?php $v->section('head:meta'); ?>
<!-- title -->
<title></title>
<?php $v->endsection(); ?>

<?php $v->section('head:style'); ?>
<!-- style : admin -->
<link rel="stylesheet" href="<?= $v->asset('admin/css/admin.css'); ?>">
<?php $v->endsection(); ?>

<?php $v->section('head:script'); ?>
<!-- script : jquery -->
<script defer src="<?= $v->asset('admin/js/jquery.js'); ?>"></script>
<!-- script : jqueryui -->
<script defer src="<?= $v->asset('admin/js/jqueryui.js'); ?>"></script>
<!-- script : scriptkit -->
<script defer src="<?= $v->asset('admin/js/scriptkit.js'); ?>"></script>
<!-- script : admin -->
<script defer src="<?= $v->asset('admin/js/admin.js'); ?>"></script>
<?php $v->endsection(); ?>

<?php $v->section('before'); ?>
<!-- header -->
<?php $v->include('admin/template/layout/header'); ?>
<?php $v->endsection(); ?>

<?php $v->section('after'); ?>
<!-- footer -->
<?php $v->include('admin/template/layout/footer'); ?>
<?php $v->endsection(); ?>
