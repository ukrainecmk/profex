<?php 
    if(!empty($this->event['files'])){
        $src = $this->event['files'][0]['url'];
    } else {
        $src = "images/concert-bg.jpg";
    }
?>
<div class="banner-header" style="background-image:url(<?= $src; ?>);"> 
    <div class="inner">
        <h1 class="project-title text-center"><?php echo $this->event['label']?></h1>
    </div>
</div>

<div class="container">
    <div class="col-md-12 project-single nopadding">
        <div class="col-md-8 col-sm-6 col-xs-12 nopadding">
            <div class="project-image">
                <?php if(!empty($this->event['files']) && count($this->event['files']) > 1) {?>
                    <ul id="slippry">
                        <?php foreach($this->event['files'] as $f) { ?>
                            <li><img src="<?php echo $f['url']?>" alt="" /></li>
                        <?php }?>
                    </ul>
                <?php } elseif(!empty($this->event['files']) && count($this->event['files']) == 1) { ?>
                    <img src="<?php echo $this->event['files'][0]['url']; ?>" alt="" />
                <?php } ?>
            </div>
            
            <div class="project-description">
                <?php echo $this->event['description']?>
                <div class="clearfix"></div>
            </div>
            
           
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12 nopadding-right">
            <div class="params">
                <div class="col-md-6 col-sm-6 col-xs-12 text-center see"><i class="fa fa-eye"></i> <?php echo $this->event['views']; ?></div>
                <div class="col-md-6 col-sm-6 col-xs-12 text-center see heart"><i class="fa fa-heart-o"></i> <?php echo $this->event['subscribed']; ?></div>
                <div class="clearfix"></div>
                
                <div class="event-links">
                    <div class="category col-md-6 col-sm-6 col-xs-12">
						<span>Категорія:</span><br />
                        <?php foreach($this->event['categories'] as $type): ?>
                            <a href="<?php echo uri::getLink('events/list/category/'.$type['id']); ?>"><?php echo $type['label']; ?></a><br />
                        <?php endforeach; ?>
                    </div>
                    <div class="location col-md-6 col-sm-6 col-xs-12">
						<span>Місто:</span><br />
                        <?php foreach($this->event['locations'] as $type): ?>
                            <a href="<?php echo uri::getLink('events/list/location/'.$type['id']); ?>"><?php echo $type['label']; ?></a><br />
                        <?php endforeach; ?>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            
            <div class="project-content">
                    
                    <p><i class="fa fa-calendar"></i> Початок події: <?php echo $this->event['start_date']; ?></p>
                    <p><i class="fa fa-map-marker"></i> Місце проведення: <?php echo $this->event['event_place']; ?></p>
                    <?php rs('user.view.showSubscribeBtn', $this->event['id'])?>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>