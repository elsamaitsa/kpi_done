<div class="content-w100">
    <!--<img src="<?php echo base_url();?>assets/images/banner.jpg" class="img-page1">-->
    <img src="https://tokoperhutani.com/assets/images/banner.jpg" class="img-page1">
    <?php
	foreach($detil_article as $dataArticle) { 
	?>
    <div class="div-title-page">
        <h2 class="text-uppercase font-weight-bold text-white"><?php echo $dataArticle->title; ?></h2>
        <small  class='pull-left' style="padding-top:5px;"><?php echo $dataArticle->tanggal.$dataArticle->jam; ?></small><br>
    </div>
    <div class="container container-row">
        <div class="card-content">
            <div style="line-height:2.0em; font-size:13px;">
                <?php echo    str_replace('../','../../../',$dataArticle->isi_article); ?>
            </div>
        </div>
    </div>
    <?php
	}
	?>
</div>