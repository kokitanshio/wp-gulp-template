export const globalFunc = () => {
  // 360px未満はVPを固定
  !(function () {
    const viewport = document.querySelector('meta[name="viewport"]');
    function switchViewport() {
      const value = window.outerWidth > 375 ? "width=device-width,initial-scale=1" : "width=375";
      if (viewport.getAttribute("content") !== value) {
        viewport.setAttribute("content", value);
      }
    }
    addEventListener("resize", switchViewport, false);
    switchViewport();
  })();

  // 外部リンクを新規タブで開く
  document.querySelectorAll('a[href^="http"]').forEach(function (link) {
    if (!link.href.includes(location.hostname)) {
      link.setAttribute("target", "_blank");
      link.setAttribute("rel", "noopener noreferrer");
      link.classList.add("blank");
    }
  });
};
