<div class="anime__review__item">
    @php
        $initial = strtoupper(mb_substr($comment->user->name, 0, 1));
    @endphp
    <div class="anime__review__item__pic">
        <div
            style="width:50px; height:50px; border-radius:50%; background:#007bff; color:white; display:flex; align-items:center; justify-content:center; font-weight:bold; font-size:20px; box-shadow:0 2px 5px rgba(0,0,0,0.2);">
            {{ $initial }}
        </div>
    </div>
    <div class="anime__review__item__text">
        <h6>{{ $comment->user->name }} - <span>{{ $comment->created_at->diffForHumans() }}</span></h6>
        <p>{{ $comment->content }}</p>
    </div>
</div>
