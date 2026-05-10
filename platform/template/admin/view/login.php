<?php $v->extend('admin/layout'); ?>

<?php $v->section('main'); ?>
<!-- @TODO -->
<h1>Login</h1>
<form action="/x/admin/authenticate" method="post">
    <input type="text" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>
<?php $v->endsection(); ?>
