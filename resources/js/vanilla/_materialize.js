/*!
* Materialize v1.0.0-beta (http://materializecss.com)
* Copyright 2014-2017 Materialize
* MIT License (https://raw.githubusercontent.com/Dogfalo/materialize/master/LICENSE)
*/
var _get = function get(object, property, receiver) { if (object === null) object = Function.prototype; var desc = Object.getOwnPropertyDescriptor(object, property); if (desc === undefined) { var parent = Object.getPrototypeOf(object); if (parent === null) { return undefined; } else { return get(parent, property, receiver); } } else if ("value" in desc) { return desc.value; } else { var getter = desc.get; if (getter === undefined) { return undefined; } return getter.call(receiver); } };

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

/*! cash-dom 1.3.5, https://github.com/kenwheeler/cash @license MIT */
(function (factory) {
    window.cash = factory();
})(function () {
    var doc = document,
    win = window,
    ArrayProto = Array.prototype,
    slice = ArrayProto.slice,
    filter = ArrayProto.filter,
    push = ArrayProto.push;
    
    var noop = function () {},
    isFunction = function (item) {
        // @see https://crbug.com/568448
        return typeof item === typeof noop && item.call;
    },
    isString = function (item) {
        return typeof item === typeof "";
    };
    
    var idMatch = /^#[\w-]*$/,
    classMatch = /^\.[\w-]*$/,
    htmlMatch = /<.+>/,
    singlet = /^\w+$/;
    
    function find(selector, context) {
        context = context || doc;
        var elems = classMatch.test(selector) ? context.getElementsByClassName(selector.slice(1)) : singlet.test(selector) ? context.getElementsByTagName(selector) : context.querySelectorAll(selector);
        return elems;
    }
    
    var frag;
    function parseHTML(str) {
        if (!frag) {
            frag = doc.implementation.createHTMLDocument(null);
            var base = frag.createElement("base");
            base.href = doc.location.href;
            frag.head.appendChild(base);
        }
        
        frag.body.innerHTML = str;
        
        return frag.body.childNodes;
    }
    
    function onReady(fn) {
        if (doc.readyState !== "loading") {
            fn();
        } else {
            doc.addEventListener("DOMContentLoaded", fn);
        }
    }
    
    function Init(selector, context) {
        if (!selector) {
            return this;
        }
        
        // If already a cash collection, don't do any further processing
        if (selector.cash && selector !== win) {
            return selector;
        }
        
        var elems = selector,
        i = 0,
        length;
        
        if (isString(selector)) {
            elems = idMatch.test(selector) ?
            // If an ID use the faster getElementById check
            doc.getElementById(selector.slice(1)) : htmlMatch.test(selector) ?
            // If HTML, parse it into real elements
            parseHTML(selector) :
            // else use `find`
            find(selector, context);
            
            // If function, use as shortcut for DOM ready
        } else if (isFunction(selector)) {
            onReady(selector);return this;
        }
        
        if (!elems) {
            return this;
        }
        
        // If a single DOM element is passed in or received via ID, return the single element
        if (elems.nodeType || elems === win) {
            this[0] = elems;
            this.length = 1;
        } else {
            // Treat like an array and loop through each item.
            length = this.length = elems.length;
            for (; i < length; i++) {
                this[i] = elems[i];
            }
        }
        
        return this;
    }
    
    function cash(selector, context) {
        return new Init(selector, context);
    }
    
    var fn = cash.fn = cash.prototype = Init.prototype = { // jshint ignore:line
        cash: true,
        length: 0,
        push: push,
        splice: ArrayProto.splice,
        map: ArrayProto.map,
        init: Init
    };
    
    Object.defineProperty(fn, "constructor", { value: cash });
    
    cash.parseHTML = parseHTML;
    cash.noop = noop;
    cash.isFunction = isFunction;
    cash.isString = isString;
    
    cash.extend = fn.extend = function (target) {
        target = target || {};
        
        var args = slice.call(arguments),
        length = args.length,
        i = 1;
        
        if (args.length === 1) {
            target = this;
            i = 0;
        }
        
        for (; i < length; i++) {
            if (!args[i]) {
                continue;
            }
            for (var key in args[i]) {
                if (args[i].hasOwnProperty(key)) {
                    target[key] = args[i][key];
                }
            }
        }
        
        return target;
    };
    
    function each(collection, callback) {
        var l = collection.length,
        i = 0;
        
        for (; i < l; i++) {
            if (callback.call(collection[i], collection[i], i, collection) === false) {
                break;
            }
        }
    }
    
    function matches(el, selector) {
        var m = el && (el.matches || el.webkitMatchesSelector || el.mozMatchesSelector || el.msMatchesSelector || el.oMatchesSelector);
        return !!m && m.call(el, selector);
    }
    
    function getCompareFunction(selector) {
        return (
            /* Use browser's `matches` function if string */
            isString(selector) ? matches :
            /* Match a cash element */
            selector.cash ? function (el) {
                return selector.is(el);
            } :
            /* Direct comparison */
            function (el, selector) {
                return el === selector;
            }
        );
    }
    
    function unique(collection) {
        return cash(slice.call(collection).filter(function (item, index, self) {
            return self.indexOf(item) === index;
        }));
    }
    
    cash.extend({
        merge: function (first, second) {
            var len = +second.length,
            i = first.length,
            j = 0;
            
            for (; j < len; i++, j++) {
                first[i] = second[j];
            }
            
            first.length = i;
            return first;
        },
        
        each: each,
        matches: matches,
        unique: unique,
        isArray: Array.isArray,
        isNumeric: function (n) {
            return !isNaN(parseFloat(n)) && isFinite(n);
        }
        
    });
    
    var uid = cash.uid = "_cash" + Date.now();
    
    function getDataCache(node) {
        return node[uid] = node[uid] || {};
    }
    
    function setData(node, key, value) {
        return getDataCache(node)[key] = value;
    }
    
    function getData(node, key) {
        var c = getDataCache(node);
        if (c[key] === undefined) {
            c[key] = node.dataset ? node.dataset[key] : cash(node).attr("data-" + key);
        }
        return c[key];
    }
    
    function removeData(node, key) {
        var c = getDataCache(node);
        if (c) {
            delete c[key];
        } else if (node.dataset) {
            delete node.dataset[key];
        } else {
            cash(node).removeAttr("data-" + name);
        }
    }
    
    fn.extend({
        data: function (name, value) {
            if (isString(name)) {
                return value === undefined ? getData(this[0], name) : this.each(function (v) {
                    return setData(v, name, value);
                });
            }
            
            for (var key in name) {
                this.data(key, name[key]);
            }
            
            return this;
        },
        
        removeData: function (key) {
            return this.each(function (v) {
                return removeData(v, key);
            });
        }
        
    });
    
    var notWhiteMatch = /\S+/g;
    
    function getClasses(c) {
        return isString(c) && c.match(notWhiteMatch);
    }
    
    function hasClass(v, c) {
        return v.classList ? v.classList.contains(c) : new RegExp("(^| )" + c + "( |$)", "gi").test(v.className);
    }
    
    function addClass(v, c, spacedName) {
        if (v.classList) {
            v.classList.add(c);
        } else if (spacedName.indexOf(" " + c + " ")) {
            v.className += " " + c;
        }
    }
    
    function removeClass(v, c) {
        if (v.classList) {
            v.classList.remove(c);
        } else {
            v.className = v.className.replace(c, "");
        }
    }
    
    fn.extend({
        addClass: function (c) {
            var classes = getClasses(c);
            
            return classes ? this.each(function (v) {
                var spacedName = " " + v.className + " ";
                each(classes, function (c) {
                    addClass(v, c, spacedName);
                });
            }) : this;
        },
        
        attr: function (name, value) {
            if (!name) {
                return undefined;
            }
            
            if (isString(name)) {
                if (value === undefined) {
                    return this[0] ? this[0].getAttribute ? this[0].getAttribute(name) : this[0][name] : undefined;
                }
                
                return this.each(function (v) {
                    if (v.setAttribute) {
                        v.setAttribute(name, value);
                    } else {
                        v[name] = value;
                    }
                });
            }
            
            for (var key in name) {
                this.attr(key, name[key]);
            }
            
            return this;
        },
        
        hasClass: function (c) {
            var check = false,
            classes = getClasses(c);
            if (classes && classes.length) {
                this.each(function (v) {
                    check = hasClass(v, classes[0]);
                    return !check;
                });
            }
            return check;
        },
        
        prop: function (name, value) {
            if (isString(name)) {
                return value === undefined ? this[0][name] : this.each(function (v) {
                    v[name] = value;
                });
            }
            
            for (var key in name) {
                this.prop(key, name[key]);
            }
            
            return this;
        },
        
        removeAttr: function (name) {
            return this.each(function (v) {
                if (v.removeAttribute) {
                    v.removeAttribute(name);
                } else {
                    delete v[name];
                }
            });
        },
        
        removeClass: function (c) {
            if (!arguments.length) {
                return this.attr("class", "");
            }
            var classes = getClasses(c);
            return classes ? this.each(function (v) {
                each(classes, function (c) {
                    removeClass(v, c);
                });
            }) : this;
        },
        
        removeProp: function (name) {
            return this.each(function (v) {
                delete v[name];
            });
        },
        
        toggleClass: function (c, state) {
            if (state !== undefined) {
                return this[state ? "addClass" : "removeClass"](c);
            }
            var classes = getClasses(c);
            return classes ? this.each(function (v) {
                var spacedName = " " + v.className + " ";
                each(classes, function (c) {
                    if (hasClass(v, c)) {
                        removeClass(v, c);
                    } else {
                        addClass(v, c, spacedName);
                    }
                });
            }) : this;
        } });
        
        fn.extend({
            add: function (selector, context) {
                return unique(cash.merge(this, cash(selector, context)));
            },
            
            each: function (callback) {
                each(this, callback);
                return this;
            },
            
            eq: function (index) {
                return cash(this.get(index));
            },
            
            filter: function (selector) {
                if (!selector) {
                    return this;
                }
                
                var comparator = isFunction(selector) ? selector : getCompareFunction(selector);
                
                return cash(filter.call(this, function (e) {
                    return comparator(e, selector);
                }));
            },
            
            first: function () {
                return this.eq(0);
            },
            
            get: function (index) {
                if (index === undefined) {
                    return slice.call(this);
                }
                return index < 0 ? this[index + this.length] : this[index];
            },
            
            index: function (elem) {
                var child = elem ? cash(elem)[0] : this[0],
                collection = elem ? this : cash(child).parent().children();
                return slice.call(collection).indexOf(child);
            },
            
            last: function () {
                return this.eq(-1);
            }
            
        });
        
        var camelCase = function () {
            var camelRegex = /(?:^\w|[A-Z]|\b\w)/g,
            whiteSpace = /[\s-_]+/g;
            return function (str) {
                return str.replace(camelRegex, function (letter, index) {
                    return letter[index === 0 ? "toLowerCase" : "toUpperCase"]();
                }).replace(whiteSpace, "");
            };
        }();
        
        var getPrefixedProp = function () {
            var cache = {},
            doc = document,
            div = doc.createElement("div"),
            style = div.style;
            
            return function (prop) {
                prop = camelCase(prop);
                if (cache[prop]) {
                    return cache[prop];
                }
                
                var ucProp = prop.charAt(0).toUpperCase() + prop.slice(1),
                prefixes = ["webkit", "moz", "ms", "o"],
                props = (prop + " " + prefixes.join(ucProp + " ") + ucProp).split(" ");
                
                each(props, function (p) {
                    if (p in style) {
                        cache[p] = prop = cache[prop] = p;
                        return false;
                    }
                });
                
                return cache[prop];
            };
        }();
        
        cash.prefixedProp = getPrefixedProp;
        cash.camelCase = camelCase;
        
        fn.extend({
            css: function (prop, value) {
                if (isString(prop)) {
                    prop = getPrefixedProp(prop);
                    return arguments.length > 1 ? this.each(function (v) {
                        return v.style[prop] = value;
                    }) : win.getComputedStyle(this[0])[prop];
                }
                
                for (var key in prop) {
                    this.css(key, prop[key]);
                }
                
                return this;
            }
            
        });
        
        function compute(el, prop) {
            return parseInt(win.getComputedStyle(el[0], null)[prop], 10) || 0;
        }
        
        each(["Width", "Height"], function (v) {
            var lower = v.toLowerCase();
            
            fn[lower] = function () {
                return this[0].getBoundingClientRect()[lower];
            };
            
            fn["inner" + v] = function () {
                return this[0]["client" + v];
            };
            
            fn["outer" + v] = function (margins) {
                return this[0]["offset" + v] + (margins ? compute(this, "margin" + (v === "Width" ? "Left" : "Top")) + compute(this, "margin" + (v === "Width" ? "Right" : "Bottom")) : 0);
            };
        });
        
        function registerEvent(node, eventName, callback) {
            var eventCache = getData(node, "_cashEvents") || setData(node, "_cashEvents", {});
            eventCache[eventName] = eventCache[eventName] || [];
            eventCache[eventName].push(callback);
            node.addEventListener(eventName, callback);
        }
        
        function removeEvent(node, eventName, callback) {
            var events = getData(node, "_cashEvents"),
            eventCache = events && events[eventName],
            index;
            
            if (!eventCache) {
                return;
            }
            
            if (callback) {
                node.removeEventListener(eventName, callback);
                index = eventCache.indexOf(callback);
                if (index >= 0) {
                    eventCache.splice(index, 1);
                }
            } else {
                each(eventCache, function (event) {
                    node.removeEventListener(eventName, event);
                });
                eventCache = [];
            }
        }
        
        fn.extend({
            off: function (eventName, callback) {
                return this.each(function (v) {
                    return removeEvent(v, eventName, callback);
                });
            },
            
            on: function (eventName, delegate, callback, runOnce) {
                // jshint ignore:line
                var originalCallback;
                if (!isString(eventName)) {
                    for (var key in eventName) {
                        this.on(key, delegate, eventName[key]);
                    }
                    return this;
                }
                
                if (isFunction(delegate)) {
                    callback = delegate;
                    delegate = null;
                }
                
                if (eventName === "ready") {
                    onReady(callback);
                    return this;
                }
                
                if (delegate) {
                    originalCallback = callback;
                    callback = function (e) {
                        var t = e.target;
                        while (!matches(t, delegate)) {
                            if (t === this || t === null) {
                                return t = false;
                            }
                            
                            t = t.parentNode;
                        }
                        
                        if (t) {
                            originalCallback.call(t, e);
                        }
                    };
                }
                
                return this.each(function (v) {
                    var finalCallback = callback;
                    if (runOnce) {
                        finalCallback = function () {
                            callback.apply(this, arguments);
                            removeEvent(v, eventName, finalCallback);
                        };
                    }
                    registerEvent(v, eventName, finalCallback);
                });
            },
            
            one: function (eventName, delegate, callback) {
                return this.on(eventName, delegate, callback, true);
            },
            
            ready: onReady,
            
            /**
            * Modified
            * Triggers browser event
            * @param String eventName
            * @param Object data - Add properties to event object
            */
            trigger: function (eventName, data) {
                if (document.createEvent) {
                    var evt = document.createEvent('HTMLEvents');
                    evt.initEvent(eventName, true, false);
                    evt = this.extend(evt, data);
                    return this.each(function (v) {
                        return v.dispatchEvent(evt);
                    });
                }
            }
            
        });
        
        function encode(name, value) {
            return "&" + encodeURIComponent(name) + "=" + encodeURIComponent(value).replace(/%20/g, "+");
        }
        
        function getSelectMultiple_(el) {
            var values = [];
            each(el.options, function (o) {
                if (o.selected) {
                    values.push(o.value);
                }
            });
            return values.length ? values : null;
        }
        
        function getSelectSingle_(el) {
            var selectedIndex = el.selectedIndex;
            return selectedIndex >= 0 ? el.options[selectedIndex].value : null;
        }
        
        function getValue(el) {
            var type = el.type;
            if (!type) {
                return null;
            }
            switch (type.toLowerCase()) {
                case "select-one":
                return getSelectSingle_(el);
                case "select-multiple":
                return getSelectMultiple_(el);
                case "radio":
                return el.checked ? el.value : null;
                case "checkbox":
                return el.checked ? el.value : null;
                default:
                return el.value ? el.value : null;
            }
        }
        
        fn.extend({
            serialize: function () {
                var query = "";
                
                each(this[0].elements || this, function (el) {
                    if (el.disabled || el.tagName === "FIELDSET") {
                        return;
                    }
                    var name = el.name;
                    switch (el.type.toLowerCase()) {
                        case "file":
                        case "reset":
                        case "submit":
                        case "button":
                        break;
                        case "select-multiple":
                        var values = getValue(el);
                        if (values !== null) {
                            each(values, function (value) {
                                query += encode(name, value);
                            });
                        }
                        break;
                        default:
                        var value = getValue(el);
                        if (value !== null) {
                            query += encode(name, value);
                        }
                    }
                });
                
                return query.substr(1);
            },
            
            val: function (value) {
                if (value === undefined) {
                    return getValue(this[0]);
                }
                
                return this.each(function (v) {
                    return v.value = value;
                });
            }
            
        });
        
        function insertElement(el, child, prepend) {
            if (prepend) {
                var first = el.childNodes[0];
                el.insertBefore(child, first);
            } else {
                el.appendChild(child);
            }
        }
        
        function insertContent(parent, child, prepend) {
            var str = isString(child);
            
            if (!str && child.length) {
                each(child, function (v) {
                    return insertContent(parent, v, prepend);
                });
                return;
            }
            
            each(parent, str ? function (v) {
                return v.insertAdjacentHTML(prepend ? "afterbegin" : "beforeend", child);
            } : function (v, i) {
                return insertElement(v, i === 0 ? child : child.cloneNode(true), prepend);
            });
        }
        
        fn.extend({
            after: function (selector) {
                cash(selector).insertAfter(this);
                return this;
            },
            
            append: function (content) {
                insertContent(this, content);
                return this;
            },
            
            appendTo: function (parent) {
                insertContent(cash(parent), this);
                return this;
            },
            
            before: function (selector) {
                cash(selector).insertBefore(this);
                return this;
            },
            
            clone: function () {
                return cash(this.map(function (v) {
                    return v.cloneNode(true);
                }));
            },
            
            empty: function () {
                this.html("");
                return this;
            },
            
            html: function (content) {
                if (content === undefined) {
                    return this[0].innerHTML;
                }
                var source = content.nodeType ? content[0].outerHTML : content;
                return this.each(function (v) {
                    return v.innerHTML = source;
                });
            },
            
            insertAfter: function (selector) {
                var _this = this;
                
                cash(selector).each(function (el, i) {
                    var parent = el.parentNode,
                    sibling = el.nextSibling;
                    _this.each(function (v) {
                        parent.insertBefore(i === 0 ? v : v.cloneNode(true), sibling);
                    });
                });
                
                return this;
            },
            
            insertBefore: function (selector) {
                var _this2 = this;
                cash(selector).each(function (el, i) {
                    var parent = el.parentNode;
                    _this2.each(function (v) {
                        parent.insertBefore(i === 0 ? v : v.cloneNode(true), el);
                    });
                });
                return this;
            },
            
            prepend: function (content) {
                insertContent(this, content, true);
                return this;
            },
            
            prependTo: function (parent) {
                insertContent(cash(parent), this, true);
                return this;
            },
            
            remove: function () {
                return this.each(function (v) {
                    if (!!v.parentNode) {
                        return v.parentNode.removeChild(v);
                    }
                });
            },
            
            text: function (content) {
                if (content === undefined) {
                    return this[0].textContent;
                }
                return this.each(function (v) {
                    return v.textContent = content;
                });
            }
            
        });
        
        var docEl = doc.documentElement;
        
        fn.extend({
            position: function () {
                var el = this[0];
                return {
                    left: el.offsetLeft,
                    top: el.offsetTop
                };
            },
            
            offset: function () {
                var rect = this[0].getBoundingClientRect();
                return {
                    top: rect.top + win.pageYOffset - docEl.clientTop,
                    left: rect.left + win.pageXOffset - docEl.clientLeft
                };
            },
            
            offsetParent: function () {
                return cash(this[0].offsetParent);
            }
            
        });
        
        fn.extend({
            children: function (selector) {
                var elems = [];
                this.each(function (el) {
                    push.apply(elems, el.children);
                });
                elems = unique(elems);
                
                return !selector ? elems : elems.filter(function (v) {
                    return matches(v, selector);
                });
            },
            
            closest: function (selector) {
                if (!selector || this.length < 1) {
                    return cash();
                }
                if (this.is(selector)) {
                    return this.filter(selector);
                }
                return this.parent().closest(selector);
            },
            
            is: function (selector) {
                if (!selector) {
                    return false;
                }
                
                var match = false,
                comparator = getCompareFunction(selector);
                
                this.each(function (el) {
                    match = comparator(el, selector);
                    return !match;
                });
                
                return match;
            },
            
            find: function (selector) {
                if (!selector || selector.nodeType) {
                    return cash(selector && this.has(selector).length ? selector : null);
                }
                
                var elems = [];
                this.each(function (el) {
                    push.apply(elems, find(selector, el));
                });
                
                return unique(elems);
            },
            
            has: function (selector) {
                var comparator = isString(selector) ? function (el) {
                    return find(selector, el).length !== 0;
                } : function (el) {
                    return el.contains(selector);
                };
                
                return this.filter(comparator);
            },
            
            next: function () {
                return cash(this[0].nextElementSibling);
            },
            
            not: function (selector) {
                if (!selector) {
                    return this;
                }
                
                var comparator = getCompareFunction(selector);
                
                return this.filter(function (el) {
                    return !comparator(el, selector);
                });
            },
            
            parent: function () {
                var result = [];
                
                this.each(function (item) {
                    if (item && item.parentNode) {
                        result.push(item.parentNode);
                    }
                });
                
                return unique(result);
            },
            
            parents: function (selector) {
                var last,
                result = [];
                
                this.each(function (item) {
                    last = item;
                    
                    while (last && last.parentNode && last !== doc.body.parentNode) {
                        last = last.parentNode;
                        
                        if (!selector || selector && matches(last, selector)) {
                            result.push(last);
                        }
                    }
                });
                
                return unique(result);
            },
            
            prev: function () {
                return cash(this[0].previousElementSibling);
            },
            
            siblings: function (selector) {
                var collection = this.parent().children(selector),
                el = this[0];
                
                return collection.filter(function (i) {
                    return i !== el;
                });
            }
            
        });
        
        return cash;
    });
    ;
    var Component = function () {
        /**
        * Generic constructor for all components
        * @constructor
        * @param {Element} el
        * @param {Object} options
        */
        function Component(classDef, el, options) {
            _classCallCheck(this, Component);
            
            // Display error if el is valid HTML Element
            if (!(el instanceof Element)) {
                console.error(Error(el + ' is not an HTML Element'));
            }
            
            // If exists, destroy and reinitialize in child
            var ins = classDef.getInstance(el);
            if (!!ins) {
                ins.destroy();
            }
            
            this.el = el;
            this.$el = cash(el);
        }
        
        /**
        * Initializes components
        * @param {class} classDef
        * @param {Element | NodeList | jQuery} els
        * @param {Object} options
        */
        
        
        _createClass(Component, null, [{
            key: "init",
            value: function init(classDef, els, options) {
                var instances = null;
                if (els instanceof Element) {
                    instances = new classDef(els, options);
                } else if (!!els && (els.jquery || els.cash || els instanceof NodeList)) {
                    var instancesArr = [];
                    for (var i = 0; i < els.length; i++) {
                        instancesArr.push(new classDef(els[i], options));
                    }
                    instances = instancesArr;
                }
                
                return instances;
            }
        }]);
        
        return Component;
    }();
    
    ; // Required for Meteor package, the use of window prevents export by Meteor
    (function (window) {
        if (window.Package) {
            M = {};
        } else {
            window.M = {};
        }
        
        // Check for jQuery
        M.jQueryLoaded = !!window.jQuery;
    })(window);
    
    // AMD
    if (typeof define === "function" && define.amd) {
        define("M", [], function () {
            return M;
        });
        
        // Common JS
    } else if (typeof exports !== 'undefined' && !exports.nodeType) {
        if (typeof module !== 'undefined' && !module.nodeType && module.exports) {
            exports = module.exports = M;
        }
        exports.default = M;
    }
    
    M.keys = {
        TAB: 9,
        ENTER: 13,
        ESC: 27,
        ARROW_UP: 38,
        ARROW_DOWN: 40
    };
    
    /**
    * TabPress Keydown handler
    */
    M.tabPressed = false;
    var docHandleKeydown = function (e) {
        if (e.which === M.keys.TAB) {
            M.tabPressed = true;
        }
    };
    var docHandleKeyup = function (e) {
        if (e.which === M.keys.TAB) {
            M.tabPressed = false;
        }
    };
    document.addEventListener('keydown', docHandleKeydown);
    document.addEventListener('keyup', docHandleKeyup);
    
    /**
    * Initialize jQuery wrapper for plugin
    * @param {Class} plugin  javascript class
    * @param {string} pluginName  jQuery plugin name
    * @param {string} classRef  Class reference name
    */
    M.initializeJqueryWrapper = function (plugin, pluginName, classRef) {
        jQuery.fn[pluginName] = function (methodOrOptions) {
            // Call plugin method if valid method name is passed in
            if (plugin.prototype[methodOrOptions]) {
                var params = Array.prototype.slice.call(arguments, 1);
                
                // Getter methods
                if (methodOrOptions.slice(0, 3) === 'get') {
                    var instance = this.first()[0][classRef];
                    return instance[methodOrOptions].apply(instance, params);
                }
                
                // Void methods
                return this.each(function () {
                    var instance = this[classRef];
                    instance[methodOrOptions].apply(instance, params);
                });
                
                // Initialize plugin if options or no argument is passed in
            } else if (typeof methodOrOptions === 'object' || !methodOrOptions) {
                plugin.init(this, arguments[0]);
                return this;
            }
            
            // Return error if an unrecognized  method name is passed in
            jQuery.error("Method " + methodOrOptions + " does not exist on jQuery." + pluginName);
        };
    };
    
    /**
    * Automatically initialize components
    * @param {Element} context  DOM Element to search within for components
    */
    M.AutoInit = function (context) {
        // Use document.body if no context is given
        var root = !!context ? context : document.body;
        
        var registry = {
            Collapsible: root.querySelectorAll('.collapsible:not(.no-autoinit)'),
            Dropdown: root.querySelectorAll('.dropdown-trigger:not(.no-autoinit)'),
            Modal: root.querySelectorAll('.modal:not(.no-autoinit)'),
            Sidenav: root.querySelectorAll('.sidenav:not(.no-autoinit)'),
            Tooltip: root.querySelectorAll('.tooltipped:not(.no-autoinit)'),
        };
        
        for (var pluginName in registry) {
            var plugin = M[pluginName];
            plugin.init(registry[pluginName]);
        }
    };
    
    /**
    * Generate approximated selector string for a jQuery object
    * @param {jQuery} obj  jQuery object to be parsed
    * @returns {string}
    */
    M.objectSelectorString = function (obj) {
        var tagStr = obj.prop('tagName') || '';
        var idStr = obj.attr('id') || '';
        var classStr = obj.attr('class') || '';
        return (tagStr + idStr + classStr).replace(/\s/g, '');
    };
    
    // Unique Random ID
    M.guid = function () {
        function s4() {
            return Math.floor((1 + Math.random()) * 0x10000).toString(16).substring(1);
        }
        return function () {
            return s4() + s4() + '-' + s4() + '-' + s4() + '-' + s4() + '-' + s4() + s4() + s4();
        };
    }();
    
    /**
    * Escapes hash from special characters
    * @param {string} hash  String returned from this.hash
    * @returns {string}
    */
    M.escapeHash = function (hash) {
        return hash.replace(/(:|\.|\[|\]|,|=|\/)/g, "\\$1");
    };
    
    M.elementOrParentIsFixed = function (element) {
        var $element = $(element);
        var $checkElements = $element.add($element.parents());
        var isFixed = false;
        $checkElements.each(function () {
            if ($(this).css("position") === "fixed") {
                isFixed = true;
                return false;
            }
        });
        return isFixed;
    };
    
    /**
    * @typedef {Object} Edges
    * @property {Boolean} top  If the top edge was exceeded
    * @property {Boolean} right  If the right edge was exceeded
    * @property {Boolean} bottom  If the bottom edge was exceeded
    * @property {Boolean} left  If the left edge was exceeded
    */
    
    /**
    * @typedef {Object} Bounding
    * @property {Number} left  left offset coordinate
    * @property {Number} top  top offset coordinate
    * @property {Number} width
    * @property {Number} height
    */
    
    /**
    * Escapes hash from special characters
    * @param {Element} container  Container element that acts as the boundary
    * @param {Bounding} bounding  element bounding that is being checked
    * @param {Number} offset  offset from edge that counts as exceeding
    * @returns {Edges}
    */
    M.checkWithinContainer = function (container, bounding, offset) {
        var edges = {
            top: false,
            right: false,
            bottom: false,
            left: false
        };
        
        var containerRect = container.getBoundingClientRect();
        
        var scrollLeft = container.scrollLeft;
        var scrollTop = container.scrollTop;
        
        var scrolledX = bounding.left - scrollLeft;
        var scrolledY = bounding.top - scrollTop;
        
        // Check for container and viewport for each edge
        if (scrolledX < containerRect.left + offset || scrolledX < offset) {
            edges.left = true;
        }
        
        if (scrolledX + bounding.width > containerRect.right - offset || scrolledX + bounding.width > window.innerWidth - offset) {
            edges.right = true;
        }
        
        if (scrolledY < containerRect.top + offset || scrolledY < offset) {
            edges.top = true;
        }
        
        if (scrolledY + bounding.height > containerRect.bottom - offset || scrolledY + bounding.height > window.innerHeight - offset) {
            edges.bottom = true;
        }
        
        return edges;
    };
    
    M.checkPossibleAlignments = function (el, container, bounding, offset) {
        var canAlign = {
            top: true,
            right: true,
            bottom: true,
            left: true,
            spaceOnTop: null,
            spaceOnRight: null,
            spaceOnBottom: null,
            spaceOnLeft: null
        };
        
        var containerAllowsOverflow = getComputedStyle(container).overflow === 'visible';
        var containerRect = container.getBoundingClientRect();
        var containerHeight = Math.min(containerRect.height, window.innerHeight);
        var containerWidth = Math.min(containerRect.width, window.innerWidth);
        var elOffsetRect = el.getBoundingClientRect();
        
        var scrollLeft = container.scrollLeft;
        var scrollTop = container.scrollTop;
        
        var scrolledX = bounding.left - scrollLeft;
        var scrolledYTopEdge = bounding.top - scrollTop;
        var scrolledYBottomEdge = bounding.top + elOffsetRect.height - scrollTop;
        
        // Check for container and viewport for left
        canAlign.spaceOnRight = !containerAllowsOverflow ? containerWidth - (scrolledX + bounding.width) : window.innerWidth - (elOffsetRect.left + bounding.width);
        if (canAlign.spaceOnRight < 0) {
            canAlign.left = false;
        }
        
        // Check for container and viewport for Right
        canAlign.spaceOnLeft = !containerAllowsOverflow ? scrolledX - bounding.width + elOffsetRect.width : elOffsetRect.right - bounding.width;
        if (canAlign.spaceOnLeft < 0) {
            canAlign.right = false;
        }
        
        // Check for container and viewport for Top
        canAlign.spaceOnBottom = !containerAllowsOverflow ? containerHeight - (scrolledYTopEdge + bounding.height + offset) : window.innerHeight - (elOffsetRect.top + bounding.height + offset);
        if (canAlign.spaceOnBottom < 0) {
            canAlign.top = false;
        }
        
        // Check for container and viewport for Bottom
        canAlign.spaceOnTop = !containerAllowsOverflow ? scrolledYBottomEdge - (bounding.height - offset) : elOffsetRect.bottom - (bounding.height + offset);
        if (canAlign.spaceOnTop < 0) {
            canAlign.bottom = false;
        }
        
        return canAlign;
    };
    
    M.getOverflowParent = function (element) {
        if (element == null) {
            return null;
        }
        
        if (element === document.body || getComputedStyle(element).overflow !== 'visible') {
            return element;
        }
        
        return M.getOverflowParent(element.parentElement);
    };
    
    /**
    * Gets id of component from a trigger
    * @param {Element} trigger  trigger
    * @returns {string}
    */
    M.getIdFromTrigger = function (trigger) {
        var id = trigger.getAttribute('data-target');
        if (!id) {
            id = trigger.getAttribute('href');
            if (id) {
                id = id.slice(1);
            } else {
                id = "";
            }
        }
        return id;
    };
    
    /**
    * Multi browser support for document scroll top
    * @returns {Number}
    */
    M.getDocumentScrollTop = function () {
        return window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
    };
    
    /**
    * Multi browser support for document scroll left
    * @returns {Number}
    */
    M.getDocumentScrollLeft = function () {
        return window.pageXOffset || document.documentElement.scrollLeft || document.body.scrollLeft || 0;
    };
    
    /**
    * @typedef {Object} Edges
    * @property {Boolean} top  If the top edge was exceeded
    * @property {Boolean} right  If the right edge was exceeded
    * @property {Boolean} bottom  If the bottom edge was exceeded
    * @property {Boolean} left  If the left edge was exceeded
    */
    
    /**
    * @typedef {Object} Bounding
    * @property {Number} left  left offset coordinate
    * @property {Number} top  top offset coordinate
    * @property {Number} width
    * @property {Number} height
    */
    
    /**
    * Get time in ms
    * @license https://raw.github.com/jashkenas/underscore/master/LICENSE
    * @type {function}
    * @return {number}
    */
    var getTime = Date.now || function () {
        return new Date().getTime();
    };
    
    /**
    * Returns a function, that, when invoked, will only be triggered at most once
    * during a given window of time. Normally, the throttled function will run
    * as much as it can, without ever going more than once per `wait` duration;
    * but if you'd like to disable the execution on the leading edge, pass
    * `{leading: false}`. To disable execution on the trailing edge, ditto.
    * @license https://raw.github.com/jashkenas/underscore/master/LICENSE
    * @param {function} func
    * @param {number} wait
    * @param {Object=} options
    * @returns {Function}
    */
    M.throttle = function (func, wait, options) {
        var context = void 0,
        args = void 0,
        result = void 0;
        var timeout = null;
        var previous = 0;
        options || (options = {});
        var later = function () {
            previous = options.leading === false ? 0 : getTime();
            timeout = null;
            result = func.apply(context, args);
            context = args = null;
        };
        return function () {
            var now = getTime();
            if (!previous && options.leading === false) previous = now;
            var remaining = wait - (now - previous);
            context = this;
            args = arguments;
            if (remaining <= 0) {
                clearTimeout(timeout);
                timeout = null;
                previous = now;
                result = func.apply(context, args);
                context = args = null;
            } else if (!timeout && options.trailing !== false) {
                timeout = setTimeout(later, remaining);
            }
            return result;
        };
    };
    ; /*
    v2.2.0
    2017 Julian Garnier
    Released under the MIT license
    */
    var $jscomp = { scope: {} };$jscomp.defineProperty = "function" == typeof Object.defineProperties ? Object.defineProperty : function (e, r, p) {
        if (p.get || p.set) throw new TypeError("ES3 does not support getters and setters.");e != Array.prototype && e != Object.prototype && (e[r] = p.value);
    };$jscomp.getGlobal = function (e) {
        return "undefined" != typeof window && window === e ? e : "undefined" != typeof global && null != global ? global : e;
    };$jscomp.global = $jscomp.getGlobal(this);$jscomp.SYMBOL_PREFIX = "jscomp_symbol_";
    $jscomp.initSymbol = function () {
        $jscomp.initSymbol = function () {};$jscomp.global.Symbol || ($jscomp.global.Symbol = $jscomp.Symbol);
    };$jscomp.symbolCounter_ = 0;$jscomp.Symbol = function (e) {
        return $jscomp.SYMBOL_PREFIX + (e || "") + $jscomp.symbolCounter_++;
    };
    $jscomp.initSymbolIterator = function () {
        $jscomp.initSymbol();var e = $jscomp.global.Symbol.iterator;e || (e = $jscomp.global.Symbol.iterator = $jscomp.global.Symbol("iterator"));"function" != typeof Array.prototype[e] && $jscomp.defineProperty(Array.prototype, e, { configurable: !0, writable: !0, value: function () {
            return $jscomp.arrayIterator(this);
        } });$jscomp.initSymbolIterator = function () {};
    };$jscomp.arrayIterator = function (e) {
        var r = 0;return $jscomp.iteratorPrototype(function () {
            return r < e.length ? { done: !1, value: e[r++] } : { done: !0 };
        });
    };
    $jscomp.iteratorPrototype = function (e) {
        $jscomp.initSymbolIterator();e = { next: e };e[$jscomp.global.Symbol.iterator] = function () {
            return this;
        };return e;
    };$jscomp.array = $jscomp.array || {};$jscomp.iteratorFromArray = function (e, r) {
        $jscomp.initSymbolIterator();e instanceof String && (e += "");var p = 0,
        m = { next: function () {
            if (p < e.length) {
                var u = p++;return { value: r(u, e[u]), done: !1 };
            }m.next = function () {
                return { done: !0, value: void 0 };
            };return m.next();
        } };m[Symbol.iterator] = function () {
            return m;
        };return m;
    };
    $jscomp.polyfill = function (e, r, p, m) {
        if (r) {
            p = $jscomp.global;e = e.split(".");for (m = 0; m < e.length - 1; m++) {
                var u = e[m];u in p || (p[u] = {});p = p[u];
            }e = e[e.length - 1];m = p[e];r = r(m);r != m && null != r && $jscomp.defineProperty(p, e, { configurable: !0, writable: !0, value: r });
        }
    };$jscomp.polyfill("Array.prototype.keys", function (e) {
        return e ? e : function () {
            return $jscomp.iteratorFromArray(this, function (e) {
                return e;
            });
        };
    }, "es6-impl", "es3");var $jscomp$this = this;
    (function (r) {
        M.anime = r();
    })(function () {
        function e(a) {
            if (!h.col(a)) try {
                return document.querySelectorAll(a);
            } catch (c) {}
        }function r(a, c) {
            for (var d = a.length, b = 2 <= arguments.length ? arguments[1] : void 0, f = [], n = 0; n < d; n++) {
                if (n in a) {
                    var k = a[n];c.call(b, k, n, a) && f.push(k);
                }
            }return f;
        }function p(a) {
            return a.reduce(function (a, d) {
                return a.concat(h.arr(d) ? p(d) : d);
            }, []);
        }function m(a) {
            if (h.arr(a)) return a;
            h.str(a) && (a = e(a) || a);return a instanceof NodeList || a instanceof HTMLCollection ? [].slice.call(a) : [a];
        }function u(a, c) {
            return a.some(function (a) {
                return a === c;
            });
        }function C(a) {
            var c = {},
            d;for (d in a) {
                c[d] = a[d];
            }return c;
        }function D(a, c) {
            var d = C(a),
            b;for (b in a) {
                d[b] = c.hasOwnProperty(b) ? c[b] : a[b];
            }return d;
        }function z(a, c) {
            var d = C(a),
            b;for (b in c) {
                d[b] = h.und(a[b]) ? c[b] : a[b];
            }return d;
        }function T(a) {
            a = a.replace(/^#?([a-f\d])([a-f\d])([a-f\d])$/i, function (a, c, d, k) {
                return c + c + d + d + k + k;
            });var c = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(a);
            a = parseInt(c[1], 16);var d = parseInt(c[2], 16),
            c = parseInt(c[3], 16);return "rgba(" + a + "," + d + "," + c + ",1)";
        }function U(a) {
            function c(a, c, b) {
                0 > b && (b += 1);1 < b && --b;return b < 1 / 6 ? a + 6 * (c - a) * b : .5 > b ? c : b < 2 / 3 ? a + (c - a) * (2 / 3 - b) * 6 : a;
            }var d = /hsl\((\d+),\s*([\d.]+)%,\s*([\d.]+)%\)/g.exec(a) || /hsla\((\d+),\s*([\d.]+)%,\s*([\d.]+)%,\s*([\d.]+)\)/g.exec(a);a = parseInt(d[1]) / 360;var b = parseInt(d[2]) / 100,
            f = parseInt(d[3]) / 100,
            d = d[4] || 1;if (0 == b) f = b = a = f;else {
                var n = .5 > f ? f * (1 + b) : f + b - f * b,
                k = 2 * f - n,
                f = c(k, n, a + 1 / 3),
                b = c(k, n, a);a = c(k, n, a - 1 / 3);
            }return "rgba(" + 255 * f + "," + 255 * b + "," + 255 * a + "," + d + ")";
        }function y(a) {
            if (a = /([\+\-]?[0-9#\.]+)(%|px|pt|em|rem|in|cm|mm|ex|ch|pc|vw|vh|vmin|vmax|deg|rad|turn)?$/.exec(a)) return a[2];
        }function V(a) {
            if (-1 < a.indexOf("translate") || "perspective" === a) return "px";if (-1 < a.indexOf("rotate") || -1 < a.indexOf("skew")) return "deg";
        }function I(a, c) {
            return h.fnc(a) ? a(c.target, c.id, c.total) : a;
        }function E(a, c) {
            if (c in a.style) return getComputedStyle(a).getPropertyValue(c.replace(/([a-z])([A-Z])/g, "$1-$2").toLowerCase()) || "0";
        }function J(a, c) {
            if (h.dom(a) && u(W, c)) return "transform";if (h.dom(a) && (a.getAttribute(c) || h.svg(a) && a[c])) return "attribute";if (h.dom(a) && "transform" !== c && E(a, c)) return "css";if (null != a[c]) return "object";
        }function X(a, c) {
            var d = V(c),
            d = -1 < c.indexOf("scale") ? 1 : 0 + d;a = a.style.transform;if (!a) return d;for (var b = [], f = [], n = [], k = /(\w+)\((.+?)\)/g; b = k.exec(a);) {
                f.push(b[1]), n.push(b[2]);
            }a = r(n, function (a, b) {
                return f[b] === c;
            });return a.length ? a[0] : d;
        }function K(a, c) {
            switch (J(a, c)) {case "transform":
            return X(a, c);case "css":
            return E(a, c);case "attribute":
            return a.getAttribute(c);}return a[c] || 0;
        }function L(a, c) {
            var d = /^(\*=|\+=|-=)/.exec(a);if (!d) return a;var b = y(a) || 0;c = parseFloat(c);a = parseFloat(a.replace(d[0], ""));switch (d[0][0]) {case "+":
            return c + a + b;case "-":
            return c - a + b;case "*":
            return c * a + b;}
        }function F(a, c) {
            return Math.sqrt(Math.pow(c.x - a.x, 2) + Math.pow(c.y - a.y, 2));
        }function M(a) {
            a = a.points;for (var c = 0, d, b = 0; b < a.numberOfItems; b++) {
                var f = a.getItem(b);0 < b && (c += F(d, f));d = f;
            }return c;
        }function N(a) {
            if (a.getTotalLength) return a.getTotalLength();switch (a.tagName.toLowerCase()) {case "circle":
            return 2 * Math.PI * a.getAttribute("r");case "rect":
            return 2 * a.getAttribute("width") + 2 * a.getAttribute("height");case "line":
            return F({ x: a.getAttribute("x1"), y: a.getAttribute("y1") }, { x: a.getAttribute("x2"), y: a.getAttribute("y2") });case "polyline":
            return M(a);case "polygon":
            var c = a.points;return M(a) + F(c.getItem(c.numberOfItems - 1), c.getItem(0));}
        }function Y(a, c) {
            function d(b) {
                b = void 0 === b ? 0 : b;return a.el.getPointAtLength(1 <= c + b ? c + b : 0);
            }var b = d(),
            f = d(-1),
            n = d(1);switch (a.property) {case "x":
            return b.x;case "y":
            return b.y;
            case "angle":
            return 180 * Math.atan2(n.y - f.y, n.x - f.x) / Math.PI;}
        }function O(a, c) {
            var d = /-?\d*\.?\d+/g,
            b;b = h.pth(a) ? a.totalLength : a;if (h.col(b)) {
                if (h.rgb(b)) {
                    var f = /rgb\((\d+,\s*[\d]+,\s*[\d]+)\)/g.exec(b);b = f ? "rgba(" + f[1] + ",1)" : b;
                } else b = h.hex(b) ? T(b) : h.hsl(b) ? U(b) : void 0;
            } else f = (f = y(b)) ? b.substr(0, b.length - f.length) : b, b = c && !/\s/g.test(b) ? f + c : f;b += "";return { original: b, numbers: b.match(d) ? b.match(d).map(Number) : [0], strings: h.str(a) || c ? b.split(d) : [] };
        }function P(a) {
            a = a ? p(h.arr(a) ? a.map(m) : m(a)) : [];return r(a, function (a, d, b) {
                return b.indexOf(a) === d;
            });
        }function Z(a) {
            var c = P(a);return c.map(function (a, b) {
                return { target: a, id: b, total: c.length };
            });
        }function aa(a, c) {
            var d = C(c);if (h.arr(a)) {
                var b = a.length;2 !== b || h.obj(a[0]) ? h.fnc(c.duration) || (d.duration = c.duration / b) : a = { value: a };
            }return m(a).map(function (a, b) {
                b = b ? 0 : c.delay;a = h.obj(a) && !h.pth(a) ? a : { value: a };h.und(a.delay) && (a.delay = b);return a;
            }).map(function (a) {
                return z(a, d);
            });
        }function ba(a, c) {
            var d = {},
            b;for (b in a) {
                var f = I(a[b], c);h.arr(f) && (f = f.map(function (a) {
                    return I(a, c);
                }), 1 === f.length && (f = f[0]));d[b] = f;
            }d.duration = parseFloat(d.duration);d.delay = parseFloat(d.delay);return d;
        }function ca(a) {
            return h.arr(a) ? A.apply(this, a) : Q[a];
        }function da(a, c) {
            var d;return a.tweens.map(function (b) {
                b = ba(b, c);var f = b.value,
                e = K(c.target, a.name),
                k = d ? d.to.original : e,
                k = h.arr(f) ? f[0] : k,
                w = L(h.arr(f) ? f[1] : f, k),
                e = y(w) || y(k) || y(e);b.from = O(k, e);b.to = O(w, e);b.start = d ? d.end : a.offset;b.end = b.start + b.delay + b.duration;b.easing = ca(b.easing);b.elasticity = (1E3 - Math.min(Math.max(b.elasticity, 1), 999)) / 1E3;b.isPath = h.pth(f);b.isColor = h.col(b.from.original);b.isColor && (b.round = 1);return d = b;
            });
        }function ea(a, c) {
            return r(p(a.map(function (a) {
                return c.map(function (b) {
                    var c = J(a.target, b.name);if (c) {
                        var d = da(b, a);b = { type: c, property: b.name, animatable: a, tweens: d, duration: d[d.length - 1].end, delay: d[0].delay };
                    } else b = void 0;return b;
                });
            })), function (a) {
                return !h.und(a);
            });
        }function R(a, c, d, b) {
            var f = "delay" === a;return c.length ? (f ? Math.min : Math.max).apply(Math, c.map(function (b) {
                return b[a];
            })) : f ? b.delay : d.offset + b.delay + b.duration;
        }function fa(a) {
            var c = D(ga, a),
            d = D(S, a),
            b = Z(a.targets),
            f = [],
            e = z(c, d),
            k;for (k in a) {
                e.hasOwnProperty(k) || "targets" === k || f.push({ name: k, offset: e.offset, tweens: aa(a[k], d) });
            }a = ea(b, f);return z(c, { children: [], animatables: b, animations: a, duration: R("duration", a, c, d), delay: R("delay", a, c, d) });
        }function q(a) {
            function c() {
                return window.Promise && new Promise(function (a) {
                    return p = a;
                });
            }function d(a) {
                return g.reversed ? g.duration - a : a;
            }function b(a) {
                for (var b = 0, c = {}, d = g.animations, f = d.length; b < f;) {
                    var e = d[b],
                    k = e.animatable,
                    h = e.tweens,
                    n = h.length - 1,
                    l = h[n];n && (l = r(h, function (b) {
                        return a < b.end;
                    })[0] || l);for (var h = Math.min(Math.max(a - l.start - l.delay, 0), l.duration) / l.duration, w = isNaN(h) ? 1 : l.easing(h, l.elasticity), h = l.to.strings, p = l.round, n = [], m = void 0, m = l.to.numbers.length, t = 0; t < m; t++) {
                        var x = void 0,
                        x = l.to.numbers[t],
                        q = l.from.numbers[t],
                        x = l.isPath ? Y(l.value, w * x) : q + w * (x - q);p && (l.isColor && 2 < t || (x = Math.round(x * p) / p));n.push(x);
                    }if (l = h.length) for (m = h[0], w = 0; w < l; w++) {
                        p = h[w + 1], t = n[w], isNaN(t) || (m = p ? m + (t + p) : m + (t + " "));
                    } else m = n[0];ha[e.type](k.target, e.property, m, c, k.id);e.currentValue = m;b++;
                }if (b = Object.keys(c).length) for (d = 0; d < b; d++) {
                    H || (H = E(document.body, "transform") ? "transform" : "-webkit-transform"), g.animatables[d].target.style[H] = c[d].join(" ");
                }g.currentTime = a;g.progress = a / g.duration * 100;
            }function f(a) {
                if (g[a]) g[a](g);
            }function e() {
                g.remaining && !0 !== g.remaining && g.remaining--;
            }function k(a) {
                var k = g.duration,
                n = g.offset,
                w = n + g.delay,
                r = g.currentTime,
                x = g.reversed,
                q = d(a);if (g.children.length) {
                    var u = g.children,
                    v = u.length;
                    if (q >= g.currentTime) for (var G = 0; G < v; G++) {
                        u[G].seek(q);
                    } else for (; v--;) {
                        u[v].seek(q);
                    }
                }if (q >= w || !k) g.began || (g.began = !0, f("begin")), f("run");if (q > n && q < k) b(q);else if (q <= n && 0 !== r && (b(0), x && e()), q >= k && r !== k || !k) b(k), x || e();f("update");a >= k && (g.remaining ? (t = h, "alternate" === g.direction && (g.reversed = !g.reversed)) : (g.pause(), g.completed || (g.completed = !0, f("complete"), "Promise" in window && (p(), m = c()))), l = 0);
            }a = void 0 === a ? {} : a;var h,
            t,
            l = 0,
            p = null,
            m = c(),
            g = fa(a);g.reset = function () {
                var a = g.direction,
                c = g.loop;g.currentTime = 0;g.progress = 0;g.paused = !0;g.began = !1;g.completed = !1;g.reversed = "reverse" === a;g.remaining = "alternate" === a && 1 === c ? 2 : c;b(0);for (a = g.children.length; a--;) {
                    g.children[a].reset();
                }
            };g.tick = function (a) {
                h = a;t || (t = h);k((l + h - t) * q.speed);
            };g.seek = function (a) {
                k(d(a));
            };g.pause = function () {
                var a = v.indexOf(g);-1 < a && v.splice(a, 1);g.paused = !0;
            };g.play = function () {
                g.paused && (g.paused = !1, t = 0, l = d(g.currentTime), v.push(g), B || ia());
            };g.reverse = function () {
                g.reversed = !g.reversed;t = 0;l = d(g.currentTime);
            };g.restart = function () {
                g.pause();
                g.reset();g.play();
            };g.finished = m;g.reset();g.autoplay && g.play();return g;
        }var ga = { update: void 0, begin: void 0, run: void 0, complete: void 0, loop: 1, direction: "normal", autoplay: !0, offset: 0 },
        S = { duration: 1E3, delay: 0, easing: "easeOutElastic", elasticity: 500, round: 0 },
        W = "translateX translateY translateZ rotate rotateX rotateY rotateZ scale scaleX scaleY scaleZ skewX skewY perspective".split(" "),
        H,
        h = { arr: function (a) {
            return Array.isArray(a);
        }, obj: function (a) {
            return -1 < Object.prototype.toString.call(a).indexOf("Object");
        },
        pth: function (a) {
            return h.obj(a) && a.hasOwnProperty("totalLength");
        }, svg: function (a) {
            return a instanceof SVGElement;
        }, dom: function (a) {
            return a.nodeType || h.svg(a);
        }, str: function (a) {
            return "string" === typeof a;
        }, fnc: function (a) {
            return "function" === typeof a;
        }, und: function (a) {
            return "undefined" === typeof a;
        }, hex: function (a) {
            return (/(^#[0-9A-F]{6}$)|(^#[0-9A-F]{3}$)/i.test(a)
        );
    }, rgb: function (a) {
        return (/^rgb/.test(a)
    );
}, hsl: function (a) {
    return (/^hsl/.test(a)
);
}, col: function (a) {
    return h.hex(a) || h.rgb(a) || h.hsl(a);
} },
A = function () {
    function a(a, d, b) {
        return (((1 - 3 * b + 3 * d) * a + (3 * b - 6 * d)) * a + 3 * d) * a;
    }return function (c, d, b, f) {
        if (0 <= c && 1 >= c && 0 <= b && 1 >= b) {
            var e = new Float32Array(11);if (c !== d || b !== f) for (var k = 0; 11 > k; ++k) {
                e[k] = a(.1 * k, c, b);
            }return function (k) {
                if (c === d && b === f) return k;if (0 === k) return 0;if (1 === k) return 1;for (var h = 0, l = 1; 10 !== l && e[l] <= k; ++l) {
                    h += .1;
                }--l;var l = h + (k - e[l]) / (e[l + 1] - e[l]) * .1,
                n = 3 * (1 - 3 * b + 3 * c) * l * l + 2 * (3 * b - 6 * c) * l + 3 * c;if (.001 <= n) {
                    for (h = 0; 4 > h; ++h) {
                        n = 3 * (1 - 3 * b + 3 * c) * l * l + 2 * (3 * b - 6 * c) * l + 3 * c;if (0 === n) break;var m = a(l, c, b) - k,
                        l = l - m / n;
                    }k = l;
                } else if (0 === n) k = l;else {
                    var l = h,
                    h = h + .1,
                    g = 0;do {
                        m = l + (h - l) / 2, n = a(m, c, b) - k, 0 < n ? h = m : l = m;
                    } while (1e-7 < Math.abs(n) && 10 > ++g);k = m;
                }return a(k, d, f);
            };
        }
    };
}(),
Q = function () {
    function a(a, b) {
        return 0 === a || 1 === a ? a : -Math.pow(2, 10 * (a - 1)) * Math.sin(2 * (a - 1 - b / (2 * Math.PI) * Math.asin(1)) * Math.PI / b);
    }var c = "Quad Cubic Quart Quint Sine Expo Circ Back Elastic".split(" "),
    d = { In: [[.55, .085, .68, .53], [.55, .055, .675, .19], [.895, .03, .685, .22], [.755, .05, .855, .06], [.47, 0, .745, .715], [.95, .05, .795, .035], [.6, .04, .98, .335], [.6, -.28, .735, .045], a], Out: [[.25, .46, .45, .94], [.215, .61, .355, 1], [.165, .84, .44, 1], [.23, 1, .32, 1], [.39, .575, .565, 1], [.19, 1, .22, 1], [.075, .82, .165, 1], [.175, .885, .32, 1.275], function (b, c) {
        return 1 - a(1 - b, c);
    }], InOut: [[.455, .03, .515, .955], [.645, .045, .355, 1], [.77, 0, .175, 1], [.86, 0, .07, 1], [.445, .05, .55, .95], [1, 0, 0, 1], [.785, .135, .15, .86], [.68, -.55, .265, 1.55], function (b, c) {
        return .5 > b ? a(2 * b, c) / 2 : 1 - a(-2 * b + 2, c) / 2;
    }] },
    b = { linear: A(.25, .25, .75, .75) },
    f = {},
    e;for (e in d) {
        f.type = e, d[f.type].forEach(function (a) {
            return function (d, f) {
                b["ease" + a.type + c[f]] = h.fnc(d) ? d : A.apply($jscomp$this, d);
            };
        }(f)), f = { type: f.type };
    }return b;
}(),
ha = { css: function (a, c, d) {
    return a.style[c] = d;
}, attribute: function (a, c, d) {
    return a.setAttribute(c, d);
}, object: function (a, c, d) {
    return a[c] = d;
}, transform: function (a, c, d, b, f) {
    b[f] || (b[f] = []);b[f].push(c + "(" + d + ")");
} },
v = [],
B = 0,
ia = function () {
    function a() {
        B = requestAnimationFrame(c);
    }function c(c) {
        var b = v.length;if (b) {
            for (var d = 0; d < b;) {
                v[d] && v[d].tick(c), d++;
            }a();
        } else cancelAnimationFrame(B), B = 0;
    }return a;
}();q.version = "2.2.0";q.speed = 1;q.running = v;q.remove = function (a) {
    a = P(a);for (var c = v.length; c--;) {
        for (var d = v[c], b = d.animations, f = b.length; f--;) {
            u(a, b[f].animatable.target) && (b.splice(f, 1), b.length || d.pause());
        }
    }
};q.getValue = K;q.path = function (a, c) {
    var d = h.str(a) ? e(a)[0] : a,
    b = c || 100;return function (a) {
        return { el: d, property: a, totalLength: N(d) * (b / 100) };
    };
};q.setDashoffset = function (a) {
    var c = N(a);a.setAttribute("stroke-dasharray", c);return c;
};q.bezier = A;q.easings = Q;q.timeline = function (a) {
    var c = q(a);c.pause();c.duration = 0;c.add = function (d) {
        c.children.forEach(function (a) {
            a.began = !0;a.completed = !0;
        });m(d).forEach(function (b) {
            var d = z(b, D(S, a || {}));d.targets = d.targets || a.targets;b = c.duration;var e = d.offset;d.autoplay = !1;d.direction = c.direction;d.offset = h.und(e) ? b : L(e, b);c.began = !0;c.completed = !0;c.seek(d.offset);d = q(d);d.began = !0;d.completed = !0;d.duration > b && (c.duration = d.duration);c.children.push(d);
        });c.seek(0);c.reset();c.autoplay && c.restart();return c;
    };return c;
};q.random = function (a, c) {
    return Math.floor(Math.random() * (c - a + 1)) + a;
};return q;
});
;(function ($, anim) {
    'use strict';
    
    var _defaults = {
        accordion: true,
        onOpenStart: undefined,
        onOpenEnd: undefined,
        onCloseStart: undefined,
        onCloseEnd: undefined,
        inDuration: 300,
        outDuration: 300
    };
    
    /**
    * @class
    *
    */
    
    var Collapsible = function (_Component) {
        _inherits(Collapsible, _Component);
        
        /**
        * Construct Collapsible instance
        * @constructor
        * @param {Element} el
        * @param {Object} options
        */
        function Collapsible(el, options) {
            _classCallCheck(this, Collapsible);
            
            var _this3 = _possibleConstructorReturn(this, (Collapsible.__proto__ || Object.getPrototypeOf(Collapsible)).call(this, Collapsible, el, options));
            
            _this3.el.M_Collapsible = _this3;
            
            /**
            * Options for the collapsible
            * @member Collapsible#options
            * @prop {Boolean} [accordion=false] - Type of the collapsible
            * @prop {Function} onOpenStart - Callback function called before collapsible is opened
            * @prop {Function} onOpenEnd - Callback function called after collapsible is opened
            * @prop {Function} onCloseStart - Callback function called before collapsible is closed
            * @prop {Function} onCloseEnd - Callback function called after collapsible is closed
            * @prop {Number} inDuration - Transition in duration in milliseconds.
            * @prop {Number} outDuration - Transition duration in milliseconds.
            */
            _this3.options = $.extend({}, Collapsible.defaults, options);
            
            // Setup tab indices
            _this3.$headers = _this3.$el.children('li').children('.collapsible-header');
            _this3.$headers.attr('tabindex', 0);
            
            _this3._setupEventHandlers();
            
            // Open first active
            var $activeBodies = _this3.$el.children('li.activated').children('.collapsible-body');
            if (_this3.options.accordion) {
                // Handle Accordion
                $activeBodies.first().css('display', 'block');
            } else {
                // Handle Expandables
                $activeBodies.css('display', 'block');
            }
            return _this3;
        }
        
        _createClass(Collapsible, [{
            key: "destroy",
            
            
            /**
            * Teardown component
            */
            value: function destroy() {
                this._removeEventHandlers();
                this.el.M_Collapsible = undefined;
            }
            
            /**
            * Setup Event Handlers
            */
            
        }, {
            key: "_setupEventHandlers",
            value: function _setupEventHandlers() {
                var _this4 = this;
                
                this._handleCollapsibleClickBound = this._handleCollapsibleClick.bind(this);
                this._handleCollapsibleKeydownBound = this._handleCollapsibleKeydown.bind(this);
                this.el.addEventListener('click', this._handleCollapsibleClickBound);
                this.$headers.each(function (header) {
                    header.addEventListener('keydown', _this4._handleCollapsibleKeydownBound);
                });
            }
            
            /**
            * Remove Event Handlers
            */
            
        }, {
            key: "_removeEventHandlers",
            value: function _removeEventHandlers() {
                this.el.removeEventListener('click', this._handleCollapsibleClickBound);
            }
            
            /**
            * Handle Collapsible Click
            * @param {Event} e
            */
            
        }, {
            key: "_handleCollapsibleClick",
            value: function _handleCollapsibleClick(e) {
                var $header = $(e.target).closest('.collapsible-header');
                if (e.target && $header.length) {
                    var $collapsible = $header.closest('.collapsible');
                    if ($collapsible[0] === this.el) {
                        var $collapsibleLi = $header.closest('li');
                        var $collapsibleLis = $collapsible.children('li');
                        var isActive = $collapsibleLi[0].classList.contains('activated');
                        var index = $collapsibleLis.index($collapsibleLi);
                        
                        if (isActive) {
                            this.close(index);
                        } else {
                            this.open(index);
                        }
                    }
                }
            }
            
            /**
            * Handle Collapsible Keydown
            * @param {Event} e
            */
            
        }, {
            key: "_handleCollapsibleKeydown",
            value: function _handleCollapsibleKeydown(e) {
                if (e.keyCode === 13) {
                    this._handleCollapsibleClickBound(e);
                }
            }
            
            /**
            * Animate in collapsible slide
            * @param {Number} index - 0th index of slide
            */
            
        }, {
            key: "_animateIn",
            value: function _animateIn(index) {
                var _this5 = this;
                
                var $collapsibleLi = this.$el.children('li').eq(index);
                if ($collapsibleLi.length) {
                    var $body = $collapsibleLi.children('.collapsible-body');
                    
                    anim.remove($body[0]);
                    $body.css({
                        display: 'block',
                        overflow: 'hidden',
                        height: 0,
                        paddingTop: '',
                        paddingBottom: ''
                    });
                    
                    var pTop = $body.css('padding-top');
                    var pBottom = $body.css('padding-bottom');
                    var finalHeight = $body[0].scrollHeight;
                    $body.css({
                        paddingTop: 0,
                        paddingBottom: 0
                    });
                    
                    anim({
                        targets: $body[0],
                        height: finalHeight,
                        paddingTop: pTop,
                        paddingBottom: pBottom,
                        duration: this.options.inDuration,
                        easing: 'easeInOutCubic',
                        complete: function (anim) {
                            $body.css({
                                overflow: '',
                                paddingTop: '',
                                paddingBottom: '',
                                height: ''
                            });
                            
                            // onOpenEnd callback
                            if (typeof _this5.options.onOpenEnd === 'function') {
                                _this5.options.onOpenEnd.call(_this5, $collapsibleLi[0]);
                            }
                        }
                    });
                }
            }
            
            /**
            * Animate out collapsible slide
            * @param {Number} index - 0th index of slide to open
            */
            
        }, {
            key: "_animateOut",
            value: function _animateOut(index) {
                var _this6 = this;
                
                var $collapsibleLi = this.$el.children('li').eq(index);
                if ($collapsibleLi.length) {
                    var $body = $collapsibleLi.children('.collapsible-body');
                    anim.remove($body[0]);
                    $body.css('overflow', 'hidden');
                    anim({
                        targets: $body[0],
                        height: 0,
                        paddingTop: 0,
                        paddingBottom: 0,
                        duration: this.options.outDuration,
                        easing: 'easeInOutCubic',
                        complete: function () {
                            $body.css({
                                height: '',
                                overflow: '',
                                padding: '',
                                display: ''
                            });
                            
                            // onCloseEnd callback
                            if (typeof _this6.options.onCloseEnd === 'function') {
                                _this6.options.onCloseEnd.call(_this6, $collapsibleLi[0]);
                            }
                        }
                    });
                }
            }
            
            /**
            * Open Collapsible
            * @param {Number} index - 0th index of slide
            */
            
        }, {
            key: "open",
            value: function open(index) {
                var _this7 = this;
                
                var $collapsibleLi = this.$el.children('li').eq(index);
                if ($collapsibleLi.length && !$collapsibleLi[0].classList.contains('activated')) {
                    
                    // onOpenStart callback
                    if (typeof this.options.onOpenStart === 'function') {
                        this.options.onOpenStart.call(this, $collapsibleLi[0]);
                    }
                    
                    // Handle accordion behavior
                    if (this.options.accordion) {
                        var $collapsibleLis = this.$el.children('li');
                        var $activeLis = this.$el.children('li.activated');
                        $activeLis.each(function (el) {
                            var index = $collapsibleLis.index($(el));
                            _this7.close(index);
                        });
                    }
                    
                    // Animate in
                    $collapsibleLi[0].classList.add('activated');
                    this._animateIn(index);
                }
            }
            
            /**
            * Close Collapsible
            * @param {Number} index - 0th index of slide
            */
            
        }, {
            key: "close",
            value: function close(index) {
                var $collapsibleLi = this.$el.children('li').eq(index);
                if ($collapsibleLi.length && $collapsibleLi[0].classList.contains('activated')) {
                    
                    // onCloseStart callback
                    if (typeof this.options.onCloseStart === 'function') {
                        this.options.onCloseStart.call(this, $collapsibleLi[0]);
                    }
                    
                    // Animate out
                    $collapsibleLi[0].classList.remove('activated');
                    this._animateOut(index);
                }
            }
        }], [{
            key: "init",
            value: function init(els, options) {
                return _get(Collapsible.__proto__ || Object.getPrototypeOf(Collapsible), "init", this).call(this, this, els, options);
            }
            
            /**
            * Get Instance
            */
            
        }, {
            key: "getInstance",
            value: function getInstance(el) {
                var domElem = !!el.jquery ? el[0] : el;
                return domElem.M_Collapsible;
            }
        }, {
            key: "defaults",
            get: function () {
                return _defaults;
            }
        }]);
        
        return Collapsible;
    }(Component);
    
    M.Collapsible = Collapsible;
    
    if (M.jQueryLoaded) {
        M.initializeJqueryWrapper(Collapsible, 'collapsible', 'M_Collapsible');
    }
})(cash, M.anime);
;(function ($, anim) {
    'use strict';
    
    var _defaults = {
        alignment: 'left',
        autoFocus: true,
        constrainWidth: true,
        container: null,
        coverTrigger: true,
        closeOnClick: true,
        hover: false,
        inDuration: 150,
        outDuration: 250,
        onOpenStart: null,
        onOpenEnd: null,
        onCloseStart: null,
        onCloseEnd: null
    };
    
    /**
    * @class
    */
    
    var Dropdown = function (_Component2) {
        _inherits(Dropdown, _Component2);
        
        function Dropdown(el, options) {
            _classCallCheck(this, Dropdown);
            
            var _this8 = _possibleConstructorReturn(this, (Dropdown.__proto__ || Object.getPrototypeOf(Dropdown)).call(this, Dropdown, el, options));
            
            _this8.el.M_Dropdown = _this8;
            Dropdown._dropdowns.push(_this8);
            
            _this8.id = M.getIdFromTrigger(el);
            _this8.dropdownEl = document.getElementById(_this8.id);
            _this8.$dropdownEl = $(_this8.dropdownEl);
            
            /**
            * Options for the dropdown
            * @member Dropdown#options
            * @prop {String} [alignment='left'] - Edge which the dropdown is aligned to
            * @prop {Boolean} [autoFocus=true] - Automatically focus dropdown el for keyboard
            * @prop {Boolean} [constrainWidth=true] - Constrain width to width of the button
            * @prop {Element} container - Container element to attach dropdown to (optional)
            * @prop {Boolean} [coverTrigger=true] - Place dropdown over trigger
            * @prop {Boolean} [closeOnClick=true] - Close on click of dropdown item
            * @prop {Boolean} [hover=false] - Open dropdown on hover
            * @prop {Number} [inDuration=150] - Duration of open animation in ms
            * @prop {Number} [outDuration=250] - Duration of close animation in ms
            * @prop {Function} onOpenStart - Function called when dropdown starts opening
            * @prop {Function} onOpenEnd - Function called when dropdown finishes opening
            * @prop {Function} onCloseStart - Function called when dropdown starts closing
            * @prop {Function} onCloseEnd - Function called when dropdown finishes closing
            */
            _this8.options = $.extend({}, Dropdown.defaults, options);
            
            /**
            * Describes open/close state of dropdown
            * @type {Boolean}
            */
            _this8.isOpen = false;
            
            /**
            * Describes if dropdown content is scrollable
            * @type {Boolean}
            */
            _this8.isScrollable = false;
            
            /**
            * Describes if touch moving on dropdown content
            * @type {Boolean}
            */
            _this8.isTouchMoving = false;
            
            _this8.focusedIndex = -1;
            _this8.filterQuery = [];
            
            // Move dropdown-content after dropdown-trigger
            if (!!_this8.options.container) {
                $(_this8.options.container).append(_this8.dropdownEl);
            } else {
                _this8.$el.after(_this8.dropdownEl);
            }
            
            _this8._makeDropdownFocusable();
            _this8._resetFilterQueryBound = _this8._resetFilterQuery.bind(_this8);
            _this8._handleDocumentClickBound = _this8._handleDocumentClick.bind(_this8);
            _this8._handleDocumentTouchmoveBound = _this8._handleDocumentTouchmove.bind(_this8);
            _this8._handleDropdownKeydownBound = _this8._handleDropdownKeydown.bind(_this8);
            _this8._handleTriggerKeydownBound = _this8._handleTriggerKeydown.bind(_this8);
            _this8._setupEventHandlers();
            return _this8;
        }
        
        _createClass(Dropdown, [{
            key: "destroy",
            
            
            /**
            * Teardown component
            */
            value: function destroy() {
                this._resetDropdownStyles();
                this._removeEventHandlers();
                Dropdown._dropdowns.splice(Dropdown._dropdowns.indexOf(this), 1);
                this.el.M_Dropdown = undefined;
            }
            
            /**
            * Setup Event Handlers
            */
            
        }, {
            key: "_setupEventHandlers",
            value: function _setupEventHandlers() {
                // Trigger keydown handler
                this.el.addEventListener('keydown', this._handleTriggerKeydownBound);
                
                // Hover event handlers
                if (this.options.hover) {
                    this._handleMouseEnterBound = this._handleMouseEnter.bind(this);
                    this.el.addEventListener('mouseenter', this._handleMouseEnterBound);
                    this._handleMouseLeaveBound = this._handleMouseLeave.bind(this);
                    this.el.addEventListener('mouseleave', this._handleMouseLeaveBound);
                    this.dropdownEl.addEventListener('mouseleave', this._handleMouseLeaveBound);
                    
                    // Click event handlers
                } else {
                    this._handleClickBound = this._handleClick.bind(this);
                    this.el.addEventListener('click', this._handleClickBound);
                }
            }
            
            /**
            * Remove Event Handlers
            */
            
        }, {
            key: "_removeEventHandlers",
            value: function _removeEventHandlers() {
                // Trigger keydown handler
                this.el.removeEventListener('keydown', this._handleTriggerKeydownBound);
                
                if (this.options.hover) {
                    this.el.removeEventHandlers('mouseenter', this._handleMouseEnterBound);
                    this.el.removeEventHandlers('mouseleave', this._handleMouseLeaveBound);
                    this.dropdownEl.removeEventHandlers('mouseleave', this._handleMouseLeaveBound);
                } else {
                    this.el.removeEventListener('click', this._handleClickBound);
                }
            }
        }, {
            key: "_setupTemporaryEventHandlers",
            value: function _setupTemporaryEventHandlers() {
                // Use capture phase event handler to prevent click
                document.body.addEventListener('click', this._handleDocumentClickBound, true);
                document.body.addEventListener('touchend', this._handleDocumentClickBound);
                document.body.addEventListener('touchmove', this._handleDocumentTouchmoveBound);
                this.dropdownEl.addEventListener('keydown', this._handleDropdownKeydownBound);
            }
        }, {
            key: "_removeTemporaryEventHandlers",
            value: function _removeTemporaryEventHandlers() {
                // Use capture phase event handler to prevent click
                document.body.removeEventListener('click', this._handleDocumentClickBound, true);
                document.body.removeEventListener('touchend', this._handleDocumentClickBound);
                document.body.removeEventListener('touchmove', this._handleDocumentTouchmoveBound);
                this.dropdownEl.removeEventListener('keydown', this._handleDropdownKeydownBound);
            }
        }, {
            key: "_handleClick",
            value: function _handleClick(e) {
                e.preventDefault();
                this.open();
            }
        }, {
            key: "_handleMouseEnter",
            value: function _handleMouseEnter() {
                this.open();
            }
        }, {
            key: "_handleMouseLeave",
            value: function _handleMouseLeave(e) {
                var toEl = e.toElement || e.relatedTarget;
                var leaveToDropdownContent = !!$(toEl).closest('.dropdown-content').length;
                var leaveToActiveDropdownTrigger = false;
                
                var $closestTrigger = $(toEl).closest('.dropdown-trigger');
                if ($closestTrigger.length && !!$closestTrigger[0].M_Dropdown && $closestTrigger[0].M_Dropdown.isOpen) {
                    leaveToActiveDropdownTrigger = true;
                }
                
                // Close hover dropdown if mouse did not leave to either active dropdown-trigger or dropdown-content
                if (!leaveToActiveDropdownTrigger && !leaveToDropdownContent) {
                    this.close();
                }
            }
        }, {
            key: "_handleDocumentClick",
            value: function _handleDocumentClick(e) {
                var _this9 = this;
                
                var $target = $(e.target);
                if (this.options.closeOnClick && $target.closest('.dropdown-content').length && !this.isTouchMoving) {
                    // isTouchMoving to check if scrolling on mobile.
                    setTimeout(function () {
                        _this9.close();
                    }, 0);
                } else if ($target.closest('.dropdown-trigger').length || !$target.closest('.dropdown-content').length) {
                    setTimeout(function () {
                        _this9.close();
                    }, 0);
                }
                this.isTouchMoving = false;
            }
        }, {
            key: "_handleTriggerKeydown",
            value: function _handleTriggerKeydown(e) {
                // ARROW DOWN OR ENTER WHEN SELECT IS CLOSED - open Dropdown
                if ((e.which === M.keys.ARROW_DOWN || e.which === M.keys.ENTER) && !this.isOpen) {
                    e.preventDefault();
                    this.open();
                }
            }
            
            /**
            * Handle Document Touchmove
            * @param {Event} e
            */
            
        }, {
            key: "_handleDocumentTouchmove",
            value: function _handleDocumentTouchmove(e) {
                var $target = $(e.target);
                if ($target.closest('.dropdown-content').length) {
                    this.isTouchMoving = true;
                }
            }
            
            /**
            * Handle Dropdown Keydown
            * @param {Event} e
            */
            
        }, {
            key: "_handleDropdownKeydown",
            value: function _handleDropdownKeydown(e) {
                if (e.which === M.keys.TAB) {
                    e.preventDefault();
                    this.close();
                    
                    // Navigate down dropdown list
                } else if ((e.which === M.keys.ARROW_DOWN || e.which === M.keys.ARROW_UP) && this.isOpen) {
                    e.preventDefault();
                    var direction = e.which === M.keys.ARROW_DOWN ? 1 : -1;
                    var newFocusedIndex = this.focusedIndex;
                    var foundNewIndex = false;
                    do {
                        newFocusedIndex = newFocusedIndex + direction;
                        
                        if (!!this.dropdownEl.children[newFocusedIndex] && this.dropdownEl.children[newFocusedIndex].tabIndex !== -1) {
                            foundNewIndex = true;
                            break;
                        }
                    } while (newFocusedIndex < this.dropdownEl.children.length && newFocusedIndex >= 0);
                    
                    if (foundNewIndex) {
                        this.focusedIndex = newFocusedIndex;
                        this._focusFocusedItem();
                    }
                    
                    // ENTER selects choice on focused item
                } else if (e.which === M.keys.ENTER && this.isOpen) {
                    // Search for <a> and <button>
                    var focusedElement = this.dropdownEl.children[this.focusedIndex];
                    var $activatableElement = $(focusedElement).find('a, button').first();
                    
                    // Click a or button tag if exists, otherwise click li tag
                    !!$activatableElement.length ? $activatableElement[0].click() : focusedElement.click();
                    
                    // Close dropdown on ESC
                } else if (e.which === M.keys.ESC && this.isOpen) {
                    e.preventDefault();
                    this.close();
                }
                
                // CASE WHEN USER TYPE LETTERS
                var letter = String.fromCharCode(e.which).toLowerCase(),
                nonLetters = [9, 13, 27, 38, 40];
                if (letter && nonLetters.indexOf(e.which) === -1) {
                    this.filterQuery.push(letter);
                    
                    var string = this.filterQuery.join(''),
                    newOptionEl = $(this.dropdownEl).find('li').filter(function (el) {
                        return $(el).text().toLowerCase().indexOf(string) === 0;
                    })[0];
                    
                    if (newOptionEl) {
                        this.focusedIndex = $(newOptionEl).index();
                        this._focusFocusedItem();
                    }
                }
                
                this.filterTimeout = setTimeout(this._resetFilterQueryBound, 1000);
            }
            
            /**
            * Setup dropdown
            */
            
        }, {
            key: "_resetFilterQuery",
            value: function _resetFilterQuery() {
                this.filterQuery = [];
            }
        }, {
            key: "_resetDropdownStyles",
            value: function _resetDropdownStyles() {
                this.$dropdownEl.css({
                    display: '',
                    width: '',
                    height: '',
                    left: '',
                    top: '',
                    'transform-origin': '',
                    transform: '',
                    opacity: ''
                });
            }
        }, {
            key: "_makeDropdownFocusable",
            value: function _makeDropdownFocusable() {
                // Needed for arrow key navigation
                this.dropdownEl.tabIndex = 0;
                
                // Only set tabindex if it hasn't been set by user
                $(this.dropdownEl).children().each(function (el) {
                    if (!el.getAttribute('tabindex')) {
                        el.setAttribute('tabindex', 0);
                    }
                });
            }
        }, {
            key: "_focusFocusedItem",
            value: function _focusFocusedItem() {
                if (this.focusedIndex >= 0 && this.focusedIndex < this.dropdownEl.children.length && this.options.autoFocus) {
                    this.dropdownEl.children[this.focusedIndex].focus();
                }
            }
        }, {
            key: "_getDropdownPosition",
            value: function _getDropdownPosition() {
                var offsetParentBRect = this.el.offsetParent.getBoundingClientRect();
                var triggerBRect = this.el.getBoundingClientRect();
                var dropdownBRect = this.dropdownEl.getBoundingClientRect();
                
                var idealHeight = dropdownBRect.height;
                var idealWidth = dropdownBRect.width;
                var idealXPos = triggerBRect.left - dropdownBRect.left;
                var idealYPos = triggerBRect.top - dropdownBRect.top;
                
                var dropdownBounds = {
                    left: idealXPos,
                    top: idealYPos,
                    height: idealHeight,
                    width: idealWidth
                };
                
                // Countainer here will be closest ancestor with overflow: hidden
                var closestOverflowParent = this.dropdownEl.offsetParent;
                var alignments = M.checkPossibleAlignments(this.el, closestOverflowParent, dropdownBounds, this.options.coverTrigger ? 0 : triggerBRect.height);
                
                var verticalAlignment = 'top';
                var horizontalAlignment = this.options.alignment;
                idealYPos += this.options.coverTrigger ? 0 : triggerBRect.height;
                
                // Reset isScrollable
                this.isScrollable = false;
                
                if (!alignments.top) {
                    if (alignments.bottom) {
                        verticalAlignment = 'bottom';
                    } else {
                        this.isScrollable = true;
                        
                        // Determine which side has most space and cutoff at correct height
                        if (alignments.spaceOnTop > alignments.spaceOnBottom) {
                            verticalAlignment = 'bottom';
                            idealHeight += alignments.spaceOnTop;
                            idealYPos -= alignments.spaceOnTop;
                        } else {
                            idealHeight += alignments.spaceOnBottom;
                        }
                    }
                }
                
                // If preferred horizontal alignment is possible
                if (!alignments[horizontalAlignment]) {
                    var oppositeAlignment = horizontalAlignment === 'left' ? 'right' : 'left';
                    if (alignments[oppositeAlignment]) {
                        horizontalAlignment = oppositeAlignment;
                    } else {
                        // Determine which side has most space and cutoff at correct height
                        if (alignments.spaceOnLeft > alignments.spaceOnRight) {
                            horizontalAlignment = 'right';
                            idealWidth += alignments.spaceOnLeft;
                            idealXPos -= alignments.spaceOnLeft;
                        } else {
                            horizontalAlignment = 'left';
                            idealWidth += alignments.spaceOnRight;
                        }
                    }
                }
                
                if (verticalAlignment === 'bottom') {
                    idealYPos = idealYPos - dropdownBRect.height + (this.options.coverTrigger ? triggerBRect.height : 0);
                }
                if (horizontalAlignment === 'right') {
                    idealXPos = idealXPos - dropdownBRect.width + triggerBRect.width;
                }
                return {
                    x: idealXPos,
                    y: idealYPos,
                    verticalAlignment: verticalAlignment,
                    horizontalAlignment: horizontalAlignment,
                    height: idealHeight,
                    width: idealWidth
                };
            }
            
            /**
            * Animate in dropdown
            */
            
        }, {
            key: "_animateIn",
            value: function _animateIn() {
                var _this10 = this;
                
                anim.remove(this.dropdownEl);
                anim({
                    targets: this.dropdownEl,
                    opacity: {
                        value: [0, 1],
                        easing: 'easeOutQuad'
                    },
                    scaleX: [.3, 1],
                    scaleY: [.3, 1],
                    duration: this.options.inDuration,
                    easing: 'easeOutQuint',
                    complete: function (anim) {
                        if (_this10.options.autoFocus) {
                            _this10.dropdownEl.focus();
                        }
                        
                        // onOpenEnd callback
                        if (typeof _this10.options.onOpenEnd === 'function') {
                            var elem = anim.animatables[0].target;
                            _this10.options.onOpenEnd.call(elem, _this10.el);
                        }
                    }
                });
            }
            
            /**
            * Animate out dropdown
            */
            
        }, {
            key: "_animateOut",
            value: function _animateOut() {
                var _this11 = this;
                
                anim.remove(this.dropdownEl);
                anim({
                    targets: this.dropdownEl,
                    opacity: {
                        value: 0,
                        easing: 'easeOutQuint'
                    },
                    scaleX: .3,
                    scaleY: .3,
                    duration: this.options.outDuration,
                    easing: 'easeOutQuint',
                    complete: function (anim) {
                        _this11._resetDropdownStyles();
                        
                        // onCloseEnd callback
                        if (typeof _this11.options.onCloseEnd === 'function') {
                            var elem = anim.animatables[0].target;
                            _this11.options.onCloseEnd.call(_this11, _this11.el);
                        }
                    }
                });
            }
            
            /**
            * Place dropdown
            */
            
        }, {
            key: "_placeDropdown",
            value: function _placeDropdown() {
                // Set width before calculating positionInfo
                var idealWidth = this.options.constrainWidth ? this.el.getBoundingClientRect().width : this.dropdownEl.getBoundingClientRect().width;
                this.dropdownEl.style.width = idealWidth + 'px';
                
                var positionInfo = this._getDropdownPosition();
                this.dropdownEl.style.left = positionInfo.x + 'px';
                this.dropdownEl.style.top = positionInfo.y + 'px';
                this.dropdownEl.style.height = positionInfo.height + 'px';
                this.dropdownEl.style.width = positionInfo.width + 'px';
                this.dropdownEl.style.transformOrigin = (positionInfo.horizontalAlignment === 'left' ? '0' : '100%') + " " + (positionInfo.verticalAlignment === 'top' ? '0' : '100%');
            }
            
            /**
            * Open Dropdown
            */
            
        }, {
            key: "open",
            value: function open() {
                if (this.isOpen) {
                    return;
                }
                this.isOpen = true;
                
                // onOpenStart callback
                if (typeof this.options.onOpenStart === 'function') {
                    this.options.onOpenStart.call(this, this.el);
                }
                
                // Reset styles
                this._resetDropdownStyles();
                this.dropdownEl.style.display = 'block';
                
                this._placeDropdown();
                this._animateIn();
                this._setupTemporaryEventHandlers();
            }
            
            /**
            * Close Dropdown
            */
            
        }, {
            key: "close",
            value: function close() {
                if (!this.isOpen) {
                    return;
                }
                this.isOpen = false;
                this.focusedIndex = -1;
                
                // onCloseStart callback
                if (typeof this.options.onCloseStart === 'function') {
                    this.options.onCloseStart.call(this, this.el);
                }
                
                this._animateOut();
                this._removeTemporaryEventHandlers();
                
                if (this.options.autoFocus) {
                    this.el.focus();
                }
            }
            
            /**
            * Recalculate dimensions
            */
            
        }, {
            key: "recalculateDimensions",
            value: function recalculateDimensions() {
                if (this.isOpen) {
                    this.$dropdownEl.css({
                        width: '',
                        height: '',
                        left: '',
                        top: '',
                        'transform-origin': ''
                    });
                    this._placeDropdown();
                }
            }
        }], [{
            key: "init",
            value: function init(els, options) {
                return _get(Dropdown.__proto__ || Object.getPrototypeOf(Dropdown), "init", this).call(this, this, els, options);
            }
            
            /**
            * Get Instance
            */
            
        }, {
            key: "getInstance",
            value: function getInstance(el) {
                var domElem = !!el.jquery ? el[0] : el;
                return domElem.M_Dropdown;
            }
        }, {
            key: "defaults",
            get: function () {
                return _defaults;
            }
        }]);
        
        return Dropdown;
    }(Component);
    
    /**
    * @static
    * @memberof Dropdown
    */
    
    
    Dropdown._dropdowns = [];
    
    window.M.Dropdown = Dropdown;
    
    if (M.jQueryLoaded) {
        M.initializeJqueryWrapper(Dropdown, 'dropdown', 'M_Dropdown');
    }
})(cash, M.anime);
;(function ($, anim) {
    'use strict';
    
    var _defaults = {
        opacity: 0.5,
        inDuration: 250,
        outDuration: 250,
        onOpenStart: null,
        onOpenEnd: null,
        onCloseStart: null,
        onCloseEnd: null,
        preventScrolling: true,
        dismissible: true,
        startingTop: '4%',
        endingTop: '10%'
    };
    
    /**
    * @class
    *
    */
    
    var Modal = function (_Component3) {
        _inherits(Modal, _Component3);
        
        /**
        * Construct Modal instance and set up overlay
        * @constructor
        * @param {Element} el
        * @param {Object} options
        */
        function Modal(el, options) {
            _classCallCheck(this, Modal);
            
            var _this12 = _possibleConstructorReturn(this, (Modal.__proto__ || Object.getPrototypeOf(Modal)).call(this, Modal, el, options));
            
            _this12.el.M_Modal = _this12;
            
            /**
            * Options for the modal
            * @member Modal#options
            * @prop {Number} [opacity=0.5] - Opacity of the modal overlay
            * @prop {Number} [inDuration=250] - Length in ms of enter transition
            * @prop {Number} [outDuration=250] - Length in ms of exit transition
            * @prop {Function} onOpenStart - Callback function called before modal is opened
            * @prop {Function} onOpenEnd - Callback function called after modal is opened
            * @prop {Function} onCloseStart - Callback function called before modal is closed
            * @prop {Function} onCloseEnd - Callback function called after modal is closed
            * @prop {Boolean} [dismissible=true] - Allow modal to be dismissed by keyboard or overlay click
            * @prop {String} [startingTop='4%'] - startingTop
            * @prop {String} [endingTop='10%'] - endingTop
            */
            _this12.options = $.extend({}, Modal.defaults, options);
            
            /**
            * Describes open/close state of modal
            * @type {Boolean}
            */
            _this12.isOpen = false;
            
            _this12.id = _this12.$el.attr('id');
            _this12._openingTrigger = undefined;
            _this12.$overlay = $('<div class="modal-overlay"></div>');
            _this12.el.tabIndex = 0;
            
            Modal._count++;
            _this12._setupEventHandlers();
            return _this12;
        }
        
        _createClass(Modal, [{
            key: "destroy",
            
            
            /**
            * Teardown component
            */
            value: function destroy() {
                Modal._count--;
                this._removeEventHandlers();
                this.el.removeAttribute('style');
                this.$overlay.remove();
                this.el.M_Modal = undefined;
            }
            
            /**
            * Setup Event Handlers
            */
            
        }, {
            key: "_setupEventHandlers",
            value: function _setupEventHandlers() {
                this._handleOverlayClickBound = this._handleOverlayClick.bind(this);
                this._handleModalCloseClickBound = this._handleModalCloseClick.bind(this);
                
                if (Modal._count === 1) {
                    document.body.addEventListener('click', this._handleTriggerClick);
                }
                this.$overlay[0].addEventListener('click', this._handleOverlayClickBound);
                this.el.addEventListener('click', this._handleModalCloseClickBound);
            }
            
            /**
            * Remove Event Handlers
            */
            
        }, {
            key: "_removeEventHandlers",
            value: function _removeEventHandlers() {
                if (Modal._count === 0) {
                    document.body.removeEventListener('click', this._handleTriggerClick);
                }
                this.$overlay[0].removeEventListener('click', this._handleOverlayClickBound);
                this.el.removeEventListener('click', this._handleModalCloseClickBound);
            }
            
            /**
            * Handle Trigger Click
            * @param {Event} e
            */
            
        }, {
            key: "_handleTriggerClick",
            value: function _handleTriggerClick(e) {
                var $trigger = $(e.target).closest('.modal-trigger');
                if ($trigger.length) {
                    var modalId = M.getIdFromTrigger($trigger[0]);
                    var modalInstance = document.getElementById(modalId).M_Modal;
                    if (modalInstance) {
                        modalInstance.open($trigger);
                    }
                    e.preventDefault();
                }
            }
            
            /**
            * Handle Overlay Click
            */
            
        }, {
            key: "_handleOverlayClick",
            value: function _handleOverlayClick() {
                if (this.options.dismissible) {
                    this.close();
                }
            }
            
            /**
            * Handle Modal Close Click
            * @param {Event} e
            */
            
        }, {
            key: "_handleModalCloseClick",
            value: function _handleModalCloseClick(e) {
                var $closeTrigger = $(e.target).closest('.modal-close');
                if ($closeTrigger.length) {
                    this.close();
                }
            }
            
            /**
            * Handle Keydown
            * @param {Event} e
            */
            
        }, {
            key: "_handleKeydown",
            value: function _handleKeydown(e) {
                // ESC key
                if (e.keyCode === 27 && this.options.dismissible) {
                    this.close();
                }
            }
            
            /**
            * Handle Focus
            * @param {Event} e
            */
            
        }, {
            key: "_handleFocus",
            value: function _handleFocus(e) {
                if (!this.el.contains(e.target)) {
                    this.el.focus();
                }
            }
            
            /**
            * Animate in modal
            */
            
        }, {
            key: "_animateIn",
            value: function _animateIn() {
                var _this13 = this;
                
                // Set initial styles
                $.extend(this.el.style, {
                    display: 'block',
                    opacity: 0
                });
                $.extend(this.$overlay[0].style, {
                    display: 'block',
                    opacity: 0
                });
                
                // Animate overlay
                anim({
                    targets: this.$overlay[0],
                    opacity: this.options.opacity,
                    duration: this.options.inDuration,
                    easing: 'easeOutQuad'
                });
                
                // Define modal animation options
                var enterAnimOptions = {
                    targets: this.el,
                    duration: this.options.inDuration,
                    easing: 'easeOutCubic',
                    // Handle modal onOpenEnd callback
                    complete: function () {
                        if (typeof _this13.options.onOpenEnd === 'function') {
                            _this13.options.onOpenEnd.call(_this13, _this13.el, _this13._openingTrigger);
                        }
                    }
                };
                
                // Bottom sheet animation
                if (this.el.classList.contains('bottom-sheet')) {
                    $.extend(enterAnimOptions, {
                        bottom: 0,
                        opacity: 1
                    });
                    anim(enterAnimOptions);
                    
                    // Normal modal animation
                } else {
                    $.extend(enterAnimOptions, {
                        top: [this.options.startingTop, this.options.endingTop],
                        opacity: 1,
                        scaleX: [.8, 1],
                        scaleY: [.8, 1]
                    });
                    anim(enterAnimOptions);
                }
            }
            
            /**
            * Animate out modal
            */
            
        }, {
            key: "_animateOut",
            value: function _animateOut() {
                var _this14 = this;
                
                // Animate overlay
                anim({
                    targets: this.$overlay[0],
                    opacity: 0,
                    duration: this.options.outDuration,
                    easing: 'easeOutQuart'
                });
                
                // Define modal animation options
                var exitAnimOptions = {
                    targets: this.el,
                    duration: this.options.outDuration,
                    easing: 'easeOutCubic',
                    // Handle modal ready callback
                    complete: function () {
                        _this14.el.style.display = 'none';
                        _this14.$overlay.remove();
                        
                        // Call onCloseEnd callback
                        if (typeof _this14.options.onCloseEnd === 'function') {
                            _this14.options.onCloseEnd.call(_this14, _this14.el);
                        }
                    }
                };
                
                // Bottom sheet animation
                if (this.el.classList.contains('bottom-sheet')) {
                    $.extend(exitAnimOptions, {
                        bottom: '-100%',
                        opacity: 0
                    });
                    anim(exitAnimOptions);
                    
                    // Normal modal animation
                } else {
                    $.extend(exitAnimOptions, {
                        top: [this.options.endingTop, this.options.startingTop],
                        opacity: 0,
                        scaleX: 0.8,
                        scaleY: 0.8
                    });
                    anim(exitAnimOptions);
                }
            }
            
            /**
            * Open Modal
            * @param {cash} [$trigger]
            */
            
        }, {
            key: "open",
            value: function open($trigger) {
                if (this.isOpen) {
                    return;
                }
                
                this.isOpen = true;
                Modal._modalsOpen++;
                
                // Set Z-Index based on number of currently open modals
                this.$overlay[0].style.zIndex = 1000 + Modal._modalsOpen * 2;
                this.el.style.zIndex = 1000 + Modal._modalsOpen * 2 + 1;
                
                // Set opening trigger, undefined indicates modal was opened by javascript
                this._openingTrigger = !!$trigger ? $trigger[0] : undefined;
                
                // onOpenStart callback
                if (typeof this.options.onOpenStart === 'function') {
                    this.options.onOpenStart.call(this, this.el, this._openingTrigger);
                }
                
                if (this.options.preventScrolling) {
                    document.body.style.overflow = 'hidden';
                }
                
                this.el.classList.add('open');
                this.el.insertAdjacentElement('afterend', this.$overlay[0]);
                
                if (this.options.dismissible) {
                    this._handleKeydownBound = this._handleKeydown.bind(this);
                    this._handleFocusBound = this._handleFocus.bind(this);
                    document.addEventListener('keydown', this._handleKeydownBound);
                    document.addEventListener('focus', this._handleFocusBound, true);
                }
                
                anim.remove(this.el);
                anim.remove(this.$overlay[0]);
                this._animateIn();
                
                // Focus modal
                this.el.focus();
                
                return this;
            }
            
            /**
            * Close Modal
            */
            
        }, {
            key: "close",
            value: function close() {
                if (!this.isOpen) {
                    return;
                }
                
                this.isOpen = false;
                Modal._modalsOpen--;
                
                // Call onCloseStart callback
                if (typeof this.options.onCloseStart === 'function') {
                    this.options.onCloseStart.call(this, this.el);
                }
                
                this.el.classList.remove('open');
                
                // Enable body scrolling only if there are no more modals open.
                if (Modal._modalsOpen === 0) {
                    document.body.style.overflow = '';
                }
                
                if (this.options.dismissible) {
                    document.removeEventListener('keydown', this._handleKeydownBound);
                    document.removeEventListener('focus', this._handleFocusBound);
                }
                
                anim.remove(this.el);
                anim.remove(this.$overlay[0]);
                this._animateOut();
                return this;
            }
        }], [{
            key: "init",
            value: function init(els, options) {
                return _get(Modal.__proto__ || Object.getPrototypeOf(Modal), "init", this).call(this, this, els, options);
            }
            
            /**
            * Get Instance
            */
            
        }, {
            key: "getInstance",
            value: function getInstance(el) {
                var domElem = !!el.jquery ? el[0] : el;
                return domElem.M_Modal;
            }
        }, {
            key: "defaults",
            get: function () {
                return _defaults;
            }
        }]);
        
        return Modal;
    }(Component);
    
    /**
    * @static
    * @memberof Modal
    */
    
    
    Modal._modalsOpen = 0;
    
    /**
    * @static
    * @memberof Modal
    */
    Modal._count = 0;
    
    M.Modal = Modal;
    
    if (M.jQueryLoaded) {
        M.initializeJqueryWrapper(Modal, 'modal', 'M_Modal');
    }
})(cash, M.anime);
;(function ($, anim) {
    'use strict';
    
    var _defaults = {
        exitDelay: 200,
        enterDelay: 0,
        html: null,
        margin: 5,
        inDuration: 250,
        outDuration: 200,
        position: 'bottom',
        transitionMovement: 10
    };
    
    /**
    * @class
    *
    */
    
    var Tooltip = function (_Component7) {
        _inherits(Tooltip, _Component7);
        
        /**
        * Construct Tooltip instance
        * @constructor
        * @param {Element} el
        * @param {Object} options
        */
        function Tooltip(el, options) {
            _classCallCheck(this, Tooltip);
            
            var _this25 = _possibleConstructorReturn(this, (Tooltip.__proto__ || Object.getPrototypeOf(Tooltip)).call(this, Tooltip, el, options));
            
            _this25.el.M_Tooltip = _this25;
            _this25.options = $.extend({}, Tooltip.defaults, options);
            
            _this25.isOpen = false;
            _this25.isHovered = false;
            _this25.isFocused = false;
            _this25._appendTooltipEl();
            _this25._setupEventHandlers();
            return _this25;
        }
        
        _createClass(Tooltip, [{
            key: "destroy",
            
            
            /**
            * Teardown component
            */
            value: function destroy() {
                $(this.tooltipEl).remove();
                this._removeEventHandlers();
                this.el.M_Tooltip = undefined;
            }
        }, {
            key: "_appendTooltipEl",
            value: function _appendTooltipEl() {
                var tooltipEl = document.createElement('div');
                tooltipEl.classList.add('material-tooltip');
                this.tooltipEl = tooltipEl;
                
                var tooltipContentEl = document.createElement('div');
                tooltipContentEl.classList.add('tooltip-content');
                tooltipContentEl.innerHTML = this.options.html;
                tooltipEl.appendChild(tooltipContentEl);
                document.body.appendChild(tooltipEl);
            }
        }, {
            key: "_updateTooltipContent",
            value: function _updateTooltipContent() {
                this.tooltipEl.querySelector('.tooltip-content').innerHTML = this.options.html;
            }
        }, {
            key: "_setupEventHandlers",
            value: function _setupEventHandlers() {
                this._handleMouseEnterBound = this._handleMouseEnter.bind(this);
                this._handleMouseLeaveBound = this._handleMouseLeave.bind(this);
                this._handleFocusBound = this._handleFocus.bind(this);
                this._handleBlurBound = this._handleBlur.bind(this);
                this.el.addEventListener('mouseenter', this._handleMouseEnterBound);
                this.el.addEventListener('mouseleave', this._handleMouseLeaveBound);
                this.el.addEventListener('focus', this._handleFocusBound, true);
                this.el.addEventListener('blur', this._handleBlurBound, true);
            }
        }, {
            key: "_removeEventHandlers",
            value: function _removeEventHandlers() {
                this.el.removeEventListener('mouseenter', this._handleMouseEnterBound);
                this.el.removeEventListener('mouseleave', this._handleMouseLeaveBound);
                this.el.removeEventListener('focus', this._handleFocusBound, true);
                this.el.removeEventListener('blur', this._handleBlurBound, true);
            }
        }, {
            key: "open",
            value: function open() {
                if (this.isOpen) {
                    return;
                }
                
                this.isOpen = true;
                // Update tooltip content with HTML attribute options
                this.options = $.extend({}, this.options, this._getAttributeOptions());
                this._updateTooltipContent();
                this._setEnterDelayTimeout();
            }
        }, {
            key: "close",
            value: function close() {
                if (!this.isOpen) {
                    return;
                }
                
                this.isOpen = false;
                this._setExitDelayTimeout();
            }
            
            /**
            * Create timeout which delays when the tooltip closes
            */
            
        }, {
            key: "_setExitDelayTimeout",
            value: function _setExitDelayTimeout() {
                var _this26 = this;
                
                clearTimeout(this._exitDelayTimeout);
                
                this._exitDelayTimeout = setTimeout(function () {
                    if (_this26.isHovered || _this26.isFocused) {
                        return;
                    }
                    
                    _this26._animateOut();
                }, this.options.exitDelay);
            }
            
            /**
            * Create timeout which delays when the toast closes
            */
            
        }, {
            key: "_setEnterDelayTimeout",
            value: function _setEnterDelayTimeout() {
                var _this27 = this;
                
                clearTimeout(this._enterDelayTimeout);
                
                this._enterDelayTimeout = setTimeout(function () {
                    if (!_this27.isHovered && !_this27.isFocused) {
                        return;
                    }
                    
                    _this27._animateIn();
                }, this.options.enterDelay);
            }
        }, {
            key: "_positionTooltip",
            value: function _positionTooltip() {
                var origin = this.el,
                tooltip = this.tooltipEl,
                originHeight = origin.offsetHeight,
                originWidth = origin.offsetWidth,
                tooltipHeight = tooltip.offsetHeight,
                tooltipWidth = tooltip.offsetWidth,
                newCoordinates = void 0,
                margin = this.options.margin,
                targetTop = void 0,
                targetLeft = void 0;
                
                this.xMovement = 0, this.yMovement = 0;
                
                targetTop = origin.getBoundingClientRect().top + M.getDocumentScrollTop();
                targetLeft = origin.getBoundingClientRect().left + M.getDocumentScrollLeft();
                
                if (this.options.position === 'top') {
                    targetTop += -tooltipHeight - margin;
                    targetLeft += originWidth / 2 - tooltipWidth / 2;
                    this.yMovement = -this.options.transitionMovement;
                } else if (this.options.position === 'right') {
                    targetTop += originHeight / 2 - tooltipHeight / 2;
                    targetLeft += originWidth + margin;
                    this.xMovement = this.options.transitionMovement;
                } else if (this.options.position === 'left') {
                    targetTop += originHeight / 2 - tooltipHeight / 2;
                    targetLeft += -tooltipWidth - margin;
                    this.xMovement = -this.options.transitionMovement;
                } else {
                    targetTop += originHeight + margin;
                    targetLeft += originWidth / 2 - tooltipWidth / 2;
                    this.yMovement = this.options.transitionMovement;
                }
                
                newCoordinates = this._repositionWithinScreen(targetLeft, targetTop, tooltipWidth, tooltipHeight);
                $(tooltip).css({
                    top: newCoordinates.y + 'px',
                    left: newCoordinates.x + 'px'
                });
            }
        }, {
            key: "_repositionWithinScreen",
            value: function _repositionWithinScreen(x, y, width, height) {
                var scrollLeft = M.getDocumentScrollLeft();
                var scrollTop = M.getDocumentScrollTop();
                var newX = x - scrollLeft;
                var newY = y - scrollTop;
                
                var bounding = {
                    left: newX,
                    top: newY,
                    width: width,
                    height: height
                };
                
                var offset = this.options.margin + this.options.transitionMovement;
                var edges = M.checkWithinContainer(document.body, bounding, offset);
                
                if (edges.left) {
                    newX = offset;
                } else if (edges.right) {
                    newX -= newX + width - window.innerWidth;
                }
                
                if (edges.top) {
                    newY = offset;
                } else if (edges.bottom) {
                    newY -= newY + height - window.innerHeight;
                }
                
                return {
                    x: newX + scrollLeft,
                    y: newY + scrollTop
                };
            }
        }, {
            key: "_animateIn",
            value: function _animateIn() {
                this._positionTooltip();
                this.tooltipEl.style.visibility = 'visible';
                anim.remove(this.tooltipEl);
                anim({
                    targets: this.tooltipEl,
                    opacity: 1,
                    translateX: this.xMovement,
                    translateY: this.yMovement,
                    duration: this.options.inDuration,
                    easing: 'easeOutCubic'
                });
            }
        }, {
            key: "_animateOut",
            value: function _animateOut() {
                anim.remove(this.tooltipEl);
                anim({
                    targets: this.tooltipEl,
                    opacity: 0,
                    translateX: 0,
                    translateY: 0,
                    duration: this.options.outDuration,
                    easing: 'easeOutCubic'
                });
            }
        }, {
            key: "_handleMouseEnter",
            value: function _handleMouseEnter() {
                this.isHovered = true;
                this.open();
            }
        }, {
            key: "_handleMouseLeave",
            value: function _handleMouseLeave() {
                this.isHovered = false;
                this.close();
            }
        }, {
            key: "_handleFocus",
            value: function _handleFocus() {
                this.isFocused = true;
                this.open();
            }
        }, {
            key: "_handleBlur",
            value: function _handleBlur() {
                this.isFocused = false;
                this.close();
            }
        }, {
            key: "_getAttributeOptions",
            value: function _getAttributeOptions() {
                var attributeOptions = {};
                var tooltipTextOption = this.el.getAttribute('data-tooltip');
                var positionOption = this.el.getAttribute('data-position');
                
                if (tooltipTextOption) {
                    attributeOptions.html = tooltipTextOption;
                }
                
                if (positionOption) {
                    attributeOptions.position = positionOption;
                }
                return attributeOptions;
            }
        }], [{
            key: "init",
            value: function init(els, options) {
                return _get(Tooltip.__proto__ || Object.getPrototypeOf(Tooltip), "init", this).call(this, this, els, options);
            }
            
            /**
            * Get Instance
            */
            
        }, {
            key: "getInstance",
            value: function getInstance(el) {
                var domElem = !!el.jquery ? el[0] : el;
                return domElem.M_Tooltip;
            }
        }, {
            key: "defaults",
            get: function () {
                return _defaults;
            }
        }]);
        
        return Tooltip;
    }(Component);
    
    M.Tooltip = Tooltip;
    
    if (M.jQueryLoaded) {
        M.initializeJqueryWrapper(Tooltip, 'tooltip', 'M_Tooltip');
    }
})(cash, M.anime);
; /*!
* Waves v0.6.4
* http://fian.my.id/Waves
*
* Copyright 2014 Alfiana E. Sibuea and other contributors
* Released under the MIT license
* https://github.com/fians/Waves/blob/master/LICENSE
*/

;(function (window) {
    'use strict';
    
    var Waves = Waves || {};
    var $$ = document.querySelectorAll.bind(document);
    
    // Find exact position of element
    function isWindow(obj) {
        return obj !== null && obj === obj.window;
    }
    
    function getWindow(elem) {
        return isWindow(elem) ? elem : elem.nodeType === 9 && elem.defaultView;
    }
    
    function offset(elem) {
        var docElem,
        win,
        box = { top: 0, left: 0 },
        doc = elem && elem.ownerDocument;
        
        docElem = doc.documentElement;
        
        if (typeof elem.getBoundingClientRect !== typeof undefined) {
            box = elem.getBoundingClientRect();
        }
        win = getWindow(doc);
        return {
            top: box.top + win.pageYOffset - docElem.clientTop,
            left: box.left + win.pageXOffset - docElem.clientLeft
        };
    }
    
    function convertStyle(obj) {
        var style = '';
        
        for (var a in obj) {
            if (obj.hasOwnProperty(a)) {
                style += a + ':' + obj[a] + ';';
            }
        }
        
        return style;
    }
    
    var Effect = {
        
        // Effect delay
        duration: 750,
        
        show: function (e, element) {
            
            // Disable right click
            if (e.button === 2) {
                return false;
            }
            
            var el = element || this;
            
            // Create ripple
            var ripple = document.createElement('div');
            ripple.className = 'waves-ripple';
            el.appendChild(ripple);
            
            // Get click coordinate and element witdh
            var pos = offset(el);
            var relativeY = e.pageY - pos.top;
            var relativeX = e.pageX - pos.left;
            var scale = 'scale(' + el.clientWidth / 100 * 10 + ')';
            
            // Support for touch devices
            if ('touches' in e) {
                relativeY = e.touches[0].pageY - pos.top;
                relativeX = e.touches[0].pageX - pos.left;
            }
            
            // Attach data to element
            ripple.setAttribute('data-hold', Date.now());
            ripple.setAttribute('data-scale', scale);
            ripple.setAttribute('data-x', relativeX);
            ripple.setAttribute('data-y', relativeY);
            
            // Set ripple position
            var rippleStyle = {
                'top': relativeY + 'px',
                'left': relativeX + 'px'
            };
            
            ripple.className = ripple.className + ' waves-notransition';
            ripple.setAttribute('style', convertStyle(rippleStyle));
            ripple.className = ripple.className.replace('waves-notransition', '');
            
            // Scale the ripple
            rippleStyle['-webkit-transform'] = scale;
            rippleStyle['-moz-transform'] = scale;
            rippleStyle['-ms-transform'] = scale;
            rippleStyle['-o-transform'] = scale;
            rippleStyle.transform = scale;
            rippleStyle.opacity = '1';
            
            rippleStyle['-webkit-transition-duration'] = Effect.duration + 'ms';
            rippleStyle['-moz-transition-duration'] = Effect.duration + 'ms';
            rippleStyle['-o-transition-duration'] = Effect.duration + 'ms';
            rippleStyle['transition-duration'] = Effect.duration + 'ms';
            
            rippleStyle['-webkit-transition-timing-function'] = 'cubic-bezier(0.250, 0.460, 0.450, 0.940)';
            rippleStyle['-moz-transition-timing-function'] = 'cubic-bezier(0.250, 0.460, 0.450, 0.940)';
            rippleStyle['-o-transition-timing-function'] = 'cubic-bezier(0.250, 0.460, 0.450, 0.940)';
            rippleStyle['transition-timing-function'] = 'cubic-bezier(0.250, 0.460, 0.450, 0.940)';
            
            ripple.setAttribute('style', convertStyle(rippleStyle));
        },
        
        hide: function (e) {
            TouchHandler.touchup(e);
            
            var el = this;
            var width = el.clientWidth * 1.4;
            
            // Get first ripple
            var ripple = null;
            var ripples = el.getElementsByClassName('waves-ripple');
            if (ripples.length > 0) {
                ripple = ripples[ripples.length - 1];
            } else {
                return false;
            }
            
            var relativeX = ripple.getAttribute('data-x');
            var relativeY = ripple.getAttribute('data-y');
            var scale = ripple.getAttribute('data-scale');
            
            // Get delay beetween mousedown and mouse leave
            var diff = Date.now() - Number(ripple.getAttribute('data-hold'));
            var delay = 350 - diff;
            
            if (delay < 0) {
                delay = 0;
            }
            
            // Fade out ripple after delay
            setTimeout(function () {
                var style = {
                    'top': relativeY + 'px',
                    'left': relativeX + 'px',
                    'opacity': '0',
                    
                    // Duration
                    '-webkit-transition-duration': Effect.duration + 'ms',
                    '-moz-transition-duration': Effect.duration + 'ms',
                    '-o-transition-duration': Effect.duration + 'ms',
                    'transition-duration': Effect.duration + 'ms',
                    '-webkit-transform': scale,
                    '-moz-transform': scale,
                    '-ms-transform': scale,
                    '-o-transform': scale,
                    'transform': scale
                };
                
                ripple.setAttribute('style', convertStyle(style));
                
                setTimeout(function () {
                    try {
                        el.removeChild(ripple);
                    } catch (e) {
                        return false;
                    }
                }, Effect.duration);
            }, delay);
        },
        
        // Little hack to make <input> can perform waves effect
        wrapInput: function (elements) {
            for (var a = 0; a < elements.length; a++) {
                var el = elements[a];
                
                if (el.tagName.toLowerCase() === 'input') {
                    var parent = el.parentNode;
                    
                    // If input already have parent just pass through
                    if (parent.tagName.toLowerCase() === 'i' && parent.className.indexOf('waves-effect') !== -1) {
                        continue;
                    }
                    
                    // Put element class and style to the specified parent
                    var wrapper = document.createElement('i');
                    wrapper.className = el.className + ' waves-input-wrapper';
                    
                    var elementStyle = el.getAttribute('style');
                    
                    if (!elementStyle) {
                        elementStyle = '';
                    }
                    
                    wrapper.setAttribute('style', elementStyle);
                    
                    el.className = 'waves-button-input';
                    el.removeAttribute('style');
                    
                    // Put element as child
                    parent.replaceChild(wrapper, el);
                    wrapper.appendChild(el);
                }
            }
        }
    };
    
    /**
    * Disable mousedown event for 500ms during and after touch
    */
    var TouchHandler = {
        /* uses an integer rather than bool so there's no issues with
        * needing to clear timeouts if another touch event occurred
        * within the 500ms. Cannot mouseup between touchstart and
        * touchend, nor in the 500ms after touchend. */
        touches: 0,
        allowEvent: function (e) {
            var allow = true;
            
            if (e.type === 'touchstart') {
                TouchHandler.touches += 1; //push
            } else if (e.type === 'touchend' || e.type === 'touchcancel') {
                setTimeout(function () {
                    if (TouchHandler.touches > 0) {
                        TouchHandler.touches -= 1; //pop after 500ms
                    }
                }, 500);
            } else if (e.type === 'mousedown' && TouchHandler.touches > 0) {
                allow = false;
            }
            
            return allow;
        },
        touchup: function (e) {
            TouchHandler.allowEvent(e);
        }
    };
    
    /**
    * Delegated click handler for .waves-effect element.
    * returns null when .waves-effect element not in "click tree"
    */
    function getWavesEffectElement(e) {
        if (TouchHandler.allowEvent(e) === false) {
            return null;
        }
        
        var element = null;
        var target = e.target || e.srcElement;
        
        while (target.parentNode !== null) {
            if (!(target instanceof SVGElement) && target.className.indexOf('waves-effect') !== -1) {
                element = target;
                break;
            }
            target = target.parentNode;
        }
        return element;
    }
    
    /**
    * Bubble the click and show effect if .waves-effect elem was found
    */
    function showEffect(e) {
        var element = getWavesEffectElement(e);
        
        if (element !== null) {
            Effect.show(e, element);
            
            if ('ontouchstart' in window) {
                element.addEventListener('touchend', Effect.hide, false);
                element.addEventListener('touchcancel', Effect.hide, false);
            }
            
            element.addEventListener('mouseup', Effect.hide, false);
            element.addEventListener('mouseleave', Effect.hide, false);
            element.addEventListener('dragend', Effect.hide, false);
        }
    }
    
    Waves.displayEffect = function (options) {
        options = options || {};
        
        if ('duration' in options) {
            Effect.duration = options.duration;
        }
        
        //Wrap input inside <i> tag
        Effect.wrapInput($$('.waves-effect'));
        
        if ('ontouchstart' in window) {
            document.body.addEventListener('touchstart', showEffect, false);
        }
        
        document.body.addEventListener('mousedown', showEffect, false);
    };
    
    /**
    * Attach Waves to an input element (or any element which doesn't
    * bubble mouseup/mousedown events).
    *   Intended to be used with dynamically loaded forms/inputs, or
    * where the user doesn't want a delegated click handler.
    */
    Waves.attach = function (element) {
        //FUTURE: automatically add waves classes and allow users
        // to specify them with an options param? Eg. light/classic/button
        if (element.tagName.toLowerCase() === 'input') {
            Effect.wrapInput([element]);
            element = element.parentNode;
        }
        
        if ('ontouchstart' in window) {
            element.addEventListener('touchstart', showEffect, false);
        }
        
        element.addEventListener('mousedown', showEffect, false);
    };
    
    window.Waves = Waves;
    
    document.addEventListener('DOMContentLoaded', function () {
        Waves.displayEffect();
    }, false);
})(window);
;(function ($, anim) {
    'use strict';
    
    var _defaults = {
        html: '',
        displayLength: 4000,
        inDuration: 300,
        outDuration: 375,
        classes: '',
        completeCallback: null,
        activationPercent: 0.8
    };
    
    var Toast = function () {
        function Toast(options) {
            _classCallCheck(this, Toast);
            
            /**
            * Options for the toast
            * @member Toast#options
            */
            this.options = $.extend({}, Toast.defaults, options);
            this.message = this.options.html;
            
            /**
            * Describes current pan state toast
            * @type {Boolean}
            */
            this.panning = false;
            
            /**
            * Time remaining until toast is removed
            */
            this.timeRemaining = this.options.displayLength;
            
            if (Toast._toasts.length === 0) {
                Toast._createContainer();
            }
            
            // Create new toast
            Toast._toasts.push(this);
            var toastElement = this._createToast();
            toastElement.M_Toast = this;
            this.el = toastElement;
            this._animateIn();
            this._setTimer();
        }
        
        _createClass(Toast, [{
            key: "_createToast",
            
            
            /**
            * Create toast and append it to toast container
            */
            value: function _createToast() {
                var toast = document.createElement('div');
                toast.classList.add('toast');
                
                // Add custom classes onto toast
                if (!!this.options.classes.length) {
                    $(toast).addClass(this.options.classes);
                }
                
                // Set content
                if (typeof HTMLElement === 'object' ? this.message instanceof HTMLElement : this.message && typeof this.message === 'object' && this.message !== null && this.message.nodeType === 1 && typeof this.message.nodeName === 'string') {
                    toast.appendChild(this.message);
                    
                    // Check if it is jQuery object
                } else if (!!this.message.jquery) {
                    $(toast).append(this.message[0]);
                    
                    // Insert as html;
                } else {
                    toast.innerHTML = this.message;
                }
                
                // Append toasft
                Toast._container.appendChild(toast);
                return toast;
            }
            
            /**
            * Animate in toast
            */
            
        }, {
            key: "_animateIn",
            value: function _animateIn() {
                // Animate toast in
                anim({
                    targets: this.el,
                    top: 0,
                    opacity: 1,
                    duration: 300,
                    easing: 'easeOutCubic'
                });
            }
            
            /**
            * Create setInterval which automatically removes toast when timeRemaining >= 0
            * has been reached
            */
            
        }, {
            key: "_setTimer",
            value: function _setTimer() {
                var _this28 = this;
                
                if (this.timeRemaining !== Infinity) {
                    this.counterInterval = setInterval(function () {
                        // If toast is not being dragged, decrease its time remaining
                        if (!_this28.panning) {
                            _this28.timeRemaining -= 20;
                        }
                        
                        // Animate toast out
                        if (_this28.timeRemaining <= 0) {
                            _this28.dismiss();
                        }
                    }, 20);
                }
            }
            
            /**
            * Dismiss toast with animation
            */
            
        }, {
            key: "dismiss",
            value: function dismiss() {
                var _this29 = this;
                
                window.clearInterval(this.counterInterval);
                var activationDistance = this.el.offsetWidth * this.options.activationPercent;
                
                if (this.wasSwiped) {
                    this.el.style.transition = 'transform .05s, opacity .05s';
                    this.el.style.transform = "translateX(" + activationDistance + "px)";
                    this.el.style.opacity = 0;
                }
                
                anim({
                    targets: this.el,
                    opacity: 0,
                    marginTop: -40,
                    duration: this.options.outDuration,
                    easing: 'easeOutExpo',
                    complete: function () {
                        // Call the optional callback
                        if (typeof _this29.options.completeCallback === 'function') {
                            _this29.options.completeCallback();
                        }
                        // Remove toast from DOM
                        _this29.el.parentNode.removeChild(_this29.el);
                        Toast._toasts.splice(Toast._toasts.indexOf(_this29), 1);
                        if (Toast._toasts.length === 0) {
                            Toast._removeContainer();
                        }
                    }
                });
            }
        }], [{
            key: "getInstance",
            
            
            /**
            * Get Instance
            */
            value: function getInstance(el) {
                var domElem = !!el.jquery ? el[0] : el;
                return domElem.M_Toast;
            }
            
            /**
            * Append toast container and add event handlers
            */
            
        }, {
            key: "_createContainer",
            value: function _createContainer() {
                var container = document.createElement('div');
                container.setAttribute('id', 'toast-container');
                
                // Add event handler
                container.addEventListener('touchstart', Toast._onDragStart);
                container.addEventListener('touchmove', Toast._onDragMove);
                container.addEventListener('touchend', Toast._onDragEnd);
                
                container.addEventListener('mousedown', Toast._onDragStart);
                document.addEventListener('mousemove', Toast._onDragMove);
                document.addEventListener('mouseup', Toast._onDragEnd);
                
                document.body.appendChild(container);
                Toast._container = container;
            }
            
            /**
            * Remove toast container and event handlers
            */
            
        }, {
            key: "_removeContainer",
            value: function _removeContainer() {
                // Add event handler
                document.removeEventListener('mousemove', Toast._onDragMove);
                document.removeEventListener('mouseup', Toast._onDragEnd);
                
                Toast._container.parentNode.removeChild(Toast._container);
                Toast._container = null;
            }
            
            /**
            * Begin drag handler
            * @param {Event} e
            */
            
        }, {
            key: "_onDragStart",
            value: function _onDragStart(e) {
                if (e.target && $(e.target).closest('.toast').length) {
                    var $toast = $(e.target).closest('.toast');
                    var toast = $toast[0].M_Toast;
                    toast.panning = true;
                    Toast._draggedToast = toast;
                    toast.el.classList.add('panning');
                    toast.el.style.transition = '';
                    toast.startingXPos = Toast._xPos(e);
                    toast.time = Date.now();
                    toast.xPos = Toast._xPos(e);
                }
            }
            
            /**
            * Drag move handler
            * @param {Event} e
            */
            
        }, {
            key: "_onDragMove",
            value: function _onDragMove(e) {
                if (!!Toast._draggedToast) {
                    e.preventDefault();
                    var toast = Toast._draggedToast;
                    toast.deltaX = Math.abs(toast.xPos - Toast._xPos(e));
                    toast.xPos = Toast._xPos(e);
                    toast.velocityX = toast.deltaX / (Date.now() - toast.time);
                    toast.time = Date.now();
                    
                    var totalDeltaX = toast.xPos - toast.startingXPos;
                    var activationDistance = toast.el.offsetWidth * toast.options.activationPercent;
                    toast.el.style.transform = "translateX(" + totalDeltaX + "px)";
                    toast.el.style.opacity = 1 - Math.abs(totalDeltaX / activationDistance);
                }
            }
            
            /**
            * End drag handler
            */
            
        }, {
            key: "_onDragEnd",
            value: function _onDragEnd() {
                if (!!Toast._draggedToast) {
                    var toast = Toast._draggedToast;
                    toast.panning = false;
                    toast.el.classList.remove('panning');
                    
                    var totalDeltaX = toast.xPos - toast.startingXPos;
                    var activationDistance = toast.el.offsetWidth * toast.options.activationPercent;
                    var shouldBeDismissed = Math.abs(totalDeltaX) > activationDistance || toast.velocityX > 1;
                    
                    // Remove toast
                    if (shouldBeDismissed) {
                        toast.wasSwiped = true;
                        toast.dismiss();
                        
                        // Animate toast back to original position
                    } else {
                        toast.el.style.transition = 'transform .2s, opacity .2s';
                        toast.el.style.transform = '';
                        toast.el.style.opacity = '';
                    }
                    Toast._draggedToast = null;
                }
            }
            
            /**
            * Get x position of mouse or touch event
            * @param {Event} e
            */
            
        }, {
            key: "_xPos",
            value: function _xPos(e) {
                if (e.targetTouches && e.targetTouches.length >= 1) {
                    return e.targetTouches[0].clientX;
                }
                // mouse event
                return e.clientX;
            }
            
            /**
            * Remove all toasts
            */
            
        }, {
            key: "dismissAll",
            value: function dismissAll() {
                for (var toastIndex in Toast._toasts) {
                    Toast._toasts[toastIndex].dismiss();
                }
            }
        }, {
            key: "defaults",
            get: function () {
                return _defaults;
            }
        }]);
        
        return Toast;
    }();
    
    /**
    * @static
    * @memberof Toast
    * @type {Array.<Toast>}
    */
    
    
    Toast._toasts = [];
    
    /**
    * @static
    * @memberof Toast
    */
    Toast._container = null;
    
    /**
    * @static
    * @memberof Toast
    * @type {Toast}
    */
    Toast._draggedToast = null;
    
    M.Toast = Toast;
    M.toast = function (options) {
        return new Toast(options);
    };
})(cash, M.anime);
;(function ($, anim) {
    'use strict';
    
    var _defaults = {
        edge: 'left',
        draggable: true,
        inDuration: 250,
        outDuration: 200,
        onOpenStart: null,
        onOpenEnd: null,
        onCloseStart: null,
        onCloseEnd: null,
        preventScrolling: true
    };
    
    /**
    * @class
    */
    
    var Sidenav = function (_Component8) {
        _inherits(Sidenav, _Component8);
        
        /**
        * Construct Sidenav instance and set up overlay
        * @constructor
        * @param {Element} el
        * @param {Object} options
        */
        function Sidenav(el, options) {
            _classCallCheck(this, Sidenav);
            
            var _this30 = _possibleConstructorReturn(this, (Sidenav.__proto__ || Object.getPrototypeOf(Sidenav)).call(this, Sidenav, el, options));
            
            _this30.el.M_Sidenav = _this30;
            _this30.id = _this30.$el.attr('id');
            
            /**
            * Options for the Sidenav
            * @member Sidenav#options
            * @prop {String} [edge='left'] - Side of screen on which Sidenav appears
            * @prop {Boolean} [draggable=true] - Allow swipe gestures to open/close Sidenav
            * @prop {Number} [inDuration=250] - Length in ms of enter transition
            * @prop {Number} [outDuration=200] - Length in ms of exit transition
            * @prop {Function} onOpenStart - Function called when sidenav starts entering
            * @prop {Function} onOpenEnd - Function called when sidenav finishes entering
            * @prop {Function} onCloseStart - Function called when sidenav starts exiting
            * @prop {Function} onCloseEnd - Function called when sidenav finishes exiting
            */
            _this30.options = $.extend({}, Sidenav.defaults, options);
            
            /**
            * Describes open/close state of Sidenav
            * @type {Boolean}
            */
            _this30.isOpen = false;
            
            /**
            * Describes if Sidenav is fixed
            * @type {Boolean}
            */
            _this30.isFixed = _this30.el.classList.contains('sidenav-fixed');
            
            /**
            * Describes if Sidenav is being draggeed
            * @type {Boolean}
            */
            _this30.isDragged = false;
            
            // Window size variables for window resize checks
            _this30.lastWindowWidth = window.innerWidth;
            _this30.lastWindowHeight = window.innerHeight;
            
            _this30._createOverlay();
            _this30._createDragTarget();
            _this30._setupEventHandlers();
            _this30._setupClasses();
            _this30._setupFixed();
            
            Sidenav._sidenavs.push(_this30);
            return _this30;
        }
        
        _createClass(Sidenav, [{
            key: "destroy",
            
            
            /**
            * Teardown component
            */
            value: function destroy() {
                this._removeEventHandlers();
                this._overlay.parentNode.removeChild(this._overlay);
                this.dragTarget.parentNode.removeChild(this.dragTarget);
                this.el.M_Sidenav = undefined;
                
                var index = Sidenav._sidenavs.indexOf(this);
                if (index >= 0) {
                    Sidenav._sidenavs.splice(index, 1);
                }
            }
        }, {
            key: "_createOverlay",
            value: function _createOverlay() {
                var overlay = document.createElement('div');
                this._closeBound = this.close.bind(this);
                overlay.classList.add('sidenav-overlay');
                
                overlay.addEventListener('click', this._closeBound);
                
                document.body.appendChild(overlay);
                this._overlay = overlay;
            }
        }, {
            key: "_setupEventHandlers",
            value: function _setupEventHandlers() {
                if (Sidenav._sidenavs.length === 0) {
                    document.body.addEventListener('click', this._handleTriggerClick);
                }
                
                this._handleDragTargetDragBound = this._handleDragTargetDrag.bind(this);
                this._handleDragTargetReleaseBound = this._handleDragTargetRelease.bind(this);
                this._handleCloseDragBound = this._handleCloseDrag.bind(this);
                this._handleCloseReleaseBound = this._handleCloseRelease.bind(this);
                this._handleCloseTriggerClickBound = this._handleCloseTriggerClick.bind(this);
                
                this.dragTarget.addEventListener('touchmove', this._handleDragTargetDragBound);
                this.dragTarget.addEventListener('touchend', this._handleDragTargetReleaseBound);
                this._overlay.addEventListener('touchmove', this._handleCloseDragBound);
                this._overlay.addEventListener('touchend', this._handleCloseReleaseBound);
                this.el.addEventListener('touchmove', this._handleCloseDragBound);
                this.el.addEventListener('touchend', this._handleCloseReleaseBound);
                this.el.addEventListener('click', this._handleCloseTriggerClickBound);
                
                // Add resize for side nav fixed
                if (this.isFixed) {
                    this._handleWindowResizeBound = this._handleWindowResize.bind(this);
                    window.addEventListener('resize', this._handleWindowResizeBound);
                }
            }
        }, {
            key: "_removeEventHandlers",
            value: function _removeEventHandlers() {
                if (Sidenav._sidenavs.length === 1) {
                    document.body.removeEventListener('click', this._handleTriggerClick);
                }
                
                this.dragTarget.removeEventListener('touchmove', this._handleDragTargetDragBound);
                this.dragTarget.removeEventListener('touchend', this._handleDragTargetReleaseBound);
                this._overlay.removeEventListener('touchmove', this._handleCloseDragBound);
                this._overlay.removeEventListener('touchend', this._handleCloseReleaseBound);
                this.el.removeEventListener('touchmove', this._handleCloseDragBound);
                this.el.removeEventListener('touchend', this._handleCloseReleaseBound);
                this.el.removeEventListener('click', this._handleCloseTriggerClickBound);
                
                // Remove resize for side nav fixed
                if (this.isFixed) {
                    window.removeEventListener('resize', this._handleWindowResizeBound);
                }
            }
            
            /**
            * Handle Trigger Click
            * @param {Event} e
            */
            
        }, {
            key: "_handleTriggerClick",
            value: function _handleTriggerClick(e) {
                var $trigger = $(e.target).closest('.sidenav-trigger');
                if (e.target && $trigger.length) {
                    var sidenavId = M.getIdFromTrigger($trigger[0]);
                    
                    var sidenavInstance = document.getElementById(sidenavId).M_Sidenav;
                    if (sidenavInstance) {
                        sidenavInstance.open($trigger);
                    }
                    e.preventDefault();
                }
            }
            
            /**
            * Set variables needed at the beggining of drag
            * and stop any current transition.
            * @param {Event} e
            */
            
        }, {
            key: "_startDrag",
            value: function _startDrag(e) {
                var clientX = e.targetTouches[0].clientX;
                this.isDragged = true;
                this._startingXpos = clientX;
                this._xPos = this._startingXpos;
                this._time = Date.now();
                this._width = this.el.getBoundingClientRect().width;
                this._overlay.style.display = 'block';
                this._initialScrollTop = this.isOpen ? this.el.scrollTop : M.getDocumentScrollTop();
                this._verticallyScrolling = false;
                anim.remove(this.el);
                anim.remove(this._overlay);
            }
            
            /**
            * Set variables needed at each drag move update tick
            * @param {Event} e
            */
            
        }, {
            key: "_dragMoveUpdate",
            value: function _dragMoveUpdate(e) {
                var clientX = e.targetTouches[0].clientX;
                var currentScrollTop = this.isOpen ? this.el.scrollTop : M.getDocumentScrollTop();
                this.deltaX = Math.abs(this._xPos - clientX);
                this._xPos = clientX;
                this.velocityX = this.deltaX / (Date.now() - this._time);
                this._time = Date.now();
                if (this._initialScrollTop !== currentScrollTop) {
                    this._verticallyScrolling = true;
                }
            }
            
            /**
            * Handles Dragging of Sidenav
            * @param {Event} e
            */
            
        }, {
            key: "_handleDragTargetDrag",
            value: function _handleDragTargetDrag(e) {
                // Check if draggable
                if (!this.options.draggable || this._isCurrentlyFixed() || this._verticallyScrolling) {
                    return;
                }
                
                // If not being dragged, set initial drag start variables
                if (!this.isDragged) {
                    this._startDrag(e);
                }
                
                // Run touchmove updates
                this._dragMoveUpdate(e);
                
                // Calculate raw deltaX
                var totalDeltaX = this._xPos - this._startingXpos;
                
                // dragDirection is the attempted user drag direction
                var dragDirection = totalDeltaX > 0 ? 'right' : 'left';
                
                // Don't allow totalDeltaX to exceed Sidenav width or be dragged in the opposite direction
                totalDeltaX = Math.min(this._width, Math.abs(totalDeltaX));
                if (this.options.edge === dragDirection) {
                    totalDeltaX = 0;
                }
                
                /**
                * transformX is the drag displacement
                * transformPrefix is the initial transform placement
                * Invert values if Sidenav is right edge
                */
                var transformX = totalDeltaX;
                var transformPrefix = 'translateX(-100%)';
                if (this.options.edge === 'right') {
                    transformPrefix = 'translateX(100%)';
                    transformX = -transformX;
                }
                
                // Calculate open/close percentage of sidenav, with open = 1 and close = 0
                this.percentOpen = Math.min(1, totalDeltaX / this._width);
                
                // Set transform and opacity styles
                this.el.style.transform = transformPrefix + " translateX(" + transformX + "px)";
                this._overlay.style.opacity = this.percentOpen;
            }
            
            /**
            * Handle Drag Target Release
            */
            
        }, {
            key: "_handleDragTargetRelease",
            value: function _handleDragTargetRelease() {
                if (this.isDragged) {
                    if (this.percentOpen > .5) {
                        this.open();
                    } else {
                        this._animateOut();
                    }
                    
                    this.isDragged = false;
                    this._verticallyScrolling = false;
                }
            }
            
            /**
            * Handle Close Drag
            * @param {Event} e
            */
            
        }, {
            key: "_handleCloseDrag",
            value: function _handleCloseDrag(e) {
                if (this.isOpen) {
                    // Check if draggable
                    if (!this.options.draggable || this._isCurrentlyFixed() || this._verticallyScrolling) {
                        return;
                    }
                    
                    // If not being dragged, set initial drag start variables
                    if (!this.isDragged) {
                        this._startDrag(e);
                    }
                    
                    // Run touchmove updates
                    this._dragMoveUpdate(e);
                    
                    // Calculate raw deltaX
                    var totalDeltaX = this._xPos - this._startingXpos;
                    
                    // dragDirection is the attempted user drag direction
                    var dragDirection = totalDeltaX > 0 ? 'right' : 'left';
                    
                    // Don't allow totalDeltaX to exceed Sidenav width or be dragged in the opposite direction
                    totalDeltaX = Math.min(this._width, Math.abs(totalDeltaX));
                    if (this.options.edge !== dragDirection) {
                        totalDeltaX = 0;
                    }
                    
                    var transformX = -totalDeltaX;
                    if (this.options.edge === 'right') {
                        transformX = -transformX;
                    }
                    
                    // Calculate open/close percentage of sidenav, with open = 1 and close = 0
                    this.percentOpen = Math.min(1, 1 - totalDeltaX / this._width);
                    
                    // Set transform and opacity styles
                    this.el.style.transform = "translateX(" + transformX + "px)";
                    this._overlay.style.opacity = this.percentOpen;
                }
            }
            
            /**
            * Handle Close Release
            */
            
        }, {
            key: "_handleCloseRelease",
            value: function _handleCloseRelease() {
                if (this.isOpen && this.isDragged) {
                    if (this.percentOpen > .5) {
                        this._animateIn();
                    } else {
                        this.close();
                    }
                    
                    this.isDragged = false;
                    this._verticallyScrolling = false;
                }
            }
            
            /**
            * Handles closing of Sidenav when element with class .sidenav-close
            */
            
        }, {
            key: "_handleCloseTriggerClick",
            value: function _handleCloseTriggerClick(e) {
                var $closeTrigger = $(e.target).closest('.sidenav-close');
                if ($closeTrigger.length && !this._isCurrentlyFixed()) {
                    this.close();
                }
            }
            
            /**
            * Handle Window Resize
            */
            
        }, {
            key: "_handleWindowResize",
            value: function _handleWindowResize() {
                // Only handle horizontal resizes
                if (this.lastWindowWidth !== window.innerWidth) {
                    if (window.innerWidth > 992) {
                        this.open();
                    } else {
                        this.close();
                    }
                }
                
                this.lastWindowWidth = window.innerWidth;
                this.lastWindowHeight = window.innerHeight;
            }
        }, {
            key: "_setupClasses",
            value: function _setupClasses() {
                if (this.options.edge === 'right') {
                    this.el.classList.add('right-aligned');
                    this.dragTarget.classList.add('right-aligned');
                }
            }
        }, {
            key: "_removeClasses",
            value: function _removeClasses() {
                this.el.classList.remove('right-aligned');
                this.dragTarget.classList.remove('right-aligned');
            }
        }, {
            key: "_setupFixed",
            value: function _setupFixed() {
                if (this._isCurrentlyFixed()) {
                    this.open();
                }
            }
        }, {
            key: "_isCurrentlyFixed",
            value: function _isCurrentlyFixed() {
                return this.isFixed && window.innerWidth > 992;
            }
        }, {
            key: "_createDragTarget",
            value: function _createDragTarget() {
                var dragTarget = document.createElement('div');
                dragTarget.classList.add('drag-target');
                document.body.appendChild(dragTarget);
                this.dragTarget = dragTarget;
            }
        }, {
            key: "_preventBodyScrolling",
            value: function _preventBodyScrolling() {
                var body = document.body;
                body.style.overflow = 'hidden';
            }
        }, {
            key: "_enableBodyScrolling",
            value: function _enableBodyScrolling() {
                var body = document.body;
                body.style.overflow = '';
            }
        }, {
            key: "open",
            value: function open() {
                if (this.isOpen === true) {
                    return;
                }
                
                this.isOpen = true;
                
                // Run onOpenStart callback
                if (typeof this.options.onOpenStart === 'function') {
                    this.options.onOpenStart.call(this, this.el);
                }
                
                // Handle fixed Sidenav
                if (this._isCurrentlyFixed()) {
                    anim.remove(this.el);
                    anim({
                        targets: this.el,
                        translateX: 0,
                        duration: 0,
                        easing: 'easeOutQuad'
                    });
                    this._enableBodyScrolling();
                    this._overlay.style.display = 'none';
                    
                    // Handle non-fixed Sidenav
                } else {
                    if (this.options.preventScrolling) {
                        this._preventBodyScrolling();
                    }
                    
                    if (!this.isDragged || this.percentOpen != 1) {
                        this._animateIn();
                    }
                }
            }
        }, {
            key: "close",
            value: function close() {
                if (this.isOpen === false) {
                    return;
                }
                
                this.isOpen = false;
                
                // Run onCloseStart callback
                if (typeof this.options.onCloseStart === 'function') {
                    this.options.onCloseStart.call(this, this.el);
                }
                
                // Handle fixed Sidenav
                if (this._isCurrentlyFixed()) {
                    var transformX = this.options.edge === 'left' ? '-105%' : '105%';
                    this.el.style.transform = "translateX(" + transformX + ")";
                    
                    // Handle non-fixed Sidenav
                } else {
                    this._enableBodyScrolling();
                    
                    if (!this.isDragged || this.percentOpen != 0) {
                        this._animateOut();
                    } else {
                        this._overlay.style.display = 'none';
                    }
                }
            }
        }, {
            key: "_animateIn",
            value: function _animateIn() {
                this._animateSidenavIn();
                this._animateOverlayIn();
            }
        }, {
            key: "_animateSidenavIn",
            value: function _animateSidenavIn() {
                var _this31 = this;
                
                var slideOutPercent = this.options.edge === 'left' ? -1 : 1;
                if (this.isDragged) {
                    slideOutPercent = this.options.edge === 'left' ? slideOutPercent + this.percentOpen : slideOutPercent - this.percentOpen;
                }
                
                anim.remove(this.el);
                anim({
                    targets: this.el,
                    translateX: [slideOutPercent * 100 + "%", 0],
                    duration: this.options.inDuration,
                    easing: 'easeOutQuad',
                    complete: function () {
                        // Run onOpenEnd callback
                        if (typeof _this31.options.onOpenEnd === 'function') {
                            _this31.options.onOpenEnd.call(_this31, _this31.el);
                        }
                    }
                });
            }
        }, {
            key: "_animateOverlayIn",
            value: function _animateOverlayIn() {
                var start = 0;
                if (this.isDragged) {
                    start = this.percentOpen;
                } else {
                    $(this._overlay).css({
                        display: 'block'
                    });
                }
                
                anim.remove(this._overlay);
                anim({
                    targets: this._overlay,
                    opacity: [start, 1],
                    duration: this.options.inDuration,
                    easing: 'easeOutQuad'
                });
            }
        }, {
            key: "_animateOut",
            value: function _animateOut() {
                this._animateSidenavOut();
                this._animateOverlayOut();
            }
        }, {
            key: "_animateSidenavOut",
            value: function _animateSidenavOut() {
                var _this32 = this;
                
                var endPercent = this.options.edge === 'left' ? -1 : 1;
                var slideOutPercent = 0;
                if (this.isDragged) {
                    slideOutPercent = this.options.edge === 'left' ? endPercent + this.percentOpen : endPercent - this.percentOpen;
                }
                
                anim.remove(this.el);
                anim({
                    targets: this.el,
                    translateX: [slideOutPercent * 100 + "%", endPercent * 105 + "%"],
                    duration: this.options.outDuration,
                    easing: 'easeOutQuad',
                    complete: function () {
                        // Run onOpenEnd callback
                        if (typeof _this32.options.onCloseEnd === 'function') {
                            _this32.options.onCloseEnd.call(_this32, _this32.el);
                        }
                    }
                });
            }
        }, {
            key: "_animateOverlayOut",
            value: function _animateOverlayOut() {
                var _this33 = this;
                
                anim.remove(this._overlay);
                anim({
                    targets: this._overlay,
                    opacity: 0,
                    duration: this.options.outDuration,
                    easing: 'easeOutQuad',
                    complete: function () {
                        $(_this33._overlay).css('display', 'none');
                    }
                });
            }
        }], [{
            key: "init",
            value: function init(els, options) {
                return _get(Sidenav.__proto__ || Object.getPrototypeOf(Sidenav), "init", this).call(this, this, els, options);
            }
            
            /**
            * Get Instance
            */
            
        }, {
            key: "getInstance",
            value: function getInstance(el) {
                var domElem = !!el.jquery ? el[0] : el;
                return domElem.M_Sidenav;
            }
        }, {
            key: "defaults",
            get: function () {
                return _defaults;
            }
        }]);
        
        return Sidenav;
    }(Component);
    
    /**
    * @static
    * @memberof Sidenav
    * @type {Array.<Sidenav>}
    */
    
    
    Sidenav._sidenavs = [];
    
    window.M.Sidenav = Sidenav;
    
    if (M.jQueryLoaded) {
        M.initializeJqueryWrapper(Sidenav, 'sidenav', 'M_Sidenav');
    }
})(cash, M.anime);
;(function ($) {
    // Function to update labels of text fields
    M.updateTextFields = function () {
        var input_selector = 'input[type=text], input[type=password], input[type=email], input[type=url], input[type=tel], input[type=number], input[type=search], input[type=date], input[type=time], textarea';
        $(input_selector).each(function (element, index) {
            var $this = $(this);
            if (element.value.length > 0 || $(element).is(':focus') || element.autofocus || $this.attr('placeholder') !== null) {
                $this.siblings('label').addClass('active');
            } else if (element.validity) {
                $this.siblings('label').toggleClass('active', element.validity.badInput === true);
            } else {
                $this.siblings('label').removeClass('active');
            }
        });
    };
    
    M.validate_field = function (object) {
        var hasLength = object.attr('data-length') !== null;
        var lenAttr = parseInt(object.attr('data-length'));
        var len = object[0].value.length;
        
        if (len === 0 && object[0].validity.badInput === false && !object.is(':required')) {
            if (object.hasClass('validate')) {
                object.removeClass('valid');
                object.removeClass('invalid');
            }
        } else {
            if (object.hasClass('validate')) {
                // Check for character counter attributes
                if (object.is(':valid') && hasLength && len <= lenAttr || object.is(':valid') && !hasLength) {
                    object.removeClass('invalid');
                    object.addClass('valid');
                } else {
                    object.removeClass('valid');
                    object.addClass('invalid');
                }
            }
        }
    };
    
    M.textareaAutoResize = function ($textarea) {
        // Wrap if native element
        if ($textarea instanceof Element) {
            $textarea = $($textarea);
        }
        
        if (!$textarea.length) {
            console.error("No textarea element found");
            return;
        }
        
        // Textarea Auto Resize
        var hiddenDiv = $('.hiddendiv').first();
        if (!hiddenDiv.length) {
            hiddenDiv = $('<div class="hiddendiv common"></div>');
            $('body').append(hiddenDiv);
        }
        
        // Set font properties of hiddenDiv
        var fontFamily = $textarea.css('font-family');
        var fontSize = $textarea.css('font-size');
        var lineHeight = $textarea.css('line-height');
        
        // Firefox can't handle padding shorthand.
        var paddingTop = $textarea.css('padding-top');
        var paddingRight = $textarea.css('padding-right');
        var paddingBottom = $textarea.css('padding-bottom');
        var paddingLeft = $textarea.css('padding-left');
        
        if (fontSize) {
            hiddenDiv.css('font-size', fontSize);
        }
        if (fontFamily) {
            hiddenDiv.css('font-family', fontFamily);
        }
        if (lineHeight) {
            hiddenDiv.css('line-height', lineHeight);
        }
        if (paddingTop) {
            hiddenDiv.css('padding-top', paddingTop);
        }
        if (paddingRight) {
            hiddenDiv.css('padding-right', paddingRight);
        }
        if (paddingBottom) {
            hiddenDiv.css('padding-bottom', paddingBottom);
        }
        if (paddingLeft) {
            hiddenDiv.css('padding-left', paddingLeft);
        }
        
        // Set original-height, if none
        if (!$textarea.data('original-height')) {
            $textarea.data('original-height', $textarea.height());
        }
        
        if ($textarea.attr('wrap') === 'off') {
            hiddenDiv.css('overflow-wrap', 'normal').css('white-space', 'pre');
        }
        
        hiddenDiv.text($textarea[0].value + '\n');
        var content = hiddenDiv.html().replace(/\n/g, '<br>');
        hiddenDiv.html(content);
        
        // When textarea is hidden, width goes crazy.
        // Approximate with half of window size
        
        if ($textarea[0].offsetWidth > 0 && $textarea[0].offsetHeight > 0) {
            hiddenDiv.css('width', $textarea.width() + 'px');
        } else {
            hiddenDiv.css('width', window.innerWidth / 2 + 'px');
        }
        
        /**
        * Resize if the new height is greater than the
        * original height of the textarea
        */
        if ($textarea.data('original-height') <= hiddenDiv.innerHeight()) {
            $textarea.css('height', hiddenDiv.innerHeight() + 'px');
        } else if ($textarea[0].value.length < $textarea.data('previous-length')) {
            /**
            * In case the new height is less than original height, it
            * means the textarea has less text than before
            * So we set the height to the original one
            */
            $textarea.css('height', $textarea.data('original-height') + 'px');
        }
        $textarea.data('previous-length', $textarea[0].value.length);
    };
    
    $(document).ready(function () {
        // Text based inputs
        var input_selector = 'input[type=text], input[type=password], input[type=email], input[type=url], input[type=tel], input[type=number], input[type=search], input[type=date], input[type=time], textarea';
        
        // Add active if form auto complete
        $(document).on('change', input_selector, function () {
            if (this.value.length !== 0 || $(this).attr('placeholder') !== null) {
                $(this).siblings('label').addClass('active');
            }
            M.validate_field($(this));
        });
        
        // Add active if input element has been pre-populated on document ready
        $(document).ready(function () {
            M.updateTextFields();
        });
        
        // HTML DOM FORM RESET handling
        $(document).on('reset', function (e) {
            var formReset = $(e.target);
            if (formReset.is('form')) {
                formReset.find(input_selector).removeClass('valid').removeClass('invalid');
                formReset.find(input_selector).each(function (e) {
                    if (this.value.length) {
                        $(this).siblings('label').removeClass('active');
                    }
                });
            }
        });
        
        /**
        * Add active when element has focus
        * @param {Event} e
        */
        document.addEventListener('focus', function (e) {
            if ($(e.target).is(input_selector)) {
                $(e.target).siblings('label, .prefix').addClass('active');
            }
        }, true);
        
        /**
        * Remove active when element is blurred
        * @param {Event} e
        */
        document.addEventListener('blur', function (e) {
            var $inputElement = $(e.target);
            if ($inputElement.is(input_selector)) {
                var selector = ".prefix";
                
                if ($inputElement[0].value.length === 0 && $inputElement[0].validity.badInput !== true && $inputElement.attr('placeholder') === null) {
                    selector += ", label";
                }
                $inputElement.siblings(selector).removeClass('active');
                M.validate_field($inputElement);
            }
        }, true);
        
        // Radio and Checkbox focus class
        var radio_checkbox = 'input[type=radio], input[type=checkbox]';
        $(document).on('keyup', radio_checkbox, function (e) {
            // TAB, check if tabbing to radio or checkbox.
            if (e.which === M.keys.TAB) {
                $(this).addClass('tabbed');
                var $this = $(this);
                $this.one('blur', function (e) {
                    $(this).removeClass('tabbed');
                });
                return;
            }
        });
        
        var text_area_selector = '.materialize-textarea';
        $(text_area_selector).each(function () {
            var $textarea = $(this);
            /**
            * Resize textarea on document load after storing
            * the original height and the original length
            */
            $textarea.data('original-height', $textarea.height());
            $textarea.data('previous-length', this.value.length);
            M.textareaAutoResize($textarea);
        });
        
        $(document).on('keyup', text_area_selector, function () {
            M.textareaAutoResize($(this));
        });
        $(document).on('keydown', text_area_selector, function () {
            M.textareaAutoResize($(this));
        });
        
        // File Input Path
        $(document).on('change', '.file-field input[type="file"]', function () {
            var file_field = $(this).closest('.file-field');
            var path_input = file_field.find('input.file-path');
            var files = $(this)[0].files;
            var file_names = [];
            for (var i = 0; i < files.length; i++) {
                file_names.push(files[i].name);
            }
            path_input[0].value = file_names.join(", ");
            path_input.trigger('change');
        });
    }); // End of $(document).ready
})(cash);
;(function ($, anim) {
    'use strict';
    
    var _defaults = {
        indicators: true,
        height: 400,
        duration: 500,
        interval: 6000
    };
    
    /**
    * @class
    *
    */
    
    var Slider = function (_Component11) {
        _inherits(Slider, _Component11);
        
        /**
        * Construct Slider instance and set up overlay
        * @constructor
        * @param {Element} el
        * @param {Object} options
        */
        function Slider(el, options) {
            _classCallCheck(this, Slider);
            
            var _this39 = _possibleConstructorReturn(this, (Slider.__proto__ || Object.getPrototypeOf(Slider)).call(this, Slider, el, options));
            
            _this39.el.M_Slider = _this39;
            
            /**
            * Options for the modal
            * @member Slider#options
            * @prop {Boolean} [indicators=true] - Show indicators
            * @prop {Number} [height=400] - height of slider
            * @prop {Number} [duration=500] - Length in ms of slide transition
            * @prop {Number} [interval=6000] - Length in ms of slide interval
            */
            _this39.options = $.extend({}, Slider.defaults, options);
            
            // setup
            _this39.$slider = _this39.$el.find('.slides');
            _this39.$slides = _this39.$slider.children('li');
            _this39.activeIndex = _this39.$slides.filter(function (item) {
                return $(item).hasClass('active');
            }).first().index();
            if (_this39.activeIndex != -1) {
                _this39.$active = _this39.$slides.eq(_this39.activeIndex);
            }
            
            _this39._setSliderHeight();
            
            // Set initial positions of captions
            _this39.$slides.find('.caption').each(function (el) {
                _this39._animateCaptionIn(el, 0);
            });
            
            // Move img src into background-image
            _this39.$slides.find('img').each(function (el) {
                var placeholderBase64 = 'data:image/gif;base64,R0lGODlhAQABAIABAP///wAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';
                if ($(el).attr('src') !== placeholderBase64) {
                    $(el).css('background-image', 'url("' + $(el).attr('src') + '")');
                    $(el).attr('src', placeholderBase64);
                }
            });
            
            _this39._setupIndicators();
            
            // Show active slide
            if (_this39.$active) {
                _this39.$active.css('display', 'block');
            } else {
                _this39.$slides.first().addClass('active');
                anim({
                    targets: _this39.$slides.first()[0],
                    opacity: 1,
                    duration: _this39.options.duration,
                    easing: 'easeOutQuad'
                });
                
                _this39.activeIndex = 0;
                _this39.$active = _this39.$slides.eq(_this39.activeIndex);
                
                // Update indicators
                if (_this39.options.indicators) {
                    _this39.$indicators.eq(_this39.activeIndex).addClass('active');
                }
            }
            
            // Adjust height to current slide
            _this39.$active.find('img').each(function (el) {
                anim({
                    targets: _this39.$active.find('.caption')[0],
                    opacity: 1,
                    translateX: 0,
                    translateY: 0,
                    duration: _this39.options.duration,
                    easing: 'easeOutQuad'
                });
            });
            
            _this39._setupEventHandlers();
            
            // auto scroll
            _this39.start();
            return _this39;
        }
        
        _createClass(Slider, [{
            key: "destroy",
            
            
            /**
            * Teardown component
            */
            value: function destroy() {
                this.pause();
                this._removeIndicators();
                this._removeEventHandlers();
                this.el.M_Slider = undefined;
            }
            
            /**
            * Setup Event Handlers
            */
            
        }, {
            key: "_setupEventHandlers",
            value: function _setupEventHandlers() {
                var _this40 = this;
                
                this._handleIntervalBound = this._handleInterval.bind(this);
                this._handleIndicatorClickBound = this._handleIndicatorClick.bind(this);
                
                if (this.options.indicators) {
                    this.$indicators.each(function (el) {
                        el.addEventListener('click', _this40._handleIndicatorClickBound);
                    });
                }
            }
            
            /**
            * Remove Event Handlers
            */
            
        }, {
            key: "_removeEventHandlers",
            value: function _removeEventHandlers() {
                var _this41 = this;
                
                if (this.options.indicators) {
                    this.$indicators.each(function (el) {
                        el.removeEventListener('click', _this41._handleIndicatorClickBound);
                    });
                }
            }
            
            /**
            * Handle indicator click
            * @param {Event} e
            */
            
        }, {
            key: "_handleIndicatorClick",
            value: function _handleIndicatorClick(e) {
                var currIndex = $(e.target).index();
                this.set(currIndex);
            }
            
            /**
            * Handle Interval
            */
            
        }, {
            key: "_handleInterval",
            value: function _handleInterval() {
                var newActiveIndex = this.$slider.find('.active').index();
                if (this.$slides.length === newActiveIndex + 1) newActiveIndex = 0; // loop to start
                else newActiveIndex += 1;
                
                this.set(newActiveIndex);
            }
            
            /**
            * Animate in caption
            * @param {Element} caption
            * @param {Number} duration
            */
            
        }, {
            key: "_animateCaptionIn",
            value: function _animateCaptionIn(caption, duration) {
                var animOptions = {
                    targets: caption,
                    opacity: 0,
                    duration: duration,
                    easing: 'easeOutQuad'
                };
                
                if ($(caption).hasClass('center-align')) {
                    animOptions.translateY = -100;
                } else if ($(caption).hasClass('right-align')) {
                    animOptions.translateX = 100;
                } else if ($(caption).hasClass('left-align')) {
                    animOptions.translateX = -100;
                }
                
                anim(animOptions);
            }
            
            /**
            * Set height of slider
            */
            
        }, {
            key: "_setSliderHeight",
            value: function _setSliderHeight() {
                // If fullscreen, do nothing
                if (!this.$el.hasClass('fullscreen')) {
                    if (this.options.indicators) {
                        // Add height if indicators are present
                        this.$el.css('height', this.options.height + 40 + 'px');
                    } else {
                        this.$el.css('height', this.options.height + 'px');
                    }
                    this.$slider.css('height', this.options.height + 'px');
                }
            }
            
            /**
            * Setup indicators
            */
            
        }, {
            key: "_setupIndicators",
            value: function _setupIndicators() {
                var _this42 = this;
                
                if (this.options.indicators) {
                    this.$indicators = $('<ul class="indicators"></ul>');
                    this.$slides.each(function (el, index) {
                        var $indicator = $('<li class="indicator-item"></li>');
                        _this42.$indicators.append($indicator[0]);
                    });
                    this.$el.append(this.$indicators[0]);
                    this.$indicators = this.$indicators.children('li.indicator-item');
                }
            }
            
            /**
            * Remove indicators
            */
            
        }, {
            key: "_removeIndicators",
            value: function _removeIndicators() {
                this.$el.find('ul.indicators').remove();
            }
            
            /**
            * Cycle to nth item
            * @param {Number} index
            */
            
        }, {
            key: "set",
            value: function set(index) {
                var _this43 = this;
                
                // Wrap around indices.
                if (index >= this.$slides.length) index = 0;else if (index < 0) index = this.$slides.length - 1;
                
                // Only do if index changes
                if (this.activeIndex != index) {
                    this.$active = this.$slides.eq(this.activeIndex);
                    var $caption = this.$active.find('.caption');
                    this.$active.removeClass('active');
                    
                    anim({
                        targets: this.$active[0],
                        opacity: 0,
                        duration: this.options.duration,
                        easing: 'easeOutQuad',
                        complete: function () {
                            _this43.$slides.not('.active').each(function (el) {
                                anim({
                                    targets: el,
                                    opacity: 0,
                                    translateX: 0,
                                    translateY: 0,
                                    duration: 0,
                                    easing: 'easeOutQuad'
                                });
                            });
                        }
                    });
                    
                    this._animateCaptionIn($caption[0], this.options.duration);
                    
                    // Update indicators
                    if (this.options.indicators) {
                        this.$indicators.eq(this.activeIndex).removeClass('active');
                        this.$indicators.eq(index).addClass('active');
                    }
                    
                    anim({
                        targets: this.$slides.eq(index)[0],
                        opacity: 1,
                        duration: this.options.duration,
                        easing: 'easeOutQuad'
                    });
                    
                    anim({
                        targets: this.$slides.eq(index).find('.caption')[0],
                        opacity: 1,
                        translateX: 0,
                        translateY: 0,
                        duration: this.options.duration,
                        delay: this.options.duration,
                        easing: 'easeOutQuad'
                    });
                    
                    this.$slides.eq(index).addClass('active');
                    this.activeIndex = index;
                    
                    // Reset interval
                    this.start();
                }
            }
            
            /**
            * Pause slider interval
            */
            
        }, {
            key: "pause",
            value: function pause() {
                clearInterval(this.interval);
            }
            
            /**
            * Start slider interval
            */
            
        }, {
            key: "start",
            value: function start() {
                clearInterval(this.interval);
                this.interval = setInterval(this._handleIntervalBound, this.options.duration + this.options.interval);
            }
            
            /**
            * Move to next slide
            */
            
        }, {
            key: "next",
            value: function next() {
                var newIndex = this.activeIndex + 1;
                
                // Wrap around indices.
                if (newIndex >= this.$slides.length) newIndex = 0;else if (newIndex < 0) newIndex = this.$slides.length - 1;
                
                this.set(newIndex);
            }
            
            /**
            * Move to previous slide
            */
            
        }, {
            key: "prev",
            value: function prev() {
                var newIndex = this.activeIndex - 1;
                
                // Wrap around indices.
                if (newIndex >= this.$slides.length) newIndex = 0;else if (newIndex < 0) newIndex = this.$slides.length - 1;
                
                this.set(newIndex);
            }
        }], [{
            key: "init",
            value: function init(els, options) {
                return _get(Slider.__proto__ || Object.getPrototypeOf(Slider), "init", this).call(this, this, els, options);
            }
            
            /**
            * Get Instance
            */
            
        }, {
            key: "getInstance",
            value: function getInstance(el) {
                var domElem = !!el.jquery ? el[0] : el;
                return domElem.M_Slider;
            }
        }, {
            key: "defaults",
            get: function () {
                return _defaults;
            }
        }]);
        
        return Slider;
    }(Component);
    
    M.Slider = Slider;
    
    if (M.jQueryLoaded) {
        M.initializeJqueryWrapper(Slider, 'slider', 'M_Slider');
    }
})(cash, M.anime);
;(function ($, anim) {
    $(document).on('click', '.card', function (e) {
        if ($(this).children('.card-reveal').length) {
            var $card = $(e.target).closest('.card');
            if ($card.data('initialOverflow') === undefined) {
                $card.data('initialOverflow', $card.css('overflow') === undefined ? '' : $card.css('overflow'));
            }
            var $cardReveal = $(this).find('.card-reveal');
            if ($(e.target).is($('.card-reveal .card-title')) || $(e.target).is($('.card-reveal .card-title i'))) {
                // Make Reveal animate down and display none
                anim({
                    targets: $cardReveal[0],
                    translateY: 0,
                    duration: 225,
                    easing: 'easeInOutQuad',
                    complete: function (anim) {
                        var el = anim.animatables[0].target;
                        $(el).css({ display: 'none' });
                        $card.css('overflow', $card.data('initialOverflow'));
                    }
                });
            } else if ($(e.target).is($('.card .activator')) || $(e.target).is($('.card .activator i'))) {
                $card.css('overflow', 'hidden');
                $cardReveal.css({ display: 'block' });
                anim({
                    targets: $cardReveal[0],
                    translateY: '-100%',
                    duration: 300,
                    easing: 'easeInOutQuad'
                });
            }
        }
    });
})(cash, M.anime);
;(function ($) {
    'use strict';

    var _defaults = {};

    /**
    * @class
    *
    */
    var CharacterCounter = function (_Component17) {
        _inherits(CharacterCounter, _Component17);

        /**
        * Construct CharacterCounter instance
        * @constructor
        * @param {Element} el
        * @param {Object} options
        */
        function CharacterCounter(el, options) {
            _classCallCheck(this, CharacterCounter);
            
            var _this60 = _possibleConstructorReturn(this, (CharacterCounter.__proto__ || Object.getPrototypeOf(CharacterCounter)).call(this, CharacterCounter, el, options));
            
            _this60.el.M_CharacterCounter = _this60;
            
            /**
            * Options for the character counter
            */
            _this60.options = $.extend({}, CharacterCounter.defaults, options);
            
            _this60.isInvalid = false;
            _this60.isValidLength = false;
            _this60._setupCounter();
            _this60._setupEventHandlers();
            return _this60;
        }
        
        _createClass(CharacterCounter, [{
            key: "destroy",
            
            
            /**
            * Teardown component
            */
            value: function destroy() {
                this._removeEventHandlers();
                this.el.CharacterCounter = undefined;
                this._removeCounter();
            }
            
            /**
            * Setup Event Handlers
            */
            
        }, {
            key: "_setupEventHandlers",
            value: function _setupEventHandlers() {
                this._handleUpdateCounterBound = this.updateCounter.bind(this);
                
                this.el.addEventListener('focus', this._handleUpdateCounterBound, true);
                this.el.addEventListener('input', this._handleUpdateCounterBound, true);
            }
            
            /**
            * Remove Event Handlers
            */
            
        }, {
            key: "_removeEventHandlers",
            value: function _removeEventHandlers() {
                this.el.removeEventListener('focus', this._handleUpdateCounterBound, true);
                this.el.removeEventListener('input', this._handleUpdateCounterBound, true);
            }
            
            /**
            * Setup counter element
            */
            
        }, {
            key: "_setupCounter",
            value: function _setupCounter() {
                this.counterEl = document.createElement('span');
                $(this.counterEl).addClass('character-counter').css({
                    float: 'right',
                    'font-size': '12px',
                    height: 1
                });
                
                this.$el.parent().append(this.counterEl);
            }
            
            /**
            * Remove counter element
            */
            
        }, {
            key: "_removeCounter",
            value: function _removeCounter() {
                $(this.counterEl).remove();
            }
            
            /**
            * Update counter
            */
            
        }, {
            key: "updateCounter",
            value: function updateCounter() {
                var maxLength = +this.$el.attr('data-length'),
                actualLength = this.el.value.length - 1;
                var linesCount = this.el.value.split('\n');
                this.isValidLength = actualLength <= maxLength;
                var counterString = actualLength + linesCount.length;
                
                if (maxLength) {
                    counterString += '/' + maxLength;
                    this._validateInput();
                }
                
                $(this.counterEl).html(counterString);
            }
            
            /**
            * Add validation classes
            */
            
        }, {
            key: "_validateInput",
            value: function _validateInput() {
                if (this.isValidLength && this.isInvalid) {
                    this.isInvalid = false;
                    this.$el.removeClass('invalid');
                } else if (!this.isValidLength && !this.isInvalid) {
                    this.isInvalid = true;
                    this.$el.removeClass('valid');
                    this.$el.addClass('invalid');
                }
            }
        }], [{
            key: "init",
            value: function init(els, options) {
                return _get(CharacterCounter.__proto__ || Object.getPrototypeOf(CharacterCounter), "init", this).call(this, this, els, options);
            }
            
            /**
            * Get Instance
            */
            
        }, {
            key: "getInstance",
            value: function getInstance(el) {
                var domElem = !!el.jquery ? el[0] : el;
                return domElem.M_CharacterCounter;
            }
        }, {
            key: "defaults",
            get: function () {
                return _defaults;
            }
        }]);
        
        return CharacterCounter;
    }(Component);
    
    M.CharacterCounter = CharacterCounter;
    
    if (M.jQueryLoaded) {
        M.initializeJqueryWrapper(CharacterCounter, 'characterCounter', 'M_CharacterCounter');
    }
})(cash);
;(function ($, anim) {
    'use strict';
    
    var _defaults = {};
    
    /**
    * @class
    *
    */
    
    var Range = function (_Component21) {
        _inherits(Range, _Component21);
        
        /**
        * Construct Range instance
        * @constructor
        * @param {Element} el
        * @param {Object} options
        */
        function Range(el, options) {
            _classCallCheck(this, Range);
            
            var _this71 = _possibleConstructorReturn(this, (Range.__proto__ || Object.getPrototypeOf(Range)).call(this, Range, el, options));
            
            _this71.el.M_Range = _this71;
            
            /**
            * Options for the range
            * @member Range#options
            */
            _this71.options = $.extend({}, Range.defaults, options);
            
            _this71._mousedown = false;
            
            // Setup
            _this71._setupThumb();
            
            _this71._setupEventHandlers();
            return _this71;
        }
        
        _createClass(Range, [{
            key: "destroy",
            
            
            /**
            * Teardown component
            */
            value: function destroy() {
                this._removeEventHandlers();
                this._removeThumb();
                this.el.M_Range = undefined;
            }
            
            /**
            * Setup Event Handlers
            */
            
        }, {
            key: "_setupEventHandlers",
            value: function _setupEventHandlers() {
                this._handleRangeChangeBound = this._handleRangeChange.bind(this);
                this._handleRangeFocusBound = this._handleRangeFocus.bind(this);
                this._handleRangeMousedownTouchstartBound = this._handleRangeMousedownTouchstart.bind(this);
                this._handleRangeInputMousemoveTouchmoveBound = this._handleRangeInputMousemoveTouchmove.bind(this);
                this._handleRangeMouseupTouchendBound = this._handleRangeMouseupTouchend.bind(this);
                this._handleRangeBlurMouseoutTouchleaveBound = this._handleRangeBlurMouseoutTouchleave.bind(this);
                
                this.el.addEventListener('change', this._handleRangeChangeBound);
                this.el.addEventListener('focus', this._handleRangeFocusBound);
                
                this.el.addEventListener('mousedown', this._handleRangeMousedownTouchstartBound);
                this.el.addEventListener('touchstart', this._handleRangeMousedownTouchstartBound);
                
                this.el.addEventListener('input', this._handleRangeInputMousemoveTouchmoveBound);
                this.el.addEventListener('mousemove', this._handleRangeInputMousemoveTouchmoveBound);
                this.el.addEventListener('touchmove', this._handleRangeInputMousemoveTouchmoveBound);
                
                this.el.addEventListener('mouseup', this._handleRangeMouseupTouchendBound);
                this.el.addEventListener('touchend', this._handleRangeMouseupTouchendBound);
                
                this.el.addEventListener('blur', this._handleRangeBlurMouseoutTouchleaveBound);
                this.el.addEventListener('mouseout', this._handleRangeBlurMouseoutTouchleaveBound);
                this.el.addEventListener('touchleave', this._handleRangeBlurMouseoutTouchleaveBound);
            }
            
            /**
            * Remove Event Handlers
            */
            
        }, {
            key: "_removeEventHandlers",
            value: function _removeEventHandlers() {
                this.el.removeEventListener('change', this._handleRangeChangeBound);
                this.el.removeEventListener('focus', this._handleRangeFocusBound);
                
                this.el.removeEventListener('mousedown', this._handleRangeMousedownTouchstartBound);
                this.el.removeEventListener('touchstart', this._handleRangeMousedownTouchstartBound);
                
                this.el.removeEventListener('input', this._handleRangeInputMousemoveTouchmoveBound);
                this.el.removeEventListener('mousemove', this._handleRangeInputMousemoveTouchmoveBound);
                this.el.removeEventListener('touchmove', this._handleRangeInputMousemoveTouchmoveBound);
                
                this.el.removeEventListener('mouseup', this._handleRangeMouseupTouchendBound);
                this.el.removeEventListener('touchend', this._handleRangeMouseupTouchendBound);
                
                this.el.removeEventListener('blur', this._handleRangeBlurMouseoutTouchleaveBound);
                this.el.removeEventListener('mouseout', this._handleRangeBlurMouseoutTouchleaveBound);
                this.el.removeEventListener('touchleave', this._handleRangeBlurMouseoutTouchleaveBound);
            }
            
            /**
            * Handle Range Change
            * @param {Event} e
            */
            
        }, {
            key: "_handleRangeChange",
            value: function _handleRangeChange() {
                $(this.value).html(this.$el.val());
                
                if (!$(this.thumb).hasClass('active')) {
                    this._showRangeBubble();
                }
                
                var offsetLeft = this._calcRangeOffset();
                $(this.thumb).addClass('active').css('left', offsetLeft + 'px');
            }
            
            /**
            * Handle Range Focus
            * @param {Event} e
            */
            
        }, {
            key: "_handleRangeFocus",
            value: function _handleRangeFocus() {
                if (M.tabPressed) {
                    this.$el.addClass('focused');
                }
            }
            
            /**
            * Handle Range Mousedown and Touchstart
            * @param {Event} e
            */
            
        }, {
            key: "_handleRangeMousedownTouchstart",
            value: function _handleRangeMousedownTouchstart(e) {
                // Set indicator value
                $(this.value).html(this.$el.val());
                
                this._mousedown = true;
                this.$el.addClass('active');
                
                if (!$(this.thumb).hasClass('active')) {
                    this._showRangeBubble();
                }
                
                if (e.type !== 'input') {
                    var offsetLeft = this._calcRangeOffset();
                    $(this.thumb).addClass('active').css('left', offsetLeft + 'px');
                }
            }
            
            /**
            * Handle Range Input, Mousemove and Touchmove
            */
            
        }, {
            key: "_handleRangeInputMousemoveTouchmove",
            value: function _handleRangeInputMousemoveTouchmove() {
                if (this._mousedown) {
                    if (!$(this.thumb).hasClass('active')) {
                        this._showRangeBubble();
                    }
                    
                    var offsetLeft = this._calcRangeOffset();
                    $(this.thumb).addClass('active').css('left', offsetLeft + 'px');
                    $(this.value).html(this.$el.val());
                }
            }
            
            /**
            * Handle Range Mouseup and Touchend
            */
            
        }, {
            key: "_handleRangeMouseupTouchend",
            value: function _handleRangeMouseupTouchend() {
                this._mousedown = false;
                this.$el.removeClass('active');
            }
            
            /**
            * Handle Range Blur, Mouseout and Touchleave
            */
            
        }, {
            key: "_handleRangeBlurMouseoutTouchleave",
            value: function _handleRangeBlurMouseoutTouchleave() {
                if (!this._mousedown) {
                    this.$el.removeClass('focused');
                    var paddingLeft = parseInt(this.$el.css('padding-left'));
                    var marginLeft = 7 + paddingLeft + 'px';
                    
                    if ($(this.thumb).hasClass('active')) {
                        anim.remove(this.thumb);
                        anim({
                            targets: this.thumb,
                            height: 0,
                            width: 0,
                            top: 10,
                            easing: 'easeOutQuad',
                            marginLeft: marginLeft,
                            duration: 100
                        });
                    }
                    $(this.thumb).removeClass('active');
                }
            }
            
            /**
            * Setup dropdown
            */
            
        }, {
            key: "_setupThumb",
            value: function _setupThumb() {
                this.thumb = document.createElement('span');
                this.value = document.createElement('span');
                $(this.thumb).addClass('thumb');
                $(this.value).addClass('value');
                $(this.thumb).append(this.value);
                this.$el.after(this.thumb);
            }
            
            /**
            * Remove dropdown
            */
            
        }, {
            key: "_removeThumb",
            value: function _removeThumb() {
                $(this.thumb).remove();
            }
            
            /**
            * morph thumb into bubble
            */
            
        }, {
            key: "_showRangeBubble",
            value: function _showRangeBubble() {
                var paddingLeft = parseInt($(this.thumb).parent().css('padding-left'));
                var marginLeft = -7 + paddingLeft + 'px'; // TODO: fix magic number?
                anim.remove(this.thumb);
                anim({
                    targets: this.thumb,
                    height: 30,
                    width: 30,
                    top: -30,
                    marginLeft: marginLeft,
                    duration: 300,
                    easing: 'easeOutQuint'
                });
            }
            
            /**
            * Calculate the offset of the thumb
            * @return {Number}  offset in pixels
            */
            
        }, {
            key: "_calcRangeOffset",
            value: function _calcRangeOffset() {
                var width = this.$el.width() - 15;
                var max = parseFloat(this.$el.attr('max'));
                var min = parseFloat(this.$el.attr('min'));
                var percent = (parseFloat(this.$el.val()) - min) / (max - min);
                return percent * width;
            }
        }], [{
            key: "init",
            value: function init(els, options) {
                return _get(Range.__proto__ || Object.getPrototypeOf(Range), "init", this).call(this, this, els, options);
            }
            
            /**
            * Get Instance
            */
            
        }, {
            key: "getInstance",
            value: function getInstance(el) {
                var domElem = !!el.jquery ? el[0] : el;
                return domElem.M_Range;
            }
        }, {
            key: "defaults",
            get: function () {
                return _defaults;
            }
        }]);
        
        return Range;
    }(Component);
    
    M.Range = Range;
    
    if (M.jQueryLoaded) {
        M.initializeJqueryWrapper(Range, 'range', 'M_Range');
    }
    
    Range.init($('input[type=range]'));
})(cash, M.anime);

document.addEventListener('DOMContentLoaded', function() {
    let dropdowns = M.Dropdown.init(document.querySelectorAll('.dropdown-trigger'), {
        coverTrigger: false,
        closeOnClick: false,
        alignment: 'left',
    });
    document.getElementById('adminka-collapsible').addEventListener('click', () => {
        dropdowns.forEach(menu => {
            setTimeout(() => {
                menu.recalculateDimensions()
            }, 400);
        })
    })
    M.Tooltip.init(document.querySelectorAll('.tooltipped'), {
        position: 'top',
    });
    M.Sidenav.init(document.querySelectorAll('.sidenav'), {
        draggable: false,
    });
    M.Collapsible.init(document.querySelectorAll('.collapsible'));
    M.CharacterCounter.init(document.querySelectorAll('.counter'))
    M.Modal.init(document.querySelectorAll('.modal'));
});
