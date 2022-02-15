/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./assets/src/sass/frontend.scss":
/*!***************************************!*\
  !*** ./assets/src/sass/frontend.scss ***!
  \***************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!***********************************!*\
  !*** ./assets/src/js/frontend.js ***!
  \***********************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _sass_frontend_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../sass/frontend.scss */ "./assets/src/sass/frontend.scss");
/**
 * SASS
 */

/**
 * JavaScript
 */

/**
 * Add here your JavasScript code
 */

(function ($) {
  'use strict';
  /**
   * All of the code for your public-facing JavaScript source
   * should reside in this file.
   */

  $(document).on('submit', '#gs-post-form', function (e) {
    e.preventDefault();
    var formData = new FormData();
    formData.append("gs_post_featured_image", $('#gs_post_featured_image')[0].files[0]);
    formData.append("action", "gs_do_create_post");
    formData.append("gs_nonce", plugin_frontend_script.nonce);
    formData.append("gs_post_title", $('#gs_post_title').val());
    formData.append("gs_post_type", $('#gs_post_type').val());
    formData.append("gs_post_content", $('#gs_post_content').val());
    formData.append("gs_post_excerpt", $('#gs_post_excerpt').val());
    $.ajax({
      url: plugin_frontend_script.ajaxurl,
      type: 'post',
      processData: false,
      contentType: false,
      data: formData,
      success: function success(data) {
        $(".gs-result").html(data);
      }
    });
  });
})(jQuery);
})();

/******/ })()
;