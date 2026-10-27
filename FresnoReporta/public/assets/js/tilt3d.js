// Fresno Reporta — efecto de inclinación 3D al pasar el mouse sobre tarjetas .tilt-card
(function () {
    function attachTilt(card) {
        var maxTilt = 7;

        function onMove(e) {
            var rect = card.getBoundingClientRect();
            var x = e.clientX - rect.left;
            var y = e.clientY - rect.top;
            var midX = rect.width / 2;
            var midY = rect.height / 2;
            var rotateX = ((y - midY) / midY) * -maxTilt;
            var rotateY = ((x - midX) / midX) * maxTilt;
            card.style.transform = 'perspective(900px) rotateX(' + rotateX.toFixed(2) + 'deg) rotateY(' + rotateY.toFixed(2) + 'deg) translateZ(0)';
        }

        function onLeave() {
            card.style.transform = 'perspective(900px) rotateX(0deg) rotateY(0deg) translateZ(0)';
        }

        card.addEventListener('mousemove', onMove);
        card.addEventListener('mouseleave', onLeave);
    }

    function init() {
        if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
        if (window.matchMedia && window.matchMedia('(pointer: coarse)').matches) return; // evitar en táctil
        document.querySelectorAll('.tilt-card').forEach(attachTilt);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
