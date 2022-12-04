<?php
/*
Plugin Name: Google Calendar Events wp
Plugin URI: https://github.com/digiraldo
Description: Eventos de Calendario de Google para tu Web, Muestra el calendario de Google como eventos dentro de una seccion de tu pagina web.
Version: 1.1.0
Author: digiraldo
Author URI: https://digiraldo.online/
Text Domain: google-calendar-events-wp
*/
/*  Copyright 2022 digiraldo

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
/* function borrar(){}
register_uninstall_hook( __FILE__, 'borrar'); */



function activarCal(){
    global $wpdb;

	$sqlFondoConf ="CREATE TABLE IF NOT EXISTS {$wpdb->prefix}evento_fondo_conf(
		`id_fondo` INT NOT NULL,
		`api_key` VARCHAR(80) NOT NULL,
		`id_cal` VARCHAR(80) NOT NULL,
		`color_fondo` VARCHAR(10) NOT NULL,
		`color_bag_fec` VARCHAR(10) NOT NULL,
		`color_por_fec` VARCHAR(10) NOT NULL,
		`color_txt_fec` VARCHAR(10) NOT NULL,
		`color_bag_des` VARCHAR(10) NOT NULL,
		`color_por_des` VARCHAR(10) NOT NULL,
		`color_txt_tit` VARCHAR(10) NOT NULL,
		`color_txt_des` VARCHAR(10) NOT NULL,
		`color_bag_bot` VARCHAR(10) NOT NULL,
		`color_por_bot` VARCHAR(10) NOT NULL,
		`color_fon_btn` VARCHAR(10) NOT NULL,
		`color_tex_btn` VARCHAR(10) NOT NULL,
		PRIMARY KEY (`id_fondo`)
	)";

	$wpdb->query($sqlFondoConf);
	

	$dataFondoConf = "INSERT INTO {$wpdb->prefix}evento_fondo_conf (`id_fondo`, `api_key`, `id_cal`, `color_fondo`, `color_bag_fec`, `color_por_fec`, `color_txt_fec`, `color_bag_des`, `color_por_des`, `color_txt_tit`, `color_txt_des`, `color_bag_bot`, `color_por_bot`, `color_fon_btn`, `color_tex_btn`) VALUES
	(0, '', '', '#151719', '#3B3B3B', '', '#808080', '#364454', '', '#708090', '#D3D3D3', '#365444', '', '#D70026', '#FFFFFF')";
	
	$wpdb->query($dataFondoConf);

	$sqlTextoConf ="CREATE TABLE IF NOT EXISTS {$wpdb->prefix}evento_texto_pred(
		`id_texto` INT NOT NULL,
		`cal_title` VARCHAR(60) NOT NULL,
		`cal_fecha` VARCHAR(60) NOT NULL,
		`title_desc` VARCHAR(60) NOT NULL,
		`desc_evento` VARCHAR(400) NOT NULL,
		`title_location` VARCHAR(200) NOT NULL,
		`text_url` VARCHAR(60) NOT NULL,
		`text_btn` VARCHAR(45) NOT NULL,
		PRIMARY KEY (`id_texto`)
	)";

	$wpdb->query($sqlTextoConf);


	$dataTextoConf = "INSERT INTO {$wpdb->prefix}evento_texto_pred (`id_texto`, `cal_title`, `cal_fecha`, `title_desc`, `desc_evento`, `title_location`, `text_url`, `text_btn`) VALUES
	(0, 'Nuestros Programas', 'Pronto', 'Entrenamiento y Actividades', 'En el momento no tenemos programas habilitados, si quiere saber acerca de ellos o los programas que realizamos, lo invitamos dar click', 'Pronto', '#', 'Vamos')";

	$wpdb->query($dataTextoConf);

	$sqlSwTexto ="CREATE TABLE IF NOT EXISTS {$wpdb->prefix}evento_switch_texto(
		`id_sw` INT NOT NULL,
		`dato` VARCHAR(15) NOT NULL,
		`cal_id` VARCHAR(30) NOT NULL,
		`switch` VARCHAR(15) NOT NULL,
		`estado` VARCHAR(15) NOT NULL,
		`estatus` VARCHAR(5) NOT NULL,
		`col_btn` VARCHAR(30) NOT NULL,
		`type_btn` VARCHAR(30) NOT NULL,
		PRIMARY KEY (`id_sw`)
	)";

	$wpdb->query($sqlSwTexto);


	$dataSwTexto = "INSERT INTO {$wpdb->prefix}evento_switch_texto (`id_sw`, `dato`, `cal_id`, `switch`, `estado`, `estatus`, `col_btn`, type_btn) VALUES
	(0, '', '', '', 'Desactivado', 'off', 'btn-light', '')";

	$wpdb->query($dataSwTexto);
}

global $wpdb;
$fondoConfCal = "{$wpdb->prefix}evento_fondo_conf";
$textoPredCal = "{$wpdb->prefix}evento_texto_pred";
$switchTxtCal = "{$wpdb->prefix}evento_switch_texto";

$queryFondoCal = "SELECT * FROM $fondoConfCal";
$listaFonConfCal = $wpdb->get_results($queryFondoCal, ARRAY_A);
if (empty($listaFonConfCal)) {
  $listaFonConfCal = array();
}
/*  */
$fConfig = json_encode($listaFonConfCal, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT); //
file_put_contents(__DIR__.'../admin/build/json/fondo_config.json', $fConfig);


$queryTextCal = "SELECT * FROM $textoPredCal";
$listaTextPredCal = $wpdb->get_results($queryTextCal, ARRAY_A);
if (empty($listaTextPredCal)) {
  $listaTextPredCal = array();
}
/*  */
$tConfig = json_encode($listaTextPredCal, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT); //
file_put_contents(__DIR__.'../admin/build/json/lista_texto.json', $tConfig);


$querySwCal = "SELECT * FROM $switchTxtCal";
$listaSwTextCal = $wpdb->get_results($querySwCal, ARRAY_A);
if (empty($listaSwTextCal)) {
  $listaSwTextCal = array();
}
/*  */
$sConfig = json_encode($listaSwTextCal, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT); //
file_put_contents(__DIR__.'../admin/build/json/switch_config.json', $sConfig);


function desactivarCal(){
	global $wpdb;

	$sqlBorrarTablas = "DROP TABLE `wp_evento_fondo_conf`, `wp_evento_switch_texto`, `wp_evento_texto_pred`";

	$wpdb->query($sqlBorrarTablas);
}

/* echo "hola Plugin"; */

register_activation_hook(__FILE__,'activarCal');
register_deactivation_hook(__FILE__,'desactivarCal');

add_action( 'admin_menu','crearMenuCal');

function crearMenuCal(){
	add_menu_page(
        'Eventos Calendario',//Titulo de la pagina
        'Eventos gCal',// Titulo del menu
        'manage_options', // Capability
		plugin_dir_path(__FILE__).'admin/lista_eventos.php', //slug
        null, //function del contenido
        plugin_dir_url(__FILE__).'admin/build/img/calendario.svg',//icono
        '100' //priority
    );
}

function mostrarContenidoCal(){
	echo "<h1>Contenido de la Pagina</h1>";
}

//encolar bootstrap
//encolar bootstrap
function encolarBootstrapJSCal($hook){
    //echo "<script>console.log('$hook')</script>";
    if($hook != "google-calendar-events-wp/admin/lista_eventos.php"){
        return ;
    }
    wp_enqueue_script('bootstrapJs',plugins_url('admin/bootstrap/js/bootstrap.min.js',__FILE__),array('jquery'));
    wp_enqueue_script('calendario',plugins_url('admin/build/js/eventos.js',__FILE__),array('jquery'));
}
add_action('admin_enqueue_scripts','encolarBootstrapJSCal');


function encolarBootstrapCSSCal($hook){
    if($hook != "google-calendar-events-wp/admin/lista_eventos.php"){
        return ;
    }
    wp_enqueue_style('bootstrapCSS',plugins_url('admin/bootstrap/css/bootstrap.min.css',__FILE__));
    wp_enqueue_style('eventos',plugins_url('admin/build/css/app.css',__FILE__));
}
add_action('admin_enqueue_scripts','encolarBootstrapCSSCal');


//encolar js propio
//encolar js propio
function encolarJSCal($hook){
    //echo "<script>console.log('$hook')</script>";
    if($hook != "google-calendar-events-wp/admin/lista_eventos.php"){
        return ;
    }
    wp_enqueue_script('jsExterno',plugins_url('admin/build/js/lista-eventos.js',__FILE__),array('jquery'));
}
add_action('admin_enqueue_scripts','encolarJSCal');


add_action ('wp_enqueue_scripts', 'cargar_frontend_js');
function cargar_frontend_js () {
  wp_enqueue_script( 'mi-script', get_template_directory_uri() . 'admin/build/js/eventos.js', array('jquery'), '1.0.0', true );
}


function mostrar_eventos($atts) {
	global $wpdb;

	$textoPred = "{$wpdb->prefix}evento_texto_pred";
	$switchTxt = "{$wpdb->prefix}evento_switch_texto";
	/* */ 
	$id = shortcode_atts( array(
	'id_corto' => '',
	'id_largo' => 'gcf-custom-template',
	), $atts );
	
	
	$queryText = "SELECT * FROM $textoPred";
	$listaTextPred = $wpdb->get_results($queryText);
	if (empty($listaTextPred)) {
		$listaTextPred = array();
	}
	
	$querySw = "SELECT * FROM $switchTxt";
	$listaSwText = $wpdb->get_results($querySw, ARRAY_A);
	if (empty($listaSwText)) {
		$listaSwText = array();
	}
	
	$a = shortcode_atts($listaTextPred[0], $atts );

  $texto = 
	'<div class="gCalFlow" id="' . $id['id_largo'] . '">' .
 '<div class="gcf-header-block">' .
   '<div class="gcf-title-block">' .
	 '<span class="gcf-title">' . $a['cal_title'] . '</span>' .
   '</div>' .
 '</div>' .
 '<hr size="1px" color="LightSlateGray" />' .
 '<div class="gcf-item-container-block">' .
   '<div class="gcf-item-block">' .
	 '<div class="gcf-item-header-block">' .
	   '<div class="gcf-item-date-block">' .
		 '<span class="gcf-item-daterange">' .
		   '<h2 class="no-margin"><span></span></h2>' .
		   '<br>' .
		   '<h3 class="no-margin">' . $a['cal_fecha'] . '<br><span></span></h3>' .
		 '</span>' .
	   '</div>' .
	 '</div>' .
	 '<div class="gcf-item-body-block">' .
	   '<div class="gcf-item-title-block">' .
		 '<strong class="gcf-item-title">' . $a['title_desc'] . '</strong>' .
	   '</div>' .
	   '<div class="gcf-item-description">' .
	     $a['desc_evento'] . 
	   '</div>' .
	   '<div class="gcf-item-location">' .
	   $a['title_location'] .
	   '</div>' .
	 '</div>' .
	 '<div class="btn-calendario">' .
	   '<a href="' . $a['text_url'] . '" class="boton-roja" role="button">' . $a['text_btn'] . '</a>' .
	 '</div>' .
   '</div>' .
 '</div>' .
 '<hr size="1px" color="LightSlateGray" />' .
 '<div class="gcf-last-update-block">' .
   'Ultima actualizacion: <span class="gcf-last-update"></span>' .
 '</div>' .
'</div>' .
'<br>'
// . '<div id="elemen"></div>'
;

    return $texto;
}
add_shortcode('eventos', 'mostrar_eventos');


?>

<!-- Insertar CSS del Calendario de Google en las paginas -->
<!-- Insertar CSS del Calendario de Google en las paginas -->
<?php 
add_action('wp_head', function(){?>
<?php
 global $wpdb;

$fondoConf = "{$wpdb->prefix}evento_fondo_conf";

$queryFondo = "SELECT * FROM $fondoConf";
$listaFonConf = $wpdb->get_results($queryFondo, ARRAY_A);
if (empty($listaFonConf)) {
  $listaFonConf = array();
}/* */
/*
$textoPred = "{$wpdb->prefix}evento_texto_pred";
$switchTxt = "{$wpdb->prefix}evento_switch_texto";

$queryText = "SELECT * FROM $textoPred";
$listaTextPred = $wpdb->get_results($queryText, ARRAY_A);
if (empty($listaTextPred)) {
  $listaTextPred = array();
}

$querySw = "SELECT * FROM $switchTxt";
$listaSwText = $wpdb->get_results($querySw, ARRAY_A);
if (empty($listaSwText)) {
  $listaSwText = array();
}
 */
?>

<link rel="stylesheet" href="/wordpress/wp-content/plugins/google-calendar-events-wp/admin/build/css/app.css">
<style>
.gCalFlow .gcf-header-block .gcf-title-block .gcf-title {
    color: <?php echo $listaFonConf[0]['color_txt_tit']; ?>;
}

.gCalFlow .gcf-header-block .gcf-title-block .gcf-title a {
    color: <?php echo $listaFonConf[0]['color_txt_tit']; ?>;
}

.gCalFlow .gcf-header-block .gcf-title-block .gcf-title a:hover {
    color: <?php echo $listaFonConf[0]['color_txt_des']; ?>;
}

.gCalFlow .gcf-item-container-block .gcf-item-block .gcf-item-header-block {
    background-color: <?php echo $listaFonConf[0]['color_bag_fec'] ,$listaFonConf[0]['color_por_fec']; ?>;
}

.gCalFlow .gcf-item-container-block .gcf-item-block .gcf-item-header-block .gcf-item-date-block .gcf-item-daterange h2,
.gCalFlow .gcf-item-container-block .gcf-item-block .gcf-item-header-block .gcf-item-date-block .gcf-item-daterange h3,
.gCalFlow .gcf-item-container-block .gcf-item-block .gcf-item-header-block .gcf-item-date-block .gcf-item-daterange h4 {
    color: <?php echo $listaFonConf[0]['color_txt_fec']; ?>;
}

.gCalFlow .gcf-item-container-block .gcf-item-block .gcf-item-body-block {
    background-color: <?php echo $listaFonConf[0]['color_bag_des'] ,$listaFonConf[0]['color_por_des']; ?>;
}

.gCalFlow .gcf-item-container-block .gcf-item-block .gcf-item-body-block .gcf-item-title-block .gcf-item-title {
    color: <?php echo $listaFonConf[0]['color_txt_tit']; ?>;
}

.gCalFlow .gcf-item-container-block .gcf-item-block .gcf-item-body-block .gcf-item-title-block .gcf-item-title a {
    color: <?php echo $listaFonConf[0]['color_txt_tit']; ?>;
}

.gCalFlow .gcf-item-container-block .gcf-item-block .gcf-item-body-block .gcf-item-title-block .gcf-item-title a:hover {
    color: <?php echo $listaFonConf[0]['color_txt_fec']; ?>;
}

.gCalFlow .gcf-item-container-block .gcf-item-block .gcf-item-body-block .gcf-item-description {
    color: <?php echo $listaFonConf[0]['color_txt_des']; ?>;
}

.gCalFlow .gcf-item-container-block .gcf-item-block .gcf-item-body-block .gcf-item-location {
    color: <?php echo $listaFonConf[0]['color_txt_tit']; ?>;
}

.gCalFlow .gcf-item-container-block .gcf-item-block .btn-calendario {
    background-color: <?php echo $listaFonConf[0]['color_bag_bot'] ,$listaFonConf[0]['color_por_bot']; ?>;
}

.gCalFlow .gcf-item-container-block .gcf-item-block .btn-calendario .boton-roja {
    background-color: <?php echo $listaFonConf[0]['color_fon_btn']; ?>;
    color: <?php echo $listaFonConf[0]['color_tex_btn']; ?>;
}

.gCalFlow .gcf-item-container-block .gcf-item-block .btn-calendario .boton-roja:hover {
    background-color: <?php echo $listaFonConf[0]['color_tex_btn']; ?>;
    color: <?php echo $listaFonConf[0]['color_fon_btn']; ?>;
}

.gCalFlow .gcf-last-update-block {
    color: <?php echo $listaFonConf[0]['color_txt_tit']; ?>;
}

.gCalFlow .gcf-last-update-block .gcf-last-update {
    color: <?php echo $listaFonConf[0]['color_txt_des']; ?>;
}

.btn-roja {
    background-color: <?php echo $listaFonConf[0]['color_fon_btn']; ?>;
    color: <?php echo $listaFonConf[0]['color_tex_btn']; ?>;
  }

.btn-roja:hover {
  background-color: <?php echo $listaFonConf[0]['color_tex_btn']; ?>;
  color: <?php echo $listaFonConf[0]['color_fon_btn']; ?>;
}
</style>
<?php }  ,9999); ?>
<!-- 
/wordpress/wp-content/plugins/google-calendar-events-wp/
 -->

<!-- Insertar JavaScript del Calendario de Google en las paginas wp_head -->
<!-- Insertar JavaScript del Calendario de Google en las paginas wp_footer -->

<?php 

add_action('wp_head', function(){?>
<!-- window.jQuery || document.write('<script src="wp-content/plugins/google-calendar-events-wp/admin/build/js/jquery.min.js"><\/script>')) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

<?php }  ,1); ?>



<?php 
add_action('wp_footer', function(){?>
<?php 
global $wpdb;
$fondoConfCal = "{$wpdb->prefix}evento_fondo_conf";

$queryFondoCal = "SELECT * FROM $fondoConfCal";
$listaFonConfCal = $wpdb->get_results($queryFondoCal, ARRAY_A);
if (empty($listaFonConfCal)) {
  $listaFonConfCal = array();
}
?>
<script>

/* -------------------------Configuracion id Eventos------------------------- */
/* -------------------------Configuracion id Eventos------------------------- */

_gCalFlow_debug = true;

var $ = jQuery;
  $(function() {
    $('#gcf-simple').gCalFlow({
      calid: '<?php echo $listaFonConfCal[0]['id_cal']; ?>',
      apikey: '<?php echo $listaFonConfCal[0]['api_key']; ?>'
    });
    $('#gcf-design').gCalFlow({
      calid: '<?php echo $listaFonConfCal[0]['id_cal']; ?>',
      apikey: '<?php echo $listaFonConfCal[0]['api_key']; ?>',
      maxitem: 10,
      date_formatter: function(d, allday_p) {
         return d.getDate() + "/" + (d.getMonth()+1) + "/" + d.getYear().toString().substr(-2)
         }
    });
    $('#gcf-ticker').gCalFlow({
        calid: '<?php echo $listaFonConfCal[0]['id_cal']; ?>',
        apikey: '<?php echo $listaFonConfCal[0]['api_key']; ?>',
        maxitem: 25,
        scroll_interval: 5 * 1000,
        daterange_formatter: function (start_date, end_date, allday_p) {
        function pad(n) { return n < 10 ? "0"+n : n; }
        var monthname = [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic" ];
        return pad(start_date.getDate()) + " " + pad(monthname[start_date.getMonth()]) + " - " + pad(end_date.getDate()) + " " + pad(monthname[end_date.getMonth()]);
        },
    });
    $('#gcf-custom-template').gCalFlow({
      calid: '<?php echo $listaFonConfCal[0]['id_cal']; ?>',
      apikey: '<?php echo $listaFonConfCal[0]['api_key']; ?>',
      maxitem: 3,
      scroll_interval: 5 * 1000,
      mode: 'updates',
      daterange_formatter: function (start_date, end_date, allday_p) {
      function pad(n) { return n < 10 ? "0"+n : n; }
      var monthname = [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic" ];
      return "<h2 class=\"no-margin\">" + pad(start_date.getDate()) + "<br><span>" + pad(monthname[start_date.getMonth()]) + "</span></h2>" + "<br>" + "<h3 class=\"no-margin\">" + pad(end_date.getDate()) + "<br><span>" + pad(monthname[end_date.getMonth()]) + "</span></h3>";
      },
    }); 
  });
 /* 
console.log(new Date().toJSON());
console.log($.prototype.fetch);
console.log($.data['items']);
console.log($.find(".gcf-item-title"));
console.log($.find(".gcf-item-title")[0]['innerText']);
console.log(gCalFlow.prototype.fetch(now));
log.debug(this.gcal_url());

console.log($.find(".gcf-item-description")[0]['innerText']);
console.log(document.Ajax call success. Response data: );

const heading = document.querySelector('.gcf-item-title')
  console.log(heading);

console.log(heading.Ajaxcallsuccess.Responsedata);

  gCalFlow.prototype.fetch (arrayCal){};
 */
</script>
<!-- <script src="/wordpress/wp-content/plugins/google-calendar-events-wp/admin/build/js/eventos.js"></script> -->
<?php }  ,9999); ?>
<!-- 
/wordpress/wp-content/plugins/google-calendar-events-wp/
 -->