<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?= $this->element('core') ?>

<?= $this->Html->css('System.style.css') ?>
<?= $this->Html->css('System.fontawesome-iconpicker.min.css') ?>
<?= $this->Html->script('System.fontawesome-iconpicker.min') ?>
</head>
<body>

<div id="wrapper">
    <?= $this->element('header') ?>
            
    <!--center start-->
    <?= $this->fetch('content'); ?>
    <!--center end-->    
                               
    <?= $this->element('footer') ?>
</div>

</body>
</html>