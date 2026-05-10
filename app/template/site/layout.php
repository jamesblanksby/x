<?php $v->extend('base'); ?>

<?php $v->section('head:meta'); ?>
<!-- title -->
<title></title>
<!-- description -->
<meta name="description" content>
<?php $v->endsection(); ?>

<?php $v->section('head:share'); ?>
<!-- share -->
<meta property="og:type" content="url">
<meta property="og:url" content>
<meta property="og:title" content>
<meta property="og:description" content>
<meta property="og:image" content>
<?php $v->endsection(); ?>

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
<?php $v->include('site/template/layout/header'); ?>
<?php $v->endsection(); ?>

<?php $v->section('after'); ?>
<!-- footer -->
<?php $v->include('site/template/layout/footer'); ?>
<?php $v->endsection(); ?>
