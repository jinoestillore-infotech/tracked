<?php
require 'process_edit_profile.php';

$pageTitle = "Edit Profile";
include '../includes/header.php';
?>

<div class="container pt-3 pb-4">
    <div class="row justify-content-center align-items-center">
        <div class="col-lg-5">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <!-- HEADER -->
                <div class="text-dark p-4">
                    <h3 class="fw-bold mb-1">
                        Edit Profile
                    </h3>
                    <p class="mb-0 opacity-75">
                        Update your personal information and profile picture.
                    </p>
                </div>
                <!-- BODY -->
                <div class="card-body p-4 p-lg-5">
                    <!-- PROFILE PREVIEW -->
                    <div class="text-center mb-4">
                        <img
                            src="../uploads/profile/<?= htmlspecialchars($user['profile_picture']) ?>"
                            class="rounded-circle shadow-sm border"
                            width="120"
                            height="120"
                            style="object-fit: cover;"
                        >
                    </div>
                    <form method="POST" enctype="multipart/form-data">
                        <!-- FULL NAME -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Full Name
                            </label>
                            <input
                                type="text"
                                name="fullname"
                                class="form-control form-control-lg rounded-3"
                                value="<?= htmlspecialchars($user['fullname']) ?>"
                                placeholder="Enter your full name"
                                required
                            >
                        </div>

                        <!-- PROFILE PICTURE -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Profile Picture
                            </label>
                            <input
                                type="file"
                                name="profile_picture"
                                class="form-control rounded-3"
                                accept=".jpg,.jpeg,.png,.webp"
                            >
                            <div class="form-text">
                                Allowed formats: JPG, JPEG, PNG, WEBP
                            </div>
                        </div>
                        <!-- ACTIONS -->
                        <div class="d-flex gap-3">
                            <button
                                type="submit"
                                class="btn btn-primary px-4 rounded-3 w-100"
                            >
                                Save Changes
                            </button>
                            <a
                                href="index.php"
                                class="btn btn-outline-secondary px-4 rounded-3 w-100"
                            >
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>