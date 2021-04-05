// Controllo che gli eventi passivi siano disponibili nel browser
var supportsPassiveAttribute = false;
try {
  let opts = Object.defineProperty({}, 'passive', {
    get: function() {
        supportsPassiveAttribute = true;
    }
  });
  window.addEventListener("testPassive", null, opts);
  window.removeEventListener("testPassive", null, opts);
} catch (e) {}