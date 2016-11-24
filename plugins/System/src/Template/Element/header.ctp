<div class="header">
    <table width="100%">
        <tr>
            <td><?php echo $this->Html->image('System.logo.png'); ?></td>
            <td align="right">
                <?php echo __("Welcome") ?>, <strong>Developer</strong>
            </td>
        </tr>
    </table>
    <div id="menu_nav">
        <ul>
            <?php /* ?>
            <li>
                <a href="">
                    <p class="top_left"></p>
                    <p class="top_center">Home</p>
                    <p class="top_right"></p>
                    <div class="cl"></div>
                </a>
                <ul class="linkchild">
                    <li><a href=""><p>Submenu</p></a></li>
                </ul>
            </li>
             * <?php */ ?>
            <li>
                <a href="<?= $this->Url->build(['controller'=>'pages','action'=>'index']) ?>">
                    <p class="top_left"></p>
                    <p class="top_center">Home</p>
                    <p class="top_right"></p>
                    <div class="cl"></div>
                </a>
            </li>
            
            <li>
                <a href="">
                    <p class="top_left"></p>
                    <p class="top_center">System</p>
                    <p class="top_right"></p>
                    <div class="cl"></div>
                </a>
                <ul class="linkchild">
                    <li><a href="<?= $this->Url->build(['controller'=>'pages','action'=>'auth']) ?>"><p>Auth</p></a></li>
                    <li><a href="<?= $this->Url->build(['controller'=>'menus','action'=>'index']) ?>"><p>Menu</p></a></li>
                    <li><a href="<?= $this->Url->build(['controller'=>'email_templates','action'=>'index']) ?>"><p>Email Template</p></a></li>
                </ul>
            </li>
            
            <li>
                <a href="<?= $this->Url->build(['controller'=>'languages','action'=>'index']) ?>">
                    <p class="top_left"></p>
                    <p class="top_center">Language</p>
                    <p class="top_right"></p>
                    <div class="cl"></div>
                </a>
            </li>
            
            <li>
                <?php 
                    use Cake\Datasource\ConnectionManager;
                    $dbConfig = ConnectionManager::config('default');
                ?>
                <a href="<?= $this->Url->build('/',true)."adminer.php?server=".$dbConfig['host']."&username=".$dbConfig['username']."&db=".$dbConfig['database']."&pass=".$dbConfig['password'] ?>">
                    <p class="top_left"></p>
                    <p class="top_center">Database</p>
                    <p class="top_right"></p>
                    <div class="cl"></div>
                </a>
            </li>
        </ul>
    </div>
</div>