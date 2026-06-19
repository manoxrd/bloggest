export default class LikeManager {
    constructor(likeContainer) {
        this.likeContainer = likeContainer;
        this.solidIcon = this.likeContainer.querySelector(".fa-solid");
        this.regularIcon = this.likeContainer.querySelector(".fa-regular");
        this.isProcessing = false;

        this.init();
    }

    init() {
        this.likeContainer.addEventListener("click", (e) => this.checker(e));
    }

    async checker(e) {
        if (!e.target.matches(".fa-heart")) return;
        if (this.isProcessing) return;

        if (document.querySelector('meta[name="is-logged-in"]').content === '0') {
            alert("Please login to like this post!");
            return;
        }

        this.isProcessing = true;

        if (e.target.matches(".liked")) {
            await this.unlike(e); // Wait for the server!
        } else {
            await this.like(e); // Wait for the server!
        }

        this.isProcessing = false; // Now this only happens AFTER the server replies
    }

    async like(e) {
        e.target.classList.add("invisible");
        this.solidIcon.classList.remove("invisible");
        this.solidIcon.classList.add("liked");

        const response = await fetch(window.location.pathname + "/like", {
            method: "POST",
            headers: {
                Accept: "application/json",
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]',
                ).content,
            },
            body: JSON.stringify({
                post_id: document.querySelector('#post').dataset.post,
            }),
        });

        if (!response.ok) {
            alert("Something wrong happened");
            this.unlike(e);
        }
        const data = await response.json();
        document.querySelector(".likes_count").textContent = data.likes_count;
      }
      
      async unlike(e) {
        e.target.classList.add("invisible");
        e.target.classList.remove("liked");
        this.regularIcon.classList.remove("invisible");
        
        const response = await fetch(window.location.pathname + "/like", {
          method: "DELETE",
          headers: {
            Accept: "application/json",
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector(
              'meta[name="csrf-token"]',
            ).content,
          },
          body: JSON.stringify({
            post_id: this.likeContainer.dataset.post,
          }),
        });
        
        const data = await response.json();
        document.querySelector(".likes_count").textContent=data.likes_count;
      }
    }
    