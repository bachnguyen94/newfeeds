<div class="fashion_technology_area">
    <div class="fashion">
        <div class="single_post_content">
            <h2><span>Fashion</span></h2>
            <ul class="business_catgnav wow fadeInDown">
                <li>
                    <?php $firstFashion = array_shift($fashions) ?>
                    <figure class="bsbig_fig"> <a href="pages/single_page.html" class="featured_img"> <?= $this->Core->image($firstFashion, 'imageUrl',347,232);?> <span class="overlay"></span> </a>
                        <figcaption> <a href="pages/single_page.html"><?= h($firstFashion->title)?></a> </figcaption>
                        <p><?= h($firstFashion->description)?></p>
                    </figure>
                </li>
            </ul>
            <ul class="spost_nav">
                <?php foreach($fashions as $fashion):?>
                    <li>
                        <div class="media wow fadeInDown"> <a href="pages/single_page.html" class="media-left"> <?= $this->Core->image($fashion, 'imageUrl',90,70);?> </a>
                            <div class="media-body"> <a href="pages/single_page.html" class="catg_title"> <?= h($fashion->title)?></a> </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <div class="technology">
        <div class="single_post_content">
            <h2><span>Technology</span></h2>
            <ul class="business_catgnav">
                <li>
                    <?php $firstTechnology = array_shift($technologies) ?>
                    <figure class="bsbig_fig wow fadeInDown"> <a href="pages/single_page.html" class="featured_img"> <?= $this->Core->image($firstTechnology, 'imageUrl',347,232);?> <span class="overlay"></span> </a>
                        <figcaption> <a href="pages/single_page.html"><?= h($fashion->title)?></a> </figcaption>
                        <p><?= h($fashion->description)?></p>
                    </figure>
                </li>
            </ul>
            <ul class="spost_nav">
                <?php foreach($technologies as $technology):?>
                    <li>
                        <div class="media wow fadeInDown"> <a href="pages/single_page.html" class="media-left"> <?= $this->Core->image($technology, 'imageUrl',90,70);?> </a>
                            <div class="media-body"> <a href="pages/single_page.html" class="catg_title"> <?= h($technology->title)?></a> </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>