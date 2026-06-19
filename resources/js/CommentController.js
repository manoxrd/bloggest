export default class CommentController {
    constructor(form) {
        this.post_id = document.querySelector("#post").dataset.post;

        this.createForm = form;
        this.createTemplate = document.querySelector(
            ".create-comment-template",
        );

        this.editTemplate = document.querySelector(".edit-comment-template");

        this.isUserLoggedIn = Number(
            document.querySelector('meta[name="is-logged-in"]').content,
        );

        this.kick(this.isUserLoggedIn);
        this.init();
    }

    init() {
        this.createForm.addEventListener("submit", (e) => this.store(e));
        document.addEventListener("click", (e) => this.edit(e));
        document.addEventListener("submit", (e) => this.update(e));
        document.addEventListener("submit", (e) => this.destroy(e));
    }

    async store(e) {
        e.preventDefault();
        const textarea = e.target.querySelector('textarea[name="text"]');

        if (!textarea.value) {
            document.querySelector(".create-comment-error").textContent =
                "the comment is empty, please write it and try again";
            return;
        } else {
            document.querySelector(".create-comment-error").textContent = "";
        }

        const formData = new FormData(this.createForm);
        formData.append("text", textarea.value);
        formData.append("post_id", this.post_id);

        const response = await fetch(window.location.pathname + "/comments", {
            method: "POST",
            headers: {
                Accept: "application/json",
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]',
                ).content,
            },
            body: formData,
        });

        const data = await response.json();

        if (response.status === 401) {
            data.message = "You need to log in to post a comment!";
        }

        if (data.message) {
            document.querySelector(".create-comment-error").textContent =
                data.message;
            return;
        }

        textarea.value = "";

        document.querySelector('.comments .empty')?.remove();

        this.clone(data);
    }

    async update(e) {
        if (!e.target.matches(".edit-comment")) return;
        e.preventDefault();

        const textarea = e.target.querySelector('textarea[name="text"]');
        if (!textarea.value) {
            document.querySelector(".update-comment-error").textContent =
                "the comment is empty, please write it and try again";
            return;
        } else {
            document.querySelector(".update-comment-error").textContent = "";
        }

        const viewComment = e.target.closest(".view-comment");
        const comment_id = viewComment.getAttribute("id");

        const formData = new FormData(e.target);
        formData.append("text", textarea.value);

        const response = await fetch(window.location.pathname + "/comments/" + comment_id, {
            method: "PATCH",
            headers: {
                Accept: "application/json",
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]',
                ).content,
            },
            body: formData,
        });

        const data = await response.json();

        if (data.message) {
            document.querySelector(".update-comment-error").textContent =
                data.message;
            return;
        }

        const commentText = viewComment.querySelector(".comment-text");
        commentText.classList.remove("hidden");
        commentText.textContent = data.text;

        viewComment
            .querySelector(".edit-delete-container")
            .classList.remove("hidden");

        e.target.remove();
    }

    async destroy(e) {
        if (!e.target.matches(".delete-comment")) return;
        e.preventDefault();

        if (!confirm("are you sure?")) return;

        const viewComment = e.target.closest(".view-comment");
        const comment_id = viewComment.getAttribute("id");

        const formData = new FormData(e.target);

        const response = await fetch(window.location.pathname + "/comments/" + comment_id, {
            method: "DELETE",
            headers: {
                Accept: "application/json",
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]',
                ).content,
            },
            body: formData,
        });

        const data = await response.json();

        if (data.message) {
            alert(data.message);
            return;
        }

        viewComment.remove();
    }

    edit(e) {
        const editButton = e.target.closest(".edit-button");
        const cancelButton = e.target.closest(".cancel-button");

        if (editButton) {
            const viewComment = editButton.closest(".view-comment");
            const commentText = viewComment.querySelector(".comment-text");
            editButton
                .closest(".edit-delete-container")
                .classList.add("hidden");
            commentText.classList.add("hidden");
            viewComment
                .querySelector(".comment-text-container")
                .appendChild(this.editTemplate.content.cloneNode(true));
            viewComment.querySelector("textarea[name='text']").textContent =
                commentText.textContent;
        } else if (cancelButton) {
            const viewComment = cancelButton.closest(".view-comment");

            viewComment
                .querySelector(".edit-delete-container")
                .classList.remove("hidden");
            viewComment
                .querySelector(".comment-text")
                .classList.remove("hidden");
            viewComment
                .querySelector(".comment-text-container .edit-comment")
                .remove();
        }
    }

    clone(data) {
        const comment = this.createTemplate.content.cloneNode(true);
        const profileUrl = comment.querySelector("img");
        const name = comment.querySelector(".user-name");
        const commentText = comment.querySelector(".comment-text");
        const commentTime = comment.querySelector(".comment-time");

        profileUrl.setAttribute("src", data.profilePhoto);
        name.textContent = data.name;
        commentText.textContent = data.text;
        commentTime.textContent = data.createDate;
        comment.querySelector(".view-comment").setAttribute("id", data.id);

        document.querySelector(".comments").prepend(comment);
    }

    kick(isUserAuth) {
        if (!isUserAuth) return;
    }
}
