<div class="row">
    <div class="col-sm-12">
        <div class="page-header">
            <div class="clearfix">
                <h3 class="content-title pull-left"><?php $this->edit ? lang::_e('EDIT_EVENT') : lang::_e('CREATING_EVENT'); ?></h3>
            </div>
        </div>
    </div>
</div>
                        
<form action="<?php echo uri::getAdminLink('events/save')?>" id="saveProgramForm">
    <div id="saveProgramMsg"></div>
    
    <div class="col-md-8">
        <div class="form-group">
            <label for="event_title"><?php lang::_e('EVENT_LABEL'); ?></label>
            <?php echo html::text('label', array('value' => $this->edit ? $this->event['label'] : '', 'attrs' => 'id="event_title" class="form-control"')); ?>
        </div>
        <div class="form-group">
            <label for="event_description"><?php lang::_e('EVENT_DESC'); ?></label>
            <?php echo html::textarea('description', array('value' => $this->edit ? $this->event['description'] : '', 'attrs' => 'class="form-control ckeditor"')); ?>
        </div>
		<div class="panel panel-default">
            <div class="panel-heading"><i class="fa fa-picture-o"></i> <strong><?php lang::_e('Зображення')?></strong></div>
            <div class="panel-body">
				<div id="uploadFilesShell">
					<p><?php lang::_e('DRAG_OR_SELECT_FILES')?></p>
				</div>
				<div style="clear: both;"></div>
				<ul id="progrPhotosShell">
					<li class="example progrPhotoCell thumbnail">
						<img class="progrPhoto" src="" />
						<a class="progrRemovePhoto" href="<?php echo uri::getAdminLink('events/removeImage')?>" onclick="removeProgrImg(this); return false;"><span class="glyphicon glyphicon-trash"></span> <?php lang::_e('REMOVE')?></a>
					</li>
				</ul>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 event-sidebar">
        <div class="panel panel-default">
            <div class="panel-heading"><i class="fa fa-check-square-o"></i> <strong><?php lang::_e('EVENT_PARAMS')?></strong></div>
            <div class="panel-body">
				<div class="form-group">
                    <label for="event_categories"><?php lang::_e('CATEGORIES'); ?></label>
                    <?php echo html::selectlist('categories_ids', array(
						'options' => $this->categoriesList,
						'value' => $this->edit ? $this->event['categories_ids'] : '', 
						'attrs' => 'id="event_categories" class="form-control chosen"')); ?>
                </div>
				<div class="form-group">
                    <label for="event_locations"><?php lang::_e('LOCATIONS'); ?></label>
                    <?php echo html::selectlist('locations_ids', array(
						'options' => $this->locationsList,
						'value' => $this->edit ? $this->event['locations_ids'] : '', 
						'attrs' => 'id="event_locations" class="form-control chosen"')); ?>
                </div>
				<div class="form-group">
					<label for="event_date"><?php lang::_e('EVENT_DATE'); ?></label>
					<?php echo html::text('start_date', array('value' => $this->edit ? date::dateToDatepick($this->event['start_date']) : '', 'attrs' => 'id="start_date" class="form-control date"')); ?>
				</div>
				<div class="form-group">
					<label for="event_place"><?php lang::_e('EVENT_PLACE'); ?></label>
					
					<?php echo html::text('event_place', array('value' => $this->edit ? $this->event['event_place'] : '', 'attrs' => 'id="event_place" class="form-control"')); ?>
				</div>
                <?php echo html::hidden('id', array('value' => $this->edit ? $this->event['id'] : ''))?>
                <?php echo html::submit('save', array('value' => lang::_('SAVE_EVENT'), 'attrs' => 'class="btn btn-primary"'))?>
            </div>
        </div>
    </div>
</form>
