<?php
use Cake\Core\Configure;

$this->Html->addCrumb(__('System'));

?>
<?= $this->Html->script('Slides/slide_order_ajax.js')?>
<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-cog fa-fw "></i>
            <?= __('System');?>
            <span>&gt;
                <?= __('List of Photography')?>
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
                <h2><?= __('List of Slides')?></h2>
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
                                'table_name',
                                'imageUrl',
                                'title',
                                'description',
                                'status',
                                'display_order',
                            ]
                        ]);
                        ?>
                        <tbody>
                        <?php
                            $i = 0;
                            foreach ($slides as $slide): ?>
                            <tr id=<?= $slide->id ?>>
                                <td><?= h($slide->table_name) ?></td>
                                <td><?= $this->Core->image($arr_table[$i],'imageUrl',150,150);?></td>
                                <td><?= h($arr_table[$i]->title) ?></td>
                                <td><?= h($arr_table[$i]->description) ?></td>
                                <td>
                                    <?= $this->Form->input('status', ['default' => $slide->status,'type' => 'select','options' => $status ,'class'=>'form-control','id'=>'stt', 'required' => false]); ?>
                                </td>
                                <td>
                                    <?= $this->Form->input('display_order', ['default' => $slide->display_order,'type' => 'select','options' => $orders ,'class'=>'form-control', 'required' => false]); ?>
                                </td>
                                <td>
                                    <center>
                                        <?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $slide->id], ['title' => __('Delete'), 'data-action' => 'deleteLin', 'data-delete-msg' => __('Are you sure', $slide->id), 'class' => 'btn btn-sm btn-default deleteLin', 'escape' => false]); ?>
                                    </center>
                                </td>
                            </tr>
                        <?php $i++; endforeach; ?>
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