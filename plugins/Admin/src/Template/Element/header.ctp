<!-- HEADER -->
<header id="header">
<div id="logo-group">

    <!-- PLACE YOUR LOGO HERE -->
    <span id="logo"><?php echo $this->Html->image('Admin.logo.png', array('alt'=>'Backend System'))?></span>
    <!-- END LOGO PLACEHOLDER -->

</div>

<!-- pulled right: nav area -->
<div class="pull-right">

    <!-- collapse menu button -->
    <div id="hide-menu" class="btn-header pull-right">
        <span> <a href="javascript:void(0);" data-action="toggleMenu" title="<?php echo __('Collapse menu');?>"><i class="fa fa-reorder"></i></a> </span>
    </div>
    <!-- end collapse menu -->

    <!-- #MOBILE -->
    <!-- Top menu profile link : this shows only when top menu is active -->
    <ul id="mobile-profile-img" class="header-dropdown-list hidden-xs padding-5">
        <li class="">
            <a href="#" class="dropdown-toggle no-margin userdropdown" data-toggle="dropdown">
                <?php echo $this->Html->image('../admin/img/avatars/male.png', array('alt'=>'Admin', 'class'=>'online'))?>
            </a>
            <ul class="dropdown-menu pull-right">
                <li>
                    <a href="javascript:void(0);" class="padding-10 padding-top-0 padding-bottom-0"><i class="fa fa-cog"></i> <?php echo __('Setting');?></a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="<?php echo $this->Url->build(array('plugin' => 'admin', 'controller'=>'users', 'action'=>'profile'))?>" class="padding-10 padding-top-0 padding-bottom-0"> <i class="fa fa-user"></i> <?php echo __('Profile');?></a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="javascript:void(0);" class="padding-10 padding-top-0 padding-bottom-0" data-action="toggleShortcut"><i class="fa fa-arrow-down"></i> <?php echo __('Shortcut');?></a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="javascript:void(0);" class="padding-10 padding-top-0 padding-bottom-0" data-action="launchFullscreen"><i class="fa fa-arrows-alt"></i> <?php echo __('Full screen');?></a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="<?php echo $this->Url->build(['plugin' => 'admin', 'controller'=>'users', 'action'=>'logout'])?>" class="padding-10 padding-top-5 padding-bottom-5" data-action="userLogout"><i class="fa fa-sign-out fa-lg"></i> <strong><?php echo __('Logout');?></strong></a>
                </li>
            </ul>
        </li>
    </ul>

    <!-- logout button -->
    <div id="logout" class="btn-header transparent pull-right">
        <span>
            <a href="<?php echo $this->Url->build(['plugin' => 'admin', 'controller'=>'users', 'action'=>'logout'])?>" title="<?php echo __('Signout')?>" data-action="userLogout" data-logout-msg="<?php echo __('You can improve your security further after logging out by closing this opened browser');?>">
                <i class="fa fa-sign-out"></i>
            </a>
        </span>
    </div>
    <!-- end logout button -->

    <!-- fullscreen button -->
    <div id="fullscreen" class="btn-header transparent pull-right">
        <span> <a href="javascript:void(0);" data-action="launchFullscreen" title="<?php echo __('Full screen');?>"><i class="fa fa-arrows-alt"></i></a> </span>
    </div>
    <!-- end fullscreen button -->

    <!-- multiple lang dropdown : find all flags in the flags page -->
    <ul class="header-dropdown-list hidden-xs">
        <li>
            <?php
                $listLang = \Cake\Core\Configure::read('Core.System.language');
                $defaultLang = [];
                foreach ($listLang as $key => $value) {
                    $defaultLang[$value['key']] = $value;
                }
            ?>
            
            
            
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <img src="<?php echo $this->Url->build('/') ?>admin/img/blank.gif" class="flag <?= $defaultLang[$lang]['flag']?>" alt="<?= $defaultLang[$lang]['name']?>"> <span> <?= $defaultLang[$lang]['name']?> </span> <i class="fa fa-angle-down"></i> </a>
            <ul class="dropdown-menu pull-right">
                <?php
                foreach($listLang as $value):
                    if($value['key'] == $lang) continue;
                ?>
                    <li>
                        <a href="<?= $this->Url->build(['plugin' => null, 'controller' => 'pages', 'action' => 'change_language', $value['key']])?>"><img src="<?php echo $this->Url->build('/') ?>admin/img/blank.gif" class="flag <?= $value['flag']?>" alt="<?= $value['name']?>"> <?= $value['name']?> </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </li>
    </ul>
    <!-- end multiple lang -->

</div>
<!-- end pulled right: nav area -->

</header>
<!-- END HEADER -->