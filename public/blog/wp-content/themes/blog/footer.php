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
                  <h3>A propos</h3>
                  <p>Beontime est une entreprise familiale de sécurité et gardiennage, qui se repose sur 20 ans expérience, titulaire d’un agrément CNAPS.&nbsp;Nous agissons 24h/24h et 7j/7j. Nous répondons à vos besoins dans les plus brefs délais et la mise en place d’agents en 1h sur toute le France, agissons pour différents types d’événements : gardiennage, événementiel, sûreté de la personne et de locaux, Nous disposons d’agents ADS, maitre-chien, SSIAP 1,2 et 3, garde du corps, ainsi que des hôtesses d’accueil.</p>   
              </div>
             </div>
             <div class="col-md-4">
              <div class="shortLink">
                  <h3>Liens</h3>
                  <ul>
                      <li><a href="<?php echo APP_URL; ?>/contact-us"><i class="fa fa-share" aria-hidden="true"></i> Nous contacter</a></li>
                      <li><a href="<?php echo APP_URL; ?>/available-agents"><i class="fa fa-share" aria-hidden="true"></i> Agents disponibles sur la carte</a></li>
                  </ul> 
                  <div class="social_sprite">
                      <a class="facebook" href="#"></a>
                      <a class="google" href="#"></a>
                      <a class="twitter" href="#"></a>
                      <a class="instagram" href="#"></a>
                  </div>
              </div>
             </div>
             <div class="col-md-4">
              <div class="newsletter">
                  <h3>Newsletter</h3>
                  <p>Laissez nous votre email afin de recevoir notre newsletter et être informés des nouveautés</p>   
                  <div class="newsletter_box">
                      <input type="text" class="form-control" placeholder="Votre email">
                      <span><i class="fa fa-envelope"></i></span>
                      <input type="button" class="btn_submit" value="Submit">
                  </div>
              </div>
             </div>
            </div>
            <div class="copyright text-center">
                <p>Copyright © 2020 - Alright reserved by <b>Be On Time</b>. Design &amp; Develop By <b><a class="" href="https://www.cmo-agency.com/">CMO Agency</a></b></p>
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
