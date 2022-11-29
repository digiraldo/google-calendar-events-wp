<?php
/*
Plugin Name: Google Calendar Events wp
Plugin URI: https://github.com/digiraldo
Description: Eventos de Calendario de Google para tu Web, Muestra el calendario de Google como eventos dentro de una seccion de tu pagina web.
Version: 1.0.1
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
	(0, 'Introduzca la Api-Key de Google', 'Introduzca Id del Calendario de Google', '#151719', '#3B3B3B', '', '#808080', '#364454', '', '#708090', '#D3D3D3', '#365444', '', '#D70026', '#FFFFFF')";
	
	$wpdb->query($dataFondoConf);

	$sqlTextoConf ="CREATE TABLE IF NOT EXISTS {$wpdb->prefix}evento_texto_pred(
		`id_texto` INT NOT NULL,
		`cal_title` VARCHAR(60) NOT NULL,
		`cal_fecha` VARCHAR(60) NOT NULL,
		`title_desc` VARCHAR(60) NOT NULL,
		`desc_evento` VARCHAR(400) NOT NULL,
		`title_location` VARCHAR(200) NOT NULL,
		`text_btn` VARCHAR(45) NOT NULL,
		PRIMARY KEY (`id_texto`)
	)";

	$wpdb->query($sqlTextoConf);


	$dataTextoConf = "INSERT INTO {$wpdb->prefix}evento_texto_pred (`id_texto`, `cal_title`, `cal_fecha`, `title_desc`, `desc_evento`, `title_location`, `text_btn`) VALUES
	(0, 'Nuestros Programas', 'Pronto', 'Entrenamiento y Actividades', 'En el momento no tenemos programas habilitados, si quiere saber acerca de ellos o los programas que realizamos, lo invitamos dar click', 'Pronto', 'Vamos')";

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

$fConfig = json_encode($listaFonConfCal, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT); //
/* echo $fConfig;  */
file_put_contents(__DIR__.'../admin/build/json/fondo_config.json', $fConfig);

$queryTextCal = "SELECT * FROM $textoPredCal";
$listaTextPredCal = $wpdb->get_results($queryTextCal, ARRAY_A);
if (empty($listaTextPredCal)) {
  $listaTextPredCal = array();
}
$tConfig = json_encode($listaTextPredCal, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT); //
/* echo $tConfig; */
file_put_contents(__DIR__.'../admin/build/json/lista_texto.json', $tConfig);

$querySwCal = "SELECT * FROM $switchTxtCal";
$listaSwTextCal = $wpdb->get_results($querySwCal, ARRAY_A);
if (empty($listaSwTextCal)) {
  $listaSwTextCal = array();
}
$sConfig = json_encode($listaSwTextCal, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT); //
/* echo $sConfig; */
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

function encolarBootstrapJSCal($hook){
    //echo "<script>console.log('$hook')</script>";
    if($hook != "google-calendar-events-wp/admin/lista_eventos.php"){
        return ;
    }
    wp_enqueue_script('bootstrapJs',plugins_url('admin/bootstrap/js/bootstrap.min.js',__FILE__),array('jquery'));
    // wp_enqueue_script('calendario',plugins_url('admin/build/js/calendario.js',__FILE__),array('jquery'));
    wp_enqueue_script('calendario',plugins_url('admin/build/js/eventos.js',__FILE__),array('jquery'));
}
add_action('admin_enqueue_scripts','encolarBootstrapJSCal');


function encolarBootstrapCSSCal($hook){
    if($hook != "google-calendar-events-wp/admin/lista_eventos.php"){
        return ;
    }
    wp_enqueue_style('bootstrapCSS',plugins_url('admin/bootstrap/css/bootstrap.min.css',__FILE__));
    wp_enqueue_style('eventos',plugins_url('admin/build/css/gcal.css',__FILE__));
    // wp_enqueue_style('calendario',plugins_url('admin/build/css/app.css',__FILE__));
    // wp_enqueue_style('calCss',plugins_url('admin/build/calCss.php',__FILE__));
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
	   '<a class="boton-roja" role="button">' . $a['text_btn'] . '</a>' .
	 '</div>' .
   '</div>' .
 '</div>' .
 '<hr size="1px" color="LightSlateGray" />' .
 '<div class="gcf-last-update-block">' .
   'Última actualización: <span class="gcf-last-update"></span>' .
 '</div>' .
'</div>'
;

    return $texto;
}
add_shortcode('eventos', 'mostrar_eventos');



function mostrar_fecha($atts) {
  $id = shortcode_atts( array(
    'id_corto' => '',
    'id_largo' => 'gcf-custom-template',
    ), $atts );

    $textoFecha = '<div class="gCalFlow" id="' . $id['id_largo'] . '" style="color: #fff;">No Datos de JS</div>';
    return $textoFecha;
}
add_shortcode('fecha', 'mostrar_fecha');

?>

<!-- Insertar CSS del Calendario de Google en las paginas -->
<!-- Insertar CSS del Calendario de Google en las paginas -->
<?php 
add_action('wp_head', function(){?>
<?php
global $wpdb;

$fondoConf = "{$wpdb->prefix}evento_fondo_conf";
$textoPred = "{$wpdb->prefix}evento_texto_pred";
$switchTxt = "{$wpdb->prefix}evento_switch_texto";

$queryFondo = "SELECT * FROM $fondoConf";
$listaFonConf = $wpdb->get_results($queryFondo, ARRAY_A);
if (empty($listaFonConf)) {
  $listaFonConf = array();
}

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

/* echo '<pre>'; print_r($listaFonConf[0]); echo '</pre>'; */
?>
<style>
hr {
    width: 50%
}

.gCalFlow {
    align-content: center;
    display: flex;
    flex-direction: column;
    height: 100%;
    justify-content: center;
    width: 100%
}

.gCalFlow .gcf-header-block {
    margin: 0 10px;
    padding: 5px 10px;
    text-align: center
    
}

.gCalFlow .gcf-header-block .gcf-title-block .gcf-title {
    border-collapse: separate;
    border-spacing: 10px 5px;
    color: <?php echo $listaFonConf[0]['color_txt_tit']; ?>;
    font-size: 22px;
    margin: 0;
    padding: 0;
    transition: all .3s ease-in-out
}

.gCalFlow .gcf-header-block .gcf-title-block .gcf-title a {
    color: <?php echo $listaFonConf[0]['color_txt_tit']; ?>;
    transition: all .3s ease-in-out
}

.gCalFlow .gcf-header-block .gcf-title-block .gcf-title a:hover {
    color: <?php echo $listaFonConf[0]['color_txt_des']; ?>;
    cursor: pointer;
    font-weight: 900
}

.gCalFlow .gcf-item-container-block {
    font-family: Roboto Condensed, sans-serif;
    margin: 0;
    padding: 0;
    text-align: justify
}

@media (min-width:768px) {
    .gCalFlow .gcf-item-container-block {
        padding: 0 20px
    }
}

.gCalFlow .gcf-item-container-block .gcf-item-block {
    box-shadow: 7px 7px 10px -5px rgba(255, 255, 255, 0.17); 
    -moz-box-shadow: 7px 7px 10px -5px rgba(255, 255, 255, 0.17); 
    -webkit-box-shadow: 7px 7px 10px -5px rgba(255, 255, 255, 0.17);
    display: grid;
    gap: 0;
    grid-auto-rows: auto;
    grid-template-columns: repeat(1, 1fr);
    grid-template-rows: repeat(1, 1fr);
    margin: 20px 2px;
    text-align: center
}

@media (min-width:768px) {
    .gCalFlow .gcf-item-container-block .gcf-item-block {
        align-content: center;
        display: flex;
        flex-direction: row;
        justify-content: space-between
    }
}

.gCalFlow .gcf-item-container-block .gcf-item-block .gcf-item-header-block {
    align-content: center;
    align-items: center;
    background-color: <?php echo $listaFonConf[0]['color_bag_fec'] ,$listaFonConf[0]['color_por_fec']; ?>;
    display: flex;
    justify-content: center;
    padding: 0 30px
}

.gCalFlow .gcf-item-container-block .gcf-item-block .gcf-item-header-block .gcf-item-date-block .gcf-item-daterange {
    align-content: center;
    align-items: center;
    box-sizing: border-box;
    display: flex;
    justify-content: center;
    padding: 10px 0
}

@media (min-width:768px) {
    .gCalFlow .gcf-item-container-block .gcf-item-block .gcf-item-header-block .gcf-item-date-block .gcf-item-daterange {
        align-content: center;
        align-items: center;
        display: grid;
        gap: 1px;
        grid-auto-rows: auto;
        grid-template-columns: repeat(auto, 1fr);
        grid-template-rows: repeat(auto, 1fr);
        justify-content: center;
        justify-items: end
    }
}

.gCalFlow .gcf-item-container-block .gcf-item-block .gcf-item-header-block .gcf-item-date-block .gcf-item-daterange h2,
.gCalFlow .gcf-item-container-block .gcf-item-block .gcf-item-header-block .gcf-item-date-block .gcf-item-daterange h3,
.gCalFlow .gcf-item-container-block .gcf-item-block .gcf-item-header-block .gcf-item-date-block .gcf-item-daterange h4 {
    color: <?php echo $listaFonConf[0]['color_txt_fec']; ?>;
}

.gCalFlow .gcf-item-container-block .gcf-item-block .gcf-item-header-block .gcf-item-date-block .gcf-item-daterange .no-margin {
    margin: 0 10px
}

.gCalFlow .gcf-item-container-block .gcf-item-block .gcf-item-header-block .gcf-item-date-block .gcf-item-daterange h2 {
    font-size: 31px;
    line-height: .7;
    text-align: center
}

.gCalFlow .gcf-item-container-block .gcf-item-block .gcf-item-header-block .gcf-item-date-block .gcf-item-daterange h2 span {
    font-size: 27px;
    font-weight: 400
}

.gCalFlow .gcf-item-container-block .gcf-item-block .gcf-item-header-block .gcf-item-date-block .gcf-item-daterange h3 {
    font-size: 21px;
    line-height: .8;
    text-align: center
}

.gCalFlow .gcf-item-container-block .gcf-item-block .gcf-item-header-block .gcf-item-date-block .gcf-item-daterange h3 span {
    font-size: 18px;
    font-weight: 400
}

.gCalFlow .gcf-item-container-block .gcf-item-block .gcf-item-body-block {
    background-color: <?php echo $listaFonConf[0]['color_bag_des'] ,$listaFonConf[0]['color_por_des']; ?>;
    box-sizing: border-box;
    padding: 3px 5px;
    width: 100%
}

.gCalFlow .gcf-item-container-block .gcf-item-block .gcf-item-body-block .gcf-item-title-block {
    margin: 5px 1px
}

.gCalFlow .gcf-item-container-block .gcf-item-block .gcf-item-body-block .gcf-item-title-block .gcf-item-title {
    color: <?php echo $listaFonConf[0]['color_txt_tit']; ?>;
    font-size: 26px;
    font-weight: 700;
    transition: all .3s ease-in-out
}

.gCalFlow .gcf-item-container-block .gcf-item-block .gcf-item-body-block .gcf-item-title-block .gcf-item-title a {
    color: <?php echo $listaFonConf[0]['color_txt_tit']; ?>;
    transition: all .3s ease-in-out
}

.gCalFlow .gcf-item-container-block .gcf-item-block .gcf-item-body-block .gcf-item-title-block .gcf-item-title a:hover {
    color: <?php echo $listaFonConf[0]['color_txt_fec']; ?>;
    cursor: pointer;
    font-size: 28px
}

.gCalFlow .gcf-item-container-block .gcf-item-block .gcf-item-body-block .gcf-item-description {
    color: <?php echo $listaFonConf[0]['color_txt_des']; ?>;
    font-size: 17px
}

.gCalFlow .gcf-item-container-block .gcf-item-block .gcf-item-body-block .gcf-item-location {
    color: <?php echo $listaFonConf[0]['color_txt_tit']; ?>;
    font-size: 14px;
    margin: 10px 0 0
}

.gCalFlow .gcf-item-container-block .gcf-item-block .btn-calendario {
    align-content: center;
    align-items: center;
    background-color: <?php echo $listaFonConf[0]['color_bag_bot'] ,$listaFonConf[0]['color_por_bot']; ?>;
    display: flex;
    justify-content: center
}

.gCalFlow .gcf-item-container-block .gcf-item-block .btn-calendario .boton-roja {
    background-color: <?php echo $listaFonConf[0]['color_fon_btn']; ?>;
    border: none;
    border-radius: 5px;
    color: <?php echo $listaFonConf[0]['color_tex_btn']; ?>;
    display: inline-block;
    font-weight: 700;
    margin: 8.333px;
    padding: 6px 30px;
    text-align: center;
    text-decoration: none;
    transition: all .3s ease-in-out
}

.gCalFlow .gcf-item-container-block .gcf-item-block .btn-calendario .boton-roja:hover {
    background-color: <?php echo $listaFonConf[0]['color_tex_btn']; ?>;
    color: <?php echo $listaFonConf[0]['color_fon_btn']; ?>;
    cursor: pointer;
    padding: 6px 40px
}

.gCalFlow .gcf-last-update-block {
    color: <?php echo $listaFonConf[0]['color_txt_tit']; ?>;
    font-size: 14px;
    margin: 0;
    padding: 10px 5px 40px;
    text-align: center
}

.gCalFlow .gcf-last-update-block .gcf-last-update {
    color: <?php echo $listaFonConf[0]['color_txt_des']; ?>;
    font-size: 14px;
    text-align: center
}


.btn-roja {
    background-color: <?php echo $listaFonConf[0]['color_fon_btn']; ?>;
    border: none;
    border-radius: 5px;
    color: <?php echo $listaFonConf[0]['color_tex_btn']; ?>;
    display: inline-block;
    font-weight: 700;
    margin: 2px;
    padding: 4px 10px;
    text-align: center;
    text-decoration: none;
    transition: all .3s ease-in-out
  }

  .btn-roja:hover {
    background-color: <?php echo $listaFonConf[0]['color_tex_btn']; ?>;
    color: <?php echo $listaFonConf[0]['color_fon_btn']; ?>;
    cursor: pointer;
    padding: 4px 13px
  }
</style>
<?php }  ,9999); ?>


<!-- Insertar JavaScript del Calendario de Google en las paginas wp_head -->
<!-- Insertar JavaScript del Calendario de Google en las paginas wp_footer -->
<!-- calid: '<?php echo $listaFonConfCal[0]['id_cal']; ?>',
apikey: '<?php echo $listaFonConfCal[0]['api_key']; ?>', -->

<?php 

add_action('wp_head', function(){?>
<!-- window.jQuery || document.write('<script src="wp-content/plugins/google-calendar-events-wp/admin/build/js/jquery.min.js"><\/script>')) -->
<!-- <script src="wp-content/plugins/google-calendar-events-wp/admin/build/js/jquery.min.js"></script> -->
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

/* -------------------------Configuración id Eventos------------------------- */
/* -------------------------Configuracion id Eventos------------------------- */
/* -------------------------Configuracion id Eventos------------------------- */
/* -------------------------Configuracion id Eventos------------------------- */
/* -------------------------Configuracion id Eventos------------------------- */


_gCalFlow_debug = true;

var $ = jQuery;
  $(function() {
    $('#gcf-simple').gCalFlow({
      calid: '35b2qba53usalutistin2t916o@group.calendar.google.com',
      apikey: 'AIzaSyB4x70PYpmslKqPy_fvvoMMTKADc9UdifE'
    });
    $('#gcf-design').gCalFlow({
      calid: '35b2qba53usalutistin2t916o@group.calendar.google.com',
      apikey: 'AIzaSyB4x70PYpmslKqPy_fvvoMMTKADc9UdifE',
      maxitem: 10,
      date_formatter: function(d, allday_p) {
         return d.getDate() + "/" + (d.getMonth()+1) + "/" + d.getYear().toString().substr(-2)
         }
    });
    $('#gcf-ticker').gCalFlow({
        calid: '35b2qba53usalutistin2t916o@group.calendar.google.com',
        apikey: 'AIzaSyB4x70PYpmslKqPy_fvvoMMTKADc9UdifE',
        maxitem: 25,
        scroll_interval: 5 * 1000,
        daterange_formatter: function (start_date, end_date, allday_p) {
        function pad(n) { return n < 10 ? "0"+n : n; }
        var monthname = [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic" ];
        return pad(start_date.getDate()) + " " + pad(monthname[start_date.getMonth()]) + " - " + pad(end_date.getDate()) + " " + pad(monthname[end_date.getMonth()]);
        },
    });
    $('#gcf-custom-template').gCalFlow({
      calid: '35b2qba53usalutistin2t916o@group.calendar.google.com',
      apikey: 'AIzaSyB4x70PYpmslKqPy_fvvoMMTKADc9UdifE',
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


  /* ------------------------jquery.gcal_flow------------------------ */
  /* ------------------------jquery.gcal_flow------------------------ */
  /* ------------------------jquery.gcal_flow------------------------ */
  /* ------------------------jquery.gcal_flow------------------------ */
  /* ------------------------jquery.gcal_flow------------------------ */

  (function () {
    var $, gCalFlow, j, len, log, methods, pad_zero, prio, ref;
    $ = jQuery;
    log = {};
    log.error = log.warn = log.log = log.info = log.debug = function () {};
    if (
      typeof window !== "undefined" &&
      window !== null &&
      typeof console !== "undefined" &&
      console !== null &&
      console.log != null
    ) {
      if (!window._gCalFlow_quiet) {
        ref = ["error", "warn", "info"];
        for (j = 0, len = ref.length; j < len; j++) {
          prio = ref[j];
          log[prio] = function () {
            if (console[prio]) {
              return console[prio].apply(console, arguments);
            } else {
              return console.log.apply(console, arguments);
            }
          };
        }
      }
      if (window._gCalFlow_debug) {
        log.debug = function () {
          if (console.debug != null) {
            return console.debug.apply(console, arguments);
          } else {
            return console.log.apply(console, arguments);
          }
        };
      }
    }
    pad_zero = function (num, size) {
      var i, k, ref1, ret;
      if (size == null) {
        size = 2;
      }
      if (10 * (size - 1) <= num) {
        return num;
      }
      ret = "";
      for (
        i = k = 1, ref1 = size - ("" + num).length;
        1 <= ref1 ? k <= ref1 : k >= ref1;
        i = 1 <= ref1 ? ++k : --k
      ) {
        ret = ret.concat("0");
      }
      return ret.concat(num);
    };
    gCalFlow = (function () {
      gCalFlow.demo_apikey = "AIzaSyD0vtTUjLXzH4oKCzNRDymL6E3jKBympf0";
      gCalFlow.prototype.target = null;
      gCalFlow.prototype.template = $(
        '<div class="gCalFlow">\n          <div class="gcf-header-block">\n              <div class="gcf-title-block">\n                  <span class="gcf-title">Nuestros Programas</span>\n              </div>\n          </div>\n          <hr size="1px" color="LightSlateGray"/>\n          <div class="gcf-item-container-block">\n                 <div class="gcf-item-block">\n                  <div class="gcf-item-header-block">\n                      <div class="gcf-item-date-block">\n                          <span class="gcf-item-daterange">\n                              <h2 class="no-margin">Mateo<br><span>28</span></h2>\n                              <br>\n                              <h3 class="no-margin">19<br><span>20</span></h3>\n                          </span>\n                      </div>\n                  </div>\n                  <div class="gcf-item-body-block">\n                      <div class="gcf-item-title-block">\n                          <strong class="gcf-item-title">Entrenamiento y Actividades</strong>\n                      </div>\n                      <div class="gcf-item-description">\n                          ¿Ya estás listo para ir, ser entrenado, y hacer discípulos? Echa un vistazo a nuestro opciones de formación y diferentes actividades.\n                      </div>\n                      <div class="gcf-item-location">\n                          Evento\n                      </div>\n                  </div>\n                  <div class="btn-calendario">\n                      <a class="boton-roja" href="entrenamiento" role="button">¡Vamos!</a>\n                  </div>\n              </div>\n          </div>\n          <hr size="1px" color="LightSlateGray"/>\n          <div class="gcf-last-update-block">\n              Última actualización: <span class="gcf-last-update">-- -- ----</span>\n          </div>\n        </div>'
      );
      gCalFlow.prototype.opts = {
        maxitem: 15,
        calid: null,
        apikey: gCalFlow.demo_apikey,
        mode: "upcoming",
        data_url: null,
        auto_scroll: true,
        scroll_interval: 10 * 1e3,
        link_title: true,
        link_item_title: true,
        link_item_description: false,
        link_item_location: false,
        link_target: "_blank",
        item_description_as_html: false,
        callback: null,
        no_items_html: "",
        globalize_culture:
          typeof navigator !== "undefined" &&
          navigator !== null &&
          (navigator.browserLanguage ||
            navigator.language ||
            navigator.userLanguage),
        globalize_fmt_datetime: "f",
        globalize_fmt_date: "D",
        globalize_fmt_time: "t",
        globalize_fmt_monthday: "M",
        date_formatter: function(d, allday_p) {
          const monthNames = [" ", "Ene", "Feb", "Mar",  "Abr", "May", "Jun",  "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"];
          const month = (pad_zero(d.getMonth() + 1));
          const shortmonth = +month;
          const hours = (pad_zero(d.getHours()));
          const hoursfix = ((hours + 11) % 12 + 1);
          const suffix = (hours >= 12)? 'pm' : 'am';
          var fmtstr;
              if ((typeof Globalize !== "undefined" && Globalize !== null) && (Globalize.format != null)) {
                if (allday_p) {
                  fmtstr = this.globalize_fmt_date;
                } else {
                  fmtstr = this.globalize_fmt_datetime;
                }
                return Globalize.format(d, fmtstr);
              } else {
                if (allday_p) {
                  return (d.getFullYear()) + "-" + (pad_zero(d.getMonth() + 1)) + "-" + (pad_zero(d.getDate()));
                } else {
                  return (pad_zero(d.getDate())) + " " + monthNames[shortmonth] +  ". " + (d.getFullYear()) + " - " + hoursfix + ":" + (pad_zero(d.getMinutes())) + " " + suffix;
                }
              }
            },
        daterange_formatter: function (sd, ed, allday_p) {
          var endstr, ret;
          ret = this.date_formatter(sd, allday_p);
          if (allday_p) {
            ed = new Date(ed.getTime() - 86400 * 1e3);
          }
          endstr = "";
          if (sd.getDate() !== ed.getDate() || sd.getMonth() !== ed.getMonth()) {
            if (
              typeof Globalize !== "undefined" &&
              Globalize !== null &&
              Globalize.format != null
            ) {
              endstr += Globalize.format(ed, this.globalize_fmt_monthday);
            } else {
              endstr +=
                pad_zero(ed.getMonth() + 1) + "-" + pad_zero(ed.getDate());
            }
          }
          if (
            !allday_p &&
            (sd.getHours() !== ed.getHours() ||
              sd.getMinutes() !== ed.getMinutes())
          ) {
            if (
              typeof Globalize !== "undefined" &&
              Globalize !== null &&
              Globalize.format != null
            ) {
              endstr += Globalize.format(ed, this.globalize_fmt_time);
            } else {
              endstr +=
                " " + pad_zero(ed.getHours()) + ":" + pad_zero(ed.getMinutes());
            }
          }
          if (endstr) {
            ret += " - " + endstr;
          }
          return ret;
        },
      };
      function gCalFlow(target, opts) {
        this.target = target;
        target.addClass("gCalFlow");
        if (target.children().size() > 0) {
          log.debug("Target node has children, use target element as template.");
          this.template = target;
        }
        this.update_opts(opts);
      }
      gCalFlow.prototype.update_opts = function (new_opts) {
        log.debug("update_opts was called");
        log.debug("old options:", this.opts);
        this.opts = $.extend({}, this.opts, new_opts);
        return log.debug("new options:", this.opts);
      };
      gCalFlow.prototype.gcal_url = function () {
        var now;
        if (!this.opts.calid && !this.opts.data_url) {
          log.error(
            "Option calid and data_url are missing. Abort URL generation"
          );
          this.target.text(
            "Error: You need to set 'calid' or 'data_url' option."
          );
          throw "gCalFlow: calid and data_url missing";
        }
        if (this.opts.data_url) {
          return this.opts.data_url;
        } else if (this.opts.mode === "updates") {
          now = new Date().toJSON();
          return (
            "https://www.googleapis.com/calendar/v3/calendars/" +
            this.opts.calid +
            "/events?key=" +
            this.opts.apikey +
            "&maxResults=" +
            this.opts.maxitem +
            "&orderBy=updated&timeMin=" +
            now +
            "&singleEvents=true"
          );
        } else {
          now = new Date().toJSON();
          return (
            "https://www.googleapis.com/calendar/v3/calendars/" +
            this.opts.calid +
            "/events?key=" +
            this.opts.apikey +
            "&maxResults=" +
            this.opts.maxitem +
            "&orderBy=startTime&timeMin=" +
            now +
            "&singleEvents=true"
          );
        }
      };
      gCalFlow.prototype.fetch = function () {
        var success_handler;
        log.debug("Starting ajax call for " + this.gcal_url());
        if (this.opts.apikey === this.constructor.demo_apikey) {
          log.warn(
            "You are using built-in demo API key! This key is provided for tiny use or demo only. Your access may be limited."
          );
          log.warn("Please check document and consider to use your own key.");
        }
        success_handler = (function (_this) {
          return function (data) {
            log.debug("Ajax call success. Response data:", data);
            return _this.render_data(data, _this);
          };
        })(this);
        return $.ajax({
          type: "GET",
          success: success_handler,
          dataType: "jsonp",
          url: this.gcal_url(),
        });
      };
      gCalFlow.prototype.parse_date = function (dstr) {
        var day, hour, m, min, mon, offset, ret, sec, year;
        if ((m = dstr.match(/^(\d{4})-(\d{2})-(\d{2})$/))) {
          return new Date(
            parseInt(m[1], 10),
            parseInt(m[2], 10) - 1,
            parseInt(m[3], 10),
            0,
            0,
            0
          );
        }
        offset = new Date().getTimezoneOffset() * 60 * 1e3;
        year = mon = day = null;
        hour = min = sec = 0;
        if (
          (m = dstr.match(
            /^(\d{4})-(\d{2})-(\d{2})[T ](\d{2}):(\d{2}):(\d{2}(?:\.\d+)?)(Z|([+-])(\d{2}):(\d{2}))$/
          ))
        ) {
          year = parseInt(m[1], 10);
          mon = parseInt(m[2], 10);
          day = parseInt(m[3], 10);
          hour = parseInt(m[4], 10);
          min = parseInt(m[5], 10);
          sec = parseInt(m[6], 10);
          offset =
            new Date(year, mon - 1, day, hour, min, sec).getTimezoneOffset() *
            60 *
            1e3;
          if (m[7] !== "Z") {
            offset +=
              (m[8] === "+" ? 1 : -1) *
              (parseInt(m[9], 10) * 60 + parseInt(m[10], 10)) *
              1e3 *
              60;
          }
        } else {
          log.warn("Time parse error! Unknown time pattern: " + dstr);
          return new Date(1970, 1, 1, 0, 0, 0);
        }
        log.debug("time parse (gap to local): " + offset);
        ret = new Date(
          new Date(year, mon - 1, day, hour, min, sec).getTime() - offset
        );
        log.debug("time parse: " + dstr + " -> ", ret);
        return ret;
      };
      gCalFlow.prototype.render_data = function (data) {
        var ci,
          desc_body_method,
          ed,
          ent,
          et,
          etf,
          gmapslink,
          ic,
          it,
          items,
          k,
          len1,
          link,
          ref1,
          ref2,
          sd,
          st,
          stf,
          t,
          titlelink;
        log.debug("start rendering for data:", data);
        t = this.template.clone();
        titlelink =
          (ref1 = this.opts.titlelink) != null
            ? ref1
            : "http://www.google.com/calendar/embed?src=" + this.opts.calid;
        if (this.opts.link_title) {
          t.find(".gcf-title").html(
            $("<a />")
              .attr({ target: this.opts.link_target, href: titlelink })
              .text(data.summary)
          );
        } else {
          t.find(".gcf-title").text(data.summary);
        }
        t.find(".gcf-link").attr({
          target: this.opts.link_target,
          href: titlelink,
        });
        t.find(".gcf-last-update").html(
          this.opts.date_formatter(this.parse_date(data.updated))
        );
        it = t.find(".gcf-item-block");
        it.detach();
        it = $(it[0]);
        log.debug("item block template:", it);
        items = $();
        log.debug("render entries:", data.items);
        if (this.opts.item_description_as_html) {
          desc_body_method = "html";
        } else {
          desc_body_method = "text";
        }
        if (data.items != null && data.items.length > 0) {
          ref2 = data.items.slice(0, +this.opts.maxitem + 1 || 9e9);
          for (k = 0, len1 = ref2.length; k < len1; k++) {
            ent = ref2[k];
            log.debug("formatting entry:", ent);
            ci = it.clone();
            if (ent.start) {
              if (ent.start.dateTime) {
                st = ent.start.dateTime;
              } else {
                st = ent.start.date;
              }
              sd = this.parse_date(st);
              stf = this.opts.date_formatter(sd, st.indexOf(":") < 0);
              ci.find(".gcf-item-date").html(stf);
              ci.find(".gcf-item-start-date").html(stf);
            }
            if (ent.end) {
              if (ent.end.dateTime) {
                et = ent.end.dateTime;
              } else {
                et = ent.end.date;
              }
              ed = this.parse_date(et);
              etf = this.opts.date_formatter(ed, et.indexOf(":") < 0);
              ci.find(".gcf-item-end-date").html(etf);
              ci.find(".gcf-item-daterange").html(
                this.opts.daterange_formatter(sd, ed, st.indexOf(":") < 0)
              );
            }
            ci.find(".gcf-item-update-date").html(
              this.opts.date_formatter(this.parse_date(ent.updated), false)
            );
            link = $("<a />").attr({
              target: this.opts.link_target,
              href: ent.htmlLink,
            });
            if (this.opts.link_item_title) {
              ci.find(".gcf-item-title").html(link.clone().text(ent.summary));
            } else {
              ci.find(".gcf-item-title").text(ent.summary);
            }
            if (this.opts.link_item_description) {
              ci.find(".gcf-item-description").html(
                link.clone()[desc_body_method](ent.description)
              );
            } else {
              ci.find(".gcf-item-description")[desc_body_method](ent.description);
            }
            if (this.opts.link_item_location && ent.location) {
              gmapslink =
                "<a href='https://www.google.com/maps/search/" +
                encodeURI(ent.location.toString().replace(" ", "+")) +
                "' target='new'>" +
                ent.location +
                "</a>";
              ci.find(".gcf-item-location").html(gmapslink);
            } else {
              ci.find(".gcf-item-location").text(ent.location);
            }
            ci.find(".gcf-item-link").attr({ href: ent.htmlLink });
            log.debug("formatted item entry:", ci[0]);
            items.push(ci[0]);
          }
        } else {
          items = $('<div class="gcf-no-items"></div>').html(
            this.opts.no_items_html
          );
        }
        log.debug("formatted item entry array:", items);
        ic = t.find(".gcf-item-container-block");
        log.debug("item container element:", ic);
        ic.html(items);
        this.target.html(t.html());
        this.bind_scroll();
        if (this.opts.callback) {
          return this.opts.callback.apply(this.target);
        }
      };
      gCalFlow.prototype.bind_scroll = function () {
        var scroll_children, scroll_container, scroll_timer, scroller, state;
        scroll_container = this.target.find(".gcf-item-container-block");
        scroll_children = scroll_container.find(".gcf-item-block");
        log.debug("scroll container:", scroll_container);
        if (
          !this.opts.auto_scroll ||
          scroll_container.size() < 1 ||
          scroll_children.size() < 2
        ) {
          return;
        }
        state = { idx: 0 };
        scroller = function () {
          var scroll_to;
          log.debug("current scroll position:", scroll_container.scrollTop());
          log.debug(
            "scroll capacity:",
            scroll_container[0].scrollHeight - scroll_container[0].clientHeight
          );
          if (
            typeof scroll_children[state.idx] === "undefined" ||
            scroll_container.scrollTop() >=
              scroll_container[0].scrollHeight - scroll_container[0].clientHeight
          ) {
            log.debug("scroll to top");
            state.idx = 0;
            return scroll_container.animate({
              scrollTop: scroll_children[0].offsetTop,
            });
          } else {
            scroll_to = scroll_children[state.idx].offsetTop;
            log.debug("scroll to " + scroll_to + "px");
            scroll_container.animate({ scrollTop: scroll_to });
            return (state.idx += 1);
          }
        };
        return (scroll_timer = setInterval(scroller, this.opts.scroll_interval));
      };
      return gCalFlow;
    })();
    methods = {
      init: function (opts) {
        var data;
        if (opts == null) {
          opts = {};
        }
        data = this.data("gCalFlow");
        if (!data) {
          return this.data("gCalFlow", {
            target: this,
            obj: new gCalFlow(this, opts),
          });
        }
      },
      destroy: function () {
        var data;
        data = this.data("gCalFlow");
        data.obj.target = null;
        $(window).unbind(".gCalFlow");
        data.gCalFlow.remove();
        return this.removeData("gCalFlow");
      },
      render: function () {
        if (
          typeof Globalize !== "undefined" &&
          Globalize !== null &&
          Globalize.culture != null
        ) {
          Globalize.culture(this.data("gCalFlow").obj.opts.globalize_culture);
        }
        return this.data("gCalFlow").obj.fetch();
      },
    };
    $.fn.gCalFlow = function (method) {
      var orig_args;
      orig_args = arguments;
      if (typeof method === "object" || !method) {
        return this.each(function () {
          methods.init.apply($(this), orig_args);
          return methods.render.apply($(this), orig_args);
        });
      } else if (methods[method]) {
        return this.each(function () {
          return methods[method].apply(
            $(this),
            Array.prototype.slice.call(orig_args, 1)
          );
        });
      } else if (method === "version") {
        return "3.0.2";
      } else {
        return $.error("Method " + method + " does not exist on jQuery.gCalFlow");
      }
    };
  }.call(this));
</script>
<?php }  ,9999); ?>