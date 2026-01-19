/**
 * DOMReady
 *
 * @fileOverview
 *    Cross browser object to attach functions that will be called
 *    immediatly when the DOM is ready.
 *    Released under MIT license.
 * @version 2.0.1
 * @author Victor Villaverde Laan
 * @link http://www.freelancephp.net/domready-javascript-object-cross-browser/
 * @link https://github.com/freelancephp/DOMReady
 */
(function (window) {

/**
 * @namespace DOMReady
 */
window.DOMReady = (function () {

	// Private vars
	var fns = [],
		isReady = false,
		errorHandler = null,
		run = function (fn, args) {
			try {
				// call function
				fn.apply(this, args || []);
			} catch(err) {
				// error occured while executing function
				if (errorHandler)
					errorHandler.call(this, err);
			}
		},
		ready = function () {
			isReady = true;

			// call all registered functions
			for (var x = 0; x < fns.length; x++)
				run(fns[x].fn, fns[x].args || []);

			// clear handlers
			fns = [];
		};

	/**
	 * Set error handler
	 * @static
	 * @param {Function} fn
	 * @return {DOMReady} For chaining
	 */
	this.setOnError = function (fn) {
		errorHandler = fn;

		// return this for chaining
		return this;
	};

	/**
	 * Add code or function to execute when the DOM is ready
	 * @static
	 * @param {Function} fn
	 * @param {Array} args Arguments will be passed on when calling function
	 * @return {DOMReady} For chaining
	 */
	this.add = function (fn, args) {
		// call imediately when DOM is already ready
		if (isReady) {
			run(fn, args);
		} else {
			// add to the list
			fns[fns.length] = {
				fn: fn,
				args: args
			};
		}

		// return this for chaining
		return this;
	};

	// for all browsers except IE
	if (window.addEventListener) {
		window.document.addEventListener('DOMContentLoaded', function () { ready(); }, false);
	} else {
		// for IE
		// code taken from http://ajaxian.com/archives/iecontentloaded-yet-another-domcontentloaded
		(function(){
			// check IE's proprietary DOM members
			if (!window.document.uniqueID && window.document.expando)
				return;

			// you can create any tagName, even customTag like <document :ready />
			var tempNode = window.document.createElement('document:ready');

			try {
				// see if it throws errors until after ondocumentready
				tempNode.doScroll('left');

				// call ready
				ready();
			} catch (err) {
				setTimeout(arguments.callee, 0);
			}
		})();
	}

	return this;

})();

})(window);