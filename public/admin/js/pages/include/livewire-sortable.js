!(function (e, t) {
    "object" == typeof exports && "undefined" != typeof module ? (module.exports = t()) : "function" == typeof define && define.amd ? define(t) : ((e = e || self).Sortable = t());
})(this, function () {
    "use strict";
    var e,
        t = (function (e, t) {
            return e((t = { exports: {} }), t.exports), t.exports;
        })(function (e, t) {
            var r;
            window,
                (r = function () {
                    return (function (e) {
                        var t = {};
                        function r(n) {
                            if (t[n]) return t[n].exports;
                            var o = (t[n] = { i: n, l: !1, exports: {} });
                            return e[n].call(o.exports, o, o.exports, r), (o.l = !0), o.exports;
                        }
                        return (
                            (r.m = e),
                            (r.c = t),
                            (r.d = function (e, t, n) {
                                r.o(e, t) || Object.defineProperty(e, t, { enumerable: !0, get: n });
                            }),
                            (r.r = function (e) {
                                "undefined" != typeof Symbol && Symbol.toStringTag && Object.defineProperty(e, Symbol.toStringTag, { value: "Module" }), Object.defineProperty(e, "__esModule", { value: !0 });
                            }),
                            (r.t = function (e, t) {
                                if ((1 & t && (e = r(e)), 8 & t)) return e;
                                if (4 & t && "object" == typeof e && e && e.__esModule) return e;
                                var n = Object.create(null);
                                if ((r.r(n), Object.defineProperty(n, "default", { enumerable: !0, value: e }), 2 & t && "string" != typeof e))
                                    for (var o in e)
                                        r.d(
                                            n,
                                            o,
                                            function (t) {
                                                return e[t];
                                            }.bind(null, o)
                                        );
                                return n;
                            }),
                            (r.n = function (e) {
                                var t =
                                    e && e.__esModule
                                        ? function () {
                                              return e.default;
                                          }
                                        : function () {
                                              return e;
                                          };
                                return r.d(t, "a", t), t;
                            }),
                            (r.o = function (e, t) {
                                return Object.prototype.hasOwnProperty.call(e, t);
                            }),
                            (r.p = ""),
                            r((r.s = 44))
                        );
                    })([
                        function (e, t, r) {
                            Object.defineProperty(t, "__esModule", { value: !0 });
                            var n = r(19);
                            Object.keys(n).forEach(function (e) {
                                "default" !== e &&
                                    "__esModule" !== e &&
                                    Object.defineProperty(t, e, {
                                        enumerable: !0,
                                        get: function () {
                                            return n[e];
                                        },
                                    });
                            });
                        },
                        function (e, t, r) {
                            Object.defineProperty(t, "__esModule", { value: !0 });
                            var n,
                                o = r(22),
                                i = (n = o) && n.__esModule ? n : { default: n };
                            t.default = i.default;
                        },
                        function (e, t, r) {
                            Object.defineProperty(t, "__esModule", { value: !0 });
                            var n = r(26);
                            Object.defineProperty(t, "closest", {
                                enumerable: !0,
                                get: function () {
                                    return i(n).default;
                                },
                            });
                            var o = r(24);
                            function i(e) {
                                return e && e.__esModule ? e : { default: e };
                            }
                            Object.defineProperty(t, "requestNextAnimationFrame", {
                                enumerable: !0,
                                get: function () {
                                    return i(o).default;
                                },
                            });
                        },
                        function (e, t, r) {
                            Object.defineProperty(t, "__esModule", { value: !0 });
                            var n,
                                o = r(42),
                                i = (n = o) && n.__esModule ? n : { default: n };
                            t.default = i.default;
                        },
                        function (e, t, r) {
                            Object.defineProperty(t, "__esModule", { value: !0 });
                            var n,
                                o = r(35),
                                i = (n = o) && n.__esModule ? n : { default: n };
                            t.default = i.default;
                        },
                        function (e, t, r) {
                            Object.defineProperty(t, "__esModule", { value: !0 });
                            var n = r(1);
                            Object.defineProperty(t, "Sensor", {
                                enumerable: !0,
                                get: function () {
                                    return c(n).default;
                                },
                            });
                            var o = r(21);
                            Object.defineProperty(t, "MouseSensor", {
                                enumerable: !0,
                                get: function () {
                                    return c(o).default;
                                },
                            });
                            var i = r(18);
                            Object.defineProperty(t, "TouchSensor", {
                                enumerable: !0,
                                get: function () {
                                    return c(i).default;
                                },
                            });
                            var s = r(16);
                            Object.defineProperty(t, "DragSensor", {
                                enumerable: !0,
                                get: function () {
                                    return c(s).default;
                                },
                            });
                            var a = r(14);
                            Object.defineProperty(t, "ForceTouchSensor", {
                                enumerable: !0,
                                get: function () {
                                    return c(a).default;
                                },
                            });
                            var l = r(0);
                            function c(e) {
                                return e && e.__esModule ? e : { default: e };
                            }
                            Object.keys(l).forEach(function (e) {
                                "default" !== e &&
                                    "__esModule" !== e &&
                                    Object.defineProperty(t, e, {
                                        enumerable: !0,
                                        get: function () {
                                            return l[e];
                                        },
                                    });
                            });
                        },
                        function (e, t, r) {
                            Object.defineProperty(t, "__esModule", { value: !0 });
                            var n = r(37);
                            Object.defineProperty(t, "Announcement", {
                                enumerable: !0,
                                get: function () {
                                    return a(n).default;
                                },
                            }),
                                Object.defineProperty(t, "defaultAnnouncementOptions", {
                                    enumerable: !0,
                                    get: function () {
                                        return n.defaultOptions;
                                    },
                                });
                            var o = r(34);
                            Object.defineProperty(t, "Focusable", {
                                enumerable: !0,
                                get: function () {
                                    return a(o).default;
                                },
                            });
                            var i = r(32);
                            Object.defineProperty(t, "Mirror", {
                                enumerable: !0,
                                get: function () {
                                    return a(i).default;
                                },
                            }),
                                Object.defineProperty(t, "defaultMirrorOptions", {
                                    enumerable: !0,
                                    get: function () {
                                        return i.defaultOptions;
                                    },
                                });
                            var s = r(28);
                            function a(e) {
                                return e && e.__esModule ? e : { default: e };
                            }
                            Object.defineProperty(t, "Scrollable", {
                                enumerable: !0,
                                get: function () {
                                    return a(s).default;
                                },
                            }),
                                Object.defineProperty(t, "defaultScrollableOptions", {
                                    enumerable: !0,
                                    get: function () {
                                        return s.defaultOptions;
                                    },
                                });
                        },
                        function (e, t, r) {
                            Object.defineProperty(t, "__esModule", { value: !0 });
                            var n = r(38);
                            Object.keys(n).forEach(function (e) {
                                "default" !== e &&
                                    "__esModule" !== e &&
                                    Object.defineProperty(t, e, {
                                        enumerable: !0,
                                        get: function () {
                                            return n[e];
                                        },
                                    });
                            });
                        },
                        function (e, t, r) {
                            Object.defineProperty(t, "__esModule", { value: !0 });
                            var n = r(39);
                            Object.keys(n).forEach(function (e) {
                                "default" !== e &&
                                    "__esModule" !== e &&
                                    Object.defineProperty(t, e, {
                                        enumerable: !0,
                                        get: function () {
                                            return n[e];
                                        },
                                    });
                            });
                        },
                        function (e, t, r) {
                            Object.defineProperty(t, "__esModule", { value: !0 });
                            var n = r(43);
                            Object.keys(n).forEach(function (e) {
                                "default" !== e &&
                                    "__esModule" !== e &&
                                    Object.defineProperty(t, e, {
                                        enumerable: !0,
                                        get: function () {
                                            return n[e];
                                        },
                                    });
                            });
                        },
                        function (e, t, r) {
                            Object.defineProperty(t, "__esModule", { value: !0 }),
                                (t.default = class {
                                    constructor() {
                                        this.callbacks = {};
                                    }
                                    on(e, ...t) {
                                        return this.callbacks[e] || (this.callbacks[e] = []), this.callbacks[e].push(...t), this;
                                    }
                                    off(e, t) {
                                        if (!this.callbacks[e]) return null;
                                        const r = this.callbacks[e].slice(0);
                                        for (let n = 0; n < r.length; n++) t === r[n] && this.callbacks[e].splice(n, 1);
                                        return this;
                                    }
                                    trigger(e) {
                                        if (!this.callbacks[e.type]) return null;
                                        const t = [...this.callbacks[e.type]],
                                            r = [];
                                        for (let n = t.length - 1; n >= 0; n--) {
                                            const o = t[n];
                                            try {
                                                o(e);
                                            } catch (e) {
                                                r.push(e);
                                            }
                                        }
                                        return r.length && console.error(`Draggable caught errors while triggering '${e.type}'`, r), this;
                                    }
                                });
                        },
                        function (e, t, r) {
                            Object.defineProperty(t, "__esModule", { value: !0 });
                            var n,
                                o = r(10),
                                i = (n = o) && n.__esModule ? n : { default: n };
                            t.default = i.default;
                        },
                        function (e, t, r) {
                            Object.defineProperty(t, "__esModule", { value: !0 }), (t.defaultOptions = void 0);
                            var n,
                                o =
                                    Object.assign ||
                                    function (e) {
                                        for (var t = 1; t < arguments.length; t++) {
                                            var r = arguments[t];
                                            for (var n in r) Object.prototype.hasOwnProperty.call(r, n) && (e[n] = r[n]);
                                        }
                                        return e;
                                    },
                                i = r(2),
                                s = r(6),
                                a = r(11),
                                l = (n = a) && n.__esModule ? n : { default: n },
                                c = r(5),
                                u = r(7),
                                d = r(8);
                            const g = Symbol("onDragStart"),
                                h = Symbol("onDragMove"),
                                f = Symbol("onDragStop"),
                                v = Symbol("onDragPressure"),
                                m = {
                                    "drag:start": (e) => `Picked up ${e.source.textContent.trim() || e.source.id || "draggable element"}`,
                                    "drag:stop": (e) => `Released ${e.source.textContent.trim() || e.source.id || "draggable element"}`,
                                },
                                p = {
                                    "container:dragging": "draggable-container--is-dragging",
                                    "source:dragging": "draggable-source--is-dragging",
                                    "source:placed": "draggable-source--placed",
                                    "container:placed": "draggable-container--placed",
                                    "body:dragging": "draggable--is-dragging",
                                    "draggable:over": "draggable--over",
                                    "container:over": "draggable-container--over",
                                    "source:original": "draggable--original",
                                    mirror: "draggable-mirror",
                                },
                                b = (t.defaultOptions = { draggable: ".draggable-source", handle: null, delay: 100, placedTimeout: 800, plugins: [], sensors: [] });
                            class E {
                                constructor(e = [document.body], t = {}) {
                                    if (e instanceof NodeList || e instanceof Array) this.containers = [...e];
                                    else {
                                        if (!(e instanceof HTMLElement)) throw new Error("Draggable containers are expected to be of type `NodeList`, `HTMLElement[]` or `HTMLElement`");
                                        this.containers = [e];
                                    }
                                    (this.options = o({}, b, t, { classes: o({}, p, t.classes || {}), announcements: o({}, m, t.announcements || {}) })),
                                        (this.emitter = new l.default()),
                                        (this.dragging = !1),
                                        (this.plugins = []),
                                        (this.sensors = []),
                                        (this[g] = this[g].bind(this)),
                                        (this[h] = this[h].bind(this)),
                                        (this[f] = this[f].bind(this)),
                                        (this[v] = this[v].bind(this)),
                                        document.addEventListener("drag:start", this[g], !0),
                                        document.addEventListener("drag:move", this[h], !0),
                                        document.addEventListener("drag:stop", this[f], !0),
                                        document.addEventListener("drag:pressure", this[v], !0);
                                    const r = Object.values(E.Plugins).map((e) => e),
                                        n = [c.MouseSensor, c.TouchSensor];
                                    this.addPlugin(...r, ...this.options.plugins), this.addSensor(...n, ...this.options.sensors);
                                    const i = new u.DraggableInitializedEvent({ draggable: this });
                                    this.on("mirror:created", ({ mirror: e }) => (this.mirror = e)), this.on("mirror:destroy", () => (this.mirror = null)), this.trigger(i);
                                }
                                destroy() {
                                    document.removeEventListener("drag:start", this[g], !0),
                                        document.removeEventListener("drag:move", this[h], !0),
                                        document.removeEventListener("drag:stop", this[f], !0),
                                        document.removeEventListener("drag:pressure", this[v], !0);
                                    const e = new u.DraggableDestroyEvent({ draggable: this });
                                    this.trigger(e), this.removePlugin(...this.plugins.map((e) => e.constructor)), this.removeSensor(...this.sensors.map((e) => e.constructor));
                                }
                                addPlugin(...e) {
                                    const t = e.map((e) => new e(this));
                                    return t.forEach((e) => e.attach()), (this.plugins = [...this.plugins, ...t]), this;
                                }
                                removePlugin(...e) {
                                    return this.plugins.filter((t) => e.includes(t.constructor)).forEach((e) => e.detach()), (this.plugins = this.plugins.filter((t) => !e.includes(t.constructor))), this;
                                }
                                addSensor(...e) {
                                    const t = e.map((e) => new e(this.containers, this.options));
                                    return t.forEach((e) => e.attach()), (this.sensors = [...this.sensors, ...t]), this;
                                }
                                removeSensor(...e) {
                                    return this.sensors.filter((t) => e.includes(t.constructor)).forEach((e) => e.detach()), (this.sensors = this.sensors.filter((t) => !e.includes(t.constructor))), this;
                                }
                                addContainer(...e) {
                                    return (this.containers = [...this.containers, ...e]), this.sensors.forEach((t) => t.addContainer(...e)), this;
                                }
                                removeContainer(...e) {
                                    return (this.containers = this.containers.filter((t) => !e.includes(t))), this.sensors.forEach((t) => t.removeContainer(...e)), this;
                                }
                                on(e, ...t) {
                                    return this.emitter.on(e, ...t), this;
                                }
                                off(e, t) {
                                    return this.emitter.off(e, t), this;
                                }
                                trigger(e) {
                                    return this.emitter.trigger(e), this;
                                }
                                getClassNameFor(e) {
                                    return this.options.classes[e];
                                }
                                isDragging() {
                                    return Boolean(this.dragging);
                                }
                                getDraggableElements() {
                                    return this.containers.reduce((e, t) => [...e, ...this.getDraggableElementsForContainer(t)], []);
                                }
                                getDraggableElementsForContainer(e) {
                                    return [...e.querySelectorAll(this.options.draggable)].filter((e) => e !== this.originalSource && e !== this.mirror);
                                }
                                [g](e) {
                                    const t = y(e),
                                        { target: r, container: n } = t;
                                    if (!this.containers.includes(n)) return;
                                    if (this.options.handle && r && !(0, i.closest)(r, this.options.handle)) return void t.cancel();
                                    if (((this.originalSource = (0, i.closest)(r, this.options.draggable)), (this.sourceContainer = n), !this.originalSource)) return void t.cancel();
                                    this.lastPlacedSource &&
                                        this.lastPlacedContainer &&
                                        (clearTimeout(this.placedTimeoutID),
                                        this.lastPlacedSource.classList.remove(this.getClassNameFor("source:placed")),
                                        this.lastPlacedContainer.classList.remove(this.getClassNameFor("container:placed"))),
                                        (this.source = this.originalSource.cloneNode(!0)),
                                        this.originalSource.parentNode.insertBefore(this.source, this.originalSource),
                                        (this.originalSource.style.display = "none");
                                    const s = new d.DragStartEvent({ source: this.source, originalSource: this.originalSource, sourceContainer: n, sensorEvent: t });
                                    if ((this.trigger(s), (this.dragging = !s.canceled()), s.canceled())) return this.source.parentNode.removeChild(this.source), void (this.originalSource.style.display = null);
                                    this.originalSource.classList.add(this.getClassNameFor("source:original")),
                                        this.source.classList.add(this.getClassNameFor("source:dragging")),
                                        this.sourceContainer.classList.add(this.getClassNameFor("container:dragging")),
                                        document.body.classList.add(this.getClassNameFor("body:dragging")),
                                        S(document.body, "none"),
                                        requestAnimationFrame(() => {
                                            const t = y(e).clone({ target: this.source });
                                            this[h](o({}, e, { detail: t }));
                                        });
                                }
                                [h](e) {
                                    if (!this.dragging) return;
                                    const t = y(e),
                                        { container: r } = t;
                                    let n = t.target;
                                    const o = new d.DragMoveEvent({ source: this.source, originalSource: this.originalSource, sourceContainer: r, sensorEvent: t });
                                    this.trigger(o), o.canceled() && t.cancel(), (n = (0, i.closest)(n, this.options.draggable));
                                    const s = (0, i.closest)(t.target, this.containers),
                                        a = t.overContainer || s,
                                        l = this.currentOverContainer && a !== this.currentOverContainer,
                                        c = this.currentOver && n !== this.currentOver,
                                        u = a && this.currentOverContainer !== a,
                                        g = s && n && this.currentOver !== n;
                                    if (c) {
                                        const e = new d.DragOutEvent({ source: this.source, originalSource: this.originalSource, sourceContainer: r, sensorEvent: t, over: this.currentOver });
                                        this.currentOver.classList.remove(this.getClassNameFor("draggable:over")), (this.currentOver = null), this.trigger(e);
                                    }
                                    if (l) {
                                        const e = new d.DragOutContainerEvent({ source: this.source, originalSource: this.originalSource, sourceContainer: r, sensorEvent: t, overContainer: this.currentOverContainer });
                                        this.currentOverContainer.classList.remove(this.getClassNameFor("container:over")), (this.currentOverContainer = null), this.trigger(e);
                                    }
                                    if (u) {
                                        a.classList.add(this.getClassNameFor("container:over"));
                                        const e = new d.DragOverContainerEvent({ source: this.source, originalSource: this.originalSource, sourceContainer: r, sensorEvent: t, overContainer: a });
                                        (this.currentOverContainer = a), this.trigger(e);
                                    }
                                    if (g) {
                                        n.classList.add(this.getClassNameFor("draggable:over"));
                                        const e = new d.DragOverEvent({ source: this.source, originalSource: this.originalSource, sourceContainer: r, sensorEvent: t, overContainer: a, over: n });
                                        (this.currentOver = n), this.trigger(e);
                                    }
                                }
                                [f](e) {
                                    if (!this.dragging) return;
                                    this.dragging = !1;
                                    const t = new d.DragStopEvent({ source: this.source, originalSource: this.originalSource, sensorEvent: e.sensorEvent, sourceContainer: this.sourceContainer });
                                    this.trigger(t),
                                        this.source.parentNode.insertBefore(this.originalSource, this.source),
                                        this.source.parentNode.removeChild(this.source),
                                        (this.originalSource.style.display = ""),
                                        this.source.classList.remove(this.getClassNameFor("source:dragging")),
                                        this.originalSource.classList.remove(this.getClassNameFor("source:original")),
                                        this.originalSource.classList.add(this.getClassNameFor("source:placed")),
                                        this.sourceContainer.classList.add(this.getClassNameFor("container:placed")),
                                        this.sourceContainer.classList.remove(this.getClassNameFor("container:dragging")),
                                        document.body.classList.remove(this.getClassNameFor("body:dragging")),
                                        S(document.body, ""),
                                        this.currentOver && this.currentOver.classList.remove(this.getClassNameFor("draggable:over")),
                                        this.currentOverContainer && this.currentOverContainer.classList.remove(this.getClassNameFor("container:over")),
                                        (this.lastPlacedSource = this.originalSource),
                                        (this.lastPlacedContainer = this.sourceContainer),
                                        (this.placedTimeoutID = setTimeout(() => {
                                            this.lastPlacedSource && this.lastPlacedSource.classList.remove(this.getClassNameFor("source:placed")),
                                                this.lastPlacedContainer && this.lastPlacedContainer.classList.remove(this.getClassNameFor("container:placed")),
                                                (this.lastPlacedSource = null),
                                                (this.lastPlacedContainer = null);
                                        }, this.options.placedTimeout)),
                                        (this.source = null),
                                        (this.originalSource = null),
                                        (this.currentOverContainer = null),
                                        (this.currentOver = null),
                                        (this.sourceContainer = null);
                                }
                                [v](e) {
                                    if (!this.dragging) return;
                                    const t = y(e),
                                        r = this.source || (0, i.closest)(t.originalEvent.target, this.options.draggable),
                                        n = new d.DragPressureEvent({ sensorEvent: t, source: r, pressure: t.pressure });
                                    this.trigger(n);
                                }
                            }
                            function y(e) {
                                return e.detail;
                            }
                            function S(e, t) {
                                (e.style.webkitUserSelect = t), (e.style.mozUserSelect = t), (e.style.msUserSelect = t), (e.style.oUserSelect = t), (e.style.userSelect = t);
                            }
                            (t.default = E), (E.Plugins = { Announcement: s.Announcement, Focusable: s.Focusable, Mirror: s.Mirror, Scrollable: s.Scrollable });
                        },
                        function (e, t, r) {
                            Object.defineProperty(t, "__esModule", { value: !0 });
                            var n,
                                o = r(1),
                                i = (n = o) && n.__esModule ? n : { default: n },
                                s = r(0);
                            const a = Symbol("onMouseForceWillBegin"),
                                l = Symbol("onMouseForceDown"),
                                c = Symbol("onMouseDown"),
                                u = Symbol("onMouseForceChange"),
                                d = Symbol("onMouseMove"),
                                g = Symbol("onMouseUp"),
                                h = Symbol("onMouseForceGlobalChange");
                            class f extends i.default {
                                constructor(e = [], t = {}) {
                                    super(e, t),
                                        (this.mightDrag = !1),
                                        (this[a] = this[a].bind(this)),
                                        (this[l] = this[l].bind(this)),
                                        (this[c] = this[c].bind(this)),
                                        (this[u] = this[u].bind(this)),
                                        (this[d] = this[d].bind(this)),
                                        (this[g] = this[g].bind(this));
                                }
                                attach() {
                                    for (const e of this.containers)
                                        e.addEventListener("webkitmouseforcewillbegin", this[a], !1),
                                            e.addEventListener("webkitmouseforcedown", this[l], !1),
                                            e.addEventListener("mousedown", this[c], !0),
                                            e.addEventListener("webkitmouseforcechanged", this[u], !1);
                                    document.addEventListener("mousemove", this[d]), document.addEventListener("mouseup", this[g]);
                                }
                                detach() {
                                    for (const e of this.containers)
                                        e.removeEventListener("webkitmouseforcewillbegin", this[a], !1),
                                            e.removeEventListener("webkitmouseforcedown", this[l], !1),
                                            e.removeEventListener("mousedown", this[c], !0),
                                            e.removeEventListener("webkitmouseforcechanged", this[u], !1);
                                    document.removeEventListener("mousemove", this[d]), document.removeEventListener("mouseup", this[g]);
                                }
                                [a](e) {
                                    e.preventDefault(), (this.mightDrag = !0);
                                }
                                [l](e) {
                                    if (this.dragging) return;
                                    const t = document.elementFromPoint(e.clientX, e.clientY),
                                        r = e.currentTarget,
                                        n = new s.DragStartSensorEvent({ clientX: e.clientX, clientY: e.clientY, target: t, container: r, originalEvent: e });
                                    this.trigger(r, n), (this.currentContainer = r), (this.dragging = !n.canceled()), (this.mightDrag = !1);
                                }
                                [g](e) {
                                    if (!this.dragging) return;
                                    const t = new s.DragStopSensorEvent({ clientX: e.clientX, clientY: e.clientY, target: null, container: this.currentContainer, originalEvent: e });
                                    this.trigger(this.currentContainer, t), (this.currentContainer = null), (this.dragging = !1), (this.mightDrag = !1);
                                }
                                [c](e) {
                                    this.mightDrag && (e.stopPropagation(), e.stopImmediatePropagation(), e.preventDefault());
                                }
                                [d](e) {
                                    if (!this.dragging) return;
                                    const t = document.elementFromPoint(e.clientX, e.clientY),
                                        r = new s.DragMoveSensorEvent({ clientX: e.clientX, clientY: e.clientY, target: t, container: this.currentContainer, originalEvent: e });
                                    this.trigger(this.currentContainer, r);
                                }
                                [u](e) {
                                    if (this.dragging) return;
                                    const t = e.target,
                                        r = e.currentTarget,
                                        n = new s.DragPressureSensorEvent({ pressure: e.webkitForce, clientX: e.clientX, clientY: e.clientY, target: t, container: r, originalEvent: e });
                                    this.trigger(r, n);
                                }
                                [h](e) {
                                    if (!this.dragging) return;
                                    const t = e.target,
                                        r = new s.DragPressureSensorEvent({ pressure: e.webkitForce, clientX: e.clientX, clientY: e.clientY, target: t, container: this.currentContainer, originalEvent: e });
                                    this.trigger(this.currentContainer, r);
                                }
                            }
                            t.default = f;
                        },
                        function (e, t, r) {
                            Object.defineProperty(t, "__esModule", { value: !0 });
                            var n,
                                o = r(13),
                                i = (n = o) && n.__esModule ? n : { default: n };
                            t.default = i.default;
                        },
                        function (e, t, r) {
                            Object.defineProperty(t, "__esModule", { value: !0 });
                            var n,
                                o = r(2),
                                i = r(1),
                                s = (n = i) && n.__esModule ? n : { default: n },
                                a = r(0);
                            const l = Symbol("onMouseDown"),
                                c = Symbol("onMouseUp"),
                                u = Symbol("onDragStart"),
                                d = Symbol("onDragOver"),
                                g = Symbol("onDragEnd"),
                                h = Symbol("onDrop"),
                                f = Symbol("reset");
                            class v extends s.default {
                                constructor(e = [], t = {}) {
                                    super(e, t),
                                        (this.mouseDownTimeout = null),
                                        (this.draggableElement = null),
                                        (this.nativeDraggableElement = null),
                                        (this[l] = this[l].bind(this)),
                                        (this[c] = this[c].bind(this)),
                                        (this[u] = this[u].bind(this)),
                                        (this[d] = this[d].bind(this)),
                                        (this[g] = this[g].bind(this)),
                                        (this[h] = this[h].bind(this));
                                }
                                attach() {
                                    document.addEventListener("mousedown", this[l], !0);
                                }
                                detach() {
                                    document.removeEventListener("mousedown", this[l], !0);
                                }
                                [u](e) {
                                    e.dataTransfer.setData("text", ""), (e.dataTransfer.effectAllowed = this.options.type);
                                    const t = document.elementFromPoint(e.clientX, e.clientY);
                                    if (((this.currentContainer = (0, o.closest)(e.target, this.containers)), !this.currentContainer)) return;
                                    const r = new a.DragStartSensorEvent({ clientX: e.clientX, clientY: e.clientY, target: t, container: this.currentContainer, originalEvent: e });
                                    setTimeout(() => {
                                        this.trigger(this.currentContainer, r), r.canceled() ? (this.dragging = !1) : (this.dragging = !0);
                                    }, 0);
                                }
                                [d](e) {
                                    if (!this.dragging) return;
                                    const t = document.elementFromPoint(e.clientX, e.clientY),
                                        r = this.currentContainer,
                                        n = new a.DragMoveSensorEvent({ clientX: e.clientX, clientY: e.clientY, target: t, container: r, originalEvent: e });
                                    this.trigger(r, n), n.canceled() || (e.preventDefault(), (e.dataTransfer.dropEffect = this.options.type));
                                }
                                [g](e) {
                                    if (!this.dragging) return;
                                    document.removeEventListener("mouseup", this[c], !0);
                                    const t = document.elementFromPoint(e.clientX, e.clientY),
                                        r = this.currentContainer,
                                        n = new a.DragStopSensorEvent({ clientX: e.clientX, clientY: e.clientY, target: t, container: r, originalEvent: e });
                                    this.trigger(r, n), (this.dragging = !1), this[f]();
                                }
                                [h](e) {
                                    e.preventDefault();
                                }
                                [l](e) {
                                    if (e.target && (e.target.form || e.target.contenteditable)) return;
                                    const t = (0, o.closest)(e.target, (e) => e.draggable);
                                    t && ((t.draggable = !1), (this.nativeDraggableElement = t)),
                                        document.addEventListener("mouseup", this[c], !0),
                                        document.addEventListener("dragstart", this[u], !1),
                                        document.addEventListener("dragover", this[d], !1),
                                        document.addEventListener("dragend", this[g], !1),
                                        document.addEventListener("drop", this[h], !1);
                                    const r = (0, o.closest)(e.target, this.options.draggable);
                                    r &&
                                        (this.mouseDownTimeout = setTimeout(() => {
                                            (r.draggable = !0), (this.draggableElement = r);
                                        }, this.options.delay));
                                }
                                [c]() {
                                    this[f]();
                                }
                                [f]() {
                                    clearTimeout(this.mouseDownTimeout),
                                        document.removeEventListener("mouseup", this[c], !0),
                                        document.removeEventListener("dragstart", this[u], !1),
                                        document.removeEventListener("dragover", this[d], !1),
                                        document.removeEventListener("dragend", this[g], !1),
                                        document.removeEventListener("drop", this[h], !1),
                                        this.nativeDraggableElement && ((this.nativeDraggableElement.draggable = !0), (this.nativeDraggableElement = null)),
                                        this.draggableElement && ((this.draggableElement.draggable = !1), (this.draggableElement = null));
                                }
                            }
                            t.default = v;
                        },
                        function (e, t, r) {
                            Object.defineProperty(t, "__esModule", { value: !0 });
                            var n,
                                o = r(15),
                                i = (n = o) && n.__esModule ? n : { default: n };
                            t.default = i.default;
                        },
                        function (e, t, r) {
                            Object.defineProperty(t, "__esModule", { value: !0 });
                            var n,
                                o = r(2),
                                i = r(1),
                                s = (n = i) && n.__esModule ? n : { default: n },
                                a = r(0);
                            const l = Symbol("onTouchStart"),
                                c = Symbol("onTouchHold"),
                                u = Symbol("onTouchEnd"),
                                d = Symbol("onTouchMove");
                            let g = !1;
                            window.addEventListener(
                                "touchmove",
                                (e) => {
                                    g && e.preventDefault();
                                },
                                { passive: !1 }
                            );
                            class h extends s.default {
                                constructor(e = [], t = {}) {
                                    super(e, t),
                                        (this.currentScrollableParent = null),
                                        (this.tapTimeout = null),
                                        (this.touchMoved = !1),
                                        (this[l] = this[l].bind(this)),
                                        (this[c] = this[c].bind(this)),
                                        (this[u] = this[u].bind(this)),
                                        (this[d] = this[d].bind(this));
                                }
                                attach() {
                                    document.addEventListener("touchstart", this[l]);
                                }
                                detach() {
                                    document.removeEventListener("touchstart", this[l]);
                                }
                                [l](e) {
                                    const t = (0, o.closest)(e.target, this.containers);
                                    t &&
                                        (document.addEventListener("touchmove", this[d]),
                                        document.addEventListener("touchend", this[u]),
                                        document.addEventListener("touchcancel", this[u]),
                                        t.addEventListener("contextmenu", f),
                                        (this.currentContainer = t),
                                        (this.tapTimeout = setTimeout(this[c](e, t), this.options.delay)));
                                }
                                [c](e, t) {
                                    return () => {
                                        if (this.touchMoved) return;
                                        const r = e.touches[0] || e.changedTouches[0],
                                            n = e.target,
                                            o = new a.DragStartSensorEvent({ clientX: r.pageX, clientY: r.pageY, target: n, container: t, originalEvent: e });
                                        this.trigger(t, o), (this.dragging = !o.canceled()), (g = this.dragging);
                                    };
                                }
                                [d](e) {
                                    if (((this.touchMoved = !0), !this.dragging)) return;
                                    const t = e.touches[0] || e.changedTouches[0],
                                        r = document.elementFromPoint(t.pageX - window.scrollX, t.pageY - window.scrollY),
                                        n = new a.DragMoveSensorEvent({ clientX: t.pageX, clientY: t.pageY, target: r, container: this.currentContainer, originalEvent: e });
                                    this.trigger(this.currentContainer, n);
                                }
                                [u](e) {
                                    if (
                                        ((this.touchMoved = !1),
                                        (g = !1),
                                        document.removeEventListener("touchend", this[u]),
                                        document.removeEventListener("touchcancel", this[u]),
                                        document.removeEventListener("touchmove", this[d]),
                                        this.currentContainer && this.currentContainer.removeEventListener("contextmenu", f),
                                        clearTimeout(this.tapTimeout),
                                        !this.dragging)
                                    )
                                        return;
                                    const t = e.touches[0] || e.changedTouches[0],
                                        r = document.elementFromPoint(t.pageX - window.scrollX, t.pageY - window.scrollY);
                                    e.preventDefault();
                                    const n = new a.DragStopSensorEvent({ clientX: t.pageX, clientY: t.pageY, target: r, container: this.currentContainer, originalEvent: e });
                                    this.trigger(this.currentContainer, n), (this.currentContainer = null), (this.dragging = !1);
                                }
                            }
                            function f(e) {
                                e.preventDefault(), e.stopPropagation();
                            }
                            t.default = h;
                        },
                        function (e, t, r) {
                            Object.defineProperty(t, "__esModule", { value: !0 });
                            var n,
                                o = r(17),
                                i = (n = o) && n.__esModule ? n : { default: n };
                            t.default = i.default;
                        },
                        function (e, t, r) {
                            Object.defineProperty(t, "__esModule", { value: !0 }), (t.DragPressureSensorEvent = t.DragStopSensorEvent = t.DragMoveSensorEvent = t.DragStartSensorEvent = t.SensorEvent = void 0);
                            var n,
                                o = r(3),
                                i = (n = o) && n.__esModule ? n : { default: n };
                            class s extends i.default {
                                get originalEvent() {
                                    return this.data.originalEvent;
                                }
                                get clientX() {
                                    return this.data.clientX;
                                }
                                get clientY() {
                                    return this.data.clientY;
                                }
                                get target() {
                                    return this.data.target;
                                }
                                get container() {
                                    return this.data.container;
                                }
                                get pressure() {
                                    return this.data.pressure;
                                }
                            }
                            t.SensorEvent = s;
                            class a extends s {}
                            (t.DragStartSensorEvent = a), (a.type = "drag:start");
                            class l extends s {}
                            (t.DragMoveSensorEvent = l), (l.type = "drag:move");
                            class c extends s {}
                            (t.DragStopSensorEvent = c), (c.type = "drag:stop");
                            class u extends s {}
                            (t.DragPressureSensorEvent = u), (u.type = "drag:pressure");
                        },
                        function (e, t, r) {
                            Object.defineProperty(t, "__esModule", { value: !0 });
                            var n,
                                o = r(2),
                                i = r(1),
                                s = (n = i) && n.__esModule ? n : { default: n },
                                a = r(0);
                            const l = Symbol("onContextMenuWhileDragging"),
                                c = Symbol("onMouseDown"),
                                u = Symbol("onMouseMove"),
                                d = Symbol("onMouseUp");
                            class g extends s.default {
                                constructor(e = [], t = {}) {
                                    super(e, t),
                                        (this.mouseDown = !1),
                                        (this.mouseDownTimeout = null),
                                        (this.openedContextMenu = !1),
                                        (this[l] = this[l].bind(this)),
                                        (this[c] = this[c].bind(this)),
                                        (this[u] = this[u].bind(this)),
                                        (this[d] = this[d].bind(this));
                                }
                                attach() {
                                    document.addEventListener("mousedown", this[c], !0);
                                }
                                detach() {
                                    document.removeEventListener("mousedown", this[c], !0);
                                }
                                [c](e) {
                                    if (0 !== e.button || e.ctrlKey || e.metaKey) return;
                                    document.addEventListener("mouseup", this[d]);
                                    const t = document.elementFromPoint(e.clientX, e.clientY),
                                        r = (0, o.closest)(t, this.containers);
                                    r &&
                                        (document.addEventListener("dragstart", h),
                                        (this.mouseDown = !0),
                                        clearTimeout(this.mouseDownTimeout),
                                        (this.mouseDownTimeout = setTimeout(() => {
                                            if (!this.mouseDown) return;
                                            const n = new a.DragStartSensorEvent({ clientX: e.clientX, clientY: e.clientY, target: t, container: r, originalEvent: e });
                                            this.trigger(r, n),
                                                (this.currentContainer = r),
                                                (this.dragging = !n.canceled()),
                                                this.dragging && (document.addEventListener("contextmenu", this[l]), document.addEventListener("mousemove", this[u]));
                                        }, this.options.delay)));
                                }
                                [u](e) {
                                    if (!this.dragging) return;
                                    const t = document.elementFromPoint(e.clientX, e.clientY),
                                        r = new a.DragMoveSensorEvent({ clientX: e.clientX, clientY: e.clientY, target: t, container: this.currentContainer, originalEvent: e });
                                    this.trigger(this.currentContainer, r);
                                }
                                [d](e) {
                                    if (((this.mouseDown = Boolean(this.openedContextMenu)), this.openedContextMenu)) return void (this.openedContextMenu = !1);
                                    if ((document.removeEventListener("mouseup", this[d]), document.removeEventListener("dragstart", h), !this.dragging)) return;
                                    const t = document.elementFromPoint(e.clientX, e.clientY),
                                        r = new a.DragStopSensorEvent({ clientX: e.clientX, clientY: e.clientY, target: t, container: this.currentContainer, originalEvent: e });
                                    this.trigger(this.currentContainer, r), document.removeEventListener("contextmenu", this[l]), document.removeEventListener("mousemove", this[u]), (this.currentContainer = null), (this.dragging = !1);
                                }
                                [l](e) {
                                    e.preventDefault(), (this.openedContextMenu = !0);
                                }
                            }
                            function h(e) {
                                e.preventDefault();
                            }
                            t.default = g;
                        },
                        function (e, t, r) {
                            Object.defineProperty(t, "__esModule", { value: !0 });
                            var n,
                                o = r(20),
                                i = (n = o) && n.__esModule ? n : { default: n };
                            t.default = i.default;
                        },
                        function (e, t, r) {
                            Object.defineProperty(t, "__esModule", { value: !0 });
                            var n =
                                Object.assign ||
                                function (e) {
                                    for (var t = 1; t < arguments.length; t++) {
                                        var r = arguments[t];
                                        for (var n in r) Object.prototype.hasOwnProperty.call(r, n) && (e[n] = r[n]);
                                    }
                                    return e;
                                };
                            t.default = class {
                                constructor(e = [], t = {}) {
                                    (this.containers = [...e]), (this.options = n({}, t)), (this.dragging = !1), (this.currentContainer = null);
                                }
                                attach() {
                                    return this;
                                }
                                detach() {
                                    return this;
                                }
                                addContainer(...e) {
                                    this.containers = [...this.containers, ...e];
                                }
                                removeContainer(...e) {
                                    this.containers = this.containers.filter((t) => !e.includes(t));
                                }
                                trigger(e, t) {
                                    const r = document.createEvent("Event");
                                    return (r.detail = t), r.initEvent(t.type, !0, !0), e.dispatchEvent(r), (this.lastEvent = t), t;
                                }
                            };
                        },
                        function (e, t, r) {
                            Object.defineProperty(t, "__esModule", { value: !0 }),
                                (t.default = function (e) {
                                    return requestAnimationFrame(() => {
                                        requestAnimationFrame(e);
                                    });
                                });
                        },
                        function (e, t, r) {
                            Object.defineProperty(t, "__esModule", { value: !0 });
                            var n,
                                o = r(23),
                                i = (n = o) && n.__esModule ? n : { default: n };
                            t.default = i.default;
                        },
                        function (e, t, r) {
                            Object.defineProperty(t, "__esModule", { value: !0 }),
                                (t.default = function (e, t) {
                                    if (!e) return null;
                                    const r = t,
                                        o = t,
                                        i = t,
                                        s = t,
                                        a = Boolean("string" == typeof t),
                                        l = Boolean("function" == typeof t),
                                        c = Boolean(t instanceof NodeList || t instanceof Array),
                                        u = Boolean(t instanceof HTMLElement);
                                    let d = e;
                                    do {
                                        if (((d = d.correspondingUseElement || d.correspondingElement || d), (g = d) ? (a ? n.call(g, r) : c ? [...i].includes(g) : u ? s === g : l && o(g)) : g)) return d;
                                        d = d.parentNode;
                                    } while (d && d !== document.body && d !== document);
                                    var g;
                                    return null;
                                });
                            const n = Element.prototype.matches || Element.prototype.webkitMatchesSelector || Element.prototype.mozMatchesSelector || Element.prototype.msMatchesSelector;
                        },
                        function (e, t, r) {
                            Object.defineProperty(t, "__esModule", { value: !0 });
                            var n,
                                o = r(25),
                                i = (n = o) && n.__esModule ? n : { default: n };
                            t.default = i.default;
                        },
                        function (e, t, r) {
                            Object.defineProperty(t, "__esModule", { value: !0 }), (t.defaultOptions = t.scroll = t.onDragStop = t.onDragMove = t.onDragStart = void 0);
                            var n,
                                o =
                                    Object.assign ||
                                    function (e) {
                                        for (var t = 1; t < arguments.length; t++) {
                                            var r = arguments[t];
                                            for (var n in r) Object.prototype.hasOwnProperty.call(r, n) && (e[n] = r[n]);
                                        }
                                        return e;
                                    },
                                i = r(4),
                                s = (n = i) && n.__esModule ? n : { default: n },
                                a = r(2);
                            const l = (t.onDragStart = Symbol("onDragStart")),
                                c = (t.onDragMove = Symbol("onDragMove")),
                                u = (t.onDragStop = Symbol("onDragStop")),
                                d = (t.scroll = Symbol("scroll")),
                                g = (t.defaultOptions = { speed: 6, sensitivity: 50, scrollableElements: [] });
                            class h extends s.default {
                                constructor(e) {
                                    super(e),
                                        (this.options = o({}, g, this.getOptions())),
                                        (this.currentMousePosition = null),
                                        (this.scrollAnimationFrame = null),
                                        (this.scrollableElement = null),
                                        (this.findScrollableElementFrame = null),
                                        (this[l] = this[l].bind(this)),
                                        (this[c] = this[c].bind(this)),
                                        (this[u] = this[u].bind(this)),
                                        (this[d] = this[d].bind(this));
                                }
                                attach() {
                                    this.draggable.on("drag:start", this[l]).on("drag:move", this[c]).on("drag:stop", this[u]);
                                }
                                detach() {
                                    this.draggable.off("drag:start", this[l]).off("drag:move", this[c]).off("drag:stop", this[u]);
                                }
                                getOptions() {
                                    return this.draggable.options.scrollable || {};
                                }
                                getScrollableElement(e) {
                                    return this.hasDefinedScrollableElements()
                                        ? (0, a.closest)(e, this.options.scrollableElements) || document.documentElement
                                        : (function (e) {
                                              if (!e) return f();
                                              const t = getComputedStyle(e).getPropertyValue("position"),
                                                  r = "absolute" === t,
                                                  n = (0, a.closest)(
                                                      e,
                                                      (e) =>
                                                          (!r ||
                                                              !(function (e) {
                                                                  return "static" === getComputedStyle(e).getPropertyValue("position");
                                                              })(e)) &&
                                                          (function (e) {
                                                              const t = getComputedStyle(e, null),
                                                                  r = t.getPropertyValue("overflow") + t.getPropertyValue("overflow-y") + t.getPropertyValue("overflow-x");
                                                              return /(auto|scroll)/.test(r);
                                                          })(e)
                                                  );
                                              return "fixed" !== t && n ? n : f();
                                          })(e);
                                }
                                hasDefinedScrollableElements() {
                                    return Boolean(0 !== this.options.scrollableElements.length);
                                }
                                [l](e) {
                                    this.findScrollableElementFrame = requestAnimationFrame(() => {
                                        this.scrollableElement = this.getScrollableElement(e.source);
                                    });
                                }
                                [c](e) {
                                    if (
                                        ((this.findScrollableElementFrame = requestAnimationFrame(() => {
                                            this.scrollableElement = this.getScrollableElement(e.sensorEvent.target);
                                        })),
                                        !this.scrollableElement)
                                    )
                                        return;
                                    const t = e.sensorEvent,
                                        r = { x: 0, y: 0 };
                                    "ontouchstart" in window &&
                                        ((r.y = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0), (r.x = window.pageXOffset || document.documentElement.scrollLeft || document.body.scrollLeft || 0)),
                                        (this.currentMousePosition = { clientX: t.clientX - r.x, clientY: t.clientY - r.y }),
                                        (this.scrollAnimationFrame = requestAnimationFrame(this[d]));
                                }
                                [u]() {
                                    cancelAnimationFrame(this.scrollAnimationFrame),
                                        cancelAnimationFrame(this.findScrollableElementFrame),
                                        (this.scrollableElement = null),
                                        (this.scrollAnimationFrame = null),
                                        (this.findScrollableElementFrame = null),
                                        (this.currentMousePosition = null);
                                }
                                [d]() {
                                    if (!this.scrollableElement || !this.currentMousePosition) return;
                                    cancelAnimationFrame(this.scrollAnimationFrame);
                                    const { speed: e, sensitivity: t } = this.options,
                                        r = this.scrollableElement.getBoundingClientRect(),
                                        n = r.bottom > window.innerHeight,
                                        o = r.top < 0 || n,
                                        i = f(),
                                        s = this.scrollableElement,
                                        a = this.currentMousePosition.clientX,
                                        l = this.currentMousePosition.clientY;
                                    if (s === document.body || s === document.documentElement || o) {
                                        const { innerHeight: r, innerWidth: n } = window;
                                        l < t ? (i.scrollTop -= e) : r - l < t && (i.scrollTop += e), a < t ? (i.scrollLeft -= e) : n - a < t && (i.scrollLeft += e);
                                    } else {
                                        const { offsetHeight: n, offsetWidth: o } = s;
                                        r.top + n - l < t ? (s.scrollTop += e) : l - r.top < t && (s.scrollTop -= e), r.left + o - a < t ? (s.scrollLeft += e) : a - r.left < t && (s.scrollLeft -= e);
                                    }
                                    this.scrollAnimationFrame = requestAnimationFrame(this[d]);
                                }
                            }
                            function f() {
                                return document.scrollingElement || document.documentElement;
                            }
                            t.default = h;
                        },
                        function (e, t, r) {
                            Object.defineProperty(t, "__esModule", { value: !0 }), (t.defaultOptions = void 0);
                            var n,
                                o = r(27),
                                i = (n = o) && n.__esModule ? n : { default: n };
                            (t.default = i.default), (t.defaultOptions = o.defaultOptions);
                        },
                        function (e, t, r) {
                            Object.defineProperty(t, "__esModule", { value: !0 }), (t.MirrorDestroyEvent = t.MirrorMoveEvent = t.MirrorAttachedEvent = t.MirrorCreatedEvent = t.MirrorCreateEvent = t.MirrorEvent = void 0);
                            var n,
                                o = r(3),
                                i = (n = o) && n.__esModule ? n : { default: n };
                            class s extends i.default {
                                get source() {
                                    return this.data.source;
                                }
                                get originalSource() {
                                    return this.data.originalSource;
                                }
                                get sourceContainer() {
                                    return this.data.sourceContainer;
                                }
                                get sensorEvent() {
                                    return this.data.sensorEvent;
                                }
                                get dragEvent() {
                                    return this.data.dragEvent;
                                }
                                get originalEvent() {
                                    return this.sensorEvent ? this.sensorEvent.originalEvent : null;
                                }
                            }
                            t.MirrorEvent = s;
                            class a extends s {}
                            (t.MirrorCreateEvent = a), (a.type = "mirror:create");
                            class l extends s {
                                get mirror() {
                                    return this.data.mirror;
                                }
                            }
                            (t.MirrorCreatedEvent = l), (l.type = "mirror:created");
                            class c extends s {
                                get mirror() {
                                    return this.data.mirror;
                                }
                            }
                            (t.MirrorAttachedEvent = c), (c.type = "mirror:attached");
                            class u extends s {
                                get mirror() {
                                    return this.data.mirror;
                                }
                            }
                            (t.MirrorMoveEvent = u), (u.type = "mirror:move"), (u.cancelable = !0);
                            class d extends s {
                                get mirror() {
                                    return this.data.mirror;
                                }
                            }
                            (t.MirrorDestroyEvent = d), (d.type = "mirror:destroy"), (d.cancelable = !0);
                        },
                        function (e, t, r) {
                            Object.defineProperty(t, "__esModule", { value: !0 });
                            var n = r(29);
                            Object.keys(n).forEach(function (e) {
                                "default" !== e &&
                                    "__esModule" !== e &&
                                    Object.defineProperty(t, e, {
                                        enumerable: !0,
                                        get: function () {
                                            return n[e];
                                        },
                                    });
                            });
                        },
                        function (e, t, r) {
                            Object.defineProperty(t, "__esModule", { value: !0 }), (t.defaultOptions = t.getAppendableContainer = t.onScroll = t.onMirrorMove = t.onMirrorCreated = t.onDragStop = t.onDragMove = t.onDragStart = void 0);
                            var n,
                                o =
                                    Object.assign ||
                                    function (e) {
                                        for (var t = 1; t < arguments.length; t++) {
                                            var r = arguments[t];
                                            for (var n in r) Object.prototype.hasOwnProperty.call(r, n) && (e[n] = r[n]);
                                        }
                                        return e;
                                    },
                                i = r(4),
                                s = (n = i) && n.__esModule ? n : { default: n },
                                a = r(30);
                            function l(e, t) {
                                var r = {};
                                for (var n in e) t.indexOf(n) >= 0 || (Object.prototype.hasOwnProperty.call(e, n) && (r[n] = e[n]));
                                return r;
                            }
                            const c = (t.onDragStart = Symbol("onDragStart")),
                                u = (t.onDragMove = Symbol("onDragMove")),
                                d = (t.onDragStop = Symbol("onDragStop")),
                                g = (t.onMirrorCreated = Symbol("onMirrorCreated")),
                                h = (t.onMirrorMove = Symbol("onMirrorMove")),
                                f = (t.onScroll = Symbol("onScroll")),
                                v = (t.getAppendableContainer = Symbol("getAppendableContainer")),
                                m = (t.defaultOptions = { constrainDimensions: !1, xAxis: !0, yAxis: !0, cursorOffsetX: null, cursorOffsetY: null });
                            class p extends s.default {
                                constructor(e) {
                                    super(e),
                                        (this.options = o({}, m, this.getOptions())),
                                        (this.scrollOffset = { x: 0, y: 0 }),
                                        (this.initialScrollOffset = { x: window.scrollX, y: window.scrollY }),
                                        (this[c] = this[c].bind(this)),
                                        (this[u] = this[u].bind(this)),
                                        (this[d] = this[d].bind(this)),
                                        (this[g] = this[g].bind(this)),
                                        (this[h] = this[h].bind(this)),
                                        (this[f] = this[f].bind(this));
                                }
                                attach() {
                                    this.draggable.on("drag:start", this[c]).on("drag:move", this[u]).on("drag:stop", this[d]).on("mirror:created", this[g]).on("mirror:move", this[h]);
                                }
                                detach() {
                                    this.draggable.off("drag:start", this[c]).off("drag:move", this[u]).off("drag:stop", this[d]).off("mirror:created", this[g]).off("mirror:move", this[h]);
                                }
                                getOptions() {
                                    return this.draggable.options.mirror || {};
                                }
                                [c](e) {
                                    if (e.canceled()) return;
                                    "ontouchstart" in window && document.addEventListener("scroll", this[f], !0), (this.initialScrollOffset = { x: window.scrollX, y: window.scrollY });
                                    const { source: t, originalSource: r, sourceContainer: n, sensorEvent: o } = e,
                                        i = new a.MirrorCreateEvent({ source: t, originalSource: r, sourceContainer: n, sensorEvent: o, dragEvent: e });
                                    if (
                                        (this.draggable.trigger(i),
                                        (function (e) {
                                            return /^drag/.test(e.originalEvent.type);
                                        })(o) || i.canceled())
                                    )
                                        return;
                                    const s = this[v](t) || n;
                                    this.mirror = t.cloneNode(!0);
                                    const l = new a.MirrorCreatedEvent({ source: t, originalSource: r, sourceContainer: n, sensorEvent: o, dragEvent: e, mirror: this.mirror }),
                                        c = new a.MirrorAttachedEvent({ source: t, originalSource: r, sourceContainer: n, sensorEvent: o, dragEvent: e, mirror: this.mirror });
                                    this.draggable.trigger(l), s.appendChild(this.mirror), this.draggable.trigger(c);
                                }
                                [u](e) {
                                    if (!this.mirror || e.canceled()) return;
                                    const { source: t, originalSource: r, sourceContainer: n, sensorEvent: o } = e,
                                        i = new a.MirrorMoveEvent({ source: t, originalSource: r, sourceContainer: n, sensorEvent: o, dragEvent: e, mirror: this.mirror });
                                    this.draggable.trigger(i);
                                }
                                [d](e) {
                                    if (("ontouchstart" in window && document.removeEventListener("scroll", this[f], !0), (this.initialScrollOffset = { x: 0, y: 0 }), (this.scrollOffset = { x: 0, y: 0 }), !this.mirror)) return;
                                    const { source: t, sourceContainer: r, sensorEvent: n } = e,
                                        o = new a.MirrorDestroyEvent({ source: t, mirror: this.mirror, sourceContainer: r, sensorEvent: n, dragEvent: e });
                                    this.draggable.trigger(o), o.canceled() || this.mirror.parentNode.removeChild(this.mirror);
                                }
                                [f]() {
                                    this.scrollOffset = { x: window.scrollX - this.initialScrollOffset.x, y: window.scrollY - this.initialScrollOffset.y };
                                }
                                [g]({ mirror: e, source: t, sensorEvent: r }) {
                                    const n = { mirror: e, source: t, sensorEvent: r, mirrorClass: this.draggable.getClassNameFor("mirror"), scrollOffset: this.scrollOffset, options: this.options };
                                    return Promise.resolve(n)
                                        .then(b)
                                        .then(E)
                                        .then(y)
                                        .then(S)
                                        .then(C({ initial: !0 }))
                                        .then(O)
                                        .then((e) => {
                                            let { mirrorOffset: t, initialX: r, initialY: n } = e,
                                                i = l(e, ["mirrorOffset", "initialX", "initialY"]);
                                            return (this.mirrorOffset = t), (this.initialX = r), (this.initialY = n), o({ mirrorOffset: t, initialX: r, initialY: n }, i);
                                        });
                                }
                                [h](e) {
                                    if (e.canceled()) return null;
                                    const t = { mirror: e.mirror, sensorEvent: e.sensorEvent, mirrorOffset: this.mirrorOffset, options: this.options, initialX: this.initialX, initialY: this.initialY, scrollOffset: this.scrollOffset };
                                    return Promise.resolve(t).then(C({ raf: !0 }));
                                }
                                [v](e) {
                                    const t = this.options.appendTo;
                                    return "string" == typeof t ? document.querySelector(t) : t instanceof HTMLElement ? t : "function" == typeof t ? t(e) : e.parentNode;
                                }
                            }
                            function b(e) {
                                let { source: t } = e,
                                    r = l(e, ["source"]);
                                return M((e) => {
                                    const n = t.getBoundingClientRect();
                                    e(o({ source: t, sourceRect: n }, r));
                                });
                            }
                            function E(e) {
                                let { sensorEvent: t, sourceRect: r, options: n } = e,
                                    i = l(e, ["sensorEvent", "sourceRect", "options"]);
                                return M((e) => {
                                    const s = null === n.cursorOffsetY ? t.clientY - r.top : n.cursorOffsetY,
                                        a = null === n.cursorOffsetX ? t.clientX - r.left : n.cursorOffsetX;
                                    e(o({ sensorEvent: t, sourceRect: r, mirrorOffset: { top: s, left: a }, options: n }, i));
                                });
                            }
                            function y(e) {
                                let { mirror: t, source: r, options: n } = e,
                                    i = l(e, ["mirror", "source", "options"]);
                                return M((e) => {
                                    let s, a;
                                    if (n.constrainDimensions) {
                                        const e = getComputedStyle(r);
                                        (s = e.getPropertyValue("height")), (a = e.getPropertyValue("width"));
                                    }
                                    (t.style.position = "fixed"),
                                        (t.style.pointerEvents = "none"),
                                        (t.style.top = 0),
                                        (t.style.left = 0),
                                        (t.style.margin = 0),
                                        n.constrainDimensions && ((t.style.height = s), (t.style.width = a)),
                                        e(o({ mirror: t, source: r, options: n }, i));
                                });
                            }
                            function S(e) {
                                let { mirror: t, mirrorClass: r } = e,
                                    n = l(e, ["mirror", "mirrorClass"]);
                                return M((e) => {
                                    t.classList.add(r), e(o({ mirror: t, mirrorClass: r }, n));
                                });
                            }
                            function O(e) {
                                let { mirror: t } = e,
                                    r = l(e, ["mirror"]);
                                return M((e) => {
                                    t.removeAttribute("id"), delete t.id, e(o({ mirror: t }, r));
                                });
                            }
                            function C({ withFrame: e = !1, initial: t = !1 } = {}) {
                                return (r) => {
                                    let { mirror: n, sensorEvent: i, mirrorOffset: s, initialY: a, initialX: c, scrollOffset: u, options: d } = r,
                                        g = l(r, ["mirror", "sensorEvent", "mirrorOffset", "initialY", "initialX", "scrollOffset", "options"]);
                                    return M(
                                        (e) => {
                                            const r = o({ mirror: n, sensorEvent: i, mirrorOffset: s, options: d }, g);
                                            if (s) {
                                                const e = i.clientX - s.left - u.x,
                                                    o = i.clientY - s.top - u.y;
                                                (d.xAxis && d.yAxis) || t
                                                    ? (n.style.transform = `translate3d(${e}px, ${o}px, 0)`)
                                                    : d.xAxis && !d.yAxis
                                                    ? (n.style.transform = `translate3d(${e}px, ${a}px, 0)`)
                                                    : d.yAxis && !d.xAxis && (n.style.transform = `translate3d(${c}px, ${o}px, 0)`),
                                                    t && ((r.initialX = e), (r.initialY = o));
                                            }
                                            e(r);
                                        },
                                        { frame: e }
                                    );
                                };
                            }
                            function M(e, { raf: t = !1 } = {}) {
                                return new Promise((r, n) => {
                                    t
                                        ? requestAnimationFrame(() => {
                                              e(r, n);
                                          })
                                        : e(r, n);
                                });
                            }
                            t.default = p;
                        },
                        function (e, t, r) {
                            Object.defineProperty(t, "__esModule", { value: !0 }), (t.defaultOptions = void 0);
                            var n,
                                o = r(31),
                                i = (n = o) && n.__esModule ? n : { default: n };
                            (t.default = i.default), (t.defaultOptions = o.defaultOptions);
                        },
                        function (e, t, r) {
                            Object.defineProperty(t, "__esModule", { value: !0 });
                            var n,
                                o =
                                    Object.assign ||
                                    function (e) {
                                        for (var t = 1; t < arguments.length; t++) {
                                            var r = arguments[t];
                                            for (var n in r) Object.prototype.hasOwnProperty.call(r, n) && (e[n] = r[n]);
                                        }
                                        return e;
                                    },
                                i = r(4),
                                s = (n = i) && n.__esModule ? n : { default: n };
                            const a = Symbol("onInitialize"),
                                l = Symbol("onDestroy"),
                                c = {};
                            class u extends s.default {
                                constructor(e) {
                                    super(e), (this.options = o({}, c, this.getOptions())), (this[a] = this[a].bind(this)), (this[l] = this[l].bind(this));
                                }
                                attach() {
                                    this.draggable.on("draggable:initialize", this[a]).on("draggable:destroy", this[l]);
                                }
                                detach() {
                                    this.draggable.off("draggable:initialize", this[a]).off("draggable:destroy", this[l]);
                                }
                                getOptions() {
                                    return this.draggable.options.focusable || {};
                                }
                                getElements() {
                                    return [...this.draggable.containers, ...this.draggable.getDraggableElements()];
                                }
                                [a]() {
                                    requestAnimationFrame(() => {
                                        this.getElements().forEach((e) =>
                                            (function (e) {
                                                Boolean(!e.getAttribute("tabindex") && -1 === e.tabIndex) && (d.push(e), (e.tabIndex = 0));
                                            })(e)
                                        );
                                    });
                                }
                                [l]() {
                                    requestAnimationFrame(() => {
                                        this.getElements().forEach((e) =>
                                            (function (e) {
                                                const t = d.indexOf(e);
                                                -1 !== t && ((e.tabIndex = -1), d.splice(t, 1));
                                            })(e)
                                        );
                                    });
                                }
                            }
                            t.default = u;
                            const d = [];
                        },
                        function (e, t, r) {
                            Object.defineProperty(t, "__esModule", { value: !0 });
                            var n,
                                o = r(33),
                                i = (n = o) && n.__esModule ? n : { default: n };
                            t.default = i.default;
                        },
                        function (e, t, r) {
                            Object.defineProperty(t, "__esModule", { value: !0 }),
                                (t.default = class {
                                    constructor(e) {
                                        this.draggable = e;
                                    }
                                    attach() {
                                        throw new Error("Not Implemented");
                                    }
                                    detach() {
                                        throw new Error("Not Implemented");
                                    }
                                });
                        },
                        function (e, t, r) {
                            Object.defineProperty(t, "__esModule", { value: !0 }), (t.defaultOptions = void 0);
                            var n,
                                o =
                                    Object.assign ||
                                    function (e) {
                                        for (var t = 1; t < arguments.length; t++) {
                                            var r = arguments[t];
                                            for (var n in r) Object.prototype.hasOwnProperty.call(r, n) && (e[n] = r[n]);
                                        }
                                        return e;
                                    },
                                i = r(4),
                                s = (n = i) && n.__esModule ? n : { default: n };
                            const a = Symbol("onInitialize"),
                                l = Symbol("onDestroy"),
                                c = Symbol("announceEvent"),
                                u = Symbol("announceMessage"),
                                d = (t.defaultOptions = { expire: 7e3 });
                            class g extends s.default {
                                constructor(e) {
                                    super(e), (this.options = o({}, d, this.getOptions())), (this.originalTriggerMethod = this.draggable.trigger), (this[a] = this[a].bind(this)), (this[l] = this[l].bind(this));
                                }
                                attach() {
                                    this.draggable.on("draggable:initialize", this[a]);
                                }
                                detach() {
                                    this.draggable.off("draggable:destroy", this[l]);
                                }
                                getOptions() {
                                    return this.draggable.options.announcements || {};
                                }
                                [c](e) {
                                    const t = this.options[e.type];
                                    t && "string" == typeof t && this[u](t), t && "function" == typeof t && this[u](t(e));
                                }
                                [u](e) {
                                    !(function (e, { expire: t }) {
                                        const r = document.createElement("div");
                                        (r.textContent = e),
                                            h.appendChild(r),
                                            setTimeout(() => {
                                                h.removeChild(r);
                                            }, t);
                                    })(e, { expire: this.options.expire });
                                }
                                [a]() {
                                    this.draggable.trigger = (e) => {
                                        try {
                                            this[c](e);
                                        } finally {
                                            this.originalTriggerMethod.call(this.draggable, e);
                                        }
                                    };
                                }
                                [l]() {
                                    this.draggable.trigger = this.originalTriggerMethod;
                                }
                            }
                            t.default = g;
                            const h = (function () {
                                const e = document.createElement("div");
                                return (
                                    e.setAttribute("id", "draggable-live-region"),
                                    e.setAttribute("aria-relevant", "additions"),
                                    e.setAttribute("aria-atomic", "true"),
                                    e.setAttribute("aria-live", "assertive"),
                                    e.setAttribute("role", "log"),
                                    (e.style.position = "fixed"),
                                    (e.style.width = "1px"),
                                    (e.style.height = "1px"),
                                    (e.style.top = "-1px"),
                                    (e.style.overflow = "hidden"),
                                    e
                                );
                            })();
                            document.addEventListener("DOMContentLoaded", () => {
                                document.body.appendChild(h);
                            });
                        },
                        function (e, t, r) {
                            Object.defineProperty(t, "__esModule", { value: !0 }), (t.defaultOptions = void 0);
                            var n,
                                o = r(36),
                                i = (n = o) && n.__esModule ? n : { default: n };
                            (t.default = i.default), (t.defaultOptions = o.defaultOptions);
                        },
                        function (e, t, r) {
                            Object.defineProperty(t, "__esModule", { value: !0 }), (t.DraggableDestroyEvent = t.DraggableInitializedEvent = t.DraggableEvent = void 0);
                            var n,
                                o = r(3),
                                i = (n = o) && n.__esModule ? n : { default: n };
                            class s extends i.default {
                                get draggable() {
                                    return this.data.draggable;
                                }
                            }
                            (t.DraggableEvent = s), (s.type = "draggable");
                            class a extends s {}
                            (t.DraggableInitializedEvent = a), (a.type = "draggable:initialize");
                            class l extends s {}
                            (t.DraggableDestroyEvent = l), (l.type = "draggable:destroy");
                        },
                        function (e, t, r) {
                            Object.defineProperty(t, "__esModule", { value: !0 }),
                                (t.DragStopEvent = t.DragPressureEvent = t.DragOutContainerEvent = t.DragOverContainerEvent = t.DragOutEvent = t.DragOverEvent = t.DragMoveEvent = t.DragStartEvent = t.DragEvent = void 0);
                            var n,
                                o = r(3),
                                i = (n = o) && n.__esModule ? n : { default: n };
                            class s extends i.default {
                                get source() {
                                    return this.data.source;
                                }
                                get originalSource() {
                                    return this.data.originalSource;
                                }
                                get mirror() {
                                    return this.data.mirror;
                                }
                                get sourceContainer() {
                                    return this.data.sourceContainer;
                                }
                                get sensorEvent() {
                                    return this.data.sensorEvent;
                                }
                                get originalEvent() {
                                    return this.sensorEvent ? this.sensorEvent.originalEvent : null;
                                }
                            }
                            (t.DragEvent = s), (s.type = "drag");
                            class a extends s {}
                            (t.DragStartEvent = a), (a.type = "drag:start"), (a.cancelable = !0);
                            class l extends s {}
                            (t.DragMoveEvent = l), (l.type = "drag:move");
                            class c extends s {
                                get overContainer() {
                                    return this.data.overContainer;
                                }
                                get over() {
                                    return this.data.over;
                                }
                            }
                            (t.DragOverEvent = c), (c.type = "drag:over"), (c.cancelable = !0);
                            class u extends s {
                                get overContainer() {
                                    return this.data.overContainer;
                                }
                                get over() {
                                    return this.data.over;
                                }
                            }
                            (t.DragOutEvent = u), (u.type = "drag:out");
                            class d extends s {
                                get overContainer() {
                                    return this.data.overContainer;
                                }
                            }
                            (t.DragOverContainerEvent = d), (d.type = "drag:over:container");
                            class g extends s {
                                get overContainer() {
                                    return this.data.overContainer;
                                }
                            }
                            (t.DragOutContainerEvent = g), (g.type = "drag:out:container");
                            class h extends s {
                                get pressure() {
                                    return this.data.pressure;
                                }
                            }
                            (t.DragPressureEvent = h), (h.type = "drag:pressure");
                            class f extends s {}
                            (t.DragStopEvent = f), (f.type = "drag:stop");
                        },
                        function (e, t, r) {
                            Object.defineProperty(t, "__esModule", { value: !0 });
                            var n = r(8);
                            Object.keys(n).forEach(function (e) {
                                "default" !== e &&
                                    "__esModule" !== e &&
                                    Object.defineProperty(t, e, {
                                        enumerable: !0,
                                        get: function () {
                                            return n[e];
                                        },
                                    });
                            });
                            var o = r(7);
                            Object.keys(o).forEach(function (e) {
                                "default" !== e &&
                                    "__esModule" !== e &&
                                    Object.defineProperty(t, e, {
                                        enumerable: !0,
                                        get: function () {
                                            return o[e];
                                        },
                                    });
                            });
                            var i = r(6);
                            Object.keys(i).forEach(function (e) {
                                "default" !== e &&
                                    "__esModule" !== e &&
                                    Object.defineProperty(t, e, {
                                        enumerable: !0,
                                        get: function () {
                                            return i[e];
                                        },
                                    });
                            });
                            var s = r(5);
                            Object.keys(s).forEach(function (e) {
                                "default" !== e &&
                                    "__esModule" !== e &&
                                    Object.defineProperty(t, e, {
                                        enumerable: !0,
                                        get: function () {
                                            return s[e];
                                        },
                                    });
                            });
                            var a,
                                l = r(12),
                                c = (a = l) && a.__esModule ? a : { default: a };
                            t.default = c.default;
                        },
                        function (e, t, r) {
                            Object.defineProperty(t, "__esModule", { value: !0 });
                            var n,
                                o =
                                    Object.assign ||
                                    function (e) {
                                        for (var t = 1; t < arguments.length; t++) {
                                            var r = arguments[t];
                                            for (var n in r) Object.prototype.hasOwnProperty.call(r, n) && (e[n] = r[n]);
                                        }
                                        return e;
                                    },
                                i = r(40),
                                s = (n = i) && n.__esModule ? n : { default: n },
                                a = r(9);
                            const l = Symbol("onDragStart"),
                                c = Symbol("onDragOverContainer"),
                                u = Symbol("onDragOver"),
                                d = Symbol("onDragStop"),
                                g = {
                                    "sortable:sorted": function ({ dragEvent: e }) {
                                        const t = e.source.textContent.trim() || e.source.id || "sortable element";
                                        if (e.over) {
                                            const r = e.over.textContent.trim() || e.over.id || "sortable element";
                                            return e.source.compareDocumentPosition(e.over) & Node.DOCUMENT_POSITION_FOLLOWING ? `Placed ${t} after ${r}` : `Placed ${t} before ${r}`;
                                        }
                                        return `Placed ${t} into a different container`;
                                    },
                                };
                            class h extends s.default {
                                constructor(e = [], t = {}) {
                                    super(e, o({}, t, { announcements: o({}, g, t.announcements || {}) })),
                                        (this.startIndex = null),
                                        (this.startContainer = null),
                                        (this[l] = this[l].bind(this)),
                                        (this[c] = this[c].bind(this)),
                                        (this[u] = this[u].bind(this)),
                                        (this[d] = this[d].bind(this)),
                                        this.on("drag:start", this[l]).on("drag:over:container", this[c]).on("drag:over", this[u]).on("drag:stop", this[d]);
                                }
                                destroy() {
                                    super.destroy(), this.off("drag:start", this[l]).off("drag:over:container", this[c]).off("drag:over", this[u]).off("drag:stop", this[d]);
                                }
                                index(e) {
                                    return this.getDraggableElementsForContainer(e.parentNode).indexOf(e);
                                }
                                [l](e) {
                                    (this.startContainer = e.source.parentNode), (this.startIndex = this.index(e.source));
                                    const t = new a.SortableStartEvent({ dragEvent: e, startIndex: this.startIndex, startContainer: this.startContainer });
                                    this.trigger(t), t.canceled() && e.cancel();
                                }
                                [c](e) {
                                    if (e.canceled()) return;
                                    const { source: t, over: r, overContainer: n } = e,
                                        o = this.index(t),
                                        i = new a.SortableSortEvent({ dragEvent: e, currentIndex: o, source: t, over: r });
                                    if ((this.trigger(i), i.canceled())) return;
                                    const s = v({ source: t, over: r, overContainer: n, children: this.getDraggableElementsForContainer(n) });
                                    if (!s) return;
                                    const { oldContainer: l, newContainer: c } = s,
                                        u = this.index(e.source),
                                        d = new a.SortableSortedEvent({ dragEvent: e, oldIndex: o, newIndex: u, oldContainer: l, newContainer: c });
                                    this.trigger(d);
                                }
                                [u](e) {
                                    if (e.over === e.originalSource || e.over === e.source) return;
                                    const { source: t, over: r, overContainer: n } = e,
                                        o = this.index(t),
                                        i = new a.SortableSortEvent({ dragEvent: e, currentIndex: o, source: t, over: r });
                                    if ((this.trigger(i), i.canceled())) return;
                                    const s = v({ source: t, over: r, overContainer: n, children: this.getDraggableElementsForContainer(n) });
                                    if (!s) return;
                                    const { oldContainer: l, newContainer: c } = s,
                                        u = this.index(t),
                                        d = new a.SortableSortedEvent({ dragEvent: e, oldIndex: o, newIndex: u, oldContainer: l, newContainer: c });
                                    this.trigger(d);
                                }
                                [d](e) {
                                    const t = new a.SortableStopEvent({ dragEvent: e, oldIndex: this.startIndex, newIndex: this.index(e.source), oldContainer: this.startContainer, newContainer: e.source.parentNode });
                                    this.trigger(t), (this.startIndex = null), (this.startContainer = null);
                                }
                            }
                            function f(e) {
                                return Array.prototype.indexOf.call(e.parentNode.children, e);
                            }
                            function v({ source: e, over: t, overContainer: r, children: n }) {
                                const o = !n.length,
                                    i = e.parentNode !== r,
                                    s = t && !i;
                                return o
                                    ? (function (e, t) {
                                          const r = e.parentNode;
                                          return t.appendChild(e), { oldContainer: r, newContainer: t };
                                      })(e, r)
                                    : s
                                    ? (function (e, t) {
                                          const r = f(e),
                                              n = f(t);
                                          return r < n ? e.parentNode.insertBefore(e, t.nextElementSibling) : e.parentNode.insertBefore(e, t), { oldContainer: e.parentNode, newContainer: e.parentNode };
                                      })(e, t)
                                    : i
                                    ? (function (e, t, r) {
                                          const n = e.parentNode;
                                          return t ? t.parentNode.insertBefore(e, t) : r.appendChild(e), { oldContainer: n, newContainer: e.parentNode };
                                      })(e, t, r)
                                    : null;
                            }
                            t.default = h;
                        },
                        function (e, t, r) {
                            Object.defineProperty(t, "__esModule", { value: !0 });
                            var n =
                                Object.assign ||
                                function (e) {
                                    for (var t = 1; t < arguments.length; t++) {
                                        var r = arguments[t];
                                        for (var n in r) Object.prototype.hasOwnProperty.call(r, n) && (e[n] = r[n]);
                                    }
                                    return e;
                                };
                            const o = Symbol("canceled");
                            class i {
                                constructor(e) {
                                    (this[o] = !1), (this.data = e);
                                }
                                get type() {
                                    return this.constructor.type;
                                }
                                get cancelable() {
                                    return this.constructor.cancelable;
                                }
                                cancel() {
                                    this[o] = !0;
                                }
                                canceled() {
                                    return Boolean(this[o]);
                                }
                                clone(e) {
                                    return new this.constructor(n({}, this.data, e));
                                }
                            }
                            (t.default = i), (i.type = "event"), (i.cancelable = !1);
                        },
                        function (e, t, r) {
                            Object.defineProperty(t, "__esModule", { value: !0 }), (t.SortableStopEvent = t.SortableSortedEvent = t.SortableSortEvent = t.SortableStartEvent = t.SortableEvent = void 0);
                            var n,
                                o = r(3),
                                i = (n = o) && n.__esModule ? n : { default: n };
                            class s extends i.default {
                                get dragEvent() {
                                    return this.data.dragEvent;
                                }
                            }
                            (t.SortableEvent = s), (s.type = "sortable");
                            class a extends s {
                                get startIndex() {
                                    return this.data.startIndex;
                                }
                                get startContainer() {
                                    return this.data.startContainer;
                                }
                            }
                            (t.SortableStartEvent = a), (a.type = "sortable:start"), (a.cancelable = !0);
                            class l extends s {
                                get currentIndex() {
                                    return this.data.currentIndex;
                                }
                                get over() {
                                    return this.data.oldIndex;
                                }
                                get overContainer() {
                                    return this.data.newIndex;
                                }
                            }
                            (t.SortableSortEvent = l), (l.type = "sortable:sort"), (l.cancelable = !0);
                            class c extends s {
                                get oldIndex() {
                                    return this.data.oldIndex;
                                }
                                get newIndex() {
                                    return this.data.newIndex;
                                }
                                get oldContainer() {
                                    return this.data.oldContainer;
                                }
                                get newContainer() {
                                    return this.data.newContainer;
                                }
                            }
                            (t.SortableSortedEvent = c), (c.type = "sortable:sorted");
                            class u extends s {
                                get oldIndex() {
                                    return this.data.oldIndex;
                                }
                                get newIndex() {
                                    return this.data.newIndex;
                                }
                                get oldContainer() {
                                    return this.data.oldContainer;
                                }
                                get newContainer() {
                                    return this.data.newContainer;
                                }
                            }
                            (t.SortableStopEvent = u), (u.type = "sortable:stop");
                        },
                        function (e, t, r) {
                            Object.defineProperty(t, "__esModule", { value: !0 });
                            var n = r(9);
                            Object.keys(n).forEach(function (e) {
                                "default" !== e &&
                                    "__esModule" !== e &&
                                    Object.defineProperty(t, e, {
                                        enumerable: !0,
                                        get: function () {
                                            return n[e];
                                        },
                                    });
                            });
                            var o,
                                i = r(41),
                                s = (o = i) && o.__esModule ? o : { default: o };
                            t.default = s.default;
                        },
                    ]);
                }),
                (e.exports = r());
        }),
        r = (e = t) && e.__esModule && Object.prototype.hasOwnProperty.call(e, "default") ? e.default : e;
    const n = {
        start() {
            window.livewire.directive("sortable-group", (e, t, n) => {
                if (t.modifiers.length > 0) return;
                let o = { draggable: "[wire\\:sortable-group\\.item]" };
                e.querySelector("[wire\\:sortable-group\\.handle]") && (o.handle = "[wire\\:sortable-group\\.handle]"),
                    new r(e.querySelectorAll("[wire\\:sortable-group\\.item-group]"), o).on("sortable:stop", () => {
                        setTimeout(() => {
                            let e = [];
                            e.querySelectorAll("[wire\\:sortable-group\\.item-group]").forEach((t, r) => {
                                let n = [];
                                t.querySelectorAll("[wire\\:sortable-group\\.item]").forEach((e, t) => {
                                    n.push({ order: t + 1, value: e.getAttribute("wire:sortable-group.item") });
                                }),
                                    e.push({ order: r + 1, value: t.getAttribute("wire:sortable-group.item-group"), items: n });
                            }),
                                n.call(t.method, e);
                        }, 1);
                    });
            }),
                window.livewire.directive("sortable", (e, t, n) => {
                    if (t.modifiers.length > 0) return;
                    let o = { draggable: "[wire\\:sortable\\.item]" };
                    e.querySelector("[wire\\:sortable\\.handle]") && (o.handle = "[wire\\:sortable\\.handle]"),
                        new r(e, o).on("sortable:stop", () => {
                            setTimeout(() => {
                                let e = [];
                                this.querySelectorAll("[wire\\:sortable\\.item]").forEach((t, r) => {
                                    e.push({ order: r + 1, value: t.getAttribute("wire:sortable.item") });
                                }),
                                    n.call(t.method, e);
                            }, 1);
                        });
                });
        },
    };
    return window.livewire && ((window.LivewireSortable = n), window.LivewireSortable.start()), n;
});
//# sourceMappingURL=livewire-sortable.js.map
