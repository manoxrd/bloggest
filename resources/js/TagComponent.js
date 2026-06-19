
export default class TagComponent {
  constructor(tagsHolder) {
    this.tagsHolder = tagsHolder;
    this.inputHolder = document.querySelector('#inputHolder');

    this.init();
  }

  init() {
    this.tagsHolder.addEventListener('click', (e) => this.toggle(e));
  }

  toggle(e) {
    if (!e.target.matches('.tag-button')) return;

    const tagId = e.target.getAttribute('data-id');
    const inputOfTagId = document.querySelector('input[value="' + tagId + '"]');

    if(inputOfTagId) {
      this.removeHiddenInput(inputOfTagId);
      e.target.classList.remove('tag-button-active')
    } else {
      this.addHiddenInput(tagId);
      e.target.classList.add('tag-button-active')
    }

  }

  addHiddenInput(tagId) {
    const tagInput = document.createElement('input');
    tagInput.setAttribute('name', 'tags[]')
    tagInput.setAttribute('id', 'tags[]')
    tagInput.setAttribute('value', tagId)
    tagInput.setAttribute('type', 'hidden');
    
    document.querySelector('#inputHolder').append(tagInput);
  }
  
  removeHiddenInput(input) {
    input.remove();
  }
}
