<form action="{{ route(active_state()->name()) }}"
      class="row row-cols-md-auto g-3 align-items-center"
      method="get">
    <div class="col-12">
        <label for="title" class="visually-hidden">Заголовок</label>
        <input type="text"
               class="form-control"
               id="title"
               value="{{ request()->get("title", "") }}"
               placeholder="Заголовок"
               name="title">
    </div>

    <div class="col-12">
        <label for="key" class="visually-hidden">Key</label>
        <input type="text"
               class="form-control"
               id="key"
               value="{{ request()->get("key", "") }}"
               placeholder="Key"
               name="key">
    </div>

    <div class="col-12">
        <button type="submit" class="btn btn-primary">Применить</button>
        <a href="{{ route(active_state()->name()) }}" class="btn btn-secondary">Сбросить</a>
    </div>
</form>