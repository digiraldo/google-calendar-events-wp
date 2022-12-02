<?php
global $wpdb;

$fondoConf = "{$wpdb->prefix}evento_fondo_conf";
$textoPred = "{$wpdb->prefix}evento_texto_pred";
$switchTxt = "{$wpdb->prefix}evento_switch_texto";


$idFondo = (isset($_POST['id_fondo'])) ? $_POST['id_fondo'] : "";
$apiKey = (isset($_POST['api_key'])) ? $_POST['api_key'] : "";
$idCal = (isset($_POST['id_cal'])) ? $_POST['id_cal'] : "";
$colorFondo = (isset($_POST['color_fondo'])) ? $_POST['color_fondo'] : "";

$colorBagFec = (isset($_POST['color_bag_fec'])) ? $_POST['color_bag_fec'] : "";
$colorporFec = (isset($_POST['color_por_fec'])) ? $_POST['color_por_fec'] : "";
$colorTxtFec = (isset($_POST['color_txt_fec'])) ? $_POST['color_txt_fec'] : "";

$colorBagDes = (isset($_POST['color_bag_des'])) ? $_POST['color_bag_des'] : "";
$colorporDes = (isset($_POST['color_por_des'])) ? $_POST['color_por_des'] : "";
$colorTxtTit = (isset($_POST['color_txt_tit'])) ? $_POST['color_txt_tit'] : "";
$colorTxtDes = (isset($_POST['color_txt_des'])) ? $_POST['color_txt_des'] : "";

$colorBagBot = (isset($_POST['color_bag_bot'])) ? $_POST['color_bag_bot'] : "";
$colorPorBot = (isset($_POST['color_por_bot'])) ? $_POST['color_por_bot'] : "";
$colorFonBtn = (isset($_POST['color_fon_btn'])) ? $_POST['color_fon_btn'] : "";
$colorTexBtn = (isset($_POST['color_tex_btn'])) ? $_POST['color_tex_btn'] : "";


$idTexto = (isset($_POST['id_texto'])) ? $_POST['id_texto'] : "";
$calTitle = (isset($_POST['cal_title'])) ? $_POST['cal_title'] : "";
$calFecha = (isset($_POST['cal_fecha'])) ? $_POST['cal_fecha'] : "";
$titleDesc = (isset($_POST['title_desc'])) ? $_POST['title_desc'] : "";
$descEvento = (isset($_POST['desc_evento'])) ? $_POST['desc_evento'] : "";
$titleLocation = (isset($_POST['title_location'])) ? $_POST['title_location'] : "";
$textUrl = (isset($_POST['text_url'])) ? $_POST['text_url'] : "";
$textBtn = (isset($_POST['text_btn'])) ? $_POST['text_btn'] : "";


$idSw = (isset($_POST['id_sw'])) ? $_POST['id_sw'] : "";
$dato = (isset($_POST['dato'])) ? $_POST['dato'] : "";


if (isset($_POST['btnGuardarConf'])) {
  $queryCalFon = "SELECT * FROM $textoPred ORDER BY id_fondo ASC";
  $resultadoCalFon = $wpdb->get_results($queryCalFon, ARRAY_A);
  $datosTextFon = $wpdb->prepare(
    "UPDATE {$wpdb->prefix}evento_fondo_conf SET
`id_fondo` = %s,
`api_key` = %s,
`id_cal` = %s,
`color_fondo` = %s,
`color_bag_fec` = %s,
`color_por_fec` = %s,
`color_txt_fec` = %s,
`color_bag_des` = %s,
`color_por_des` = %s,
`color_txt_tit` = %s,
`color_txt_des` = %s,
`color_bag_bot` = %s,
`color_por_bot` = %s,
`color_fon_btn` = %s,
`color_tex_btn` = %s WHERE
`id_fondo` = $idFondo",
    $idFondo,
    $apiKey,
    $idCal,
    $colorFondo,
    $colorBagFec,
    $colorporFec,
    $colorTxtFec,
    $colorBagDes,
    $colorporDes,
    $colorTxtTit,
    $colorTxtDes,
    $colorBagBot,
    $colorPorBot,
    $colorFonBtn,
    $colorTexBtn
  );
  $wpdb->query($datosTextFon);
}
/* 
echo '<pre>'; print_r($datosTextFon); echo '</pre>'; 
*/

if (isset($_POST['btnGuardarTxt'])) {
  $queryCalTex = "SELECT * FROM $textoPred ORDER BY id_texto ASC";
  $resultadoCal = $wpdb->get_results($queryCalTex, ARRAY_A);
  $datosTexto = $wpdb->prepare(
    "UPDATE {$wpdb->prefix}evento_texto_pred SET
`id_texto` = %s,
`cal_title` = %s,
`cal_fecha` = %s,
`title_desc` = %s,
`desc_evento` = %s,
`title_location` = %s,
`text_url` = %s,
`text_btn` = %s WHERE
`id_texto` = $idTexto",
    $idTexto,
    $calTitle,
    $calFecha,
    $titleDesc,
    $descEvento,
    $titleLocation,
    $textUrl,
    $textBtn
  );
  $wpdb->query($datosTexto);
}
/*
echo '<pre>'; print_r($datosTexto); echo '</pre>';
*/

if (isset($_POST['btnGuardarSw'])) {
  $querySwTex = "SELECT * FROM $switchTxt ORDER BY id_texto ASC";
  $resultadoSw = $wpdb->get_results($querySwTex, ARRAY_A);
  if ($dato == 'on') {
    $calId = 'gcf-custom-template';
    $Switch = 'checked';
    $estado = 'Activado';
    $estatus = 'on';
    $colBtn = 'btn-success';
    $typeBtn = 'hidden';
  } else {
    $calId = '';
    $Switch = '';
    $estado = 'Desactivado';
    $estatus = 'off';
    $colBtn = 'btn-light';
    $typeBtn = '';
  }
  $datosSwit = $wpdb->prepare(
    "UPDATE {$wpdb->prefix}evento_switch_texto SET
`id_sw` = %s,
`dato` = %s,
`cal_id` = %s,
`switch` = %s,
`estado` = %s,
`estatus` = %s,
`col_btn` = %s,
`type_btn` = %s WHERE
`id_sw` = $idSw",
    $idSw,
    $dato,
    $calId,
    $Switch,
    $estado,
    $estatus,
    $colBtn,
    $typeBtn
  );
  $wpdb->query($datosSwit);
}
/*
echo '<pre>'; print_r($datosSwit); echo '</pre>';
*/

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

/*  echo '<pre>'; print_r($listaSwText); echo '</pre>';*/

if ($listaFonConf[0]['color_por_fec'] == 'FF') {
  $porcentajeFecha = 'Transp. 100%';
} elseif ($listaFonConf[0]['color_por_fec'] == 'D9') {
  $porcentajeFecha = 'Transp. 85%';
} elseif ($listaFonConf[0]['color_por_fec'] == 'BF') {
  $porcentajeFecha = 'Transp. 75%';
} elseif ($listaFonConf[0]['color_por_fec'] == '80') {
  $porcentajeFecha = 'Transp. 50%';
} elseif ($listaFonConf[0]['color_por_fec'] == '40') {
  $porcentajeFecha = 'Transp. 25%';
} elseif ($listaFonConf[0]['color_por_fec'] == '26') {
  $porcentajeFecha = 'Transp. 15%';
} elseif ($listaFonConf[0]['color_por_fec'] == '0D') {
  $porcentajeFecha = 'Transp. 5%';
} else {
  $porcentajeFecha = 'Transparencia';
}

if ($listaFonConf[0]['color_por_des'] == 'FF') {
  $porcentajeDescripcion = 'Transp. 100%';
} elseif ($listaFonConf[0]['color_por_des'] == 'D9') {
  $porcentajeDescripcion = 'Transp. 85%';
} elseif ($listaFonConf[0]['color_por_des'] == 'BF') {
  $porcentajeDescripcion = 'Transp. 75%';
} elseif ($listaFonConf[0]['color_por_des'] == '80') {
  $porcentajeDescripcion = 'Transp. 50%';
} elseif ($listaFonConf[0]['color_por_des'] == '40') {
  $porcentajeDescripcion = 'Transp. 25%';
} elseif ($listaFonConf[0]['color_por_des'] == '26') {
  $porcentajeDescripcion = 'Transp. 15%';
} elseif ($listaFonConf[0]['color_por_des'] == '0D') {
  $porcentajeDescripcion = 'Transp. 55%';
} else {
  $porcentajeDescripcion = 'Transparencia';
}

if ($listaFonConf[0]['color_por_bot'] == 'FF') {
  $porcentajeBoton = 'Transp. 100%';
} elseif ($listaFonConf[0]['color_por_bot'] == 'D9') {
  $porcentajeBoton = 'Transp. 85%';
} elseif ($listaFonConf[0]['color_por_bot'] == 'BF') {
  $porcentajeBoton = 'Transp. 75%';
} elseif ($listaFonConf[0]['color_por_bot'] == '80') {
  $porcentajeBoton = 'Transp. 50%';
} elseif ($listaFonConf[0]['color_por_bot'] == '40') {
  $porcentajeBoton = 'Transp. 25%';
} elseif ($listaFonConf[0]['color_por_bot'] == '26') {
  $porcentajeBoton = 'Transp. 15%';
} elseif ($listaFonConf[0]['color_por_bot'] == '0D') {
  $porcentajeBoton = 'Transp. 5%';
} else {
  $porcentajeBoton = 'Transparencia';
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Eventos</title>
  <script src="https://kit.fontawesome.com/2a290a3f5e.js" crossorigin="anonymous"></script>
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

</head>

<body>

  <div class="container text-center text-white bg-dark" style=" height: 100%; width: 100%;">
    <div class="card-header">
      <i class="fa-solid fa-gear"></i> Configuración
    </div>
    <form class="row g-3" action="" method="post" enctype="multipart/form-data">
      <div class="card-body">
        <h5 class="card-title"><?php echo get_admin_page_title() ?></h5>
        <p class="card-text">Configuración del Calendario de Google.</p>
        <h6 class="card-title"><i class="fa-solid fa-file-code"></i> Colocar en Shortcode: <b>[eventos]</b></h6>
        <br>
        <div class="container text-center text-white bg-dark">
          <div class="card-header"><i class="fa-solid fa-fill-drip"></i> Color del Fondo</div>
          <div class="card-body">

            <div class="input-group col justify-content-center">
              <span class="input-group-text">Seleccione color de fondo</span>
              <div><input type="color" class="form-control form-control-color text-center" id="color_fondo" name="color_fondo" value="<?php echo $listaFonConf[0]['color_fondo']; ?>" title="Color fondo Calendario"></div>
              <span class="input-group-text"><i class="fa-solid fa-fill-drip"></i></span>
            </div>

          </div>
          <div class="card-footer text-muted">
            Seleccione el mismo color de fondo del calendario
          </div>
        </div>

        <br>
        <input type="hidden" required name="id_fondo" value="<?php echo $listaFonConf[0]['id_fondo']; ?>" placeholder="" id="id_fondo" requiere="">

        <div class="input-group mb-3">
          <span class="input-group-text" id="inputGroup-sizing-default">Api-Key</span>
          <input type="text" class="form-control" id="api_key" name="api_key" value="<?php echo $listaFonConf[0]['api_key']; ?>" placeholder="Introduzca la Api-Key de Google" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
          <span class="input-group-text"><i class="fa-solid fa-key"></i></span>
        </div>

        <div class="input-group mb-3">
          <span class="input-group-text" id="inputGroup-sizing-default">Id Calendario</span>
          <input type="text" class="form-control" id="id_cal" name="id_cal" value="<?php echo $listaFonConf[0]['id_cal']; ?>" placeholder="Introduzca Id del Calendario de Google" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
          <span class="input-group-text"><i class="fa-solid fa-calendar-check"></i></span>
        </div>
        <br>

        <div class="container text-center rounded" style="width: 100%; background-color: <?php echo $listaFonConf[0]['color_fondo'] ?>;">
          <div class="card-header">
            <i class="fa-solid fa-palette"></i> Color de Fondo
          </div>
          <div class="card-body">
            <div class="card-group">
              <!-- col justify-content-center -->
              <div class="card" style="padding: 2px 10px; background-color: <?php echo $listaFonConf[0]['color_bag_fec'], $listaFonConf[0]['color_por_fec']; ?>;">
                <div class="card-body input-group col-md" style="margin: 0; padding: 0;">
                  <span class="input-group-text" id="exampleColorInput" style="margin: 30px 0;">Fondo Fecha</span>
                  <div><input type="color" class="form-control form-control-color" id="color_bag_fec" name="color_bag_fec" value="<?php echo $listaFonConf[0]['color_bag_fec']; ?>" title="Seleccione color de fondo" style="margin: 30px 0;" /></div>
                  <select class="form-select dropdown-toggle" id="color_por_fec" name="color_por_fec" aria-label="Default select example" style="margin: 30px 0;">
                    <option class="dropdown-item" value="<?php echo $listaFonConf[0]['color_por_fec'] ?>" selected><?php echo $porcentajeFecha; ?></option>
                    <option class="dropdown-item" value="FF">100%</option>
                    <option class="dropdown-item" value="D9">85%</option>
                    <option class="dropdown-item" value="BF">75%</option>
                    <option class="dropdown-item" value="80">50%</option>
                    <option class="dropdown-item" value="40">25%</option>
                    <option class="dropdown-item" value="26">15%</option>
                    <option class="dropdown-item" value="0D">5%</option>
                  </select>
                  <div class="input-group mb-3 justify-content-center">
                    <span class="input-group-text" style="color: <?php echo $listaFonConf[0]['color_txt_fec']; ?>; background-color: rgba(255, 255, 255, 0.01);"> Color <b> Texto</b></span>
                    <div><input type="color" class="form-control form-control-color" id="color_txt_fec" name="color_txt_fec" value="<?php echo $listaFonConf[0]['color_txt_fec']; ?>" title="Color del Texto" style="margin-left: 0;"></div>
                  </div>
                </div>
              </div>
              <div class="card" style="padding: 2px 10px; background-color: <?php echo $listaFonConf[0]['color_bag_des'], $listaFonConf[0]['color_por_des']; ?>;">
                <div class="card-body input-group col-md" style="margin: 0; padding: 0;">
                  <span class="input-group-text" id="exampleColorInput" style="margin: 30px 0;">Fondo Evento</span>
                  <div><input type="color" class="form-control form-control-color" id="color_bag_des" name="color_bag_des" value="<?php echo $listaFonConf[0]['color_bag_des']; ?>" title="Seleccione color de fondo" style="margin: 30px 0;" /></div>
                  <select class="form-select dropdown-toggle" id="color_por_des" name="color_por_des" aria-label="Default select example" style="margin: 30px 0;">
                    <option class="dropdown-item" value="<?php echo $listaFonConf[0]['color_por_des'] ?>" selected><?php echo $porcentajeDescripcion; ?></option>
                    <option class="dropdown-item" value="FF">100%</option>
                    <option class="dropdown-item" value="D9">85%</option>
                    <option class="dropdown-item" value="BF">75%</option>
                    <option class="dropdown-item" value="80">50%</option>
                    <option class="dropdown-item" value="40">25%</option>
                    <option class="dropdown-item" value="26">15%</option>
                    <option class="dropdown-item" value="0D">5%</option>
                  </select>
                  <div class="input-group mb-3 justify-content-center">
                    <span class="input-group-text" style="color: <?php echo $listaFonConf[0]['color_txt_tit']; ?>; background-color: rgba(255, 255, 255, 0.01);"> Color <b> Título</b></span>
                    <div><input type="color" class="form-control form-control-color" id="color_txt_tit" name="color_txt_tit" value="<?php echo $listaFonConf[0]['color_txt_tit']; ?>" title="Color Texto Título" style="margin-right: 10px;" /></div>
                    <span class="input-group-text" style="color: <?php echo $listaFonConf[0]['color_txt_des']; ?>; background-color: rgba(255, 255, 255, 0.01);"> Color <b> Descrip</b></span>
                    <div><input type="color" class="form-control form-control-color" id="color_txt_des" name="color_txt_des" value="<?php echo $listaFonConf[0]['color_txt_des']; ?>" title="Color Texto Descripción" style="margin-left: 0;" /></div>
                  </div>
                </div>
              </div>
              <div class="card" style="padding: 2px 10px; background-color: <?php echo $listaFonConf[0]['color_bag_bot'], $listaFonConf[0]['color_por_bot']; ?>;">
                <div class="card-body input-group col-md" style="margin: 0; padding: 0;">
                  <span class="input-group-text" id="exampleColorInput" style="margin: 30px 0;">Fondo Botón</span>
                  <div><input type="color" class="form-control form-control-color" id="color_bag_bot" name="color_bag_bot" value="<?php echo $listaFonConf[0]['color_bag_bot']; ?>" title="Seleccione color de fondo" style="margin: 30px 0;" /></div>
                  <select class="form-select dropdown-toggle" id="color_por_bot" name="color_por_bot" aria-label="Default select example" style="margin: 30px 0;" />
                  <option class="dropdown-item" value="<?php echo $listaFonConf[0]['color_por_bot'] ?>" selected><?php echo $porcentajeBoton; ?></option>
                  <option class="dropdown-item" value="FF">100%</option>
                  <option class="dropdown-item" value="D9">85%</option>
                  <option class="dropdown-item" value="BF">75%</option>
                  <option class="dropdown-item" value="80">50%</option>
                  <option class="dropdown-item" value="40">25%</option>
                  <option class="dropdown-item" value="26">15%</option>
                  <option class="dropdown-item" value="0D">5%</option>
                  </select>
                  <div class="input-group mb-3 justify-content-center">

                    <a class="btn-roja" role="button"><?php echo $listaTextPred[0]['text_btn']; ?></a>
                    <div class="row">
                      <input type="color" class="form-control form-control-color" id="color_fon_btn" name="color_fon_btn" value="<?php echo $listaFonConf[0]['color_fon_btn']; ?>" title="color fondo del botón" style="margin-left: 5px;" />
                      <input type="color" class="form-control form-control-color" id="color_tex_btn" name="color_tex_btn" value="<?php echo $listaFonConf[0]['color_tex_btn']; ?>" title="color texto del botón" style="margin-left: 5px;" />
                    </div>
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked"  <?php echo $listaSwText[0]['switch']; ?>/>
                      <label class="form-check-label" for="flexSwitchCheckChecked"><?php echo $listaSwText[0]['estado']; ?></label>
                    </div>
                  </div>
                </div>
              </div>
            </div> <!-- card-group -->
          </div>
          <div class="card-footer text-muted">
            Color del Fondo
          </div>
        </div> <!-- card text-center -->

        <br>
        <button type="submit" class="btn btn-primary" id="btnGuardarConf" name="btnGuardarConf"><i class="fa-solid fa-floppy-disk"></i> Guardar</button>
    </form>
    <br>
    <div class="card-footer text-muted">
     Colocar Shortcode: <b>[eventos]</b>
    </div>


    <div class="container text-center card text-white bg-dark mb-3" style="width: 100%;">
      <div class="card-header"><i class="fa-solid fa-eye"></i> Previsualizar Eventos</div>
      <div class="card-body">

        <form action="" method="post" role="form" enctype="multipart/form-data" id="resetPost">

          <label class="toggle">
            <span class="toggle-label">Ver Eventos: </span>
            <input type="hidden" required name="id_sw" value="<?php echo $listaSwText[0]['id_sw']; ?>" placeholder="" id="id_sw" requiere="">
            <input class="toggle-checkbox" type="checkbox" id="switch" name="dato" placeholder="" <?php echo $listaSwText[0]['switch']; ?> />
            <div class="toggle-switch"></div>
            <span class="toggle-label"><?php echo $listaSwText[0]['estado']; ?> </span>
          </label>
          <button type="submit" id="btnGuardarSw" name="btnGuardarSw" class="btn btn-sm rounded-circle <?php echo $listaSwText[0]['col_btn']; ?>"><i class="fa-solid fa-floppy-disk"></i></button>
          <button type="button" class="btn btn-sm rounded-circle btn-info" id="btn-nuevo" <?php echo $listaSwText[0]['type_btn']; ?>><i class="fa-solid fa-pen-to-square"></i></button>

        </form>
        <br>
        <h5 class="card-title rounded" style=" background-color: <?php echo $listaFonConf[0]['color_fondo'] ?>;">

          <div class="gCalFlow" id="<?php echo $listaSwText[0]['cal_id']; ?>">
            <div class="gcf-header-block">
              <div class="gcf-title-block">
                <span class="gcf-title"><?php echo $listaTextPred[0]['cal_title']; ?></span>
              </div>
            </div>
            <hr size="1px" color="LightSlateGray" />
            <div class="gcf-item-container-block">
              <div class="gcf-item-block">
                <div class="gcf-item-header-block">
                  <div class="gcf-item-date-block">
                    <span class="gcf-item-daterange">
                      <h2 class="no-margin"><span></span></h2>
                      <br>
                      <h3 class="no-margin"><?php echo $listaTextPred[0]['cal_fecha']; ?><br><span></span></h3>
                    </span>
                  </div>
                </div>
                <div class="gcf-item-body-block">
                  <div class="gcf-item-title-block">
                    <strong class="gcf-item-title"><?php echo $listaTextPred[0]['title_desc']; ?></strong>
                  </div>
                  <div class="gcf-item-description">
                    <?php echo $listaTextPred[0]['desc_evento']; ?>
                  </div>
                  <div class="gcf-item-location">
                    <?php echo $listaTextPred[0]['title_location']; ?>
                  </div>
                </div>
                <div class="btn-calendario">
                  <a href="<?php echo $listaTextPred[0]['text_url']; ?>" class="boton-roja" role="button"><?php echo $listaTextPred[0]['text_btn']; ?></a>
                </div>
              </div>
            </div>
            <hr size="1px" color="LightSlateGray" />
            <div class="gcf-last-update-block">
              Última actualización: <span class="gcf-last-update"></span>
            </div>
          </div> <!-- gCalFlow -->

      </div>
      <div class="card-footer text-muted">
        Más información en: <img src="/wordpress/wp-content/plugins/google-calendar-events-wp/admin/img/DiGiraldo-18px.png" alt="image desc" /> <a href="https://digiraldo.online" target="_blank">DiGiraldo</a>
      </div>
    </div>
  </div>
  <!-- /wordpress/wp-content/plugins/google-calendar-events-wp/ -->

  <!-- Modal -->
  <div class="modal fade" id="even-conf" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content bg-dark">
        <!-- text-white bg-dark -->
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel"><i class="fa-solid fa-pen-to-square"></i> Editar Texto Predeterminado</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="" method="post" enctype="multipart/form-data">

          <div class="modal-body">
            <div class="form-group">

              <input type="hidden" required name="id_texto" value="<?php echo $listaTextPred[0]['id_texto']; ?>" placeholder="" id="id_texto" requiere="">

              <div class="input-group mb-3">
                <span class="input-group-text" id="cal_fecha" style="color: black;">Título Calendario</span>
                <input type="text" class="form-control" id="cal_title" name="cal_title" value="<?php echo $listaTextPred[0]['cal_title']; ?>" placeholder="Título Calendario" aria-label="Username" aria-describedby="basic-addon1">
              </div>
              <div class="input-group mb-3">
                <span class="input-group-text" id="cal_fecha" style="background-color: <?php echo $listaFonConf[0]['color_bag_fec'], $listaFonConf[0]['color_por_fec']; ?>; color: <?php echo $listaFonConf[0]['color_txt_fec']; ?>;">Texto Fecha</span>
                <input type="text" class="form-control" id="cal_fecha" name="cal_fecha" value="<?php echo $listaTextPred[0]['cal_fecha']; ?>" placeholder="" aria-label="Username" aria-describedby="basic-addon1">
              </div>
              <div class="input-group mb-3">
                <span class="input-group-text" id="title_desc" style="background-color: <?php echo $listaFonConf[0]['color_bag_des'], $listaFonConf[0]['color_por_des']; ?>; color: <?php echo $listaFonConf[0]['color_txt_tit']; ?>">Título Descripción</span>
                <input type="text" class="form-control" id="title_desc" name="title_desc" value="<?php echo $listaTextPred[0]['title_desc']; ?>" placeholder="" aria-label="Username" aria-describedby="basic-addon1">
              </div>
              <div class="input-group mb-3">
                <span class="input-group-text" style="background-color: <?php echo $listaFonConf[0]['color_bag_des'], $listaFonConf[0]['color_por_des']; ?>; color: <?php echo $listaFonConf[0]['color_txt_des']; ?>" id="desc_evento">Descripción</span>
                <textarea class="form-control" aria-label="With textarea" id="desc_evento" name="desc_evento" placeholder=""><?php echo $listaTextPred[0]['desc_evento']; ?></textarea>
              </div>
              <div class="input-group mb-3">
                <span class="input-group-text" style="background-color: <?php echo $listaFonConf[0]['color_bag_des'], $listaFonConf[0]['color_por_des']; ?>; color: <?php echo $listaFonConf[0]['color_txt_tit']; ?>" id="title_location">Ubicación</span>
                <input type="text" class="form-control" aria-label="With textarea" id="title_location" name="title_location" value="<?php echo $listaTextPred[0]['title_location']; ?>" placeholder="">
              </div>
              <div class="input-group mb-3">
                <span class="input-group-text" id="text_btn" style="background-color: <?php echo $listaFonConf[0]['color_bag_bot'], $listaFonConf[0]['color_por_bot']; ?>; color: <?php echo $listaFonConf[0]['color_tex_btn']; ?>;">Título Botón</span>
                <input type="text" class="form-control" id="text_btn" name="text_btn" value="<?php echo $listaTextPred[0]['text_btn']; ?>" placeholder="" aria-label="Username" aria-describedby="basic-addon1">
                <button class="btn-roja btn" type="button" id="text_btn"><?php echo $listaTextPred[0]['text_btn']; ?></button>
              </div>
              <div class="input-group mb-3">
                <span class="input-group-text" id="text_url">Url de Botón</span>
                <input type="text" class="form-control" id="text_url" name="text_url" value="<?php echo $listaTextPred[0]['text_url']; ?>" placeholder="" aria-label="Username" aria-describedby="basic-addon1">
                <button class="btn-roja btn" type="button" id="text_url"><i class="fa-solid fa-link"></i></button>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fa-solid fa-rectangle-xmark"></i> Cerrar</button>
            <button type="submit" class="btn btn-primary" name="btnGuardarTxt" id="btnGuardarTxt"><i class="fa-solid fa-floppy-disk"></i> Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
/* -------------------------Configuración id Eventos api_key id_cal------------------------- */
/* -------------------------Configuración id Eventos api_key id_cal------------------------- */

_gCalFlow_debug = true;

var $ = jQuery;
  $(function() {
    $('#gcf-simple').gCalFlow({
      calid: '<?php echo $listaFonConf[0]['id_cal']; ?>',
      apikey: '<?php echo $listaFonConf[0]['api_key']; ?>'
    });
    $('#gcf-design').gCalFlow({
      calid: '<?php echo $listaFonConf[0]['id_cal']; ?>',
      apikey: '<?php echo $listaFonConf[0]['api_key']; ?>',
      maxitem: 10,
      date_formatter: function(d, allday_p) {
         return d.getDate() + "/" + (d.getMonth()+1) + "/" + d.getYear().toString().substr(-2)
         }
    });
    $('#gcf-ticker').gCalFlow({
        calid: '<?php echo $listaFonConf[0]['id_cal']; ?>',
        apikey: '<?php echo $listaFonConf[0]['api_key']; ?>',
        maxitem: 25,
        scroll_interval: 5 * 1000,
        daterange_formatter: function (start_date, end_date, allday_p) {
        function pad(n) { return n < 10 ? "0"+n : n; }
        var monthname = [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic" ];
        return pad(start_date.getDate()) + " " + pad(monthname[start_date.getMonth()]) + " - " + pad(end_date.getDate()) + " " + pad(monthname[end_date.getMonth()]);
        },
    });
    $('#gcf-custom-template').gCalFlow({
      calid: '<?php echo $listaFonConf[0]['id_cal']; ?>',
      apikey: '<?php echo $listaFonConf[0]['api_key']; ?>',
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
</script>
</body>

</html>