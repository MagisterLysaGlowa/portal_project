let is_visible = false;

const burgerMenuClick = () => {
  is_visible = !is_visible;
  if (is_visible) {
    document.getElementById("burger-menu").classList.add("translate-x-0");
    document
      .getElementById("burger-menu")
      .classList.remove("translate-x-[800px]");
  } else {
    document.getElementById("burger-menu").classList.remove("translate-x-0");
    document.getElementById("burger-menu").classList.add("translate-x-[800px]");
  }
};
