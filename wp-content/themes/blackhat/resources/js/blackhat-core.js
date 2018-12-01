var blackhat = window.blackhat || {};
var $ = jQuery.noConflict();
(function ($) {
    'use strict';

    blackhat.main.init = function () {
        blackhat.main.stickyHeader();
        blackhat.main.mobileMenu();
        blackhat.main.scrollTop();
        blackhat.main.scrollToElement();
    };

    blackhat.main.executeFunctionsQueue = function ( key, queue_array ) {
        // Remove and execute all items in the array
        while ( queue_array[key].length > 0) {
            ( queue_array[key].shift() )();
        }
    }

    blackhat.main.loadScript = function( id, url, callback ) {  

        // If external asset is already in DOM and loaded, we can execute the callback immediately
        if(typeof blackhat.assetsLoaded == 'undefined') {
            blackhat.assetsLoaded = [];
        }
        if(blackhat.assetsLoaded[id] === true) {
            callback();
            return;
        }
        
        if(typeof blackhat.functionsQueue == 'undefined') {
            blackhat.functionsQueue = [];
        }
        if(typeof blackhat.functionsQueue[id] == 'undefined') {
            blackhat.functionsQueue[id] = [];
        }
        blackhat.functionsQueue[id].push( callback );

        //Check if script exists. If not, create it, if yes, we have already added it in the queue and we're all
        var assetExists = document.getElementById( id );
        if( null == assetExists ) {
            // Adding the script tag to the head as suggested before
            var body = document.getElementsByTagName( 'body' )[0];
            var script = document.createElement( 'script' );
            script.type = 'text/javascript';
            script.src = url;
            script.id = id;

            // Then bind the event to the callback function.
            // There are several events for cross browser compatibility.
            script.onload = function() {
                blackhat.assetsLoaded[id] = true;
                blackhat.main.executeFunctionsQueue( id, blackhat.functionsQueue );
            }
            script.onreadystatechange = function() {
                blackhat.assetsLoaded[id] = true;
                blackhat.main.executeFunctionsQueue( id, blackhat.functionsQueue );
            }

            // Fire the loading
            body.appendChild( script );
        } 

    };

    blackhat.main.debounce = function(func, wait, immediate) {

        var timeout;
        return function() {
            var context = this, args = arguments;
            var later = function() {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            var callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };

    };
    blackhat.main.scrollToElement = function(){
        var header = $( '#header' ),
            body   = $( 'body' );

        $('.menu-item a, .button--hero').on('click', function(event) {
            var target = $(this).attr('href');
            //console.log(target);
            if(target.match("^#")){
                if( target.length ) {
                    event.preventDefault();
                    $('html, body').stop().animate({
                        scrollTop: $(''+target+'').offset().top - header.outerHeight()
                    }, 1000);
                    body.removeClass('menu-open');
                }
            }
        });
    };
    blackhat.main.scrollTop = function(){
        var scrollTop = $( '.scroll-to-top' ),
            wrapperHeight = $('#wrapper').height();
            //console.log(wrapperHeight / 2);

        var scrollTopShow = function() {
            if ( $( window ).scrollTop() > 500 ) {
                scrollTop.fadeIn();
            } else {
                scrollTop.fadeOut();
            }
        }
        $(window).load(function(){
            
            $(".scroll-to-top").on('click', function(e){ 
                e.preventDefault();
                $("html, body").animate({ scrollTop: "0px" }, 800, 'swing');
            });
            window.addEventListener('scroll', blackhat.main.debounce( scrollTopShow, 70 ));
        });

    };
    blackhat.main.stickyHeader = function() {

        var stickyHeader = function() {
            var header = $( '#header' ),
                footerHeight = $('#footer').outerHeight(),
                main = $('#main');

            if(!$('body').hasClass == 'home'){
                $( '#content' ).css( "margin-top", header.outerHeight() );
            }
            main.css('margin-bottom', footerHeight );

            if ( $( window ).scrollTop() > 25 ) {
                header.addClass( 'sticky' );
            } else {
                header.removeClass( 'sticky' );
            }
        }

        window.addEventListener('load', stickyHeader);
        window.addEventListener('scroll', blackhat.main.debounce( stickyHeader, 70 ));
        window.addEventListener('resize', blackhat.main.debounce( stickyHeader, 150 ));

    };
    
    blackhat.main.mobileMenu = function() {

        var respMenu = $( '.resp-menu' ),
            button   = $( '#js-resp-menu-toggle' ),
            body     = $( 'body' );

        button.click(function(e) {
            body.toggleClass('menu-open');
        });

        /* Sliding side menu, close on swipe */
        if ($().swipe) {
            respMenu.swipe({
                swipeRight: function(event, direction, distance, duration, fingerCount) {
                    body.removeClass('menu-open');
                },
                threshold: 20,
                excludedElements: ""
            });
            button.swipe({
                swipeLeft: function(event, direction, distance, duration, fingerCount) {
                    body.addClass('menu-open');
                },
                threshold: 20,
                excludedElements: ""
            });
        }

        /* Sliding side menu submenu */
        respMenu.find('.menu-item > a').click(function(e) {
            if ($(this).attr('href') == "#") {
                e.preventDefault();
                $('.sub-menu').not($(this).siblings()).slideUp(300);
                $(this).siblings('.sub-menu').slideToggle(300);
            }
        });

        /* Adding submenu arrows to the responsive navigation */
        respMenu.find('.sub-menu').each(function() {
            $(this).parent().append('<a class="submenu-button" href="javascript:void(0)"><svg class="arrow-down" width="15px" height="8px"><polygon fill="#fff" points="15.002,0 7.501,7.501 0,0 "></polygon></svg></a>');
        });

        $('.submenu-button').click(function() {
            $('.sub-menu').not($(this).siblings()).slideUp(300);
            $(this).prev('.sub-menu').slideToggle(100);
            $(this).toggleClass('rotate-arrow');
        });
    };

return blackhat.main.init();

}($));
