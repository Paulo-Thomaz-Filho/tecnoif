$(document).ready(function() {
        // 1. Efeito de Fundo com Blur na Navbar
        $(window).scroll(function() {
            if ($(this).scrollTop() > 50) { // Se rolar mais de 50px
                $('.navbar').addClass('scrolled');
            } else {
                $('.navbar').removeClass('scrolled');
            }
        });

        // 2. Spy Scroll para Linha Ativa
        var sections = $('main');
        var nav = $('.navbar-nav');
        var nav_height = nav.outerHeight();

        $(window).on('scroll', function () {
            var cur_pos = $(this).scrollTop();
            
            sections.each(function() {
                var top = $(this).offset().top - nav_height,
                    bottom = top + $(this).outerHeight();
                
                if (cur_pos >= top && cur_pos <= bottom) {
                    nav.find('a').removeClass('active-spy');
                    sections.removeClass('active-spy');
                    
                    $(this).addClass('active-spy');
                    nav.find('a[href="#' + $(this).find('div[id]').attr('id') + '"]').addClass('active-spy');
                }
            });

            // Condição especial para a primeira seção (main-inicio)
            if (cur_pos < $('#sobre-nos').offset().top - nav_height) {
                nav.find('a').removeClass('active-spy');
            }
        });
    });