document.addEventListener( 'DOMContentLoaded', function () {
    new Splide( '#card-slider', {
        type   : 'loop',
        speed: 2000,
        pagination:true,
        wheel: true,
        autoplay: true,
        interval: 4000,
        autoWidth: true,
    } ).mount();
  } );

  document.addEventListener( 'DOMContentLoaded', function () {
    new Splide( '#assortiment-slider', {
        type   : 'loop',
        speed: 2000,
        pagination:true,
        wheel: true,
        autoplay: true,
        interval: 4000,
        autoWidth: true,
    } ).mount();
  } );

  document.addEventListener( 'DOMContentLoaded', function () {
    var main = new Splide( '#main-slider', {
      type      : 'fade',
      rewind    : true,
      pagination: false,
      arrows    : false,
    } );
  
    var thumbnails = new Splide( '#thumbnail-slider', {
        fixedWidth : 70,
        fixedHeight: 100,
        gap        : 10,
        arrows: false,
        rewind     : true,
        pagination : false,
        cover      : true,
        isNavigation: true,
        breakpoints : {
            600: {
            fixedWidth : 60,
            fixedHeight: 44,
            },
        },
    } );
  
    main.sync( thumbnails );
    main.mount();
    thumbnails.mount();
  } );