let rutaBase = base_url() + "Contabilidad/CuentaMovimientos/";

$(function () {

    correrTodo();

    $('.expand-icon').on('click', function (e) {
        e.preventDefault();
        toggleAccountGroup($(this));
    });

    $('.account-row').hover(
        function () {
            $(this).addClass('table-active');
        },
        function () {
            $(this).removeClass('table-active');
        }
    );

    $("#exapandAll").on('click', function () {
        correrTodo(true);
    })

    $("#collapseAll").on('click', function () {
        correrTodo();
    })

    $("#btnFiltros").on('click', function () {
        $("#modalFiltros").modal('show');
    });

    $("#formFiltros").on('submit', function (e) {
        e.preventDefault();

        if (moment($("#fechaIni").val()).isAfter($("#fechaFin").val())) {
            return alertify.warning("La fecha inicial es mayor a la fecha final");
        }

        location.href = `${rutaBase}${$("#fechaIni").val()}/${$("#fechaFin").val()}`;
    });

    $("#reiniciarFiltros").on('click', function (e) {
        location.href = rutaBase;
    });

});

function correrTodo(all = false) {
    $('.cuenta-padre').each(function () {
        let icon = $(this).find('td i');
        toggleAccountGroup(icon, all);
    })
}

function toggleAccountGroup(icon, all = false) {
    const target = icon.data('target');
    const isExpanded = icon.hasClass('expanded');

    if (isExpanded) {
        collapseGroup(icon, target);
    } else {
        expandGroup(icon, target, all);
    }
}

function expandGroup(icon, target, all = false) {
    icon.removeClass('fa-plus').addClass('fa-minus expanded');
    $('.collapsible.' + target).show();

    $('.collapsible.' + target).each(function (index) {
        $(this).delay(index * 50).fadeIn(200);

        if (all) {
            let icon = $(this).find('td i');
            expandGroup(icon, icon.data('target'), all);
        }
    });
}

function collapseGroup(icon, target) {
    icon.removeClass('fa-minus expanded').addClass('fa-plus');

    $('.collapsible.' + target + ' .expand-icon.expanded').each(function () {
        const childTarget = $(this).data('target');
        collapseGroup($(this), childTarget);
    });

    $('.collapsible.' + target).fadeOut(200);
}
