<!-- SHORTCUT AREA : With large tiles (activated via clicking user name tag)
		Note: These tiles are completely responsive,
		you can add as many as you like
		-->
<div id="shortcut">
    <ul>
        <li>
            <a href="<?php echo $this->Url->build(array('plugin' => 'Admin', 'controller'=>'users', 'action'=>'profile'))?>" class="jarvismetro-tile big-cubes <?php if($this->request->controller == 'Users' && $this->request->action == 'profile') {echo 'selected';}?> bg-color-pinkDark">
                <span class="iconbox">
                    <i class="fa fa-user fa-4x"></i>
                    <span>
                        <?php echo __('My profile');?>
                    </span>
                </span>
            </a>
        </li>
        <li>
            <a href="<?php echo $this->Url->build(array('plugin' => 'Admin', 'controller'=>'users', 'action'=>'change_password'))?>" class="jarvismetro-tile big-cubes <?php if($this->request->controller == 'Users' && $this->request->action == 'change_password') {echo 'selected';}?> bg-color-blueDark">
                <span class="iconbox">
                    <i class="fa fa-lock fa-4x"></i>
                    <span>
                        <?php echo __('Change password');?>
                    </span>
                </span>
            </a>
        </li>
    </ul>
</div>
<!-- END SHORTCUT AREA -->