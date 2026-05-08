<?php $v->extend('site/layout'); ?>

<?php $v->block('main'); ?>
<?php d($app); ?>
    <?= d($page); ?>
<?php $v->endblock(); ?>
