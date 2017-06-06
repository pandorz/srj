/**
 * Initialisation de l'application
 */  
var app = (function() {
    function App() {}
    App.prototype = {
        clickEvent : (navigator.userAgent.match(/iPad/i)) ? "touchstart" : "click",
        hoverEvent : (navigator.userAgent.match(/iPad/i)) ? "touchstart" : "mouseover"
    };
    return new App();
})();