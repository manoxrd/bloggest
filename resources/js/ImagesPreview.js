export default class ThumbnailPreview {
    constructor(form, type) {
        this.type = type;
        this.input = form.querySelector('input[name="'+ this.type +'"]');

        this.img = document.querySelector("#"+ this.type +"-img");
        this.label = document.querySelector('label[for="'+ this.type +'"]');
        
        this.deleteBtn = document.querySelector(".delete-"+ this.type +"");
        
        this.init();
      }
      
      init() {
        this.input.addEventListener("change", (e) => this.addPreview(e));
        this.deleteBtn.addEventListener("click", (e) => this.delete(e));
      }
      
      addPreview(e) {
        if (!e.target.files[0].type.startsWith("image/")) return;

        
        const file = e.target.files[0];
                
        this.img.src = URL.createObjectURL(file);
        this.toggle();
      }
      
      delete(e) {
        if (!e.target.closest(".delete-"+ this.type +"")) return;
        
        this.img.removeAttribute("src");
        this.input.value = "";
        this.toggle();
      }
      
      toggle() {
        this.img.classList.toggle("hidden");
        this.label.classList.toggle("hidden");
        this.deleteBtn.classList.toggle("invisible");
    }
}
