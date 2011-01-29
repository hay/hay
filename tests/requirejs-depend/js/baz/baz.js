define(["foo/1.6/foo"], function(f) {
    return function() {
        console.log(
            'ik ben baz en ik heb foo 1.6 nodig',
            'foo is versie:' + f.version
        );
    }
});