/*
 * loadScript() - A basic Javascript loader with support for arrays
 * - http://github.com/hay/hay/tree/master/jsloader/
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
        var script = document.createElement("script")
        script.type = "text/javascript";

        if (script.readyState){  //IE
            script.onreadystatechange = function(){
                if (script.readyState == "loaded" ||
                        script.readyState == "complete"){
                    script.onreadystatechange = null;
                    callback();
                }
            };
        } else {  //Others
            script.onload = function(){
                callback();
            };
        }

        script.src = url;
        document.getElementsByTagName("head")[0].appendChild(script);
    }

    if (typeof arg === "string") {
        load(arg, cb);
    } else {
        var i = 0, l = arg.length - 1;

        function loadCb() {
            if (i >= l) {
                cb();
                return false;
            }

            i++;
            load(arg[i], loadCb);
        }

        loadCb();
    }
}