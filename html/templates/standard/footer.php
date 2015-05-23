 <div class="footer">
	<div class="container">
		<div class="col-md-12 nopadding">
			<div class="footer-logo">
				<a href="<?php echo URL_ROOT; ?>"><img src="<?php echo document::_()->getTemplatesUrl().'/images/logo-white.png'; ?>" class="img-responsive" alt="" /></a>
				<div class="clearfix"></div>
			</div>
            
            <dl class="footer-nav">
                <dt class="nav-title">Корисні посилання</dt>
                <dd class="nav-item"><a href="#">Наші партнери</a></dd>
                <dd class="nav-item"><a href="#">Правила сайту</a></dd>
                <dd class="nav-item"><a href="#">Про проект</a></dd>
                <dd class="nav-item"><a href="#" class="openUserPopup">Контакти</a></dd>
            </dl>
            
			<div class="col-md-3 col-sm-3 col-xs-12 nopadding copyright pull-right">
				<p>© 2015 рік</p>
				<div class="clearfix"></div>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="clearfix"></div>
	</div>
</div>

<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                
                <div role="tabpanel">

                  <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#login" aria-controls="home" role="tab" data-toggle="tab">Вхід для користувачів</a>
                        </li>
                        <li role="presentation">
                            <a href="#register" aria-controls="profile" role="tab" data-toggle="tab">Реєстрація</a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="login">
                            <form action="<?php echo uri::getLink('user/login')?>" id="userLoginForm">
                                <div class="form-group">
                                    <label>Електронна пошта</label>
                                    <input class="form-control" name="login" type="email">
                                </div>
                                <div class="form-group">
                                    <label>Пароль</label>
                                    <input class="form-control" name="passwd" type="password">
                                </div>
                                <input type="submit" class="btn btn-danger" value="Увійти" />
								<input type="hidden" name="return" value="<?php echo uri::getCurrent()?>" />
								<input type="hidden" name="eid" value="" />
								<div id="userLoginMsg"></div>
                            </form>
                        </div>
                        
                        <div role="tabpanel" class="tab-pane" id="register">
                            <form action="<?php echo uri::getLink('user/subscribe')?>" id="userRegForm">
                                <div class="form-group">
                                    <label>Електронна пошта</label>
                                    <input class="form-control" name="email" type="email">
                                </div>
                                <div class="form-group">
                                    <label>Прізвище та ім’я</label>
                                    <input class="form-control" name="first_name" type="text">
                                </div>
                                <div class="form-group">
                                    <label>Пароль</label>
                                    <input class="form-control" name="passwd" type="password">
                                </div>
                                <input type="submit" class="btn btn-warning" value="Зареєструватися" />
								<div id="userRegMsg"></div>
								<input type="hidden" name="eid" value="" />
								<?php echo html::formEnd('subscribe')?>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div id="subscribeWnd" title="Підписатися">
	<?php echo rs('user.view.getSubscribeForm')?>
</div>