<?php
/**
 * The template for displaying the footer
 *
 * Contains the opening of the #site-footer div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

?>
			<!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="about_info">
                        <h3>About our platform</h3>
                        <?php dynamic_sidebar('footer-left'); ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="shortLink">
                        <h3>Short links</h3>
                        <?php dynamic_sidebar('footer-center'); ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="newsletter">
                        <h3>Newsletter</h3>
                        <p>Sign up for our newsletter and be informed of all the news in preview!</p>
                        <div class="newsletter_box">
                        	<?php echo do_shortcode ('[mailpoet_form id="1"]'); ?>
                            <!-- <input type="text" class="form-control" placeholder="Your Email Here">
                            <span><i class="fa fa-envelope"></i></span>
                            <input type="button" class="btn_submit" value="Submit"> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="copyright text-center">
                <p>Copyright © 2019 - Alright reserved by <b>OnTimeBee</b>. Design By: <b>CMO Agency</b></p>
            </div>
        </div>

    </footer>

    <script type="text/javascript">
       $(document).ready(function(){
        $(".content").slice(0,3).show();
        $("#seeMore").click(function(e){
          e.preventDefault();
          $(".content:hidden").slice(0,3).fadeIn("slow");
          
          if($(".content:hidden").length == 0){
             $("#seeMore").fadeOut("slow");
             $("#seeMoreNo").fadeIn("slow");
            }
        });
      });
    </script>

		<?php wp_footer(); ?>

	</body>
</html>
