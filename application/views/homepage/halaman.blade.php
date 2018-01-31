@layout('_layout/homepage/index')
@section('title') Beranda@endsection

@section('styles')
<link href="{{ base_url('assets/css/product-details-5.css') }}" rel="stylesheet">

<!-- gall-item Gallery for gallery page -->
<link href="{{ base_url('assets/plugins/magnific/magnific-popup.css') }}" rel="stylesheet">


<!-- bxSlider CSS file -->
<link href="{{ base_url('assets/plugins/bxslider/jquery.bxslider.css') }}" rel="stylesheet"/>

<style type="text/css">
    .bxslider.product-view-slides li img{
        width: 600px;height: 600px;object-fit: cover; object-position: center;
    }
</style>

@endsection

@section('content')
<div class="row transitionfx">
<div class="col-md-12">
    <h1 class="text-center">{{ $page->name }}</h1>
    <div style="margin-top: 40px;">{{ $page->content }}</div>
</div>

</div>
<!--/.row-->

</div>


<div style="clear:both"></div>
@endsection

@section('scripts')
<script src='{{ base_url('assets/homepage/assets/js/jquery.zoom.js') }}'></script>
<script>
    $(document).ready(function () {
        //$('.swipebox').zoom();

        $('#zoomContent').zoom();
        $(".zoomThumb a").click(function () {
            var largeImage = $(this).find("img").attr('data-large');
            $(".zoomImage1").attr('src', largeImage);
            $(".zoomImg").attr('src', largeImage);
            $(".gall-item").attr('href', largeImage);

        });

        $('.productImageZoomx').magnificPopup({
            delegate: 'img', type: 'image', gallery: {enabled: true},

            callbacks: {
                elementParse: function () {
                    this.item.src = this.item.el.attr('src');
                }
            }

        });


        $('.gall-item').magnificPopup({
            type: 'image',
            gallery: {
                enabled: true
            }
        });

        $("#zoomContent").click(function () {
            //alert();
            $('.gall-item').trigger('click');
        });

        // CHANGE IMAGE MODAL THUMB

        $(".product-thumbList a").click(function () {
            var largeImage = $(this).find("img").attr('data-large');
            $(".mainImg").attr('src', largeImage);

        });

    });
</script>

<script src="{{ base_url('assets/homepage/assets/plugins/magnific/jquery.magnific-popup.min.js') }}"></script>

<script src="{{ base_url('assets/homepage/assets/plugins/rating/bootstrap-rating.min.js') }}"></script>

<!-- bxSlider Javascript file -->
<script src="{{ base_url('assets/plugins/bxslider/plugins/jquery.fitvids.js') }}"></script>
<script src="{{ base_url('assets/plugins/bxslider/jquery.bxslider.min.js') }}"></script>


<script>
    $(document).ready(function () {

        var $$mainImgSliderPager = $('#bx-pager');

        // Slider
        var $mainImgSlider = $('.bxslider').bxSlider({
            pagerCustom: '#bx-pager',
            video: true,
            useCSS: false,
            mode: 'fade',
            controls: false
        });

        // initiates responsive slide
        var settings = function () {
            var mobileSettings = {
                slideWidth: 60,
                minSlides: 2,
                maxSlides: 3,
                slideMargin: 10,
                controls: false

            };
            var pcSettings = {
                mode: 'vertical',
                minSlides: 3,
                pager: false,
                slideMargin: 10,
                nextSelector: '.product-view-thumb-nav.next',
                prevSelector: '.product-view-thumb-nav.prev',
                nextText: ' <i class="fa fa-angle-down"></i>',
                prevText: ' <i class="fa fa-angle-up"></i>'
            };
            return ($(window).width() < 768) ? mobileSettings : pcSettings;
        }

        var thumbSlider;

        function tourLandingScript() {
            thumbSlider.reloadSlider(settings());
        }

        thumbSlider = $('.has-carousel-v .product-view-thumb').bxSlider(settings());
        $(window).resize(tourLandingScript);

    });

</script>


<script>
    $(function () {

        $('.rating-tooltip-manual').rating({
            extendSymbol: function () {
                var title;
                $(this).tooltip({
                    container: 'body',
                    placement: 'bottom',
                    trigger: 'manual',
                    title: function () {
                        return title;
                    }
                });
                $(this).on('rating.rateenter', function (e, rate) {
                    title = rate;
                    $(this).tooltip('show');
                })
                .on('rating.rateleave', function () {
                    $(this).tooltip('hide');
                });
            }
        });

    });
</script>

<script type="text/javascript" src="{{base_url('assets/js/skrollr.min.js')}}"></script>
<script type="text/javascript">
    var isMobile = function () {
        //console.log("Navigator: " + navigator.userAgent);
        return /(iphone|ipod|ipad|android|blackberry|windows ce|palm|symbian)/i.test(navigator.userAgent);
    };

    if (isMobile()) {
        // For  mobile , ipad, tab

    } else {

        if ($(window).width() < 768) {
        } else {
            var s = skrollr.init({forceHeight: false});
        }

    }


</script>


@endsection