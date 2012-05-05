<div class="box content">
    <header>
        <h1 class="title btn-small"><?php echo $title_for_layout; ?></h1>
        <div class="btn-group right">
            <?php 
                echo $this->Html->link('Ver', array('controller' => $content, 'action' => 'ver', $id),
                    array('class' => 'btn btn-small'));
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-list'));
                echo $this->Html->link($icon_plus . ' Resumen', array('controller' => $content, 'action' => 'index'),
                    array('class' => 'btn btn-small', 'escape' => false));
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-home'));
                echo $this->Html->link($icon_plus . ' Escritorio', array('controller' => 'dashboard', 'action' => 'index'),
                    array('class' => 'btn btn-small', 'escape' => false));
            ?>
        </div>
    </header>
    <?php echo $this->Session->flash(); ?>
    <?php 
        echo $this->Form->create('Archivo', array('url' => array('action' => 'agregar', $content),
            'id' => 'fileupload', 'enctype' => 'multipart/form-data')); ?>
        <?php    
            // You can add other form inputs and they will automatically be added to every AJAX request.
            // In this case, I made sure to add a 'user_id' column in the photos table of the database.   
            echo $this->Form->input('content_id', array('type' => 'hidden', 'value' => $id));
        ?>
        <div class="row fileupload-buttonbar">
            <div class="span7">
                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn btn-success fileinput-button">
                    <i class="icon-plus icon-white"></i>
                    <span>A&ntilde;adir archivos...</span>
                    <?php     
                        echo $this->Form->input('file', array(
                            'type' => 'file',
                            'label' => false,
                            'div' => false,
                            'class' => 'fileUpload',
                            'multiple' => 'multiple'
                    ));
                    ?>
                </span>
                <button type="submit" class="btn btn-primary start">
                    <i class="icon-upload icon-white"></i>
                    <span>Comenzar subida</span>
                </button>
                <button type="reset" class="btn btn-warning cancel">
                    <i class="icon-ban-circle icon-white"></i>
                    <span>Cancelar subida</span>
                </button>
                <button type="button" class="btn btn-danger delete">
                    <i class="icon-trash icon-white"></i>
                    <span>Borrar</span>
                </button>
                <input type="checkbox" class="toggle">
            </div>
            <div class="span5">
                <!-- The global progress bar -->
                <div class="progress progress-success progress-striped active fade">
                    <div class="bar" style="width:0%;"></div>
                </div>
            </div>
        </div>
        <!-- The loading indicator is shown during image processing -->
        <div class="fileupload-loading"></div>
        <br>
        <!-- The table listing the files available for upload/download -->
        <table class="table table-striped">
            <tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery">
                <?php foreach ($archivos as $a):
                        $arch = $a['Archivo'];
                    ?>
                <tr class="template-download fade in">
                    <td class="preview">
                        <?php if ($arch['thumbnail_url']) { ?>
                            <a href="<?php echo $arch['url']; ?>" title="<?php echo $arch['basename']; ?>" rel="gallery" download="<?php echo $arch['basename']; ?>">
                                <img src="<?php echo $arch['thumbnail_url']; ?>">
                            </a>
                        <?php } ?>
                    </td>
                    <td class="name">
                        <a href="<?php echo $arch['url'] ?>" title="<?php echo $arch['basename'] ?>" download="<?php echo $arch['basename']; ?>"><?php echo $arch['basename'] ?></a>
                    </td>
                    <td class="size"><span><?php echo $this->Number->toReadableSize($arch['size']); ?></span></td>
                    <td colspan="2"></td>
                    <td class="delete">
                        <button class="btn btn-danger" data-type="<?php echo 'post'; ?>" data-url="<?php
                            echo $this->Html->url(array('controller' => 'archivos', 'action' => 'borrar', $arch['id']));
                        ?>">
                            <i class="icon-trash icon-white"></i>
                            <span>Borrar</span>
                        </button>
                        <input type="checkbox" name="delete" value="1">
                    </td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    <?php echo $this->Form->end(); ?>
</div>
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td class="preview"><span class="fade"></span></td>
        <td class="name"><span>{%=file.name%}</span></td>
        <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
        {% if (file.error) { %}
            <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
        {% } else if (o.files.valid && !i) { %}
            <td>
                <div class="progress progress-success progress-striped active"><div class="bar" style="width:0%;"></div></div>
            </td>
            <td class="start">{% if (!o.options.autoUpload) { %}
                <button class="btn btn-primary">
                    <i class="icon-upload icon-white"></i>
                    <span>{%=locale.fileupload.start%}</span>
                </button>
            {% } %}</td>
        {% } else { %}
            <td colspan="2"></td>
        {% } %}
        <td class="cancel">{% if (!i) { %}
            <button class="btn btn-warning">
                <i class="icon-ban-circle icon-white"></i>
                <span>{%=locale.fileupload.cancel%}</span>
            </button>
        {% } %}</td>
    </tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        {% if (file.error) { %}
            <td></td>
            <td class="name"><span>{%=file.name%}</span></td>
            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
            <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
        {% } else { %}
            <td class="preview">{% if (file.thumbnail_url) { %}
                <a href="{%=file.url%}" title="{%=file.name%}" rel="gallery" download="{%=file.name%}"><img src="{%=file.thumbnail_url%}"></a>
            {% } %}</td>
            <td class="name">
                <a href="{%=file.url%}" title="{%=file.name%}" rel="{%=file.thumbnail_url&&'gallery'%}" download="{%=file.name%}">{%=file.name%}</a>
            </td>
            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
            <td colspan="2"></td>
        {% } %}
        <td class="delete">
            <button class="btn btn-danger" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}">
                <i class="icon-trash icon-white"></i>
                <span>{%=locale.fileupload.destroy%}</span>
            </button>
            <input type="checkbox" name="delete" value="1">
        </td>
    </tr>
{% } %}
</script>