    
</div>

    <?php 
    // Footer style data
    $footer_bg = getConfigItem('footer_bg');
    if(empty($footer_bg)){$footer_bg = '#eee';}
    $footer_text = getConfigItem('footer_text');
    if(empty($footer_text)){$footer_text = '#666';}
    $a_hover = hex2rgba($footer_text, 0.8);

    // Set Template path
    $template_path = base_url().'assets/frontend/rocky/';
    ?>

    <style type="text/css">
        footer{
            background: <?php echo $footer_bg; ?>;
            color: <?php echo $footer_text; ?>;
        }
        .footer-text p,
        a ,
        .social-icon a{color: <?php echo $footer_text; ?>;}
        .social-icon a:hover{color: <?php echo $a_hover; ?>;}
    </style>
       <!-- START FOOTER SECTION -->
        <footer class="footer">
            <div class="container">
                <div class="row wow fadeInUp" data-wow-delay="0.4s">
                    <div class="col-md-12 text-center">
                        <!-- <div class="footer-text">
                            <p>&copy;2017 <strong>zwebtheme</strong>. All Rights Reserved</p>
                        </div>
                        <div class="social-icon">
                           <a href="#" title="facebook" target="_blank"><i class="fa fa-facebook"></i></a> <a href="#" title="twitter" target="_blank"><i class="fa fa-twitter"></i></a> <a href="#" title="google-plus" target="_blank"><i class="fa fa-google-plus"></i></a> <a href="#" title="linkedin" target="_blank"><i class="fa fa-linkedin"></i></a> </div> -->
                           <?php echo getConfigItem('footer'); ?>
                    </div>
                </div>
            </div>
        </footer>
        <!-- END FOOTER SECTION -->
    
    
    
        <script src="<?php echo $template_path; ?>js/wow.min.js"></script>
        <script src="<?php echo $template_path; ?>js/plugins.js"></script>
        <script src="<?php echo $template_path; ?>js/lightbox.js"></script>
        <script src="<?php echo $template_path; ?>js/mixitup.min.js"></script>
        <script src="<?php echo $template_path; ?>js/owl.carousel.min.js"></script>
        <script src="<?php echo $template_path; ?>js/jquery.waypoints.min.js"></script>

        <script src="<?php echo $template_path; ?>js/common.js"></script>
        <script src="<?php echo $template_path; ?>js/main.js"></script>
        
</body>

</html>