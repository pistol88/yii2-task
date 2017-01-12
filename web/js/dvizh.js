dvizh_cms_host = '/task/tools';

function parents_li_delete(answer, link) {
    if(answer == 'ok') {
        $(link).parents('li').hide('slow');
    }
    else {
        alert('Error');
    }
}

function parent_li_delete(answer, link) {
    if(answer == 'ok') {
        $(link).parent('li').hide('slow');
    }
    else {
        alert('Error');
    }
}

function parents_tr_delete(answer, link) {
    if(answer == 'ok') {
        $(link).parents('tr').hide('slow');
    }
    else {
        alert('Error');
    }
}

var dvizh_engine = {
    init: function() {
        this.rework_interface();
        $(document).on('click', '.get_rework_comments', this.get_rework_comments);
        $(document).on('click', '.leave_unpayment_reworks', this.leave_unpayment_reworks);
        $(document).on('click', '.reworks_take_list', this.reworks_take_list);
        $(document).on('submit', '.rework_comment_form', this.send_rework_comment);
        $(document).on('submit', '.ajax_kudir_add', this.send_kudir_add);
        
        $(document).on('keyup', '.ajax_rework_price', this.change_rework_price);
        $(document).on('change', '.ajax_rework_payment', this.change_rework_payment);
        $(document).on('change', '.ajax_rework_payment_perfomer', this.change_rework_payment_perfomer);
        $(document).on('change', '.ajax_rework_status', this.change_rework_status);
        $(document).on('change', '.ajax_rework_perfomer', this.change_rework_perfomer);
        $(document).on('change', '.reworks_filter', this.reworks_filter);
        $(document).on('change', '.reworks_filter_members', this.reworks_filter_member);
        
        $(document).on('submit', '#reworks .add_rework', this.add_rework);
        
        $(document).on('click', '.scroll_bottom', this.scroll_bottom);

        $(document).on('submit', '.ajax_edit_comment', this.edit_comment);
        $(document).on('click', '.comments_list .ajax_edit', this.show_edit_comment);

        $(document).on('change', '#do_notification', this.do_notification);
        $(document).on('change', '#show_tasks_by_user_status', this.show_tasks_by_user_status);
    
        $(document).on('change', '.kudir_filter', this.kudir_filter);
        $(document).on('blur', '.users_select_filter, .projects_select_filter', function() { $(this).siblings('select').change(); });
        $(document).on('click', '.kudir_h_click', this.kudir_click_show);
    
        $(document).on('click', '.upload_link', this.upload_link);

        $(document).on('submit', '#add_comments form', this.add_comment);

        $(document).on('submit', '.nh_add_fine', this.add_fine);
        
        $(document).on('click', '.workday_start', this.workday_start);
        $(document).on('click', '.workday_stop', this.workday_stop);
        $(document).on('submit', '.workday_stop_report', this.send_workday_report);
    
        $(document).on('change keydown', '.users_checkboxes_filter', this.choise_user_checkbox);
        $(document).on('change keydown', '.users_select_filter', this.choise_user_select);
        $(document).on('change keydown', '.projects_select_filter', this.choise_project);
    
        $(document).on('change', '.ajax_task_status', this.change_task_status);
        $(document).on('change', '.ajax_task_payment', this.change_task_payment);
        $(document).on('change', '.ajax_user_status', this.change_task_user_status);
        $(document).on('change', '.ajax_user_price', this.change_task_user_price);
        $(document).on('change', '.ajax_user_deadline', this.change_task_user_deadline);
        $(document).on('change', '.ajax_user_payment', this.change_task_user_payment);
        $(document).on('change', '.ajax_task_price', this.change_task_price);
        $(document).on('change', '.ajax_task_deadline', this.change_task_deadline);

        $(document).on('click', '.ajax_delete', this.ajax_delete);
        $(document).on('click', '.delete', this.delete_object);
        $('.logout').click(this.logout);
        $('.course').on('change', function() {
            $('.course').css('opacity', '0.3');
            $.post(
                dvizh_cms_host+'ajax/set_course',
                {course: $(this).val()},
                function(answer) {
                    $('.course').css('opacity', '1');
                    document.location.reload();
                }
            );
        });
    },
    reworks_mass_interface: function() {
        var price_z = 0;
        var price_i = 0;
        var checked_numbers = new Array;
        $('.reworks_mass_userlist').html('');
        $.each($('.reworks_list .rework_check:checked'), function() {
            checked_numbers.push($(this).data('number'));
            var rework = $(this).parents('.rework_status_all');
            var perfomer_id = $(rework).data('perfomer');
            var ob_price = parseInt($(rework).data('ob-price'));
            var price = parseInt($(rework).data('price'));
            
            var perfomer_username = $(rework).data('perfomer-username');
            if(!$('.reworks_mass_userlist'+perfomer_id).length) {
                $('.reworks_mass_userlist').append('<li class="reworks_mass_userlist'+perfomer_id+'">'+perfomer_username+' '+dvizh_currency+'<span>'+price+'</span></li>');
            }
            else {
                $('.reworks_mass_userlist'+perfomer_id+'>span').html(price+parseInt($('.reworks_mass_userlist'+perfomer_id+'>span').html()));
            }
            
            if($(rework).data('ob-price')) {
                price_z += ob_price;
                price_i += price;
                $('.reworks_mass_price span.z').html(price_z);
                $('.reworks_mass_price span.i').html(price_i);
            }
        });
        $('.reworks_mass_checked_ids').html('Reworks: '+checked_numbers.join(', '));
    },
    rework_interface: function() {
        $(document).mouseup(function (e) {
            var container = $(".full_rework");
            if (container.has(e.target).length === 0){
                $('.full_rework').remove();
            }
        });
        $(document).on('click', '.reworks_list > li.rework_status_all', function(e) {
            if(!$(e.target).val() && !$(e.target).hasClass('ajax_rework_status') && $(this).find('.full_rework').length == 0) { 
                $('.full_rework').remove();
                $(this).after('<li class="full_rework">'+$(this).html()+'</li>');
                $('.full_rework').find('input[type=radio]').each(function() {
                    $(this).attr('name', $(this).attr('name')+'2');
                });
                if($('.full_rework .rework_comments').is(':hidden')) {
                    $('.full_rework .get_rework_comments').click();
                }
            }
        });
        
        $('.reworks_list .rework_check_all').on('click', function() {
            if($(this).prop('checked')) {
                $('.reworks_mass').show();
                dvizh_engine.reworks_mass_interface();
            }
            else {
                $('.reworks_mass').hide();
            }
            $(this).parents('.reworks_list').find('.rework_check').prop('checked', $(this).prop('checked'));
        });
        
        $('.rework_check').on('click', function() {
            if($('.reworks_list .rework_check:checked').length) {
                $('.reworks_mass').show();
                dvizh_engine.reworks_mass_interface();
            }
            else {
                $('.reworks_mass').hide();
            }
        });
        
        $('.rework_mass_payment').on('click', function() {
            $('.rework_check:checked').each(function() {
                $(this).parents('.rework_status_all').find('.ajax_rework_payment').val('yes').click();
            });
        });
        
        $('.rework_mass_payment_member').on('click', function() {
            $('.rework_check:checked').each(function() {
                $(this).parents('.rework_status_all').find('.ajax_rework_payment_perfomer').val('yes').click();
            });
        });
        
        $('.rework_mass_status_active').on('click', function() {
            $('.rework_check:checked').each(function() {
                $(this).parents('.rework_status_all').find('.ajax_rework_status').val('active').change();
            });
        });
        
        $('.rework_mass_status_close').on('click', function() {
            $('.rework_check:checked').each(function() {
                $(this).parents('.rework_status_all').find('.ajax_rework_status').val('close').change();
            });
        });
        
        $('.rework_mass_status_done').on('click', function() {
            $('.rework_check:checked').each(function() {
                $(this).parents('.rework_status_all').find('.ajax_rework_status').val('done').change();
            });
        });
    },
    change_task_payment: function() {
        var edit_select = $(this);
        $(edit_select).parents('li,p').css('opacity', 0.3);
        $.post(
            dvizh_cms_host+'tasks/change_payment',
            {ajax: "true", payment: $(edit_select).val(), id: $(edit_select).data('id')},
            function(answer) {
                var json = $.parseJSON(answer);
                if(json.result == 'success') {
                    $(edit_select).css('border', '1px solid green');
                    $(edit_select).parents('li').css('opacity', 1);
                    
                    if($(edit_select).hasClass('full_task_page')) {
                        $('.block_main').css('opacity', '0.3');
                        document.location.reload();
                    }
                    else {
                        $(edit_select).parents('li').replaceWith(json.task_inlist);
                        datepicker_init();
                    }
                }
                else {
                    alert('Error');
                }
            }
        );
    },
    change_task_status: function() {
        var edit_select = $(this);
        $(edit_select).parents('li,p').css('opacity', 0.3);
        $.post(
            dvizh_cms_host+'tasks/change_status',
            {ajax: "true", status: $(edit_select).val(), id: $(edit_select).data('id')},
            function(answer) {
                var json = $.parseJSON(answer);
                if(json.result == 'success') {
                    $(edit_select).css('border', '1px solid green');
                    $(edit_select).parents('li').css('opacity', 1);
                    
                    if($(edit_select).hasClass('full_task_page')) {
                        $('.block_main').css('opacity', '0.3');
                        document.location.reload();
                    }
                    else {
                        $(edit_select).parents('li').replaceWith(json.task_inlist);
                        datepicker_init();
                    }
                }
                else {
                    alert('Error');
                }
            }
        );
    },
    change_task_user_status: function() {
        var edit_select = $(this);
        $(edit_select).parents('li').css('opacity', 0.3);
        $.post(
            dvizh_cms_host+'tasks/change_user_status',
            {ajax: "true", status: $(edit_select).val(), user_id: $(edit_select).data('user-id'), task_id: $(edit_select).data('task-id')},
            function(answer) {
                var json = $.parseJSON(answer);
                if(json.result == 'success') {
                    $(edit_select).parents('li').css('opacity', 1);
                    
                    $(edit_select).css('border', '1px solid green');
                    $(edit_select).parents('li').find('.ajax_user_status').val($(edit_select).val());
                    
                    if($(edit_select).hasClass('full_task_page')) {
                        
                    }
                    else {
                        $(edit_select).parents('li').replaceWith(json.task_inlist);
                        datepicker_init();
                    }
                }
                else {
                    alert('Error');
                }
            }
        );
    },
    change_task_price: function() {
        var edit_input = $(this);
        $(edit_input).parents('li').css('opacity', 0.3);
        if(confirm('change?')) {
            $.post(
                dvizh_cms_host+'tasks/change_price',
                {ajax: "true", price: $(edit_input).val(), id: $(edit_input).data('id')},
                function(answer) {
                    var answer = $.parseJSON(answer);
                    if(answer.dvizh_price) {
                        $(edit_input).parents('li').css('opacity', 1);
                        $(edit_input).siblings('.dvizh_price').html(answer.dvizh_price);
                    }
                    else {
                        alert('Error');
                    }
                    if($(edit_input).hasClass('full_task_page')) {
                        $('.block_main').css('opacity', '0.3');
                        document.location.reload();
                    }
                    else {
                        $(edit_input).parents('li').replaceWith(json.task_inlist);
                        datepicker_init();
                    }
                }
            );
        }
    },
    change_task_deadline: function() {
        var edit_input = $(this);
        $(edit_input).parents('li').css('opacity', 0.3);
        if(confirm('change?')) {
            $.post(
                dvizh_cms_host+'tasks/change_deadline',
                {ajax: "true", deadline: $(edit_input).val(), id: $(edit_input).data('id')},
                function(answer) {
                    var json = $.parseJSON(answer);
                    if(json.result == 'success') {
                        $(edit_input).css('border', '1px solid green');
                        $(edit_input).parents('li').css('opacity', 1);
                        if($(edit_input).hasClass('full_task_page')) {
                            $('.block_main').css('opacity', '0.3');
                            document.location.reload();
                        }
                        else {
                            $(edit_input).parents('li').replaceWith(json.task_inlist);
                            datepicker_init();
                        }
                    }
                    else {
                        alert('Error');
                    }
                }
            );
        }
    },
    change_task_user_price: function() {
        var edit_input = $(this);
        $(edit_input).parents('li').css('opacity', 0.3);
        if(confirm('change?')) {
            $.post(
                dvizh_cms_host+'tasks/change_user_price',
                {ajax: "true", price: $(edit_input).val(), user_id: $(edit_input).data('user-id'), task_id: $(edit_input).data('task-id')},
                function(answer) {
                    var json = $.parseJSON(answer);
                    if(json.result == 'success') {
                        $(edit_input).parents('li').css('opacity', 1);
                        $(edit_input).css('border', '1px solid green');
                    }
                    else {
                        alert('Error');
                    }
                }
            );
        }
    },
    change_task_user_deadline: function() {
        var edit_input = $(this);
        $(edit_input).parents('li').css('opacity', 0.3);
        if(confirm('change?')) {
            $.post(
                dvizh_cms_host+'tasks/change_user_deadline',
                {ajax: "true", deadline: $(edit_input).val(), user_id: $(edit_input).data('user-id'), task_id: $(edit_input).data('task-id')},
                function(answer) {
                    var json = $.parseJSON(answer);
                    if(json.result == 'success') {
                        $(edit_input).parents('li').css('opacity', 1);
                        $(edit_input).css('border', '1px solid green');
                    }
                    else {
                        alert('Error');
                    }
                }
            );
        }
    },
    change_task_user_payment: function() {
        var edit_input = $(this);
        $(edit_input).parents('li').css('opacity', 0.3);
        if(confirm('change?')) {
            $.post(
                dvizh_cms_host+'tasks/change_user_payment',
                {ajax: "true", payment: $(edit_input).val(), user_id: $(edit_input).data('user-id'), task_id: $(edit_input).data('task-id')},
                function(answer) {
                    var json = $.parseJSON(answer);
                    if(json.result == 'success') {
                        $(edit_input).parents('li').css('opacity', 1);
                        $(edit_input).css('border', '1px solid green');
                    }
                    else {
                        alert('Error');
                    }
                }
            );
        }
    },
    logout: function() {
        if(!confirm('realy exit?')) {
            return false;
        }
    },
    delete_object: function() {
        //if(!confirm('Realy?')) {
            //return false;
        //}
    },
    show_tasks_by_user_status: function() {
        $.post(
            dvizh_cms_host+'tasks/show_tasks_by_user_status',
            {ajax: "true", show_tasks_by_user_status: $(this).is(':checked')},
            function(answer) {
                if(answer == 'ok') {
                    document.location.reload();
                }
                else {
                    alert('Error');
                }
            }
        );
    },
    kudir_click_show: function() {
        $(".kudir_click_show").toggle("slow");
        return false;
    },
    upload_link: function() {
        $(this).select();
    },
    add_fine: function() {
        var form_element = $(this);
        $(form_element).css('opacity', '0.3');
        var form_data = $(this).serialize();
        var form_action = $(this).attr('action');
        $.post(
            form_action,
            form_data,
            function(answer) {
                var answer = $.parseJSON(answer);
                if(answer.result == 'success') {
                    alert('done');
                }
                else {
                    alert(answer.error);
                }
                $(form_element).css('opacity', '1');
            }
        );
        return false;
    },
    add_comment: function() {
        var form_element = $(this);
        var form_data = $(this).serialize();
        var form_action = $(this).attr('action');
        $.post(
            form_action,
            form_data,
            function(answer) {
                var answer = $.parseJSON(answer);
                if(answer.error) {
                    alert(answer.error);
                }
                else {
                    $('.comments_list .no_comments').hide();
                    $('.comments_list > ul').prepend(answer.comment);
                    $(form_element).find('textarea').val('');
                }
            }
        );
        return false;
    },
    workday_start: function() {
        var wd_button = $(this);
        $.post(
            dvizh_cms_host+'workday/start',
            {ajax: "true"},
            function(answer) {
                if(answer == 'ok') {
                    $(wd_button).replaceWith('<p>OK</p>');
                }
                else {
                    alert('Error');
                }
            }
        );
    },
    workday_stop: function() {
        $(this).hide();
        $(this).siblings('form').show('slow');
    },

    send_workday_report: function() {
        var wd_form = $(this);
        $.post(
            dvizh_cms_host+'workday/stop',
            $(wd_form).serialize(),
            function(answer) {
                if(answer == 'ok') {
                    $(wd_form).html('OK');
                }
                else {
                    alert('Error');
                }
            }
        );
        return false;
    },
    ajax_delete: function() {
        if(!confirm('Realy?')) {
            return false;
        }
        var delete_url = $(this).attr('href');
        var delete_link = $(this);
        var delete_callback = $(this).data('callback');
        if(!delete_callback) var delete_callback = "parents_li_delete";
        $.post(
            delete_url,
            {ajax: "true"},
            function(answer) {
                window[delete_callback](answer, delete_link);
            }
        );
        return false;
    },
    do_notification: function() {
        if($(this).is(':checked')) {
            $('.notified_users').find('.n_u_developer').prop('checked', true);
        }
        else {
            $('.notified_users').find('input[type=checkbox]').prop('checked', false);
        }
    },
    kudir_filter: function() {
        var type = $(this).attr('type');
        var user_id = $( "#user_id_kudir").val();
        var project_id = $( "#project_id_kudir").val();
        
        $.post(
            dvizh_cms_host+'kudir/view',
            {type: type,user_id: user_id,project_id: project_id},
            function(answer) {
                var json = $.parseJSON(answer);
                if (json.result == 'ok') {
                    $('.kudir_hide').replaceWith(json.view);
                    $('.kudir_allinout').replaceWith(json.view);
                }
                else {
                    alert ('Error');
                }
            }
        );
        return false;
    },
    show_edit_comment: function() {
        $(this).parents('.comm_body').find('.comm_text').toggle('slow');
        $(this).parents('.comm_body').find('.comm_edit').toggle('slow');
        return false;
    },
    edit_comment: function() {
        var form_element = $(this);
        var form_data = $(this).serialize();
        var form_action = $(this).attr('action');
        $.post(
            form_action,
            form_data,
            function(answer) {
                var answer = $.parseJSON(answer);
                if(answer.error) {
                    alert(answer.error);
                }
                else {
                    $(form_element).parents('.comm_edit').toggle('slow');
                    $(form_element).parents('.comm_body').find('.comm_text').toggle('slow');
                    $(form_element).parents('.comm_body').find('.comm_text').html(answer.text);
                }
            }
        );
        return false;
    },
    add_rework: function() {
        var form_element = $(this);
        var form_data = $(this).serialize();
        var form_action = $(this).attr('action');
        $('#reworks .reworks_list').css('opacity', 0.3);
        $.post(
            form_action,
            form_data,
            function(answer) {
                var answer = $.parseJSON(answer);
                if(answer.error) {
                    alert(answer.error);
                }
                else {
                    $('.add_rework').hide('slow');
                    $('.add_rework textarea').val('');
                    $('#reworks .reworks_list').html(answer.reworks_list);
                    $('#reworks .reworks_list').css('opacity', 1);
                    $("html,body").animate({"scrollTop":$("body").height()}, 800); 
                }
            }
        );
        return false;
    },
    scroll_bottom: function() {
        $("html,body").animate({"scrollTop":$("body").height()}, 800); 
        return false;
    },
    change_rework_status: function() {
        var edit_select = $(this);
        $(edit_select).css('opacity', '0.3');
        $.post(
            dvizh_cms_host+'reworks/change_status',
            {ajax: "true", status: $(edit_select).val(), id: $(edit_select).data('id')},
            function(answer) {
                var json = $.parseJSON(answer);
                $(edit_select).css('opacity', '1');
                $(edit_select).parents('li.rework_status_all').replaceWith(json.rework_line);
                $(edit_select).parents('li.full_rework').prev('li').replaceWith(json.rework_line);
                $(edit_select).parents('li.full_rework').find('select[name=rework_status]').val($(edit_select).val());
            }
        );
    },
    change_rework_perfomer: function() {
        var edit_select = $(this);
        $(edit_select).css('opacity', '0.3');
        $.post(
            dvizh_cms_host+'reworks/change_perfomer',
            {ajax: "true", perfomer: $(edit_select).val(), id: $(edit_select).data('id')},
            function(answer) {
                var json = $.parseJSON(answer);
                $(edit_select).css('opacity', '1');
                $(edit_select).parents('li.rework_status_all').replaceWith(json.rework_line);
                $(edit_select).parents('li.full_rework').prev('li').replaceWith(json.rework_line);
            }
        );
    },
    send_kudir_add: function() {
        var form = $(this);
        $(form).css('opacity', '0.3');
        $('#kudirtable').css('opacity', '0.6');
        $.post(
            $(form).attr('action'),
            $(form).serialize(),
            function(answer) {
                var json = $.parseJSON(answer);
                $(form).css('opacity', '1');
                $('#kudirtable').css('opacity', '1');
                if(json.result == 'success') {
                    $('#kudirtable').html(json.table);
                }
                else {
                    alert(json.error);
                }
            }
        );
        return false;
    },
    send_rework_comment: function() {
        var form = $(this);
        $(form).css('opacity', '0.3');
        $.post(
            $(form).attr('action'),
            $(form).serialize(),
            function(answer) {
                var json = $.parseJSON(answer);
                if(json.result == 'success') {
                    $(form).find('textarea').val('');
                    $(form).parents('li.rework_status_all').find('.rework_comment').show();
                    $(form).parents('li.rework_status_all').find('.rework_comment div').html(json.last_comment);
                    $(form).css('opacity', '1');
                    $(form).parents('li.full_rework').prev('.rework_status_all').removeClass().addClass('rework_status_all').addClass('row').addClass('rework_status_'+json.rework_status).find('.ajax_rework_status').val(json.rework_status);
                    $(form).parents('li.full_rework').find('.ajax_rework_status').val(json.rework_status);
                    
                    $(form).parents('li.full_rework').find('.comments_list').prepend(json.comment_inlist);
                }
                else {
                    alert('Error');
                }
            }
        );
        return false;
    },
    change_rework_price: function() {
        var edit_input = $(this);
        $(edit_input).css('opacity', '0.3');
        //if(confirm('change?')) {
            $.post(
                dvizh_cms_host+'reworks/change_price',
                {ajax: "true", price: $(edit_input).val(), id: $(edit_input).data('id')},
                function(answer) { 
                    var json = $.parseJSON(answer);
                    $(edit_input).css('opacity', '1');
                    $(edit_input).parents('li.rework_status_all').replaceWith(json.rework_line);
                    $(edit_input).parents('li.full_rework').prev('li').replaceWith(json.rework_line);
                }
            );
        //}
    },
    change_rework_payment: function() {
        var edit_input = $(this);
        $(edit_input).css('opacity', '0.3');
        if(true) {
        //if(confirm('change?')) {
            $.post(
                dvizh_cms_host+'reworks/change_payment',
                {ajax: "true", payment: $(edit_input).val(), id: $(edit_input).data('id')},
                function(answer) {
                    var json = $.parseJSON(answer);
                    $(edit_input).css('opacity', '1');
                    $(edit_input).parents('li.rework_status_all').replaceWith(json.rework_line);
                    $(edit_input).parents('li.full_rework').prev('li').replaceWith(json.rework_line);
                }
            );
        }
    },
    change_rework_payment_perfomer: function() {
        var edit_input = $(this);
        $(edit_input).css('opacity', '0.3');
        if(true) {
        //if(confirm('change?')) {
            $.post(
                dvizh_cms_host+'reworks/change_payment_perfomer',
                {ajax: "true", payment: $(edit_input).val(), id: $(edit_input).data('id')},
                function(answer) {
                    var json = $.parseJSON(answer);
                    $(edit_input).css('opacity', '1');
                    $(edit_input).parents('li.rework_status_all').replaceWith(json.rework_line);
                    $(edit_input).parents('li.full_rework').prev('li').replaceWith(json.rework_line);
                }
            );
        }
    },
    get_rework_comments: function() {
        var comments_list = $(this).siblings('.rework_comments').find('.comments_list');
        if($(comments_list).html() == '') {
            var rework_id = $(this).data('rework-id');
            $(comments_list).html('<li>...</li>');
            $.post(
                dvizh_cms_host+'comments_ajax/get_rework_comments',
                {ajax: "true", id: rework_id},
                function(answer) {
                    var json = $.parseJSON(answer);
                    $(comments_list).html(json.comments_list);
                }
            );
        }
        
        //$(this).siblings('.rework_comment').toggle('slow');
        $(this).siblings('.rework_comments').toggle('slow');
        return false;
    },
    reworks_take_list: function() {
        var textarea = $(this).siblings('textarea');
        $(textarea).toggle('slow');
        $(textarea).val('');
        $('.reworks_list li:visible').each(function() {
            var price = parseInt($(this).data('ob-price'));
            if(price > 0) {
                var price_str = " ("+dvizh_currency+""+price+")";
            }
            else {
                var price_str = "";
            }
            var line = $(this).find('.number span').html()+') '+$(this).find('.clear_rework_text').html()+''+price_str+"\n\n";
            $(textarea).val($(textarea).val()+line);
        });
        return false;
    },
    rf_member: false,
    rf_status: false,
    rf_payment: false,
    rf_container: false,
    leave_unpayment_reworks: function() {
        dvizh_engine.rf_container = $(this).parents('.reworks_control_panel').siblings('.reworks_list');
        if($(this).hasClass('active')) {
            $(this).removeClass('active');
            $('#reworks .reworks_list li').show('slow');
            dvizh_engine.rf_payment = false;
        }
        else {
            $('#reworks .reworks_control_panel a').removeClass('active');
            $(this).addClass('active');
            dvizh_engine.rf_payment = 'no';
        }
        dvizh_engine.apply_reworks_filter();
        return false;
    },
    reworks_filter: function() {
        dvizh_engine.rf_container = $(this).parents('.reworks_control_panel').siblings('.reworks_list');
        if($(this).val() == 'all') {
            dvizh_engine.rf_status = false;
        }
        else {
            dvizh_engine.rf_status = $(this).val();
        }
        dvizh_engine.apply_reworks_filter();
    },
    reworks_filter_member: function() {
        dvizh_engine.rf_container = $(this).parents('.reworks_control_panel').siblings('.reworks_list');
        if($(this).val() == 'all') {
            dvizh_engine.rf_member = false;
        }
        else {
            dvizh_engine.rf_member = $(this).val();
        }
        dvizh_engine.apply_reworks_filter();
    },
    apply_reworks_filter: function() {
        $(dvizh_engine.rf_container).find('li').hide();
        $(dvizh_engine.rf_container).find('li').each(function() {
            if(dvizh_engine.rf_member && dvizh_engine.rf_status) {
                if($(this).data('perfomer') == dvizh_engine.rf_member && $(this).data('status') == dvizh_engine.rf_status) {
                    $(this).show();
                }
            }
            else if(dvizh_engine.rf_member) {
                if($(this).data('perfomer') == dvizh_engine.rf_member) {
                    $(this).show();
                }
            }
            else if(dvizh_engine.rf_status) {
                if($(this).data('status') == dvizh_engine.rf_status) {
                    $(this).show();
                }
            }
            else {
                $(this).show();
            }

            if(dvizh_engine.rf_payment) {
                if(parseInt($(this).data('price')) <= 0 | $(this).data('payment') != dvizh_engine.rf_payment) {
                    $(this).hide();
                }
            }
        });
    },
    choise_user_checkbox: function() {
        var filter_input = $(this);
        $(filter_input).siblings('ul.search_result').show();
        $(filter_input).siblings('ul.default_list').find('li.more').remove();
        $.post(
            dvizh_cms_host+'userpanel/get_users',
            {ajax: "true", type: $(filter_input).data('type'), str: $(filter_input).val()},
            function(answer) {
                var answer = $.parseJSON(answer);
                if(answer.items.length > 0) {
                    $(filter_input).siblings('ul.search_result').html('');
                    
                    $(answer.items).each(function(index, item) {
                        var checkbox = $('#user'+item.id).val();
                        if(!checkbox) {
                            $(filter_input).siblings('ul.search_result').append('<li class="searched"><input type="checkbox" name="members[]" value="'+item.id+'" size="30" id="user'+item.id+'"> <label for="user'+item.id+'">'+item.username+'</label> <small>'+item.role+'</small></li>');
                        }
                    });
                }
                else {
                    $(filter_input).siblings('ul.search_result').html('<li>-</li>');
                }
            }
        );
    },
    choise_user_select: function() {
        var filter_input = $(this);
        $.post(
            dvizh_cms_host+'userpanel/get_all_users',
            {ajax: "true", str: $(filter_input).val()},
            function(answer) {
                var answer = $.parseJSON(answer);
                if(answer.items.length > 0) {
                    $(filter_input).siblings('select').html('');
                    $(answer.items).each(function(index, item) {
                        $(filter_input).siblings('select').append('<option value="'+item.id+'">'+item.username+'</option>');
                    });
                }
                else {
                    $(filter_input).siblings('select').html('<option value="">-</option>');
                }
            }
        );
    },
    choise_project: function() {
        var filter_input = $(this);
        $.post(
            dvizh_cms_host+'projects/get_projects',
            {ajax: "true", str: $(filter_input).val()},
            function(answer) {
                var answer = $.parseJSON(answer);
                if(answer.items.length > 0) {
                    $(filter_input).siblings('select').html('');
                    $(answer.items).each(function(index, item) {
                        $(filter_input).siblings('select').append('<option value="'+item.id+'">'+item.name+'</option>');
                    });
                }
                else {
                    $(filter_input).siblings('select').html('<option value="">-</option>');
                }
            }
        );
    },
}

$(document).ready(function() {
    dvizh_engine.init();
    
    $(document).on('click', '.kudir_filter_btn', function(){
        var user_id = $(this).data('user_id');
        var project_id = $(this).data('project_id');
        var type = $(this).data('type');
        $.post(
            dvizh_cms_host+'kudir/view',
            {type: type,user_id: user_id,project_id: project_id},
            function(answer) {
                var json = $.parseJSON(answer);
                if (json.result == 'ok')
                {
                    $('.kudir_hide').replaceWith(json.view);
                    $('.kudir_allinout').replaceWith(json.view);
                } else {
                    alert ('Error');
                }
            }
        );
        return false;
    });
    
    
    $(document).on('click', '.nav-tabs-active a', function (e) {
        e.preventDefault();
        $(this).tab('show');
        document.location.hash = 'open-tab-'+$(this).attr('href').replace('#', '');
        return false;
    });
    
    if(document.location.hash) {
        var tab_a_id = document.location.hash.replace('#', '').replace('open-', '');
        setTimeout("$('.nav-tabs a#"+tab_a_id+"').click()", 4);
    }

    $('.nav-tabs-active a:first').tab('show');
});