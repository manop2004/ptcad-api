$(document).on('click', '.pagination a', function (event) {
	event.preventDefault();
	
	var url = $(this).attr('href'); // ดึง URL จาก pagination ที่กด

	$.ajax({
		url: url,
		type: 'GET',
		dataType: 'json',
		beforeSend: function() {
			$('#review-comment').fadeOut();
		},
		success: function (data) {
			$('#review-comment').html(data.html).fadeIn();
		},
		error: function () {
			alert('ไม่สามารถโหลดรีวิวได้ กรุณาลองใหม่อีกครั้ง');
		}
	});
});

$(document).ready(function () {
	// เมื่อกดที่ product-rating (ดาว หรือ คะแนนรีวิว)
	$('#product-rating').click(function() {
		// เปลี่ยนแท็บไปที่รีวิว
		$('ul.tab-nav li a[href="#tabs-pro_reviews"]').trigger('click');

		// เลื่อนไปยังรีวิว
		$('html, body').animate({
			scrollTop: $("#tabs-pro_reviews").offset().top - 50 // เลื่อนลงมา 50px ให้เห็นชัดขึ้น
		}, 800);
	});

	// หยุดวิดีโอเมื่อปิด Modal
	$('.modal').on('hidden.bs.modal', function () {
		let $video = $(this).find('video');
		if ($video.length) {
			$video.get(0).pause();
			$video.get(0).currentTime = 0;
		}
	});
});