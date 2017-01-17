var dvizh_engine = {
    init: function() {
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
    },
}

dvizh_engine.init();

