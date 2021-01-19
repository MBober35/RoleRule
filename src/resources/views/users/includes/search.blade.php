<form action="{{ route("admin.users.index") }}"
      class="row row-cols-md-auto g-3 align-items-center"
      method="get">
    <div class="col-12">
        <label for="name" class="visually-hidden">Имя</label>
        <input type="text"
               class="form-control"
               id="name"
               value="{{ request()->get("name", "") }}"
               placeholder="Имя"
               name="name">
    </div>

    <div class="col-12">
        <label for="email" class="visually-hidden">E-mail</label>
        <input type="text"
               class="form-control"
               id="email"
               value="{{ request()->get("email", "") }}"
               placeholder="E-mail"
               name="email">
    </div>

    <div class="col-12">
        <button type="submit" class="btn btn-primary">Применить</button>
        <a href="{{ route("admin.users.index") }}" class="btn btn-secondary">Сбросить</a>
    </div>
</form>