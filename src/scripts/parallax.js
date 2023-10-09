(function() {
  // Disabled for mobile devices
  if (window.innerWidth < 720) {
    return;
  }
  // Add event listener
  document.addEventListener("mousemove", parallax);
  const elem = document.querySelector("#container");
  // Magic happens here
  function parallax(e) {
    const _w = window.innerWidth / 2;
    const _mouseX = e.clientX;
    const _delta = _mouseX - _w;
    const _depth1 = `${50 - _delta * .01}%`;
    const _depth2 = `${50 - _delta * .02}%`;
    const _depth3 = `${50 - _delta * .06}%`;
    const x = `${_depth3}, ${_depth2}, ${_depth1}`;
    elem.style.backgroundPosition = x;
  }
})();
// credits to https://codepen.io/oscicen