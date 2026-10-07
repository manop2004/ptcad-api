<div id="review-comment">
    @foreach($reviews as $review)
        <div class="review-item">
            <div class="review-header">
                <strong>{{ Str::limit($review->user_name, 3, '***') }}</strong>
                <span class="review-date">{{ \Carbon\Carbon::parse($review->created_at)->diffForHumans() }}</span>
            </div>
            <div class="review-stars">
                @for ($i = 0; $i < $review->rating; $i++)
                    <i class="fas fa-star full-star"></i>
                @endfor
                @for ($i = 0; $i < 5 - $review->rating; $i++)
                    <i class="far fa-star empty-star"></i>
                @endfor
            </div>
            <p>{{ $review->review_text }}</p>
        </div>
    @endforeach
</div>

<div class="review-pagination">
    {{ $reviews->links('vendor.pagination.custom') }}
</div>
