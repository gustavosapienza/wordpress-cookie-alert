<?php
/*
Plugin Name: Aviso Cookie
Plugin URI: https://wordpress.org/plugins/aviso-cookie
Description: Texto de aviso de cookies
Version: 1.1
Author: Gustavo Sapienza
Author URI: http://gustavosapienza.com.br
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/




//Theme Options
function add_cookie_menu_item()
{
  add_menu_page("Aviso cookies", "Aviso cookies", "manage_options", "theme-panel-cookies", "theme_settings_cookie_page", null, 99);
}

add_action("admin_menu", "add_cookie_menu_item");


function theme_settings_cookie_page()
{
    ?>
      <div class="wrap">
      <h1>Aviso cookies</h1>
      <form method="post" action="options.php">
          <?php
              settings_fields("section_cookie");
              do_settings_sections("theme-options-cookies");      
              submit_button(); 
          ?>          
      </form>
    </div>
  <?php
}

function display_texto_cookie_element()
{
  ?>
      <h2>Texto Cookie</h2>
      <textarea name="texto_cookie" id="texto_cookie" style="width:100%; height: 200px" placeholder="Meu texto de cookie"><?php echo get_option('texto_cookie'); ?></textarea>
      <h3>Hexadecimal retícula</h3>
      <input name="hexa_cor" id="hexa_cor" style="border:0;" value="<?php echo get_option('hexa_cor'); ?>" placeholder="#000000">
      <h3>Opacidade</h3>
      <input name="opacidade" id="opacidade" style="border:0;" value="<?php echo get_option('opacidade'); ?>" placeholder="0.9">
    <?php
}


function display_theme_cookies_fields()
{
  add_settings_section("section_cookie", "Todas configurações", null, "theme-options-cookies");

    add_settings_field("texto_cookie", "texto_cookie", "display_texto_cookie_element", "theme-options-cookies", "section_cookie");

    register_setting("section_cookie", "texto_cookie");
    register_setting("section_cookie", "hexa_cor");
    register_setting("section_cookie", "opacidade");
}

add_action("admin_init", "display_theme_cookies_fields");



function aviso_cookies() {
?>
<div class="cookie_container" style="display:none">
<div class="cookie_flutuante">
  <?php echo get_option('texto_cookie'); ?>
  <button class="aceito">Aceito</button>
</div>
</div>

<script>
jQuery(document).ready(function($){
    if(localStorage.getItem("aceito") != "aceito"){
      $(".cookie_container").fadeIn()
    }
    $(document).on("click",".aceito",function(){
      $(".cookie_container").fadeOut()
      localStorage.setItem("aceito","aceito");
    });
});
</script>

<style>

  
.cookie_container {
    width: 100%;
    z-index: 10000;
    background-color: <?php echo get_option('hexa_cor'); ?>;
    position: fixed;
    bottom: 0;
    opacity: <?php echo get_option('opacidade'); ?>;
}

.cookie_flutuante {
    color: #fff;
    bottom: 0;
    font-size: 16px;
    width: 90%;
    margin-bottom: 10px;
    line-height: 31px;
    text-align: center;
    margin: 50px auto;
}
  
.cookie_flutuante button {
  cursor: pointer;
}
</style>

<?php
}

add_action('wp_head','aviso_cookies');


?>