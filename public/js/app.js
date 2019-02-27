var _typeof2 = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

function addListeners() {
    $("[data-post]").on("click", function (t) {
        return t.preventDefault(), $('<form action="' + $(this).attr("href") + '" method="POST"><input type="hidden" name="_token" value="' + csrf_token + '"></form>').appendTo("body").submit();
    }), $("[data-delete]").on("click", function (t) {
        var e = $(this).attr("data-delete");return -1 === e.indexOf("confirm") || confirm(confirmDelete) ? -1 !== e.indexOf("ajax") ? (t.preventDefault(), callAjax($(this).attr("href"), { _method: "delete" })) : -1 !== e.indexOf("resource") ? (t.preventDefault(), $('<form action="' + $(this).attr("href") + '" method="POST"><input type="hidden" name="_method" value="DELETE"><input type="hidden" name="_token" value="' + csrf_token + '"></form>').appendTo("body").submit()) : void (confirm(confirmDelete) || t.preventDefault()) : t.preventDefault();
    }), $(".ajax").on("click", function (t) {
        t.preventDefault(), callAjax($(this).attr("href"));
    }), $(".showPopup").on("click", function (t) {
        t.preventDefault(), showPopup($(this).attr("href"));
    });
}function showPopup(t) {
    $("#popup").popup("show"), $("#popupContent").html('Loading... <i class="fa fa-circle-o-notch fa-spin"></i>'), loadPopup(t);
}function setupFormLoadingImage() {
    $("form").submit(function (t) {
        return $(".loadingImage").show(), !0;
    });
}function loadPopup(t) {
    $("#popupContent").load(t, function (e, n, i) {
        console.log("ok", t, n), $(".loadingImage").hide(), "error" == n ? $("#popupContent").html("Error while loading: " + i.status + " " + i.statusText) : setupFormLoadingImage();
    });
}function loadPostPopup(t, e) {
    $.post(t, e, function (t) {
        $("#popupContent").show().html(t);
    });
}function hidePopup() {
    if (didPopupReload) return location.reload();$("#popup").popup("hide");
}function reloadPopup() {
    didPopupReload = !0, loadPopup(popupUrl);
}function callAjax(t, e) {
    -1 != window.location.href.toString().search("public") && (t = "/revo-retail/public" + t), e = e ? $.extend({}, e, { _token: csrf_token }) : { _token: csrf_token }, $.post(t, e, function () {}).done(function (t) {
        t && ($(".loadingImage").hide(), showMessage("done"), reloadPopup());
    }).fail(function (t) {
        console.log(t), $(".loadingImage").hide(), showMessage(t.responseText);
    });
}function saveOrder(t) {
    $(".loadingImage").show(), postSaveOrder(window.location.origin + "/thrust/" + t + "/updateOrder", ".sortable");
}function saveChildOrder(t, e, n) {
    $(".loadingImage").show(), postSaveOrder(window.location.origin + "/thrust/" + t + "/" + e + "/belongsToMany/" + n + "/updateOrder", ".sortableChild");
}function postSaveOrder(t, e) {
    var n = $(e).sortable("serialize");n = n + "&_token=" + csrf_token, console.log("Url:" + t), console.log("Serialized:" + n), $.post(t, n, function () {}).done(function (t) {
        t && ($(".loadingImage").hide(), console.log(t), showMessage("orderSaved"));
    }).fail(function (t) {
        $(".loadingImage").hide(), showMessage("orderNotSaved");
    });
}function showMessage(t, e) {
    $("#popupMessage").fadeIn("slow", function () {
        $("#popupMessage").delay(1200).fadeOut(400);
    }).html(parseMessage(t, e));
}function parseMessage(t, e) {
    return replaceValuesOnMessage(getTranslatedMessage(t), e);
}function getTranslatedMessage(t) {
    return lang[t] ? lang[t] : t;
}function replaceValuesOnMessage(t, e) {
    if (!e) return t;for (var n = 0; n < e.length; n++) {
        var i = new RegExp("\\{" + n + "\\}", "gm");t = t.replace(i, e[n]);
    }return t;
}function hideMessage() {
    $("#message").stop().fadeOut();
}function drawIcon(t) {
    return $("<i>", { class: "fa fa-" + t + " revo-awesome", style: "font-size: 16px;", "aria-hidden": "true" });
}function RVAjaxSelect2(t, e) {
    this.options = { width: "300px", dropdownAutoWidth: !0, ajax: { url: t, dataType: "json", type: "GET", quietMillis: 300, delay: 250, cache: !0, data: function data(t) {
                return { search: t.term };
            }, processResults: function processResults(t) {
                return { results: $.map(t, function (t) {
                        return { id: t.id, value: t.id, text: t.name };
                    }) };
            } } }, $.extend(this.options, e), this.show = function (t) {
        return $(t).select2(this.options);
    };
}function setupVisibility(t) {
    $.each(t, function (t, e) {
        setupFormFieldVisibility(t, e);
    });
}function setupFormFieldVisibility(t, e) {
    showOrHideFormVisibility(t, e, !1), $("#" + e.field).change(function (n) {
        showOrHideFormVisibility(t, e, !0);
    });
}function showOrHideFormVisibility(t, e, n) {
    var i = n ? "fast" : 0;$("#" + e.field).val() == e.value ? $("#panel_" + t).hide(i) : $("#panel_" + t).show(i);
}var _typeof = "function" == typeof Symbol && "symbol" == _typeof2(Symbol.iterator) ? function (t) {
    return typeof t === "undefined" ? "undefined" : _typeof2(t);
} : function (t) {
    return t && "function" == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t === "undefined" ? "undefined" : _typeof2(t);
};!function (t, e) {
    "object" == ("undefined" == typeof module ? "undefined" : _typeof(module)) && "object" == _typeof(module.exports) ? module.exports = t.document ? e(t, !0) : function (t) {
        if (!t.document) throw new Error("jQuery requires a window with a document");return e(t);
    } : e(t);
}("undefined" != typeof window ? window : this, function (t, e) {
    function n(t) {
        var e = t.length,
            n = tt.type(t);return "function" !== n && !tt.isWindow(t) && (!(1 !== t.nodeType || !e) || "array" === n || 0 === e || "number" == typeof e && e > 0 && e - 1 in t);
    }function i(t, e, n) {
        if (tt.isFunction(e)) return tt.grep(t, function (t, i) {
            return !!e.call(t, i, t) !== n;
        });if (e.nodeType) return tt.grep(t, function (t) {
            return t === e !== n;
        });if ("string" == typeof e) {
            if (at.test(e)) return tt.filter(e, t, n);e = tt.filter(e, t);
        }return tt.grep(t, function (t) {
            return V.call(e, t) >= 0 !== n;
        });
    }function o(t, e) {
        for (; (t = t[e]) && 1 !== t.nodeType;) {}return t;
    }function s(t) {
        var e = dt[t] = {};return tt.each(t.match(pt) || [], function (t, n) {
            e[n] = !0;
        }), e;
    }function r() {
        J.removeEventListener("DOMContentLoaded", r, !1), t.removeEventListener("load", r, !1), tt.ready();
    }function a() {
        Object.defineProperty(this.cache = {}, 0, { get: function get() {
                return {};
            } }), this.expando = tt.expando + Math.random();
    }function l(t, e, n) {
        var i;if (void 0 === n && 1 === t.nodeType) if (i = "data-" + e.replace(bt, "-$1").toLowerCase(), "string" == typeof (n = t.getAttribute(i))) {
            try {
                n = "true" === n || "false" !== n && ("null" === n ? null : +n + "" === n ? +n : yt.test(n) ? tt.parseJSON(n) : n);
            } catch (t) {}vt.set(t, e, n);
        } else n = void 0;return n;
    }function c() {
        return !0;
    }function u() {
        return !1;
    }function h() {
        try {
            return J.activeElement;
        } catch (t) {}
    }function p(t, e) {
        return tt.nodeName(t, "table") && tt.nodeName(11 !== e.nodeType ? e : e.firstChild, "tr") ? t.getElementsByTagName("tbody")[0] || t.appendChild(t.ownerDocument.createElement("tbody")) : t;
    }function d(t) {
        return t.type = (null !== t.getAttribute("type")) + "/" + t.type, t;
    }function f(t) {
        var e = Lt.exec(t.type);return e ? t.type = e[1] : t.removeAttribute("type"), t;
    }function g(t, e) {
        for (var n = 0, i = t.length; i > n; n++) {
            mt.set(t[n], "globalEval", !e || mt.get(e[n], "globalEval"));
        }
    }function m(t, e) {
        var n, i, o, s, r, a, l, c;if (1 === e.nodeType) {
            if (mt.hasData(t) && (s = mt.access(t), r = mt.set(e, s), c = s.events)) {
                delete r.handle, r.events = {};for (o in c) {
                    for (n = 0, i = c[o].length; i > n; n++) {
                        tt.event.add(e, o, c[o][n]);
                    }
                }
            }vt.hasData(t) && (a = vt.access(t), l = tt.extend({}, a), vt.set(e, l));
        }
    }function v(t, e) {
        var n = t.getElementsByTagName ? t.getElementsByTagName(e || "*") : t.querySelectorAll ? t.querySelectorAll(e || "*") : [];return void 0 === e || e && tt.nodeName(t, e) ? tt.merge([t], n) : n;
    }function y(t, e) {
        var n = e.nodeName.toLowerCase();"input" === n && Ct.test(t.type) ? e.checked = t.checked : ("input" === n || "textarea" === n) && (e.defaultValue = t.defaultValue);
    }function b(e, n) {
        var i = tt(n.createElement(e)).appendTo(n.body),
            o = t.getDefaultComputedStyle ? t.getDefaultComputedStyle(i[0]).display : tt.css(i[0], "display");return i.detach(), o;
    }function w(t) {
        var e = J,
            n = Rt[t];return n || (n = b(t, e), "none" !== n && n || (Ht = (Ht || tt("<iframe frameborder='0' width='0' height='0'/>")).appendTo(e.documentElement), e = Ht[0].contentDocument, e.write(), e.close(), n = b(t, e), Ht.detach()), Rt[t] = n), n;
    }function _(t, e, n) {
        var i,
            o,
            s,
            r,
            a = t.style;return n = n || Wt(t), n && (r = n.getPropertyValue(e) || n[e]), n && ("" !== r || tt.contains(t.ownerDocument, t) || (r = tt.style(t, e)), qt.test(r) && Mt.test(e) && (i = a.width, o = a.minWidth, s = a.maxWidth, a.minWidth = a.maxWidth = a.width = r, r = n.width, a.width = i, a.minWidth = o, a.maxWidth = s)), void 0 !== r ? r + "" : r;
    }function x(t, e) {
        return { get: function get() {
                return t() ? void delete this.get : (this.get = e).apply(this, arguments);
            } };
    }function C(t, e) {
        if (e in t) return e;for (var n = e[0].toUpperCase() + e.slice(1), i = e, o = Yt.length; o--;) {
            if ((e = Yt[o] + n) in t) return e;
        }return i;
    }function T(t, e, n) {
        var i = Bt.exec(e);return i ? Math.max(0, i[1] - (n || 0)) + (i[2] || "px") : e;
    }function S(t, e, n, i, o) {
        for (var s = n === (i ? "border" : "content") ? 4 : "width" === e ? 1 : 0, r = 0; 4 > s; s += 2) {
            "margin" === n && (r += tt.css(t, n + _t[s], !0, o)), i ? ("content" === n && (r -= tt.css(t, "padding" + _t[s], !0, o)), "margin" !== n && (r -= tt.css(t, "border" + _t[s] + "Width", !0, o))) : (r += tt.css(t, "padding" + _t[s], !0, o), "padding" !== n && (r += tt.css(t, "border" + _t[s] + "Width", !0, o)));
        }return r;
    }function A(t, e, n) {
        var i = !0,
            o = "width" === e ? t.offsetWidth : t.offsetHeight,
            s = Wt(t),
            r = "border-box" === tt.css(t, "boxSizing", !1, s);if (0 >= o || null == o) {
            if (o = _(t, e, s), (0 > o || null == o) && (o = t.style[e]), qt.test(o)) return o;i = r && (Q.boxSizingReliable() || o === t.style[e]), o = parseFloat(o) || 0;
        }return o + S(t, e, n || (r ? "border" : "content"), i, s) + "px";
    }function E(t, e) {
        for (var n, i, o, s = [], r = 0, a = t.length; a > r; r++) {
            i = t[r], i.style && (s[r] = mt.get(i, "olddisplay"), n = i.style.display, e ? (s[r] || "none" !== n || (i.style.display = ""), "" === i.style.display && xt(i) && (s[r] = mt.access(i, "olddisplay", w(i.nodeName)))) : s[r] || (o = xt(i), (n && "none" !== n || !o) && mt.set(i, "olddisplay", o ? n : tt.css(i, "display"))));
        }for (r = 0; a > r; r++) {
            i = t[r], i.style && (e && "none" !== i.style.display && "" !== i.style.display || (i.style.display = e ? s[r] || "" : "none"));
        }return t;
    }function P(t, e, n, i, o) {
        return new P.prototype.init(t, e, n, i, o);
    }function k() {
        return setTimeout(function () {
            Kt = void 0;
        }), Kt = tt.now();
    }function D(t, e) {
        var n,
            i = 0,
            o = { height: t };for (e = e ? 1 : 0; 4 > i; i += 2 - e) {
            n = _t[i], o["margin" + n] = o["padding" + n] = t;
        }return e && (o.opacity = o.width = t), o;
    }function O(t, e, n) {
        for (var i, o = (ee[e] || []).concat(ee["*"]), s = 0, r = o.length; r > s; s++) {
            if (i = o[s].call(n, e, t)) return i;
        }
    }function $(t, e, n) {
        var i,
            o,
            s,
            r,
            a,
            l,
            c,
            u = this,
            h = {},
            p = t.style,
            d = t.nodeType && xt(t),
            f = mt.get(t, "fxshow");n.queue || (a = tt._queueHooks(t, "fx"), null == a.unqueued && (a.unqueued = 0, l = a.empty.fire, a.empty.fire = function () {
            a.unqueued || l();
        }), a.unqueued++, u.always(function () {
            u.always(function () {
                a.unqueued--, tt.queue(t, "fx").length || a.empty.fire();
            });
        })), 1 === t.nodeType && ("height" in e || "width" in e) && (n.overflow = [p.overflow, p.overflowX, p.overflowY], c = tt.css(t, "display"), "none" === c && (c = w(t.nodeName)), "inline" === c && "none" === tt.css(t, "float") && (p.display = "inline-block")), n.overflow && (p.overflow = "hidden", u.always(function () {
            p.overflow = n.overflow[0], p.overflowX = n.overflow[1], p.overflowY = n.overflow[2];
        }));for (i in e) {
            if (o = e[i], Qt.exec(o)) {
                if (delete e[i], s = s || "toggle" === o, o === (d ? "hide" : "show")) {
                    if ("show" !== o || !f || void 0 === f[i]) continue;d = !0;
                }h[i] = f && f[i] || tt.style(t, i);
            }
        }if (!tt.isEmptyObject(h)) {
            f ? "hidden" in f && (d = f.hidden) : f = mt.access(t, "fxshow", {}), s && (f.hidden = !d), d ? tt(t).show() : u.done(function () {
                tt(t).hide();
            }), u.done(function () {
                var e;mt.remove(t, "fxshow");for (e in h) {
                    tt.style(t, e, h[e]);
                }
            });for (i in h) {
                r = O(d ? f[i] : 0, i, u), i in f || (f[i] = r.start, d && (r.end = r.start, r.start = "width" === i || "height" === i ? 1 : 0));
            }
        }
    }function I(t, e) {
        var n, i, o, s, r;for (n in t) {
            if (i = tt.camelCase(n), o = e[i], s = t[n], tt.isArray(s) && (o = s[1], s = t[n] = s[0]), n !== i && (t[i] = s, delete t[n]), (r = tt.cssHooks[i]) && "expand" in r) {
                s = r.expand(s), delete t[i];for (n in s) {
                    n in t || (t[n] = s[n], e[n] = o);
                }
            } else e[i] = o;
        }
    }function N(t, e, n) {
        var i,
            o,
            s = 0,
            r = te.length,
            a = tt.Deferred().always(function () {
            delete l.elem;
        }),
            l = function l() {
            if (o) return !1;for (var e = Kt || k(), n = Math.max(0, c.startTime + c.duration - e), i = n / c.duration || 0, s = 1 - i, r = 0, l = c.tweens.length; l > r; r++) {
                c.tweens[r].run(s);
            }return a.notifyWith(t, [c, s, n]), 1 > s && l ? n : (a.resolveWith(t, [c]), !1);
        },
            c = a.promise({ elem: t, props: tt.extend({}, e), opts: tt.extend(!0, { specialEasing: {} }, n), originalProperties: e, originalOptions: n, startTime: Kt || k(), duration: n.duration, tweens: [], createTween: function createTween(e, n) {
                var i = tt.Tween(t, c.opts, e, n, c.opts.specialEasing[e] || c.opts.easing);return c.tweens.push(i), i;
            }, stop: function stop(e) {
                var n = 0,
                    i = e ? c.tweens.length : 0;if (o) return this;for (o = !0; i > n; n++) {
                    c.tweens[n].run(1);
                }return e ? a.resolveWith(t, [c, e]) : a.rejectWith(t, [c, e]), this;
            } }),
            u = c.props;for (I(u, c.opts.specialEasing); r > s; s++) {
            if (i = te[s].call(c, t, u, c.opts)) return i;
        }return tt.map(u, O, c), tt.isFunction(c.opts.start) && c.opts.start.call(t, c), tt.fx.timer(tt.extend(l, { elem: t, anim: c, queue: c.opts.queue })), c.progress(c.opts.progress).done(c.opts.done, c.opts.complete).fail(c.opts.fail).always(c.opts.always);
    }function L(t) {
        return function (e, n) {
            "string" != typeof e && (n = e, e = "*");var i,
                o = 0,
                s = e.toLowerCase().match(pt) || [];if (tt.isFunction(n)) for (; i = s[o++];) {
                "+" === i[0] ? (i = i.slice(1) || "*", (t[i] = t[i] || []).unshift(n)) : (t[i] = t[i] || []).push(n);
            }
        };
    }function j(t, e, n, i) {
        function o(a) {
            var l;return s[a] = !0, tt.each(t[a] || [], function (t, a) {
                var c = a(e, n, i);return "string" != typeof c || r || s[c] ? r ? !(l = c) : void 0 : (e.dataTypes.unshift(c), o(c), !1);
            }), l;
        }var s = {},
            r = t === be;return o(e.dataTypes[0]) || !s["*"] && o("*");
    }function z(t, e) {
        var n,
            i,
            o = tt.ajaxSettings.flatOptions || {};for (n in e) {
            void 0 !== e[n] && ((o[n] ? t : i || (i = {}))[n] = e[n]);
        }return i && tt.extend(!0, t, i), t;
    }function H(t, e, n) {
        for (var i, o, s, r, a = t.contents, l = t.dataTypes; "*" === l[0];) {
            l.shift(), void 0 === i && (i = t.mimeType || e.getResponseHeader("Content-Type"));
        }if (i) for (o in a) {
            if (a[o] && a[o].test(i)) {
                l.unshift(o);break;
            }
        }if (l[0] in n) s = l[0];else {
            for (o in n) {
                if (!l[0] || t.converters[o + " " + l[0]]) {
                    s = o;break;
                }r || (r = o);
            }s = s || r;
        }return s ? (s !== l[0] && l.unshift(s), n[s]) : void 0;
    }function R(t, e, n, i) {
        var o,
            s,
            r,
            a,
            l,
            c = {},
            u = t.dataTypes.slice();if (u[1]) for (r in t.converters) {
            c[r.toLowerCase()] = t.converters[r];
        }for (s = u.shift(); s;) {
            if (t.responseFields[s] && (n[t.responseFields[s]] = e), !l && i && t.dataFilter && (e = t.dataFilter(e, t.dataType)), l = s, s = u.shift()) if ("*" === s) s = l;else if ("*" !== l && l !== s) {
                if (!(r = c[l + " " + s] || c["* " + s])) for (o in c) {
                    if (a = o.split(" "), a[1] === s && (r = c[l + " " + a[0]] || c["* " + a[0]])) {
                        !0 === r ? r = c[o] : !0 !== c[o] && (s = a[0], u.unshift(a[1]));break;
                    }
                }if (!0 !== r) if (r && t.throws) e = r(e);else try {
                    e = r(e);
                } catch (t) {
                    return { state: "parsererror", error: r ? t : "No conversion from " + l + " to " + s };
                }
            }
        }return { state: "success", data: e };
    }function M(t, e, n, i) {
        var o;if (tt.isArray(e)) tt.each(e, function (e, o) {
            n || xe.test(t) ? i(t, o) : M(t + "[" + ("object" == (void 0 === o ? "undefined" : _typeof(o)) ? e : "") + "]", o, n, i);
        });else if (n || "object" !== tt.type(e)) i(t, e);else for (o in e) {
            M(t + "[" + o + "]", e[o], n, i);
        }
    }function q(t) {
        return tt.isWindow(t) ? t : 9 === t.nodeType && t.defaultView;
    }var W = [],
        F = W.slice,
        B = W.concat,
        U = W.push,
        V = W.indexOf,
        X = {},
        Y = X.toString,
        K = X.hasOwnProperty,
        G = "".trim,
        Q = {},
        J = t.document,
        Z = "2.1.0",
        tt = function t(e, n) {
        return new t.fn.init(e, n);
    },
        et = /^-ms-/,
        nt = /-([\da-z])/gi,
        it = function it(t, e) {
        return e.toUpperCase();
    };tt.fn = tt.prototype = { jquery: Z, constructor: tt, selector: "", length: 0, toArray: function toArray() {
            return F.call(this);
        }, get: function get(t) {
            return null != t ? 0 > t ? this[t + this.length] : this[t] : F.call(this);
        }, pushStack: function pushStack(t) {
            var e = tt.merge(this.constructor(), t);return e.prevObject = this, e.context = this.context, e;
        }, each: function each(t, e) {
            return tt.each(this, t, e);
        }, map: function map(t) {
            return this.pushStack(tt.map(this, function (e, n) {
                return t.call(e, n, e);
            }));
        }, slice: function slice() {
            return this.pushStack(F.apply(this, arguments));
        }, first: function first() {
            return this.eq(0);
        }, last: function last() {
            return this.eq(-1);
        }, eq: function eq(t) {
            var e = this.length,
                n = +t + (0 > t ? e : 0);return this.pushStack(n >= 0 && e > n ? [this[n]] : []);
        }, end: function end() {
            return this.prevObject || this.constructor(null);
        }, push: U, sort: W.sort, splice: W.splice }, tt.extend = tt.fn.extend = function () {
        var t,
            e,
            n,
            i,
            o,
            s,
            r = arguments[0] || {},
            a = 1,
            l = arguments.length,
            c = !1;for ("boolean" == typeof r && (c = r, r = arguments[a] || {}, a++), "object" == (void 0 === r ? "undefined" : _typeof(r)) || tt.isFunction(r) || (r = {}), a === l && (r = this, a--); l > a; a++) {
            if (null != (t = arguments[a])) for (e in t) {
                n = r[e], i = t[e], r !== i && (c && i && (tt.isPlainObject(i) || (o = tt.isArray(i))) ? (o ? (o = !1, s = n && tt.isArray(n) ? n : []) : s = n && tt.isPlainObject(n) ? n : {}, r[e] = tt.extend(c, s, i)) : void 0 !== i && (r[e] = i));
            }
        }return r;
    }, tt.extend({ expando: "jQuery" + (Z + Math.random()).replace(/\D/g, ""), isReady: !0, error: function error(t) {
            throw new Error(t);
        }, noop: function noop() {}, isFunction: function isFunction(t) {
            return "function" === tt.type(t);
        }, isArray: Array.isArray, isWindow: function isWindow(t) {
            return null != t && t === t.window;
        }, isNumeric: function isNumeric(t) {
            return t - parseFloat(t) >= 0;
        }, isPlainObject: function isPlainObject(t) {
            if ("object" !== tt.type(t) || t.nodeType || tt.isWindow(t)) return !1;try {
                if (t.constructor && !K.call(t.constructor.prototype, "isPrototypeOf")) return !1;
            } catch (t) {
                return !1;
            }return !0;
        }, isEmptyObject: function isEmptyObject(t) {
            var e;for (e in t) {
                return !1;
            }return !0;
        }, type: function type(t) {
            return null == t ? t + "" : "object" == (void 0 === t ? "undefined" : _typeof(t)) || "function" == typeof t ? X[Y.call(t)] || "object" : void 0 === t ? "undefined" : _typeof(t);
        }, globalEval: function globalEval(t) {
            var e,
                n = eval;(t = tt.trim(t)) && (1 === t.indexOf("use strict") ? (e = J.createElement("script"), e.text = t, J.head.appendChild(e).parentNode.removeChild(e)) : n(t));
        }, camelCase: function camelCase(t) {
            return t.replace(et, "ms-").replace(nt, it);
        }, nodeName: function nodeName(t, e) {
            return t.nodeName && t.nodeName.toLowerCase() === e.toLowerCase();
        }, each: function each(t, e, i) {
            var o = 0,
                s = t.length,
                r = n(t);if (i) {
                if (r) for (; s > o && !1 !== e.apply(t[o], i); o++) {} else for (o in t) {
                    if (!1 === e.apply(t[o], i)) break;
                }
            } else if (r) for (; s > o && !1 !== e.call(t[o], o, t[o]); o++) {} else for (o in t) {
                if (!1 === e.call(t[o], o, t[o])) break;
            }return t;
        }, trim: function trim(t) {
            return null == t ? "" : G.call(t);
        }, makeArray: function makeArray(t, e) {
            var i = e || [];return null != t && (n(Object(t)) ? tt.merge(i, "string" == typeof t ? [t] : t) : U.call(i, t)), i;
        }, inArray: function inArray(t, e, n) {
            return null == e ? -1 : V.call(e, t, n);
        }, merge: function merge(t, e) {
            for (var n = +e.length, i = 0, o = t.length; n > i; i++) {
                t[o++] = e[i];
            }return t.length = o, t;
        }, grep: function grep(t, e, n) {
            for (var i = [], o = 0, s = t.length, r = !n; s > o; o++) {
                !e(t[o], o) !== r && i.push(t[o]);
            }return i;
        }, map: function map(t, e, i) {
            var o,
                s = 0,
                r = t.length,
                a = n(t),
                l = [];if (a) for (; r > s; s++) {
                null != (o = e(t[s], s, i)) && l.push(o);
            } else for (s in t) {
                null != (o = e(t[s], s, i)) && l.push(o);
            }return B.apply([], l);
        }, guid: 1, proxy: function proxy(t, e) {
            var n, i, o;return "string" == typeof e && (n = t[e], e = t, t = n), tt.isFunction(t) ? (i = F.call(arguments, 2), o = function o() {
                return t.apply(e || this, i.concat(F.call(arguments)));
            }, o.guid = t.guid = t.guid || tt.guid++, o) : void 0;
        }, now: Date.now, support: Q }), tt.each("Boolean Number String Function Array Date RegExp Object Error".split(" "), function (t, e) {
        X["[object " + e + "]"] = e.toLowerCase();
    });var ot = function (t) {
        function e(t, e, n, i) {
            var o, s, r, a, c, p, d, f, g, m;if ((e ? e.ownerDocument || e : H) !== D && k(e), e = e || D, n = n || [], !t || "string" != typeof t) return n;if (1 !== (a = e.nodeType) && 9 !== a) return [];if ($ && !i) {
                if (o = mt.exec(t)) if (r = o[1]) {
                    if (9 === a) {
                        if (!(s = e.getElementById(r)) || !s.parentNode) return n;if (s.id === r) return n.push(s), n;
                    } else if (e.ownerDocument && (s = e.ownerDocument.getElementById(r)) && j(e, s) && s.id === r) return n.push(s), n;
                } else {
                    if (o[2]) return Q.apply(n, e.getElementsByTagName(t)), n;if ((r = o[3]) && _.getElementsByClassName && e.getElementsByClassName) return Q.apply(n, e.getElementsByClassName(r)), n;
                }if (_.qsa && (!I || !I.test(t))) {
                    if (f = d = z, g = e, m = 9 === a && t, 1 === a && "object" !== e.nodeName.toLowerCase()) {
                        for (p = u(t), (d = e.getAttribute("id")) ? f = d.replace(yt, "\\$&") : e.setAttribute("id", f), f = "[id='" + f + "'] ", c = p.length; c--;) {
                            p[c] = f + h(p[c]);
                        }g = vt.test(t) && l(e.parentNode) || e, m = p.join(",");
                    }if (m) try {
                        return Q.apply(n, g.querySelectorAll(m)), n;
                    } catch (t) {} finally {
                        d || e.removeAttribute("id");
                    }
                }
            }return b(t.replace(rt, "$1"), e, n, i);
        }function n() {
            function t(n, i) {
                return e.push(n + " ") > x.cacheLength && delete t[e.shift()], t[n + " "] = i;
            }var e = [];return t;
        }function i(t) {
            return t[z] = !0, t;
        }function o(t) {
            var e = D.createElement("div");try {
                return !!t(e);
            } catch (t) {
                return !1;
            } finally {
                e.parentNode && e.parentNode.removeChild(e), e = null;
            }
        }function s(t, e) {
            for (var n = t.split("|"), i = t.length; i--;) {
                x.attrHandle[n[i]] = e;
            }
        }function r(t, e) {
            var n = e && t,
                i = n && 1 === t.nodeType && 1 === e.nodeType && (~e.sourceIndex || V) - (~t.sourceIndex || V);if (i) return i;if (n) for (; n = n.nextSibling;) {
                if (n === e) return -1;
            }return t ? 1 : -1;
        }function a(t) {
            return i(function (e) {
                return e = +e, i(function (n, i) {
                    for (var o, s = t([], n.length, e), r = s.length; r--;) {
                        n[o = s[r]] && (n[o] = !(i[o] = n[o]));
                    }
                });
            });
        }function l(t) {
            return t && _typeof(t.getElementsByTagName) !== U && t;
        }function c() {}function u(t, n) {
            var i,
                o,
                s,
                r,
                a,
                l,
                c,
                u = W[t + " "];if (u) return n ? 0 : u.slice(0);for (a = t, l = [], c = x.preFilter; a;) {
                (!i || (o = at.exec(a))) && (o && (a = a.slice(o[0].length) || a), l.push(s = [])), i = !1, (o = lt.exec(a)) && (i = o.shift(), s.push({ value: i, type: o[0].replace(rt, " ") }), a = a.slice(i.length));for (r in x.filter) {
                    !(o = pt[r].exec(a)) || c[r] && !(o = c[r](o)) || (i = o.shift(), s.push({ value: i, type: r, matches: o }), a = a.slice(i.length));
                }if (!i) break;
            }return n ? a.length : a ? e.error(t) : W(t, l).slice(0);
        }function h(t) {
            for (var e = 0, n = t.length, i = ""; n > e; e++) {
                i += t[e].value;
            }return i;
        }function p(t, e, n) {
            var i = e.dir,
                o = n && "parentNode" === i,
                s = M++;return e.first ? function (e, n, s) {
                for (; e = e[i];) {
                    if (1 === e.nodeType || o) return t(e, n, s);
                }
            } : function (e, n, r) {
                var a,
                    l,
                    c = [R, s];if (r) {
                    for (; e = e[i];) {
                        if ((1 === e.nodeType || o) && t(e, n, r)) return !0;
                    }
                } else for (; e = e[i];) {
                    if (1 === e.nodeType || o) {
                        if (l = e[z] || (e[z] = {}), (a = l[i]) && a[0] === R && a[1] === s) return c[2] = a[2];if (l[i] = c, c[2] = t(e, n, r)) return !0;
                    }
                }
            };
        }function d(t) {
            return t.length > 1 ? function (e, n, i) {
                for (var o = t.length; o--;) {
                    if (!t[o](e, n, i)) return !1;
                }return !0;
            } : t[0];
        }function f(t, e, n, i, o) {
            for (var s, r = [], a = 0, l = t.length, c = null != e; l > a; a++) {
                (s = t[a]) && (!n || n(s, i, o)) && (r.push(s), c && e.push(a));
            }return r;
        }function g(t, e, n, o, s, r) {
            return o && !o[z] && (o = g(o)), s && !s[z] && (s = g(s, r)), i(function (i, r, a, l) {
                var c,
                    u,
                    h,
                    p = [],
                    d = [],
                    g = r.length,
                    m = i || y(e || "*", a.nodeType ? [a] : a, []),
                    v = !t || !i && e ? m : f(m, p, t, a, l),
                    b = n ? s || (i ? t : g || o) ? [] : r : v;if (n && n(v, b, a, l), o) for (c = f(b, d), o(c, [], a, l), u = c.length; u--;) {
                    (h = c[u]) && (b[d[u]] = !(v[d[u]] = h));
                }if (i) {
                    if (s || t) {
                        if (s) {
                            for (c = [], u = b.length; u--;) {
                                (h = b[u]) && c.push(v[u] = h);
                            }s(null, b = [], c, l);
                        }for (u = b.length; u--;) {
                            (h = b[u]) && (c = s ? Z.call(i, h) : p[u]) > -1 && (i[c] = !(r[c] = h));
                        }
                    }
                } else b = f(b === r ? b.splice(g, b.length) : b), s ? s(null, r, b, l) : Q.apply(r, b);
            });
        }function m(t) {
            for (var e, n, i, o = t.length, s = x.relative[t[0].type], r = s || x.relative[" "], a = s ? 1 : 0, l = p(function (t) {
                return t === e;
            }, r, !0), c = p(function (t) {
                return Z.call(e, t) > -1;
            }, r, !0), u = [function (t, n, i) {
                return !s && (i || n !== A) || ((e = n).nodeType ? l(t, n, i) : c(t, n, i));
            }]; o > a; a++) {
                if (n = x.relative[t[a].type]) u = [p(d(u), n)];else {
                    if (n = x.filter[t[a].type].apply(null, t[a].matches), n[z]) {
                        for (i = ++a; o > i && !x.relative[t[i].type]; i++) {}return g(a > 1 && d(u), a > 1 && h(t.slice(0, a - 1).concat({ value: " " === t[a - 2].type ? "*" : "" })).replace(rt, "$1"), n, i > a && m(t.slice(a, i)), o > i && m(t = t.slice(i)), o > i && h(t));
                    }u.push(n);
                }
            }return d(u);
        }function v(t, n) {
            var o = n.length > 0,
                s = t.length > 0,
                r = function r(i, _r, a, l, c) {
                var u,
                    h,
                    p,
                    d = 0,
                    g = "0",
                    m = i && [],
                    v = [],
                    y = A,
                    b = i || s && x.find.TAG("*", c),
                    w = R += null == y ? 1 : Math.random() || .1,
                    _ = b.length;for (c && (A = _r !== D && _r); g !== _ && null != (u = b[g]); g++) {
                    if (s && u) {
                        for (h = 0; p = t[h++];) {
                            if (p(u, _r, a)) {
                                l.push(u);break;
                            }
                        }c && (R = w);
                    }o && ((u = !p && u) && d--, i && m.push(u));
                }if (d += g, o && g !== d) {
                    for (h = 0; p = n[h++];) {
                        p(m, v, _r, a);
                    }if (i) {
                        if (d > 0) for (; g--;) {
                            m[g] || v[g] || (v[g] = K.call(l));
                        }v = f(v);
                    }Q.apply(l, v), c && !i && v.length > 0 && d + n.length > 1 && e.uniqueSort(l);
                }return c && (R = w, A = y), m;
            };return o ? i(r) : r;
        }function y(t, n, i) {
            for (var o = 0, s = n.length; s > o; o++) {
                e(t, n[o], i);
            }return i;
        }function b(t, e, n, i) {
            var o,
                s,
                r,
                a,
                c,
                p = u(t);if (!i && 1 === p.length) {
                if (s = p[0] = p[0].slice(0), s.length > 2 && "ID" === (r = s[0]).type && _.getById && 9 === e.nodeType && $ && x.relative[s[1].type]) {
                    if (!(e = (x.find.ID(r.matches[0].replace(bt, wt), e) || [])[0])) return n;t = t.slice(s.shift().value.length);
                }for (o = pt.needsContext.test(t) ? 0 : s.length; o-- && (r = s[o], !x.relative[a = r.type]);) {
                    if ((c = x.find[a]) && (i = c(r.matches[0].replace(bt, wt), vt.test(s[0].type) && l(e.parentNode) || e))) {
                        if (s.splice(o, 1), !(t = i.length && h(s))) return Q.apply(n, i), n;break;
                    }
                }
            }return S(t, p)(i, e, !$, n, vt.test(t) && l(e.parentNode) || e), n;
        }var w,
            _,
            x,
            C,
            T,
            S,
            A,
            E,
            P,
            k,
            D,
            O,
            $,
            I,
            N,
            L,
            j,
            z = "sizzle" + -new Date(),
            H = t.document,
            R = 0,
            M = 0,
            q = n(),
            W = n(),
            F = n(),
            B = function B(t, e) {
            return t === e && (P = !0), 0;
        },
            U = "undefined",
            V = 1 << 31,
            X = {}.hasOwnProperty,
            Y = [],
            K = Y.pop,
            G = Y.push,
            Q = Y.push,
            J = Y.slice,
            Z = Y.indexOf || function (t) {
            for (var e = 0, n = this.length; n > e; e++) {
                if (this[e] === t) return e;
            }return -1;
        },
            tt = "checked|selected|async|autofocus|autoplay|controls|defer|disabled|hidden|ismap|loop|multiple|open|readonly|required|scoped",
            et = "[\\x20\\t\\r\\n\\f]",
            nt = "(?:\\\\.|[\\w-]|[^\\x00-\\xa0])+",
            it = nt.replace("w", "w#"),
            ot = "\\[" + et + "*(" + nt + ")" + et + "*(?:([*^$|!~]?=)" + et + "*(?:(['\"])((?:\\\\.|[^\\\\])*?)\\3|(" + it + ")|)|)" + et + "*\\]",
            st = ":(" + nt + ")(?:\\(((['\"])((?:\\\\.|[^\\\\])*?)\\3|((?:\\\\.|[^\\\\()[\\]]|" + ot.replace(3, 8) + ")*)|.*)\\)|)",
            rt = new RegExp("^" + et + "+|((?:^|[^\\\\])(?:\\\\.)*)" + et + "+$", "g"),
            at = new RegExp("^" + et + "*," + et + "*"),
            lt = new RegExp("^" + et + "*([>+~]|" + et + ")" + et + "*"),
            ct = new RegExp("=" + et + "*([^\\]'\"]*?)" + et + "*\\]", "g"),
            ut = new RegExp(st),
            ht = new RegExp("^" + it + "$"),
            pt = { ID: new RegExp("^#(" + nt + ")"), CLASS: new RegExp("^\\.(" + nt + ")"), TAG: new RegExp("^(" + nt.replace("w", "w*") + ")"), ATTR: new RegExp("^" + ot), PSEUDO: new RegExp("^" + st), CHILD: new RegExp("^:(only|first|last|nth|nth-last)-(child|of-type)(?:\\(" + et + "*(even|odd|(([+-]|)(\\d*)n|)" + et + "*(?:([+-]|)" + et + "*(\\d+)|))" + et + "*\\)|)", "i"), bool: new RegExp("^(?:" + tt + ")$", "i"), needsContext: new RegExp("^" + et + "*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\(" + et + "*((?:-\\d)?\\d*)" + et + "*\\)|)(?=[^-]|$)", "i") },
            dt = /^(?:input|select|textarea|button)$/i,
            ft = /^h\d$/i,
            gt = /^[^{]+\{\s*\[native \w/,
            mt = /^(?:#([\w-]+)|(\w+)|\.([\w-]+))$/,
            vt = /[+~]/,
            yt = /'|\\/g,
            bt = new RegExp("\\\\([\\da-f]{1,6}" + et + "?|(" + et + ")|.)", "ig"),
            wt = function wt(t, e, n) {
            var i = "0x" + e - 65536;return i !== i || n ? e : 0 > i ? String.fromCharCode(i + 65536) : String.fromCharCode(i >> 10 | 55296, 1023 & i | 56320);
        };try {
            Q.apply(Y = J.call(H.childNodes), H.childNodes), Y[H.childNodes.length].nodeType;
        } catch (t) {
            Q = { apply: Y.length ? function (t, e) {
                    G.apply(t, J.call(e));
                } : function (t, e) {
                    for (var n = t.length, i = 0; t[n++] = e[i++];) {}t.length = n - 1;
                } };
        }_ = e.support = {}, T = e.isXML = function (t) {
            var e = t && (t.ownerDocument || t).documentElement;return !!e && "HTML" !== e.nodeName;
        }, k = e.setDocument = function (t) {
            var e,
                n = t ? t.ownerDocument || t : H,
                i = n.defaultView;return n !== D && 9 === n.nodeType && n.documentElement ? (D = n, O = n.documentElement, $ = !T(n), i && i !== i.top && (i.addEventListener ? i.addEventListener("unload", function () {
                k();
            }, !1) : i.attachEvent && i.attachEvent("onunload", function () {
                k();
            })), _.attributes = o(function (t) {
                return t.className = "i", !t.getAttribute("className");
            }), _.getElementsByTagName = o(function (t) {
                return t.appendChild(n.createComment("")), !t.getElementsByTagName("*").length;
            }), _.getElementsByClassName = gt.test(n.getElementsByClassName) && o(function (t) {
                return t.innerHTML = "<div class='a'></div><div class='a i'></div>", t.firstChild.className = "i", 2 === t.getElementsByClassName("i").length;
            }), _.getById = o(function (t) {
                return O.appendChild(t).id = z, !n.getElementsByName || !n.getElementsByName(z).length;
            }), _.getById ? (x.find.ID = function (t, e) {
                if (_typeof(e.getElementById) !== U && $) {
                    var n = e.getElementById(t);return n && n.parentNode ? [n] : [];
                }
            }, x.filter.ID = function (t) {
                var e = t.replace(bt, wt);return function (t) {
                    return t.getAttribute("id") === e;
                };
            }) : (delete x.find.ID, x.filter.ID = function (t) {
                var e = t.replace(bt, wt);return function (t) {
                    var n = _typeof(t.getAttributeNode) !== U && t.getAttributeNode("id");return n && n.value === e;
                };
            }), x.find.TAG = _.getElementsByTagName ? function (t, e) {
                return _typeof(e.getElementsByTagName) !== U ? e.getElementsByTagName(t) : void 0;
            } : function (t, e) {
                var n,
                    i = [],
                    o = 0,
                    s = e.getElementsByTagName(t);if ("*" === t) {
                    for (; n = s[o++];) {
                        1 === n.nodeType && i.push(n);
                    }return i;
                }return s;
            }, x.find.CLASS = _.getElementsByClassName && function (t, e) {
                return _typeof(e.getElementsByClassName) !== U && $ ? e.getElementsByClassName(t) : void 0;
            }, N = [], I = [], (_.qsa = gt.test(n.querySelectorAll)) && (o(function (t) {
                t.innerHTML = "<select t=''><option selected=''></option></select>", t.querySelectorAll("[t^='']").length && I.push("[*^$]=" + et + "*(?:''|\"\")"), t.querySelectorAll("[selected]").length || I.push("\\[" + et + "*(?:value|" + tt + ")"), t.querySelectorAll(":checked").length || I.push(":checked");
            }), o(function (t) {
                var e = n.createElement("input");e.setAttribute("type", "hidden"), t.appendChild(e).setAttribute("name", "D"), t.querySelectorAll("[name=d]").length && I.push("name" + et + "*[*^$|!~]?="), t.querySelectorAll(":enabled").length || I.push(":enabled", ":disabled"), t.querySelectorAll("*,:x"), I.push(",.*:");
            })), (_.matchesSelector = gt.test(L = O.webkitMatchesSelector || O.mozMatchesSelector || O.oMatchesSelector || O.msMatchesSelector)) && o(function (t) {
                _.disconnectedMatch = L.call(t, "div"), L.call(t, "[s!='']:x"), N.push("!=", st);
            }), I = I.length && new RegExp(I.join("|")), N = N.length && new RegExp(N.join("|")), e = gt.test(O.compareDocumentPosition), j = e || gt.test(O.contains) ? function (t, e) {
                var n = 9 === t.nodeType ? t.documentElement : t,
                    i = e && e.parentNode;return t === i || !(!i || 1 !== i.nodeType || !(n.contains ? n.contains(i) : t.compareDocumentPosition && 16 & t.compareDocumentPosition(i)));
            } : function (t, e) {
                if (e) for (; e = e.parentNode;) {
                    if (e === t) return !0;
                }return !1;
            }, B = e ? function (t, e) {
                if (t === e) return P = !0, 0;var i = !t.compareDocumentPosition - !e.compareDocumentPosition;return i || (i = (t.ownerDocument || t) === (e.ownerDocument || e) ? t.compareDocumentPosition(e) : 1, 1 & i || !_.sortDetached && e.compareDocumentPosition(t) === i ? t === n || t.ownerDocument === H && j(H, t) ? -1 : e === n || e.ownerDocument === H && j(H, e) ? 1 : E ? Z.call(E, t) - Z.call(E, e) : 0 : 4 & i ? -1 : 1);
            } : function (t, e) {
                if (t === e) return P = !0, 0;var i,
                    o = 0,
                    s = t.parentNode,
                    a = e.parentNode,
                    l = [t],
                    c = [e];if (!s || !a) return t === n ? -1 : e === n ? 1 : s ? -1 : a ? 1 : E ? Z.call(E, t) - Z.call(E, e) : 0;if (s === a) return r(t, e);for (i = t; i = i.parentNode;) {
                    l.unshift(i);
                }for (i = e; i = i.parentNode;) {
                    c.unshift(i);
                }for (; l[o] === c[o];) {
                    o++;
                }return o ? r(l[o], c[o]) : l[o] === H ? -1 : c[o] === H ? 1 : 0;
            }, n) : D;
        }, e.matches = function (t, n) {
            return e(t, null, null, n);
        }, e.matchesSelector = function (t, n) {
            if ((t.ownerDocument || t) !== D && k(t), n = n.replace(ct, "='$1']"), !(!_.matchesSelector || !$ || N && N.test(n) || I && I.test(n))) try {
                var i = L.call(t, n);if (i || _.disconnectedMatch || t.document && 11 !== t.document.nodeType) return i;
            } catch (t) {}return e(n, D, null, [t]).length > 0;
        }, e.contains = function (t, e) {
            return (t.ownerDocument || t) !== D && k(t), j(t, e);
        }, e.attr = function (t, e) {
            (t.ownerDocument || t) !== D && k(t);var n = x.attrHandle[e.toLowerCase()],
                i = n && X.call(x.attrHandle, e.toLowerCase()) ? n(t, e, !$) : void 0;return void 0 !== i ? i : _.attributes || !$ ? t.getAttribute(e) : (i = t.getAttributeNode(e)) && i.specified ? i.value : null;
        }, e.error = function (t) {
            throw new Error("Syntax error, unrecognized expression: " + t);
        }, e.uniqueSort = function (t) {
            var e,
                n = [],
                i = 0,
                o = 0;if (P = !_.detectDuplicates, E = !_.sortStable && t.slice(0), t.sort(B), P) {
                for (; e = t[o++];) {
                    e === t[o] && (i = n.push(o));
                }for (; i--;) {
                    t.splice(n[i], 1);
                }
            }return E = null, t;
        }, C = e.getText = function (t) {
            var e,
                n = "",
                i = 0,
                o = t.nodeType;if (o) {
                if (1 === o || 9 === o || 11 === o) {
                    if ("string" == typeof t.textContent) return t.textContent;for (t = t.firstChild; t; t = t.nextSibling) {
                        n += C(t);
                    }
                } else if (3 === o || 4 === o) return t.nodeValue;
            } else for (; e = t[i++];) {
                n += C(e);
            }return n;
        }, x = e.selectors = { cacheLength: 50, createPseudo: i, match: pt, attrHandle: {}, find: {}, relative: { ">": { dir: "parentNode", first: !0 }, " ": { dir: "parentNode" }, "+": { dir: "previousSibling", first: !0 }, "~": { dir: "previousSibling" } }, preFilter: { ATTR: function ATTR(t) {
                    return t[1] = t[1].replace(bt, wt), t[3] = (t[4] || t[5] || "").replace(bt, wt), "~=" === t[2] && (t[3] = " " + t[3] + " "), t.slice(0, 4);
                }, CHILD: function CHILD(t) {
                    return t[1] = t[1].toLowerCase(), "nth" === t[1].slice(0, 3) ? (t[3] || e.error(t[0]), t[4] = +(t[4] ? t[5] + (t[6] || 1) : 2 * ("even" === t[3] || "odd" === t[3])), t[5] = +(t[7] + t[8] || "odd" === t[3])) : t[3] && e.error(t[0]), t;
                }, PSEUDO: function PSEUDO(t) {
                    var e,
                        n = !t[5] && t[2];return pt.CHILD.test(t[0]) ? null : (t[3] && void 0 !== t[4] ? t[2] = t[4] : n && ut.test(n) && (e = u(n, !0)) && (e = n.indexOf(")", n.length - e) - n.length) && (t[0] = t[0].slice(0, e), t[2] = n.slice(0, e)), t.slice(0, 3));
                } }, filter: { TAG: function TAG(t) {
                    var e = t.replace(bt, wt).toLowerCase();return "*" === t ? function () {
                        return !0;
                    } : function (t) {
                        return t.nodeName && t.nodeName.toLowerCase() === e;
                    };
                }, CLASS: function CLASS(t) {
                    var e = q[t + " "];return e || (e = new RegExp("(^|" + et + ")" + t + "(" + et + "|$)")) && q(t, function (t) {
                        return e.test("string" == typeof t.className && t.className || _typeof(t.getAttribute) !== U && t.getAttribute("class") || "");
                    });
                }, ATTR: function ATTR(t, n, i) {
                    return function (o) {
                        var s = e.attr(o, t);return null == s ? "!=" === n : !n || (s += "", "=" === n ? s === i : "!=" === n ? s !== i : "^=" === n ? i && 0 === s.indexOf(i) : "*=" === n ? i && s.indexOf(i) > -1 : "$=" === n ? i && s.slice(-i.length) === i : "~=" === n ? (" " + s + " ").indexOf(i) > -1 : "|=" === n && (s === i || s.slice(0, i.length + 1) === i + "-"));
                    };
                }, CHILD: function CHILD(t, e, n, i, o) {
                    var s = "nth" !== t.slice(0, 3),
                        r = "last" !== t.slice(-4),
                        a = "of-type" === e;return 1 === i && 0 === o ? function (t) {
                        return !!t.parentNode;
                    } : function (e, n, l) {
                        var c,
                            u,
                            h,
                            p,
                            d,
                            f,
                            g = s !== r ? "nextSibling" : "previousSibling",
                            m = e.parentNode,
                            v = a && e.nodeName.toLowerCase(),
                            y = !l && !a;if (m) {
                            if (s) {
                                for (; g;) {
                                    for (h = e; h = h[g];) {
                                        if (a ? h.nodeName.toLowerCase() === v : 1 === h.nodeType) return !1;
                                    }f = g = "only" === t && !f && "nextSibling";
                                }return !0;
                            }if (f = [r ? m.firstChild : m.lastChild], r && y) {
                                for (u = m[z] || (m[z] = {}), c = u[t] || [], d = c[0] === R && c[1], p = c[0] === R && c[2], h = d && m.childNodes[d]; h = ++d && h && h[g] || (p = d = 0) || f.pop();) {
                                    if (1 === h.nodeType && ++p && h === e) {
                                        u[t] = [R, d, p];break;
                                    }
                                }
                            } else if (y && (c = (e[z] || (e[z] = {}))[t]) && c[0] === R) p = c[1];else for (; (h = ++d && h && h[g] || (p = d = 0) || f.pop()) && ((a ? h.nodeName.toLowerCase() !== v : 1 !== h.nodeType) || !++p || (y && ((h[z] || (h[z] = {}))[t] = [R, p]), h !== e));) {}return (p -= o) === i || p % i == 0 && p / i >= 0;
                        }
                    };
                }, PSEUDO: function PSEUDO(t, n) {
                    var o,
                        s = x.pseudos[t] || x.setFilters[t.toLowerCase()] || e.error("unsupported pseudo: " + t);return s[z] ? s(n) : s.length > 1 ? (o = [t, t, "", n], x.setFilters.hasOwnProperty(t.toLowerCase()) ? i(function (t, e) {
                        for (var i, o = s(t, n), r = o.length; r--;) {
                            i = Z.call(t, o[r]), t[i] = !(e[i] = o[r]);
                        }
                    }) : function (t) {
                        return s(t, 0, o);
                    }) : s;
                } }, pseudos: { not: i(function (t) {
                    var e = [],
                        n = [],
                        o = S(t.replace(rt, "$1"));return o[z] ? i(function (t, e, n, i) {
                        for (var s, r = o(t, null, i, []), a = t.length; a--;) {
                            (s = r[a]) && (t[a] = !(e[a] = s));
                        }
                    }) : function (t, i, s) {
                        return e[0] = t, o(e, null, s, n), !n.pop();
                    };
                }), has: i(function (t) {
                    return function (n) {
                        return e(t, n).length > 0;
                    };
                }), contains: i(function (t) {
                    return function (e) {
                        return (e.textContent || e.innerText || C(e)).indexOf(t) > -1;
                    };
                }), lang: i(function (t) {
                    return ht.test(t || "") || e.error("unsupported lang: " + t), t = t.replace(bt, wt).toLowerCase(), function (e) {
                        var n;do {
                            if (n = $ ? e.lang : e.getAttribute("xml:lang") || e.getAttribute("lang")) return (n = n.toLowerCase()) === t || 0 === n.indexOf(t + "-");
                        } while ((e = e.parentNode) && 1 === e.nodeType);return !1;
                    };
                }), target: function target(e) {
                    var n = t.location && t.location.hash;return n && n.slice(1) === e.id;
                }, root: function root(t) {
                    return t === O;
                }, focus: function focus(t) {
                    return t === D.activeElement && (!D.hasFocus || D.hasFocus()) && !!(t.type || t.href || ~t.tabIndex);
                }, enabled: function enabled(t) {
                    return !1 === t.disabled;
                }, disabled: function disabled(t) {
                    return !0 === t.disabled;
                }, checked: function checked(t) {
                    var e = t.nodeName.toLowerCase();return "input" === e && !!t.checked || "option" === e && !!t.selected;
                }, selected: function selected(t) {
                    return t.parentNode && t.parentNode.selectedIndex, !0 === t.selected;
                }, empty: function empty(t) {
                    for (t = t.firstChild; t; t = t.nextSibling) {
                        if (t.nodeType < 6) return !1;
                    }return !0;
                }, parent: function parent(t) {
                    return !x.pseudos.empty(t);
                }, header: function header(t) {
                    return ft.test(t.nodeName);
                }, input: function input(t) {
                    return dt.test(t.nodeName);
                }, button: function button(t) {
                    var e = t.nodeName.toLowerCase();return "input" === e && "button" === t.type || "button" === e;
                }, text: function text(t) {
                    var e;return "input" === t.nodeName.toLowerCase() && "text" === t.type && (null == (e = t.getAttribute("type")) || "text" === e.toLowerCase());
                }, first: a(function () {
                    return [0];
                }), last: a(function (t, e) {
                    return [e - 1];
                }), eq: a(function (t, e, n) {
                    return [0 > n ? n + e : n];
                }), even: a(function (t, e) {
                    for (var n = 0; e > n; n += 2) {
                        t.push(n);
                    }return t;
                }), odd: a(function (t, e) {
                    for (var n = 1; e > n; n += 2) {
                        t.push(n);
                    }return t;
                }), lt: a(function (t, e, n) {
                    for (var i = 0 > n ? n + e : n; --i >= 0;) {
                        t.push(i);
                    }return t;
                }), gt: a(function (t, e, n) {
                    for (var i = 0 > n ? n + e : n; ++i < e;) {
                        t.push(i);
                    }return t;
                }) } }, x.pseudos.nth = x.pseudos.eq;for (w in { radio: !0, checkbox: !0, file: !0, password: !0, image: !0 }) {
            x.pseudos[w] = function (t) {
                return function (e) {
                    return "input" === e.nodeName.toLowerCase() && e.type === t;
                };
            }(w);
        }for (w in { submit: !0, reset: !0 }) {
            x.pseudos[w] = function (t) {
                return function (e) {
                    var n = e.nodeName.toLowerCase();return ("input" === n || "button" === n) && e.type === t;
                };
            }(w);
        }return c.prototype = x.filters = x.pseudos, x.setFilters = new c(), S = e.compile = function (t, e) {
            var n,
                i = [],
                o = [],
                s = F[t + " "];if (!s) {
                for (e || (e = u(t)), n = e.length; n--;) {
                    s = m(e[n]), s[z] ? i.push(s) : o.push(s);
                }s = F(t, v(o, i));
            }return s;
        }, _.sortStable = z.split("").sort(B).join("") === z, _.detectDuplicates = !!P, k(), _.sortDetached = o(function (t) {
            return 1 & t.compareDocumentPosition(D.createElement("div"));
        }), o(function (t) {
            return t.innerHTML = "<a href='#'></a>", "#" === t.firstChild.getAttribute("href");
        }) || s("type|href|height|width", function (t, e, n) {
            return n ? void 0 : t.getAttribute(e, "type" === e.toLowerCase() ? 1 : 2);
        }), _.attributes && o(function (t) {
            return t.innerHTML = "<input/>", t.firstChild.setAttribute("value", ""), "" === t.firstChild.getAttribute("value");
        }) || s("value", function (t, e, n) {
            return n || "input" !== t.nodeName.toLowerCase() ? void 0 : t.defaultValue;
        }), o(function (t) {
            return null == t.getAttribute("disabled");
        }) || s(tt, function (t, e, n) {
            var i;return n ? void 0 : !0 === t[e] ? e.toLowerCase() : (i = t.getAttributeNode(e)) && i.specified ? i.value : null;
        }), e;
    }(t);tt.find = ot, tt.expr = ot.selectors, tt.expr[":"] = tt.expr.pseudos, tt.unique = ot.uniqueSort, tt.text = ot.getText, tt.isXMLDoc = ot.isXML, tt.contains = ot.contains;var st = tt.expr.match.needsContext,
        rt = /^<(\w+)\s*\/?>(?:<\/\1>|)$/,
        at = /^.[^:#\[\.,]*$/;tt.filter = function (t, e, n) {
        var i = e[0];return n && (t = ":not(" + t + ")"), 1 === e.length && 1 === i.nodeType ? tt.find.matchesSelector(i, t) ? [i] : [] : tt.find.matches(t, tt.grep(e, function (t) {
            return 1 === t.nodeType;
        }));
    }, tt.fn.extend({ find: function find(t) {
            var e,
                n = this.length,
                i = [],
                o = this;if ("string" != typeof t) return this.pushStack(tt(t).filter(function () {
                for (e = 0; n > e; e++) {
                    if (tt.contains(o[e], this)) return !0;
                }
            }));for (e = 0; n > e; e++) {
                tt.find(t, o[e], i);
            }return i = this.pushStack(n > 1 ? tt.unique(i) : i), i.selector = this.selector ? this.selector + " " + t : t, i;
        }, filter: function filter(t) {
            return this.pushStack(i(this, t || [], !1));
        }, not: function not(t) {
            return this.pushStack(i(this, t || [], !0));
        }, is: function is(t) {
            return !!i(this, "string" == typeof t && st.test(t) ? tt(t) : t || [], !1).length;
        } });var lt,
        ct = /^(?:\s*(<[\w\W]+>)[^>]*|#([\w-]*))$/;(tt.fn.init = function (t, e) {
        var n, i;if (!t) return this;if ("string" == typeof t) {
            if (!(n = "<" === t[0] && ">" === t[t.length - 1] && t.length >= 3 ? [null, t, null] : ct.exec(t)) || !n[1] && e) return !e || e.jquery ? (e || lt).find(t) : this.constructor(e).find(t);if (n[1]) {
                if (e = e instanceof tt ? e[0] : e, tt.merge(this, tt.parseHTML(n[1], e && e.nodeType ? e.ownerDocument || e : J, !0)), rt.test(n[1]) && tt.isPlainObject(e)) for (n in e) {
                    tt.isFunction(this[n]) ? this[n](e[n]) : this.attr(n, e[n]);
                }return this;
            }return i = J.getElementById(n[2]), i && i.parentNode && (this.length = 1, this[0] = i), this.context = J, this.selector = t, this;
        }return t.nodeType ? (this.context = this[0] = t, this.length = 1, this) : tt.isFunction(t) ? void 0 !== lt.ready ? lt.ready(t) : t(tt) : (void 0 !== t.selector && (this.selector = t.selector, this.context = t.context), tt.makeArray(t, this));
    }).prototype = tt.fn, lt = tt(J);var ut = /^(?:parents|prev(?:Until|All))/,
        ht = { children: !0, contents: !0, next: !0, prev: !0 };tt.extend({ dir: function dir(t, e, n) {
            for (var i = [], o = void 0 !== n; (t = t[e]) && 9 !== t.nodeType;) {
                if (1 === t.nodeType) {
                    if (o && tt(t).is(n)) break;i.push(t);
                }
            }return i;
        }, sibling: function sibling(t, e) {
            for (var n = []; t; t = t.nextSibling) {
                1 === t.nodeType && t !== e && n.push(t);
            }return n;
        } }), tt.fn.extend({ has: function has(t) {
            var e = tt(t, this),
                n = e.length;return this.filter(function () {
                for (var t = 0; n > t; t++) {
                    if (tt.contains(this, e[t])) return !0;
                }
            });
        }, closest: function closest(t, e) {
            for (var n, i = 0, o = this.length, s = [], r = st.test(t) || "string" != typeof t ? tt(t, e || this.context) : 0; o > i; i++) {
                for (n = this[i]; n && n !== e; n = n.parentNode) {
                    if (n.nodeType < 11 && (r ? r.index(n) > -1 : 1 === n.nodeType && tt.find.matchesSelector(n, t))) {
                        s.push(n);break;
                    }
                }
            }return this.pushStack(s.length > 1 ? tt.unique(s) : s);
        }, index: function index(t) {
            return t ? "string" == typeof t ? V.call(tt(t), this[0]) : V.call(this, t.jquery ? t[0] : t) : this[0] && this[0].parentNode ? this.first().prevAll().length : -1;
        }, add: function add(t, e) {
            return this.pushStack(tt.unique(tt.merge(this.get(), tt(t, e))));
        }, addBack: function addBack(t) {
            return this.add(null == t ? this.prevObject : this.prevObject.filter(t));
        } }), tt.each({ parent: function parent(t) {
            var e = t.parentNode;return e && 11 !== e.nodeType ? e : null;
        }, parents: function parents(t) {
            return tt.dir(t, "parentNode");
        }, parentsUntil: function parentsUntil(t, e, n) {
            return tt.dir(t, "parentNode", n);
        }, next: function next(t) {
            return o(t, "nextSibling");
        }, prev: function prev(t) {
            return o(t, "previousSibling");
        }, nextAll: function nextAll(t) {
            return tt.dir(t, "nextSibling");
        }, prevAll: function prevAll(t) {
            return tt.dir(t, "previousSibling");
        }, nextUntil: function nextUntil(t, e, n) {
            return tt.dir(t, "nextSibling", n);
        }, prevUntil: function prevUntil(t, e, n) {
            return tt.dir(t, "previousSibling", n);
        }, siblings: function siblings(t) {
            return tt.sibling((t.parentNode || {}).firstChild, t);
        }, children: function children(t) {
            return tt.sibling(t.firstChild);
        }, contents: function contents(t) {
            return t.contentDocument || tt.merge([], t.childNodes);
        } }, function (t, e) {
        tt.fn[t] = function (n, i) {
            var o = tt.map(this, e, n);return "Until" !== t.slice(-5) && (i = n), i && "string" == typeof i && (o = tt.filter(i, o)), this.length > 1 && (ht[t] || tt.unique(o), ut.test(t) && o.reverse()), this.pushStack(o);
        };
    });var pt = /\S+/g,
        dt = {};tt.Callbacks = function (t) {
        t = "string" == typeof t ? dt[t] || s(t) : tt.extend({}, t);var e,
            n,
            i,
            o,
            r,
            a,
            l = [],
            c = !t.once && [],
            u = function s(u) {
            for (e = t.memory && u, n = !0, a = o || 0, o = 0, r = l.length, i = !0; l && r > a; a++) {
                if (!1 === l[a].apply(u[0], u[1]) && t.stopOnFalse) {
                    e = !1;break;
                }
            }i = !1, l && (c ? c.length && s(c.shift()) : e ? l = [] : h.disable());
        },
            h = { add: function add() {
                if (l) {
                    var n = l.length;!function e(n) {
                        tt.each(n, function (n, i) {
                            var o = tt.type(i);"function" === o ? t.unique && h.has(i) || l.push(i) : i && i.length && "string" !== o && e(i);
                        });
                    }(arguments), i ? r = l.length : e && (o = n, u(e));
                }return this;
            }, remove: function remove() {
                return l && tt.each(arguments, function (t, e) {
                    for (var n; (n = tt.inArray(e, l, n)) > -1;) {
                        l.splice(n, 1), i && (r >= n && r--, a >= n && a--);
                    }
                }), this;
            }, has: function has(t) {
                return t ? tt.inArray(t, l) > -1 : !(!l || !l.length);
            }, empty: function empty() {
                return l = [], r = 0, this;
            }, disable: function disable() {
                return l = c = e = void 0, this;
            }, disabled: function disabled() {
                return !l;
            }, lock: function lock() {
                return c = void 0, e || h.disable(), this;
            }, locked: function locked() {
                return !c;
            }, fireWith: function fireWith(t, e) {
                return !l || n && !c || (e = e || [], e = [t, e.slice ? e.slice() : e], i ? c.push(e) : u(e)), this;
            }, fire: function fire() {
                return h.fireWith(this, arguments), this;
            }, fired: function fired() {
                return !!n;
            } };return h;
    }, tt.extend({ Deferred: function Deferred(t) {
            var e = [["resolve", "done", tt.Callbacks("once memory"), "resolved"], ["reject", "fail", tt.Callbacks("once memory"), "rejected"], ["notify", "progress", tt.Callbacks("memory")]],
                n = "pending",
                i = { state: function state() {
                    return n;
                }, always: function always() {
                    return o.done(arguments).fail(arguments), this;
                }, then: function then() {
                    var t = arguments;return tt.Deferred(function (n) {
                        tt.each(e, function (e, s) {
                            var r = tt.isFunction(t[e]) && t[e];o[s[1]](function () {
                                var t = r && r.apply(this, arguments);t && tt.isFunction(t.promise) ? t.promise().done(n.resolve).fail(n.reject).progress(n.notify) : n[s[0] + "With"](this === i ? n.promise() : this, r ? [t] : arguments);
                            });
                        }), t = null;
                    }).promise();
                }, promise: function promise(t) {
                    return null != t ? tt.extend(t, i) : i;
                } },
                o = {};return i.pipe = i.then, tt.each(e, function (t, s) {
                var r = s[2],
                    a = s[3];i[s[1]] = r.add, a && r.add(function () {
                    n = a;
                }, e[1 ^ t][2].disable, e[2][2].lock), o[s[0]] = function () {
                    return o[s[0] + "With"](this === o ? i : this, arguments), this;
                }, o[s[0] + "With"] = r.fireWith;
            }), i.promise(o), t && t.call(o, o), o;
        }, when: function when(t) {
            var e,
                n,
                i,
                o = 0,
                s = F.call(arguments),
                r = s.length,
                a = 1 !== r || t && tt.isFunction(t.promise) ? r : 0,
                l = 1 === a ? t : tt.Deferred(),
                c = function c(t, n, i) {
                return function (o) {
                    n[t] = this, i[t] = arguments.length > 1 ? F.call(arguments) : o, i === e ? l.notifyWith(n, i) : --a || l.resolveWith(n, i);
                };
            };if (r > 1) for (e = new Array(r), n = new Array(r), i = new Array(r); r > o; o++) {
                s[o] && tt.isFunction(s[o].promise) ? s[o].promise().done(c(o, i, s)).fail(l.reject).progress(c(o, n, e)) : --a;
            }return a || l.resolveWith(i, s), l.promise();
        } });var ft;tt.fn.ready = function (t) {
        return tt.ready.promise().done(t), this;
    }, tt.extend({ isReady: !1, readyWait: 1, holdReady: function holdReady(t) {
            t ? tt.readyWait++ : tt.ready(!0);
        }, ready: function ready(t) {
            (!0 === t ? --tt.readyWait : tt.isReady) || (tt.isReady = !0, !0 !== t && --tt.readyWait > 0 || (ft.resolveWith(J, [tt]), tt.fn.trigger && tt(J).trigger("ready").off("ready")));
        } }), tt.ready.promise = function (e) {
        return ft || (ft = tt.Deferred(), "complete" === J.readyState ? setTimeout(tt.ready) : (J.addEventListener("DOMContentLoaded", r, !1), t.addEventListener("load", r, !1))), ft.promise(e);
    }, tt.ready.promise();var gt = tt.access = function (t, e, n, i, o, s, r) {
        var a = 0,
            l = t.length,
            c = null == n;if ("object" === tt.type(n)) {
            o = !0;for (a in n) {
                tt.access(t, e, a, n[a], !0, s, r);
            }
        } else if (void 0 !== i && (o = !0, tt.isFunction(i) || (r = !0), c && (r ? (e.call(t, i), e = null) : (c = e, e = function e(t, _e2, n) {
            return c.call(tt(t), n);
        })), e)) for (; l > a; a++) {
            e(t[a], n, r ? i : i.call(t[a], a, e(t[a], n)));
        }return o ? t : c ? e.call(t) : l ? e(t[0], n) : s;
    };tt.acceptData = function (t) {
        return 1 === t.nodeType || 9 === t.nodeType || !+t.nodeType;
    }, a.uid = 1, a.accepts = tt.acceptData, a.prototype = { key: function key(t) {
            if (!a.accepts(t)) return 0;var e = {},
                n = t[this.expando];if (!n) {
                n = a.uid++;try {
                    e[this.expando] = { value: n }, Object.defineProperties(t, e);
                } catch (i) {
                    e[this.expando] = n, tt.extend(t, e);
                }
            }return this.cache[n] || (this.cache[n] = {}), n;
        }, set: function set(t, e, n) {
            var i,
                o = this.key(t),
                s = this.cache[o];if ("string" == typeof e) s[e] = n;else if (tt.isEmptyObject(s)) tt.extend(this.cache[o], e);else for (i in e) {
                s[i] = e[i];
            }return s;
        }, get: function get(t, e) {
            var n = this.cache[this.key(t)];return void 0 === e ? n : n[e];
        }, access: function access(t, e, n) {
            var i;return void 0 === e || e && "string" == typeof e && void 0 === n ? (i = this.get(t, e), void 0 !== i ? i : this.get(t, tt.camelCase(e))) : (this.set(t, e, n), void 0 !== n ? n : e);
        }, remove: function remove(t, e) {
            var n,
                i,
                o,
                s = this.key(t),
                r = this.cache[s];if (void 0 === e) this.cache[s] = {};else {
                tt.isArray(e) ? i = e.concat(e.map(tt.camelCase)) : (o = tt.camelCase(e), e in r ? i = [e, o] : (i = o, i = i in r ? [i] : i.match(pt) || [])), n = i.length;for (; n--;) {
                    delete r[i[n]];
                }
            }
        }, hasData: function hasData(t) {
            return !tt.isEmptyObject(this.cache[t[this.expando]] || {});
        }, discard: function discard(t) {
            t[this.expando] && delete this.cache[t[this.expando]];
        } };var mt = new a(),
        vt = new a(),
        yt = /^(?:\{[\w\W]*\}|\[[\w\W]*\])$/,
        bt = /([A-Z])/g;tt.extend({ hasData: function hasData(t) {
            return vt.hasData(t) || mt.hasData(t);
        }, data: function data(t, e, n) {
            return vt.access(t, e, n);
        }, removeData: function removeData(t, e) {
            vt.remove(t, e);
        }, _data: function _data(t, e, n) {
            return mt.access(t, e, n);
        }, _removeData: function _removeData(t, e) {
            mt.remove(t, e);
        } }), tt.fn.extend({ data: function data(t, e) {
            var n,
                i,
                o,
                s = this[0],
                r = s && s.attributes;if (void 0 === t) {
                if (this.length && (o = vt.get(s), 1 === s.nodeType && !mt.get(s, "hasDataAttrs"))) {
                    for (n = r.length; n--;) {
                        i = r[n].name, 0 === i.indexOf("data-") && (i = tt.camelCase(i.slice(5)), l(s, i, o[i]));
                    }mt.set(s, "hasDataAttrs", !0);
                }return o;
            }return "object" == (void 0 === t ? "undefined" : _typeof(t)) ? this.each(function () {
                vt.set(this, t);
            }) : gt(this, function (e) {
                var n,
                    i = tt.camelCase(t);if (s && void 0 === e) {
                    if (void 0 !== (n = vt.get(s, t))) return n;if (void 0 !== (n = vt.get(s, i))) return n;if (void 0 !== (n = l(s, i, void 0))) return n;
                } else this.each(function () {
                    var n = vt.get(this, i);vt.set(this, i, e), -1 !== t.indexOf("-") && void 0 !== n && vt.set(this, t, e);
                });
            }, null, e, arguments.length > 1, null, !0);
        }, removeData: function removeData(t) {
            return this.each(function () {
                vt.remove(this, t);
            });
        } }), tt.extend({ queue: function queue(t, e, n) {
            var i;return t ? (e = (e || "fx") + "queue", i = mt.get(t, e), n && (!i || tt.isArray(n) ? i = mt.access(t, e, tt.makeArray(n)) : i.push(n)), i || []) : void 0;
        }, dequeue: function dequeue(t, e) {
            e = e || "fx";var n = tt.queue(t, e),
                i = n.length,
                o = n.shift(),
                s = tt._queueHooks(t, e),
                r = function r() {
                tt.dequeue(t, e);
            };"inprogress" === o && (o = n.shift(), i--), o && ("fx" === e && n.unshift("inprogress"), delete s.stop, o.call(t, r, s)), !i && s && s.empty.fire();
        }, _queueHooks: function _queueHooks(t, e) {
            var n = e + "queueHooks";return mt.get(t, n) || mt.access(t, n, { empty: tt.Callbacks("once memory").add(function () {
                    mt.remove(t, [e + "queue", n]);
                }) });
        } }), tt.fn.extend({ queue: function queue(t, e) {
            var n = 2;return "string" != typeof t && (e = t, t = "fx", n--), arguments.length < n ? tt.queue(this[0], t) : void 0 === e ? this : this.each(function () {
                var n = tt.queue(this, t, e);tt._queueHooks(this, t), "fx" === t && "inprogress" !== n[0] && tt.dequeue(this, t);
            });
        }, dequeue: function dequeue(t) {
            return this.each(function () {
                tt.dequeue(this, t);
            });
        }, clearQueue: function clearQueue(t) {
            return this.queue(t || "fx", []);
        }, promise: function promise(t, e) {
            var n,
                i = 1,
                o = tt.Deferred(),
                s = this,
                r = this.length,
                a = function a() {
                --i || o.resolveWith(s, [s]);
            };for ("string" != typeof t && (e = t, t = void 0), t = t || "fx"; r--;) {
                (n = mt.get(s[r], t + "queueHooks")) && n.empty && (i++, n.empty.add(a));
            }return a(), o.promise(e);
        } });var wt = /[+-]?(?:\d*\.|)\d+(?:[eE][+-]?\d+|)/.source,
        _t = ["Top", "Right", "Bottom", "Left"],
        xt = function xt(t, e) {
        return t = e || t, "none" === tt.css(t, "display") || !tt.contains(t.ownerDocument, t);
    },
        Ct = /^(?:checkbox|radio)$/i;!function () {
        var t = J.createDocumentFragment(),
            e = t.appendChild(J.createElement("div"));e.innerHTML = "<input type='radio' checked='checked' name='t'/>", Q.checkClone = e.cloneNode(!0).cloneNode(!0).lastChild.checked, e.innerHTML = "<textarea>x</textarea>", Q.noCloneChecked = !!e.cloneNode(!0).lastChild.defaultValue;
    }();var Tt = "undefined";Q.focusinBubbles = "onfocusin" in t;var St = /^key/,
        At = /^(?:mouse|contextmenu)|click/,
        Et = /^(?:focusinfocus|focusoutblur)$/,
        Pt = /^([^.]*)(?:\.(.+)|)$/;tt.event = { global: {}, add: function add(t, e, n, i, o) {
            var s,
                r,
                a,
                l,
                c,
                u,
                h,
                p,
                d,
                f,
                g,
                m = mt.get(t);if (m) for (n.handler && (s = n, n = s.handler, o = s.selector), n.guid || (n.guid = tt.guid++), (l = m.events) || (l = m.events = {}), (r = m.handle) || (r = m.handle = function (e) {
                return (void 0 === tt ? "undefined" : _typeof(tt)) !== Tt && tt.event.triggered !== e.type ? tt.event.dispatch.apply(t, arguments) : void 0;
            }), e = (e || "").match(pt) || [""], c = e.length; c--;) {
                a = Pt.exec(e[c]) || [], d = g = a[1], f = (a[2] || "").split(".").sort(), d && (h = tt.event.special[d] || {}, d = (o ? h.delegateType : h.bindType) || d, h = tt.event.special[d] || {}, u = tt.extend({ type: d, origType: g, data: i, handler: n, guid: n.guid, selector: o, needsContext: o && tt.expr.match.needsContext.test(o), namespace: f.join(".") }, s), (p = l[d]) || (p = l[d] = [], p.delegateCount = 0, h.setup && !1 !== h.setup.call(t, i, f, r) || t.addEventListener && t.addEventListener(d, r, !1)), h.add && (h.add.call(t, u), u.handler.guid || (u.handler.guid = n.guid)), o ? p.splice(p.delegateCount++, 0, u) : p.push(u), tt.event.global[d] = !0);
            }
        }, remove: function remove(t, e, n, i, o) {
            var s,
                r,
                a,
                l,
                c,
                u,
                h,
                p,
                d,
                f,
                g,
                m = mt.hasData(t) && mt.get(t);if (m && (l = m.events)) {
                for (e = (e || "").match(pt) || [""], c = e.length; c--;) {
                    if (a = Pt.exec(e[c]) || [], d = g = a[1], f = (a[2] || "").split(".").sort(), d) {
                        for (h = tt.event.special[d] || {}, d = (i ? h.delegateType : h.bindType) || d, p = l[d] || [], a = a[2] && new RegExp("(^|\\.)" + f.join("\\.(?:.*\\.|)") + "(\\.|$)"), r = s = p.length; s--;) {
                            u = p[s], !o && g !== u.origType || n && n.guid !== u.guid || a && !a.test(u.namespace) || i && i !== u.selector && ("**" !== i || !u.selector) || (p.splice(s, 1), u.selector && p.delegateCount--, h.remove && h.remove.call(t, u));
                        }r && !p.length && (h.teardown && !1 !== h.teardown.call(t, f, m.handle) || tt.removeEvent(t, d, m.handle), delete l[d]);
                    } else for (d in l) {
                        tt.event.remove(t, d + e[c], n, i, !0);
                    }
                }tt.isEmptyObject(l) && (delete m.handle, mt.remove(t, "events"));
            }
        }, trigger: function trigger(e, n, i, o) {
            var s,
                r,
                a,
                l,
                c,
                u,
                h,
                p = [i || J],
                d = K.call(e, "type") ? e.type : e,
                f = K.call(e, "namespace") ? e.namespace.split(".") : [];if (r = a = i = i || J, 3 !== i.nodeType && 8 !== i.nodeType && !Et.test(d + tt.event.triggered) && (d.indexOf(".") >= 0 && (f = d.split("."), d = f.shift(), f.sort()), c = d.indexOf(":") < 0 && "on" + d, e = e[tt.expando] ? e : new tt.Event(d, "object" == (void 0 === e ? "undefined" : _typeof(e)) && e), e.isTrigger = o ? 2 : 3, e.namespace = f.join("."), e.namespace_re = e.namespace ? new RegExp("(^|\\.)" + f.join("\\.(?:.*\\.|)") + "(\\.|$)") : null, e.result = void 0, e.target || (e.target = i), n = null == n ? [e] : tt.makeArray(n, [e]), h = tt.event.special[d] || {}, o || !h.trigger || !1 !== h.trigger.apply(i, n))) {
                if (!o && !h.noBubble && !tt.isWindow(i)) {
                    for (l = h.delegateType || d, Et.test(l + d) || (r = r.parentNode); r; r = r.parentNode) {
                        p.push(r), a = r;
                    }a === (i.ownerDocument || J) && p.push(a.defaultView || a.parentWindow || t);
                }for (s = 0; (r = p[s++]) && !e.isPropagationStopped();) {
                    e.type = s > 1 ? l : h.bindType || d, u = (mt.get(r, "events") || {})[e.type] && mt.get(r, "handle"), u && u.apply(r, n), (u = c && r[c]) && u.apply && tt.acceptData(r) && (e.result = u.apply(r, n), !1 === e.result && e.preventDefault());
                }return e.type = d, o || e.isDefaultPrevented() || h._default && !1 !== h._default.apply(p.pop(), n) || !tt.acceptData(i) || c && tt.isFunction(i[d]) && !tt.isWindow(i) && (a = i[c], a && (i[c] = null), tt.event.triggered = d, i[d](), tt.event.triggered = void 0, a && (i[c] = a)), e.result;
            }
        }, dispatch: function dispatch(t) {
            t = tt.event.fix(t);var e,
                n,
                i,
                o,
                s,
                r = [],
                a = F.call(arguments),
                l = (mt.get(this, "events") || {})[t.type] || [],
                c = tt.event.special[t.type] || {};if (a[0] = t, t.delegateTarget = this, !c.preDispatch || !1 !== c.preDispatch.call(this, t)) {
                for (r = tt.event.handlers.call(this, t, l), e = 0; (o = r[e++]) && !t.isPropagationStopped();) {
                    for (t.currentTarget = o.elem, n = 0; (s = o.handlers[n++]) && !t.isImmediatePropagationStopped();) {
                        (!t.namespace_re || t.namespace_re.test(s.namespace)) && (t.handleObj = s, t.data = s.data, void 0 !== (i = ((tt.event.special[s.origType] || {}).handle || s.handler).apply(o.elem, a)) && !1 === (t.result = i) && (t.preventDefault(), t.stopPropagation()));
                    }
                }return c.postDispatch && c.postDispatch.call(this, t), t.result;
            }
        }, handlers: function handlers(t, e) {
            var n,
                i,
                o,
                s,
                r = [],
                a = e.delegateCount,
                l = t.target;if (a && l.nodeType && (!t.button || "click" !== t.type)) for (; l !== this; l = l.parentNode || this) {
                if (!0 !== l.disabled || "click" !== t.type) {
                    for (i = [], n = 0; a > n; n++) {
                        s = e[n], o = s.selector + " ", void 0 === i[o] && (i[o] = s.needsContext ? tt(o, this).index(l) >= 0 : tt.find(o, this, null, [l]).length), i[o] && i.push(s);
                    }i.length && r.push({ elem: l, handlers: i });
                }
            }return a < e.length && r.push({ elem: this, handlers: e.slice(a) }), r;
        }, props: "altKey bubbles cancelable ctrlKey currentTarget eventPhase metaKey relatedTarget shiftKey target timeStamp view which".split(" "), fixHooks: {}, keyHooks: { props: "char charCode key keyCode".split(" "), filter: function filter(t, e) {
                return null == t.which && (t.which = null != e.charCode ? e.charCode : e.keyCode), t;
            } }, mouseHooks: { props: "button buttons clientX clientY offsetX offsetY pageX pageY screenX screenY toElement".split(" "), filter: function filter(t, e) {
                var n,
                    i,
                    o,
                    s = e.button;return null == t.pageX && null != e.clientX && (n = t.target.ownerDocument || J, i = n.documentElement, o = n.body, t.pageX = e.clientX + (i && i.scrollLeft || o && o.scrollLeft || 0) - (i && i.clientLeft || o && o.clientLeft || 0), t.pageY = e.clientY + (i && i.scrollTop || o && o.scrollTop || 0) - (i && i.clientTop || o && o.clientTop || 0)), t.which || void 0 === s || (t.which = 1 & s ? 1 : 2 & s ? 3 : 4 & s ? 2 : 0), t;
            } }, fix: function fix(t) {
            if (t[tt.expando]) return t;var e,
                n,
                i,
                o = t.type,
                s = t,
                r = this.fixHooks[o];for (r || (this.fixHooks[o] = r = At.test(o) ? this.mouseHooks : St.test(o) ? this.keyHooks : {}), i = r.props ? this.props.concat(r.props) : this.props, t = new tt.Event(s), e = i.length; e--;) {
                n = i[e], t[n] = s[n];
            }return t.target || (t.target = J), 3 === t.target.nodeType && (t.target = t.target.parentNode), r.filter ? r.filter(t, s) : t;
        }, special: { load: { noBubble: !0 }, focus: { trigger: function trigger() {
                    return this !== h() && this.focus ? (this.focus(), !1) : void 0;
                }, delegateType: "focusin" }, blur: { trigger: function trigger() {
                    return this === h() && this.blur ? (this.blur(), !1) : void 0;
                }, delegateType: "focusout" }, click: { trigger: function trigger() {
                    return "checkbox" === this.type && this.click && tt.nodeName(this, "input") ? (this.click(), !1) : void 0;
                }, _default: function _default(t) {
                    return tt.nodeName(t.target, "a");
                } }, beforeunload: { postDispatch: function postDispatch(t) {
                    void 0 !== t.result && (t.originalEvent.returnValue = t.result);
                } } }, simulate: function simulate(t, e, n, i) {
            var o = tt.extend(new tt.Event(), n, { type: t, isSimulated: !0, originalEvent: {} });i ? tt.event.trigger(o, null, e) : tt.event.dispatch.call(e, o), o.isDefaultPrevented() && n.preventDefault();
        } }, tt.removeEvent = function (t, e, n) {
        t.removeEventListener && t.removeEventListener(e, n, !1);
    }, tt.Event = function (t, e) {
        return this instanceof tt.Event ? (t && t.type ? (this.originalEvent = t, this.type = t.type, this.isDefaultPrevented = t.defaultPrevented || void 0 === t.defaultPrevented && t.getPreventDefault && t.getPreventDefault() ? c : u) : this.type = t, e && tt.extend(this, e), this.timeStamp = t && t.timeStamp || tt.now(), void (this[tt.expando] = !0)) : new tt.Event(t, e);
    }, tt.Event.prototype = { isDefaultPrevented: u, isPropagationStopped: u, isImmediatePropagationStopped: u, preventDefault: function preventDefault() {
            var t = this.originalEvent;this.isDefaultPrevented = c, t && t.preventDefault && t.preventDefault();
        }, stopPropagation: function stopPropagation() {
            var t = this.originalEvent;this.isPropagationStopped = c, t && t.stopPropagation && t.stopPropagation();
        }, stopImmediatePropagation: function stopImmediatePropagation() {
            this.isImmediatePropagationStopped = c, this.stopPropagation();
        } }, tt.each({ mouseenter: "mouseover", mouseleave: "mouseout" }, function (t, e) {
        tt.event.special[t] = { delegateType: e, bindType: e, handle: function handle(t) {
                var n,
                    i = this,
                    o = t.relatedTarget,
                    s = t.handleObj;return (!o || o !== i && !tt.contains(i, o)) && (t.type = s.origType, n = s.handler.apply(this, arguments), t.type = e), n;
            } };
    }), Q.focusinBubbles || tt.each({ focus: "focusin", blur: "focusout" }, function (t, e) {
        var n = function n(t) {
            tt.event.simulate(e, t.target, tt.event.fix(t), !0);
        };tt.event.special[e] = { setup: function setup() {
                var i = this.ownerDocument || this,
                    o = mt.access(i, e);o || i.addEventListener(t, n, !0), mt.access(i, e, (o || 0) + 1);
            }, teardown: function teardown() {
                var i = this.ownerDocument || this,
                    o = mt.access(i, e) - 1;o ? mt.access(i, e, o) : (i.removeEventListener(t, n, !0), mt.remove(i, e));
            } };
    }), tt.fn.extend({ on: function on(t, e, n, i, o) {
            var s, r;if ("object" == (void 0 === t ? "undefined" : _typeof(t))) {
                "string" != typeof e && (n = n || e, e = void 0);for (r in t) {
                    this.on(r, e, n, t[r], o);
                }return this;
            }if (null == n && null == i ? (i = e, n = e = void 0) : null == i && ("string" == typeof e ? (i = n, n = void 0) : (i = n, n = e, e = void 0)), !1 === i) i = u;else if (!i) return this;return 1 === o && (s = i, i = function i(t) {
                return tt().off(t), s.apply(this, arguments);
            }, i.guid = s.guid || (s.guid = tt.guid++)), this.each(function () {
                tt.event.add(this, t, i, n, e);
            });
        }, one: function one(t, e, n, i) {
            return this.on(t, e, n, i, 1);
        }, off: function off(t, e, n) {
            var i, o;if (t && t.preventDefault && t.handleObj) return i = t.handleObj, tt(t.delegateTarget).off(i.namespace ? i.origType + "." + i.namespace : i.origType, i.selector, i.handler), this;if ("object" == (void 0 === t ? "undefined" : _typeof(t))) {
                for (o in t) {
                    this.off(o, e, t[o]);
                }return this;
            }return (!1 === e || "function" == typeof e) && (n = e, e = void 0), !1 === n && (n = u), this.each(function () {
                tt.event.remove(this, t, n, e);
            });
        }, trigger: function trigger(t, e) {
            return this.each(function () {
                tt.event.trigger(t, e, this);
            });
        }, triggerHandler: function triggerHandler(t, e) {
            var n = this[0];return n ? tt.event.trigger(t, e, n, !0) : void 0;
        } });var kt = /<(?!area|br|col|embed|hr|img|input|link|meta|param)(([\w:]+)[^>]*)\/>/gi,
        Dt = /<([\w:]+)/,
        Ot = /<|&#?\w+;/,
        $t = /<(?:script|style|link)/i,
        It = /checked\s*(?:[^=]|=\s*.checked.)/i,
        Nt = /^$|\/(?:java|ecma)script/i,
        Lt = /^true\/(.*)/,
        jt = /^\s*<!(?:\[CDATA\[|--)|(?:\]\]|--)>\s*$/g,
        zt = { option: [1, "<select multiple='multiple'>", "</select>"], thead: [1, "<table>", "</table>"], col: [2, "<table><colgroup>", "</colgroup></table>"], tr: [2, "<table><tbody>", "</tbody></table>"], td: [3, "<table><tbody><tr>", "</tr></tbody></table>"], _default: [0, "", ""] };zt.optgroup = zt.option, zt.tbody = zt.tfoot = zt.colgroup = zt.caption = zt.thead, zt.th = zt.td, tt.extend({ clone: function clone(t, e, n) {
            var i,
                o,
                s,
                r,
                a = t.cloneNode(!0),
                l = tt.contains(t.ownerDocument, t);if (!(Q.noCloneChecked || 1 !== t.nodeType && 11 !== t.nodeType || tt.isXMLDoc(t))) for (r = v(a), s = v(t), i = 0, o = s.length; o > i; i++) {
                y(s[i], r[i]);
            }if (e) if (n) for (s = s || v(t), r = r || v(a), i = 0, o = s.length; o > i; i++) {
                m(s[i], r[i]);
            } else m(t, a);return r = v(a, "script"), r.length > 0 && g(r, !l && v(t, "script")), a;
        }, buildFragment: function buildFragment(t, e, n, i) {
            for (var o, s, r, a, l, c, u = e.createDocumentFragment(), h = [], p = 0, d = t.length; d > p; p++) {
                if ((o = t[p]) || 0 === o) if ("object" === tt.type(o)) tt.merge(h, o.nodeType ? [o] : o);else if (Ot.test(o)) {
                    for (s = s || u.appendChild(e.createElement("div")), r = (Dt.exec(o) || ["", ""])[1].toLowerCase(), a = zt[r] || zt._default, s.innerHTML = a[1] + o.replace(kt, "<$1></$2>") + a[2], c = a[0]; c--;) {
                        s = s.lastChild;
                    }tt.merge(h, s.childNodes), s = u.firstChild, s.textContent = "";
                } else h.push(e.createTextNode(o));
            }for (u.textContent = "", p = 0; o = h[p++];) {
                if ((!i || -1 === tt.inArray(o, i)) && (l = tt.contains(o.ownerDocument, o), s = v(u.appendChild(o), "script"), l && g(s), n)) for (c = 0; o = s[c++];) {
                    Nt.test(o.type || "") && n.push(o);
                }
            }return u;
        }, cleanData: function cleanData(t) {
            for (var e, n, i, o, s, r, a = tt.event.special, l = 0; void 0 !== (n = t[l]); l++) {
                if (tt.acceptData(n) && (s = n[mt.expando]) && (e = mt.cache[s])) {
                    if (i = Object.keys(e.events || {}), i.length) for (r = 0; void 0 !== (o = i[r]); r++) {
                        a[o] ? tt.event.remove(n, o) : tt.removeEvent(n, o, e.handle);
                    }mt.cache[s] && delete mt.cache[s];
                }delete vt.cache[n[vt.expando]];
            }
        } }), tt.fn.extend({ text: function text(t) {
            return gt(this, function (t) {
                return void 0 === t ? tt.text(this) : this.empty().each(function () {
                    (1 === this.nodeType || 11 === this.nodeType || 9 === this.nodeType) && (this.textContent = t);
                });
            }, null, t, arguments.length);
        }, append: function append() {
            return this.domManip(arguments, function (t) {
                if (1 === this.nodeType || 11 === this.nodeType || 9 === this.nodeType) {
                    p(this, t).appendChild(t);
                }
            });
        }, prepend: function prepend() {
            return this.domManip(arguments, function (t) {
                if (1 === this.nodeType || 11 === this.nodeType || 9 === this.nodeType) {
                    var e = p(this, t);e.insertBefore(t, e.firstChild);
                }
            });
        }, before: function before() {
            return this.domManip(arguments, function (t) {
                this.parentNode && this.parentNode.insertBefore(t, this);
            });
        }, after: function after() {
            return this.domManip(arguments, function (t) {
                this.parentNode && this.parentNode.insertBefore(t, this.nextSibling);
            });
        }, remove: function remove(t, e) {
            for (var n, i = t ? tt.filter(t, this) : this, o = 0; null != (n = i[o]); o++) {
                e || 1 !== n.nodeType || tt.cleanData(v(n)), n.parentNode && (e && tt.contains(n.ownerDocument, n) && g(v(n, "script")), n.parentNode.removeChild(n));
            }return this;
        }, empty: function empty() {
            for (var t, e = 0; null != (t = this[e]); e++) {
                1 === t.nodeType && (tt.cleanData(v(t, !1)), t.textContent = "");
            }return this;
        }, clone: function clone(t, e) {
            return t = null != t && t, e = null == e ? t : e, this.map(function () {
                return tt.clone(this, t, e);
            });
        }, html: function html(t) {
            return gt(this, function (t) {
                var e = this[0] || {},
                    n = 0,
                    i = this.length;if (void 0 === t && 1 === e.nodeType) return e.innerHTML;if ("string" == typeof t && !$t.test(t) && !zt[(Dt.exec(t) || ["", ""])[1].toLowerCase()]) {
                    t = t.replace(kt, "<$1></$2>");try {
                        for (; i > n; n++) {
                            e = this[n] || {}, 1 === e.nodeType && (tt.cleanData(v(e, !1)), e.innerHTML = t);
                        }e = 0;
                    } catch (t) {}
                }e && this.empty().append(t);
            }, null, t, arguments.length);
        }, replaceWith: function replaceWith() {
            var t = arguments[0];return this.domManip(arguments, function (e) {
                t = this.parentNode, tt.cleanData(v(this)), t && t.replaceChild(e, this);
            }), t && (t.length || t.nodeType) ? this : this.remove();
        }, detach: function detach(t) {
            return this.remove(t, !0);
        }, domManip: function domManip(t, e) {
            t = B.apply([], t);var n,
                i,
                o,
                s,
                r,
                a,
                l = 0,
                c = this.length,
                u = this,
                h = c - 1,
                p = t[0],
                g = tt.isFunction(p);if (g || c > 1 && "string" == typeof p && !Q.checkClone && It.test(p)) return this.each(function (n) {
                var i = u.eq(n);g && (t[0] = p.call(this, n, i.html())), i.domManip(t, e);
            });if (c && (n = tt.buildFragment(t, this[0].ownerDocument, !1, this), i = n.firstChild, 1 === n.childNodes.length && (n = i), i)) {
                for (o = tt.map(v(n, "script"), d), s = o.length; c > l; l++) {
                    r = n, l !== h && (r = tt.clone(r, !0, !0), s && tt.merge(o, v(r, "script"))), e.call(this[l], r, l);
                }if (s) for (a = o[o.length - 1].ownerDocument, tt.map(o, f), l = 0; s > l; l++) {
                    r = o[l], Nt.test(r.type || "") && !mt.access(r, "globalEval") && tt.contains(a, r) && (r.src ? tt._evalUrl && tt._evalUrl(r.src) : tt.globalEval(r.textContent.replace(jt, "")));
                }
            }return this;
        } }), tt.each({ appendTo: "append", prependTo: "prepend", insertBefore: "before", insertAfter: "after", replaceAll: "replaceWith" }, function (t, e) {
        tt.fn[t] = function (t) {
            for (var n, i = [], o = tt(t), s = o.length - 1, r = 0; s >= r; r++) {
                n = r === s ? this : this.clone(!0), tt(o[r])[e](n), U.apply(i, n.get());
            }return this.pushStack(i);
        };
    });var Ht,
        Rt = {},
        Mt = /^margin/,
        qt = new RegExp("^(" + wt + ")(?!px)[a-z%]+$", "i"),
        Wt = function Wt(t) {
        return t.ownerDocument.defaultView.getComputedStyle(t, null);
    };!function () {
        function e() {
            r.style.cssText = "-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;padding:1px;border:1px;display:block;width:4px;margin-top:1%;position:absolute;top:1%", o.appendChild(s);var e = t.getComputedStyle(r, null);n = "1%" !== e.top, i = "4px" === e.width, o.removeChild(s);
        }var n,
            i,
            o = J.documentElement,
            s = J.createElement("div"),
            r = J.createElement("div");r.style.backgroundClip = "content-box", r.cloneNode(!0).style.backgroundClip = "", Q.clearCloneStyle = "content-box" === r.style.backgroundClip, s.style.cssText = "border:0;width:0;height:0;position:absolute;top:0;left:-9999px;margin-top:1px", s.appendChild(r), t.getComputedStyle && tt.extend(Q, { pixelPosition: function pixelPosition() {
                return e(), n;
            }, boxSizingReliable: function boxSizingReliable() {
                return null == i && e(), i;
            }, reliableMarginRight: function reliableMarginRight() {
                var e,
                    n = r.appendChild(J.createElement("div"));return n.style.cssText = r.style.cssText = "padding:0;margin:0;border:0;display:block;-webkit-box-sizing:content-box;-moz-box-sizing:content-box;box-sizing:content-box", n.style.marginRight = n.style.width = "0", r.style.width = "1px", o.appendChild(s), e = !parseFloat(t.getComputedStyle(n, null).marginRight), o.removeChild(s), r.innerHTML = "", e;
            } });
    }(), tt.swap = function (t, e, n, i) {
        var o,
            s,
            r = {};for (s in e) {
            r[s] = t.style[s], t.style[s] = e[s];
        }o = n.apply(t, i || []);for (s in e) {
            t.style[s] = r[s];
        }return o;
    };var Ft = /^(none|table(?!-c[ea]).+)/,
        Bt = new RegExp("^(" + wt + ")(.*)$", "i"),
        Ut = new RegExp("^([+-])=(" + wt + ")", "i"),
        Vt = { position: "absolute", visibility: "hidden", display: "block" },
        Xt = { letterSpacing: 0, fontWeight: 400 },
        Yt = ["Webkit", "O", "Moz", "ms"];tt.extend({ cssHooks: { opacity: { get: function get(t, e) {
                    if (e) {
                        var n = _(t, "opacity");return "" === n ? "1" : n;
                    }
                } } }, cssNumber: { columnCount: !0, fillOpacity: !0, fontWeight: !0, lineHeight: !0, opacity: !0, order: !0, orphans: !0, widows: !0, zIndex: !0, zoom: !0 }, cssProps: { float: "cssFloat" }, style: function style(t, e, n, i) {
            if (t && 3 !== t.nodeType && 8 !== t.nodeType && t.style) {
                var o,
                    s,
                    r,
                    a = tt.camelCase(e),
                    l = t.style;return e = tt.cssProps[a] || (tt.cssProps[a] = C(l, a)), r = tt.cssHooks[e] || tt.cssHooks[a], void 0 === n ? r && "get" in r && void 0 !== (o = r.get(t, !1, i)) ? o : l[e] : (s = void 0 === n ? "undefined" : _typeof(n), "string" === s && (o = Ut.exec(n)) && (n = (o[1] + 1) * o[2] + parseFloat(tt.css(t, e)), s = "number"), void (null != n && n === n && ("number" !== s || tt.cssNumber[a] || (n += "px"), Q.clearCloneStyle || "" !== n || 0 !== e.indexOf("background") || (l[e] = "inherit"), r && "set" in r && void 0 === (n = r.set(t, n, i)) || (l[e] = "", l[e] = n))));
            }
        }, css: function css(t, e, n, i) {
            var o,
                s,
                r,
                a = tt.camelCase(e);return e = tt.cssProps[a] || (tt.cssProps[a] = C(t.style, a)), r = tt.cssHooks[e] || tt.cssHooks[a], r && "get" in r && (o = r.get(t, !0, n)), void 0 === o && (o = _(t, e, i)), "normal" === o && e in Xt && (o = Xt[e]), "" === n || n ? (s = parseFloat(o), !0 === n || tt.isNumeric(s) ? s || 0 : o) : o;
        } }), tt.each(["height", "width"], function (t, e) {
        tt.cssHooks[e] = { get: function get(t, n, i) {
                return n ? 0 === t.offsetWidth && Ft.test(tt.css(t, "display")) ? tt.swap(t, Vt, function () {
                    return A(t, e, i);
                }) : A(t, e, i) : void 0;
            }, set: function set(t, n, i) {
                var o = i && Wt(t);return T(t, n, i ? S(t, e, i, "border-box" === tt.css(t, "boxSizing", !1, o), o) : 0);
            } };
    }), tt.cssHooks.marginRight = x(Q.reliableMarginRight, function (t, e) {
        return e ? tt.swap(t, { display: "inline-block"
        }, _, [t, "marginRight"]) : void 0;
    }), tt.each({ margin: "", padding: "", border: "Width" }, function (t, e) {
        tt.cssHooks[t + e] = { expand: function expand(n) {
                for (var i = 0, o = {}, s = "string" == typeof n ? n.split(" ") : [n]; 4 > i; i++) {
                    o[t + _t[i] + e] = s[i] || s[i - 2] || s[0];
                }return o;
            } }, Mt.test(t) || (tt.cssHooks[t + e].set = T);
    }), tt.fn.extend({ css: function css(t, e) {
            return gt(this, function (t, e, n) {
                var i,
                    o,
                    s = {},
                    r = 0;if (tt.isArray(e)) {
                    for (i = Wt(t), o = e.length; o > r; r++) {
                        s[e[r]] = tt.css(t, e[r], !1, i);
                    }return s;
                }return void 0 !== n ? tt.style(t, e, n) : tt.css(t, e);
            }, t, e, arguments.length > 1);
        }, show: function show() {
            return E(this, !0);
        }, hide: function hide() {
            return E(this);
        }, toggle: function toggle(t) {
            return "boolean" == typeof t ? t ? this.show() : this.hide() : this.each(function () {
                xt(this) ? tt(this).show() : tt(this).hide();
            });
        } }), tt.Tween = P, P.prototype = { constructor: P, init: function init(t, e, n, i, o, s) {
            this.elem = t, this.prop = n, this.easing = o || "swing", this.options = e, this.start = this.now = this.cur(), this.end = i, this.unit = s || (tt.cssNumber[n] ? "" : "px");
        }, cur: function cur() {
            var t = P.propHooks[this.prop];return t && t.get ? t.get(this) : P.propHooks._default.get(this);
        }, run: function run(t) {
            var e,
                n = P.propHooks[this.prop];return this.pos = e = this.options.duration ? tt.easing[this.easing](t, this.options.duration * t, 0, 1, this.options.duration) : t, this.now = (this.end - this.start) * e + this.start, this.options.step && this.options.step.call(this.elem, this.now, this), n && n.set ? n.set(this) : P.propHooks._default.set(this), this;
        } }, P.prototype.init.prototype = P.prototype, P.propHooks = { _default: { get: function get(t) {
                var e;return null == t.elem[t.prop] || t.elem.style && null != t.elem.style[t.prop] ? (e = tt.css(t.elem, t.prop, ""), e && "auto" !== e ? e : 0) : t.elem[t.prop];
            }, set: function set(t) {
                tt.fx.step[t.prop] ? tt.fx.step[t.prop](t) : t.elem.style && (null != t.elem.style[tt.cssProps[t.prop]] || tt.cssHooks[t.prop]) ? tt.style(t.elem, t.prop, t.now + t.unit) : t.elem[t.prop] = t.now;
            } } }, P.propHooks.scrollTop = P.propHooks.scrollLeft = { set: function set(t) {
            t.elem.nodeType && t.elem.parentNode && (t.elem[t.prop] = t.now);
        } }, tt.easing = { linear: function linear(t) {
            return t;
        }, swing: function swing(t) {
            return .5 - Math.cos(t * Math.PI) / 2;
        } }, tt.fx = P.prototype.init, tt.fx.step = {};var Kt,
        Gt,
        Qt = /^(?:toggle|show|hide)$/,
        Jt = new RegExp("^(?:([+-])=|)(" + wt + ")([a-z%]*)$", "i"),
        Zt = /queueHooks$/,
        te = [$],
        ee = { "*": [function (t, e) {
            var n = this.createTween(t, e),
                i = n.cur(),
                o = Jt.exec(e),
                s = o && o[3] || (tt.cssNumber[t] ? "" : "px"),
                r = (tt.cssNumber[t] || "px" !== s && +i) && Jt.exec(tt.css(n.elem, t)),
                a = 1,
                l = 20;if (r && r[3] !== s) {
                s = s || r[3], o = o || [], r = +i || 1;do {
                    a = a || ".5", r /= a, tt.style(n.elem, t, r + s);
                } while (a !== (a = n.cur() / i) && 1 !== a && --l);
            }return o && (r = n.start = +r || +i || 0, n.unit = s, n.end = o[1] ? r + (o[1] + 1) * o[2] : +o[2]), n;
        }] };tt.Animation = tt.extend(N, { tweener: function tweener(t, e) {
            tt.isFunction(t) ? (e = t, t = ["*"]) : t = t.split(" ");for (var n, i = 0, o = t.length; o > i; i++) {
                n = t[i], ee[n] = ee[n] || [], ee[n].unshift(e);
            }
        }, prefilter: function prefilter(t, e) {
            e ? te.unshift(t) : te.push(t);
        } }), tt.speed = function (t, e, n) {
        var i = t && "object" == (void 0 === t ? "undefined" : _typeof(t)) ? tt.extend({}, t) : { complete: n || !n && e || tt.isFunction(t) && t, duration: t, easing: n && e || e && !tt.isFunction(e) && e };return i.duration = tt.fx.off ? 0 : "number" == typeof i.duration ? i.duration : i.duration in tt.fx.speeds ? tt.fx.speeds[i.duration] : tt.fx.speeds._default, (null == i.queue || !0 === i.queue) && (i.queue = "fx"), i.old = i.complete, i.complete = function () {
            tt.isFunction(i.old) && i.old.call(this), i.queue && tt.dequeue(this, i.queue);
        }, i;
    }, tt.fn.extend({ fadeTo: function fadeTo(t, e, n, i) {
            return this.filter(xt).css("opacity", 0).show().end().animate({ opacity: e }, t, n, i);
        }, animate: function animate(t, e, n, i) {
            var o = tt.isEmptyObject(t),
                s = tt.speed(e, n, i),
                r = function r() {
                var e = N(this, tt.extend({}, t), s);(o || mt.get(this, "finish")) && e.stop(!0);
            };return r.finish = r, o || !1 === s.queue ? this.each(r) : this.queue(s.queue, r);
        }, stop: function stop(t, e, n) {
            var i = function i(t) {
                var e = t.stop;delete t.stop, e(n);
            };return "string" != typeof t && (n = e, e = t, t = void 0), e && !1 !== t && this.queue(t || "fx", []), this.each(function () {
                var e = !0,
                    o = null != t && t + "queueHooks",
                    s = tt.timers,
                    r = mt.get(this);if (o) r[o] && r[o].stop && i(r[o]);else for (o in r) {
                    r[o] && r[o].stop && Zt.test(o) && i(r[o]);
                }for (o = s.length; o--;) {
                    s[o].elem !== this || null != t && s[o].queue !== t || (s[o].anim.stop(n), e = !1, s.splice(o, 1));
                }(e || !n) && tt.dequeue(this, t);
            });
        }, finish: function finish(t) {
            return !1 !== t && (t = t || "fx"), this.each(function () {
                var e,
                    n = mt.get(this),
                    i = n[t + "queue"],
                    o = n[t + "queueHooks"],
                    s = tt.timers,
                    r = i ? i.length : 0;for (n.finish = !0, tt.queue(this, t, []), o && o.stop && o.stop.call(this, !0), e = s.length; e--;) {
                    s[e].elem === this && s[e].queue === t && (s[e].anim.stop(!0), s.splice(e, 1));
                }for (e = 0; r > e; e++) {
                    i[e] && i[e].finish && i[e].finish.call(this);
                }delete n.finish;
            });
        } }), tt.each(["toggle", "show", "hide"], function (t, e) {
        var n = tt.fn[e];tt.fn[e] = function (t, i, o) {
            return null == t || "boolean" == typeof t ? n.apply(this, arguments) : this.animate(D(e, !0), t, i, o);
        };
    }), tt.each({ slideDown: D("show"), slideUp: D("hide"), slideToggle: D("toggle"), fadeIn: { opacity: "show" }, fadeOut: { opacity: "hide" }, fadeToggle: { opacity: "toggle" } }, function (t, e) {
        tt.fn[t] = function (t, n, i) {
            return this.animate(e, t, n, i);
        };
    }), tt.timers = [], tt.fx.tick = function () {
        var t,
            e = 0,
            n = tt.timers;for (Kt = tt.now(); e < n.length; e++) {
            (t = n[e])() || n[e] !== t || n.splice(e--, 1);
        }n.length || tt.fx.stop(), Kt = void 0;
    }, tt.fx.timer = function (t) {
        tt.timers.push(t), t() ? tt.fx.start() : tt.timers.pop();
    }, tt.fx.interval = 13, tt.fx.start = function () {
        Gt || (Gt = setInterval(tt.fx.tick, tt.fx.interval));
    }, tt.fx.stop = function () {
        clearInterval(Gt), Gt = null;
    }, tt.fx.speeds = { slow: 600, fast: 200, _default: 400 }, tt.fn.delay = function (t, e) {
        return t = tt.fx ? tt.fx.speeds[t] || t : t, e = e || "fx", this.queue(e, function (e, n) {
            var i = setTimeout(e, t);n.stop = function () {
                clearTimeout(i);
            };
        });
    }, function () {
        var t = J.createElement("input"),
            e = J.createElement("select"),
            n = e.appendChild(J.createElement("option"));t.type = "checkbox", Q.checkOn = "" !== t.value, Q.optSelected = n.selected, e.disabled = !0, Q.optDisabled = !n.disabled, t = J.createElement("input"), t.value = "t", t.type = "radio", Q.radioValue = "t" === t.value;
    }();var ne,
        ie = tt.expr.attrHandle;tt.fn.extend({ attr: function attr(t, e) {
            return gt(this, tt.attr, t, e, arguments.length > 1);
        }, removeAttr: function removeAttr(t) {
            return this.each(function () {
                tt.removeAttr(this, t);
            });
        } }), tt.extend({ attr: function attr(t, e, n) {
            var i,
                o,
                s = t.nodeType;if (t && 3 !== s && 8 !== s && 2 !== s) return _typeof(t.getAttribute) === Tt ? tt.prop(t, e, n) : (1 === s && tt.isXMLDoc(t) || (e = e.toLowerCase(), i = tt.attrHooks[e] || (tt.expr.match.bool.test(e) ? ne : void 0)), void 0 === n ? i && "get" in i && null !== (o = i.get(t, e)) ? o : (o = tt.find.attr(t, e), null == o ? void 0 : o) : null !== n ? i && "set" in i && void 0 !== (o = i.set(t, n, e)) ? o : (t.setAttribute(e, n + ""), n) : void tt.removeAttr(t, e));
        }, removeAttr: function removeAttr(t, e) {
            var n,
                i,
                o = 0,
                s = e && e.match(pt);if (s && 1 === t.nodeType) for (; n = s[o++];) {
                i = tt.propFix[n] || n, tt.expr.match.bool.test(n) && (t[i] = !1), t.removeAttribute(n);
            }
        }, attrHooks: { type: { set: function set(t, e) {
                    if (!Q.radioValue && "radio" === e && tt.nodeName(t, "input")) {
                        var n = t.value;return t.setAttribute("type", e), n && (t.value = n), e;
                    }
                } } } }), ne = { set: function set(t, e, n) {
            return !1 === e ? tt.removeAttr(t, n) : t.setAttribute(n, n), n;
        } }, tt.each(tt.expr.match.bool.source.match(/\w+/g), function (t, e) {
        var n = ie[e] || tt.find.attr;ie[e] = function (t, e, i) {
            var o, s;return i || (s = ie[e], ie[e] = o, o = null != n(t, e, i) ? e.toLowerCase() : null, ie[e] = s), o;
        };
    });var oe = /^(?:input|select|textarea|button)$/i;tt.fn.extend({ prop: function prop(t, e) {
            return gt(this, tt.prop, t, e, arguments.length > 1);
        }, removeProp: function removeProp(t) {
            return this.each(function () {
                delete this[tt.propFix[t] || t];
            });
        } }), tt.extend({ propFix: { for: "htmlFor", class: "className" }, prop: function prop(t, e, n) {
            var i,
                o,
                s,
                r = t.nodeType;if (t && 3 !== r && 8 !== r && 2 !== r) return s = 1 !== r || !tt.isXMLDoc(t), s && (e = tt.propFix[e] || e, o = tt.propHooks[e]), void 0 !== n ? o && "set" in o && void 0 !== (i = o.set(t, n, e)) ? i : t[e] = n : o && "get" in o && null !== (i = o.get(t, e)) ? i : t[e];
        }, propHooks: { tabIndex: { get: function get(t) {
                    return t.hasAttribute("tabindex") || oe.test(t.nodeName) || t.href ? t.tabIndex : -1;
                } } } }), Q.optSelected || (tt.propHooks.selected = { get: function get(t) {
            var e = t.parentNode;return e && e.parentNode && e.parentNode.selectedIndex, null;
        } }), tt.each(["tabIndex", "readOnly", "maxLength", "cellSpacing", "cellPadding", "rowSpan", "colSpan", "useMap", "frameBorder", "contentEditable"], function () {
        tt.propFix[this.toLowerCase()] = this;
    });var se = /[\t\r\n\f]/g;tt.fn.extend({ addClass: function addClass(t) {
            var e,
                n,
                i,
                o,
                s,
                r,
                a = "string" == typeof t && t,
                l = 0,
                c = this.length;if (tt.isFunction(t)) return this.each(function (e) {
                tt(this).addClass(t.call(this, e, this.className));
            });if (a) for (e = (t || "").match(pt) || []; c > l; l++) {
                if (n = this[l], i = 1 === n.nodeType && (n.className ? (" " + n.className + " ").replace(se, " ") : " ")) {
                    for (s = 0; o = e[s++];) {
                        i.indexOf(" " + o + " ") < 0 && (i += o + " ");
                    }r = tt.trim(i), n.className !== r && (n.className = r);
                }
            }return this;
        }, removeClass: function removeClass(t) {
            var e,
                n,
                i,
                o,
                s,
                r,
                a = 0 === arguments.length || "string" == typeof t && t,
                l = 0,
                c = this.length;if (tt.isFunction(t)) return this.each(function (e) {
                tt(this).removeClass(t.call(this, e, this.className));
            });if (a) for (e = (t || "").match(pt) || []; c > l; l++) {
                if (n = this[l], i = 1 === n.nodeType && (n.className ? (" " + n.className + " ").replace(se, " ") : "")) {
                    for (s = 0; o = e[s++];) {
                        for (; i.indexOf(" " + o + " ") >= 0;) {
                            i = i.replace(" " + o + " ", " ");
                        }
                    }r = t ? tt.trim(i) : "", n.className !== r && (n.className = r);
                }
            }return this;
        }, toggleClass: function toggleClass(t, e) {
            var n = void 0 === t ? "undefined" : _typeof(t);return "boolean" == typeof e && "string" === n ? e ? this.addClass(t) : this.removeClass(t) : this.each(tt.isFunction(t) ? function (n) {
                tt(this).toggleClass(t.call(this, n, this.className, e), e);
            } : function () {
                if ("string" === n) for (var e, i = 0, o = tt(this), s = t.match(pt) || []; e = s[i++];) {
                    o.hasClass(e) ? o.removeClass(e) : o.addClass(e);
                } else (n === Tt || "boolean" === n) && (this.className && mt.set(this, "__className__", this.className), this.className = this.className || !1 === t ? "" : mt.get(this, "__className__") || "");
            });
        }, hasClass: function hasClass(t) {
            for (var e = " " + t + " ", n = 0, i = this.length; i > n; n++) {
                if (1 === this[n].nodeType && (" " + this[n].className + " ").replace(se, " ").indexOf(e) >= 0) return !0;
            }return !1;
        } });var re = /\r/g;tt.fn.extend({ val: function val(t) {
            var e,
                n,
                i,
                o = this[0];return arguments.length ? (i = tt.isFunction(t), this.each(function (n) {
                var o;1 === this.nodeType && (o = i ? t.call(this, n, tt(this).val()) : t, null == o ? o = "" : "number" == typeof o ? o += "" : tt.isArray(o) && (o = tt.map(o, function (t) {
                    return null == t ? "" : t + "";
                })), (e = tt.valHooks[this.type] || tt.valHooks[this.nodeName.toLowerCase()]) && "set" in e && void 0 !== e.set(this, o, "value") || (this.value = o));
            })) : o ? (e = tt.valHooks[o.type] || tt.valHooks[o.nodeName.toLowerCase()], e && "get" in e && void 0 !== (n = e.get(o, "value")) ? n : (n = o.value, "string" == typeof n ? n.replace(re, "") : null == n ? "" : n)) : void 0;
        } }), tt.extend({ valHooks: { select: { get: function get(t) {
                    for (var e, n, i = t.options, o = t.selectedIndex, s = "select-one" === t.type || 0 > o, r = s ? null : [], a = s ? o + 1 : i.length, l = 0 > o ? a : s ? o : 0; a > l; l++) {
                        if (n = i[l], !(!n.selected && l !== o || (Q.optDisabled ? n.disabled : null !== n.getAttribute("disabled")) || n.parentNode.disabled && tt.nodeName(n.parentNode, "optgroup"))) {
                            if (e = tt(n).val(), s) return e;r.push(e);
                        }
                    }return r;
                }, set: function set(t, e) {
                    for (var n, i, o = t.options, s = tt.makeArray(e), r = o.length; r--;) {
                        i = o[r], (i.selected = tt.inArray(tt(i).val(), s) >= 0) && (n = !0);
                    }return n || (t.selectedIndex = -1), s;
                } } } }), tt.each(["radio", "checkbox"], function () {
        tt.valHooks[this] = { set: function set(t, e) {
                return tt.isArray(e) ? t.checked = tt.inArray(tt(t).val(), e) >= 0 : void 0;
            } }, Q.checkOn || (tt.valHooks[this].get = function (t) {
            return null === t.getAttribute("value") ? "on" : t.value;
        });
    }), tt.each("blur focus focusin focusout load resize scroll unload click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup error contextmenu".split(" "), function (t, e) {
        tt.fn[e] = function (t, n) {
            return arguments.length > 0 ? this.on(e, null, t, n) : this.trigger(e);
        };
    }), tt.fn.extend({ hover: function hover(t, e) {
            return this.mouseenter(t).mouseleave(e || t);
        }, bind: function bind(t, e, n) {
            return this.on(t, null, e, n);
        }, unbind: function unbind(t, e) {
            return this.off(t, null, e);
        }, delegate: function delegate(t, e, n, i) {
            return this.on(e, t, n, i);
        }, undelegate: function undelegate(t, e, n) {
            return 1 === arguments.length ? this.off(t, "**") : this.off(e, t || "**", n);
        } });var ae = tt.now(),
        le = /\?/;tt.parseJSON = function (t) {
        return JSON.parse(t + "");
    }, tt.parseXML = function (t) {
        var e, n;if (!t || "string" != typeof t) return null;try {
            n = new DOMParser(), e = n.parseFromString(t, "text/xml");
        } catch (t) {
            e = void 0;
        }return (!e || e.getElementsByTagName("parsererror").length) && tt.error("Invalid XML: " + t), e;
    };var ce,
        ue,
        he = /#.*$/,
        pe = /([?&])_=[^&]*/,
        de = /^(.*?):[ \t]*([^\r\n]*)$/gm,
        fe = /^(?:about|app|app-storage|.+-extension|file|res|widget):$/,
        ge = /^(?:GET|HEAD)$/,
        me = /^\/\//,
        ve = /^([\w.+-]+:)(?:\/\/(?:[^\/?#]*@|)([^\/?#:]*)(?::(\d+)|)|)/,
        ye = {},
        be = {},
        we = "*/".concat("*");try {
        ue = location.href;
    } catch (t) {
        ue = J.createElement("a"), ue.href = "", ue = ue.href;
    }ce = ve.exec(ue.toLowerCase()) || [], tt.extend({ active: 0, lastModified: {}, etag: {}, ajaxSettings: { url: ue, type: "GET", isLocal: fe.test(ce[1]), global: !0, processData: !0, async: !0, contentType: "application/x-www-form-urlencoded; charset=UTF-8", accepts: { "*": we, text: "text/plain", html: "text/html", xml: "application/xml, text/xml", json: "application/json, text/javascript" }, contents: { xml: /xml/, html: /html/, json: /json/ }, responseFields: { xml: "responseXML", text: "responseText", json: "responseJSON" }, converters: { "* text": String, "text html": !0, "text json": tt.parseJSON, "text xml": tt.parseXML }, flatOptions: { url: !0, context: !0 } }, ajaxSetup: function ajaxSetup(t, e) {
            return e ? z(z(t, tt.ajaxSettings), e) : z(tt.ajaxSettings, t);
        }, ajaxPrefilter: L(ye), ajaxTransport: L(be), ajax: function ajax(t, e) {
            function n(t, e, n, r) {
                var l,
                    u,
                    v,
                    y,
                    w,
                    x = e;2 !== b && (b = 2, a && clearTimeout(a), i = void 0, s = r || "", _.readyState = t > 0 ? 4 : 0, l = t >= 200 && 300 > t || 304 === t, n && (y = H(h, _, n)), y = R(h, y, _, l), l ? (h.ifModified && (w = _.getResponseHeader("Last-Modified"), w && (tt.lastModified[o] = w), (w = _.getResponseHeader("etag")) && (tt.etag[o] = w)), 204 === t || "HEAD" === h.type ? x = "nocontent" : 304 === t ? x = "notmodified" : (x = y.state, u = y.data, v = y.error, l = !v)) : (v = x, (t || !x) && (x = "error", 0 > t && (t = 0))), _.status = t, _.statusText = (e || x) + "", l ? f.resolveWith(p, [u, x, _]) : f.rejectWith(p, [_, x, v]), _.statusCode(m), m = void 0, c && d.trigger(l ? "ajaxSuccess" : "ajaxError", [_, h, l ? u : v]), g.fireWith(p, [_, x]), c && (d.trigger("ajaxComplete", [_, h]), --tt.active || tt.event.trigger("ajaxStop")));
            }"object" == (void 0 === t ? "undefined" : _typeof(t)) && (e = t, t = void 0), e = e || {};var i,
                o,
                s,
                r,
                a,
                l,
                c,
                u,
                h = tt.ajaxSetup({}, e),
                p = h.context || h,
                d = h.context && (p.nodeType || p.jquery) ? tt(p) : tt.event,
                f = tt.Deferred(),
                g = tt.Callbacks("once memory"),
                m = h.statusCode || {},
                v = {},
                y = {},
                b = 0,
                w = "canceled",
                _ = { readyState: 0, getResponseHeader: function getResponseHeader(t) {
                    var e;if (2 === b) {
                        if (!r) for (r = {}; e = de.exec(s);) {
                            r[e[1].toLowerCase()] = e[2];
                        }e = r[t.toLowerCase()];
                    }return null == e ? null : e;
                }, getAllResponseHeaders: function getAllResponseHeaders() {
                    return 2 === b ? s : null;
                }, setRequestHeader: function setRequestHeader(t, e) {
                    var n = t.toLowerCase();return b || (t = y[n] = y[n] || t, v[t] = e), this;
                }, overrideMimeType: function overrideMimeType(t) {
                    return b || (h.mimeType = t), this;
                }, statusCode: function statusCode(t) {
                    var e;if (t) if (2 > b) for (e in t) {
                        m[e] = [m[e], t[e]];
                    } else _.always(t[_.status]);return this;
                }, abort: function abort(t) {
                    var e = t || w;return i && i.abort(e), n(0, e), this;
                } };if (f.promise(_).complete = g.add, _.success = _.done, _.error = _.fail, h.url = ((t || h.url || ue) + "").replace(he, "").replace(me, ce[1] + "//"), h.type = e.method || e.type || h.method || h.type, h.dataTypes = tt.trim(h.dataType || "*").toLowerCase().match(pt) || [""], null == h.crossDomain && (l = ve.exec(h.url.toLowerCase()), h.crossDomain = !(!l || l[1] === ce[1] && l[2] === ce[2] && (l[3] || ("http:" === l[1] ? "80" : "443")) === (ce[3] || ("http:" === ce[1] ? "80" : "443")))), h.data && h.processData && "string" != typeof h.data && (h.data = tt.param(h.data, h.traditional)), j(ye, h, e, _), 2 === b) return _;c = h.global, c && 0 == tt.active++ && tt.event.trigger("ajaxStart"), h.type = h.type.toUpperCase(), h.hasContent = !ge.test(h.type), o = h.url, h.hasContent || (h.data && (o = h.url += (le.test(o) ? "&" : "?") + h.data, delete h.data), !1 === h.cache && (h.url = pe.test(o) ? o.replace(pe, "$1_=" + ae++) : o + (le.test(o) ? "&" : "?") + "_=" + ae++)), h.ifModified && (tt.lastModified[o] && _.setRequestHeader("If-Modified-Since", tt.lastModified[o]), tt.etag[o] && _.setRequestHeader("If-None-Match", tt.etag[o])), (h.data && h.hasContent && !1 !== h.contentType || e.contentType) && _.setRequestHeader("Content-Type", h.contentType), _.setRequestHeader("Accept", h.dataTypes[0] && h.accepts[h.dataTypes[0]] ? h.accepts[h.dataTypes[0]] + ("*" !== h.dataTypes[0] ? ", " + we + "; q=0.01" : "") : h.accepts["*"]);for (u in h.headers) {
                _.setRequestHeader(u, h.headers[u]);
            }if (h.beforeSend && (!1 === h.beforeSend.call(p, _, h) || 2 === b)) return _.abort();w = "abort";for (u in { success: 1, error: 1, complete: 1 }) {
                _[u](h[u]);
            }if (i = j(be, h, e, _)) {
                _.readyState = 1, c && d.trigger("ajaxSend", [_, h]), h.async && h.timeout > 0 && (a = setTimeout(function () {
                    _.abort("timeout");
                }, h.timeout));try {
                    b = 1, i.send(v, n);
                } catch (t) {
                    if (!(2 > b)) throw t;n(-1, t);
                }
            } else n(-1, "No Transport");return _;
        }, getJSON: function getJSON(t, e, n) {
            return tt.get(t, e, n, "json");
        }, getScript: function getScript(t, e) {
            return tt.get(t, void 0, e, "script");
        } }), tt.each(["get", "post"], function (t, e) {
        tt[e] = function (t, n, i, o) {
            return tt.isFunction(n) && (o = o || i, i = n, n = void 0), tt.ajax({ url: t, type: e, dataType: o, data: n, success: i });
        };
    }), tt.each(["ajaxStart", "ajaxStop", "ajaxComplete", "ajaxError", "ajaxSuccess", "ajaxSend"], function (t, e) {
        tt.fn[e] = function (t) {
            return this.on(e, t);
        };
    }), tt._evalUrl = function (t) {
        return tt.ajax({ url: t, type: "GET", dataType: "script", async: !1, global: !1, throws: !0 });
    }, tt.fn.extend({ wrapAll: function wrapAll(t) {
            var e;return tt.isFunction(t) ? this.each(function (e) {
                tt(this).wrapAll(t.call(this, e));
            }) : (this[0] && (e = tt(t, this[0].ownerDocument).eq(0).clone(!0), this[0].parentNode && e.insertBefore(this[0]), e.map(function () {
                for (var t = this; t.firstElementChild;) {
                    t = t.firstElementChild;
                }return t;
            }).append(this)), this);
        }, wrapInner: function wrapInner(t) {
            return this.each(tt.isFunction(t) ? function (e) {
                tt(this).wrapInner(t.call(this, e));
            } : function () {
                var e = tt(this),
                    n = e.contents();n.length ? n.wrapAll(t) : e.append(t);
            });
        }, wrap: function wrap(t) {
            var e = tt.isFunction(t);return this.each(function (n) {
                tt(this).wrapAll(e ? t.call(this, n) : t);
            });
        }, unwrap: function unwrap() {
            return this.parent().each(function () {
                tt.nodeName(this, "body") || tt(this).replaceWith(this.childNodes);
            }).end();
        } }), tt.expr.filters.hidden = function (t) {
        return t.offsetWidth <= 0 && t.offsetHeight <= 0;
    }, tt.expr.filters.visible = function (t) {
        return !tt.expr.filters.hidden(t);
    };var _e = /%20/g,
        xe = /\[\]$/,
        Ce = /\r?\n/g,
        Te = /^(?:submit|button|image|reset|file)$/i,
        Se = /^(?:input|select|textarea|keygen)/i;tt.param = function (t, e) {
        var n,
            i = [],
            o = function o(t, e) {
            e = tt.isFunction(e) ? e() : null == e ? "" : e, i[i.length] = encodeURIComponent(t) + "=" + encodeURIComponent(e);
        };if (void 0 === e && (e = tt.ajaxSettings && tt.ajaxSettings.traditional), tt.isArray(t) || t.jquery && !tt.isPlainObject(t)) tt.each(t, function () {
            o(this.name, this.value);
        });else for (n in t) {
            M(n, t[n], e, o);
        }return i.join("&").replace(_e, "+");
    }, tt.fn.extend({ serialize: function serialize() {
            return tt.param(this.serializeArray());
        }, serializeArray: function serializeArray() {
            return this.map(function () {
                var t = tt.prop(this, "elements");return t ? tt.makeArray(t) : this;
            }).filter(function () {
                var t = this.type;return this.name && !tt(this).is(":disabled") && Se.test(this.nodeName) && !Te.test(t) && (this.checked || !Ct.test(t));
            }).map(function (t, e) {
                var n = tt(this).val();return null == n ? null : tt.isArray(n) ? tt.map(n, function (t) {
                    return { name: e.name, value: t.replace(Ce, "\r\n") };
                }) : { name: e.name, value: n.replace(Ce, "\r\n") };
            }).get();
        } }), tt.ajaxSettings.xhr = function () {
        try {
            return new XMLHttpRequest();
        } catch (t) {}
    };var Ae = 0,
        Ee = {},
        Pe = { 0: 200, 1223: 204 },
        ke = tt.ajaxSettings.xhr();t.ActiveXObject && tt(t).on("unload", function () {
        for (var t in Ee) {
            Ee[t]();
        }
    }), Q.cors = !!ke && "withCredentials" in ke, Q.ajax = ke = !!ke, tt.ajaxTransport(function (t) {
        var _e3;return Q.cors || ke && !t.crossDomain ? { send: function send(n, i) {
                var o,
                    s = t.xhr(),
                    r = ++Ae;if (s.open(t.type, t.url, t.async, t.username, t.password), t.xhrFields) for (o in t.xhrFields) {
                    s[o] = t.xhrFields[o];
                }t.mimeType && s.overrideMimeType && s.overrideMimeType(t.mimeType), t.crossDomain || n["X-Requested-With"] || (n["X-Requested-With"] = "XMLHttpRequest");for (o in n) {
                    s.setRequestHeader(o, n[o]);
                }_e3 = function e(t) {
                    return function () {
                        _e3 && (delete Ee[r], _e3 = s.onload = s.onerror = null, "abort" === t ? s.abort() : "error" === t ? i(s.status, s.statusText) : i(Pe[s.status] || s.status, s.statusText, "string" == typeof s.responseText ? { text: s.responseText } : void 0, s.getAllResponseHeaders()));
                    };
                }, s.onload = _e3(), s.onerror = _e3("error"), _e3 = Ee[r] = _e3("abort"), s.send(t.hasContent && t.data || null);
            }, abort: function abort() {
                _e3 && _e3();
            } } : void 0;
    }), tt.ajaxSetup({ accepts: { script: "text/javascript, application/javascript, application/ecmascript, application/x-ecmascript" }, contents: { script: /(?:java|ecma)script/ }, converters: { "text script": function textScript(t) {
                return tt.globalEval(t), t;
            } } }), tt.ajaxPrefilter("script", function (t) {
        void 0 === t.cache && (t.cache = !1), t.crossDomain && (t.type = "GET");
    }), tt.ajaxTransport("script", function (t) {
        if (t.crossDomain) {
            var e, _n;return { send: function send(i, o) {
                    e = tt("<script>").prop({ async: !0, charset: t.scriptCharset, src: t.url }).on("load error", _n = function n(t) {
                        e.remove(), _n = null, t && o("error" === t.type ? 404 : 200, t.type);
                    }), J.head.appendChild(e[0]);
                }, abort: function abort() {
                    _n && _n();
                } };
        }
    });var De = [],
        Oe = /(=)\?(?=&|$)|\?\?/;tt.ajaxSetup({ jsonp: "callback", jsonpCallback: function jsonpCallback() {
            var t = De.pop() || tt.expando + "_" + ae++;return this[t] = !0, t;
        } }), tt.ajaxPrefilter("json jsonp", function (e, n, i) {
        var o,
            s,
            r,
            a = !1 !== e.jsonp && (Oe.test(e.url) ? "url" : "string" == typeof e.data && !(e.contentType || "").indexOf("application/x-www-form-urlencoded") && Oe.test(e.data) && "data");return a || "jsonp" === e.dataTypes[0] ? (o = e.jsonpCallback = tt.isFunction(e.jsonpCallback) ? e.jsonpCallback() : e.jsonpCallback, a ? e[a] = e[a].replace(Oe, "$1" + o) : !1 !== e.jsonp && (e.url += (le.test(e.url) ? "&" : "?") + e.jsonp + "=" + o), e.converters["script json"] = function () {
            return r || tt.error(o + " was not called"), r[0];
        }, e.dataTypes[0] = "json", s = t[o], t[o] = function () {
            r = arguments;
        }, i.always(function () {
            t[o] = s, e[o] && (e.jsonpCallback = n.jsonpCallback, De.push(o)), r && tt.isFunction(s) && s(r[0]), r = s = void 0;
        }), "script") : void 0;
    }), tt.parseHTML = function (t, e, n) {
        if (!t || "string" != typeof t) return null;"boolean" == typeof e && (n = e, e = !1), e = e || J;var i = rt.exec(t),
            o = !n && [];return i ? [e.createElement(i[1])] : (i = tt.buildFragment([t], e, o), o && o.length && tt(o).remove(), tt.merge([], i.childNodes));
    };var $e = tt.fn.load;tt.fn.load = function (t, e, n) {
        if ("string" != typeof t && $e) return $e.apply(this, arguments);var i,
            o,
            s,
            r = this,
            a = t.indexOf(" ");return a >= 0 && (i = t.slice(a), t = t.slice(0, a)), tt.isFunction(e) ? (n = e, e = void 0) : e && "object" == (void 0 === e ? "undefined" : _typeof(e)) && (o = "POST"), r.length > 0 && tt.ajax({ url: t, type: o, dataType: "html", data: e }).done(function (t) {
            s = arguments, r.html(i ? tt("<div>").append(tt.parseHTML(t)).find(i) : t);
        }).complete(n && function (t, e) {
            r.each(n, s || [t.responseText, e, t]);
        }), this;
    }, tt.expr.filters.animated = function (t) {
        return tt.grep(tt.timers, function (e) {
            return t === e.elem;
        }).length;
    };var Ie = t.document.documentElement;tt.offset = { setOffset: function setOffset(t, e, n) {
            var i,
                o,
                s,
                r,
                a,
                l,
                c,
                u = tt.css(t, "position"),
                h = tt(t),
                p = {};"static" === u && (t.style.position = "relative"), a = h.offset(), s = tt.css(t, "top"), l = tt.css(t, "left"), c = ("absolute" === u || "fixed" === u) && (s + l).indexOf("auto") > -1, c ? (i = h.position(), r = i.top, o = i.left) : (r = parseFloat(s) || 0, o = parseFloat(l) || 0), tt.isFunction(e) && (e = e.call(t, n, a)), null != e.top && (p.top = e.top - a.top + r), null != e.left && (p.left = e.left - a.left + o), "using" in e ? e.using.call(t, p) : h.css(p);
        } }, tt.fn.extend({ offset: function offset(t) {
            if (arguments.length) return void 0 === t ? this : this.each(function (e) {
                tt.offset.setOffset(this, t, e);
            });var e,
                n,
                i = this[0],
                o = { top: 0, left: 0 },
                s = i && i.ownerDocument;return s ? (e = s.documentElement, tt.contains(e, i) ? (_typeof(i.getBoundingClientRect) !== Tt && (o = i.getBoundingClientRect()), n = q(s), { top: o.top + n.pageYOffset - e.clientTop, left: o.left + n.pageXOffset - e.clientLeft }) : o) : void 0;
        }, position: function position() {
            if (this[0]) {
                var t,
                    e,
                    n = this[0],
                    i = { top: 0, left: 0 };return "fixed" === tt.css(n, "position") ? e = n.getBoundingClientRect() : (t = this.offsetParent(), e = this.offset(), tt.nodeName(t[0], "html") || (i = t.offset()), i.top += tt.css(t[0], "borderTopWidth", !0), i.left += tt.css(t[0], "borderLeftWidth", !0)), { top: e.top - i.top - tt.css(n, "marginTop", !0), left: e.left - i.left - tt.css(n, "marginLeft", !0) };
            }
        }, offsetParent: function offsetParent() {
            return this.map(function () {
                for (var t = this.offsetParent || Ie; t && !tt.nodeName(t, "html") && "static" === tt.css(t, "position");) {
                    t = t.offsetParent;
                }return t || Ie;
            });
        } }), tt.each({ scrollLeft: "pageXOffset", scrollTop: "pageYOffset" }, function (e, n) {
        var i = "pageYOffset" === n;tt.fn[e] = function (o) {
            return gt(this, function (e, o, s) {
                var r = q(e);return void 0 === s ? r ? r[n] : e[o] : void (r ? r.scrollTo(i ? t.pageXOffset : s, i ? s : t.pageYOffset) : e[o] = s);
            }, e, o, arguments.length, null);
        };
    }), tt.each(["top", "left"], function (t, e) {
        tt.cssHooks[e] = x(Q.pixelPosition, function (t, n) {
            return n ? (n = _(t, e), qt.test(n) ? tt(t).position()[e] + "px" : n) : void 0;
        });
    }), tt.each({ Height: "height", Width: "width" }, function (t, e) {
        tt.each({ padding: "inner" + t, content: e, "": "outer" + t }, function (n, i) {
            tt.fn[i] = function (i, o) {
                var s = arguments.length && (n || "boolean" != typeof i),
                    r = n || (!0 === i || !0 === o ? "margin" : "border");return gt(this, function (e, n, i) {
                    var o;return tt.isWindow(e) ? e.document.documentElement["client" + t] : 9 === e.nodeType ? (o = e.documentElement, Math.max(e.body["scroll" + t], o["scroll" + t], e.body["offset" + t], o["offset" + t], o["client" + t])) : void 0 === i ? tt.css(e, n, r) : tt.style(e, n, i, r);
                }, e, s ? i : void 0, s, null);
            };
        });
    }), tt.fn.size = function () {
        return this.length;
    }, tt.fn.andSelf = tt.fn.addBack, "function" == typeof define && define.amd && define("jquery", [], function () {
        return tt;
    });var Ne = t.jQuery,
        Le = t.$;return tt.noConflict = function (e) {
        return t.$ === tt && (t.$ = Le), e && t.jQuery === tt && (t.jQuery = Ne), tt;
    }, (void 0 === e ? "undefined" : _typeof(e)) === Tt && (t.jQuery = t.$ = tt), tt;
}), function (t, e) {
    function n(e, n) {
        var o,
            s,
            r,
            a = e.nodeName.toLowerCase();return "area" === a ? (o = e.parentNode, s = o.name, !(!e.href || !s || "map" !== o.nodeName.toLowerCase()) && !!(r = t("img[usemap=#" + s + "]")[0]) && i(r)) : (/input|select|textarea|button|object/.test(a) ? !e.disabled : "a" === a ? e.href || n : n) && i(e);
    }function i(e) {
        return t.expr.filters.visible(e) && !t(e).parents().addBack().filter(function () {
            return "hidden" === t.css(this, "visibility");
        }).length;
    }var o = 0,
        s = /^ui-id-\d+$/;t.ui = t.ui || {}, t.extend(t.ui, { version: "1.10.4", keyCode: { BACKSPACE: 8, COMMA: 188, DELETE: 46, DOWN: 40, END: 35, ENTER: 13, ESCAPE: 27, HOME: 36, LEFT: 37, NUMPAD_ADD: 107, NUMPAD_DECIMAL: 110, NUMPAD_DIVIDE: 111, NUMPAD_ENTER: 108, NUMPAD_MULTIPLY: 106, NUMPAD_SUBTRACT: 109, PAGE_DOWN: 34, PAGE_UP: 33, PERIOD: 190, RIGHT: 39, SPACE: 32, TAB: 9, UP: 38 } }), t.fn.extend({ focus: function (e) {
            return function (n, i) {
                return "number" == typeof n ? this.each(function () {
                    var e = this;setTimeout(function () {
                        t(e).focus(), i && i.call(e);
                    }, n);
                }) : e.apply(this, arguments);
            };
        }(t.fn.focus), scrollParent: function scrollParent() {
            var e;return e = t.ui.ie && /(static|relative)/.test(this.css("position")) || /absolute/.test(this.css("position")) ? this.parents().filter(function () {
                return (/(relative|absolute|fixed)/.test(t.css(this, "position")) && /(auto|scroll)/.test(t.css(this, "overflow") + t.css(this, "overflow-y") + t.css(this, "overflow-x"))
                );
            }).eq(0) : this.parents().filter(function () {
                return (/(auto|scroll)/.test(t.css(this, "overflow") + t.css(this, "overflow-y") + t.css(this, "overflow-x"))
                );
            }).eq(0), /fixed/.test(this.css("position")) || !e.length ? t(document) : e;
        }, zIndex: function zIndex(n) {
            if (n !== e) return this.css("zIndex", n);if (this.length) for (var i, o, s = t(this[0]); s.length && s[0] !== document;) {
                if (("absolute" === (i = s.css("position")) || "relative" === i || "fixed" === i) && (o = parseInt(s.css("zIndex"), 10), !isNaN(o) && 0 !== o)) return o;s = s.parent();
            }return 0;
        }, uniqueId: function uniqueId() {
            return this.each(function () {
                this.id || (this.id = "ui-id-" + ++o);
            });
        }, removeUniqueId: function removeUniqueId() {
            return this.each(function () {
                s.test(this.id) && t(this).removeAttr("id");
            });
        } }), t.extend(t.expr[":"], { data: t.expr.createPseudo ? t.expr.createPseudo(function (e) {
            return function (n) {
                return !!t.data(n, e);
            };
        }) : function (e, n, i) {
            return !!t.data(e, i[3]);
        }, focusable: function focusable(e) {
            return n(e, !isNaN(t.attr(e, "tabindex")));
        }, tabbable: function tabbable(e) {
            var i = t.attr(e, "tabindex"),
                o = isNaN(i);return (o || i >= 0) && n(e, !o);
        } }), t("<a>").outerWidth(1).jquery || t.each(["Width", "Height"], function (n, i) {
        function o(e, n, i, o) {
            return t.each(s, function () {
                n -= parseFloat(t.css(e, "padding" + this)) || 0, i && (n -= parseFloat(t.css(e, "border" + this + "Width")) || 0), o && (n -= parseFloat(t.css(e, "margin" + this)) || 0);
            }), n;
        }var s = "Width" === i ? ["Left", "Right"] : ["Top", "Bottom"],
            r = i.toLowerCase(),
            a = { innerWidth: t.fn.innerWidth, innerHeight: t.fn.innerHeight, outerWidth: t.fn.outerWidth, outerHeight: t.fn.outerHeight };t.fn["inner" + i] = function (n) {
            return n === e ? a["inner" + i].call(this) : this.each(function () {
                t(this).css(r, o(this, n) + "px");
            });
        }, t.fn["outer" + i] = function (e, n) {
            return "number" != typeof e ? a["outer" + i].call(this, e) : this.each(function () {
                t(this).css(r, o(this, e, !0, n) + "px");
            });
        };
    }), t.fn.addBack || (t.fn.addBack = function (t) {
        return this.add(null == t ? this.prevObject : this.prevObject.filter(t));
    }), t("<a>").data("a-b", "a").removeData("a-b").data("a-b") && (t.fn.removeData = function (e) {
        return function (n) {
            return arguments.length ? e.call(this, t.camelCase(n)) : e.call(this);
        };
    }(t.fn.removeData)), t.ui.ie = !!/msie [\w.]+/.exec(navigator.userAgent.toLowerCase()), t.support.selectstart = "onselectstart" in document.createElement("div"), t.fn.extend({ disableSelection: function disableSelection() {
            return this.bind((t.support.selectstart ? "selectstart" : "mousedown") + ".ui-disableSelection", function (t) {
                t.preventDefault();
            });
        }, enableSelection: function enableSelection() {
            return this.unbind(".ui-disableSelection");
        } }), t.extend(t.ui, { plugin: { add: function add(e, n, i) {
                var o,
                    s = t.ui[e].prototype;for (o in i) {
                    s.plugins[o] = s.plugins[o] || [], s.plugins[o].push([n, i[o]]);
                }
            }, call: function call(t, e, n) {
                var i,
                    o = t.plugins[e];if (o && t.element[0].parentNode && 11 !== t.element[0].parentNode.nodeType) for (i = 0; o.length > i; i++) {
                    t.options[o[i][0]] && o[i][1].apply(t.element, n);
                }
            } }, hasScroll: function hasScroll(e, n) {
            if ("hidden" === t(e).css("overflow")) return !1;var i = n && "left" === n ? "scrollLeft" : "scrollTop",
                o = !1;return e[i] > 0 || (e[i] = 1, o = e[i] > 0, e[i] = 0, o);
        } });
}(jQuery), function (t, e) {
    var n = 0,
        i = Array.prototype.slice,
        o = t.cleanData;t.cleanData = function (e) {
        for (var n, i = 0; null != (n = e[i]); i++) {
            try {
                t(n).triggerHandler("remove");
            } catch (t) {}
        }o(e);
    }, t.widget = function (n, i, o) {
        var s,
            r,
            a,
            l,
            c = {},
            u = n.split(".")[0];n = n.split(".")[1], s = u + "-" + n, o || (o = i, i = t.Widget), t.expr[":"][s.toLowerCase()] = function (e) {
            return !!t.data(e, s);
        }, t[u] = t[u] || {}, r = t[u][n], a = t[u][n] = function (t, n) {
            return this._createWidget ? (arguments.length && this._createWidget(t, n), e) : new a(t, n);
        }, t.extend(a, r, { version: o.version, _proto: t.extend({}, o), _childConstructors: [] }), l = new i(), l.options = t.widget.extend({}, l.options), t.each(o, function (n, o) {
            return t.isFunction(o) ? (c[n] = function () {
                var t = function t() {
                    return i.prototype[n].apply(this, arguments);
                },
                    e = function e(t) {
                    return i.prototype[n].apply(this, t);
                };return function () {
                    var n,
                        i = this._super,
                        s = this._superApply;return this._super = t, this._superApply = e, n = o.apply(this, arguments), this._super = i, this._superApply = s, n;
                };
            }(), e) : (c[n] = o, e);
        }), a.prototype = t.widget.extend(l, { widgetEventPrefix: r ? l.widgetEventPrefix || n : n }, c, { constructor: a, namespace: u, widgetName: n, widgetFullName: s }), r ? (t.each(r._childConstructors, function (e, n) {
            var i = n.prototype;t.widget(i.namespace + "." + i.widgetName, a, n._proto);
        }), delete r._childConstructors) : i._childConstructors.push(a), t.widget.bridge(n, a);
    }, t.widget.extend = function (n) {
        for (var o, s, r = i.call(arguments, 1), a = 0, l = r.length; l > a; a++) {
            for (o in r[a]) {
                s = r[a][o], r[a].hasOwnProperty(o) && s !== e && (n[o] = t.isPlainObject(s) ? t.isPlainObject(n[o]) ? t.widget.extend({}, n[o], s) : t.widget.extend({}, s) : s);
            }
        }return n;
    }, t.widget.bridge = function (n, o) {
        var s = o.prototype.widgetFullName || n;t.fn[n] = function (r) {
            var a = "string" == typeof r,
                l = i.call(arguments, 1),
                c = this;return r = !a && l.length ? t.widget.extend.apply(null, [r].concat(l)) : r, a ? this.each(function () {
                var i,
                    o = t.data(this, s);return o ? t.isFunction(o[r]) && "_" !== r.charAt(0) ? (i = o[r].apply(o, l), i !== o && i !== e ? (c = i && i.jquery ? c.pushStack(i.get()) : i, !1) : e) : t.error("no such method '" + r + "' for " + n + " widget instance") : t.error("cannot call methods on " + n + " prior to initialization; attempted to call method '" + r + "'");
            }) : this.each(function () {
                var e = t.data(this, s);e ? e.option(r || {})._init() : t.data(this, s, new o(r, this));
            }), c;
        };
    }, t.Widget = function () {}, t.Widget._childConstructors = [], t.Widget.prototype = { widgetName: "widget", widgetEventPrefix: "", defaultElement: "<div>", options: { disabled: !1, create: null }, _createWidget: function _createWidget(e, i) {
            i = t(i || this.defaultElement || this)[0], this.element = t(i), this.uuid = n++, this.eventNamespace = "." + this.widgetName + this.uuid, this.options = t.widget.extend({}, this.options, this._getCreateOptions(), e), this.bindings = t(), this.hoverable = t(), this.focusable = t(), i !== this && (t.data(i, this.widgetFullName, this), this._on(!0, this.element, { remove: function remove(t) {
                    t.target === i && this.destroy();
                } }), this.document = t(i.style ? i.ownerDocument : i.document || i), this.window = t(this.document[0].defaultView || this.document[0].parentWindow)), this._create(), this._trigger("create", null, this._getCreateEventData()), this._init();
        }, _getCreateOptions: t.noop, _getCreateEventData: t.noop, _create: t.noop, _init: t.noop, destroy: function destroy() {
            this._destroy(), this.element.unbind(this.eventNamespace).removeData(this.widgetName).removeData(this.widgetFullName).removeData(t.camelCase(this.widgetFullName)), this.widget().unbind(this.eventNamespace).removeAttr("aria-disabled").removeClass(this.widgetFullName + "-disabled ui-state-disabled"), this.bindings.unbind(this.eventNamespace), this.hoverable.removeClass("ui-state-hover"), this.focusable.removeClass("ui-state-focus");
        }, _destroy: t.noop, widget: function widget() {
            return this.element;
        }, option: function option(n, i) {
            var o,
                s,
                r,
                a = n;if (0 === arguments.length) return t.widget.extend({}, this.options);if ("string" == typeof n) if (a = {}, o = n.split("."), n = o.shift(), o.length) {
                for (s = a[n] = t.widget.extend({}, this.options[n]), r = 0; o.length - 1 > r; r++) {
                    s[o[r]] = s[o[r]] || {}, s = s[o[r]];
                }if (n = o.pop(), 1 === arguments.length) return s[n] === e ? null : s[n];s[n] = i;
            } else {
                if (1 === arguments.length) return this.options[n] === e ? null : this.options[n];a[n] = i;
            }return this._setOptions(a), this;
        }, _setOptions: function _setOptions(t) {
            var e;for (e in t) {
                this._setOption(e, t[e]);
            }return this;
        }, _setOption: function _setOption(t, e) {
            return this.options[t] = e, "disabled" === t && (this.widget().toggleClass(this.widgetFullName + "-disabled ui-state-disabled", !!e).attr("aria-disabled", e), this.hoverable.removeClass("ui-state-hover"), this.focusable.removeClass("ui-state-focus")), this;
        }, enable: function enable() {
            return this._setOption("disabled", !1);
        }, disable: function disable() {
            return this._setOption("disabled", !0);
        }, _on: function _on(n, i, o) {
            var s,
                r = this;"boolean" != typeof n && (o = i, i = n, n = !1), o ? (i = s = t(i), this.bindings = this.bindings.add(i)) : (o = i, i = this.element, s = this.widget()), t.each(o, function (o, a) {
                function l() {
                    return n || !0 !== r.options.disabled && !t(this).hasClass("ui-state-disabled") ? ("string" == typeof a ? r[a] : a).apply(r, arguments) : e;
                }"string" != typeof a && (l.guid = a.guid = a.guid || l.guid || t.guid++);var c = o.match(/^(\w+)\s*(.*)$/),
                    u = c[1] + r.eventNamespace,
                    h = c[2];h ? s.delegate(h, u, l) : i.bind(u, l);
            });
        }, _off: function _off(t, e) {
            e = (e || "").split(" ").join(this.eventNamespace + " ") + this.eventNamespace, t.unbind(e).undelegate(e);
        }, _delay: function _delay(t, e) {
            function n() {
                return ("string" == typeof t ? i[t] : t).apply(i, arguments);
            }var i = this;return setTimeout(n, e || 0);
        }, _hoverable: function _hoverable(e) {
            this.hoverable = this.hoverable.add(e), this._on(e, { mouseenter: function mouseenter(e) {
                    t(e.currentTarget).addClass("ui-state-hover");
                }, mouseleave: function mouseleave(e) {
                    t(e.currentTarget).removeClass("ui-state-hover");
                } });
        }, _focusable: function _focusable(e) {
            this.focusable = this.focusable.add(e), this._on(e, { focusin: function focusin(e) {
                    t(e.currentTarget).addClass("ui-state-focus");
                }, focusout: function focusout(e) {
                    t(e.currentTarget).removeClass("ui-state-focus");
                } });
        }, _trigger: function _trigger(e, n, i) {
            var o,
                s,
                r = this.options[e];if (i = i || {}, n = t.Event(n), n.type = (e === this.widgetEventPrefix ? e : this.widgetEventPrefix + e).toLowerCase(), n.target = this.element[0], s = n.originalEvent) for (o in s) {
                o in n || (n[o] = s[o]);
            }return this.element.trigger(n, i), !(t.isFunction(r) && !1 === r.apply(this.element[0], [n].concat(i)) || n.isDefaultPrevented());
        } }, t.each({ show: "fadeIn", hide: "fadeOut" }, function (e, n) {
        t.Widget.prototype["_" + e] = function (i, o, s) {
            "string" == typeof o && (o = { effect: o });var r,
                a = o ? !0 === o || "number" == typeof o ? n : o.effect || n : e;o = o || {}, "number" == typeof o && (o = { duration: o }), r = !t.isEmptyObject(o), o.complete = s, o.delay && i.delay(o.delay), r && t.effects && t.effects.effect[a] ? i[e](o) : a !== e && i[a] ? i[a](o.duration, o.easing, s) : i.queue(function (n) {
                t(this)[e](), s && s.call(i[0]), n();
            });
        };
    });
}(jQuery), function (t) {
    var e = !1;t(document).mouseup(function () {
        e = !1;
    }), t.widget("ui.mouse", { version: "1.10.4", options: { cancel: "input,textarea,button,select,option", distance: 1, delay: 0 }, _mouseInit: function _mouseInit() {
            var e = this;this.element.bind("mousedown." + this.widgetName, function (t) {
                return e._mouseDown(t);
            }).bind("click." + this.widgetName, function (n) {
                return !0 === t.data(n.target, e.widgetName + ".preventClickEvent") ? (t.removeData(n.target, e.widgetName + ".preventClickEvent"), n.stopImmediatePropagation(), !1) : void 0;
            }), this.started = !1;
        }, _mouseDestroy: function _mouseDestroy() {
            this.element.unbind("." + this.widgetName), this._mouseMoveDelegate && t(document).unbind("mousemove." + this.widgetName, this._mouseMoveDelegate).unbind("mouseup." + this.widgetName, this._mouseUpDelegate);
        }, _mouseDown: function _mouseDown(n) {
            if (!e) {
                this._mouseStarted && this._mouseUp(n), this._mouseDownEvent = n;var i = this,
                    o = 1 === n.which,
                    s = !("string" != typeof this.options.cancel || !n.target.nodeName) && t(n.target).closest(this.options.cancel).length;return !(o && !s && this._mouseCapture(n)) || (this.mouseDelayMet = !this.options.delay, this.mouseDelayMet || (this._mouseDelayTimer = setTimeout(function () {
                    i.mouseDelayMet = !0;
                }, this.options.delay)), this._mouseDistanceMet(n) && this._mouseDelayMet(n) && (this._mouseStarted = !1 !== this._mouseStart(n), !this._mouseStarted) ? (n.preventDefault(), !0) : (!0 === t.data(n.target, this.widgetName + ".preventClickEvent") && t.removeData(n.target, this.widgetName + ".preventClickEvent"), this._mouseMoveDelegate = function (t) {
                    return i._mouseMove(t);
                }, this._mouseUpDelegate = function (t) {
                    return i._mouseUp(t);
                }, t(document).bind("mousemove." + this.widgetName, this._mouseMoveDelegate).bind("mouseup." + this.widgetName, this._mouseUpDelegate), n.preventDefault(), e = !0, !0));
            }
        }, _mouseMove: function _mouseMove(e) {
            return t.ui.ie && (!document.documentMode || 9 > document.documentMode) && !e.button ? this._mouseUp(e) : this._mouseStarted ? (this._mouseDrag(e), e.preventDefault()) : (this._mouseDistanceMet(e) && this._mouseDelayMet(e) && (this._mouseStarted = !1 !== this._mouseStart(this._mouseDownEvent, e), this._mouseStarted ? this._mouseDrag(e) : this._mouseUp(e)), !this._mouseStarted);
        }, _mouseUp: function _mouseUp(e) {
            return t(document).unbind("mousemove." + this.widgetName, this._mouseMoveDelegate).unbind("mouseup." + this.widgetName, this._mouseUpDelegate), this._mouseStarted && (this._mouseStarted = !1, e.target === this._mouseDownEvent.target && t.data(e.target, this.widgetName + ".preventClickEvent", !0), this._mouseStop(e)), !1;
        }, _mouseDistanceMet: function _mouseDistanceMet(t) {
            return Math.max(Math.abs(this._mouseDownEvent.pageX - t.pageX), Math.abs(this._mouseDownEvent.pageY - t.pageY)) >= this.options.distance;
        }, _mouseDelayMet: function _mouseDelayMet() {
            return this.mouseDelayMet;
        }, _mouseStart: function _mouseStart() {}, _mouseDrag: function _mouseDrag() {}, _mouseStop: function _mouseStop() {}, _mouseCapture: function _mouseCapture() {
            return !0;
        } });
}(jQuery), function (t, e) {
    function n(t, e, n) {
        return [parseFloat(t[0]) * (d.test(t[0]) ? e / 100 : 1), parseFloat(t[1]) * (d.test(t[1]) ? n / 100 : 1)];
    }function i(e, n) {
        return parseInt(t.css(e, n), 10) || 0;
    }function o(e) {
        var n = e[0];return 9 === n.nodeType ? { width: e.width(), height: e.height(), offset: { top: 0, left: 0 } } : t.isWindow(n) ? { width: e.width(), height: e.height(), offset: { top: e.scrollTop(), left: e.scrollLeft() } } : n.preventDefault ? { width: 0, height: 0, offset: { top: n.pageY, left: n.pageX } } : { width: e.outerWidth(), height: e.outerHeight(), offset: e.offset() };
    }t.ui = t.ui || {};var s,
        r = Math.max,
        a = Math.abs,
        l = Math.round,
        c = /left|center|right/,
        u = /top|center|bottom/,
        h = /[\+\-]\d+(\.[\d]+)?%?/,
        p = /^\w+/,
        d = /%$/,
        f = t.fn.position;t.position = { scrollbarWidth: function scrollbarWidth() {
            if (void 0 !== s) return s;var e,
                n,
                i = t("<div style='display:block;position:absolute;width:50px;height:50px;overflow:hidden;'><div style='height:100px;width:auto;'></div></div>"),
                o = i.children()[0];return t("body").append(i), e = o.offsetWidth, i.css("overflow", "scroll"), n = o.offsetWidth, e === n && (n = i[0].clientWidth), i.remove(), s = e - n;
        }, getScrollInfo: function getScrollInfo(e) {
            var n = e.isWindow || e.isDocument ? "" : e.element.css("overflow-x"),
                i = e.isWindow || e.isDocument ? "" : e.element.css("overflow-y"),
                o = "scroll" === n || "auto" === n && e.width < e.element[0].scrollWidth;return { width: "scroll" === i || "auto" === i && e.height < e.element[0].scrollHeight ? t.position.scrollbarWidth() : 0, height: o ? t.position.scrollbarWidth() : 0 };
        }, getWithinInfo: function getWithinInfo(e) {
            var n = t(e || window),
                i = t.isWindow(n[0]);return { element: n, isWindow: i, isDocument: !!n[0] && 9 === n[0].nodeType, offset: n.offset() || { left: 0, top: 0 }, scrollLeft: n.scrollLeft(), scrollTop: n.scrollTop(), width: i ? n.width() : n.outerWidth(), height: i ? n.height() : n.outerHeight() };
        } }, t.fn.position = function (e) {
        if (!e || !e.of) return f.apply(this, arguments);e = t.extend({}, e);var s,
            d,
            g,
            m,
            v,
            y,
            b = t(e.of),
            w = t.position.getWithinInfo(e.within),
            _ = t.position.getScrollInfo(w),
            x = (e.collision || "flip").split(" "),
            C = {};return y = o(b), b[0].preventDefault && (e.at = "left top"), d = y.width, g = y.height, m = y.offset, v = t.extend({}, m), t.each(["my", "at"], function () {
            var t,
                n,
                i = (e[this] || "").split(" ");1 === i.length && (i = c.test(i[0]) ? i.concat(["center"]) : u.test(i[0]) ? ["center"].concat(i) : ["center", "center"]), i[0] = c.test(i[0]) ? i[0] : "center", i[1] = u.test(i[1]) ? i[1] : "center", t = h.exec(i[0]), n = h.exec(i[1]), C[this] = [t ? t[0] : 0, n ? n[0] : 0], e[this] = [p.exec(i[0])[0], p.exec(i[1])[0]];
        }), 1 === x.length && (x[1] = x[0]), "right" === e.at[0] ? v.left += d : "center" === e.at[0] && (v.left += d / 2), "bottom" === e.at[1] ? v.top += g : "center" === e.at[1] && (v.top += g / 2), s = n(C.at, d, g), v.left += s[0], v.top += s[1], this.each(function () {
            var o,
                c,
                u = t(this),
                h = u.outerWidth(),
                p = u.outerHeight(),
                f = i(this, "marginLeft"),
                y = i(this, "marginTop"),
                T = h + f + i(this, "marginRight") + _.width,
                S = p + y + i(this, "marginBottom") + _.height,
                A = t.extend({}, v),
                E = n(C.my, u.outerWidth(), u.outerHeight());"right" === e.my[0] ? A.left -= h : "center" === e.my[0] && (A.left -= h / 2), "bottom" === e.my[1] ? A.top -= p : "center" === e.my[1] && (A.top -= p / 2), A.left += E[0], A.top += E[1], t.support.offsetFractions || (A.left = l(A.left), A.top = l(A.top)), o = { marginLeft: f, marginTop: y }, t.each(["left", "top"], function (n, i) {
                t.ui.position[x[n]] && t.ui.position[x[n]][i](A, { targetWidth: d, targetHeight: g, elemWidth: h, elemHeight: p, collisionPosition: o, collisionWidth: T, collisionHeight: S, offset: [s[0] + E[0], s[1] + E[1]], my: e.my, at: e.at, within: w, elem: u });
            }), e.using && (c = function c(t) {
                var n = m.left - A.left,
                    i = n + d - h,
                    o = m.top - A.top,
                    s = o + g - p,
                    l = { target: { element: b, left: m.left, top: m.top, width: d, height: g }, element: { element: u, left: A.left, top: A.top, width: h, height: p }, horizontal: 0 > i ? "left" : n > 0 ? "right" : "center", vertical: 0 > s ? "top" : o > 0 ? "bottom" : "middle" };h > d && d > a(n + i) && (l.horizontal = "center"), p > g && g > a(o + s) && (l.vertical = "middle"), l.important = r(a(n), a(i)) > r(a(o), a(s)) ? "horizontal" : "vertical", e.using.call(this, t, l);
            }), u.offset(t.extend(A, { using: c }));
        });
    }, t.ui.position = { fit: { left: function left(t, e) {
                var n,
                    i = e.within,
                    o = i.isWindow ? i.scrollLeft : i.offset.left,
                    s = i.width,
                    a = t.left - e.collisionPosition.marginLeft,
                    l = o - a,
                    c = a + e.collisionWidth - s - o;e.collisionWidth > s ? l > 0 && 0 >= c ? (n = t.left + l + e.collisionWidth - s - o, t.left += l - n) : t.left = c > 0 && 0 >= l ? o : l > c ? o + s - e.collisionWidth : o : l > 0 ? t.left += l : c > 0 ? t.left -= c : t.left = r(t.left - a, t.left);
            }, top: function top(t, e) {
                var n,
                    i = e.within,
                    o = i.isWindow ? i.scrollTop : i.offset.top,
                    s = e.within.height,
                    a = t.top - e.collisionPosition.marginTop,
                    l = o - a,
                    c = a + e.collisionHeight - s - o;e.collisionHeight > s ? l > 0 && 0 >= c ? (n = t.top + l + e.collisionHeight - s - o, t.top += l - n) : t.top = c > 0 && 0 >= l ? o : l > c ? o + s - e.collisionHeight : o : l > 0 ? t.top += l : c > 0 ? t.top -= c : t.top = r(t.top - a, t.top);
            } }, flip: { left: function left(t, e) {
                var n,
                    i,
                    o = e.within,
                    s = o.offset.left + o.scrollLeft,
                    r = o.width,
                    l = o.isWindow ? o.scrollLeft : o.offset.left,
                    c = t.left - e.collisionPosition.marginLeft,
                    u = c - l,
                    h = c + e.collisionWidth - r - l,
                    p = "left" === e.my[0] ? -e.elemWidth : "right" === e.my[0] ? e.elemWidth : 0,
                    d = "left" === e.at[0] ? e.targetWidth : "right" === e.at[0] ? -e.targetWidth : 0,
                    f = -2 * e.offset[0];0 > u ? (0 > (n = t.left + p + d + f + e.collisionWidth - r - s) || a(u) > n) && (t.left += p + d + f) : h > 0 && ((i = t.left - e.collisionPosition.marginLeft + p + d + f - l) > 0 || h > a(i)) && (t.left += p + d + f);
            }, top: function top(t, e) {
                var n,
                    i,
                    o = e.within,
                    s = o.offset.top + o.scrollTop,
                    r = o.height,
                    l = o.isWindow ? o.scrollTop : o.offset.top,
                    c = t.top - e.collisionPosition.marginTop,
                    u = c - l,
                    h = c + e.collisionHeight - r - l,
                    p = "top" === e.my[1],
                    d = p ? -e.elemHeight : "bottom" === e.my[1] ? e.elemHeight : 0,
                    f = "top" === e.at[1] ? e.targetHeight : "bottom" === e.at[1] ? -e.targetHeight : 0,
                    g = -2 * e.offset[1];0 > u ? (i = t.top + d + f + g + e.collisionHeight - r - s, t.top + d + f + g > u && (0 > i || a(u) > i) && (t.top += d + f + g)) : h > 0 && (n = t.top - e.collisionPosition.marginTop + d + f + g - l, t.top + d + f + g > h && (n > 0 || h > a(n)) && (t.top += d + f + g));
            } }, flipfit: { left: function left() {
                t.ui.position.flip.left.apply(this, arguments), t.ui.position.fit.left.apply(this, arguments);
            }, top: function top() {
                t.ui.position.flip.top.apply(this, arguments), t.ui.position.fit.top.apply(this, arguments);
            } } }, function () {
        var e,
            n,
            i,
            o,
            s,
            r = document.getElementsByTagName("body")[0],
            a = document.createElement("div");e = document.createElement(r ? "div" : "body"), i = { visibility: "hidden", width: 0, height: 0, border: 0, margin: 0, background: "none" }, r && t.extend(i, { position: "absolute", left: "-1000px", top: "-1000px" });for (s in i) {
            e.style[s] = i[s];
        }e.appendChild(a), n = r || document.documentElement, n.insertBefore(e, n.firstChild), a.style.cssText = "position: absolute; left: 10.7432222px;", o = t(a).offset().left, t.support.offsetFractions = o > 10 && 11 > o, e.innerHTML = "", n.removeChild(e);
    }();
}(jQuery), function (t) {
    t.widget("ui.draggable", t.ui.mouse, { version: "1.10.4", widgetEventPrefix: "drag", options: { addClasses: !0, appendTo: "parent", axis: !1, connectToSortable: !1, containment: !1, cursor: "auto", cursorAt: !1, grid: !1, handle: !1, helper: "original", iframeFix: !1, opacity: !1, refreshPositions: !1, revert: !1, revertDuration: 500, scope: "default", scroll: !0, scrollSensitivity: 20, scrollSpeed: 20, snap: !1, snapMode: "both", snapTolerance: 20, stack: !1, zIndex: !1, drag: null, start: null, stop: null }, _create: function _create() {
            "original" !== this.options.helper || /^(?:r|a|f)/.test(this.element.css("position")) || (this.element[0].style.position = "relative"), this.options.addClasses && this.element.addClass("ui-draggable"), this.options.disabled && this.element.addClass("ui-draggable-disabled"), this._mouseInit();
        }, _destroy: function _destroy() {
            this.element.removeClass("ui-draggable ui-draggable-dragging ui-draggable-disabled"), this._mouseDestroy();
        }, _mouseCapture: function _mouseCapture(e) {
            var n = this.options;return !(this.helper || n.disabled || t(e.target).closest(".ui-resizable-handle").length > 0) && (this.handle = this._getHandle(e), !!this.handle && (t(!0 === n.iframeFix ? "iframe" : n.iframeFix).each(function () {
                t("<div class='ui-draggable-iframeFix' style='background: #fff;'></div>").css({ width: this.offsetWidth + "px", height: this.offsetHeight + "px", position: "absolute", opacity: "0.001", zIndex: 1e3 }).css(t(this).offset()).appendTo("body");
            }), !0));
        }, _mouseStart: function _mouseStart(e) {
            var n = this.options;return this.helper = this._createHelper(e), this.helper.addClass("ui-draggable-dragging"), this._cacheHelperProportions(), t.ui.ddmanager && (t.ui.ddmanager.current = this), this._cacheMargins(), this.cssPosition = this.helper.css("position"), this.scrollParent = this.helper.scrollParent(), this.offsetParent = this.helper.offsetParent(), this.offsetParentCssPosition = this.offsetParent.css("position"), this.offset = this.positionAbs = this.element.offset(), this.offset = { top: this.offset.top - this.margins.top, left: this.offset.left - this.margins.left }, this.offset.scroll = !1, t.extend(this.offset, { click: { left: e.pageX - this.offset.left, top: e.pageY - this.offset.top }, parent: this._getParentOffset(), relative: this._getRelativeOffset() }), this.originalPosition = this.position = this._generatePosition(e), this.originalPageX = e.pageX, this.originalPageY = e.pageY, n.cursorAt && this._adjustOffsetFromHelper(n.cursorAt), this._setContainment(), !1 === this._trigger("start", e) ? (this._clear(), !1) : (this._cacheHelperProportions(), t.ui.ddmanager && !n.dropBehaviour && t.ui.ddmanager.prepareOffsets(this, e), this._mouseDrag(e, !0), t.ui.ddmanager && t.ui.ddmanager.dragStart(this, e), !0);
        }, _mouseDrag: function _mouseDrag(e, n) {
            if ("fixed" === this.offsetParentCssPosition && (this.offset.parent = this._getParentOffset()), this.position = this._generatePosition(e), this.positionAbs = this._convertPositionTo("absolute"), !n) {
                var i = this._uiHash();if (!1 === this._trigger("drag", e, i)) return this._mouseUp({}), !1;this.position = i.position;
            }return this.options.axis && "y" === this.options.axis || (this.helper[0].style.left = this.position.left + "px"), this.options.axis && "x" === this.options.axis || (this.helper[0].style.top = this.position.top + "px"), t.ui.ddmanager && t.ui.ddmanager.drag(this, e), !1;
        }, _mouseStop: function _mouseStop(e) {
            var n = this,
                i = !1;return t.ui.ddmanager && !this.options.dropBehaviour && (i = t.ui.ddmanager.drop(this, e)), this.dropped && (i = this.dropped, this.dropped = !1), !("original" === this.options.helper && !t.contains(this.element[0].ownerDocument, this.element[0])) && ("invalid" === this.options.revert && !i || "valid" === this.options.revert && i || !0 === this.options.revert || t.isFunction(this.options.revert) && this.options.revert.call(this.element, i) ? t(this.helper).animate(this.originalPosition, parseInt(this.options.revertDuration, 10), function () {
                !1 !== n._trigger("stop", e) && n._clear();
            }) : !1 !== this._trigger("stop", e) && this._clear(), !1);
        }, _mouseUp: function _mouseUp(e) {
            return t("div.ui-draggable-iframeFix").each(function () {
                this.parentNode.removeChild(this);
            }), t.ui.ddmanager && t.ui.ddmanager.dragStop(this, e), t.ui.mouse.prototype._mouseUp.call(this, e);
        }, cancel: function cancel() {
            return this.helper.is(".ui-draggable-dragging") ? this._mouseUp({}) : this._clear(), this;
        }, _getHandle: function _getHandle(e) {
            return !this.options.handle || !!t(e.target).closest(this.element.find(this.options.handle)).length;
        }, _createHelper: function _createHelper(e) {
            var n = this.options,
                i = t.isFunction(n.helper) ? t(n.helper.apply(this.element[0], [e])) : "clone" === n.helper ? this.element.clone().removeAttr("id") : this.element;return i.parents("body").length || i.appendTo("parent" === n.appendTo ? this.element[0].parentNode : n.appendTo), i[0] === this.element[0] || /(fixed|absolute)/.test(i.css("position")) || i.css("position", "absolute"), i;
        }, _adjustOffsetFromHelper: function _adjustOffsetFromHelper(e) {
            "string" == typeof e && (e = e.split(" ")), t.isArray(e) && (e = { left: +e[0], top: +e[1] || 0 }), "left" in e && (this.offset.click.left = e.left + this.margins.left), "right" in e && (this.offset.click.left = this.helperProportions.width - e.right + this.margins.left), "top" in e && (this.offset.click.top = e.top + this.margins.top), "bottom" in e && (this.offset.click.top = this.helperProportions.height - e.bottom + this.margins.top);
        }, _getParentOffset: function _getParentOffset() {
            var e = this.offsetParent.offset();return "absolute" === this.cssPosition && this.scrollParent[0] !== document && t.contains(this.scrollParent[0], this.offsetParent[0]) && (e.left += this.scrollParent.scrollLeft(), e.top += this.scrollParent.scrollTop()), (this.offsetParent[0] === document.body || this.offsetParent[0].tagName && "html" === this.offsetParent[0].tagName.toLowerCase() && t.ui.ie) && (e = { top: 0, left: 0 }), { top: e.top + (parseInt(this.offsetParent.css("borderTopWidth"), 10) || 0), left: e.left + (parseInt(this.offsetParent.css("borderLeftWidth"), 10) || 0) };
        }, _getRelativeOffset: function _getRelativeOffset() {
            if ("relative" === this.cssPosition) {
                var t = this.element.position();return { top: t.top - (parseInt(this.helper.css("top"), 10) || 0) + this.scrollParent.scrollTop(), left: t.left - (parseInt(this.helper.css("left"), 10) || 0) + this.scrollParent.scrollLeft() };
            }return { top: 0, left: 0 };
        }, _cacheMargins: function _cacheMargins() {
            this.margins = { left: parseInt(this.element.css("marginLeft"), 10) || 0, top: parseInt(this.element.css("marginTop"), 10) || 0, right: parseInt(this.element.css("marginRight"), 10) || 0, bottom: parseInt(this.element.css("marginBottom"), 10) || 0 };
        }, _cacheHelperProportions: function _cacheHelperProportions() {
            this.helperProportions = { width: this.helper.outerWidth(), height: this.helper.outerHeight() };
        }, _setContainment: function _setContainment() {
            var e,
                n,
                i,
                o = this.options;return o.containment ? "window" === o.containment ? void (this.containment = [t(window).scrollLeft() - this.offset.relative.left - this.offset.parent.left, t(window).scrollTop() - this.offset.relative.top - this.offset.parent.top, t(window).scrollLeft() + t(window).width() - this.helperProportions.width - this.margins.left, t(window).scrollTop() + (t(window).height() || document.body.parentNode.scrollHeight) - this.helperProportions.height - this.margins.top]) : "document" === o.containment ? void (this.containment = [0, 0, t(document).width() - this.helperProportions.width - this.margins.left, (t(document).height() || document.body.parentNode.scrollHeight) - this.helperProportions.height - this.margins.top]) : o.containment.constructor === Array ? void (this.containment = o.containment) : ("parent" === o.containment && (o.containment = this.helper[0].parentNode), n = t(o.containment), void ((i = n[0]) && (e = "hidden" !== n.css("overflow"), this.containment = [(parseInt(n.css("borderLeftWidth"), 10) || 0) + (parseInt(n.css("paddingLeft"), 10) || 0), (parseInt(n.css("borderTopWidth"), 10) || 0) + (parseInt(n.css("paddingTop"), 10) || 0), (e ? Math.max(i.scrollWidth, i.offsetWidth) : i.offsetWidth) - (parseInt(n.css("borderRightWidth"), 10) || 0) - (parseInt(n.css("paddingRight"), 10) || 0) - this.helperProportions.width - this.margins.left - this.margins.right, (e ? Math.max(i.scrollHeight, i.offsetHeight) : i.offsetHeight) - (parseInt(n.css("borderBottomWidth"), 10) || 0) - (parseInt(n.css("paddingBottom"), 10) || 0) - this.helperProportions.height - this.margins.top - this.margins.bottom], this.relative_container = n))) : void (this.containment = null);
        }, _convertPositionTo: function _convertPositionTo(e, n) {
            n || (n = this.position);var i = "absolute" === e ? 1 : -1,
                o = "absolute" !== this.cssPosition || this.scrollParent[0] !== document && t.contains(this.scrollParent[0], this.offsetParent[0]) ? this.scrollParent : this.offsetParent;return this.offset.scroll || (this.offset.scroll = { top: o.scrollTop(), left: o.scrollLeft() }), { top: n.top + this.offset.relative.top * i + this.offset.parent.top * i - ("fixed" === this.cssPosition ? -this.scrollParent.scrollTop() : this.offset.scroll.top) * i, left: n.left + this.offset.relative.left * i + this.offset.parent.left * i - ("fixed" === this.cssPosition ? -this.scrollParent.scrollLeft() : this.offset.scroll.left) * i };
        }, _generatePosition: function _generatePosition(e) {
            var n,
                i,
                o,
                s,
                r = this.options,
                a = "absolute" !== this.cssPosition || this.scrollParent[0] !== document && t.contains(this.scrollParent[0], this.offsetParent[0]) ? this.scrollParent : this.offsetParent,
                l = e.pageX,
                c = e.pageY;return this.offset.scroll || (this.offset.scroll = { top: a.scrollTop(), left: a.scrollLeft() }), this.originalPosition && (this.containment && (this.relative_container ? (i = this.relative_container.offset(), n = [this.containment[0] + i.left, this.containment[1] + i.top, this.containment[2] + i.left, this.containment[3] + i.top]) : n = this.containment, e.pageX - this.offset.click.left < n[0] && (l = n[0] + this.offset.click.left), e.pageY - this.offset.click.top < n[1] && (c = n[1] + this.offset.click.top), e.pageX - this.offset.click.left > n[2] && (l = n[2] + this.offset.click.left), e.pageY - this.offset.click.top > n[3] && (c = n[3] + this.offset.click.top)), r.grid && (o = r.grid[1] ? this.originalPageY + Math.round((c - this.originalPageY) / r.grid[1]) * r.grid[1] : this.originalPageY, c = n ? o - this.offset.click.top >= n[1] || o - this.offset.click.top > n[3] ? o : o - this.offset.click.top >= n[1] ? o - r.grid[1] : o + r.grid[1] : o, s = r.grid[0] ? this.originalPageX + Math.round((l - this.originalPageX) / r.grid[0]) * r.grid[0] : this.originalPageX, l = n ? s - this.offset.click.left >= n[0] || s - this.offset.click.left > n[2] ? s : s - this.offset.click.left >= n[0] ? s - r.grid[0] : s + r.grid[0] : s)), { top: c - this.offset.click.top - this.offset.relative.top - this.offset.parent.top + ("fixed" === this.cssPosition ? -this.scrollParent.scrollTop() : this.offset.scroll.top), left: l - this.offset.click.left - this.offset.relative.left - this.offset.parent.left + ("fixed" === this.cssPosition ? -this.scrollParent.scrollLeft() : this.offset.scroll.left) };
        }, _clear: function _clear() {
            this.helper.removeClass("ui-draggable-dragging"), this.helper[0] === this.element[0] || this.cancelHelperRemoval || this.helper.remove(), this.helper = null, this.cancelHelperRemoval = !1;
        }, _trigger: function _trigger(e, n, i) {
            return i = i || this._uiHash(), t.ui.plugin.call(this, e, [n, i]), "drag" === e && (this.positionAbs = this._convertPositionTo("absolute")), t.Widget.prototype._trigger.call(this, e, n, i);
        }, plugins: {}, _uiHash: function _uiHash() {
            return { helper: this.helper, position: this.position, originalPosition: this.originalPosition, offset: this.positionAbs };
        } }), t.ui.plugin.add("draggable", "connectToSortable", { start: function start(e, n) {
            var i = t(this).data("ui-draggable"),
                o = i.options,
                s = t.extend({}, n, { item: i.element });i.sortables = [], t(o.connectToSortable).each(function () {
                var n = t.data(this, "ui-sortable");n && !n.options.disabled && (i.sortables.push({ instance: n, shouldRevert: n.options.revert }), n.refreshPositions(), n._trigger("activate", e, s));
            });
        }, stop: function stop(e, n) {
            var i = t(this).data("ui-draggable"),
                o = t.extend({}, n, { item: i.element });t.each(i.sortables, function () {
                this.instance.isOver ? (this.instance.isOver = 0, i.cancelHelperRemoval = !0, this.instance.cancelHelperRemoval = !1, this.shouldRevert && (this.instance.options.revert = this.shouldRevert), this.instance._mouseStop(e), this.instance.options.helper = this.instance.options._helper, "original" === i.options.helper && this.instance.currentItem.css({ top: "auto", left: "auto" })) : (this.instance.cancelHelperRemoval = !1, this.instance._trigger("deactivate", e, o));
            });
        }, drag: function drag(e, n) {
            var i = t(this).data("ui-draggable"),
                o = this;t.each(i.sortables, function () {
                var s = !1,
                    r = this;this.instance.positionAbs = i.positionAbs, this.instance.helperProportions = i.helperProportions, this.instance.offset.click = i.offset.click, this.instance._intersectsWith(this.instance.containerCache) && (s = !0, t.each(i.sortables, function () {
                    return this.instance.positionAbs = i.positionAbs, this.instance.helperProportions = i.helperProportions, this.instance.offset.click = i.offset.click, this !== r && this.instance._intersectsWith(this.instance.containerCache) && t.contains(r.instance.element[0], this.instance.element[0]) && (s = !1), s;
                })), s ? (this.instance.isOver || (this.instance.isOver = 1, this.instance.currentItem = t(o).clone().removeAttr("id").appendTo(this.instance.element).data("ui-sortable-item", !0), this.instance.options._helper = this.instance.options.helper, this.instance.options.helper = function () {
                    return n.helper[0];
                }, e.target = this.instance.currentItem[0], this.instance._mouseCapture(e, !0), this.instance._mouseStart(e, !0, !0), this.instance.offset.click.top = i.offset.click.top, this.instance.offset.click.left = i.offset.click.left, this.instance.offset.parent.left -= i.offset.parent.left - this.instance.offset.parent.left, this.instance.offset.parent.top -= i.offset.parent.top - this.instance.offset.parent.top, i._trigger("toSortable", e), i.dropped = this.instance.element, i.currentItem = i.element, this.instance.fromOutside = i), this.instance.currentItem && this.instance._mouseDrag(e)) : this.instance.isOver && (this.instance.isOver = 0, this.instance.cancelHelperRemoval = !0, this.instance.options.revert = !1, this.instance._trigger("out", e, this.instance._uiHash(this.instance)), this.instance._mouseStop(e, !0), this.instance.options.helper = this.instance.options._helper, this.instance.currentItem.remove(), this.instance.placeholder && this.instance.placeholder.remove(), i._trigger("fromSortable", e), i.dropped = !1);
            });
        } }), t.ui.plugin.add("draggable", "cursor", { start: function start() {
            var e = t("body"),
                n = t(this).data("ui-draggable").options;e.css("cursor") && (n._cursor = e.css("cursor")), e.css("cursor", n.cursor);
        }, stop: function stop() {
            var e = t(this).data("ui-draggable").options;e._cursor && t("body").css("cursor", e._cursor);
        } }), t.ui.plugin.add("draggable", "opacity", { start: function start(e, n) {
            var i = t(n.helper),
                o = t(this).data("ui-draggable").options;i.css("opacity") && (o._opacity = i.css("opacity")), i.css("opacity", o.opacity);
        }, stop: function stop(e, n) {
            var i = t(this).data("ui-draggable").options;i._opacity && t(n.helper).css("opacity", i._opacity);
        } }), t.ui.plugin.add("draggable", "scroll", { start: function start() {
            var e = t(this).data("ui-draggable");e.scrollParent[0] !== document && "HTML" !== e.scrollParent[0].tagName && (e.overflowOffset = e.scrollParent.offset());
        }, drag: function drag(e) {
            var n = t(this).data("ui-draggable"),
                i = n.options,
                o = !1;n.scrollParent[0] !== document && "HTML" !== n.scrollParent[0].tagName ? (i.axis && "x" === i.axis || (n.overflowOffset.top + n.scrollParent[0].offsetHeight - e.pageY < i.scrollSensitivity ? n.scrollParent[0].scrollTop = o = n.scrollParent[0].scrollTop + i.scrollSpeed : e.pageY - n.overflowOffset.top < i.scrollSensitivity && (n.scrollParent[0].scrollTop = o = n.scrollParent[0].scrollTop - i.scrollSpeed)), i.axis && "y" === i.axis || (n.overflowOffset.left + n.scrollParent[0].offsetWidth - e.pageX < i.scrollSensitivity ? n.scrollParent[0].scrollLeft = o = n.scrollParent[0].scrollLeft + i.scrollSpeed : e.pageX - n.overflowOffset.left < i.scrollSensitivity && (n.scrollParent[0].scrollLeft = o = n.scrollParent[0].scrollLeft - i.scrollSpeed))) : (i.axis && "x" === i.axis || (e.pageY - t(document).scrollTop() < i.scrollSensitivity ? o = t(document).scrollTop(t(document).scrollTop() - i.scrollSpeed) : t(window).height() - (e.pageY - t(document).scrollTop()) < i.scrollSensitivity && (o = t(document).scrollTop(t(document).scrollTop() + i.scrollSpeed))), i.axis && "y" === i.axis || (e.pageX - t(document).scrollLeft() < i.scrollSensitivity ? o = t(document).scrollLeft(t(document).scrollLeft() - i.scrollSpeed) : t(window).width() - (e.pageX - t(document).scrollLeft()) < i.scrollSensitivity && (o = t(document).scrollLeft(t(document).scrollLeft() + i.scrollSpeed)))), !1 !== o && t.ui.ddmanager && !i.dropBehaviour && t.ui.ddmanager.prepareOffsets(n, e);
        } }), t.ui.plugin.add("draggable", "snap", { start: function start() {
            var e = t(this).data("ui-draggable"),
                n = e.options;e.snapElements = [], t(n.snap.constructor !== String ? n.snap.items || ":data(ui-draggable)" : n.snap).each(function () {
                var n = t(this),
                    i = n.offset();this !== e.element[0] && e.snapElements.push({ item: this, width: n.outerWidth(), height: n.outerHeight(), top: i.top, left: i.left });
            });
        }, drag: function drag(e, n) {
            var i,
                o,
                s,
                r,
                a,
                l,
                c,
                u,
                h,
                p,
                d = t(this).data("ui-draggable"),
                f = d.options,
                g = f.snapTolerance,
                m = n.offset.left,
                v = m + d.helperProportions.width,
                y = n.offset.top,
                b = y + d.helperProportions.height;for (h = d.snapElements.length - 1; h >= 0; h--) {
                a = d.snapElements[h].left, l = a + d.snapElements[h].width, c = d.snapElements[h].top, u = c + d.snapElements[h].height, a - g > v || m > l + g || c - g > b || y > u + g || !t.contains(d.snapElements[h].item.ownerDocument, d.snapElements[h].item) ? (d.snapElements[h].snapping && d.options.snap.release && d.options.snap.release.call(d.element, e, t.extend(d._uiHash(), { snapItem: d.snapElements[h].item })), d.snapElements[h].snapping = !1) : ("inner" !== f.snapMode && (i = g >= Math.abs(c - b), o = g >= Math.abs(u - y), s = g >= Math.abs(a - v), r = g >= Math.abs(l - m), i && (n.position.top = d._convertPositionTo("relative", { top: c - d.helperProportions.height, left: 0 }).top - d.margins.top), o && (n.position.top = d._convertPositionTo("relative", { top: u, left: 0 }).top - d.margins.top), s && (n.position.left = d._convertPositionTo("relative", { top: 0, left: a - d.helperProportions.width }).left - d.margins.left), r && (n.position.left = d._convertPositionTo("relative", { top: 0, left: l }).left - d.margins.left)), p = i || o || s || r, "outer" !== f.snapMode && (i = g >= Math.abs(c - y), o = g >= Math.abs(u - b), s = g >= Math.abs(a - m), r = g >= Math.abs(l - v), i && (n.position.top = d._convertPositionTo("relative", { top: c, left: 0 }).top - d.margins.top), o && (n.position.top = d._convertPositionTo("relative", { top: u - d.helperProportions.height, left: 0 }).top - d.margins.top), s && (n.position.left = d._convertPositionTo("relative", { top: 0, left: a }).left - d.margins.left), r && (n.position.left = d._convertPositionTo("relative", { top: 0, left: l - d.helperProportions.width }).left - d.margins.left)), !d.snapElements[h].snapping && (i || o || s || r || p) && d.options.snap.snap && d.options.snap.snap.call(d.element, e, t.extend(d._uiHash(), { snapItem: d.snapElements[h].item })), d.snapElements[h].snapping = i || o || s || r || p);
            }
        } }), t.ui.plugin.add("draggable", "stack", { start: function start() {
            var e,
                n = this.data("ui-draggable").options,
                i = t.makeArray(t(n.stack)).sort(function (e, n) {
                return (parseInt(t(e).css("zIndex"), 10) || 0) - (parseInt(t(n).css("zIndex"), 10) || 0);
            });i.length && (e = parseInt(t(i[0]).css("zIndex"), 10) || 0, t(i).each(function (n) {
                t(this).css("zIndex", e + n);
            }), this.css("zIndex", e + i.length));
        } }), t.ui.plugin.add("draggable", "zIndex", { start: function start(e, n) {
            var i = t(n.helper),
                o = t(this).data("ui-draggable").options;i.css("zIndex") && (o._zIndex = i.css("zIndex")), i.css("zIndex", o.zIndex);
        }, stop: function stop(e, n) {
            var i = t(this).data("ui-draggable").options;i._zIndex && t(n.helper).css("zIndex", i._zIndex);
        } });
}(jQuery), function (t) {
    function e(t, e, n) {
        return t > e && e + n > t;
    }t.widget("ui.droppable", { version: "1.10.4", widgetEventPrefix: "drop", options: { accept: "*", activeClass: !1, addClasses: !0, greedy: !1, hoverClass: !1, scope: "default", tolerance: "intersect", activate: null, deactivate: null, drop: null, out: null, over: null }, _create: function _create() {
            var e,
                n = this.options,
                i = n.accept;this.isover = !1, this.isout = !0, this.accept = t.isFunction(i) ? i : function (t) {
                return t.is(i);
            }, this.proportions = function () {
                return arguments.length ? void (e = arguments[0]) : e || (e = { width: this.element[0].offsetWidth, height: this.element[0].offsetHeight });
            }, t.ui.ddmanager.droppables[n.scope] = t.ui.ddmanager.droppables[n.scope] || [], t.ui.ddmanager.droppables[n.scope].push(this), n.addClasses && this.element.addClass("ui-droppable");
        }, _destroy: function _destroy() {
            for (var e = 0, n = t.ui.ddmanager.droppables[this.options.scope]; n.length > e; e++) {
                n[e] === this && n.splice(e, 1);
            }this.element.removeClass("ui-droppable ui-droppable-disabled");
        }, _setOption: function _setOption(e, n) {
            "accept" === e && (this.accept = t.isFunction(n) ? n : function (t) {
                return t.is(n);
            }), t.Widget.prototype._setOption.apply(this, arguments);
        }, _activate: function _activate(e) {
            var n = t.ui.ddmanager.current;this.options.activeClass && this.element.addClass(this.options.activeClass), n && this._trigger("activate", e, this.ui(n));
        }, _deactivate: function _deactivate(e) {
            var n = t.ui.ddmanager.current;this.options.activeClass && this.element.removeClass(this.options.activeClass), n && this._trigger("deactivate", e, this.ui(n));
        }, _over: function _over(e) {
            var n = t.ui.ddmanager.current;n && (n.currentItem || n.element)[0] !== this.element[0] && this.accept.call(this.element[0], n.currentItem || n.element) && (this.options.hoverClass && this.element.addClass(this.options.hoverClass), this._trigger("over", e, this.ui(n)));
        }, _out: function _out(e) {
            var n = t.ui.ddmanager.current;n && (n.currentItem || n.element)[0] !== this.element[0] && this.accept.call(this.element[0], n.currentItem || n.element) && (this.options.hoverClass && this.element.removeClass(this.options.hoverClass), this._trigger("out", e, this.ui(n)));
        }, _drop: function _drop(e, n) {
            var i = n || t.ui.ddmanager.current,
                o = !1;return !(!i || (i.currentItem || i.element)[0] === this.element[0]) && (this.element.find(":data(ui-droppable)").not(".ui-draggable-dragging").each(function () {
                var e = t.data(this, "ui-droppable");return e.options.greedy && !e.options.disabled && e.options.scope === i.options.scope && e.accept.call(e.element[0], i.currentItem || i.element) && t.ui.intersect(i, t.extend(e, { offset: e.element.offset() }), e.options.tolerance) ? (o = !0, !1) : void 0;
            }), !o && !!this.accept.call(this.element[0], i.currentItem || i.element) && (this.options.activeClass && this.element.removeClass(this.options.activeClass), this.options.hoverClass && this.element.removeClass(this.options.hoverClass), this._trigger("drop", e, this.ui(i)), this.element));
        }, ui: function ui(t) {
            return { draggable: t.currentItem || t.element, helper: t.helper, position: t.position, offset: t.positionAbs };
        } }), t.ui.intersect = function (t, n, i) {
        if (!n.offset) return !1;var o,
            s,
            r = (t.positionAbs || t.position.absolute).left,
            a = (t.positionAbs || t.position.absolute).top,
            l = r + t.helperProportions.width,
            c = a + t.helperProportions.height,
            u = n.offset.left,
            h = n.offset.top,
            p = u + n.proportions().width,
            d = h + n.proportions().height;switch (i) {case "fit":
                return r >= u && p >= l && a >= h && d >= c;case "intersect":
                return r + t.helperProportions.width / 2 > u && p > l - t.helperProportions.width / 2 && a + t.helperProportions.height / 2 > h && d > c - t.helperProportions.height / 2;case "pointer":
                return o = (t.positionAbs || t.position.absolute).left + (t.clickOffset || t.offset.click).left, s = (t.positionAbs || t.position.absolute).top + (t.clickOffset || t.offset.click).top, e(s, h, n.proportions().height) && e(o, u, n.proportions().width);case "touch":
                return (a >= h && d >= a || c >= h && d >= c || h > a && c > d) && (r >= u && p >= r || l >= u && p >= l || u > r && l > p);default:
                return !1;}
    }, t.ui.ddmanager = { current: null, droppables: { default: [] }, prepareOffsets: function prepareOffsets(e, n) {
            var i,
                o,
                s = t.ui.ddmanager.droppables[e.options.scope] || [],
                r = n ? n.type : null,
                a = (e.currentItem || e.element).find(":data(ui-droppable)").addBack();t: for (i = 0; s.length > i; i++) {
                if (!(s[i].options.disabled || e && !s[i].accept.call(s[i].element[0], e.currentItem || e.element))) {
                    for (o = 0; a.length > o; o++) {
                        if (a[o] === s[i].element[0]) {
                            s[i].proportions().height = 0;continue t;
                        }
                    }s[i].visible = "none" !== s[i].element.css("display"), s[i].visible && ("mousedown" === r && s[i]._activate.call(s[i], n), s[i].offset = s[i].element.offset(), s[i].proportions({ width: s[i].element[0].offsetWidth, height: s[i].element[0].offsetHeight }));
                }
            }
        }, drop: function drop(e, n) {
            var i = !1;return t.each((t.ui.ddmanager.droppables[e.options.scope] || []).slice(), function () {
                this.options && (!this.options.disabled && this.visible && t.ui.intersect(e, this, this.options.tolerance) && (i = this._drop.call(this, n) || i), !this.options.disabled && this.visible && this.accept.call(this.element[0], e.currentItem || e.element) && (this.isout = !0, this.isover = !1, this._deactivate.call(this, n)));
            }), i;
        }, dragStart: function dragStart(e, n) {
            e.element.parentsUntil("body").bind("scroll.droppable", function () {
                e.options.refreshPositions || t.ui.ddmanager.prepareOffsets(e, n);
            });
        }, drag: function drag(e, n) {
            e.options.refreshPositions && t.ui.ddmanager.prepareOffsets(e, n), t.each(t.ui.ddmanager.droppables[e.options.scope] || [], function () {
                if (!this.options.disabled && !this.greedyChild && this.visible) {
                    var i,
                        o,
                        s,
                        r = t.ui.intersect(e, this, this.options.tolerance),
                        a = !r && this.isover ? "isout" : r && !this.isover ? "isover" : null;a && (this.options.greedy && (o = this.options.scope, s = this.element.parents(":data(ui-droppable)").filter(function () {
                        return t.data(this, "ui-droppable").options.scope === o;
                    }), s.length && (i = t.data(s[0], "ui-droppable"), i.greedyChild = "isover" === a)), i && "isover" === a && (i.isover = !1, i.isout = !0, i._out.call(i, n)), this[a] = !0, this["isout" === a ? "isover" : "isout"] = !1, this["isover" === a ? "_over" : "_out"].call(this, n), i && "isout" === a && (i.isout = !1, i.isover = !0, i._over.call(i, n)));
                }
            });
        }, dragStop: function dragStop(e, n) {
            e.element.parentsUntil("body").unbind("scroll.droppable"), e.options.refreshPositions || t.ui.ddmanager.prepareOffsets(e, n);
        } };
}(jQuery), function (t) {
    function e(t) {
        return parseInt(t, 10) || 0;
    }function n(t) {
        return !isNaN(parseInt(t, 10));
    }t.widget("ui.resizable", t.ui.mouse, { version: "1.10.4", widgetEventPrefix: "resize", options: { alsoResize: !1, animate: !1, animateDuration: "slow", animateEasing: "swing", aspectRatio: !1, autoHide: !1, containment: !1, ghost: !1, grid: !1, handles: "e,s,se", helper: !1, maxHeight: null, maxWidth: null, minHeight: 10, minWidth: 10, zIndex: 90, resize: null, start: null, stop: null }, _create: function _create() {
            var e,
                n,
                i,
                o,
                s,
                r = this,
                a = this.options;if (this.element.addClass("ui-resizable"), t.extend(this, { _aspectRatio: !!a.aspectRatio, aspectRatio: a.aspectRatio, originalElement: this.element, _proportionallyResizeElements: [], _helper: a.helper || a.ghost || a.animate ? a.helper || "ui-resizable-helper" : null }), this.element[0].nodeName.match(/canvas|textarea|input|select|button|img/i) && (this.element.wrap(t("<div class='ui-wrapper' style='overflow: hidden;'></div>").css({ position: this.element.css("position"), width: this.element.outerWidth(), height: this.element.outerHeight(), top: this.element.css("top"), left: this.element.css("left") })), this.element = this.element.parent().data("ui-resizable", this.element.data("ui-resizable")), this.elementIsWrapper = !0, this.element.css({ marginLeft: this.originalElement.css("marginLeft"), marginTop: this.originalElement.css("marginTop"), marginRight: this.originalElement.css("marginRight"), marginBottom: this.originalElement.css("marginBottom") }), this.originalElement.css({ marginLeft: 0, marginTop: 0, marginRight: 0, marginBottom: 0 }), this.originalResizeStyle = this.originalElement.css("resize"), this.originalElement.css("resize", "none"), this._proportionallyResizeElements.push(this.originalElement.css({ position: "static", zoom: 1, display: "block" })), this.originalElement.css({ margin: this.originalElement.css("margin") }), this._proportionallyResize()), this.handles = a.handles || (t(".ui-resizable-handle", this.element).length ? { n: ".ui-resizable-n", e: ".ui-resizable-e", s: ".ui-resizable-s", w: ".ui-resizable-w", se: ".ui-resizable-se", sw: ".ui-resizable-sw", ne: ".ui-resizable-ne", nw: ".ui-resizable-nw" } : "e,s,se"), this.handles.constructor === String) for ("all" === this.handles && (this.handles = "n,e,s,w,se,sw,ne,nw"), e = this.handles.split(","), this.handles = {}, n = 0; e.length > n; n++) {
                i = t.trim(e[n]), s = "ui-resizable-" + i, o = t("<div class='ui-resizable-handle " + s + "'></div>"), o.css({ zIndex: a.zIndex }), "se" === i && o.addClass("ui-icon ui-icon-gripsmall-diagonal-se"), this.handles[i] = ".ui-resizable-" + i, this.element.append(o);
            }this._renderAxis = function (e) {
                var n, i, o, s;e = e || this.element;for (n in this.handles) {
                    this.handles[n].constructor === String && (this.handles[n] = t(this.handles[n], this.element).show()), this.elementIsWrapper && this.originalElement[0].nodeName.match(/textarea|input|select|button/i) && (i = t(this.handles[n], this.element), s = /sw|ne|nw|se|n|s/.test(n) ? i.outerHeight() : i.outerWidth(), o = ["padding", /ne|nw|n/.test(n) ? "Top" : /se|sw|s/.test(n) ? "Bottom" : /^e$/.test(n) ? "Right" : "Left"].join(""), e.css(o, s), this._proportionallyResize()), t(this.handles[n]).length;
                }
            }, this._renderAxis(this.element), this._handles = t(".ui-resizable-handle", this.element).disableSelection(), this._handles.mouseover(function () {
                r.resizing || (this.className && (o = this.className.match(/ui-resizable-(se|sw|ne|nw|n|e|s|w)/i)), r.axis = o && o[1] ? o[1] : "se");
            }), a.autoHide && (this._handles.hide(), t(this.element).addClass("ui-resizable-autohide").mouseenter(function () {
                a.disabled || (t(this).removeClass("ui-resizable-autohide"), r._handles.show());
            }).mouseleave(function () {
                a.disabled || r.resizing || (t(this).addClass("ui-resizable-autohide"), r._handles.hide());
            })), this._mouseInit();
        }, _destroy: function _destroy() {
            this._mouseDestroy();var e,
                n = function n(e) {
                t(e).removeClass("ui-resizable ui-resizable-disabled ui-resizable-resizing").removeData("resizable").removeData("ui-resizable").unbind(".resizable").find(".ui-resizable-handle").remove();
            };return this.elementIsWrapper && (n(this.element), e = this.element, this.originalElement.css({ position: e.css("position"), width: e.outerWidth(), height: e.outerHeight(), top: e.css("top"), left: e.css("left") }).insertAfter(e), e.remove()), this.originalElement.css("resize", this.originalResizeStyle), n(this.originalElement), this;
        }, _mouseCapture: function _mouseCapture(e) {
            var n,
                i,
                o = !1;for (n in this.handles) {
                ((i = t(this.handles[n])[0]) === e.target || t.contains(i, e.target)) && (o = !0);
            }return !this.options.disabled && o;
        }, _mouseStart: function _mouseStart(n) {
            var i,
                o,
                s,
                r = this.options,
                a = this.element.position(),
                l = this.element;return this.resizing = !0, /absolute/.test(l.css("position")) ? l.css({ position: "absolute", top: l.css("top"), left: l.css("left") }) : l.is(".ui-draggable") && l.css({ position: "absolute", top: a.top, left: a.left }), this._renderProxy(), i = e(this.helper.css("left")), o = e(this.helper.css("top")), r.containment && (i += t(r.containment).scrollLeft() || 0, o += t(r.containment).scrollTop() || 0), this.offset = this.helper.offset(), this.position = { left: i, top: o }, this.size = this._helper ? { width: this.helper.width(), height: this.helper.height() } : { width: l.width(), height: l.height() }, this.originalSize = this._helper ? { width: l.outerWidth(), height: l.outerHeight() } : { width: l.width(), height: l.height() }, this.originalPosition = { left: i, top: o }, this.sizeDiff = { width: l.outerWidth() - l.width(), height: l.outerHeight() - l.height() }, this.originalMousePosition = { left: n.pageX, top: n.pageY }, this.aspectRatio = "number" == typeof r.aspectRatio ? r.aspectRatio : this.originalSize.width / this.originalSize.height || 1, s = t(".ui-resizable-" + this.axis).css("cursor"), t("body").css("cursor", "auto" === s ? this.axis + "-resize" : s), l.addClass("ui-resizable-resizing"), this._propagate("start", n), !0;
        }, _mouseDrag: function _mouseDrag(e) {
            var n,
                i = this.helper,
                o = {},
                s = this.originalMousePosition,
                r = this.axis,
                a = this.position.top,
                l = this.position.left,
                c = this.size.width,
                u = this.size.height,
                h = e.pageX - s.left || 0,
                p = e.pageY - s.top || 0,
                d = this._change[r];return !!d && (n = d.apply(this, [e, h, p]), this._updateVirtualBoundaries(e.shiftKey), (this._aspectRatio || e.shiftKey) && (n = this._updateRatio(n, e)), n = this._respectSize(n, e), this._updateCache(n), this._propagate("resize", e), this.position.top !== a && (o.top = this.position.top + "px"), this.position.left !== l && (o.left = this.position.left + "px"), this.size.width !== c && (o.width = this.size.width + "px"), this.size.height !== u && (o.height = this.size.height + "px"), i.css(o), !this._helper && this._proportionallyResizeElements.length && this._proportionallyResize(), t.isEmptyObject(o) || this._trigger("resize", e, this.ui()), !1);
        }, _mouseStop: function _mouseStop(e) {
            this.resizing = !1;var n,
                i,
                o,
                s,
                r,
                a,
                l,
                c = this.options,
                u = this;return this._helper && (n = this._proportionallyResizeElements, i = n.length && /textarea/i.test(n[0].nodeName), o = i && t.ui.hasScroll(n[0], "left") ? 0 : u.sizeDiff.height, s = i ? 0 : u.sizeDiff.width, r = { width: u.helper.width() - s, height: u.helper.height() - o }, a = parseInt(u.element.css("left"), 10) + (u.position.left - u.originalPosition.left) || null, l = parseInt(u.element.css("top"), 10) + (u.position.top - u.originalPosition.top) || null, c.animate || this.element.css(t.extend(r, { top: l, left: a })), u.helper.height(u.size.height), u.helper.width(u.size.width), this._helper && !c.animate && this._proportionallyResize()), t("body").css("cursor", "auto"), this.element.removeClass("ui-resizable-resizing"), this._propagate("stop", e), this._helper && this.helper.remove(), !1;
        }, _updateVirtualBoundaries: function _updateVirtualBoundaries(t) {
            var e,
                i,
                o,
                s,
                r,
                a = this.options;r = { minWidth: n(a.minWidth) ? a.minWidth : 0, maxWidth: n(a.maxWidth) ? a.maxWidth : 1 / 0, minHeight: n(a.minHeight) ? a.minHeight : 0, maxHeight: n(a.maxHeight) ? a.maxHeight : 1 / 0 }, (this._aspectRatio || t) && (e = r.minHeight * this.aspectRatio, o = r.minWidth / this.aspectRatio, i = r.maxHeight * this.aspectRatio, s = r.maxWidth / this.aspectRatio, e > r.minWidth && (r.minWidth = e), o > r.minHeight && (r.minHeight = o), r.maxWidth > i && (r.maxWidth = i), r.maxHeight > s && (r.maxHeight = s)), this._vBoundaries = r;
        }, _updateCache: function _updateCache(t) {
            this.offset = this.helper.offset(), n(t.left) && (this.position.left = t.left), n(t.top) && (this.position.top = t.top), n(t.height) && (this.size.height = t.height), n(t.width) && (this.size.width = t.width);
        }, _updateRatio: function _updateRatio(t) {
            var e = this.position,
                i = this.size,
                o = this.axis;return n(t.height) ? t.width = t.height * this.aspectRatio : n(t.width) && (t.height = t.width / this.aspectRatio), "sw" === o && (t.left = e.left + (i.width - t.width), t.top = null), "nw" === o && (t.top = e.top + (i.height - t.height), t.left = e.left + (i.width - t.width)), t;
        }, _respectSize: function _respectSize(t) {
            var e = this._vBoundaries,
                i = this.axis,
                o = n(t.width) && e.maxWidth && e.maxWidth < t.width,
                s = n(t.height) && e.maxHeight && e.maxHeight < t.height,
                r = n(t.width) && e.minWidth && e.minWidth > t.width,
                a = n(t.height) && e.minHeight && e.minHeight > t.height,
                l = this.originalPosition.left + this.originalSize.width,
                c = this.position.top + this.size.height,
                u = /sw|nw|w/.test(i),
                h = /nw|ne|n/.test(i);return r && (t.width = e.minWidth), a && (t.height = e.minHeight), o && (t.width = e.maxWidth), s && (t.height = e.maxHeight), r && u && (t.left = l - e.minWidth), o && u && (t.left = l - e.maxWidth), a && h && (t.top = c - e.minHeight), s && h && (t.top = c - e.maxHeight), t.width || t.height || t.left || !t.top ? t.width || t.height || t.top || !t.left || (t.left = null) : t.top = null, t;
        }, _proportionallyResize: function _proportionallyResize() {
            if (this._proportionallyResizeElements.length) {
                var t,
                    e,
                    n,
                    i,
                    o,
                    s = this.helper || this.element;for (t = 0; this._proportionallyResizeElements.length > t; t++) {
                    if (o = this._proportionallyResizeElements[t], !this.borderDif) for (this.borderDif = [], n = [o.css("borderTopWidth"), o.css("borderRightWidth"), o.css("borderBottomWidth"), o.css("borderLeftWidth")], i = [o.css("paddingTop"), o.css("paddingRight"), o.css("paddingBottom"), o.css("paddingLeft")], e = 0; n.length > e; e++) {
                        this.borderDif[e] = (parseInt(n[e], 10) || 0) + (parseInt(i[e], 10) || 0);
                    }o.css({ height: s.height() - this.borderDif[0] - this.borderDif[2] || 0, width: s.width() - this.borderDif[1] - this.borderDif[3] || 0 });
                }
            }
        }, _renderProxy: function _renderProxy() {
            var e = this.element,
                n = this.options;this.elementOffset = e.offset(), this._helper ? (this.helper = this.helper || t("<div style='overflow:hidden;'></div>"), this.helper.addClass(this._helper).css({ width: this.element.outerWidth() - 1, height: this.element.outerHeight() - 1, position: "absolute", left: this.elementOffset.left + "px", top: this.elementOffset.top + "px", zIndex: ++n.zIndex }), this.helper.appendTo("body").disableSelection()) : this.helper = this.element;
        }, _change: { e: function e(t, _e4) {
                return { width: this.originalSize.width + _e4 };
            }, w: function w(t, e) {
                var n = this.originalSize;return { left: this.originalPosition.left + e, width: n.width - e };
            }, n: function n(t, e, _n2) {
                var i = this.originalSize;return { top: this.originalPosition.top + _n2, height: i.height - _n2 };
            }, s: function s(t, e, n) {
                return { height: this.originalSize.height + n };
            }, se: function se(e, n, i) {
                return t.extend(this._change.s.apply(this, arguments), this._change.e.apply(this, [e, n, i]));
            }, sw: function sw(e, n, i) {
                return t.extend(this._change.s.apply(this, arguments), this._change.w.apply(this, [e, n, i]));
            }, ne: function ne(e, n, i) {
                return t.extend(this._change.n.apply(this, arguments), this._change.e.apply(this, [e, n, i]));
            }, nw: function nw(e, n, i) {
                return t.extend(this._change.n.apply(this, arguments), this._change.w.apply(this, [e, n, i]));
            } }, _propagate: function _propagate(e, n) {
            t.ui.plugin.call(this, e, [n, this.ui()]), "resize" !== e && this._trigger(e, n, this.ui());
        }, plugins: {}, ui: function ui() {
            return { originalElement: this.originalElement, element: this.element, helper: this.helper, position: this.position, size: this.size, originalSize: this.originalSize, originalPosition: this.originalPosition };
        } }), t.ui.plugin.add("resizable", "animate", { stop: function stop(e) {
            var n = t(this).data("ui-resizable"),
                i = n.options,
                o = n._proportionallyResizeElements,
                s = o.length && /textarea/i.test(o[0].nodeName),
                r = s && t.ui.hasScroll(o[0], "left") ? 0 : n.sizeDiff.height,
                a = s ? 0 : n.sizeDiff.width,
                l = { width: n.size.width - a, height: n.size.height - r },
                c = parseInt(n.element.css("left"), 10) + (n.position.left - n.originalPosition.left) || null,
                u = parseInt(n.element.css("top"), 10) + (n.position.top - n.originalPosition.top) || null;n.element.animate(t.extend(l, u && c ? { top: u, left: c } : {}), { duration: i.animateDuration, easing: i.animateEasing, step: function step() {
                    var i = { width: parseInt(n.element.css("width"), 10), height: parseInt(n.element.css("height"), 10), top: parseInt(n.element.css("top"), 10), left: parseInt(n.element.css("left"), 10) };o && o.length && t(o[0]).css({ width: i.width, height: i.height }), n._updateCache(i), n._propagate("resize", e);
                } });
        } }), t.ui.plugin.add("resizable", "containment", { start: function start() {
            var n,
                i,
                o,
                s,
                r,
                a,
                l,
                c = t(this).data("ui-resizable"),
                u = c.options,
                h = c.element,
                p = u.containment,
                d = p instanceof t ? p.get(0) : /parent/.test(p) ? h.parent().get(0) : p;d && (c.containerElement = t(d), /document/.test(p) || p === document ? (c.containerOffset = { left: 0, top: 0 }, c.containerPosition = { left: 0, top: 0 }, c.parentData = { element: t(document), left: 0, top: 0, width: t(document).width(), height: t(document).height() || document.body.parentNode.scrollHeight }) : (n = t(d), i = [], t(["Top", "Right", "Left", "Bottom"]).each(function (t, o) {
                i[t] = e(n.css("padding" + o));
            }), c.containerOffset = n.offset(), c.containerPosition = n.position(), c.containerSize = { height: n.innerHeight() - i[3], width: n.innerWidth() - i[1] }, o = c.containerOffset, s = c.containerSize.height, r = c.containerSize.width, a = t.ui.hasScroll(d, "left") ? d.scrollWidth : r, l = t.ui.hasScroll(d) ? d.scrollHeight : s, c.parentData = { element: d, left: o.left, top: o.top, width: a, height: l }));
        }, resize: function resize(e) {
            var n,
                i,
                o,
                s,
                r = t(this).data("ui-resizable"),
                a = r.options,
                l = r.containerOffset,
                c = r.position,
                u = r._aspectRatio || e.shiftKey,
                h = { top: 0, left: 0 },
                p = r.containerElement;p[0] !== document && /static/.test(p.css("position")) && (h = l), c.left < (r._helper ? l.left : 0) && (r.size.width = r.size.width + (r._helper ? r.position.left - l.left : r.position.left - h.left), u && (r.size.height = r.size.width / r.aspectRatio), r.position.left = a.helper ? l.left : 0), c.top < (r._helper ? l.top : 0) && (r.size.height = r.size.height + (r._helper ? r.position.top - l.top : r.position.top), u && (r.size.width = r.size.height * r.aspectRatio), r.position.top = r._helper ? l.top : 0), r.offset.left = r.parentData.left + r.position.left, r.offset.top = r.parentData.top + r.position.top, n = Math.abs((r._helper, r.offset.left - h.left + r.sizeDiff.width)), i = Math.abs((r._helper ? r.offset.top - h.top : r.offset.top - l.top) + r.sizeDiff.height), o = r.containerElement.get(0) === r.element.parent().get(0), s = /relative|absolute/.test(r.containerElement.css("position")), o && s && (n -= Math.abs(r.parentData.left)), n + r.size.width >= r.parentData.width && (r.size.width = r.parentData.width - n, u && (r.size.height = r.size.width / r.aspectRatio)), i + r.size.height >= r.parentData.height && (r.size.height = r.parentData.height - i, u && (r.size.width = r.size.height * r.aspectRatio));
        }, stop: function stop() {
            var e = t(this).data("ui-resizable"),
                n = e.options,
                i = e.containerOffset,
                o = e.containerPosition,
                s = e.containerElement,
                r = t(e.helper),
                a = r.offset(),
                l = r.outerWidth() - e.sizeDiff.width,
                c = r.outerHeight() - e.sizeDiff.height;e._helper && !n.animate && /relative/.test(s.css("position")) && t(this).css({ left: a.left - o.left - i.left, width: l, height: c }), e._helper && !n.animate && /static/.test(s.css("position")) && t(this).css({ left: a.left - o.left - i.left, width: l, height: c });
        } }), t.ui.plugin.add("resizable", "alsoResize", { start: function start() {
            var e = t(this).data("ui-resizable"),
                n = e.options,
                i = function i(e) {
                t(e).each(function () {
                    var e = t(this);e.data("ui-resizable-alsoresize", { width: parseInt(e.width(), 10), height: parseInt(e.height(), 10), left: parseInt(e.css("left"), 10), top: parseInt(e.css("top"), 10) });
                });
            };"object" != _typeof(n.alsoResize) || n.alsoResize.parentNode ? i(n.alsoResize) : n.alsoResize.length ? (n.alsoResize = n.alsoResize[0], i(n.alsoResize)) : t.each(n.alsoResize, function (t) {
                i(t);
            });
        }, resize: function resize(e, n) {
            var i = t(this).data("ui-resizable"),
                o = i.options,
                s = i.originalSize,
                r = i.originalPosition,
                a = { height: i.size.height - s.height || 0, width: i.size.width - s.width || 0, top: i.position.top - r.top || 0, left: i.position.left - r.left || 0 },
                l = function l(e, i) {
                t(e).each(function () {
                    var e = t(this),
                        o = t(this).data("ui-resizable-alsoresize"),
                        s = {},
                        r = i && i.length ? i : e.parents(n.originalElement[0]).length ? ["width", "height"] : ["width", "height", "top", "left"];t.each(r, function (t, e) {
                        var n = (o[e] || 0) + (a[e] || 0);n && n >= 0 && (s[e] = n || null);
                    }), e.css(s);
                });
            };"object" != _typeof(o.alsoResize) || o.alsoResize.nodeType ? l(o.alsoResize) : t.each(o.alsoResize, function (t, e) {
                l(t, e);
            });
        }, stop: function stop() {
            t(this).removeData("resizable-alsoresize");
        } }), t.ui.plugin.add("resizable", "ghost", { start: function start() {
            var e = t(this).data("ui-resizable"),
                n = e.options,
                i = e.size;e.ghost = e.originalElement.clone(), e.ghost.css({ opacity: .25, display: "block", position: "relative", height: i.height, width: i.width, margin: 0, left: 0, top: 0 }).addClass("ui-resizable-ghost").addClass("string" == typeof n.ghost ? n.ghost : ""), e.ghost.appendTo(e.helper);
        }, resize: function resize() {
            var e = t(this).data("ui-resizable");e.ghost && e.ghost.css({ position: "relative", height: e.size.height, width: e.size.width });
        }, stop: function stop() {
            var e = t(this).data("ui-resizable");e.ghost && e.helper && e.helper.get(0).removeChild(e.ghost.get(0));
        } }), t.ui.plugin.add("resizable", "grid", { resize: function resize() {
            var e = t(this).data("ui-resizable"),
                n = e.options,
                i = e.size,
                o = e.originalSize,
                s = e.originalPosition,
                r = e.axis,
                a = "number" == typeof n.grid ? [n.grid, n.grid] : n.grid,
                l = a[0] || 1,
                c = a[1] || 1,
                u = Math.round((i.width - o.width) / l) * l,
                h = Math.round((i.height - o.height) / c) * c,
                p = o.width + u,
                d = o.height + h,
                f = n.maxWidth && p > n.maxWidth,
                g = n.maxHeight && d > n.maxHeight,
                m = n.minWidth && n.minWidth > p,
                v = n.minHeight && n.minHeight > d;n.grid = a, m && (p += l), v && (d += c), f && (p -= l), g && (d -= c), /^(se|s|e)$/.test(r) ? (e.size.width = p, e.size.height = d) : /^(ne)$/.test(r) ? (e.size.width = p, e.size.height = d, e.position.top = s.top - h) : /^(sw)$/.test(r) ? (e.size.width = p, e.size.height = d, e.position.left = s.left - u) : (d - c > 0 ? (e.size.height = d, e.position.top = s.top - h) : (e.size.height = c, e.position.top = s.top + o.height - c), p - l > 0 ? (e.size.width = p, e.position.left = s.left - u) : (e.size.width = l, e.position.left = s.left + o.width - l));
        } });
}(jQuery), function (t) {
    t.widget("ui.selectable", t.ui.mouse, { version: "1.10.4", options: { appendTo: "body", autoRefresh: !0, distance: 0, filter: "*", tolerance: "touch", selected: null, selecting: null, start: null, stop: null, unselected: null, unselecting: null }, _create: function _create() {
            var e,
                n = this;this.element.addClass("ui-selectable"), this.dragged = !1, this.refresh = function () {
                e = t(n.options.filter, n.element[0]), e.addClass("ui-selectee"), e.each(function () {
                    var e = t(this),
                        n = e.offset();t.data(this, "selectable-item", { element: this, $element: e, left: n.left, top: n.top, right: n.left + e.outerWidth(), bottom: n.top + e.outerHeight(), startselected: !1, selected: e.hasClass("ui-selected"), selecting: e.hasClass("ui-selecting"), unselecting: e.hasClass("ui-unselecting") });
                });
            }, this.refresh(), this.selectees = e.addClass("ui-selectee"), this._mouseInit(), this.helper = t("<div class='ui-selectable-helper'></div>");
        }, _destroy: function _destroy() {
            this.selectees.removeClass("ui-selectee").removeData("selectable-item"), this.element.removeClass("ui-selectable ui-selectable-disabled"), this._mouseDestroy();
        }, _mouseStart: function _mouseStart(e) {
            var n = this,
                i = this.options;this.opos = [e.pageX, e.pageY], this.options.disabled || (this.selectees = t(i.filter, this.element[0]), this._trigger("start", e), t(i.appendTo).append(this.helper), this.helper.css({ left: e.pageX, top: e.pageY, width: 0, height: 0 }), i.autoRefresh && this.refresh(), this.selectees.filter(".ui-selected").each(function () {
                var i = t.data(this, "selectable-item");i.startselected = !0, e.metaKey || e.ctrlKey || (i.$element.removeClass("ui-selected"), i.selected = !1, i.$element.addClass("ui-unselecting"), i.unselecting = !0, n._trigger("unselecting", e, { unselecting: i.element }));
            }), t(e.target).parents().addBack().each(function () {
                var i,
                    o = t.data(this, "selectable-item");return o ? (i = !e.metaKey && !e.ctrlKey || !o.$element.hasClass("ui-selected"), o.$element.removeClass(i ? "ui-unselecting" : "ui-selected").addClass(i ? "ui-selecting" : "ui-unselecting"), o.unselecting = !i, o.selecting = i, o.selected = i, i ? n._trigger("selecting", e, { selecting: o.element }) : n._trigger("unselecting", e, { unselecting: o.element }), !1) : void 0;
            }));
        }, _mouseDrag: function _mouseDrag(e) {
            if (this.dragged = !0, !this.options.disabled) {
                var n,
                    i = this,
                    o = this.options,
                    s = this.opos[0],
                    r = this.opos[1],
                    a = e.pageX,
                    l = e.pageY;return s > a && (n = a, a = s, s = n), r > l && (n = l, l = r, r = n), this.helper.css({ left: s, top: r, width: a - s, height: l - r }), this.selectees.each(function () {
                    var n = t.data(this, "selectable-item"),
                        c = !1;n && n.element !== i.element[0] && ("touch" === o.tolerance ? c = !(n.left > a || s > n.right || n.top > l || r > n.bottom) : "fit" === o.tolerance && (c = n.left > s && a > n.right && n.top > r && l > n.bottom), c ? (n.selected && (n.$element.removeClass("ui-selected"), n.selected = !1), n.unselecting && (n.$element.removeClass("ui-unselecting"), n.unselecting = !1), n.selecting || (n.$element.addClass("ui-selecting"), n.selecting = !0, i._trigger("selecting", e, { selecting: n.element }))) : (n.selecting && ((e.metaKey || e.ctrlKey) && n.startselected ? (n.$element.removeClass("ui-selecting"), n.selecting = !1, n.$element.addClass("ui-selected"), n.selected = !0) : (n.$element.removeClass("ui-selecting"), n.selecting = !1, n.startselected && (n.$element.addClass("ui-unselecting"), n.unselecting = !0), i._trigger("unselecting", e, { unselecting: n.element }))), n.selected && (e.metaKey || e.ctrlKey || n.startselected || (n.$element.removeClass("ui-selected"), n.selected = !1, n.$element.addClass("ui-unselecting"), n.unselecting = !0, i._trigger("unselecting", e, { unselecting: n.element })))));
                }), !1;
            }
        }, _mouseStop: function _mouseStop(e) {
            var n = this;return this.dragged = !1, t(".ui-unselecting", this.element[0]).each(function () {
                var i = t.data(this, "selectable-item");i.$element.removeClass("ui-unselecting"), i.unselecting = !1, i.startselected = !1, n._trigger("unselected", e, { unselected: i.element });
            }), t(".ui-selecting", this.element[0]).each(function () {
                var i = t.data(this, "selectable-item");i.$element.removeClass("ui-selecting").addClass("ui-selected"), i.selecting = !1, i.selected = !0, i.startselected = !0, n._trigger("selected", e, { selected: i.element });
            }), this._trigger("stop", e), this.helper.remove(), !1;
        } });
}(jQuery), function (t) {
    function e(t, e, n) {
        return t > e && e + n > t;
    }function n(t) {
        return (/left|right/.test(t.css("float")) || /inline|table-cell/.test(t.css("display"))
        );
    }t.widget("ui.sortable", t.ui.mouse, { version: "1.10.4", widgetEventPrefix: "sort", ready: !1, options: { appendTo: "parent", axis: !1, connectWith: !1, containment: !1, cursor: "auto", cursorAt: !1, dropOnEmpty: !0, forcePlaceholderSize: !1, forceHelperSize: !1, grid: !1, handle: !1, helper: "original", items: "> *", opacity: !1, placeholder: !1, revert: !1, scroll: !0, scrollSensitivity: 20, scrollSpeed: 20, scope: "default", tolerance: "intersect", zIndex: 1e3, activate: null, beforeStop: null, change: null, deactivate: null, out: null, over: null, receive: null, remove: null, sort: null, start: null, stop: null, update: null }, _create: function _create() {
            var t = this.options;this.containerCache = {}, this.element.addClass("ui-sortable"), this.refresh(), this.floating = !!this.items.length && ("x" === t.axis || n(this.items[0].item)), this.offset = this.element.offset(), this._mouseInit(), this.ready = !0;
        }, _destroy: function _destroy() {
            this.element.removeClass("ui-sortable ui-sortable-disabled"), this._mouseDestroy();for (var t = this.items.length - 1; t >= 0; t--) {
                this.items[t].item.removeData(this.widgetName + "-item");
            }return this;
        }, _setOption: function _setOption(e, n) {
            "disabled" === e ? (this.options[e] = n, this.widget().toggleClass("ui-sortable-disabled", !!n)) : t.Widget.prototype._setOption.apply(this, arguments);
        }, _mouseCapture: function _mouseCapture(e, n) {
            var i = null,
                o = !1,
                s = this;return !this.reverting && !this.options.disabled && "static" !== this.options.type && (this._refreshItems(e), t(e.target).parents().each(function () {
                return t.data(this, s.widgetName + "-item") === s ? (i = t(this), !1) : void 0;
            }), t.data(e.target, s.widgetName + "-item") === s && (i = t(e.target)), !!i && !(this.options.handle && !n && (t(this.options.handle, i).find("*").addBack().each(function () {
                this === e.target && (o = !0);
            }), !o)) && (this.currentItem = i, this._removeCurrentsFromItems(), !0));
        }, _mouseStart: function _mouseStart(e, n, i) {
            var o,
                s,
                r = this.options;if (this.currentContainer = this, this.refreshPositions(), this.helper = this._createHelper(e), this._cacheHelperProportions(), this._cacheMargins(), this.scrollParent = this.helper.scrollParent(), this.offset = this.currentItem.offset(), this.offset = { top: this.offset.top - this.margins.top, left: this.offset.left - this.margins.left }, t.extend(this.offset, { click: { left: e.pageX - this.offset.left, top: e.pageY - this.offset.top }, parent: this._getParentOffset(), relative: this._getRelativeOffset() }), this.helper.css("position", "absolute"), this.cssPosition = this.helper.css("position"), this.originalPosition = this._generatePosition(e), this.originalPageX = e.pageX, this.originalPageY = e.pageY, r.cursorAt && this._adjustOffsetFromHelper(r.cursorAt), this.domPosition = { prev: this.currentItem.prev()[0], parent: this.currentItem.parent()[0] }, this.helper[0] !== this.currentItem[0] && this.currentItem.hide(), this._createPlaceholder(), r.containment && this._setContainment(), r.cursor && "auto" !== r.cursor && (s = this.document.find("body"), this.storedCursor = s.css("cursor"), s.css("cursor", r.cursor), this.storedStylesheet = t("<style>*{ cursor: " + r.cursor + " !important; }</style>").appendTo(s)), r.opacity && (this.helper.css("opacity") && (this._storedOpacity = this.helper.css("opacity")), this.helper.css("opacity", r.opacity)), r.zIndex && (this.helper.css("zIndex") && (this._storedZIndex = this.helper.css("zIndex")), this.helper.css("zIndex", r.zIndex)), this.scrollParent[0] !== document && "HTML" !== this.scrollParent[0].tagName && (this.overflowOffset = this.scrollParent.offset()), this._trigger("start", e, this._uiHash()), this._preserveHelperProportions || this._cacheHelperProportions(), !i) for (o = this.containers.length - 1; o >= 0; o--) {
                this.containers[o]._trigger("activate", e, this._uiHash(this));
            }return t.ui.ddmanager && (t.ui.ddmanager.current = this), t.ui.ddmanager && !r.dropBehaviour && t.ui.ddmanager.prepareOffsets(this, e), this.dragging = !0, this.helper.addClass("ui-sortable-helper"), this._mouseDrag(e), !0;
        }, _mouseDrag: function _mouseDrag(e) {
            var n,
                i,
                o,
                s,
                r = this.options,
                a = !1;for (this.position = this._generatePosition(e), this.positionAbs = this._convertPositionTo("absolute"), this.lastPositionAbs || (this.lastPositionAbs = this.positionAbs), this.options.scroll && (this.scrollParent[0] !== document && "HTML" !== this.scrollParent[0].tagName ? (this.overflowOffset.top + this.scrollParent[0].offsetHeight - e.pageY < r.scrollSensitivity ? this.scrollParent[0].scrollTop = a = this.scrollParent[0].scrollTop + r.scrollSpeed : e.pageY - this.overflowOffset.top < r.scrollSensitivity && (this.scrollParent[0].scrollTop = a = this.scrollParent[0].scrollTop - r.scrollSpeed), this.overflowOffset.left + this.scrollParent[0].offsetWidth - e.pageX < r.scrollSensitivity ? this.scrollParent[0].scrollLeft = a = this.scrollParent[0].scrollLeft + r.scrollSpeed : e.pageX - this.overflowOffset.left < r.scrollSensitivity && (this.scrollParent[0].scrollLeft = a = this.scrollParent[0].scrollLeft - r.scrollSpeed)) : (e.pageY - t(document).scrollTop() < r.scrollSensitivity ? a = t(document).scrollTop(t(document).scrollTop() - r.scrollSpeed) : t(window).height() - (e.pageY - t(document).scrollTop()) < r.scrollSensitivity && (a = t(document).scrollTop(t(document).scrollTop() + r.scrollSpeed)), e.pageX - t(document).scrollLeft() < r.scrollSensitivity ? a = t(document).scrollLeft(t(document).scrollLeft() - r.scrollSpeed) : t(window).width() - (e.pageX - t(document).scrollLeft()) < r.scrollSensitivity && (a = t(document).scrollLeft(t(document).scrollLeft() + r.scrollSpeed))), !1 !== a && t.ui.ddmanager && !r.dropBehaviour && t.ui.ddmanager.prepareOffsets(this, e)), this.positionAbs = this._convertPositionTo("absolute"), this.options.axis && "y" === this.options.axis || (this.helper[0].style.left = this.position.left + "px"), this.options.axis && "x" === this.options.axis || (this.helper[0].style.top = this.position.top + "px"), n = this.items.length - 1; n >= 0; n--) {
                if (i = this.items[n], o = i.item[0], (s = this._intersectsWithPointer(i)) && i.instance === this.currentContainer && o !== this.currentItem[0] && this.placeholder[1 === s ? "next" : "prev"]()[0] !== o && !t.contains(this.placeholder[0], o) && ("semi-dynamic" !== this.options.type || !t.contains(this.element[0], o))) {
                    if (this.direction = 1 === s ? "down" : "up", "pointer" !== this.options.tolerance && !this._intersectsWithSides(i)) break;this._rearrange(e, i), this._trigger("change", e, this._uiHash());break;
                }
            }return this._contactContainers(e), t.ui.ddmanager && t.ui.ddmanager.drag(this, e), this._trigger("sort", e, this._uiHash()), this.lastPositionAbs = this.positionAbs, !1;
        }, _mouseStop: function _mouseStop(e, n) {
            if (e) {
                if (t.ui.ddmanager && !this.options.dropBehaviour && t.ui.ddmanager.drop(this, e), this.options.revert) {
                    var i = this,
                        o = this.placeholder.offset(),
                        s = this.options.axis,
                        r = {};s && "x" !== s || (r.left = o.left - this.offset.parent.left - this.margins.left + (this.offsetParent[0] === document.body ? 0 : this.offsetParent[0].scrollLeft)), s && "y" !== s || (r.top = o.top - this.offset.parent.top - this.margins.top + (this.offsetParent[0] === document.body ? 0 : this.offsetParent[0].scrollTop)), this.reverting = !0, t(this.helper).animate(r, parseInt(this.options.revert, 10) || 500, function () {
                        i._clear(e);
                    });
                } else this._clear(e, n);return !1;
            }
        }, cancel: function cancel() {
            if (this.dragging) {
                this._mouseUp({ target: null }), "original" === this.options.helper ? this.currentItem.css(this._storedCSS).removeClass("ui-sortable-helper") : this.currentItem.show();for (var e = this.containers.length - 1; e >= 0; e--) {
                    this.containers[e]._trigger("deactivate", null, this._uiHash(this)), this.containers[e].containerCache.over && (this.containers[e]._trigger("out", null, this._uiHash(this)), this.containers[e].containerCache.over = 0);
                }
            }return this.placeholder && (this.placeholder[0].parentNode && this.placeholder[0].parentNode.removeChild(this.placeholder[0]), "original" !== this.options.helper && this.helper && this.helper[0].parentNode && this.helper.remove(), t.extend(this, { helper: null, dragging: !1, reverting: !1, _noFinalSort: null }), this.domPosition.prev ? t(this.domPosition.prev).after(this.currentItem) : t(this.domPosition.parent).prepend(this.currentItem)), this;
        }, serialize: function serialize(e) {
            var n = this._getItemsAsjQuery(e && e.connected),
                i = [];return e = e || {}, t(n).each(function () {
                var n = (t(e.item || this).attr(e.attribute || "id") || "").match(e.expression || /(.+)[\-=_](.+)/);n && i.push((e.key || n[1] + "[]") + "=" + (e.key && e.expression ? n[1] : n[2]));
            }), !i.length && e.key && i.push(e.key + "="), i.join("&");
        }, toArray: function toArray(e) {
            var n = this._getItemsAsjQuery(e && e.connected),
                i = [];return e = e || {}, n.each(function () {
                i.push(t(e.item || this).attr(e.attribute || "id") || "");
            }), i;
        }, _intersectsWith: function _intersectsWith(t) {
            var e = this.positionAbs.left,
                n = e + this.helperProportions.width,
                i = this.positionAbs.top,
                o = i + this.helperProportions.height,
                s = t.left,
                r = s + t.width,
                a = t.top,
                l = a + t.height,
                c = this.offset.click.top,
                u = this.offset.click.left,
                h = "x" === this.options.axis || i + c > a && l > i + c,
                p = "y" === this.options.axis || e + u > s && r > e + u,
                d = h && p;return "pointer" === this.options.tolerance || this.options.forcePointerForContainers || "pointer" !== this.options.tolerance && this.helperProportions[this.floating ? "width" : "height"] > t[this.floating ? "width" : "height"] ? d : e + this.helperProportions.width / 2 > s && r > n - this.helperProportions.width / 2 && i + this.helperProportions.height / 2 > a && l > o - this.helperProportions.height / 2;
        }, _intersectsWithPointer: function _intersectsWithPointer(t) {
            var n = "x" === this.options.axis || e(this.positionAbs.top + this.offset.click.top, t.top, t.height),
                i = "y" === this.options.axis || e(this.positionAbs.left + this.offset.click.left, t.left, t.width),
                o = n && i,
                s = this._getDragVerticalDirection(),
                r = this._getDragHorizontalDirection();return !!o && (this.floating ? r && "right" === r || "down" === s ? 2 : 1 : s && ("down" === s ? 2 : 1));
        }, _intersectsWithSides: function _intersectsWithSides(t) {
            var n = e(this.positionAbs.top + this.offset.click.top, t.top + t.height / 2, t.height),
                i = e(this.positionAbs.left + this.offset.click.left, t.left + t.width / 2, t.width),
                o = this._getDragVerticalDirection(),
                s = this._getDragHorizontalDirection();return this.floating && s ? "right" === s && i || "left" === s && !i : o && ("down" === o && n || "up" === o && !n);
        }, _getDragVerticalDirection: function _getDragVerticalDirection() {
            var t = this.positionAbs.top - this.lastPositionAbs.top;return 0 !== t && (t > 0 ? "down" : "up");
        }, _getDragHorizontalDirection: function _getDragHorizontalDirection() {
            var t = this.positionAbs.left - this.lastPositionAbs.left;return 0 !== t && (t > 0 ? "right" : "left");
        }, refresh: function refresh(t) {
            return this._refreshItems(t), this.refreshPositions(), this;
        }, _connectWith: function _connectWith() {
            var t = this.options;return t.connectWith.constructor === String ? [t.connectWith] : t.connectWith;
        }, _getItemsAsjQuery: function _getItemsAsjQuery(e) {
            function n() {
                a.push(this);
            }var i,
                o,
                s,
                r,
                a = [],
                l = [],
                c = this._connectWith();if (c && e) for (i = c.length - 1; i >= 0; i--) {
                for (s = t(c[i]), o = s.length - 1; o >= 0; o--) {
                    (r = t.data(s[o], this.widgetFullName)) && r !== this && !r.options.disabled && l.push([t.isFunction(r.options.items) ? r.options.items.call(r.element) : t(r.options.items, r.element).not(".ui-sortable-helper").not(".ui-sortable-placeholder"), r]);
                }
            }for (l.push([t.isFunction(this.options.items) ? this.options.items.call(this.element, null, { options: this.options, item: this.currentItem }) : t(this.options.items, this.element).not(".ui-sortable-helper").not(".ui-sortable-placeholder"), this]), i = l.length - 1; i >= 0; i--) {
                l[i][0].each(n);
            }return t(a);
        }, _removeCurrentsFromItems: function _removeCurrentsFromItems() {
            var e = this.currentItem.find(":data(" + this.widgetName + "-item)");this.items = t.grep(this.items, function (t) {
                for (var n = 0; e.length > n; n++) {
                    if (e[n] === t.item[0]) return !1;
                }return !0;
            });
        }, _refreshItems: function _refreshItems(e) {
            this.items = [], this.containers = [this];var n,
                i,
                o,
                s,
                r,
                a,
                l,
                c,
                u = this.items,
                h = [[t.isFunction(this.options.items) ? this.options.items.call(this.element[0], e, { item: this.currentItem }) : t(this.options.items, this.element), this]],
                p = this._connectWith();if (p && this.ready) for (n = p.length - 1; n >= 0; n--) {
                for (o = t(p[n]), i = o.length - 1; i >= 0; i--) {
                    (s = t.data(o[i], this.widgetFullName)) && s !== this && !s.options.disabled && (h.push([t.isFunction(s.options.items) ? s.options.items.call(s.element[0], e, { item: this.currentItem }) : t(s.options.items, s.element), s]), this.containers.push(s));
                }
            }for (n = h.length - 1; n >= 0; n--) {
                for (r = h[n][1], a = h[n][0], i = 0, c = a.length; c > i; i++) {
                    l = t(a[i]), l.data(this.widgetName + "-item", r), u.push({ item: l, instance: r, width: 0, height: 0, left: 0, top: 0 });
                }
            }
        }, refreshPositions: function refreshPositions(e) {
            this.offsetParent && this.helper && (this.offset.parent = this._getParentOffset());var n, i, o, s;for (n = this.items.length - 1; n >= 0; n--) {
                i = this.items[n], i.instance !== this.currentContainer && this.currentContainer && i.item[0] !== this.currentItem[0] || (o = this.options.toleranceElement ? t(this.options.toleranceElement, i.item) : i.item, e || (i.width = o.outerWidth(), i.height = o.outerHeight()), s = o.offset(), i.left = s.left, i.top = s.top);
            }if (this.options.custom && this.options.custom.refreshContainers) this.options.custom.refreshContainers.call(this);else for (n = this.containers.length - 1; n >= 0; n--) {
                s = this.containers[n].element.offset(), this.containers[n].containerCache.left = s.left, this.containers[n].containerCache.top = s.top, this.containers[n].containerCache.width = this.containers[n].element.outerWidth(), this.containers[n].containerCache.height = this.containers[n].element.outerHeight();
            }return this;
        }, _createPlaceholder: function _createPlaceholder(e) {
            e = e || this;var n,
                i = e.options;i.placeholder && i.placeholder.constructor !== String || (n = i.placeholder, i.placeholder = { element: function element() {
                    var i = e.currentItem[0].nodeName.toLowerCase(),
                        o = t("<" + i + ">", e.document[0]).addClass(n || e.currentItem[0].className + " ui-sortable-placeholder").removeClass("ui-sortable-helper");return "tr" === i ? e.currentItem.children().each(function () {
                        t("<td>&#160;</td>", e.document[0]).attr("colspan", t(this).attr("colspan") || 1).appendTo(o);
                    }) : "img" === i && o.attr("src", e.currentItem.attr("src")), n || o.css("visibility", "hidden"), o;
                }, update: function update(t, o) {
                    (!n || i.forcePlaceholderSize) && (o.height() || o.height(e.currentItem.innerHeight() - parseInt(e.currentItem.css("paddingTop") || 0, 10) - parseInt(e.currentItem.css("paddingBottom") || 0, 10)), o.width() || o.width(e.currentItem.innerWidth() - parseInt(e.currentItem.css("paddingLeft") || 0, 10) - parseInt(e.currentItem.css("paddingRight") || 0, 10)));
                } }), e.placeholder = t(i.placeholder.element.call(e.element, e.currentItem)), e.currentItem.after(e.placeholder), i.placeholder.update(e, e.placeholder);
        }, _contactContainers: function _contactContainers(i) {
            var o,
                s,
                r,
                a,
                l,
                c,
                u,
                h,
                p,
                d,
                f = null,
                g = null;for (o = this.containers.length - 1; o >= 0; o--) {
                if (!t.contains(this.currentItem[0], this.containers[o].element[0])) if (this._intersectsWith(this.containers[o].containerCache)) {
                    if (f && t.contains(this.containers[o].element[0], f.element[0])) continue;f = this.containers[o], g = o;
                } else this.containers[o].containerCache.over && (this.containers[o]._trigger("out", i, this._uiHash(this)), this.containers[o].containerCache.over = 0);
            }if (f) if (1 === this.containers.length) this.containers[g].containerCache.over || (this.containers[g]._trigger("over", i, this._uiHash(this)), this.containers[g].containerCache.over = 1);else {
                for (r = 1e4, a = null, d = f.floating || n(this.currentItem), l = d ? "left" : "top", c = d ? "width" : "height", u = this.positionAbs[l] + this.offset.click[l], s = this.items.length - 1; s >= 0; s--) {
                    t.contains(this.containers[g].element[0], this.items[s].item[0]) && this.items[s].item[0] !== this.currentItem[0] && (!d || e(this.positionAbs.top + this.offset.click.top, this.items[s].top, this.items[s].height)) && (h = this.items[s].item.offset()[l], p = !1, Math.abs(h - u) > Math.abs(h + this.items[s][c] - u) && (p = !0, h += this.items[s][c]), r > Math.abs(h - u) && (r = Math.abs(h - u), a = this.items[s], this.direction = p ? "up" : "down"));
                }if (!a && !this.options.dropOnEmpty) return;if (this.currentContainer === this.containers[g]) return;a ? this._rearrange(i, a, null, !0) : this._rearrange(i, null, this.containers[g].element, !0), this._trigger("change", i, this._uiHash()), this.containers[g]._trigger("change", i, this._uiHash(this)), this.currentContainer = this.containers[g], this.options.placeholder.update(this.currentContainer, this.placeholder), this.containers[g]._trigger("over", i, this._uiHash(this)), this.containers[g].containerCache.over = 1;
            }
        }, _createHelper: function _createHelper(e) {
            var n = this.options,
                i = t.isFunction(n.helper) ? t(n.helper.apply(this.element[0], [e, this.currentItem])) : "clone" === n.helper ? this.currentItem.clone() : this.currentItem;return i.parents("body").length || t("parent" !== n.appendTo ? n.appendTo : this.currentItem[0].parentNode)[0].appendChild(i[0]), i[0] === this.currentItem[0] && (this._storedCSS = { width: this.currentItem[0].style.width, height: this.currentItem[0].style.height, position: this.currentItem.css("position"), top: this.currentItem.css("top"), left: this.currentItem.css("left") }), (!i[0].style.width || n.forceHelperSize) && i.width(this.currentItem.width()), (!i[0].style.height || n.forceHelperSize) && i.height(this.currentItem.height()), i;
        }, _adjustOffsetFromHelper: function _adjustOffsetFromHelper(e) {
            "string" == typeof e && (e = e.split(" ")), t.isArray(e) && (e = { left: +e[0], top: +e[1] || 0 }), "left" in e && (this.offset.click.left = e.left + this.margins.left), "right" in e && (this.offset.click.left = this.helperProportions.width - e.right + this.margins.left), "top" in e && (this.offset.click.top = e.top + this.margins.top), "bottom" in e && (this.offset.click.top = this.helperProportions.height - e.bottom + this.margins.top);
        }, _getParentOffset: function _getParentOffset() {
            this.offsetParent = this.helper.offsetParent();var e = this.offsetParent.offset();return "absolute" === this.cssPosition && this.scrollParent[0] !== document && t.contains(this.scrollParent[0], this.offsetParent[0]) && (e.left += this.scrollParent.scrollLeft(), e.top += this.scrollParent.scrollTop()), (this.offsetParent[0] === document.body || this.offsetParent[0].tagName && "html" === this.offsetParent[0].tagName.toLowerCase() && t.ui.ie) && (e = { top: 0, left: 0 }), { top: e.top + (parseInt(this.offsetParent.css("borderTopWidth"), 10) || 0), left: e.left + (parseInt(this.offsetParent.css("borderLeftWidth"), 10) || 0) };
        }, _getRelativeOffset: function _getRelativeOffset() {
            if ("relative" === this.cssPosition) {
                var t = this.currentItem.position();return { top: t.top - (parseInt(this.helper.css("top"), 10) || 0) + this.scrollParent.scrollTop(), left: t.left - (parseInt(this.helper.css("left"), 10) || 0) + this.scrollParent.scrollLeft() };
            }return { top: 0, left: 0 };
        }, _cacheMargins: function _cacheMargins() {
            this.margins = { left: parseInt(this.currentItem.css("marginLeft"), 10) || 0, top: parseInt(this.currentItem.css("marginTop"), 10) || 0 };
        }, _cacheHelperProportions: function _cacheHelperProportions() {
            this.helperProportions = { width: this.helper.outerWidth(), height: this.helper.outerHeight() };
        }, _setContainment: function _setContainment() {
            var e,
                n,
                i,
                o = this.options;"parent" === o.containment && (o.containment = this.helper[0].parentNode), ("document" === o.containment || "window" === o.containment) && (this.containment = [0 - this.offset.relative.left - this.offset.parent.left, 0 - this.offset.relative.top - this.offset.parent.top, t("document" === o.containment ? document : window).width() - this.helperProportions.width - this.margins.left, (t("document" === o.containment ? document : window).height() || document.body.parentNode.scrollHeight) - this.helperProportions.height - this.margins.top]), /^(document|window|parent)$/.test(o.containment) || (e = t(o.containment)[0], n = t(o.containment).offset(), i = "hidden" !== t(e).css("overflow"), this.containment = [n.left + (parseInt(t(e).css("borderLeftWidth"), 10) || 0) + (parseInt(t(e).css("paddingLeft"), 10) || 0) - this.margins.left, n.top + (parseInt(t(e).css("borderTopWidth"), 10) || 0) + (parseInt(t(e).css("paddingTop"), 10) || 0) - this.margins.top, n.left + (i ? Math.max(e.scrollWidth, e.offsetWidth) : e.offsetWidth) - (parseInt(t(e).css("borderLeftWidth"), 10) || 0) - (parseInt(t(e).css("paddingRight"), 10) || 0) - this.helperProportions.width - this.margins.left, n.top + (i ? Math.max(e.scrollHeight, e.offsetHeight) : e.offsetHeight) - (parseInt(t(e).css("borderTopWidth"), 10) || 0) - (parseInt(t(e).css("paddingBottom"), 10) || 0) - this.helperProportions.height - this.margins.top]);
        }, _convertPositionTo: function _convertPositionTo(e, n) {
            n || (n = this.position);var i = "absolute" === e ? 1 : -1,
                o = "absolute" !== this.cssPosition || this.scrollParent[0] !== document && t.contains(this.scrollParent[0], this.offsetParent[0]) ? this.scrollParent : this.offsetParent,
                s = /(html|body)/i.test(o[0].tagName);return { top: n.top + this.offset.relative.top * i + this.offset.parent.top * i - ("fixed" === this.cssPosition ? -this.scrollParent.scrollTop() : s ? 0 : o.scrollTop()) * i, left: n.left + this.offset.relative.left * i + this.offset.parent.left * i - ("fixed" === this.cssPosition ? -this.scrollParent.scrollLeft() : s ? 0 : o.scrollLeft()) * i };
        }, _generatePosition: function _generatePosition(e) {
            var n,
                i,
                o = this.options,
                s = e.pageX,
                r = e.pageY,
                a = "absolute" !== this.cssPosition || this.scrollParent[0] !== document && t.contains(this.scrollParent[0], this.offsetParent[0]) ? this.scrollParent : this.offsetParent,
                l = /(html|body)/i.test(a[0].tagName);return "relative" !== this.cssPosition || this.scrollParent[0] !== document && this.scrollParent[0] !== this.offsetParent[0] || (this.offset.relative = this._getRelativeOffset()), this.originalPosition && (this.containment && (e.pageX - this.offset.click.left < this.containment[0] && (s = this.containment[0] + this.offset.click.left), e.pageY - this.offset.click.top < this.containment[1] && (r = this.containment[1] + this.offset.click.top), e.pageX - this.offset.click.left > this.containment[2] && (s = this.containment[2] + this.offset.click.left), e.pageY - this.offset.click.top > this.containment[3] && (r = this.containment[3] + this.offset.click.top)), o.grid && (n = this.originalPageY + Math.round((r - this.originalPageY) / o.grid[1]) * o.grid[1], r = this.containment ? n - this.offset.click.top >= this.containment[1] && n - this.offset.click.top <= this.containment[3] ? n : n - this.offset.click.top >= this.containment[1] ? n - o.grid[1] : n + o.grid[1] : n, i = this.originalPageX + Math.round((s - this.originalPageX) / o.grid[0]) * o.grid[0], s = this.containment ? i - this.offset.click.left >= this.containment[0] && i - this.offset.click.left <= this.containment[2] ? i : i - this.offset.click.left >= this.containment[0] ? i - o.grid[0] : i + o.grid[0] : i)), { top: r - this.offset.click.top - this.offset.relative.top - this.offset.parent.top + ("fixed" === this.cssPosition ? -this.scrollParent.scrollTop() : l ? 0 : a.scrollTop()), left: s - this.offset.click.left - this.offset.relative.left - this.offset.parent.left + ("fixed" === this.cssPosition ? -this.scrollParent.scrollLeft() : l ? 0 : a.scrollLeft()) };
        }, _rearrange: function _rearrange(t, e, n, i) {
            n ? n[0].appendChild(this.placeholder[0]) : e.item[0].parentNode.insertBefore(this.placeholder[0], "down" === this.direction ? e.item[0] : e.item[0].nextSibling), this.counter = this.counter ? ++this.counter : 1;var o = this.counter;this._delay(function () {
                o === this.counter && this.refreshPositions(!i);
            });
        }, _clear: function _clear(t, e) {
            function n(t, e, n) {
                return function (i) {
                    n._trigger(t, i, e._uiHash(e));
                };
            }this.reverting = !1;var i,
                o = [];if (!this._noFinalSort && this.currentItem.parent().length && this.placeholder.before(this.currentItem), this._noFinalSort = null, this.helper[0] === this.currentItem[0]) {
                for (i in this._storedCSS) {
                    ("auto" === this._storedCSS[i] || "static" === this._storedCSS[i]) && (this._storedCSS[i] = "");
                }this.currentItem.css(this._storedCSS).removeClass("ui-sortable-helper");
            } else this.currentItem.show();for (this.fromOutside && !e && o.push(function (t) {
                this._trigger("receive", t, this._uiHash(this.fromOutside));
            }), !this.fromOutside && this.domPosition.prev === this.currentItem.prev().not(".ui-sortable-helper")[0] && this.domPosition.parent === this.currentItem.parent()[0] || e || o.push(function (t) {
                this._trigger("update", t, this._uiHash());
            }), this !== this.currentContainer && (e || (o.push(function (t) {
                this._trigger("remove", t, this._uiHash());
            }), o.push(function (t) {
                return function (e) {
                    t._trigger("receive", e, this._uiHash(this));
                };
            }.call(this, this.currentContainer)), o.push(function (t) {
                return function (e) {
                    t._trigger("update", e, this._uiHash(this));
                };
            }.call(this, this.currentContainer)))), i = this.containers.length - 1; i >= 0; i--) {
                e || o.push(n("deactivate", this, this.containers[i])), this.containers[i].containerCache.over && (o.push(n("out", this, this.containers[i])), this.containers[i].containerCache.over = 0);
            }if (this.storedCursor && (this.document.find("body").css("cursor", this.storedCursor), this.storedStylesheet.remove()), this._storedOpacity && this.helper.css("opacity", this._storedOpacity), this._storedZIndex && this.helper.css("zIndex", "auto" === this._storedZIndex ? "" : this._storedZIndex), this.dragging = !1, this.cancelHelperRemoval) {
                if (!e) {
                    for (this._trigger("beforeStop", t, this._uiHash()), i = 0; o.length > i; i++) {
                        o[i].call(this, t);
                    }this._trigger("stop", t, this._uiHash());
                }return this.fromOutside = !1, !1;
            }if (e || this._trigger("beforeStop", t, this._uiHash()), this.placeholder[0].parentNode.removeChild(this.placeholder[0]), this.helper[0] !== this.currentItem[0] && this.helper.remove(), this.helper = null, !e) {
                for (i = 0; o.length > i; i++) {
                    o[i].call(this, t);
                }this._trigger("stop", t, this._uiHash());
            }return this.fromOutside = !1, !0;
        }, _trigger: function _trigger() {
            !1 === t.Widget.prototype._trigger.apply(this, arguments) && this.cancel();
        }, _uiHash: function _uiHash(e) {
            var n = e || this;return { helper: n.helper, placeholder: n.placeholder || t([]), position: n.position, originalPosition: n.originalPosition, offset: n.positionAbs, item: n.currentItem, sender: e ? e.element : null };
        } });
}(jQuery);var popupUrl = void 0,
    didPopupReload = !1;$(document).ready(function () {
    setupFormLoadingImage(), $("#popup").popup({ scrolllock: !0, blur: !0, transition: "all 0.3s" }), $(".sortable").sortable({ axis: "y" }), $(".dropdown").click(function () {
        $(this).next(".dropdown-container-inverse").toggle(), $(this).next(".dropdown-container").toggle();
    }), addListeners();
}), function (t) {
    t.fn.searcher = function (e, n) {
        var i = t.extend({ resultsDiv: "results", allDiv: "all", minChars: 3, onFound: null, updateAddressBar: !0 }, n),
            o = null;this.on("keyup", function () {
            clearTimeout(o);var n = t(this);o = setTimeout(function () {
                var o = n.val();o.length >= i.minChars ? (i.updateAddressBar && window.history.pushState("", "", "?search=" + o), t("#" + i.resultsDiv).show(), t("#" + i.allDiv).hide(), t("#" + i.resultsDiv).load(e + n.val().replace(new RegExp(" ", "g"), "%20"), i.onFound)) : (i.updateAddressBar && window.history.pushState("", "", "?"), t("#" + i.resultsDiv).hide(), t("#" + i.allDiv).show());
            }, 300);
        });
    };
}(jQuery), function (t) {
    "function" == typeof define && define.amd ? define(["jquery"], t) : "object" == ("undefined" == typeof module ? "undefined" : _typeof(module)) && module.exports ? module.exports = function (e, n) {
        return void 0 === n && (n = "undefined" != typeof window ? require("jquery") : require("jquery")(e)), t(n), n;
    } : t(jQuery);
}(function (t) {
    var e = function () {
        if (t && t.fn && t.fn.select2 && t.fn.select2.amd) var e = t.fn.select2.amd;var e;return function () {
            if (!e || !e.requirejs) {
                e ? n = e : e = {};var t, n, i;!function (e) {
                    function o(t, e) {
                        return _.call(t, e);
                    }function s(t, e) {
                        var n,
                            i,
                            o,
                            s,
                            r,
                            a,
                            l,
                            c,
                            u,
                            h,
                            p,
                            d,
                            f = e && e.split("/"),
                            g = b.map,
                            m = g && g["*"] || {};if (t) {
                            for (t = t.split("/"), r = t.length - 1, b.nodeIdCompat && C.test(t[r]) && (t[r] = t[r].replace(C, "")), "." === t[0].charAt(0) && f && (d = f.slice(0, f.length - 1), t = d.concat(t)), u = 0; u < t.length; u++) {
                                if ("." === (p = t[u])) t.splice(u, 1), u -= 1;else if (".." === p) {
                                    if (0 === u || 1 === u && ".." === t[2] || ".." === t[u - 1]) continue;u > 0 && (t.splice(u - 1, 2), u -= 2);
                                }
                            }t = t.join("/");
                        }if ((f || m) && g) {
                            for (n = t.split("/"), u = n.length; u > 0; u -= 1) {
                                if (i = n.slice(0, u).join("/"), f) for (h = f.length; h > 0; h -= 1) {
                                    if ((o = g[f.slice(0, h).join("/")]) && (o = o[i])) {
                                        s = o, a = u;break;
                                    }
                                }if (s) break;!l && m && m[i] && (l = m[i], c = u);
                            }!s && l && (s = l, a = c), s && (n.splice(0, a, s), t = n.join("/"));
                        }return t;
                    }function r(t, n) {
                        return function () {
                            var i = x.call(arguments, 0);return "string" != typeof i[0] && 1 === i.length && i.push(null), _f.apply(e, i.concat([t, n]));
                        };
                    }function a(t) {
                        return function (e) {
                            return s(e, t);
                        };
                    }function l(t) {
                        return function (e) {
                            v[t] = e;
                        };
                    }function c(t) {
                        if (o(y, t)) {
                            var n = y[t];delete y[t], w[t] = !0, d.apply(e, n);
                        }if (!o(v, t) && !o(w, t)) throw new Error("No " + t);return v[t];
                    }function u(t) {
                        var e,
                            n = t ? t.indexOf("!") : -1;return n > -1 && (e = t.substring(0, n), t = t.substring(n + 1, t.length)), [e, t];
                    }function h(t) {
                        return t ? u(t) : [];
                    }function p(t) {
                        return function () {
                            return b && b.config && b.config[t] || {};
                        };
                    }var d,
                        _f,
                        g,
                        m,
                        v = {},
                        y = {},
                        b = {},
                        w = {},
                        _ = Object.prototype.hasOwnProperty,
                        x = [].slice,
                        C = /\.js$/;g = function g(t, e) {
                        var n,
                            i = u(t),
                            o = i[0],
                            r = e[1];return t = i[1], o && (o = s(o, r), n = c(o)), o ? t = n && n.normalize ? n.normalize(t, a(r)) : s(t, r) : (t = s(t, r), i = u(t), o = i[0], t = i[1], o && (n = c(o))), { f: o ? o + "!" + t : t, n: t, pr: o, p: n };
                    }, m = { require: function require(t) {
                            return r(t);
                        }, exports: function exports(t) {
                            var e = v[t];return void 0 !== e ? e : v[t] = {};
                        }, module: function module(t) {
                            return { id: t, uri: "", exports: v[t], config: p(t) };
                        } }, d = function d(t, n, i, s) {
                        var a,
                            u,
                            p,
                            d,
                            f,
                            b,
                            _,
                            x = [],
                            C = void 0 === i ? "undefined" : _typeof(i);if (s = s || t, b = h(s), "undefined" === C || "function" === C) {
                            for (n = !n.length && i.length ? ["require", "exports", "module"] : n, f = 0; f < n.length; f += 1) {
                                if (d = g(n[f], b), "require" === (u = d.f)) x[f] = m.require(t);else if ("exports" === u) x[f] = m.exports(t), _ = !0;else if ("module" === u) a = x[f] = m.module(t);else if (o(v, u) || o(y, u) || o(w, u)) x[f] = c(u);else {
                                    if (!d.p) throw new Error(t + " missing " + u);d.p.load(d.n, r(s, !0), l(u), {}), x[f] = v[u];
                                }
                            }p = i ? i.apply(v[t], x) : void 0, t && (a && a.exports !== e && a.exports !== v[t] ? v[t] = a.exports : p === e && _ || (v[t] = p));
                        } else t && (v[t] = i);
                    }, t = n = _f = function f(t, n, i, o, s) {
                        if ("string" == typeof t) return m[t] ? m[t](n) : c(g(t, h(n)).f);if (!t.splice) {
                            if (b = t, b.deps && _f(b.deps, b.callback), !n) return;n.splice ? (t = n, n = i, i = null) : t = e;
                        }return n = n || function () {}, "function" == typeof i && (i = o, o = s), o ? d(e, t, n, i) : setTimeout(function () {
                            d(e, t, n, i);
                        }, 4), _f;
                    }, _f.config = function (t) {
                        return _f(t);
                    }, t._defined = v, i = function i(t, e, n) {
                        if ("string" != typeof t) throw new Error("See almond README: incorrect module build, no module name");e.splice || (n = e, e = []), o(v, t) || o(y, t) || (y[t] = [t, e, n]);
                    }, i.amd = { jQuery: !0 };
                }(), e.requirejs = t, e.require = n, e.define = i;
            }
        }(), e.define("almond", function () {}), e.define("jquery", [], function () {
            var e = t || $;return null == e && console && console.error && console.error("Select2: An instance of jQuery or a jQuery-compatible library was not found. Make sure that you are including jQuery before Select2 on your web page."), e;
        }), e.define("select2/utils", ["jquery"], function (t) {
            function e(t) {
                var e = t.prototype,
                    n = [];for (var i in e) {
                    "function" == typeof e[i] && "constructor" !== i && n.push(i);
                }return n;
            }var n = {};n.Extend = function (t, e) {
                function n() {
                    this.constructor = t;
                }var i = {}.hasOwnProperty;for (var o in e) {
                    i.call(e, o) && (t[o] = e[o]);
                }return n.prototype = e.prototype, t.prototype = new n(), t.__super__ = e.prototype, t;
            }, n.Decorate = function (t, n) {
                function i() {
                    var e = Array.prototype.unshift,
                        i = n.prototype.constructor.length,
                        o = t.prototype.constructor;i > 0 && (e.call(arguments, t.prototype.constructor), o = n.prototype.constructor), o.apply(this, arguments);
                }function o() {
                    this.constructor = i;
                }var s = e(n),
                    r = e(t);n.displayName = t.displayName, i.prototype = new o();for (var a = 0; a < r.length; a++) {
                    var l = r[a];i.prototype[l] = t.prototype[l];
                }for (var c = 0; c < s.length; c++) {
                    var u = s[c];i.prototype[u] = function (t) {
                        var e = function e() {};t in i.prototype && (e = i.prototype[t]);var o = n.prototype[t];return function () {
                            return Array.prototype.unshift.call(arguments, e), o.apply(this, arguments);
                        };
                    }(u);
                }return i;
            };var i = function i() {
                this.listeners = {};
            };i.prototype.on = function (t, e) {
                this.listeners = this.listeners || {}, t in this.listeners ? this.listeners[t].push(e) : this.listeners[t] = [e];
            }, i.prototype.trigger = function (t) {
                var e = Array.prototype.slice,
                    n = e.call(arguments, 1);this.listeners = this.listeners || {}, null == n && (n = []), 0 === n.length && n.push({}), n[0]._type = t, t in this.listeners && this.invoke(this.listeners[t], e.call(arguments, 1)), "*" in this.listeners && this.invoke(this.listeners["*"], arguments);
            }, i.prototype.invoke = function (t, e) {
                for (var n = 0, i = t.length; n < i; n++) {
                    t[n].apply(this, e);
                }
            }, n.Observable = i, n.generateChars = function (t) {
                for (var e = "", n = 0; n < t; n++) {
                    e += Math.floor(36 * Math.random()).toString(36);
                }return e;
            }, n.bind = function (t, e) {
                return function () {
                    t.apply(e, arguments);
                };
            }, n._convertData = function (t) {
                for (var e in t) {
                    var n = e.split("-"),
                        i = t;if (1 !== n.length) {
                        for (var o = 0; o < n.length; o++) {
                            var s = n[o];s = s.substring(0, 1).toLowerCase() + s.substring(1), s in i || (i[s] = {}), o == n.length - 1 && (i[s] = t[e]), i = i[s];
                        }delete t[e];
                    }
                }return t;
            }, n.hasScroll = function (e, n) {
                var i = t(n),
                    o = n.style.overflowX,
                    s = n.style.overflowY;return (o !== s || "hidden" !== s && "visible" !== s) && ("scroll" === o || "scroll" === s || i.innerHeight() < n.scrollHeight || i.innerWidth() < n.scrollWidth);
            }, n.escapeMarkup = function (t) {
                var e = { "\\": "&#92;", "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#39;", "/": "&#47;" };return "string" != typeof t ? t : String(t).replace(/[&<>"'\/\\]/g, function (t) {
                    return e[t];
                });
            }, n.appendMany = function (e, n) {
                if ("1.7" === t.fn.jquery.substr(0, 3)) {
                    var i = t();t.map(n, function (t) {
                        i = i.add(t);
                    }), n = i;
                }e.append(n);
            }, n.__cache = {};var o = 0;return n.GetUniqueElementId = function (t) {
                var e = t.getAttribute("data-select2-id");return null == e && (t.id ? (e = t.id, t.setAttribute("data-select2-id", e)) : (t.setAttribute("data-select2-id", ++o), e = o.toString())), e;
            }, n.StoreData = function (t, e, i) {
                var o = n.GetUniqueElementId(t);n.__cache[o] || (n.__cache[o] = {}), n.__cache[o][e] = i;
            }, n.GetData = function (e, i) {
                var o = n.GetUniqueElementId(e);return i ? n.__cache[o] && null != n.__cache[o][i] ? n.__cache[o][i] : t(e).data(i) : n.__cache[o];
            }, n.RemoveData = function (t) {
                var e = n.GetUniqueElementId(t);null != n.__cache[e] && delete n.__cache[e];
            }, n;
        }), e.define("select2/results", ["jquery", "./utils"], function (t, e) {
            function n(t, e, i) {
                this.$element = t, this.data = i, this.options = e, n.__super__.constructor.call(this);
            }return e.Extend(n, e.Observable), n.prototype.render = function () {
                var e = t('<ul class="select2-results__options" role="tree"></ul>');return this.options.get("multiple") && e.attr("aria-multiselectable", "true"), this.$results = e, e;
            }, n.prototype.clear = function () {
                this.$results.empty();
            }, n.prototype.displayMessage = function (e) {
                var n = this.options.get("escapeMarkup");this.clear(), this.hideLoading();var i = t('<li role="treeitem" aria-live="assertive" class="select2-results__option"></li>'),
                    o = this.options.get("translations").get(e.message);i.append(n(o(e.args))), i[0].className += " select2-results__message", this.$results.append(i);
            }, n.prototype.hideMessages = function () {
                this.$results.find(".select2-results__message").remove();
            }, n.prototype.append = function (t) {
                this.hideLoading();var e = [];if (null == t.results || 0 === t.results.length) return void (0 === this.$results.children().length && this.trigger("results:message", { message: "noResults" }));t.results = this.sort(t.results);for (var n = 0; n < t.results.length; n++) {
                    var i = t.results[n],
                        o = this.option(i);e.push(o);
                }this.$results.append(e);
            }, n.prototype.position = function (t, e) {
                e.find(".select2-results").append(t);
            }, n.prototype.sort = function (t) {
                return this.options.get("sorter")(t);
            }, n.prototype.highlightFirstItem = function () {
                var t = this.$results.find(".select2-results__option[aria-selected]"),
                    e = t.filter("[aria-selected=true]");e.length > 0 ? e.first().trigger("mouseenter") : t.first().trigger("mouseenter"), this.ensureHighlightVisible();
            }, n.prototype.setClasses = function () {
                var n = this;this.data.current(function (i) {
                    var o = t.map(i, function (t) {
                        return t.id.toString();
                    });n.$results.find(".select2-results__option[aria-selected]").each(function () {
                        var n = t(this),
                            i = e.GetData(this, "data"),
                            s = "" + i.id;null != i.element && i.element.selected || null == i.element && t.inArray(s, o) > -1 ? n.attr("aria-selected", "true") : n.attr("aria-selected", "false");
                    });
                });
            }, n.prototype.showLoading = function (t) {
                this.hideLoading();var e = this.options.get("translations").get("searching"),
                    n = { disabled: !0, loading: !0, text: e(t) },
                    i = this.option(n);i.className += " loading-results", this.$results.prepend(i);
            }, n.prototype.hideLoading = function () {
                this.$results.find(".loading-results").remove();
            }, n.prototype.option = function (n) {
                var i = document.createElement("li");i.className = "select2-results__option";var o = { role: "treeitem", "aria-selected": "false" };n.disabled && (delete o["aria-selected"], o["aria-disabled"] = "true"), null == n.id && delete o["aria-selected"], null != n._resultId && (i.id = n._resultId), n.title && (i.title = n.title), n.children && (o.role = "group", o["aria-label"] = n.text, delete o["aria-selected"]);for (var s in o) {
                    var r = o[s];i.setAttribute(s, r);
                }if (n.children) {
                    var a = t(i),
                        l = document.createElement("strong");l.className = "select2-results__group", t(l), this.template(n, l);for (var c = [], u = 0; u < n.children.length; u++) {
                        var h = n.children[u],
                            p = this.option(h);c.push(p);
                    }var d = t("<ul></ul>", { class: "select2-results__options select2-results__options--nested" });d.append(c), a.append(l), a.append(d);
                } else this.template(n, i);return e.StoreData(i, "data", n), i;
            }, n.prototype.bind = function (n, i) {
                var o = this,
                    s = n.id + "-results";this.$results.attr("id", s), n.on("results:all", function (t) {
                    o.clear(), o.append(t.data), n.isOpen() && (o.setClasses(), o.highlightFirstItem());
                }), n.on("results:append", function (t) {
                    o.append(t.data), n.isOpen() && o.setClasses();
                }), n.on("query", function (t) {
                    o.hideMessages(), o.showLoading(t);
                }), n.on("select", function () {
                    n.isOpen() && (o.setClasses(), o.highlightFirstItem());
                }), n.on("unselect", function () {
                    n.isOpen() && (o.setClasses(), o.highlightFirstItem());
                }), n.on("open", function () {
                    o.$results.attr("aria-expanded", "true"), o.$results.attr("aria-hidden", "false"), o.setClasses(), o.ensureHighlightVisible();
                }), n.on("close", function () {
                    o.$results.attr("aria-expanded", "false"), o.$results.attr("aria-hidden", "true"), o.$results.removeAttr("aria-activedescendant");
                }), n.on("results:toggle", function () {
                    var t = o.getHighlightedResults();0 !== t.length && t.trigger("mouseup");
                }), n.on("results:select", function () {
                    var t = o.getHighlightedResults();if (0 !== t.length) {
                        var n = e.GetData(t[0], "data");"true" == t.attr("aria-selected") ? o.trigger("close", {}) : o.trigger("select", { data: n });
                    }
                }), n.on("results:previous", function () {
                    var t = o.getHighlightedResults(),
                        e = o.$results.find("[aria-selected]"),
                        n = e.index(t);if (0 !== n) {
                        var i = n - 1;0 === t.length && (i = 0);var s = e.eq(i);s.trigger("mouseenter");var r = o.$results.offset().top,
                            a = s.offset().top,
                            l = o.$results.scrollTop() + (a - r);0 === i ? o.$results.scrollTop(0) : a - r < 0 && o.$results.scrollTop(l);
                    }
                }), n.on("results:next", function () {
                    var t = o.getHighlightedResults(),
                        e = o.$results.find("[aria-selected]"),
                        n = e.index(t),
                        i = n + 1;if (!(i >= e.length)) {
                        var s = e.eq(i);s.trigger("mouseenter");var r = o.$results.offset().top + o.$results.outerHeight(!1),
                            a = s.offset().top + s.outerHeight(!1),
                            l = o.$results.scrollTop() + a - r;0 === i ? o.$results.scrollTop(0) : a > r && o.$results.scrollTop(l);
                    }
                }), n.on("results:focus", function (t) {
                    t.element.addClass("select2-results__option--highlighted");
                }), n.on("results:message", function (t) {
                    o.displayMessage(t);
                }), t.fn.mousewheel && this.$results.on("mousewheel", function (t) {
                    var e = o.$results.scrollTop(),
                        n = o.$results.get(0).scrollHeight - e + t.deltaY,
                        i = t.deltaY > 0 && e - t.deltaY <= 0,
                        s = t.deltaY < 0 && n <= o.$results.height();i ? (o.$results.scrollTop(0), t.preventDefault(), t.stopPropagation()) : s && (o.$results.scrollTop(o.$results.get(0).scrollHeight - o.$results.height()), t.preventDefault(), t.stopPropagation());
                }), this.$results.on("mouseup", ".select2-results__option[aria-selected]", function (n) {
                    var i = t(this),
                        s = e.GetData(this, "data");if ("true" === i.attr("aria-selected")) return void (o.options.get("multiple") ? o.trigger("unselect", { originalEvent: n, data: s }) : o.trigger("close", {}));o.trigger("select", { originalEvent: n, data: s });
                }), this.$results.on("mouseenter", ".select2-results__option[aria-selected]", function (n) {
                    var i = e.GetData(this, "data");o.getHighlightedResults().removeClass("select2-results__option--highlighted"), o.trigger("results:focus", { data: i, element: t(this) });
                });
            }, n.prototype.getHighlightedResults = function () {
                return this.$results.find(".select2-results__option--highlighted");
            }, n.prototype.destroy = function () {
                this.$results.remove();
            }, n.prototype.ensureHighlightVisible = function () {
                var t = this.getHighlightedResults();if (0 !== t.length) {
                    var e = this.$results.find("[aria-selected]"),
                        n = e.index(t),
                        i = this.$results.offset().top,
                        o = t.offset().top,
                        s = this.$results.scrollTop() + (o - i),
                        r = o - i;s -= 2 * t.outerHeight(!1), n <= 2 ? this.$results.scrollTop(0) : (r > this.$results.outerHeight() || r < 0) && this.$results.scrollTop(s);
                }
            }, n.prototype.template = function (e, n) {
                var i = this.options.get("templateResult"),
                    o = this.options.get("escapeMarkup"),
                    s = i(e, n);null == s ? n.style.display = "none" : "string" == typeof s ? n.innerHTML = o(s) : t(n).append(s);
            }, n;
        }), e.define("select2/keys", [], function () {
            return { BACKSPACE: 8, TAB: 9, ENTER: 13, SHIFT: 16, CTRL: 17, ALT: 18, ESC: 27, SPACE: 32, PAGE_UP: 33, PAGE_DOWN: 34, END: 35, HOME: 36, LEFT: 37, UP: 38, RIGHT: 39, DOWN: 40, DELETE: 46 };
        }), e.define("select2/selection/base", ["jquery", "../utils", "../keys"], function (t, e, n) {
            function i(t, e) {
                this.$element = t, this.options = e, i.__super__.constructor.call(this);
            }return e.Extend(i, e.Observable), i.prototype.render = function () {
                var n = t('<span class="select2-selection" role="combobox"  aria-haspopup="true" aria-expanded="false"></span>');return this._tabindex = 0, null != e.GetData(this.$element[0], "old-tabindex") ? this._tabindex = e.GetData(this.$element[0], "old-tabindex") : null != this.$element.attr("tabindex") && (this._tabindex = this.$element.attr("tabindex")), n.attr("title", this.$element.attr("title")), n.attr("tabindex", this._tabindex), this.$selection = n, n;
            }, i.prototype.bind = function (t, e) {
                var i = this,
                    o = (t.id, t.id + "-results");this.container = t, this.$selection.on("focus", function (t) {
                    i.trigger("focus", t);
                }), this.$selection.on("blur", function (t) {
                    i._handleBlur(t);
                }), this.$selection.on("keydown", function (t) {
                    i.trigger("keypress", t), t.which === n.SPACE && t.preventDefault();
                }), t.on("results:focus", function (t) {
                    i.$selection.attr("aria-activedescendant", t.data._resultId);
                }), t.on("selection:update", function (t) {
                    i.update(t.data);
                }), t.on("open", function () {
                    i.$selection.attr("aria-expanded", "true"), i.$selection.attr("aria-owns", o), i._attachCloseHandler(t);
                }), t.on("close", function () {
                    i.$selection.attr("aria-expanded", "false"), i.$selection.removeAttr("aria-activedescendant"), i.$selection.removeAttr("aria-owns"), i.$selection.focus(), i._detachCloseHandler(t);
                }), t.on("enable", function () {
                    i.$selection.attr("tabindex", i._tabindex);
                }), t.on("disable", function () {
                    i.$selection.attr("tabindex", "-1");
                });
            }, i.prototype._handleBlur = function (e) {
                var n = this;window.setTimeout(function () {
                    document.activeElement == n.$selection[0] || t.contains(n.$selection[0], document.activeElement) || n.trigger("blur", e);
                }, 1);
            }, i.prototype._attachCloseHandler = function (n) {
                t(document.body).on("mousedown.select2." + n.id, function (n) {
                    var i = t(n.target),
                        o = i.closest(".select2");t(".select2.select2-container--open").each(function () {
                        t(this), this != o[0] && e.GetData(this, "element").select2("close");
                    });
                });
            }, i.prototype._detachCloseHandler = function (e) {
                t(document.body).off("mousedown.select2." + e.id);
            }, i.prototype.position = function (t, e) {
                e.find(".selection").append(t);
            }, i.prototype.destroy = function () {
                this._detachCloseHandler(this.container);
            }, i.prototype.update = function (t) {
                throw new Error("The `update` method must be defined in child classes.");
            }, i;
        }), e.define("select2/selection/single", ["jquery", "./base", "../utils", "../keys"], function (t, e, n, i) {
            function o() {
                o.__super__.constructor.apply(this, arguments);
            }return n.Extend(o, e), o.prototype.render = function () {
                var t = o.__super__.render.call(this);return t.addClass("select2-selection--single"), t.html('<span class="select2-selection__rendered"></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span>'), t;
            }, o.prototype.bind = function (t, e) {
                var n = this;o.__super__.bind.apply(this, arguments);var i = t.id + "-container";this.$selection.find(".select2-selection__rendered").attr("id", i).attr("role", "textbox").attr("aria-readonly", "true"), this.$selection.attr("aria-labelledby", i), this.$selection.on("mousedown", function (t) {
                    1 === t.which && n.trigger("toggle", { originalEvent: t });
                }), this.$selection.on("focus", function (t) {}), this.$selection.on("blur", function (t) {}), t.on("focus", function (e) {
                    t.isOpen() || n.$selection.focus();
                });
            }, o.prototype.clear = function () {
                var t = this.$selection.find(".select2-selection__rendered");t.empty(), t.removeAttr("title");
            }, o.prototype.display = function (t, e) {
                var n = this.options.get("templateSelection");return this.options.get("escapeMarkup")(n(t, e));
            }, o.prototype.selectionContainer = function () {
                return t("<span></span>");
            }, o.prototype.update = function (t) {
                if (0 === t.length) return void this.clear();var e = t[0],
                    n = this.$selection.find(".select2-selection__rendered"),
                    i = this.display(e, n);n.empty().append(i), n.attr("title", e.title || e.text);
            }, o;
        }), e.define("select2/selection/multiple", ["jquery", "./base", "../utils"], function (t, e, n) {
            function i(t, e) {
                i.__super__.constructor.apply(this, arguments);
            }return n.Extend(i, e), i.prototype.render = function () {
                var t = i.__super__.render.call(this);return t.addClass("select2-selection--multiple"), t.html('<ul class="select2-selection__rendered"></ul>'), t;
            }, i.prototype.bind = function (e, o) {
                var s = this;i.__super__.bind.apply(this, arguments), this.$selection.on("click", function (t) {
                    s.trigger("toggle", { originalEvent: t });
                }), this.$selection.on("click", ".select2-selection__choice__remove", function (e) {
                    if (!s.options.get("disabled")) {
                        var i = t(this),
                            o = i.parent(),
                            r = n.GetData(o[0], "data");s.trigger("unselect", { originalEvent: e, data: r });
                    }
                });
            }, i.prototype.clear = function () {
                var t = this.$selection.find(".select2-selection__rendered");t.empty(), t.removeAttr("title");
            }, i.prototype.display = function (t, e) {
                var n = this.options.get("templateSelection");return this.options.get("escapeMarkup")(n(t, e));
            }, i.prototype.selectionContainer = function () {
                return t('<li class="select2-selection__choice"><span class="select2-selection__choice__remove" role="presentation">&times;</span></li>');
            }, i.prototype.update = function (t) {
                if (this.clear(), 0 !== t.length) {
                    for (var e = [], i = 0; i < t.length; i++) {
                        var o = t[i],
                            s = this.selectionContainer(),
                            r = this.display(o, s);s.append(r), s.attr("title", o.title || o.text), n.StoreData(s[0], "data", o), e.push(s);
                    }var a = this.$selection.find(".select2-selection__rendered");n.appendMany(a, e);
                }
            }, i;
        }), e.define("select2/selection/placeholder", ["../utils"], function (t) {
            function e(t, e, n) {
                this.placeholder = this.normalizePlaceholder(n.get("placeholder")), t.call(this, e, n);
            }return e.prototype.normalizePlaceholder = function (t, e) {
                return "string" == typeof e && (e = { id: "", text: e }), e;
            }, e.prototype.createPlaceholder = function (t, e) {
                var n = this.selectionContainer();return n.html(this.display(e)), n.addClass("select2-selection__placeholder").removeClass("select2-selection__choice"), n;
            }, e.prototype.update = function (t, e) {
                var n = 1 == e.length && e[0].id != this.placeholder.id;if (e.length > 1 || n) return t.call(this, e);this.clear();var i = this.createPlaceholder(this.placeholder);this.$selection.find(".select2-selection__rendered").append(i);
            }, e;
        }), e.define("select2/selection/allowClear", ["jquery", "../keys", "../utils"], function (t, e, n) {
            function i() {}return i.prototype.bind = function (t, e, n) {
                var i = this;t.call(this, e, n), null == this.placeholder && this.options.get("debug") && window.console && console.error && console.error("Select2: The `allowClear` option should be used in combination with the `placeholder` option."), this.$selection.on("mousedown", ".select2-selection__clear", function (t) {
                    i._handleClear(t);
                }), e.on("keypress", function (t) {
                    i._handleKeyboardClear(t, e);
                });
            }, i.prototype._handleClear = function (t, e) {
                if (!this.options.get("disabled")) {
                    var i = this.$selection.find(".select2-selection__clear");if (0 !== i.length) {
                        e.stopPropagation();var o = n.GetData(i[0], "data"),
                            s = this.$element.val();this.$element.val(this.placeholder.id);var r = { data: o };if (this.trigger("clear", r), r.prevented) return void this.$element.val(s);for (var a = 0; a < o.length; a++) {
                            if (r = { data: o[a] }, this.trigger("unselect", r), r.prevented) return void this.$element.val(s);
                        }this.$element.trigger("change"), this.trigger("toggle", {});
                    }
                }
            }, i.prototype._handleKeyboardClear = function (t, n, i) {
                i.isOpen() || n.which != e.DELETE && n.which != e.BACKSPACE || this._handleClear(n);
            }, i.prototype.update = function (e, i) {
                if (e.call(this, i), !(this.$selection.find(".select2-selection__placeholder").length > 0 || 0 === i.length)) {
                    var o = t('<span class="select2-selection__clear">&times;</span>');n.StoreData(o[0], "data", i), this.$selection.find(".select2-selection__rendered").prepend(o);
                }
            }, i;
        }), e.define("select2/selection/search", ["jquery", "../utils", "../keys"], function (t, e, n) {
            function i(t, e, n) {
                t.call(this, e, n);
            }return i.prototype.render = function (e) {
                var n = t('<li class="select2-search select2-search--inline"><input class="select2-search__field" type="search" tabindex="-1" autocomplete="off" autocorrect="off" autocapitalize="none" spellcheck="false" role="textbox" aria-autocomplete="list" /></li>');this.$searchContainer = n, this.$search = n.find("input");var i = e.call(this);return this._transferTabIndex(), i;
            }, i.prototype.bind = function (t, i, o) {
                var s = this;t.call(this, i, o), i.on("open", function () {
                    s.$search.trigger("focus");
                }), i.on("close", function () {
                    s.$search.val(""), s.$search.removeAttr("aria-activedescendant"), s.$search.trigger("focus");
                }), i.on("enable", function () {
                    s.$search.prop("disabled", !1), s._transferTabIndex();
                }), i.on("disable", function () {
                    s.$search.prop("disabled", !0);
                }), i.on("focus", function (t) {
                    s.$search.trigger("focus");
                }), i.on("results:focus", function (t) {
                    s.$search.attr("aria-activedescendant", t.id);
                }), this.$selection.on("focusin", ".select2-search--inline", function (t) {
                    s.trigger("focus", t);
                }), this.$selection.on("focusout", ".select2-search--inline", function (t) {
                    s._handleBlur(t);
                }), this.$selection.on("keydown", ".select2-search--inline", function (t) {
                    if (t.stopPropagation(), s.trigger("keypress", t), s._keyUpPrevented = t.isDefaultPrevented(), t.which === n.BACKSPACE && "" === s.$search.val()) {
                        var i = s.$searchContainer.prev(".select2-selection__choice");if (i.length > 0) {
                            var o = e.GetData(i[0], "data");s.searchRemoveChoice(o), t.preventDefault();
                        }
                    }
                });var r = document.documentMode,
                    a = r && r <= 11;this.$selection.on("input.searchcheck", ".select2-search--inline", function (t) {
                    if (a) return void s.$selection.off("input.search input.searchcheck");s.$selection.off("keyup.search");
                }), this.$selection.on("keyup.search input.search", ".select2-search--inline", function (t) {
                    if (a && "input" === t.type) return void s.$selection.off("input.search input.searchcheck");var e = t.which;e != n.SHIFT && e != n.CTRL && e != n.ALT && e != n.TAB && s.handleSearch(t);
                });
            }, i.prototype._transferTabIndex = function (t) {
                this.$search.attr("tabindex", this.$selection.attr("tabindex")), this.$selection.attr("tabindex", "-1");
            }, i.prototype.createPlaceholder = function (t, e) {
                this.$search.attr("placeholder", e.text);
            }, i.prototype.update = function (t, e) {
                var n = this.$search[0] == document.activeElement;this.$search.attr("placeholder", ""), t.call(this, e), this.$selection.find(".select2-selection__rendered").append(this.$searchContainer), this.resizeSearch(), n && this.$search.focus();
            }, i.prototype.handleSearch = function () {
                if (this.resizeSearch(), !this._keyUpPrevented) {
                    var t = this.$search.val();this.trigger("query", { term: t });
                }this._keyUpPrevented = !1;
            }, i.prototype.searchRemoveChoice = function (t, e) {
                this.trigger("unselect", { data: e }), this.$search.val(e.text), this.handleSearch();
            }, i.prototype.resizeSearch = function () {
                this.$search.css("width", "25px");var t = "";t = "" !== this.$search.attr("placeholder") ? this.$selection.find(".select2-selection__rendered").innerWidth() : .75 * (this.$search.val().length + 1) + "em", this.$search.css("width", t);
            }, i;
        }), e.define("select2/selection/eventRelay", ["jquery"], function (t) {
            function e() {}return e.prototype.bind = function (e, n, i) {
                var o = this,
                    s = ["open", "opening", "close", "closing", "select", "selecting", "unselect", "unselecting", "clear", "clearing"],
                    r = ["opening", "closing", "selecting", "unselecting", "clearing"];e.call(this, n, i), n.on("*", function (e, n) {
                    if (-1 !== t.inArray(e, s)) {
                        n = n || {};var i = t.Event("select2:" + e, { params: n });o.$element.trigger(i), -1 !== t.inArray(e, r) && (n.prevented = i.isDefaultPrevented());
                    }
                });
            }, e;
        }), e.define("select2/translation", ["jquery", "require"], function (t, e) {
            function n(t) {
                this.dict = t || {};
            }return n.prototype.all = function () {
                return this.dict;
            }, n.prototype.get = function (t) {
                return this.dict[t];
            }, n.prototype.extend = function (e) {
                this.dict = t.extend({}, e.all(), this.dict);
            }, n._cache = {}, n.loadPath = function (t) {
                if (!(t in n._cache)) {
                    var i = e(t);n._cache[t] = i;
                }return new n(n._cache[t]);
            }, n;
        }), e.define("select2/diacritics", [], function () {
            return { "Ⓐ": "A", "Ａ": "A", "À": "A", "Á": "A", "Â": "A", "Ầ": "A", "Ấ": "A", "Ẫ": "A", "Ẩ": "A", "Ã": "A", "Ā": "A", "Ă": "A", "Ằ": "A", "Ắ": "A", "Ẵ": "A", "Ẳ": "A", "Ȧ": "A", "Ǡ": "A", "Ä": "A", "Ǟ": "A", "Ả": "A", "Å": "A", "Ǻ": "A", "Ǎ": "A", "Ȁ": "A", "Ȃ": "A", "Ạ": "A", "Ậ": "A", "Ặ": "A", "Ḁ": "A", "Ą": "A", "Ⱥ": "A", "Ɐ": "A", "Ꜳ": "AA", "Æ": "AE", "Ǽ": "AE", "Ǣ": "AE", "Ꜵ": "AO", "Ꜷ": "AU", "Ꜹ": "AV", "Ꜻ": "AV", "Ꜽ": "AY", "Ⓑ": "B", "Ｂ": "B", "Ḃ": "B", "Ḅ": "B", "Ḇ": "B", "Ƀ": "B", "Ƃ": "B", "Ɓ": "B", "Ⓒ": "C", "Ｃ": "C", "Ć": "C", "Ĉ": "C", "Ċ": "C", "Č": "C", "Ç": "C", "Ḉ": "C", "Ƈ": "C", "Ȼ": "C", "Ꜿ": "C", "Ⓓ": "D", "Ｄ": "D", "Ḋ": "D", "Ď": "D", "Ḍ": "D", "Ḑ": "D", "Ḓ": "D", "Ḏ": "D", "Đ": "D", "Ƌ": "D", "Ɗ": "D", "Ɖ": "D", "Ꝺ": "D", "Ǳ": "DZ", "Ǆ": "DZ", "ǲ": "Dz", "ǅ": "Dz", "Ⓔ": "E", "Ｅ": "E", "È": "E", "É": "E", "Ê": "E", "Ề": "E", "Ế": "E", "Ễ": "E", "Ể": "E", "Ẽ": "E", "Ē": "E", "Ḕ": "E", "Ḗ": "E", "Ĕ": "E", "Ė": "E", "Ë": "E", "Ẻ": "E", "Ě": "E", "Ȅ": "E", "Ȇ": "E", "Ẹ": "E", "Ệ": "E", "Ȩ": "E", "Ḝ": "E", "Ę": "E", "Ḙ": "E", "Ḛ": "E", "Ɛ": "E", "Ǝ": "E", "Ⓕ": "F", "Ｆ": "F", "Ḟ": "F", "Ƒ": "F", "Ꝼ": "F", "Ⓖ": "G", "Ｇ": "G", "Ǵ": "G", "Ĝ": "G", "Ḡ": "G", "Ğ": "G", "Ġ": "G", "Ǧ": "G", "Ģ": "G", "Ǥ": "G", "Ɠ": "G", "Ꞡ": "G", "Ᵹ": "G", "Ꝿ": "G", "Ⓗ": "H", "Ｈ": "H", "Ĥ": "H", "Ḣ": "H", "Ḧ": "H", "Ȟ": "H", "Ḥ": "H", "Ḩ": "H", "Ḫ": "H", "Ħ": "H", "Ⱨ": "H", "Ⱶ": "H", "Ɥ": "H", "Ⓘ": "I", "Ｉ": "I", "Ì": "I", "Í": "I", "Î": "I", "Ĩ": "I", "Ī": "I", "Ĭ": "I", "İ": "I", "Ï": "I", "Ḯ": "I", "Ỉ": "I", "Ǐ": "I", "Ȉ": "I", "Ȋ": "I", "Ị": "I", "Į": "I", "Ḭ": "I", "Ɨ": "I", "Ⓙ": "J", "Ｊ": "J", "Ĵ": "J", "Ɉ": "J", "Ⓚ": "K", "Ｋ": "K", "Ḱ": "K", "Ǩ": "K", "Ḳ": "K", "Ķ": "K", "Ḵ": "K", "Ƙ": "K", "Ⱪ": "K", "Ꝁ": "K", "Ꝃ": "K", "Ꝅ": "K", "Ꞣ": "K", "Ⓛ": "L", "Ｌ": "L", "Ŀ": "L", "Ĺ": "L", "Ľ": "L", "Ḷ": "L", "Ḹ": "L", "Ļ": "L", "Ḽ": "L", "Ḻ": "L", "Ł": "L", "Ƚ": "L", "Ɫ": "L", "Ⱡ": "L", "Ꝉ": "L", "Ꝇ": "L", "Ꞁ": "L", "Ǉ": "LJ", "ǈ": "Lj", "Ⓜ": "M", "Ｍ": "M", "Ḿ": "M", "Ṁ": "M", "Ṃ": "M", "Ɱ": "M", "Ɯ": "M", "Ⓝ": "N", "Ｎ": "N", "Ǹ": "N", "Ń": "N", "Ñ": "N", "Ṅ": "N", "Ň": "N", "Ṇ": "N", "Ņ": "N", "Ṋ": "N", "Ṉ": "N", "Ƞ": "N", "Ɲ": "N", "Ꞑ": "N", "Ꞥ": "N", "Ǌ": "NJ", "ǋ": "Nj", "Ⓞ": "O", "Ｏ": "O", "Ò": "O", "Ó": "O", "Ô": "O", "Ồ": "O", "Ố": "O", "Ỗ": "O", "Ổ": "O", "Õ": "O", "Ṍ": "O", "Ȭ": "O", "Ṏ": "O", "Ō": "O", "Ṑ": "O", "Ṓ": "O", "Ŏ": "O", "Ȯ": "O", "Ȱ": "O", "Ö": "O", "Ȫ": "O", "Ỏ": "O", "Ő": "O", "Ǒ": "O", "Ȍ": "O", "Ȏ": "O", "Ơ": "O", "Ờ": "O", "Ớ": "O", "Ỡ": "O", "Ở": "O", "Ợ": "O", "Ọ": "O", "Ộ": "O", "Ǫ": "O", "Ǭ": "O", "Ø": "O", "Ǿ": "O", "Ɔ": "O", "Ɵ": "O", "Ꝋ": "O", "Ꝍ": "O", "Ƣ": "OI", "Ꝏ": "OO", "Ȣ": "OU", "Ⓟ": "P", "Ｐ": "P", "Ṕ": "P", "Ṗ": "P", "Ƥ": "P", "Ᵽ": "P", "Ꝑ": "P", "Ꝓ": "P", "Ꝕ": "P", "Ⓠ": "Q", "Ｑ": "Q", "Ꝗ": "Q", "Ꝙ": "Q", "Ɋ": "Q", "Ⓡ": "R", "Ｒ": "R", "Ŕ": "R", "Ṙ": "R", "Ř": "R", "Ȑ": "R", "Ȓ": "R", "Ṛ": "R", "Ṝ": "R", "Ŗ": "R", "Ṟ": "R", "Ɍ": "R", "Ɽ": "R", "Ꝛ": "R", "Ꞧ": "R", "Ꞃ": "R", "Ⓢ": "S", "Ｓ": "S", "ẞ": "S", "Ś": "S", "Ṥ": "S", "Ŝ": "S", "Ṡ": "S", "Š": "S", "Ṧ": "S", "Ṣ": "S", "Ṩ": "S", "Ș": "S", "Ş": "S", "Ȿ": "S", "Ꞩ": "S", "Ꞅ": "S", "Ⓣ": "T", "Ｔ": "T", "Ṫ": "T", "Ť": "T", "Ṭ": "T", "Ț": "T", "Ţ": "T", "Ṱ": "T", "Ṯ": "T", "Ŧ": "T", "Ƭ": "T", "Ʈ": "T", "Ⱦ": "T", "Ꞇ": "T", "Ꜩ": "TZ", "Ⓤ": "U", "Ｕ": "U", "Ù": "U", "Ú": "U", "Û": "U", "Ũ": "U", "Ṹ": "U", "Ū": "U", "Ṻ": "U", "Ŭ": "U", "Ü": "U", "Ǜ": "U", "Ǘ": "U", "Ǖ": "U", "Ǚ": "U", "Ủ": "U", "Ů": "U", "Ű": "U", "Ǔ": "U", "Ȕ": "U", "Ȗ": "U", "Ư": "U", "Ừ": "U", "Ứ": "U", "Ữ": "U", "Ử": "U", "Ự": "U", "Ụ": "U", "Ṳ": "U", "Ų": "U", "Ṷ": "U", "Ṵ": "U", "Ʉ": "U", "Ⓥ": "V", "Ｖ": "V", "Ṽ": "V", "Ṿ": "V", "Ʋ": "V", "Ꝟ": "V", "Ʌ": "V", "Ꝡ": "VY", "Ⓦ": "W", "Ｗ": "W", "Ẁ": "W", "Ẃ": "W", "Ŵ": "W", "Ẇ": "W", "Ẅ": "W", "Ẉ": "W", "Ⱳ": "W", "Ⓧ": "X", "Ｘ": "X", "Ẋ": "X", "Ẍ": "X", "Ⓨ": "Y", "Ｙ": "Y", "Ỳ": "Y", "Ý": "Y", "Ŷ": "Y", "Ỹ": "Y", "Ȳ": "Y", "Ẏ": "Y", "Ÿ": "Y", "Ỷ": "Y", "Ỵ": "Y", "Ƴ": "Y", "Ɏ": "Y", "Ỿ": "Y", "Ⓩ": "Z", "Ｚ": "Z", "Ź": "Z", "Ẑ": "Z", "Ż": "Z", "Ž": "Z", "Ẓ": "Z", "Ẕ": "Z", "Ƶ": "Z", "Ȥ": "Z", "Ɀ": "Z", "Ⱬ": "Z", "Ꝣ": "Z", "ⓐ": "a", "ａ": "a", "ẚ": "a", "à": "a", "á": "a", "â": "a", "ầ": "a", "ấ": "a", "ẫ": "a", "ẩ": "a", "ã": "a", "ā": "a", "ă": "a", "ằ": "a", "ắ": "a", "ẵ": "a", "ẳ": "a", "ȧ": "a", "ǡ": "a", "ä": "a", "ǟ": "a", "ả": "a", "å": "a", "ǻ": "a", "ǎ": "a", "ȁ": "a", "ȃ": "a", "ạ": "a", "ậ": "a", "ặ": "a", "ḁ": "a", "ą": "a", "ⱥ": "a", "ɐ": "a", "ꜳ": "aa", "æ": "ae", "ǽ": "ae", "ǣ": "ae", "ꜵ": "ao", "ꜷ": "au", "ꜹ": "av", "ꜻ": "av", "ꜽ": "ay", "ⓑ": "b", "ｂ": "b", "ḃ": "b", "ḅ": "b", "ḇ": "b", "ƀ": "b", "ƃ": "b", "ɓ": "b", "ⓒ": "c", "ｃ": "c", "ć": "c", "ĉ": "c", "ċ": "c", "č": "c", "ç": "c", "ḉ": "c", "ƈ": "c", "ȼ": "c", "ꜿ": "c", "ↄ": "c", "ⓓ": "d", "ｄ": "d", "ḋ": "d", "ď": "d", "ḍ": "d", "ḑ": "d", "ḓ": "d", "ḏ": "d", "đ": "d", "ƌ": "d", "ɖ": "d", "ɗ": "d", "ꝺ": "d", "ǳ": "dz", "ǆ": "dz", "ⓔ": "e", "ｅ": "e", "è": "e", "é": "e", "ê": "e", "ề": "e", "ế": "e", "ễ": "e", "ể": "e", "ẽ": "e", "ē": "e", "ḕ": "e", "ḗ": "e", "ĕ": "e", "ė": "e", "ë": "e", "ẻ": "e", "ě": "e", "ȅ": "e", "ȇ": "e", "ẹ": "e", "ệ": "e", "ȩ": "e", "ḝ": "e", "ę": "e", "ḙ": "e", "ḛ": "e", "ɇ": "e", "ɛ": "e", "ǝ": "e", "ⓕ": "f", "ｆ": "f", "ḟ": "f", "ƒ": "f", "ꝼ": "f", "ⓖ": "g", "ｇ": "g", "ǵ": "g", "ĝ": "g", "ḡ": "g", "ğ": "g", "ġ": "g", "ǧ": "g", "ģ": "g", "ǥ": "g", "ɠ": "g", "ꞡ": "g", "ᵹ": "g", "ꝿ": "g", "ⓗ": "h", "ｈ": "h", "ĥ": "h", "ḣ": "h", "ḧ": "h", "ȟ": "h", "ḥ": "h", "ḩ": "h", "ḫ": "h", "ẖ": "h", "ħ": "h", "ⱨ": "h", "ⱶ": "h", "ɥ": "h", "ƕ": "hv", "ⓘ": "i", "ｉ": "i", "ì": "i", "í": "i", "î": "i", "ĩ": "i", "ī": "i", "ĭ": "i", "ï": "i", "ḯ": "i", "ỉ": "i", "ǐ": "i", "ȉ": "i", "ȋ": "i", "ị": "i", "į": "i", "ḭ": "i", "ɨ": "i", "ı": "i", "ⓙ": "j", "ｊ": "j", "ĵ": "j", "ǰ": "j", "ɉ": "j", "ⓚ": "k", "ｋ": "k", "ḱ": "k", "ǩ": "k", "ḳ": "k", "ķ": "k", "ḵ": "k", "ƙ": "k", "ⱪ": "k", "ꝁ": "k", "ꝃ": "k", "ꝅ": "k", "ꞣ": "k", "ⓛ": "l", "ｌ": "l", "ŀ": "l", "ĺ": "l", "ľ": "l", "ḷ": "l", "ḹ": "l", "ļ": "l", "ḽ": "l", "ḻ": "l", "ſ": "l", "ł": "l", "ƚ": "l", "ɫ": "l", "ⱡ": "l", "ꝉ": "l", "ꞁ": "l", "ꝇ": "l", "ǉ": "lj", "ⓜ": "m", "ｍ": "m", "ḿ": "m", "ṁ": "m", "ṃ": "m", "ɱ": "m", "ɯ": "m", "ⓝ": "n", "ｎ": "n", "ǹ": "n", "ń": "n", "ñ": "n", "ṅ": "n", "ň": "n", "ṇ": "n", "ņ": "n", "ṋ": "n", "ṉ": "n", "ƞ": "n", "ɲ": "n", "ŉ": "n", "ꞑ": "n", "ꞥ": "n", "ǌ": "nj", "ⓞ": "o", "ｏ": "o", "ò": "o", "ó": "o", "ô": "o", "ồ": "o", "ố": "o", "ỗ": "o", "ổ": "o", "õ": "o", "ṍ": "o", "ȭ": "o", "ṏ": "o", "ō": "o", "ṑ": "o", "ṓ": "o", "ŏ": "o", "ȯ": "o", "ȱ": "o", "ö": "o", "ȫ": "o", "ỏ": "o", "ő": "o", "ǒ": "o", "ȍ": "o", "ȏ": "o", "ơ": "o", "ờ": "o", "ớ": "o", "ỡ": "o", "ở": "o", "ợ": "o", "ọ": "o", "ộ": "o", "ǫ": "o", "ǭ": "o", "ø": "o", "ǿ": "o", "ɔ": "o", "ꝋ": "o", "ꝍ": "o", "ɵ": "o", "ƣ": "oi", "ȣ": "ou", "ꝏ": "oo", "ⓟ": "p", "ｐ": "p", "ṕ": "p", "ṗ": "p", "ƥ": "p", "ᵽ": "p", "ꝑ": "p", "ꝓ": "p", "ꝕ": "p", "ⓠ": "q", "ｑ": "q", "ɋ": "q", "ꝗ": "q", "ꝙ": "q", "ⓡ": "r", "ｒ": "r", "ŕ": "r", "ṙ": "r", "ř": "r", "ȑ": "r", "ȓ": "r", "ṛ": "r", "ṝ": "r", "ŗ": "r", "ṟ": "r", "ɍ": "r", "ɽ": "r", "ꝛ": "r", "ꞧ": "r", "ꞃ": "r", "ⓢ": "s", "ｓ": "s", "ß": "s", "ś": "s", "ṥ": "s", "ŝ": "s", "ṡ": "s", "š": "s", "ṧ": "s", "ṣ": "s", "ṩ": "s", "ș": "s", "ş": "s", "ȿ": "s", "ꞩ": "s", "ꞅ": "s", "ẛ": "s", "ⓣ": "t", "ｔ": "t", "ṫ": "t", "ẗ": "t", "ť": "t", "ṭ": "t", "ț": "t", "ţ": "t", "ṱ": "t", "ṯ": "t", "ŧ": "t", "ƭ": "t", "ʈ": "t", "ⱦ": "t", "ꞇ": "t", "ꜩ": "tz", "ⓤ": "u", "ｕ": "u", "ù": "u", "ú": "u", "û": "u", "ũ": "u", "ṹ": "u", "ū": "u", "ṻ": "u", "ŭ": "u", "ü": "u", "ǜ": "u", "ǘ": "u", "ǖ": "u", "ǚ": "u", "ủ": "u", "ů": "u", "ű": "u", "ǔ": "u", "ȕ": "u", "ȗ": "u", "ư": "u", "ừ": "u", "ứ": "u", "ữ": "u", "ử": "u", "ự": "u", "ụ": "u", "ṳ": "u", "ų": "u", "ṷ": "u", "ṵ": "u", "ʉ": "u", "ⓥ": "v", "ｖ": "v", "ṽ": "v", "ṿ": "v", "ʋ": "v", "ꝟ": "v", "ʌ": "v", "ꝡ": "vy", "ⓦ": "w", "ｗ": "w", "ẁ": "w", "ẃ": "w", "ŵ": "w", "ẇ": "w", "ẅ": "w", "ẘ": "w", "ẉ": "w", "ⱳ": "w", "ⓧ": "x", "ｘ": "x", "ẋ": "x", "ẍ": "x", "ⓨ": "y", "ｙ": "y", "ỳ": "y", "ý": "y", "ŷ": "y", "ỹ": "y", "ȳ": "y", "ẏ": "y", "ÿ": "y", "ỷ": "y", "ẙ": "y", "ỵ": "y", "ƴ": "y", "ɏ": "y", "ỿ": "y", "ⓩ": "z", "ｚ": "z", "ź": "z", "ẑ": "z", "ż": "z", "ž": "z", "ẓ": "z", "ẕ": "z", "ƶ": "z", "ȥ": "z", "ɀ": "z", "ⱬ": "z", "ꝣ": "z", "Ά": "Α", "Έ": "Ε", "Ή": "Η", "Ί": "Ι", "Ϊ": "Ι", "Ό": "Ο", "Ύ": "Υ", "Ϋ": "Υ", "Ώ": "Ω", "ά": "α", "έ": "ε", "ή": "η", "ί": "ι", "ϊ": "ι", "ΐ": "ι", "ό": "ο", "ύ": "υ", "ϋ": "υ", "ΰ": "υ", "ω": "ω", "ς": "σ" };
        }), e.define("select2/data/base", ["../utils"], function (t) {
            function e(t, n) {
                e.__super__.constructor.call(this);
            }return t.Extend(e, t.Observable), e.prototype.current = function (t) {
                throw new Error("The `current` method must be defined in child classes.");
            }, e.prototype.query = function (t, e) {
                throw new Error("The `query` method must be defined in child classes.");
            }, e.prototype.bind = function (t, e) {}, e.prototype.destroy = function () {}, e.prototype.generateResultId = function (e, n) {
                var i = e.id + "-result-";return i += t.generateChars(4), null != n.id ? i += "-" + n.id.toString() : i += "-" + t.generateChars(4), i;
            }, e;
        }), e.define("select2/data/select", ["./base", "../utils", "jquery"], function (t, e, n) {
            function i(t, e) {
                this.$element = t, this.options = e, i.__super__.constructor.call(this);
            }return e.Extend(i, t), i.prototype.current = function (t) {
                var e = [],
                    i = this;this.$element.find(":selected").each(function () {
                    var t = n(this),
                        o = i.item(t);e.push(o);
                }), t(e);
            }, i.prototype.select = function (t) {
                var e = this;if (t.selected = !0, n(t.element).is("option")) return t.element.selected = !0, void this.$element.trigger("change");if (this.$element.prop("multiple")) this.current(function (i) {
                    var o = [];t = [t], t.push.apply(t, i);for (var s = 0; s < t.length; s++) {
                        var r = t[s].id;-1 === n.inArray(r, o) && o.push(r);
                    }e.$element.val(o), e.$element.trigger("change");
                });else {
                    var i = t.id;this.$element.val(i), this.$element.trigger("change");
                }
            }, i.prototype.unselect = function (t) {
                var e = this;if (this.$element.prop("multiple")) {
                    if (t.selected = !1, n(t.element).is("option")) return t.element.selected = !1, void this.$element.trigger("change");this.current(function (i) {
                        for (var o = [], s = 0; s < i.length; s++) {
                            var r = i[s].id;r !== t.id && -1 === n.inArray(r, o) && o.push(r);
                        }e.$element.val(o), e.$element.trigger("change");
                    });
                }
            }, i.prototype.bind = function (t, e) {
                var n = this;this.container = t, t.on("select", function (t) {
                    n.select(t.data);
                }), t.on("unselect", function (t) {
                    n.unselect(t.data);
                });
            }, i.prototype.destroy = function () {
                this.$element.find("*").each(function () {
                    e.RemoveData(this);
                });
            }, i.prototype.query = function (t, e) {
                var i = [],
                    o = this;this.$element.children().each(function () {
                    var e = n(this);if (e.is("option") || e.is("optgroup")) {
                        var s = o.item(e),
                            r = o.matches(t, s);null !== r && i.push(r);
                    }
                }), e({ results: i });
            }, i.prototype.addOptions = function (t) {
                e.appendMany(this.$element, t);
            }, i.prototype.option = function (t) {
                var i;t.children ? (i = document.createElement("optgroup"), i.label = t.text) : (i = document.createElement("option"), void 0 !== i.textContent ? i.textContent = t.text : i.innerText = t.text), void 0 !== t.id && (i.value = t.id), t.disabled && (i.disabled = !0), t.selected && (i.selected = !0), t.title && (i.title = t.title);var o = n(i),
                    s = this._normalizeItem(t);return s.element = i, e.StoreData(i, "data", s), o;
            }, i.prototype.item = function (t) {
                var i = {};if (null != (i = e.GetData(t[0], "data"))) return i;if (t.is("option")) i = { id: t.val(), text: t.text(), disabled: t.prop("disabled"), selected: t.prop("selected"), title: t.prop("title") };else if (t.is("optgroup")) {
                    i = { text: t.prop("label"), children: [], title: t.prop("title") };for (var o = t.children("option"), s = [], r = 0; r < o.length; r++) {
                        var a = n(o[r]),
                            l = this.item(a);s.push(l);
                    }i.children = s;
                }return i = this._normalizeItem(i), i.element = t[0], e.StoreData(t[0], "data", i), i;
            }, i.prototype._normalizeItem = function (t) {
                t !== Object(t) && (t = { id: t, text: t }), t = n.extend({}, { text: "" }, t);var e = { selected: !1, disabled: !1 };return null != t.id && (t.id = t.id.toString()), null != t.text && (t.text = t.text.toString()), null == t._resultId && t.id && null != this.container && (t._resultId = this.generateResultId(this.container, t)), n.extend({}, e, t);
            }, i.prototype.matches = function (t, e) {
                return this.options.get("matcher")(t, e);
            }, i;
        }), e.define("select2/data/array", ["./select", "../utils", "jquery"], function (t, e, n) {
            function i(t, e) {
                var n = e.get("data") || [];i.__super__.constructor.call(this, t, e), this.addOptions(this.convertToOptions(n));
            }return e.Extend(i, t), i.prototype.select = function (t) {
                var e = this.$element.find("option").filter(function (e, n) {
                    return n.value == t.id.toString();
                });0 === e.length && (e = this.option(t), this.addOptions(e)), i.__super__.select.call(this, t);
            }, i.prototype.convertToOptions = function (t) {
                for (var i = this, o = this.$element.find("option"), s = o.map(function () {
                    return i.item(n(this)).id;
                }).get(), r = [], a = 0; a < t.length; a++) {
                    var l = this._normalizeItem(t[a]);if (n.inArray(l.id, s) >= 0) {
                        var c = o.filter(function (t) {
                            return function () {
                                return n(this).val() == t.id;
                            };
                        }(l)),
                            u = this.item(c),
                            h = n.extend(!0, {}, l, u),
                            p = this.option(h);c.replaceWith(p);
                    } else {
                        var d = this.option(l);if (l.children) {
                            var f = this.convertToOptions(l.children);e.appendMany(d, f);
                        }r.push(d);
                    }
                }return r;
            }, i;
        }), e.define("select2/data/ajax", ["./array", "../utils", "jquery"], function (t, e, n) {
            function i(t, e) {
                this.ajaxOptions = this._applyDefaults(e.get("ajax")), null != this.ajaxOptions.processResults && (this.processResults = this.ajaxOptions.processResults), i.__super__.constructor.call(this, t, e);
            }return e.Extend(i, t), i.prototype._applyDefaults = function (t) {
                var e = { data: function data(t) {
                        return n.extend({}, t, { q: t.term });
                    }, transport: function transport(t, e, i) {
                        var o = n.ajax(t);return o.then(e), o.fail(i), o;
                    } };return n.extend({}, e, t, !0);
            }, i.prototype.processResults = function (t) {
                return t;
            }, i.prototype.query = function (t, e) {
                function i() {
                    var i = s.transport(s, function (i) {
                        var s = o.processResults(i, t);o.options.get("debug") && window.console && console.error && (s && s.results && n.isArray(s.results) || console.error("Select2: The AJAX results did not return an array in the `results` key of the response.")), e(s);
                    }, function () {
                        "status" in i && (0 === i.status || "0" === i.status) || o.trigger("results:message", { message: "errorLoading" });
                    });o._request = i;
                }var o = this;null != this._request && (n.isFunction(this._request.abort) && this._request.abort(), this._request = null);var s = n.extend({ type: "GET" }, this.ajaxOptions);"function" == typeof s.url && (s.url = s.url.call(this.$element, t)), "function" == typeof s.data && (s.data = s.data.call(this.$element, t)), this.ajaxOptions.delay && null != t.term ? (this._queryTimeout && window.clearTimeout(this._queryTimeout), this._queryTimeout = window.setTimeout(i, this.ajaxOptions.delay)) : i();
            }, i;
        }), e.define("select2/data/tags", ["jquery"], function (t) {
            function e(e, n, i) {
                var o = i.get("tags"),
                    s = i.get("createTag");void 0 !== s && (this.createTag = s);var r = i.get("insertTag");if (void 0 !== r && (this.insertTag = r), e.call(this, n, i), t.isArray(o)) for (var a = 0; a < o.length; a++) {
                    var l = o[a],
                        c = this._normalizeItem(l),
                        u = this.option(c);this.$element.append(u);
                }
            }return e.prototype.query = function (t, e, n) {
                function i(t, s) {
                    for (var r = t.results, a = 0; a < r.length; a++) {
                        var l = r[a],
                            c = null != l.children && !i({ results: l.children }, !0);if ((l.text || "").toUpperCase() === (e.term || "").toUpperCase() || c) return !s && (t.data = r, void n(t));
                    }if (s) return !0;var u = o.createTag(e);if (null != u) {
                        var h = o.option(u);h.attr("data-select2-tag", !0), o.addOptions([h]), o.insertTag(r, u);
                    }t.results = r, n(t);
                }var o = this;if (this._removeOldTags(), null == e.term || null != e.page) return void t.call(this, e, n);t.call(this, e, i);
            }, e.prototype.createTag = function (e, n) {
                var i = t.trim(n.term);return "" === i ? null : { id: i, text: i };
            }, e.prototype.insertTag = function (t, e, n) {
                e.unshift(n);
            }, e.prototype._removeOldTags = function (e) {
                this._lastTag, this.$element.find("option[data-select2-tag]").each(function () {
                    this.selected || t(this).remove();
                });
            }, e;
        }), e.define("select2/data/tokenizer", ["jquery"], function (t) {
            function e(t, e, n) {
                var i = n.get("tokenizer");void 0 !== i && (this.tokenizer = i), t.call(this, e, n);
            }return e.prototype.bind = function (t, e, n) {
                t.call(this, e, n), this.$search = e.dropdown.$search || e.selection.$search || n.find(".select2-search__field");
            }, e.prototype.query = function (e, n, i) {
                function o(e) {
                    var n = r._normalizeItem(e);if (!r.$element.find("option").filter(function () {
                        return t(this).val() === n.id;
                    }).length) {
                        var i = r.option(n);i.attr("data-select2-tag", !0), r._removeOldTags(), r.addOptions([i]);
                    }s(n);
                }function s(t) {
                    r.trigger("select", { data: t });
                }var r = this;n.term = n.term || "";var a = this.tokenizer(n, this.options, o);a.term !== n.term && (this.$search.length && (this.$search.val(a.term), this.$search.focus()), n.term = a.term), e.call(this, n, i);
            }, e.prototype.tokenizer = function (e, n, i, o) {
                for (var s = i.get("tokenSeparators") || [], r = n.term, a = 0, l = this.createTag || function (t) {
                    return { id: t.term, text: t.term };
                }; a < r.length;) {
                    var c = r[a];if (-1 !== t.inArray(c, s)) {
                        var u = r.substr(0, a),
                            h = t.extend({}, n, { term: u }),
                            p = l(h);null != p ? (o(p), r = r.substr(a + 1) || "", a = 0) : a++;
                    } else a++;
                }return { term: r };
            }, e;
        }), e.define("select2/data/minimumInputLength", [], function () {
            function t(t, e, n) {
                this.minimumInputLength = n.get("minimumInputLength"), t.call(this, e, n);
            }return t.prototype.query = function (t, e, n) {
                if (e.term = e.term || "", e.term.length < this.minimumInputLength) return void this.trigger("results:message", { message: "inputTooShort", args: { minimum: this.minimumInputLength, input: e.term, params: e } });t.call(this, e, n);
            }, t;
        }), e.define("select2/data/maximumInputLength", [], function () {
            function t(t, e, n) {
                this.maximumInputLength = n.get("maximumInputLength"), t.call(this, e, n);
            }return t.prototype.query = function (t, e, n) {
                if (e.term = e.term || "", this.maximumInputLength > 0 && e.term.length > this.maximumInputLength) return void this.trigger("results:message", { message: "inputTooLong", args: { maximum: this.maximumInputLength, input: e.term, params: e } });t.call(this, e, n);
            }, t;
        }), e.define("select2/data/maximumSelectionLength", [], function () {
            function t(t, e, n) {
                this.maximumSelectionLength = n.get("maximumSelectionLength"), t.call(this, e, n);
            }return t.prototype.query = function (t, e, n) {
                var i = this;this.current(function (o) {
                    var s = null != o ? o.length : 0;if (i.maximumSelectionLength > 0 && s >= i.maximumSelectionLength) return void i.trigger("results:message", { message: "maximumSelected", args: { maximum: i.maximumSelectionLength } });t.call(i, e, n);
                });
            }, t;
        }), e.define("select2/dropdown", ["jquery", "./utils"], function (t, e) {
            function n(t, e) {
                this.$element = t, this.options = e, n.__super__.constructor.call(this);
            }return e.Extend(n, e.Observable), n.prototype.render = function () {
                var e = t('<span class="select2-dropdown"><span class="select2-results"></span></span>');return e.attr("dir", this.options.get("dir")), this.$dropdown = e, e;
            }, n.prototype.bind = function () {}, n.prototype.position = function (t, e) {}, n.prototype.destroy = function () {
                this.$dropdown.remove();
            }, n;
        }), e.define("select2/dropdown/search", ["jquery", "../utils"], function (t, e) {
            function n() {}return n.prototype.render = function (e) {
                var n = e.call(this),
                    i = t('<span class="select2-search select2-search--dropdown"><input class="select2-search__field" type="search" tabindex="-1" autocomplete="off" autocorrect="off" autocapitalize="none" spellcheck="false" role="textbox" /></span>');return this.$searchContainer = i, this.$search = i.find("input"), n.prepend(i), n;
            }, n.prototype.bind = function (e, n, i) {
                var o = this;e.call(this, n, i), this.$search.on("keydown", function (t) {
                    o.trigger("keypress", t), o._keyUpPrevented = t.isDefaultPrevented();
                }), this.$search.on("input", function (e) {
                    t(this).off("keyup");
                }), this.$search.on("keyup input", function (t) {
                    o.handleSearch(t);
                }), n.on("open", function () {
                    o.$search.attr("tabindex", 0), o.$search.focus(), window.setTimeout(function () {
                        o.$search.focus();
                    }, 0);
                }), n.on("close", function () {
                    o.$search.attr("tabindex", -1), o.$search.val(""), o.$search.blur();
                }), n.on("focus", function () {
                    n.isOpen() || o.$search.focus();
                }), n.on("results:all", function (t) {
                    null != t.query.term && "" !== t.query.term || (o.showSearch(t) ? o.$searchContainer.removeClass("select2-search--hide") : o.$searchContainer.addClass("select2-search--hide"));
                });
            }, n.prototype.handleSearch = function (t) {
                if (!this._keyUpPrevented) {
                    var e = this.$search.val();this.trigger("query", { term: e });
                }this._keyUpPrevented = !1;
            }, n.prototype.showSearch = function (t, e) {
                return !0;
            }, n;
        }), e.define("select2/dropdown/hidePlaceholder", [], function () {
            function t(t, e, n, i) {
                this.placeholder = this.normalizePlaceholder(n.get("placeholder")), t.call(this, e, n, i);
            }return t.prototype.append = function (t, e) {
                e.results = this.removePlaceholder(e.results), t.call(this, e);
            }, t.prototype.normalizePlaceholder = function (t, e) {
                return "string" == typeof e && (e = { id: "", text: e }), e;
            }, t.prototype.removePlaceholder = function (t, e) {
                for (var n = e.slice(0), i = e.length - 1; i >= 0; i--) {
                    var o = e[i];this.placeholder.id === o.id && n.splice(i, 1);
                }return n;
            }, t;
        }), e.define("select2/dropdown/infiniteScroll", ["jquery"], function (t) {
            function e(t, e, n, i) {
                this.lastParams = {}, t.call(this, e, n, i), this.$loadingMore = this.createLoadingMore(), this.loading = !1;
            }return e.prototype.append = function (t, e) {
                this.$loadingMore.remove(), this.loading = !1, t.call(this, e), this.showLoadingMore(e) && this.$results.append(this.$loadingMore);
            }, e.prototype.bind = function (e, n, i) {
                var o = this;e.call(this, n, i), n.on("query", function (t) {
                    o.lastParams = t, o.loading = !0;
                }), n.on("query:append", function (t) {
                    o.lastParams = t, o.loading = !0;
                }), this.$results.on("scroll", function () {
                    var e = t.contains(document.documentElement, o.$loadingMore[0]);!o.loading && e && o.$results.offset().top + o.$results.outerHeight(!1) + 50 >= o.$loadingMore.offset().top + o.$loadingMore.outerHeight(!1) && o.loadMore();
                });
            }, e.prototype.loadMore = function () {
                this.loading = !0;var e = t.extend({}, { page: 1 }, this.lastParams);e.page++, this.trigger("query:append", e);
            }, e.prototype.showLoadingMore = function (t, e) {
                return e.pagination && e.pagination.more;
            }, e.prototype.createLoadingMore = function () {
                var e = t('<li class="select2-results__option select2-results__option--load-more"role="treeitem" aria-disabled="true"></li>'),
                    n = this.options.get("translations").get("loadingMore");return e.html(n(this.lastParams)), e;
            }, e;
        }), e.define("select2/dropdown/attachBody", ["jquery", "../utils"], function (t, e) {
            function n(e, n, i) {
                this.$dropdownParent = i.get("dropdownParent") || t(document.body), e.call(this, n, i);
            }return n.prototype.bind = function (t, e, n) {
                var i = this,
                    o = !1;t.call(this, e, n), e.on("open", function () {
                    i._showDropdown(), i._attachPositioningHandler(e), o || (o = !0, e.on("results:all", function () {
                        i._positionDropdown(), i._resizeDropdown();
                    }), e.on("results:append", function () {
                        i._positionDropdown(), i._resizeDropdown();
                    }));
                }), e.on("close", function () {
                    i._hideDropdown(), i._detachPositioningHandler(e);
                }), this.$dropdownContainer.on("mousedown", function (t) {
                    t.stopPropagation();
                });
            }, n.prototype.destroy = function (t) {
                t.call(this), this.$dropdownContainer.remove();
            }, n.prototype.position = function (t, e, n) {
                e.attr("class", n.attr("class")), e.removeClass("select2"), e.addClass("select2-container--open"), e.css({ position: "absolute", top: -999999 }), this.$container = n;
            }, n.prototype.render = function (e) {
                var n = t("<span></span>"),
                    i = e.call(this);return n.append(i), this.$dropdownContainer = n, n;
            }, n.prototype._hideDropdown = function (t) {
                this.$dropdownContainer.detach();
            }, n.prototype._attachPositioningHandler = function (n, i) {
                var o = this,
                    s = "scroll.select2." + i.id,
                    r = "resize.select2." + i.id,
                    a = "orientationchange.select2." + i.id,
                    l = this.$container.parents().filter(e.hasScroll);l.each(function () {
                    e.StoreData(this, "select2-scroll-position", { x: t(this).scrollLeft(), y: t(this).scrollTop() });
                }), l.on(s, function (n) {
                    var i = e.GetData(this, "select2-scroll-position");t(this).scrollTop(i.y);
                }), t(window).on(s + " " + r + " " + a, function (t) {
                    o._positionDropdown(), o._resizeDropdown();
                });
            }, n.prototype._detachPositioningHandler = function (n, i) {
                var o = "scroll.select2." + i.id,
                    s = "resize.select2." + i.id,
                    r = "orientationchange.select2." + i.id;this.$container.parents().filter(e.hasScroll).off(o), t(window).off(o + " " + s + " " + r);
            }, n.prototype._positionDropdown = function () {
                var e = t(window),
                    n = this.$dropdown.hasClass("select2-dropdown--above"),
                    i = this.$dropdown.hasClass("select2-dropdown--below"),
                    o = null,
                    s = this.$container.offset();s.bottom = s.top + this.$container.outerHeight(!1);var r = { height: this.$container.outerHeight(!1) };r.top = s.top, r.bottom = s.top + r.height;var a = { height: this.$dropdown.outerHeight(!1) },
                    l = { top: e.scrollTop(), bottom: e.scrollTop() + e.height() },
                    c = l.top < s.top - a.height,
                    u = l.bottom > s.bottom + a.height,
                    h = { left: s.left, top: r.bottom },
                    p = this.$dropdownParent;"static" === p.css("position") && (p = p.offsetParent());var d = p.offset();h.top -= d.top, h.left -= d.left, n || i || (o = "below"), u || !c || n ? !c && u && n && (o = "below") : o = "above", ("above" == o || n && "below" !== o) && (h.top = r.top - d.top - a.height), null != o && (this.$dropdown.removeClass("select2-dropdown--below select2-dropdown--above").addClass("select2-dropdown--" + o), this.$container.removeClass("select2-container--below select2-container--above").addClass("select2-container--" + o)), this.$dropdownContainer.css(h);
            }, n.prototype._resizeDropdown = function () {
                var t = { width: this.$container.outerWidth(!1) + "px" };this.options.get("dropdownAutoWidth") && (t.minWidth = t.width, t.position = "relative", t.width = "auto"), this.$dropdown.css(t);
            }, n.prototype._showDropdown = function (t) {
                this.$dropdownContainer.appendTo(this.$dropdownParent), this._positionDropdown(), this._resizeDropdown();
            }, n;
        }), e.define("select2/dropdown/minimumResultsForSearch", [], function () {
            function t(e) {
                for (var n = 0, i = 0; i < e.length; i++) {
                    var o = e[i];o.children ? n += t(o.children) : n++;
                }return n;
            }function e(t, e, n, i) {
                this.minimumResultsForSearch = n.get("minimumResultsForSearch"), this.minimumResultsForSearch < 0 && (this.minimumResultsForSearch = 1 / 0), t.call(this, e, n, i);
            }return e.prototype.showSearch = function (e, n) {
                return !(t(n.data.results) < this.minimumResultsForSearch) && e.call(this, n);
            }, e;
        }), e.define("select2/dropdown/selectOnClose", ["../utils"], function (t) {
            function e() {}return e.prototype.bind = function (t, e, n) {
                var i = this;t.call(this, e, n), e.on("close", function (t) {
                    i._handleSelectOnClose(t);
                });
            }, e.prototype._handleSelectOnClose = function (e, n) {
                if (n && null != n.originalSelect2Event) {
                    var i = n.originalSelect2Event;if ("select" === i._type || "unselect" === i._type) return;
                }var o = this.getHighlightedResults();if (!(o.length < 1)) {
                    var s = t.GetData(o[0], "data");null != s.element && s.element.selected || null == s.element && s.selected || this.trigger("select", { data: s });
                }
            }, e;
        }), e.define("select2/dropdown/closeOnSelect", [], function () {
            function t() {}return t.prototype.bind = function (t, e, n) {
                var i = this;t.call(this, e, n), e.on("select", function (t) {
                    i._selectTriggered(t);
                }), e.on("unselect", function (t) {
                    i._selectTriggered(t);
                });
            }, t.prototype._selectTriggered = function (t, e) {
                var n = e.originalEvent;n && n.ctrlKey || this.trigger("close", { originalEvent: n, originalSelect2Event: e });
            }, t;
        }), e.define("select2/i18n/en", [], function () {
            return { errorLoading: function errorLoading() {
                    return "The results could not be loaded.";
                }, inputTooLong: function inputTooLong(t) {
                    var e = t.input.length - t.maximum,
                        n = "Please delete " + e + " character";return 1 != e && (n += "s"), n;
                }, inputTooShort: function inputTooShort(t) {
                    return "Please enter " + (t.minimum - t.input.length) + " or more characters";
                }, loadingMore: function loadingMore() {
                    return "Loading more results…";
                }, maximumSelected: function maximumSelected(t) {
                    var e = "You can only select " + t.maximum + " item";return 1 != t.maximum && (e += "s"), e;
                }, noResults: function noResults() {
                    return "No results found";
                }, searching: function searching() {
                    return "Searching…";
                } };
        }), e.define("select2/defaults", ["jquery", "require", "./results", "./selection/single", "./selection/multiple", "./selection/placeholder", "./selection/allowClear", "./selection/search", "./selection/eventRelay", "./utils", "./translation", "./diacritics", "./data/select", "./data/array", "./data/ajax", "./data/tags", "./data/tokenizer", "./data/minimumInputLength", "./data/maximumInputLength", "./data/maximumSelectionLength", "./dropdown", "./dropdown/search", "./dropdown/hidePlaceholder", "./dropdown/infiniteScroll", "./dropdown/attachBody", "./dropdown/minimumResultsForSearch", "./dropdown/selectOnClose", "./dropdown/closeOnSelect", "./i18n/en"], function (t, e, n, i, o, s, r, a, l, c, u, h, p, d, f, g, m, v, y, b, w, _, x, C, T, S, A, E, P) {
            function k() {
                this.reset();
            }return k.prototype.apply = function (h) {
                if (h = t.extend(!0, {}, this.defaults, h), null == h.dataAdapter) {
                    if (null != h.ajax ? h.dataAdapter = f : null != h.data ? h.dataAdapter = d : h.dataAdapter = p, h.minimumInputLength > 0 && (h.dataAdapter = c.Decorate(h.dataAdapter, v)), h.maximumInputLength > 0 && (h.dataAdapter = c.Decorate(h.dataAdapter, y)), h.maximumSelectionLength > 0 && (h.dataAdapter = c.Decorate(h.dataAdapter, b)), h.tags && (h.dataAdapter = c.Decorate(h.dataAdapter, g)), null == h.tokenSeparators && null == h.tokenizer || (h.dataAdapter = c.Decorate(h.dataAdapter, m)), null != h.query) {
                        var P = e(h.amdBase + "compat/query");h.dataAdapter = c.Decorate(h.dataAdapter, P);
                    }if (null != h.initSelection) {
                        var k = e(h.amdBase + "compat/initSelection");h.dataAdapter = c.Decorate(h.dataAdapter, k);
                    }
                }if (null == h.resultsAdapter && (h.resultsAdapter = n, null != h.ajax && (h.resultsAdapter = c.Decorate(h.resultsAdapter, C)), null != h.placeholder && (h.resultsAdapter = c.Decorate(h.resultsAdapter, x)), h.selectOnClose && (h.resultsAdapter = c.Decorate(h.resultsAdapter, A))), null == h.dropdownAdapter) {
                    if (h.multiple) h.dropdownAdapter = w;else {
                        var D = c.Decorate(w, _);h.dropdownAdapter = D;
                    }if (0 !== h.minimumResultsForSearch && (h.dropdownAdapter = c.Decorate(h.dropdownAdapter, S)), h.closeOnSelect && (h.dropdownAdapter = c.Decorate(h.dropdownAdapter, E)), null != h.dropdownCssClass || null != h.dropdownCss || null != h.adaptDropdownCssClass) {
                        var O = e(h.amdBase + "compat/dropdownCss");h.dropdownAdapter = c.Decorate(h.dropdownAdapter, O);
                    }h.dropdownAdapter = c.Decorate(h.dropdownAdapter, T);
                }if (null == h.selectionAdapter) {
                    if (h.multiple ? h.selectionAdapter = o : h.selectionAdapter = i, null != h.placeholder && (h.selectionAdapter = c.Decorate(h.selectionAdapter, s)), h.allowClear && (h.selectionAdapter = c.Decorate(h.selectionAdapter, r)), h.multiple && (h.selectionAdapter = c.Decorate(h.selectionAdapter, a)), null != h.containerCssClass || null != h.containerCss || null != h.adaptContainerCssClass) {
                        var $ = e(h.amdBase + "compat/containerCss");h.selectionAdapter = c.Decorate(h.selectionAdapter, $);
                    }h.selectionAdapter = c.Decorate(h.selectionAdapter, l);
                }if ("string" == typeof h.language) if (h.language.indexOf("-") > 0) {
                    var I = h.language.split("-"),
                        N = I[0];h.language = [h.language, N];
                } else h.language = [h.language];if (t.isArray(h.language)) {
                    var L = new u();h.language.push("en");for (var j = h.language, z = 0; z < j.length; z++) {
                        var H = j[z],
                            R = {};try {
                            R = u.loadPath(H);
                        } catch (t) {
                            try {
                                H = this.defaults.amdLanguageBase + H, R = u.loadPath(H);
                            } catch (t) {
                                h.debug && window.console && console.warn && console.warn('Select2: The language file for "' + H + '" could not be automatically loaded. A fallback will be used instead.');continue;
                            }
                        }L.extend(R);
                    }h.translations = L;
                } else {
                    var M = u.loadPath(this.defaults.amdLanguageBase + "en"),
                        q = new u(h.language);q.extend(M), h.translations = q;
                }return h;
            }, k.prototype.reset = function () {
                function e(t) {
                    function e(t) {
                        return h[t] || t;
                    }return t.replace(/[^\u0000-\u007E]/g, e);
                }function n(i, o) {
                    if ("" === t.trim(i.term)) return o;if (o.children && o.children.length > 0) {
                        for (var s = t.extend(!0, {}, o), r = o.children.length - 1; r >= 0; r--) {
                            null == n(i, o.children[r]) && s.children.splice(r, 1);
                        }return s.children.length > 0 ? s : n(i, s);
                    }var a = e(o.text).toUpperCase(),
                        l = e(i.term).toUpperCase();return a.indexOf(l) > -1 ? o : null;
                }this.defaults = { amdBase: "./", amdLanguageBase: "./i18n/", closeOnSelect: !0, debug: !1, dropdownAutoWidth: !1, escapeMarkup: c.escapeMarkup, language: P, matcher: n, minimumInputLength: 0, maximumInputLength: 0, maximumSelectionLength: 0, minimumResultsForSearch: 0, selectOnClose: !1, sorter: function sorter(t) {
                        return t;
                    }, templateResult: function templateResult(t) {
                        return t.text;
                    }, templateSelection: function templateSelection(t) {
                        return t.text;
                    }, theme: "default", width: "resolve" };
            }, k.prototype.set = function (e, n) {
                var i = t.camelCase(e),
                    o = {};o[i] = n;var s = c._convertData(o);t.extend(!0, this.defaults, s);
            }, new k();
        }), e.define("select2/options", ["require", "jquery", "./defaults", "./utils"], function (t, e, n, i) {
            function o(e, o) {
                if (this.options = e, null != o && this.fromElement(o), this.options = n.apply(this.options), o && o.is("input")) {
                    var s = t(this.get("amdBase") + "compat/inputData");this.options.dataAdapter = i.Decorate(this.options.dataAdapter, s);
                }
            }return o.prototype.fromElement = function (t) {
                var n = ["select2"];null == this.options.multiple && (this.options.multiple = t.prop("multiple")), null == this.options.disabled && (this.options.disabled = t.prop("disabled")), null == this.options.language && (t.prop("lang") ? this.options.language = t.prop("lang").toLowerCase() : t.closest("[lang]").prop("lang") && (this.options.language = t.closest("[lang]").prop("lang"))), null == this.options.dir && (t.prop("dir") ? this.options.dir = t.prop("dir") : t.closest("[dir]").prop("dir") ? this.options.dir = t.closest("[dir]").prop("dir") : this.options.dir = "ltr"), t.prop("disabled", this.options.disabled), t.prop("multiple", this.options.multiple), i.GetData(t[0], "select2Tags") && (this.options.debug && window.console && console.warn && console.warn('Select2: The `data-select2-tags` attribute has been changed to use the `data-data` and `data-tags="true"` attributes and will be removed in future versions of Select2.'), i.StoreData(t[0], "data", i.GetData(t[0], "select2Tags")), i.StoreData(t[0], "tags", !0)), i.GetData(t[0], "ajaxUrl") && (this.options.debug && window.console && console.warn && console.warn("Select2: The `data-ajax-url` attribute has been changed to `data-ajax--url` and support for the old attribute will be removed in future versions of Select2."), t.attr("ajax--url", i.GetData(t[0], "ajaxUrl")), i.StoreData(t[0], "ajax-Url", i.GetData(t[0], "ajaxUrl")));var o = {};o = e.fn.jquery && "1." == e.fn.jquery.substr(0, 2) && t[0].dataset ? e.extend(!0, {}, t[0].dataset, i.GetData(t[0])) : i.GetData(t[0]);var s = e.extend(!0, {}, o);s = i._convertData(s);for (var r in s) {
                    e.inArray(r, n) > -1 || (e.isPlainObject(this.options[r]) ? e.extend(this.options[r], s[r]) : this.options[r] = s[r]);
                }return this;
            }, o.prototype.get = function (t) {
                return this.options[t];
            }, o.prototype.set = function (t, e) {
                this.options[t] = e;
            }, o;
        }), e.define("select2/core", ["jquery", "./options", "./utils", "./keys"], function (t, e, n, i) {
            var o = function t(i, o) {
                null != n.GetData(i[0], "select2") && n.GetData(i[0], "select2").destroy(), this.$element = i, this.id = this._generateId(i), o = o || {}, this.options = new e(o, i), t.__super__.constructor.call(this);var s = i.attr("tabindex") || 0;n.StoreData(i[0], "old-tabindex", s), i.attr("tabindex", "-1");var r = this.options.get("dataAdapter");this.dataAdapter = new r(i, this.options);var a = this.render();this._placeContainer(a);var l = this.options.get("selectionAdapter");this.selection = new l(i, this.options), this.$selection = this.selection.render(), this.selection.position(this.$selection, a);var c = this.options.get("dropdownAdapter");this.dropdown = new c(i, this.options), this.$dropdown = this.dropdown.render(), this.dropdown.position(this.$dropdown, a);var u = this.options.get("resultsAdapter");this.results = new u(i, this.options, this.dataAdapter), this.$results = this.results.render(), this.results.position(this.$results, this.$dropdown);var h = this;this._bindAdapters(), this._registerDomEvents(), this._registerDataEvents(), this._registerSelectionEvents(), this._registerDropdownEvents(), this._registerResultsEvents(), this._registerEvents(), this.dataAdapter.current(function (t) {
                    h.trigger("selection:update", { data: t });
                }), i.addClass("select2-hidden-accessible"), i.attr("aria-hidden", "true"), this._syncAttributes(), n.StoreData(i[0], "select2", this);
            };return n.Extend(o, n.Observable), o.prototype._generateId = function (t) {
                var e = "";return e = null != t.attr("id") ? t.attr("id") : null != t.attr("name") ? t.attr("name") + "-" + n.generateChars(2) : n.generateChars(4), e = e.replace(/(:|\.|\[|\]|,)/g, ""), e = "select2-" + e;
            }, o.prototype._placeContainer = function (t) {
                t.insertAfter(this.$element);var e = this._resolveWidth(this.$element, this.options.get("width"));null != e && t.css("width", e);
            }, o.prototype._resolveWidth = function (t, e) {
                var n = /^width:(([-+]?([0-9]*\.)?[0-9]+)(px|em|ex|%|in|cm|mm|pt|pc))/i;if ("resolve" == e) {
                    var i = this._resolveWidth(t, "style");return null != i ? i : this._resolveWidth(t, "element");
                }if ("element" == e) {
                    var o = t.outerWidth(!1);return o <= 0 ? "auto" : o + "px";
                }if ("style" == e) {
                    var s = t.attr("style");if ("string" != typeof s) return null;for (var r = s.split(";"), a = 0, l = r.length; a < l; a += 1) {
                        var c = r[a].replace(/\s/g, ""),
                            u = c.match(n);if (null !== u && u.length >= 1) return u[1];
                    }return null;
                }return e;
            }, o.prototype._bindAdapters = function () {
                this.dataAdapter.bind(this, this.$container), this.selection.bind(this, this.$container), this.dropdown.bind(this, this.$container), this.results.bind(this, this.$container);
            }, o.prototype._registerDomEvents = function () {
                var e = this;this.$element.on("change.select2", function () {
                    e.dataAdapter.current(function (t) {
                        e.trigger("selection:update", { data: t });
                    });
                }), this.$element.on("focus.select2", function (t) {
                    e.trigger("focus", t);
                }), this._syncA = n.bind(this._syncAttributes, this), this._syncS = n.bind(this._syncSubtree, this), this.$element[0].attachEvent && this.$element[0].attachEvent("onpropertychange", this._syncA);var i = window.MutationObserver || window.WebKitMutationObserver || window.MozMutationObserver;null != i ? (this._observer = new i(function (n) {
                    t.each(n, e._syncA), t.each(n, e._syncS);
                }), this._observer.observe(this.$element[0], { attributes: !0, childList: !0, subtree: !1 })) : this.$element[0].addEventListener && (this.$element[0].addEventListener("DOMAttrModified", e._syncA, !1), this.$element[0].addEventListener("DOMNodeInserted", e._syncS, !1), this.$element[0].addEventListener("DOMNodeRemoved", e._syncS, !1));
            }, o.prototype._registerDataEvents = function () {
                var t = this;this.dataAdapter.on("*", function (e, n) {
                    t.trigger(e, n);
                });
            }, o.prototype._registerSelectionEvents = function () {
                var e = this,
                    n = ["toggle", "focus"];this.selection.on("toggle", function () {
                    e.toggleDropdown();
                }), this.selection.on("focus", function (t) {
                    e.focus(t);
                }), this.selection.on("*", function (i, o) {
                    -1 === t.inArray(i, n) && e.trigger(i, o);
                });
            }, o.prototype._registerDropdownEvents = function () {
                var t = this;this.dropdown.on("*", function (e, n) {
                    t.trigger(e, n);
                });
            }, o.prototype._registerResultsEvents = function () {
                var t = this;this.results.on("*", function (e, n) {
                    t.trigger(e, n);
                });
            }, o.prototype._registerEvents = function () {
                var t = this;this.on("open", function () {
                    t.$container.addClass("select2-container--open");
                }), this.on("close", function () {
                    t.$container.removeClass("select2-container--open");
                }), this.on("enable", function () {
                    t.$container.removeClass("select2-container--disabled");
                }), this.on("disable", function () {
                    t.$container.addClass("select2-container--disabled");
                }), this.on("blur", function () {
                    t.$container.removeClass("select2-container--focus");
                }), this.on("query", function (e) {
                    t.isOpen() || t.trigger("open", {}), this.dataAdapter.query(e, function (n) {
                        t.trigger("results:all", { data: n, query: e });
                    });
                }), this.on("query:append", function (e) {
                    this.dataAdapter.query(e, function (n) {
                        t.trigger("results:append", { data: n, query: e });
                    });
                }), this.on("keypress", function (e) {
                    var n = e.which;t.isOpen() ? n === i.ESC || n === i.TAB || n === i.UP && e.altKey ? (t.close(), e.preventDefault()) : n === i.ENTER ? (t.trigger("results:select", {}), e.preventDefault()) : n === i.SPACE && e.ctrlKey ? (t.trigger("results:toggle", {}), e.preventDefault()) : n === i.UP ? (t.trigger("results:previous", {}), e.preventDefault()) : n === i.DOWN && (t.trigger("results:next", {}), e.preventDefault()) : (n === i.ENTER || n === i.SPACE || n === i.DOWN && e.altKey) && (t.open(), e.preventDefault());
                });
            }, o.prototype._syncAttributes = function () {
                this.options.set("disabled", this.$element.prop("disabled")), this.options.get("disabled") ? (this.isOpen() && this.close(), this.trigger("disable", {})) : this.trigger("enable", {});
            }, o.prototype._syncSubtree = function (t, e) {
                var n = !1,
                    i = this;if (!t || !t.target || "OPTION" === t.target.nodeName || "OPTGROUP" === t.target.nodeName) {
                    if (e) {
                        if (e.addedNodes && e.addedNodes.length > 0) for (var o = 0; o < e.addedNodes.length; o++) {
                            var s = e.addedNodes[o];s.selected && (n = !0);
                        } else e.removedNodes && e.removedNodes.length > 0 && (n = !0);
                    } else n = !0;n && this.dataAdapter.current(function (t) {
                        i.trigger("selection:update", { data: t });
                    });
                }
            }, o.prototype.trigger = function (t, e) {
                var n = o.__super__.trigger,
                    i = { open: "opening", close: "closing", select: "selecting", unselect: "unselecting", clear: "clearing" };if (void 0 === e && (e = {}), t in i) {
                    var s = i[t],
                        r = { prevented: !1, name: t, args: e };if (n.call(this, s, r), r.prevented) return void (e.prevented = !0);
                }n.call(this, t, e);
            }, o.prototype.toggleDropdown = function () {
                this.options.get("disabled") || (this.isOpen() ? this.close() : this.open());
            }, o.prototype.open = function () {
                this.isOpen() || this.trigger("query", {});
            }, o.prototype.close = function () {
                this.isOpen() && this.trigger("close", {});
            }, o.prototype.isOpen = function () {
                return this.$container.hasClass("select2-container--open");
            }, o.prototype.hasFocus = function () {
                return this.$container.hasClass("select2-container--focus");
            }, o.prototype.focus = function (t) {
                this.hasFocus() || (this.$container.addClass("select2-container--focus"), this.trigger("focus", {}));
            }, o.prototype.enable = function (t) {
                this.options.get("debug") && window.console && console.warn && console.warn('Select2: The `select2("enable")` method has been deprecated and will be removed in later Select2 versions. Use $element.prop("disabled") instead.'), null != t && 0 !== t.length || (t = [!0]);var e = !t[0];this.$element.prop("disabled", e);
            }, o.prototype.data = function () {
                this.options.get("debug") && arguments.length > 0 && window.console && console.warn && console.warn('Select2: Data can no longer be set using `select2("data")`. You should consider setting the value instead using `$element.val()`.');var t = [];return this.dataAdapter.current(function (e) {
                    t = e;
                }), t;
            }, o.prototype.val = function (e) {
                if (this.options.get("debug") && window.console && console.warn && console.warn('Select2: The `select2("val")` method has been deprecated and will be removed in later Select2 versions. Use $element.val() instead.'), null == e || 0 === e.length) return this.$element.val();var n = e[0];t.isArray(n) && (n = t.map(n, function (t) {
                    return t.toString();
                })), this.$element.val(n).trigger("change");
            }, o.prototype.destroy = function () {
                this.$container.remove(), this.$element[0].detachEvent && this.$element[0].detachEvent("onpropertychange", this._syncA), null != this._observer ? (this._observer.disconnect(), this._observer = null) : this.$element[0].removeEventListener && (this.$element[0].removeEventListener("DOMAttrModified", this._syncA, !1), this.$element[0].removeEventListener("DOMNodeInserted", this._syncS, !1), this.$element[0].removeEventListener("DOMNodeRemoved", this._syncS, !1)), this._syncA = null, this._syncS = null, this.$element.off(".select2"), this.$element.attr("tabindex", n.GetData(this.$element[0], "old-tabindex")), this.$element.removeClass("select2-hidden-accessible"), this.$element.attr("aria-hidden", "false"), n.RemoveData(this.$element[0]), this.dataAdapter.destroy(), this.selection.destroy(), this.dropdown.destroy(), this.results.destroy(), this.dataAdapter = null, this.selection = null, this.dropdown = null, this.results = null;
            }, o.prototype.render = function () {
                var e = t('<span class="select2 select2-container"><span class="selection"></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>');return e.attr("dir", this.options.get("dir")), this.$container = e, this.$container.addClass("select2-container--" + this.options.get("theme")), n.StoreData(e[0], "element", this.$element), e;
            }, o;
        }), e.define("jquery-mousewheel", ["jquery"], function (t) {
            return t;
        }), e.define("jquery.select2", ["jquery", "jquery-mousewheel", "./select2/core", "./select2/defaults", "./select2/utils"], function (t, e, n, i, o) {
            if (null == t.fn.select2) {
                var s = ["open", "close", "destroy"];t.fn.select2 = function (e) {
                    if ("object" == _typeof(e = e || {})) return this.each(function () {
                        var i = t.extend(!0, {}, e);new n(t(this), i);
                    }), this;if ("string" == typeof e) {
                        var i,
                            r = Array.prototype.slice.call(arguments, 1);return this.each(function () {
                            var t = o.GetData(this, "select2");null == t && window.console && console.error && console.error("The select2('" + e + "') method was called on an element that is not using Select2."), i = t[e].apply(t, r);
                        }), t.inArray(e, s) > -1 ? this : i;
                    }throw new Error("Invalid arguments for Select2: " + e);
                };
            }return null == t.fn.select2.defaults && (t.fn.select2.defaults = i), n;
        }), { define: e.define, require: e.require };
    }(),
        n = e.require("jquery.select2");return t.fn.select2.amd = e, n;
}), function (t, e) {
    var n = t.document,
        i = t.location,
        o = t.escape("scrollPosition|" + i.pathname + i.search);t.loadScroll = function () {
        var e;try {
            e = (localStorage.getItem(o) || "").split("|");
        } catch (a) {
            for (var i = n.cookie.split(";"), s = i.length - 1; 0 <= s && !e; s--) {
                var r = i[s].split("=");r[0] == o && (e = t.unescape(r[1]).split("|"));
            }
        }for (e = e || [], i = e.length - 1; 0 <= i; i--) {
            s = e[i].split(",");try {
                if ("" == s[0]) t.scrollTo(s[1], s[2]);else if (s[0]) {
                    var a = n.getElementById(s[0]);a.scrollLeft = s[1], a.scrollTop = s[2];
                }
            } catch (t) {}
        }
    }, t.saveScroll = function () {
        var i,
            s,
            r = [];for (t.pageXOffset !== e ? (i = t.pageXOffset, s = t.pageYOffset) : n.documentElement && n.documentElement.scrollLeft !== e ? (i = n.documentElement.scrollLeft, s = n.documentElement.scrollTop) : (i = n.body.scrollLeft, s = n.body.scrollTop), (i || s) && r.push(["", i, s].join()), i = n.all || n.getElementsByTagName("*"), s = 0; s < i.length; s++) {
            var a = i[s];a.id && (a.scrollLeft || a.scrollTop) && r.push([a.id, a.scrollLeft, a.scrollTop].join());
        }try {
            localStorage.setItem(o, r.join("|"));
        } catch (t) {
            n.cookie = o + "=" + r.join("|") + ";";
        }
    };
}(window), function (t) {
    var e, n;t.attachEvent ? (e = t.attachEvent, n = "on") : (e = t.addEventListener, n = ""), e(n + "load", t.loadScroll, !1), e(n + "unload", t.saveScroll, !1);
}(window), setTimeout(function () {
    if ("undefined" != typeof Sys && void 0 !== Sys.WebForms) {
        var t = Sys.WebForms.PageRequestManager.getInstance();t.add_beginRequest(window.saveScroll), t.add_endRequest(window.loadScroll);
    }
}, 0), function (t, e) {
    "object" == ("undefined" == typeof exports ? "undefined" : _typeof(exports)) && "object" == ("undefined" == typeof module ? "undefined" : _typeof(module)) ? module.exports = e() : "function" == typeof define && define.amd ? define([], e) : "object" == ("undefined" == typeof exports ? "undefined" : _typeof(exports)) ? exports.places = e() : t.places = e();
}(this, function () {
    return function (t) {
        function e(i) {
            if (n[i]) return n[i].exports;var o = n[i] = { i: i, l: !1, exports: {} };return t[i].call(o.exports, o, o.exports, e), o.l = !0, o.exports;
        }var n = {};return e.m = t, e.c = n, e.i = function (t) {
            return t;
        }, e.d = function (t, n, i) {
            e.o(t, n) || Object.defineProperty(t, n, { configurable: !1, enumerable: !0, get: i });
        }, e.n = function (t) {
            var n = t && t.__esModule ? function () {
                return t.default;
            } : function () {
                return t;
            };return e.d(n, "a", n), n;
        }, e.o = function (t, e) {
            return Object.prototype.hasOwnProperty.call(t, e);
        }, e.p = "", e(e.s = 82);
    }([function (t, e, n) {
        "use strict";
        function i(t) {
            return t.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&");
        }var o = n(1);t.exports = { isArray: null, isFunction: null, isObject: null, bind: null, each: null, map: null, mixin: null, isMsie: function isMsie(t) {
                if (void 0 === t && (t = navigator.userAgent), /(msie|trident)/i.test(t)) {
                    var e = t.match(/(msie |rv:)(\d+(.\d+)?)/i);if (e) return e[2];
                }return !1;
            }, escapeRegExChars: function escapeRegExChars(t) {
                return t.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&");
            }, isNumber: function isNumber(t) {
                return "number" == typeof t;
            }, toStr: function toStr(t) {
                return void 0 === t || null === t ? "" : t + "";
            }, cloneDeep: function cloneDeep(t) {
                var e = this.mixin({}, t),
                    n = this;return this.each(e, function (t, i) {
                    t && (n.isArray(t) ? e[i] = [].concat(t) : n.isObject(t) && (e[i] = n.cloneDeep(t)));
                }), e;
            }, error: function error(t) {
                throw new Error(t);
            }, every: function every(t, e) {
                var n = !0;return t ? (this.each(t, function (i, o) {
                    if (!(n = e.call(null, i, o, t))) return !1;
                }), !!n) : n;
            }, any: function any(t, e) {
                var n = !1;return t ? (this.each(t, function (i, o) {
                    if (e.call(null, i, o, t)) return n = !0, !1;
                }), n) : n;
            }, getUniqueId: function () {
                var t = 0;return function () {
                    return t++;
                };
            }(), templatify: function templatify(t) {
                if (this.isFunction(t)) return t;var e = o.element(t);return "SCRIPT" === e.prop("tagName") ? function () {
                    return e.text();
                } : function () {
                    return String(t);
                };
            }, defer: function defer(t) {
                setTimeout(t, 0);
            }, noop: function noop() {}, formatPrefix: function formatPrefix(t, e) {
                return e ? "" : t + "-";
            }, className: function className(t, e, n) {
                return (n ? "" : ".") + t + e;
            }, escapeHighlightedString: function escapeHighlightedString(t, e, n) {
                e = e || "<em>";var o = document.createElement("div");o.appendChild(document.createTextNode(e)), n = n || "</em>";var s = document.createElement("div");s.appendChild(document.createTextNode(n));var r = document.createElement("div");return r.appendChild(document.createTextNode(t)), r.innerHTML.replace(RegExp(i(o.innerHTML), "g"), e).replace(RegExp(i(s.innerHTML), "g"), n);
            } };
    }, function (t, e, n) {
        "use strict";
        t.exports = { element: null };
    }, function (t, e) {
        t.exports = function (t) {
            return JSON.parse(JSON.stringify(t));
        };
    }, function (t, e) {
        var n = Object.prototype.hasOwnProperty,
            i = Object.prototype.toString;t.exports = function (t, e, o) {
            if ("[object Function]" !== i.call(e)) throw new TypeError("iterator must be a function");var s = t.length;if (s === +s) for (var r = 0; r < s; r++) {
                e.call(o, t[r], r, t);
            } else for (var a in t) {
                n.call(t, a) && e.call(o, t[a], a, t);
            }
        };
    }, function (t, e) {
        var n;n = function () {
            return this;
        }();try {
            n = n || Function("return this")() || (0, eval)("this");
        } catch (t) {
            "object" == ("undefined" == typeof window ? "undefined" : _typeof(window)) && (n = window);
        }t.exports = n;
    }, function (t, e) {
        var n = {}.toString;t.exports = Array.isArray || function (t) {
            return "[object Array]" == n.call(t);
        };
    }, function (t, e, n) {
        "use strict";
        function i(t, e) {
            var i = n(3),
                o = this;"function" == typeof Error.captureStackTrace ? Error.captureStackTrace(this, this.constructor) : o.stack = new Error().stack || "Cannot get a stacktrace, browser is too old", this.name = "AlgoliaSearchError", this.message = t || "Unknown error", e && i(e, function (t, e) {
                o[e] = t;
            });
        }function o(t, e) {
            function n() {
                var n = Array.prototype.slice.call(arguments, 0);"string" != typeof n[0] && n.unshift(e), i.apply(this, n), this.name = "AlgoliaSearch" + t + "Error";
            }return s(n, i), n;
        }var s = n(31);s(i, Error), t.exports = { AlgoliaSearchError: i, UnparsableJSON: o("UnparsableJSON", "Could not parse the incoming response as JSON, see err.more for details"), RequestTimeout: o("RequestTimeout", "Request timedout before getting a response"), Network: o("Network", "Network issue, see err.more for details"), JSONPScriptFail: o("JSONPScriptFail", "<script> was loaded but did not call our provided callback"), JSONPScriptError: o("JSONPScriptError", "<script> unable to load due to an `error` event on it"), Unknown: o("Unknown", "Unknown error occured") };
    }, function (t, e, n) {
        var i = n(3);t.exports = function (t, e) {
            var n = [];return i(t, function (i, o) {
                n.push(e(i, o, t));
            }), n;
        };
    }, function (t, e, n) {
        (function (i) {
            function o() {
                return !("undefined" == typeof window || !window.process || "renderer" !== window.process.type) || "undefined" != typeof document && document.documentElement && document.documentElement.style && document.documentElement.style.WebkitAppearance || "undefined" != typeof window && window.console && (window.console.firebug || window.console.exception && window.console.table) || "undefined" != typeof navigator && navigator.userAgent && navigator.userAgent.toLowerCase().match(/firefox\/(\d+)/) && parseInt(RegExp.$1, 10) >= 31 || "undefined" != typeof navigator && navigator.userAgent && navigator.userAgent.toLowerCase().match(/applewebkit\/(\d+)/);
            }function s(t) {
                var n = this.useColors;if (t[0] = (n ? "%c" : "") + this.namespace + (n ? " %c" : " ") + t[0] + (n ? "%c " : " ") + "+" + e.humanize(this.diff), n) {
                    var i = "color: " + this.color;t.splice(1, 0, i, "color: inherit");var o = 0,
                        s = 0;t[0].replace(/%[a-zA-Z%]/g, function (t) {
                        "%%" !== t && (o++, "%c" === t && (s = o));
                    }), t.splice(s, 0, i);
                }
            }function r() {
                return "object" == ("undefined" == typeof console ? "undefined" : _typeof(console)) && console.log && Function.prototype.apply.call(console.log, console, arguments);
            }function a(t) {
                try {
                    null == t ? e.storage.removeItem("debug") : e.storage.debug = t;
                } catch (t) {}
            }function l() {
                var t;try {
                    t = e.storage.debug;
                } catch (t) {}return !t && void 0 !== i && "env" in i && (t = n.i({ NODE_ENV: "production" }).DEBUG), t;
            }e = t.exports = n(65), e.log = r, e.formatArgs = s, e.save = a, e.load = l, e.useColors = o, e.storage = "undefined" != typeof chrome && void 0 !== chrome.storage ? chrome.storage.local : function () {
                try {
                    return window.localStorage;
                } catch (t) {}
            }(), e.colors = ["lightseagreen", "forestgreen", "goldenrod", "dodgerblue", "darkorchid", "crimson"], e.formatters.j = function (t) {
                try {
                    return JSON.stringify(t);
                } catch (t) {
                    return "[UnexpectedJSONParseError]: " + t.message;
                }
            }, e.enable(l());
        }).call(e, n(11));
    }, function (t, e, n) {
        "use strict";
        var i = n(0),
            o = { wrapper: { position: "relative", display: "inline-block" }, hint: { position: "absolute", top: "0", left: "0", borderColor: "transparent", boxShadow: "none", opacity: "1" }, input: { position: "relative", verticalAlign: "top", backgroundColor: "transparent" }, inputWithNoHint: { position: "relative", verticalAlign: "top" }, dropdown: { position: "absolute", top: "100%", left: "0", zIndex: "100", display: "none" }, suggestions: { display: "block" }, suggestion: { whiteSpace: "nowrap", cursor: "pointer" }, suggestionChild: { whiteSpace: "normal" }, ltr: { left: "0", right: "auto" }, rtl: { left: "auto", right: "0" }, defaultClasses: { root: "algolia-autocomplete", prefix: "aa", noPrefix: !1, dropdownMenu: "dropdown-menu", input: "input", hint: "hint", suggestions: "suggestions", suggestion: "suggestion", cursor: "cursor", dataset: "dataset", empty: "empty" }, appendTo: { wrapper: { position: "absolute", zIndex: "100", display: "none" }, input: {}, inputWithNoHint: {}, dropdown: { display: "block" } } };i.isMsie() && i.mixin(o.input, { backgroundImage: "url(data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7)" }), i.isMsie() && i.isMsie() <= 7 && i.mixin(o.input, { marginTop: "-1px" }), t.exports = o;
    }, function (t, e, n) {
        "use strict";
        function i(t, e, n, i) {
            var o;if (!n) return this;for (e = e.split(h), n = i ? c(n, i) : n, this._callbacks = this._callbacks || {}; o = e.shift();) {
                this._callbacks[o] = this._callbacks[o] || { sync: [], async: [] }, this._callbacks[o][t].push(n);
            }return this;
        }function o(t, e, n) {
            return i.call(this, "async", t, e, n);
        }function s(t, e, n) {
            return i.call(this, "sync", t, e, n);
        }function r(t) {
            var e;if (!this._callbacks) return this;for (t = t.split(h); e = t.shift();) {
                delete this._callbacks[e];
            }return this;
        }function a(t) {
            var e, n, i, o, s;if (!this._callbacks) return this;for (t = t.split(h), i = [].slice.call(arguments, 1); (e = t.shift()) && (n = this._callbacks[e]);) {
                o = l(n.sync, this, [e].concat(i)), s = l(n.async, this, [e].concat(i)), o() && u(s);
            }return this;
        }function l(t, e, n) {
            function i() {
                for (var i, o = 0, s = t.length; !i && o < s; o += 1) {
                    i = !1 === t[o].apply(e, n);
                }return !i;
            }return i;
        }function c(t, e) {
            return t.bind ? t.bind(e) : function () {
                t.apply(e, [].slice.call(arguments, 0));
            };
        }var u = n(68),
            h = /\s+/;t.exports = { onSync: s, onAsync: o, off: r, trigger: a };
    }, function (t, e) {
        function n() {
            throw new Error("setTimeout has not been defined");
        }function i() {
            throw new Error("clearTimeout has not been defined");
        }function o(t) {
            if (u === setTimeout) return setTimeout(t, 0);if ((u === n || !u) && setTimeout) return u = setTimeout, setTimeout(t, 0);try {
                return u(t, 0);
            } catch (e) {
                try {
                    return u.call(null, t, 0);
                } catch (e) {
                    return u.call(this, t, 0);
                }
            }
        }function s(t) {
            if (h === clearTimeout) return clearTimeout(t);if ((h === i || !h) && clearTimeout) return h = clearTimeout, clearTimeout(t);try {
                return h(t);
            } catch (e) {
                try {
                    return h.call(null, t);
                } catch (e) {
                    return h.call(this, t);
                }
            }
        }function r() {
            g && d && (g = !1, d.length ? f = d.concat(f) : m = -1, f.length && a());
        }function a() {
            if (!g) {
                var t = o(r);g = !0;for (var e = f.length; e;) {
                    for (d = f, f = []; ++m < e;) {
                        d && d[m].run();
                    }m = -1, e = f.length;
                }d = null, g = !1, s(t);
            }
        }function l(t, e) {
            this.fun = t, this.array = e;
        }function c() {}var u,
            h,
            p = t.exports = {};!function () {
            try {
                u = "function" == typeof setTimeout ? setTimeout : n;
            } catch (t) {
                u = n;
            }try {
                h = "function" == typeof clearTimeout ? clearTimeout : i;
            } catch (t) {
                h = i;
            }
        }();var d,
            f = [],
            g = !1,
            m = -1;p.nextTick = function (t) {
            var e = new Array(arguments.length - 1);if (arguments.length > 1) for (var n = 1; n < arguments.length; n++) {
                e[n - 1] = arguments[n];
            }f.push(new l(t, e)), 1 !== f.length || g || o(a);
        }, l.prototype.run = function () {
            this.fun.apply(null, this.array);
        }, p.title = "browser", p.browser = !0, p.env = {}, p.argv = [], p.version = "", p.versions = {}, p.on = c, p.addListener = c, p.once = c, p.off = c, p.removeListener = c, p.removeAllListeners = c, p.emit = c, p.prependListener = c, p.prependOnceListener = c, p.listeners = function (t) {
            return [];
        }, p.binding = function (t) {
            throw new Error("process.binding is not supported");
        }, p.cwd = function () {
            return "/";
        }, p.chdir = function (t) {
            throw new Error("process.chdir is not supported");
        }, p.umask = function () {
            return 0;
        };
    }, function (t, e) {
        t.exports = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 14 20"><path d="M7 0C3.13 0 0 3.13 0 7c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5C5.62 9.5 4.5 8.38 4.5 7S5.62 4.5 7 4.5 9.5 5.62 9.5 7 8.38 9.5 7 9.5z"/></svg>\n';
    }, function (t, e, n) {
        "use strict";
        Object.defineProperty(e, "__esModule", { value: !0 }), e.default = "1.10.0";
    }, function (t, e, n) {
        "use strict";
        function i(t) {
            return t && t.__esModule ? t : { default: t };
        }function o(t) {
            var e = s({}, c.default, t.templates);return { source: (0, a.default)(s({}, t, { formatInputValue: e.value, templates: void 0 })), templates: e, displayKey: "value", name: "places" };
        }Object.defineProperty(e, "__esModule", { value: !0 });var s = Object.assign || function (t) {
            for (var e = 1; e < arguments.length; e++) {
                var n = arguments[e];for (var i in n) {
                    Object.prototype.hasOwnProperty.call(n, i) && (t[i] = n[i]);
                }
            }return t;
        };e.default = o;var r = n(24),
            a = i(r),
            l = n(25),
            c = i(l);
    }, function (t, e, n) {
        "use strict";
        "language" in navigator || (navigator.language = navigator.userLanguage && navigator.userLanguage.replace(/-[a-z]{2}$/, String.prototype.toUpperCase) || "en-US");
    }, function (t, e) {
        function n(t, e) {
            if (e = e || {}, void 0 === t) throw new Error(r);var n = !0 === e.prepend ? "prepend" : "append",
                a = void 0 !== e.container ? e.container : document.querySelector("head"),
                l = o.indexOf(a);-1 === l && (l = o.push(a) - 1, s[l] = {});var c;return void 0 !== s[l] && void 0 !== s[l][n] ? c = s[l][n] : (c = s[l][n] = i(), "prepend" === n ? a.insertBefore(c, a.childNodes[0]) : a.appendChild(c)), 65279 === t.charCodeAt(0) && (t = t.substr(1, t.length)), c.styleSheet ? c.styleSheet.cssText += t : c.textContent += t, c;
        }function i() {
            var t = document.createElement("style");return t.setAttribute("type", "text/css"), t;
        }var o = [],
            s = [],
            r = "insert-css: You need to provide a CSS string. Usage: insertCss(cssString[, options]).";t.exports = n, t.exports.insertCss = n;
    }, function (t, e) {
        t.exports = ".algolia-places {\n  width: 100%;\n}\n\n.ap-input, .ap-hint {\n  width: 100%;\n  padding-right: 35px;\n  padding-left: 16px;\n  line-height: 40px;\n  height: 40px;\n  border: 1px solid #CCC;\n  border-radius: 3px;\n  outline: none;\n  font: inherit;\n  appearance: none;\n  -webkit-appearance: none;\n  box-sizing: border-box;\n}\n\n.ap-input::-webkit-search-decoration {\n  -webkit-appearance: none;\n}\n\n.ap-input::-ms-clear {\n  display: none;\n}\n\n.ap-input:hover ~ .ap-input-icon svg,\n.ap-input:focus ~ .ap-input-icon svg,\n.ap-input-icon:hover svg {\n  fill: #aaaaaa;\n}\n\n.ap-dropdown-menu {\n  width: 100%;\n  background: #ffffff;\n  box-shadow: 0 1px 10px rgba(0, 0, 0, 0.2), 0 2px 4px 0 rgba(0, 0, 0, 0.1);\n  border-radius: 3px;\n  margin-top: 3px;\n  overflow: hidden;\n}\n\n.ap-suggestion {\n  cursor: pointer;\n  height: 46px;\n  line-height: 46px;\n  padding-left: 18px;\n  overflow: hidden;\n}\n\n.ap-suggestion em {\n  font-weight: bold;\n  font-style: normal;\n}\n\n.ap-address {\n  font-size: smaller;\n  margin-left: 12px;\n  color: #aaaaaa;\n}\n\n.ap-suggestion-icon {\n  margin-right: 10px;\n  width: 14px;\n  height: 20px;\n  vertical-align: middle;\n}\n\n.ap-suggestion-icon svg {\n  -webkit-transform: scale(0.9) translateY(2px);\n          transform: scale(0.9) translateY(2px);\n  fill: #cfcfcf;\n}\n\n.ap-input-icon {\n  border: 0;\n  background: transparent;\n  position: absolute;\n  top: 0;\n  bottom: 0;\n  right: 16px;\n  outline: none;\n}\n\n.ap-input-icon.ap-icon-pin {\n  cursor: initial;\n}\n\n.ap-input-icon svg {\n  fill: #cfcfcf;\n  position: absolute;\n  top: 50%;\n  right: 0;\n  -webkit-transform: translateY(-50%);\n          transform: translateY(-50%);\n}\n\n.ap-cursor {\n  background: #efefef;\n}\n\n.ap-cursor .ap-suggestion-icon svg {\n  -webkit-transform: scale(1) translateY(2px);\n          transform: scale(1) translateY(2px);\n  fill: #aaaaaa;\n}\n\n.ap-footer {\n  opacity: .8;\n  text-align: right;\n  padding: .5em 1em .5em 0;\n  font-size: 12px;\n  line-height: 12px;\n}\n\n.ap-footer a {\n  color: inherit;\n  text-decoration: none;\n}\n\n.ap-footer a svg {\n  vertical-align: text-bottom;\n  max-width: 60px;\n}\n\n.ap-footer:hover {\n  opacity: 1;\n}\n";
    }, function (t, e, n) {
        function i(t, e) {
            return function (n, i, s) {
                if ("function" == typeof n && "object" == (void 0 === i ? "undefined" : _typeof(i)) || "object" == (void 0 === s ? "undefined" : _typeof(s))) throw new o.AlgoliaSearchError("index.search usage is index.search(query, params, cb)");0 === arguments.length || "function" == typeof n ? (s = n, n = "") : 1 !== arguments.length && "function" != typeof i || (s = i, i = void 0), "object" == (void 0 === n ? "undefined" : _typeof(n)) && null !== n ? (i = n, n = void 0) : void 0 !== n && null !== n || (n = "");var r = "";void 0 !== n && (r += t + "=" + encodeURIComponent(n));var a;return void 0 !== i && (i.additionalUA && (a = i.additionalUA, delete i.additionalUA), r = this.as._getSearchParams(i, r)), this._search(r, e, s, a);
            };
        }t.exports = i;var o = n(6);
    }, function (t, e, n) {
        t.exports = function (t, e) {
            var i = n(76),
                o = n(3),
                s = {};return o(i(t), function (n) {
                !0 !== e(n) && (s[n] = t[n]);
            }), s;
        };
    }, function (t, e, n) {
        "use strict";
        function i(t) {
            t && t.el || o.error("EventBus initialized without el"), this.$el = s.element(t.el);
        }var o = n(0),
            s = n(1);o.mixin(i.prototype, { trigger: function trigger(t) {
                var e = [].slice.call(arguments, 1),
                    n = o.Event("autocomplete:" + t);return this.$el.trigger(n, e), n;
            } }), t.exports = i;
    }, function (t, e, n) {
        "use strict";
        t.exports = { wrapper: '<span class="%ROOT%"></span>', dropdown: '<span class="%PREFIX%%DROPDOWN_MENU%"></span>', dataset: '<div class="%PREFIX%%DATASET%-%CLASS%"></div>', suggestions: '<span class="%PREFIX%%SUGGESTIONS%"></span>', suggestion: '<div class="%PREFIX%%SUGGESTION%"></div>' };
    }, function (t, e, n) {
        "use strict";
        t.exports = function (t) {
            var e = t.match(/Algolia for vanilla JavaScript (\d+\.)(\d+\.)(\d+)/);if (e) return [e[1], e[2], e[3]];
        };
    }, function (t, e) {
        t.exports = "0.31.0";
    }, function (t, e, n) {
        "use strict";
        function i(t) {
            return t && t.__esModule ? t : { default: t };
        }function o(t, e, n) {
            return e in t ? Object.defineProperty(t, e, { value: n, enumerable: !0, configurable: !0, writable: !0 }) : t[e] = n, t;
        }function s(t) {
            var e = t.algoliasearch,
                n = t.clientOptions,
                i = t.apiKey,
                s = t.appId,
                a = t.hitsPerPage,
                c = t.aroundLatLng,
                h = t.aroundRadius,
                p = t.aroundLatLngViaIP,
                d = t.insideBoundingBox,
                f = t.insidePolygon,
                g = t.countries,
                m = t.formatInputValue,
                v = t.computeQueryParams,
                y = void 0 === v ? function (t) {
                return t;
            } : v,
                b = t.useDeviceLocation,
                w = void 0 !== b && b,
                _ = t.language,
                x = void 0 === _ ? navigator.language.split("-")[0] : _,
                C = t.onHits,
                T = void 0 === C ? function () {} : C,
                S = t.onError,
                A = void 0 === S ? function (t) {
                throw t;
            } : S,
                E = t.onRateLimitReached,
                P = t.type,
                k = e.initPlaces(s, i, n);k.as.addAlgoliaAgent("Algolia Places " + u.default);var D = { countries: g, hitsPerPage: a || 5, language: x, type: P };Array.isArray(D.countries) && (D.countries = D.countries.map(function (t) {
                return t.toLowerCase();
            })), "string" == typeof D.language && (D.language = D.language.toLowerCase()), c ? D.aroundLatLng = c : void 0 !== p && (D.aroundLatLngViaIP = p), h && (D.aroundRadius = h), d && (D.insideBoundingBox = d), f && (D.insidePolygon = f);var O = void 0;return w && navigator.geolocation.watchPosition(function (t) {
                var e = t.coords;O = e.latitude + "," + e.longitude;
            }), function (t, e) {
                var n;return k.search(y(r({}, D, (n = {}, o(n, O ? "aroundLatLng" : void 0, O), o(n, "query", t), n)))).then(function (e) {
                    var n = e.hits.map(function (n, i) {
                        return (0, l.default)({ formatInputValue: m, hit: n, hitIndex: i, query: t, rawAnswer: e });
                    });return T({ hits: n, query: t, rawAnswer: e }), n;
                }).then(e).catch(function (t) {
                    if (429 === t.statusCode) return void E();A(t);
                });
            };
        }Object.defineProperty(e, "__esModule", { value: !0 });var r = Object.assign || function (t) {
            for (var e = 1; e < arguments.length; e++) {
                var n = arguments[e];for (var i in n) {
                    Object.prototype.hasOwnProperty.call(n, i) && (t[i] = n[i]);
                }
            }return t;
        };e.default = s;var a = n(29),
            l = i(a),
            c = n(13),
            u = i(c);
    }, function (t, e, n) {
        "use strict";
        function i(t) {
            return t && t.__esModule ? t : { default: t };
        }Object.defineProperty(e, "__esModule", { value: !0 });var o = n(30),
            s = i(o),
            r = n(28),
            a = i(r),
            l = n(32),
            c = i(l),
            u = n(36),
            h = i(u);e.default = { footer: '<div class="ap-footer">\n  Built by <a href="https://www.algolia.com/places" title="Search by Algolia" class="ap-footer-algolia">' + c.default.trim() + '</a>\n  using <a href="https://community.algolia.com/places/documentation.html#license" class="ap-footer-osm" title="Algolia Places data © OpenStreetMap contributors">' + h.default.trim() + " <span>data</span></a>\n  </div>", value: s.default, suggestion: a.default };
    }, function (t, e, n) {
        "use strict";
        function i(t) {
            for (var e = 0; e < t.length; e++) {
                var n = t[e],
                    i = n.match(/country\/(.*)?/);if (i) return i[1];
            }
        }Object.defineProperty(e, "__esModule", { value: !0 }), e.default = i;
    }, function (t, e, n) {
        "use strict";
        function i(t) {
            var e = { country: "country", city: "city", "amenity/bus_station": "busStop", "amenity/townhall": "townhall", "railway/station": "trainStation", "aeroway/aerodrome": "airport", "aeroway/terminal": "airport", "aeroway/gate": "airport" };for (var n in e) {
                if (-1 !== t.indexOf(n)) return e[n];
            }return "address";
        }Object.defineProperty(e, "__esModule", { value: !0 }), e.default = i;
    }, function (t, e, n) {
        "use strict";
        function i(t) {
            return t && t.__esModule ? t : { default: t };
        }function o(t) {
            var e = t.type,
                n = t.highlight,
                i = n.name,
                o = n.administrative,
                s = n.city,
                r = n.country;return ('<span class="ap-suggestion-icon">' + b[e].trim() + '</span>\n<span class="ap-name">' + i + '</span>\n<span class="ap-address">\n  ' + [s, o, r].filter(function (t) {
                return void 0 !== t;
            }).join(", ") + "</span>").replace(/\s*\n\s*/g, " ");
        }Object.defineProperty(e, "__esModule", { value: !0 }), e.default = o;var s = n(12),
            r = i(s),
            a = n(34),
            l = i(a),
            c = n(35),
            u = i(c),
            h = n(33),
            p = i(h),
            d = n(39),
            f = i(d),
            g = n(38),
            m = i(g),
            v = n(37),
            y = i(v),
            b = { address: r.default, city: l.default, country: u.default, busStop: p.default, trainStation: f.default, townhall: m.default, airport: y.default };
    }, function (t, e, n) {
        "use strict";
        function i(t) {
            return t && t.__esModule ? t : { default: t };
        }function o(t) {
            for (var e = t[0].value, n = [], i = 1; i < t.length; ++i) {
                "none" !== t[i].matchLevel && n.push({ index: i, words: t[i].matchedWords });
            }return 0 === n.length ? e : (n.sort(function (t, e) {
                return t.words > e.words ? -1 : t.words < e.words ? 1 : t.index - e.index;
            }), 0 === n[0].index ? e + " (" + t[n[1].index].value + ")" : t[n[0].index].value + " (" + e + ")");
        }function s(t) {
            var e = t.formatInputValue,
                n = t.hit,
                i = t.hitIndex,
                s = t.query,
                a = t.rawAnswer;try {
                var c = n.locale_names[0],
                    h = n.country,
                    p = n.administrative && n.administrative[0] !== c ? n.administrative[0] : void 0,
                    d = n.city && n.city[0] !== c ? n.city[0] : void 0,
                    f = n.suburb && n.suburb[0] !== c ? n.suburb[0] : void 0,
                    g = n.county && n.county[0] !== c ? n.county[0] : void 0,
                    m = { name: o(n._highlightResult.locale_names), city: d ? o(n._highlightResult.city) : void 0, administrative: p ? o(n._highlightResult.administrative) : void 0, country: h ? n._highlightResult.country.value : void 0, suburb: f ? o(n._highlightResult.suburb) : void 0, county: g ? o(n._highlightResult.county) : void 0 },
                    v = { name: c, administrative: p, county: g, city: d, suburb: f, country: h, countryCode: (0, l.default)(n._tags), type: (0, u.default)(n._tags), latlng: { lat: n._geoloc.lat, lng: n._geoloc.lng }, postcode: n.postcode && n.postcode[0] },
                    y = e(v);return r({}, v, { highlight: m, hit: n, hitIndex: i, query: s, rawAnswer: a, value: y });
            } catch (t) {
                return console.error("Could not parse object", n), console.error(t), { value: "Could not parse object" };
            }
        }Object.defineProperty(e, "__esModule", { value: !0 });var r = Object.assign || function (t) {
            for (var e = 1; e < arguments.length; e++) {
                var n = arguments[e];for (var i in n) {
                    Object.prototype.hasOwnProperty.call(n, i) && (t[i] = n[i]);
                }
            }return t;
        };e.default = s;var a = n(26),
            l = i(a),
            c = n(27),
            u = i(c);
    }, function (t, e, n) {
        "use strict";
        function i(t) {
            var e = t.administrative,
                n = t.city,
                i = t.country;return (t.name + ("country" !== t.type && void 0 !== i ? "," : "") + "\n " + (n ? n + "," : "") + "\n " + (e ? e + "," : "") + "\n " + (i || "")).replace(/\s*\n\s*/g, " ").trim();
        }Object.defineProperty(e, "__esModule", { value: !0 }), e.default = i;
    }, function (t, e) {
        "function" == typeof Object.create ? t.exports = function (t, e) {
            t.super_ = e, t.prototype = Object.create(e.prototype, { constructor: { value: t, enumerable: !1, writable: !0, configurable: !0 } });
        } : t.exports = function (t, e) {
            t.super_ = e;var n = function n() {};n.prototype = e.prototype, t.prototype = new n(), t.prototype.constructor = t;
        };
    }, function (t, e) {
        t.exports = '<svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" baseProfile="basic" viewBox="0 0 1366 362">\n  <linearGradient id="SVGID_1_" x1="428.2578" x2="434.1453" y1="404.1504" y2="409.8504" gradientUnits="userSpaceOnUse" gradientTransform="matrix(94.045 0 0 -94.072 -40381.527 38479.52)">\n    <stop offset="0" stop-color="#00AEFF"/>\n    <stop offset="1" stop-color="#3369E7"/>\n  </linearGradient>\n  <path d="M61.8 15.4h242.8c23.9 0 43.4 19.4 43.4 43.4v242.9c0 23.9-19.4 43.4-43.4 43.4H61.8c-23.9 0-43.4-19.4-43.4-43.4v-243c0-23.9 19.4-43.3 43.4-43.3z" fill="url(#SVGID_1_)"/>\n  <path d="M187 98.7c-51.4 0-93.1 41.7-93.1 93.2S135.6 285 187 285s93.1-41.7 93.1-93.2-41.6-93.1-93.1-93.1zm0 158.8c-36.2 0-65.6-29.4-65.6-65.6s29.4-65.6 65.6-65.6 65.6 29.4 65.6 65.6-29.3 65.6-65.6 65.6zm0-117.8v48.9c0 1.4 1.5 2.4 2.8 1.7l43.4-22.5c1-.5 1.3-1.7.8-2.7-9-15.8-25.7-26.6-45-27.3-1 0-2 .8-2 1.9zm-60.8-35.9l-5.7-5.7c-5.6-5.6-14.6-5.6-20.2 0l-6.8 6.8c-5.6 5.6-5.6 14.6 0 20.2l5.6 5.6c.9.9 2.2.7 3-.2 3.3-4.5 6.9-8.8 10.9-12.8 4.1-4.1 8.3-7.7 12.9-11 1-.6 1.1-2 .3-2.9zM217.5 89V77.7c0-7.9-6.4-14.3-14.3-14.3h-33.3c-7.9 0-14.3 6.4-14.3 14.3v11.6c0 1.3 1.2 2.2 2.5 1.9 9.3-2.7 19.1-4.1 29-4.1 9.5 0 18.9 1.3 28 3.8 1.2.3 2.4-.6 2.4-1.9z" fill="#FFFFFF"/>\n  <path d="M842.5 267.6c0 26.7-6.8 46.2-20.5 58.6-13.7 12.4-34.6 18.6-62.8 18.6-10.3 0-31.7-2-48.8-5.8l6.3-31c14.3 3 33.2 3.8 43.1 3.8 15.7 0 26.9-3.2 33.6-9.6s10-15.9 10-28.5v-6.4c-3.9 1.9-9 3.8-15.3 5.8-6.3 1.9-13.6 2.9-21.8 2.9-10.8 0-20.6-1.7-29.5-5.1-8.9-3.4-16.6-8.4-22.9-15-6.3-6.6-11.3-14.9-14.8-24.8s-5.3-27.6-5.3-40.6c0-12.2 1.9-27.5 5.6-37.7 3.8-10.2 9.2-19 16.5-26.3 7.2-7.3 16-12.9 26.3-17s22.4-6.7 35.5-6.7c12.7 0 24.4 1.6 35.8 3.5 11.4 1.9 21.1 3.9 29 6.1v155.2zm-108.7-77.2c0 16.4 3.6 34.6 10.8 42.2 7.2 7.6 16.5 11.4 27.9 11.4 6.2 0 12.1-.9 17.6-2.6 5.5-1.7 9.9-3.7 13.4-6.1v-97.1c-2.8-.6-14.5-3-25.8-3.3-14.2-.4-25 5.4-32.6 14.7-7.5 9.3-11.3 25.6-11.3 40.8zm294.3 0c0 13.2-1.9 23.2-5.8 34.1s-9.4 20.2-16.5 27.9c-7.1 7.7-15.6 13.7-25.6 17.9s-25.4 6.6-33.1 6.6c-7.7-.1-23-2.3-32.9-6.6-9.9-4.3-18.4-10.2-25.5-17.9-7.1-7.7-12.6-17-16.6-27.9s-6-20.9-6-34.1c0-13.2 1.8-25.9 5.8-36.7 4-10.8 9.6-20 16.8-27.7s15.8-13.6 25.6-17.8c9.9-4.2 20.8-6.2 32.6-6.2s22.7 2.1 32.7 6.2c10 4.2 18.6 10.1 25.6 17.8 7.1 7.7 12.6 16.9 16.6 27.7 4.2 10.8 6.3 23.5 6.3 36.7zm-40 .1c0-16.9-3.7-31-10.9-40.8-7.2-9.9-17.3-14.8-30.2-14.8-12.9 0-23 4.9-30.2 14.8-7.2 9.9-10.7 23.9-10.7 40.8 0 17.1 3.6 28.6 10.8 38.5 7.2 10 17.3 14.9 30.2 14.9 12.9 0 23-5 30.2-14.9 7.2-10 10.8-21.4 10.8-38.5zm127.1 86.4c-64.1.3-64.1-51.8-64.1-60.1L1051 32l39.1-6.2v183.6c0 4.7 0 34.5 25.1 34.6v32.9zm68.9 0h-39.3V108.1l39.3-6.2v175zm-19.7-193.5c13.1 0 23.8-10.6 23.8-23.7S1177.6 36 1164.4 36s-23.8 10.6-23.8 23.7 10.7 23.7 23.8 23.7zm117.4 18.6c12.9 0 23.8 1.6 32.6 4.8 8.8 3.2 15.9 7.7 21.1 13.4s8.9 13.5 11.1 21.7c2.3 8.2 3.4 17.2 3.4 27.1v100.6c-6 1.3-15.1 2.8-27.3 4.6s-25.9 2.7-41.1 2.7c-10.1 0-19.4-1-27.7-2.9-8.4-1.9-15.5-5-21.5-9.3-5.9-4.3-10.5-9.8-13.9-16.6-3.3-6.8-5-16.4-5-26.4 0-9.6 1.9-15.7 5.6-22.3 3.8-6.6 8.9-12 15.3-16.2 6.5-4.2 13.9-7.2 22.4-9s17.4-2.7 26.6-2.7c4.3 0 8.8.3 13.6.8s9.8 1.4 15.2 2.7v-6.4c0-4.5-.5-8.8-1.6-12.8-1.1-4.1-3-7.6-5.6-10.7-2.7-3.1-6.2-5.5-10.6-7.2s-10-3-16.7-3c-9 0-17.2 1.1-24.7 2.4-7.5 1.3-13.7 2.8-18.4 4.5l-4.7-32.1c4.9-1.7 12.2-3.4 21.6-5.1s19.5-2.6 30.3-2.6zm3.3 141.9c12 0 20.9-.7 27.1-1.9v-39.8c-2.2-.6-5.3-1.3-9.4-1.9-4.1-.6-8.6-1-13.6-1-4.3 0-8.7.3-13.1 1-4.4.6-8.4 1.8-11.9 3.5s-6.4 4.1-8.5 7.2c-2.2 3.1-3.2 4.9-3.2 9.6 0 9.2 3.2 14.5 9 18 5.9 3.6 13.7 5.3 23.6 5.3zM512.9 103c12.9 0 23.8 1.6 32.6 4.8 8.8 3.2 15.9 7.7 21.1 13.4 5.3 5.8 8.9 13.5 11.1 21.7 2.3 8.2 3.4 17.2 3.4 27.1v100.6c-6 1.3-15.1 2.8-27.3 4.6-12.2 1.8-25.9 2.7-41.1 2.7-10.1 0-19.4-1-27.7-2.9-8.4-1.9-15.5-5-21.5-9.3-5.9-4.3-10.5-9.8-13.9-16.6-3.3-6.8-5-16.4-5-26.4 0-9.6 1.9-15.7 5.6-22.3 3.8-6.6 8.9-12 15.3-16.2 6.5-4.2 13.9-7.2 22.4-9s17.4-2.7 26.6-2.7c4.3 0 8.8.3 13.6.8 4.7.5 9.8 1.4 15.2 2.7v-6.4c0-4.5-.5-8.8-1.6-12.8-1.1-4.1-3-7.6-5.6-10.7-2.7-3.1-6.2-5.5-10.6-7.2-4.4-1.7-10-3-16.7-3-9 0-17.2 1.1-24.7 2.4-7.5 1.3-13.7 2.8-18.4 4.5l-4.7-32.1c4.9-1.7 12.2-3.4 21.6-5.1 9.4-1.8 19.5-2.6 30.3-2.6zm3.4 142c12 0 20.9-.7 27.1-1.9v-39.8c-2.2-.6-5.3-1.3-9.4-1.9-4.1-.6-8.6-1-13.6-1-4.3 0-8.7.3-13.1 1-4.4.6-8.4 1.8-11.9 3.5s-6.4 4.1-8.5 7.2c-2.2 3.1-3.2 4.9-3.2 9.6 0 9.2 3.2 14.5 9 18s13.7 5.3 23.6 5.3zm158.5 31.9c-64.1.3-64.1-51.8-64.1-60.1L610.6 32l39.1-6.2v183.6c0 4.7 0 34.5 25.1 34.6v32.9z" fill="#182359"/></svg>';
    }, function (t, e) {
        t.exports = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 54.9 50.5"><path d="M9.6 12.7H8.5c-2.3 0-4.1 1.9-4.1 4.1v1.1c0 2.2 1.8 4 4 4.1v21.7h-.7c-1.3 0-2.3 1-2.3 2.3h7.1c0-1.3-1-2.3-2.3-2.3h-.5V22.1c2.2-.1 4-1.9 4-4.1v-1.1c0-2.3-1.8-4.2-4.1-4.2zM46 7.6h-7.5c0-1.8-1.5-3.3-3.3-3.3h-3.6c-1.8 0-3.3 1.5-3.3 3.3H21c-2.5 0-4.6 2-4.6 4.6v26.3c0 1.7 1.3 3.1 3 3.1h.8v1.6c0 1.7 1.4 3.1 3.1 3.1 1.7 0 3-1.4 3-3.1v-1.6h14.3v1.6c0 1.7 1.4 3.1 3.1 3.1 1.7 0 3.1-1.4 3.1-3.1v-1.6h.8c1.7 0 3.1-1.4 3.1-3.1V12.2c-.2-2.5-2.2-4.6-4.7-4.6zm-27.4 4.6c0-1.3 1.1-2.4 2.4-2.4h25c1.3 0 2.4 1.1 2.4 2.4v.3c0 1.3-1.1 2.4-2.4 2.4H21c-1.3 0-2.4-1.1-2.4-2.4v-.3zM21 38c-1.5 0-2.7-1.2-2.7-2.7 0-1.5 1.2-2.7 2.7-2.7 1.5 0 2.7 1.2 2.7 2.7 0 1.5-1.2 2.7-2.7 2.7zm0-10.1c-1.3 0-2.4-1.1-2.4-2.4v-6.6c0-1.3 1.1-2.4 2.4-2.4h25c1.3 0 2.4 1.1 2.4 2.4v6.6c0 1.3-1.1 2.4-2.4 2.4H21zm24.8 10c-1.5 0-2.7-1.2-2.7-2.7 0-1.5 1.2-2.7 2.7-2.7 1.5 0 2.7 1.2 2.7 2.7 0 1.5-1.2 2.7-2.7 2.7z"/></svg>\n';
    }, function (t, e) {
        t.exports = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 18 19"><path d="M12 9V3L9 0 6 3v2H0v14h18V9h-6zm-8 8H2v-2h2v2zm0-4H2v-2h2v2zm0-4H2V7h2v2zm6 8H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V7h2v2zm0-4H8V3h2v2zm6 12h-2v-2h2v2zm0-4h-2v-2h2v2z"/></svg>\n';
    }, function (t, e) {
        t.exports = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">\n  <path d="M10 0C4.48 0 0 4.48 0 10s4.48 10 10 10 10-4.48 10-10S15.52 0 10 0zM9 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L7 13v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H6V8h2c.55 0 1-.45 1-1V5h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/>\n</svg>\n';
    }, function (t, e) {
        t.exports = '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12">\n  <path fill="#797979" fill-rule="evenodd" d="M6.577.5L5.304.005 2.627 1.02 0 0l.992 2.767-.986 2.685.998 2.76-1 2.717.613.22 3.39-3.45.563.06.726-.69s-.717-.92-.91-1.86c.193-.146.184-.14.355-.285C4.1 1.93 6.58.5 6.58.5zm-4.17 11.354l.22.12 2.68-1.05 2.62 1.04 2.644-1.03 1.02-2.717-.33-.944s-1.13 1.26-3.44.878c-.174.29-.25.37-.25.37s-1.11-.31-1.683-.89c-.573.58-.795.71-.795.71l.08.634-2.76 2.89zm6.26-4.395c1.817 0 3.29-1.53 3.29-3.4 0-1.88-1.473-3.4-3.29-3.4s-3.29 1.52-3.29 3.4c0 1.87 1.473 3.4 3.29 3.4z"/>\n</svg>\n';
    }, function (t, e) {
        t.exports = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path d="M22.9 1.1s1.3.3-4.3 6.5l.7 3.8.2-.2c.4-.4 1-.4 1.3 0 .4.4.4 1 0 1.3l-1.2 1.2.3 1.7.1-.1c.4-.4 1-.4 1.3 0 .4.4.4 1 0 1.3l-1.1 1.1c.2 1.9.3 3.6.1 4.5 0 0-1.2 1.2-1.8.5 0 0-2.3-7.7-3.8-11.1-5.9 6-6.4 5.6-6.4 5.6s1.2 3.8-.2 5.2l-2.3-4.3h.1l-4.3-2.3c1.3-1.3 5.2-.2 5.2-.2s-.5-.4 5.6-6.3C8.9 7.7 1.2 5.5 1.2 5.5c-.7-.7.5-1.8.5-1.8.9-.2 2.6-.1 4.5.1l1.1-1.1c.4-.4 1-.4 1.3 0 .4.4.4 1 0 1.3l1.7.3 1.2-1.2c.4-.4 1-.4 1.3 0 .4.4.4 1 0 1.3l-.2.2 3.8.7c6.2-5.5 6.5-4.2 6.5-4.2z"/></svg>\n';
    }, function (t, e) {
        t.exports = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path d="M12 .6L2.5 6.9h18.9L12 .6zM3.8 8.2c-.7 0-1.3.6-1.3 1.3v8.8L.3 22.1c-.2.3-.3.5-.3.6 0 .6.8.6 1.3.6h21.5c.4 0 1.3 0 1.3-.6 0-.2-.1-.3-.3-.6l-2.2-3.8V9.5c0-.7-.6-1.3-1.3-1.3H3.8zm2.5 2.5c.7 0 1.1.6 1.3 1.3v7.6H5.1V12c0-.7.5-1.3 1.2-1.3zm5.7 0c.7 0 1.3.6 1.3 1.3v7.6h-2.5V12c-.1-.7.5-1.3 1.2-1.3zm5.7 0c.7 0 1.3.6 1.3 1.3v7.6h-2.5V12c-.1-.7.5-1.3 1.2-1.3z"/></svg>\n';
    }, function (t, e) {
        t.exports = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 15 20">\n  <path d="M13.105 20l-2.366-3.354H4.26L1.907 20H0l3.297-4.787c-1.1-.177-2.196-1.287-2.194-2.642V2.68C1.1 1.28 2.317-.002 3.973 0h7.065c1.647-.002 2.863 1.28 2.86 2.676v9.895c.003 1.36-1.094 2.47-2.194 2.647L15 20h-1.895zM6.11 2h2.78c.264 0 .472-.123.472-.27v-.46c0-.147-.22-.268-.472-.27H6.11c-.252.002-.47.123-.47.27v.46c0 .146.206.27.47.27zm6.26 3.952V4.175c-.004-.74-.5-1.387-1.436-1.388H4.066c-.936 0-1.43.648-1.436 1.388v1.777c-.002.86.644 1.384 1.436 1.388h6.868c.793-.004 1.44-.528 1.436-1.388zm-8.465 5.386c-.69-.003-1.254.54-1.252 1.21-.002.673.56 1.217 1.252 1.222.697-.006 1.26-.55 1.262-1.22-.002-.672-.565-1.215-1.262-1.212zm8.42 1.21c-.005-.67-.567-1.213-1.265-1.21-.69-.003-1.253.54-1.25 1.21-.003.673.56 1.217 1.25 1.222.698-.006 1.26-.55 1.264-1.22z"/>\n</svg>\n';
    }, function (t, e, n) {
        "use strict";
        function i(t) {
            return t && t.__esModule ? t : { default: t };
        }function o(t) {
            var e = t.container,
                n = t.style,
                i = t.autocompleteOptions,
                r = void 0 === i ? {} : i;if (e instanceof NodeList) {
                if (e.length > 1) throw new Error(C.default.multiContainers);return o(s({}, t, { container: e[0] }));
            }if ("string" == typeof e) {
                var l = document.querySelectorAll(e);return o(s({}, t, { container: l }));
            }if (!(e instanceof HTMLInputElement)) throw new Error(C.default.badContainer);var u = new a.default(),
                p = "ap" + (!1 === n ? "-nostyle" : ""),
                f = s({ autoselect: !0, hint: !1, cssClasses: { root: "algolia-places" + (!1 === n ? "-nostyle" : ""), prefix: p }, debug: !1 }, r),
                m = (0, d.default)(s({}, t, { algoliasearch: c.default, onHits: function onHits(t) {
                    var e = t.hits,
                        n = t.rawAnswer,
                        i = t.query;return u.emit("suggestions", { rawAnswer: n, query: i, suggestions: e });
                }, onError: function onError(t) {
                    return u.emit("error", t);
                }, onRateLimitReached: function onRateLimitReached() {
                    if (0 === u.listenerCount("limit")) return void console.log(C.default.rateLimitReached);u.emit("limit", { message: C.default.rateLimitReached });
                }, container: void 0 })),
                y = (0, h.default)(e, f, m),
                b = e.parentNode;["selected", "autocompleted"].forEach(function (t) {
                y.on("autocomplete:" + t, function (t, e) {
                    u.emit("change", { rawAnswer: e.rawAnswer, query: e.query, suggestion: e, suggestionIndex: e.hitIndex });
                });
            }), y.on("autocomplete:cursorchanged", function (t, e) {
                u.emit("cursorchanged", { rawAnswer: e.rawAnswer, query: e.query, suggestion: e, suggestionIndex: e.hitIndex });
            });var w = document.createElement("button");w.setAttribute("type", "button"), w.setAttribute("aria-label", "clear"), w.classList.add(p + "-input-icon"), w.classList.add(p + "-icon-clear"), w.innerHTML = g.default, b.appendChild(w), w.style.display = "none";var _ = document.createElement("button");_.setAttribute("type", "button"), _.setAttribute("aria-label", "focus"), _.classList.add(p + "-input-icon"), _.classList.add(p + "-icon-pin"), _.innerHTML = v.default, b.appendChild(_), _.addEventListener("click", function () {
                return y.focus();
            }), w.addEventListener("click", function () {
                y.autocomplete.setVal(""), y.focus(), w.style.display = "none", _.style.display = "", u.emit("clear");
            });var x = "",
                T = function T() {
                var t = y.val();"" === t ? (_.style.display = "", w.style.display = "none", x !== t && u.emit("clear")) : (w.style.display = "", _.style.display = "none"), x = t;
            };return b.querySelector("." + p + "-input").addEventListener("input", T), ["open", "close", "getVal"].forEach(function (t) {
                u[t] = function () {
                    var e;(e = y.autocomplete)[t].apply(e, arguments);
                };
            }), u.destroy = function () {
                var t;b.querySelector("." + p + "-input").removeEventListener("input", T), (t = y.autocomplete).destroy.apply(t, arguments);
            }, u.setVal = function () {
                var t;x = arguments.length <= 0 ? void 0 : arguments[0], (t = y.autocomplete).setVal.apply(t, arguments);
            }, u.autocomplete = y, u;
        }Object.defineProperty(e, "__esModule", { value: !0 });var s = Object.assign || function (t) {
            for (var e = 1; e < arguments.length; e++) {
                var n = arguments[e];for (var i in n) {
                    Object.prototype.hasOwnProperty.call(n, i) && (t[i] = n[i]);
                }
            }return t;
        };e.default = o;var r = n(75),
            a = i(r),
            l = n(43),
            c = i(l),
            u = n(54),
            h = i(u);n(15);var p = n(14),
            d = i(p),
            f = n(79),
            g = i(f),
            m = n(12),
            v = i(m),
            y = n(17),
            b = i(y),
            w = n(16),
            _ = i(w),
            x = n(64),
            C = i(x);(0, _.default)(b.default, { prepend: !0 });
    }, function (t, e, n) {
        function i(t, e, i) {
            var s = n(8)("algoliasearch"),
                r = n(2),
                a = n(5),
                c = n(7),
                u = "Usage: algoliasearch(applicationID, apiKey, opts)";if (!0 !== i._allowEmptyCredentials && !t) throw new l.AlgoliaSearchError("Please provide an application ID. " + u);if (!0 !== i._allowEmptyCredentials && !e) throw new l.AlgoliaSearchError("Please provide an API key. " + u);this.applicationID = t, this.apiKey = e, this.hosts = { read: [], write: [] }, i = i || {}, this._timeouts = i.timeouts || { connect: 1e3, read: 2e3, write: 3e4 }, i.timeout && (this._timeouts.connect = this._timeouts.read = this._timeouts.write = i.timeout);var h = i.protocol || "https:";if (/:$/.test(h) || (h += ":"), "http:" !== h && "https:" !== h) throw new l.AlgoliaSearchError("protocol must be `http:` or `https:` (was `" + i.protocol + "`)");if (this._checkAppIdData(), i.hosts) a(i.hosts) ? (this.hosts.read = r(i.hosts), this.hosts.write = r(i.hosts)) : (this.hosts.read = r(i.hosts.read), this.hosts.write = r(i.hosts.write));else {
                var p = c(this._shuffleResult, function (e) {
                    return t + "-" + e + ".algolianet.com";
                }),
                    d = (!1 === i.dsn ? "" : "-dsn") + ".algolia.net";this.hosts.read = [this.applicationID + d].concat(p), this.hosts.write = [this.applicationID + ".algolia.net"].concat(p);
            }this.hosts.read = c(this.hosts.read, o(h)), this.hosts.write = c(this.hosts.write, o(h)), this.extraHeaders = {}, this.cache = i._cache || {}, this._ua = i._ua, this._useCache = !(void 0 !== i._useCache && !i._cache) || i._useCache, this._useFallback = void 0 === i.useFallback || i.useFallback, this._setTimeout = i._setTimeout, s("init done, %j", this);
        }function o(t) {
            return function (e) {
                return t + "//" + e.toLowerCase();
            };
        }function s(t) {
            if (void 0 === Array.prototype.toJSON) return JSON.stringify(t);var e = Array.prototype.toJSON;delete Array.prototype.toJSON;var n = JSON.stringify(t);return Array.prototype.toJSON = e, n;
        }function r(t) {
            for (var e, n, i = t.length; 0 !== i;) {
                n = Math.floor(Math.random() * i), i -= 1, e = t[i], t[i] = t[n], t[n] = e;
            }return t;
        }function a(t) {
            var e = {};for (var n in t) {
                if (Object.prototype.hasOwnProperty.call(t, n)) {
                    var i;i = "x-algolia-api-key" === n || "x-algolia-application-id" === n ? "**hidden for security purposes**" : t[n], e[n] = i;
                }
            }return e;
        }t.exports = i;var l = n(6),
            c = n(49),
            u = n(42),
            h = n(52),
            p = n.i({ NODE_ENV: "production" }).RESET_APP_DATA_TIMER && parseInt(n.i({ NODE_ENV: "production" }).RESET_APP_DATA_TIMER, 10) || 12e4;i.prototype.initIndex = function (t) {
            return new u(this, t);
        }, i.prototype.setExtraHeader = function (t, e) {
            this.extraHeaders[t.toLowerCase()] = e;
        }, i.prototype.getExtraHeader = function (t) {
            return this.extraHeaders[t.toLowerCase()];
        }, i.prototype.unsetExtraHeader = function (t) {
            delete this.extraHeaders[t.toLowerCase()];
        }, i.prototype.addAlgoliaAgent = function (t) {
            -1 === this._ua.indexOf(";" + t) && (this._ua += ";" + t);
        }, i.prototype._jsonRequest = function (t) {
            function e(n, c) {
                function v(t) {
                    var e = t && t.body && t.body.message && t.body.status || t.statusCode || t && t.body && 200;r("received response: statusCode: %s, computed statusCode: %d, headers: %j", t.statusCode, e, t.headers);var n = 2 === Math.floor(e / 100),
                        s = new Date();if (m.push({ currentHost: C, headers: a(o), content: i || null, contentLength: void 0 !== i ? i.length : null, method: c.method, timeouts: c.timeouts, url: c.url, startTime: x, endTime: s, duration: s - x, statusCode: e }), n) return p._useCache && h && (h[_] = t.responseText), t.body;if (4 !== Math.floor(e / 100)) return d += 1, b();r("unrecoverable error");var u = new l.AlgoliaSearchError(t.body && t.body.message, { debugData: m, statusCode: e });return p._promise.reject(u);
                }function y(e) {
                    r("error: %s, stack: %s", e.message, e.stack);var n = new Date();return m.push({ currentHost: C, headers: a(o), content: i || null, contentLength: void 0 !== i ? i.length : null, method: c.method, timeouts: c.timeouts, url: c.url, startTime: x, endTime: n, duration: n - x }), e instanceof l.AlgoliaSearchError || (e = new l.Unknown(e && e.message, e)), d += 1, e instanceof l.Unknown || e instanceof l.UnparsableJSON || d >= p.hosts[t.hostType].length && (f || !g) ? (e.debugData = m, p._promise.reject(e)) : e instanceof l.RequestTimeout ? w() : b();
                }function b() {
                    return r("retrying request"), p._incrementHostIndex(t.hostType), e(n, c);
                }function w() {
                    return r("retrying request with higher timeout"), p._incrementHostIndex(t.hostType), p._incrementTimeoutMultipler(), c.timeouts = p._getTimeoutsForRequest(t.hostType), e(n, c);
                }p._checkAppIdData();var _,
                    x = new Date();if (p._useCache && (_ = t.url), p._useCache && i && (_ += "_body_" + c.body), p._useCache && h && void 0 !== h[_]) return r("serving response from cache"), p._promise.resolve(JSON.parse(h[_]));if (d >= p.hosts[t.hostType].length) return !g || f ? (r("could not get any response"), p._promise.reject(new l.AlgoliaSearchError("Cannot connect to the AlgoliaSearch API. Send an email to support@algolia.com to report and resolve the issue. Application id was: " + p.applicationID, { debugData: m }))) : (r("switching to fallback"), d = 0, c.method = t.fallback.method, c.url = t.fallback.url, c.jsonBody = t.fallback.body, c.jsonBody && (c.body = s(c.jsonBody)), o = p._computeRequestHeaders({ additionalUA: u, headers: t.headers }), c.timeouts = p._getTimeoutsForRequest(t.hostType), p._setHostIndexByType(0, t.hostType), f = !0, e(p._request.fallback, c));var C = p._getHostByType(t.hostType),
                    T = C + c.url,
                    S = { body: c.body, jsonBody: c.jsonBody, method: c.method, headers: o, timeouts: c.timeouts, debug: r };return r("method: %s, url: %s, headers: %j, timeouts: %d", S.method, T, S.headers, S.timeouts), n === p._request.fallback && r("using fallback"), n.call(p, T, S).then(v, y);
            }this._checkAppIdData();var i,
                o,
                r = n(8)("algoliasearch:" + t.url),
                u = t.additionalUA || "",
                h = t.cache,
                p = this,
                d = 0,
                f = !1,
                g = p._useFallback && p._request.fallback && t.fallback;this.apiKey.length > 500 && void 0 !== t.body && (void 0 !== t.body.params || void 0 !== t.body.requests) ? (t.body.apiKey = this.apiKey, o = this._computeRequestHeaders({ additionalUA: u, withApiKey: !1, headers: t.headers })) : o = this._computeRequestHeaders({ additionalUA: u, headers: t.headers }), void 0 !== t.body && (i = s(t.body)), r("request start");var m = [],
                v = e(p._request, { url: t.url, method: t.method, body: i, jsonBody: t.body, timeouts: p._getTimeoutsForRequest(t.hostType) });if ("function" != typeof t.callback) return v;v.then(function (e) {
                c(function () {
                    t.callback(null, e);
                }, p._setTimeout || setTimeout);
            }, function (e) {
                c(function () {
                    t.callback(e);
                }, p._setTimeout || setTimeout);
            });
        }, i.prototype._getSearchParams = function (t, e) {
            if (void 0 === t || null === t) return e;for (var n in t) {
                null !== n && void 0 !== t[n] && t.hasOwnProperty(n) && (e += "" === e ? "" : "&", e += n + "=" + encodeURIComponent("[object Array]" === Object.prototype.toString.call(t[n]) ? s(t[n]) : t[n]));
            }return e;
        }, i.prototype._computeRequestHeaders = function (t) {
            var e = n(3),
                i = t.additionalUA ? this._ua + ";" + t.additionalUA : this._ua,
                o = { "x-algolia-agent": i, "x-algolia-application-id": this.applicationID };return !1 !== t.withApiKey && (o["x-algolia-api-key"] = this.apiKey), this.userToken && (o["x-algolia-usertoken"] = this.userToken), this.securityTags && (o["x-algolia-tagfilters"] = this.securityTags), e(this.extraHeaders, function (t, e) {
                o[e] = t;
            }), t.headers && e(t.headers, function (t, e) {
                o[e] = t;
            }), o;
        }, i.prototype.search = function (t, e, i) {
            var o = n(5),
                s = n(7);if (!o(t)) throw new Error("Usage: client.search(arrayOfQueries[, callback])");"function" == typeof e ? (i = e, e = {}) : void 0 === e && (e = {});var r = this,
                a = { requests: s(t, function (t) {
                    var e = "";return void 0 !== t.query && (e += "query=" + encodeURIComponent(t.query)), { indexName: t.indexName, params: r._getSearchParams(t.params, e) };
                }) },
                l = s(a.requests, function (t, e) {
                return e + "=" + encodeURIComponent("/1/indexes/" + encodeURIComponent(t.indexName) + "?" + t.params);
            }).join("&"),
                c = "/1/indexes/*/queries";return void 0 !== e.strategy && (c += "?strategy=" + e.strategy), this._jsonRequest({ cache: this.cache, method: "POST", url: c, body: a, hostType: "read", fallback: { method: "GET", url: "/1/indexes/*", body: { params: l } }, callback: i });
        }, i.prototype.searchForFacetValues = function (t) {
            var e = n(5),
                i = n(7),
                o = "Usage: client.searchForFacetValues([{indexName, params: {facetName, facetQuery, ...params}}, ...queries])";if (!e(t)) throw new Error(o);var s = this;return s._promise.all(i(t, function (t) {
                if (!t || void 0 === t.indexName || void 0 === t.params.facetName || void 0 === t.params.facetQuery) throw new Error(o);var e = n(2),
                    i = n(19),
                    r = t.indexName,
                    a = t.params,
                    l = a.facetName,
                    c = i(e(a), function (t) {
                    return "facetName" === t;
                }),
                    u = s._getSearchParams(c, "");return s._jsonRequest({ cache: s.cache, method: "POST", url: "/1/indexes/" + encodeURIComponent(r) + "/facets/" + encodeURIComponent(l) + "/query",
                    hostType: "read", body: { params: u } });
            }));
        }, i.prototype.setSecurityTags = function (t) {
            if ("[object Array]" === Object.prototype.toString.call(t)) {
                for (var e = [], n = 0; n < t.length; ++n) {
                    if ("[object Array]" === Object.prototype.toString.call(t[n])) {
                        for (var i = [], o = 0; o < t[n].length; ++o) {
                            i.push(t[n][o]);
                        }e.push("(" + i.join(",") + ")");
                    } else e.push(t[n]);
                }t = e.join(",");
            }this.securityTags = t;
        }, i.prototype.setUserToken = function (t) {
            this.userToken = t;
        }, i.prototype.clearCache = function () {
            this.cache = {};
        }, i.prototype.setRequestTimeout = function (t) {
            t && (this._timeouts.connect = this._timeouts.read = this._timeouts.write = t);
        }, i.prototype.setTimeouts = function (t) {
            this._timeouts = t;
        }, i.prototype.getTimeouts = function () {
            return this._timeouts;
        }, i.prototype._getAppIdData = function () {
            var t = h.get(this.applicationID);return null !== t && this._cacheAppIdData(t), t;
        }, i.prototype._setAppIdData = function (t) {
            return t.lastChange = new Date().getTime(), this._cacheAppIdData(t), h.set(this.applicationID, t);
        }, i.prototype._checkAppIdData = function () {
            var t = this._getAppIdData(),
                e = new Date().getTime();return null === t || e - t.lastChange > p ? this._resetInitialAppIdData(t) : t;
        }, i.prototype._resetInitialAppIdData = function (t) {
            var e = t || {};return e.hostIndexes = { read: 0, write: 0 }, e.timeoutMultiplier = 1, e.shuffleResult = e.shuffleResult || r([1, 2, 3]), this._setAppIdData(e);
        }, i.prototype._cacheAppIdData = function (t) {
            this._hostIndexes = t.hostIndexes, this._timeoutMultiplier = t.timeoutMultiplier, this._shuffleResult = t.shuffleResult;
        }, i.prototype._partialAppIdDataUpdate = function (t) {
            var e = n(3),
                i = this._getAppIdData();return e(t, function (t, e) {
                i[e] = t;
            }), this._setAppIdData(i);
        }, i.prototype._getHostByType = function (t) {
            return this.hosts[t][this._getHostIndexByType(t)];
        }, i.prototype._getTimeoutMultiplier = function () {
            return this._timeoutMultiplier;
        }, i.prototype._getHostIndexByType = function (t) {
            return this._hostIndexes[t];
        }, i.prototype._setHostIndexByType = function (t, e) {
            var i = n(2),
                o = i(this._hostIndexes);return o[e] = t, this._partialAppIdDataUpdate({ hostIndexes: o }), t;
        }, i.prototype._incrementHostIndex = function (t) {
            return this._setHostIndexByType((this._getHostIndexByType(t) + 1) % this.hosts[t].length, t);
        }, i.prototype._incrementTimeoutMultipler = function () {
            var t = Math.max(this._timeoutMultiplier + 1, 4);return this._partialAppIdDataUpdate({ timeoutMultiplier: t });
        }, i.prototype._getTimeoutsForRequest = function (t) {
            return { connect: this._timeouts.connect * this._timeoutMultiplier, complete: this._timeouts[t] * this._timeoutMultiplier };
        };
    }, function (t, e, n) {
        function i(t, e) {
            this.indexName = e, this.as = t, this.typeAheadArgs = null, this.typeAheadValueOption = null, this.cache = {};
        }var o = n(18),
            s = n(47),
            r = n(48);t.exports = i, i.prototype.clearCache = function () {
            this.cache = {};
        }, i.prototype.search = o("query"), i.prototype.similarSearch = o("similarQuery"), i.prototype.browse = function (t, e, i) {
            var o,
                s,
                r = n(50),
                a = this;0 === arguments.length || 1 === arguments.length && "function" == typeof arguments[0] ? (o = 0, i = arguments[0], t = void 0) : "number" == typeof arguments[0] ? (o = arguments[0], "number" == typeof arguments[1] ? s = arguments[1] : "function" == typeof arguments[1] && (i = arguments[1], s = void 0), t = void 0, e = void 0) : "object" == _typeof(arguments[0]) ? ("function" == typeof arguments[1] && (i = arguments[1]), e = arguments[0], t = void 0) : "string" == typeof arguments[0] && "function" == typeof arguments[1] && (i = arguments[1], e = void 0), e = r({}, e || {}, { page: o, hitsPerPage: s, query: t });var l = this.as._getSearchParams(e, "");return this.as._jsonRequest({ method: "POST", url: "/1/indexes/" + encodeURIComponent(a.indexName) + "/browse", body: { params: l }, hostType: "read", callback: i });
        }, i.prototype.browseFrom = function (t, e) {
            return this.as._jsonRequest({ method: "POST", url: "/1/indexes/" + encodeURIComponent(this.indexName) + "/browse", body: { cursor: t }, hostType: "read", callback: e });
        }, i.prototype.searchForFacetValues = function (t, e) {
            var i = n(2),
                o = n(19);if (void 0 === t.facetName || void 0 === t.facetQuery) throw new Error("Usage: index.searchForFacetValues({facetName, facetQuery, ...params}[, callback])");var s = t.facetName,
                r = o(i(t), function (t) {
                return "facetName" === t;
            }),
                a = this.as._getSearchParams(r, "");return this.as._jsonRequest({ method: "POST", url: "/1/indexes/" + encodeURIComponent(this.indexName) + "/facets/" + encodeURIComponent(s) + "/query", hostType: "read", body: { params: a }, callback: e });
        }, i.prototype.searchFacet = s(function (t, e) {
            return this.searchForFacetValues(t, e);
        }, r("index.searchFacet(params[, callback])", "index.searchForFacetValues(params[, callback])")), i.prototype._search = function (t, e, n, i) {
            return this.as._jsonRequest({ cache: this.cache, method: "POST", url: e || "/1/indexes/" + encodeURIComponent(this.indexName) + "/query", body: { params: t }, hostType: "read", fallback: { method: "GET", url: "/1/indexes/" + encodeURIComponent(this.indexName), body: { params: t } }, callback: n, additionalUA: i });
        }, i.prototype.getObject = function (t, e, n) {
            var i = this;1 !== arguments.length && "function" != typeof e || (n = e, e = void 0);var o = "";if (void 0 !== e) {
                o = "?attributes=";for (var s = 0; s < e.length; ++s) {
                    0 !== s && (o += ","), o += e[s];
                }
            }return this.as._jsonRequest({ method: "GET", url: "/1/indexes/" + encodeURIComponent(i.indexName) + "/" + encodeURIComponent(t) + o, hostType: "read", callback: n });
        }, i.prototype.getObjects = function (t, e, i) {
            var o = n(5),
                s = n(7);if (!o(t)) throw new Error("Usage: index.getObjects(arrayOfObjectIDs[, callback])");var r = this;1 !== arguments.length && "function" != typeof e || (i = e, e = void 0);var a = { requests: s(t, function (t) {
                    var n = { indexName: r.indexName, objectID: t };return e && (n.attributesToRetrieve = e.join(",")), n;
                }) };return this.as._jsonRequest({ method: "POST", url: "/1/indexes/*/objects", hostType: "read", body: a, callback: i });
        }, i.prototype.as = null, i.prototype.indexName = null, i.prototype.typeAheadArgs = null, i.prototype.typeAheadValueOption = null;
    }, function (t, e, n) {
        "use strict";
        var i = n(41),
            o = n(44);t.exports = o(i, "(lite) ");
    }, function (t, e, n) {
        "use strict";
        var i = n(67),
            o = i.Promise || n(66).Promise;t.exports = function (t, e) {
            function s(t, e, i) {
                return i = n(2)(i || {}), i._ua = i._ua || s.ua, new r(t, e, i);
            }function r() {
                t.apply(this, arguments);
            }var a = n(31),
                l = n(6),
                c = n(45),
                u = n(46),
                h = n(51);e = e || "", s.version = n(53), s.ua = "Algolia for vanilla JavaScript " + e + s.version, s.initPlaces = h(s), i.__algolia = { debug: n(8), algoliasearch: s };var p = { hasXMLHttpRequest: "XMLHttpRequest" in i, hasXDomainRequest: "XDomainRequest" in i };return p.hasXMLHttpRequest && (p.cors = "withCredentials" in new XMLHttpRequest()), a(r, t), r.prototype._request = function (t, e) {
                return new o(function (n, i) {
                    function o() {
                        if (!f) {
                            clearTimeout(d);var t;try {
                                t = { body: JSON.parse(m.responseText), responseText: m.responseText, statusCode: m.status, headers: m.getAllResponseHeaders && m.getAllResponseHeaders() || {} };
                            } catch (e) {
                                t = new l.UnparsableJSON({ more: m.responseText });
                            }t instanceof l.UnparsableJSON ? i(t) : n(t);
                        }
                    }function s(t) {
                        f || (clearTimeout(d), i(new l.Network({ more: t })));
                    }function r() {
                        f = !0, m.abort(), i(new l.RequestTimeout());
                    }function a() {
                        v = !0, clearTimeout(d), d = setTimeout(r, e.timeouts.complete);
                    }function u() {
                        v || a();
                    }function h() {
                        !v && m.readyState > 1 && a();
                    }if (!p.cors && !p.hasXDomainRequest) return void i(new l.Network("CORS not supported"));t = c(t, e.headers);var d,
                        f,
                        g = e.body,
                        m = p.cors ? new XMLHttpRequest() : new XDomainRequest(),
                        v = !1;d = setTimeout(r, e.timeouts.connect), m.onprogress = u, "onreadystatechange" in m && (m.onreadystatechange = h), m.onload = o, m.onerror = s, m instanceof XMLHttpRequest ? m.open(e.method, t, !0) : m.open(e.method, t), p.cors && (g && ("POST" === e.method ? m.setRequestHeader("content-type", "application/x-www-form-urlencoded") : m.setRequestHeader("content-type", "application/json")), m.setRequestHeader("accept", "application/json")), m.send(g);
                });
            }, r.prototype._request.fallback = function (t, e) {
                return t = c(t, e.headers), new o(function (n, i) {
                    u(t, e, function (t, e) {
                        if (t) return void i(t);n(e);
                    });
                });
            }, r.prototype._promise = { reject: function reject(t) {
                    return o.reject(t);
                }, resolve: function resolve(t) {
                    return o.resolve(t);
                }, delay: function delay(t) {
                    return new o(function (e) {
                        setTimeout(e, t);
                    });
                }, all: function all(t) {
                    return o.all(t);
                } }, s;
        };
    }, function (t, e, n) {
        "use strict";
        function i(t, e) {
            return (/\?/.test(t) ? t += "&" : t += "?", t + o(e)
            );
        }t.exports = i;var o = n(78);
    }, function (t, e, n) {
        "use strict";
        function i(t, e, n) {
            function i() {
                e.debug("JSONP: success"), m || p || (m = !0, h || (e.debug("JSONP: Fail. Script loaded but did not call the callback"), a(), n(new o.JSONPScriptFail())));
            }function r() {
                "loaded" !== this.readyState && "complete" !== this.readyState || i();
            }function a() {
                clearTimeout(v), f.onload = null, f.onreadystatechange = null, f.onerror = null, d.removeChild(f);
            }function l() {
                try {
                    delete window[g], delete window[g + "_loaded"];
                } catch (t) {
                    window[g] = window[g + "_loaded"] = void 0;
                }
            }function c() {
                e.debug("JSONP: Script timeout"), p = !0, a(), n(new o.RequestTimeout());
            }function u() {
                e.debug("JSONP: Script error"), m || p || (a(), n(new o.JSONPScriptError()));
            }if ("GET" !== e.method) return void n(new Error("Method " + e.method + " " + t + " is not supported by JSONP."));e.debug("JSONP: start");var h = !1,
                p = !1;s += 1;var d = document.getElementsByTagName("head")[0],
                f = document.createElement("script"),
                g = "algoliaJSONP_" + s,
                m = !1;window[g] = function (t) {
                if (l(), p) return void e.debug("JSONP: Late answer, ignoring");h = !0, a(), n(null, { body: t });
            }, t += "&callback=" + g, e.jsonBody && e.jsonBody.params && (t += "&" + e.jsonBody.params);var v = setTimeout(c, e.timeouts.complete);f.onreadystatechange = r, f.onload = i, f.onerror = u, f.async = !0, f.defer = !0, f.src = t, d.appendChild(f);
        }t.exports = i;var o = n(6),
            s = 0;
    }, function (t, e) {
        t.exports = function (t, e) {
            function n() {
                return i || (console.warn(e), i = !0), t.apply(this, arguments);
            }var i = !1;return n;
        };
    }, function (t, e) {
        t.exports = function (t, e) {
            return "algoliasearch: `" + t + "` was replaced by `" + e + "`. Please see https://github.com/algolia/algoliasearch-client-javascript/wiki/Deprecated#" + t.toLowerCase().replace(/[\.\(\)]/g, "");
        };
    }, function (t, e) {
        t.exports = function (t, e) {
            e(t, 0);
        };
    }, function (t, e, n) {
        var i = n(3);t.exports = function t(e) {
            var n = Array.prototype.slice.call(arguments);return i(n, function (n) {
                for (var i in n) {
                    n.hasOwnProperty(i) && ("object" == _typeof(e[i]) && "object" == _typeof(n[i]) ? e[i] = t({}, e[i], n[i]) : void 0 !== n[i] && (e[i] = n[i]));
                }
            }), e;
        };
    }, function (t, e, n) {
        function i(t) {
            return function (e, i, s) {
                var r = n(2);s = s && r(s) || {}, s.hosts = s.hosts || ["places-dsn.algolia.net", "places-1.algolianet.com", "places-2.algolianet.com", "places-3.algolianet.com"], 0 !== arguments.length && "object" != (void 0 === e ? "undefined" : _typeof(e)) && void 0 !== e || (e = "", i = "", s._allowEmptyCredentials = !0);var a = t(e, i, s),
                    l = a.initIndex("places");return l.search = o("query", "/1/places/query"), l.getObject = function (t, e) {
                    return this.as._jsonRequest({ method: "GET", url: "/1/places/" + encodeURIComponent(t), hostType: "read", callback: e });
                }, l;
            };
        }t.exports = i;var o = n(18);
    }, function (t, e, n) {
        (function (e) {
            function i(t, e) {
                return l("localStorage failed with", e), r(), a = u, a.get(t);
            }function o(t, e) {
                return 1 === arguments.length ? a.get(t) : a.set(t, e);
            }function s() {
                try {
                    return "localStorage" in e && null !== e.localStorage && (e.localStorage[c] || e.localStorage.setItem(c, JSON.stringify({})), !0);
                } catch (t) {
                    return !1;
                }
            }function r() {
                try {
                    e.localStorage.removeItem(c);
                } catch (t) {}
            }var a,
                l = n(8)("algoliasearch:src/hostIndexState.js"),
                c = "algoliasearch-client-js",
                u = { state: {}, set: function set(t, e) {
                    return this.state[t] = e, this.state[t];
                }, get: function get(t) {
                    return this.state[t] || null;
                } },
                h = { set: function set(t, n) {
                    u.set(t, n);try {
                        var o = JSON.parse(e.localStorage[c]);return o[t] = n, e.localStorage[c] = JSON.stringify(o), o[t];
                    } catch (e) {
                        return i(t, e);
                    }
                }, get: function get(t) {
                    try {
                        return JSON.parse(e.localStorage[c])[t] || null;
                    } catch (e) {
                        return i(t, e);
                    }
                } };a = s() ? h : u, t.exports = { get: o, set: o, supportsLocalStorage: s };
        }).call(e, n(4));
    }, function (t, e, n) {
        "use strict";
        t.exports = "3.27.1";
    }, function (t, e, n) {
        "use strict";
        t.exports = n(62);
    }, function (t, e, n) {
        "use strict";
        function i(t) {
            t = t || {}, t.templates = t.templates || {}, t.source || u.error("missing source"), t.name && !r(t.name) && u.error("invalid dataset name: " + t.name), this.query = null, this._isEmpty = !0, this.highlight = !!t.highlight, this.name = void 0 === t.name || null === t.name ? u.getUniqueId() : t.name, this.source = t.source, this.displayFn = o(t.display || t.displayKey), this.debounce = t.debounce, this.templates = s(t.templates, this.displayFn), this.css = u.mixin({}, d, t.appendTo ? d.appendTo : {}), this.cssClasses = t.cssClasses = u.mixin({}, d.defaultClasses, t.cssClasses || {}), this.cssClasses.prefix = t.cssClasses.formattedPrefix || u.formatPrefix(this.cssClasses.prefix, this.cssClasses.noPrefix);var e = u.className(this.cssClasses.prefix, this.cssClasses.dataset);this.$el = t.$menu && t.$menu.find(e + "-" + this.name).length > 0 ? h.element(t.$menu.find(e + "-" + this.name)[0]) : h.element(p.dataset.replace("%CLASS%", this.name).replace("%PREFIX%", this.cssClasses.prefix).replace("%DATASET%", this.cssClasses.dataset)), this.$menu = t.$menu, this.clearCachedSuggestions();
        }function o(t) {
            function e(e) {
                return e[t];
            }return t = t || "value", u.isFunction(t) ? t : e;
        }function s(t, e) {
            function n(t) {
                return "<p>" + e(t) + "</p>";
            }return { empty: t.empty && u.templatify(t.empty), header: t.header && u.templatify(t.header), footer: t.footer && u.templatify(t.footer), suggestion: t.suggestion || n };
        }function r(t) {
            return (/^[_a-zA-Z0-9-]+$/.test(t)
            );
        }var a = "aaDataset",
            l = "aaValue",
            c = "aaDatum",
            u = n(0),
            h = n(1),
            p = n(21),
            d = n(9),
            f = n(10);i.extractDatasetName = function (t) {
            return h.element(t).data(a);
        }, i.extractValue = function (t) {
            return h.element(t).data(l);
        }, i.extractDatum = function (t) {
            var e = h.element(t).data(c);return "string" == typeof e && (e = JSON.parse(e)), e;
        }, u.mixin(i.prototype, f, { _render: function _render(t, e) {
                function n() {
                    var e = [].slice.call(arguments, 0);return e = [{ query: t, isEmpty: !0 }].concat(e), d.templates.empty.apply(this, e);
                }function i() {
                    function t(t) {
                        var e,
                            n = p.suggestion.replace("%PREFIX%", s.cssClasses.prefix).replace("%SUGGESTION%", s.cssClasses.suggestion);return e = h.element(n).attr({ role: "option", id: ["option", Math.floor(1e8 * Math.random())].join("-") }).append(d.templates.suggestion.apply(this, [t].concat(o))), e.data(a, d.name), e.data(l, d.displayFn(t) || void 0), e.data(c, JSON.stringify(t)), e.children().each(function () {
                            h.element(this).css(s.css.suggestionChild);
                        }), e;
                    }var n,
                        i,
                        o = [].slice.call(arguments, 0),
                        s = this,
                        r = p.suggestions.replace("%PREFIX%", this.cssClasses.prefix).replace("%SUGGESTIONS%", this.cssClasses.suggestions);return n = h.element(r).css(this.css.suggestions), i = u.map(e, t), n.append.apply(n, i), n;
                }function o() {
                    var e = [].slice.call(arguments, 0);return e = [{ query: t, isEmpty: !r }].concat(e), d.templates.header.apply(this, e);
                }function s() {
                    var e = [].slice.call(arguments, 0);return e = [{ query: t, isEmpty: !r }].concat(e), d.templates.footer.apply(this, e);
                }if (this.$el) {
                    var r,
                        d = this,
                        f = [].slice.call(arguments, 2);this.$el.empty(), r = e && e.length, this._isEmpty = !r, !r && this.templates.empty ? this.$el.html(n.apply(this, f)).prepend(d.templates.header ? o.apply(this, f) : null).append(d.templates.footer ? s.apply(this, f) : null) : r && this.$el.html(i.apply(this, f)).prepend(d.templates.header ? o.apply(this, f) : null).append(d.templates.footer ? s.apply(this, f) : null), this.$menu && this.$menu.addClass(this.cssClasses.prefix + (r ? "with" : "without") + "-" + this.name).removeClass(this.cssClasses.prefix + (r ? "without" : "with") + "-" + this.name), this.trigger("rendered", t);
                }
            }, getRoot: function getRoot() {
                return this.$el;
            }, update: function update(t) {
                function e(e) {
                    if (!this.canceled && t === this.query) {
                        var n = [].slice.call(arguments, 1);this.cacheSuggestions(t, e, n), this._render.apply(this, [t, e].concat(n));
                    }
                }if (this.query = t, this.canceled = !1, this.shouldFetchFromCache(t)) e.apply(this, [this.cachedSuggestions].concat(this.cachedRenderExtraArgs));else {
                    var n = this,
                        i = function i() {
                        n.canceled || n.source(t, e.bind(n));
                    };if (this.debounce) {
                        var o = function o() {
                            n.debounceTimeout = null, i();
                        };clearTimeout(this.debounceTimeout), this.debounceTimeout = setTimeout(o, this.debounce);
                    } else i();
                }
            }, cacheSuggestions: function cacheSuggestions(t, e, n) {
                this.cachedQuery = t, this.cachedSuggestions = e, this.cachedRenderExtraArgs = n;
            }, shouldFetchFromCache: function shouldFetchFromCache(t) {
                return this.cachedQuery === t && this.cachedSuggestions && this.cachedSuggestions.length;
            }, clearCachedSuggestions: function clearCachedSuggestions() {
                delete this.cachedQuery, delete this.cachedSuggestions, delete this.cachedRenderExtraArgs;
            }, cancel: function cancel() {
                this.canceled = !0;
            }, clear: function clear() {
                this.cancel(), this.$el.empty(), this.trigger("rendered", "");
            }, isEmpty: function isEmpty() {
                return this._isEmpty;
            }, destroy: function destroy() {
                this.clearCachedSuggestions(), this.$el = null;
            } }), t.exports = i;
    }, function (t, e, n) {
        "use strict";
        function i(t) {
            var e,
                n,
                i,
                a = this;t = t || {}, t.menu || s.error("menu is required"), s.isArray(t.datasets) || s.isObject(t.datasets) || s.error("1 or more datasets required"), t.datasets || s.error("datasets is required"), this.isOpen = !1, this.isEmpty = !0, this.minLength = t.minLength || 0, this.templates = {}, this.appendTo = t.appendTo || !1, this.css = s.mixin({}, c, t.appendTo ? c.appendTo : {}), this.cssClasses = t.cssClasses = s.mixin({}, c.defaultClasses, t.cssClasses || {}), this.cssClasses.prefix = t.cssClasses.formattedPrefix || s.formatPrefix(this.cssClasses.prefix, this.cssClasses.noPrefix), e = s.bind(this._onSuggestionClick, this), n = s.bind(this._onSuggestionMouseEnter, this), i = s.bind(this._onSuggestionMouseLeave, this);var l = s.className(this.cssClasses.prefix, this.cssClasses.suggestion);this.$menu = r.element(t.menu).on("mouseenter.aa", l, n).on("mouseleave.aa", l, i).on("click.aa", l, e), this.$container = t.appendTo ? t.wrapper : this.$menu, t.templates && t.templates.header && (this.templates.header = s.templatify(t.templates.header), this.$menu.prepend(this.templates.header())), t.templates && t.templates.empty && (this.templates.empty = s.templatify(t.templates.empty), this.$empty = r.element('<div class="' + s.className(this.cssClasses.prefix, this.cssClasses.empty, !0) + '"></div>'), this.$menu.append(this.$empty), this.$empty.hide()), this.datasets = s.map(t.datasets, function (e) {
                return o(a.$menu, e, t.cssClasses);
            }), s.each(this.datasets, function (t) {
                var e = t.getRoot();e && 0 === e.parent().length && a.$menu.append(e), t.onSync("rendered", a._onRendered, a);
            }), t.templates && t.templates.footer && (this.templates.footer = s.templatify(t.templates.footer), this.$menu.append(this.templates.footer()));var u = this;r.element(window).resize(function () {
                u._redraw();
            });
        }function o(t, e, n) {
            return new i.Dataset(s.mixin({ $menu: t, cssClasses: n }, e));
        }var s = n(0),
            r = n(1),
            a = n(10),
            l = n(55),
            c = n(9);s.mixin(i.prototype, a, { _onSuggestionClick: function _onSuggestionClick(t) {
                this.trigger("suggestionClicked", r.element(t.currentTarget));
            }, _onSuggestionMouseEnter: function _onSuggestionMouseEnter(t) {
                var e = r.element(t.currentTarget);if (!e.hasClass(s.className(this.cssClasses.prefix, this.cssClasses.cursor, !0))) {
                    this._removeCursor();var n = this;setTimeout(function () {
                        n._setCursor(e, !1);
                    }, 0);
                }
            }, _onSuggestionMouseLeave: function _onSuggestionMouseLeave(t) {
                t.relatedTarget && r.element(t.relatedTarget).closest("." + s.className(this.cssClasses.prefix, this.cssClasses.cursor, !0)).length > 0 || (this._removeCursor(), this.trigger("cursorRemoved"));
            }, _onRendered: function _onRendered(t, e) {
                function n(t) {
                    return t.isEmpty();
                }function i(t) {
                    return t.templates && t.templates.empty;
                }if (this.isEmpty = s.every(this.datasets, n), this.isEmpty) {
                    if (e.length >= this.minLength && this.trigger("empty"), this.$empty) {
                        if (e.length < this.minLength) this._hide();else {
                            var o = this.templates.empty({ query: this.datasets[0] && this.datasets[0].query });this.$empty.html(o), this.$empty.show(), this._show();
                        }
                    } else s.any(this.datasets, i) ? e.length < this.minLength ? this._hide() : this._show() : this._hide();
                } else this.isOpen && (this.$empty && (this.$empty.empty(), this.$empty.hide()), e.length >= this.minLength ? this._show() : this._hide());this.trigger("datasetRendered");
            }, _hide: function _hide() {
                this.$container.hide();
            }, _show: function _show() {
                this.$container.css("display", "block"), this._redraw(), this.trigger("shown");
            }, _redraw: function _redraw() {
                this.isOpen && this.appendTo && this.trigger("redrawn");
            }, _getSuggestions: function _getSuggestions() {
                return this.$menu.find(s.className(this.cssClasses.prefix, this.cssClasses.suggestion));
            }, _getCursor: function _getCursor() {
                return this.$menu.find(s.className(this.cssClasses.prefix, this.cssClasses.cursor)).first();
            }, _setCursor: function _setCursor(t, e) {
                t.first().addClass(s.className(this.cssClasses.prefix, this.cssClasses.cursor, !0)).attr("aria-selected", "true"), this.trigger("cursorMoved", e);
            }, _removeCursor: function _removeCursor() {
                this._getCursor().removeClass(s.className(this.cssClasses.prefix, this.cssClasses.cursor, !0)).removeAttr("aria-selected");
            }, _moveCursor: function _moveCursor(t) {
                var e, n, i, o;if (this.isOpen) {
                    if (n = this._getCursor(), e = this._getSuggestions(), this._removeCursor(), i = e.index(n) + t, -1 == (i = (i + 1) % (e.length + 1) - 1)) return void this.trigger("cursorRemoved");i < -1 && (i = e.length - 1), this._setCursor(o = e.eq(i), !0), this._ensureVisible(o);
                }
            }, _ensureVisible: function _ensureVisible(t) {
                var e, n, i, o;e = t.position().top, n = e + t.height() + parseInt(t.css("margin-top"), 10) + parseInt(t.css("margin-bottom"), 10), i = this.$menu.scrollTop(), o = this.$menu.height() + parseInt(this.$menu.css("padding-top"), 10) + parseInt(this.$menu.css("padding-bottom"), 10), e < 0 ? this.$menu.scrollTop(i + e) : o < n && this.$menu.scrollTop(i + (n - o));
            }, close: function close() {
                this.isOpen && (this.isOpen = !1, this._removeCursor(), this._hide(), this.trigger("closed"));
            }, open: function open() {
                this.isOpen || (this.isOpen = !0, this.isEmpty || this._show(), this.trigger("opened"));
            }, setLanguageDirection: function setLanguageDirection(t) {
                this.$menu.css("ltr" === t ? this.css.ltr : this.css.rtl);
            }, moveCursorUp: function moveCursorUp() {
                this._moveCursor(-1);
            }, moveCursorDown: function moveCursorDown() {
                this._moveCursor(1);
            }, getDatumForSuggestion: function getDatumForSuggestion(t) {
                var e = null;return t.length && (e = { raw: l.extractDatum(t), value: l.extractValue(t), datasetName: l.extractDatasetName(t) }), e;
            }, getCurrentCursor: function getCurrentCursor() {
                return this._getCursor().first();
            }, getDatumForCursor: function getDatumForCursor() {
                return this.getDatumForSuggestion(this._getCursor().first());
            }, getDatumForTopSuggestion: function getDatumForTopSuggestion() {
                return this.getDatumForSuggestion(this._getSuggestions().first());
            }, cursorTopSuggestion: function cursorTopSuggestion() {
                this._setCursor(this._getSuggestions().first(), !1);
            }, update: function update(t) {
                function e(e) {
                    e.update(t);
                }s.each(this.datasets, e);
            }, empty: function empty() {
                function t(t) {
                    t.clear();
                }s.each(this.datasets, t), this.isEmpty = !0;
            }, isVisible: function isVisible() {
                return this.isOpen && !this.isEmpty;
            }, destroy: function destroy() {
                function t(t) {
                    t.destroy();
                }this.$menu.off(".aa"), this.$menu = null, s.each(this.datasets, t);
            } }), i.Dataset = l, t.exports = i;
    }, function (t, e, n) {
        "use strict";
        function i(t) {
            var e,
                n,
                i,
                s,
                r = this;t = t || {}, t.input || l.error("input is missing"), e = l.bind(this._onBlur, this), n = l.bind(this._onFocus, this), i = l.bind(this._onKeydown, this), s = l.bind(this._onInput, this), this.$hint = c.element(t.hint), this.$input = c.element(t.input).on("blur.aa", e).on("focus.aa", n).on("keydown.aa", i), 0 === this.$hint.length && (this.setHint = this.getHint = this.clearHint = this.clearHintIfInvalid = l.noop), l.isMsie() ? this.$input.on("keydown.aa keypress.aa cut.aa paste.aa", function (t) {
                a[t.which || t.keyCode] || l.defer(l.bind(r._onInput, r, t));
            }) : this.$input.on("input.aa", s), this.query = this.$input.val(), this.$overflowHelper = o(this.$input);
        }function o(t) {
            return c.element('<pre aria-hidden="true"></pre>').css({ position: "absolute", visibility: "hidden", whiteSpace: "pre", fontFamily: t.css("font-family"), fontSize: t.css("font-size"), fontStyle: t.css("font-style"), fontVariant: t.css("font-variant"), fontWeight: t.css("font-weight"), wordSpacing: t.css("word-spacing"), letterSpacing: t.css("letter-spacing"), textIndent: t.css("text-indent"), textRendering: t.css("text-rendering"), textTransform: t.css("text-transform") }).insertAfter(t);
        }function s(t, e) {
            return i.normalizeQuery(t) === i.normalizeQuery(e);
        }function r(t) {
            return t.altKey || t.ctrlKey || t.metaKey || t.shiftKey;
        }var a;a = { 9: "tab", 27: "esc", 37: "left", 39: "right", 13: "enter", 38: "up", 40: "down" };var l = n(0),
            c = n(1),
            u = n(10);i.normalizeQuery = function (t) {
            return (t || "").replace(/^\s*/g, "").replace(/\s{2,}/g, " ");
        }, l.mixin(i.prototype, u, { _onBlur: function _onBlur() {
                this.resetInputValue(), this.$input.removeAttr("aria-activedescendant"), this.trigger("blurred");
            }, _onFocus: function _onFocus() {
                this.trigger("focused");
            }, _onKeydown: function _onKeydown(t) {
                var e = a[t.which || t.keyCode];this._managePreventDefault(e, t), e && this._shouldTrigger(e, t) && this.trigger(e + "Keyed", t);
            }, _onInput: function _onInput() {
                this._checkInputValue();
            }, _managePreventDefault: function _managePreventDefault(t, e) {
                var n, i, o;switch (t) {case "tab":
                        i = this.getHint(), o = this.getInputValue(), n = i && i !== o && !r(e);break;case "up":case "down":
                        n = !r(e);break;default:
                        n = !1;}n && e.preventDefault();
            }, _shouldTrigger: function _shouldTrigger(t, e) {
                var n;switch (t) {case "tab":
                        n = !r(e);break;default:
                        n = !0;}return n;
            }, _checkInputValue: function _checkInputValue() {
                var t, e, n;t = this.getInputValue(), e = s(t, this.query), n = !(!e || !this.query) && this.query.length !== t.length, this.query = t, e ? n && this.trigger("whitespaceChanged", this.query) : this.trigger("queryChanged", this.query);
            }, focus: function focus() {
                this.$input.focus();
            }, blur: function blur() {
                this.$input.blur();
            }, getQuery: function getQuery() {
                return this.query;
            }, setQuery: function setQuery(t) {
                this.query = t;
            }, getInputValue: function getInputValue() {
                return this.$input.val();
            }, setInputValue: function setInputValue(t, e) {
                void 0 === t && (t = this.query), this.$input.val(t), e ? this.clearHint() : this._checkInputValue();
            }, expand: function expand() {
                this.$input.attr("aria-expanded", "true");
            }, collapse: function collapse() {
                this.$input.attr("aria-expanded", "false");
            }, setActiveDescendant: function setActiveDescendant(t) {
                this.$input.attr("aria-activedescendant", t);
            }, removeActiveDescendant: function removeActiveDescendant() {
                this.$input.removeAttr("aria-activedescendant");
            }, resetInputValue: function resetInputValue() {
                this.setInputValue(this.query, !0);
            }, getHint: function getHint() {
                return this.$hint.val();
            }, setHint: function setHint(t) {
                this.$hint.val(t);
            }, clearHint: function clearHint() {
                this.setHint("");
            }, clearHintIfInvalid: function clearHintIfInvalid() {
                var t, e, n;t = this.getInputValue(), e = this.getHint(), n = t !== e && 0 === e.indexOf(t), "" !== t && n && !this.hasOverflow() || this.clearHint();
            }, getLanguageDirection: function getLanguageDirection() {
                return (this.$input.css("direction") || "ltr").toLowerCase();
            }, hasOverflow: function hasOverflow() {
                var t = this.$input.width() - 2;return this.$overflowHelper.text(this.getInputValue()), this.$overflowHelper.width() >= t;
            }, isCursorAtEnd: function isCursorAtEnd() {
                var t, e, n;return t = this.$input.val().length, e = this.$input[0].selectionStart, l.isNumber(e) ? e === t : !document.selection || (n = document.selection.createRange(), n.moveStart("character", -t), t === n.text.length);
            }, destroy: function destroy() {
                this.$hint.off(".aa"), this.$input.off(".aa"), this.$hint = this.$input = this.$overflowHelper = null;
            } }), t.exports = i;
    }, function (t, e, n) {
        "use strict";
        function i(t) {
            var e, n;if (t = t || {}, t.input || l.error("missing input"), this.isActivated = !1, this.debug = !!t.debug, this.autoselect = !!t.autoselect, this.autoselectOnBlur = !!t.autoselectOnBlur, this.openOnFocus = !!t.openOnFocus, this.minLength = l.isNumber(t.minLength) ? t.minLength : 1, this.autoWidth = void 0 === t.autoWidth || !!t.autoWidth, this.clearOnSelected = !!t.clearOnSelected, t.hint = !!t.hint, t.hint && t.appendTo) throw new Error("[autocomplete.js] hint and appendTo options can't be used at the same time");this.css = t.css = l.mixin({}, f, t.appendTo ? f.appendTo : {}), this.cssClasses = t.cssClasses = l.mixin({}, f.defaultClasses, t.cssClasses || {}), this.cssClasses.prefix = t.cssClasses.formattedPrefix = l.formatPrefix(this.cssClasses.prefix, this.cssClasses.noPrefix), this.listboxId = t.listboxId = [this.cssClasses.root, "listbox", l.getUniqueId()].join("-");var s = o(t);this.$node = s.wrapper;var r = this.$input = s.input;e = s.menu, n = s.hint, t.dropdownMenuContainer && c.element(t.dropdownMenuContainer).css("position", "relative").append(e.css("top", "0")), r.on("blur.aa", function (t) {
                var n = document.activeElement;l.isMsie() && (e[0] === n || e[0].contains(n)) && (t.preventDefault(), t.stopImmediatePropagation(), l.defer(function () {
                    r.focus();
                }));
            }), e.on("mousedown.aa", function (t) {
                t.preventDefault();
            }), this.eventBus = t.eventBus || new u({ el: r }), this.dropdown = new i.Dropdown({ appendTo: t.appendTo, wrapper: this.$node, menu: e, datasets: t.datasets, templates: t.templates, cssClasses: t.cssClasses, minLength: this.minLength }).onSync("suggestionClicked", this._onSuggestionClicked, this).onSync("cursorMoved", this._onCursorMoved, this).onSync("cursorRemoved", this._onCursorRemoved, this).onSync("opened", this._onOpened, this).onSync("closed", this._onClosed, this).onSync("shown", this._onShown, this).onSync("empty", this._onEmpty, this).onSync("redrawn", this._onRedrawn, this).onAsync("datasetRendered", this._onDatasetRendered, this), this.input = new i.Input({ input: r, hint: n }).onSync("focused", this._onFocused, this).onSync("blurred", this._onBlurred, this).onSync("enterKeyed", this._onEnterKeyed, this).onSync("tabKeyed", this._onTabKeyed, this).onSync("escKeyed", this._onEscKeyed, this).onSync("upKeyed", this._onUpKeyed, this).onSync("downKeyed", this._onDownKeyed, this).onSync("leftKeyed", this._onLeftKeyed, this).onSync("rightKeyed", this._onRightKeyed, this).onSync("queryChanged", this._onQueryChanged, this).onSync("whitespaceChanged", this._onWhitespaceChanged, this), this._bindKeyboardShortcuts(t), this._setLanguageDirection();
        }function o(t) {
            var e, n, i, o;e = c.element(t.input), n = c.element(d.wrapper.replace("%ROOT%", t.cssClasses.root)).css(t.css.wrapper), t.appendTo || "block" !== e.css("display") || "table" !== e.parent().css("display") || n.css("display", "table-cell");var r = d.dropdown.replace("%PREFIX%", t.cssClasses.prefix).replace("%DROPDOWN_MENU%", t.cssClasses.dropdownMenu);i = c.element(r).css(t.css.dropdown).attr({ role: "listbox", id: t.listboxId }), t.templates && t.templates.dropdownMenu && i.html(l.templatify(t.templates.dropdownMenu)()), o = e.clone().css(t.css.hint).css(s(e)), o.val("").addClass(l.className(t.cssClasses.prefix, t.cssClasses.hint, !0)).removeAttr("id name placeholder required").prop("readonly", !0).attr({ "aria-hidden": "true", autocomplete: "off", spellcheck: "false", tabindex: -1 }), o.removeData && o.removeData(), e.data(a, { "aria-autocomplete": e.attr("aria-autocomplete"), "aria-expanded": e.attr("aria-expanded"), "aria-owns": e.attr("aria-owns"), autocomplete: e.attr("autocomplete"), dir: e.attr("dir"), role: e.attr("role"), spellcheck: e.attr("spellcheck"), style: e.attr("style"), type: e.attr("type") }), e.addClass(l.className(t.cssClasses.prefix, t.cssClasses.input, !0)).attr({ autocomplete: "off", spellcheck: !1, role: "combobox", "aria-autocomplete": t.datasets && t.datasets[0] && t.datasets[0].displayKey ? "both" : "list", "aria-expanded": "false", "aria-label": t.ariaLabel, "aria-owns": t.listboxId }).css(t.hint ? t.css.input : t.css.inputWithNoHint);try {
                e.attr("dir") || e.attr("dir", "auto");
            } catch (t) {}return n = t.appendTo ? n.appendTo(c.element(t.appendTo).eq(0)).eq(0) : e.wrap(n).parent(), n.prepend(t.hint ? o : null).append(i), { wrapper: n, input: e, hint: o, menu: i };
        }function s(t) {
            return { backgroundAttachment: t.css("background-attachment"), backgroundClip: t.css("background-clip"), backgroundColor: t.css("background-color"), backgroundImage: t.css("background-image"), backgroundOrigin: t.css("background-origin"), backgroundPosition: t.css("background-position"), backgroundRepeat: t.css("background-repeat"), backgroundSize: t.css("background-size") };
        }function r(t, e) {
            var n = t.find(l.className(e.prefix, e.input));l.each(n.data(a), function (t, e) {
                void 0 === t ? n.removeAttr(e) : n.attr(e, t);
            }), n.detach().removeClass(l.className(e.prefix, e.input, !0)).insertAfter(t), n.removeData && n.removeData(a), t.remove();
        }var a = "aaAttrs",
            l = n(0),
            c = n(1),
            u = n(20),
            h = n(57),
            p = n(56),
            d = n(21),
            f = n(9);l.mixin(i.prototype, { _bindKeyboardShortcuts: function _bindKeyboardShortcuts(t) {
                if (t.keyboardShortcuts) {
                    var e = this.$input,
                        n = [];l.each(t.keyboardShortcuts, function (t) {
                        "string" == typeof t && (t = t.toUpperCase().charCodeAt(0)), n.push(t);
                    }), c.element(document).keydown(function (t) {
                        var i = t.target || t.srcElement,
                            o = i.tagName;if (!i.isContentEditable && "INPUT" !== o && "SELECT" !== o && "TEXTAREA" !== o) {
                            var s = t.which || t.keyCode;-1 !== n.indexOf(s) && (e.focus(), t.stopPropagation(), t.preventDefault());
                        }
                    });
                }
            }, _onSuggestionClicked: function _onSuggestionClicked(t, e) {
                var n;(n = this.dropdown.getDatumForSuggestion(e)) && this._select(n);
            }, _onCursorMoved: function _onCursorMoved(t, e) {
                var n = this.dropdown.getDatumForCursor(),
                    i = this.dropdown.getCurrentCursor().attr("id");this.input.setActiveDescendant(i), n && (e && this.input.setInputValue(n.value, !0), this.eventBus.trigger("cursorchanged", n.raw, n.datasetName));
            }, _onCursorRemoved: function _onCursorRemoved() {
                this.input.resetInputValue(), this._updateHint(), this.eventBus.trigger("cursorremoved");
            }, _onDatasetRendered: function _onDatasetRendered() {
                this._updateHint(), this.eventBus.trigger("updated");
            }, _onOpened: function _onOpened() {
                this._updateHint(), this.input.expand(), this.eventBus.trigger("opened");
            }, _onEmpty: function _onEmpty() {
                this.eventBus.trigger("empty");
            }, _onRedrawn: function _onRedrawn() {
                this.$node.css("top", "0px"), this.$node.css("left", "0px");var t = this.$input[0].getBoundingClientRect();this.autoWidth && this.$node.css("width", t.width + "px");var e = this.$node[0].getBoundingClientRect(),
                    n = t.bottom - e.top;this.$node.css("top", n + "px");var i = t.left - e.left;this.$node.css("left", i + "px"), this.eventBus.trigger("redrawn");
            }, _onShown: function _onShown() {
                this.eventBus.trigger("shown"), this.autoselect && this.dropdown.cursorTopSuggestion();
            }, _onClosed: function _onClosed() {
                this.input.clearHint(), this.input.removeActiveDescendant(), this.input.collapse(), this.eventBus.trigger("closed");
            }, _onFocused: function _onFocused() {
                if (this.isActivated = !0, this.openOnFocus) {
                    var t = this.input.getQuery();t.length >= this.minLength ? this.dropdown.update(t) : this.dropdown.empty(), this.dropdown.open();
                }
            }, _onBlurred: function _onBlurred() {
                var t, e;t = this.dropdown.getDatumForCursor(), e = this.dropdown.getDatumForTopSuggestion(), this.debug || (this.autoselectOnBlur && t ? this._select(t) : this.autoselectOnBlur && e ? this._select(e) : (this.isActivated = !1, this.dropdown.empty(), this.dropdown.close()));
            }, _onEnterKeyed: function _onEnterKeyed(t, e) {
                var n, i;n = this.dropdown.getDatumForCursor(), i = this.dropdown.getDatumForTopSuggestion(), n ? (this._select(n), e.preventDefault()) : this.autoselect && i && (this._select(i), e.preventDefault());
            }, _onTabKeyed: function _onTabKeyed(t, e) {
                var n;(n = this.dropdown.getDatumForCursor()) ? (this._select(n), e.preventDefault()) : this._autocomplete(!0);
            }, _onEscKeyed: function _onEscKeyed() {
                this.dropdown.close(), this.input.resetInputValue();
            }, _onUpKeyed: function _onUpKeyed() {
                var t = this.input.getQuery();this.dropdown.isEmpty && t.length >= this.minLength ? this.dropdown.update(t) : this.dropdown.moveCursorUp(), this.dropdown.open();
            }, _onDownKeyed: function _onDownKeyed() {
                var t = this.input.getQuery();this.dropdown.isEmpty && t.length >= this.minLength ? this.dropdown.update(t) : this.dropdown.moveCursorDown(), this.dropdown.open();
            }, _onLeftKeyed: function _onLeftKeyed() {
                "rtl" === this.dir && this._autocomplete();
            }, _onRightKeyed: function _onRightKeyed() {
                "ltr" === this.dir && this._autocomplete();
            }, _onQueryChanged: function _onQueryChanged(t, e) {
                this.input.clearHintIfInvalid(), e.length >= this.minLength ? this.dropdown.update(e) : this.dropdown.empty(), this.dropdown.open(), this._setLanguageDirection();
            }, _onWhitespaceChanged: function _onWhitespaceChanged() {
                this._updateHint(), this.dropdown.open();
            }, _setLanguageDirection: function _setLanguageDirection() {
                var t = this.input.getLanguageDirection();this.dir !== t && (this.dir = t, this.$node.css("direction", t), this.dropdown.setLanguageDirection(t));
            }, _updateHint: function _updateHint() {
                var t, e, n, i, o, s;t = this.dropdown.getDatumForTopSuggestion(), t && this.dropdown.isVisible() && !this.input.hasOverflow() ? (e = this.input.getInputValue(), n = h.normalizeQuery(e), i = l.escapeRegExChars(n), o = new RegExp("^(?:" + i + ")(.+$)", "i"), s = o.exec(t.value), s ? this.input.setHint(e + s[1]) : this.input.clearHint()) : this.input.clearHint();
            }, _autocomplete: function _autocomplete(t) {
                var e, n, i, o;e = this.input.getHint(), n = this.input.getQuery(), i = t || this.input.isCursorAtEnd(), e && n !== e && i && (o = this.dropdown.getDatumForTopSuggestion(), o && this.input.setInputValue(o.value), this.eventBus.trigger("autocompleted", o.raw, o.datasetName));
            }, _select: function _select(t) {
                void 0 !== t.value && this.input.setQuery(t.value), this.clearOnSelected ? this.setVal("") : this.input.setInputValue(t.value, !0), this._setLanguageDirection(), !1 === this.eventBus.trigger("selected", t.raw, t.datasetName).isDefaultPrevented() && (this.dropdown.close(), l.defer(l.bind(this.dropdown.empty, this.dropdown)));
            }, open: function open() {
                if (!this.isActivated) {
                    var t = this.input.getInputValue();t.length >= this.minLength ? this.dropdown.update(t) : this.dropdown.empty();
                }this.dropdown.open();
            }, close: function close() {
                this.dropdown.close();
            }, setVal: function setVal(t) {
                t = l.toStr(t), this.isActivated ? this.input.setInputValue(t) : (this.input.setQuery(t), this.input.setInputValue(t, !0)), this._setLanguageDirection();
            }, getVal: function getVal() {
                return this.input.getQuery();
            }, destroy: function destroy() {
                this.input.destroy(), this.dropdown.destroy(), r(this.$node, this.cssClasses), this.$node = null;
            }, getWrapper: function getWrapper() {
                return this.dropdown.$container[0];
            } }), i.Dropdown = p, i.Input = h, i.sources = n(60), t.exports = i;
    }, function (t, e, n) {
        "use strict";
        var i = n(0),
            o = n(23),
            s = n(22);t.exports = function (t, e) {
            function n(n, o) {
                t.search(n, e, function (t, e) {
                    if (t) return void i.error(t.message);o(e.hits, e);
                });
            }var r = s(t.as._ua);return r && r[0] >= 3 && r[1] > 20 && (e = e || {}, e.additionalUA = "autocomplete.js " + o), n;
        };
    }, function (t, e, n) {
        "use strict";
        t.exports = { hits: n(59), popularIn: n(61) };
    }, function (t, e, n) {
        "use strict";
        var i = n(0),
            o = n(23),
            s = n(22);t.exports = function (t, e, n, r) {
            function a(a, l) {
                t.search(a, e, function (t, a) {
                    if (t) return void i.error(t.message);if (a.hits.length > 0) {
                        var h = a.hits[0],
                            p = i.mixin({ hitsPerPage: 0 }, n);delete p.source, delete p.index;var d = s(u.as._ua);return d && d[0] >= 3 && d[1] > 20 && (e.additionalUA = "autocomplete.js " + o), void u.search(c(h), p, function (t, e) {
                            if (t) return void i.error(t.message);var n = [];if (r.includeAll) {
                                var o = r.allTitle || "All departments";n.push(i.mixin({ facet: { value: o, count: e.nbHits } }, i.cloneDeep(h)));
                            }i.each(e.facets, function (t, e) {
                                i.each(t, function (t, o) {
                                    n.push(i.mixin({ facet: { facet: e, value: o, count: t } }, i.cloneDeep(h)));
                                });
                            });for (var s = 1; s < a.hits.length; ++s) {
                                n.push(a.hits[s]);
                            }l(n, a);
                        });
                    }l([]);
                });
            }var l = s(t.as._ua);if (l && l[0] >= 3 && l[1] > 20 && (e = e || {}, e.additionalUA = "autocomplete.js " + o), !n.source) return i.error("Missing 'source' key");var c = i.isFunction(n.source) ? n.source : function (t) {
                return t[n.source];
            };if (!n.index) return i.error("Missing 'index' key");var u = n.index;return r = r || {}, a;
        };
    }, function (t, e, n) {
        "use strict";
        function i(t, e, n, i) {
            n = s.isArray(n) ? n : [].slice.call(arguments, 2);var c = o(t).each(function (t, s) {
                var c = o(s),
                    u = new l({ el: c }),
                    h = i || new a({ input: c, eventBus: u, dropdownMenuContainer: e.dropdownMenuContainer, hint: void 0 === e.hint || !!e.hint, minLength: e.minLength, autoselect: e.autoselect, autoselectOnBlur: e.autoselectOnBlur, openOnFocus: e.openOnFocus, templates: e.templates, debug: e.debug, clearOnSelected: e.clearOnSelected, cssClasses: e.cssClasses, datasets: n, keyboardShortcuts: e.keyboardShortcuts, appendTo: e.appendTo, autoWidth: e.autoWidth });c.data(r, h);
            });return c.autocomplete = {}, s.each(["open", "close", "getVal", "setVal", "destroy", "getWrapper"], function (t) {
                c.autocomplete[t] = function () {
                    var e,
                        n = arguments;return c.each(function (i, s) {
                        var a = o(s).data(r);e = a[t].apply(a, n);
                    }), e;
                };
            }), c;
        }var o = n(63);n(1).element = o;var s = n(0);s.isArray = o.isArray, s.isFunction = o.isFunction, s.isObject = o.isPlainObject, s.bind = o.proxy, s.each = function (t, e) {
            function n(t, n) {
                return e(n, t);
            }o.each(t, n);
        }, s.map = o.map, s.mixin = o.extend, s.Event = o.Event;var r = "aaAutocomplete",
            a = n(58),
            l = n(20);i.sources = a.sources, i.escapeHighlightedString = s.escapeHighlightedString;var c = "autocomplete" in window,
            u = window.autocomplete;i.noConflict = function () {
            return c ? window.autocomplete = u : delete window.autocomplete, i;
        }, t.exports = i;
    }, function (t, e) {
        !function (e, n) {
            t.exports = function (t) {
                var e = function () {
                    function e(t) {
                        return null == t ? String(t) : K[G.call(t)] || "object";
                    }function n(t) {
                        return "function" == e(t);
                    }function i(t) {
                        return null != t && t == t.window;
                    }function o(t) {
                        return null != t && t.nodeType == t.DOCUMENT_NODE;
                    }function s(t) {
                        return "object" == e(t);
                    }function r(t) {
                        return s(t) && !i(t) && Object.getPrototypeOf(t) == Object.prototype;
                    }function a(t) {
                        var e = !!t && "length" in t && t.length,
                            n = S.type(t);return "function" != n && !i(t) && ("array" == n || 0 === e || "number" == typeof e && e > 0 && e - 1 in t);
                    }function l(t) {
                        return O.call(t, function (t) {
                            return null != t;
                        });
                    }function c(t) {
                        return t.length > 0 ? S.fn.concat.apply([], t) : t;
                    }function u(t) {
                        return t.replace(/::/g, "/").replace(/([A-Z]+)([A-Z][a-z])/g, "$1_$2").replace(/([a-z\d])([A-Z])/g, "$1_$2").replace(/_/g, "-").toLowerCase();
                    }function h(t) {
                        return t in L ? L[t] : L[t] = new RegExp("(^|\\s)" + t + "(\\s|$)");
                    }function p(t, e) {
                        return "number" != typeof e || j[u(t)] ? e : e + "px";
                    }function d(t) {
                        var e, n;return N[t] || (e = I.createElement(t), I.body.appendChild(e), n = getComputedStyle(e, "").getPropertyValue("display"), e.parentNode.removeChild(e), "none" == n && (n = "block"), N[t] = n), N[t];
                    }function f(t) {
                        return "children" in t ? $.call(t.children) : S.map(t.childNodes, function (t) {
                            if (1 == t.nodeType) return t;
                        });
                    }function g(t, e) {
                        var n,
                            i = t ? t.length : 0;for (n = 0; n < i; n++) {
                            this[n] = t[n];
                        }this.length = i, this.selector = e || "";
                    }function m(t, e, n) {
                        for (T in e) {
                            n && (r(e[T]) || tt(e[T])) ? (r(e[T]) && !r(t[T]) && (t[T] = {}), tt(e[T]) && !tt(t[T]) && (t[T] = []), m(t[T], e[T], n)) : e[T] !== C && (t[T] = e[T]);
                        }
                    }function v(t, e) {
                        return null == e ? S(t) : S(t).filter(e);
                    }function y(t, e, i, o) {
                        return n(e) ? e.call(t, i, o) : e;
                    }function b(t, e, n) {
                        null == n ? t.removeAttribute(e) : t.setAttribute(e, n);
                    }function w(t, e) {
                        var n = t.className || "",
                            i = n && n.baseVal !== C;if (e === C) return i ? n.baseVal : n;i ? n.baseVal = e : t.className = e;
                    }function _(t) {
                        try {
                            return t ? "true" == t || "false" != t && ("null" == t ? null : +t + "" == t ? +t : /^[\[\{]/.test(t) ? S.parseJSON(t) : t) : t;
                        } catch (e) {
                            return t;
                        }
                    }function x(t, e) {
                        e(t);for (var n = 0, i = t.childNodes.length; n < i; n++) {
                            x(t.childNodes[n], e);
                        }
                    }var C,
                        T,
                        S,
                        A,
                        E,
                        P,
                        k = [],
                        D = k.concat,
                        O = k.filter,
                        $ = k.slice,
                        I = t.document,
                        N = {},
                        L = {},
                        j = { "column-count": 1, columns: 1, "font-weight": 1, "line-height": 1, opacity: 1, "z-index": 1, zoom: 1 },
                        z = /^\s*<(\w+|!)[^>]*>/,
                        H = /^<(\w+)\s*\/?>(?:<\/\1>|)$/,
                        R = /<(?!area|br|col|embed|hr|img|input|link|meta|param)(([\w:]+)[^>]*)\/>/gi,
                        M = /^(?:body|html)$/i,
                        q = /([A-Z])/g,
                        W = ["val", "css", "html", "text", "data", "width", "height", "offset"],
                        F = ["after", "prepend", "before", "append"],
                        B = I.createElement("table"),
                        U = I.createElement("tr"),
                        V = { tr: I.createElement("tbody"), tbody: B, thead: B, tfoot: B, td: U, th: U, "*": I.createElement("div") },
                        X = /complete|loaded|interactive/,
                        Y = /^[\w-]*$/,
                        K = {},
                        G = K.toString,
                        Q = {},
                        J = I.createElement("div"),
                        Z = { tabindex: "tabIndex", readonly: "readOnly", for: "htmlFor", class: "className", maxlength: "maxLength", cellspacing: "cellSpacing", cellpadding: "cellPadding", rowspan: "rowSpan", colspan: "colSpan", usemap: "useMap", frameborder: "frameBorder", contenteditable: "contentEditable" },
                        tt = Array.isArray || function (t) {
                        return t instanceof Array;
                    };return Q.matches = function (t, e) {
                        if (!e || !t || 1 !== t.nodeType) return !1;var n = t.matches || t.webkitMatchesSelector || t.mozMatchesSelector || t.oMatchesSelector || t.matchesSelector;if (n) return n.call(t, e);var i,
                            o = t.parentNode,
                            s = !o;return s && (o = J).appendChild(t), i = ~Q.qsa(o, e).indexOf(t), s && J.removeChild(t), i;
                    }, E = function E(t) {
                        return t.replace(/-+(.)?/g, function (t, e) {
                            return e ? e.toUpperCase() : "";
                        });
                    }, P = function P(t) {
                        return O.call(t, function (e, n) {
                            return t.indexOf(e) == n;
                        });
                    }, Q.fragment = function (t, e, n) {
                        var i, o, s;return H.test(t) && (i = S(I.createElement(RegExp.$1))), i || (t.replace && (t = t.replace(R, "<$1></$2>")), e === C && (e = z.test(t) && RegExp.$1), e in V || (e = "*"), s = V[e], s.innerHTML = "" + t, i = S.each($.call(s.childNodes), function () {
                            s.removeChild(this);
                        })), r(n) && (o = S(i), S.each(n, function (t, e) {
                            W.indexOf(t) > -1 ? o[t](e) : o.attr(t, e);
                        })), i;
                    }, Q.Z = function (t, e) {
                        return new g(t, e);
                    }, Q.isZ = function (t) {
                        return t instanceof Q.Z;
                    }, Q.init = function (t, e) {
                        var i;if (!t) return Q.Z();if ("string" == typeof t) {
                            if (t = t.trim(), "<" == t[0] && z.test(t)) i = Q.fragment(t, RegExp.$1, e), t = null;else {
                                if (e !== C) return S(e).find(t);i = Q.qsa(I, t);
                            }
                        } else {
                            if (n(t)) return S(I).ready(t);if (Q.isZ(t)) return t;if (tt(t)) i = l(t);else if (s(t)) i = [t], t = null;else if (z.test(t)) i = Q.fragment(t.trim(), RegExp.$1, e), t = null;else {
                                if (e !== C) return S(e).find(t);i = Q.qsa(I, t);
                            }
                        }return Q.Z(i, t);
                    }, S = function S(t, e) {
                        return Q.init(t, e);
                    }, S.extend = function (t) {
                        var e,
                            n = $.call(arguments, 1);return "boolean" == typeof t && (e = t, t = n.shift()), n.forEach(function (n) {
                            m(t, n, e);
                        }), t;
                    }, Q.qsa = function (t, e) {
                        var n,
                            i = "#" == e[0],
                            o = !i && "." == e[0],
                            s = i || o ? e.slice(1) : e,
                            r = Y.test(s);return t.getElementById && r && i ? (n = t.getElementById(s)) ? [n] : [] : 1 !== t.nodeType && 9 !== t.nodeType && 11 !== t.nodeType ? [] : $.call(r && !i && t.getElementsByClassName ? o ? t.getElementsByClassName(s) : t.getElementsByTagName(e) : t.querySelectorAll(e));
                    }, S.contains = I.documentElement.contains ? function (t, e) {
                        return t !== e && t.contains(e);
                    } : function (t, e) {
                        for (; e && (e = e.parentNode);) {
                            if (e === t) return !0;
                        }return !1;
                    }, S.type = e, S.isFunction = n, S.isWindow = i, S.isArray = tt, S.isPlainObject = r, S.isEmptyObject = function (t) {
                        var e;for (e in t) {
                            return !1;
                        }return !0;
                    }, S.isNumeric = function (t) {
                        var e = Number(t),
                            n = void 0 === t ? "undefined" : _typeof(t);return null != t && "boolean" != n && ("string" != n || t.length) && !isNaN(e) && isFinite(e) || !1;
                    }, S.inArray = function (t, e, n) {
                        return k.indexOf.call(e, t, n);
                    }, S.camelCase = E, S.trim = function (t) {
                        return null == t ? "" : String.prototype.trim.call(t);
                    }, S.uuid = 0, S.support = {}, S.expr = {}, S.noop = function () {}, S.map = function (t, e) {
                        var n,
                            i,
                            o,
                            s = [];if (a(t)) for (i = 0; i < t.length; i++) {
                            null != (n = e(t[i], i)) && s.push(n);
                        } else for (o in t) {
                            null != (n = e(t[o], o)) && s.push(n);
                        }return c(s);
                    }, S.each = function (t, e) {
                        var n, i;if (a(t)) {
                            for (n = 0; n < t.length; n++) {
                                if (!1 === e.call(t[n], n, t[n])) return t;
                            }
                        } else for (i in t) {
                            if (!1 === e.call(t[i], i, t[i])) return t;
                        }return t;
                    }, S.grep = function (t, e) {
                        return O.call(t, e);
                    }, t.JSON && (S.parseJSON = JSON.parse), S.each("Boolean Number String Function Array Date RegExp Object Error".split(" "), function (t, e) {
                        K["[object " + e + "]"] = e.toLowerCase();
                    }), S.fn = { constructor: Q.Z, length: 0, forEach: k.forEach, reduce: k.reduce, push: k.push, sort: k.sort, splice: k.splice, indexOf: k.indexOf, concat: function concat() {
                            var t,
                                e,
                                n = [];for (t = 0; t < arguments.length; t++) {
                                e = arguments[t], n[t] = Q.isZ(e) ? e.toArray() : e;
                            }return D.apply(Q.isZ(this) ? this.toArray() : this, n);
                        }, map: function map(t) {
                            return S(S.map(this, function (e, n) {
                                return t.call(e, n, e);
                            }));
                        }, slice: function slice() {
                            return S($.apply(this, arguments));
                        }, ready: function ready(t) {
                            return X.test(I.readyState) && I.body ? t(S) : I.addEventListener("DOMContentLoaded", function () {
                                t(S);
                            }, !1), this;
                        }, get: function get(t) {
                            return t === C ? $.call(this) : this[t >= 0 ? t : t + this.length];
                        }, toArray: function toArray() {
                            return this.get();
                        }, size: function size() {
                            return this.length;
                        }, remove: function remove() {
                            return this.each(function () {
                                null != this.parentNode && this.parentNode.removeChild(this);
                            });
                        }, each: function each(t) {
                            return k.every.call(this, function (e, n) {
                                return !1 !== t.call(e, n, e);
                            }), this;
                        }, filter: function filter(t) {
                            return n(t) ? this.not(this.not(t)) : S(O.call(this, function (e) {
                                return Q.matches(e, t);
                            }));
                        }, add: function add(t, e) {
                            return S(P(this.concat(S(t, e))));
                        }, is: function is(t) {
                            return this.length > 0 && Q.matches(this[0], t);
                        }, not: function not(t) {
                            var e = [];if (n(t) && t.call !== C) this.each(function (n) {
                                t.call(this, n) || e.push(this);
                            });else {
                                var i = "string" == typeof t ? this.filter(t) : a(t) && n(t.item) ? $.call(t) : S(t);this.forEach(function (t) {
                                    i.indexOf(t) < 0 && e.push(t);
                                });
                            }return S(e);
                        }, has: function has(t) {
                            return this.filter(function () {
                                return s(t) ? S.contains(this, t) : S(this).find(t).size();
                            });
                        }, eq: function eq(t) {
                            return -1 === t ? this.slice(t) : this.slice(t, +t + 1);
                        }, first: function first() {
                            var t = this[0];return t && !s(t) ? t : S(t);
                        }, last: function last() {
                            var t = this[this.length - 1];return t && !s(t) ? t : S(t);
                        }, find: function find(t) {
                            var e = this;return t ? "object" == (void 0 === t ? "undefined" : _typeof(t)) ? S(t).filter(function () {
                                var t = this;return k.some.call(e, function (e) {
                                    return S.contains(e, t);
                                });
                            }) : 1 == this.length ? S(Q.qsa(this[0], t)) : this.map(function () {
                                return Q.qsa(this, t);
                            }) : S();
                        }, closest: function closest(t, e) {
                            var n = [],
                                i = "object" == (void 0 === t ? "undefined" : _typeof(t)) && S(t);return this.each(function (s, r) {
                                for (; r && !(i ? i.indexOf(r) >= 0 : Q.matches(r, t));) {
                                    r = r !== e && !o(r) && r.parentNode;
                                }r && n.indexOf(r) < 0 && n.push(r);
                            }), S(n);
                        }, parents: function parents(t) {
                            for (var e = [], n = this; n.length > 0;) {
                                n = S.map(n, function (t) {
                                    if ((t = t.parentNode) && !o(t) && e.indexOf(t) < 0) return e.push(t), t;
                                });
                            }return v(e, t);
                        }, parent: function parent(t) {
                            return v(P(this.pluck("parentNode")), t);
                        }, children: function children(t) {
                            return v(this.map(function () {
                                return f(this);
                            }), t);
                        }, contents: function contents() {
                            return this.map(function () {
                                return this.contentDocument || $.call(this.childNodes);
                            });
                        }, siblings: function siblings(t) {
                            return v(this.map(function (t, e) {
                                return O.call(f(e.parentNode), function (t) {
                                    return t !== e;
                                });
                            }), t);
                        }, empty: function empty() {
                            return this.each(function () {
                                this.innerHTML = "";
                            });
                        }, pluck: function pluck(t) {
                            return S.map(this, function (e) {
                                return e[t];
                            });
                        }, show: function show() {
                            return this.each(function () {
                                "none" == this.style.display && (this.style.display = ""), "none" == getComputedStyle(this, "").getPropertyValue("display") && (this.style.display = d(this.nodeName));
                            });
                        }, replaceWith: function replaceWith(t) {
                            return this.before(t).remove();
                        }, wrap: function wrap(t) {
                            var e = n(t);if (this[0] && !e) var i = S(t).get(0),
                                o = i.parentNode || this.length > 1;return this.each(function (n) {
                                S(this).wrapAll(e ? t.call(this, n) : o ? i.cloneNode(!0) : i);
                            });
                        }, wrapAll: function wrapAll(t) {
                            if (this[0]) {
                                S(this[0]).before(t = S(t));for (var e; (e = t.children()).length;) {
                                    t = e.first();
                                }S(t).append(this);
                            }return this;
                        }, wrapInner: function wrapInner(t) {
                            var e = n(t);return this.each(function (n) {
                                var i = S(this),
                                    o = i.contents(),
                                    s = e ? t.call(this, n) : t;o.length ? o.wrapAll(s) : i.append(s);
                            });
                        }, unwrap: function unwrap() {
                            return this.parent().each(function () {
                                S(this).replaceWith(S(this).children());
                            }), this;
                        }, clone: function clone() {
                            return this.map(function () {
                                return this.cloneNode(!0);
                            });
                        }, hide: function hide() {
                            return this.css("display", "none");
                        }, toggle: function toggle(t) {
                            return this.each(function () {
                                var e = S(this);(t === C ? "none" == e.css("display") : t) ? e.show() : e.hide();
                            });
                        }, prev: function prev(t) {
                            return S(this.pluck("previousElementSibling")).filter(t || "*");
                        }, next: function next(t) {
                            return S(this.pluck("nextElementSibling")).filter(t || "*");
                        }, html: function html(t) {
                            return 0 in arguments ? this.each(function (e) {
                                var n = this.innerHTML;S(this).empty().append(y(this, t, e, n));
                            }) : 0 in this ? this[0].innerHTML : null;
                        }, text: function text(t) {
                            return 0 in arguments ? this.each(function (e) {
                                var n = y(this, t, e, this.textContent);this.textContent = null == n ? "" : "" + n;
                            }) : 0 in this ? this.pluck("textContent").join("") : null;
                        }, attr: function attr(t, e) {
                            var n;return "string" != typeof t || 1 in arguments ? this.each(function (n) {
                                if (1 === this.nodeType) if (s(t)) for (T in t) {
                                    b(this, T, t[T]);
                                } else b(this, t, y(this, e, n, this.getAttribute(t)));
                            }) : 0 in this && 1 == this[0].nodeType && null != (n = this[0].getAttribute(t)) ? n : C;
                        }, removeAttr: function removeAttr(t) {
                            return this.each(function () {
                                1 === this.nodeType && t.split(" ").forEach(function (t) {
                                    b(this, t);
                                }, this);
                            });
                        }, prop: function prop(t, e) {
                            return t = Z[t] || t, 1 in arguments ? this.each(function (n) {
                                this[t] = y(this, e, n, this[t]);
                            }) : this[0] && this[0][t];
                        }, removeProp: function removeProp(t) {
                            return t = Z[t] || t, this.each(function () {
                                delete this[t];
                            });
                        }, data: function data(t, e) {
                            var n = "data-" + t.replace(q, "-$1").toLowerCase(),
                                i = 1 in arguments ? this.attr(n, e) : this.attr(n);return null !== i ? _(i) : C;
                        }, val: function val(t) {
                            return 0 in arguments ? (null == t && (t = ""), this.each(function (e) {
                                this.value = y(this, t, e, this.value);
                            })) : this[0] && (this[0].multiple ? S(this[0]).find("option").filter(function () {
                                return this.selected;
                            }).pluck("value") : this[0].value);
                        }, offset: function offset(e) {
                            if (e) return this.each(function (t) {
                                var n = S(this),
                                    i = y(this, e, t, n.offset()),
                                    o = n.offsetParent().offset(),
                                    s = { top: i.top - o.top, left: i.left - o.left };"static" == n.css("position") && (s.position = "relative"), n.css(s);
                            });if (!this.length) return null;if (I.documentElement !== this[0] && !S.contains(I.documentElement, this[0])) return { top: 0, left: 0 };var n = this[0].getBoundingClientRect();return { left: n.left + t.pageXOffset, top: n.top + t.pageYOffset, width: Math.round(n.width), height: Math.round(n.height) };
                        }, css: function css(t, n) {
                            if (arguments.length < 2) {
                                var i = this[0];if ("string" == typeof t) {
                                    if (!i) return;return i.style[E(t)] || getComputedStyle(i, "").getPropertyValue(t);
                                }if (tt(t)) {
                                    if (!i) return;var o = {},
                                        s = getComputedStyle(i, "");return S.each(t, function (t, e) {
                                        o[e] = i.style[E(e)] || s.getPropertyValue(e);
                                    }), o;
                                }
                            }var r = "";if ("string" == e(t)) n || 0 === n ? r = u(t) + ":" + p(t, n) : this.each(function () {
                                this.style.removeProperty(u(t));
                            });else for (T in t) {
                                t[T] || 0 === t[T] ? r += u(T) + ":" + p(T, t[T]) + ";" : this.each(function () {
                                    this.style.removeProperty(u(T));
                                });
                            }return this.each(function () {
                                this.style.cssText += ";" + r;
                            });
                        }, index: function index(t) {
                            return t ? this.indexOf(S(t)[0]) : this.parent().children().indexOf(this[0]);
                        }, hasClass: function hasClass(t) {
                            return !!t && k.some.call(this, function (t) {
                                return this.test(w(t));
                            }, h(t));
                        }, addClass: function addClass(t) {
                            return t ? this.each(function (e) {
                                if ("className" in this) {
                                    A = [];var n = w(this);y(this, t, e, n).split(/\s+/g).forEach(function (t) {
                                        S(this).hasClass(t) || A.push(t);
                                    }, this), A.length && w(this, n + (n ? " " : "") + A.join(" "));
                                }
                            }) : this;
                        }, removeClass: function removeClass(t) {
                            return this.each(function (e) {
                                if ("className" in this) {
                                    if (t === C) return w(this, "");A = w(this), y(this, t, e, A).split(/\s+/g).forEach(function (t) {
                                        A = A.replace(h(t), " ");
                                    }), w(this, A.trim());
                                }
                            });
                        }, toggleClass: function toggleClass(t, e) {
                            return t ? this.each(function (n) {
                                var i = S(this);y(this, t, n, w(this)).split(/\s+/g).forEach(function (t) {
                                    (e === C ? !i.hasClass(t) : e) ? i.addClass(t) : i.removeClass(t);
                                });
                            }) : this;
                        }, scrollTop: function scrollTop(t) {
                            if (this.length) {
                                var e = "scrollTop" in this[0];return t === C ? e ? this[0].scrollTop : this[0].pageYOffset : this.each(e ? function () {
                                    this.scrollTop = t;
                                } : function () {
                                    this.scrollTo(this.scrollX, t);
                                });
                            }
                        }, scrollLeft: function scrollLeft(t) {
                            if (this.length) {
                                var e = "scrollLeft" in this[0];return t === C ? e ? this[0].scrollLeft : this[0].pageXOffset : this.each(e ? function () {
                                    this.scrollLeft = t;
                                } : function () {
                                    this.scrollTo(t, this.scrollY);
                                });
                            }
                        }, position: function position() {
                            if (this.length) {
                                var t = this[0],
                                    e = this.offsetParent(),
                                    n = this.offset(),
                                    i = M.test(e[0].nodeName) ? { top: 0, left: 0 } : e.offset();return n.top -= parseFloat(S(t).css("margin-top")) || 0, n.left -= parseFloat(S(t).css("margin-left")) || 0, i.top += parseFloat(S(e[0]).css("border-top-width")) || 0, i.left += parseFloat(S(e[0]).css("border-left-width")) || 0, { top: n.top - i.top, left: n.left - i.left };
                            }
                        }, offsetParent: function offsetParent() {
                            return this.map(function () {
                                for (var t = this.offsetParent || I.body; t && !M.test(t.nodeName) && "static" == S(t).css("position");) {
                                    t = t.offsetParent;
                                }return t;
                            });
                        } }, S.fn.detach = S.fn.remove, ["width", "height"].forEach(function (t) {
                        var e = t.replace(/./, function (t) {
                            return t[0].toUpperCase();
                        });S.fn[t] = function (n) {
                            var s,
                                r = this[0];return n === C ? i(r) ? r["inner" + e] : o(r) ? r.documentElement["scroll" + e] : (s = this.offset()) && s[t] : this.each(function (e) {
                                r = S(this), r.css(t, y(this, n, e, r[t]()));
                            });
                        };
                    }), F.forEach(function (n, i) {
                        var o = i % 2;S.fn[n] = function () {
                            var n,
                                s,
                                r = S.map(arguments, function (t) {
                                var i = [];return n = e(t), "array" == n ? (t.forEach(function (t) {
                                    return t.nodeType !== C ? i.push(t) : S.zepto.isZ(t) ? i = i.concat(t.get()) : void (i = i.concat(Q.fragment(t)));
                                }), i) : "object" == n || null == t ? t : Q.fragment(t);
                            }),
                                a = this.length > 1;return r.length < 1 ? this : this.each(function (e, n) {
                                s = o ? n : n.parentNode, n = 0 == i ? n.nextSibling : 1 == i ? n.firstChild : 2 == i ? n : null;var l = S.contains(I.documentElement, s);r.forEach(function (e) {
                                    if (a) e = e.cloneNode(!0);else if (!s) return S(e).remove();s.insertBefore(e, n), l && x(e, function (e) {
                                        if (!(null == e.nodeName || "SCRIPT" !== e.nodeName.toUpperCase() || e.type && "text/javascript" !== e.type || e.src)) {
                                            var n = e.ownerDocument ? e.ownerDocument.defaultView : t;n.eval.call(n, e.innerHTML);
                                        }
                                    });
                                });
                            });
                        }, S.fn[o ? n + "To" : "insert" + (i ? "Before" : "After")] = function (t) {
                            return S(t)[n](this), this;
                        };
                    }), Q.Z.prototype = g.prototype = S.fn, Q.uniq = P, Q.deserializeValue = _, S.zepto = Q, S;
                }();return function (e) {
                    function n(t) {
                        return t._zid || (t._zid = d++);
                    }function i(t, e, i, r) {
                        if (e = o(e), e.ns) var a = s(e.ns);return (v[n(t)] || []).filter(function (t) {
                            return t && (!e.e || t.e == e.e) && (!e.ns || a.test(t.ns)) && (!i || n(t.fn) === n(i)) && (!r || t.sel == r);
                        });
                    }function o(t) {
                        var e = ("" + t).split(".");return { e: e[0], ns: e.slice(1).sort().join(" ") };
                    }function s(t) {
                        return new RegExp("(?:^| )" + t.replace(" ", " .* ?") + "(?: |$)");
                    }function r(t, e) {
                        return t.del && !b && t.e in w || !!e;
                    }function a(t) {
                        return _[t] || b && w[t] || t;
                    }function l(t, i, s, l, c, h, d) {
                        var f = n(t),
                            g = v[f] || (v[f] = []);i.split(/\s/).forEach(function (n) {
                            if ("ready" == n) return e(document).ready(s);var i = o(n);i.fn = s, i.sel = c, i.e in _ && (s = function s(t) {
                                var n = t.relatedTarget;if (!n || n !== this && !e.contains(this, n)) return i.fn.apply(this, arguments);
                            }), i.del = h;var f = h || s;i.proxy = function (e) {
                                if (e = u(e), !e.isImmediatePropagationStopped()) {
                                    e.data = l;var n = f.apply(t, e._args == p ? [e] : [e].concat(e._args));return !1 === n && (e.preventDefault(), e.stopPropagation()), n;
                                }
                            }, i.i = g.length, g.push(i), "addEventListener" in t && t.addEventListener(a(i.e), i.proxy, r(i, d));
                        });
                    }function c(t, e, o, s, l) {
                        var c = n(t);(e || "").split(/\s/).forEach(function (e) {
                            i(t, e, o, s).forEach(function (e) {
                                delete v[c][e.i], "removeEventListener" in t && t.removeEventListener(a(e.e), e.proxy, r(e, l));
                            });
                        });
                    }function u(t, n) {
                        return !n && t.isDefaultPrevented || (n || (n = t), e.each(S, function (e, i) {
                            var o = n[e];t[e] = function () {
                                return this[i] = x, o && o.apply(n, arguments);
                            }, t[i] = C;
                        }), t.timeStamp || (t.timeStamp = Date.now()), (n.defaultPrevented !== p ? n.defaultPrevented : "returnValue" in n ? !1 === n.returnValue : n.getPreventDefault && n.getPreventDefault()) && (t.isDefaultPrevented = x)), t;
                    }function h(t) {
                        var e,
                            n = { originalEvent: t };for (e in t) {
                            T.test(e) || t[e] === p || (n[e] = t[e]);
                        }return u(n, t);
                    }var p,
                        d = 1,
                        f = Array.prototype.slice,
                        g = e.isFunction,
                        m = function m(t) {
                        return "string" == typeof t;
                    },
                        v = {},
                        y = {},
                        b = "onfocusin" in t,
                        w = { focus: "focusin", blur: "focusout" },
                        _ = { mouseenter: "mouseover", mouseleave: "mouseout" };y.click = y.mousedown = y.mouseup = y.mousemove = "MouseEvents", e.event = { add: l, remove: c }, e.proxy = function (t, i) {
                        var o = 2 in arguments && f.call(arguments, 2);if (g(t)) {
                            var s = function s() {
                                return t.apply(i, o ? o.concat(f.call(arguments)) : arguments);
                            };return s._zid = n(t), s;
                        }if (m(i)) return o ? (o.unshift(t[i], t), e.proxy.apply(null, o)) : e.proxy(t[i], t);throw new TypeError("expected function");
                    }, e.fn.bind = function (t, e, n) {
                        return this.on(t, e, n);
                    }, e.fn.unbind = function (t, e) {
                        return this.off(t, e);
                    }, e.fn.one = function (t, e, n, i) {
                        return this.on(t, e, n, i, 1);
                    };var x = function x() {
                        return !0;
                    },
                        C = function C() {
                        return !1;
                    },
                        T = /^([A-Z]|returnValue$|layer[XY]$|webkitMovement[XY]$)/,
                        S = { preventDefault: "isDefaultPrevented", stopImmediatePropagation: "isImmediatePropagationStopped", stopPropagation: "isPropagationStopped" };e.fn.delegate = function (t, e, n) {
                        return this.on(e, t, n);
                    }, e.fn.undelegate = function (t, e, n) {
                        return this.off(e, t, n);
                    }, e.fn.live = function (t, n) {
                        return e(document.body).delegate(this.selector, t, n), this;
                    }, e.fn.die = function (t, n) {
                        return e(document.body).undelegate(this.selector, t, n), this;
                    }, e.fn.on = function (t, n, i, o, s) {
                        var r,
                            a,
                            u = this;return t && !m(t) ? (e.each(t, function (t, e) {
                            u.on(t, n, i, e, s);
                        }), u) : (m(n) || g(o) || !1 === o || (o = i, i = n, n = p), o !== p && !1 !== i || (o = i, i = p), !1 === o && (o = C), u.each(function (u, p) {
                            s && (r = function r(t) {
                                return c(p, t.type, o), o.apply(this, arguments);
                            }), n && (a = function a(t) {
                                var i,
                                    s = e(t.target).closest(n, p).get(0);if (s && s !== p) return i = e.extend(h(t), { currentTarget: s, liveFired: p }), (r || o).apply(s, [i].concat(f.call(arguments, 1)));
                            }), l(p, t, o, i, n, a || r);
                        }));
                    }, e.fn.off = function (t, n, i) {
                        var o = this;return t && !m(t) ? (e.each(t, function (t, e) {
                            o.off(t, n, e);
                        }), o) : (m(n) || g(i) || !1 === i || (i = n, n = p), !1 === i && (i = C), o.each(function () {
                            c(this, t, i, n);
                        }));
                    }, e.fn.trigger = function (t, n) {
                        return t = m(t) || e.isPlainObject(t) ? e.Event(t) : u(t), t._args = n, this.each(function () {
                            t.type in w && "function" == typeof this[t.type] ? this[t.type]() : "dispatchEvent" in this ? this.dispatchEvent(t) : e(this).triggerHandler(t, n);
                        });
                    }, e.fn.triggerHandler = function (t, n) {
                        var o, s;return this.each(function (r, a) {
                            o = h(m(t) ? e.Event(t) : t), o._args = n, o.target = a, e.each(i(a, t.type || t), function (t, e) {
                                if (s = e.proxy(o), o.isImmediatePropagationStopped()) return !1;
                            });
                        }), s;
                    }, "focusin focusout focus blur load resize scroll unload click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select keydown keypress keyup error".split(" ").forEach(function (t) {
                        e.fn[t] = function (e) {
                            return 0 in arguments ? this.bind(t, e) : this.trigger(t);
                        };
                    }), e.Event = function (t, e) {
                        m(t) || (e = t, t = e.type);var n = document.createEvent(y[t] || "Events"),
                            i = !0;if (e) for (var o in e) {
                            "bubbles" == o ? i = !!e[o] : n[o] = e[o];
                        }return n.initEvent(t, i, !0), u(n);
                    };
                }(e), function (t) {
                    var e,
                        n = [];t.fn.remove = function () {
                        return this.each(function () {
                            this.parentNode && ("IMG" === this.tagName && (n.push(this), this.src = "data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=", e && clearTimeout(e), e = setTimeout(function () {
                                n = [];
                            }, 6e4)), this.parentNode.removeChild(this));
                        });
                    };
                }(e), function (t) {
                    function e(e, i) {
                        var l = e[a],
                            c = l && o[l];if (void 0 === i) return c || n(e);if (c) {
                            if (i in c) return c[i];var u = r(i);if (u in c) return c[u];
                        }return s.call(t(e), i);
                    }function n(e, n, s) {
                        var l = e[a] || (e[a] = ++t.uuid),
                            c = o[l] || (o[l] = i(e));return void 0 !== n && (c[r(n)] = s), c;
                    }function i(e) {
                        var n = {};return t.each(e.attributes || l, function (e, i) {
                            0 == i.name.indexOf("data-") && (n[r(i.name.replace("data-", ""))] = t.zepto.deserializeValue(i.value));
                        }), n;
                    }var o = {},
                        s = t.fn.data,
                        r = t.camelCase,
                        a = t.expando = "Zepto" + +new Date(),
                        l = [];t.fn.data = function (i, o) {
                        return void 0 === o ? t.isPlainObject(i) ? this.each(function (e, o) {
                            t.each(i, function (t, e) {
                                n(o, t, e);
                            });
                        }) : 0 in this ? e(this[0], i) : void 0 : this.each(function () {
                            n(this, i, o);
                        });
                    }, t.data = function (e, n, i) {
                        return t(e).data(n, i);
                    }, t.hasData = function (e) {
                        var n = e[a],
                            i = n && o[n];return !!i && !t.isEmptyObject(i);
                    }, t.fn.removeData = function (e) {
                        return "string" == typeof e && (e = e.split(/\s+/)), this.each(function () {
                            var n = this[a],
                                i = n && o[n];i && t.each(e || i, function (t) {
                                delete i[e ? r(this) : t];
                            });
                        });
                    }, ["remove", "empty"].forEach(function (e) {
                        var n = t.fn[e];t.fn[e] = function () {
                            var t = this.find("*");return "remove" === e && (t = t.add(this)), t.removeData(), n.call(this);
                        };
                    });
                }(e), e;
            }(e);
        }(window);
    }, function (t, e, n) {
        "use strict";
        Object.defineProperty(e, "__esModule", { value: !0 }), e.default = { multiContainers: "Algolia Places: 'container' must point to a single <input> element.\nExample: instantiate the library twice if you want to bind two <inputs>.\n\nSee https://community.algolia.com/places/documentation.html#api-options-container", badContainer: "Algolia Places: 'container' must point to an <input> element.\n\nSee https://community.algolia.com/places/documentation.html#api-options-container", rateLimitReached: "Algolia Places: Current rate limit reached.\n\nSign up for a free 100,000 queries/month account at\nhttps://www.algolia.com/users/sign_up/places.\n\nOr upgrade your 100,000 queries/month plan by contacting us at\nhttps://community.algolia.com/places/contact.html." };
    }, function (t, e, n) {
        function i(t) {
            var n,
                i = 0;for (n in t) {
                i = (i << 5) - i + t.charCodeAt(n), i |= 0;
            }return e.colors[Math.abs(i) % e.colors.length];
        }function o(t) {
            function n() {
                if (n.enabled) {
                    var t = n,
                        i = +new Date(),
                        o = i - (c || i);t.diff = o, t.prev = c, t.curr = i, c = i;for (var s = new Array(arguments.length), r = 0; r < s.length; r++) {
                        s[r] = arguments[r];
                    }s[0] = e.coerce(s[0]), "string" != typeof s[0] && s.unshift("%O");var a = 0;s[0] = s[0].replace(/%([a-zA-Z%])/g, function (n, i) {
                        if ("%%" === n) return n;a++;var o = e.formatters[i];if ("function" == typeof o) {
                            var r = s[a];n = o.call(t, r), s.splice(a, 1), a--;
                        }return n;
                    }), e.formatArgs.call(t, s), (n.log || e.log || console.log.bind(console)).apply(t, s);
                }
            }return n.namespace = t, n.enabled = e.enabled(t), n.useColors = e.useColors(), n.color = i(t), "function" == typeof e.init && e.init(n), n;
        }function s(t) {
            e.save(t), e.names = [], e.skips = [];for (var n = ("string" == typeof t ? t : "").split(/[\s,]+/), i = n.length, o = 0; o < i; o++) {
                n[o] && (t = n[o].replace(/\*/g, ".*?"), "-" === t[0] ? e.skips.push(new RegExp("^" + t.substr(1) + "$")) : e.names.push(new RegExp("^" + t + "$")));
            }
        }function r() {
            e.enable("");
        }function a(t) {
            var n, i;for (n = 0, i = e.skips.length; n < i; n++) {
                if (e.skips[n].test(t)) return !1;
            }for (n = 0, i = e.names.length; n < i; n++) {
                if (e.names[n].test(t)) return !0;
            }return !1;
        }function l(t) {
            return t instanceof Error ? t.stack || t.message : t;
        }e = t.exports = o.debug = o.default = o, e.coerce = l, e.disable = r, e.enable = s, e.enabled = a, e.humanize = n(74), e.names = [], e.skips = [], e.formatters = {};var c;
    }, function (t, e, n) {
        (function (e, n) {
            !function (e, n) {
                t.exports = function () {
                    "use strict";
                    function t(t) {
                        var e = void 0 === t ? "undefined" : _typeof(t);return null !== t && ("object" === e || "function" === e);
                    }function i(t) {
                        return "function" == typeof t;
                    }function o(t) {
                        q = t;
                    }function s(t) {
                        W = t;
                    }function r() {
                        return void 0 !== M ? function () {
                            M(l);
                        } : a();
                    }function a() {
                        var t = setTimeout;return function () {
                            return t(l, 1);
                        };
                    }function l() {
                        for (var t = 0; t < R; t += 2) {
                            (0, Y[t])(Y[t + 1]), Y[t] = void 0, Y[t + 1] = void 0;
                        }R = 0;
                    }function c(t, e) {
                        var n = this,
                            i = new this.constructor(h);void 0 === i[G] && k(i);var o = n._state;if (o) {
                            var s = arguments[o - 1];W(function () {
                                return A(o, i, s, n._result);
                            });
                        } else C(n, i, t, e);return i;
                    }function u(t) {
                        var e = this;if (t && "object" == (void 0 === t ? "undefined" : _typeof(t)) && t.constructor === e) return t;var n = new e(h);return b(n, t), n;
                    }function h() {}function p() {
                        return new TypeError("You cannot resolve a promise with itself");
                    }function d() {
                        return new TypeError("A promises callback cannot return that same promise.");
                    }function f(t) {
                        try {
                            return t.then;
                        } catch (t) {
                            return tt.error = t, tt;
                        }
                    }function g(t, e, n, i) {
                        try {
                            t.call(e, n, i);
                        } catch (t) {
                            return t;
                        }
                    }function m(t, e, n) {
                        W(function (t) {
                            var i = !1,
                                o = g(n, e, function (n) {
                                i || (i = !0, e !== n ? b(t, n) : _(t, n));
                            }, function (e) {
                                i || (i = !0, x(t, e));
                            }, "Settle: " + (t._label || " unknown promise"));!i && o && (i = !0, x(t, o));
                        }, t);
                    }function v(t, e) {
                        e._state === J ? _(t, e._result) : e._state === Z ? x(t, e._result) : C(e, void 0, function (e) {
                            return b(t, e);
                        }, function (e) {
                            return x(t, e);
                        });
                    }function y(t, e, n) {
                        e.constructor === t.constructor && n === c && e.constructor.resolve === u ? v(t, e) : n === tt ? (x(t, tt.error), tt.error = null) : void 0 === n ? _(t, e) : i(n) ? m(t, e, n) : _(t, e);
                    }function b(e, n) {
                        e === n ? x(e, p()) : t(n) ? y(e, n, f(n)) : _(e, n);
                    }function w(t) {
                        t._onerror && t._onerror(t._result), T(t);
                    }function _(t, e) {
                        t._state === Q && (t._result = e, t._state = J, 0 !== t._subscribers.length && W(T, t));
                    }function x(t, e) {
                        t._state === Q && (t._state = Z, t._result = e, W(w, t));
                    }function C(t, e, n, i) {
                        var o = t._subscribers,
                            s = o.length;t._onerror = null, o[s] = e, o[s + J] = n, o[s + Z] = i, 0 === s && t._state && W(T, t);
                    }function T(t) {
                        var e = t._subscribers,
                            n = t._state;if (0 !== e.length) {
                            for (var i = void 0, o = void 0, s = t._result, r = 0; r < e.length; r += 3) {
                                i = e[r], o = e[r + n], i ? A(n, i, o, s) : o(s);
                            }t._subscribers.length = 0;
                        }
                    }function S(t, e) {
                        try {
                            return t(e);
                        } catch (t) {
                            return tt.error = t, tt;
                        }
                    }function A(t, e, n, o) {
                        var s = i(n),
                            r = void 0,
                            a = void 0,
                            l = void 0,
                            c = void 0;if (s) {
                            if (r = S(n, o), r === tt ? (c = !0, a = r.error, r.error = null) : l = !0, e === r) return void x(e, d());
                        } else r = o, l = !0;e._state !== Q || (s && l ? b(e, r) : c ? x(e, a) : t === J ? _(e, r) : t === Z && x(e, r));
                    }function E(t, e) {
                        try {
                            e(function (e) {
                                b(t, e);
                            }, function (e) {
                                x(t, e);
                            });
                        } catch (e) {
                            x(t, e);
                        }
                    }function P() {
                        return et++;
                    }function k(t) {
                        t[G] = et++, t._state = void 0, t._result = void 0, t._subscribers = [];
                    }function D() {
                        return new Error("Array Methods must be provided an Array");
                    }function O(t) {
                        return new nt(this, t).promise;
                    }function $(t) {
                        var e = this;return new e(H(t) ? function (n, i) {
                            for (var o = t.length, s = 0; s < o; s++) {
                                e.resolve(t[s]).then(n, i);
                            }
                        } : function (t, e) {
                            return e(new TypeError("You must pass an array to race."));
                        });
                    }function I(t) {
                        var e = this,
                            n = new e(h);return x(n, t), n;
                    }function N() {
                        throw new TypeError("You must pass a resolver function as the first argument to the promise constructor");
                    }function L() {
                        throw new TypeError("Failed to construct 'Promise': Please use the 'new' operator, this object constructor cannot be called as a function.");
                    }function j() {
                        var t = void 0;if (void 0 !== n) t = n;else if ("undefined" != typeof self) t = self;else try {
                            t = Function("return this")();
                        } catch (t) {
                            throw new Error("polyfill failed because global object is unavailable in this environment");
                        }var e = t.Promise;if (e) {
                            var i = null;try {
                                i = Object.prototype.toString.call(e.resolve());
                            } catch (t) {}if ("[object Promise]" === i && !e.cast) return;
                        }t.Promise = it;
                    }var z = void 0;z = Array.isArray ? Array.isArray : function (t) {
                        return "[object Array]" === Object.prototype.toString.call(t);
                    };var H = z,
                        R = 0,
                        M = void 0,
                        q = void 0,
                        W = function W(t, e) {
                        Y[R] = t, Y[R + 1] = e, 2 === (R += 2) && (q ? q(l) : K());
                    },
                        F = "undefined" != typeof window ? window : void 0,
                        B = F || {},
                        U = B.MutationObserver || B.WebKitMutationObserver,
                        V = "undefined" == typeof self && void 0 !== e && "[object process]" === {}.toString.call(e),
                        X = "undefined" != typeof Uint8ClampedArray && "undefined" != typeof importScripts && "undefined" != typeof MessageChannel,
                        Y = new Array(1e3),
                        K = void 0;K = V ? function () {
                        return function () {
                            return e.nextTick(l);
                        };
                    }() : U ? function () {
                        var t = 0,
                            e = new U(l),
                            n = document.createTextNode("");return e.observe(n, { characterData: !0 }), function () {
                            n.data = t = ++t % 2;
                        };
                    }() : X ? function () {
                        var t = new MessageChannel();return t.port1.onmessage = l, function () {
                            return t.port2.postMessage(0);
                        };
                    }() : void 0 === F ? function () {
                        try {
                            var t = Function("return this")().require("vertx");return M = t.runOnLoop || t.runOnContext, r();
                        } catch (t) {
                            return a();
                        }
                    }() : a();var G = Math.random().toString(36).substring(2),
                        Q = void 0,
                        J = 1,
                        Z = 2,
                        tt = { error: null },
                        et = 0,
                        nt = function () {
                        function t(t, e) {
                            this._instanceConstructor = t, this.promise = new t(h), this.promise[G] || k(this.promise), H(e) ? (this.length = e.length, this._remaining = e.length, this._result = new Array(this.length), 0 === this.length ? _(this.promise, this._result) : (this.length = this.length || 0, this._enumerate(e), 0 === this._remaining && _(this.promise, this._result))) : x(this.promise, D());
                        }return t.prototype._enumerate = function (t) {
                            for (var e = 0; this._state === Q && e < t.length; e++) {
                                this._eachEntry(t[e], e);
                            }
                        }, t.prototype._eachEntry = function (t, e) {
                            var n = this._instanceConstructor,
                                i = n.resolve;if (i === u) {
                                var o = f(t);if (o === c && t._state !== Q) this._settledAt(t._state, e, t._result);else if ("function" != typeof o) this._remaining--, this._result[e] = t;else if (n === it) {
                                    var s = new n(h);y(s, t, o), this._willSettleAt(s, e);
                                } else this._willSettleAt(new n(function (e) {
                                    return e(t);
                                }), e);
                            } else this._willSettleAt(i(t), e);
                        }, t.prototype._settledAt = function (t, e, n) {
                            var i = this.promise;i._state === Q && (this._remaining--, t === Z ? x(i, n) : this._result[e] = n), 0 === this._remaining && _(i, this._result);
                        }, t.prototype._willSettleAt = function (t, e) {
                            var n = this;C(t, void 0, function (t) {
                                return n._settledAt(J, e, t);
                            }, function (t) {
                                return n._settledAt(Z, e, t);
                            });
                        }, t;
                    }(),
                        it = function () {
                        function t(e) {
                            this[G] = P(), this._result = this._state = void 0, this._subscribers = [], h !== e && ("function" != typeof e && N(), this instanceof t ? E(this, e) : L());
                        }return t.prototype.catch = function (t) {
                            return this.then(null, t);
                        }, t.prototype.finally = function (t) {
                            var e = this,
                                n = e.constructor;return e.then(function (e) {
                                return n.resolve(t()).then(function () {
                                    return e;
                                });
                            }, function (e) {
                                return n.resolve(t()).then(function () {
                                    throw e;
                                });
                            });
                        }, t;
                    }();return it.prototype.then = c, it.all = O, it.race = $, it.resolve = u, it.reject = I, it._setScheduler = o, it._setAsap = s, it._asap = W, it.polyfill = j, it.Promise = it, it;
                }();
            }();
        }).call(e, n(11), n(4));
    }, function (t, e, n) {
        (function (e) {
            var n;n = "undefined" != typeof window ? window : void 0 !== e ? e : "undefined" != typeof self ? self : {}, t.exports = n;
        }).call(e, n(4));
    }, function (t, e, n) {
        "use strict";
        function i() {
            a && l && (a = !1, l.length ? p = l.concat(p) : h = -1, p.length && o());
        }function o() {
            if (!a) {
                d = !1, a = !0;for (var t = p.length, e = setTimeout(i); t;) {
                    for (l = p, p = []; l && ++h < t;) {
                        l[h].run();
                    }h = -1, t = p.length;
                }l = null, h = -1, a = !1, clearTimeout(e);
            }
        }function s(t, e) {
            this.fun = t, this.array = e;
        }function r(t) {
            var e = new Array(arguments.length - 1);if (arguments.length > 1) for (var n = 1; n < arguments.length; n++) {
                e[n - 1] = arguments[n];
            }p.push(new s(t, e)), d || a || (d = !0, c());
        }for (var a, l, c, u = [n(71), n(70), n(69), n(72), n(73)], h = -1, p = [], d = !1, f = -1, g = u.length; ++f < g;) {
            if (u[f] && u[f].test && u[f].test()) {
                c = u[f].install(o);break;
            }
        }s.prototype.run = function () {
            var t = this.fun,
                e = this.array;switch (e.length) {case 0:
                    return t();case 1:
                    return t(e[0]);case 2:
                    return t(e[0], e[1]);case 3:
                    return t(e[0], e[1], e[2]);default:
                    return t.apply(null, e);}
        }, t.exports = r;
    }, function (t, e, n) {
        "use strict";
        (function (t) {
            e.test = function () {
                return !t.setImmediate && void 0 !== t.MessageChannel;
            }, e.install = function (e) {
                var n = new t.MessageChannel();return n.port1.onmessage = e, function () {
                    n.port2.postMessage(0);
                };
            };
        }).call(e, n(4));
    }, function (t, e, n) {
        "use strict";
        (function (t) {
            var n = t.MutationObserver || t.WebKitMutationObserver;e.test = function () {
                return n;
            }, e.install = function (e) {
                var i = 0,
                    o = new n(e),
                    s = t.document.createTextNode("");return o.observe(s, { characterData: !0 }), function () {
                    s.data = i = ++i % 2;
                };
            };
        }).call(e, n(4));
    }, function (t, e, n) {
        "use strict";
        (function (t) {
            e.test = function () {
                return void 0 !== t && !t.browser;
            }, e.install = function (e) {
                return function () {
                    t.nextTick(e);
                };
            };
        }).call(e, n(11));
    }, function (t, e, n) {
        "use strict";
        (function (t) {
            e.test = function () {
                return "document" in t && "onreadystatechange" in t.document.createElement("script");
            }, e.install = function (e) {
                return function () {
                    var n = t.document.createElement("script");return n.onreadystatechange = function () {
                        e(), n.onreadystatechange = null, n.parentNode.removeChild(n), n = null;
                    }, t.document.documentElement.appendChild(n), e;
                };
            };
        }).call(e, n(4));
    }, function (t, e, n) {
        "use strict";
        e.test = function () {
            return !0;
        }, e.install = function (t) {
            return function () {
                setTimeout(t, 0);
            };
        };
    }, function (t, e) {
        function n(t) {
            if (t = String(t), !(t.length > 100)) {
                var e = /^((?:\d+)?\.?\d+) *(milliseconds?|msecs?|ms|seconds?|secs?|s|minutes?|mins?|m|hours?|hrs?|h|days?|d|years?|yrs?|y)?$/i.exec(t);if (e) {
                    var n = parseFloat(e[1]);switch ((e[2] || "ms").toLowerCase()) {case "years":case "year":case "yrs":case "yr":case "y":
                            return n * u;case "days":case "day":case "d":
                            return n * c;case "hours":case "hour":case "hrs":case "hr":case "h":
                            return n * l;case "minutes":case "minute":case "mins":case "min":case "m":
                            return n * a;case "seconds":case "second":case "secs":case "sec":case "s":
                            return n * r;case "milliseconds":case "millisecond":case "msecs":case "msec":case "ms":
                            return n;default:
                            return;}
                }
            }
        }function i(t) {
            return t >= c ? Math.round(t / c) + "d" : t >= l ? Math.round(t / l) + "h" : t >= a ? Math.round(t / a) + "m" : t >= r ? Math.round(t / r) + "s" : t + "ms";
        }function o(t) {
            return s(t, c, "day") || s(t, l, "hour") || s(t, a, "minute") || s(t, r, "second") || t + " ms";
        }function s(t, e, n) {
            if (!(t < e)) return t < 1.5 * e ? Math.floor(t / e) + " " + n : Math.ceil(t / e) + " " + n + "s";
        }var r = 1e3,
            a = 60 * r,
            l = 60 * a,
            c = 24 * l,
            u = 365.25 * c;t.exports = function (t, e) {
            e = e || {};var s = void 0 === t ? "undefined" : _typeof(t);if ("string" === s && t.length > 0) return n(t);if ("number" === s && !1 === isNaN(t)) return e.long ? o(t) : i(t);throw new Error("val is not a non-empty string or a valid number. val=" + JSON.stringify(t));
        };
    }, function (t, e) {
        function n() {
            this._events = this._events || {}, this._maxListeners = this._maxListeners || void 0;
        }function i(t) {
            return "function" == typeof t;
        }function o(t) {
            return "number" == typeof t;
        }function s(t) {
            return "object" == (void 0 === t ? "undefined" : _typeof(t)) && null !== t;
        }function r(t) {
            return void 0 === t;
        }t.exports = n, n.EventEmitter = n, n.prototype._events = void 0, n.prototype._maxListeners = void 0, n.defaultMaxListeners = 10, n.prototype.setMaxListeners = function (t) {
            if (!o(t) || t < 0 || isNaN(t)) throw TypeError("n must be a positive number");return this._maxListeners = t, this;
        }, n.prototype.emit = function (t) {
            var e, n, o, a, l, c;if (this._events || (this._events = {}), "error" === t && (!this._events.error || s(this._events.error) && !this._events.error.length)) {
                if ((e = arguments[1]) instanceof Error) throw e;var u = new Error('Uncaught, unspecified "error" event. (' + e + ")");throw u.context = e, u;
            }if (n = this._events[t], r(n)) return !1;if (i(n)) switch (arguments.length) {case 1:
                    n.call(this);break;case 2:
                    n.call(this, arguments[1]);break;case 3:
                    n.call(this, arguments[1], arguments[2]);break;default:
                    a = Array.prototype.slice.call(arguments, 1), n.apply(this, a);} else if (s(n)) for (a = Array.prototype.slice.call(arguments, 1), c = n.slice(), o = c.length, l = 0; l < o; l++) {
                c[l].apply(this, a);
            }return !0;
        }, n.prototype.addListener = function (t, e) {
            var o;if (!i(e)) throw TypeError("listener must be a function");return this._events || (this._events = {}), this._events.newListener && this.emit("newListener", t, i(e.listener) ? e.listener : e), this._events[t] ? s(this._events[t]) ? this._events[t].push(e) : this._events[t] = [this._events[t], e] : this._events[t] = e, s(this._events[t]) && !this._events[t].warned && (o = r(this._maxListeners) ? n.defaultMaxListeners : this._maxListeners) && o > 0 && this._events[t].length > o && (this._events[t].warned = !0, console.error("(node) warning: possible EventEmitter memory leak detected. %d listeners added. Use emitter.setMaxListeners() to increase limit.", this._events[t].length), "function" == typeof console.trace && console.trace()), this;
        }, n.prototype.on = n.prototype.addListener, n.prototype.once = function (t, e) {
            function n() {
                this.removeListener(t, n), o || (o = !0, e.apply(this, arguments));
            }if (!i(e)) throw TypeError("listener must be a function");var o = !1;return n.listener = e, this.on(t, n), this;
        }, n.prototype.removeListener = function (t, e) {
            var n, o, r, a;if (!i(e)) throw TypeError("listener must be a function");if (!this._events || !this._events[t]) return this;if (n = this._events[t], r = n.length, o = -1, n === e || i(n.listener) && n.listener === e) delete this._events[t], this._events.removeListener && this.emit("removeListener", t, e);else if (s(n)) {
                for (a = r; a-- > 0;) {
                    if (n[a] === e || n[a].listener && n[a].listener === e) {
                        o = a;break;
                    }
                }if (o < 0) return this;1 === n.length ? (n.length = 0, delete this._events[t]) : n.splice(o, 1), this._events.removeListener && this.emit("removeListener", t, e);
            }return this;
        }, n.prototype.removeAllListeners = function (t) {
            var e, n;if (!this._events) return this;if (!this._events.removeListener) return 0 === arguments.length ? this._events = {} : this._events[t] && delete this._events[t], this;if (0 === arguments.length) {
                for (e in this._events) {
                    "removeListener" !== e && this.removeAllListeners(e);
                }return this.removeAllListeners("removeListener"), this._events = {}, this;
            }if (n = this._events[t], i(n)) this.removeListener(t, n);else if (n) for (; n.length;) {
                this.removeListener(t, n[n.length - 1]);
            }return delete this._events[t], this;
        }, n.prototype.listeners = function (t) {
            return this._events && this._events[t] ? i(this._events[t]) ? [this._events[t]] : this._events[t].slice() : [];
        }, n.prototype.listenerCount = function (t) {
            if (this._events) {
                var e = this._events[t];if (i(e)) return 1;if (e) return e.length;
            }return 0;
        }, n.listenerCount = function (t, e) {
            return t.listenerCount(e);
        };
    }, function (t, e, n) {
        "use strict";
        var i = Object.prototype.hasOwnProperty,
            o = Object.prototype.toString,
            s = Array.prototype.slice,
            r = n(77),
            a = Object.prototype.propertyIsEnumerable,
            l = !a.call({ toString: null }, "toString"),
            c = a.call(function () {}, "prototype"),
            u = ["toString", "toLocaleString", "valueOf", "hasOwnProperty", "isPrototypeOf", "propertyIsEnumerable", "constructor"],
            h = function h(t) {
            var e = t.constructor;return e && e.prototype === t;
        },
            p = { $console: !0, $external: !0, $frame: !0, $frameElement: !0, $frames: !0, $innerHeight: !0, $innerWidth: !0, $outerHeight: !0, $outerWidth: !0, $pageXOffset: !0, $pageYOffset: !0, $parent: !0, $scrollLeft: !0, $scrollTop: !0, $scrollX: !0, $scrollY: !0, $self: !0, $webkitIndexedDB: !0, $webkitStorageInfo: !0, $window: !0 },
            d = function () {
            if ("undefined" == typeof window) return !1;for (var t in window) {
                try {
                    if (!p["$" + t] && i.call(window, t) && null !== window[t] && "object" == _typeof(window[t])) try {
                        h(window[t]);
                    } catch (t) {
                        return !0;
                    }
                } catch (t) {
                    return !0;
                }
            }return !1;
        }(),
            f = function f(t) {
            if ("undefined" == typeof window || !d) return h(t);try {
                return h(t);
            } catch (t) {
                return !1;
            }
        },
            g = function g(t) {
            var e = null !== t && "object" == (void 0 === t ? "undefined" : _typeof(t)),
                n = "[object Function]" === o.call(t),
                s = r(t),
                a = e && "[object String]" === o.call(t),
                h = [];if (!e && !n && !s) throw new TypeError("Object.keys called on a non-object");var p = c && n;if (a && t.length > 0 && !i.call(t, 0)) for (var d = 0; d < t.length; ++d) {
                h.push(String(d));
            }if (s && t.length > 0) for (var g = 0; g < t.length; ++g) {
                h.push(String(g));
            } else for (var m in t) {
                p && "prototype" === m || !i.call(t, m) || h.push(String(m));
            }if (l) for (var v = f(t), y = 0; y < u.length; ++y) {
                v && "constructor" === u[y] || !i.call(t, u[y]) || h.push(u[y]);
            }return h;
        };g.shim = function () {
            if (Object.keys) {
                if (!function () {
                    return 2 === (Object.keys(arguments) || "").length;
                }(1, 2)) {
                    var t = Object.keys;Object.keys = function (e) {
                        return t(r(e) ? s.call(e) : e);
                    };
                }
            } else Object.keys = g;return Object.keys || g;
        }, t.exports = g;
    }, function (t, e, n) {
        "use strict";
        var i = Object.prototype.toString;t.exports = function (t) {
            var e = i.call(t),
                n = "[object Arguments]" === e;return n || (n = "[object Array]" !== e && null !== t && "object" == (void 0 === t ? "undefined" : _typeof(t)) && "number" == typeof t.length && t.length >= 0 && "[object Function]" === i.call(t.callee)), n;
        };
    }, function (t, e, n) {
        "use strict";
        function i(t, e) {
            if (t.map) return t.map(e);for (var n = [], i = 0; i < t.length; i++) {
                n.push(e(t[i], i));
            }return n;
        }var o = function o(t) {
            switch (void 0 === t ? "undefined" : _typeof(t)) {case "string":
                    return t;case "boolean":
                    return t ? "true" : "false";case "number":
                    return isFinite(t) ? t : "";default:
                    return "";}
        };t.exports = function (t, e, n, a) {
            return e = e || "&", n = n || "=", null === t && (t = void 0), "object" == (void 0 === t ? "undefined" : _typeof(t)) ? i(r(t), function (r) {
                var a = encodeURIComponent(o(r)) + n;return s(t[r]) ? i(t[r], function (t) {
                    return a + encodeURIComponent(o(t));
                }).join(e) : a + encodeURIComponent(o(t[r]));
            }).join(e) : a ? encodeURIComponent(o(a)) + n + encodeURIComponent(o(t)) : "";
        };var s = Array.isArray || function (t) {
            return "[object Array]" === Object.prototype.toString.call(t);
        },
            r = Object.keys || function (t) {
            var e = [];for (var n in t) {
                Object.prototype.hasOwnProperty.call(t, n) && e.push(n);
            }return e;
        };
    }, function (t, e) {
        t.exports = '<svg width="12" height="12" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg"><path d="M.566 1.698L0 1.13 1.132 0l.565.566L6 4.868 10.302.566 10.868 0 12 1.132l-.566.565L7.132 6l4.302 4.3.566.568L10.868 12l-.565-.566L6 7.132l-4.3 4.302L1.13 12 0 10.868l.566-.565L4.868 6 .566 1.698z"/></svg>\n';
    },,, function (t, e, n) {
        "use strict";
        function i(t) {
            return t && t.__esModule ? t : { default: t };
        }var o = n(40),
            s = i(o),
            r = n(13),
            a = i(r);t.exports = s.default, t.exports.version = a.default;
    }]);
}), function (t) {
    var e,
        n,
        i = t(window),
        o = {},
        s = [],
        r = [],
        a = null,
        l = [],
        c = null,
        u = /(iPad|iPhone|iPod)/g.test(navigator.userAgent),
        h = { _init: function _init(e) {
            var n = t(e),
                i = n.data("popupoptions");r[e.id] = !1, s[e.id] = 0, n.data("popup-initialized") || (n.attr("data-popup-initialized", "true"), h._initonce(e)), i.autoopen && setTimeout(function () {
                h.show(e, 0);
            }, 0);
        }, _initonce: function _initonce(n) {
            var i,
                o,
                s = t(n),
                r = t("body"),
                l = s.data("popupoptions");if (a = parseInt(r.css("margin-right"), 10), c = void 0 !== document.body.style.webkitTransition || void 0 !== document.body.style.MozTransition || void 0 !== document.body.style.msTransition || void 0 !== document.body.style.OTransition || void 0 !== document.body.style.transition, "tooltip" == l.type && (l.background = !1, l.scrolllock = !1), l.backgroundactive && (l.background = !1, l.blur = !1, l.scrolllock = !1), l.scrolllock) {
                var p, d;void 0 === e && (p = t('<div style="width:50px;height:50px;overflow:auto"><div/></div>').appendTo("body"), d = p.children(), e = d.innerWidth() - d.height(99).innerWidth(), p.remove());
            }if (s.attr("id") || s.attr("id", "j-popup-" + parseInt(1e8 * Math.random(), 10)), s.addClass("popup_content"), r.prepend(n), s.wrap('<div id="' + n.id + '_wrapper" class="popup_wrapper" />'), i = t("#" + n.id + "_wrapper"), i.css({ opacity: 0, visibility: "hidden", position: "absolute" }), u && i.css("cursor", "pointer"), "overlay" == l.type && i.css("overflow", "auto"), s.css({ opacity: 0, visibility: "hidden", display: "inline-block" }), l.setzindex && !l.autozindex && i.css("z-index", "100001"), l.outline || s.css("outline", "none"), l.transition && (s.css("transition", l.transition), i.css("transition", l.transition)), s.attr("aria-hidden", !0), l.background && !t("#" + n.id + "_background").length) {
                r.prepend('<div id="' + n.id + '_background" class="popup_background"></div>');var f = t("#" + n.id + "_background");f.css({ opacity: 0, visibility: "hidden", backgroundColor: l.color, position: "fixed", top: 0, right: 0, bottom: 0, left: 0 }), l.setzindex && !l.autozindex && f.css("z-index", "100000"), l.transition && f.css("transition", l.transition);
            }"overlay" == l.type && (s.css({ textAlign: "left", position: "relative", verticalAlign: "middle" }), o = { position: "fixed", width: "100%", height: "100%", top: 0, left: 0, textAlign: "center" }, l.backgroundactive && (o.position = "relative", o.height = "0", o.overflow = "visible"), i.css(o), i.append('<div class="popup_align" />'), t(".popup_align").css({ display: "inline-block", verticalAlign: "middle", height: "100%" })), s.attr("role", "dialog");var g = l.openelement ? l.openelement : "." + n.id + "_open";t(g).each(function (e, n) {
                t(n).attr("data-popup-ordinal", e), n.id || t(n).attr("id", "open_" + parseInt(1e8 * Math.random(), 10));
            }), s.attr("aria-labelledby") || s.attr("aria-label") || s.attr("aria-labelledby", t(g).attr("id"));var m = l.closeelement ? l.closeelement : "." + n.id + "_close";t(document).on("click", m, function (t) {
                h.hide(n), t.preventDefault();
            }), "hover" == l.action ? (l.keepfocus = !1, t(g).on("mouseenter", function (e) {
                h.show(n, t(this).data("popup-ordinal"));
            }), t(g).on("mouseleave", function (t) {
                h.hide(n);
            })) : t(document).on("click", g, function (e) {
                e.preventDefault();var i = t(this).data("popup-ordinal");setTimeout(function () {
                    h.show(n, i);
                }, 0);
            }), l.detach ? s.hide().detach() : i.hide();
        }, show: function show(o, u) {
            var d = t(o);if (!d.data("popup-visible")) {
                d.data("popup-initialized") || h._init(o), d.attr("data-popup-initialized", "true");var f = t("body"),
                    g = d.data("popupoptions"),
                    m = t("#" + o.id + "_wrapper"),
                    v = t("#" + o.id + "_background");if (p(o, u, g.beforeopen), r[o.id] = u, setTimeout(function () {
                    l.push(o.id);
                }, 0), g.autozindex) {
                    for (var y = document.getElementsByTagName("*"), b = y.length, w = 0, _ = 0; _ < b; _++) {
                        var x = t(y[_]).css("z-index");"auto" !== x && (x = parseInt(x, 10), w < x && (w = x));
                    }s[o.id] = w, g.background && s[o.id] > 0 && t("#" + o.id + "_background").css({ zIndex: s[o.id] + 1 }), s[o.id] > 0 && m.css({ zIndex: s[o.id] + 2 });
                }g.detach ? (m.prepend(o), d.show()) : m.show(), n = setTimeout(function () {
                    m.css({ visibility: "visible", opacity: 1 }), t("html").addClass("popup_visible").addClass("popup_visible_" + o.id), d.addClass("popup_content_visible");
                }, 20), g.scrolllock && (f.css("overflow", "hidden"), f.height() > i.height() && f.css("margin-right", a + e)), g.backgroundactive && d.css({ top: (i.height() - (d.get(0).offsetHeight + parseInt(d.css("margin-top"), 10) + parseInt(d.css("margin-bottom"), 10))) / 2 + "px" }), d.css({ visibility: "visible", opacity: 1 }), g.background && (v.css({ visibility: "visible", opacity: g.opacity }), setTimeout(function () {
                    v.css({ opacity: g.opacity });
                }, 0)), d.data("popup-visible", !0), h.reposition(o, u), d.data("focusedelementbeforepopup", document.activeElement), g.keepfocus && (d.attr("tabindex", -1), setTimeout(function () {
                    "closebutton" === g.focuselement ? t("#" + o.id + " ." + o.id + "_close:first").focus() : g.focuselement ? t(g.focuselement).focus() : d.focus();
                }, g.focusdelay)), t(g.pagecontainer).attr("aria-hidden", !0), d.attr("aria-hidden", !1), p(o, u, g.onopen), c ? m.one("transitionend", function () {
                    p(o, u, g.opentransitionend);
                }) : p(o, u, g.opentransitionend);
            }
        }, hide: function hide(e) {
            n && clearTimeout(n);var i = t("body"),
                o = t(e),
                s = o.data("popupoptions"),
                u = t("#" + e.id + "_wrapper"),
                h = t("#" + e.id + "_background");o.data("popup-visible", !1), 1 === l.length ? t("html").removeClass("popup_visible").removeClass("popup_visible_" + e.id) : t("html").hasClass("popup_visible_" + e.id) && t("html").removeClass("popup_visible_" + e.id), l.pop(), t("html").hasClass("popup_content_visible") && o.removeClass("popup_content_visible"), s.keepfocus && setTimeout(function () {
                t(o.data("focusedelementbeforepopup")).is(":visible") && o.data("focusedelementbeforepopup").focus();
            }, 0), u.css({ visibility: "hidden", opacity: 0 }), o.css({ visibility: "hidden", opacity: 0 }), s.background && h.css({ visibility: "hidden", opacity: 0 }), t(s.pagecontainer).attr("aria-hidden", !1), o.attr("aria-hidden", !0), p(e, r[e.id], s.onclose), c && "0s" !== o.css("transition-duration") ? o.one("transitionend", function (t) {
                o.data("popup-visible") || (s.detach ? o.hide().detach() : u.hide()), s.scrolllock && setTimeout(function () {
                    i.css({ overflow: "visible", "margin-right": a });
                }, 10), p(e, r[e.id], s.closetransitionend);
            }) : (s.detach ? o.hide().detach() : u.hide(), s.scrolllock && setTimeout(function () {
                i.css({ overflow: "visible", "margin-right": a });
            }, 10), p(e, r[e.id], s.closetransitionend));
        }, toggle: function toggle(e, n) {
            t(e).data("popup-visible") ? h.hide(e) : setTimeout(function () {
                h.show(e, n);
            }, 0);
        }, reposition: function reposition(e, n) {
            var o = t(e),
                s = o.data("popupoptions"),
                r = t("#" + e.id + "_wrapper");t("#" + e.id + "_background");if (n = n || 0, "tooltip" == s.type) {
                r.css({ position: "absolute" });var a;a = s.tooltipanchor ? t(s.tooltipanchor) : s.openelement ? t(s.openelement).filter('[data-popup-ordinal="' + n + '"]') : t("." + e.id + '_open[data-popup-ordinal="' + n + '"]');var l = a.offset();"right" == s.horizontal ? r.css("left", l.left + a.outerWidth() + s.offsetleft) : "leftedge" == s.horizontal ? r.css("left", l.left + a.outerWidth() - a.outerWidth() + s.offsetleft) : "left" == s.horizontal ? r.css("right", i.width() - l.left - s.offsetleft) : "rightedge" == s.horizontal ? r.css("right", i.width() - l.left - a.outerWidth() - s.offsetleft) : r.css("left", l.left + a.outerWidth() / 2 - o.outerWidth() / 2 - parseFloat(o.css("marginLeft")) + s.offsetleft), "bottom" == s.vertical ? r.css("top", l.top + a.outerHeight() + s.offsettop) : "bottomedge" == s.vertical ? r.css("top", l.top + a.outerHeight() - o.outerHeight() + s.offsettop) : "top" == s.vertical ? r.css("bottom", i.height() - l.top - s.offsettop) : "topedge" == s.vertical ? r.css("bottom", i.height() - l.top - o.outerHeight() - s.offsettop) : r.css("top", l.top + a.outerHeight() / 2 - o.outerHeight() / 2 - parseFloat(o.css("marginTop")) + s.offsettop);
            } else "overlay" == s.type && (s.horizontal ? r.css("text-align", s.horizontal) : r.css("text-align", "center"), s.vertical ? o.css("vertical-align", s.vertical) : o.css("vertical-align", "middle"));
        } },
        p = function p(e, n, i) {
        var s = o.openelement ? o.openelement : "." + e.id + "_open",
            r = t(s + '[data-popup-ordinal="' + n + '"]');"function" == typeof i && i.call(t(e), e, r);
    };t(document).on("keydown", function (e) {
        if (l.length) {
            var n = l[l.length - 1],
                i = document.getElementById(n);t(i).data("popupoptions").escape && 27 == e.keyCode && t(i).data("popup-visible") && h.hide(i);
        }
    }), t(document).on("click", function (e) {
        if (l.length) {
            var n = l[l.length - 1],
                i = document.getElementById(n);t(i).data("popupoptions").blur && !t(e.target).parents().andSelf().is("#" + n) && t(i).data("popup-visible") && 2 !== e.which && (h.hide(i), "overlay" === t(i).data("popupoptions").type && e.preventDefault());
        }
    }), t(document).on("focusin", function (e) {
        if (l.length) {
            var n = l[l.length - 1],
                i = document.getElementById(n);t(i).data("popupoptions").keepfocus && (i.contains(e.target) || (e.stopPropagation(), i.focus()));
        }
    }), t.fn.popup = function (e) {
        return this.each(function () {
            var n = t(this);if ("object" === (void 0 === e ? "undefined" : _typeof(e))) {
                var i = t.extend({}, t.fn.popup.defaults, e);n.data("popupoptions", i), o = n.data("popupoptions"), h._init(this);
            } else "string" == typeof e ? (n.data("popupoptions") || (n.data("popupoptions", t.fn.popup.defaults), o = n.data("popupoptions")), h[e].call(this, this)) : (el.data("popupoptions") || (el.data("popupoptions", t.fn.popup.defaults), o = el.data("popupoptions")), h._init(this));
        });
    }, t.fn.popup.defaults = { type: "overlay", autoopen: !1, background: !0, backgroundactive: !1, color: "black", opacity: "0.5", horizontal: "center", vertical: "middle", offsettop: 0, offsetleft: 0, escape: !0, blur: !0, setzindex: !0, autozindex: !1, scrolllock: !1, keepfocus: !0, focuselement: null, focusdelay: 50, outline: !1, pagecontainer: null, detach: !1, openelement: null, closeelement: null, transition: null, tooltipanchor: null, beforeopen: null, onclose: null, onopen: null, opentransitionend: null, closetransitionend: null };
}(jQuery);
setupFormLoadingImage();
function setupFormLoadingImage() {
    $('form').submit(function (event) {
        $('.busy').show('fast');
        return true;
    });
}

function copyToClipboard(element) {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($(element).text()).select();
    document.execCommand("copy");
    $temp.remove();
}

function toggleSidebar() {
    var position = 0;
    if ($('#sidebar').position().left == 0) {
        position = -350;
    }
    $('#sidebar').animate({ "left": position + "px" }, 200);
}

var csrf_token = "{{ csrf_token() }}";
$(".delete-resource, .delete-resource-simple").on('click', function (e) {
    if (!confirm("Are you sure?")) {
        return false;
    } else {
        e.preventDefault();
        var url = $(this).attr('href');
        $('<form action="' + url + '" method="POST"><input type="hidden" name="_method" value="DELETE"><input type="hidden" name="_token" value="' + csrf_token + '"></form>').appendTo('body').submit();
    }
});
!function (a) {
    var b = new Array(),
        c = new Array();a.fn.doAutosize = function (b) {
        var c = a(this).data("minwidth"),
            d = a(this).data("maxwidth"),
            e = "",
            f = a(this),
            g = a("#" + a(this).data("tester_id"));if (e !== (e = f.val())) {
            var h = e.replace(/&/g, "&amp;").replace(/\s/g, " ").replace(/</g, "&lt;").replace(/>/g, "&gt;");g.html(h);var i = g.width(),
                j = i + b.comfortZone >= c ? i + b.comfortZone : c,
                k = f.width(),
                l = k > j && j >= c || j > c && d > j;l && f.width(j);
        }
    }, a.fn.resetAutosize = function (b) {
        var c = a(this).data("minwidth") || b.minInputWidth || a(this).width(),
            d = a(this).data("maxwidth") || b.maxInputWidth || a(this).closest(".tagsinput").width() - b.inputPadding,
            e = a(this),
            f = a("<tester/>").css({ position: "absolute", top: -9999, left: -9999, width: "auto", fontSize: e.css("fontSize"), fontFamily: e.css("fontFamily"), fontWeight: e.css("fontWeight"), letterSpacing: e.css("letterSpacing"), whiteSpace: "nowrap" }),
            g = a(this).attr("id") + "_autosize_tester";!a("#" + g).length > 0 && (f.attr("id", g), f.appendTo("body")), e.data("minwidth", c), e.data("maxwidth", d), e.data("tester_id", g), e.css("width", c);
    }, a.fn.addTag = function (d, e) {
        return e = jQuery.extend({ focus: !1, callback: !0 }, e), this.each(function () {
            var f = a(this).attr("id"),
                g = a(this).val().split(b[f]);if ("" == g[0] && (g = new Array()), d = jQuery.trim(d), e.unique) {
                var h = a(this).tagExist(d);1 == h && a("#" + f + "_tag").addClass("not_valid");
            } else var h = !1;if ("" != d && 1 != h) {
                if (a("<span>").addClass("tag").append(a("<span>").text(d).append("&nbsp;&nbsp;"), a("<a>", { href: "#", title: "Removing tag", text: "x" }).click(function () {
                    return a("#" + f).removeTag(escape(d));
                })).insertBefore("#" + f + "_addTag"), g.push(d), a("#" + f + "_tag").val(""), e.focus ? a("#" + f + "_tag").focus() : a("#" + f + "_tag").blur(), a.fn.tagsInput.updateTagsField(this, g), e.callback && c[f] && c[f].onAddTag) {
                    var i = c[f].onAddTag;i.call(this, d);
                }if (c[f] && c[f].onChange) {
                    var j = g.length,
                        i = c[f].onChange;i.call(this, a(this), g[j - 1]);
                }
            }
        }), !1;
    }, a.fn.removeTag = function (d) {
        return d = unescape(d), this.each(function () {
            var e = a(this).attr("id"),
                f = a(this).val().split(b[e]);for (a("#" + e + "_tagsinput .tag").remove(), str = "", i = 0; i < f.length; i++) {
                f[i] != d && (str = str + b[e] + f[i]);
            }if (a.fn.tagsInput.importTags(this, str), c[e] && c[e].onRemoveTag) {
                var g = c[e].onRemoveTag;g.call(this, d);
            }
        }), !1;
    }, a.fn.tagExist = function (c) {
        var d = a(this).attr("id"),
            e = a(this).val().split(b[d]);return jQuery.inArray(c, e) >= 0;
    }, a.fn.importTags = function (b) {
        var c = a(this).attr("id");a("#" + c + "_tagsinput .tag").remove(), a.fn.tagsInput.importTags(this, b);
    }, a.fn.tagsInput = function (e) {
        var f = jQuery.extend({ interactive: !0, defaultText: "add a tag", minChars: 0, width: "300px", height: "100px", autocomplete: { selectFirst: !1 }, hide: !0, delimiter: ",", unique: !0, removeWithBackspace: !0, placeholderColor: "#666666", autosize: !0, comfortZone: 20, inputPadding: 12 }, e),
            g = 0;return this.each(function () {
            if ("undefined" == typeof a(this).attr("data-tagsinput-init")) {
                a(this).attr("data-tagsinput-init", !0), f.hide && a(this).hide();var e = a(this).attr("id");(!e || b[a(this).attr("id")]) && (e = a(this).attr("id", "tags" + new Date().getTime() + g++).attr("id"));var h = jQuery.extend({ pid: e, real_input: "#" + e, holder: "#" + e + "_tagsinput", input_wrapper: "#" + e + "_addTag", fake_input: "#" + e + "_tag" }, f);b[e] = h.delimiter, (f.onAddTag || f.onRemoveTag || f.onChange) && (c[e] = new Array(), c[e].onAddTag = f.onAddTag, c[e].onRemoveTag = f.onRemoveTag, c[e].onChange = f.onChange);var i = '<div id="' + e + '_tagsinput" class="tagsinput"><div id="' + e + '_addTag">';if (f.interactive && (i = i + '<input id="' + e + '_tag" value="" data-default="' + f.defaultText + '" />'), i += '</div><div class="tags_clear"></div></div>', a(i).insertAfter(this), a(h.holder).css("width", f.width), a(h.holder).css("min-height", f.height), a(h.holder).css("height", f.height), "" != a(h.real_input).val() && a.fn.tagsInput.importTags(a(h.real_input), a(h.real_input).val()), f.interactive) {
                    if (a(h.fake_input).val(a(h.fake_input).attr("data-default")), a(h.fake_input).css("color", f.placeholderColor), a(h.fake_input).resetAutosize(f), a(h.holder).bind("click", h, function (b) {
                        a(b.data.fake_input).focus();
                    }), a(h.fake_input).bind("focus", h, function (b) {
                        a(b.data.fake_input).val() == a(b.data.fake_input).attr("data-default") && a(b.data.fake_input).val(""), a(b.data.fake_input).css("color", "#000000");
                    }), void 0 != f.autocomplete_url) {
                        autocomplete_options = { source: f.autocomplete_url };for (attrname in f.autocomplete) {
                            autocomplete_options[attrname] = f.autocomplete[attrname];
                        }void 0 !== jQuery.Autocompleter ? (a(h.fake_input).autocomplete(f.autocomplete_url, f.autocomplete), a(h.fake_input).bind("result", h, function (b, c, d) {
                            c && a("#" + e).addTag(c[0] + "", { focus: !0, unique: f.unique });
                        })) : void 0 !== jQuery.ui.autocomplete && (a(h.fake_input).autocomplete(autocomplete_options), a(h.fake_input).bind("autocompleteselect", h, function (b, c) {
                            return a(b.data.real_input).addTag(c.item.value, { focus: !0, unique: f.unique }), !1;
                        }));
                    } else a(h.fake_input).bind("blur", h, function (b) {
                        var c = a(this).attr("data-default");return "" != a(b.data.fake_input).val() && a(b.data.fake_input).val() != c ? b.data.minChars <= a(b.data.fake_input).val().length && (!b.data.maxChars || b.data.maxChars >= a(b.data.fake_input).val().length) && a(b.data.real_input).addTag(a(b.data.fake_input).val(), { focus: !0, unique: f.unique }) : (a(b.data.fake_input).val(a(b.data.fake_input).attr("data-default")), a(b.data.fake_input).css("color", f.placeholderColor)), !1;
                    });a(h.fake_input).bind("keypress", h, function (b) {
                        return d(b) ? (b.preventDefault(), b.data.minChars <= a(b.data.fake_input).val().length && (!b.data.maxChars || b.data.maxChars >= a(b.data.fake_input).val().length) && a(b.data.real_input).addTag(a(b.data.fake_input).val(), { focus: !0, unique: f.unique }), a(b.data.fake_input).resetAutosize(f), !1) : void (b.data.autosize && a(b.data.fake_input).doAutosize(f));
                    }), h.removeWithBackspace && a(h.fake_input).bind("keydown", function (b) {
                        if (8 == b.keyCode && "" == a(this).val()) {
                            b.preventDefault();var c = a(this).closest(".tagsinput").find(".tag:last").text(),
                                d = a(this).attr("id").replace(/_tag$/, "");c = c.replace(/[\s]+x$/, ""), a("#" + d).removeTag(escape(c)), a(this).trigger("focus");
                        }
                    }), a(h.fake_input).blur(), h.unique && a(h.fake_input).keydown(function (b) {
                        (8 == b.keyCode || String.fromCharCode(b.which).match(/\w+|[áéíóúÁÉÍÓÚñÑ,/]+/)) && a(this).removeClass("not_valid");
                    });
                }
            }
        }), this;
    }, a.fn.tagsInput.updateTagsField = function (c, d) {
        var e = a(c).attr("id");a(c).val(d.join(b[e]));
    }, a.fn.tagsInput.importTags = function (d, e) {
        a(d).val("");var f = a(d).attr("id"),
            g = e.split(b[f]);for (i = 0; i < g.length; i++) {
            a(d).addTag(g[i], { focus: !1, callback: !1 });
        }if (c[f] && c[f].onChange) {
            var h = c[f].onChange;h.call(d, d, g[i]);
        }
    };var d = function d(b) {
        var c = !1;return 13 == b.which ? !0 : ("string" == typeof b.data.delimiter ? b.which == b.data.delimiter.charCodeAt(0) && (c = !0) : a.each(b.data.delimiter, function (a, d) {
            b.which == d.charCodeAt(0) && (c = !0);
        }), c);
    };
}(jQuery);
/* =============================================================
 * bootstrap-typeahead.js v2.3.2
 * http://twitter.github.com/bootstrap/javascript.html#typeahead
 * =============================================================
 * Copyright 2012 Twitter, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ============================================================ */

!function ($) {

    "use strict"; // jshint ;_;


    /* TYPEAHEAD PUBLIC CLASS DEFINITION
     * ================================= */

    var Typeahead = function Typeahead(element, options) {
        this.$element = $(element);
        this.options = $.extend({}, $.fn.typeahead.defaults, options);
        this.matcher = this.options.matcher || this.matcher;
        this.sorter = this.options.sorter || this.sorter;
        this.highlighter = this.options.highlighter || this.highlighter;
        this.updater = this.options.updater || this.updater;
        this.source = this.options.source;
        this.$menu = $(this.options.menu);
        this.shown = false;
        this.listen();
    };

    Typeahead.prototype = {

        constructor: Typeahead,

        select: function select() {
            var val = this.$menu.find('.active').attr('data-value');
            this.$element.val(this.updater(val)).change();
            return this.hide();
        },

        updater: function updater(item) {
            return item;
        },

        show: function show() {
            var pos = $.extend({}, this.$element.position(), {
                height: this.$element[0].offsetHeight
            });

            this.$menu.insertAfter(this.$element).css({
                top: pos.top + pos.height,
                left: pos.left
            }).show();

            this.shown = true;
            return this;
        },

        hide: function hide() {
            this.$menu.hide();
            this.shown = false;
            return this;
        },

        lookup: function lookup(event) {
            var items;

            this.query = this.$element.val();

            if (!this.query || this.query.length < this.options.minLength) {
                return this.shown ? this.hide() : this;
            }

            items = $.isFunction(this.source) ? this.source(this.query, $.proxy(this.process, this)) : this.source;

            return items ? this.process(items) : this;
        },

        process: function process(items) {
            var that = this;

            items = $.grep(items, function (item) {
                return that.matcher(item);
            });

            items = this.sorter(items);

            if (!items.length) {
                return this.shown ? this.hide() : this;
            }

            return this.render(items.slice(0, this.options.items)).show();
        },

        matcher: function matcher(item) {
            return ~item.toLowerCase().indexOf(this.query.toLowerCase());
        },

        sorter: function sorter(items) {
            var beginswith = [],
                caseSensitive = [],
                caseInsensitive = [],
                item;

            while (item = items.shift()) {
                if (!item.toLowerCase().indexOf(this.query.toLowerCase())) beginswith.push(item);else if (~item.indexOf(this.query)) caseSensitive.push(item);else caseInsensitive.push(item);
            }

            return beginswith.concat(caseSensitive, caseInsensitive);
        },

        highlighter: function highlighter(item) {
            var query = this.query.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, '\\$&');
            return item.replace(new RegExp('(' + query + ')', 'ig'), function ($1, match) {
                return '<strong>' + match + '</strong>';
            });
        },

        render: function render(items) {
            var that = this;

            items = $(items).map(function (i, item) {
                i = $(that.options.item).attr('data-value', item);
                i.find('a').html(that.highlighter(item));
                return i[0];
            });

            items.first().addClass('active');
            this.$menu.html(items);
            return this;
        },

        next: function next(event) {
            var active = this.$menu.find('.active').removeClass('active'),
                next = active.next();

            if (!next.length) {
                next = $(this.$menu.find('li')[0]);
            }

            next.addClass('active');
        },

        prev: function prev(event) {
            var active = this.$menu.find('.active').removeClass('active'),
                prev = active.prev();

            if (!prev.length) {
                prev = this.$menu.find('li').last();
            }

            prev.addClass('active');
        },

        listen: function listen() {
            this.$element.on('focus', $.proxy(this.focus, this)).on('blur', $.proxy(this.blur, this)).on('keypress', $.proxy(this.keypress, this)).on('keyup', $.proxy(this.keyup, this));

            if (this.eventSupported('keydown')) {
                this.$element.on('keydown', $.proxy(this.keydown, this));
            }

            this.$menu.on('click', $.proxy(this.click, this)).on('mouseenter', 'li', $.proxy(this.mouseenter, this)).on('mouseleave', 'li', $.proxy(this.mouseleave, this));
        },

        eventSupported: function eventSupported(eventName) {
            var isSupported = eventName in this.$element;
            if (!isSupported) {
                this.$element.setAttribute(eventName, 'return;');
                isSupported = typeof this.$element[eventName] === 'function';
            }
            return isSupported;
        },

        move: function move(e) {
            if (!this.shown) return;

            switch (e.keyCode) {
                case 9: // tab
                case 13: // enter
                case 27:
                    // escape
                    e.preventDefault();
                    break;

                case 38:
                    // up arrow
                    e.preventDefault();
                    this.prev();
                    break;

                case 40:
                    // down arrow
                    e.preventDefault();
                    this.next();
                    break;
            }

            e.stopPropagation();
        },

        keydown: function keydown(e) {
            this.suppressKeyPressRepeat = ~$.inArray(e.keyCode, [40, 38, 9, 13, 27]);
            this.move(e);
        },

        keypress: function keypress(e) {
            if (this.suppressKeyPressRepeat) return;
            this.move(e);
        },

        keyup: function keyup(e) {
            switch (e.keyCode) {
                case 40: // down arrow
                case 38: // up arrow
                case 16: // shift
                case 17: // ctrl
                case 18:
                    // alt
                    break;

                case 9: // tab
                case 13:
                    // enter
                    if (!this.shown) return;
                    this.select();
                    break;

                case 27:
                    // escape
                    if (!this.shown) return;
                    this.hide();
                    break;

                default:
                    this.lookup();
            }

            e.stopPropagation();
            e.preventDefault();
        },

        focus: function focus(e) {
            this.focused = true;
        },

        blur: function blur(e) {
            this.focused = false;
            if (!this.mousedover && this.shown) this.hide();
        },

        click: function click(e) {
            e.stopPropagation();
            e.preventDefault();
            this.select();
            this.$element.focus();
        },

        mouseenter: function mouseenter(e) {
            this.mousedover = true;
            this.$menu.find('.active').removeClass('active');
            $(e.currentTarget).addClass('active');
        },

        mouseleave: function mouseleave(e) {
            this.mousedover = false;
            if (!this.focused && this.shown) this.hide();
        }

        /* TYPEAHEAD PLUGIN DEFINITION
         * =========================== */

    };var old = $.fn.typeahead;

    $.fn.typeahead = function (option) {
        return this.each(function () {
            var $this = $(this),
                data = $this.data('typeahead'),
                options = (typeof option === "undefined" ? "undefined" : _typeof2(option)) == 'object' && option;
            if (!data) $this.data('typeahead', data = new Typeahead(this, options));
            if (typeof option == 'string') data[option]();
        });
    };

    $.fn.typeahead.defaults = {
        source: [],
        items: 8,
        menu: '<ul class="typeahead dropdown-menu"></ul>',
        item: '<li><a href="#"></a></li>',
        minLength: 1
    };

    $.fn.typeahead.Constructor = Typeahead;

    /* TYPEAHEAD NO CONFLICT
     * =================== */

    $.fn.typeahead.noConflict = function () {
        $.fn.typeahead = old;
        return this;
    };

    /* TYPEAHEAD DATA-API
     * ================== */

    $(document).on('focus.typeahead.data-api', '[data-provide="typeahead"]', function (e) {
        var $this = $(this);
        if ($this.data('typeahead')) return;
        $this.typeahead($this.data());
    });
}(window.jQuery);

/*jslint forin: true */

;(function ($) {
    $.fn.extend({
        mention: function mention(options) {
            this.opts = {
                users: [],
                delimiter: '@',
                sensitive: true,
                emptyQuery: false,
                queryBy: ['name', 'username'],
                typeaheadOpts: {}
            };

            var settings = $.extend({}, this.opts, options),
                _checkDependencies = function _checkDependencies() {
                if (typeof $ == 'undefined') {
                    throw new Error("jQuery is Required");
                } else {
                    if (typeof $.fn.typeahead == 'undefined') {
                        throw new Error("Typeahead is Required");
                    }
                }
                return true;
            },
                _extractCurrentQuery = function _extractCurrentQuery(query, caratPos) {
                var i;
                for (i = caratPos; i >= 0; i--) {
                    if (query[i] == settings.delimiter) {
                        break;
                    }
                }
                return query.substring(i, caratPos);
            },
                _matcher = function _matcher(itemProps) {
                var i;

                if (settings.emptyQuery) {
                    var q = this.query.toLowerCase(),
                        caratPos = this.$element[0].selectionStart,
                        lastChar = q.slice(caratPos - 1, caratPos);
                    if (lastChar == settings.delimiter) {
                        return true;
                    }
                }

                for (i in settings.queryBy) {
                    if (itemProps[settings.queryBy[i]]) {
                        var item = itemProps[settings.queryBy[i]].toLowerCase(),
                            usernames = this.query.toLowerCase().match(new RegExp(settings.delimiter + '\\w+', "g")),
                            j;
                        if (!!usernames) {
                            for (j = 0; j < usernames.length; j++) {
                                var username = usernames[j].substring(1).toLowerCase(),
                                    re = new RegExp(settings.delimiter + item, "g"),
                                    used = this.query.toLowerCase().match(re);

                                if (item.indexOf(username) != -1 && used === null) {
                                    return true;
                                }
                            }
                        }
                    }
                }
            },
                _updater = function _updater(item) {
                var data = this.query,
                    caratPos = this.$element[0].selectionStart,
                    i;

                for (i = caratPos; i >= 0; i--) {
                    if (data[i] == settings.delimiter) {
                        break;
                    }
                }
                var replace = data.substring(i, caratPos),
                    textBefore = data.substring(0, i),
                    textAfter = data.substring(caratPos),
                    data = textBefore + settings.delimiter + item + textAfter;

                this.tempQuery = data;

                return data;
            },
                _sorter = function _sorter(items) {
                if (items.length && settings.sensitive) {
                    var currentUser = _extractCurrentQuery(this.query, this.$element[0].selectionStart).substring(1),
                        i,
                        len = items.length,
                        priorities = {
                        highest: [],
                        high: [],
                        med: [],
                        low: []
                    },
                        finals = [];
                    if (currentUser.length == 1) {
                        for (i = 0; i < len; i++) {
                            var currentRes = items[i];

                            if (currentRes.username[0] == currentUser) {
                                priorities.highest.push(currentRes);
                            } else if (currentRes.username[0].toLowerCase() == currentUser.toLowerCase()) {
                                priorities.high.push(currentRes);
                            } else if (currentRes.username.indexOf(currentUser) != -1) {
                                priorities.med.push(currentRes);
                            } else {
                                priorities.low.push(currentRes);
                            }
                        }
                        for (i in priorities) {
                            var j;
                            for (j in priorities[i]) {
                                finals.push(priorities[i][j]);
                            }
                        }
                        return finals;
                    }
                }
                return items;
            },
                _render = function _render(items) {
                var that = this;
                items = $(items).map(function (i, item) {

                    i = $(that.options.item).attr('data-value', item.username);

                    var _linkHtml = $('<div />');

                    if (item.image) {
                        _linkHtml.append('<img class="mention_image" src="' + item.image + '">');
                    }
                    if (item.name) {
                        _linkHtml.append('<b class="mention_name">' + item.name + '</b>');
                    }
                    if (item.username) {
                        _linkHtml.append('<span class="mention_username"> ' + settings.delimiter + item.username + '</span>');
                    }

                    i.find('a').html(that.highlighter(_linkHtml.html()));
                    return i[0];
                });

                items.first().addClass('active');
                this.$menu.html(items);
                return this;
            };

            $.fn.typeahead.Constructor.prototype.render = _render;

            return this.each(function () {
                var _this = $(this);
                if (_checkDependencies()) {
                    _this.typeahead($.extend({
                        source: settings.users,
                        matcher: _matcher,
                        updater: _updater,
                        sorter: _sorter
                    }, settings.typeaheadOpts));
                }
            });
        }
    });
})(jQuery);