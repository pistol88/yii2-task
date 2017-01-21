if (typeof pistol88 == "undefined" || !pistol88) {
    var pistol88 = {};
}

pistol88.task_ajax_widgets = {
    init: function() {
        $(document).on('keyup', '.task_ajax_widget .ajax_rework_price', this.change_rework_price);
        $(document).on('change', '.task_ajax_widget .ajax_rework_payment', this.change_rework_payment);
        $(document).on('change', '.task_ajax_widget .ajax_rework_payment_perfomer', this.change_rework_payment_perfomer);
        $(document).on('change', '.task_ajax_widget .ajax_rework_status', this.change_rework_status);
        $(document).on('change', '.task_ajax_widget .ajax_rework_perfomer', this.change_rework_perfomer);
        $(document).on('change', '.task_ajax_widget .ajax_rework_deadline', this.change_rework_deadline);
        
        $(document).on('change', '.task_ajax_widget .ajax_task_status', this.change_task_status);
        $(document).on('change', '.task_ajax_widget .ajax_task_payment', this.change_task_payment);
        $(document).on('change', '.task_ajax_widget .ajax_user_status', this.change_task_user_status);
        $(document).on('change', '.task_ajax_widget .ajax_user_price', this.change_task_user_price);
        $(document).on('change', '.task_ajax_widget .ajax_user_deadline', this.change_task_user_deadline);
        $(document).on('change', '.task_ajax_widget .ajax_user_payment', this.change_task_user_payment);
        $(document).on('change', '.task_ajax_widget .ajax_task_price', this.change_task_price);
        $(document).on('change', '.task_ajax_widget .ajax_task_deadline', this.change_task_deadline);
    },
    render: function(data) {
        $('.task-members-widget').replaceWith(data.membersWidgetHtml);
        
        if(data.reworkId) {
            $('.rework_'+data.reworkId).replaceWith(data.htmlData);
        }
        
        if(data.taskId) {
            $('.tashHeader'+data.taskId).replaceWith(data.taskHeaderWidgetHtml);
        }
    },
    change_task_payment: function() {
        var edit_select = $(this);
        $(edit_select).css('opacity', 0.3);
        $.post(
            dvizhTaskToolsUrl+'change_payment',
            {ajax: "true", payment: $(edit_select).val(), task_id: $(edit_select).data('id')},
            function(answer) {
                var json = $.parseJSON(answer);
                if(json.result == 'success') {
                    $(edit_select).css('opacity', 1);
                    pistol88.task_ajax_widgets.render(json);
                }
                else {
                    alert('Error');
                }
            }
        );
    },
    change_task_status: function() {
        var edit_select = $(this);
        $(edit_select).css('opacity', 0.3);
        $.post(
            dvizhTaskToolsUrl+'change_status',
            {ajax: "true", status: $(edit_select).val(), task_id: $(edit_select).data('id')},
            function(answer) {
                var json = $.parseJSON(answer);
                if(json.result == 'success') {
                    $(edit_select).css('opacity', 1);
                    pistol88.task_ajax_widgets.render(json);
                }
                else {
                    alert('Error');
                }
            }
        );
    },
    change_task_user_status: function() {
        var edit_select = $(this);
        $(edit_select).css('opacity', 0.3);
        $.post(
            dvizhTaskToolsUrl+'change_user_status',
            {ajax: "true", status: $(edit_select).val(), user_id: $(edit_select).data('user-id'), task_id: $(edit_select).data('task-id')},
            function(answer) {
                var json = $.parseJSON(answer);
                if(json.result == 'success') {
                    $(edit_select).css('opacity', 1);
                    pistol88.task_ajax_widgets.render(json);
                }
                else {
                    alert('Error');
                }
            }
        );
    },
    change_task_price: function() {
        var edit_input = $(this);
        $(edit_input).css('opacity', 0.3);
        if(confirm('change?')) {
            $.post(
                dvizhTaskToolsUrl+'change_price',
                {ajax: "true", price: $(edit_input).val(), task_id: $(edit_input).data('id')},
                function(answer) {
                    var json = $.parseJSON(answer);
                    if(json.result == 'success') {
                        $(edit_input).css('opacity', 1);
                        pistol88.task_ajax_widgets.render(json);
                    }
                    else {
                        alert('Error');
                    }
                }
            );
        }
    },
    change_task_deadline: function() {
        var edit_input = $(this);
        $(edit_input).css('opacity', 0.3);
        if(confirm('change?')) {
            $.post(
                dvizhTaskToolsUrl+'change_deadline',
                {ajax: "true", deadline: $(edit_input).val(), task_id: $(edit_input).data('id')},
                function(answer) {
                    var json = $.parseJSON(answer);
                    if(json.result == 'success') {
                        $(edit_input).css('opacity', 1);
                        pistol88.task_ajax_widgets.render(json);
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
        $(edit_input).css('opacity', 0.3);
        if(confirm('change?')) {
            $.post(
                dvizhTaskToolsUrl+'change_user_price',
                {ajax: "true", price: $(edit_input).val(), user_id: $(edit_input).data('user-id'), task_id: $(edit_input).data('task-id')},
                function(answer) {
                    var json = $.parseJSON(answer);
                    if(json.result == 'success') {
                        $(edit_input).css('opacity', 1);
                        pistol88.task_ajax_widgets.render(json);
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
        $(edit_input).css('opacity', 0.3);
        if(confirm('change?')) {
            $.post(
                dvizhTaskToolsUrl+'change_user_deadline',
                {ajax: "true", deadline: $(edit_input).val(), user_id: $(edit_input).data('user-id'), task_id: $(edit_input).data('task-id')},
                function(answer) {
                    var json = $.parseJSON(answer);
                    if(json.result == 'success') {
                        $(edit_input).css('opacity', 1);
                        pistol88.task_ajax_widgets.render(json);
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
        $(edit_input).css('opacity', 0.3);
        if(confirm('change?')) {
            $.post(
                dvizhTaskToolsUrl+'change_user_payment',
                {ajax: "true", payment: $(edit_input).val(), user_id: $(edit_input).data('user-id'), task_id: $(edit_input).data('task-id')},
                function(answer) {
                    var json = $.parseJSON(answer);
                    if(json.result == 'success') {
                        $(edit_input).css('opacity', 1);
                        pistol88.task_ajax_widgets.render(json);
                    }
                    else {
                        alert('Error');
                    }
                }
            );
        }
    },
    change_rework_status: function() {
        var edit_select = $(this);
        $(edit_select).css('opacity', '0.3');
        $.post(
            dvizhTaskToolsUrl+'reworks_change_status',
            {ajax: "true", status: $(edit_select).val(), rework_id: $(edit_select).data('id')},
            function(answer) {
                var json = $.parseJSON(answer);
                if(json.result == 'success') {
                    $(edit_select).css('opacity', 1);
                    pistol88.task_ajax_widgets.render(json);
                }
                else {
                    alert('Error');
                }
            }
        );
    },
    change_rework_perfomer: function() {
        var edit_select = $(this);
        $(edit_select).css('opacity', '0.3');
        $.post(
            dvizhTaskToolsUrl+'reworks_change_perfomer',
            {ajax: "true", perfomer: $(edit_select).val(), rework_id: $(edit_select).data('id')},
            function(answer) {
                var json = $.parseJSON(answer);
                if(json.result == 'success') {
                    $(edit_select).css('opacity', 1);
                    pistol88.task_ajax_widgets.render(json);
                }
                else {
                    alert('Error');
                }
            }
        );
    },
    change_rework_deadline: function() {
        var edit_select = $(this);
        $(edit_select).css('opacity', '0.3');
        $.post(
            dvizhTaskToolsUrl+'reworks_change_deadline',
            {ajax: "true", perfomer: $(edit_select).val(), rework_id: $(edit_select).data('id')},
            function(answer) {
                var json = $.parseJSON(answer);
                if(json.result == 'success') {
                    $(edit_select).css('opacity', 1);
                    pistol88.task_ajax_widgets.render(json);
                }
                else {
                    alert('Error');
                }
            }
        );
    },
    change_rework_price: function() {
        var edit_input = $(this);
        $(edit_input).css('opacity', '0.3');
        //if(confirm('change?')) {
            $.post(
                dvizhTaskToolsUrl+'reworks_change_price',
                {ajax: "true", price: $(edit_input).val(), rework_id: $(edit_input).data('id')},
                function(answer) { 
                    var json = $.parseJSON(answer);
                    if(json.result == 'success') {
                        $(edit_input).css('opacity', 1);
                        pistol88.task_ajax_widgets.render(json);
                    }
                    else {
                        alert('Error');
                    }
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
                dvizhTaskToolsUrl+'reworks_change_payment',
                {ajax: "true", payment: $(edit_input).val(), rework_id: $(edit_input).data('id')},
                function(answer) {
                    var json = $.parseJSON(answer);
                    if(json.result == 'success') {
                        $(edit_input).css('opacity', 1);
                        pistol88.task_ajax_widgets.render(json);
                    }
                    else {
                        alert('Error');
                    }
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
                dvizhTaskToolsUrl+'reworks_change_payment_perfomer',
                {ajax: "true", payment: $(edit_input).val(), rework_id: $(edit_input).data('id')},
                function(answer) {
                    var json = $.parseJSON(answer);
                    if(json.result == 'success') {
                        $(edit_input).css('opacity', 1);
                        pistol88.task_ajax_widgets.render(json);
                    }
                    else {
                        alert('Error');
                    }
                }
            );
        }
    },
}

pistol88.task_ajax_widgets.init();