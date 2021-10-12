export const toggleNav = () => {
  const navmenu = document.querySelector(".topnav__menu");
  const toggle = document.querySelector(".topnav__toggle");
  const links = document.querySelectorAll(".topnav__link");
  toggle.addEventListener("click", () => {
    navmenu.classList.toggle("active");
    links.forEach((link, index) => {
      if (link.style.animation) {
        link.style.animation = "";
      } else {
        link.style.animation = `navLinkFade 1s ease forwards ${
          index / 7 + 0.2
        }s`;
      }
    });
    toggle.classList.toggle("cross");
  });
};
