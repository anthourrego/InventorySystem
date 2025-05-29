let rutaBase = base_url() + "Contabilidad/CuentaMovimientos/";

$(function () {
    // Inicializar estado de expansión
    initializeExpandedState();

    // Manejar clicks en iconos de expansión
    $('.expand-icon').on('click', function (e) {
        e.preventDefault();
        toggleAccountGroup($(this));
    });

    // Hover effects
    $('.account-row').hover(
        function () {
            $(this).addClass('table-active');
        },
        function () {
            $(this).removeClass('table-active');
        }
    );

    function initializeExpandedState() {
        // Expandir por defecto algunos grupos
        const defaultExpanded = ['activos', 'activos-corrientes', 'efectivo', 'caja'];

        defaultExpanded.forEach(function (target) {
            const icon = $('.expand-icon[data-target="' + target + '"]');
            if (icon.length) {
                expandGroup(icon, target);
            }
        });
    }

    function toggleAccountGroup(icon) {
        const target = icon.data('target');
        const isExpanded = icon.hasClass('expanded');

        if (isExpanded) {
            collapseGroup(icon, target);
        } else {
            expandGroup(icon, target);
        }
    }

});

function expandGroup(icon, target) {
    icon.removeClass('fa-plus').addClass('fa-minus expanded');
    $('.collapsible.' + target).show();

    // Animar la aparición
    $('.collapsible.' + target).each(function (index) {
        $(this).delay(index * 50).fadeIn(200);
    });
}

function collapseGroup(icon, target) {
    icon.removeClass('fa-minus expanded').addClass('fa-plus');

    // Colapsar grupos hijos primero
    $('.collapsible.' + target + ' .expand-icon.expanded').each(function () {
        const childTarget = $(this).data('target');
        debugger
        collapseGroup($(this), childTarget);
    });

    // Ocultar el grupo
    $('.collapsible.' + target).fadeOut(200);
}
