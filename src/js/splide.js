import "@splidejs/splide/css/core";
import Splide from "@splidejs/splide";

const option = {
  autoplay: true, // 自動再生を有効
  type: "loop", // ループさせる
  arrows: false, // 矢印ボタンを非表示
  pagination: true, // ページネーションを有効
  pauseOnHover: false, // ホバー時にスライドを停止させない
  pauseOnFocus: false, // フォーカス時にスライドを停止させない
  focus: "center", // フォーカス位置を中央にする
  gap: 18, // スライド間の余白
  interval: 5000, // 自動再生の間隔
  speed: 2000, // スライダーの移動時間

  classes: {
    // クラス名を変更
    pagination: "splide__pagination",
    page: "splide__pagination__page",
  },
};

export const splideFunc = () => {
  const splide = document.querySelector(".splide");
  if (!splide) {
    return;
  }
  new Splide(".js-splide", option).mount();
};
