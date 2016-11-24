<?php
use Cake\Core\Configure;

$this->Html->addCrumb(__('System'));
?>
<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-cog fa-fw "></i>
            <?= __('System');?>
            <span>&gt;
                <?= __('List of Fashion')?>
            </span>
        </h1>
    </div>
    <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
        <ul id="sparks" class="">
            <li class="sparks-info">
                <?= $this->Html->link(__('Add new'), ['action' => 'form'], ['class' => 'btn btn-primary']) ?>
            </li>
        </ul>
    </div>
</div>

<div class="row">
    <!-- NEW WIDGET START -->
    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

        <!-- Widget ID (each widget will need unique ID)-->
        <div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-editbutton="true">
            <header>
                <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                <h2><?= __('List of Fashion')?></h2>
            </header>

            <!-- widget div-->
            <div>
                <!-- widget edit box -->
                <div class="jarviswidget-editbox">
                    <!-- This area used as dropdown edit box -->
                </div>
                <!-- end widget edit box -->

                <!-- widget content -->
                <div class="widget-body">

                    <?php
                    $status = \Cake\Core\Configure::read('Core.System.active');
                    $group = \Cake\Core\Configure::read('Core.Users.group');
                    ?>
                    <table id="" class="table table-striped table-bordered" width="100%">
                        <?=
                        $this->element('filter_table', [
                            'fields' => [
                                'imageUrl',
                                'title',
                                'description',
                                'slide_id'
                            ]
                        ]);
                        ?>
                        <tbody>
                        <?php foreach ($fashions as $fashion): ?>
                            <tr>
                                <td><?= $this->Core->image($fashion,'imageUrl',100,100);?></td>
                                <td><?= h($fashion->title) ?></td>
                                <td><?= h($fashion->description) ?></td>
                                <td><?= h($fashion->slide_id) ?></td>
                                <td>
                                    <center>
                                        <?= $this->Html->link('<i class="fa fa-eye"></i> ', ['action' => 'view', $fashion->id], ['title' => __('View'),'escape' => false, 'class' => 'btn btn-sm btn-default'] ); ?>
                                        <?= $this->Html->link('<i class="fa fa-edit"></i> ', ['action' => 'form', $fashion->id], ['title' => __('Edit'),'escape' => false, 'class' => 'btn btn-sm btn-default'] ); ?>
                                        <?= $this->Form->postLink('<i class="fa fa-trash-o"></i> ', ['action' => 'delete', $fashion->id], ['title' => __('Delete'), 'data-action' => 'deleteLin', 'data-delete-msg' => __('Are you sure', $fashion->id), 'class' => 'btn btn-sm btn-default deleteLin', 'escape' => false]); ?>
                                    </center>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?= $this->element('Admin.paginator_cake') ?>
                </div>
                <!-- end widget content -->

            </div>
            <!-- end widget div -->

        </div>
        <!-- end widget -->

    </article>
    <!-- WIDGET END -->
</div>