<div class="card">
    <div class="card-body">
        <ul class="nav nav-pills flex-column">
            @foreach ($rules as $item)
                <li class="nav-item">
                    <a href="#" class="nav-link{{ ! empty($rule) && $rule->slug === $item->slug ? " active" : "" }}">
                        {{ $item->title }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>