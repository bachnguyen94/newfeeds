<%
use Cake\Utility\Inflector;

$fields = collection($fields)
    ->filter(function($field) use ($schema) {
        return $schema->columnType($field) !== 'binary';
    })
    ->toArray();
$pk = "\$$singularVar->{$primaryKey[0]}";
%>

<?php $this->Html->addCrumb(__('<%= $singularHumanName %>'));?>
<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-9">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-cog fa-fw "></i>
            <?= __('<%= $singularHumanName %>');?>
            <span>&gt;
                <?= $this->Html->link(__('List of <%= strtolower($pluralHumanName) %>'), ['plugin'=>'admin','action' => 'index'])?>
            </span>
        </h1>
    </div>
</div>

<div class="row">
    <article class="col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">
        <!-- Widget ID (each widget will need unique ID)-->
        <div class="jarviswidget jarviswidget-sortable jarviswidget-color-darken" id="wid-id-4" data-widget-editbutton="false" data-widget-custombutton="false" role="widget" style="">
            <header role="heading">
                <span class="widget-icon">
                    <i class="fa fa-user"></i>
                </span>
                <h2><?= h($<%= $singularVar %>-><%= $displayField %>) ?></h2>
            </header>
            <!-- widget div-->
            <div role="content">
                <!-- widget edit box -->
                <div class="jarviswidget-editbox">
                    <!-- This area used as dropdown edit box -->
                </div>
                <!-- end widget edit box -->
                <!-- widget content -->
                <div class="widget-body">
                    <fieldset>
                        <table id="user" class="table table-bordered table-striped" style="clear: both">
                            <tbody>
                        <% foreach ($fields as $field) : %>
    <tr>
                                <td style="width:35%;"><?= __('<%= ucfirst(strtolower(Inflector::humanize($field))) %>') ?></td>
                                <td style="width:65%">
                                    <% 
                                        $fieldData = $schema->column($field);
                                        if($fieldData['type'] == 'datetime')
                                        {
%>
<?= $this->Core->datetime($<%= $singularVar %>-><%= $field %>) ?>
<%
                                        }
                                        else if($fieldData['type'] == 'date')
                                        {
%>
<?= $this->Core->datetime($<%= $singularVar %>-><%= $field %>,false) ?>
<%
                                        }
                                        else if($fieldData['type'] == 'boolean')
                                        {
%>
<?= ($<%= $singularVar %>-><%= $field %>)?__('Yes'):__('No') ?>
<%
                                        }
                                        else
                                        {
%>
<?= h($<%= $singularVar %>-><%= $field %>) ?>
<%
                                        }
                                    %>
                                </td>
                            </tr>
                        <% endforeach; %>
    </tbody>
                        </table>
                    </fieldset>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12">
                                <?= $this->Html->link(__('Back'), ['plugin'=>'admin','action' => 'index'], ['class' => 'btn btn-default']) ?>
                                <?= $this->Html->link(__('Edit'), ['action' => 'edit', <%= $pk %>], ['class' => 'btn btn-primary']) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end widget content -->
            </div>
            <!-- end widget div -->
        </div>
        <!-- end widget -->
    </article>
</div>
