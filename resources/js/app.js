import "./libs/trix";
import "./bootstrap";
import TagComponent from "./TagComponent";
import LikeManager from "./LikeManager";
import CommentController from "./CommentController";
import ProfileNavigation from "./ProfileNavigation";
import ShowPassword from "./ShowPassword";
import ImagesPreview from "./ImagesPreview";
import ProfileImagePreview from "./ProfileImagePreview";
import DropdownMenu from "./DropdownMenu";

document.addEventListener("DOMContentLoaded", () => {
    const deleteProfileImage = document.querySelector("#delete-profile-photo");

    if (deleteProfileImage) {
        deleteProfileImage.addEventListener("click", (e) => {
            document
                .querySelector("img#profile_photo")
                .removeAttribute("src");
            document
                .querySelector('input[name="delete_photo"]')
                .setAttribute("value", "true");
        });
    }

    const tagsHolder = document.querySelector("#postTagsHolder");
    if (tagsHolder) {
        new TagComponent(tagsHolder);
    }

    const likeContainer = document.querySelector(".like-container");
    if (likeContainer) {
        new LikeManager(likeContainer);
    }

    const commentForm = document.querySelector("#commentForm");
    if (commentForm) {
        new CommentController(commentForm);
    }
    
    const profileNavigation = document.querySelector('.profile-nav');
    if (profileNavigation) {
      new ProfileNavigation(profileNavigation);
    }

    const showPassword = document.querySelector('.showPassword');
    if (showPassword) {
      new ShowPassword();
    }

    const dropdownMenu = document.querySelector('.dropdownMenu');
    if (dropdownMenu) {
      new DropdownMenu(dropdownMenu);
    }
    
    const imagePreviewForm = ((document.querySelector('#createPostForm') || document.querySelector('#editPostForm')) || document.querySelector('#editProfile') ) ;
    const type = imagePreviewForm.dataset.type
    if (imagePreviewForm) {
      new ImagesPreview(imagePreviewForm, type);
    }

    const profileImagePreview = document.querySelector('#createPostForm');
    if (profileImagePreview) {
      new ProfileImagePreview(profileImagePreview);
    }

});
