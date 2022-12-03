## Plugin para WordPress, que muestra Eventos del calendario de Google.

### google-calendar-events-wp (Google Calendar Events wp)

Eventos de Calendario de Google para tu Web, Muestra el calendario de Google como eventos dentro de una seccion de tu pagina web.

Author: digiraldo
Author URI: https://digiraldo.online/

### Insertar script desde functions.php

* Usaremos el archivo «functions.php» + la función add_action().

#### 1. ¿Cómo insertar un script javascript «EN LÍNEA» de forma correcta?
Insertar script en el HEAD (<head></head>):

* a) En el frontend
```
function mi_script() {
  echo '<script>console.log('Hola Mundo');</script>';
}
add_action( 'wp_head', 'mi_script' );
```

* b) En el backend o administrador
```
function mi_script() {
  echo '<script>console.log('Hola Mundo');</script>';
}
add_action( 'admin_head', 'mi_script' );
```


Insertar script en el FOOTER (al final del </body>):

* a) En el frontend
```
function mi_script() {
  echo '<script>console.log('Hola Mundo');</script>';
}
add_action( 'wp_footer', 'mi_script' );
```

* b) En el backend o administrador
```
function mi_script() {
  echo '<script>console.log('Hola Mundo');</script>';
}
add_action( 'admin_footer', 'mi_script' );
```


#### 2. ¿Cómo insertar un «ARCHIVO» javascript de forma correcta?

Si queremos en insertar un archivo js, debemos mejor usar la función wp_enqueue_script():


* a) En el frontend
```
add_action ('wp_enqueue_scripts', 'cargar_archivo_js');
function cargar_archivo_js () {
  wp_enqueue_script( 'mi-script', get_template_directory_uri() . '/js/mi-script.js', array(), '1.0.0', true );
}
```

* b) En un plugin sería muy similar:
```
add_action ('wp_enqueue_scripts', 'cargar_archivo_js');
function cargar_archivo_js () {
  wp_enqueue_script( 'mi-script', plugin_dir_url( __FILE__ ) . '/js/mi-script.js', array(), '1.0.0', true );
}
```



Resaltar codigos en pagina web: https://github.com/EnlighterJS/EnlighterJS