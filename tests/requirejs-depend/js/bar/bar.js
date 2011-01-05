define(["foo/1.5/foo"], function(f) {
    return function() {
        console.log(
            'ik ben bar en ik heb foo 1.5 nodig',
            'foo is versie:' + f.version
        );
    }
});