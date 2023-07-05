/******/ (function(modules) { // webpackBootstrap
/******/ 	// install a JSONP callback for chunk loading
/******/ 	function webpackJsonpCallback(data) {
/******/ 		var chunkIds = data[0];
/******/ 		var moreModules = data[1];
/******/ 		var executeModules = data[2];
/******/
/******/ 		// add "moreModules" to the modules object,
/******/ 		// then flag all "chunkIds" as loaded and fire callback
/******/ 		var moduleId, chunkId, i = 0, resolves = [];
/******/ 		for(;i < chunkIds.length; i++) {
/******/ 			chunkId = chunkIds[i];
/******/ 			if(Object.prototype.hasOwnProperty.call(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 				resolves.push(installedChunks[chunkId][0]);
/******/ 			}
/******/ 			installedChunks[chunkId] = 0;
/******/ 		}
/******/ 		for(moduleId in moreModules) {
/******/ 			if(Object.prototype.hasOwnProperty.call(moreModules, moduleId)) {
/******/ 				modules[moduleId] = moreModules[moduleId];
/******/ 			}
/******/ 		}
/******/ 		if(parentJsonpFunction) parentJsonpFunction(data);
/******/
/******/ 		while(resolves.length) {
/******/ 			resolves.shift()();
/******/ 		}
/******/
/******/ 		// add entry modules from loaded chunk to deferred list
/******/ 		deferredModules.push.apply(deferredModules, executeModules || []);
/******/
/******/ 		// run deferred modules when all chunks ready
/******/ 		return checkDeferredModules();
/******/ 	};
/******/ 	function checkDeferredModules() {
/******/ 		var result;
/******/ 		for(var i = 0; i < deferredModules.length; i++) {
/******/ 			var deferredModule = deferredModules[i];
/******/ 			var fulfilled = true;
/******/ 			for(var j = 1; j < deferredModule.length; j++) {
/******/ 				var depId = deferredModule[j];
/******/ 				if(installedChunks[depId] !== 0) fulfilled = false;
/******/ 			}
/******/ 			if(fulfilled) {
/******/ 				deferredModules.splice(i--, 1);
/******/ 				result = __webpack_require__(__webpack_require__.s = deferredModule[0]);
/******/ 			}
/******/ 		}
/******/
/******/ 		return result;
/******/ 	}
/******/
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// object to store loaded and loading chunks
/******/ 	// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 	// Promise = chunk loading, 0 = chunk loaded
/******/ 	var installedChunks = {
/******/ 		"main": 0
/******/ 	};
/******/
/******/ 	var deferredModules = [];
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/ 	var jsonpArray = window["webpackJsonp"] = window["webpackJsonp"] || [];
/******/ 	var oldJsonpFunction = jsonpArray.push.bind(jsonpArray);
/******/ 	jsonpArray.push = webpackJsonpCallback;
/******/ 	jsonpArray = jsonpArray.slice();
/******/ 	for(var i = 0; i < jsonpArray.length; i++) webpackJsonpCallback(jsonpArray[i]);
/******/ 	var parentJsonpFunction = oldJsonpFunction;
/******/
/******/
/******/ 	// add entry module to deferred list
/******/ 	deferredModules.push(["./src/js/index.js","vendor"]);
/******/ 	// run deferred modules when ready
/******/ 	return checkDeferredModules();
/******/ })
/************************************************************************/
/******/ ({

/***/ "./src/blocks/components/read-more.js":
/*!********************************************!*\
  !*** ./src/blocks/components/read-more.js ***!
  \********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

document.addEventListener("DOMContentLoaded", function () {
  var readMore = document.querySelector(".read-more");
  var fullText = document.querySelector(".full-text");
  var flag = 0;
  readMore.addEventListener("click", function (e) {
    if (flag == 0) {
      flag++;
      fullText.classList.add("active");
      e.currentTarget.innerHTML = 'свернуть';
    } else {
      flag--;
      fullText.classList.remove("active");
      e.currentTarget.innerHTML = 'Читать дальше';
    }
  });
});

/***/ }),

/***/ "./src/blocks/components/select.js":
/*!*****************************************!*\
  !*** ./src/blocks/components/select.js ***!
  \*****************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var choices_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! choices.js */ "./node_modules/choices.js/public/assets/scripts/choices.js");
/* harmony import */ var choices_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(choices_js__WEBPACK_IMPORTED_MODULE_0__);

var selects = document.querySelectorAll(".g-select");
document.addEventListener("DOMContentLoaded", function () {
  if (selects) {
    selects.forEach(function (el) {
      var choices = new choices_js__WEBPACK_IMPORTED_MODULE_0___default.a(el, {
        itemSelectText: '',
        shouldSort: false
      });
    });
  }
});

/***/ }),

/***/ "./src/blocks/components/simlebar.js":
/*!*******************************************!*\
  !*** ./src/blocks/components/simlebar.js ***!
  \*******************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var simplebar__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! simplebar */ "./node_modules/simplebar/dist/simplebar.esm.js");

var simplebars = document.querySelectorAll("[data-simplebar]");

if (simplebars) {
  simplebars.forEach(function (el) {
    new simplebar__WEBPACK_IMPORTED_MODULE_0__["default"](el);
  });
}

/***/ }),

/***/ "./src/blocks/components/tabs.js":
/*!***************************************!*\
  !*** ./src/blocks/components/tabs.js ***!
  \***************************************/
/*! exports provided: tabs */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "tabs", function() { return tabs; });
var tabs = function tabs() {
  var tabsBtn = document.querySelectorAll(".g-tabs__btn");
  tabsBtn.forEach(function (el) {
    el.addEventListener("click", function () {
      var tabsPath = el.dataset.tabsPath;
      el.closest(".g-tabs").querySelector('.g-tabs__btn--active').classList.remove('g-tabs__btn--active');
      el.closest(".g-tabs").querySelector("[data-tabs-path=\"".concat(tabsPath, "\"]")).classList.add('g-tabs__btn--active');
      var tabsContent = el.closest(".g-tabs").querySelectorAll(".g-tabs__content");

      var switchContent = function switchContent(path, element) {
        for (var i = 0; i < tabsContent.length; i++) {
          var _el = tabsContent[i];

          _el.classList.remove('g-tabs__content--active');
        }

        element.closest(".g-tabs").querySelector("[data-tabs-target=\"".concat(path, "\"]")).classList.add('g-tabs__content--active');
      };

      switchContent(tabsPath, el);
    });
  });
};

/***/ }),

/***/ "./src/blocks/modules/catalog/catalog-toggle.js":
/*!******************************************************!*\
  !*** ./src/blocks/modules/catalog/catalog-toggle.js ***!
  \******************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

document.addEventListener("DOMContentLoaded", function () {
  var catalogToggle = document.querySelector(".catalog-toggle");

  function toggleCatalog() {
    this.classList.toggle("isOpen");
  }

  catalogToggle === null || catalogToggle === void 0 ? void 0 : catalogToggle.addEventListener("click", toggleCatalog);
});

/***/ }),

/***/ "./src/blocks/modules/collections-section/collections-section-slider.js":
/*!******************************************************************************!*\
  !*** ./src/blocks/modules/collections-section/collections-section-slider.js ***!
  \******************************************************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _components_tabs__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../components/tabs */ "./src/blocks/components/tabs.js");
/* harmony import */ var swiper__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! swiper */ "./node_modules/swiper/swiper.esm.js");


document.addEventListener("DOMContentLoaded", function () {
  var collectionsSlider = new swiper__WEBPACK_IMPORTED_MODULE_1__["default"](".collections-section-slider", {
    modules: [swiper__WEBPACK_IMPORTED_MODULE_1__["Navigation"], swiper__WEBPACK_IMPORTED_MODULE_1__["Scrollbar"]],
    slidesPerView: 'auto',
    centeredSlides: true,
    spaceBetween: 6,
    breakpoints: {
      577: {
        centeredSlides: false
      },
      769: {
        spaceBetween: 12,
        centeredSlides: false
      }
    },
    scrollbar: {
      el: '.collections-section-slider__scrollbar'
    },
    navigation: {
      nextEl: '.collections-section-slider__btn--next',
      prevEl: '.collections-section-slider__btn--prev'
    }
  });
  Object(_components_tabs__WEBPACK_IMPORTED_MODULE_0__["tabs"])();
});

/***/ }),

/***/ "./src/blocks/modules/footer/footer-menu.js":
/*!**************************************************!*\
  !*** ./src/blocks/modules/footer/footer-menu.js ***!
  \**************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

document.addEventListener("DOMContentLoaded", function () {
  var footerTitles = document.querySelectorAll(".footer__title");
  footerTitles.forEach(function (el) {
    el.addEventListener("click", function (e) {
      e.currentTarget.classList.toggle("active");
      el.closest(".footer__col").querySelector(".footer-menu").classList.toggle("active");
    });
  });
});

/***/ }),

/***/ "./src/blocks/modules/header/burger.js":
/*!*********************************************!*\
  !*** ./src/blocks/modules/header/burger.js ***!
  \*********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

document.addEventListener("DOMContentLoaded", function () {
  var burger = document.querySelector(".menu-btn");
  var overlay = document.querySelector(".overlay");
  var nav = document.querySelector(".nav");
  var body = document.body;

  var navOpen = function navOpen() {
    burger.classList.toggle("is-active");
    body.classList.toggle("lock");
    nav.classList.toggle("show");
    overlay.classList.toggle("active");
  };

  var navClose = function navClose() {
    burger.classList.remove("is-active");
    body.classList.remove("lock");
    nav.classList.remove("show");
    overlay.classList.remove("active");
  };

  burger === null || burger === void 0 ? void 0 : burger.addEventListener("click", navOpen);
  overlay.addEventListener("click", navClose);
});

/***/ }),

/***/ "./src/blocks/modules/header/open-form.js":
/*!************************************************!*\
  !*** ./src/blocks/modules/header/open-form.js ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

document.addEventListener("DOMContentLoaded", function () {
  var searchForm = document.querySelectorAll(".search-form__form");
  document.addEventListener("click", function (e) {
    if (e.target.classList.contains("open-form")) {
      searchForm.forEach(function (el) {
        return el.classList.toggle("active");
      });
    } else if (!e.target.closest(".search-form")) {
      searchForm.forEach(function (el) {
        return el.classList.remove("active");
      });
    }
  });
});

/***/ }),

/***/ "./src/blocks/modules/hero/hero-slider.js":
/*!************************************************!*\
  !*** ./src/blocks/modules/hero/hero-slider.js ***!
  \************************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var swiper__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! swiper */ "./node_modules/swiper/swiper.esm.js");

document.addEventListener("DOMContentLoaded", function () {
  new swiper__WEBPACK_IMPORTED_MODULE_0__["default"]('.hero-slider', {
    modules: [swiper__WEBPACK_IMPORTED_MODULE_0__["Navigation"], swiper__WEBPACK_IMPORTED_MODULE_0__["Pagination"]],
    navigation: {
      nextEl: '.hero-slider__btn--next',
      prevEl: '.hero-slider__btn--prev'
    },
    pagination: {
      el: '.hero-slider__pag',
      type: 'bullets',
      clickable: true
    }
  });
});

/***/ }),

/***/ "./src/blocks/modules/logos/logos-slider.js":
/*!**************************************************!*\
  !*** ./src/blocks/modules/logos/logos-slider.js ***!
  \**************************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var swiper__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! swiper */ "./node_modules/swiper/swiper.esm.js");
/* harmony import */ var gsap_ScrollTrigger__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! gsap/ScrollTrigger */ "./node_modules/gsap/ScrollTrigger.js");
/* harmony import */ var gsap__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! gsap */ "./node_modules/gsap/index.js");
function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function _iterableToArrayLimit(arr, i) { var _i = arr == null ? null : typeof Symbol !== "undefined" && arr[Symbol.iterator] || arr["@@iterator"]; if (_i == null) return; var _arr = []; var _n = true; var _d = false; var _s, _e; try { for (_i = _i.call(arr); !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }




gsap__WEBPACK_IMPORTED_MODULE_2__["default"].registerPlugin(gsap_ScrollTrigger__WEBPACK_IMPORTED_MODULE_1__["default"]);

var showDemo = function showDemo() {
  gsap__WEBPACK_IMPORTED_MODULE_2__["default"].utils.toArray('.logos').forEach(function (section, index) {
    var w = section.querySelector('.logos-slider .swiper-wrapper');

    var _ref = index % 2 ? ['100%', (w.scrollWidth - section.offsetWidth) * -0.2] : [w.scrollWidth * -0.2, 0],
        _ref2 = _slicedToArray(_ref, 2),
        x = _ref2[0],
        xEnd = _ref2[1];

    gsap__WEBPACK_IMPORTED_MODULE_2__["default"].fromTo(w, {
      x: x
    }, {
      x: xEnd,
      scrollTrigger: {
        trigger: section,
        scrub: 1
      }
    });
  });
};

document.addEventListener("DOMContentLoaded", function () {
  new swiper__WEBPACK_IMPORTED_MODULE_0__["default"]('.logos-slider', {
    slidesPerView: 'auto',
    spaceBetween: 22,
    loop: true,
    centeredSlides: true
  });
});
showDemo();

/***/ }),

/***/ "./src/blocks/modules/popular-categories/popular-categories-more.js":
/*!**************************************************************************!*\
  !*** ./src/blocks/modules/popular-categories/popular-categories-more.js ***!
  \**************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

document.addEventListener("DOMContentLoaded", function () {
  var moreCategories = document.querySelector(".more-categories");
  var popularCategories = document.querySelector(".popular-categories");
  var hiddenCategories = document.querySelectorAll(".popular-category--hidden");
  moreCategories === null || moreCategories === void 0 ? void 0 : moreCategories.addEventListener("click", function (e) {
    popularCategories.classList.add("active");
    hiddenCategories.forEach(function (el) {
      return el.classList.remove("popular-category--hidden");
    });
    hiddenCategories.forEach(function (el) {
      return el.classList.add("popular-category--active");
    });
  });
});

/***/ }),

/***/ "./src/blocks/modules/popular-categories/popular-categories-slider.js":
/*!****************************************************************************!*\
  !*** ./src/blocks/modules/popular-categories/popular-categories-slider.js ***!
  \****************************************************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var swiper__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! swiper */ "./node_modules/swiper/swiper.esm.js");

document.addEventListener("DOMContentLoaded", function () {
  var popularCategoriesSlider = document.querySelector(".popular-categories-slider");

  if (popularCategoriesSlider) {
    var mySwiper;

    var initializeSlider = function initializeSlider() {
      mySwiper = new swiper__WEBPACK_IMPORTED_MODULE_0__["default"](popularCategoriesSlider, {
        slidesPerView: 'auto',
        spaceBetween: 6,
        centeredSlides: true,
        modules: [swiper__WEBPACK_IMPORTED_MODULE_0__["Navigation"], swiper__WEBPACK_IMPORTED_MODULE_0__["Scrollbar"]],
        breakpoints: {
          577: {
            centeredSlides: false
          }
        },
        scrollbar: {
          el: '.popular-categories-slider__scrollbar'
        },
        navigation: {
          nextEl: '.popular-categories-slider__btn--next',
          prevEl: '.popular-categories-slider__btn--prev'
        }
      });
    };

    if (window.innerWidth <= 768) {
      initializeSlider();
      popularCategoriesSlider.dataset.mobile = "true";
    }

    var mobileSlider = function mobileSlider() {
      if (window.innerWidth <= 768 && popularCategoriesSlider.dataset.mobile == "false") {
        initializeSlider();
        popularCategoriesSlider.dataset.mobile = "true";
      }

      if (window.innerWidth > 768) {
        popularCategoriesSlider.dataset.mobile = "false";

        if (popularCategoriesSlider.classList.contains("swiper-initialized")) {
          mySwiper.destroy();
        }
      }
    };

    mobileSlider();
    window.addEventListener("resize", function () {
      mobileSlider();
    });
  }
});

/***/ }),

/***/ "./src/js/import/components.js":
/*!*************************************!*\
  !*** ./src/js/import/components.js ***!
  \*************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _blocks_components_select__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../blocks/components/select */ "./src/blocks/components/select.js");
/* harmony import */ var _blocks_components_simlebar__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../blocks/components/simlebar */ "./src/blocks/components/simlebar.js");
/* harmony import */ var _blocks_components_read_more__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../blocks/components/read-more */ "./src/blocks/components/read-more.js");
/* harmony import */ var _blocks_components_read_more__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_blocks_components_read_more__WEBPACK_IMPORTED_MODULE_2__);




/***/ }),

/***/ "./src/js/import/modules.js":
/*!**********************************!*\
  !*** ./src/js/import/modules.js ***!
  \**********************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _modules_header_open_form__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! %modules%/header/open-form */ "./src/blocks/modules/header/open-form.js");
/* harmony import */ var _modules_header_open_form__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_modules_header_open_form__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _modules_header_burger__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! %modules%/header/burger */ "./src/blocks/modules/header/burger.js");
/* harmony import */ var _modules_header_burger__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_modules_header_burger__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _modules_hero_hero_slider__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! %modules%/hero/hero-slider */ "./src/blocks/modules/hero/hero-slider.js");
/* harmony import */ var _modules_logos_logos_slider__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! %modules%/logos/logos-slider */ "./src/blocks/modules/logos/logos-slider.js");
/* harmony import */ var _modules_collections_section_collections_section_slider__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! %modules%/collections-section/collections-section-slider */ "./src/blocks/modules/collections-section/collections-section-slider.js");
/* harmony import */ var _modules_popular_categories_popular_categories_slider__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! %modules%/popular-categories/popular-categories-slider */ "./src/blocks/modules/popular-categories/popular-categories-slider.js");
/* harmony import */ var _modules_popular_categories_popular_categories_more__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! %modules%/popular-categories/popular-categories-more */ "./src/blocks/modules/popular-categories/popular-categories-more.js");
/* harmony import */ var _modules_popular_categories_popular_categories_more__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_modules_popular_categories_popular_categories_more__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var _modules_footer_footer_menu__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! %modules%/footer/footer-menu */ "./src/blocks/modules/footer/footer-menu.js");
/* harmony import */ var _modules_footer_footer_menu__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(_modules_footer_footer_menu__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var _modules_catalog_catalog_toggle__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! %modules%/catalog/catalog-toggle */ "./src/blocks/modules/catalog/catalog-toggle.js");
/* harmony import */ var _modules_catalog_catalog_toggle__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(_modules_catalog_catalog_toggle__WEBPACK_IMPORTED_MODULE_8__);










/***/ }),

/***/ "./src/js/index.js":
/*!*************************!*\
  !*** ./src/js/index.js ***!
  \*************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _import_modules__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./import/modules */ "./src/js/import/modules.js");
/* harmony import */ var _import_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./import/components */ "./src/js/import/components.js");



/***/ })

/******/ });
//# sourceMappingURL=main.js.map