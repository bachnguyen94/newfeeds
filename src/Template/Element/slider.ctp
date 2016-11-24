<section id="sliderSection">
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8">
            <div class="slick_slider">
                <?php $i =0; foreach ($slide_entities as $slide_entity): ?>
                    <div class="single_iteam"> <a href="#"><?= $this->Core->image(${'record'.$i},'imageUrl',710,448);?></a>
                        <div class="slider_article">
                            <h2><a class="slider_tittle" href="pages/single_page.html"><?= h(${'record'.$i}->title) ?></a></h2>
                            <p><?= h($slide_entity->description) ?></p>
                        </div>
                    </div>
                <?php $i++; endforeach; ?>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4">
            <div class="latest_post">
                <h2><span>Latest post</span></h2>
                <div class="latest_post_container">
                    <div id="prev-button"><i class="fa fa-chevron-up"></i></div>
                    <ul class="latest_postnav">
                        <?php foreach ($lastestposts as $lastestpost): ?>
                        <li>
                            <div class="media"> <a href="pages/single_page.html" class="media-left"><?= $this->Core->image($lastestpost,'imageUrl',90,70);?></a>
                                <div class="media-body"> <a href="pages/single_page.html" class="catg_title"><?= h($lastestpost->title) ?></a> </div>
                            </div>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <div id="next-button"><i class="fa  fa-chevron-down"></i></div>
                </div>
            </div>
        </div>
    </div>
</section>