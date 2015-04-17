/**
 * Created by steven.delgado on 20-02-2015.
 */
$(document).ready(function ($) {

    //Barra de nav activación
    var url = window.location;
    //Sólo funcionará si cadena en href coincide con la ubicación
    $('ul.nav a[href="' + url + '"]').parent().addClass('active');
    // También Trabajará para hrefs relativos y absolutos
    $('ul.nav a').filter(function () {
        return this.href == url;
    }).parent().addClass('active');

    //Validación de input
    $('.input-group input[required], .input-group textarea[required], .input-group select[required]').on('keyup change', function () {
        var $form = $(this).closest('form'),
            $group = $(this).closest('.input-group'),
            $addon = $group.find('.input-group-addon'),
            $icon = $addon.find('span'),
            state = false;

        if (!$group.data('validate')) {
            state = $(this).val() ? true : false;
        } else if ($group.data('validate') == "mail") {
            state = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test($(this).val())
        } else if ($group.data('validate') == 'phone') {
            state = /^[(]{0,1}[0-9]{3}[)]{0,1}[-\s\.]{0,1}[0-9]{3}[-\s\.]{0,1}[0-9]{4}$/.test($(this).val())
        } else if ($group.data('validate') == "length") {
            state = $(this).val().length >= $group.data('length') ? true : false;
        } else if ($group.data('validate') == "number") {
            state = !isNaN(parseFloat($(this).val())) && isFinite($(this).val());
        }

        if (state) {
            $addon.removeClass('danger');
            $addon.addClass('success');
            $icon.attr('class', 'glyphicon glyphicon-ok');
        } else {
            $addon.removeClass('success');
            $addon.addClass('danger');
            $icon.attr('class', 'glyphicon glyphicon-remove');
        }

        if ($form.find('.input-group-addon.danger').length == 0) {
            $form.find('[type="submit"]').prop('disabled', false);
        } else {
            $form.find('[type="submit"]').prop('disabled', true);
        }
    });

    //Active de Carousel
    $('#custom_carousel').on('slide.bs.carousel', function (evt) {
        $('#custom_carousel .controls li.active').removeClass('active');
        $('#custom_carousel .controls li:eq(' + $(evt.relatedTarget).index() + ')').addClass('active');
    });
    $('.input-group input[required], .input-group textarea[required], .input-group select[required]').trigger('change');

    //busqueda
    $('#input-search').on('keyup', function () {
        var rex = new RegExp($(this).val(), 'i');
        $('.searchable-container .items').hide();
        $('.searchable-container .items').filter(function () {
            return rex.test($(this).text());
        }).show();
    });

    //@TODO Barra lateral revisar
    var trigger = $('.hamburger'),
        overlay = $('.overlay'),
        isClosed = false;

    trigger.click(function () {
        hamburger_cross();
    });

    function hamburger_cross() {

        if (isClosed == true) {
            overlay.hide();
            trigger.removeClass('is-open');
            trigger.addClass('is-closed');
            isClosed = false;
        } else {
            overlay.show();
            trigger.removeClass('is-closed');
            trigger.addClass('is-open');
            isClosed = true;
        }
    }

    $('[data-toggle="offcanvas"]').click(function () {
        $('#wrapper').toggleClass('toggled');
    });
    $('.dropdown').on('show.bs.dropdown', function (e) {
        $(this).find('.dropdown-menu').first().stop(true, true).slideDown();
    });
    $('.dropdown').on('hide.bs.dropdown', function (e) {
        $(this).find('.dropdown-menu').first().stop(true, true).slideUp();
    });
    $('[data-toggle="tooltip"]').tooltip();
});
