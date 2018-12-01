var blackhat = window.blackhat || {};
var $ = jQuery.noConflict();
(function ($) {
    'use strict';

    blackhat.main.initFunctions = function () {
        blackhat.main.onClickEvents();
    };

    blackhat.main.onClickEvents = function ( args ) {
        $( window ).load( function() {
            //put various on click functionalities here
        });
    };
    
    blackhat.main.accordion = function ( args ) {

        var defaults = {
            "blockId": "blackhat-accordion-1",
            "animationTime": 300,
        };

        var options = $.extend( defaults, args );

        // blackhat Accordion
        $( '#' + options.blockId + '' ).on( 'click', '.blackhat-accordion__panel', function () {
            if ( $( this ).hasClass( 'blackhat-accordion__panel--current' ) ) {
                $( this ).removeClass( 'blackhat-accordion__panel--current' ).find( '.blackhat-accordion__panel-content' ).slideUp( options.animationTime );
            } else {
                var currentAccordionPanel = $( '#' + options.blockId + ' .blackhat-accordion__panel--current' );
                if ( currentAccordionPanel.length > 0 ) {
                    currentAccordionPanel.removeClass( 'blackhat-accordion__panel--current' ).find( '.blackhat-accordion__panel-content' ).slideUp( options.animationTime );
                }
                $( this ).addClass( 'blackhat-accordion__panel--current' ).find( '.blackhat-accordion__panel-content' ).slideDown( options.animationTime );
            }
        });

    };
    blackhat.main.contactForm = function(){
        (function() {
            // trim polyfill : https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/Trim
            if (!String.prototype.trim) {
                (function() {
                    // Make sure we trim BOM and NBSP
                    var rtrim = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;
                    String.prototype.trim = function() {
                        return this.replace(rtrim, '');
                    };
                })();
            }
    
            [].slice.call( document.querySelectorAll( 'input.input__field' ) ).forEach( function( inputEl ) {
                // in case the input is already filled..
                if( inputEl.value.trim() !== '' ) {
                    classie.add( inputEl.parentNode, 'input--filled' );
                }
    
                // events:
                inputEl.addEventListener( 'focus', onInputFocus );
                inputEl.addEventListener( 'blur', onInputBlur );
            } );
    
            function onInputFocus( ev ) {
                classie.add( ev.target.parentNode, 'input--filled' );
            }
    
            function onInputBlur( ev ) {
                if( ev.target.value.trim() === '' ) {
                    classie.remove( ev.target.parentNode, 'input--filled' );
                }
            }
        })();
    }
    blackhat.main.appearAnimations = function() {
        $( window ).on( 'load', function() {
            function countProgress(){
                var counts = $('.skills__single-item--counter');
                counts.each(function () {  
                    $(this).prop('Counter', 0).animate({  
                        Counter: $(this).data('count')
                    }, {  
                        duration: 2000,  
                        easing: 'linear',  
                        step: function (now) {  
                            $(this).text(Math.ceil(now) + '%');  
                        },complete: function() {
                            $(this).text(this.Counter + '%').stop(true, true);
                        }
                    });  
                });
            }
            ( function( $ ) {
                $( '[data-appear-effect]' ).each( function() {
                    $( this ).waypoint( function( direction ) {				
                        var $element = $( this.element ),
                        options  = { 
                            effect: $element.data( 'appear-effect' ),
                            delay:  $element.data( 'appear-delay' )
                        };
                        
                        $element.addClass( options.effect );
        
                        if ( options.delay > 1 ) {
                            $element.css( 'animation-delay', options.delay + 'ms' );
                        }	
        
                        setTimeout( function() {
                            if($element.hasClass('animated')) { 
                                return true; 
                            }else {
                                $element.addClass( 'animated' );
                                if($($element).hasClass('skills__container')){
                                    countProgress();
                                }
                            }
                        }, options.delay );			
                    }, {
                        offset: '75%'
                    })
                });
            }).apply( this, [jQuery] );
        });
    };

    blackhat.main.contactAjax = function(args){
        var defaults = {
            "animationTime": 300,
            "requiredFields": [
                'full-name',
                'phone-number',
                'email',
            ]
        };
        var options = $.extend( defaults, args );

        $(window).load(function(){
            $( '#'+ options.formId +'' ).on( 'submit', function() {
                var form_data = $( this ).serializeArray();

                // Here we add our nonce
                form_data.push( { "name" : "security", "value" : blackhat.ajax_nonce } );
                /* var count = 0;
                $.each(options.requiredFields , function(index, val) { 
                    if($('#'+ val +'').val().length == 0) {
                        $('#'+ val +'').addClass('invalid');
                        count++;
                        //console.log(count);
                    }
                    else {
                        $('#'+ val +'').removeClass('invalid');
                    }
                    $('#'+ val +'').on('click', function(){
                        $('#'+ val +'').removeClass('invalid');
                    });
                });
                if(count > 0){
                    toastr.options.positionClass = "toast-top-center";
                    toastr.error(options.errorResponse);
                    return false;
                    
                }else {

                } */
                $.ajax({
                    url : blackhat.adminAjax, // Here goes our WordPress AJAX endpoint.
                    type : 'POST',
                    data : form_data,
                    dataType:   'json',
                    beforeSend: function () {
                        //is_sending = true;
                        // You could do an animation here...
                    },
                    success : function( response ) {
                        // You can craft something here to handle the message return
                        if (response.status === 'success') {
                            // Here, you could trigger a success message
                            document.getElementById(options.formId).reset();
    
                            toastr.options.positionClass = "toast-top-center";
                            toastr.success(response.status_data);
                            setTimeout(window.location = response.redirectPath, 2000);
                        }
                        if(response.status === 'error') {
                            toastr.options.positionClass = "toast-top-center";
                            toastr.error(response.status_data)
                            $('#'+ response.field +'').addClass('invalid');
                        }
                    },
                    fail : function( err ) {
                    // You can craft something here to handle an error if something goes wrong when doing the AJAX request.
                        alert( "There was an error: " + err );
                    }
                });
                return false;
            });
        });
        
    };

    blackhat.main.tabs = function( args ) {

        var defaults = {
			"animationTime": 300
        };

        var options = $.extend( defaults, args );

        // Set first tab active
        $( '#blackhat-tabs-' + options.blockId + ' .blackhat-tabs__title:first-child' ).addClass( 'blackhat-tabs__title--current' );
        $( '#blackhat-tabs-' + options.blockId + ' .blackhat-tabs__panel:first-child' ).addClass( 'blackhat-tabs__panel--current' );

        // Get current tab from URL
        var hash = $.trim( window.location.hash );
        var $blockId = hash.split( '-' );
        if ( hash ) {
            var $index = $( '#blackhat-tabs-' + $blockId[1] + ' .blackhat-tabs__link[href=' + hash + ']' ).parent().index();
            $( '#blackhat-tabs-' + $blockId[1] + ' .blackhat-tabs__title' ).removeClass( 'blackhat-tabs__title--current' );
            $( '#blackhat-tabs-' + $blockId[1] + ' .blackhat-tabs__panel' ).removeClass( 'blackhat-tabs__panel--current' );
            $( '#blackhat-tabs-' + $blockId[1] + ' .blackhat-tabs__link[href=' + hash + ']' ).parent().addClass( 'blackhat-tabs__title--current' );
            $( '#blackhat-tabs-' + $blockId[1] + ' .blackhat-tabs__panel' ).eq( $index ).addClass( 'blackhat-tabs__panel--current' );
        }
        
        // blackhat Tabs
        $( '#blackhat-tabs-' + options.blockId + '' ).on( 'click', '.blackhat-tabs__title', function () {
            var $that = $( this );
            if ( ! $( this ).hasClass( 'blackhat-tabs__title--current' ) ) {
                $( '#blackhat-tabs-' + options.blockId + ' .blackhat-tabs__title' ).removeClass( 'blackhat-tabs__title--current' );
                $( '#blackhat-tabs-' + options.blockId + ' .blackhat-tabs__panel' ).fadeOut( options.animationTime ).promise().done( function() {
                    $( '#blackhat-tabs-' + options.blockId + ' .blackhat-tabs__panel' ).removeClass( 'blackhat-tabs__panel--current' );
                    $( '#blackhat-tabs-' + options.blockId + ' .blackhat-tabs__panels' )
                    .children( '.blackhat-tabs__panel' )
                    .eq( $that.index() )
                    .fadeIn( options.animationTime )
                    .addClass( 'blackhat-tabs__panel--current' );
                } );

                $( this ).addClass( 'blackhat-tabs__title--current' );
            }
        });  
    };

    blackhat.main.slickSlider = function ( args ) {

        var defaults = {};

        var options = $.extend( defaults, args );

        $( window ).load( function() {
            $( '#' + options.blockId + '' ).slick( options.options );
        });
        
    };
    blackhat.main.fancyBox = function(args) {
        var defaults = {
            "loop" : true,
            "buttons" : true,
            "closeBtn"   : true,
        };

        var options = $.extend( defaults );

        $("[data-fancybox]").fancybox(options.options);
        $(".fancybox").fancybox(options.options);

    };
    blackhat.main.googleMap = function ( args ) {

        var defaults = {
            "zoom": 15,
            "scrollwheel": false,
			"draggable": false
        };

        var options = $.extend( defaults, args );

        $( window ).load( function() {

            var map = new google.maps.Map( document.getElementById( options.blockId ), {
                zoom: options.zoom,
                scrollwheel: options.scrollwheel,
			    draggable: options.draggable,
                center: new google.maps.LatLng( options.lat, options.lng ),
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });

            var infowindow = new google.maps.InfoWindow({ maxWidth: 350 });

            var marker = new google.maps.Marker({
                position: new google.maps.LatLng( options.lat, options.lng ),
                map: map
            });

            google.maps.event.addListener( marker, 'click', ( function( marker ) {
                return function() {
                    infowindow.setContent('<p class="blackhat-map__info">' + options.address + '</p>');
                    infowindow.open( map, marker );
                }
            })( marker ));

        });

    };

    return blackhat.main.initFunctions();

}($));
