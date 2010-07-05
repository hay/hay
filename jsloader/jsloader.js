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