<div class="col mb-3">
    <div class="card h-100">
        <div class="card-body">
            <h5 class="card-title">Авторизация</h5>
            <h6 class="card-subtitle mb-3 text-muted">Генерация одноразовой ссылки</h6>

            <div class="btn-group-vertical w-100" role="group">
                <button type="button"
                        data-confirm="get-link-form"
                        class="btn btn-outline-secondary">
                    Вывести
                </button>
                <button type="submit"
                        data-confirm="self-link-form"
                        class="btn btn-outline-secondary">
                    Отправить себе
                </button>
                <button type="submit"
                        data-confirm="send-link-form"
                        class="btn btn-outline-secondary">
                    Отправить пользователю
                </button>
            </div>

            <confirm-form id="get-link-form" confirm-text="Да, отправить!">
                <template>
                    <form action="{{ route("admin.users.get-link", compact("user")) }}"
                          id="get-link-form"
                          method="post">
                        @csrf
                    </form>
                </template>
            </confirm-form>

            <confirm-form id="self-link-form" confirm-text="Да, отправить!">
                <template>
                    <form action="{{ route("admin.users.self-link", compact("user")) }}"
                          id="self-link-form"
                          method="post">
                        @csrf
                    </form>
                </template>
            </confirm-form>

            <confirm-form id="send-link-form" confirm-text="Да, отправить!">
                <template>
                    <form action="{{ route("admin.users.send-link", compact("user")) }}"
                          id="send-link-form"
                          method="post">
                        @csrf
                    </form>
                </template>
            </confirm-form>
        </div>
    </div>
</div>