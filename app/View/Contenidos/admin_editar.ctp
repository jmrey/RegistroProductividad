<div class="box form">
    <header>
        <h1 class="title btn-small">Contenidos</h1>
        <div class="btn-group right">
            <?php 
                echo $this->Html->link('Ver', array('controller' => 'contenidos', 'action' => 'display', $this->request->data['Contenido']['name'], 'admin' => 0),
                    array('class' => 'btn btn-small'));
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-home'));
                echo $this->Html->link($icon_plus, array('controller' => 'dashboard', 'action' => 'index', 'admin' => 0),
                    array('class' => 'btn btn-small', 'escape' => false));
            ?>
        </div>
    </header>
    <?php echo $this->Form->create('Contenido', array('url' => array(
        'controller' => 'contenidos', 'action' => 'editar', $this->request->data['Contenido']['name'], 'admin' => $isAdmin
    ),'class' => 'form-inline container-fluid')); ?>
    <fieldset>
        <legend>Datos de Contenido</legend>
        <div class="row-fluid">
            <div class="span12">
                <?php
                    echo $this->Form->hidden('id');
                    echo $this->Form->hidden('type');
                    echo $this->Form->input('name', array(
                        'label' => 'Nombre:',
                        'disabled' => true,
                        'class' => 'disabled'
                    ));
                ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <?php
                    echo $this->Form->input('title', array(
                        'label' => 'Título:'
                    ));
                ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <?php
                    echo $this->Form->input('content', array(
                        'type' => 'textarea',
                        'label' => 'Contenido:'
                    ));
                ?>
            </div>
        </div>
        <!--<div class="row-fluid">
            <div class="span12">
                <?php
                    echo $this->Form->input('type', array(
                        'label' => 'Tipo:',
                        'options' => array(
                            'page' => 'Página',
                            'text' => 'Texto'
                        ),
                        'class' => 'disabled'
                    ));
                ?>
            </div>
        </div>-->
    </fieldset>
    <div class="form-actions f-right">
        <div class="left">
            <?php echo $this->Session->flash(); ?>
        </div>
        <?php 
            echo $this->Form->submit('Guardar', array('class' => 'btn btn-success btn-large', 'div' => false));
            echo $this->Form->button('Limpiar', array('type' => 'reset', 'class' => 'btn btn-large'));
        ?>
    </div>
    <?php echo $this->Form->end(); ?>
</div>