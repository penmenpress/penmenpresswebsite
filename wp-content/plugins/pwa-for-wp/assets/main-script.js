function pwaforwpGetParamByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}
jQuery(document).ready(function($){
    $(".pwaforwp-colorpicker").wpColorPicker();	// Color picker
	$(".pwaforwp-icon-upload").click(function(e) {	// Application Icon upload
		e.preventDefault();
		var pwaforwpMediaUploader = wp.media({
			title: pwaforwp_obj.uploader_title,
			button: {
				text: pwaforwp_obj.uploader_button
			},
			multiple: false,  // Set this to true to allow multiple files to be selected
                        library:{type : 'image'}
		})
		.on("select", function() {
			var attachment = pwaforwpMediaUploader.state().get("selection").first().toJSON();
			$(".pwaforwp-icon").val(attachment.url);
		})
		.open();
	});
	$(".pwaforwp-splash-icon-upload").click(function(e) {	// Splash Screen Icon upload
		e.preventDefault();
		var pwaforwpMediaUploader = wp.media({
			title: pwaforwp_obj.splash_uploader_title,
			button: {
				text: pwaforwp_obj.uploader_button
			},
			multiple: false,  // Set this to true to allow multiple files to be selected
                        library:{type : 'image'}
		})
		.on("select", function() {
			var attachment = pwaforwpMediaUploader.state().get("selection").first().toJSON();
			$(".pwaforwp-splash-icon").val(attachment.url);
		})
		.open();
	});

	$(".pwaforwp-tabs a").click(function(e){
		var href = $(this).attr("href");
		var currentTab = pwaforwpGetParamByName("tab",href);
		if(!currentTab){
			currentTab = "dashboard";
		}
		$(this).siblings().removeClass("nav-tab-active");
		$(this).addClass("nav-tab-active");
		$(".form-wrap").find(".pwaforwp-"+currentTab).siblings().hide();
		$(".form-wrap .pwaforwp-"+currentTab).show();		
		window.history.pushState("", "", href);
		return false;
	});
	var url      = window.location.href;     // Returns full URL
	var currentTab = pwaforwpGetParamByName("tab",url);
	if(currentTab=='help'){
		$('.pwaforwp-help').find("tr th:first").hide()
		$('.pwaforwp-settings-form').find('p.submit').hide();
	}
        
        $(".pwaforwp-activate-service").on("click", function(e){
            $(".pwaforwp-settings-form #submit").click();
            $(this).hide();
        });
        $(".pwaforwp-service-activate").on("click", function(){       
        var filetype = $(this).attr("data-id");                
                $.ajax({
                    url:ajaxurl,
                    dataType: "json",
                    data:{filetype:filetype, action:"pwaforwp_download_setup_files", pwaforwp_security_nonce:pwaforwp_obj.pwaforwp_security_nonce},
                    success:function(response){
	                    if(response["status"]=="t"){
	                        $(".pwaforwp-service-activate[data-id="+filetype+"]").hide();
	                        $(".pwaforwp-service-activate[data-id="+filetype+"]").siblings(".dashicons").removeClass("dashicons-no-alt");
	                        $(".pwaforwp-service-activate[data-id="+filetype+"]").siblings(".dashicons").addClass("dashicons-yes");
	                        $(".pwaforwp-service-activate[data-id="+filetype+"]").siblings(".dashicons").css("color", "#46b450");
	                    }else{
	                        alert(pwaforwp_obj.file_status);
	                    }  
                    }                
                });
        return false;
    });
        
    //Help Query
    $(".pwa-send-query").on("click", function(e){
	    e.preventDefault();   
	    var message = $("#pwaforwp_query_message").val();           
	                $.ajax({
	                    type: "POST",    
	                    url: ajaxurl,                    
	                    dataType: "json",
	                    data:{action:"pwaforwp_send_query_message", message:message, pwaforwp_security_nonce:pwaforwp_obj.pwaforwp_security_nonce},
	                    success:function(response){                       
	                      if(response['status'] =='t'){
	                        $(".pwa-query-success").show();
	                        $(".pwa-query-error").hide();
	                      }else{
	                        $(".pwa-query-success").hide();  
	                        $(".pwa-query-error").show();
	                      }
	                    },
	                    error: function(response){                    
	                    console.log(response);
	                    }
	                    });
	    
	});
         $(".pwaforwp-feedback-notice-close").on("click", function(e){
          e.preventDefault();               
                $.ajax({
                    type: "POST",    
                    url:ajaxurl,                    
                    dataType: "json",
                    data:{action:"pwaforwp_review_notice_close", pwaforwp_security_nonce:pwaforwp_obj.pwaforwp_security_nonce},
                    success:function(response){                       
                      if(response['status'] =='t'){
                       $(".pwaforwp-feedback-notice").hide();
                      }
                    },
                    error: function(response){                    
                    console.log(response);
                    }
                    });
    
        });
        
        $(".pwaforwp-manual-notification").on("click", function(e){
	    e.preventDefault();   
	    var message = $("#pwaforwp_notification_message").val();           
	                $.ajax({
	                    type: "POST",    
	                    url: ajaxurl,                    
	                    dataType: "json",
	                    data:{action:"pwaforwp_send_notification_manually", message:message, pwaforwp_security_nonce:pwaforwp_obj.pwaforwp_security_nonce},
	                    success:function(response){                                 
	                      if(response['status'] =='t'){
                                var html = '<span style="color:green">Success: '+response['success']+'</span><br>';
                                    html +='<span style="color:red;">Failure: '+response['failure']+'</span>';
	                        $(".pwaforwp-notification-success").show();
                                $(".pwaforwp-notification-success").html(html);
	                        $(".pwaforwp-notification-error").hide();
	                      }else{
	                        $(".pwaforwp-notification-success").hide();  
	                        $(".pwaforwp-notification-error").show();
	                      }
	                    },
	                    error: function(response){                    
	                    console.log(response);
	                    }
	                    });
	    
	});
        
	$("#pwaforwp_settings_utm_setting").click(function(){
		console.log($(this).prop("checked"));
		if($(this).prop("checked")){
			$('.pwawp_utm_values_class').fadeIn();
		}else{
			$('.pwawp_utm_values_class').fadeOut(200);
		}
	});
        $(".pwaforwp-onesignal-support").click(function(){		
		if($(this).prop("checked")){
			$('.pwaforwp-onesignal-instruction').fadeIn();
		}else{
			$('.pwaforwp-onesignal-instruction').fadeOut(200);
		}
	});
	$('.pwawp_utm_values_class').find('input').focusout(function(){
		if($(this).attr('data-val')!==$(this).val()){
			$("#pwa-utm_change_track").val('1');
		}
	});
});
