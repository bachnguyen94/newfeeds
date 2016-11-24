<!DOCTYPE html>
<html>
<head>
    <?= $this->element('core');?>
    <?php
    echo $this->Html->css(array(
        'Admin.smartadmin-production-plugins.min.css',
        'Admin.smartadmin-production.min.css',
        'Admin.smartadmin-skins.min.css',
        'Admin.smartadmin-rtl.min.css',
        'Admin.demo.min.css',
    ));
    ?>
</head>
<body class="">
    <?php
        echo $this->element('Admin.header');
        $cell = $this->cell('Admin.Menu');
        echo $cell;
    ?>
    <div id="main" role="main">
        <?php echo $this->element('Admin.breadcrumb')?>
        <div id="content">
            <div class="row">
                <?= $this->Flash->render() ?>
            </div>
            <section id="widget-grid" class="">
                <?php echo $this->fetch('content'); ?>
            </section>
        </div>
    </div>
    <?php
        echo $this->element('Admin.footer');
        echo $this->element('Admin.shortcut');
    ?>

    <?php
    echo $this->Html->script(array(
//        'Admin.libs.smart-admin.js',
        'Admin.plugin/pace/pace.min.js',
        'Admin.app.config.js',
        'Admin.demo.min.js',
        'Admin.app.min.js',
        'Admin.notification/SmartNotification.min.js',
        'Admin.plugin/datatables/jquery.dataTables.min.js',
        'Admin.plugin/datatables/dataTables.colVis.min.js',
        'Admin.plugin/datatables/dataTables.tableTools.min.js',
        'Admin.plugin/datatables/dataTables.bootstrap.min.js',
        'Admin.plugin/datatable-responsive/datatables.responsive.min.js',
        'Admin.global-smart.js',
    ));
    ?>

</body>
</html>