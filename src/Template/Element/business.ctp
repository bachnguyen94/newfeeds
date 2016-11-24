<div class="single_post_content">
    <h2><span>Business</span></h2>
    <div class="single_post_content_left">
        <ul class="business_catgnav  wow fadeInDown">
            <li>
                <?php $firstBusiness = array_shift($businesses) ?>
                <figure class="bsbig_fig"> <a href="pages/single_page.html" class="featured_img"> <?= $this->Core->image($firstBusiness, 'imageUrl',347,232);?> <span class="overlay"></span> </a>
                    <figcaption> <a href="pages/single_page.html"><?= h($firstBusiness->title)?></a> </figcaption>
                    <p><?= h($firstBusiness->description)?></p>
                </figure>
            </li>
        </ul>
    </div>
    <div class="single_post_content_right">
        <ul class="spost_nav">
            <?php foreach($businesses as $business):?>
                <li>
                    <div class="media wow fadeInDown"> <a href="pages/single_page.html" class="media-left"> <?= $this->Core->image($business, 'imageUrl',72,72);?> </a>
                        <div class="media-body"> <a href="pages/single_page.html" class="catg_title"> <?= h($business->title)?></a> </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>