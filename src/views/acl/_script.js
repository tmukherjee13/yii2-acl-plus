$('i.glyphicon-refresh-animate').hide();
function updateMenus(r) {
    _opts.menus.avaliable = r.avaliable;
    _opts.menus.assigned = r.assigned;
    search('avaliable');
    search('assigned');
}

$('#btn-new').click(function () {
    var $this = $(this);
    var route = $('#inp-route').val().trim();
    if (route != '') {
        $this.children('i.glyphicon-refresh-animate').show();
        $.post($this.attr('href'), {route: route}, function (r) {
            $('#inp-route').val('').focus();
            updateMenus(r);
        }).always(function () {
            $this.children('i.glyphicon-refresh-animate').hide();
        });
    }
    return false;
});

$('.btn-assign').click(function () {
    var $this = $(this);
    var target = $this.data('target');
    var menus = $('select.list[data-target="' + target + '"]').val();

    if (menus && menus.length) {
        $this.children('i.glyphicon-refresh-animate').show();
        $.post($this.attr('href'), {menus: menus}, function (r) {
            updateMenus(r);
        }).always(function () {
            $this.children('i.glyphicon-refresh-animate').hide();
        });
    }
    return false;
});

$('#btn-refresh').click(function () {
    var $icon = $(this).children('span.glyphicon');
    $icon.addClass('glyphicon-refresh-animate');
    $.post($(this).attr('href'), function (r) {
        updateMenus(r);
    }).always(function () {
        $icon.removeClass('glyphicon-refresh-animate');
    });
    return false;
});

$('.search[data-target]').keyup(function () {
    search($(this).data('target'));
});

function search(target) {
    var $list = $('select.list[data-target="' + target + '"]');
    $list.html('');
    var q = $('.search[data-target="' + target + '"]').val();
    $.each(_opts.menus[target], function (i,text) {
        var r = this;
        if (r.indexOf(q) >= 0) {
            $('<option>').text(text).val(i).appendTo($list);
        }
    });
}

// initial
search('avaliable');
search('assigned');
