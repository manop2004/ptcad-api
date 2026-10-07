@extends('layouts.temp_ma')

@section('title')ให้คะแนนสินค้า | @endsection

@section('css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<style>
    body {
        font-family: 'Noto Sans Thai', sans-serif;
    }
    .review-card {
        max-width: 600px;
        margin: 30px auto;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        margin-bottom: 30px;
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
        pointer-events: all;
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
    .drop-zone p {
        margin: 0;
        font-size: 0.95rem;
    }
    .drop-zone span {
        color: #007bff;
        text-decoration: underline;
    }
    .drop-zone input {
        display: none;
    }
    /* Preview ภายใน drop zone */
    .preview-wrapper {
        position: relative;
        display: inline-block;
    }
    .preview-wrapper img,
    .preview-wrapper video {
        max-width: 100%;
        max-height: 200px;
        display: block;
    }
    .remove-preview {
        position: absolute;
        top: -10px;
        right: -10px;
        background: #dc3545;
        border: none;
        border-radius: 50%;
        color: #fff;
        width: 24px;
        height: 24px;
        font-size: 16px;
        line-height: 20px;
        cursor: pointer;
    }
	.form-control{
		font-size: 14px;
	}
	.submit-wrapper {
		max-width: 600px;
		margin: 0 auto;
	}
    /* ตัวอย่างสไตล์ error แบบ inline */
    .text-danger.small {
        display: block;
        margin-top: 4px;
    }
</style>
@endsection

@section('content')
<div class="container my-5">
	@if(session('success'))
    <div class="alert alert-success text-center">
		<img src="/icon/succeed.png" width="70">
		<br>
        <p>{{ session('success') }}</p>
    </div>
	@endif

    @if(empty(count($products)))
        <!--h1 class="card-title text-center mb-4 text-primary">ไม่พบข้อมูล</h1-->
    @else
        <h1 class="card-title text-center mb-4 text-primary">ให้คะแนนสินค้า</h1>
        
        <!-- Form เดียวสำหรับรีวิวสินค้าหลายรายการ -->
        <form id="reviewForm" method="POST" action="{{ route('reviews.store') }}" enctype="multipart/form-data">
            @csrf

            @foreach($products as $product)
                <div class="card review-card">
                    <div class="card-body">
                        <!-- ข้อมูลสินค้า -->
                        <div class="mb-4 d-flex align-items-center">
                            <img src="{{ $product->product_img }}" class="rounded me-3" alt="รูปสินค้า" width="80">
                            <div>
                                <h2 class="h5 mb-1">{{ $product->product_name }}</h2>
                                <p class="mb-0 text-muted">{{ $product->detail_name }}</p>
                            </div>
                        </div>

                        <!-- ฟอร์มรีวิวของสินค้านี้ -->
                        <input type="hidden" name="reviews[{{ $product->proId }}][user_id]" value="{{ $product->user_id }}">
                        <input type="hidden" name="reviews[{{ $product->proId }}][product_id]" value="{{ $product->proId }}">
                        <input type="hidden" name="reviews[{{ $product->proId }}][order_id]" value="{{ $product->orderId }}">

                        <!-- ให้คะแนนดาว -->
                        <div class="mb-3">
                            <label class="form-label">ให้คะแนนความพึงพอใจ</label>
                            <div id="stars_{{ $product->proId }}">
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
                            <!-- ฟิลด์ rating (hidden) -->
                            <input type="hidden" name="reviews[{{ $product->proId }}][rating]" id="rating_{{ $product->proId }}" value="0" required />
                            @error("reviews.".$product->proId.".rating")
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- กล่องข้อความรีวิว -->
                        <div class="mb-3">
                            <label for="reviewText_{{ $product->proId }}" class="form-label">
                                เขียนรีวิวของคุณ <small>(สูงสุด ~200 คำ)</small>
                            </label>
                            <textarea class="form-control"
                                      id="reviewText_{{ $product->proId }}"
                                      name="reviews[{{ $product->proId }}][review_text]"
                                      rows="4"
                                      placeholder="บอกความรู้สึกหรือข้อแนะนำเกี่ยวกับสินค้า..."
                                      maxlength="200"></textarea>
                            @error("reviews.".$product->proId.".review_text")
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- โซนอัปโหลดไฟล์ (รูปภาพและวิดีโออยู่ในบรรทัดเดียวกัน) -->
                        <div class="row mb-3">
                            <!-- รูปภาพ -->
                            <div class="col-6">
                                <label class="form-label">รูปภาพ (ไม่เกิน 3MB)</label>
                                <div class="drop-zone" id="imageDropZone_{{ $product->proId }}" data-default='<p><img src="/assets/fontend/images/icons/camera.png" width="70"></p>'>
                                    <!-- Preview container -->
                                    <div class="preview-wrapper-container">
                                         <p><img src="/assets/fontend/images/icons/camera.png" width="70"></p>
                                    </div>
                                    <input type="file" accept="image/*" id="imageUpload_{{ $product->proId }}" name="reviews[{{ $product->proId }}][image]" value="">
                                </div>
                                @error("reviews.".$product->proId.".image")
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- วิดีโอ -->
                            <div class="col-6">
                                <label class="form-label">วิดีโอ (ไม่เกิน 10MB)</label>
                                <div class="drop-zone" id="videoDropZone_{{ $product->proId }}" data-default='<p><img src="/assets/fontend/images/icons/video-camera.png" width="70"></p>'>
                                    <!-- Preview container -->
                                    <div class="preview-wrapper-container">
                                         <p><img src="/assets/fontend/images/icons/video-camera.png" width="70"></p>
                                    </div>
                                    <input type="file" accept="video/*" id="videoUpload_{{ $product->proId }}" name="reviews[{{ $product->proId }}][video]" value="">
                                </div>
                                @error("reviews.".$product->proId.".video")
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
            @endforeach

            <!-- ปุ่มส่งรีวิวเดียวสำหรับสินค้าทั้งหมด -->
            <div class="submit-wrapper mb-5">
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">ยืนยัน</button>
                </div>
            </div>

        </form>
    @endif
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// รอให้ DOM โหลดเสร็จ
document.addEventListener('DOMContentLoaded', function(){
    const productIds = @json($products->pluck('proId'));
    console.log("Product IDs:", productIds);

    productIds.forEach(function(id) {
        // --- Star Rating ---
        const starContainer = document.getElementById('stars_' + id);
        const ratingInput = document.getElementById('rating_' + id);
        if(starContainer && ratingInput) {
            const stars = starContainer.querySelectorAll('.star-rating');
            stars.forEach(function(star) {
                star.addEventListener('click', function() {
                    const value = star.getAttribute('data-value');
                    ratingInput.value = value;
                    stars.forEach(function(s) {
                        s.classList.remove('active');
                        if(parseInt(s.getAttribute('data-value')) <= parseInt(value)){
                            s.classList.add('active');
                        }
                    });
                    console.log("Product ID " + id + " rating: " + value);
                });
            });
        } else {
            console.error("Star container or rating input not found for product ID:", id);
        }

        // --- Image Upload & Drag/Drop ---
        const imageDropZone = document.getElementById('imageDropZone_' + id);
        const imageInput = document.getElementById('imageUpload_' + id);
        if(imageDropZone && imageInput) {
            const defaultImageContent = imageDropZone.getAttribute('data-default');
            imageDropZone.addEventListener('click', function() {
                imageInput.click();
            });
            ['dragenter', 'dragover'].forEach(function(eventName) {
                imageDropZone.addEventListener(eventName, function(e) {
                    e.preventDefault();
                    imageDropZone.classList.add('dragover');
                });
            });
            ['dragleave', 'drop'].forEach(function(eventName) {
                imageDropZone.addEventListener(eventName, function(e) {
                    e.preventDefault();
                    imageDropZone.classList.remove('dragover');
                });
            });
            imageDropZone.addEventListener('drop', function(e) {
                e.preventDefault();
                const files = e.dataTransfer.files;
                if(files.length > 1) {
                    alert('อัปโหลดรูปได้เพียง 1 รูปเท่านั้น');
                    return;
                }
                const file = files[0];
                if(!file.type.startsWith('image/')) {
                    alert('กรุณาอัปโหลดไฟล์รูปภาพเท่านั้น');
                    return;
                }
				// ตรวจสอบขนาดรูปภาพ
                if(!validateImageSize(file)) return;
                imageInput.files = files;
                showImagePreview(file, imageDropZone, defaultImageContent);
            });
            imageInput.addEventListener('change', function() {
                const file = imageInput.files[0];
                if(file) {
					if(!validateImageSize(file)) {
                        imageInput.value = '';
                        return;
                    }
                    showImagePreview(file, imageDropZone, defaultImageContent);
                } else {
                    // หากยกเลิกการเลือกไฟล์
                    let previewContainer = imageDropZone.querySelector('.preview-wrapper-container');
                    if (previewContainer) {
                        previewContainer.innerHTML = defaultImageContent;
                    }
                }
            });
        } else {
            console.error("Image elements not found for product ID:", id);
        }

        // --- Video Upload & Drag/Drop ---
        const videoDropZone = document.getElementById('videoDropZone_' + id);
        const videoInput = document.getElementById('videoUpload_' + id);
        if(videoDropZone && videoInput) {
            const defaultVideoContent = videoDropZone.getAttribute('data-default');
            videoDropZone.addEventListener('click', function() {
                videoInput.click();
            });
            ['dragenter', 'dragover'].forEach(function(eventName) {
                videoDropZone.addEventListener(eventName, function(e) {
                    e.preventDefault();
                    videoDropZone.classList.add('dragover');
                });
            });
            ['dragleave', 'drop'].forEach(function(eventName) {
                videoDropZone.addEventListener(eventName, function(e) {
                    e.preventDefault();
                    videoDropZone.classList.remove('dragover');
                });
            });
            videoDropZone.addEventListener('drop', function(e) {
                e.preventDefault();
                const files = e.dataTransfer.files;
                if(files.length > 1) {
                    alert('อัปโหลดวิดีโอได้เพียง 1 ไฟล์เท่านั้น');
                    return;
                }
                const file = files[0];
                if(!file.type.startsWith('video/')) {
                    alert('กรุณาอัปโหลดไฟล์วิดีโอเท่านั้น');
                    return;
                }
                if(!validateVideoSize(file)) return;
                videoInput.files = files;
                showVideoPreview(file, videoDropZone, defaultVideoContent);
            });
            videoInput.addEventListener('change', function() {
                const file = videoInput.files[0];
                if(file) {
                    if(!validateVideoSize(file)) {
                        videoInput.value = '';
                        return;
                    }
                    showVideoPreview(file, videoDropZone, defaultVideoContent);
                } else {
                    // หากยกเลิกการเลือกไฟล์
                    let previewContainer = videoDropZone.querySelector('.preview-wrapper-container');
                    if (previewContainer) {
                        previewContainer.innerHTML = defaultVideoContent;
                    }
                }
            });
        } else {
            console.error("Video elements not found for product ID:", id);
        }
    });
});

// ฟังก์ชันแสดง preview รูปภาพ พร้อมปุ่มลบ
function showImagePreview(file, container, defaultContent) {
    const reader = new FileReader();
    reader.onload = function(e) {
        let previewContainer = container.querySelector('.preview-wrapper-container');
        if (!previewContainer) {
            // หากไม่มี preview container ให้สร้างใหม่แล้วแทรกก่อน input element
            previewContainer = document.createElement('div');
            previewContainer.classList.add('preview-wrapper-container');
            const inputElement = container.querySelector('input[type="file"]');
            container.insertBefore(previewContainer, inputElement);
        }
        // แสดงผล preview ภายใน previewContainer
        previewContainer.innerHTML = `
            <div class="preview-wrapper">
                <img src="${e.target.result}" alt="Preview" class="preview-image">
                <button type="button" class="remove-preview" title="ลบ"><i class="fa-solid fa-xmark"></i></button>
            </div>
        `;
        previewContainer.querySelector('.remove-preview').addEventListener('click', function() {
            // คืนค่า previewContainer เป็นค่า default จาก data attribute
            previewContainer.innerHTML = defaultContent;
            // เคลียร์ค่าใน input file โดยไม่ลบ element นั้น
            const input = container.querySelector('input[type="file"]');
            if (input) {
                input.value = "";
            }
        });
    };
    reader.readAsDataURL(file);
}

function validateImageSize(file) {
    const maxSize = 3 * 1024 * 1024; // 3MB
    if(file.size > maxSize) {
        alert("ขนาดรูปภาพเกิน 3MB");
        return false;
    }
    return true;
}

// ฟังก์ชันตรวจสอบขนาดวิดีโอ (ไม่เกิน 10MB)
function validateVideoSize(file) {
    const maxSize = 10 * 1024 * 1024; // 10MB
    if(file.size > maxSize) {
        alert("ขนาดวิดีโอเกิน 10MB");
        return false;
    }
    return true;
}

// ฟังก์ชันแสดง preview วิดีโอ พร้อมปุ่มลบ
function showVideoPreview(file, container, defaultContent) {
    const reader = new FileReader();
    reader.onload = function(e) {
        let previewContainer = container.querySelector('.preview-wrapper-container');
        if (!previewContainer) {
            previewContainer = document.createElement('div');
            previewContainer.classList.add('preview-wrapper-container');
            const inputElement = container.querySelector('input[type="file"]');
            container.insertBefore(previewContainer, inputElement);
        }
        previewContainer.innerHTML = `
            <div class="preview-wrapper">
                <video controls class="preview-video">
                    <source src="${e.target.result}" type="${file.type}">
                    เบราว์เซอร์ของคุณไม่รองรับการเล่นวิดีโอ
                </video>
                <button type="button" class="remove-preview" title="ลบ"><i class="fa-solid fa-xmark"></i></button>
            </div>
        `;
        previewContainer.querySelector('.remove-preview').addEventListener('click', function() {
            previewContainer.innerHTML = defaultContent;
            const input = container.querySelector('input[type="file"]');
            if (input) {
                input.value = "";
            }
        });
    };
    reader.readAsDataURL(file);
}
</script>
@endsection
