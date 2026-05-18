<?php $v->extend('site/layout'); ?>

<?php $v->start('main'); ?>
    <!-- error -->
    <section class="error">
        <!-- @TODO -->
        <h1><?= $exception->getStatus(); ?></h1>
    </section>
<?php $v->stop(); ?>
