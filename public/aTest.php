<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>ให้คะแนนสินค้า</title>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- CSS ภายในไฟล์เดียว -->
  <style>
    body {
      background-color: #f5f5f5;
    }
    .review-card {
      max-width: 600px;
      margin: 30px auto;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    .card-title {
      font-size: 1.8rem;
    }
    /* Inline SVG Star Rating */
    .star-rating {
      width: 24px;
      height: 24px;
      fill: #ccc;
      cursor: pointer;
      margin-right: 5px;
      transition: fill 0.2s, transform 0.2s;
    }
    .star-rating:hover,
    .star-rating.active {
      fill: #ffcc00;
      transform: scale(1.1);
    }
    /* Drop Zone */
    .drop-zone {
      border: 2px dashed #ccc;
      border-radius: 8px;
      padding: 20px;
      text-align: center;
      cursor: pointer;
      transition: background-color 0.2s;
      position: relative;
      color: #666;
      min-height: 120px;
    }
    .drop-zone:hover {
      background-color: #fafafa;
    }
    .drop-zone.dragover {
      background-color: #e6f7ff;
      border-color: #66c0f4;
      color: #333;
    }
    .drop-zone i {
      font-size: 2rem;
      margin-bottom: 8px;
      color: #999;
    }
    .drop-zone p {
      margin: 0;
      font-size: 0.95rem;
    }
    .drop-zone span {
      color: #007bff;
      text-decoration: underline;
    }
    /* ซ่อน input */
    .drop-zone input {
      display: none;
    }
    /* Preview ของไฟล์ */
    .preview-container {
      margin-top: 10px;
    }
    .preview-image,
    .preview-video {
      max-width: 100%;
      max-height: 200px;
      display: block;
      margin: 5px auto;
    }
  </style>
</head>
<body>
  <div class="container my-5">
    <div class="card mx-auto review-card">
      <div class="card-body">
        <h1 class="card-title text-center mb-4 text-primary">ให้คะแนนสินค้า</h1>
        <!-- ข้อมูลสินค้า (ตัวอย่าง) -->
        <div class="mb-4 d-flex align-items-center">
          <img src="https://via.placeholder.com/80" class="rounded me-3" alt="รูปสินค้า">
          <div>
            <h2 class="h5 mb-1">ชื่อสินค้า</h2>
            <p class="mb-0 text-muted">รายละเอียดสินค้าสั้น ๆ ที่นี่</p>
          </div>
        </div>

        <!-- ฟอร์มรีวิว -->
        <form id="reviewForm">
          <!-- ให้คะแนนดาว (ใช้ inline SVG) -->
          <div class="mb-3">
            <label class="form-label">ให้คะแนนความพึงพอใจ</label>
            <div id="stars">
              <svg class="star-rating" data-value="1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                <path d="M287.9 17.8L354 150.2 494.5 171.5C522.2 175.4 531.8 209.6 511.7 228.6L412.2 324.1 434.7 463.6C439.6 491.4 412.4 512.6 387.5 497.7L288 435.6 188.5 497.7C163.6 512.6 136.4 491.4 141.3 463.6L163.8 324.1 64.33 228.6C44.22 209.6 53.82 175.4 81.5 171.5L222 150.2 287.9 17.8z"/>
              </svg>
              <svg class="star-rating" data-value="2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                <path d="M287.9 17.8L354 150.2 494.5 171.5C522.2 175.4 531.8 209.6 511.7 228.6L412.2 324.1 434.7 463.6C439.6 491.4 412.4 512.6 387.5 497.7L288 435.6 188.5 497.7C163.6 512.6 136.4 491.4 141.3 463.6L163.8 324.1 64.33 228.6C44.22 209.6 53.82 175.4 81.5 171.5L222 150.2 287.9 17.8z"/>
              </svg>
              <svg class="star-rating" data-value="3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                <path d="M287.9 17.8L354 150.2 494.5 171.5C522.2 175.4 531.8 209.6 511.7 228.6L412.2 324.1 434.7 463.6C439.6 491.4 412.4 512.6 387.5 497.7L288 435.6 188.5 497.7C163.6 512.6 136.4 491.4 141.3 463.6L163.8 324.1 64.33 228.6C44.22 209.6 53.82 175.4 81.5 171.5L222 150.2 287.9 17.8z"/>
              </svg>
              <svg class="star-rating" data-value="4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                <path d="M287.9 17.8L354 150.2 494.5 171.5C522.2 175.4 531.8 209.6 511.7 228.6L412.2 324.1 434.7 463.6C439.6 491.4 412.4 512.6 387.5 497.7L288 435.6 188.5 497.7C163.6 512.6 136.4 491.4 141.3 463.6L163.8 324.1 64.33 228.6C44.22 209.6 53.82 175.4 81.5 171.5L222 150.2 287.9 17.8z"/>
              </svg>
              <svg class="star-rating" data-value="5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                <path d="M287.9 17.8L354 150.2 494.5 171.5C522.2 175.4 531.8 209.6 511.7 228.6L412.2 324.1 434.7 463.6C439.6 491.4 412.4 512.6 387.5 497.7L288 435.6 188.5 497.7C163.6 512.6 136.4 491.4 141.3 463.6L163.8 324.1 64.33 228.6C44.22 209.6 53.82 175.4 81.5 171.5L222 150.2 287.9 17.8z"/>
              </svg>
            </div>
            <input type="hidden" name="rating" id="rating" value="0" />
          </div>

          <!-- กล่องข้อความรีวิว -->
          <div class="mb-3">
            <label for="reviewText" class="form-label">
              เขียนรีวิวของคุณ <small>(สูงสุด ~100 คำ)</small>
            </label>
            <textarea class="form-control" id="reviewText" name="reviewText" rows="4" placeholder="บอกความรู้สึกหรือข้อแนะนำเกี่ยวกับสินค้า..."></textarea>
          </div>

          <!-- โซนอัปโหลดไฟล์ (รูปภาพและวิดีโออยู่ในบรรทัดเดียวกัน) -->
          <div class="row mb-3">
            <!-- รูปภาพ -->
            <div class="col-6">
              <label class="form-label">รูปภาพ</label>
              <div class="drop-zone" id="imageDropZone">
                <i class="fa-solid fa-image" style="display:none;"></i>
                <p><img src="/assets/fontend/images/icons/camera.png" width="70"></p>
                <input type="file" accept="image/*" id="imageUpload" name="imageUpload" />
              </div>
              <div class="form-text">รองรับไฟล์ภาพ เช่น JPG, PNG, GIF</div>
              <div class="preview-container" id="imagePreviewContainer"></div>
            </div>
            <!-- วิดีโอ -->
            <div class="col-6">
              <label class="form-label">วิดีโอ (ไม่เกิน 20MB)</label>
              <div class="drop-zone" id="videoDropZone">
                <i class="fa-solid fa-video" style="display:none;"></i>
                <p><img src="/assets/fontend/images/icons/video-camera.png" width="70"></p>
                <input type="file" accept="video/*" id="videoUpload" name="videoUpload" />
              </div>
              <div class="form-text">รองรับไฟล์วิดีโอ เช่น MP4, MOV</div>
              <div class="preview-container" id="videoPreviewContainer"></div>
            </div>
          </div>

          <!-- ปุ่มส่งรีวิว -->
          <div class="d-grid">
            <button type="submit" class="btn btn-primary">ยืนยัน</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- SweetAlert2 (แทนที่ alert() แบบเดิมของเบราว์เซอร์ ให้เป็น popup สวยงาม) -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- JavaScript ภายในไฟล์เดียว -->
  <script>
    // ----- 1) จัดการให้คะแนน (Star Rating) -----
    const stars = document.querySelectorAll(".star-rating");
    const ratingInput = document.getElementById("rating");
    stars.forEach((star) => {
      star.addEventListener("click", () => {
        const value = star.getAttribute("data-value");
        ratingInput.value = value;
        stars.forEach((s) => s.classList.remove("active"));
        stars.forEach((s) => {
          if (s.getAttribute("data-value") <= value) {
            s.classList.add("active");
          }
        });
      });
    });

    // ----- 2) จัดการ Drag & Drop รูปภาพ -----
    const imageDropZone = document.getElementById("imageDropZone");
    const imageInput = document.getElementById("imageUpload");
    const imagePreviewContainer = document.getElementById("imagePreviewContainer");

    ["dragenter", "dragover", "dragleave", "drop"].forEach((eventName) => {
      imageDropZone.addEventListener(eventName, (e) => e.preventDefault());
    });
    ["dragenter", "dragover"].forEach((eventName) => {
      imageDropZone.addEventListener(eventName, () => {
        imageDropZone.classList.add("dragover");
      });
    });
    ["dragleave", "drop"].forEach((eventName) => {
      imageDropZone.addEventListener(eventName, () => {
        imageDropZone.classList.remove("dragover");
      });
    });
    imageDropZone.addEventListener("drop", (e) => {
      const files = e.dataTransfer.files;
      if (files.length > 1) {
        Swal.fire({ icon: "warning", title: "อัปโหลดรูปได้เพียง 1 รูปเท่านั้น", confirmButtonText: "ตกลง" });
        return;
      }
      const file = files[0];
      if (!file.type.startsWith("image/")) {
        Swal.fire({ icon: "warning", title: "กรุณาอัปโหลดไฟล์รูปภาพเท่านั้น", confirmButtonText: "ตกลง" });
        return;
      }
      imageInput.files = files;
      showImagePreview(file);
    });
    imageDropZone.addEventListener("click", () => {
      imageInput.click();
    });
    imageInput.addEventListener("change", () => {
      const file = imageInput.files[0];
      if (file) {
        showImagePreview(file);
      } else {
        imagePreviewContainer.innerHTML = "";
      }
    });
    function showImagePreview(file) {
      const reader = new FileReader();
      reader.onload = (e) => {
        imagePreviewContainer.innerHTML = `<img src="${e.target.result}" alt="Preview" class="preview-image"/>`;
      };
      reader.readAsDataURL(file);
    }

    // ----- 3) จัดการ Drag & Drop วิดีโอ -----
    const videoDropZone = document.getElementById("videoDropZone");
    const videoInput = document.getElementById("videoUpload");
    const videoPreviewContainer = document.getElementById("videoPreviewContainer");

    ["dragenter", "dragover", "dragleave", "drop"].forEach((eventName) => {
      videoDropZone.addEventListener(eventName, (e) => e.preventDefault());
    });
    ["dragenter", "dragover"].forEach((eventName) => {
      videoDropZone.addEventListener(eventName, () => {
        videoDropZone.classList.add("dragover");
      });
    });
    ["dragleave", "drop"].forEach((eventName) => {
      videoDropZone.addEventListener(eventName, () => {
        videoDropZone.classList.remove("dragover");
      });
    });
    videoDropZone.addEventListener("drop", (e) => {
      const files = e.dataTransfer.files;
      if (files.length > 1) {
        Swal.fire({ icon: "warning", title: "อัปโหลดวิดีโอได้เพียง 1 ไฟล์เท่านั้น", confirmButtonText: "ตกลง" });
        return;
      }
      const file = files[0];
      if (!file.type.startsWith("video/")) {
        Swal.fire({ icon: "warning", title: "กรุณาอัปโหลดไฟล์วิดีโอเท่านั้น", confirmButtonText: "ตกลง" });
        return;
      }
      if (!validateVideoSize(file)) return;
      videoInput.files = files;
      showVideoPreview(file);
    });
    videoDropZone.addEventListener("click", () => {
      videoInput.click();
    });
    videoInput.addEventListener("change", () => {
      const file = videoInput.files[0];
      if (file) {
        if (!validateVideoSize(file)) {
          videoInput.value = "";
          return;
        }
        showVideoPreview(file);
      } else {
        videoPreviewContainer.innerHTML = "";
      }
    });
    function validateVideoSize(file) {
      const maxSize = 20 * 1024 * 1024; // 20MB
      if (file.size > maxSize) {
        Swal.fire({ icon: "warning", title: "ขนาดวิดีโอเกิน 20MB", confirmButtonText: "ตกลง" });
        return false;
      }
      return true;
    }
    function showVideoPreview(file) {
      const reader = new FileReader();
      reader.onload = (e) => {
        videoPreviewContainer.innerHTML = `
          <video controls class="preview-video">
            <source src="${e.target.result}" type="${file.type}">
            เบราว์เซอร์ของคุณไม่รองรับการเล่นวิดีโอ
          </video>
        `;
      };
      reader.readAsDataURL(file);
    }

    // ----- 4) จัดการ Submit ฟอร์ม -----
    const reviewForm = document.getElementById("reviewForm");
    reviewForm.addEventListener("submit", (e) => {
      e.preventDefault();
      if (ratingInput.value === "0") {
        Swal.fire({ icon: "warning", title: "กรุณาให้คะแนนก่อนส่งรีวิว", confirmButtonText: "ตกลง" });
        return;
      }
      const videoFile = videoInput.files[0];
      if (videoFile && videoFile.size > 20 * 1024 * 1024) {
        Swal.fire({ icon: "warning", title: "ขนาดวิดีโอเกิน 20MB", confirmButtonText: "ตกลง" });
        return;
      }
      const formData = new FormData(reviewForm);
      console.log("Rating:", formData.get("rating"));
      console.log("Review Text:", formData.get("reviewText"));
      console.log("Image File:", formData.get("imageUpload"));
      console.log("Video File:", formData.get("videoUpload"));
      Swal.fire({ icon: "success", title: "รีวิวของคุณถูกส่งเรียบร้อย!", text: "(ตัวอย่าง)", confirmButtonText: "ตกลง" });
    });
  </script>
</body>
</html>