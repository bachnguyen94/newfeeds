<div class="single_post_content">
    <h2><span>Games</span></h2>
    <div class="single_post_content_left">
        <ul class="business_catgnav">
            <li>
                <?php $firstGame = array_shift($games) ?>
                <figure class="bsbig_fig  wow fadeInDown"> <a class="featured_img" href="pages/single_page.html"> <?= $this->Core->image($firstGame, 'imageUrl',347,232);?> <span class="overlay"></span> </a>
                    <figcaption> <a href="pages/single_page.html"><?= h($firstGame->title)?></a> </figcaption>
                    <p><?= h($firstGame->description)?></p>
                </figure>
            </li>
        </ul>
    </div>
    <div class="single_post_content_right">
        <ul class="spost_nav">
            <?php foreach($games as $game):?>
                <li>
                    <div class="media wow fadeInDown"> <a href="pages/single_page.html" class="media-left"> <?= $this->Core->image($game, 'imageUrl',72,72);?> </a>
                        <div class="media-body"> <a href="pages/single_page.html" class="catg_title"> <?= h($game->title)?></a> </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>