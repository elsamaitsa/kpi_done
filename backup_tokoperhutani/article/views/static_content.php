<div class="content-w100">
    <!-- <img src="<?php echo base_url();?>assets/images/banner.jpg" class="img-page1"> -->
    <img src="<?php echo base_url(); ?>assets/images/banner.svg" class="img-set">
    <?php
    foreach($detil_article as $dataArticle) { 
        if($dataArticle->title=="CONTACT CENTER CALL 1500-235 "){ ?>
    <div class="div-title-page">
        <h2 class="text-uppercase font-weight-bold text-white">Contact Center Call 1500-235</h2>
    </div>
    <div class="container container-row">
        <div class="card-content text-center" style="padding:35px 150px">
            <div class="mySlides">
                <div class="numbertext">1 /2</div>
                <img src="<?php echo base_url(); ?>article/static/gambar_kantor2.jpg"
                    style="width:50%">
            </div>

            <div class="mySlides">
                <div class="numbertext">2 / 2</div>
                <img src="<?php echo base_url(); ?>article/static/gambar_kantor.jpg"
                    style="width:50%">
            </div>

            <a class="prev" onclick="plusSlides(-1)">❮</a>
            <a class="next" onclick="plusSlides(1)">❯</a>


            <div class="row1 mt-1 mb-3">
                <div class="column1" style="margin-left: 35%;">
                    <img class="demo cursor"
                        src="<?php echo base_url(); ?>article/static/gambar_kantor2.jpg"
                        style="width:50%" onclick="currentSlide(1)">
                </div>
                <div class="column1">
                    <img class="demo cursor"
                        src="<?php echo base_url(); ?>article/static/gambar_kantor3.jpg"
                        style="width:50%" onclick="currentSlide(2)">
                </div>

            </div>

            <h5 class="float-right">1500-235</h5>
            <h5 class="text-muted text-left">Telepon</h5>
            <hr style="margin:10px 0px;">

            <h5 class="float-right">62811-910-235</h5>
            <h5 class="text-muted text-left">Whatsapp</h5>
            <hr style="margin:10px 0px;">
            
            <h5 class="float-right">contact.center@perhutani.com</h5>
            <h5 class="text-muted text-left">Email</h5>
            <hr style="margin:10px 0px;">

            <h5 class="float-right">https://facebook.com/TokoPerhutaniID/</h5>
            <h5 class="text-muted text-left">Facebook</h5>
            <hr style="margin:10px 0px;">

            <h5 class="float-right">https://twitter.com/tokoperhutani</h5>
            <h5 class="text-muted text-left">Twitter</h5>
            <hr style="margin:10px 0px;">

            <h5 class="float-right">http://instagram.com/tokoperhutani</h5>
            <h5 class="text-muted text-left">Instagram</h5>
            <hr style="margin:10px 0px;">
        </div>
    </div>
    <?php }else{ ?>
    <div class="div-title-page">
        <h2 class="text-uppercase font-weight-bold text-white"><?php echo $dataArticle->title; ?></h2>
        <small  class='pull-left' style="padding-top:5px;"><?php echo $dataArticle->tanggal."<br>".$dataArticle->jam; ?></small><br>
    </div>
    <div class="container container-row">
        <div class="card-content">
            <div style="line-height:2.0em; font-size:13px;">
                <?php echo    str_replace('../','../../../pht/',$dataArticle->isi_article); ?>
            </div>
            <?php
                if($dataArticle->document != ""){
                    echo "<a  href='".base_url()."upload/file_article/dokumen/".$dataArticle->document."' style='width:50%;' alt=''>Download Document</a>";
                }else{
                    echo "";
                }
            ?>
        </div>
    </div>

    <?php }} ?>
</div>

<script>
    var slideIndex = 1;
    showSlides(slideIndex);

    function plusSlides(n) {
        showSlides(slideIndex += n);
    }

    function currentSlide(n) {
        showSlides(slideIndex = n);
    }

    function showSlides(n) {
        var i;
        var slides = document.getElementsByClassName("mySlides");
        var dots = document.getElementsByClassName("demo");
        var captionText = document.getElementById("caption");
        if (n > slides.length) {
            slideIndex = 1
        }
        if (n < 1) {
            slideIndex = slides.length
        }
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        slides[slideIndex - 1].style.display = "block";
        dots[slideIndex - 1].className += " active";
        // captionText.innerHTML = dots[slideIndex - 1].alt;
    }
</script>