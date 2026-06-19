export default class ShowPassword {
    constructor() {
        this.init();
    }

    init() {
        document.addEventListener("click", (e) => this.toggle(e));
    }

    toggle(e) {
        if (!e.target.matches(".showPassword-icon")) return;

        if (e.target.matches(".fa-eye")) {
            e.target.classList.remove("fa-eye");
            e.target.classList.add("fa-eye-slash");

            const passwordContainer = e.target.closest(".password-container");
            passwordContainer
                .querySelector(".password-input")
                .setAttribute("type", "text");
        } else {
            e.target.classList.remove("fa-eye-slash");
            e.target.classList.add("fa-eye");

            const passwordContainer = e.target.closest(".password-container");
            passwordContainer
                .querySelector(".password-input")
                .setAttribute("type", "password");
        }
    }
}
