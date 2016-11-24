<div class="single_post_content">
    <h2><span>Photography</span></h2>
    <ul class="photograph_nav  wow fadeInDown">
        <?php foreach($photographies as $photography):?>
            <li>
                <div class="photo_grid">
                    <figure class="effect-layla"> <a class="fancybox-buttons" data-fancybox-group="button" href="images/photograph_img2.jpg" title="Photography Ttile 1"> <?= $this->Core->image($photography, 'imageUrl',281,390);?> </figure>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>