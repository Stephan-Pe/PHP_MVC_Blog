export const showPassword = () => {
  const togglePassword = document.querySelectorAll(".togglePassword");
  const password = document.querySelector(".password");
  togglePassword.forEach((toggle) => {
    if (toggle) {
      toggle.addEventListener("click", function (e) {
        // toggle the type attribute
        const type =
          password.getAttribute("type") === "password" ? "text" : "password";
        password.setAttribute("type", type);
        // toggle the eye / eye slash icon
        this.classList.toggle("bi-eye");
      });
    }
  });
};
