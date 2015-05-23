<?php if(!frame::_()->isHome()) {
	echo $this->banner;
}?>
<div class="events" id="content">
    <div class="container">
        <div class="col-md-12 nopadding"> 
            <span class="title"><?php if(isset($this->pageData['category']['label'])) echo $this->pageData['category']['label']; else echo 'Актуальні події'; ?></span>
            <div class="clearfix"></div>
            
            <div class="events-cat">
                <?php $i = 1; ?>
                <?php if(!empty($this->events)) { ?>
                    <?php foreach($this->events as $p) { ?>
                        <div class="col-md-4 col-sm-4 col-xs-6 project-item nopadding animated" data-animtype="fadeInUp"
                                             data-animrepeat="0"
                                             data-animspeed="0.7s"
                                             data-animdelay="0.3s">
                            <div class="project-inside">
                                <?php if(!empty($p['files'])) {?>
                                    <a href="<?php echo rs('events.getLink', $p)?>">
                                        <img class="img-responsive" src="<?php echo $p['files'][0]['url']?>" />
                                    </a>
                                <?php }?>
                                <div class="project-information">
                                    <div class="pull-left">
                                        <div class="accepted">
                                            <p><?php echo $p['label']; ?></p><br />
                                            <p><i class="fa fa-user"></i> <?php echo $p['subscribed']; ?></p>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                    <a href="<?php echo rs('events.getLink', $p)?>" class="join"><?php lang::_e('EVENTM_DETAILS')?></a>
                                    
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <?php if($i++ % 3 == 0) echo '<div class="clearfix"></div>'; ?>
                        <?php //rs('user.view.showSubscribeBtn', $p['id'])?>
                        
                    <?php }?>
                <?php } else { ?>
                    <b><?php lang::_e('NO_EVENTS_FOUND')?></b>
                <?php }?>
				<div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<div class="clearfix"></div>