<?php $v->extend('site/layout'); ?>

<?php $v->block('main'); ?>
    <!-- error -->
    <section class="error">
        <!-- @TODO -->
        <h1><?= $exception->getStatus(); ?></h1>
    </section>
<?php $v->endblock(); ?>
