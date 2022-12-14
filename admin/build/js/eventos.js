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
        '<div class="gCalFlow">\n          <div class="gcf-header-block">\n              <div class="gcf-title-block">\n                  <span class="gcf-title">Nuestros Programas</span>\n              </div>\n          </div>\n          <hr size="1px" color="LightSlateGray"/>\n          <div class="gcf-item-container-block">\n                 <div class="gcf-item-block">\n                  <div class="gcf-item-header-block">\n                      <div class="gcf-item-date-block">\n                          <span class="gcf-item-daterange">\n                              <h2 class="no-margin">Mateo<br><span>28</span></h2>\n                              <br>\n                              <h3 class="no-margin">19<br><span>20</span></h3>\n                          </span>\n                      </div>\n                  </div>\n                  <div class="gcf-item-body-block">\n                      <div class="gcf-item-title-block">\n                          <strong class="gcf-item-title">Entrenamiento y Actividades</strong>\n                      </div>\n                      <div class="gcf-item-description">\n                          ???Ya est???s listo para ir, ser entrenado, y hacer disc???pulos? Echa un vistazo a nuestro opciones de formaci???n y diferentes actividades.\n                      </div>\n                      <div class="gcf-item-location">\n                          Evento\n                      </div>\n                  </div>\n                  <div class="btn-calendario">\n                      <a class="boton-roja" href="entrenamiento" role="button">Vamos</a>\n                  </div>\n              </div>\n          </div>\n          <hr size="1px" color="LightSlateGray"/>\n          <div class="gcf-last-update-block">\n              ???ltima actualizaci???n: <span class="gcf-last-update">-- -- ----</span>\n          </div>\n        </div>'
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
            //"Option calid and data_url are missing. Abort URL generation"
            "Faltan las opciones Id Calendario y/o Api-Key. Para ver los eventos"
          );
          this.target.text(
            //"Error: You need to set 'calid' or 'data_url' option."
            "Error: debe configurar la opcion 'Id Calendario' y 'Api-Key'."
          );
          throw "gCalFlow: faltan 'Id Calendario' y 'Api-Key'";
          //throw "gCalFlow: calid and data_url missing";
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
/*         log.debug(this.gcal_url());
        console.log(this.gcal_url()); */

        const arrayCal = this.gcal_url();
        const arrayAll = arrayCal['items'];
        console.log(arrayAll);
        // Solicitud GET (Request).//
         fetch(arrayCal)
          .then(response => response.json())  // convertir a json
          .then(data => mostrarData(data))  //  imprimir los datos en la consola
          .catch(err => console.log('Solicitud fallida', err)); // Capturar errores

          const mostrarData = (data) => {
            console.log(data);
            console.log(data['items']);

            let element = document.getElementById('elemen')
            element.innerHTML = `
              <p>${data.summary}</p>
              <p>${data.description}</p>
              `;
          }


        if (this.opts.apikey === this.constructor.demo_apikey) {
          log.warn(
            "You are using built-in demo API key! This key is provided for tiny use or demo only. Your access may be limited."
          );
          log.warn("Please check document and consider to use your own key.");
        }
        success_handler = (function (_this) {
          return function (data) {
            log.debug("Ajax call success. Response data:", data);
            log.debug(data);
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
  
  
  //console.log(t.find(".gcf-title").html);