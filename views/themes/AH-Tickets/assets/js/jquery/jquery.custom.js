//-> (jQuery.javascript) TATWERAT FrameWork [ AH Support Tickets ]

function isUrl(url) {
    var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
    return regexp.test(url);
}

function AH_Support_JS() {

    // scrollTop
    this.scrollToTop = function () {
        $(this).hide().removeAttr("href");
        if ($(window).scrollTop() !== "0") {
            $(this).fadeIn("slow");
        }
        var scrollDiv = $(this);
        $(window).scroll(function () {
            if ($(window).scrollTop() === "0") {
                $(scrollDiv).fadeOut("fast");
            } else {
                $(scrollDiv).fadeIn(800);
            }
        });
        $(this).on('click', function () {
            $("html, body").animate({
                scrollTop: 0
            }, "slow");
        });
    };

    // tispy tooltip function
    this.tispy = function () {
        $('.s_title').tipsy({gravity: 's', fade: false});
        $('.n_title').tipsy({gravity: 'n', fade: false});
        $('.e_title').tipsy({gravity: 'e', fade: false});
        $('.o_title').tipsy({gravity: 'o', fade: false});
    };

    // show wrapper
    this.showWrapper = function () {
        $('#Wrapper').css({"visibility": "visible"}).animate({opacity: "1"}, 500);
    };

    // costum jQuery elment
    this.custom = function () {

        // chose color
        $('.custom-select').fancySelect(); // custom select
        $('[data-toggle="tooltip"]').tooltip(); // tooltip

        // checkbox toggle
        $('label.toggle.custom').on('click', function () {
            if ($('input:hidden', this).val() === 'off' || $('input:hidden', this).val() === '') {
                $('input:hidden', this).val('on');
            } else {
                $('input:hidden', this).val('off');
            }
        });

        // tickets table
        $('.my-tickets.users .table').dataTable({
            iDisplayLength: 10,
            orderFixed: [[0, 'desc']],
            language: {
                url: $('body').attr('data-url') + '/languages/tables/table-' + $('html').attr('lang') + '.json'
            }
        });
		$('.my-sms .table').dataTable({
            iDisplayLength: 10,
            orderFixed: [[0, 'desc']],
            language: {
                url: $('body').attr('data-url') + '/languages/tables/table-' + $('html').attr('lang') + '.json'
            }
        });
        $('.my-tickets.admin .table').dataTable({
            iDisplayLength: 10,
            orderFixed: [[0, 'desc']],
            language: {
                url: $('body').attr('data-url') + '/languages/tables/table-' + $('html').attr('lang') + '.json'
            }
        });

        $('.my-departments .table, .my-customers .table').dataTable({
            "iDisplayLength": 10,
            language: {
                url: $('body').attr('data-url') + '/languages/tables/table-' + $('html').attr('lang') + '.json'
            }
        });

        // submiting buttons
        $('.modal form button[type="submit"]').on('click', function () {
            var ua = navigator.userAgent;
            if (/chrome/i.test(ua)) {
                $(this).parents('form').submit();
            }
        });

        // tinymce textarea
        var tiny_direction = 'ltr';
        if ($('html').attr('lang') == 'ar' || $('html').attr('lang') == 'fa') {
            tiny_direction = 'rtl';
        }
        tinyMCE.init({
            selector: "textarea.tinymce",
			language: "fa_IR",
			content_css: $("#siteURL").attr("href")+"/views/themes/AH-Tickets/assets/js/tinymce/skins/lightgray/mycontent.css",
            min_height: 250,
            plugins: [
                "advlist autolink lists link image charmap print preview anchor",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "template paste textcolor colorpicker textpattern imagetools"

            ],
            menubar: false,
            toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | forecolor backcolor",
            setup: function (editor) {
                editor.on('change', function () {
                    tinyMCE.triggerSave();
                });
            },
            language: $('html').attr('lang'),
            directionality: tiny_direction
        });

        tinyMCE.init({
            selector: "textarea.options_textarea",
			language: "fa_IR",
			content_css: $("#siteURL").attr("href")+"/views/themes/AH-Tickets/assets/js/tinymce/skins/lightgray/mycontent.css",
            min_height: 350,
            plugins: [
                "advlist autolink lists link image charmap print preview anchor",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "template paste textcolor colorpicker textpattern imagetools"

            ],
            menubar: false,
            toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | forecolor backcolor",
            setup: function (editor) {
                editor.on('change', function () {
                    tinyMCE.triggerSave();
                });
            },
            directionality: tiny_direction
        });

        // ajax user data json
        $('#tickets').on('click', '.user_data', function () {
            var url = $(this).data('ajaxurl');
            $.getJSON(url, function (user) {
                $('#User-Data .table .id').find('p').text(user.id);
                $('#User-Data .table .photo').find('img').attr('src', user.photo);
                $('#User-Data .table .name').find('p').text(user.name);
                $('#User-Data .table .email').find('p').text(user.email);
				$('#User-Data .table .phone').find('p').html(user.phone);
                $('#User-Data .table .gender').find('p').text(user.gender);
                $('#User-Data .table .country').find('p').text(user.country);
                $('#User-Data .table .bio').find('p').html(user.bio);
            });
            $('#User-Data .table').hide();
            $('#User-Data .ajax-loader').show().delay(1000).fadeOut(function () {
                $('#User-Data .table').delay(10).fadeIn(300);
            });
        });

        // ajax create new tickets
        $('form#create-ticket').on('submit', function (e) {
            e.preventDefault();
            tinymce.triggerSave();
            var form = $(this);
            var content = form.find('#content').val();
            var progress = $('.over_load .progress');
            var bar = $('.over_load .bar');
            var percent = $('.over_load .percent');
            var percentVal = '0%';
            if (form.find('input:file').val()) {
                var types = form.find('input#attachment').data('types');
                var types_array = types.split(',');
                var file_type = form.find('input:file').val();
                var file_size = (form.find('input:file')[0].files[0].size / 1024 / 1024);
                var max_size = form.find('input#max_attach').val();
                file_size = (Math.round(file_size * 100) / 100);
                console.log(types_array);
                console.log('file_type = ' + file_type.substring(file_type.lastIndexOf('.') + 1).toLowerCase());
                if ($.inArray(file_type.substring(file_type.lastIndexOf('.') + 1).toLowerCase(), types_array) === -1) {
                    alert('invalid file type ' + file_type);
                    return;
                } else if (max_size < file_size) {
                    alert('file size bigger than ' + max_size + ' MP');
                    return;
                } else {
                    $('.over_load').show();
                    progress.show();
                    bar.width(percentVal);
                    percent.html(percentVal);
                }
            }
            //tinyMCE.triggerSave();
            form.ajaxSubmit({
                url: form.attr('action'),
                data: form.serialize(),
                beforeSubmit: function () {
                    if (form.find('input#subject').val() == '') {
                        form.find('input#subject').focus();
                        progress.hide();
                        return false;
                    } else if (content == "" || content == null) {
                        alert(form.find('#content').attr('data-error'));
                        progress.hide();
                        return false;
                    } else {
                        form.find('.btn.btn-success').attr('disabled', 'disabled').find('>em').css({"padding": "0 5px", "display": "inline-block"});
                    }
                },
                uploadProgress: function (event, position, total, percentComplete) {
                    var percentVal = percentComplete + '%';
                    bar.width(percentVal);
                    percent.html('wait for uploading ' + percentVal);
                },
                success: function (data) {
                    if (data) {
                        form.find('.show-alerts').html(data);
						form.find('.btn.btn-success').attr('disabled', 'disabled').find('>em').css({"padding": "0 5px", "display": "none"});
						
                    } else {
                        bar.width(0);
                        percent.html('0%').parent().css("visibility", "hidden");
                        $('.over_load').delay(1500).fadeOut(500);
                        var reply_id = form.data('reply');
                        if (reply_id) {
                            setTimeout(function () {
                                window.location.hash = reply_id;
                                window.location.reload();
                            }, 100);
                        } else {
                            setTimeout(function () {
                                window.location.href = form.find('input#tickets_redirect').val();
                            }, 100);
                        }
                    }
                }
                /*complete: function(xhr) {
                 status.html(xhr.responseText);
                 }*/

            });
            return false;
        });

        // department modal (edit,add)
        $('.modal').on('shown.bs.modal', function () {
            $('form input[type="text"]:first', this).focus();
        });
        $('#departments').on('click', '.btn.btn-d-edit', function () {
            $('#add-department form input#department_add').val('edit');
            $('#add-department form input#d_name').val($(this).data('name'));
            $('#add-department form input#d_id').val($(this).data('id'));
            $('#add-department .modal-title').text($(this).data('title-lang'));
        });

        $('#departments').on('click', '.btn.btn-d-add', function () {
            $('#add-department form input#department_add').val('new');
            $('#add-department form input#d_name, #add-department form input#d_id').val('');
            $('#add-department .modal-title').text($(this).data('title-lang'));
        });

        $('#add-department form').each(function () {
            var form = $(this);
            form.ajaxForm({
                beforeSubmit: function () {
                    form.find('button[type="submit"]').attr('disabled', 'disabled').find('>em').css({"padding": "0 5px", "display": "inline-block"});
                },
                success: function (data) {
                    if (data) {
                        form.find('.show-alerts').html(data);
                        form.find('button[type="submit"]').removeAttr('disabled').find('>em').css({"padding": "0", "display": "none"});
                        $('.modal-open .modal').animate({
                            scrollTop: 0
                        }, 500);
                    } else {
                        window.location.href = form.data('href');
                        setTimeout(function () {
                            window.location.reload();
                        }, 500);
                    }
                }
            });
        });

        // department delete
        $('#departments').on('click', '.btn.btn-d-delete', function () {
            var msg = confirm($(this).data('alert-lang'));
            var id = $(this).data('id');
            if (msg === true) {
                $(this).parent().parent().fadeOut(500);
                $.post('', {department_delete: 'yes', d_id: id}, function () {
                    console.log('department-[' + id + '] deleted');
                });
            }
        });

        // customers modal (edit,add)
        $('#customers').on('click', '.btn.btn-u-add', function () {
            $('#add-user form input#user_add').val('new');
            $('#add-user form input#u_id, #add-user form input#name, #add-user form input#email, #add-user form input#password, #add-user form textarea#bio, #add-user form input#phone').val('');
            $('#add-user form select#country option, #add-user form select#gender option, #add-user form select#activate option').removeAttr('selected').change();
            $('#add-user .modal-title').text($(this).data('title-lang'));
            $('#add-user form img.modal_photo').attr('src', '');
            $('#add-user form input#password').next('p').remove();
			$('#add-user form input#phone').next('p').remove();
        });

        $('#customers').on('click', '.btn.btn-u-edit', function () {
            $('#add-user form input#user_add').val('edit');
            $('#add-user form input#u_id').val($(this).data('id'));
            $('#add-user form input#name').val($(this).data('name'));
            $('#add-user form img.modal_photo').attr('src', $(this).data('photo'));
            $('#add-user form input#email').val($(this).data('email'));
            $('#add-user form input#password').val($(this).data('password'));
            $('#add-user form textarea#bio').val($(this).data('bio'));
            $('#add-user form select#country option[value="' + $(this).data('country') + '"]').attr('selected', 'selected').change();
            $('#add-user form select#gender option[value="' + $(this).data('gender') + '"]').attr('selected', 'selected').change();
            $('#add-user form select#activate option[value="' + $(this).data('activate') + '"]').attr('selected', 'selected').change();
            $('#add-user .modal-title').text($(this).data('title-lang'));
            $('#add-user form input#password').next('p').remove();
            $('#add-user form input#password').after('<p class="text-warning">' + $(this).data('password-lang') + '</p>');
			$('#add-user form input#phone').next('p').remove();
			$('#add-user form input#phone').after('<p class="text-warning">' + $(this).data('phone-lang') + '</p>');
        });

        $('#add-user form').each(function () {
            var form = $(this);
            form.ajaxForm({
                beforeSubmit: function () {
                    form.find('button[type="submit"]').attr('disabled', 'disabled').find('>em').css({"padding": "0 5px", "display": "inline-block"});
                },
                success: function (data) {
                    if (data) {
                        form.find('.show-alerts').html(data);
                        form.find('button[type="submit"]').removeAttr('disabled').find('>em').css({"padding": "0", "display": "none"});
                        $('.modal-open .modal').animate({
                            scrollTop: 0
                        }, 500);
                    } else {
                        window.location.href = form.data('href');
                        setTimeout(function () {
                            window.location.reload();
                        }, 500);
                    }
                }
            });
        });

        // stuff modal (edit,add)
        $('#stuff').on('click', '.btn.btn-stuff-add', function () {
            $('#add-stuff form input#stuff_add').val('new');
            $('#add-stuff form input#u_id, #add-stuff form input#name, #add-stuff form input#email, #add-stuff form input#password, #add-stuff form textarea#bio, #add-user form input#phone').val('');
            $('#add-stuff form select#country option, #add-stuff form select#gender option, #add-stuff form select#activate option').removeAttr('selected').change();
            $('#add-stuff .modal-title').text($(this).data('title-lang'));
            $('#add-stuff form input#password').next('p').remove();
			$('#add-stuff form input#phone').next('p').remove();
            $('#add-stuff form img.modal_photo').attr('src', '');
            $('#add-stuff form input:checkbox').prop('checked', false);
            $('#add-stuff form input:checkbox:first').prop('checked', true);
        });

        $('#stuff').on('click', '.btn.btn-stuff-edit', function () {
            $('#add-stuff form input#stuff_add').val('edit');
            $('#add-stuff form input#u_id').val($(this).data('id'));
            $('#add-stuff form img.modal_photo').attr('src', $(this).data('photo'));
            $('#add-stuff form input#name').val($(this).data('name'));
            $('#add-stuff form input#email').val($(this).data('email'));
            $('#add-stuff form input#password').val($(this).data('password'));
            $('#add-stuff form textarea#bio').val($(this).data('bio'));
            $('#add-stuff form select#country option[value="' + $(this).data('country') + '"]').attr('selected', 'selected').change();
            $('#add-stuff form select#gender option[value="' + $(this).data('gender') + '"]').attr('selected', 'selected').change();
            $('#add-stuff form select#activate option[value="' + $(this).data('activate') + '"]').attr('selected', 'selected').change();
            $('#add-stuff form select#edit_customers option[value="' + $(this).data('addedits') + '"]').prop('selected', 'selected').change();
            var departments = $(this).data('departments');
            var d_array = departments.split(',');
            $('#add-stuff form input:checkbox').prop('checked', false);
            $.each(d_array, function (i, value) {
                $('#add-stuff form input:checkbox[value="' + value + '"]').prop('checked', true).change();
            });
            $('#add-stuff .modal-title').text($(this).data('title-lang'));
            $('#add-stuff form input#password').next('p').remove();
            $('#add-stuff form input#password').after('<p class="text-warning">' + $(this).data('password-lang') + '</p>');
			$('#add-stuff form input#phone').next('p').remove();
			$('#add-stuff form input#phone').after('<p class="text-warning">' + $(this).data('phone-lang') + '</p>');
        });

        $('#add-stuff form').each(function () {
            var form = $(this);
            form.ajaxForm({
                beforeSubmit: function () {
                    form.find('button[type="submit"]').attr('disabled', 'disabled').find('>em').css({"padding": "0 5px", "display": "inline-block"});
                },
                success: function (data) {
                    if (data) {
                        form.find('.show-alerts').html(data);
                        form.find('button[type="submit"]').removeAttr('disabled').find('>em').css({"padding": "0", "display": "none"});
                        $('.modal-open .modal').animate({
                            scrollTop: 0
                        }, 500);
                    } else {
                        window.location.href = form.data('href');
                        setTimeout(function () {
                            window.location.reload();
                        }, 500);
                    }
                }
            });
        });

        // upload photo
        $('#add-stuff input[name="photo"], #edit-profile input[name="photo"], #add-user input[name="photo"]').on('change', function () {
            var photo = (window.URL ? URL : webkitURL).createObjectURL(this.files[0]);
            $(this).prev().prev('img.modal_photo').attr('src', photo);
        });

        // user delete
        $('.ah-panel-body').on('click', '.btn.btn-u-delete', function () {
            var msg = confirm($(this).data('alert-lang'));
            var id = $(this).data('id');
            if (msg === true) {
                $(this).parent().parent().fadeOut(500);
                $.post('', {user_delete: 'yes', u_id: id}, function () {
                    console.log('account-[' + id + '] deleted');
                });
            }
        });

        // update profile modal
        $('#edit-profile form').each(function () {
            var form = $(this);
            form.ajaxForm({
                beforeSubmit: function () {
                    form.find('button[type="submit"]').attr('disabled', 'disabled').find('>em').css({"padding": "0 5px", "display": "inline-block"});
                },
                success: function (data) {
                    if (data) {
                        form.find('.show-alerts').html(data);
                        form.find('button[type="submit"]').removeAttr('disabled').find('>em').css({"padding": "0", "display": "none"});
                        $('.modal-open .modal').animate({
                            scrollTop: 0
                        }, 500);
                    } else {
                        window.location.href = form.data('href');
                        setTimeout(function () {
                            window.location.reload();
                        }, 500);
                    }
                }
            });
        });

        // add knowledge
        $('#add-knowledge form').each(function () {
            var form = $(this);
            form.ajaxForm({
                beforeSubmit: function () {
                    form.find('button[type="submit"]').attr('disabled', 'disabled').find('>em').css({"padding": "0 5px", "display": "inline-block"});
                },
                success: function (data) {
                    if (data) {
                        form.find('.show-alerts').html(data);
                        form.find('button[type="submit"]').removeAttr('disabled').find('>em').css({"padding": "0", "display": "none"});
                        $('.modal-open .modal').animate({
                            scrollTop: 0
                        }, 500);
                    } else {
                        window.location.href = form.data('href');
                        setTimeout(function () {
                            window.location.reload();
                        }, 500);
                    }
                }
            });
        });

        $('#knowledge').on('click', '.btn.btn-kn-add', function () {
            $('#add-knowledge form .show-alerts').html('');
            $('#add-knowledge form input#knowledge_add').val('new');
            $('#add-knowledge form input#title, #add-knowledge form input#knowledge_id').val('');
            $('#add-department .modal-title').text($(this).data('title-lang'));
            $('#add-knowledge form select#allow_visitors option:first').attr('selected', 'selected').change();
            $('#add-knowledge form select#department option:first').attr('selected', 'selected').change();
            tinymce.get("content").setContent('');
        });

        // edit knowledge
        $('#knowledge').on('click', '.btn.btn-knowledge-edit', function () {
            $('#add-knowledge form .show-alerts').html('');
            $('#add-knowledge form input#knowledge_add').val('edit');
            $('#add-knowledge form input#knowledge_id').val($(this).data('id'));
            $('#add-knowledge form input#title').val($(this).data('title'));
            //tinyMCE.get('#add-knowledge form input#content').setContent($(this).data('content'));
            tinymce.get("content").setContent('');
            tinymce.get("content").execCommand('mceInsertContent', false, $(this).data('content'));
            $('#add-knowledge form select#allow_visitors option[value="' + $(this).data('public') + '"]').attr('selected', 'selected').change();
            $('#add-knowledge form select#department option[value="' + $(this).data('department') + '"]').attr('selected', 'selected').change();
            $('#add-knowledge .modal-title').text($(this).data('title-lang'));
        });

        // department delete
        $('#knowledge').on('click', '.btn.btn-kn-delete', function () {
            var msg = confirm($(this).data('alert-lang'));
            var id = $(this).data('id');
            if (msg === true) {
                $(this).parent().parent().fadeOut(500);
                $.post('', {post_delete: 'yes', post_id: id}, function () {
                    console.log('post-[' + id + '] deleted');
                });
            }
        });


        // rate-rang
        $('.rate .rate-rang').each(function () {
            var num = $(this).data('value');
            for (var x = 1; x <= num; x++) {
                $('i:nth-child(' + x + ')', this).addClass('active');
            }
        });

        // reply rate
        $('.reply .rate').each(function () {
            var div = $(this);
            $('.rating', this).find('input:radio').on('click', function () {
                var ID = $(this).parent().parent().parent().parent().parent().parent().attr('id').replace(/\D/g, '');
                var value = $(this).val();
                /*div.find('.form-group').remove();
                 div.append('<div class="rate-rang" data-value="' + value + '"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>');
                 for (var x = 1; x <= value; x++) {
                 div.find('.rate-rang i:nth-child(' + x + ')', this).addClass('active');
                 }*/
                $.post("", {add_rate: 'true', rate_value: value, reply_id: ID}, function () {
                    console.log('done rating');
                    window.location.reload();
                });
            });
        });

        // close ticket
        $('.colose-ticket').on('click', function () {
            var id = $(this).data('id');
            var msg = confirm($(this).data('alert-lang'));
            if (msg === true) {
                $.post('', {close_ticket: 'yes', t_id: id}, function () {
                    console.log('ticket-[' + id + '] closed');
                    window.location.reload();
                });
            }
        });

        // delete reply
        $('.reply .delete-reply').on('click', function () {
            var id = $(this).data('id');
            var p_id = $(this).data('parentid');
            var msg = confirm($(this).data('alert-lang'));
            if (msg === true) {
                $(this).parent().parent().parent().fadeOut(500);
                $.post('', {delete_my_reply: 'yes', reply_id: id, parent_id: p_id}, function () {
                    console.log('reply-[' + id + '] deleted');
                });
            }
        });

        /*Dasboard*/
        $(".ah_rang input.status").knob({'stopper': true});

        // lang set
        $('select#change_lang').on('change', function () {
            var value = $(this).val();
            if (value) {
                $.post('', {set_lang: 'yes', lang_key: value}, function () {
                    window.location.reload();
                });
            }
        });

        // user-tickets
        $('body').on('click', 'a.btn-u-tickets', function () {
            var btn = $(this);
            $('#user-tickets table tbody').html('');
            $.post($('#user-tickets').attr('data-ajaxurl'), {user_tikects: 'true', user_id: btn.attr('data-id')}, function (data) {
                $('#user-tickets .modal-dialog').html(data);
            });
            return true;
        });
		$('body').on('click', 'a.btn-s-tickets', function () {
            var btn = $(this);
            $('#staff-tickets table tbody').html('');
            $.post($('#staff-tickets').attr('data-ajaxurl'), {user_tikects: 'true', user_id: btn.attr('data-id')}, function (data) {
                $('#staff-tickets .modal-dialog').html(data);
            });
            return true;
        });

        // tickets filter
        $('#tickets,.my-tickets.users').each(function () {
            var table = $(this);
            $.get(table.attr('data-ajaxurl'), function (data) {
                table.find('.dataTables_length').append(data);
            });
            table.on('change', '.dataTables_length .tickets-filter', function () {
                table.find('.dataTables_filter input[type="search"]').val($(this).val()).keyup();
            });
        });

        // change department
        $('#change-department form').each(function () {
            var form = $(this);
            form.ajaxForm({
                beforeSubmit: function () {
                    form.find('button[type="submit"]').attr('disabled', 'disabled').find('>em').css({"padding": "0 5px", "display": "inline-block"});
                },
                success: function (data) {
                    if (data) {
                        alert('Error : ' + data);
                        form.find('button[type="submit"]').removeAttr('disabled').find('>em').css({"padding": "0", "display": "none"});
                    } else {
                        window.location.href = form.attr('data-href');
                        setTimeout(function () {
                            window.location.reload();
                        }, 5000);
                    }
                }
            });
        });

        // update options
        $('#options-form').each(function () {
            var form = $(this);
            form.ajaxForm({
                beforeSubmit: function () {
                    form.find('button[type="submit"]').attr('disabled', 'disabled').find('>em').css({"padding": "0 5px", "display": "inline-block"});
                },
                success: function (data) {
                    if (data) {
                        form.find('.show-alerts').html(data);
                        form.find('button[type="submit"]').removeAttr('disabled').find('>em').css({"padding": "0", "display": "none"});
                    } else {
                        setTimeout(function () {
                            window.location.reload();
                        }, 500);
                    }
                }
            });
        });

        // minicolors
        $('input.minicolors').minicolors();

        // upload button
        $('.input-upload .upload-btn').on('click', function () {
            var ID = $(this).attr('data-target');
            $(ID).attr('data-button', '#' + $(this).parent().find('input').attr('id'));
        });
        $('.input-upload input[type="text"]').on('focus', function () {
            $(this).next('img').attr('src', $(this).val());
        });

        // upload modal
        $('#Upload-Modal').each(function () {
            var modal = $(this);
            var form = $('form', this);
            var alert = $('.show-alerts', this);
            var progress = $('.progress', this);
            var bar = $('.progress .bar', this);
            var percent = $('.progress .percent', this);
            $('#file-name', this).on('change', function () {
                var photo = (window.URL ? URL : webkitURL).createObjectURL(this.files[0]);
                var label = $(this).parent();
                var label_title = label.attr('data-title');
                label.attr('data-title', $(this).val());
                form.ajaxSubmit({
                    url: form.attr('action'),
                    data: form.serialize(),
                    beforeSubmit: function () {
                        progress.show();
                    },
                    uploadProgress: function (event, position, total, percentComplete) {
                        var percentVal = percentComplete + '%';
                        bar.width(percentVal);
                        percent.html('wait for uploading ' + percentVal);
                    },
                    success: function (data) {
                        bar.width(0);
                        percent.html('0%').parent().css("visibility", "hidden");
                        progress.fadeOut(500);
                        if (isUrl(data)) {
                            alert.html('');
                            label.attr('data-title', label_title);
                            modal.modal('hide');
                            $(modal.attr('data-button')).val(data).focus();
                        } else {
                            alert.html(data);
                            label.attr('data-title', label_title);
                        }
                    }
                });
            });
        });

        // page tabe
        $('.add_hash a').on('click', function () {
            window.location.hash = $(this).attr('href');
        });

        // breadcrumb title
        $('.main-search.single span.breadcrumb_title').text($('.main-body .panel:first > .panel-heading > h3').text());

        // add like
        $('.add_like .btn').on('click', function () {
            var count = $(this).parents('.post_single').find('em.like_count').text();
            var type = $(this).data('type');
            var id = $(this).data('id');
            count = parseInt(count);
            if (type == '+1') {
                count++;
                if (count >= 0) {
                    $(this).parents('.post_single').find('em.like_count').parent().removeClass('error');
                }
            } else if (type == '-1') {
                count--;
                if (count < 0) {
                    $(this).parents('.post_single').find('em.like_count').parent().addClass('error');
                }
            }
            $(this).parents('.post_single').find('em.like_count').text(count);
            $(this).parent().find('.btn').attr('disabled', 'disabled');
            $.post('', {post_like: 'true', post_id: id, like_type: type}, function () {
                console.log('add_like');
            });
        });

        // subscribe form
        $('form#subscribe').each(function () {
            var form = $(this);
            form.ajaxForm({
                beforeSubmit: function () {
                    form.find('button[type="submit"]').attr('disabled', 'disabled').find('>em').css({"padding": "0 5px", "display": "inline-block"});
                },
                success: function (data) {
                    if (data) {
                        form.find('.show-alerts').html(data);
                        form.find('button[type="submit"]').removeAttr('disabled').find('>em').css({"padding": "0", "display": "none"});
                        form.find('input[type="email"]').val('');
                    }
                }
            });
        });

        // subscribe form
        $('form#contactForm').each(function () {
            var form = $(this);
            form.ajaxForm({
                beforeSubmit: function () {
                    form.find('button[type="submit"]').attr('disabled', 'disabled').find('>em').css({"padding": "0 5px", "display": "inline-block"});
                },
                success: function (data) {
                    if (data) {
                        form.find('.show-alerts').html(data);
                        form.find('button[type="submit"]').removeAttr('disabled').find('>em').css({"padding": "0", "display": "none"});
                        form.find('input,textarea').val('');
                    }
                }
            });
        });

        // search from
        /*$('.main-search form').each(function () {
         var obj_data;
         var form = $(this);
         $('#question', this).keypress(function () {
         $.post(form.attr('data-ajax'), {get_seach: 'true', query: $(this).val()}, function (data) {
         console.log(data);
         //obj_data.push(data);
         console.log(obj_data);
         });
         obj_data = ["eee", "tttt"];
         $('#question', this).typeahead({
         local: obj_data //
         });
         });
         });*/
        $('.main-search form').on('submit', function () {
            var url = $(this).attr('action');
            var query = $('input#question', this).val();
            window.location.href = url + query.replace(" ", "+");
            return false;
        });

        /*$('button.btn.run_new_updates#v_2_2').on('click', function () {
            var btn = $(this);
            var url = $(this).data('ajax');
            $.ajax({
                url: url,
                data: {update_2_2: true},
                type: 'POST',
                beforeSend: function () {
                    btn.attr('disabled', 'disabled').find('>em').css({"padding": "0 5px", "display": "inline-block"});
                },
                success: function (data) {
                    if (data) {
                        setTimeout(function () {
                            window.location.reload();
                        }, 1500);
                    }
                }
            });
        });*/
		$('button.btn.run_new_updates').on('click', function () {
            var btn = $(this);
            var url = $(this).data('ajax');
            $.ajax({
                url: url,
                data: {version:$(this).attr('id')},
                type: 'POST',
                beforeSend: function () {
                    btn.attr('disabled', 'disabled').find('>em').css({"padding": "0 5px", "display": "inline-block"});
                },
                success: function (data) {
                    if (data) {
                        setTimeout(function () {
                            window.location.reload();
                        }, 1500);
                    }
                }
            });
        });
    };
}
// on window load run functions
$(document).ready(function () {
//added by Mahyar Ansary
$('#regPassword').strength({
            strengthClass: 'form-control input-lg input-padding strength',
            strengthMeterClass: 'strength_meter',
            strengthButtonClass: 'button_strength',
            strengthButtonText: 'نمایش کلمه عبور',
            strengthButtonTextToggle: 'پنهان سازی'
        });
    var runJS = new AH_Support_JS(); // function object

    runJS.tispy();

    function scrollBanner(config, topVal) {
        config.banner.css({
            'background-position': 'center ' + (-topVal / 2) + "px"});
    }
    
     $('.menu-btn').on('click',function(){
       $('#menu-sm-links').toggleClass('hidden'); 
     });

    // fixed menu
    $(this).scroll(function () {
        //$('.fixed-menu').fixedMenu($(this));
        var windowTop = $(this).scrollTop();
        if ($(this).width() > 1000) {
            scrollBanner({
                banner: $('#_Header')
            }, windowTop);
        }
    });

    // when loader fadeOut
    $('div.loading_window').delay(100).fadeOut(function () {
        runJS.showWrapper();
        runJS.custom();
        var hash = window.location.hash;
        if (hash) {
            var target = $(hash);
            if (hash == '#dashboard') {
                $('a[href="' + hash + '"]').click();
            } else if (hash == '#tickets') {
                $('a[href="' + hash + '"]').click();
            } else if (hash == '#departments') {
                $('a[href="' + hash + '"]').click();
            } else if (hash == '#customers') {
                $('a[href="' + hash + '"]').click();
            } else if (hash == '#stuff') {
                $('a[href="' + hash + '"]').click();
            } else if (hash == '#knowledge') {
                $('a[href="' + hash + '"]').click();
            } else if (hash == '#setting') {
                $('a[href="' + hash + '"]').click();
            }
            else if (hash == '#sms') {
                $('a[href="' + hash + '"]').click();
            }
            $('html,body').animate({
                scrollTop: target.offset().top - 14
            }, 1000);
            //window.location.hash = '';
        }
    });

//    $(this).on('focusin', function (e) {
//        if ($(event.target).closest(".mce-window").length) {
//            e.stopImmediatePropagation();
//        }
//    });

    $('a.notification ~ ul').each(function () {
        $(this).on('click', 'li', function () {
            var url = $(this).data('href');
            var id = $(this).data('id');
            $.post($('body').data('url') + '/get-ajax/notifications', {read_notification: 'true', n_id: id}, function (data) {
                window.location.href = url;
            });
        });
    });

    // get-ajax/notifications_count

    function get_browser_notifications() {
        $.getJSON($('body').data('url') + '/get-ajax/notifications&browser_notification_list=get', function (data) {
            $.each(data, function (i, item) {
                browser_notifications(
                        item.n_id,
                        item.n_data.photo, $('body').data('site-name'),
                        item.n_data.user_name + ' : ' + item.n_data.text,
                        item.n_data.link
                        );
            });
        });
    }

    function notifications_count() {
        var count = $('a.notification span').text();
        count = parseInt(count);
        $('<audio id="notificationAudio"><source src="' + $('body').data('url') + '/controller/files/ah_notification.ogg" type="audio/ogg"><source src="' + $('body').data('url') + '/controller/files/ah_notification.mp3" type="audio/mpeg"></audio>').appendTo('body');
        $.post($('body').data('url') + '/get-ajax/notifications', {get_notification_count: 'get'}, function (data) {
            if (data >= 1) {
                if (data > count) {
                    $('#notificationAudio')[0].play();
                    get_browser_notifications();
                }
                $('a.notification span').show().text(data);
            } else {
                $('a.notification span').hide().text('0');
            }
        });
    }
    function notifications_list() {
        $.post($('body').data('url') + '/get-ajax/notifications', {get_notification_list: 'get'}, function (data) {
            if (data) {
                $('a.notification').next('ul').html(data);
            }
        });
    }
    if ($('body').data('allow-notifications') == 1) {
        notifications_count();
        notifications_list();
        setInterval(notifications_count, 5000);
        setInterval(notifications_list, 5000);
    }

//    setInterval(function () {
//        $.notifyRequest(function () {
//            // Callback: Trigger notification
//            $.notify("", "Hello", "This is a test");
//        });
//    }, 5000);

    function notifyBrowser(id, icon, title, desc, url) {
        if (Notification.permission !== "granted") {
            Notification.requestPermission();
        } else {
            var notification = new Notification(title, {
                icon: icon,
                body: desc,
            });
            /* Remove the notification from Notification Center when clicked.*/
            notification.onclick = function () {
                window.open(url);
            };
            /* Callback function when the notification is closed. */
            notification.onclose = function () {
                $.post($('body').data('url') + '/get-ajax/notifications', {read_boewser_notification: 'post', n_id: id}, function (data) {
                    console.log('Notification closed');
                });
            };
        }
    }

    function browser_notifications(id, icon, title, desc, url) {
        document.addEventListener('DOMContentLoaded', function ()
        {

            if (Notification.permission !== "granted")
            {
                Notification.requestPermission();
            }

        });
        notifyBrowser(id, icon, title, desc, url);
    }

});
$(document).on('focusin', function (e) {
    if ($(e.target).closest(".mce-window").length || $(e.target).closest(".moxman-window").length) {
        e.stopImmediatePropagation();
    }
});
/*---------- TATWERAT FrameWork ---------*/