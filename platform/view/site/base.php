<?php $v->extend('base'); ?>

<?php $v->section('head:meta'); ?>
<!-- title -->
<title><?= $v->page_title($page); ?></title>
<!-- description -->
<meta name="description" content="<?= $v->page_description($page); ?>">
<?php $v->endsection(); ?>

<?php $v->section('head:share'); ?>
<!-- share -->
<meta property="og:type" content="url">
<meta property="og:url" content="<?= $v->page_url($page); ?>">
<meta property="og:title" content="<?= $v->page_title($page); ?>">
<meta property="og:description" content="<?= $v->page_description($page); ?>">
<meta property="og:image" content="<?= $v->page_image($page); ?>">
<?php $v->endsection(); ?>
