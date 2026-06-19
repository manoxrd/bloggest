export default class CommentController {
  constructor(btn) {

    this.menu = document.querySelector('.menu')
    this.open = btn.querySelector('.open')
    this.close = btn.querySelector('.close')

      this.init();
  }

  init() {
    document.addEventListener('click', (e) => this.listener(e))
  }

  listener(e) {
    if(!e.target.closest('.dropdownMenu')) return

    this.btnToggle()
    this.menuToggle(e)
  }

  btnToggle() {
    this.open.classList.toggle('hidden')
    this.close.classList.toggle('hidden')
  }

  menuToggle(e) {
    this.menu.classList.toggle('hidden')
  }

}
