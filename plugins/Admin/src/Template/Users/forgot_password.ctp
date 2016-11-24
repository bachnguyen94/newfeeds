<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" id="extr-page">
<head>
    <?= $this->element('core');?>
    <?php
    echo $this->Html->css(array(
        'Admin.smartadmin-production-plugins.min.css',
        'Admin.smartadmin-production.min.css',
        'Admin.smartadmin-skins.min.css',
        'Admin.smartadmin-rtl.min.css',
    ));
    ?>

</head>
<body class="animated fadeInDown">
<header id="header">

    <div id="logo-group">
        <span id="logo">
            <?php echo $this->Html->image('../admin/img/logo.png', array('alt'=>'SmartAdmin'))?>
        </span>
    </div>
</header>

<div id="main" role="main">

    <!-- MAIN CONTENT -->
    <div id="content" class="container">

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-md-offset-3 col-lg-offset-3">
                <div class="well no-padding">
                    <?= $this->Form->create(null, ['class' => 'login-form', 'class' => 'smart-form client-form'])?>
                        <header>
                            Sign In
                        </header>

                        <fieldset>

                            <section>
                                <label class="label">E-mail</label>
                                <label class="input"><i class="icon-append fa fa-user"></i>
                                    <input type="email" name="email">
                                    <b class="tooltip tooltip-top-right"><i class="fa fa-user txt-color-teal"></i> Please enter email address/username</b></label>
                            </section>

                            <section>
                                <label class="label">Password</label>
                                <label class="input"> <i class="icon-append fa fa-lock"></i>
                                    <input type="password" name="password">
                                    <b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> Enter your password</b> </label>
                                <div class="note">
                                    <a href="forgotpassword.html">Forgot password?</a>
                                </div>
                            </section>

                            <section>
                                <label class="checkbox">
                                    <input type="checkbox" name="remember" checked="">
                                    <i></i>Stay signed in
                                </label>
                            </section>
                        </fieldset>
                        <footer>
                            <button type="submit" class="btn btn-primary">
                                Sign in
                            </button>
                        </footer>
                    <?= $this->Form->end()?>
                </div>
            </div>
        </div>
    </div>

</div>

<?php
echo $this->Html->script(array(
    'Admin.plugin/pace/pace.min.js',
));
?>
</body>
</html>