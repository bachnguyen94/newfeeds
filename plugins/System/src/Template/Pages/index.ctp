<?php use \Cake\Core\Configure; ?>

<div class="breadscrumb">
    <span><?= __("System") ?></span>
    <?= $this->Html->image('System.brk_center.png') ?>
    <span><?= __("Home") ?></span>
</div>

<div id="center">
    <div id="left">
        <div class="left_top"><?php echo __('Menu') ?></div>
        <div class="content_left hw-tab-link">
            <ul>
                <li class="active"><?php echo $this->Html->image('System.icon_menu_left.png'); ?><a href="#tabs-1">Home</a></li>
                <li><?php echo $this->Html->image('System.icon_menu_left.png'); ?><a href="#tabs-2">phpinfo</a></li>
                <li><?php echo $this->Html->image('System.icon_menu_left.png'); ?><a href="#tabs-3">Cake PHP</a></li>
            </ul>
        </div>
        
        <div class="hw-10"></div>
        
        <div class="left_top"><?php echo __('Other') ?></div>
        <div class="content_left">
            <ul>
                <li><?php echo $this->Html->image('System.icon_menu_left.png'); ?> <a href="<?= $this->Url->build('/system/smartadmin/index.html') ?>">Smart Admin</a></li>
            </ul>
        </div>
    </div>
    
    <div id="right_notfull">
        <?= $this->Flash->render('flash'); ?>
        
        <div class="hw-tab-div">
            <div id="tabs-1">
                <table class="tblForm" width="100%">
                    <tr>
                        <td>This is home page</td>
                    </tr>
                </table>
            </div>
            <div id="tabs-2">
                <iframe style="width:100%;height:500px" src="<?php echo $this->Url->build(['action'=>'phpinfo']) ?>"></iframe>
            </div>
            <div id="tabs-3">
                <table class="tblForm" width="100%">
                    <tr>
                        <th style="text-align: left" colspan="2"><?php echo __('List of cakephp global constant') ?></th>
                    </tr>
                    <tr>
                        <th>APP</th>
                        <td><?= APP ?></td>
                    </tr>
                    <tr>
                        <th>APP_DIR</th>
                        <td><?= APP_DIR ?></td>
                    </tr>
                    <tr>
                        <th>CACHE</th>
                        <td><?= CACHE ?></td>
                    </tr>
                    <tr>
                        <th>CAKE</th>
                        <td><?= CAKE ?></td>
                    </tr>
                    <tr>
                        <th>CAKE_CORE_INCLUDE_PATH</th>
                        <td><?= CAKE_CORE_INCLUDE_PATH ?></td>
                    </tr>
                    <tr>
                        <th>CORE_PATH</th>
                        <td><?= CORE_PATH ?></td>
                    </tr>
                    <tr>
                        <th>DS</th>
                        <td><?= DS ?></td>
                    </tr>
                    <tr>
                        <th>LOGS</th>
                        <td><?= LOGS ?></td>
                    </tr>
                    <tr>
                        <th>ROOT</th>
                        <td><?= ROOT ?></td>
                    </tr>
                    <tr>
                        <th>TESTS</th>
                        <td><?= TESTS ?></td>
                    </tr>
                    <tr>
                        <th>TMP</th>
                        <td><?= TMP ?></td>
                    </tr>
                    <tr>
                        <th>WWW_ROOT</th>
                        <td><?= WWW_ROOT ?></td>
                    </tr>
                    <tr>
                        <th>TIME_START</th>
                        <td><?= TIME_START ?></td>
                    </tr>
                    <tr>
                        <th>SECOND</th>
                        <td><?= SECOND ?></td>
                    </tr>
                    <tr>
                        <th>MINUTE</th>
                        <td><?= MINUTE ?></td>
                    </tr>
                    <tr>
                        <th>HOUR</th>
                        <td><?= HOUR ?></td>
                    </tr>
                    <tr>
                        <th>DAY</th>
                        <td><?= DAY ?></td>
                    </tr>
                    <tr>
                        <th>WEEK</th>
                        <td><?= WEEK ?></td>
                    </tr>
                    <tr>
                        <th>MONTH</th>
                        <td><?= MONTH ?></td>
                    </tr>
                    <tr>
                        <th>YEAR</th>
                        <td><?= YEAR ?></td>
                    </tr>
                </table>
                
                <table class="tblForm" width="100%">
                    <tr>
                        <th style="text-align: left" colspan="2"><?php echo __('List of cakephp global configuration') ?></th>
                    </tr>
                    <tr>
                        <th>debug</th>
                        <td><?= Configure::read('debug') ?></td>
                    </tr>
                    <tr>
                        <th>App.namespace</th>
                        <td><?= Configure::read('App.namespace') ?></td>
                    </tr>
                    <tr>
                        <th>App.baseUrl</th>
                        <td><?= Configure::read('App.baseUrl') ?></td>
                    </tr>
                    <tr>
                        <th>App.base</th>
                        <td><?= Configure::read('App.base') ?></td>
                    </tr>
                    <tr>
                        <th>App.encoding</th>
                        <td><?= Configure::read('App.encoding') ?></td>
                    </tr>
                    <tr>
                        <th>App.webroot</th>
                        <td><?= Configure::read('App.webroot') ?></td>
                    </tr>
                    <tr>
                        <th>App.wwwRoot</th>
                        <td><?= Configure::read('App.wwwRoot') ?></td>
                    </tr>
                    <tr>
                        <th>App.fullBaseUrl</th>
                        <td><?= Configure::read('App.fullBaseUrl') ?></td>
                    </tr>
                    <tr>
                        <th>App.imageBaseUrl</th>
                        <td><?= Configure::read('App.imageBaseUrl') ?></td>
                    </tr>
                    <tr>
                        <th>App.cssBaseUrl</th>
                        <td><?= Configure::read('App.cssBaseUrl') ?></td>
                    </tr>
                    <tr>
                        <th>App.jsBaseUrl</th>
                        <td><?= Configure::read('App.jsBaseUrl') ?></td>
                    </tr>
                    <tr>
                        <th>App.paths.plugins</th>
                        <td><?= Configure::read('App.paths.plugins.0') ?></td>
                    </tr>
                    <tr>
                        <th>App.paths.templates</th>
                        <td><?= Configure::read('App.paths.templates.0') ?></td>
                    </tr>
                    <tr>
                        <th>App.paths.locales</th>
                        <td><?= Configure::read('App.paths.locales.0') ?></td>
                    </tr>
                    <tr>
                        <th>Security.salt</th>
                        <td><?= Configure::read('Security.salt') ?></td>
                    </tr>
                    <tr>
                        <th>Asset.timestamp</th>
                        <td><?= Configure::read('Asset.timestamp') ?></td>
                    </tr>
                </table>
            </div>
          </div>
    </div>
    <!--right end-->
    <div class="cl"></div>
    <div class="height10"></div>
</div>

<style>
.hw-tab-div div
{
    display: none;
}

#tab-1 
{
 display: block;   
}
</style>

<script>
$(document).ready(function() 
{
    $(".hw-tab-link a").click(function(event) 
    {
        event.preventDefault();
        $(this).parent().addClass("active");
        $(this).parent().siblings().removeClass("active");
        var tab = $(this).attr("href");
        $(".hw-tab-div div").not(tab).css("display", "none");
        $(tab).fadeIn();
    });
    
    $("#tabs-1").show();
});
</script>