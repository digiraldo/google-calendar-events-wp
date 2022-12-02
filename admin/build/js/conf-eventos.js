
/* -------------------------Configuracion Eventos------------------------- */
/* -------------------------Configuracion Eventos------------------------- */


_gCalFlow_debug = true;

var $ = jQuery;
  $(function() {
    $('#gcf-simple').gCalFlow({
      calid: 'Aqui su Id del calendario de Google',
      apikey: 'Aqui su Api Key'
    });
    $('#gcf-design').gCalFlow({
      calid: 'Aqui su Id del calendario de Google',
      apikey: 'Aqui su Api Key',
      maxitem: 10,
      date_formatter: function(d, allday_p) {
         return d.getDate() + "/" + (d.getMonth()+1) + "/" + d.getYear().toString().substr(-2)
         }
    });
    $('#gcf-ticker').gCalFlow({
        calid: 'Aqui su Id del calendario de Google',
        apikey: 'Aqui su Api Key',
        maxitem: 25,
        scroll_interval: 5 * 1000,
        daterange_formatter: function (start_date, end_date, allday_p) {
        function pad(n) { return n < 10 ? "0"+n : n; }
        var monthname = [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic" ];
        return pad(start_date.getDate()) + " " + pad(monthname[start_date.getMonth()]) + " - " + pad(end_date.getDate()) + " " + pad(monthname[end_date.getMonth()]);
        },
    });
    $('#gcf-custom-template').gCalFlow({
      calid: 'Aqui su Id del calendario de Google',
      apikey: 'Aqui su Api Key',
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