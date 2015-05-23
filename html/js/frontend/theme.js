var mainCategoriesHtml = {};
jQuery(document).ready(function(){
    jQuery('#slippry').slippry();
    
    jQuery('.openUserPopup').click(function(e){
        jQuery('#userModal').modal('show');
    });

    jQuery('.tip').tooltip();
    jQuery('.dropdown-toggle').dropdown();
  
    var offset = 220;
    var duration = 500;
    jQuery(window).scroll(function() {
        if (jQuery(this).scrollTop() > offset) {
            jQuery('.back-to-top').fadeIn(duration);
        } else {
            jQuery('.back-to-top').fadeOut(duration);
        }
    });
    
    jQuery('.back-to-top').click(function(event) {
        event.preventDefault();
        jQuery('html, body').animate({scrollTop: 0}, duration);
        return false;
    });
	
	jQuery('#myTab1 .mainCategoryLink').click(function(){
		var id = parseInt(jQuery(this).data('id'))
		,	dataToEl = jQuery(jQuery(this).attr('href'))
		,	writeHtml = function() {
				dataToEl.html( mainCategoriesHtml[ id ] );
			};
		
		if(!mainCategoriesHtml[ id ]) {
			doAjaxReq({
				url: getReqUrl('categories/getProductsHtml/'+ id)
			,	msgEl: dataToEl
			,	onSuccess: function(res) {
					if(!res.errors && res.html) {
						mainCategoriesHtml[ id ] = res.html;
						writeHtml();
					}
				}
			});
		} else {
			writeHtml();
		}
	});
	jQuery('#myTab1 .mainCategoryLink:first').click();
    
    // animate download counter for products
    var count = jQuery('.progress p').attr('data-has');
    jQuery('.progress p').animateNumber(
        {
          number: count
        },
        1000
    );
    
    jQuery('#filters a').click(function (e) {
        e.preventDefault();
        jQuery(this).tab('show');
    })
	
	jQuery(".goto_btn .goto").click(function() {
    jQuery('html, body').animate({
        scrollTop: jQuery("#content").offset().top
    }, 1000);
});
    $('#userLoginForm').submit(function(){
        doAjaxReq({
           form: this
        ,	msgEl: $('#userLoginMsg')
        ,	onSuccess: function(res) {
				if(!res.error) {
					if(res.return) {
						redirect( res.return );
					}
				}
			}
        });
        return false;
    });
	 $('#userRegForm').submit(function(){
        doAjaxReq({
           form: this
        ,	msgEl: $('#userRegMsg')
        ,	onSuccess: function(res) {
				if(!res.error) {
					reload();
				}
			}
        });
        return false;
    });
});
