<!DOCTYPE HTML>
<html lang="en-US">
    <head>
        <meta charset="UTF-8">
        <title><?php echo empty($this->title) ? 'Портал Eventer' : $this->title; ?></title>
        
        <link rel="stylesheet/less" type="text/css" href="<?php echo document::_()->getTemplatesUrl(). '/style.less'; ?>" />
        <?php
            if(!empty($this->scripts)) echo $this->scripts;
            if(!empty($this->styles)) echo $this->styles;
        ?>
        
        <link rel="icon" href="<?php echo URL_ROOT.'/favicon.ico'; ?>" type="image/x-icon">
        <link rel="shortcut icon" href="<?php echo URL_ROOT.'/favicon.ico'; ?>" type="image/x-icon">
    </head>
	<body>
		<div class="header">
            <div class="container">
				<div class="col-md-12 nopadding">
					<div class="logo col-md-2 col-sm-2 col-xs-12 pull-left">
						<a href="<?php echo URL_ROOT; ?>"><img src="<?php echo document::_()->getTemplatesUrl().'/img/uwc_logo.png'; ?>" alt="" /></a>
					</div>
					
                    <?php if(rs('user.isLoggedIn')) { ?>
                        <div class="pull-right logged-user">
                            <?php $user = rs('user.model.getLoggedIn'); ?>
                            Ви увійшли як <a  class="login" href="<?php echo uri::getLink('user/profile'); ?>"><?php echo $user['login']; ?></a>. <a class="login" href="<?php echo uri::getLink('user/logout') ?>">Вийти?</a>
                        </div>
                    <?php } else { ?>
                        <div class="pull-right logged-user">
                            <a class="not-login" href="<?php echo uri::getLink( LOGIN_ALIAS ); ?>">Вхід</a>
                        </div>
                    <?php } ?>
					<div class="search pull-right col-md-4">
						<form action="<?php echo uri::getLink('events/list')?>">
							<input type="text" name="s" placeholder="Шукати..." />
						</form>
					</div>
					<div class="clearfix"></div>
					<div class="events-list">
						<div class="inner">
							<div class="event-types">
								<?php $array = rs('categories.model.getListForFrontend'); ?>
								<?php 
									foreach($array as $category) {
										$cat_title = $category['label'];
										$cat_link = rs('categories.getLink', $category);
										echo '<a href="'.$cat_link.'" class="button">'.$cat_title.'</a>';
									}
								?>
							</div>
						</div>
					</div>
					
				</div>
                <div class="clearfix"></div>
            </div>
        </div>
		
        <?php echo $this->content;?>
		
		<?php echo $this->footer;?>
        
	</body>
</html>