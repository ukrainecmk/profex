<?php echo $this->banner;?>

<div class="container">
    <div class="col-md-6 col-sm-6 col-xs-12">
        <h2>Профіль користувача</h2>
        <form action="<?php echo uri::getLink('user/saveProfile')?>" class="profileForm">
            <div class="form-group">
                <label for="first_name" class="control-label"><?php lang::_e('FIRST_NAME')?></label>
                <?php echo html::text('first_name', array('value' => $this->user['first_name'], 'attrs' => 'class="form-control"'))?>
            </div>
            <div class="form-group">
                <label for="last_name" class="control-label"><?php lang::_e('LAST_NAME')?></label>
                <?php echo html::text('last_name', array('value' => $this->user['last_name'], 'attrs' => 'class="form-control"'))?>
            </div>
            <div class="form-group">
                <label for="email" class="control-label"><?php lang::_e('EMAIL')?></label>
                <?php echo html::text('email', array('value' => $this->user['email'], 'attrs' => 'class="form-control"'))?>
            </div>
            <div class="form-group">
                <label for="login" class="control-label"><?php lang::_e('LOGIN')?></label>
                <?php echo html::text('login', array('value' => $this->user['login'], 'attrs' => 'class="form-control"'))?>
            </div>
            <div class="form-group">
                <label for="passwd" class="control-label"><?php lang::_e('PASSWORD')?></label>
                <?php echo html::text('passwd', array('attrs' => 'class="form-control"'))?>
            </div>
            <?php echo html::formEnd('subscribe')?>
            <div class="text-center">
                <input type="submit" class="btn btn-primary" value="<?php lang::_e('SAVE')?>" />
            </div>
            <div class="profileFormMsg"></div>
        </form>
    </div>

    <div class="col-md-6 col-sm-6 col-xs-12">
        <h2>Я піду на:</h2>
        <?php if(!empty($this->user['subscribed']) && !empty($this->subscribedPrograms)) { ?>
            <ul class="list-group">
            <?php foreach($this->subscribedPrograms as $p) { ?>
                    <li class="subscriptionRow list-group-item">
                        <a href="<?php echo uri::getLink('events/view/'. $p['id'])?>"><?php echo $p['label']?></a>
                        <a class="unsubscribeBtn label label-danger pull-right" href="<?php echo uri::getLink('user/unsubscribe/'. $p['id'])?>"><?php lang::_e('UNSUBSCRIBE')?></a>
                    </li>
            <?php }?>
            </ul>
        <?php }?>
    </div>
    
    <div class="clearfix"></div>
    
    <br /><br />
</div>