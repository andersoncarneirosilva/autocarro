!function(e) {
    "use strict";
    
    function i() {}
    
    i.prototype.init = function() {
        const textElement = document.getElementById("texto_final");
        if (textElement) { // Verifica se o elemento existe
            new SimpleMDE({
                element: textElement,
                spellChecker: !1,
                autosave: {
                    enabled: !0,
                    unique_id: "simplemde1"
                }
            });
        }
    };

    e.SimpleMDEEditor = new i;
    e.SimpleMDEEditor.Constructor = i;
}(window.jQuery), function() {
    "use strict";

    if (document.getElementById("texto_final")) { // Verifica antes de inicializar
        window.jQuery.SimpleMDEEditor.init();
    }
}();


!function(e) {
    "use strict";
    
    function i() {}
    
    i.prototype.init = function() {
        const textElement = document.getElementById("edit_texto_final");
        if (textElement) { // Verifica se o elemento existe
            new SimpleMDE({
                element: textElement,
                spellChecker: !1,
                autosave: {
                    enabled: !0,
                    unique_id: "simplemde1"
                }
            });
        }
    };

    e.SimpleMDEEditor = new i;
    e.SimpleMDEEditor.Constructor = i;
}(window.jQuery), function() {
    "use strict";

    if (document.getElementById("edit_texto_final")) { // Verifica antes de inicializar
        window.jQuery.SimpleMDEEditor.init();
    }
}();

!function(e) {
    "use strict";
    
    function i() {}
    
    i.prototype.init = function() {
        const textElement = document.getElementById("texto_inicial");
        if (textElement) { // Verifica se o elemento existe
            new SimpleMDE({
                element: textElement,
                spellChecker: !1,
                autosave: {
                    enabled: !0,
                    unique_id: "simplemde1"
                }
            });
        }
    };

    e.SimpleMDEEditor = new i;
    e.SimpleMDEEditor.Constructor = i;
}(window.jQuery), function() {
    "use strict";

    if (document.getElementById("texto_inicial")) { // Verifica antes de inicializar
        window.jQuery.SimpleMDEEditor.init();
    }
}();


!function(e) {
    "use strict";
    
    function i() {}
    
    i.prototype.init = function() {
        const textElement = document.getElementById("edit_texto_inicial");
        if (textElement) { // Verifica se o elemento existe
            new SimpleMDE({
                element: textElement,
                spellChecker: !1,
                autosave: {
                    enabled: !0,
                    unique_id: "simplemde1"
                }
            });
        }
    };

    e.SimpleMDEEditor = new i;
    e.SimpleMDEEditor.Constructor = i;
}(window.jQuery), function() {
    "use strict";

    if (document.getElementById("edit_texto_inicial")) { // Verifica antes de inicializar
        window.jQuery.SimpleMDEEditor.init();
    }
}();