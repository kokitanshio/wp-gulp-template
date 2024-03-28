export const globalFunc = () => {
  // 360px未満はVPを固定
  !(function () {
    const viewport = document.querySelector('meta[name="viewport"]');
    function switchViewport() {
      const value = window.outerWidth > 360 ? "width=device-width,initial-scale=1" : "width=360";
      if (viewport.getAttribute("content") !== value) {
        viewport.setAttribute("content", value);
      }
    }
    addEventListener("resize", switchViewport, false);
    switchViewport();
  })();
};
