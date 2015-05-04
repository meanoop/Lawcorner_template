<script type="text/javascript">
    $(document).ready(function() {
		$('.fancybox').fancybox();
		
		var loggedin =<?php echo $loggedin ?>;
		$(".styled, select").uniform();
        $("#login_submit").click(function() {
            var password = $("#password").val();
            var email = $("#email").val();
			
            $.post(
                    "/ajaxlogin/",
                    {
                        email: email,
                        password: password
                    },
            function(data) {
                if (data == 'client') {
                    loggedin = 1;
                    $('#reg-box').hide();
                    //ToggleRegisterBox_top();
                    $('.register-overlay').fadeOut();
									
                    save_question();
					                
                    $(".login-section").hide();
                    $(".loginseparator").hide();
                }
            });
        });
		
		 window.validator = $('#ask-question-form').validate(
         	{
					validClass: 'checked',
                    errorClass: 'warning',
                    errorElement: 'label',
                    ignore: '.ignore',
                    rules:
                            {
                               
							   	title:
                                        {
                                            required: true,
											minlength: 6
                                        },
								law_type:
										{
											required:true, 						  
										},
                              	postcode_edit:
										{
											required:true, 
											minlength:3, 							  
										},
                            },
                            
                    messages:
                            {
                                
                                title:
                                        {
                                            required: 'Question title required',
                                            minlength: jQuery.format('Question title too short')
                                        },
                               
                            
								law_type:
										{
											required: 'Please select a Practise area',				  
										},
                              	postcode_edit:
										{
											required: 'Postcode is required',
											minlength: jQuery.format('Please enter a valid pincode')					  
										},
                                
                            },
                    errorPlacement: function(error, element)
                    {
                        $('#' + element.attr('id') + '_check').html('&#33;').addClass('warning');
                    },
                    success: function(label, element)
                    {
                        label.html('&#10003;').removeClass('warning').addClass('checked');
                        $('#' + $(element).attr('id')).qtip('destroy').removeClass('invalid');
						
						$('.terms_area').removeClass('warning_msg');
                    },
                    highlight: function(element, errorClass, validClass)
                    {
                       
                       	var checkElementId = '#' + $(element).attr('id') + '_check';
                        
                        $(checkElementId).html('&#33;').removeClass(validClass).addClass(errorClass);
                    },
                    unhighlight: function(element, errorClass, validClass)
                    {
                        if(typeof($(element).attr('id')) != 'undefined'){
	                        
	                        var checkElementId = '#' + $(element).attr('id') + '_check';
	                        
	                        if ($(element).data('qtip'))
	                        {
	                            $(element).qtip('destroy');
	                        }
	                        $(checkElementId).html('&#10003;').removeClass(errorClass).addClass(validClass);
                        }
                    },
                    showErrors: function(errorMap, errorList)
                    {
                        var i, elements;
                        for (i = 0; this.errorList[i]; i++)
                        {
                            var error = this.errorList[i];
                            if (this.settings.highlight)
                            {
                                this.settings.highlight.call(this, error.element, this.settings.errorClass, this.settings.validClass);
                            }
                            this.showLabelNew(error.element, error.message);
                        }
                        if (this.errorList.length)
                        {
                            this.toShow = this.toShow.add(this.containers);
                        }
                        if (this.settings.success)
                        {
                            for (i = 0; this.successList[i]; i++)
                            {
                                this.showLabelNew(this.successList[i]);
                            }
                        }
                        if (this.settings.unhighlight)
                        {
                            for (i = 0, elements = this.validElements(); elements[i]; i++)
                            {
                                this.settings.unhighlight.call(this, elements[i], this.settings.errorClass, this.settings.validClass);
                            }
                        }
                        this.toHide = this.toHide.not(this.toShow);
                        this.hideErrors();
                        this.addWrapper(this.toShow).show();
                    }
                });
	
		 $("#question_submit").click(function(event) {
		
            var titleValid = $('#title').valid(); 
			var typeValid = $('#law_type').valid(); 
			var postcodeValid = $('#postcode_edit').valid(); 
			
            ValidateQuestionData = titleValid && typeValid && postcodeValid ;
            if (ValidateQuestionData)
            {
				event.preventDefault();
				
				if (!get_recaptcha_response())	{ 
					return false;
					//$('.g-recaptcha').css('border', '3px solid red'); 
				}
				else {grecaptcha.reset();}
				
                if (loggedin != 1){
					
  					
					$.fancybox.close();
					//hide_all();
					$('#reg-box').show();
                  	ToggleRegisterBox_top();
                
                }else{
                    //  Submit question 
					$.fancybox.close();
					//$('#ask-question-box').hide();
                    //ToggleRegisterBox_top();
                   // $('.register-overlay').fadeOut();
					
				   	save_question();
                }
            } 
		
        });

        $("#ask_question").click(function(event) {
			
			current_postcode = get_current_postcode();
			if (current_postcode) { 
				event.preventDefault();
				
				$("#ask_question_fancybox_link").fancybox().trigger('click');
				
				$('#postcode_edit').val(current_postcode);
				
				$('.register-overlay').click(function() {
			   		// ToggleRegisterBox_top();
					$('#postcode-box').css('display', 'none');	
					$('#overlay').css('display', 'none');							
					return false;
				});
				
			} else { 
				event.preventDefault();
				
				$('#result_side').empty();
            	$('#postCodeFromtopmenu').show();
            	$('#search_side').hide();
                TogglePostcodeBox_top();
                
               	return false;
				
				//$('#postcode-form').attr('action', '/find-a-lawyer/');
				// TogglePostcodeBox();			 
			}  
        });
		
		(function($)
        {
            $.extend(true, $.validator,
                    {
                        prototype:
                                {
                                    showLabelNew: function(element, message)
                                    {
                                        var label = this.errorsFor(element);
                                        if (label.length)
                                        {
                                            if ($(element).is(':file'))
                                            {
                                                element = '#photo-area';
                                            }
                                            else if ($(element).is(':radio'))
                                            {
                                                element = '#genders [name="gender"]';
                                            }

                                            if ($(element).data('qtip'))
                                            {
                                                $(element).qtip('option', 'content.text', message);
                                            }
                                            else
                                            {
                                                if (element == '#photo-area')
                                                {
                                                    $(element).qtip({content: {text: message}, style: {classes: 'qtip-red qtip-rounded qtip-shadow tooltip'}, position: {my: 'top center', at: 'bottom center'}}).addClass('invalid');
                                                }
                                                else if (element == '#genders [name="gender"]')
                                                {
                                                    $(element).qtip({content: {text: message}, style: {classes: 'qtip-red qtip-rounded qtip-shadow tooltip'}, position: {my: 'top left', at: 'bottom left'}}).addClass('invalid');
                                                }
                                                else
                                                {
                                                    $(element).qtip({content: {text: message}, style: {classes: 'qtip-red qtip-rounded qtip-shadow tooltip'}}).addClass('invalid');
                                                }
                                            }
                                        }
                                        else
                                        {
                                            // create label
                                            label = $('<' + this.settings.errorElement + '>')
                                                    .attr('for', this.idOrName(element))
                                                    .addClass(this.settings.errorClass)
                                                    .html(message || '');
                                            if (this.settings.wrapper)
                                            {
                                                // make sure the element is visible, even in IE
                                                // actually showing the wrapped element is handled elsewhere
                                                label = label.hide().show().wrap('<' + this.settings.wrapper + '/>').parent();
                                            }
                                            if (!this.labelContainer.append(label).length)
                                            {
                                                if (this.settings.errorPlacement)
                                                {
                                                    this.settings.errorPlacement(label, $(element));
                                                }
                                                else
                                                {
                                                    label.insertAfter(element);
                                                }
                                            }
                                        }
                                        if (!message && this.settings.success)
                                        {
                                            label.text('');
                                            if (typeof this.settings.success === 'string')
                                            {
                                                label.addClass(this.settings.success);
                                            }
                                            else
                                            {
                                                this.settings.success(label, element);
                                            }
                                        }
                                        this.toShow = this.toShow.add(label);
                                    }
                                }
                    });
        }(jQuery));
		
		//added
		
		 $('#log-m').click(function(evt){
            evt.preventDefault();
            
            //  Toggle login box
            $('#regdiv').hide();
            $('#logindiv').show();
			$(this).addClass('active-tab');
			$('#reg-m').removeClass('active-tab');
        });
        
        $('#reg-m').click(function(evt){
            evt.preventDefault();
            
            //  Toggle login box
            $('#logindiv').hide();
            $('#regdiv').show();
			$(this).addClass('active-tab');
			$('#log-m').removeClass('active-tab');
        });
        
        //  User clicks register button
        $("#reg_submit").click(function(evt) {
            evt.preventDefault();
            
                
            if ( $("#register-user-form").valid() ){
                $.post(
                    "/register-client/",
                    {
                        'reg_first_name': $('#reg_first_name').val(),
                        'reg_last_name': $('#reg_last_name').val(),
                        'reg_email': $('#reg_email').val(),
                        'reg_password': $('#reg_password').val()
                    },
                    function(data) {
                        if (data) {
                                loggedin = 1;

                                $('#reg-box').hide();
                                //ToggleRegisterBox_top();
                                $('.register-overlay').fadeOut();
                                save_question('signup');

                                $(".login-section").hide();
                                $(".loginseparator").hide();
                            }
                    });
            }
        });
		
		//added
		
    });
    
	// save the client question
    function save_question(mode){
		
		var question_title = $('#title').val();
		var description = $('#description').val();
		var postcode_edit = $('#postcode_edit').val();
		var law_type = $('#law_type').val();
		
		current_postcode = get_current_postcode();
		
		if (current_postcode != postcode_edit)	{
			setPostcode_aq(postcode_edit);
		}
		
        $.post(
                        "/save-question/",
                        {
                            question_title: question_title, description: description, postcode_edit: postcode_edit, law_type:law_type
                        },
                function(data) {
                    if (data == "saved") {
                        $("#message").text(function() {
                            return "Question was saved";
                        });
                        var overlay = $('#overlay');
                        var postcodeBox = $('#postcode-box');

                        // Hide
                        if (overlay.css('display') == 'block' && postcodeBox.css('display') == 'block' && (1 || postcodeBox.css('top') == '85px' || postcodeBox.css('top') == '95px'))
                        {
                            postcodeBox.animate({'top': '-=25', 'opacity': 0}, 250, function() {
                                $(this).css('display', 'none');
                            });
                            overlay.fadeOut();
                            
                        } 
                        else if (postcodeBox.css('top') == '60px' || postcodeBox.css('top') == '70px' || 1)
                        {
                            // Show
							if(mode == 'signup'){
								$('#thanks-box p').html('Thanks for asking a question. Please verify your email address by clicking the email we just sent you.');
								$('#ask-question-form')[0].reset();
							}else{
								$('#thanks-box p').html('Thanks for asking a question.');
								$('#ask-question-form')[0].reset();
							}
                            $('#thanks-box').css('display','block');
                            overlay.fadeTo(250, 0.85);
                            postcodeBox.css('display', 'block').animate({'opacity': 1, 'top': '+=26'}, 250);
                        }
                        $('#overlay').click(function(){
                            //window.location.replace("/"+lawyer_id+"/Lawyer");
                        })
                        
                            
                    } else {
						alert("Question was not saved");
                        $("#message").text(function() {
							
                            return "Question was not saved";
                        });
                    }
                });
    }
	
	// get the updated postcode through ajax
    function get_current_postcode(){
        
		var result = 0;
		
		$.ajax({
				url : '/get-postcode/',
				type : "get",
				async: false,
				success : function(data) {
				   if (data !== null && data.length >= 3 && data.length <= 4)
                    {
                    	result = data;
                    }
					else {
						result = 0;	
					}
				},
				error: function() {
				    result = 0;
				}
			 });
 
		return result ;
				
				
    }
	
	// get google recaptcha response through ajax
    function get_recaptcha_response(){
        
		recaptcha_response = true;
		data = $("#ask-question-form").serialize();
		
		$.ajax({
			url: '/recaptcha-response/',
			type: 'POST',
			data: data,
			async : false,
			success: function(result) {
				if (result == '1')	{
					recaptcha_response = true;
				} else {
					recaptcha_response = false;
				}
				
			}
		});
				
		return recaptcha_response;	
    }
	
	function setPostcode_aq(postcode)
	{
		if (postcode.length == 4 || postcode.length == 3)
		{
        	$.post(
                    '/set-postcode/',
                    {
                        postcode: postcode,
                    },
            		function(data) {
               		 	if (data == 'client') {}
            		});
			
    	}
	}
	
	//jquery.uniform.js
	(function(a){a.uniform={options:{selectClass:"selector",radioClass:"radio",checkboxClass:"checker",fileClass:"uploader",filenameClass:"filename",fileBtnClass:"action",fileDefaultText:"No file selected",fileBtnText:"Choose File",checkedClass:"checked",focusClass:"focus",disabledClass:"disabled",buttonClass:"button",activeClass:"active",hoverClass:"hover",useID:true,idPrefix:"uniform",resetSelector:false,autoHide:true},elements:[]};if(a.browser.msie&&a.browser.version<7){a.support.selectOpacity=false}else{a.support.selectOpacity=true}a.fn.uniform=function(k){k=a.extend(a.uniform.options,k);var d=this;if(k.resetSelector!=false){a(k.resetSelector).mouseup(function(){function l(){a.uniform.update(d)}setTimeout(l,10)})}function j(l){$el=a(l);$el.addClass($el.attr("type"));b(l)}function g(l){a(l).addClass("uniform");b(l)}function i(o){var m=a(o);var p=a("<div>"),l=a("<span>");p.addClass(k.buttonClass);if(k.useID&&m.attr("id")!=""){p.attr("id",k.idPrefix+"-"+m.attr("id"))}var n;if(m.is("a")||m.is("button")){n=m.text()}else{if(m.is(":submit")||m.is(":reset")||m.is("input[type=button]")){n=m.attr("value")}}n=n==""?m.is(":reset")?"Reset":"Submit":n;l.html(n);m.css("opacity",0);m.wrap(p);m.wrap(l);p=m.closest("div");l=m.closest("span");if(m.is(":disabled")){p.addClass(k.disabledClass)}p.bind({"mouseenter.uniform":function(){p.addClass(k.hoverClass)},"mouseleave.uniform":function(){p.removeClass(k.hoverClass);p.removeClass(k.activeClass)},"mousedown.uniform touchbegin.uniform":function(){p.addClass(k.activeClass)},"mouseup.uniform touchend.uniform":function(){p.removeClass(k.activeClass)},"click.uniform touchend.uniform":function(r){if(a(r.target).is("span")||a(r.target).is("div")){if(o[0].dispatchEvent){var q=document.createEvent("MouseEvents");q.initEvent("click",true,true);o[0].dispatchEvent(q)}else{o[0].click()}}}});o.bind({"focus.uniform":function(){p.addClass(k.focusClass)},"blur.uniform":function(){p.removeClass(k.focusClass)}});a.uniform.noSelect(p);b(o)}function e(o){var m=a(o);var p=a("<div />"),l=a("<span />");if(!m.css("display")=="none"&&k.autoHide){p.hide()}p.addClass(k.selectClass);if(k.useID&&o.attr("id")!=""){p.attr("id",k.idPrefix+"-"+o.attr("id"))}var n=o.find(":selected:first");if(n.length==0){n=o.find("option:first")}l.html(n.html());o.css("opacity",0);o.wrap(p);o.before(l);p=o.parent("div");l=o.siblings("span");o.bind({"change.uniform":function(){l.text(o.find(":selected").html());p.removeClass(k.activeClass)},"focus.uniform":function(){p.addClass(k.focusClass)},"blur.uniform":function(){p.removeClass(k.focusClass);p.removeClass(k.activeClass)},"mousedown.uniform touchbegin.uniform":function(){p.addClass(k.activeClass)},"mouseup.uniform touchend.uniform":function(){p.removeClass(k.activeClass)},"click.uniform touchend.uniform":function(){p.removeClass(k.activeClass)},"mouseenter.uniform":function(){p.addClass(k.hoverClass)},"mouseleave.uniform":function(){p.removeClass(k.hoverClass);p.removeClass(k.activeClass)},"keyup.uniform":function(){l.text(o.find(":selected").html())}});if(a(o).attr("disabled")){p.addClass(k.disabledClass)}a.uniform.noSelect(l);b(o)}function f(n){var m=a(n);var o=a("<div />"),l=a("<span />");if(!m.css("display")=="none"&&k.autoHide){o.hide()}o.addClass(k.checkboxClass);if(k.useID&&n.attr("id")!=""){o.attr("id",k.idPrefix+"-"+n.attr("id"))}a(n).wrap(o);a(n).wrap(l);l=n.parent();o=l.parent();a(n).css("opacity",0).bind({"focus.uniform":function(){o.addClass(k.focusClass)},"blur.uniform":function(){o.removeClass(k.focusClass)},"click.uniform touchend.uniform":function(){if(!a(n).attr("checked")){l.removeClass(k.checkedClass)}else{l.addClass(k.checkedClass)}},"mousedown.uniform touchbegin.uniform":function(){o.addClass(k.activeClass)},"mouseup.uniform touchend.uniform":function(){o.removeClass(k.activeClass)},"mouseenter.uniform":function(){o.addClass(k.hoverClass)},"mouseleave.uniform":function(){o.removeClass(k.hoverClass);o.removeClass(k.activeClass)}});if(a(n).attr("checked")){l.addClass(k.checkedClass)}if(a(n).attr("disabled")){o.addClass(k.disabledClass)}b(n)}function c(n){var m=a(n);var o=a("<div />"),l=a("<span />");if(!m.css("display")=="none"&&k.autoHide){o.hide()}o.addClass(k.radioClass);if(k.useID&&n.attr("id")!=""){o.attr("id",k.idPrefix+"-"+n.attr("id"))}a(n).wrap(o);a(n).wrap(l);l=n.parent();o=l.parent();a(n).css("opacity",0).bind({"focus.uniform":function(){o.addClass(k.focusClass)},"blur.uniform":function(){o.removeClass(k.focusClass)},"click.uniform touchend.uniform":function(){if(!a(n).attr("checked")){l.removeClass(k.checkedClass)}else{var p=k.radioClass.split(" ")[0];a("."+p+" span."+k.checkedClass+":has([name='"+a(n).attr("name")+"'])").removeClass(k.checkedClass);l.addClass(k.checkedClass)}},"mousedown.uniform touchend.uniform":function(){if(!a(n).is(":disabled")){o.addClass(k.activeClass)}},"mouseup.uniform touchbegin.uniform":function(){o.removeClass(k.activeClass)},"mouseenter.uniform touchend.uniform":function(){o.addClass(k.hoverClass)},"mouseleave.uniform":function(){o.removeClass(k.hoverClass);o.removeClass(k.activeClass)}});if(a(n).attr("checked")){l.addClass(k.checkedClass)}if(a(n).attr("disabled")){o.addClass(k.disabledClass)}b(n)}function h(q){var o=a(q);var r=a("<div />"),p=a("<span>"+k.fileDefaultText+"</span>"),m=a("<span>"+k.fileBtnText+"</span>");if(!o.css("display")=="none"&&k.autoHide){r.hide()}r.addClass(k.fileClass);p.addClass(k.filenameClass);m.addClass(k.fileBtnClass);if(k.useID&&o.attr("id")!=""){r.attr("id",k.idPrefix+"-"+o.attr("id"))}o.wrap(r);o.after(m);o.after(p);r=o.closest("div");p=o.siblings("."+k.filenameClass);m=o.siblings("."+k.fileBtnClass);if(!o.attr("size")){var l=r.width();o.attr("size",l/10)}var n=function(){var s=o.val();if(s===""){s=k.fileDefaultText}else{s=s.split(/[\/\\]+/);s=s[(s.length-1)]}p.text(s)};n();o.css("opacity",0).bind({"focus.uniform":function(){r.addClass(k.focusClass)},"blur.uniform":function(){r.removeClass(k.focusClass)},"mousedown.uniform":function(){if(!a(q).is(":disabled")){r.addClass(k.activeClass)}},"mouseup.uniform":function(){r.removeClass(k.activeClass)},"mouseenter.uniform":function(){r.addClass(k.hoverClass)},"mouseleave.uniform":function(){r.removeClass(k.hoverClass);r.removeClass(k.activeClass)}});if(a.browser.msie){o.bind("click.uniform.ie7",function(){setTimeout(n,0)})}else{o.bind("change.uniform",n)}if(o.attr("disabled")){r.addClass(k.disabledClass)}a.uniform.noSelect(p);a.uniform.noSelect(m);b(q)}a.uniform.restore=function(l){if(l==undefined){l=a(a.uniform.elements)}a(l).each(function(){if(a(this).is(":checkbox")){a(this).unwrap().unwrap()}else{if(a(this).is("select")){a(this).siblings("span").remove();a(this).unwrap()}else{if(a(this).is(":radio")){a(this).unwrap().unwrap()}else{if(a(this).is(":file")){a(this).siblings("span").remove();a(this).unwrap()}else{if(a(this).is("button, :submit, :reset, a, input[type='button']")){a(this).unwrap().unwrap()}}}}}a(this).unbind(".uniform");a(this).css("opacity","1");var m=a.inArray(a(l),a.uniform.elements);a.uniform.elements.splice(m,1)})};function b(l){l=a(l).get();if(l.length>1){a.each(l,function(m,n){a.uniform.elements.push(n)})}else{a.uniform.elements.push(l)}}a.uniform.noSelect=function(l){function m(){return false}a(l).each(function(){this.onselectstart=this.ondragstart=m;a(this).mousedown(m).css({MozUserSelect:"none"})})};a.uniform.update=function(l){if(l==undefined){l=a(a.uniform.elements)}l=a(l);l.each(function(){var n=a(this);if(n.is("select")){var m=n.siblings("span");var p=n.parent("div");p.removeClass(k.hoverClass+" "+k.focusClass+" "+k.activeClass);m.html(n.find(":selected").html());if(n.is(":disabled")){p.addClass(k.disabledClass)}else{p.removeClass(k.disabledClass)}}else{if(n.is(":checkbox")){var m=n.closest("span");var p=n.closest("div");p.removeClass(k.hoverClass+" "+k.focusClass+" "+k.activeClass);m.removeClass(k.checkedClass);if(n.is(":checked")){m.addClass(k.checkedClass)}if(n.is(":disabled")){p.addClass(k.disabledClass)}else{p.removeClass(k.disabledClass)}}else{if(n.is(":radio")){var m=n.closest("span");var p=n.closest("div");p.removeClass(k.hoverClass+" "+k.focusClass+" "+k.activeClass);m.removeClass(k.checkedClass);if(n.is(":checked")){m.addClass(k.checkedClass)}if(n.is(":disabled")){p.addClass(k.disabledClass)}else{p.removeClass(k.disabledClass)}}else{if(n.is(":file")){var p=n.parent("div");var o=n.siblings(k.filenameClass);btnTag=n.siblings(k.fileBtnClass);p.removeClass(k.hoverClass+" "+k.focusClass+" "+k.activeClass);o.text(n.val());if(n.is(":disabled")){p.addClass(k.disabledClass)}else{p.removeClass(k.disabledClass)}}else{if(n.is(":submit")||n.is(":reset")||n.is("button")||n.is("a")||l.is("input[type=button]")){var p=n.closest("div");p.removeClass(k.hoverClass+" "+k.focusClass+" "+k.activeClass);if(n.is(":disabled")){p.addClass(k.disabledClass)}else{p.removeClass(k.disabledClass)}}}}}}})};return this.each(function(){if(a.support.selectOpacity){var l=a(this);if(l.is("select")){if(l.attr("multiple")!=true){if(l.attr("size")==undefined||l.attr("size")<=1){e(l)}}}else{if(l.is(":checkbox")){f(l)}else{if(l.is(":radio")){c(l)}else{if(l.is(":file")){h(l)}else{if(l.is(":text, :password, input[type='email']")){j(l)}else{if(l.is("textarea")){g(l)}else{if(l.is("a")||l.is(":submit")||l.is(":reset")||l.is("button")||l.is("input[type=button]")){i(l)}}}}}}}}})}})(jQuery);
	
	
</script>