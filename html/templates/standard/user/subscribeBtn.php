<?php if(!$this->subscribed) {?>
    <a href="<?php echo uri::getLink('user/subscribe/'. $this->eid, array('_nonce' => html::generateNonce('subscribe')))?>" class="subscribeBtn btn btn-success" data-eid="<?php echo $this->eid?>">
		<i class="fa fa-thumbs-o-up"> </i> <?php lang::_e('SUBSCRIBE')?>
	</a>
<?php }?>