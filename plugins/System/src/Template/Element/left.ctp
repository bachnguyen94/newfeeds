<div id="left">
    <div class="left_top"><?php echo __('Account') ?></div>
    <div class="content_left">
        <ul>
            <li><?php echo $this->Html->image('admin/icon_menu_left.png'); ?><?php echo $this->Html->link(__('Profile'),array('controller'=>'users','action'=>'profile')); ?></li>
            <li><?php echo $this->Html->image('admin/icon_menu_left.png'); ?><?php echo $this->Html->link(__('Change password'),array('controller'=>'users','action'=>'password')); ?></li>
        </ul>
    </div>
</div>