<?php use Cake\Core\Configure;?>
<!-- Left panel : Navigation area -->
<!-- Note: This width of the aside area can be adjusted through LESS variables -->
<aside id="left-panel">

<!-- User info -->
<div class="login-info">
    <span> <!-- User image size is adjusted inside CSS, it should stay as it -->

        <a href="javascript:void(0);" id="show-shortcut" data-action="toggleShortcut">
            <?php
                echo $this->Html->image('../admin/img/avatars/male.png', array('class'=>'online'))
            ?>
            <span>
                <?= $this->CurUser->first_name.' '.$this->CurUser->last_name ?>
            </span>
            <i class="fa fa-angle-down"></i>
        </a>

    </span>
</div>
<!-- end user info -->

<?php

$highlightSetting = [
    
];

?>


<!-- NAVIGATION : This navigation is also responsive-->
<nav>
    <ul>
        <?php
        $request = array(
            'plugin' => strtolower($this->request->plugin),
            'controller' => strtolower($this->request->controller),
            'action' => strtolower($this->request->action),
            'admin' => strtolower($this->request->plugin) == 'admin' ? true : false
        );
        
        $curCA = $request['controller'] . '/' . $request['action'];
        
        foreach ($menus as $name => $params) 
        {
            $class = null;
            $url = '#';
            $hasSub = $active = false;
            if (isset($params['child'])) 
            {
                $hasSub = true;
            }
            
            if ($params['url']) 
            {
                $url = $params['url'];
            }
            
            if(!empty($params['highlight']))
            {
                $highlight = explode("\r\n",$params['highlight']);
                foreach($highlight as $item)
                {
                    if($curCA == $item)
                    {
                        $class .= ' open active ';
                        $active = true;
                        break;
                    }
                }
            }
            else if ($params['url'] && $request['controller'] == $params['url']['controller'] && $request['action'] == $params['url']['action']) 
            {
                $class .= ' open active ';
                $active = true;
            }

            echo '<li class="' . $class . '">';
            echo '<a  href="' . $this->Url->build($url) . '">';
            echo '<i class="fa ' . $params['icon'] . '"></i>';
            echo '<span class="menu-item-parent">';
            echo __($name);
            echo '</span>';
            echo '</a>';
            if ($hasSub) {
                echo '<ul>';
                foreach ($params['child'] as $nameSub => $subParams) 
                {
                    $class = null;
                    
                    if(!empty($subParams['highlight']))
                    {
                        $highlight = explode("\r\n",$subParams['highlight']);

                        foreach($highlight as $item)
                        {
                            if($curCA == $item)
                            {
                                $class = 'active';
                                break;
                            }
                        }
                    }
                    else if ($subParams['url'] && $request['controller'] == $subParams['url']['controller'] && $request['action'] == $subParams['url']['action']) 
                    {
                        $class = 'active';
                    }
                    
                    $url = $subParams['url'] ? $subParams['url'] : '#';
                    echo '<li class="' . $class . '">';
                    echo $this->Html->link('<i class="fa '.$subParams['icon'].'"></i>&nbsp;'.__($nameSub), $url, ['escape' => false]);
                    echo '</li>';
                }
                echo '</ul>';
            }
            echo '</li>';
            echo '</li>';
        }
        ?>
    </ul>
</nav>
    <span class="minifyme" data-action="minifyMenu">
        <i class="fa fa-arrow-circle-left hit"></i>
    </span>
</aside>
<!-- END NAVIGATION -->