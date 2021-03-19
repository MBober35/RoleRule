<div class="col mb-3">
    <div class="card h-100">
        <div class="card-body">
            <h5 class="card-title">Данные</h5>
            <div class="row">
                <dt class="col-sm-3">Имя</dt>
                <dd class="col-sm-9">{{ $user->name }}</dd>

                <dt class="col-sm-3">E-mail</dt>
                <dd class="col-sm-9"><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></dd>
            </div>
        </div>
    </div>
</div>