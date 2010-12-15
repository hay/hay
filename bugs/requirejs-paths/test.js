/*
// This works....
require({
    paths : {
        "bar" : "foo"
    }
},
["bar/foo"],
function() {
    alert('main loaded');
});
*/

// And this does not work :(
require({
    paths : {
        "bar/" : "foo/"
    }
},
["bar/foo"],
function() {
    alert('main loaded');
});