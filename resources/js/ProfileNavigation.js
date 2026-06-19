export default class ProfileNavigation {
    constructor(container) {
        this.container = container;

        this.postsBtn = container.querySelector(".pn-posts");
        this.posts = document.querySelector("#posts");

        this.commentsBtn = container.querySelector(".pn-comments");
        this.comments = document.querySelector("#comments");

        this.init();
    }

    init() {
        this.container.addEventListener("click", (e) => this.controller(e));
    }

    controller(e) {
        if (e.target.matches(".pn-posts")) {
            this.showPosts(e.target);
        } else if (e.target.matches(".pn-comments")) {
            this.showComments(e.target);
        }
    }

    showPosts(button) {
        if (button.classList.contains(".pn-active")) return;
        button.classList.add("pn-active");
        this.commentsBtn.classList.remove("pn-active");

        this.posts.classList.remove("hidden");
        this.comments.classList.add("hidden");

        this.type("posts");
    }

    showComments(button) {
        if (button.classList.contains(".pn-active")) return;
        button.classList.add("pn-active");
        this.postsBtn.classList.remove("pn-active");

        this.comments.classList.remove("hidden");
        this.posts.classList.add("hidden");

        this.type("comments");
    }

    type(param) {
        const url = new URL(window.location.href);

        url.searchParams.set("type", param);

        window.history.replaceState({}, "", url);
    }
}
