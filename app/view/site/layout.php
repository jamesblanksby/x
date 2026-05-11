<?php $v->extend('site/base'); ?>

<?php $v->section('head:style'); ?>
<!-- style : site -->
<link rel="stylesheet" href="<?= $v->asset('site/css/site.css'); ?>">
<?php $v->endsection(); ?>

<?php $v->section('head:script'); ?>
<!-- script : site -->
<script defer src="<?= $v->asset('site/js/site.js'); ?>"></script>
<?php $v->endsection(); ?>

<?php $v->section('before'); ?>
<!-- header -->
<?php $v->include('site/layout/header'); ?>
<?php $v->endsection(); ?>

<?php $v->section('after'); ?>
<!-- footer -->
<?php $v->include('site/layout/footer'); ?>
<?php $v->endsection(); ?>
