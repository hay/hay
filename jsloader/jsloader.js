/*
 * loadScript() - A basic Javascript loader with support for arrays
 * - http://github.com/hay/hay/tree/master/jsloader/
 * Tutorial:
 * - http://www.haykranen.nl/?p=1290
 * Based on Nicholas C. Zakas' script:
 * - http://www.nczonline.net/blog/2009/07/28/the-best-way-to-load-external-javascript/
 * Licensed under the MIT / X11 License:
 * - http://opensource.org/licenses/mit-license.php
 *
 * USAGE
 * You can either load a single script (just provide the URL) or an array
 * of scripts. You can then provide a callback for your 'init' function
 *
 * - Single script:
 * loadScript("http://example.com/myscript.js", function() {
 *     alert('loaded!');
 * });
 *
 * - Multiple scripts:
 * var scripts = ['script1.js', 'script2.js', 'script3.js'];
 * loadScript(scripts, function() {
 *     alert("All scripts loaded!");
 * });
 *
**/

function loadScript(arg, cb) {
    function load(url, callback) {
        // Callback is not required
        callback = callback || function(){};

        var script = document.createElement("script")
        script.type = "text/javascript";

        if (script.readyState) {  // IE
            script.onreadystatechange = function() {
                // IE sometimes gives back the one state, and sometimes the
                // other, so we need to check for both
                if (script.readyState === "loaded" ||
                    script.readyState === "complete") {
                    script.onreadystatechange = null;
                    callback();
                }
            };
        } else {  // Others
            script.onload = function() {
                callback();
            };
        }

        script.src = url;
        // Adding to the <head> is safer than the end of the <body>
        document.getElementsByTagName("head")[0].appendChild(script);
    }

    // Used for loading one single file
    if (typeof arg === "string") {
        load(arg, cb);
    } else if (arg instanceof Array) {
        // Load an array of files
        var i = 0, l = arg.length;

        function loadCb() {
            if (i >= l) {
                // Execute the original callback
                cb();
                return false;
            }

            load(arg[i], loadCb);
            i++;
        }

        loadCb();
    }
}