$(document).ready(function(){
	$('#saveUserForm').submit(function(){
		var form = $(this);
		textEditorsSave();
		doAjaxReq({
			form: form
		,	msgEl: $('#saveUserMsg')
		,	onSuccess: function(res) {
				if(res.event_edit_link) {
					redirect( res.event_edit_link );
				}
			}
		});
		return false;
	});
});