export default class ProfileImagePreview {
//     constructor(form) {
//         this.input = form.querySelector('input[name="thumbnail"]');

//         this.img = document.querySelector("#thumbnail-img");
//         this.label = document.querySelector('label[for="thumbnail"]');

//         this.deleteBtn = document.querySelector(".delete-thumbnail");

//         this.init();
    }

//     init() {
//         this.input.addEventListener("change", (e) => this.addPreview(e));
//         this.deleteBtn.addEventListener("click", (e) => this.delete(e));
//     }

//     addPreview(e) {
//         if (!e.target.files[0].type.startsWith("image/")) return;

//         const file = e.target.files[0];

//         this.img.src = URL.createObjectURL(file);
//         this.toggle();
//     }

//     delete(e) {
//         if (!e.target.closest(".delete-thumbnail")) return;

//         this.img.removeAttribute("src");
//         this.input.value = "";
//         this.toggle();
//     }

//     toggle() {
//         this.img.classList.toggle("hidden");
//         this.label.classList.toggle("hidden");
//         this.deleteBtn.classList.toggle("invisible");
//     }
// }
