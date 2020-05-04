<div id="carousel">
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <?php
                $categories = new Query('categories');
                $categories->preSelect("SELECT *")
                    ->paginate(8)
                    ->get();

                echo templateIterator($categories->rows, function() {
                    return '
                        <div class="swiper-slide" style="background-image: url(/uploads/{{image}})">
                            <div class="slide-details">
                                <div class="slide-text">
                                    {{name}}
                                </div>
                                <a href="byCategory.php?cat_id={{id}}" class="btn btn-primary mt-4">
                                    EXPLORE
                                </a>
                            </div>
                        </div>
                    ';
                });
            ?>
        </div>
        <div class="swiper-pagination"></div>
        <div class="slider-info">
            <!-- 1/2 -->
        </div>
        <div class="slider-navigation">
            <div class="slider-navigation-prev"></div>
            <div class="slider-navigation-next"></div>
        </div>
    </div>
</div>


<script>
    function initSlide() {
        infoEl = this.el.querySelector(".slider-info");
        infoEl.innerHTML = (this.activeIndex + 1) + " / " + this.slides.length;
    }
    if(document.querySelector("#carousel > .swiper-container")) {
        var swiper = new Swiper('#carousel > .swiper-container', {
            autoplay: {
                delay: 5000,
            },
            navigation: {
                nextEl: '.slider-navigation-next',
                prevEl: '.slider-navigation-prev',
            },
            pagination: {
                el: '.swiper-pagination',
                dynamicBullets: true,

            },
            on: {
                init: initSlide,
                slideChange: initSlide
            }
        });
    }
</script>