<?php $v->extend('base'); ?>

<?php $v->section('head:meta'); ?>
<?php $v->parent(); ?>
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
