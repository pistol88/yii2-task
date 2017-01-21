if (typeof pistol88 == "undefined" || !pistol88) {
    var pistol88 = {};
}

pistol88.task_members = {
    init: function() {
        $(document).on('keypress', '.task-members-widget .newDeveloperInput', this.addNewDeveloper);
        $(document).on('keypress', '.task-members-widget .newClientInput', this.addNewClient);
        $(document).on('submit', '.task-members-widget .newmember form', this.addNewMember)
        $(document).on('click', '.task-members-widget .deleteMember', this.deleteMember);
        $(document).on('click', '.task-members-widget .memberCheckbox', this.sendNewMemberForm)
    },
    sendNewMemberForm: function() {
        $(this).parents('form').submit();
        $('.newMemberInput').val('');
    },
    addNewClient: function() {
        var str = $(this).val();
        var input = $(this);
        $.post(
            dvizhUrl+'/client/tools/get-clients-by-name',
            {ajax: "true", str: str},
            function(answer) {
                var json = $.parseJSON(answer);
                if(json.result == 'success') {
                    var userList = $(input).siblings('.users-list');
                    $(userList).html('<ul></ul>');
                    $.each(json.elements, function() {
                        $(userList).find('ul').append('<li><input class="memberCheckbox" type="radio" name="clients[]" value="'+this.id+'" /> &nbsp;&nbsp; <a href="/client/client/view?id='+this.id+'" target="_blank">'+this.name+' - <small><small>'+this.category+'</small></small></a></li>');
                    });
                }
                else {
                    alert('Error');
                }
            }
        );
    },
    addNewDeveloper: function() { 
        var str = $(this).val();
        var input = $(this);
        $.post(
            dvizhUrl+'/staffer/tools/get-staffers-by-name',
            {ajax: "true", str: str},
            function(answer) {
                var json = $.parseJSON(answer);
                if(json.result == 'success') {
                    var userList = $(input).siblings('.users-list');
                    $(userList).html('<ul></ul>');
                    $.each(json.elements, function() {
                        $(userList).find('ul').append('<li><input class="memberCheckbox" type="radio" name="staffers[]" value="'+this.id+'" /> &nbsp;&nbsp; <a href="/staffer/staffer/view?id='+this.id+'" target="_blank">'+this.name+' - <small><small>'+this.category+'</small></small></a></li>');
                    });
                }
                else {
                    alert('Error');
                }
            }
        );
    },
    addNewMember: function() {
        var form = $(this);
        $('.task-members-widget').css('opacity', '0.3');
        $.post(
            $(form).attr('action'),
            $(form).serialize(),
            function(answer) {
                var json = $.parseJSON(answer);
                
                $('.task-members-widget').replaceWith(json.membersWidgetHtml);
                if(json.result == 'success') {
                    $(form).find('ul').html('');
                }
                else {
                    alert('Error');
                }
            }
        );
        
        return false;
    },

    deleteMember: function() {
        var a = $(this);
        $('.task-members-widget').css('opacity', '0.3');
        $.post(
            $(a).attr('href'),
            {ajax: "true"},
            function(answer) {
                var json = $.parseJSON(answer);
                if(json.result == 'success') {
                    $('.task-members-widget').replaceWith(json.membersWidgetHtml);
                }
                else {
                    alert('Error');
                }
            }
        );
        
        return false;
    },
}

pistol88.task_members.init();