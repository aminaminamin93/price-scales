$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});



$(document).ready(function($){

    // jQuery sticky Menu

    $(".mainmenu-area").sticky({topSpacing:0});

    $('.product-carousel').owlCarousel({
        loop:true,
        nav:true,
        margin:20,
        responsiveClass:true,
        responsive:{
            0:{
                items:1,
            },
            600:{
                items:3,
            },
            1000:{
                items:5,
            }
        }
    });

    $('.related-products-carousel').owlCarousel({
        loop:true,
        nav:true,
        margin:20,
        responsiveClass:true,
        responsive:{
            0:{
                items:1,
            },
            600:{
                items:2,
            },
            1000:{
                items:2,
            },
            1200:{
                items:3,
            }
        }
    });

    $('.brand-list').owlCarousel({
        loop:true,
        nav:true,
        margin:20,
        responsiveClass:true,
        responsive:{
            0:{
                items:1,
            },
            600:{
                items:3,
            },
            1000:{
                items:4,
            }
        }
    });


    // Bootstrap Mobile Menu fix
    $(".navbar-nav li a").click(function(){
        $(".navbar-collapse").removeClass('in');
    });

    // jQuery Scroll effect
    // $('.navbar-nav li a, .scroll-to-up').bind('click', function(event) {
    //     var $anchor = $(this);
    //     var headerH = $('.header-area').outerHeight();
    //     $('html, body').stop().animate({
    //         scrollTop : $($anchor.attr('href')).offset().top - headerH + "px"
    //     }, 1200, 'easeInOutExpo');
    //
    //     event.preventDefault();
    // });

    // Bootstrap ScrollPSY
    $('body').scrollspy({
        target: '.navbar-collapse',
        offset: 95
    })

//user default layouts



        $(".li-category").click(function () {
            $('.view-category').toggle();
            $('.view-brand').hide();

        });
        $(".li-brand").click(function () {
            $('.view-brand').toggle();
            $('.view-category').hide();
        });

        if ($('#action-message').is(':visible')) {
          setTimeout(function(){
            $("#action-message").slideToggle(2000);
          }, 4000);

        }

        $('#search-btn').click(function(){
            // var css = $('.search-form').toggle('display');
            $('.search-form').toggle('slow');


        });
        //ajax search product
        $('#search-product').click(function(){
             $('.search-form').hide('slow');
            var search = $('input[name=search]').val();
            var brand = $('#brand').val();
            var category = $('#category').val();
            var price_range = $('input[name=price_range]').val();
            var more_than = $('input[name=more_than]').val();
            var condition = $('#condition').val();

            $.ajax({
                url: '/product/form/search',
                type: 'POST',
                data: { search : search,
                        brand : brand,
                        category : category,
                        price : price_range,
                        more_than : more_than,
                        condition : condition,
                        _token : $('input[name=_token]').val()
                },
                success: function(response)
                {
                    $('.content').html(response);

                }
            });
//






        });





    // $(function() {
    //     $( "#slider-range" ).slider({
    //         range: true,
    //         min: 0,
    //         max: 500,
    //         values: [ 75, 300 ],
    //         slide: function( event, ui ) {
    //             $( "#amount" ).val( "RM" + ui.values[ 0 ] + " - RM" + ui.values[ 1 ] );
    //         }
    //     });
    //     $( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
    //         " - $" + $( "#slider-range" ).slider( "values", 1 ) );
    // });
    //
    //
    // $("#Slider2").slider({ dimension: '&nbsp;MYR', from: 0, to: 10000, step: 1 ,skin: "plastic" });
});

// $(document).on('click', '.pagination a', function(e){
//     e.preventDefault();
//
//     var page = $(this).attr('href').split('page=')[1];
//
//     getProducts(page);
//      $('html, body').animate({
//         scrollTop: $('.container').offset().top
//     }, 'fast');
// });

function getProducts(page){

  var search_data = $('input[name=data-search]').val();
  console.log('getting products for page = ' + page +"---|"+ search_data);
  $.ajax({
    url: '/product/form/search?page='+ page,
    type: 'GET',
    data: {
      search : search_data
    },

  }).done(function(data){
     $('.content').html(data);
  });
}
